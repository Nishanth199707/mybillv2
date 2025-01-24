<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\PartyPayment;
use App\Models\Plan;
use App\Models\Payment;
use Carbon\Carbon;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function frontendlogin()
    {
        Log::info('Accessing the frontend login page.');

        return view('front.frontpage');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        return view('adminHome');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function staffHome(Request $request)
    {
        $auth_user = $request->session()->get('user_id');
        $business = Business::select('*')->where('user_id', $auth_user)->first();
        $payments = PartyPayment::where('mode_of_payment', 'cheque')
        // ->where('collection_date', $currentDate)
        ->where('payment_type', 'waiting')
        ->join('parties', 'party_payments.party_id', '=', 'parties.id')
        ->select('party_payments.*', 'parties.name as party_name')
        ->where('party_payments.user_id', $request->session()->get('user_id'))
        ->orderBy('party_payments.collection_date')
        ->get();
        return view('staff.managerHome', compact('business','payments'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function superadminHome(Request $request)
    {
        $auth_user = Auth::user();
        $business = Business::select('*')->where('user_id', $auth_user->id)->first();


        $currentDate = Carbon::now()->format('d-m-Y');
        $payments = PartyPayment::where('mode_of_payment', 'cheque')
            // ->where('collection_date', $currentDate)
            ->where('payment_type', 'waiting')
            ->join('parties', 'party_payments.party_id', '=', 'parties.id')
            ->select('party_payments.*', 'parties.name as party_name')
            ->where('party_payments.user_id', $request->session()->get('user_id'))
            ->orderBy('party_payments.collection_date')
            ->get();

        $plan = Plan::get();
        $activePlan = Payment::where('user_id', $auth_user->id)
            ->where(function ($query) {
                $query->where('payment_status', 'Completed')
                    ->orWhere('payment_status', 'PAYMENT_SUCCESS');
            })
            ->with('plan')
            ->orderBy('id', 'desc')
            ->first();


        // dd($activePlan->id);
        // Initialize default values
        $remainingDays = null;
        $planDetails = null;

        if ($activePlan) {
            // Fetch plan details
            $planDetails = $activePlan->plan;
            if ($planDetails) {
                // Calculate remaining days
                $noOfDays = (int) $planDetails->no_of_days;
                $startDate = Carbon::parse($activePlan->created_at);
                $endDate = $startDate->addDays($noOfDays);
                // $remainingDays = Carbon::now()->diffInDays($endDate, false);
                $remainingDays = floor(Carbon::now()->diffInDays($endDate, false));
            }
        }



        if (!$activePlan) {
            return view('front.payment_home', compact('plan'));
        }
        if ($remainingDays <= 0) {

            return view('front.subscription_expired');
        }else{

            return view('superadminhome', compact('business', 'payments', 'remainingDays', 'activePlan'));
        }
        return view('superadminhome', compact('business', 'payments', 'remainingDays', 'activePlan'));
    }
}
