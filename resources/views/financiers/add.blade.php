@extends('layouts.v2.app')
@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span> Add Financier</h4> -->

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-6">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Add New Financier</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('financiers.store') }}">
                            @csrf
                                                        
                            <div class="mb-3">
                                <label class="form-label">Financier Name</label>
                                <input type="text" class="form-control" name="financier_name" value="{{ old('financier_name') }}" placeholder="Financier Name" />
                                @if ($errors->has('financier_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('financier_name') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Agent Code</label>
                                <input type="text" class="form-control" name="agent_code" value="{{ old('agent_code') }}" placeholder="Agent Code" />
                                @if ($errors->has('agent_code'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('agent_code') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Executive Name</label>
                                <input type="text" class="form-control" name="executive_name" value="{{ old('executive_name') }}" placeholder="Executive Name" />
                                @if ($errors->has('financier_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('executive_name') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Executive Phone</label>
                                <input type="text" class="form-control" name="executive_phone" value="{{ old('executive_phone') }}" placeholder="Executive Phone" />
                                @if ($errors->has('executive_phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('executive_phone') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Company Email</label>
                                <input type="text" class="form-control" name="company_email" value="{{ old('company_email') }}" placeholder="Company Email" />
                                @if ($errors->has('company_email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company_email') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
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
