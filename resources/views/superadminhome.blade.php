@extends('layouts.v2.app')

@section('content')
    <!-- Content wrapper -->

    @if (!$activePlan)
        {{-- Redirect user to the payment form --}}
        <script>
            window.location.href = "{{ route('front.payment_home') }}";
        </script>
    @else
        <div class="content-wrapper">
            <!-- Content -->
            <div class="container-xxl flex-grow-1 container-p-y">
                <div class="row">
                    <div class="col-lg-12 mb-4 order-0">
                        <div class="row">

                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Congratulations &nbsp;&nbsp;
                                            @if (Auth::user())
                                                {{ Auth::user()->name }}
                                            @endif🎉
                                        </h5>
                                        <p class="mb-4">
                                            You have done <span class="fw-medium">72%</span> more sales today.
                                            @if ($business == null)
                                                <br>
                                                <a href="{{ route('business.create') }}"
                                                    class="btn btn-outline-primary">Complete Your Profile</a>
                                            @endif
                                            <br>

                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Add Sale Button -->
                                        <a href="{{ route('sale.create') }}"
                                            class="btn btn-primary mb-2 align-items-center rounded-pill me-2">
                                            <i class="bx bx-plus me-1"></i>Add Sale
                                        </a>
                                        <!-- Add Purchase Button -->
                                        <a href="{{ route('purchase.create') }}"
                                            class="btn btn-danger mb-2 align-items-center rounded-pill">
                                            <i class="bx bx-plus me-1"></i> Add Purchase
                                        </a>

                                        <!-- Add Receipt Button -->
                                        <a href="{{ route('partypayment.receivePayment') }}"
                                            class="btn btn-success mb-2 align-items-center rounded-pill me-2">
                                            &nbsp; <i class="bx bx-plus me-1"></i>Add Receipt &nbsp;
                                        </a>
                                        <!-- Add Payment Button -->
                                        <a href="{{ route('partypayment.addPayment') }}"
                                            class="btn btn-warning mb-2 align-items-center rounded-pill">
                                            <i class="bx bx-plus me-1"></i> Add Payment
                                        </a>

                                        <a href="{{ route('product.index') }}"
                                            style="background-color:#A02334; border:none; box-shadow:none;"
                                            class="btn btn-secondary mb-2 align-items-center rounded-pill">
                                            <i class="bx bx-plus me-1"></i> View Product</a>
                                        @if ($business->business_category == 'Accounting & CA')
                                            <a href="{{ route('audit-access.client-list') }}"
                                                style=" border:none; box-shadow:none;"
                                                class="btn btn-success mb-2 align-items-center rounded-pill">

                                                My Clients
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                    <br>
                    <div class="row">

                        {{-- <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}"
                                                alt="chart success" class="rounded" />
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="fw-medium d-block mb-1">Profit</span>
                                    <h3 class="card-title mb-2">$12,628</h3>
                                    <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +72.80%</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('assets/img/icons/unicons/wallet-info.png') }}"
                                                alt="Credit Card" class="rounded" />
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="fw-medium d-block mb-1">Sales</span>
                                    <h3 class="card-title text-nowrap mb-1">$4,679</h3>
                                    <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4"></div>

                    </div>
                </div> --}}

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Today Collection</h5>
                                    @if ($payments->isEmpty())
                                        <p>No payments found for today's collection.</p>
                                    @else
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Party Name</th>
                                                    <th>Collection Date</th>
                                                    <th>Amount</th>
                                                    <th>Cheque / Ref No</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($payments as $payment)
                                                    <tr>
                                                        <td>{{ $payment->party_name }}</td>
                                                        <td>{{ $payment->collection_date }}</td>
                                                        <td>{{ number_format($payment->credit, 2) }}</td>
                                                        <td>{{ $payment->transaction_number }}</td>
                                                        <td>
                                                            <form action="{{ route('partypayment.ajaxsave') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="paymentid"
                                                                    value="{{ $payment->id }}">
                                                                <input type="hidden" name="partyid"
                                                                    value="{{ $payment->party_id }}">
                                                                <input type="hidden" name="transaction_type"
                                                                    value="{{ $payment->transaction_type }}">
                                                                <input type="hidden" name="cheque_amount"
                                                                    value="{{ $payment->credit }}">
                                                                <input type="hidden" name="transaction_number"
                                                                    value="{{ $payment->transaction_number }}">
                                                                <input type="hidden" name="collection_date"
                                                                    value="{{ $payment->collection_date }}">
                                                                <button type="submit"
                                                                    class="btn btn-primary">Collected</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('assets/img/icons/unicons/paypal.png') }}" alt="Payments"
                                                class="rounded" />
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" id="cardOpt3"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="fw-medium d-block mb-1">Payments</span>
                                    <h3 class="card-title mb-2">$2,456</h3> <!-- Adjust this value as needed -->
                                    <small class="text-danger fw-medium"><i class="bx bx-down-arrow-alt"></i>
                                        -14.82%</small> <!-- Adjust this value as needed -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="avatar flex-shrink-0">
                                            <img src="{{ asset('assets/img/icons/unicons/cc-primary.png') }}"
                                                alt="Transactions" class="rounded" />
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn p-0" type="button" id="cardOpt6"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="fw-medium d-block mb-1">Transactions</span>
                                    <h3 class="card-title text-nowrap mb-1">$14,857</h3>
                                    <!-- Adjust this value as needed -->
                                    <small class="text-success fw-medium"><i class="bx bx-up-arrow-alt"></i>
                                        +28.14%</small> <!-- Adjust this value as needed -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4"></div>
                    </div>
                </div>

                <div class="col-lg-5">

                </div>
            </div> --}}

                </div>
            </div>
    @endif
@endsection
