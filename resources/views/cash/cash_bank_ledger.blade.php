@extends('layouts.v2.app')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Cash Ledger</h5>
                        <div>
                            <button id="print-ledger" class="btn btn-outline-secondary me-2">Print</button>
                            <button id="download-pdf" class="btn btn-outline-primary">Download PDF</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('sales.cash_received_ledger') }}" class="row mb-4">
                            <div class="col-md-3"></div>
                            <div class="col-md-2">
                                <label for="from_date" class="form-label">From Date</label>
                                <input type="date" id="from_date" name="from_date" class="form-control"
                                    value="{{ request('from_date') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="to_date" class="form-label">To Date</label>
                                <input type="date" id="to_date" name="to_date" class="form-control"
                                    value="{{ request('to_date') }}">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Filter</button>
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <a href="{{ route('sales.cash_received_ledger') }}" class="btn btn-danger w-50">Clear</a>
                            </div>
                        </form>
                        <div class="mt-3 text-end">
                            <h4><strong>Total Cash:</strong> ₹ {{ number_format($totalCashReceived, 2) }}</h4>
                        </div>
                        <div id="ledger-table-wrapper">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Invoice No</th>
                                        <th>Party Name</th>
                                        <th>Debit</th>
                                        <th>Credit</th>
                                        <th>Closing Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $total = 0;
                                    @endphp
                                    @foreach ($cashReceivedLedger as $transaction)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d M, Y') }}</td>
                                        <td>{{ $transaction->invoice }}</td>
                                        <td>@if(!empty($transaction->party_name)){{ $transaction->party_name }}@else{{ 'Expense' }} @endif</td>
                                        <td>{{ $transaction->debit }}</td>
                                        <td>{{ $transaction->credit }}</td>
                                        @php
                                        $line_total = $transaction->credit - $transaction->debit; // Correct calculation
                                        $total += $line_total; // Correct assignment
                                        @endphp
                                        <td>₹ {{ number_format($total, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.24/jspdf.plugin.autotable.min.js"></script>
<script>
    // Print Ledger
    document.getElementById('print-ledger').addEventListener('click', function () {
        const printContents = document.getElementById('ledger-table-wrapper').innerHTML;
        const originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    });

    document.getElementById('download-pdf').addEventListener('click', function () {
        const { jsPDF } = window.jspdf; // Ensure jsPDF is loaded
        const doc = new jsPDF();

        // Add Title
        doc.text('Cash Ledger Report', 14, 10);

        // Prepare Table Data
        const data = @json($cashReceivedLedger).map((transaction, index) => [
            index + 1,
            transaction.invoice,
            transaction.date,
            transaction.party_name,
            `₹ ${parseFloat(transaction.amount).toFixed(2)}`
        ]);

        // Add Table
        doc.autoTable({
            head: [['#', 'Invoice No', 'Date', 'Party Name', 'Cash Received']],
            body: data,
            startY: 20,
            styles: { overflow: 'linebreak', fontSize: 10 },
            theme: 'grid',
        });

        // Save PDF
        doc.save('cash_ledger_report.pdf');
    });
</script>
@endpush

@endsection
