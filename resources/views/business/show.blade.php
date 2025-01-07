@extends('layouts.v2.app')

@section('content')
<br>
<div class="container">
        <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Business Details</h5>
                </div>
                @if ($business != null)
                    
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Logo:</strong>
                        </div>
                        <div class="col-md-8">
                            <img src="{{ asset('uploads/'.$business->logo) }}" width="100" height="100" alt="">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Company Name:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $business->company_name }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>GST Available:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ ucfirst($business->gstavailable) }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>GSTIN:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $business->gstin }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Phone:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $business->phone_no }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Email:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $business->email }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Address:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $business->address }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Business Type:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $business->business_type }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Business Category:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $business->business_category }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Pincode:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $business->pincode }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>State:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $indianStates[$business->state] ?? $business->state }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Country:</strong>
                        </div>
                        <div class="col-md-8">
                            India
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>City:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $business->city }}
                        </div>
                    </div>
                    <!-- <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>Description:</strong>
                        </div>
                        <div class="col-md-8">
                            {{ $business->description }}
                        </div>
                    </div> -->
                    <div class="row mb-3">
                        <!-- <div class="col-md-4">
                            <strong>Signature:</strong>
                        </div> -->
                        <!-- <div class="col-md-8">
                            <img src="{{ asset('uploads/'.$business->signature) }}" width="200" height="100" alt="">
                        </div> -->
                    </div>
                    <div class="text-end">
                        <a href="{{ route('business.edit', $business->id) }}" class="btn btn-primary">Edit Business</a>
                    </div>
                </div>

                @else
                <div class="card-body text-center py-5">
                    <i class="bx bx-info-circle text-primary" style="font-size: 48px;"></i>
                    <h5 class="my-4">No Business Details Available</h5>
                    <p class="text-muted mb-4">It looks like you haven't completed your business profile yet. Please complete your profile to continue.</p>
                    <a href="{{ route('business.create') }}" class="btn btn-primary btn-lg">Complete Your Profile</a>
                </div>
                
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
