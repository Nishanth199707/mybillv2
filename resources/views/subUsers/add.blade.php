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
                                        placeholder="John Doe" />
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
                                    <label class="form-label">Permissions</label>

                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[service]" id="service" value="true"
                                            class="form-check-input">
                                        <label for="service" class="form-check-label">Service</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[cash_bank]" id="cash_bank" value="true"
                                            class="form-check-input">
                                        <label for="cash_bank" class="form-check-label">Cash & Bank</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[payment]" id="payment" value="true"
                                            class="form-check-input">
                                        <label for="payment" class="form-check-label">Payments</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[report]" id="report" value="true"
                                            class="form-check-input">
                                        <label for="report" class="form-check-label">Reports</label>
                                    </div>
                                    @if ($errors->has('permissions'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('permissions') }}</strong>
                                        </span>
                                    @endif
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
