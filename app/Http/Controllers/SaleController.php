<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Emi;
use App\Models\EmiReceived;
use App\Models\Financier;
use App\Models\Party;
use App\Models\PartyPayment;
use App\Models\Product;
use App\Models\States;
use App\Models\Setting;
use App\Models\ProductCategory;
use App\Models\ProductsubCategory;
use App\Models\PurchaseCustomDetails;
use App\Models\Sale;
use App\Models\User;
use App\Models\SaleDetail;
use App\Models\SaleReturn;
use App\Models\SaleReturnDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Http;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd( $request->session()->get('user_id'));
        if ($request->ajax()) {
            $data = DB::table('sales')
                ->join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
                ->join('parties', 'sale_details.party_id', '=', 'parties.id')
                ->orderBy('sales.id', 'DESC')
                ->where('sales.user_id', $request->session()->get('user_id'))
                ->select('sales.*', 'sale_details.item_description', 'parties.name as party', 'parties.phone_no')
                ->get();

            // dd($data);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<form action="' . url('superadmin/sale/' . $row->id) . '" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this Bill?\')">
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <a class="btn btn-info btn-sm" style="margin:5px;" href="' . url('superadmin/sale/' . $row->id) . '"><i class="fa-solid fa-list"></i> View</a>';

                    if ($row->cash_type === 'emi') {
                        $btn .= '<button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                     <a class="btn btn-primary btn-sm" href="' . url('superadmin/sale/' . $row->id . '/edit') . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                  </form>';
                    } else {
                        $btn .= '<button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                  </form>';
                    }


                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('sales.view');
    }

    public function autocomplete(Request $request): JsonResponse
    {
        $searchTerm = $request->get('search');

        $userId = $request->session()->get('user_id');

        // Get the business category for the current user
        $businessCategory = Business::select('business_category')
            ->where('user_id', $userId)
            ->first();

        $query = Product::query();

        $query->where('products.user_id', $userId)->where('products.status',1);

        // if ($businessCategory && $businessCategory->business_category === 'Mobile & Accessories') {
        //     $query->select('products.id', 'products.item_name', 'products.sale_price', 'products.gst_rate', 'products.stock', 'purchase_custom_details.field_name', 'purchase_custom_details.field_value')
        //         ->leftJoin('purchase_custom_details', 'products.id', '=', 'purchase_custom_details.product_id')
        //         ->where('purchase_custom_details.stock', '!=', 0)
        //         ->where(function ($subQuery) use ($searchTerm) {
        //             $subQuery->where('products.item_name', 'LIKE', $searchTerm . '%')
        //                 ->orWhere('purchase_custom_details.field_value', $searchTerm);
        //         });
        //                } else {
        //     $query->select('id', 'item_name', 'item_code_barcode', 'sale_price', 'gst_rate', 'stock')
        //         ->where(function ($subQuery) use ($searchTerm) {
        //             $subQuery->where('item_name', 'LIKE', '%' . $searchTerm . '%')
        //                 ->orWhere('item_code_barcode', 'LIKE', '%' . $searchTerm . '%');
        //         });
        // }

        $customDetail = DB::table('purchase_custom_details')
            ->where('field_value', $searchTerm)
            ->first();

        // if ($businessCategory && $businessCategory->business_category === 'Mobile & Accessories') {

            if (!empty($customDetail)) {
                $query->leftJoin('purchase_custom_details','products.id', '=', 'purchase_custom_details.product_id')
                    ->select('products.id', 'products.item_name', 'products.sale_price', 'products.gst_rate', 'products.stock', 'purchase_custom_details.field_value')
                    ->where('purchase_custom_details.stock', '!=', 0)
                    ->where('products.status', 1)
                    ->where(function ($subQuery) use ($searchTerm) {
                        $subQuery->where('products.item_name', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('purchase_custom_details.field_value', 'LIKE', '%' . $searchTerm . '%');
                    });
            } else if (empty($customDetail)) {
                // First part of the query with purchase_custom_details
                $query1 = DB::table('products')
                    ->leftJoin('purchase_custom_details', 'products.id', '=', 'purchase_custom_details.product_id')
                    ->select('products.id', 'products.item_name','products.purchase_price', 'products.sale_price', 'products.gst_rate', 'products.stock', 'purchase_custom_details.field_value')
                    ->where('purchase_custom_details.stock', '!=', 0)
                    ->where('products.user_id', $userId)
                    ->where('products.status', 1)
                    ->where(function ($subQuery) use ($searchTerm) {
                        $subQuery->where('products.item_name', 'LIKE', '%' . $searchTerm . '%')
                            ->orWhere('purchase_custom_details.field_value', 'LIKE', '%' . $searchTerm . '%');
                    });

                // Second part of the query for products only
                $query2 = DB::table('products')
                    ->select('products.id', 'products.item_name','products.purchase_price', 'products.sale_price', 'products.gst_rate', 'products.stock', DB::raw('NULL as field_value'))
                    ->where('products.user_id', $userId)
                    ->where('products.status', 1)
                    ->where('products.item_name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('item_code_barcode', 'LIKE', '%' . $searchTerm . '%');

                // Combine both queries using UNION
                $query = $query1->union($query2);
            } else {
                $query->where('products.item_name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('item_code_barcode', 'LIKE', '%' . $searchTerm . '%');
            }
        // } else {
        //     $query->select('id', 'item_name', 'item_code_barcode', 'sale_price', 'gst_rate', 'stock')
        //         ->where(function ($subQuery) use ($searchTerm) {
        //             $subQuery->where('item_name', 'LIKE', '%' . $searchTerm . '%')
        //                 ->orWhere('item_code_barcode', 'LIKE', '%' . $searchTerm . '%');
        //         });
        // }
        // dd($query->toSql(), $query->getBindings());
        $data = $query->get();

        // Return the result as JSON
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $gstavailable = $request->session()->get('gstavailable');
        // dd($gstavailable);
        $user_id = $request->session()->get('user_id');
        $business = Business::select('id')->where('user_id', '=', $user_id)->first();
        $setting = Setting::where('user_id', $request->session()->get('user_id'))->first();


        $invoice_id = Sale::where('business_id', $business->id)
            ->where('user_id', $user_id)
            ->select('invoice_no')
            ->orderBy('id', 'DESC')
            ->first();
        // dd($invoice_id->invoice_no);
        if ($invoice_id) {
            // Extract the numeric part from the last invoice number
            $lastInvoiceNumber = (int) str_replace('INV', '', $invoice_id->invoice_no);
            $nextInvoiceNumber = $lastInvoiceNumber + 1;
        } else {
            // Start from 1 if no previous invoice exists
            $nextInvoiceNumber = 1;
        }

        $party = Party::all();
        $productcategory = ProductCategory::all();
        $invoice_no = $this->invoice_num($nextInvoiceNumber, $pad_len = 4, $prefix = 'INV');


        $productcategory = ProductCategory::select('*')->where('user_id', $request->session()->get('user_id'))->get();

        $productsubcategory = ProductsubCategory::select('*')->where('user_id', $request->session()->get('user_id'))->get();

        $businessCategory = Business::select('business_category', 'gstavailable','gst_auth','auth_response','gstin')->where('user_id', '=', $user_id)->first();

        // dd($businessCategory);
        if ($request->session()->get('gstavailable') == 'yes') {

            return view('sales.add', compact('party', 'invoice_no', 'productsubcategory', 'productcategory', 'businessCategory', 'setting'));
        } else {
            return view('sales.addnogst', compact('party', 'invoice_no', 'productsubcategory', 'productcategory', 'businessCategory'));
        }
    }

    public function invoice($id)
    {
        $invoice_no = 0;
        $party = Party::all();
        $productcategory = ProductCategory::all();
        $invoice_no += $id;
        $invoice_no = $this->invoice_num($invoice_no, $pad_len = 4, $prefix = 'INV');

        $sale = Sale::find($id);
        $saledetail = SaleDetail::where('sale_id', '=', $id)->get();
        // return view('sales.add',compact('party','sale','invoice_no','saledetail','productcategory'));
        return response()->json(
            [
                'party' => $party,
                'sale' => $sale,
                'invoice_no' => $invoice_no,
                'saledetail' => $saledetail,
                'productcategory' => $productcategory,
                'success' => 'Sales saved successfully.',
            ]
        );
    }

    public function invoice_num($input, $pad_len = 4, $prefix = 'INV')
    {
        // dd(strlen($input),$pad_len);
        if ($pad_len <= strlen($input)) {
            trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate invoice number', E_USER_ERROR);
        }

        if (is_string($prefix)) {
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));
        }

        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
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
        $e_bill = $request->e_bill;
        $request->validate([
            'party' => 'required',
            'cash_type' => 'required',
            'item_description1' => 'required',
            'qty1' => 'required',
        ]);

        $user_id = $request->session()->get('user_id');
        $business_id = Business::where('user_id', '=', $user_id)->select('id')->first();
        if($e_bill == '1'){
            $user_details = User::where('id', '=', $user_id)->first();
            $bus_details = Business::where('user_id', '=', $user_id)->first();
            $user_state = States::where('name', '=', $bus_details->state)->first();
            $party_deatils = Party::where('id', '=', $request->partyid)->first();
            $party_state = States::where('name', '=', $party_deatils->state)->first();
        }

        $salesArr = [
            'user_id' => $user_id,
            'business_id' => $business_id->id,
            "party" => $request->party,
            "party_id" => $request->partyid,
            "invoice_date" => $request->invoice_date,
            "invoice_no" => $request->invoice_no,
            "totalAmountDisplay" => $request->totalAmountDisplay,

            "taxable28Amount" => $request->taxable28Amount,
            "taxable18Amount" => $request->taxable18Amount,
            "taxable12Amount" => $request->taxable12Amount,
            "taxable5Amount" => $request->taxable5Amount,
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
            "cash_received" => $request->cash_received,
            "totQues" => $request->totQues,
            "cash_type" => $request->cash_type,
            "bill_type" => 'sale',
            'purchase_order_date' => $request->purchase_order_date,
            'purchase_order_number' => $request->purchase_order_number,
            'vehicle_no' => $request->vehicle_no,
        ];
        $cgstValue = $request->tax_amount_28_cgst + $request->tax_amount_18_cgst + $request->tax_amount_12_cgst + $request->tax_amount_5_cgst;
        $sgstValue = $request->tax_amount_28_sgst + $request->tax_amount_18_sgst + $request->tax_amount_12_sgst + $request->tax_amount_5_sgst;
        $igstValue = $request->tax_amount_28_igst + $request->tax_amount_18_igst + $request->tax_amount_12_igst + $request->tax_amount_5_igst;

        $saleInsert = Sale::create($salesArr);
        // $j=0;
        // dd($request->totQues);
        $itemdetais = [];
        for ($j = 0; $j < $request->totQues; $j++) {
            $i = $j + 1;
            if ($request->input("product_id{$i}") != '' && $request->input("qty{$i}") != '') {

                $productId = $request->input("product_id{$i}");

                if (!empty($productId)) {
                    $product = Product::where('id', $productId)->first();

                    if ($product) {

                        $salePrice = $request->input("rpqty{$i}");
                        $gst = $request->input("gst{$i}");
                        $SalePrice = round($salePrice / (1 + ($gst / 100)));

                        $product->update([

                            'sale_price' => $SalePrice,
                        ]);
                    }
                }

                Product::where('id', '=', $request->input("product_id{$i}"))
                    ->decrement('stock', $request->input("qty{$i}"));

                $itemDescription = $request->input("item_description{$i}");

                if (preg_match('/\((\d+)\)/', $itemDescription, $matches)) {
                    $code = $matches[1];
                } else {
                    $code = null;
                }

                // dd($code,$itemDescription);

                // dd($request->input("qty{$i}"), $itemDescription , $code);
                DB::table('purchase_custom_details')->where('field_value', '=', $code)
                    ->decrement('stock', $request->input("qty{$i}"));

                $salesProductArr = [
                    'user_id' => $user_id,
                    'business_id' => $business_id->id,
                    "party_id" => $request->partyid,
                    "sale_id" => $saleInsert->id,
                    "product_id" => $request->input("product_id{$i}"),
                    "item_description" => $request->input("item_description{$i}"),
                    "rpqty" => $SalePrice,
                    "qty" => $request->input("qty{$i}"),
                    "gst" => $request->input("gst{$i}"),
                    "discount" => $request->input("dis{$i}"),
                    "amount" => $request->input("amount{$i}"),
                    "gstvaldata" => $request->input("gstvaldata{$i}"),
                    "total_amount" => $request->input("total_amount{$i}"),
                ];
                if($e_bill == '1'){

                if($party_state->code == $user_state->code){
                    $cgst = $product->gst_rate/2;
                    $sgst = $product->gst_rate/2;
                    $igst = 0;
                }else{
                    $cgst = 0;
                    $sgst = 0;
                    $igst = $product->gst_rate;
                }

                $itemdetais[] = [
                        "productName" => "$product->item_name",
                        "productDesc" => "$product->description",
                        "hsnCode" => (int)$product->hsn_code,
                        "quantity" => (int)$request->input("qty{$i}"),
                        "qtyUnit" => "$product->units",
                        "taxableAmount" => (int)$request->input("amount{$i}"),
                        "sgstRate" => (int)$sgst,
                        "cgstRate" => (int)$cgst,
                        "igstRate" => (int)$igst,
                        "cessRate" => 0 ];
                }
                SaleDetail::create($salesProductArr);
            }
        }

        $party = PartyPayment::where('user_id', '=', $user_id)->where('business_id', '=', $business_id->id)->select('*')->first();

        if ($party != null) {

            $opening_balance = PartyPayment::where('party_id', $request->partyid)
                ->orderBy('id', 'DESC')
                ->latest('paid_date')
                ->value('closing_balance') ?? 0;

            $partyPaymentArr = [
                'user_id' => $user_id,
                'business_id' => $business_id->id,
                'party_id' => $request->partyid,
                'transaction_type' => 'sale',
                'invoice_no' => $request->invoice_no,
                'paid_date' => $request->invoice_date,
                'credit' => $request->net_amount,
                'payment_type' => 'credit',
                'opening_balance' => $opening_balance + $request->net_amount,
                'closing_balance' => $opening_balance + $request->net_amount,
            ];

            PartyPayment::create($partyPaymentArr);
        } else {
            $partyPaymentArr = [
                'user_id' => $user_id,
                'business_id' => $business_id->id,
                'party_id' => $request->partyid,
                'transaction_type' => 'sale',
                'invoice_no' => $request->invoice_no,
                'paid_date' => $request->invoice_date,
                'credit' => $request->net_amount,
                'payment_type' => 'credit',
                'opening_balance' => $request->net_amount,
                'closing_balance' => $request->net_amount,
            ];

            PartyPayment::create($partyPaymentArr);
        }
        if ($request->cash_type == 'cash' || $request->cash_type == 'online') {

            $latestPayment = PartyPayment::where('party_id', $request->partyid)
                ->orderBy('id', 'DESC')
                ->latest('paid_date')
                ->first();

            $transactionType = 'sale';
            $prefix = ($transactionType === 'sale') ? 'REC' : 'PMT';

            $invoice_id = PartyPayment::where('user_id', $user_id)
                ->where('debit', '!=', '0.00')
                ->where('invoice_no', 'LIKE', "$prefix%")
                ->orderBy('id', 'DESC')
                ->first();

            if ($invoice_id) {
                $lastInvoiceNumber = (int) str_replace($prefix, '', $invoice_id->invoice_no);
                $nextInvoiceNumber = $lastInvoiceNumber + 1;
            } else {
                $nextInvoiceNumber = 1;
            }

            $invoice_no = $this->invoice_num($nextInvoiceNumber, 4, $prefix);

            if ($latestPayment) {
                $opening_balance = $latestPayment->opening_balance;
            } else {
                $opening_balance = 0;
            }

            $closing_balance = $opening_balance - $request->cash_received;

            $partyPaymentArr = [
                'user_id' => $user_id,
                'business_id' => $business_id->id,
                'party_id' => $request->partyid,
                'transaction_type' => 'sale',
                'invoice_no' => $invoice_no,
                'paid_date' => $request->invoice_date,
                'debit' => $request->cash_received,
                'payment_type' => 'debit',
                'mode_of_payment' => $request->cash_type,
                'opening_balance' => $opening_balance,
                'closing_balance' => $closing_balance,
            ];

            PartyPayment::create($partyPaymentArr);
        } elseif ($request->cash_type == 'emi') {

            $latestPayment = PartyPayment::where('party_id', $request->partyid)
                ->orderBy('id', 'DESC')
                ->latest('paid_date')
                ->first();

            $transactionType = 'sale';

            $prefix = ($transactionType === 'sale') ? 'REC' : 'PMT';

            $invoice_id = PartyPayment::where('user_id', $user_id)
                ->where('debit', '!=', '0.00')
                ->where('invoice_no', 'LIKE', "$prefix%")
                ->orderBy('id', 'DESC')
                ->first();

            if ($invoice_id) {
                $lastInvoiceNumber = (int) str_replace($prefix, '', $invoice_id->invoice_no);
                $nextInvoiceNumber = $lastInvoiceNumber + 1;
            } else {
                $nextInvoiceNumber = 1;
            }

            $invoice_no = $this->invoice_num($nextInvoiceNumber, 4, $prefix);

            if ($latestPayment) {
                $opening_balance = $latestPayment->opening_balance;
            } else {
                $opening_balance = 0;
            }

            $closing_balance = $opening_balance - $request->cash_received;

            $partyPaymentArr = [
                'user_id' => $user_id,
                'business_id' => $business_id->id,
                'party_id' => $request->partyid,
                'transaction_type' => 'sale',
                'invoice_no' => $invoice_no,
                'paid_date' => $request->invoice_date,
                'debit' => $request->initial_payment,
                'payment_type' => 'debit',
                'mode_of_payment' => $request->cash_type,
                'opening_balance' => $opening_balance,
                'closing_balance' => $closing_balance,
            ];

            PartyPayment::create($partyPaymentArr);
        }

        if ($request->financier_name) {
            // dd($request->financier_name);

            $balance = $request->net_amount - $request->initial_payment;
            $financier = Financier::select('id')->where('user_id', $request->session()->get('user_id'))
                ->where('financier_name', $request->financier_name)->first();

            $emiarr = [
                'user_id' => $user_id,
                'business_id' => $business_id->id,
                "sale_id" => $saleInsert->id,
                'financier_name' => $request->financier_name,
                'loan_no' => $request->loan_no,
                'initial_payment' => $request->initial_payment,
                'emi' => $request->emi,
                'scheme' => $request->scheme,
            ];
            // dd($emiarr);
            $emi = Emi::create($emiarr);

            $old_emi = EmiReceived::select('id', 'closing_balance')->where('financier_id', $financier->id)->where('user_id', $request->session()->get('user_id'))->orderBy('id', 'desc')->first();
            if ($old_emi) {
                $openingBalance = $old_emi->closing_balance;
                $closingBalance = $old_emi->closing_balance + $balance;
                $emireceivedarr = [
                    'user_id' => $user_id,
                    'business_id' => $business_id->id,
                    'sale_id' => $saleInsert->id,
                    'financier_id' => $financier->id,
                    'loan_no' => $request->loan_no,
                    'paid_date' => $request->paid_date,
                    'credit' => $balance,
                    'payment_type' => 'credit',
                    'mode_of_payment' => 'credit',
                    'receipt_type' => 'notpaid',
                    'opening_balance' => $openingBalance,
                    'closing_balance' => $closingBalance,
                    'status' => 'notpaid',

                ];
                EmiReceived::create($emireceivedarr);
            } else {
                $emireceivedarr = [
                    'user_id' => $user_id,
                    'business_id' => $business_id->id,
                    'sale_id' => $saleInsert->id,
                    'financier_id' => $financier->id,
                    'loan_no' => $request->loan_no,
                    'paid_date' => $request->paid_date,
                    'credit' => $balance,
                    'payment_type' => 'credit',
                    'mode_of_payment' => 'credit',
                    'receipt_type' => 'notpaid',
                    'opening_balance' => $balance,
                    'closing_balance' => $balance,
                    'status' => 'notpaid',

                ];
                EmiReceived::create($emireceivedarr);
            }
        }
        if($e_bill == '1'){
            $jsonData = [
                "supplyType" => "O",
                "subSupplyType" => "1",
                "subSupplyDesc" => " ",
                "docType" => "INV",
                "docNo" => "INV".$saleInsert->id."",
                "docDate" => date('d/m/Y'),
                "fromGstin" => "$request->gstin",
                "fromTrdName" => "$user_details->name",
                "fromAddr1" => "$user_details->address",
                "fromAddr2" => "".$user_details->address."",
                "fromPlace" => "$user_details->city",
                "actFromStateCode" => $user_state->code ? (int)$user_state->code : 0,
                "fromPincode" => $bus_details->pincode ? (int)$bus_details->pincode : 000000,
                "fromStateCode" => $user_state->code ? (int)$user_state->code : 0,
                "toGstin" => "$party_deatils->gstin",
                "toTrdName" => "$party_deatils->name",
                "toAddr1" => "$party_deatils->billing_address_1",
                "toAddr2" => "$party_deatils->billing_address_2",
                "toPlace" => " ",
                "toPincode" => $party_deatils->billing_pincode ? (int)$party_deatils->billing_pincode : 000000,
                "actToStateCode" => $party_state->code ? (int)$party_state->code : 0,
                "toStateCode" => $party_state->code ? (int)$party_state->code : 0,
                "transactionType" => 1,
                "dispatchFromGSTIN" => "$request->gstin",
                "dispatchFromTradeName" => "$bus_details->company_name",
                "shipToGSTIN" => "$party_deatils->gstin",
                "shipToTradeName" => "$party_deatils->name",
                "totalValue" => (int)$request->TotalAmount,
                "cgstValue" => (int)$cgstValue,
                "sgstValue" => (int)$sgstValue,
                "igstValue" => (int)$igstValue,
                "cessValue" => 0,
                "cessNonAdvolValue" => 0,
                "totInvValue" => (int)$request->net_amount,
                "transMode" => "$request->transMode",
                "transDistance" => "$request->transDistance",
                "transporterName" => "$request->transporterName",
                "transDocNo" => "$request->transDocNo",
                "transDocDate" => date('d/m/Y'),
                "vehicleNo" => $request->vehicleNo,
                "vehicleType" => $request->vehicleType,
                "itemList" =>
                    $itemdetais,
            ];
            if (!empty($request->transporterId)) {
                $jsonData["transporterId"] = $request->transporterId;
            }
            $client_id = env('MASTERGST_CLIENT_ID');
            $client_secret = env('MASTERGST_CLIENT_SECRET');
            $email = env('MASTERGST_MAILID');
            $gsturl = env('GST_BASE_URL');
            $ipAddress = $_SERVER['SERVER_ADDR'] ?? getHostByName(getHostName());
            try {
                // Make the API call with SSL verification disabled
                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'ip_address' => $ipAddress,
                    'client_id' => $client_id,
                    'client_secret' => $client_secret,
                    'gstin' => $request->gstin,
                ])->withoutVerifying()->post($gsturl.'/ewaybillapi/v1.03/ewayapi/genewaybill?email='.$email.'', $jsonData);
                // Check for a successful response
                if ($response->successful()) {
                 $response_data = $response->json();
                 $res_ebill = $response_data['data']['ewayBillNo'];
                 $sales_update = Sale::where('id',$saleInsert->id);
                 $sales_update->update([
                    'ewayBillNo' => $res_ebill,
                    'ebillresponse' => json_encode($response->json())
                ]);
                } else {
                    // Log the response status and body for debugging
                    Log::error('API response error', [
                        'status' => $response->status(),
                        'body' => $response->body()
                    ]);
                }
            } catch (RequestException $e) {
                // Catch any errors
                if ($e->hasResponse()) {
                    $response = $e->getResponse();
                    echo json_encode($response->json());
                    die;
                } else {
                    // Log the exception for debugging
                    Log::error('API request exception', [
                        'exception' => $e->getMessage()
                    ]);
                }
            }

        }
        // return response()->json([])->with('success','Sale Completed successfully.');
        // return response()->json(['invoice_id' => $saleInsert->id, 'success' => 'Product saved successfully.']);
        // $saleArrData = Sale::find($saleInsert->id);
        // $saledetailData = SaleDetail::where('sale_id', '=', $saleInsert->id)->get();

        return redirect()->route('sale.show', $saleInsert->id)->with('success', 'New Sale Added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function showdata(Request $request)
    {
        dd($_GET);
        //
        // $saleArrData = Sale::find($saleInsert->id);
        // $saledetailData = SaleDetail::where('sale_id', '=', $saleInsert->id)->get();

    }

    public function show($id, Request $request)
    {
        //
        $sale = Sale::where('id', $id)
            ->select(
                '*',
                DB::raw('SUM(tax_amount_28_cgst + tax_amount_18_cgst + tax_amount_12_cgst + tax_amount_5_cgst) as total_cgst'),
                DB::raw('SUM(tax_amount_28_sgst + tax_amount_18_sgst + tax_amount_12_sgst + tax_amount_5_sgst) as total_sgst'),
                DB::raw('SUM(tax_amount_28_igst + tax_amount_18_igst + tax_amount_12_igst + tax_amount_5_igst) as total_igst')
            )
            ->groupBy('id')
            ->first();

        // dd($sale);

        $user_id = $request->session()->get('user_id');
        // dd($user_id);

        // $saledetail = SaleDetail::join('products', 'products.id','=','sale_details.product_id')->where('sale_details.sale_id', '=', $sale->id)->get();
        $saledetail = SaleDetail::join('products', 'products.id', '=', 'sale_details.product_id')
            ->where('sale_details.sale_id', '=', $sale->id)
            ->where('sale_details.user_id', $request->session()->get('user_id'))
            ->groupBy('products.hsn_code', 'sale_details.amount', 'sale_details.gst', 'sale_details.rpqty', 'sale_details.discount', 'sale_details.product_id', 'sale_details.item_description') // Group by product ID and product name
            ->select(
                'sale_details.product_id',
                'sale_details.item_description',
                DB::raw('SUM(sale_details.total_amount) as total_amount'),
                DB::raw('SUM(sale_details.qty) as qty'),
                'sale_details.rpqty',
                'sale_details.amount',
                'sale_details.discount',
                'sale_details.gst',
                'products.hsn_code',

            )
            ->get();
        $party = Party::where('id', '=', $sale->party_id)->first();
        $emi = Emi::where('sale_id', '=', $sale->id)->first();

        // dd($party);

        $business = Business::where('id', '=', $sale->business_id)->select('*')->first();

        $setting = Setting::where('settings.user_id', $request->session()->get('user_id'))
            ->join('setting_details', 'settings.id', '=', 'setting_details.settings_id')
            ->select('settings.*', 'setting_details.signature_image', 'setting_details.description_text')
            ->first();
        // dd($sale);
        if ($request->session()->get('gstavailable') == 'yes') {
            // dd($setting->invoice);
            return view('sales.' . $setting->invoice, compact('business', 'party', 'sale', 'saledetail', 'emi', 'setting'));
        } else {

            // dd($setting->invoice);
            return view('sales.shownogst', compact('business', 'party', 'sale', 'saledetail', 'emi', 'setting'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Sale $sale)
    {
        //
        // dd($sale);

        $user_id = $request->session()->get('user_id');
        $business = Business::where('user_id', '=', $user_id)->select('*')->first();

        $invoice_no = 0;
        $party = Party::where('user_id', '=', $user_id)->first();
        $productcategory = ProductCategory::all();
        // $invoice_no += $id;
        // $invoice_no = $this->invoice_num ($invoice_no, $pad_len = 7, $prefix = 'INV');
        $invoice_no = $sale->invoice_no;
        $sale = Sale::find($sale->id);
        $saledetail = SaleDetail::where('sale_id', '=', $sale->id)->where('user_id', '=', $user_id)->get();
        $emi = Emi::where('sale_id', '=', $sale->id)->where('user_id', '=', $user_id)->first();
        // dd($emi);
        // return view('sales.add',compact('party','sale','invoice_no','saledetail','productcategory'));
        // return response()->json();

        $businessCategory = Business::select('business_category')->where('user_id', '=', $user_id)->first();

        if ($businessCategory->business_category === 'Mobile & Accessories') {
            $businessCategory = 'mobile-accessories';
        } else {
            $businessCategory = 'null';
        }

        if ($request->session()->get('gstavailable') == 'yes') {
            return view('sales.edit', compact('party', 'sale', 'invoice_no', 'business', 'saledetail', 'emi', 'productcategory', 'businessCategory'));
        } else {
            return view('sales.editnogst', compact('party', 'sale', 'invoice_no', 'business', 'saledetail', 'emi', 'productcategory', 'businessCategory'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        //
        // dd($request);

        if (empty($request->session()->get('user_id'))) {
            return redirect()->route('login');
        }

        // $request->validate([
        //     'party' => 'required',
        //     'cash_type' => 'required',
        //     'item_description1' => 'required',
        //     'qty1' => 'required',
        // ]);

        $user_id = $request->session()->get('user_id');
        $business_id = Business::where('user_id', '=', $user_id)->select('id')->first();

        $emi = Emi::where('sale_id', '=', $sale->id)->where('user_id', $user_id)->first();

        // $salesArr = [
        //     'user_id' => $user_id,
        //     'business_id' => $business_id->id,
        //     "party" => $request->party,
        //     "party_id" => $request->partyid,
        //     "invoice_date" => $request->invoice_date,
        //     "invoice_no" => $request->invoice_no,
        //     "totalAmountDisplay" => $request->totalAmountDisplay,

        //     "taxable28Amount" => $request->taxable28Amount,
        //     "taxable18Amount" => $request->taxable18Amount,
        //     "taxable12Amount" => $request->taxable12Amount,
        //     "taxable5Amount" => $request->taxable5Amount,
        //     "tax_amount_28_cgst" => $request->tax_amount_28_cgst,
        //     "tax_amount_28_sgst" => $request->tax_amount_28_sgst,

        //     "tax_amount_18_cgst" => $request->tax_amount_18_cgst,
        //     "tax_amount_18_sgst" => $request->tax_amount_18_sgst,
        //     "tax_amount_12_cgst" => $request->tax_amount_12_cgst,
        //     "tax_amount_12_sgst" => $request->tax_amount_12_sgst,
        //     "tax_amount_5_cgst" => $request->tax_amount_5_cgst,
        //     "tax_amount_5_sgst" => $request->tax_amount_5_sgst,
        //     "tax_amount" => $request->tax_amount,
        //     "net_amount" => $request->net_amount,
        //     "totQues" => $request->totQues,
        //     "cash_type" => $request->cash_type,
        //     "bill_type" => 'sale'
        // ];

        // $sale->update($salesArr);
        // $i = 0;
        // // dd($request->totQues);
        // for ($j = 0; $j < $request->totQues; $j++) {
        //     $i = $j + 1;
        //     if ($request->input("product_id{$i}") != '' && $request->input("qty{$i}") != '') {

        //         if ($request->input("sale_detail_id{$i}") != 0) {
        //             $saledetail = SaleDetail::find($request->input("sale_detail_id{$i}"));

        //             if ($saledetail->qty == $request->input("qty{$i}")) {
        //                 $salesProductArr = [
        //                     'user_id' => $user_id,
        //                     'business_id' => $business_id->id,
        //                     "party_id" => $request->partyid,
        //                     "sale_id" => $saledetail->sale_id,
        //                     "product_id" => $request->input("product_id{$i}"),
        //                     "item_description" => $request->input("item_description{$i}"),
        //                     "rpqty" => $request->input("rpqty{$i}"),
        //                     "qty" => $request->input("qty{$i}"),
        //                     "amount" => $request->input("amount{$i}"),
        //                     "gst" => $request->input("gst{$i}"),
        //                     "gstvaldata" => $request->input("gstvaldata{$i}"),
        //                     "total_amount" => $request->input("total_amount{$i}"),
        //                 ];
        //                 $saledetail->update($salesProductArr);
        //             } else {
        //                 $difference = $saledetail->qty - $request->input("qty{$i}");
        //                 $stock_update = Product::where('id', '=', $request->input("product_id{$i}"));
        //                 if ($difference > 0) {
        //                     $stock_update->increment('stock', $difference);
        //                 }
        //                 if ($difference < 0) {
        //                     $stock_update->increment('stock', abs($difference));
        //                 }

        //                 $salesProductArr = [
        //                     'user_id' => $user_id,
        //                     'business_id' => $business_id->id,
        //                     "party_id" => $request->partyid,
        //                     "sale_id" => $saledetail->sale_id,
        //                     "product_id" => $request->input("product_id{$i}"),
        //                     "item_description" => $request->input("item_description{$i}"),
        //                     "rpqty" => $request->input("rpqty{$i}"),
        //                     "qty" => $request->input("qty{$i}"),
        //                     "amount" => $request->input("amount{$i}"),
        //                     "gst" => $request->input("gst{$i}"),
        //                     "gstvaldata" => $request->input("gstvaldata{$i}"),
        //                     "total_amount" => $request->input("total_amount{$i}"),
        //                 ];
        //                 $saledetail->update($salesProductArr);
        //             }
        //         } else {

        //             $salesProductArr = [
        //                 'user_id' => $user_id,
        //                 'business_id' => $business_id->id,
        //                 "party_id" => $request->partyid,
        //                 "sale_id" => $sale->id,
        //                 "product_id" => $request->input("product_id{$i}"),
        //                 "item_description" => $request->input("item_description{$i}"),
        //                 "rpqty" => $request->input("rpqty{$i}"),
        //                 "qty" => $request->input("qty{$i}"),
        //                 "amount" => $request->input("amount{$i}"),
        //                 "gst" => $request->input("gst{$i}"),
        //                 "gstvaldata" => $request->input("gstvaldata{$i}"),
        //                 "total_amount" => $request->input("total_amount{$i}"),
        //             ];
        //             SaleDetail::create($salesProductArr);
        //         }
        //     }

        // dd($request->all());
        if ($request->financier_name) {
            // dd($request->financier_name);

            $balance = $request->net_amount - $request->initial_payment;
            $financier = Financier::select('id')->where('user_id', $request->session()->get('user_id'))->where('financier_name', $request->financier_name)->first();
            $emireceived = EmiReceived::where('sale_id', '=', $sale->id)->where('user_id', $user_id)->first();

            $emiarr = [
                'user_id' => $user_id,
                'business_id' => $business_id->id,
                "sale_id" => $sale->id,
                'financier_name' => $request->financier_name,
                'loan_no' => $request->loan_no,
                'initial_payment' => $request->initial_payment,
                'emi' => $request->emi,
                'scheme' => $request->scheme,
            ];
            // dd($emiarr);
            $emi->update($emiarr);

            if ($emireceived) {
                $emireceivedarr = [
                    'user_id' => $user_id,
                    'business_id' => $business_id->id,
                    'sale_id' => $sale->id,
                    'financier_id' => $financier->id,
                    'loan_no' => $request->loan_no,
                    'paid_date' => $request->paid_date,
                    'credit' => $balance,
                    'payment_type' => 'credit',
                    'mode_of_payment' => 'credit',
                    'receipt_type' => 'notpaid',
                    'opening_balance' => $balance,
                    'closing_balance' => $balance,
                    'status' => 'unpaid',

                ];
                $emireceived->update($emireceivedarr);
            }
        }
        // }

        // return response()->json([])->with('success','Sale Completed successfully.');
        // return response()->json(['invoice_id' => $sale->id, 'success' => 'Sale saved successfully.']);
        return redirect()->route('sale.index', $sale->id)->with('success', 'Sale Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Retrieve related sale details
            $saleDetails = SaleDetail::where('sale_id', $sale->id)->get();

            foreach ($saleDetails as $detail) {
                $product = Product::find($detail->product_id);

                if ($product) {
                    // Increase stock when a sale is deleted
                    $product->stock += $detail->qty;
                    $product->save();
                }
            }

            // Delete related sale details
            SaleDetail::where('sale_id', $sale->id)->delete();
            Emi::where('sale_id', $sale->id)->delete();
            // Delete the sale
            $sale->delete(); // Use Eloquent model's delete method directly

            // Commit the transaction
            DB::commit();

            return redirect()->route('sale.index')
                ->with('success', 'Sale and related details deleted successfully');
        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();

            // Log the exact error
            \Log::error('Error deleting sale: ' . $e->getMessage(), [
                'exception' => $e,
            ]);

            //  display the error details
            // if (config('app.debug')) {
            //     return redirect()->route('sale.index')
            //         ->with('error', 'Failed to delete sale. Error details: ' . $e->getMessage());
            // } else {
            //     // Generic error message for production
            //     return redirect()->route('sale.index')
            //         ->with('error', 'Failed to delete sale. Please try again.');
            // }
        }
    }





    public function cashReceivedLedger(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $business = Business::where('user_id', '=', $user_id)->first();
        $from_Date = date_create($request->from_date);
        $fromDate = date_format($from_Date, "d-m-Y");
        $to_Date = date_create($request->to_date);
        $toDate = date_format($to_Date, "d-m-Y");

        $cashReceivedLedger = PartyPayment::join('parties', 'party_payments.party_id', '=', 'parties.id')
            ->where('party_payments.user_id', $user_id)
            // ->where('party_payments.invoice_no', 'like', '%REC%')
            ->where('party_payments.mode_of_payment', 'cash')
            ->select(
                'parties.id as party_id',
                'party_payments.invoice_no as invoice',
                'parties.name as party_name',
                // 'party_payments.debit as amount',
                'party_payments.paid_date as date'
            )
            ->orderBy('party_payments.id', 'DESC');
        if ($request->filled('from_date') && $request->filled('to_date')) {

            $cashReceivedLedger->whereBetween('party_payments.paid_date', [$fromDate, $toDate]);
        }

        $cashReceivedLedger = $cashReceivedLedger->get();

        $totalCashReceived = $cashReceivedLedger->sum('amount');

        return view('cash.cash_bank_ledger', compact('business', 'cashReceivedLedger', 'totalCashReceived'));
    }

    public function bankLedger(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $business = Business::where('user_id', '=', $user_id)->first();
        $from_Date = date_create($request->from_date);
        $fromDate = date_format($from_Date, "d-m-Y");
        $to_Date = date_create($request->to_date);
        $toDate = date_format($to_Date, "d-m-Y");

        $onlinecashReceivedLedger = PartyPayment::join('parties', 'party_payments.party_id', '=', 'parties.id','left')
            ->where('party_payments.user_id', $user_id)
            ->where('party_payments.invoice_no', 'like', '%REC%')
            ->whereNotIn('party_payments.mode_of_payment', ['cash'])
            ->select(
                'parties.id as party_id',
                'party_payments.invoice_no as invoice',
                'parties.name as party_name',
                'party_payments.debit as amount',
                'party_payments.paid_date as date'
            )
            ->orderBy('party_payments.id', 'DESC');
        if ($request->filled('from_date') && $request->filled('to_date')) {

            $onlinecashReceivedLedger->whereBetween('party_payments.paid_date', [$fromDate, $toDate]);
        }

        // Execute the query
        $onlinecashReceivedLedger = $onlinecashReceivedLedger->get();
        $totalOnlineCashReceived = $onlinecashReceivedLedger->sum('amount');

        return view('cash.bank_ledger', compact('business',  'onlinecashReceivedLedger', 'totalOnlineCashReceived'));
    }
}
