<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Emi;
use App\Models\EmiReceived;
use App\Models\Financier;
use App\Models\PartyPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class FinancierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Financier::select('*')->where('user_id', $request->session()->get('user_id'))->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<form action="' . url('superadmin/financiers/' . $row->id . '') . '" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this Financier?\')">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <a class="btn btn-info btn-sm" href="' . url('superadmin/financiers/' . $row->id . '') . '"><i class="fa-solid fa-list"></i> Show</a>
                            <a class="btn btn-primary btn-sm" href="' . url('superadmin/financiers/' . $row->id . '/edit') . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                        </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('financiers.view');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('financiers.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate([

            'financier_name' => 'required|string|max:255',
            'agent_code' => 'required|string|max:255',
            'executive_name' => 'nullable|string|max:255',
            'executive_phone' => 'nullable|string|max:255',
            'company_email' => 'nullable|email|max:255',
        ]);

        $userId = $request->session()->get('user_id');

        $business = Business::select('id')->where('user_id', $userId)->first();

        $financierArr = [
            'user_id' => $userId,
            'business_id' => $business->id,
            'financier_name' => $request->financier_name,
            'agent_code' => $request->agent_code,
            'executive_name' => $request->executive_name,
            'executive_phone' => $request->executive_phone,
            'company_email' => $request->company_email,
        ];

        Financier::create($financierArr);

        return redirect()->route('financiers.index')
            ->with('success', 'Financier created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Financier $financier, Request $request)
    {
        $financier = Financier::select('*')->where('user_id', $request->session()->get('user_id'))->findOrFail($financier->id);

        $emis = Emi::where('financier_name', $financier->financier_name)
            ->where('business_id', $financier->business_id)
            ->get();

        $emiReceiveds = EmiReceived::where('business_id', $financier->business_id)->where('user_id', $request->session()->get('user_id'))
            ->where('financier_id',$financier->id)
            ->get();

        $pendings = EmiReceived::where('business_id', $financier->business_id)
            ->where('financier_id',$financier->id)
            ->where('user_id', $request->session()->get('user_id'))
            ->get();
        // dd($pendings);
        // Calculate totals for display
        $totalInitialPayment = $emis->sum('initial_payment');
        $totalEmiPaid = $emis->sum('emi_amount_paid');
        $totalEmiBalance = $emis->sum('emi_amount_balance');

        // Pass data to the view
        return view('financiers.show', [
            'financier' => $financier,
            'emis' => $emis,
            'emiReceiveds' => $emiReceiveds,
            'totalInitialPayment' => $totalInitialPayment,
            'totalEmiPaid' => $totalEmiPaid,
            'totalEmiBalance' => $totalEmiBalance,
            'pendings' => $pendings,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Financier $financier)
    {
        return view('financiers.edit', compact('financier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Financier $financier)
    {
        $request->validate([
            'financier_name' => 'required|string|max:255',
            'agent_code' => 'required|string|max:255',
        ]);

        $financierArr = [
            'financier_name' => $request->financier_name,
            'agent_code' => $request->agent_code,
            'executive_name' => $request->executive_name,
            'executive_phone' => $request->executive_phone,
            'company_email' => $request->company_email,

        ];

        $financier->update($financierArr);
        return redirect()->route('financiers.index')
            ->with('success', 'Financier updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Financier $financier)
    {
        $financier->delete();
        return redirect()->route('financiers.index')
            ->with('success', 'Financier deleted successfully.');
    }

    public function ajaxstore(Request $request)
    {
        // dd($request);
        $request->validate([
            'financier_name' => 'required|string|max:255',
            'agent_code' => 'required|string|max:255',
            'executive_name' => 'nullable|string|max:255',
            'executive_phone' => 'nullable|string|max:255',
            'company_email' => 'nullable|email|max:255',
        ]);

        $userId = $request->session()->get('user_id');

        $business = Business::select('id')->where('user_id', $userId)->first();

        $financierArr = [
            'user_id' => $userId,
            'business_id' => $business->id,
            'financier_name' => $request->financier_name,
            'agent_code' => $request->agent_code,
            'executive_name' => $request->executive_name,
            'executive_phone' => $request->executive_phone,
            'company_email' => $request->company_email,
        ];

        Financier::updateOrCreate($financierArr);
        $financier = Financier::select('*')->where('user_id', $request->session()->get('user_id'))->get();
        // return redirect()->route('party.index')->with('success','Party created successfully.');
        return response()->json(['success' => 'Financier created successfully.', 'financiers' => $financier], 200);
    }

    public function fetchfinanciers(Request $request)
    {

        $userId = $request->session()->get('user_id');

        $business = Business::select('id')->where('user_id', $userId)->first();

        $financier = Financier::where('user_id', '=', $userId)->where('business_id', '=', $business->id)->get();
        // return redirect()->route('party.index')->with('success','Party created successfully.');
        return response()->json(['success' => 'Financier created successfully.', 'financiers' => $financier], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $today = Carbon::now();
        $formattedToday = $today->format('d-m-Y');

        $userId = $request->session()->get('user_id');
        $business = Business::select('id')->where('user_id', $userId)->first();
        $old_emi = EmiReceived::select('id','closing_balance')->where('financier_id', $request->financier_id)->where('user_id', $request->session()->get('user_id'))->orderBy('id','desc')->first();

        $openingBalance = $old_emi->closing_balance;
        $closingBalance = $old_emi->closing_balance - $request->credit;

        $emireceivedarr = [
            'user_id' => $userId,
            'business_id' => $business->id,
            'sale_id' => $request->sale_id,
            'financier_id' => $request->financier_id,
            'loan_no' => $request->loan_no,
            'paid_date' => $formattedToday,
            'debit' => $request->credit,
            'payment_type' => 'debit',
            'mode_of_payment' => 'debit',
            'receipt_type' => 'paid',
            'opening_balance' => $openingBalance,
            'closing_balance' => $closingBalance,
            'status' => 'paid',

        ];
        EmiReceived::create($emireceivedarr);

        $emiReceived = EmiReceived::findOrFail($id);
        $emiReceived->status = 'paid';
        $emiReceived->save();

        $emiparty = DB::table('emi_receiveds')
            ->join('sales', 'emi_receiveds.sale_id', '=', 'sales.id')
            ->where('emi_receiveds.sale_id', $emiReceived->sale_id)
            ->where('emi_receiveds.user_id', $userId)
            ->select('sales.party_id')
            ->first();

        $latestPayment = PartyPayment::where('party_id', $emiparty->party_id)
            ->orderBy('id', 'DESC')
            ->latest('paid_date')
            ->first();

        $transactionType = 'sale';

        $prefix = ($transactionType === 'sale') ? 'REC' : 'PMT';

        $invoice_id = PartyPayment::where('user_id', $userId)
            ->where('debit', '!=', '0.00')
            ->where('invoice_no', 'LIKE', "$prefix%")
            ->orderBy('invoice_no', 'DESC')
            ->first();

        if ($invoice_id) {
            $lastInvoiceNumber = (int) str_replace($prefix, '', $invoice_id->invoice_no);
            $nextInvoiceNumber = $lastInvoiceNumber + 1;
        } else {
            $nextInvoiceNumber = 1;
        }

        $invoice_no = $this->invoice_num($nextInvoiceNumber,4, $prefix);

        if ($latestPayment) {
            $opening_balance = $latestPayment->opening_balance;
        } else {
            $opening_balance = 0;
        }

        $closing_balance = $opening_balance - $request->credit;

        $partyPaymentArr = [
            'user_id' => $userId,
            'business_id' => $business->id,
            'party_id' => $emiparty->party_id,
            'transaction_type' => 'sale',
            'invoice_no' => $invoice_no,
            'paid_date' => $formattedToday,
            'debit' => $request->credit,
            'payment_type' => 'debit',
            'mode_of_payment' => 'emi',
            'opening_balance' => $opening_balance,
            'closing_balance' => $closing_balance,
        ];

        // dd($partyPaymentArr);
        PartyPayment::create($partyPaymentArr);

        // Redirect or return response
        return redirect()->route('financiers.index')->with('success', 'Status updated successfully');

    }
    public function invoice_num($nextInvoiceNumber, $length = 4, $prefix = 'REC')
{
    // Format the number to the specified length with leading zeros
    $formattedNumber = str_pad($nextInvoiceNumber, $length, '0', STR_PAD_LEFT);

    // Combine the prefix and the formatted number
    return $prefix . $formattedNumber;
}

}
