@extends('layouts.v2.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center mb-1">
                            <h5 class="mb-0">Add New Repair Request</h5>
                        </div>
                        <div class="card-body">
                            <form id="repair-form" method="POST" action="{{ route('repairs.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-4 mb-1">
                                        <label class="form-label">Service No</label>
                                        <input type="text" class="form-control" name="service_no" value="{{ $service_no }}" readonly />
                                        @if ($errors->has('service_no'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('service_no') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                <!-- Customer Details -->
                                <h5 class="mb-4">Customer Details</h5>
                                <div class="row">
                                    <div class="col-md-3 mb-1">
                                        <label class="form-label">Party Name</label>
                                        {{-- <input type="text" class="form-control" name="customer_name" value="{{ old('customer_name') }}" required /> --}}
                                        <div style="display:flex">
                                            <input type="text" required class="form-control party" id="party"
                                                required name="party" value="">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#basicModal1" style="background:linear-gradient(to right,#ff746e, #ff9e6f);border:none;">+</button>
                                        </div>
                                            <input type="hidden" required class="party" id="partyid" required
                                                name="customer_name" value="">
                                                
                                        @if ($errors->has('customer_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('customer_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mb-1">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required />
                                        @if ($errors->has('address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mb-1">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required />
                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mb-1">
                                        <label class="form-label" for="formValidationName">Date</label>
                                        <input type="text" class="form-control"   name="repair_date" value="{{ date('d-m-Y') }}">
                                        @if ($errors->has('repair_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('repair_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-1">
                                        <label class="form-label">Model No</label>
                                        <input type="text" class="form-control" name="model" value="{{ old('model') }}"  />
                                        @if ($errors->has('model'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('model') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <!-- Repair Details -->
                                <h5 class="mt-4 mb-4">Repair Details</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-1">
                                        <label class="form-label">Complaint / Remark</label>
                                        <textarea class="form-control" name="complaint_remark" rows="2" required>{{ old('complaint_remark') }}</textarea>
                                        @if ($errors->has('complaint_remark'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('complaint_remark') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-4 mb-1">
                                        <label class="form-label">IMEI</label>
                                        <input type="text" class="form-control" name="imei" value="{{ old('imei') }}" />
                                        @if ($errors->has('imei'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('imei') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-4 mb-1">
                                        <label class="form-label">Unlock PIN</label>
                                        <input type="text" class="form-control" name="mobile_pin" value="{{ old('mobile_pin') }}" required />
                                        @if ($errors->has('mobile_pin'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('mobile_pin') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Phone Condition -->
                                <h5 class="mt-4 mb-4">Phone Condition</h5>
                                <div class="row">
                                    <div class="col-md-4 mb-1">
                                        <label class="form-label">Phone Condition</label>
                                        <select name="phone_condition" class="form-select" required>
                                            <option value="">Select Condition</option>
                                            <option value="working">Working</option>
                                            <option value="damaged">Damaged</option>
                                            <option value="not_working">Not Working</option>
                                        </select>
                                        @if ($errors->has('phone_condition'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('phone_condition') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-4 mb-1">
                                        <label class="form-label">Battery Included?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="battery" id="battery_yes" value="yes" checked>
                                            <label class="form-check-label" for="battery_yes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="battery" id="battery_no" value="no">
                                            <label class="form-check-label" for="battery_no">No</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-1" id="battery_details" style="display: none;">
                                        <label class="form-label">Battery Details</label>
                                        <input type="text" class="form-control" name="battery_details" placeholder="Enter battery details" />
                                    </div>

                                    <div class="col-md-4 mb-1">
                                        <label class="form-label">SIM Included?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sim" id="sim_yes" value="yes" checked>
                                            <label class="form-check-label" for="sim_yes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sim" id="sim_no" value="no">
                                            <label class="form-check-label" for="sim_no">No</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-1" id="sim_details" style="display: none;">
                                        <label class="form-label">SIM Details</label>
                                        <input type="text" class="form-control" name="sim_details" placeholder="Enter SIM details" />
                                    </div>

                                    <div class="col-md-4 mb-1">
                                        <label class="form-label">Estimated Amount</label>
                                        <input type="number" class="form-control" name="estimated_amount" value="{{ old('estimated_amount') }}" required />
                                        @if ($errors->has('estimated_amount'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('estimated_amount') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-1">
                                        <label class="form-label">Estimated Delivery Date</label>
                                        <input type="date" class="form-control" name="estimated_delivery_date" value="{{ old('estimated_delivery_date') }}" required />
                                        @if ($errors->has('estimated_delivery_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('estimated_delivery_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-4 mb-1">
                                        <label class="form-label">Received By</label>
                                        <input type="text" class="form-control" name="received_by"  pattern="[A-Za-z\s]+" title="Please enter alphabets only." value="{{ old('received_by') }}" required />
                                        @if ($errors->has('received_by'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('received_by') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label class="form-label">Cash Received </label>
                                        <input type="number" style="text-decoration: none;" class="form-control" name="cash_received" value="{{ old('cash_received') }}"  />
                                        @if ($errors->has('cash_received'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('cash_received') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label class="form-label">Pattern Image</label>
                                        <img width="75" height="75" id="pattern" src="{{ asset('pattern/pattern.PNG') }}" title="" alt="pattern" />
                                        @if ($errors->has('pattern_image'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('pattern_image') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <button type="submit" class="btn btn-primary">Submit Repair Request</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-backdrop fade"></div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="basicModal1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Add Party</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="validation-errors-party"></div>
                    <form method="POST" id="partyForm" action="{{ route('party.ajaxsave') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Type and Party Type -->
                        <div class="mb-3 row">
                            <div class="col-md-3">
                                <label class="form-label">Type</label>
                                <div>
                                    <input type="radio" id="sale" name="transaction_type" value="sale"
                                        checked />
                                    <label for="sale">Sale</label>
                                    <input type="radio" id="purchase" name="transaction_type" value="purchase" />
                                    <label for="purchase">Purchase</label>
                                </div>
                                @if ($errors->has('transaction_type'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('transaction_type') }}</strong>
                                </span>
                                @endif
                            </div>
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
                                        @if (old('party_type', 'unregistered' )==$key) selected @endif>{{ $val }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('party_type'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('party_type') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">State</label>
                                    <select class="form-control" name="state">
                                        <option value="">Select State</option>
                                        <option value="Andhra Pradesh" {{ old('state') == 'Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
                                        <option value="Arunachal Pradesh" {{ old('state') == 'Arunachal Pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
                                        <option value="Assam" {{ old('state') == 'Assam' ? 'selected' : '' }}>Assam</option>
                                        <option value="Bihar" {{ old('state') == 'Bihar' ? 'selected' : '' }}>Bihar</option>
                                        <option value="Chhattisgarh" {{ old('state') == 'Chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
                                        <option value="Goa" {{ old('state') == 'Goa' ? 'selected' : '' }}>Goa</option>
                                        <option value="Gujarat" {{ old('state') == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                                        <option value="Haryana" {{ old('state') == 'Haryana' ? 'selected' : '' }}>Haryana</option>
                                        <option value="Himachal Pradesh" {{ old('state') == 'Himachal Pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
                                        <option value="Jharkhand" {{ old('state') == 'Jharkhand' ? 'selected' : '' }}>Jharkhand</option>
                                        <option value="Karnataka" {{ old('state') == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                                        <option value="Kerala" {{ old('state') == 'Kerala' ? 'selected' : '' }}>Kerala</option>
                                        <option value="Madhya Pradesh" {{ old('state') == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
                                        <option value="Maharashtra" {{ old('state') == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                        <option value="Manipur" {{ old('state') == 'Manipur' ? 'selected' : '' }}>Manipur</option>
                                        <option value="Meghalaya" {{ old('state') == 'Meghalaya' ? 'selected' : '' }}>Meghalaya</option>
                                        <option value="Mizoram" {{ old('state') == 'Mizoram' ? 'selected' : '' }}>Mizoram</option>
                                        <option value="Nagaland" {{ old('state') == 'Nagaland' ? 'selected' : '' }}>Nagaland</option>
                                        <option value="Odisha" {{ old('state') == 'Odisha' ? 'selected' : '' }}>Odisha</option>
                                        <option value="Punjab" {{ old('state') == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                                        <option value="Rajasthan" {{ old('state') == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                                        <option value="Sikkim" {{ old('state') == 'Sikkim' ? 'selected' : '' }}>Sikkim</option>
                                        <option value="Tamil Nadu" {{ old('state') == 'Tamil Nadu' ? 'selected' : 'selected' }}>Tamil Nadu</option>
                                        <option value="Telangana" {{ old('state') == 'Telangana' ? 'selected' : '' }}>Telangana</option>
                                        <option value="Tripura" {{ old('state') == 'Tripura' ? 'selected' : '' }}>Tripura</option>
                                        <option value="Uttar Pradesh" {{ old('state') == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                                        <option value="Uttarakhand" {{ old('state') == 'Uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
                                        <option value="West Bengal" {{ old('state') == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
                                        <option value="Andaman and Nicobar Islands" {{ old('state') == 'Andaman and Nicobar Islands' ? 'selected' : '' }}>Andaman and Nicobar Islands</option>
                                        <option value="Chandigarh" {{ old('state') == 'Chandigarh' ? 'selected' : '' }}>Chandigarh</option>
                                        <option value="Dadra and Nagar Haveli and Daman and Diu" {{ old('state') == 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : '' }}>Dadra and Nagar Haveli and Daman and Diu</option>
                                        <option value="Lakshadweep" {{ old('state') == 'Lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
                                        <option value="Delhi" {{ old('state') == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                                        <option value="Puducherry" {{ old('state') == 'Puducherry' ? 'selected' : '' }}>Puducherry</option>
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
                                    <input type="text" class="form-control" name="opening_balance" placeholder="0" value="0" />
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
                                        value="{{ old('name') }}" />
                                    @if ($errors->has('name'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Phone No</label>
                                    <input type="text" class="form-control" name="phone_no"
                                        value="{{ old('phone_no') }}" />
                                    @if ($errors->has('phone_no'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('phone_no') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email"
                                        value="{{ old('email') }}" />
                                    @if ($errors->has('email'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div id="gstin-field" class="mb-3" style="display: none;">
                                    <label class="form-label">GSTIN</label>
                                    <input type="text" class="form-control" name="gstin"
                                        value="{{ old('gstin') }}" />
                                    @if ($errors->has('gstin'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('gstin') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Address Section -->
                        <h5>Address</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Business Address</h6>
                                <div class="mb-3">
                                    <label class="form-label">Address 1</label>
                                    <input type="text" class="form-control" name="billing_address_1"
                                        id="billing_address_1" value="{{ old('billing_address_1') }}" />
                                    @if ($errors->has('billing_address_1'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('billing_address_1') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address 2</label>
                                    <input type="text" class="form-control" name="billing_address_2"
                                        id="billing_address_2" value="{{ old('billing_address_2') }}" />
                                    @if ($errors->has('billing_address_2'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('billing_address_2') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pincode</label>
                                    <input type="text" class="form-control" name="billing_pincode"
                                        id="billing_pincode" value="{{ old('billing_pincode') }}" />
                                    @if ($errors->has('billing_pincode'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('billing_pincode') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6" id="shipping-address-section">
                                <h6>Shipping Address</h6>
                                <div>
                                    <input type="radio" id="same_address_yes" name="same_address" value="yes" />
                                    <label for="same_address_yes">Same as Business Address</label>
                                    <input type="radio" id="same_address_no" name="same_address" value="no"
                                        checked />
                                    <label for="same_address_no">Different Address</label>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address 1</label>
                                    <input type="text" class="form-control" name="shipping_address_1"
                                        id="shipping_address_1" value="{{ old('shipping_address_1') }}" />
                                    @if ($errors->has('shipping_address_1'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('shipping_address_1') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address 2</label>
                                    <input type="text" class="form-control" name="shipping_address_2"
                                        id="shipping_address_2" value="{{ old('shipping_address_2') }}" />
                                    @if ($errors->has('shipping_address_2'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('shipping_address_2') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Pincode</label>
                                    <input type="text" class="form-control" name="shipping_pincode"
                                        id="shipping_pincode" value="{{ old('shipping_pincode') }}" />
                                    @if ($errors->has('shipping_pincode'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('shipping_pincode') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="partysaveBtn" class="btn btn-primary" style="background:linear-gradient(to right,#ff746e, #ff9e6f);border:none;">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        var path = "{{ route('autocomplete') }}";
        var partypath = "{{ route('partyautocomplete') }}";
        $(document).ready(function() {
            // Initialize autocomplete only once
            $('.party').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: partypath,
                        type: 'GET',
                        dataType: "json",
                        data: {
                            partysearch: request.term,
                            type: "sale"
                        },
                        success: function(data) {
                            if (data.length > 0) {
                                response(data.map(function(party) {
                                    $("#party_gst").val(party.gst_profile);
                                    return {
                                        label: party.name,
                                        id: party.id,
                                        party_detail: [
                                            party.billing_address_1,
                                            party.billing_address_2,
                                            party.billing_pincode
                                        ].filter(Boolean).join(', '),
                                        partyphone: party.phone_no,
                                        state: party.state
                                    };
                                }));
                            } else {
                                console.log("No matching party found.");
                                response([]); // Send an empty response
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching data: ", status, error);
                        }
                    });
                },
                select: function(event, ui) {
                    $(this).val(ui.item.label);
                    $('#partyid').val(ui.item.id);
                    $('#address').val(ui.item.party_detail);
                    $('#phone').val(ui.item.partyphone);
                    $('#state').val(ui.item.state);
                    return false; // Prevent default behavior
                }
            });
        });
    </script>
    <script>
                $('#partysaveBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#partyForm').serialize(),
                url: "{{ route('party.ajaxsave') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {

                    $('#partyForm').trigger("reset");
                    $('#basicModal1').modal('hide');
                    $('.modal-backdrop').hide();
                    // table.draw();
                    $('#party').html('<option value="">-- Select Party --</option>');
                    $.each(data.party, function(key, value) {
                        $("#party").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });


                },
                error: function(xhr) {
                    console.log('Error:', xhr);
                    $('#partysaveBtn').html('Save Changes');

                    $('#validation-errors-party').html('');
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $('#validation-errors-party').append(
                            '<div class="alert alert-danger">' + value + '</div'
                        );
                    });

                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const batteryYes = document.getElementById('battery_yes');
            const batteryDetailsField = document.getElementById('battery_details');
            const simYes = document.getElementById('sim_yes');
            const simDetailsField = document.getElementById('sim_details');

            function toggleBatteryDetails() {
                batteryDetailsField.style.display = batteryYes.checked ? 'block' : 'none';
            }

            function toggleSimDetails() {
                simDetailsField.style.display = simYes.checked ? 'block' : 'none';
            }

            // Initial check
            toggleBatteryDetails();
            toggleSimDetails();

            // Add event listeners
            batteryYes.addEventListener('change', toggleBatteryDetails);
            document.getElementById('battery_no').addEventListener('change', toggleBatteryDetails);
            simYes.addEventListener('change', toggleSimDetails);
            document.getElementById('sim_no').addEventListener('change', toggleSimDetails);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const partyTypeSelect = document.getElementById('party_type');
            const gstinField = document.getElementById('gstin-field');
            const saleRadio = document.getElementById('sale');
            const purchaseRadio = document.getElementById('purchase');
            const shippingAddressSection = document.getElementById('shipping-address-section');
    
            function toggleGstinField() {
                if (partyTypeSelect.value === 'registered') {
                    gstinField.style.display = 'block';
                } else {
                    gstinField.style.display = 'none';
                }
            }
    
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
    
            // Add event listeners
            partyTypeSelect.addEventListener('change', toggleGstinField);
            saleRadio.addEventListener('change', toggleAddressFields);
            purchaseRadio.addEventListener('change', toggleAddressFields);
    
            // Address copy functionality
            const sameAddressRadio = document.getElementById('same_address_yes');
            const differentAddressRadio = document.getElementById('same_address_no');
    
            const billingAddressFields = {
                address1: document.getElementById('billing_address_1'),
                address2: document.getElementById('billing_address_2'),
                pincode: document.getElementById('billing_pincode')
            };
    
            const shippingAddressFields = {
                address1: document.getElementById('shipping_address_1'),
                address2: document.getElementById('shipping_address_2'),
                pincode: document.getElementById('shipping_pincode')
            };
    
            function copyAddress() {
                if (sameAddressRadio.checked) {
                    shippingAddressFields.address1.value = billingAddressFields.address1.value;
                    shippingAddressFields.address2.value = billingAddressFields.address2.value;
                    shippingAddressFields.pincode.value = billingAddressFields.pincode.value;
                } else {
                    shippingAddressFields.address1.value = '';
                    shippingAddressFields.address2.value = '';
                    shippingAddressFields.pincode.value = '';
                }
            }
    
            // Add event listeners for radio buttons
            sameAddressRadio.addEventListener('change', copyAddress);
            differentAddressRadio.addEventListener('change', copyAddress);
        });
    </script>
@endsection
