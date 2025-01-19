<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Business;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = ProductCategory::select('*')->where('user_id', $request->session()->get('user_id'))->get();
            $data->user_type = $request->session()->get('user_type');
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    $image = '<img src="' . asset('uploads/category/' . $row->image) . '" width="50" height="50">';
                    return $image;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<form';
                    if( $row->user_type == 'admin'){
                    $btn .=  'action="' . url('superadmin/productcategory/' . $row->id . '') . '"';
                    }else{
                    $btn .=  'action="' . url('staff/sproductcategory/' . $row->id . '') . '"';
                    }

                   $btn .= 'method="POST" onsubmit="return confirm(\'Are you sure you want to delete this Category?\')">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">';
                    if( $row->user_type == 'admin'){
                    $btn .=  '<a class="btn btn-info btn-sm" href="' . url('superadmin/productcategory/' . $row->id . '') . '"><i class="fa-solid fa-list"></i> Show</a>';
                    }else{
                    $btn .=  '<a class="btn btn-info btn-sm" href="' . url('staff/productcategory/' . $row->id . '') . '"><i class="fa-solid fa-list"></i> Show</a>';
                    }
                    if( $row->user_type == 'admin'){
                    $btn .=  ' <a class="btn btn-primary btn-sm" href="' . url('superadmin/productcategory/' . $row->id . '/edit') . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>';
                    }else{
                    $btn .=  '<a class="btn btn-info btn-sm" href="' . url('staff/productcategory/' . $row->id . '/edit') . '"><i class="fa-solid fa-list"></i> Edit</a>';
                    }
                    $btn .=  '     <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                                </form>';
                    return $btn;
                })

                ->rawColumns(['image', 'action'])
                ->make(true);
        }
        return view('productcategory.view');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('productcategory.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        if (empty($request->session()->get('user_id'))) {
            return redirect()->route('login');
        }
        $request->validate([
            'name' => 'required',
            'status' => 'required',

        ]);



        $user_id = $request->session()->get('user_id');

        $business_id = Business::where('user_id', '=', $user_id)->select('id')->first();
        // dd($business_id);

        $productcategoryArr = [
            'user_id' => $user_id,
            'business_id' => $business_id->id,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status
        ];
        if ($request->hasFile('image')) {
            $categroy_image_fileName = 'cimage_' . time() . '.' . $request->file('image')->extension();
            $request->image->move(public_path('uploads/category'), $categroy_image_fileName);
            $productcategoryArr['image'] = $categroy_image_fileName;
        }
        // dd($productcategoryArr);

        // dd($productcategoryArr);

        ProductCategory::create($productcategoryArr);

        return redirect()->route('productcategory.index')
            ->with('success', 'Product Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductCategory $productCategory, $id, Request $request)
    {
        $productCategory = ProductCategory::where('id', $id)->where('user_id', $request->session()->get('user_id'))->first();
        return view('productcategory.show', compact('productCategory'));
    }

    public function categoryindex(Request $request)
    {
        //
        // return view('productcategory.show',compact('productCategory'));

        $categories = ProductCategory::select('id', 'name')->where('user_id', $request->session()->get('user_id'))->get();

        return response()->json($categories);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $productCategory = productCategory::find($id);
        // dd($productCategory);
        return view('productcategory.edit', compact('productCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (empty($request->session()->get('user_id'))) {
            return redirect()->route('login');
        }
        $request->validate([
            'name' => 'required',
            'status' => 'required',

        ]);

        $productCategory = productCategory::find($id);


        $user_id = $request->session()->get('user_id');

        $business_id = Business::where('user_id', '=', $user_id)->select('id')->first();

        $productcategoryArr = [
            'user_id' => $user_id,
            'business_id' => $business_id->id,
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status
        ];

        if ($request->hasFile('image')) {
            $categroy_image_fileName = 'cimage_' . time() . '.' . $request->file('image')->extension();
            $request->image->move(public_path('uploads/category'), $categroy_image_fileName);
            $productcategoryArr['image'] = $categroy_image_fileName;
        }

        $productCategory->update($productcategoryArr);

        return redirect()->route('productcategory.index')
            ->with('success', 'Product Category Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $productCategory = productCategory::find($id);

        $productCategory->delete();
        return redirect()->route('productcategory.index')
            ->with('success', 'Product Category deleted successfully');
    }
}
