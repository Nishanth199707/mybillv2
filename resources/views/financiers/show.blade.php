@extends('layouts.v2.app')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Financier Details</h5>
                    </div>
                    <div class="card-body">

                        <!-- Tab Navigation -->
                        <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill"
                                    href="#pills-profile" role="tab" aria-controls="pills-profile"
                                    aria-selected="true">Profile</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-transactions-tab" data-bs-toggle="pill"
                                    href="#pills-transactions" role="tab" aria-controls="pills-transactions"
                                    aria-selected="false">Transactions</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pills-ledger-tab" data-bs-toggle="pill" href="#pills-ledger"
                                    role="tab" aria-controls="pills-ledger" aria-selected="false">Ledger</a>
                            </li>

                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <!-- Profile Tab -->
                            <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <section>
                                    <div class="row">
                                        <div class="col-md-12 mb-4">

                                            <p><strong>Financier Name:</strong>
                                                {{ strtoupper($financier->financier_name) }}
                                            </p>
                                            <p><strong>Agent Code:</strong> {{ $financier->agent_code }}</p>
                                            <p><strong>Executive Name:</strong> {{ $financier->executive_name }}</p>
                                            <p><strong>Executive Phone:</strong> {{ $financier->executive_phone }}</p>
                                            <p><strong>Company Email:</strong> {{ $financier->company_email }}</p>
                                        </div>
                                </section>
                            </div>

                            <!-- Transactions Tab -->
                            <div class="tab-pane fade" id="pills-transactions" role="tabpanel"
                                aria-labelledby="pills-transactions-tab">
                                <section>
                                    <h3 class="mt-4">Transaction History</h3>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Party</th>
                                                <th>Loan No</th>
                                                <th>Loan No</th>
                                                <th>Amount Due</th>
                                                <th>Status</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pendings as $payment)
                                            @if($payment->debit != 0)
                                            <tr>
                                                <td>{{ $payment->invoice_date }}</td>
                                                <td>{{ $payment->party }}</td>
                                                <td>{{ $payment->invoice_no }}</td>
                                                <td>{{ $payment->loan_no }}</td>
                                                <td>₹ {{ number_format($payment->debit, 2) }}</td>
                                                <td>{{ $payment->status }}</td>
                                                <td>
                                                    @if($payment->status == "notpaid")
                                                    <form action="{{ route('emi-received.update', $payment->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="sale_id" value="{{ $payment->sale_id }}">
                                                        <input type="hidden" name="financier_id" value="{{ $payment->financier_id }}">
                                                        <input type="hidden" name="loan_no" value="{{ $payment->loan_no }}">
                                                        <input type="hidden" name="credit" value="{{ $payment->debit }}">
                                                        <input type="hidden" name="opening_balance" value="{{ $payment->opening_balance }}">
                                                        {{-- <input type="hidden" name="status" value="{{ $payment->status }}"> --}}
                                                        <button type="submit" class="btn btn-danger ">
                                                            Collected</button>
                                                    </form>
                                                    @else

                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </section>
                            </div>

                            <!-- Ledger Tab -->
                            <div class="tab-pane fade" id="pills-ledger" role="tabpanel"
                                aria-labelledby="pills-ledger-tab">
                                <section>
                                    <h3 class="mt-4">Financier Ledger</h3>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Loan No</th>
                                                <th>Paid Date</th>
                                                <th>Credit</th>
                                                <th>Debit</th>
                                                <th>Closing Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($emiReceiveds as $emiReceived)
                                            <tr>
                                                <td>{{ $emiReceived->loan_no }}</td>
                                                <td>{{ $emiReceived->paid_date }}</td>
                                                <td>₹ {{ number_format($emiReceived->credit, 2) }}</td>
                                                <td>₹ {{ number_format($emiReceived->debit, 2) }}</td>
                                                <td>₹ {{ number_format($emiReceived->closing_balance, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </section>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
