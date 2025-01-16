<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Party;
use App\Models\Sale;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Business;
use App\Models\PartyPayment;
use Illuminate\Http\JsonResponse;

class PartyController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = $request->session()->get('user_id');

        if ($request->ajax()) {
            $query = Party::select('*')->where('user_id', $userId);

            if ($request->party_type != null) {

                $query->where('transaction_type', $request->party_type);
            } else {
                $query = Party::select('*')->where('user_id', $userId);
            }

            $data = $query->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<form action="' . url('superadmin/party/' . $row->id) . '" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this Party?\')">
                                 <input type="hidden" name="_method" value="DELETE">
                                 <input type="hidden" name="_token" value="' . csrf_token() . '">
                                 <a class="btn btn-info btn-sm" href="' . url('superadmin/party/' . $row->id) . '"><i class="fa-solid fa-list"></i> Show</a>
                                 <a class="btn btn-primary btn-sm" href="' . url('superadmin/party/' . $row->id . '/edit') . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                 <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                             </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('party.view');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $business = Business::where('user_id', '=', $user_id)->select('state', 'gstavailable','business_category')->first();

        // dd($business);

        return view('party.add', compact('business'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        //
        if (empty($request->session()->get('user_id'))) {
            return redirect()->route('login');
        }

        $request->validate([
            'party_type' => 'required',
            'name' => 'required',
            // 'gstin'=> 'required',
            // 'phone_no'=> 'required',
            // 'email'=> 'required',
        ]);

        $user_id = $request->session()->get('user_id');
        $business_id = Business::where('user_id', '=', $user_id)->select('id')->first();

        $partyArr = [

            'user_id' => $user_id,
            'business_id' => $business_id->id,
            'transaction_type' => $request->transaction_type,
            'party_type' => $request->party_type,
            'state' => $request->state,
            'name' => $request->name,
            'gstin' => $request->gstin,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'billing_address_1' => $request->billing_address_1,
            'billing_address_2' => $request->billing_address_2,
            'billing_pincode' => $request->billing_pincode,
            'shipping_address_1' => $request->shipping_address_1,
            'shipping_address_2' => $request->shipping_address_2,
            'shipping_pincode' => $request->shipping_pincode,
            'opening_balance' => $request->opening_balance,
            'gst_profile' => $request->gstin_status,
            'gst_response' => $request->gstin_reponse,
        ];

        $party = Party::create($partyArr);

        // if ($request->has('opening_balance') && $request->opening_balance != 0) {
        $partyPaymentArr = [
            'user_id' => $user_id,
            'business_id' => $business_id->id,
            'party_id' => $party->id,
            'transaction_type' => $request->transaction_type,
            'credit' => $request->opening_balance,
            'payment_type' => 'credit',
            'opening_balance' => $request->opening_balance,
            'closing_balance' => $request->opening_balance,
        ];

        PartyPayment::create($partyPaymentArr);
        // }


        return redirect()->route('party.index')
            ->with('success', 'Party created successfully.');
    }

    public function ajaxstore(Request $request)
    {
        //
        if (empty($request->session()->get('user_id'))) {
            return redirect()->route('login');
        }

        $request->validate([
            'party_type' => 'required',
            'name' => 'required',
            // 'gstin'=> 'required',
            // 'phone_no'=> 'required',
            // 'email'=> 'required',
        ]);

        $user_id = $request->session()->get('user_id');
        $business_id = Business::where('user_id', '=', $user_id)->select('id')->first();

        $partyArr = [

            'user_id' => $user_id,
            'business_id' => $business_id->id,
            'transaction_type' => $request->transaction_type,
            'party_type' => $request->party_type,
            'state' => $request->state,
            'name' => $request->name,
            'gstin' => $request->gstin,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'billing_address_1' => $request->billing_address_1,
            'billing_address_2' => $request->billing_address_2,
            'billing_pincode' => $request->billing_pincode,
            'shipping_address_1' => $request->shipping_address_1,
            'shipping_address_2' => $request->shipping_address_2,
            'shipping_pincode' => $request->shipping_pincode,
            'opening_balance' => $request->opening_balance,
        ];

        // dd($partyArr);

        $party = Party::create($partyArr);

        $partyPaymentArr = [
            'user_id' => $user_id,
            'business_id' => $business_id->id,
            'party_id' => $party->id,
            'transaction_type' => $request->transaction_type,
            'credit' => $request->opening_balance,
            'payment_type' => 'credit',
            'opening_balance' => $request->opening_balance,
            'closing_balance' => $request->opening_balance,
        ];

        PartyPayment::create($partyPaymentArr);

        $party = Party::select('*')->where('user_id', $request->session()->get('user_id'))->get();
        return response()->json(['success' => 'Party created successfully.', 'party' => $party], 200);
    }

    public function partyautocomplete(Request $request): JsonResponse
    {

        $data = Party::select("*")
            ->where('name', 'LIKE', '%' . $request->get('partysearch') . '%')
            ->where('transaction_type', $request->type)
            ->where('user_id', $request->session()->get('user_id'))
            ->take(10)
            ->get();

        return response()->json($data);
    }



    /**
     * Display the specified resource.
     */

    public function show(Party $party, Request $request)
    {
        $userId = $request->session()->get('user_id');
        $partyId = $party->id;

        $timePeriod = $request->get('time_period', 'all');
        $transactionType = $request->get('transaction_type', 'all');

        $salesQuery = Sale::where('user_id', $userId)
            ->where('party_id', $partyId)
            ->where('bill_type', 'sale')->get();
        $purchasesQuery = Purchase::where('user_id', $userId)
            ->where('party_id', $partyId)
            ->where('bill_type', 'purchase')->get();

        $paymentsQuery = PartyPayment::join('parties', 'party_payments.party_id', '=', 'parties.id')
            ->select('party_payments.*')
            ->where('parties.user_id', $userId)
            ->where('parties.id', $partyId)
            ->whereNotIn('party_payments.payment_type', ['waiting', 'collected']);



        $startDate = null;
        $endDate = Carbon::now();

        if ($timePeriod != 'all') {
            if ($timePeriod == '30_days') {
                $startDate = Carbon::now()->subDays(30);
            } elseif ($timePeriod == '7_days') {
                $startDate = Carbon::now()->subDays(7);
            } else {
                $startDate = Carbon::now()->subDays(365);
            }

            $paymentsQuery->whereBetween('paid_date', [$startDate, $endDate]);
        }

        if ($transactionType == 'sale') {
            $payments = $paymentsQuery->where('transaction_type', 'sale')->where('invoice_no', '!=', 'null')

                ->where('paid_date', '!=', 'null')
                // ->where('credit', '!=', 0)
                // ->where('debit', 0)

                ->get();
        } elseif ($transactionType == 'purchase') {
            $payments = $paymentsQuery->where('transaction_type', 'purchase')->whereNull('invoice_no')

                ->whereNull('paid_date')
                // ->where('credit', '!=', 0)
                // ->where('debit', 0)

                ->get();
        } else {
            $payments = $paymentsQuery->where('invoice_no', '!=', 'null')
                ->where('paid_date', '!=', 'null')
                // ->where('credit', '!=', 0)
                // ->where('debit', 0)
                ->get();
        }
        // dd($payments);

        // $closingBalance = $payments->sum('credit') - $payments->sum('debit');
        $closing_Balance = PartyPayment::where('party_id', $partyId)->where('payment_type', '!=', 'waiting')->orderBy('party_payments.id', 'DESC')->select('party_payments.closing_balance')
            ->first();
        // dd($closing_Balance);
        if ($closing_Balance != '') {

            $closingBalance = $closing_Balance->closing_balance;
        } else {
            $closingBalance = 0.00;
        }

        //    dd( $closingBalance);
        $data = Party::where('user_id', $userId)->where('id', $partyId)->first();
        $Paymentdata = PartyPayment::where('user_id', $userId)
            ->where('party_id', $partyId)
            ->get();

        // dd($payments);
        return view('party.show', compact('data', 'purchasesQuery', 'salesQuery', 'Paymentdata', 'payments', 'closingBalance', 'startDate', 'endDate', 'partyId'));
    }

    public function filterTransactions(Party $party, Request $request)
    {

        $userId = $request->session()->get('user_id');
        $partyId = $party->id;
        // Get filters from the request
        $timePeriod = $request->time_period;
        $transactionType = $request->transaction_type;


        $salesQuery = Sale::where('user_id', $userId)
            ->where('party_id', $partyId)
            ->where('bill_type', 'sale');
        $purchasesQuery = Purchase::where('user_id', $userId)
            ->where('party_id', $partyId)
            ->where('bill_type', 'purchase');

        // Initialize startDate and endDate
        $startDate = null;
        $endDate = Carbon::now();

        // Apply time period filter if not 'all'
        if ($timePeriod != 'all') {
            // Determine the start date based on the selected time period
            if ($timePeriod == '30_days') {
                $startDate = Carbon::now()->subDays(30);
            } elseif ($timePeriod == '7_days') {
                $startDate = Carbon::now()->subDays(7);
            } else {
                $startDate = Carbon::now()->subDays(365); // Default to last 365 days
            }

            $salesQuery->whereRaw('STR_TO_DATE(invoice_date, "%d-%m-%Y") BETWEEN ? AND ?', [$startDate, $endDate]);
            $purchasesQuery->whereRaw('STR_TO_DATE(purchase_date, "%d-%m-%Y") BETWEEN ? AND ?', [$startDate, $endDate]);
        }

        // Filter by transaction type if specified
        if ($transactionType == 'sale') {
            $sales = $salesQuery->get();
            $purchases = collect(); // Empty collection for purchases
        } elseif ($transactionType == 'purchase') {
            $sales = collect(); // Empty collection for sales
            $purchases = $purchasesQuery->get();
        } else {
            // No specific transaction type selected, fetch all
            $sales = $salesQuery->get();
            $purchases = $purchasesQuery->get();
        }

        // Retrieve the party data
        $data = Party::where('user_id', $userId)->where('id', $partyId)->first();

        // Prepare the response data
        $response = [
            'data' => $data,
            'sales' => $sales,
            'purchases' => $purchases,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'transactionType' => $transactionType,
        ];

        // Return JSON response
        return response()->json($response);
    }


    public function filterLedger(Party $party, Request $request)
    {

        $userId = $request->session()->get('user_id');
        $partyId = $party->id;
        // Get filters from the request
        $timePeriod = $request->time_period; // Default to 'all' time
        $transactionType = $request->transaction_type; // Default to both sales and purchases

        // Initialize queries
        $salesQuery = PartyPayment::where('user_id', $userId)
            ->where('party_id', $partyId)
            ->where('transaction_type', 'sale');
        $purchasesQuery = PartyPayment::where('user_id', $userId)
            ->where('party_id', $partyId)
            ->where('transaction_type', 'purchase')
            ->where('payment_type', '!=', 'waiting');


        // Initialize startDate and endDate
        $startDate = null;
        $endDate = Carbon::now();

        // Apply time period filter if not 'all'
        if ($timePeriod != 'all') {
            // Determine the start date based on the selected time period
            if ($timePeriod == '30_days') {
                $startDate = Carbon::now()->subDays(30);
            } elseif ($timePeriod == '7_days') {
                $startDate = Carbon::now()->subDays(7);
            } else {
                $startDate = Carbon::now()->subDays(365); // Default to last 365 days
            }

            $salesQuery->whereRaw('STR_TO_DATE(paid_date, "%d-%m-%Y") BETWEEN ? AND ?', [$startDate, $endDate]);
            $purchasesQuery->whereRaw('STR_TO_DATE(paid_date, "%d-%m-%Y") BETWEEN ? AND ?', [$startDate, $endDate]);
        }

        // Filter by transaction type if specified
        if ($transactionType == 'sale') {
            $sales = $salesQuery->get();
            $purchases = collect(); // Empty collection for purchases
        } elseif ($transactionType == 'purchase') {
            $sales = collect(); // Empty collection for sales
            $purchases = $purchasesQuery->get();
        } else {
            // No specific transaction type selected, fetch all
            $sales = $salesQuery->get();
            $purchases = $purchasesQuery->get();
        }

        // Calculate the closing balance
        $closingBalance = 0;

        if ($transactionType == 'sale') {
            $closingBalance = $sales->sum('credit') - $sales->sum('debit');;
        } elseif ($transactionType == 'purchase') {
            $closingBalance = $purchases->sum('credit') - $purchases->sum('debit');;
        }

        // Retrieve the party data
        $data = Party::where('user_id', $userId)->where('id', $partyId)->first();

        // Prepare the response data
        $response = [
            'data' => $data,
            'sales' => $sales,
            'purchases' => $purchases,
            'closingBalance' => $closingBalance,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'transactionType' => $transactionType,
        ];

        // Return JSON response
        return response()->json($response);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Party $party)
    {
        //
        //
        //  $party = Party::all();
        $user_id = $request->session()->get('user_id');
        $business = Business::where('user_id', '=', $user_id)->select('state', 'gstavailable')->first();

        return view('party.edit', compact('party', 'business'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Party $party)
    {
        //
        //
        if (empty($request->session()->get('user_id'))) {
            return redirect()->route('login');
        }

        $request->validate([
            'party_type' => 'required',
            'name' => 'required',
            // 'gstin'=> 'required',
            // 'phone_no'=> 'required',
            // 'email'=> 'required',
        ]);

        // $POB = $party->opening_balance;

        $user_id = $request->session()->get('user_id');
        $business_id = Business::where('user_id', '=', $user_id)->select('id')->first();



        $partyArr = [

            'user_id' => $user_id,
            'business_id' => $business_id->id,
            'transaction_type' => $request->transaction_type,
            'party_type' => $request->party_type,
            'state' => $request->state,
            'name' => $request->name,
            'gstin' => $request->gstin,
            'phone_no' => $request->phone_no,
            'email' => $request->email,
            'billing_address_1' => $request->billing_address_1,
            'billing_address_2' => $request->billing_address_2,
            'billing_pincode' => $request->billing_pincode,
            'shipping_address_1' => $request->shipping_address_1,
            'shipping_address_2' => $request->shipping_address_2,
            'shipping_pincode' => $request->shipping_pincode,
            'opening_balance' => $request->opening_balance,
        ];

        $party->update($partyArr);

        // if ($POB == 0) {

        //     if ($request->opening_balance != 0) {
        //         $partyPaymentArr = [
        //             'user_id' => $user_id,
        //             'business_id' => $business_id->id,
        //             'party_id' => $party->id,
        //             'transaction_type' => $request->transaction_type,
        //             'credit' => $request->opening_balance,
        //             'payment_type' => 'credit',
        //             'opening_balance' => $request->opening_balance,
        //             'closing_balance' => $closingBalance,
        //         ];

        //         PartyPayment::create($partyPaymentArr);
        //     }
        // } else {
        // Retrieve the first payment record for the party
        $partyPayment = PartyPayment::where('party_id', $party->id)
            ->where('payment_type', 'credit')
            ->where('invoice_no', NULL)
            ->first();

        // dd($partyPayment);



        // Prepare payment update data
        $partyPaymentData = [
            'user_id' => $user_id,
            'business_id' => $business_id->id,
            'party_id' => $party->id,
            'transaction_type' => $request->transaction_type,
            'credit' => $request->opening_balance,
            'payment_type' => 'credit',
            'opening_balance' => $request->opening_balance,
            'closing_balance' => $request->opening_balance,
        ];

        // Update the existing payment record
        $partyPayment->update($partyPaymentData);

        // Get all remaining payments for the same party
        $remainingPayments = PartyPayment::where('party_id', $party->id)
            ->whereNotIn('payment_type', ['waiting', 'collected'])
            ->orderBy('created_at', 'asc')
            ->get();


        // Check if there are remaining payments
        if ($remainingPayments->isNotEmpty()) {
            // Initialize opening balance based on the last payment's closing balance
            $opening_balance = $partyPayment->closing_balance;

            // Loop through remaining payments to update their balances
            foreach ($remainingPayments as $remainingPayment) {
                // Skip the updated payment record
                if ($remainingPayment->id === $partyPayment->id) {
                    continue;
                }

                // Set the current opening balance
                $remainingPayment->opening_balance = $opening_balance;

                // Calculate the closing balance
                // Closing balance = Opening balance + Credit - Debit
                $remainingPayment->closing_balance = $opening_balance + ($remainingPayment->credit - $remainingPayment->debit);

                // Save the updated entry
                $remainingPayment->save();

                // Update opening balance for the next iteration
                $opening_balance = $remainingPayment->closing_balance;
            }
            // }
        }



        return redirect()->route('party.index')
            ->with('success', 'Party Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Party $party)
    {
        //
        // First, delete the related party payments
        PartyPayment::where('party_id', $party->id)->delete();

        // Then, delete the party
        Party::findOrFail($party->id)->delete();
        return redirect()->route('party.index')
            ->with('success', 'Party deleted successfully');
    }


    public function invoice_num($number, $pad_len = 7, $prefix = 'REC')
    {
        // Pad the number with leading zeros to the specified length
        $paddedNumber = str_pad($number, $pad_len, '0', STR_PAD_LEFT);
        // Combine the prefix with the padded number
        return $prefix . $paddedNumber;
    }


    public function partypayment(Request $request)
    {

        $date = $request->paid_date;
        $formattedDate = Carbon::parse($date)->format('d-m-Y');
        $formattedCollectionDate = Carbon::parse($request->collection_date)->format('d-m-Y');
        $user_id = $request->session()->get('user_id');
        $business_id = Business::where('user_id', '=', $user_id)->select('id')->first();

        $latestPayment = PartyPayment::where('party_id', $request->partyid)
            ->whereNotIn('payment_type', ['waiting', 'collected'])
            ->orderBy('id', 'DESC')
            ->latest('paid_date')
            ->first();

        // dd($latestPayment->paid_date,$latestPayment->party_id);
        $data = Party::select('*')->where('user_id', $user_id)->where('id', $request->partyid)->first();


        $transactionType = $data->transaction_type; // or 'purchase', set this based on your logic

        // Set the appropriate prefix based on transaction type
        // $prefix = ($transactionType === 'sale') ? 'REC' : 'PMT';

        if ($request->adjust_payment == 'yes') {

            $prefix = 'ADJ';
        } else {
            $prefix = ($transactionType === 'sale') ? 'REC' : 'PMT';
        }

        // Fetch the last invoice based on the prefix
        $invoice_id = PartyPayment::where('user_id', $user_id)
            ->where('debit', '!=', '0.00')
            ->where('invoice_no', 'LIKE', "$prefix%") // Filter by prefix
            ->orderBy('id', 'DESC')
            ->first();

        if ($invoice_id) {
            // Extract the numeric part from the last invoice number
            $lastInvoiceNumber = (int) str_replace($prefix, '', $invoice_id->invoice_no);
            $nextInvoiceNumber = $lastInvoiceNumber + 1;
        } else {
            // Start from 1 if no previous invoice exists
            $nextInvoiceNumber = 1;
        }

        // Generate the next invoice number with padding
        $invoice_no = $this->invoice_num($nextInvoiceNumber, 4, $prefix);



        if ($request->mode_of_payment == 'cheque') {

            $partyPaymentArr = [
                'user_id' => $user_id,
                'business_id' => $business_id->id,
                'party_id' => $request->partyid,
                'transaction_type' => $data->transaction_type,
                'remark' => $request->remark,
                'paid_date' => $formattedDate,
                'credit' => $request->cash_received,
                'payment_type' => 'waiting',
                'mode_of_payment' => $request->mode_of_payment,
                'receipt_type' => $data->transaction_type,
                'transaction_number' => $request->transaction_number,
                'collection_date' => $formattedCollectionDate,
                'opening_balance' => $latestPayment->closing_balance,
                'closing_balance' => $latestPayment->closing_balance,
            ];
        } else if ($request->has('cheque_amount')) {

            //  dd($request->all());

            if ($latestPayment) {
                $opening_balance = $latestPayment->closing_balance;
            } else {
                $opening_balance = 0;
            }

            $closing_balance = $opening_balance - $request->cheque_amount;

            // dd($opening_balance , $closing_balance);

            $partyPaymentArr = [
                'user_id' => $user_id,
                'business_id' => $business_id->id,
                'party_id' => $request->partyid,
                'transaction_type' => $request->transaction_type,
                'invoice_no' => $invoice_no,
                'remark' => $request->remark,
                'paid_date' => $formattedDate,
                'debit' => $request->cheque_amount,
                'payment_type' => 'debit',
                'mode_of_payment' => 'cheque',
                'receipt_type' => $request->transaction_type,
                'transaction_number' => $request->transaction_number,
                'collection_date' => $formattedCollectionDate,
                'opening_balance' => $opening_balance,
                'closing_balance' => $closing_balance,
            ];
            $payment = PartyPayment::where('party_id', $request->partyid)->where('id', $request->paymentid)->first();
            $payment->update(['payment_type' => 'collected']);
        } else if ($request->mode_of_payment == 'scheme') {

            $latestPayment = PartyPayment::where('party_id', $request->partyid)
                ->orderBy('id', 'DESC')
                ->latest('paid_date')
                ->first();

            $transactionType = 'purchase';

            $prefix = ($transactionType === 'purchase') ? 'DN' : 'CN';

            // Fetch the last invoice based on the prefix
            $invoice_id = PartyPayment::where('user_id', $user_id)
                ->where('debit', '!=', '0.00')
                ->where('invoice_no', 'LIKE', "$prefix%") // Filter by prefix
                ->orderBy('invoice_no', 'DESC')
                ->first();

            if ($invoice_id) {
                // Extract the numeric part from the last invoice number
                $lastInvoiceNumber = (int) str_replace($prefix, '', $invoice_id->invoice_no);
                $nextInvoiceNumber = $lastInvoiceNumber + 1;
            } else {
                // Start from 1 if no previous invoice exists
                $nextInvoiceNumber = 1;
            }
            $invoice_no = $this->invoice_num($nextInvoiceNumber, 4, $prefix);
            // dd($invoice_no );
            if ($latestPayment) {
                $opening_balance = $latestPayment->closing_balance;
            } else {
                $opening_balance = 0;
            }

            $closing_balance = $opening_balance - $request->cash_received;

            $partyPaymentArr = [
                'user_id' => $user_id,
                'business_id' => $business_id->id,
                'party_id' => $request->partyid,
                'transaction_type' => 'purchase',
                'invoice_no' => $invoice_no,
                'paid_date' => $formattedDate,
                'debit' => $request->cash_received,
                'payment_type' => 'debit',
                'mode_of_payment' => $request->mode_of_payment,
                'opening_balance' => $opening_balance,
                'closing_balance' => $closing_balance,
            ];

            PartyPayment::create($partyPaymentArr);
        } else {

            // dd($latestPayment->closing_balance);

            if ($latestPayment) {
                $opening_balance = $latestPayment->closing_balance;
            } else {
                $opening_balance = 0;
            }

            // dd( $opening_balance );

            $closing_balance = $opening_balance - $request->cash_received;

            // dd( $opening_balance,$closing_balance ,$request->cash_received);

            $partyPaymentArr = [
                'user_id' => $user_id,
                'business_id' => $business_id->id,
                'party_id' => $request->partyid,
                'transaction_type' => $data->transaction_type,
                'invoice_no' => $invoice_no,
                'remark' => $request->remark,
                'paid_date' => $formattedDate,
                'debit' => $request->cash_received,
                'payment_type' => 'debit',
                'mode_of_payment' => $request->mode_of_payment,
                'receipt_type' => $data->transaction_type,
                'transaction_number' => $request->transaction_number,
                'collection_date' => $request->collection_date,
                'opening_balance' => $opening_balance,
                'closing_balance' => $closing_balance,
            ];
        }

        PartyPayment::create($partyPaymentArr);
        return redirect()->to('superadmin/party/' . $request->partyid);
    }

    public function receivePayment(Request $request)
    {

        $user_id = $request->session()->get('user_id');
        $business_id = Business::where('user_id', '=', $user_id)->select('id')->first();

        $data = Party::select('*')->where('user_id', $user_id)->where('transaction_type', 'sale')->get();
        return view('party.ReceivePayment', compact('data'));
    }

    public function addPayment(Request $request)
    {

        $user_id = $request->session()->get('user_id');
        $business_id = Business::where('user_id', '=', $user_id)->select('id')->first();

        $data = Party::select('*')->where('user_id', $user_id)->where('transaction_type', 'purchase')->get();

        return view('party.AddPayment', compact('data'));
    }

    public function viewReceipt(Request $request)
    {
        $userId = $request->session()->get('user_id');

        // $Date = Carbon::today()->format('d-m-Y');

        $data = PartyPayment::join('parties', 'party_payments.party_id', '=', 'parties.id')
            ->where('party_payments.user_id', $userId)
            ->select(
                'parties.id as party_id',
                'party_payments.invoice_no as invoice',
                'parties.name as party_name',
                'party_payments.debit as amount',
                'party_payments.paid_date as date'
            )
            ->where('party_payments.invoice_no', 'like', '%REC%')
            // ->where('party_payments.receipt_type', 'sale')
            ->orderBy('party_payments.invoice_no', 'DESC')
            ->get();

        // dd( $data  ,$userId);

        return view('party.viewReceipt', compact('data'));
    }

    public function viewPayment(Request $request)
    {
        $userId = $request->session()->get('user_id');

        $Date = Carbon::today()->format('d-m-Y');

        $data = PartyPayment::join('parties', 'party_payments.party_id', '=', 'parties.id', 'left')
        ->where('party_payments.user_id', $userId)
        ->where(function ($query) {
            $query->where('party_payments.invoice_no', 'like', '%PMT%')
                  ->orWhere('party_payments.invoice_no', 'like', '%EXPN%');
        })
        ->orderBy('party_payments.invoice_no', 'DESC')
        ->select('parties.name as party_name', 'party_payments.invoice_no as invoice', 'party_payments.debit as amount', 'party_payments.paid_date as date')
        ->get();

        // dd( $data ,$Date ,$userId);
        return view('party.viewPayment', compact('data'));
    }

    public function paymentdestroy($id)
    {
        // dd($id);
        // Find the payment entry by ID
        $payment = PartyPayment::findOrFail($id);

        // dd($payment);
        // Capture the debit value of the deleted entry
        $debitDeleted = $payment->debit;

        // Delete the entry
        $payment->delete();

        // Get all remaining payments for the same party
        $remainingPayments = PartyPayment::where('party_id', $payment->party_id)->orderBy('created_at', 'asc')->get();



        // If there are remaining payments, calculate balances
        if ($remainingPayments->isNotEmpty()) {
            // Loop through remaining payments to update their balances
            foreach ($remainingPayments as $index => $remainingPayment) {
                // Set opening balance for the first entry
                if ($index === 0) {
                    $opening_balance = $remainingPayment->closing_balance; // No previous entry, so opening balance is zero
                } else {
                    // Use the previous entry's closing balance as the new opening balance
                    $opening_balance = $remainingPayments[$index - 1]->closing_balance;
                }

                // Calculate closing balance for the current entry
                $remainingPayment->opening_balance = $opening_balance;
                $remainingPayment->closing_balance = $opening_balance - $remainingPayment->debit;

                // Save the updated entry
                $remainingPayment->save();
            }
        }

        // Redirect back with updated balances
        // return redirect()->route('your.route.name') // Update with your actual route name
        //                  ->with([
        //                      'success' => 'Payment entry deleted successfully.',
        //                      'debitDeleted' => $debitDeleted,
        //                  ]);
        return redirect()->to('superadmin/party/' . $payment->party_id);
    }
    public function viewCheque(Request $request)
    {
        $userId = $request->session()->get('user_id');

        $data = PartyPayment::join('parties', 'party_payments.party_id', '=', 'parties.id')
            ->where('parties.user_id', $userId)
            ->whereIn('party_payments.payment_type', ['waiting', 'collected'])
            ->orderBy('party_payments.invoice_no', 'DESC')
            ->select(
                'parties.name as party_name',
                'party_payments.transaction_number as cheque_no',
                'party_payments.credit as amount',
                'party_payments.paid_date as date',
                \DB::raw('CASE
                    WHEN party_payments.payment_type = "waiting" THEN "Waiting"
                    WHEN party_payments.payment_type = "collected" THEN "Collected"
                    ELSE "Unknown"
                END as status')
            )
            ->get();

        return view('party.viewCheque', compact('data'));
    }


    public function debtors(Request $request)
    {
        $userId = $request->session()->get('user_id');
        $data = PartyPayment::join('parties', 'party_payments.party_id', '=', 'parties.id')
            ->where('parties.user_id', $userId)
            ->where('party_payments.invoice_no', 'like', '%PMT%')
            ->select(
                'parties.name as party_name',
                DB::raw('MAX(party_payments.invoice_no) as latest_invoice'),
                DB::raw('SUM(party_payments.debit) as total_amount'),
            )
            ->groupBy('parties.id')
        ->orderBy('parties.id', 'ASC')
            ->get();

        return view('party.debtors', compact('data'));
    }

    public function creditors(Request $request)
{
    $userId = $request->session()->get('user_id');

    $data = PartyPayment::join('parties', 'party_payments.party_id', '=', 'parties.id')
        ->where('party_payments.user_id', $userId)
        ->where('party_payments.invoice_no', 'like', '%REC%')
        ->select(
            'parties.name as party_name',
            DB::raw('COUNT(party_payments.invoice_no) as total_receipts'),
            DB::raw('SUM(party_payments.credit) as total_amount'),
            DB::raw('MAX(party_payments.paid_date) as latest_date'),
            DB::raw('MAX(party_payments.invoice_no) as latest_invoice')
        )
        ->groupBy('parties.id')
        ->orderBy('parties.id', 'ASC')
        ->get();

    return view('party.creditors', compact('data'));
}

}
