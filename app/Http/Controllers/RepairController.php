<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Repair;
use Illuminate\Http\Request;
use App\Models\PartyPayment;
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

                $repairs = Repair::select('repairs.id', 'repairs.service_no', 'parties.name as customer_name', 'repairs.date', 'repairs.phone', 'repairs.complaint_remark', 'repairs.user_id', 'repairs.status')
                    ->leftjoin('parties','parties.id','=','repairs.customer_name')
                    ->where('repairs.user_id', $request->session()->get('user_id'))
                    ->when($request->status, function ($query) use ($request) {
                        $query->where('repairs.status', $request->status);
                    })
                    ->when($request->filled('repairs.date_from') && $request->filled('repairs.date_to'), function ($query) use ($fromDate, $toDate) {
                        $query->whereBetween('repairs.created_at', [$fromDate, $toDate]);
                    })
                    ->orderBy('repairs.id', 'DESC')
                    ->get();




                return DataTables::of($repairs)
                    ->addColumn('status', function ($row) {
                        $statuses = ['in_progress', 'waiting_for_spare', 'returned', 'completed','delivered'];
                        $options = '';
                        foreach ($statuses as $status) {
                            $selected = $row->status === $status ? 'selected' : '';
                            $options .= "<option value='{$status}' {$selected}>" . ucwords(str_replace('_', ' ', $status)) . "</option>";
                        }
                        return '<select class=" status-select btn btn-secondary"  data-id="' . $row->id . '">' . $options . '</select>';
                    })
                    ->addColumn('action', function ($row) {
                        if($row->status != 'delivered'){
                          $az ='<a class="btn btn-primary btn-sm edit'.$row->id.'" href="' . route('repairs.edit', $row->id) . '">
                            <i class="fa fa-edit"></i> Edit
                        </a>';
                        }else{
                            $az =' ';
                        }
                        return '
                            <a class="btn btn-info btn-sm" href="' . route('repairs.show', $row->id) . '">View</a>'.$az.'
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
      $repair =  Repair::create([
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
        // PartyPayment

        $partyPaymentArr = [
            'user_id' => $request->session()->get('user_id'),
            'business_id' => $business->id,
            'party_id' => $request->customer_name,
            'transaction_type' => 'service-'.$repair->id.'',
            'invoice_no' => $request->service_no,
            'paid_date' => $request->repair_date,
            'debit' => $request->cash_received,
            'payment_type' => 'debit',
            'opening_balance' => $request->cash_received,
            'closing_balance' =>$request->cash_received,
        ];

        PartyPayment::create($partyPaymentArr);

                $latestPayment = PartyPayment::where('party_id', $request->partyid)
                ->orderBy('id', 'DESC')
                ->latest('paid_date')
                ->first();



            $invoice_id = PartyPayment::where('user_id', $request->session()->get('user_id'))
                ->where('credit', '!=', '0.00')
                ->where('invoice_no', 'LIKE', "REC")
                ->orderBy('id', 'DESC')
                ->first();
            if ($invoice_id) {
                $lastInvoiceNumber = (int) str_replace($prefix, '', $invoice_id->invoice_no);
                $nextInvoiceNumber = $lastInvoiceNumber + 1;
            } else {
                $nextInvoiceNumber = 1;
            }

            $invoice_no = $this->invoice_num($nextInvoiceNumber, 4, 'REC');
            $partyPaymentArr = [
                'user_id' => $request->session()->get('user_id'),
                'business_id' => $business->id,
                'party_id' => $request->customer_name,
                'transaction_type' =>  'service-'.$repair->id.'',
                'invoice_no' => $invoice_no,
                'paid_date' => $request->repair_date,
                'credit' => $request->cash_received ? $request->cash_received : 0 ,
                'payment_type' => 'credit',
                'opening_balance' => $request->cash_received ? $request->cash_received : 0 ,
                'closing_balance' => $request->cash_received ? $request->cash_received : 0 ,
                'mode_of_payment' => 'cash',
            ];
            PartyPayment::create($partyPaymentArr);

        return redirect()->route('repairs.index')->with('success', 'Repair request Created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Repair $repair)
    {
        $business = Business::where('user_id', $request->session()->get('user_id'))->first();
        $repair_det = Repair::leftjoin('parties','parties.id','=','repairs.customer_name')->where('repairs.id',$repair->id)->where('repairs.user_id', $request->session()->get('user_id'))->first();

        return view('repairs.show', compact('repair', 'business','repair_det'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Repair $repair)
    {

        $repair_det = Repair::leftjoin('parties','parties.id','=','repairs.customer_name')->where('repairs.id',$repair->id)->where('repairs.user_id', $request->session()->get('user_id'))->first();

        return view('repairs.edit', compact('repair','repair_det'));
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
            'status' => $request->status,
        ]);

        $partyPaymentArr1 = [
            'paid_date' => $request->repair_date,
            'debit' => $request->cash_received,
            'payment_type' => 'debit',
            'opening_balance' => $request->cash_received,
            'closing_balance' =>$request->cash_received,
        ];
        $updated = PartyPayment::where('transaction_type', 'service-' . $repair->id)->where('payment_type','debit')->update($partyPaymentArr1);


        $partyPaymentArr = [
            'paid_date' => $request->repair_date,
            'credit' => $request->cash_received,
            'payment_type' => 'credit',
            'opening_balance' => $request->cash_received,
            'closing_balance' => $request->cash_received,
        ];
        $updated = PartyPayment::where('transaction_type', 'service-' . $repair->id)->where('payment_type','credit')->update($partyPaymentArr);

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
            ->orderBy('repairs.id', 'DESC');


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
