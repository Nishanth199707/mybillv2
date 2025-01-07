<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SaleReport;
use App\Exports\SaleNonGst;
use App\Exports\PurchaseReport;
use App\Exports\PurchaseNonGst;
use App\Exports\StockReport;
use App\Exports\PartyReport;
use App\Exports\RepairReport;
use App\Models\Sale;
use App\Models\Business;
use App\Models\Purchase;
use App\Models\Product;
use App\Model\PurchaseCustomDetails;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;


class GstReportController extends Controller
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function saleexport(Request $request)
    {

        $business = Business::select('*')->where('user_id', $request->session()->get('user_id'))->first();
        if ($business->gstavailable == 'yes') {
            return Excel::download(new SaleReport($request->from_date, $request->to_date, $request->subcategory, $request->category), 'salereport.xlsx');
        } else {
            return Excel::download(new SaleNonGst($request->from_date, $request->to_date, $request->subcategory, $request->category), 'salereport.xlsx');
        }
        return Excel::download(new SaleReport($request->from_date, $request->to_date, $request->subcategory, $request->category), 'salereport.xlsx');
    }

    public function purchaseexport(Request $request)
    {
        $business = Business::select('*')->where('user_id', $request->session()->get('user_id'))->first();
        if ($business->gstavailable == 'yes') {
            return Excel::download(new PurchaseReport($request->from_date, $request->to_date, $request->subcategory, $request->category), 'purchasereport.xlsx');
        } else {
            return Excel::download(new PurchaseNonGst($request->from_date, $request->to_date, $request->subcategory, $request->category), 'purchasereport.xlsx');
        }
        return Excel::download(new PurchaseReport($request->from_date, $request->to_date, $request->subcategory, $request->category), 'purchasereport.xlsx');
    }

    public function stockexport(Request $request)
    {
        // dd($request->subcategory,$request->category);
        return Excel::download(new StockReport($request->subcategory, $request->category), 'stockreport.xlsx');
    }

    public function partyexport(Request $request)
    {
        return Excel::download(new PartyReport($request->filter), 'PartyReport.xlsx');
    }

    public function serviceexport(Request $request)
    {
        return Excel::download(new RepairReport($request->filter), 'ServiceReport.xlsx');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        if ($request->ajax()) {
            $data = Sale::where('user_id', $request->session()->get('user_id'))->get();

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $data->whereDate('created_at', '>=', $request->from_date)
                    ->whereDate('created_at', '<=', $request->to_date);
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('gstreport.view');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(GstReport $gstReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GstReport $gstReport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GstReport $gstReport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GstReport $gstReport)
    {
        //
    }


    public function salereport(Request $request)
    {
        //    dd($request);
        if ($request->ajax()) {
            // dd($request->all());
            // Start with the user's sales data
            $data = Sale::join('businesses', 'businesses.id', '=', 'sales.business_id')
                ->join('sale_details', 'sale_details.sale_id', '=', 'sales.id')
                ->join('products', 'products.id', '=', 'sale_details.product_id')
                ->join('productsub_categories', 'productsub_categories.id', '=', 'products.sub_category_id')
                ->where('sales.user_id', $request->session()->get('user_id'));

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $fromDate = $request->input('from_date') . ' 00:00:00';
                $toDate = $request->input('to_date') . ' 23:59:59';

                $data->whereBetween('sales.created_at', [$fromDate, $toDate]);
            }

            if ($request->filled('from_date') && $request->filled('to_date') && $request->filled('subcategory') && $request->filled('category') && $request->subcategory !== 'all' && $request->category !== 'all') {
                $fromDate = $request->input('from_date') . ' 00:00:00';
                $toDate = $request->input('to_date') . ' 23:59:59';

                $data->whereBetween('sales.created_at', [$fromDate, $toDate])
                    ->where('products.sub_category_id', $request->input('subcategory'))
                    ->where('products.category', $request->input('category'));
            }


            if ($request->filled('subcategory') && $request->subcategory !== 'all') {
                $subcategoryId = $request->input('subcategory');
                $data->where('products.sub_category_id', $subcategoryId);
            }

            // Filter by Product (if selected)
            if ($request->filled('category') && $request->category !== 'all') {
                $productId = $request->input('category');
                $data->where('products.category', $productId);
            }
            $data->get();

            $totalAmount = $data->sum('net_amount');

            // dd($totalAmount);
            // Get the results as a DataTable
            return Datatables::of($data)
                ->addIndexColumn()
                ->with('totalAmount', $totalAmount)
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Return the view if not an AJAX request
        return view('gstreport.salereport');
    }



    public function purchasereport(Request $request)
    {
        // Check if the request is an AJAX request
        if ($request->ajax()) {
            // Start by querying the purchase data
            $data = Purchase::join('businesses', 'businesses.id', '=', 'purchases.business_id')
                ->join('purchase_details', 'purchase_details.purchase_id', '=', 'purchases.id')
                ->join('products', 'products.id', '=', 'purchase_details.product_id')
                ->join('productsub_categories', 'productsub_categories.id', '=', 'products.sub_category_id')
                ->where('purchases.user_id', $request->session()->get('user_id'));

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $fromDate = $request->input('from_date') . ' 00:00:00';
                $toDate = $request->input('to_date') . ' 23:59:59';

                $data->whereBetween('purchases.created_at', [$fromDate, $toDate]);
            }
            // Filter by date range if both from_date and to_date are provided
            if ($request->filled('from_date') && $request->filled('to_date') && $request->subcategory !== 'all' && $request->category !== 'all') {
                $fromDate = $request->input('from_date') . ' 00:00:00';
                $toDate = $request->input('to_date') . ' 23:59:59';

                $data->whereBetween('purchases.created_at', [$fromDate, $toDate]);
            }

            // Filter by Subcategory if provided
            if ($request->filled('subcategory') && $request->subcategory !== 'all') {
                $subcategoryId = $request->input('subcategory');
                $data->where('products.sub_category_id', $subcategoryId);
            }

            // Filter by Category if provided
            if ($request->filled('category') && $request->category !== 'all') {
                $categoryId = $request->input('category');
                $data->where('products.category', $categoryId);
            }

            $totalAmount = $data->sum('net_amount');

            // Return the results as a DataTable
            return Datatables::of($data)
                ->addIndexColumn()
                ->with('totalAmount', $totalAmount)
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // If the request is not AJAX, return the regular view
        return view('gstreport.purchasereport');
    }


    public function stockreport(Request $request)
    {
        // dd($request->ajax());
        // try {
            if ($request->ajax()) {
                // Start building the query
                $data = Product::join('productsub_categories', 'productsub_categories.id', '=', 'products.sub_category_id')
                ->leftJoin('purchase_custom_details', 'purchase_custom_details.product_id', '=', 'products.id')
                ->select(
                    'products.id',
                    'products.item_name', // Select product name to group by
                    'products.category',
                    'productsub_categories.name as subcategory_name',
                    'products.stock as total_stock', // Aggregate stock
                    DB::raw('GROUP_CONCAT(purchase_custom_details.field_value SEPARATOR ", ") as imei') // Aggregate IMEIs
                )
                ->groupBy(
                    'products.id',
                    'products.item_name', // Group by product name
                    'products.category',
                    'productsub_categories.name'
                )
                ->where('products.user_id', $request->session()->get('user_id'));
            
    
                // Apply filters if selected
                if ($request->filled('subcategory') && $request->filled('category') && $request->subcategory !== 'all' && $request->category !== 'all') {
                    $data->where('products.sub_category_id', $request->input('subcategory'))
                        ->where('products.category', $request->input('category'));
                }
    
                if ($request->filled('subcategory') && $request->subcategory !== 'all') {
                    $data->where('products.sub_category_id', $request->input('subcategory'));
                }
    
                if ($request->filled('category') && $request->category !== 'all') {
                    $data->where('products.category', $request->input('category'));
                }
    
                // Get the results
                $products = $data->get();
    
                // dd($products);
                // After fetching the results, group IMEIs by product
                $products->map(function ($product) {
                    // Collect all IMEI values associated with each product
                    $product->imei_list = DB::table('purchase_custom_details')->where('product_id', $product->id)
                        ->pluck('field_value')->toArray();
                });
    
                // Return the data to DataTables
                return DataTables::of($products)
                    ->addIndexColumn() // Add an index column for row numbers
                    ->editColumn('total_stock', function ($row) {
                        return $row->total_stock ?? 0; // Return 0 if stock is null
                    })
                    ->addColumn('imei_list', function ($row) {
                        // Ensure $row->imei_list is an array before using implode()
                        $imeiList = is_array($row->imei_list) ? $row->imei_list : [];
                        return implode('<br>', $imeiList); // Join IMEI values with <br> to show each on a new line
                    })
                    ->rawColumns(['imei_list']) // Allow HTML (line breaks) in the IMEI list
                    ->make(true);
            }
        // } catch (\Exception $e) {
        //     // Log the error for debugging purposes
        //     \Log::error('Error fetching product stock data', [
        //         'message' => $e->getMessage(),
        //         'code' => $e->getCode(),
        //         'trace' => $e->getTraceAsString()
        //     ]);
    
        //     // Return an error response
        //     return response()->json([
        //         'error' => 'An error occurred while processing the data.',
        //         'message' => $e->getMessage(),
        //         'code' => $e->getCode()
        //     ], 500);
        // }
    
        // If not an AJAX request, return the view
        return view('gstreport.stockreport');
    }
    
    

    public function generatePdf(Request $request)
    {
        $category = $request->category;
        $subcategory = $request->subcategory;

        $stocks = Product::join('productsub_categories', 'productsub_categories.id', '=', 'products.sub_category_id')
            ->leftJoin('purchase_custom_details', 'purchase_custom_details.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.item_name',
                'products.category',
                'productsub_categories.name as subcategory_name',
                DB::raw('SUM(products.stock) as total_stock'),
                DB::raw('GROUP_CONCAT(purchase_custom_details.field_value) as imei') // Concatenate IMEIs into a list
            )
            ->groupBy(
                'products.id',
                'products.item_name',
                'products.category',
                'productsub_categories.name'
            )
            ->when($category && $category !== 'all', function ($query) use ($category) {
                return $query->where('products.category', $category);
            })
            ->when($subcategory && $subcategory !== 'all', function ($query) use ($subcategory) {
                return $query->where('productsub_categories.name', $subcategory);
            })
            ->get();

        $pdf = PDF::loadView('reports.stock_report_pdf', compact('stocks'));

        return $pdf->download('stock_report.pdf');
    }
}
