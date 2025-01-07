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
                                        <label class="form-label">Customer Name</label>
                                        <input type="text" class="form-control" name="customer_name" value="{{ old('customer_name') }}" required />
                                        @if ($errors->has('customer_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('customer_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mb-1">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" name="address" value="{{ old('address') }}" required />
                                        @if ($errors->has('address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mb-1">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required />
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
@endsection
