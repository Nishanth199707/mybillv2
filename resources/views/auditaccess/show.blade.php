@extends('layouts.v2.app')

@section('content')

<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        
        <!-- Product Category Details -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Product Category Details</h5>
                        <!-- <small class="text-muted float-end">Default label</small> -->
                    </div>
                    <div class="card-body">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="btn btn-primary btn-sm" href="{{ route('productcategory.index') }}">
                                <i class="fa fa-arrow-left"></i> Back to Categories
                            </a>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong> <br/>
                                    {{ $productCategory->name }}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                                <div class="form-group">
                                    <strong>Description:</strong> <br/>
                                    {{ $productCategory->description }}
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                                <div class="form-group">
                                    <strong>Status:</strong> <br/>
                                    {{ ucfirst($productCategory->status) }}
                                </div>
                            </div>

                            @if ($productCategory->image)
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                <div class="form-group">
                                    <strong>Image:</strong> <br/>
                                    <img src="{{ asset('storage/' . $productCategory->image) }}" alt="{{ $productCategory->name }}" class="img-fluid" width="200">
                                </div>
                            </div>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
