<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Setting;
use App\Models\SettingDetail;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $userId = $request->session()->get('user_id');
        // dd($userId);
        if ($request->ajax()) {

            $data = Business::select('*')->where('user_id', $userId)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('logo', function ($row) {
                    $logo = '<img src="' . asset('uploads/' . $row->logo) . '" width="50" height="50">';
                    return $logo;
                })->editColumn('name', function ($row) {
                    $name = User::find($row->user_id)->name;
                    return $name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<form action="' . url('superadmin/business/' . $row->id . '') . '" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <a class="btn btn-info btn-sm" href="' . url('superadmin/business/' . $row->id . '') . '"><i class="fa-solid fa-list"></i> View</a>
                                <a class="btn btn-primary btn-sm" href="' . url('superadmin/business/' . $row->id . '/edit') . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                                </form>';
                    return $btn;
                })

                ->rawColumns(['logo', 'action'])
                ->make(true);
        }

        return view('business.view');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('business.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //
        if (empty($request->session()->get('user_id'))) {
            return redirect()->route('login');
        }


        $request->validate([
            // 'logo' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'company_name' => 'required',
            'gstavailable' => 'required',
            // 'phone_no' => 'required',
            // 'email' => 'required',
            'address' => 'required',
            'business_type' => 'required',
            'business_category' => 'required',
            'pincode' => 'required',
            'state' => 'required',
            'country' => 'required',
            'city' => 'required',
            // 'signature' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $clogo_fileName = '';
        $signature_fileName = '';
        if ($request->hasFile('logo')) {
            $clogo_fileName = 'clogo_' . time() . '.' . $request->file('logo')->extension();
            $request->logo->move(public_path('uploads'), $clogo_fileName);
        }
        if ($request->hasFile('signature')) {
            $signature_fileName = 'signature_' . time() . '.' . $request->file('signature')->extension();
            $request->signature->move(public_path('uploads'), $signature_fileName);
        }

        $businessArr = [
            'user_id' => $request->session()->get('user_id'),
            'logo' => $clogo_fileName,
            'company_name' => Auth::user()->name,
            'gstavailable' => $request->gstavailable,
            'gstin' => $request->gstin,
            'phone_no' => Auth::user()->phone,
            'email' => Auth::user()->email,
            'address' => $request->address,
            'business_type' => $request->business_type,
            'business_category' => $request->business_category,
            'pincode' => $request->pincode,
            'state' => $request->state,
            'country' => $request->country,
            'city' => $request->city,
            'description' => $request->description,
            'signature' => $signature_fileName,
        ];

        // dd($businessArr);

        $business = Business::create($businessArr);

        $setting = Setting::create([
            'business_id' => $business->id,
            'user_id' => $request->session()->get('user_id'),
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
        $settingDetail = new SettingDetail();
        $settingDetail->business_id = $business->id;
        $settingDetail->user_id = $request->session()->get('user_id');
        $settingDetail->settings_id = $setting->id;
        $settingDetail->save();


        $gstavailable = $request->gstavailable;
        $request->session()->put('gstavailable', $gstavailable);

        return redirect()->route('business.indexshow')
            ->with('success', 'Business created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Business $business, Request $request)
    {
        //
        $userId = $request->session()->get('user_id');
        $businessId = $request->business->id;

        $business = Business::select('*')->where('user_id', $userId)->where('id', $businessId)->first();
        // dd($business);
        return view('business.show', compact('business'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Business $business)
    {
        //
        return view('business.edit', compact('business'));
    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, Business $business)
    {
        try {
            // Check if the user is logged in
            if (empty($request->session()->get('user_id'))) {
                return redirect()->route('login');
            }

            // dd($request->all());
            // Validate the input data
            $request->validate([
                'company_name' => 'required',
                // 'gstavailable' => 'required',
                'phone_no' => 'required',
                'email' => 'required',
                'address' => 'required',
                'business_type' => 'required',
                'business_category' => 'required',
                'pincode' => 'required',
                'state' => 'required',
                'country' => 'required',
                'city' => 'required',
            ]);

            // Prepare the data for updating the business
            $businessArr = [
                'user_id' => $request->session()->get('user_id'),
                'company_name' => $request->company_name,
                // 'gstavailable' => $request->gstavailable,
                // 'gstin' => $request->gstin,
                'phone_no' => $request->phone_no,
                'email' => $request->email,
                'address' => $request->address,
                'business_type' => $request->business_type,
                'business_category' => $request->business_category,
                'pincode' => $request->pincode,
                'state' => $request->state,
                'country' => $request->country,
                'city' => $request->city,
                'description' => $request->description,
            ];

            // Handle file uploads
            if ($request->hasFile('logo')) {
                $clogo_fileName = 'clogo_' . time() . '.' . $request->file('logo')->extension();
                $request->logo->move(public_path('uploads'), $clogo_fileName);
                $businessArr['logo'] = $clogo_fileName;
            }
            if ($request->hasFile('signature')) {
                $signature_fileName = 'signature_' . time() . '.' . $request->file('signature')->extension();
                $request->signature->move(public_path('uploads'), $signature_fileName);
                $businessArr['signature'] = $signature_fileName;
            }

            // Update the business data
            $business->update($businessArr);

            // Store gstavailable in session
            $gstavailable = $request->gstavailable;
            $request->session()->put('gstavailable', $gstavailable);

            // Redirect with success message
            return redirect()->route('business.indexshow')
                ->with('success', 'Business Updated successfully.');
        } catch (\Exception $e) {
            // Log the exception message
            Log::error('Error updating business: ' . $e->getMessage());

            // Optionally, log the full exception for detailed debugging
            Log::error($e);

            // Redirect back with error message
            return redirect()->route('business.indexshow')
                ->with('error', 'Failed to update business. Please try again later.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Business $business)
    {
        //
        //
        $business->delete();
        return redirect()->route('business.index')
            ->with('success', 'Business deleted successfully');
    }


    public function indexshow(Request $request)
    {

        $userId = $request->session()->get('user_id');

        $business = Business::select('*')->where('user_id', $userId)->first();
        $exists = Business::where('user_id', $userId)->exists();

        if ($exists) {
            return view('business.show', compact('business'));
        } else {
            return view('business.indexshow');
        }
    }

    public function ebillsettings(Request $request){
        $userId = $request->session()->get('user_id');

        $business = Business::select('*')->where('user_id', $userId)->first();
        return view('business.ebillsettings', compact('business'));
    }


}
