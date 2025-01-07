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
                            <h5 class="mb-0">Add Payment</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('partypayment.ajaxsave') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="partyid" class="form-label">Party Name</label>
                                    <select class="form-control" id="partyid" name="partyid" required>
                                        <option value="">Select Party</option>
                                        @foreach ($data as $party)
                                            <option value="{{ $party->id }}">{{ $party->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" name="paid_date" id="date" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" name="cash_received" id="amount" required>
                                </div>
                                <div class="mb-3">
                                    <label for="modeOfPayment" class="form-label">Mode of Payment</label>
                                    <select id="modeOfPayment" name="mode_of_payment" class="form-select" required>
                                        <option value="">Select</option>
                                        <option value="cash">Cash</option>
                                        <option value="upi">UPI</option>
                                        <option value="bank_transfer">Bank Transfer</option>
                                        <option value="cheque">Cheque</option>
                                        <option value="scheme">Scheme</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                         <label for="remark" class="form-label">Remark</label>
                                         <input type="text" class="form-control" id="remark" name="remark">
                                </div>
                                

                                <div class="mb-3" id="transactionNumberContainer" style="display: none;">
                                    <label for="transactionNumber" class="form-label">Transaction Number</label>
                                    <input type="text" class="form-control" name="transaction_number" id="transactionNumber">
                                </div>

                                <div class="mb-3" id="chequeFields" style="display: none;">
                                    <div class="row">
                                        <div class="col">
                                            <label for="chequeNumber" class="form-label">Cheque Number</label>
                                            <input type="text" class="form-control" name="transaction_number" id="chequeNumber">
                                        </div>
                                        <div class="col">
                                            <label for="collectionDate" class="form-label">Collection Date</label>
                                            <input type="date" class="form-control" name="collection_date" id="collectionDate">
                                        </div>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                         <button type="submit" class="btn btn-primary" id="saveBtn">Submit</button>
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
@endsection

@push('scripts')
    <script>
        document.getElementById('modeOfPayment').addEventListener('change', function() {
            const transactionNumberContainer = document.getElementById('transactionNumberContainer');
            const chequeFields = document.getElementById('chequeFields');
            if (this.value === 'cheque') {
                transactionNumberContainer.style.display = 'none'; // Hide transaction number
                chequeFields.style.display = 'block'; // Show cheque fields
            } else {
                chequeFields.style.display = 'none'; // Hide cheque fields
                if (this.value !== 'cash') {
                    transactionNumberContainer.style.display = 'block'; // Show transaction number for non-cash payments
                } else {
                    transactionNumberContainer.style.display = 'none'; // Hide transaction number for cash
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Set today's date as the default value
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('date').value = today;
        });
    </script>
@endpush
