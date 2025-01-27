@extends('layouts.v2.app')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Basic Layout -->
            <div class="row">
                <div class="col-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Create Audit Access Request</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('audit-access.store') }}" method="POST">
                                @csrf

                                <!-- Auditor Dropdown -->
                                <div class="mb-3">
                                    @if ($loggedInUser->business_category == 'Accounting & CA')
                                        <label for="auditor_id" class="form-label">Select Auditor</label>
                                        <select name="auditor_id" id="auditor_id" class="form-select" disabled>

                                            <option value="{{ $auditors->user_id }}">{{ $auditors->company_name }}</option>
                                        </select>
                                    @else
                                        <label for="auditor_id" class="form-label">Select Auditor</label>
                                        <select name="auditor_id" id="auditor_id" class="form-select"></select>
                                        @if ($errors->has('auditor_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('auditor_id') }}</strong>
                                            </span>
                                        @endif
                                    @endif
                                </div>

                                <!-- Client Dropdown -->
                                <div class="mb-3">
                                    @if ($loggedInUser->business_category == 'Accounting & CA')
                                        <label for="target_user_id" class="form-label">Select Client</label>
                                        <select name="target_user_id" id="target_user_id" class="form-select"></select>
                                        @if ($errors->has('target_user_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('target_user_id') }}</strong>
                                            </span>
                                        @endif
                                    @else
                                        <label for="target_user_id" class="form-label">Select Client</label>
                                        <select name="target_user_id" id="target_user_id" class="form-select" disabled>
                                            <option value="{{ $users->user_id }}">{{ $users->company_name }}</option>
                                        </select>
                                        @if ($errors->has('target_user_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('target_user_id') }}</strong>
                                            </span>
                                        @endif
                                    @endif
                                </div>


                                <div class="mb-3">
                                    <label for="reason" class="form-label">Reason</label>
                                    <textarea name="reason" id="reason" class="form-control" rows="4" placeholder="Enter the reason">{{ old('reason') }}</textarea>
                                    @if ($errors->has('reason'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('reason') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div style="text-align: right;">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
        $(document).ready(function () {
            // Select2 for Auditor Search
            $('#auditor_id').select2({
                placeholder: 'Search for an auditor by User ID',
                minimumInputLength: 1,
                ajax: {
                    url: '/ajax/auditors',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term // Send search term to the server
                        };
                    },
                    processResults: function (response) {
                        if (response.auditors && response.auditors.length > 0) {
                            return {
                                results: response.auditors.map(item => ({
                                    id: item.user_id, // Value to be submitted
                                    text: `${item.company_name} (${item.user_id})` // Display text
                                }))
                            };
                        } else {
                            // Handle "No auditors found" message
                            alert(response.message || 'No results found.');
                            return {
                                results: []
                            };
                        }
                    },
                    cache: true
                }
            });
    
            // Select2 for Client Search
            $('#target_user_id').select2({
                placeholder: 'Search for a client by User ID',
                minimumInputLength: 1,
                ajax: {
                    url: '/ajax/clients',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term // Send search term to the server
                        };
                    },
                    processResults: function (response) {
                        if (response.clients && response.clients.length > 0) {
                            return {
                                results: response.clients.map(item => ({
                                    id: item.user_id, // Value to be submitted
                                    text: `${item.company_name} (${item.user_id})` // Display text
                                }))
                            };
                        } else if (response.message) {
                            // Handle "An auditor is already assigned" message
                            alert(response.message);
                            return {
                                results: []
                            };
                        } else {
                            // Default fallback for empty responses
                            alert('No results found.');
                            return {
                                results: []
                            };
                        }
                    },
                    cache: true
                }
            });
        });
    </script>
    



@endsection
