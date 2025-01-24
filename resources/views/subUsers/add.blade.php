@extends('layouts.v2.app')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Basic Layout -->
            <div class="row">
                <div class="col-6">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Add Sub-User</h5>
                        </div>
                        <div class="card-body">

                            <form method="POST" action="{{ route('subuser.store') }}">
                                @csrf

                                <!-- Sub-User Name -->
                                <div class="mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                        placeholder=" " />
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- Sub-User Email -->
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <div class="input-group">
                                        <input type="text" name="email" value="{{ old('email') }}"
                                            class="form-control" />
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Sub-User Password -->
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required>
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- User Type -->
                                <div class="mb-3">
                                    <label class="form-label">User Type</label>
                                    <select class="form-select" name="user_type">

                                        <option value="staff" {{ old('user_type') == 'staff' ? 'selected' : '' }}>Staff
                                        </option>
                                    </select>
                                    @if ($errors->has('user_type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('user_type') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- Permissions -->
                                <div class="mb-3">
                                    <h4>Permissions</h4>

                                    <!-- Party Permission -->
                                    {{-- <div class="form-check">
                                        <input type="checkbox" name="permissions[party]" id="party" value="true" class="form-check-input">
                                        <label for="party" class="form-check-label">Party</label>
                                    </div> --}}

                                    <!-- Product Permission -->
                                    {{-- <div class="form-check">
                                        <input type="checkbox" name="permissions[product]" id="product" value="true" class="form-check-input">
                                        <label for="product" class="form-check-label">Product</label>
                                    </div> --}}

                                    <!-- Purchase Permission -->
                                    {{-- <div class="form-check">
                                        <input type="checkbox" name="permissions[purchase]" id="purchase" value="true" class="form-check-input">
                                        <label for="purchase" class="form-check-label">Purchase</label>
                                    </div> --}}

                                    <!-- Sale Permission -->
                                    {{-- <div class="form-check">
                                        <input type="checkbox" name="permissions[sale]" id="sale" value="true" class="form-check-input">
                                        <label for="sale" class="form-check-label">Sale</label>
                                    </div> --}}

                                    <!-- Quotation Permission -->
                                    {{-- <div class="form-check">
                                        <input type="checkbox" name="permissions[quotation]" id="quotation" value="true" class="form-check-input">
                                        <label for="quotation" class="form-check-label">Quotation</label>
                                    </div> --}}

                                    <!-- Payment Permission -->
                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[payment]" id="payment" value="true" class="form-check-input">
                                        <label for="payment" class="form-check-label">Payment</label>
                                    </div>

                                    <!-- Expense Permission -->
                                    {{-- <div class="form-check">
                                        <input type="checkbox" name="permissions[expense]" id="expense" value="true" class="form-check-input">
                                        <label for="expense" class="form-check-label">Expense</label>
                                    </div> --}}


                                      <!-- Service Permission -->
                                      <div class="form-check">
                                        <input type="checkbox" name="permissions[service]" id="service" value="true" class="form-check-input">
                                        <label for="service" class="form-check-label">Service Cash</label>
                                    </div>
                                    <!-- Cash & Bank Permission -->
                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[cash_bank]" id="cash_bank" value="true" class="form-check-input">
                                        <label for="cash_bank" class="form-check-label">Cash & Bank</label>
                                    </div>

                                    <!-- Report Permission -->
                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[report]" id="report" value="true" class="form-check-input">
                                        <label for="report" class="form-check-label">Report</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[settings]" id="settings" value="true" class="form-check-input">
                                        <label for="settings" class="form-check-label">Settings</label>
                                    </div>

                                    <!-- Setting Permission -->
                                    {{-- <div class="form-check">
                                        <input type="checkbox" name="permissions[setting]" id="setting" value="true" class="form-check-input">
                                        <label for="setting" class="form-check-label">Setting</label>
                                    </div> --}}

                                    <!-- Finance Permission -->
                                    {{-- <div class="form-check">
                                        <input type="checkbox" name="permissions[finance]" id="finance" value="true" class="form-check-input">
                                        <label for="finance" class="form-check-label">Finance</label>
                                    </div> --}}
                                </div>

                                <button type="submit" class="btn btn-primary">Save Sub-User</button>
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
