<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Repair;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;


class RepairController extends Controller
{

    public function index(Request $request)
    {

        if ($request->ajax()) {
            try {
               
                $fromDate = $request->input('date_from') . ' 00:00:00';
                $toDate = $request->input('date_to') . ' 23:59:59';
                
                $repairs = Repair::select('id', 'service_no', 'customer_name', 'date', 'phone', 'complaint_remark', 'user_id', 'status')
                    ->where('user_id', $request->session()->get('user_id'))
                    ->when($request->status, function ($query) use ($request) {
                        $query->where('status', $request->status);
                    })
                    ->when($request->filled('date_from') && $request->filled('date_to'), function ($query) use ($fromDate, $toDate) {
                        $query->whereBetween('created_at', [$fromDate, $toDate]);
                    })
                    ->orderBy('id', 'DESC')
                    ->get();
                
                


                return DataTables::of($repairs)
                    ->addColumn('status', function ($row) {
                        $statuses = ['in_progress', 'waiting_for_spare', 'returned', 'completed'];
                        $options = '';
                        foreach ($statuses as $status) {
                            $selected = $row->status === $status ? 'selected' : '';
                            $options .= "<option value='{$status}' {$selected}>" . ucwords(str_replace('_', ' ', $status)) . "</option>";
                        }
                        return '<select class=" status-select btn btn-secondary"  data-id="' . $row->id . '">' . $options . '</select>';
                    })
                    ->addColumn('action', function ($row) {
                        return '
                            <a class="btn btn-info btn-sm" href="' . route('repairs.show', $row->id) . '">View</a>
                            <a class="btn btn-primary btn-sm" href="' . route('repairs.edit', $row->id) . '">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <form action="' . route('repairs.destroy', $row->id) . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this Service Bill?\')">
                                ' . csrf_field() . method_field("DELETE") . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>';
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        return view('repairs.view');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $business = Business::where('user_id', $request->session()->get('user_id'))->select('id')->first();

        if (!$business) {
            return redirect()->route('repairs.index')->with('error', 'Business not found.');
        }

        $service_id = Repair::where('business_id', $business->id)
            ->where('user_id', $request->session()->get('user_id'))
            ->select('service_no')
            ->orderBy('id', 'DESC')
            ->first();

        if ($service_id) {
            $lastServiceNumber = (int)str_replace('SER', '', $service_id->service_no);
            $nextServiceNumber = $lastServiceNumber + 1;
        } else {
            $nextServiceNumber = 1;
        }
        $service_no = $this->invoice_num($nextServiceNumber, $pad_len = 4, $prefix = 'SER');


        return view('repairs.add', compact('service_no'));
    }

    public function invoice_num($input, $pad_len = 4, $prefix = 'SER')
    {
        if ($pad_len <= strlen($input))
            trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate quotation number', E_USER_ERROR);

        if (is_string($prefix))
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ensure user is authenticated
        if (empty($request->session()->get('user_id'))) {
            return redirect()->route('login');
        }
        $business = Business::where('user_id', $request->session()->get('user_id'))->select('id')->first();

        if (!$business) {
            return redirect()->route('repairs.index')->with('error', 'Business not found.');
        }

        // dd($request->all());
        // Create a new repair record
        Repair::create([
            'business_id' => $business->id,
            'user_id' => $request->session()->get('user_id'),
            'service_no' => $request->service_no,
            'customer_name' => $request->customer_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'date' => $request->repair_date,
            'complaint_remark' => $request->complaint_remark,
            'imei' => $request->imei,
            'mobile_pin' => $request->mobile_pin,
            'phone_condition' => $request->phone_condition,
            'battery' => $request->battery,
            'battery_details' => $request->battery_details,
            'sim' => $request->sim,
            'sim_details' => $request->sim_details,
            'estimated_amount' => $request->estimated_amount,
            'estimated_delivery_date' => $request->estimated_delivery_date,
            'received_by' => $request->received_by,
            'model' => $request->model,
            'cash_received' => $request->cash_received,
        ]);

        return redirect()->route('repairs.index')->with('success', 'Repair request Created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Repair $repair)
    {
        $business = Business::where('user_id', $request->session()->get('user_id'))->first();

        return view('repairs.show', compact('repair', 'business'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Repair $repair)
    {
        return view('repairs.edit', compact('repair'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Repair $repair)
    {
        // Ensure user is authenticated
        if (empty($request->session()->get('user_id'))) {
            return redirect()->route('login');
        }

        $business = Business::where('user_id', $request->session()->get('user_id'))->select('id')->first();

        if (!$business) {
            return redirect()->route('repairs.add')->with('error', 'Business not found.');
        }

        // Update the existing repair record
        $repair->update([
            'business_id' => $business->id,
            'user_id' => $request->session()->get('user_id'),
            'service_no' => $request->service_no,
            'customer_name' => $request->customer_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'date' => $request->repair_date,
            'complaint_remark' => $request->complaint_remark,
            'imei' => $request->imei,
            'mobile_pin' => $request->mobile_pin,
            'phone_condition' => $request->phone_condition,
            'battery' => $request->battery,
            'battery_details' => $request->battery_details,
            'sim' => $request->sim,
            'sim_details' => $request->sim_details,
            'estimated_amount' => $request->estimated_amount,
            'estimated_delivery_date' => $request->estimated_delivery_date,
            'received_by' => $request->received_by,
            'model' => $request->model,
            'cash_received' => $request->cash_received,
        ]);

        return redirect()->route('repairs.index')->with('success', 'Repair request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Repair $repair)
    {
        $repair->delete();
        return redirect()->route('repairs.index')->with('success', 'Repair request deleted successfully.');
    }

    /**
     * Show the bill for the specified repair.
     */
    public function showBill(Request $request, Repair $repair)
    {
        $business = Business::where('user_id', $request->session()->get('user_id'))->first();

        return view('repairs.show', compact('repair', 'business'));
    }

    public function cashReceived(Request $request)
    {
        $userId = $request->session()->get('user_id');
        $from_Date = date_create($request->from_date);
        $fromDate = date_format($from_Date, "d-m-Y");
        $to_Date = date_create($request->to_date);
        $toDate = date_format($to_Date, "d-m-Y");

        // Initialize the query
        $cashReceivedQuery = Repair::where('repairs.user_id', $userId)
            ->select('repairs.service_no', 'repairs.customer_name', 'repairs.cash_received', 'repairs.date')
            ->whereNotNull('repairs.cash_received')
            ->orderBy('repairs.date', 'DESC');


        // Apply date range filters if provided
        if ($request->filled('from_date') && $request->filled('to_date')) {

            $cashReceivedQuery->whereBetween('repairs.date', [$fromDate, $toDate]);
        }

        // Execute the query
        $cashReceived = $cashReceivedQuery->get();
        // dd( $cashReceived);
        // Calculate the total cash received
        // $totalCashReceived = $cashReceived->sum('cash_received');

        $totalCashReceived = $cashReceived->sum(function ($item) {
            return (float) $item->cash_received; // Force it to be treated as a float
        });
        // Prepare the from and to dates for the view
        $fromDateForView = $fromDate;
        $toDateForView = $toDate;

        // Return the view with the necessary data
        return view('repairs.cash', compact('cashReceived', 'totalCashReceived', 'fromDateForView', 'toDateForView'));
    }




    public function updateStatus(Request $request, $id)
    {
        // dd($id);
        $repair = Repair::findOrFail($id);
        $repair->status = $request->status;
        $repair->save();

        return response()->json(['message' => 'Status updated successfully.']);
    }
}
