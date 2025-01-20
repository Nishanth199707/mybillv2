<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Party;
use App\Models\PartyPayment;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductsubCategory;
use App\Models\PurchaseCustomDetails;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PurchaseReturnController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PurchaseReturn::select('*')->where('user_id', $request->session()->get('user_id'))->orderBy('id', 'DESC')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<form action="' . route('purchasereturns.destroy', $row->id) . '" method="POST" style="display:inline;">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <a class="btn btn-info btn-sm" href="' . route('purchasereturns.show', $row->id) . '"><i class="fa-solid fa-list"></i> Show</a>
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                        </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('purchaseReturn.view'); // Adjust the path to your actual view
    }

    public function create(Request $request)
    {
        //
        $user_id = $request->session()->get('user_id');
        $party = Party::select('*')->where('user_id', $request->session()->get('user_id'))->get();
        $productcategory = ProductCategory::select('*')->where('user_id', $request->session()->get('user_id'))->get();
        $productsubcategory = ProductsubCategory::select('*')->where('user_id', $request->session()->get('user_id'))->get();
        $businessCategory = Business::select('business_category')->where('user_id', $request->session()->get('user_id'))->first();

        $transactionType = 'purchase';

        $prefix = ($transactionType === 'purchase') ? 'DN' : 'CN';

        // Fetch the last invoice based on the prefix
        $invoice_id = PurchaseReturn::where('user_id', $user_id)
            ->orderBy('purchase_no', 'DESC')
            ->first();

            // dd( $invoice_id->purchase_no);
        if ($invoice_id) {
            // Extract the numeric part from the last invoice number
            $lastInvoiceNumber = (int) str_replace($prefix, '', $invoice_id->purchase_no);
            $nextInvoiceNumber = $lastInvoiceNumber + 1;
        } else {
            // Start from 1 if no previous invoice exists
            $nextInvoiceNumber = 1;
        }
        $invoice_no = $this->invoice_num($nextInvoiceNumber, 2, $prefix);
        // $purchase_no = $this->invoice_num($purchase_no_id, $pad_len = 7, $prefix = 'PUR');
        if ($request->session()->get('gstavailable') == 'yes') {
            return view('purchaseReturn.add', compact('party', 'invoice_no', 'productcategory', 'productsubcategory', 'businessCategory')); //'purchase_no'
        } else {
            return view('purchaseReturn.addnogst  ', compact('party', 'invoice_no', 'productcategory', 'productsubcategory', 'businessCategory')); //'purchase_no'
        }
    }

    public function store(Request $request)
    {

        // dd($request->all());
        if (empty($request->session()->get('user_id'))) {
            return redirect()->route('login');
        }

        $user_id = $request->session()->get('user_id');
        $business_id = Business::where('user_id', $user_id)->select('id')->first();

        if (!$business_id) {
            return redirect()->route('purchasereturns.index')->with('error', 'Business not found.');
        }

        DB::beginTransaction();

        try {
            $purchaseReturnData = [
                'user_id' => $user_id,
                'business_id' => $business_id->id,
                "party" => $request->party,
                "party_id" => $request->partyid,
                "purchase_date" => $request->purchase_date,
                "purchase_no" => $request->purchase_no,
                "totalAmountDisplay" => $request->totalAmountDisplay,
                "tax_amount_18_cgst" => $request->tax_amount_18_cgst,
                "tax_amount_18_sgst" => $request->tax_amount_18_sgst,
                "tax_amount_12_cgst" => $request->tax_amount_12_cgst,
                "tax_amount_12_sgst" => $request->tax_amount_12_sgst,
                "tax_amount_5_cgst" => $request->tax_amount_5_cgst,
                "tax_amount_5_sgst" => $request->tax_amount_5_sgst,
                "tax_amount" => $request->tax_amount,
                "net_amount" => $request->net_amount,
                "totQues" => $request->totQues,
                "cash_type" => $request->cash_type,
                "bill_type" => 'purchase',
                "remarks" => $request->remarks,
            ];

            $purchaseReturn = PurchaseReturn::create($purchaseReturnData);

            for ($i = 1; $i <= $request->totQues; $i++) {
                if ($request->input("product_id{$i}") && $request->input("qty{$i}")) {
                  Product::where('id', $request->input("product_id{$i}"))
                    ->decrement('stock', $request->input("qty{$i}"));

                    $code = $request->input("imei{$i}");
                    $product_retun =  PurchaseCustomDetails::where('user_id', $user_id)->where('field_value', '=', $code)->first();
                    if(!empty($product_retun->stock)){
                        $product_current_stock = $product_retun->stock - $request->input("qty{$i}");
                    }
                    PurchaseCustomDetails::where('user_id', $user_id)
                    ->where('field_value', '=', $code)
                    ->update(['stock' => $product_current_stock ]);

                    $purchaseReturnDetailData = [
                        'user_id' => $user_id,
                        'business_id' => $business_id->id,
                        "party_id" => $request->partyid,
                        "purchase_return_id" => $purchaseReturn->id,
                        "product_id" => $request->input("product_id{$i}"),
                        "item_description" => $request->input("item_description{$i}"),
                        "rpqty" => $request->input("rpqty{$i}"),
                        "qty" => $request->input("qty{$i}"),
                        "gst" => $request->input("gst{$i}"),
                        "gstvaldata" => $request->input("gstvaldata{$i}"),
                        "total_amount" => $request->input("total_amount{$i}"),
                    ];

                    PurchaseReturnDetail::create($purchaseReturnDetailData);
                }
            }

            if ($request->cash_type) {

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
                $invoice_no = $this->invoice_num($nextInvoiceNumber, 2, $prefix);

                if ($latestPayment) {
                    $opening_balance = $latestPayment->closing_balance;
                } else {
                    $opening_balance = 0;
                }

                $closing_balance = $opening_balance - $request->net_amount;

                $partyPaymentArr = [
                    'user_id' => $user_id,
                    'business_id' => $business_id->id,
                    'party_id' => $request->partyid,
                    'transaction_type' => 'purchase',
                    'invoice_no' => $invoice_no,
                    'paid_date' => $request->purchase_date,
                    'debit' => $request->net_amount,
                    'payment_type' => 'debit',
                    'mode_of_payment' => $request->cash_type,
                    'opening_balance' => $opening_balance,
                    'closing_balance' => $closing_balance,
                ];

                PartyPayment::create($partyPaymentArr);

            }

            DB::commit();
            return redirect()->route('purchasereturns.index')->with('success', 'Purchase return added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Purchase Return creation failed: ' . $e->getMessage());
            return redirect()->route('purchasereturns.index')->with('error', 'Failed to add purchase return.');
        }
    }

    public function invoice_num($input, $pad_len = 2, $prefix = 'INV')
    {
        if ($pad_len <= strlen($input)) {
            trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate invoice number', E_USER_ERROR);
        }

        if (is_string($prefix)) {
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));
        }

        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
    }

    public function show(Request $request, PurchaseReturn $purchasereturn)
    {

        $user_id = $request->session()->get('user_id');

        // Fetching the details of the purchase return
        $purchasedetail = PurchaseReturnDetail::join('products', 'products.id', '=', 'purchase_return_details.product_id')
            ->where('purchase_return_details.purchase_return_id', '=', $purchasereturn->id)
            ->groupBy(
                'products.hsn_code',
                'purchase_return_details.gst',
                'purchase_return_details.rpqty',
                'purchase_return_details.product_id',
                'purchase_return_details.item_description'
            ) // Group by relevant fields
            ->select(
                'purchase_return_details.product_id',
                'purchase_return_details.item_description',
                DB::raw('SUM(purchase_return_details.total_amount) as total_amount'),
                DB::raw('SUM(purchase_return_details.qty) as qty'),
                'purchase_return_details.rpqty',
                'purchase_return_details.gst',
                'products.hsn_code'
            )
            ->get();

        // Fetching party information
        $party = Party::where('id', '=', $purchasereturn->party_id)->first();

        // dd( $party,$purchasereturn->party_id,$purchasedetail,$purchasereturn->id,$purchasereturn->all(),$purchasereturn->id);
        // Fetching business information
        $business = Business::where('user_id', '=', $user_id)->first();

        // Return the view with necessary data
        return view('purchaseReturn.show', compact('business', 'party', 'purchasereturn', 'purchasedetail'));
    }

    public function edit($id)
    {
        $purchaseReturn = PurchaseReturn::with('details')->findOrFail($id);
        $products = Product::all(); // Load available products
        return view('purchase_returns.edit', compact('purchaseReturn', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'party' => 'required',
            'cash_type' => 'required',
            'item_description1' => 'required',
            'qty1' => 'required',
            'purchase_no' => 'required',
        ]);

        $purchaseReturn = PurchaseReturn::findOrFail($id);

        DB::beginTransaction();

        try {
            $purchaseReturn->update([
                'party' => $request->party,
                'party_id' => $request->partyid,
                'purchase_date' => $request->purchase_date,
                'purchase_no' => $request->purchase_no,
                'totalAmountDisplay' => $request->totalAmountDisplay,
                'cash_type' => $request->cash_type,
            ]);

            // Update purchase return details (you might need to implement logic for this)
            // You could also handle deletion and addition of details based on your requirements

            DB::commit();
            return redirect()->route('purchasereturns.index')->with('success', 'Purchase return updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('purchasereturns.index')->with('error', 'Failed to update purchase return.');
        }
    }

    public function destroy($id)
    {
        $purchaseReturn = PurchaseReturn::findOrFail($id);

        DB::beginTransaction();

        try {
            // Delete the related PurchaseReturnDetail records
            $purchaseReturn->details()->delete(); // Assuming 'details' is the relationship method

            // Delete the PurchaseReturn record itself
            $purchaseReturn->delete();

            DB::commit();
            return redirect()->route('purchasereturns.index')->with('success', 'Purchase return deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('purchasereturns.index')->with('error', 'Failed to delete purchase return: ' . $e->getMessage());
        }
    }

}
