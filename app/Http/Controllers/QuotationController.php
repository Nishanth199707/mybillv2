<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\Business;
use App\Models\Party;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductsubCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Quotation::select('*')->where('user_id', $request->session()->get('user_id'))->orderBy('id', 'DESC')->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <a class="btn btn-info btn-sm" href="' . route('quotations.show', $row->id) . '"><i class="fa-solid fa-eye"></i> Show</a>
                        <form action="' . route('quotations.destroy', $row->id) . '" method="POST" style="display:inline;">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                        </form>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('quotation.view'); // Adjust the path to your actual view
    }

    public function create(Request $request)
    {
        $gstavailable = $request->session()->get('gstavailable');
        $user_id = $request->session()->get('user_id');
        $business = Business::select('id')->where('user_id', '=', $user_id)->first();

        $quotation_id = Quotation::where('business_id', $business->id)
            ->where('user_id', $user_id)
            ->orderBy('quotation_no', 'DESC')
            ->first();

        if ($quotation_id) {
            // Extract the numeric part from the last quotation number
            $lastQuotationNumber = (int)str_replace('QT', '', $quotation_id->quotation_no);
            $nextQuotationNumber = $lastQuotationNumber + 1;
        } else {
            // Start from 1 if no previous quotation exists
            $nextQuotationNumber = 1;
        }

        $party = Party::all();
        $productcategory = ProductCategory::all();
        $quotation_no = $this->invoice_num($nextQuotationNumber, $pad_len = 3, $prefix = 'QT');

        $productsubcategory = ProductsubCategory::select('*')->where('user_id', $user_id)->get();
        $businessCategory = Business::select('business_category')->where('user_id', '=', $user_id)->first();

        // Determine business category
        if ($businessCategory->business_category === 'Mobile & Accessories') {
            $businessCategory = 'mobile-accessories';
        } else {
            $businessCategory = 'null';
        }

        // Render the appropriate view based on GST availability
        if ($gstavailable == 'yes') {
            return view('quotation.add', compact('party', 'quotation_no', 'productsubcategory', 'productcategory', 'businessCategory'));
        } else {
            return view('quotation.addnogst', compact('party', 'quotation_no', 'productsubcategory', 'productcategory', 'businessCategory'));
        }
    }

    public function invoice($id)
    {
        $quotation_no = 0;
        $party = Party::all();
        $productcategory = ProductCategory::all();
        $quotation_no += $id;
        $quotation_no = $this->invoice_num($quotation_no, $pad_len = 3, $prefix = 'QT');

        $quotation = Quotation::find($id);
        // Assuming you have a model for quotation details
        $quotationDetail = $quotation->quotationDetails; // Adjust as per your relationship

        return response()->json([
            'party' => $party,
            'quotation' => $quotation,
            'quotation_no' => $quotation_no,
            'quotationDetail' => $quotationDetail,
            'productcategory' => $productcategory,
            'success' => 'Quotation retrieved successfully.'
        ]);
    }

    public function invoice_num($input, $pad_len = 3, $prefix = 'QT')
    {
        if ($pad_len <= strlen($input))
            trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate quotation number', E_USER_ERROR);

        if (is_string($prefix))
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
    }


    public function store(Request $request)
    {
          
        $user_id = $request->session()->get('user_id');
        $business_id = Business::where('user_id', '=', $user_id)->select('id')->first();
    
        if (!$business_id) {
            return redirect()->route('quotations.index')->with('error', 'Business not found.');
        }
    
        DB::beginTransaction();
    
        try {
            // Create the quotation
            $quotationData = [
                'user_id' => $user_id,
                'business_id' => $business_id->id,
                'party' => $request->party,
                'party_id' => $request->partyid,
                'quotation_date' => $request->quotation_date,
                'quotation_no' => $request->quotation_no,
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
            "cash_type" => 'quotation',
        
            ];
    
            // Create the quotation record
            $quotation = Quotation::create($quotationData);
    
            // Prepare the quotation details array
            $quotationDetails = [];
    
            for ($j = 0; $j < $request->totQues; $j++) {
                $i = $j + 1;
    
                if ($request->input("product_id{$i}") != '' && $request->input("qty{$i}") != '') {
                   
                    $details = [
                        'product_id' => $request->input("product_id{$i}"),
                        'item_description' => $request->input("item_description{$i}"),
                        'rpqty' => $request->input("rpqty{$i}"),
                        'qty' => $request->input("qty{$i}"),
                        'gst' => $request->input("gst{$i}"),
                        'discount' => $request->input("dis{$i}"),
                        'amount' => $request->input("amount{$i}"),
                        'gstvaldata' => $request->input("gstvaldata{$i}"),
                        'total_amount' => $request->input("total_amount{$i}"),
                    ];
    
                    // Add to the quotation details array
                    $quotationDetails[] = $details;
                }
            }
    
            // Encode the details as JSON
            $quotation->quotation_details = json_encode($quotationDetails);
            $quotation->save();
    
            DB::commit();
            return redirect()->route('quotations.index')->with('success', 'Quotation created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Quotation creation failed: ' . $e->getMessage());
            return redirect()->route('quotations.index')->with('error', 'Failed to create quotation.');
        }
    }
    

    public function show(Request $request, Quotation $quotation)
    {
     
        $business = Business::where('id', $quotation->business_id)->first();
    
   
        $quotationDetails = json_decode($quotation->quotation_details, true);
        // dd($quotationDetails);
            $party = Party::where('id', $quotation->party_id)->first();
        
      
        $gstAvailable = $request->session()->get('gstavailable') === 'yes';
    
      
        return view('quotation.show', compact('quotation', 'quotationDetails', 'business', 'party', 'gstAvailable'));
    }
    

    public function edit($id)
    {
        $quotation = Quotation::findOrFail($id);
        $businesses = Business::where('user_id', $quotation->user_id)->get();
        $parties = Party::where('user_id', $quotation->user_id)->get();
        $quotationDetails = json_decode($quotation->quotation_details, true);

        return view('quotation.edit', compact('quotation', 'businesses', 'parties', 'quotationDetails'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'party' => 'required',
            'quotation_no' => 'required',
            'totQues' => 'required|integer|min:1',
            'quotation_date' => 'required|date',
        ]);

        $quotation = Quotation::findOrFail($id);
        $quotationDetails = [];

        for ($i = 1; $i <= $request->totQues; $i++) {
            if ($request->input("product_id{$i}") && $request->input("qty{$i}")) {
                $quotationDetails[] = [
                    'product_id' => $request->input("product_id{$i}"),
                    'item_description' => $request->input("item_description{$i}"),
                    'qty' => $request->input("qty{$i}"),
                    'amount' => $request->input("amount{$i}"),
                    'total_amount' => $request->input("total_amount{$i}"),
                ];
            }
        }

        $quotation->update([
            'party' => $request->party,
            'party_id' => $request->party_id,
            'quotation_date' => $request->quotation_date,
            'quotation_no' => $request->quotation_no,
            'discount' => $request->discount ?? 0,
            'taxable28Amount' => $request->taxable28Amount ?? 0,
            'taxable18Amount' => $request->taxable18Amount ?? 0,
            'taxable12Amount' => $request->taxable12Amount ?? 0,
            'taxable5Amount' => $request->taxable5Amount ?? 0,
            'totalAmountDisplay' => $request->totalAmountDisplay ?? 0,
            'tax_amount' => $request->tax_amount ?? 0,
            'net_amount' => $request->net_amount,
            'totQues' => $request->totQues,
            'quotation_details' => json_encode($quotationDetails),
        ]);

        return redirect()->route('quotations.index')->with('success', 'Quotation updated successfully.');
    }

    public function destroy($id)
    {
        $quotation = Quotation::findOrFail($id);
        $quotation->delete();

        return redirect()->route('quotations.index')->with('success', 'Quotation deleted successfully.');
    }
}
