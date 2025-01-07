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

        if (isset($input['email']) && isset($input['password'])) {
            if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
                $auth_user = Auth::user();

                switch ($auth_user->usertype) {
                    case 'superadmin':
                        return redirect()->route('superadmin.home');
                    case 'admin':
                        return redirect()->route('superadmin.home');
                    case 'manager':
                        return redirect()->route('manager.home');
                    default:
                        return redirect()->route('home');
                }
            } else {
                return redirect()->route('login')
                    ->with('error', 'Email-Address and Password are incorrect.');
            }
        }

        if (isset($input['mobileno']) && isset($input['otp'])) {
            $otpRecord = DB::table('otps')
                ->where('mobileno', $input['mobileno'])
                ->where('otp', $input['otp'])
                ->where('expires_at', '>=', now())
                ->first();

            if ($otpRecord) {
                // Fetch the user by mobile number
                $auth_user = User::where('phone', $input['mobileno'])->where('id', $otpRecord->user_id)->first();

                if ($auth_user) {
                    // Log the user in manually
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
                } else {
                    return redirect()->route('login')
                        ->with('error', 'User not found for the provided mobile number.');
                }
            } else {
                return redirect()->route('login')
                    ->with('error', 'Invalid or expired OTP.');
            }
        }

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
