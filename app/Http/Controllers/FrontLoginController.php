<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Business;
use App\Models\Setting;
use App\Models\SettingDetail;
use App\Models\UserVerify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class FrontLoginController extends Controller
{
    public function registerpost(Request $request)
    {
        try {
            // Validate request
            $validatedData = $request->validate([
                'company_name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string',
                'phone_no' => 'required|string',
                'gstavailable' => 'required',
                'address' => 'required|string',
                'business_type' => 'required|string',
                'business_category' => 'required|string',
                'pincode' => 'required|string',
                'state' => 'required|string',
                'country' => 'required|string',
                'city' => 'required|string',

            ]);

            // Create user
            $user = User::create([
                'name' => $validatedData['company_name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'phone' => $validatedData['phone_no'],
                'usertype' => 'superadmin',
                'gst_profile' => $request->gstin_status,
                'gst_response' => $request->gstin_reponse,
            ]);

            // Auth::login($user);

            // Handle file uploads
            $logoFileName = null;
            $signatureFileName = null;

            if ($request->hasFile('logo')) {
                $logoFileName = 'clogo_' . time() . '.' . $request->file('logo')->extension();
                $request->file('logo')->move(public_path('uploads'), $logoFileName);
            }

            if ($request->hasFile('signature')) {
                $signatureFileName = 'signature_' . time() . '.' . $request->file('signature')->extension();
                $request->file('signature')->move(public_path('uploads'), $signatureFileName);
            }

            // Create business
            $business = Business::create([
                'user_id' => $user->id,
                'logo' => $logoFileName,
                'company_name' => $user->name,
                'gstavailable' => $validatedData['gstavailable'],
                'gstin' => $request->gstin,
                'phone_no' => $user->phone,
                'email' => $user->email,
                'address' => $validatedData['address'],
                'business_type' => $validatedData['business_type'],
                'business_category' => $validatedData['business_category'],
                'pincode' => $validatedData['pincode'],
                'state' => $validatedData['state'],
                'country' => $validatedData['country'],
                'city' => $validatedData['city'],

            ]);

            // Create settings and setting details
            $setting = Setting::create([
                'business_id' => $business->id,
                'user_id' => $user->id,
                'ewaybill_no' => 'no',
                'purchase_order_date' => 'no',
                'purchase_order_number' => 'no',
                'vehicle_no' => 'no',
                'logo' => 'no',
                'emi' => 'no',
                'description' => 'no',
                'signature' => 'no',
                'shipping_address' => 'no',
                'invoice' => 'show',
            ]);

            SettingDetail::create([
                'business_id' => $business->id,
                'user_id' => $user->id,
                'settings_id' => $setting->id,
            ]);

            // Email verification
            $token = Str::random(64);
            UserVerify::create([
                'user_id' => $user->id,
                'token' => $token,
            ]);

            try {
                Mail::send('emails.TemailVerificationEmail', ['token' => $token,'p_register_verify'=>'1'], function($message) use($request){
                    $message->to($request->email);
                    $message->subject('Email Verification Mail');
                });
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to send verification email.'], 500);
            }

            return redirect()->route('superadmin.home')->with('success', 'User registered successfully! Please check your email for verification.');

        } catch (QueryException $exception) {
            Log::error('Database Error:', [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);

            return redirect()->back()->withErrors(['database' => 'A database error occurred.'])->withInput();
        } catch (\Exception $exception) {
            Log::error('General Error:', [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);

            return redirect()->back()->withErrors(['message' => $exception->getMessage()])->withInput();
        }
    }


    public function sendOtp(Request $request)
    {


        $validated = $request->validate([
            'mobileno' => 'required|digits:10',
        ]);

        $mobileno = $validated['mobileno'];

        $userExists = DB::table('users')->where('phone', $mobileno)->first();

        if (!$userExists) {
            return response()->json(['success' => false, 'message' => 'Mobile number not registered.'], 404);
        }

        $otp = rand(100000, 999999); // Generate a 6-digit OTP

        // Prepare SMS message
        $message = "{$otp} is your OTP for Mobile Verification. valid for 10 minutes. Do not share your OTP with anyone. MYDAILYBILL";

        // API request parameters
        $params = [
            'key' => env('SMS_API_KEY'),
            'route' => env('SMS_API_ROUTE'),
            'sender' => env('SMS_API_SENDER'),
            'number' => $mobileno,
            'sms' => $message,
            'templateid' => env('SMS_TEMPLATE_ID'),
        ];

        try {
            // Send API request
            $response = Http::get(env('SMS_BASE_URL'), $params);

            if ($response->successful()) {
                // Save OTP details to the database
                DB::table('otps')->insert([
                    'otp' => $otp,
                    'otp_message' => $message,
                    'otp_status' => 'pending',
                    'mobileno' => $mobileno,
                    'response' => $response->body(),
                    'send_date' => Carbon::now(),
                    'track_id' => $response->json()['track_id'] ?? null,
                    'user_id' => $userExists->id,
                    'expires_at' => Carbon::now()->addMinutes(10),
                ]);

                DB::table('users')
                ->where('id', $userExists->id)
                ->update(['otp' => $otp]);

                return response()->json(['success' => true, 'message' => 'OTP sent successfully.']);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to send OTP.'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error sending OTP: ' . $e->getMessage()], 500);
        }
    }
}
