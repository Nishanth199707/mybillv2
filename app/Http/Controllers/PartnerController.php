<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PartnerController extends Controller
{
    //
    public function partnerlogin()
    {
        return view('partner.login');
    }
    public function partnerregister()
    {
        return view('partner.register');
    }

    public function partnersignup(Request $request)
    {
        // Create the User first
        $register = [
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "phone" => $request->phone,
            "usertype" => 'partner'
        ];
        $user = User::create($register);

        // Prepare Partner data
        $partnersignup = [
            "user_id" => $user->id,
            "name" => $request->name,
            "category" => $request->category,
            "company_name" => $request->company_name,
            "phone_no" => $request->phone_no,
            "email" => $request->email,
            "password" => $request->password
        ];

        // Insert the Partner record and get the inserted partner's instance
        $partner = Partner::create($partnersignup);


        if ($partner->id === null) {
            $partnerCode = 'SSS1111';
        } else {
            // Generate the custom code using the ID
            $partnerCode = 'SSS' . str_pad($partner->id, 4, '1', STR_PAD_LEFT);
        }
        $updateResult = Partner::where('id', $partner->id)->update(['partner_code' => $partnerCode]);

        if ($updateResult) {
            // The update was successful
            return redirect()->route('partner.login')->with('success', 'Partner registered successfully');
        } else {
            // The update failed, log the issue for debugging
            \Log::error('Failed to update partner_code for partner ID: ' . $partner->id);
            return redirect()->route('partner.register')->with('error', 'Failed to register partner. Please try again.');
        }
    }



    public function partnersignin(Request $request)
    {
        //
        // dd($request);
        $input = $request->all();

        $validator = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('partner.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {
            $auth_user = Auth::user();
            // dd($auth_user->usertype);
            // return redirect()->route('front.dashboard');
            switch ($auth_user->usertype) {
                case 'partner':
                    return redirect()->route('partner.home');
                default:
                    return redirect()->route('partner.login');
            }

        } else {
            return redirect()->route('partner.login')
                ->with('error', 'Email-Address and Password are incorrect.');
        }
    }

    public function PartnerHome(Request $request)
    {
        $userId = $request->session()->get('user_id');

        $partner = Partner::select('partner_code')->where('user_id', '=', $userId)->first();


        return view('partner.partnerHome', compact('partner'));
    }

    public function Dsc()
    {
        return view('partner.dscapply');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'You have been logged out.');
    }

}
