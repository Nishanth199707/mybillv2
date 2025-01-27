@extends('layouts.v2.app')

@section('content')

@php
use App\Models\Business;
use App\Models\SubUser;
use App\Models\User;

$user_id = session('user_id');
$subuser = session('sub_user');

if ($subuser != null) {
    $authUser = User::select('*')->where('id', $subuser)->first();
} else {
    $authUser = User::select('*')->where('id', $user_id)->first();
}
$business = Business::select('*')->where('user_id', $user_id)->first();
$permission = SubUser::select('permissions')->where('user_id', $user_id)->first();
if(!empty($permissions)){
    $permissionsd = json_decode($permission->permissions);
}else{
    $permissionsd ="";
}
// dd($permission);
@endphp
        <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <div class="col-lg-12 mb-4 order-0">
                        <div class="row">
                            <div class="col-md-12 mb-4">
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

                                        @if($subuser !== null && $permissionsd && isset($permissionsd->payment) && $permissionsd->payment == 'true')
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
                                        @endif
                                     <a href="{{ route('partypayment.addPayment') }}"
                                        class="btn mb-2 align-items-center rounded-pill" style="background-color: cadetblue;color:#ffff;">
                                        <i class="bx bx-plus me-1"></i> Add Product
                                    </a>
                                        <a href="{{ route('party.create') }}"
                                            class="btn btn-secondary mb-2 align-items-center rounded-pill">
                                            <i class="bx bx-plus me-1"></i> Add Party
                                        </a>
                                        <a href="{{ route('repairs.create') }}"
                                            class="btn btn-info mb-2 align-items-center rounded-pill">
                                            <i class="bx bx-plus me-1"></i> Add Service
                                        </a>
                                        <a href="{{ route('expense.category') }}"
                                            class="btn btn-dark mb-2 align-items-center rounded-pill">
                                            <i class="bx bx-plus me-1"></i> Add Expense
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
                </div>
            </div>
@endsection
