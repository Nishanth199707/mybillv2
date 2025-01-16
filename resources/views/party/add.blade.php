@extends('layouts.v2.app')
@section('content')
<style>
    .readonly {
    background-color: #f0f0f0;
    pointer-events: none; /* Prevent interaction */
    color: #999; /* Gray out text */
    }
</style>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Add New Party</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('party.store') }}" enctype="multipart/form-data">
                            @csrf

                           

                            <!-- Party Type and Sale/Purchase Selection in the Same Row -->
                            <div class="mb-3 row">
                                <div class="col-md-3">
                                    <label class="form-label">Type</label>
                                    <div>
                                        <input type="radio" id="sale" name="transaction_type" value="sale" checked />
                                        <label for="sale">Sale</label>
                                        @if($business->business_category != 'Accounting & CA')
                                        <input type="radio" id="purchase" name="transaction_type" value="purchase" />
                                        <label for="purchase">Purchase</label>
                                        @endif
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
                                        'registered' => 'Registered'
                                        ];
                                        @endphp
                                        @foreach ($party_type as $key => $val)
                                        <option @if(old('party_type', 'unregistered' )==$key) selected @endif value="{{$key}}">{{$val}}</option>
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
                                        <option @if(old('party_type', 'unregistered' )==$key) selected @endif value="{{$key}}">{{$val}}</option>
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
                                    <div class="mb-3">
                                        <label class="form-label">State</label>
                                        <select name="state" class="form-select">
                                            <option value="" disabled {{ empty($business->state) ? 'selected' : '' }}>Select State</option>
                                            <option value="Andhra Pradesh" {{ $business->state == 'Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
                                            <option value="Arunachal Pradesh" {{ $business->state == 'Arunachal Pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
                                            <option value="Assam" {{ $business->state == 'Assam' ? 'selected' : '' }}>Assam</option>
                                            <option value="Bihar" {{ $business->state == 'Bihar' ? 'selected' : '' }}>Bihar</option>
                                            <option value="Chhattisgarh" {{ $business->state == 'Chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
                                            <option value="Goa" {{ $business->state == 'Goa' ? 'selected' : '' }}>Goa</option>
                                            <option value="Gujarat" {{ $business->state == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                                            <option value="Haryana" {{ $business->state == 'Haryana' ? 'selected' : '' }}>Haryana</option>
                                            <option value="Himachal Pradesh" {{ $business->state == 'Himachal Pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
                                            <option value="Jharkhand" {{ $business->state == 'Jharkhand' ? 'selected' : '' }}>Jharkhand</option>
                                            <option value="Karnataka" {{ $business->state == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                                            <option value="Kerala" {{ $business->state == 'Kerala' ? 'selected' : '' }}>Kerala</option>
                                            <option value="Madhya Pradesh" {{ $business->state == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
                                            <option value="Maharashtra" {{ $business->state == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                            <option value="Manipur" {{ $business->state == 'Manipur' ? 'selected' : '' }}>Manipur</option>
                                            <option value="Meghalaya" {{ $business->state == 'Meghalaya' ? 'selected' : '' }}>Meghalaya</option>
                                            <option value="Mizoram" {{ $business->state == 'Mizoram' ? 'selected' : '' }}>Mizoram</option>
                                            <option value="Nagaland" {{ $business->state == 'Nagaland' ? 'selected' : '' }}>Nagaland</option>
                                            <option value="Odisha" {{ $business->state == 'Odisha' ? 'selected' : '' }}>Odisha</option>
                                            <option value="Punjab" {{ $business->state == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                                            <option value="Rajasthan" {{ $business->state == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                                            <option value="Sikkim" {{ $business->state == 'Sikkim' ? 'selected' : '' }}>Sikkim</option>
                                            <option value="Tamil Nadu" {{ $business->state == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                                            <option value="Telangana" {{ $business->state == 'Telangana' ? 'selected' : '' }}>Telangana</option>
                                            <option value="Tripura" {{ $business->state == 'Tripura' ? 'selected' : '' }}>Tripura</option>
                                            <option value="Uttar Pradesh" {{ $business->state == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                                            <option value="Uttarakhand" {{ $business->state == 'Uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
                                            <option value="West Bengal" {{ $business->state == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
                                            <option value="Andaman and Nicobar Islands" {{ $business->state == 'Andaman and Nicobar Islands' ? 'selected' : '' }}>Andaman and Nicobar Islands</option>
                                            <option value="Chandigarh" {{ $business->state == 'Chandigarh' ? 'selected' : '' }}>Chandigarh</option>
                                            <option value="Dadra and Nagar Haveli and Daman and Diu" {{ $business->state == 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : '' }}>Dadra and Nagar Haveli and Daman and Diu</option>
                                            <option value="Lakshadweep" {{ $business->state == 'Lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
                                            <option value="Delhi" {{ $business->state == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                                            <option value="Puducherry" {{ $business->state == 'Puducherry' ? 'selected' : '' }}>Puducherry</option>
                                        </select>

                                        @if ($errors->has('state'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('state') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label class="form-label">Opening Balance</label>
                                        <input type="text" class="form-control" name="opening_balance" value="0"
                                            placeholder="0" />
                                        @if ($errors->has('opening_balance'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('opening_balance') }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Party Details Section -->
                                <h5>Party Details</h5>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" class="form-control checkgst" id="name" name="name" value="{{ old('name') }}" />
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
                                            <input type="text" class="form-control" name="phone_no" value="{{ old('phone_no') }}" />
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
                                            <input type="text" class="form-control" name="email" value="{{ old('email') }}" />
                                            @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div id="gstin-field" class="mb-3" style="display: none;">
                                            <label class="form-label">GSTIN</label>
                                            <input type="text" id="gstin" class="form-control" name="gstin" value="{{ old('gstin') }}" />
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
                                            <input type="text" class="form-control checkgst" name="billing_address_1" id="billing_address_1" value="{{ old('billing_address_1') }}" />
                                            @if ($errors->has('billing_address_1'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('billing_address_1') }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Address 2</label>
                                            <input type="text" class="form-control checkgst" name="billing_address_2" id="billing_address_2" value="{{ old('billing_address_2') }}" />
                                            @if ($errors->has('billing_address_2'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('billing_address_2') }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pincode</label>
                                            <input type="text" class="form-control checkgst" name="billing_pincode" id="billing_pincode" value="{{ old('billing_pincode') }}" />
                                            @if ($errors->has('billing_pincode'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('billing_pincode') }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="shipping-address-section">
                                        <h6>Shipping Address</h6>
                                        <div>
                                            <input type="radio" id="same_address_yes" name="same_address" value="yes" checked/>
                                            <label for="same_address_yes">Same as Business Address</label>
                                            <input type="radio" id="same_address_no" name="same_address" value="no" />
                                            <label for="same_address_no">Different Address</label>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Address 1</label>
                                            <input type="text" class="form-control" name="shipping_address_1" id="shipping_address_1" value="{{ old('shipping_address_1') }}" />
                                            @if ($errors->has('shipping_address_1'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('shipping_address_1') }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Address 2</label>
                                            <input type="text" class="form-control" name="shipping_address_2" id="shipping_address_2" value="{{ old('shipping_address_2') }}" />
                                            @if ($errors->has('shipping_address_2'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('shipping_address_2') }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Pincode</label>
                                            <input type="text" class="form-control" name="shipping_pincode" id="shipping_pincode" value="{{ old('shipping_pincode') }}" />
                                            @if ($errors->has('shipping_pincode'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('shipping_pincode') }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const partyTypeSelect = document.getElementById('party_type');
        const gstinField = document.getElementById('gstin-field');
        const saleRadio = document.getElementById('sale');
        const purchaseRadio = document.getElementById('purchase');
        const shippingAddressSection = document.getElementById('shipping-address-section');

        // Function to toggle GSTIN field visibility
        function toggleGstinField() {
            if (partyTypeSelect.value === 'registered') {
                gstinField.style.display = 'block';
                // $('.checkgst').addClass('readonly');
            } else {
                // $('.checkgst').removeClass('readonly');
                gstinField.style.display = 'none';
                $('#name').val('');
                            $('#billing_address_1').val('');
                            $('#billing_address_2').val('');
                            $('#billing_pincode').val('');
            }
        }

        // Function to toggle Shipping Address section visibility
        function toggleAddressFields() {
            if (saleRadio.checked) {
                shippingAddressSection.style.display = 'block';
            } else {
                shippingAddressSection.style.display = 'none';
            }
        }

        // Initial checks
        toggleGstinField();
        toggleAddressFields();

        // Event listener for Party Type dropdown change
        partyTypeSelect.addEventListener('change', function() {
            toggleGstinField();
        });

        // Event listeners for Transaction Type radio buttons change
        document.querySelectorAll('input[name="transaction_type"]').forEach(function(element) {
            element.addEventListener('change', function() {
                toggleAddressFields();
            });
        });
        document.querySelectorAll('input[name="same_address"]').forEach(function(element) {
            element.addEventListener('change', function() {
                if (this.value === 'yes') {
                    // Copy business address to shipping address
                    document.getElementById('shipping_address_1').value = document
                        .getElementById('billing_address_1').value;
                    document.getElementById('shipping_address_2').value = document
                        .getElementById('billing_address_2').value;
                    document.getElementById('shipping_pincode').value = document.getElementById(
                        'billing_pincode').value;
                } else {
                    // Clear shipping address
                    document.getElementById('shipping_address_1').value = '';
                    document.getElementById('shipping_address_2').value = '';
                    document.getElementById('shipping_pincode').value = '';
                }
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Set up the CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#gstin").on('input', function () {
            var gstin = $(this).val();
            if (gstin.length == 15) {
                $.ajax({
                    url: '{{ url('search') }}/' + gstin,
                    type: 'GET',
                    success: function (data) {
                        var response = JSON.parse(data);
                        console.log(response.data);
                        if (response.data) {
                            $('#name').val(response.data.lgnm);
                            $('#billing_address_1').val(
                                response.data.pradr.addr.bnm + ', ' +
                                response.data.pradr.addr.st 
                            );
                            $('#billing_address_2').val(
                                response.data.pradr.addr.loc + ', ' +
                                response.data.pradr.addr.dst
                            );
                            $('#billing_pincode').val(response.data.pradr.addr.pncd);
                            
                        } else {
                            console.error("Unexpected response structure: ", response);
                        }
                    },
                    error: function (xhr) {
                        // Handle the error
                    }
                });
            }
        });
    });
</script>

@endsection