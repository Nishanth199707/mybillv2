@extends('layouts.v2.app')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Create Audit Access Request</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('audit-access.store') }}" method="POST">
                                @csrf
                                <!-- Auditor Dropdown -->
                                <div class="mb-3">
                                    <label for="auditor_id" class="form-label">Select Auditor</label>
                                    @if ($loggedInUser->business_category == 'Accounting & CA')
                                        <select name="auditor_id" class="form-select" readonly>
                                            <option value="{{ $auditors->user_id }}">{{ $auditors->company_name }}</option>
                                        </select>
                                    @else
                                        <select name="auditor_id" id="auditor_id" class="form-select"></select>
                                        @error('auditor_id')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                        <!-- Error message container for auditor -->
                                        <div id="auditor-error-message"></div>
                                    @endif
                                </div>

                                <!-- Client Dropdown -->
                                <div class="mb-3">
                                    <label for="target_user_id" class="form-label">Select Client</label>
                                    @if ($loggedInUser->business_category == 'Accounting & CA')
                                        <select name="target_user_id" id="target_user_id" class="form-select"></select>
                                        @error('target_user_id')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    @else
                                        <select name="target_user_id" class="form-select" readonly>
                                            <option value="{{ $users->user_id }}">{{ $users->company_name }}</option>
                                        </select>
                                    @endif
                                    <!-- Error message container for client -->
                                    <div id="client-error-message"></div>
                                </div>

                                <!-- Reason -->
                                <div class="mb-3">
                                    <label for="reason" class="form-label">Reason</label>
                                    <textarea name="reason" id="reason" class="form-control" rows="4">{{ old('reason') }}</textarea>
                                    @error('reason')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Select2 Initialization -->
    <script>
        $(document).ready(function() {
            // Select2 for Auditor Search
            $('#auditor_id').select2({
                placeholder: 'Search for an auditor by User ID',
                minimumInputLength: 1,
                ajax: {
                    url: '/ajax/auditors',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term
                        }; // Send the search term to the server
                    },
                    processResults: function(response) {
                        if (response.message) {
                            // Show the message inline if it's part of the response
                            $('#auditor-error-message').html(`<span class="text-danger">${response.message}</span>`);
                            return {
                                results: []
                            }; // No results, show nothing
                        }

                        // If auditors are found, populate the Select2 dropdown
                        $('#auditor-error-message').html(''); // Clear error message if successful
                        return {
                            results: response.auditors.map(function(item) {
                                return {
                                    id: item.user_id, // Value to submit
                                    text: `${item.company_name} (${item.user_id})` // Displayed text
                                };
                            })
                        };
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
                    data: function(params) {
                        return {
                            search: params.term
                        }; // Send the search term to the server
                    },
                    processResults: function(response) {
                        if (response.message) {
                            // Show the message inline if it's part of the response
                            $('#client-error-message').html(`<span class="text-danger">${response.message}</span>`);
                            return {
                                results: []
                            }; // No results, show nothing
                        }

                        // If clients are found, populate the Select2 dropdown
                        $('#client-error-message').html(''); // Clear error message if successful
                        return {
                            results: response.clients.map(function(item) {
                                return {
                                    id: item.user_id, // Value to submit
                                    text: `${item.company_name} (${item.user_id})` // Displayed text
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
@endsection
