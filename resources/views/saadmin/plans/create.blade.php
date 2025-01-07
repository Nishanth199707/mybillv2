@extends('salayouts.v2.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Create Plan Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Create New Plan</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('plans.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Plan Name</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="offer_price" class="form-label">Offer Price</label>
                                    <input type="number" id="offer_price" name="offer_price" class="form-control" value="{{ old('offer_price') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="sale_price" class="form-label">Sale Price</label>
                                    <input type="number" id="sale_price" name="sale_price" class="form-control" value="{{ old('sale_price') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="no_of_days" class="form-label">No Of Days</label>
                                    <input type="text" id="no_of_days" name="no_of_days" class="form-control" value="{{ old('no_of_days') }}" required>
                                </div>

                                

                                <button type="submit" class="btn btn-primary">Create Plan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </div>
@endsection
