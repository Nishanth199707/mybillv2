<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Party;
use App\Models\PartyPayment;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductsubCategory;
use App\Models\Purchase;
use App\Models\PurchaseCustomDetails;
use App\Models\PurchaseDetail;
use App\Models\PurchaseReturn;
use App\Models\PurchaseReturnDetail;
use App\Models\Sale;
use App\Models\SaleDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        //
        if ($request->ajax()) {
            $data = Purchase::select('*')->where('user_id', $request->session()->get('user_id'))->orderBy('id','DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<form action="' . url('superadmin/purchase/' . $row->id . '') . '" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this Bill?\')">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <a class="btn btn-info btn-sm" href="' . url('superadmin/purchase/' . $row->id . '') . '"><i class="fa-solid fa-list"></i> Show</a>
                                <a class="btn btn-primary btn-sm" style="display:none;" href="' . url('superadmin/purchase/' . $row->id . '/edit') . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                                </form>';
                    return $btn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
        return view('purchase.view');
    }

    public function purchaseautocomplete(Request $request): JsonResponse
    {
        $data = Product::select("id", "item_name", "purchase_price", "sale_price", "gst_rate", "stock",'imei')
            ->where('item_name', 'LIKE', '%' . $request->get('search') . '%')
            ->where('user_id', $request->session()->get('user_id'))
            ->where('item_type','!=','service')
            ->where('status',1)
            ->take(10)
            ->get();
        return response()->json($data);
    }

    public function invoice_num($input, $pad_len = 5, $prefix = 'INV')
    {
        if ($pad_len <= strlen($input))
            trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate invoice number', E_USER_ERROR);

        if (is_string($prefix))
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $user_id = $request->session()->get('user_id');

        // $purchase_no_id = Purchase::where('user_id', '=', $user_id)->orderby('id', 'DESC')->first();
        // if (empty($purchase_no_id)) {
        //     $purchase_no_id = 1;
        // } else {
        //     $purchase_no_id = $purchase_no_id->id + 1;
        // }
        $party = Party::select('*')->where('user_id', $request->session()->get('user_id'))->get();
        $productcategory = ProductCategory::select('*')->where('user_id', $request->session()->get('user_id'))->get();

        $productsubcategory = ProductsubCategory::select('*')->where('user_id', $request->session()->get('user_id'))->get();

        $businessCategory = Business::select('business_category','gstavailable')->where('user_id', $request->session()->get('user_id'))->first();

        // $purchase_no = $this->invoice_num($purchase_no_id, $pad_len = 7, $prefix = 'PUR');
        if ($request->session()->get('gstavailable') == 'yes') {
            return view('purchase.add', compact('party', 'productcategory', 'productsubcategory', 'businessCategory')); //'purchase_no'
        } else {
            return view('purchase.addnogst  ', compact('party', 'productcategory', 'productsubcategory',  'businessCategory')); //'purchase_no'
            // return view('purchase.add', compact('party', 'productcategory', 'productsubcategory', 'businessCategory')); //'purchase_no'
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (empty($request->session()->get('user_id'))) {
            return redirect()->route('login');
        }

        // Validate the incoming request
        $request->validate([
            'party' => 'required',
            'cash_type' => 'required',
            'item_description1' => 'required',
            'qty1' => 'required',
        ]);

        $user_id = $request->session()->get('user_id');
        $business = Business::where('user_id', $user_id)->first();

        if (!$business) {
            return redirect()->route('purchase.index')->with('error', 'Business not found.');
        }

        DB::beginTransaction();

        try {
            // Create the purchase
            $salesArr = $this->prepareSalesArray($request, $user_id, $business->id);
            $purchaseInsert = Purchase::create($salesArr);

            $this->handlePurchaseDetails($request, $purchaseInsert->id, $user_id, $business->id);
            $this->handlePartyPayment($request, $purchaseInsert->id, $user_id, $business->id);

            // Handle IMEI numbers
            $this->handleIMEI($request, $purchaseInsert->id, $user_id, $business->id);

            // Update product prices
            $this->updateProductPrices($request);

            DB::commit();
            return redirect()->route('purchase.index', $purchaseInsert->id)->with('success', 'New Purchase Added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error for debugging
            \Log::error('Purchase creation failed: ' . $e->getMessage());
            return redirect()->route('purchase.index')->with('error', 'Failed to add new purchase.');
        }
    }

    // Method to prepare the sales array
    private function prepareSalesArray(Request $request, $user_id, $business_id)
    {
        return [
            'user_id' => $user_id,
            'business_id' => $business_id,
            "party" => $request->party,
            "party_id" => $request->partyid,
            "purchase_date" => $request->purchase_date,
            "purchase_no" => $request->purchase_no,
            "totalAmountDisplay" => $request->totalAmountDisplay,
            "tax_amount_28_cgst" => $request->tax_amount_28_cgst,
            "tax_amount_28_sgst" => $request->tax_amount_28_sgst,
            "tax_amount_18_cgst" => $request->tax_amount_18_cgst,
            "tax_amount_18_sgst" => $request->tax_amount_18_sgst,
            "tax_amount_12_cgst" => $request->tax_amount_12_cgst,
            "tax_amount_12_sgst" => $request->tax_amount_12_sgst,
            "tax_amount_5_cgst" => $request->tax_amount_5_cgst,
            "tax_amount_5_sgst" => $request->tax_amount_5_sgst,
            "tax_amount_28_igst" => $request->tax_amount_28_igst,
            "tax_amount_18_igst" => $request->tax_amount_18_igst,
            "tax_amount_12_igst" => $request->tax_amount_12_igst,
            "tax_amount_5_igst" => $request->tax_amount_5_igst,
            "tax_amount" => $request->tax_amount,
            "net_amount" => $request->net_amount,
            "totQues" => $request->totQues,
            "cash_type" => $request->cash_type,
            "bill_type" => 'purchase'
        ];
    }

    // Method to handle purchase details
    private function handlePurchaseDetails(Request $request, $purchaseId, $user_id, $business_id)
    {
        for ($j = 0; $j < $request->totQues; $j++) {
            $i = $j + 1;

            if ($request->input("product_id{$i}") && $request->input("qty{$i}")) {
                Product::where('id', $request->input("product_id{$i}"))
                    ->increment('stock', $request->input("qty{$i}"));

                $purchasesProductArr = [
                    'user_id' => $user_id,
                    'business_id' => $business_id,
                    "party_id" => $request->partyid,
                    "purchase_id" => $purchaseId,
                    "product_id" => $request->input("product_id{$i}"),
                    "item_description" => $request->input("item_description{$i}"),
                    "rpqty" => $request->input("rpqty{$i}"),
                    "qty" => $request->input("qty{$i}"),
                    "gst" => $request->input("gst{$i}"),
                    "gstvaldata" => $request->input("gstvaldata{$i}"),
                    "total_amount" => $request->input("total_amount{$i}"),
                ];

                PurchaseDetail::create($purchasesProductArr);
            }
        }
    }

    // Method to handle party payment
    private function handlePartyPayment(Request $request, $purchaseId, $user_id, $business_id)
    {
        // Initialize party payment data
        $partyPaymentData = [
            'user_id' => $user_id,
            'business_id' => $business_id,
            'party_id' => $request->partyid,
            'transaction_type' => 'purchase',
            'invoice_no' => $request->purchase_no,
            'paid_date' => $request->purchase_date,
            'credit' => $request->net_amount,
            'payment_type' => 'credit',
            'mode_of_payment' => $request->cash_type,
        ];

        // Get the latest party payment for opening balance
        $opening_balance = PartyPayment::where('party_id', $request->partyid)
        ->orderBy('id', 'DESC')
        ->latest('paid_date')
        ->value('closing_balance') ?? 0;


// dd( $opening_balance);

        // $opening_balance = $latestPartyPayment ? $latestPartyPayment->closing_balance : 0;
        $partyPaymentData['opening_balance'] = $opening_balance + $request->net_amount;
        $partyPaymentData['closing_balance'] = $opening_balance + $request->net_amount;

        // Create the party payment record
        PartyPayment::create($partyPaymentData);


        // dd($latestPartyPayment->closing_balance);
        // If payment type is cash, handle debit transaction
        if ($request->cash_type === 'cash') {

            $transactionType = 'purchase'; // or 'purchase', set this based on your logic

            // Set the appropriate prefix based on transaction type
            $prefix = ($transactionType === 'purchase') ? 'PMT' : 'REC';

            // Fetch the last invoice based on the prefix
            $invoice_id = PartyPayment::where('user_id', $user_id)
                ->where('debit', '!=', '0.00')
                ->where('invoice_no', 'LIKE', "$prefix%") // Filter by prefix
                ->orderBy('invoice_no', 'DESC')
                ->first();

            if ($invoice_id) {
                // Extract the numeric part from the last invoice number
                $lastInvoiceNumber = (int)str_replace($prefix, '', $invoice_id->invoice_no);
                $nextInvoiceNumber = $lastInvoiceNumber + 1;
            } else {
                // Start from 1 if no previous invoice exists
                $nextInvoiceNumber = 1;
            }

            // Generate the next invoice number with padding
            $invoice_no = $this->invoice_num($nextInvoiceNumber, 4, $prefix);


            $latestPayment = PartyPayment::where('party_id', $request->partyid)
            ->orderBy('id', 'DESC')
            ->latest('paid_date')
            ->first();

        if ($latestPayment) {
            $opening_balance = $latestPayment->opening_balance;
        } else {
            $opening_balance = 0;
        }

        $closing_balance = $opening_balance - $request->net_amount;
            // Prepare debit transaction details
            $debitData = [
                'user_id' => $user_id,
                'business_id' => $business_id,
                'party_id' => $request->partyid,
                'transaction_type' => 'purchase',
                'invoice_no' => $invoice_no,
                'paid_date' => $request->purchase_date,
                'debit' => $request->net_amount,
                'payment_type' => 'debit',
                'mode_of_payment' => $request->cash_type,
                'opening_balance' =>  $opening_balance ,
                'closing_balance' => $closing_balance,
            ];

            // Create the debit party payment record
            PartyPayment::create($debitData);
        }
    }


    // Method to handle IMEI entries
    private function handleIMEI(Request $request, $purchaseId, $user_id, $business_id)
    {
        for ($j = 0; $j < $request->totQues; $j++) {
            $i = $j + 1;
            $imeiValues = $request->input("imei");

            if (isset($imeiValues[$i])) {
                foreach ($imeiValues[$i] as $imei) {
                    if (!empty($imei)) {
                        $imeiData = [
                            'user_id' => $user_id,
                            'business_id' => $business_id,
                            'party_id' => $request->partyid,
                            'purchase_id' => $purchaseId,
                            'product_id' => $request->input("product_id{$i}"),
                            'field_name' => 'IMEI',
                            'field_value' => $imei,
                            'stock' => 1,
                        ];
                        PurchaseCustomDetails::create($imeiData);
                    }
                }
            }
        }
    }

    // Method to update product prices
    private function updateProductPrices(Request $request)
    {
        for ($j = 0; $j < $request->totQues; $j++) {
            $i = $j + 1;
            $productId = $request->input("product_id{$i}");

            if ($productId) {
                $product = Product::find($productId);
                if ($product) {
                    $purchasePrice = $request->input("rpqty{$i}");
                    $salePrice = $request->input("saleamount{$i}");
                    $gst = $request->input("gst{$i}");
                    $SalePrice = round($salePrice / (1 + ($gst / 100)), 2);

                    $product->update([
                        'purchase_price' => $purchasePrice,
                        // 'sale_price' => $SalePrice,
                    ]);
                }
            }
        }
    }




    /**
     * Display the specified resource.
     */
    public function show(Request $request, Purchase $purchase)
    {
        //
        $user_id = $request->session()->get('user_id');

        // $saledetail = SaleDetail::join('products', 'products.id','=','sale_details.product_id')->where('sale_details.sale_id', '=', $sale->id)->get();
        $purchasedetail = PurchaseDetail::join('products', 'products.id', '=', 'purchase_details.product_id')
            ->where('purchase_details.purchase_id', '=', $purchase->id)
            ->groupBy('products.hsn_code', 'purchase_details.gst', 'purchase_details.rpqty', 'purchase_details.product_id', 'purchase_details.item_description') // Group by product ID and product name
            ->select(
                'purchase_details.product_id',
                'purchase_details.item_description',
                DB::raw('SUM(purchase_details.total_amount) as total_amount'),
                DB::raw('SUM(purchase_details.qty) as qty'),
                'purchase_details.rpqty', // Optional
                'purchase_details.gst', // Optional
                'products.hsn_code', // Optional
            )
            ->get();
        // dd($saledetail);
        $party = Party::where('user_id', '=', $user_id)->where('transaction_type', $purchase->bill_type)->first();

        $business = Business::where('user_id', '=', $user_id)->select('*')->first();

        // dd($sale);

        return view('purchase.show', compact('business', 'party', 'purchase', 'purchasedetail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Purchase $purchase)
    {
        //
        // dd($sale);

        $user_id = $request->session()->get('user_id');
        $business = Business::where('user_id', '=', $user_id)->select('*')->first();


        $purchase_no = 0;
        $party = Party::where('user_id', '=', $user_id)->first();
        $productcategory = ProductCategory::all();
        // $purchase_no += $id;
        // $purchase_no = $this->purchase_num ($purchase_no, $pad_len = 7, $prefix = 'INV');
        $purchase_no = $purchase->purchase_no;
        $purchase = Purchase::find($purchase->id);
        $purchasedetail = DB::table('purchase_details')
            ->join('products', 'purchase_details.product_id', '=', 'products.id')
            ->where('purchase_details.purchase_id', $purchase->id)
            ->select('purchase_details.*', 'products.sale_price') // select fields you need
            ->get();


        // return view('sales.add',compact('party','sale','purchase_no','saledetail','productcategory'));
        // return response()->json();


        return view('purchase.edit', compact(
            'party',
            'purchase',
            'purchase_no',
            'business',
            'purchasedetail',
            'productcategory',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        //

        // dd($request);

        if (empty($request->session()->get('user_id'))) {
            return redirect()->route('login');
        }

        $request->validate([
            'party' => 'required',
            'cash_type' => 'required',
            'item_description1' => 'required',
            'qty1' => 'required',
        ]);



        $user_id = $request->session()->get('user_id');
        $business_id = Business::where('user_id', '=', $user_id)->select('id')->first();

        $purchasesArr = [
            'user_id' => $user_id,
            'business_id' => $business_id->id,
            "party" => $request->party,
            "party_id" => $request->partyid,
            "invoice_date" => $request->invoice_date,
            "invoice_no" => $request->invoice_no,
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
            "bill_type" => 'purchase'
        ];

        $purchase->update($purchasesArr);
        $i = 0;
        // dd($request->totQues);
        for ($j = 0; $j < $request->totQues; $j++) {
            $i = $j + 1;
            if ($request->input("product_id{$i}") != '' && $request->input("qty{$i}") != '') {

                if ($request->input("purchase_detail_id{$i}") != 0) {
                    $purchasedetail = PurchaseDetail::find($request->input("purchase_detail_id{$i}"));

                    if ($purchasedetail->qty == $request->input("qty{$i}")) {
                        $purchasesProductArr = [
                            'user_id' => $user_id,
                            'business_id' => $business_id->id,
                            "party_id" => $request->partyid,
                            "purchase_id" => $purchasedetail->purchase_id,
                            "product_id" => $request->input("product_id{$i}"),
                            "item_description" => $request->input("item_description{$i}"),
                            "rpqty" => $request->input("rpqty{$i}"),
                            "qty" => $request->input("qty{$i}"),
                            "gst" => $request->input("gst{$i}"),
                            "gstvaldata" => $request->input("gstvaldata{$i}"),
                            "total_amount" => $request->input("total_amount{$i}"),
                        ];
                        $purchasedetail->update($purchasesProductArr);
                    } else {
                        $difference = $purchasedetail->qty - $request->input("qty{$i}");
                        $stock_update = Product::where('id', '=', $request->input("product_id{$i}"));
                        if ($difference > 0) {
                            $stock_update->increment('stock', $difference);
                        }
                        if ($difference < 0) {
                            $stock_update->increment('stock', abs($difference));
                        }

                        $purchasesProductArr = [
                            'user_id' => $user_id,
                            'business_id' => $business_id->id,
                            "party_id" => $request->partyid,
                            "purchase_id" => $purchasedetail->purchase_id,
                            "product_id" => $request->input("product_id{$i}"),
                            "item_description" => $request->input("item_description{$i}"),
                            "rpqty" => $request->input("rpqty{$i}"),
                            "qty" => $request->input("qty{$i}"),
                            "gst" => $request->input("gst{$i}"),
                            "gstvaldata" => $request->input("gstvaldata{$i}"),
                            "total_amount" => $request->input("total_amount{$i}"),
                        ];
                        $purchasedetail->update($purchasesProductArr);
                    }
                } else {

                    $purchasesProductArr = [
                        'user_id' => $user_id,
                        'business_id' => $business_id->id,
                        "party_id" => $request->partyid,
                        "purchase_id" => $purchase->id,
                        "product_id" => $request->input("product_id{$i}"),
                        "item_description" => $request->input("item_description{$i}"),
                        "rpqty" => $request->input("rpqty{$i}"),
                        "qty" => $request->input("qty{$i}"),
                        "gst" => $request->input("gst{$i}"),
                        "gstvaldata" => $request->input("gstvaldata{$i}"),
                        "total_amount" => $request->input("total_amount{$i}"),
                    ];
                    PurchaseDetail::create($purchasesProductArr);
                }
            }
            $productId = $request->input("product_id{$i}");

            if (!empty($productId)) {
                $product = Product::where('id', $productId)->first();

                if ($product) {
                    $purchasePrice = $request->input("rpqty{$i}");
                    $salePrice = $request->input("saleamount{$i}");
                    $gst = $request->input("gst{$i}");
                    $SalePrice = round($salePrice / (1 + ($gst / 100)), 2);

                    $product->update([
                        'purchase_price' => $purchasePrice,
                        'sale_price' => $SalePrice,
                    ]);
                }
            }
        }
        return redirect()->route('purchase.index', $purchase->id)->with('success', 'Purchase Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            $purchaseDetails = PurchaseDetail::where('purchase_id', $purchase->id)->get();
            $purchaseCustomDetails = PurchaseCustomDetails::where('purchase_id', $purchase->id)->get();

            foreach ($purchaseDetails as $detail) {

                $product = Product::find($detail->product_id);
                if ($product) {
                    $product->stock -= $detail->qty;

                    // if ($product->stock < 0) {
                    //     $product->stock = 0;
                    // }

                    $product->save();
                }
            }



            PurchaseDetail::where('purchase_id', $purchase->id)->delete();
            PurchaseCustomDetails::where('purchase_id', $purchase->id)->delete();

            $purchase->delete();

            DB::commit();

            return redirect()->route('purchase.index')
                ->with('success', 'Purchase and related details deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('purchase.index')
                ->with('error', 'Failed to delete purchase. Please try again.');
        }
    }

    public function purchasereturnindex(Request $request)
    {
        $user_id = $request->session()->get('user_id');


        $party = Party::where('user_id', '=', $user_id)->get();
        $productcategory = ProductCategory::where('user_id', '=', $user_id)->get();

        if ($request->session()->get('gstavailable') == 'yes') {
            return view('purchase.purchasereturn', compact('party', 'productcategory')); //'purchase_no'
        } else {
            return view('purchase.purchasereturnnogst  ', compact('party', 'productcategory')); //'purchase_no'
        }
    }
}
