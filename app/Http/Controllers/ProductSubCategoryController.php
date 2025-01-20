<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\ProductsubCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Business;

class ProductSubCategoryController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = ProductsubCategory::select('productsub_categories.*', 'product_categories.name as category_name')
            ->join('product_categories', 'productsub_categories.product_categories_id', '=', 'product_categories.id')
            ->where('productsub_categories.user_id', $request->session()->get('user_id'))
            ->get();
                    return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<form action="' . url('superadmin/productsubcategory/' . $row->id . '') . '" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this Sub Category?\')">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <a class="btn btn-info btn-sm" href="' . url('superadmin/productsubcategory/' . $row->id . '') . '"><i class="fa-solid fa-list"></i> Show</a>
                                <a class="btn btn-primary btn-sm" href="' . url('superadmin/productsubcategory/' . $row->id . '/edit') . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                                </form>';
                                return $btn;
                    })

                    ->rawColumns(['image','action'])
                    ->make(true);
        }
        return view('productsubcategory.view');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $ProductCategory = ProductCategory::select('*')->where('user_id', $request->session()->get('user_id'))->get();

        return view('productsubcategory.add',compact('ProductCategory'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        if(empty($request->session()->get('user_id'))){
            return redirect()->route('login');
        }
        $request->validate([
            'name' => 'required',
            'status' => 'required',

        ]);



        $user_id = $request->session()->get('user_id');

        $business_id = Business::where('user_id','=',$user_id)->select('id')->first();
        // dd($business_id);

        $productsubCategoryArr = [
            'user_id' => $user_id,
            'business_id' => $business_id->id,
            'product_categories_id' => $request->product_categories_id,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status
        ];
    

        ProductsubCategory::create($productsubCategoryArr);

        return redirect()->route('productsubcategory.index')
                        ->with('success','Product Sub Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(productsubCategory $productsubCategory,$id,Request $request)
    {
        //
        $productsubCategory = ProductsubCategory::join('product_categories', 'productsub_categories.product_categories_id', '=', 'product_categories.id')
        ->where('productsub_categories.id', $id)
        ->where('productsub_categories.user_id', $request->session()->get('user_id'))
        ->select('productsub_categories.*', 'product_categories.name as category_name')
        ->first();
    
        return view('productsubcategory.show',compact('productsubCategory'));

       

    }

    public function subcategoryindex(Request $request)
    {
        //
        // return view('productsubcategory.show',compact('productsubCategory'));

        $subcategories = ProductsubCategory::select('id', 'name')->where('user_id', $request->session()->get('user_id'))->get();

        return response()->json($subcategories);

    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id)
    {
        //
        $productsubCategory = ProductsubCategory::find($id);
        $ProductCategory = ProductCategory::select('*')->where('user_id', $request->session()->get('user_id'))->get();

        // dd($productsubCategory);
        return view('productsubcategory.edit',compact('productsubCategory','ProductCategory'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if(empty($request->session()->get('user_id'))){
            return redirect()->route('login');
        }
        $request->validate([
            'name' => 'required',
            'status' => 'required',

        ]);

        $productsubCategory = ProductsubCategory::find($id);


        $user_id = $request->session()->get('user_id');

        $business_id = Business::where('user_id','=',$user_id)->select('id')->first();

        $productsubCategoryArr = [
            'user_id' => $user_id,
            'business_id' => $business_id->id,
            'product_categories_id' =>  $request->product_categories_id,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status
        ];

  
        $productsubCategory->update($productsubCategoryArr);

        return redirect()->route('productsubcategory.index')
                        ->with('success','Product Sub Category Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $productsubCategory = ProductsubCategory::find($id);

        $productsubCategory->delete();
        return redirect()->route('productsubcategory.index')
        ->with('success','Sub Category deleted successfully');
    }
}
