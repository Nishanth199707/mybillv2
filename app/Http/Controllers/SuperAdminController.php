<?php

namespace App\Http\Controllers;

use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Business;
use App\Models\User;
use App\Models\PartyPayment;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;


class SuperAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function saregister()
    // {
    //     //
    //     return view('saauth.register');
    // }
    public function __construct()
    {
        // $this->middleware('superadmin');
    }


    public function salogin()
    {
        return view('saauth.login');
    }


    public function saloginpost(Request $request)
    {
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
        // dd( $input['email'],$input['password']);
        if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']])) {

            $auth_user = Auth::user();
            switch ($auth_user->usertype) {
                case 'superadmin':
                    return redirect()->route('sa.home');
              
                default:
                    return redirect()->route('sadamin.login');
            }
        } else {
            return redirect()->route('sadamin.login')->with('error', 'Email-Address and Password are incorrect.');
        }
    }

    public function superadminHome(Request $request)
    {
        $auth_user = Auth::user();
        $business = Business::select('*')->where('user_id', $auth_user->id)->first();

        $currentDate = Carbon::now()->format('d-m-Y');
        $payments = PartyPayment::where('mode_of_payment', 'cheque')
            ->where('collection_date', $currentDate)
            ->where('payment_type', 'waiting')
            ->join('parties', 'party_payments.party_id', '=', 'parties.id')
            ->select('party_payments.*', 'parties.name as party_name')
            ->where('party_payments.user_id', $request->session()->get('user_id'))
            ->orderBy('party_payments.collection_date')
            ->get();

        // dd($business);
        return view('saadmin.superadminhome', compact('business', 'payments'));
    }

    public function sausers(Request $request)
    {
        // $data = User::select('*')->where('id', $request->session()->get('user_id'))->get();
        // dd( $data);
        // $data = User::select('*')->where('id','!=', $request->session()->get('user_id'))->get();
        if ($request->ajax()) {
            $data = User::select('*')->where('id', $request->session()->get('user_id')) > get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<form action="' . url('superadmin/users/' . $row->id . '') . '" method="POST">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a class="btn btn-info btn-sm" href="' . url('superadmin/users/' . $row->id . '') . '"><i class="fa-solid fa-list"></i> Show</a>
                    <a class="btn btn-primary btn-sm" href="' . url('superadmin/users/' . $row->id . '/edit') . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // return view('users.view');
        return view('saadmin.users');
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $newStatus = $user->is_active;
        switch ($request->status) {
            case 1:
                $newStatus = 0;
                break;
            case 0:
                $newStatus = 1;
                break;
            default:
                $newStatus = $user->is_active;
                break;
        }

        $user->update(['is_active' => $newStatus]);

        return response()->json(['success' => true, 'status' => $newStatus]);
    }


    public function salogout(Request $request)
    {
        // Clear specific cookies if you have any custom cookies
        \Cookie::queue(\Cookie::forget('user_login'));
        \Cookie::queue(\Cookie::forget('user_id'));

        // Logout the user
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate the CSRF token to avoid any potential issues
        $request->session()->regenerateToken();

        // Redirect to the login page or homepage
        return view('saauth.login');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuperAdmin $superAdmin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuperAdmin $superAdmin)
    {
        //
    }
}
