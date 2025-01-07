@extends('layouts.v2.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Cash Received</h5>
                        </div>
                        <div class="card-body">
                            <!-- Date Filter Form -->
                            <form method="GET" action="{{ route('repairs.cashReceived') }}" class="row mb-4">
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
                                   
                                <div class="col-md-3 d-flex align-items-end"><a href="{{route('repairs.cashReceived')}}" class="btn btn-danger w-50">Clear</a></div>

                            </form>

                            <div class="mt-3 text-end">
                                <h5>Total Cash Received: ₹ {{ number_format($totalCashReceived, 2) }}</h5>
                            </div>
                            
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Service No</th>
                                        <th>Customer Name</th>
                                        <th>Cash Received</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cashReceived as $index => $transaction)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $transaction->service_no }}</td>
                                            <td>{{ $transaction->customer_name }}</td>
                                            <td>₹ {{ number_format(floatval($transaction->cash_received), 2) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d M, Y') }}</td>
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
