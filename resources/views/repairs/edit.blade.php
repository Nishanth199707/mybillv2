@extends('layouts.v2.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center mb-1">
                            <h5 class="mb-0">Edit Repair Request</h5>
                        </div>
                        <div class="card-body">
                            <form id="repair-form" method="POST" action="{{ route('repairs.update', $repair->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Service No -->
                                <div class="col-md-4 mb-1">
                                    <label class="form-label">Service No</label>
                                    <input type="text" class="form-control" name="service_no" value="{{ $repair->service_no }}" readonly />
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
                                        <input type="text" required class="form-control party" id="party"
                                        required name="party" value="{{ $repair_det->name }}">
                                    <input type="hidden" required class="party" id="partyid" required
                                        name="customer_name" value="{{ old('customer_name', $repair->customer_name) }}">
                                        @if ($errors->has('customer_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('customer_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mb-1">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" name="address" value="{{ old('address', $repair->address) }}" required />
                                        @if ($errors->has('address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mb-1">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control" name="phone" value="{{ old('phone', $repair->phone) }}" required />
                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-3 mb-1">
                                        <label class="form-label" for="formValidationName">Date</label>
                                        <input type="text" class="form-control" name="repair_date" value="{{ old('repair_date', \Carbon\Carbon::parse($repair->repair_date)->format('d-m-Y')) }}" />
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
                                        <input type="text" class="form-control" name="model" value="{{ old('model', $repair->model) }}" />
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
                                        <textarea class="form-control" name="complaint_remark" rows="2" required>{{ old('complaint_remark', $repair->complaint_remark) }}</textarea>
                                        @if ($errors->has('complaint_remark'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('complaint_remark') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-4 mb-1">
                                        <label class="form-label">IMEI</label>
                                        <input type="text" class="form-control" name="imei" value="{{ old('imei', $repair->imei) }}" />
                                        @if ($errors->has('imei'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('imei') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-4 mb-1">
                                        <label class="form-label">Unlock PIN</label>
                                        <input type="text" class="form-control" name="mobile_pin" value="{{ old('mobile_pin', $repair->mobile_pin) }}" required />
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
                                            <option value="working" {{ old('phone_condition', $repair->phone_condition) == 'working' ? 'selected' : '' }}>Working</option>
                                            <option value="damaged" {{ old('phone_condition', $repair->phone_condition) == 'damaged' ? 'selected' : '' }}>Damaged</option>
                                            <option value="not_working" {{ old('phone_condition', $repair->phone_condition) == 'not_working' ? 'selected' : '' }}>Not Working</option>
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
                                            <input class="form-check-input" type="radio" name="battery" id="battery_yes" value="yes" {{ $repair->battery == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="battery_yes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="battery" id="battery_no" value="no" {{ $repair->battery == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="battery_no">No</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-1" id="battery_details" style="{{ $repair->battery == 'no' ? 'display: none;' : 'display: block;' }}">
                                        <label class="form-label">Battery Details</label>
                                        <input type="text" class="form-control" name="battery_details" value="{{ old('battery_details', $repair->battery_details) }}" placeholder="Enter battery details" />
                                    </div>

                                    <div class="col-md-4 mb-1">
                                        <label class="form-label">SIM Included?</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sim" id="sim_yes" value="yes" {{ $repair->sim == 'yes' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sim_yes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="sim" id="sim_no" value="no" {{ $repair->sim == 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sim_no">No</label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-1" id="sim_details" style="{{ $repair->sim == 'no' ? 'display: none;' : 'display: block;' }}">
                                        <label class="form-label">SIM Details</label>
                                        <input type="text" class="form-control" name="sim_details" value="{{ old('sim_details', $repair->sim_details) }}" placeholder="Enter SIM details" />
                                    </div>

                                    <div class="col-md-4 mb-1">
                                        <label class="form-label">Estimated Amount</label>
                                        <input type="number" class="form-control" name="estimated_amount" value="{{ old('estimated_amount', $repair->estimated_amount) }}" required />
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
                                        <input type="date" class="form-control" name="estimated_delivery_date" value="{{ old('estimated_delivery_date', $repair->estimated_delivery_date) }}" required />
                                        @if ($errors->has('estimated_delivery_date'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('estimated_delivery_date') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="col-md-4 mb-1">
                                        <label class="form-label">Received By</label>
                                        <input type="text" class="form-control" name="received_by" value="{{ old('received_by', $repair->received_by) }}" required />
                                        @if ($errors->has('received_by'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('received_by') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 mb-1">
                                        <label class="form-label">Cash Received</label>
                                        <input type="text" class="form-control" name="cash_received" value="{{ old('cash_received', $repair->cash_received) }}" />
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
                                    <div class="col-md-4 mb-1">
                                        <label class="form-label">Delivered</label>
                                        {{-- <select id="repair-status-filter" class="form-select" name="status">
                                            <option value="">All Status</option>
                                            <option value="in_progress">In Progress</option>
                                            <option value="waiting_for_spare">Waiting for Spare</option>
                                            <option value="returned">Returned</option>
                                            <option value="completed">Completed</option>
                                            <option value="delivered">Delivered</option>
                                        </select> --}}
                                        <input type="checkbox" id="status" name="status" value="delivered">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Update Repair Request</button>
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
