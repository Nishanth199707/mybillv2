<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Business;
use App\Models\ProductCategory;
use App\Models\ProductsubCategory;
use App\Models\PurchaseCustomDetails;
use App\Models\SaleDetail;
use App\Models\HsnCode;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function getSubcategories(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductsubCategory::select('productsub_categories.*', 'product_categories.name as category_name')
                ->join('product_categories', 'productsub_categories.product_categories_id', '=', 'product_categories.id')
                ->where('productsub_categories.user_id', $request->session()->get('user_id'))
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<form action="' . url('superadmin/productsubcategory/' . $row->id . '') . '" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this Sub Category?\')" >
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <a class="btn btn-primary btn-sm" href="' . url('superadmin/productsubcategory/' . $row->id . '/edit') . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                                </form>';
                    return $btn;


                })

                ->rawColumns(['image', 'action'])
                ->make(true);
        }
        return view('productsubCategory.view');
    }
    public function getCategories(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductCategory::where('user_id', $request->session()->get('user_id'))->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function($row) {
                    return '<img src="' . asset('uploads/category/' . $row->image) . '" width="50" height="50" alt="Category Image">';
                })
                ->addColumn('action', function($row) {
                    $editUrl = url('superadmin/productcategory/' . $row->id . '/edit');
                    $showUrl = url('superadmin/productcategory/' . $row->id);
                    $deleteUrl = url('superadmin/productcategory/' . $row->id);

                    return '
                        <form action="' . $deleteUrl . '" method="POST" style="display:inline; ">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <a class="btn btn-info btn-sm" href="' . $showUrl . '">
                                <i class="fa-solid fa-list"></i> Show
                            </a>
                            <a class="btn btn-primary btn-sm" href="' . $editUrl . '">
                                <i class="fa-solid fa-pen-to-square"></i> Edit
                            </a>
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\');">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                        </form>';
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('productcategory.view');

    }
    public function index(Request $request)
    {
        //

        if ($request->ajax()) {
            $products = Product::select('products.*', 'productsub_categories.name as category_name')
                ->join('productsub_categories', 'products.sub_category_id', '=', 'productsub_categories.id')
                ->where('products.user_id', $request->session()->get('user_id'))
                ->where('products.status', 1);

            if ($request->has('subcategoryFilter') && $request->subcategoryFilter !== 'all') {
                $products->where('products.sub_category_id', $request->subcategoryFilter);
            }

            if ($request->has('categoryFilter') && $request->categoryFilter !== 'all') {
                $products->where('products.category', $request->categoryFilter);
            }

            // Get the filtered data
            $data = $products->get();


            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    if (!empty($row->image)) {
                        $imagePath = asset('uploads/product/' . $row->image);
                        return '<img src="' . $imagePath . '" width="50" height="50">';
                    } else {
                        return ''; // Or return a placeholder image if desired
                    }
                })
                ->addColumn('action', function ($row) {

                   $query = SaleDetail::query();
                   $query->where('sale_details.product_id', $row->id);
                   $query->where('sale_details.user_id', $row->user_id);
                   $data1 = $query->first();
                    if(empty($data1)){
                        return '<form action="' . url('superadmin/product/' . $row->id) . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this Product?\')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <a class="btn btn-info btn-sm" href="' . url('superadmin/product/' . $row->id) . '"><i class="fa-solid fa-list"></i> Show</a>
                        <a class="btn btn-primary btn-sm" href="' . url('superadmin/product/' . $row->id . '/edit') . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                    </form>';
                    }else{
                        return '                        <a class="btn btn-info btn-sm" href="' . url('superadmin/product/' . $row->id) . '"><i class="fa-solid fa-list"></i> Show</a>
                        <a class="btn btn-primary btn-sm" href="' . url('superadmin/product/' . $row->id . '/edit') . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                        <a class="btn btn-primary btn-sm" href="' . url('superadmin/product/disable/' . $row->id ) . '"><i class="fa-solid fa-pen-to-square"></i> Disable</a>
                        ';
                    }

                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }


        return view('product.view');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // dd($request->session()->get('gstavailable'));

        $user_id = $request->session()->get('user_id');
        $businessCategory = Business::select('business_category','gstavailable')->where('user_id', '=', $user_id)->first();

        $productcategory = ProductCategory::select('*')->where('user_id', $request->session()->get('user_id'))->get();

        $productsubcategory = ProductsubCategory::select('*')->where('user_id', $request->session()->get('user_id'))->get();

        // $hsncode = HsnCode::select('*')->get();


        return view('product.add', compact('productcategory', 'businessCategory', 'productsubcategory'));
    }

    public function getHsnCodes(Request $request)
    {
        $search = $request->input('q'); // 'q' is the default search term used by Select2

        $user_id = $request->session()->get('user_id');
        if (!$user_id) {
            return response()->json(['error' => 'User not authenticated'], 401); // Handle case when user_id is not found in session
        }

        $businessCategory = Business::select('business_category','gstavailable')
                                    ->where('user_id', '=', $user_id)
                                    ->first();

        if (!$businessCategory) {
            return response()->json(['error' => 'Business information not found'], 404);
        }

        $hsnCodes = HsnCode::query()
            ->when($search, function ($query, $search) {
                return $query->where('code', 'like', "%{$search}%")
                             ->orWhere('description', 'like', "%{$search}%");
            });

        // Check the business category and filter accordingly
        if ($businessCategory->business_category == 'Accounting & CA') {
            $hsnCodes->where('type', 2);
        } else {
            $hsnCodes->where('type', 1);
        }

        // Ordering and pagination
        $hsnCodes = $hsnCodes->orderBy('code', 'ASC')
                             ->select('code', 'description')
                             ->paginate(10); // Adjust the pagination size as needed

        return response()->json([
            'results' => $hsnCodes->items(), // Send paginated items to Select2
            'pagination' => ['more' => $hsnCodes->hasMorePages()],
        ]);
    }


    public function store(Request $request)
    {
        // dd($request);
        if (empty($request->session()->get('user_id'))) {
            return redirect()->route('login');
        }

        // Validate incoming request
        $request->validate([
            'item_type' => 'required',
            'category' => 'required',
            'item_name' => 'required',
            // 'sale_price' => 'required',
            // 'units'=> 'required',
            // 'stock'=> 'required',
        ]);

        $user_id = $request->session()->get('user_id');
        $business_id = Business::where('user_id', '=', $user_id)->select('id')->first();

        $itemCodeBarcodes = $request->input('item_code_barcode');

        if($request->has('imeiCheckbox')){
            $imei = 'yes';
        }else{
            $imei = 'no';

        }

        $productArr = [
            'user_id' => $user_id,
            'business_id' => $business_id->id,
            'item_type' => $request->item_type,
            'category' => $request->category,
            'sub_category_id' => $request->sub_category,
            'item_code_barcode' => $itemCodeBarcodes,
            'item_name' => $request->item_name,
            'price_type' => $request->price_type,
            'sale_price' => $request->sale_price,
            'gst_rate' => $request->gst_rate,
            'units' => $request->units,
            'stock' => $request->stock,
            'purchase_type' => $request->purchase_type,
            'purchase_price' => $request->purchase_price,
            'hsn_code' => $request->hsn_code,
            'description' => $request->description,
            'imei' => $imei,
        ];

        if ($request->hasFile('image')) {
            $categroy_image_fileName = 'pimage_' . random_int(100000, 999999) . '.' . $request->file('image')->extension();
            $request->image->move(public_path('uploads/product'), $categroy_image_fileName);
            $productArr['image'] = $categroy_image_fileName;
        }

        // Create a new product for each item_code_barcode
        $product = Product::create($productArr);

        if ($request->has('imei')) {
            foreach ($request->input('imei') as $modalKey => $modalFields) {
                foreach ($modalFields as $fieldKey => $imei) {
                    if (!empty($imei)) { // Ensure the IMEI field is not null or empty
                        $imeiData = [
                            'user_id' => $user_id,
                            'business_id' => $business_id->id,
                            'party_id' => '00',
                            'purchase_id' => '00',
                            'product_id' => $product->id,
                            'field_name' => 'IMEI',
                            'field_value' => $imei,
                            'stock' => 1,
                        ];
                        PurchaseCustomDetails::create($imeiData);
                    }
                }
            }
        }

        return redirect()->route('product.index')
            ->with('success', 'Products created successfully.');
    }

    public function disable(Request $request, $product_id)
    {
        // Find the product by ID
        $productupdate = Product::find($product_id);

        // Check if the product exists
        if (!$productupdate) {
            return redirect()->route('product.index')
                ->with('error', 'Product not found.');
        }

        // Update the status
        $productupdate->status = 0;
        $updateResult = $productupdate->save();

        // Check if the update was successful
        if ($updateResult) {
            return redirect()->route('product.index')
                ->with('success', 'Product disabled successfully.');
        } else {
            return redirect()->route('product.index')
                ->with('error', 'Failed to disable the product.');
        }
    }

    public function disablelist(Request $request){
        if ($request->ajax()) {
            $products = Product::select('products.*', 'productsub_categories.name as category_name')
                ->join('productsub_categories', 'products.sub_category_id', '=', 'productsub_categories.id')
                ->where('products.user_id', $request->session()->get('user_id'))
                ->where('products.status', 0);

            if ($request->has('subcategoryFilter') && $request->subcategoryFilter !== 'all') {
                $products->where('products.sub_category_id', $request->subcategoryFilter);
            }

            if ($request->has('categoryFilter') && $request->categoryFilter !== 'all') {
                $products->where('products.category', $request->categoryFilter);
            }

            // Get the filtered data
            $data = $products->get();


            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    if (!empty($row->image)) {
                        $imagePath = asset('uploads/product/' . $row->image);
                        return '<img src="' . $imagePath . '" width="50" height="50">';
                    } else {
                        return ''; // Or return a placeholder image if desired
                    }
                })
                ->addColumn('action', function ($row) {

                        return '                        <a class="btn btn-info btn-sm" href="' . url('superadmin/product/' . $row->id) . '"><i class="fa-solid fa-list"></i> Show</a>
                        <a class="btn btn-primary btn-sm" href="' . url('superadmin/product/enable/' . $row->id ) . '"><i class="fa-solid fa-pen-to-square"></i> Enable</a>
                        ';

                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }


        return view('product.dis_productview');
    }

    public function enable(Request $request, $product_id)
    {
        // Find the product by ID
        $productupdate = Product::find($product_id);

        // Check if the product exists
        if (!$productupdate) {
            return redirect()->route('product.index')
                ->with('error', 'Product not found.');
        }

        // Update the status
        $productupdate->status = 1;
        $updateResult = $productupdate->save();

        // Check if the update was successful
        if ($updateResult) {
            return redirect()->route('product.index')
                ->with('success', 'Product Enabled successfully.');
        } else {
            return redirect()->route('product.index')
                ->with('error', 'Failed to Enabled the product.');
        }
    }

    public function storeAjax(Request $request)
    {
        if (empty($request->session()->get('user_id'))) {
            return redirect()->route('login');
        }

        // Validate incoming request
        $request->validate([
            'item_type' => 'required',
            'category' => 'required',
            'item_name' => 'required',
            // 'sale_price' => 'required',
            // 'units'=> 'required',
            // 'stock'=> 'required',
        ]);

        $user_id = $request->session()->get('user_id');
        $business_id = Business::where('user_id', '=', $user_id)->select('id')->first();

        // Process each item_code_barcode separately
        $itemCodeBarcodes = $request->input('item_code_barcode');
        if($request->has('imeiCheckbox')){
            $imei = 'yes';
        }else{
            $imei = 'no';

        }

        // Prepare product data
        $productArr = [
            'user_id' => $user_id,
            'business_id' => $business_id->id,
            'item_type' => $request->item_type,
            'category' => $request->category,
            'sub_category_id' => $request->sub_category,
            'item_code_barcode' => $itemCodeBarcodes,
            'item_name' => $request->item_name,
            'price_type' => $request->price_type,
            'sale_price' => $request->sale_price,
            'gst_rate' => $request->gst_rate,
            'units' => $request->units,
            'stock' => $request->stock,
            'purchase_type' => $request->purchase_type,
            'purchase_price' => $request->purchase_price,
            'hsn_code' => $request->hsn_code,
            'description' => $request->description,
            'imei' => $imei,
        ];

        if ($request->hasFile('image')) {
            $categroy_image_fileName = 'pimage_' . random_int(100000, 999999) . '.' . $request->file('image')->extension();
            $request->image->move(public_path('uploads/product'), $categroy_image_fileName);
            $productArr['image'] = $categroy_image_fileName;
        }


       $inser_data = Product::updateOrCreate($productArr);

       if ($request->has('imei')) {
        foreach ($request->input('imei') as $modalKey => $modalFields) {
            foreach ($modalFields as $fieldKey => $imei) {
                if (!empty($imei)) { // Ensure the IMEI field is not null or empty
                    $imeiData = [
                        'user_id' => $user_id,
                        'business_id' => $business_id->id,
                        'party_id' => '00',
                        'purchase_id' => '00',
                        'product_id' => $inser_data->id,
                        'field_name' => 'IMEI',
                        'field_value' => $imei,
                        'stock' => 1,
                    ];
                    PurchaseCustomDetails::create($imeiData);
                }
            }
        }
    }

       $product = Product::where('id',$inser_data->id)->get();

        return response()->json(['success' => 'Product created successfully.', 'product' => $product], 200);
    }



    /**
     * Display the specified resource.
     */
    public function show(Product $product, Request $request)
    {
        //

        $businessCategory = Business::select('business_category','gstavailable')->where('user_id', $request->session()->get('user_id'))->first();
        $productCategory = productCategory::select('*')->where('user_id', $request->session()->get('user_id'))->get();
        $ProductsubCategory = ProductsubCategory::select('*')->where('user_id', $request->session()->get('user_id'))->get();

        $unsoldProducts = Product::join('purchase_custom_details', 'products.id', '=', 'purchase_custom_details.product_id')
        ->where('products.user_id', $request->session()->get('user_id'))
        ->where('purchase_custom_details.stock', '!=', 0)
        ->where('purchase_custom_details.product_id',$product->id)
        ->select(
            'products.id as product_id',
            'products.item_name',
            'purchase_custom_details.field_value',
            'purchase_custom_details.stock as purchase_stock'
        )
        ->get();

        // dd($unsoldProducts->toSql(), $unsoldProducts->getBindings());
// dd($product);

        return view('product.show', compact('product', 'unsoldProducts', 'productCategory', 'businessCategory', 'ProductsubCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product, Request $request)
    {
        //
        $businessCategory = Business::select('business_category','gstavailable')->where('user_id', $request->session()->get('user_id'))->first();
        $productCategory = productCategory::select('*')->where('user_id', $request->session()->get('user_id'))->get();
        $ProductsubCategory = ProductsubCategory::select('*')->where('user_id', $request->session()->get('user_id'))->get();
        $unsoldProducts = Product::join('purchase_custom_details', 'products.id', '=', 'purchase_custom_details.product_id')
        ->where('products.user_id', $request->session()->get('user_id'))
        ->where('purchase_custom_details.stock', '!=', 0)
        ->where('purchase_custom_details.product_id',$product->id)
        ->select(
            'products.id as product_id',
            'products.item_name',
            'purchase_custom_details.field_value',
            'purchase_custom_details.stock as purchase_stock'
        )
        ->get();

        return view('product.edit', compact('product', 'productCategory', 'businessCategory', 'ProductsubCategory','unsoldProducts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        //
        if (empty($request->session()->get('user_id'))) {
            return redirect()->route('login');
        }

        $request->validate([
            'item_type' => 'required',
            'category' => 'required',
            'item_name' => 'required',
            'sale_price' => 'required',
            // 'units'=> 'required',
            // 'stock'=> 'required',
        ]);



        $user_id = $request->session()->get('user_id');
        $business_id = Business::where('user_id', '=', $user_id)->select('id')->first();

        $productArr = [
            'user_id' => $user_id,
            'business_id' => $business_id->id,
            'item_type' => $request->item_type,
            'category' => $request->category,
            'sub_category_id' => $request->sub_category,
            'item_code_barcode' => $request->item_code_barcode,
            'item_name' => $request->item_name,
            'price_type' => $request->price_type,
            'sale_price' => $request->sale_price,
            'gst_rate' => $request->gst_rate,
            'units' => $request->units,
            'stock' => $request->stock,
            'purchase_type' => $request->purchase_type,
            'purchase_price' => $request->purchase_price,
            'hsn_code' => $request->hsn_code,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            $categroy_image_fileName = 'pimage_' . random_int(100000, 999999) . '.' . $request->file('image')->extension();
            $request->image->move(public_path('uploads/product'), $categroy_image_fileName);
            $productArr['image'] = $categroy_image_fileName;
        }

        // dd($productArr);

        // dd($productArr);
        if ($request->has('imei')) {
            PurchaseCustomDetails::where('product_id', $id)
            ->where('purchase_id', 0)
            ->where('party_id', 0)
            ->where('field_name', 'IMEI')
            ->where('stock', '!=', 0)
            ->delete();
            foreach ($request->input('imei') as $modalKey => $modalFields) {
                foreach ($modalFields as $fieldKey => $imei) {
                    if (!empty($imei)) { // Ensure the IMEI field is not null or empty
                        $imeiData = [
                            'user_id' => $user_id,
                            'business_id' => $business_id->id,
                            'party_id' => '00',
                            'purchase_id' => '00',
                            'product_id' => $id,
                            'field_name' => 'IMEI',
                            'field_value' => $imei,
                            'stock' => 1,
                        ];
                        PurchaseCustomDetails::create($imeiData);
                    }
                }
            }
        }

        $productupdate = Product::find($id);
        $productupdate->update($productArr);
        return redirect()->route('product.index')
            ->with('success', 'Product Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $product = Product::find($id);

        $product->delete();
        return redirect()->route('product.index')
            ->with('success', 'Product deleted successfully');
    }


    public function getBrandsByCategory(Request $request,$categoryId)
{
    $user_id = $request->session()->get('user_id');
    $subcategory = productCategory::where('user_id', '=', $user_id)->where('name', $categoryId)->first();
    $brands = ProductSubCategory::where('user_id', '=', $user_id)->where('product_categories_id', $subcategory->id)->get(['id', 'name']);

    return response()->json($brands);
}
}
