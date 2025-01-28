<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Setting;
use App\Models\SettingDetail;
use App\Models\Status;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class SettingController extends Controller
{
    /**
     * Display a listing of the settings.
     */
    public function index(Request $request)
    {

        $setting = Setting::where('settings.user_id', $request->session()->get('user_id'))
            ->join('setting_details', 'settings.id', '=', 'setting_details.settings_id')
            ->select('settings.*', 'setting_details.signature_image','setting_details.description_text')
            ->first();

            // dd($setting);
        if ($setting) {
            return view('settings.view', compact('setting'));
        } else {
            return redirect()->route('settings.create');
        }

    }

    /**
     * Show the form for creating a new setting.
     */
    public function create()
    {
        return view('settings.add');
    }

    /**
     * Store a newly created setting in the database.
     */
    public function store(Request $request)
    {
        // Ensure user is authenticated
        if (empty($request->session()->get('user_id'))) {
            return redirect()->route('login');
        }

        // Find business associated with the user
        $business_id = Business::where('user_id', $request->session()->get('user_id'))->select('id')->first();

        if (!$business_id) {
            return redirect()->route('settings.index')->with('error', 'Business not found.');
        }

        // Create setting
        $setting = Setting::create([
            'business_id' => $business_id->id,
            'user_id' => $request->session()->get('user_id'),
            'ewaybill_no' => $request->ewaybill_no,
            'purchase_order_date' => $request->purchase_order_date,
            'purchase_order_number' => $request->purchase_order_number,
            'vehicle_no' => $request->vehicle_no,
            'logo' => $request->logo,
            'emi' => $request->emi,
            'description' => $request->description,
            'signature' => $request->signature,
            'shipping_address' => $request->shipping_address,
            'invoice' => $request->invoice,
            'watermark' => $request->watermark,
        ]);

        // Create setting detail
        $settingDetail = new SettingDetail();
        $settingDetail->business_id = $business_id->id;
        $settingDetail->user_id = $request->session()->get('user_id');
        $settingDetail->settings_id = $setting->id;

    //    dd($request->file('signature_image'));
        if ($request->hasFile('signature_image')) {
            // Store the file in the 'settings_uploads' directory
            $signature_fileName = 'signature_' . time() . '.' . $request->file('signature_image')->extension();
            $request->file('signature_image')->move(public_path('settings_uploads'), $signature_fileName);
            $settingDetail->signature_image = $signature_fileName;
        }

        // Save the setting detail
        $settingDetail->save();

        return redirect()->route('settings.index')->with('success', 'Setting created successfully.');
    }

    /**
     * Display the specified setting.
     */
    public function show(Request $request, Setting $setting)
    {
        // Fetch associated business
        $business = Business::where('user_id', $request->session()->get('user_id'))->first();

        return view('settings.show', compact('setting', 'business'));
    }

    /**
     * Show the form for editing the specified setting.
     */
    public function edit(Request $request,Setting $setting)
    {
        // dd($setting);
        $settingDetail = SettingDetail::where('user_id', $request->session()->get('user_id'))->where('settings_id', $setting->id)->select('signature_image','description_text')->first();
        $business = Business::where('user_id', $request->session()->get('user_id'))->first();

        return view('settings.edit', compact('setting','settingDetail','business'));
    }
    /**
     * Update the specified setting in the database.
     */
    public function update(Request $request, Setting $setting)
    {

        if (empty($request->session()->get('user_id'))) {
            return redirect()->route('login');
        }

        // Find business associated with the user
        $business_id = Business::where('user_id', $request->session()->get('user_id'))->select('id')->first();

        if (!$business_id) {
            return redirect()->route('settings.index')->with('error', 'Business not found.');
        }

        // Update the setting
        $setting->update([
            'business_id' => $business_id->id,
            'user_id' => $request->session()->get('user_id'),
            'ewaybill_no' => $request->ewaybill_no,
            'purchase_order_date' => $request->purchase_order_date,
            'purchase_order_number' => $request->purchase_order_number,
            'vehicle_no' => $request->vehicle_no,
            'logo' => $request->logo,
            'emi' => $request->emi,
            'description' => $request->description,
            'signature' => $request->signature,
            'shipping_address' => $request->shipping_address,
            'invoice' => $request->invoice,
            'watermark' => $request->watermark,

        ]);

        // Find the associated setting detail
        $settingDetail = SettingDetail::where('settings_id', $setting->id)->first();

        // Handle file upload for signature_image if it exists
        $signature_fileName = $settingDetail->signature_image;

        if ($request->hasFile('signature_image')) {
            $signature_fileName = 'signature_' . time() . '.' . $request->file('signature_image')->extension();
            $request->file('signature_image')->move(public_path('settings_uploads'), $signature_fileName);
        }


        // Update the setting detail with file uploads and text values
        $settingDetail->update([
            'logo_image' => $request->hasFile('logo_image') ? $request->file('logo_image')->store('logos', 'public') : $settingDetail->logo_image,
            'logo_text' => $request->logo_text,
            'description_image' => $request->hasFile('description_image') ? $request->file('description_image')->store('descriptions', 'public') : $settingDetail->description_image,
            'description_text' => $request->description_text,
            'signature_image' => $signature_fileName,
        ]);

        return redirect()->route('settings.index')->with('success', 'Setting updated successfully.');
    }


    /**
     * Remove the specified setting from storage.
     */
    public function destroy(Setting $setting)
    {
        $setting->delete();

        return redirect()->route('settings.index')->with('success', 'Setting deleted successfully.');
    }

    public function tasksettings(Request $request)
    {

        if ($request->ajax()) {
            $data = Status::where('user_id', $request->session()->get('user_id'))
            ->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<form action="' . route('task.statusdistroy') . '" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this?\')">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" name="id" value="' . $row->id . '">
                            <a class="btn btn-primary btn-sm" href="' . url('/superadmin/taskstatusedit/' . $row->id) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                        </form>';
                return $btn;
            })
            ->rawColumns(['action']) // Specify which columns allow raw HTML
            ->make(true);
        }

        $status='';
        return view('settings.task',compact('status'));

    }

    public function taskstatusedit(Request $request, $id)
    {
        $status = Status::find($id);
        return view('settings.task',compact('status'));
    }

    public function ststusstore(Request $request)
    {
        $userId = $request->session()->get('user_id');
        $task = new Status();
        $method = $request->action_fun;
        if($method == 'add' && !empty($request->status_name)){
            $task->name = $request->status_name;
            $task->status = $request->status;
            $task->user_id = $userId;
            $task->save();
            return redirect()->route('task.settings')
            ->with('success', 'Task Added successfully');
        }elseif($method == 'update' && !empty($request->status_name)){
            $task = Status::find($request->id);
            $task->name = $request->status_name;
            $task->status = $request->status;
            $task->user_id = $userId;
            $task->save();
            return redirect()->route('task.settings')->with('success', 'Task Updated successfully');
        }
    }

    public function statusdistroy(Request $request)
    {
        //
        $id = $request->id;

        $task = Status::find($id);
        $task->delete();

        return redirect()->route('task.settings')
            ->with('success', 'Status deleted successfully');
    }
}
