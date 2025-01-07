@extends('layouts.v2.app')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">View Setting</h5>
                    </div>
                    <div class="card-body">
                        <!-- General Settings -->
                        <div class="row mb-4">
                            {{-- <div class="col-md-4">
                                <label class="form-label">E-way Bill</label>
                                <p>{{ $setting->ewaybill_no === 'yes' ? 'Yes' : 'No' }}</p>
                            </div> --}}

                            <div class="col-md-4">
                                <label class="form-label">Purchase Order Date</label>
                                <p>{{ $setting->purchase_order_date === 'yes' ? 'Yes' : 'No' }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Purchase Order Number</label>
                                <p>{{ $setting->purchase_order_number === 'yes' ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Vehicle Number</label>
                                <p>{{ $setting->vehicle_no === 'yes' ? 'Yes' : 'No' }}</p>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Description (Yes/No)</label>
                                <p>{{ $setting->description === 'yes' ? 'Yes' : 'No' }}</p>
                                
                                @if($setting->description === 'yes')
                                    <div class="mt-3">
                                        <p>{{ $setting->description_text }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">EMI</label>
                                <p>{{ $setting->emi === 'yes' ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Signature</label>
                                <p>{{ $setting->signature === 'yes' ? 'Yes' : 'No' }}</p>

                                @if($setting->signature === 'yes')
                                    <div class="mt-3">
                                        <img src="{{  asset('settings_uploads/'.$setting->signature_image) }}" alt="Signature Image" class="img-thumbnail" width="100">
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Shipping Address</label>
                                <p>{{ $setting->shipping_address === 'yes' ? 'Yes' : 'No' }}</p>
                            </div>
                            <div class="col-md-4">
                                    <label for="watermark" class="form-label">Watermark</label>
                                    <p>{{ $setting->watermark === 'yes' ? 'Yes' : 'No' }}</p>
                                </div>
                            <div class="col-md-4">
                                <label class="form-label">Invoice</label>
                                <select name="invoice" class=""  id="" disabled>
                                    <option value="show" {{ $setting->invoice == 'show' ? 'selected' : '' }}>Theme 1</option>
                                    <option value="show_theme" {{ $setting->invoice == 'show_theme' ? 'selected' : '' }}>Theme 2</option>
                                    <option value="show1" {{ $setting->invoice == 'show1' ? 'selected' : '' }}>Theme 3</option> 
                                </select>
                            </div>
                        </div>

                        <!-- Back Button -->
                        <div class="text-end mt-3">
                            <a href="{{ route('settings.edit', $setting->id) }}" class="btn btn-secondary">Back to Edit Settings</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="content-backdrop fade"></div>
</div>
@endsection
