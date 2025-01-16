<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\SubUser;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    /**
     * Create a new controller instance.
     *
     * @return RedirectResponse
     */
    // public function login(Request $request): RedirectResponse
    // {
    //     $input = $request->all();

    //     $validator = Validator::make($input, [
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->route('login')
    //             ->withErrors($validator)
    //             ->withInput($request->only('email'));
    //     }

    //     if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
    //         $auth_user = Auth::user();

    //         switch ($auth_user->usertype) {
    //             case 'superadmin':
    //                 return redirect()->route('superadmin.home');
    //             case 'admin':
    //                 return redirect()->route('superadmin.home');
    //             case 'manager':
    //                 return redirect()->route('manager.home');
    //             default:
    //                 return redirect()->route('home');
    //         }
    //     } else {
    //         return redirect()->route('login')
    //             ->with('error', 'Email-Address and Password are incorrect.');
    //     }
    // }

    public function login(Request $request): RedirectResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'email' => 'required_without:otp|email',
            'password' => 'required_without:otp',
            'mobileno' => 'required_without:email|digits:10',
            'otp' => 'required_without:password|digits:6',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput($request->only('email', 'mobileno'));
        }
        // Email and Password Login
        if (isset($input['email']) && isset($input['password'])) {
            if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
                $auth_user = Auth::user();

                // Main user logic
                switch ($auth_user->usertype) {
                    case 'superadmin':
                        return redirect()->route('superadmin.home');
                    case 'admin':
                        return redirect()->route('admin.home');
                    case 'manager':
                        return redirect()->route('manager.home');
                    default:
                        return redirect()->route('home');
                }
            }
        }

        // Check SubUser credentials
        if (!empty($input['email']) && !empty($input['password'])) {
            // Retrieve user by email
            $subUser = \App\Models\SubUser::where('email', $input['email'])->first();

            if ($subUser->where('password', $subUser->password)) {
                // User authentication successful
                $auth_user = $subUser;

                session(['sub_user_id' => $auth_user->id]);
                session(['sub_user_parent_id' => $auth_user->user_id]);

                // dd(session('sub_user_id'),session('sub_user_parent_id'));
                // dd($auth_user->usertype);
                // Redirect based on user type
                switch ($auth_user->usertype) {
                    
                    case 'staff':
                        return redirect()->route('staff.home');
                    
                    default:
                        return redirect()->route('home');
                }

                // dd($auth_user->usertype);

            } else {
                // Authentication failed
                return back()->with('error', 'Invalid email or password.');
            }
        }
        // OTP and Mobile Number Login
        if (isset($input['mobileno']) && isset($input['otp'])) {
            $otpRecord = DB::table('otps')
                ->where('mobileno', $input['mobileno'])
                ->where('otp', $input['otp'])
                ->where('expires_at', '>=', now())
                ->first();

            if ($otpRecord) {
                // Fetch the user or subuser by mobile number
                $auth_user = User::where('phone', $input['mobileno'])
                    ->orWhereHas('subUsers', function ($query) use ($input) {
                        $query->where('phone', $input['mobileno']);
                    })
                    ->first();

                if ($auth_user) {
                    // Check if SubUser or Main User
                    if ($auth_user instanceof SubUser) {
                        Auth::login($auth_user);
                        return redirect()->route('subuser.dashboard');
                    } else {
                        Auth::login($auth_user);
                        switch ($auth_user->usertype) {
                            case 'superadmin':
                                return redirect()->route('superadmin.home');
                            case 'admin':
                                return redirect()->route('admin.home');
                            case 'manager':
                                return redirect()->route('manager.home');
                            default:
                                return redirect()->route('home');
                        }
                    }
                } else {
                    return redirect()->route('login')
                        ->with('error', 'User not found for the provided mobile number.');
                }
            } else {
                return redirect()->route('login')
                    ->with('error', 'Invalid or expired OTP.');
            }
        }
        // dd('Invalid login credentials.');
        return redirect()->route('login')
            ->with('error', 'Invalid login credentials.');
    }



    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        header("cache-Control:no-store,no-cache, must-revalidate");
        header("cache-Control:post-check=0,pre-check=0", false);
        header("Pragma:no-cache");
        header("Expires: Sat,26 Jul 1997 05:00:00: GMT");
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->route('login');
    }


    public function expired()
    {
        return view('front.subscription_expired');
    }
}
