<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\UserVerify;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // dd($data);
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8', // Ensure confirmation check is included
            'phone' => 'required|digits:10', // Check for exactly 10 digits
            'usertype' => 'required|string'
        ]);

        // if ($validator->fails()) {
        //     // dd($validator->errors());
        //     return response()->json($validator->errors(), 422);
        // }
    }
    

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function create(array $data)
    {
        try {       
            // Step 1: Prepare user data
            $register = [
                "name" => $data['name'],
                "email" => $data['email'],
                "password" => Hash::make($data['password']),
                "phone" => $data['phone'],
                "usertype" => 'superadmin',
            ];
    
            // Step 2: Create the user
            $user = User::create($register);
            if (!$user) {
                throw new \Exception('Failed to create user.');
            }
    
            // Step 3: Generate a verification token
            $token = Str::random(64);
            $userVerify = UserVerify::create([
                'user_id' => $user->id,
                'token' => $token,
            ]);
    
            if (!$userVerify) {
                throw new \Exception('Failed to generate verification token.');
            }
    
            // Step 4: Send verification email
            try {
                Mail::send('emails.emailVerificationEmail', ['token' => $token], function ($message) use ($data) {
                    $message->to($data['email']);
                    $message->subject('Email Verification Mail');
                });
            } catch (\Exception $e) {
                Log::error('Email Sending Failed: ' . $e->getMessage());
                throw new \Exception('Failed to send verification email.');
            }
    
            // Step 5: Return the created user
            return $user;
    
        } catch (QueryException $exception) {
            Log::error('Database Query Exception:', [
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
    
            throw new \Exception('A database error occurred.');
        } catch (\Exception $e) {
            Log::error('Unexpected Error: ' . $e->getMessage());
            throw $e;
        }
    }
    
}
