@extends('layouts.v2.app')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Setting</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('settings.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- General Settings -->
                            <div class="row mb-4">
                                <!-- <div class="col-md-4">
                                    <label for="ewaybill_no" class="form-label">E-way Bill</label>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="ewaybill_no" value="yes" id="ewaybill_yes" {{ old('ewaybill_no', $setting->ewaybill_no) === 'yes' ? 'checked' : '' }}>
                                        <label for="ewaybill_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="ewaybill_no" value="no" id="ewaybill_no" {{ old('ewaybill_no', $setting->ewaybill_no) === 'no' ? 'checked' : '' }}>
                                        <label for="ewaybill_no" class="form-check-label">No</label>
                                    </div>
                                </div> -->

                                <div class="col-md-4">
                                    <label for="purchase_order_date" class="form-label">Purchase Order Date</label>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="purchase_order_date" value="yes" id="po_date_yes" {{ old('purchase_order_date', $setting->purchase_order_date) === 'yes' ? 'checked' : '' }}>
                                        <label for="po_date_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="purchase_order_date" value="no" id="po_date_no" {{ old('purchase_order_date', $setting->purchase_order_date) === 'no' ? 'checked' : '' }}>
                                        <label for="po_date_no" class="form-check-label">No</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="purchase_order_number" class="form-label">Purchase Order Number</label>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="purchase_order_number" value="yes" id="po_number_yes" {{ old('purchase_order_number', $setting->purchase_order_number) === 'yes' ? 'checked' : '' }}>
                                        <label for="po_number_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="purchase_order_number" value="no" id="po_number_no" {{ old('purchase_order_number', $setting->purchase_order_number) === 'no' ? 'checked' : '' }}>
                                        <label for="po_number_no" class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="vehicle_no" class="form-label">Vehicle Number</label>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="vehicle_no" value="yes" id="vehicle_yes" {{ old('vehicle_no', $setting->vehicle_no) === 'yes' ? 'checked' : '' }}>
                                        <label for="vehicle_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="vehicle_no" value="no" id="vehicle_no" {{ old('vehicle_no', $setting->vehicle_no) === 'no' ? 'checked' : '' }}>
                                        <label for="vehicle_no" class="form-check-label">No</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Description (Yes/No)</label>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="description" value="yes" id="description_yes" {{ old('description', $setting->description) === 'yes' ? 'checked' : '' }}>
                                        <label for="description_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="description" value="no" id="description_no" {{ old('description', $setting->description) === 'no' ? 'checked' : '' }}>
                                        <label for="description_no" class="form-check-label">No</label>
                                    </div>

                                    <!-- Only show this textarea when 'Yes' is selected -->
                                    <div class="mt-3" id="description_text_input" style="display: {{ old('description', $setting->description) === 'yes' ? 'block' : 'none' }};">
                                        <textarea name="description_text" class="form-control" placeholder="Enter description text">{{ old('description_text', $settingDetail->description_text) }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">EMI</label>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="emi" value="yes" id="emi_yes" {{ old('emi', $setting->emi) === 'yes' ? 'checked' : '' }}>
                                        <label for="emi_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="emi" value="no" id="emi_no" {{ old('emi', $setting->emi) === 'no' ? 'checked' : '' }}>
                                        <label for="emi_no" class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="form-label">Signature</label>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="signature" value="yes" id="signature_yes" {{ old('signature', $setting->signature) === 'yes' ? 'checked' : '' }}>
                                        <label for="signature_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="signature" value="no" id="signature_no" {{ old('signature', $setting->signature) === 'no' ? 'checked' : '' }}>
                                        <label for="signature_no" class="form-check-label">No</label>
                                    </div>
                                    @if($setting->signature === 'yes')
                                    <div class="mt-3">
                                        <img src="{{  asset('settings_uploads/'.$settingDetail->signature_image) }}" alt="Signature Image" class="img-thumbnail" width="100">
                                    </div>
                                @endif
                                    <div class="mt-3" id="signature_image_input" style="display: {{ old('signature', $setting->signature) === 'yes' ? 'block' : 'none' }};">
                                        <input type="file" name="signature_image" class="form-control">
                                    </div>
                                </div>
                           
                            <div class="col-md-4">
                                    <label for="shipping_address" class="form-label">Shipping Address</label>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="shipping_address" value="yes" id="shipping_address_yes" {{ old('shipping_address', $setting->shipping_address) === 'yes' ? 'checked' : '' }}>
                                        <label for="shipping_address_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="shipping_address" value="no" id="shipping_address_no" {{ old('shipping_address', $setting->shipping_address) === 'no' ? 'checked' : '' }}>
                                        <label for="shipping_address_no" class="form-check-label">No</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="watermark" class="form-label">Watermark</label>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="watermark" value="yes" id="watermark_yes" {{ old('watermark', $setting->watermark) === 'yes' ? 'checked' : '' }}>
                                        <label for="watermark_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="watermark" value="no" id="watermark_no" {{ old('watermark', $setting->watermark) === 'no' ? 'checked' : '' }}>
                                        <label for="watermark_no" class="form-check-label">No</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="Invoice" class="form-label">Invoice Theme</label>
                                    <div class="form-check">
                                        
                                        <select name="invoice" class="form-select"  id="">
                                            <option value="show" {{ $setting->invoice == 'show' ? 'selected' : '' }}>Theme 1</option>
                                            <option value="show_theme" {{ $setting->invoice == 'show_theme' ? 'selected' : '' }}>Theme 2</option>
                                            <option value="show1" {{ $setting->invoice == 'show' ? 'selected' : '' }}>Theme 3</option>                        
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Submit Button -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Save Setting</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="content-backdrop fade"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Show/hide input fields based on description selection
        document.querySelectorAll('input[name="description"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                document.getElementById('description_text_input').style.display = (this.value === 'yes') ? 'block' : 'none';
            });
        });

        // Show/hide input fields based on signature selection
        document.querySelectorAll('input[name="signature"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                document.getElementById('signature_image_input').style.display = (this.value === 'yes') ? 'block' : 'none';
            });
        });
    });
</script>
@endsection
