@extends('layouts.v2.app')
@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Edit Party</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('party.update', $party->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Party Type and Sale/Purchase Selection in the Same Row -->
                            <div class="mb-3 row">
                                <div class="col-md-3">
                                    <label class="form-label">Type</label>
                                    <div>
                                        <input type="radio" id="sale" name="transaction_type" value="sale"
                                            {{ $party->transaction_type == 'sale' ? 'checked' : '' }} />
                                        <label for="sale">Sale</label>
                                        <input type="radio" id="purchase" name="transaction_type" value="purchase"
                                            {{ $party->transaction_type == 'purchase' ? 'checked' : '' }} />
                                        <label for="purchase">Purchase</label>
                                    </div>
                                    @if ($errors->has('transaction_type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('transaction_type') }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                @if($business->gstavailable == 'yes')
                                <div class="col-md-3">
                                    <label class="form-label">Party Type</label>
                                    <select name="party_type" id="party_type" class="form-select">
                                        @php
                                        $party_type = [
                                        'unregistered' => 'Unregistered',
                                        'registered' => 'Registered',
                                        ];
                                        @endphp
                                        @foreach ($party_type as $key => $val)
                                        <option value="{{ $key }}"
                                            {{ old('party_type', $party->party_type) == $key ? 'selected' : '' }}>
                                            {{ $val }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('party_type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('party_type') }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                @else
                                <div class="col-md-3">
                                    <label class="form-label">Party Type</label>
                                    <select name="party_type" id="party_type" class="form-select">
                                        @php
                                        $party_type = [
                                        'unregistered' => 'Unregistered',
                                        ];
                                        @endphp
                                        @foreach ($party_type as $key => $val)
                                        <option value="{{ $key }}"
                                            {{ old('party_type', $party->party_type) == $key ? 'selected' : '' }}>
                                            {{ $val }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('party_type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('party_type') }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                @endif

                                <div class="col-md-3">
                                    <label class="form-label">State</label>
                                    <select name="state" id="state" class="form-select">
                                        @php
                                        $states = [
                                        '' => 'Select State',
                                        'Andhra Pradesh' => 'Andhra Pradesh',
                                        'Arunachal Pradesh' => 'Arunachal Pradesh',
                                        'Assam' => 'Assam',
                                        'Bihar' => 'Bihar',
                                        'Chhattisgarh' => 'Chhattisgarh',
                                        'Goa' => 'Goa',
                                        'Gujarat' => 'Gujarat',
                                        'Haryana' => 'Haryana',
                                        'Himachal Pradesh' => 'Himachal Pradesh',
                                        'Jharkhand' => 'Jharkhand',
                                        'Karnataka' => 'Karnataka',
                                        'Kerala' => 'Kerala',
                                        'Madhya Pradesh' => 'Madhya Pradesh',
                                        'Maharashtra' => 'Maharashtra',
                                        'Manipur' => 'Manipur',
                                        'Meghalaya' => 'Meghalaya',
                                        'Mizoram' => 'Mizoram',
                                        'Nagaland' => 'Nagaland',
                                        'Odisha' => 'Odisha',
                                        'Punjab' => 'Punjab',
                                        'Rajasthan' => 'Rajasthan',
                                        'Sikkim' => 'Sikkim',
                                        'Tamil Nadu' => 'Tamil Nadu',
                                        'Telangana' => 'Telangana',
                                        'Tripura' => 'Tripura',
                                        'Uttar Pradesh' => 'Uttar Pradesh',
                                        'Uttarakhand' => 'Uttarakhand',
                                        'West Bengal' => 'West Bengal',
                                        'Delhi' => 'Delhi',
                                        'Jammu and Kashmir' => 'Jammu and Kashmir',
                                        'Ladakh' => 'Ladakh',
                                        'Andaman and Nicobar Islands' => 'Andaman and Nicobar Islands',
                                        'Chandigarh' => 'Chandigarh',
                                        'Dadra and Nagar Haveli and Daman and Diu' => 'Dadra and Nagar Haveli and Daman and Diu',
                                        'Lakshadweep' => 'Lakshadweep',
                                        'Puducherry' => 'Puducherry',
                                        ];
                                        @endphp
                                        @foreach ($states as $key => $val)
                                        <option value="{{ $key }}"
                                            {{ old('state', $party->state) == $key ? 'selected' : '' }}>
                                            {{ $val }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('state'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Opening Balance</label>
                                        <input type="text" class="form-control" name="opening_balance"
                                            placeholder="0" value="{{ $party->opening_balance }}" />
                                        @if ($errors->has('opening_balance'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('opening_balance') }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Party Details Section -->
                            <h5>Party Details</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name', $party->name) }}" />
                                        @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Phone No</label>
                                        <input type="text" class="form-control" name="phone_no"
                                            value="{{ old('phone_no', $party->phone_no) }}" />
                                        @if ($errors->has('phone_no'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone_no') }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control" name="email"
                                            value="{{ old('email', $party->email) }}" />
                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div id="gstin-field" class="mb-3"
                                        style="{{ $party->party_type == 'registered' ? 'display: block;' : 'display: none;' }}">
                                        <label class="form-label">GSTIN</label>
                                        <input type="text" class="form-control" name="gstin"
                                            value="{{ old('gstin', $party->gstin) }}" />
                                        @if ($errors->has('gstin'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('gstin') }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Address Section -->
                            <h5>Address</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Business Address</h6>
                                    <br>
                                    <div class="mb-3">
                                        <label class="form-label">Address 1</label>
                                        <input type="text" class="form-control" name="billing_address_1"
                                            id="billing_address_1"
                                            value="{{ old('billing_address_1', $party->billing_address_1) }}" />
                                        @if ($errors->has('billing_address_1'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billing_address_1') }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Address 2</label>
                                        <input type="text" class="form-control" name="billing_address_2"
                                            id="billing_address_2"
                                            value="{{ old('billing_address_2', $party->billing_address_2) }}" />
                                        @if ($errors->has('billing_address_2'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billing_address_2') }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Pincode</label>
                                        <input type="text" class="form-control" name="billing_pincode"
                                            id="billing_pincode"
                                            value="{{ old('billing_pincode', $party->billing_pincode) }}" />
                                        @if ($errors->has('billing_pincode'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('billing_pincode') }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6" id="shipping-address-section"
                                    style="{{ $party->transaction_type == 'sale' ? 'display: block;' : 'display: none;' }}">
                                    <h6>Shipping Address</h6>
                                    <div>
                                        <input type="radio" id="same_address_yes" name="same_address"
                                            value="yes" checked
                                            {{ old('same_address', $party->same_address) == 'yes' ? 'checked' : '' }} />
                                        <label for="same_address_yes">Same as Business Address</label>
                                        <input type="radio" id="same_address_no" name="same_address"
                                            value="no"
                                            {{ old('same_address', $party->same_address) == 'no' ? 'checked' : '' }} />
                                        <label for="same_address_no">Different Address</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Address 1</label>
                                        <input type="text" class="form-control" name="shipping_address_1"
                                            id="shipping_address_1"
                                            value="{{ old('shipping_address_1', $party->shipping_address_1) }}" />
                                        @if ($errors->has('shipping_address_1'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('shipping_address_1') }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Address 2</label>
                                        <input type="text" class="form-control" name="shipping_address_2"
                                            id="shipping_address_2"
                                            value="{{ old('shipping_address_2', $party->shipping_address_2) }}" />
                                        @if ($errors->has('shipping_address_2'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('shipping_address_2') }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Pincode</label>
                                        <input type="text" class="form-control" name="shipping_pincode"
                                            id="shipping_pincode"
                                            value="{{ old('shipping_pincode', $party->shipping_pincode) }}" />
                                        @if ($errors->has('shipping_pincode'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('shipping_pincode') }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 text-end" style="text-align: right;">
                                <button type="submit" class="btn btn-primary">Update Party</button>
                                <a href="{{ route('party.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Basic Layout -->
    </div>
    <!-- / Content -->
</div>
<!-- / Content wrapper -->


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const partyTypeSelect = document.getElementById('party_type');
        const gstinField = document.getElementById('gstin-field');
        const saleRadio = document.getElementById('sale');
        const purchaseRadio = document.getElementById('purchase');
        const shippingAddressSection = document.getElementById('shipping-address-section');
        const billingAddress1 = document.getElementById('billing_address_1');
        const billingAddress2 = document.getElementById('billing_address_2');
        const billingPincode = document.getElementById('billing_pincode');
        const shippingAddress1 = document.getElementById('shipping_address_1');
        const shippingAddress2 = document.getElementById('shipping_address_2');
        const shippingPincode = document.getElementById('shipping_pincode');

        // Function to toggle GSTIN field visibility
        function toggleGstinField() {
            if (partyTypeSelect && gstinField) {
                if (partyTypeSelect.value === 'registered') {
                    gstinField.style.display = 'block';
                } else {
                    gstinField.style.display = 'none';
                    if (billingAddress1) billingAddress1.value = '';
                    if (billingAddress2) billingAddress2.value = '';
                    if (billingPincode) billingPincode.value = '';
                }
            }
        }

        // Function to toggle Shipping Address section visibility
        function toggleAddressFields() {
            if (saleRadio && shippingAddressSection) {
                if (saleRadio.checked) {
                    shippingAddressSection.style.display = 'block';
                } else if (purchaseRadio) {
                    shippingAddressSection.style.display = 'none';
                }
            }
        }

        // Function to copy billing address to shipping address
        function copyBillingToShipping() {
            if (shippingAddress1 && billingAddress1) {
                shippingAddress1.value = billingAddress1.value;
            }
            if (shippingAddress2 && billingAddress2) {
                shippingAddress2.value = billingAddress2.value;
            }
            if (shippingPincode && billingPincode) {
                shippingPincode.value = billingPincode.value;
            }
        }

        // Function to clear shipping address fields
        function clearShippingAddress() {
            if (shippingAddress1) shippingAddress1.value = '';
            if (shippingAddress2) shippingAddress2.value = '';
            if (shippingPincode) shippingPincode.value = '';
        }

        // Initial checks
        toggleGstinField();
        toggleAddressFields();

        // Event listener for Party Type dropdown change
        if (partyTypeSelect) {
            partyTypeSelect.addEventListener('change', toggleGstinField);
        }

        // Event listeners for Transaction Type radio buttons change
        document.querySelectorAll('input[name="transaction_type"]').forEach(function (element) {
            element.addEventListener('change', toggleAddressFields);
        });

        // Event listeners for Same Address radio buttons change
        document.querySelectorAll('input[name="same_address"]').forEach(function (element) {
            element.addEventListener('change', function () {
                if (this.value === 'yes') {
                    copyBillingToShipping();
                } else {
                    clearShippingAddress();
                }
            });
        });

        // Event listeners for real-time billing address input updates
        [billingAddress1, billingAddress2, billingPincode].forEach(function (field) {
            if (field) {
                field.addEventListener('input', function () {
                    if (document.querySelector('input[name="same_address"]:checked')?.value === 'yes') {
                        copyBillingToShipping();
                    }
                });
            }
        });
    });
</script>

@endsection