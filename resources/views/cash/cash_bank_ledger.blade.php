@extends('layouts.v2.app')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Cash Ledger</h5>
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

                            <div class="col-md-3 d-flex align-items-end"><a href="{{route('sales.cash_received_ledger')}}" class="btn btn-danger w-50">Clear</a></div>

                        </form>
                        <div class="mt-3 text-end">
                            <h4><strong>Total Cash:</strong> ₹ {{ number_format($totalCashReceived, 2) }}</h4>
                        </div>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Invoice No</th>
                                    <th>Date</th>
                                    <th>Party Name</th>
                                    <th>Cash Received</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cashReceivedLedger as $transaction)
                                <tr>
                                    <td>{{ $transaction->invoice }}</td>
                                    <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d M, Y') }}</td>
                                    <td>{{ $transaction->party_name }}</td>
                                    <td>₹ {{ number_format($transaction->amount, 2) }}</td>
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
@endsection