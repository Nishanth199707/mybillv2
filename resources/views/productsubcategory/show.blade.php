@extends('layouts.v2.app')

@section('content')

<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        
        <!-- Product Sub-Category Details -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Product Sub-Category Details</h5>
                    </div>
                    <div class="card-body">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="btn btn-primary btn-sm" href="{{ route('productsubcategory.index') }}">
                                <i class="fa fa-arrow-left"></i> Back to Sub-Categories
                            </a>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong> <br/>
                                    {{ $productsubCategory->name }}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                                <div class="form-group">
                                    <strong>Category Name:</strong> <br/>
                                    {{ $productsubCategory->category_name }}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                                <div class="form-group">
                                    <strong>Description:</strong> <br/>
                                    {{ $productsubCategory->description }}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                                <div class="form-group">
                                    <strong>Status:</strong> <br/>
                                    {{ ucfirst($productsubCategory->status) }}
                                </div>
                            </div>

                            

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
