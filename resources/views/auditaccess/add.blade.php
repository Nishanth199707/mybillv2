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
                        <h5 class="mb-0">Create Audit Access Request</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('audit-access.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="auditor_id" class="form-label">Select Auditor</label>
                                <select name="auditor_id" id="auditor_id" class="form-select">
                                    @foreach ($auditors as $auditor)
                                        <option value="{{ $auditor->user_id }}">{{ $auditor->company_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('auditor_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('auditor_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="target_user_id" class="form-label">Select Client</label>
                                <select name="target_user_id" id="target_user_id" class="form-select">
                                    @foreach ($users as $user)
                                        <option value="{{ $user->user_id }}">{{ $user->company_name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('target_user_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('target_user_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="reason" class="form-label">Reason</label>
                                <textarea name="reason" id="reason" class="form-control" rows="4" placeholder="Enter the reason">{{ old('reason') }}</textarea>
                                @if ($errors->has('reason'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('reason') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div style="text-align: right;">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
