@extends('layouts.v2.app')
<link rel="stylesheet" href="{{ asset('assets/datatable/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.checkboxes.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatable/buttons.bootstrap5.css') }}">
<!-- Row Group CSS -->
<link rel="stylesheet" href="{{ asset('assets/datatable/rowgroup.bootstrap5.css') }}">
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Basic Layout -->
            <div class="row">
                <div class="col-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Product Sub Category</h5>
                            <!-- <small class="text-muted float-end">Default label</small> -->
                        </div>
                        <div class="card-body">

                            <form method="POST" action="{{ route('productsubcategory.store') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <label for="product_category" class="form-label">Select Product Category</label>
                                    <select name="product_categories_id" id="product_category" class="form-select"
                                        required>
                                        <option value="">Select a category</option>
                                        @foreach ($ProductCategory as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                      @if ($errors->has('product_categories_id'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('product_categories_id') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                        placeholder="Enter the Product Category Name" />
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @enderror
                            </div>


                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    @php
                                        $businessstatus = ['active' => 'Active', 'inactive' => 'Inactive'];
                                    @endphp
                                    @foreach ($businessstatus as $key => $val)
                                        <option @if (old('status') == $val) selected @endif
                                            value="{{ $key }}">{{ $val }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('status'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('status') }}</strong>
                                    </span>
                                @enderror
                        </div>


                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" value="{{ old('description') }}" rows="4" cols="10"
                                placeholder="Enter the description"></textarea>
                            @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @enderror
                    </div>


                    <div style="text-align: right;">
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
</div>
<!-- / Content -->



<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
@endsection
