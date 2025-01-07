<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminStoreRequest;
use App\Models\User;
use App\Models\Business;
use App\Models\UserVerify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Models\Plan;

class FrontendLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function homepage()
    {
        //
        $plan = Plan::all();
        // dd($plan);

        return view('front.frontpage', compact('plan'));
    }

    public function index()
    {
        //
        // return view('front.register');
    }
    public function frontdashboard()
    {
        //
        return view('front.dashboard');
    }

    public function terms()
    {
        return view('front.terms');
    }

    public function privacy()
    {
        return view('front.privacy');
    }

    public function refund()
    {
        return view('front.refund');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function frontlogin()
    {
        //
        return view('front.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function registerpost(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'name' => 'required|string|max:255',
                'password' => 'required|min:8|confirmed',
                'phone' => 'required|numeric',
                'usertype' => 'required|string',
            ]);


            $register = [
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "phone" => $request->phone,
                "usertype" => 'superadmin'
            ];
            // dd($register);
            $user = User::create($register);

            if (!$user) {
                return response()->json(['error' => 'Failed to create user. Please try again later.'], 500);
            }

            $token = Str::random(64);



            // Step 5: Save the verification token to the database
            $userVerify = UserVerify::create([
                'user_id' => $user->id,
                'token' => $token,
            ]);
            if (!$userVerify) {
                return response()->json(['error' => 'Failed to generate verification token.'], 500);
            }

            // Step 6: Send the verification email
            try {
                // Mail::send('email.emailVerificationEmail', ['token' => $token], function ($message) use ($validated) {
                //     $message->to($validated['email']);
                //     $message->subject('Email Verification Mail');
                // });

                Mail::send('email.emailVerificationEmail', ['token' => $token], function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('Email Verification Mail');
                });
            } catch (\Exception $e) {
                return response()->json(['error' => 'Failed to send verification email.'], 500);
            }

            // Step 7: Return success response
            return response()->json(['message' => 'User registered successfully! Please check your email for verification.']);
        } catch (QueryException $exception) {

            $errorDetails = [
                'error_message' => $exception->getMessage(),
                'error_file' => $exception->getFile(),
                'error_line' => $exception->getLine(),
            ];

            // Log unexpected errors
            Log::error('Unexpected Error:', $errorDetails);
            // Return all error details in the response
            return response()->json([
                'error' => 'An unexpected error occurred.',
                'details' => $errorDetails,
            ], 500);
        }
    }

    public function loginpost(Request $request)
    {
        //
        // dd($request);
        $input = $request->all();

        $validator = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('front.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
            $auth_user = Auth::user();
            // switch ($auth_user->usertype) {
            //     case 'superadmin':
            //         $userId = $auth_user->id;
            //         $exists = Business::where('user_id', $userId)->exists();

            //         if ($exists) {
            //             return redirect()->route('superadmin.home');
            //         } else {
            //             return redirect()->route('business.indexshow');
            //         }

            //     case 'admin':
            //         return redirect()->route('superadmin.home');
            //     case 'manager':
            //         return redirect()->route('manager.home');
            //     case 'user':
            //         return redirect()->route('front.dashboard');
            //     default:
            //         return redirect()->route('front.login');
            // }
            return redirect()->route('frontpage');
        } else {
            return redirect()->route('front.login')
                ->with('error', 'Email-Address and Password are incorrect.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // public function verifyAccount($token)

    // {

    //     $verifyUser = UserVerify::where('token', $token)->first();



    //     $message = 'Sorry your email cannot be identified.';



    //     if (!is_null($verifyUser)) {

    //         $user = $verifyUser->user;



    //         if (!$user->is_email_verified) {

    //             $verifyUser->user->is_email_verified = 1;

    //             $verifyUser->user->save();

    //             $message = "Your e-mail is verified. You can now login.";
    //         } else {

    //             $message = "Your e-mail is already verified. You can now login.";
    //         }
    //     }



    //     return redirect()->route('login')->with('message', $message);
    // }

    public function verifyAccount(Request $request, $token)
    {
        $p_register_verify = $request->query('p_register_verify', null); // Get the p_register_verify parameter
        $verifyUser = UserVerify::where('token', $token)->first();
    
        $message = 'Sorry, your email cannot be identified.';
        $sessionData = $request->session()->get('previous_data', null); // Retrieve session data
        // dd($sessionData);
        if (!is_null($verifyUser)) {
            $user = $verifyUser->user;
    
            if (!$user->is_email_verified) {
                $verifyUser->user->is_email_verified = 1;
                $verifyUser->user->save();
                $message = "Your e-mail is verified.";
    
                Auth::login($user);
    
                if ($p_register_verify === '1') {
                    // Redirect with session data preserved
                    return redirect()->route('superadmin.home')->with([
                        'message' => $message . ' Please proceed with your payment.',
                        'session_data' => $sessionData, // Pass session data to view
                    ]);
                }
            } else {
                $message = "Your e-mail is already verified. You can now login.";
            }
        }
    
        return redirect()->route('login')->with('message', $message);
    }
    

}
