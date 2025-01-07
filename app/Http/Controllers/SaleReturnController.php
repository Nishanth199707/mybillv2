<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Party;
use App\Models\PartyPayment;
use App\Models\Product;
use App\Models\Setting;
use App\Models\ProductCategory;
use App\Models\ProductsubCategory;
use App\Models\SaleReturn;
use App\Models\SaleReturnDetail;
use App\Models\PurchaseCustomDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class SaleReturnController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SaleReturn::select('*')->where('user_id', $request->session()->get('user_id'))->orderBy('id', 'DESC')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<form action="' . route('salereturns.destroy', $row->id) . '" method="POST" style="display:inline;">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <a class="btn btn-info btn-sm" href="' . route('salereturns.show', $row->id) . '"><i class="fa-solid fa-list"></i> Show</a>
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                        </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('saleReturn.view'); // Adjust the path to your actual view
    }

    public function create(Request $request)
    {
        $user_id = $request->session()->get('user_id');

        $business = Business::select('id')->where('user_id', '=', $user_id)->first();
        $invoice_id = SaleReturn::where('business_id', $business->id)
            ->where('user_id', $user_id)
            ->orderBy('return_invoice_no', 'DESC')
            ->first();

        if ($invoice_id) {
            // Extract the numeric part from the last invoice number
            $lastInvoiceNumber = (int) str_replace('CN', '', $invoice_id->return_invoice_no);
            $nextInvoiceNumber = $lastInvoiceNumber + 1;
        } else {
            // Start from 1 if no previous invoice exists
            $nextInvoiceNumber = 1;
        }

        $party = Party::all();
        $productcategory = ProductCategory::select('*')->where('user_id', $user_id)->get();
        $invoice_no = $this->invoice_num($nextInvoiceNumber, $pad_len = 3, $prefix = 'CN');
        $productcategory = ProductCategory::select('*')->where('user_id', $user_id)->get();
        $productsubcategory = ProductsubCategory::select('*')->where('user_id', $user_id)->get();
        $businessCategory = Business::select('business_category')->where('user_id', $user_id)->first();

        return view($request->session()->get('gstavailable') == 'yes' ? 'saleReturn.add' : 'saleReturn.addnogst', compact('party', 'invoice_no', 'productcategory', 'productsubcategory', 'businessCategory'));
    }

    public function invoice_num($input, $pad_len = 3, $prefix = 'CN')
    {
        if ($pad_len <= strlen($input)) {
            trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate invoice number', E_USER_ERROR);
        }

        if (is_string($prefix)) {
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));
        }

        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if (empty($request->session()->get('user_id'))) {
            return redirect()->route('login');
        }
// dd($request->all());
        $request->validate([
            'party' => 'required',
            'cash_type' => 'required',
            'item_description1' => 'required',
            'qty1' => 'required',
            'return_invoice_no' => 'required',
            'totQues' => 'required',
        ]);

        $user_id = $request->session()->get('user_id');
        $business_id = Business::where('user_id', $user_id)->select('id')->first();

        if (!$business_id) {
            return redirect()->route('salereturns.index')->with('error', 'Business not found.');
        }

        DB::beginTransaction();

        try {
            $saleReturnData = [
                'user_id' => $user_id,
                'business_id' => $business_id->id,
                'party' => $request->party,
                'party_id' => $request->partyid,
                'return_invoice_date' => $request->return_invoice_date,
                'return_invoice_no' => $request->return_invoice_no,
                'totalAmountDisplay' => $request->totalAmountDisplay,
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
                'tax_amount' => $request->tax_amount,
                'net_amount' => $request->net_amount,
                'totQues' => $request->totQues,
                'cash_type' => $request->cash_type,

                'bill_type' => 'sale',
            ];

            $saleReturn = SaleReturn::create($saleReturnData);

            for ($i = 1; $i <= $request->totQues; $i++) {
                if ($request->input("product_id{$i}") && $request->input("qty{$i}")) {
                    Product::where('id', $request->input("product_id{$i}"))
                        ->increment('stock', $request->input("qty{$i}"));

                        $imeiValues = $request->input("imei");

                        if (isset($imeiValues[$i])) {
                            foreach ($imeiValues[$i] as $imei) {
                                if (!empty($imei)) {
                                    $imeiData = [
                                        'user_id' => $user_id,
                                        'business_id' => $business_id->id,
                                        'party_id' => $request->partyid,
                                        'purchase_id' => $saleReturn->id,
                                        'product_id' => $request->input("product_id{$i}"),
                                        'field_name' => 'IMEI',
                                        'field_value' => $imei,
                                        'stock' => 1,
                                    ];
                                    PurchaseCustomDetails::create($imeiData);
                                }
                            }
                        }
                    $saleReturnDetailData = [
                        'user_id' => $user_id,
                        'business_id' => $business_id->id,
                        'party_id' => $request->partyid,
                        'sale_return_id' => $saleReturn->id,
                        "product_id" => $request->input("product_id{$i}"),
                        "item_description" => $request->input("item_description{$i}"),
                        "rpqty" => $request->input("rpqty{$i}"),
                        "qty" => $request->input("qty{$i}"),
                        "gst" => $request->input("gst{$i}"),
                        "discount" => $request->input("dis{$i}"),
                        "amount" => $request->input("amount{$i}"),
                        "gstvaldata" => $request->input("gstvaldata{$i}"),
                        "total_amount" => $request->input("total_amount{$i}"),
                    ];

                    SaleReturnDetail::create($saleReturnDetailData);
                }
            }

            // Payment handling remains unchanged
            if ($request->cash_type) {



                $opening_balance = PartyPayment::where('party_id', $request->partyid)
                    ->orderBy('id', 'DESC')
                    ->latest('paid_date')
                    ->value('closing_balance') ?? 0;

                $partyPaymentArr = [
                    'user_id' => $user_id,
                    'business_id' => $business_id->id,
                    'party_id' => $request->partyid,
                    'transaction_type' => 'sale',
                    'invoice_no' => $request->return_invoice_no,
                    'paid_date' => $request->return_invoice_date,
                    'credit' => $request->net_amount,
                    'payment_type' => 'credit',
                    'mode_of_payment' => $request->cash_type,
                    'opening_balance' => $opening_balance + $request->net_amount,
                    'closing_balance' => $opening_balance + $request->net_amount,
                ];

                PartyPayment::create($partyPaymentArr);

            }

            DB::commit();
            return redirect()->route('salereturns.index')->with('success', 'Sale return added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Sale Return creation failed: ' . $e->getMessage());
            return redirect()->route('salereturns.index')->with('error', 'Failed to add sale return.');
        }
    }

    public function show(Request $request, SaleReturn $salereturn)
    {
        $user_id = $request->session()->get('user_id');

        $saledetail = SaleReturnDetail::join('products', 'products.id', '=', 'sale_return_details.product_id')
            ->where('sale_return_details.sale_return_id', '=', $salereturn->id)
            ->groupBy(
                'products.hsn_code',
                'sale_return_details.amount',
                'sale_return_details.gst',
                'sale_return_details.rpqty',
                'sale_return_details.product_id',
                'sale_return_details.item_description'
            )
            ->select(
                'sale_return_details.product_id',
                'sale_return_details.item_description',
                DB::raw('SUM(sale_return_details.total_amount) as total_amount'),
                DB::raw('SUM(sale_return_details.qty) as qty'),
                'sale_return_details.rpqty',
                'sale_return_details.amount',
                'sale_return_details.gst',
                'products.hsn_code'
            )
            ->get();

        $party = Party::where('id', '=', $salereturn->party_id)->first();
        $business = Business::where('user_id', '=', $user_id)->first();

        $setting = Setting::where('settings.user_id', $request->session()->get('user_id'))
        ->join('setting_details', 'settings.id', '=', 'setting_details.settings_id')
        ->select('settings.*', 'setting_details.signature_image', 'setting_details.description_text')
        ->first();
        return view('saleReturn.' . $setting->invoice, compact('business', 'party', 'salereturn', 'saledetail'));
    }

    public function edit($id)
    {
        $saleReturn = SaleReturn::with('details')->findOrFail($id);
        $products = Product::all();
        return view('saleReturn.edit', compact('saleReturn', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'party' => 'required',
            'cash_type' => 'required',
            'item_description1' => 'required',
            'qty1' => 'required',
            'return_invoice_no' => 'required',
        ]);

        $saleReturn = SaleReturn::findOrFail($id);

        DB::beginTransaction();

        try {
            $saleReturn->update([
                'party' => $request->party,
                'party_id' => $request->partyid,
                'return_invoice_date' => $request->return_invoice_date,
                'return_invoice_no' => $request->return_invoice_no,
                'totalAmountDisplay' => $request->totalAmountDisplay,
                'cash_type' => $request->cash_type,
            ]);

            // Update SaleReturnDetail logic here if necessary

            DB::commit();
            return redirect()->route('salereturns.index')->with('success', 'Sale return updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('salereturns.index')->with('error', 'Failed to update sale return.');
        }
    }

    public function destroy($id)
    {
        $saleReturn = SaleReturn::findOrFail($id);

        DB::beginTransaction();

        try {
            $saleReturn->details()->delete(); // Assuming 'details' is the relationship method

            $saleReturn->delete();

            DB::commit();
            return redirect()->route('salereturns.index')->with('success', 'Sale return deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('salereturns.index')->with('error', 'Failed to delete sale return: ' . $e->getMessage());
        }
    }
}
