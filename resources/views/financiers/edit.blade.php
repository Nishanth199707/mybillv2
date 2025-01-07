@extends('layouts.v2.app')

<link rel="stylesheet" href="{{ asset('assets/datatable/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatable/datatables.checkboxes.css') }}">
<link rel="stylesheet" href="{{ asset('assets/datatable/buttons.bootstrap5.css') }}">
<!-- Row Group CSS -->
<link rel="stylesheet" href="{{ asset('assets/datatable/rowgroup.bootstrap5.css') }}">

@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span> Edit Financier</h4> --}}

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-6">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Edit Financier</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('financiers.update', $financier->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Financier Name</label>
                                <input type="text" class="form-control" name="financier_name" value="{{ $financier->financier_name }}" placeholder="Financier Name" />
                                @if ($errors->has('financier_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('financier_name') }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Agent Code</label>
                                <input type="text" class="form-control" name="agent_code" value="{{ $financier->agent_code }}" placeholder="Agent Code" />
                                @if ($errors->has('agent_code'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('agent_code') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Executive Name</label>
                                <input type="text" class="form-control" name="executive_name" value="{{ $financier->executive_name }}" placeholder="Executive Name" />
                                @if ($errors->has('financier_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('executive_name') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Executive Phone</label>
                                <input type="text" class="form-control" name="executive_phone" value="{{ $financier->executive_phone }}" placeholder="Executive Phone" />
                                @if ($errors->has('executive_phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('executive_phone') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Company Email</label>
                                <input type="text" class="form-control" name="company_email" value="{{ $financier->company_email }}" placeholder="Company Email" />
                                @if ($errors->has('company_email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('company_email') }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <!-- Footer -->
    <footer class="content-footer footer bg-footer-theme">
        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
            <div class="mb-2 mb-md-0">
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                , made with ❤️ by
                <a href="https://themeselection.com" target="_blank" class="footer-link fw-medium">ThemeSelection</a>
            </div>
            <div class="d-none d-lg-inline-block">
                <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>
                <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/" target="_blank" class="footer-link me-4">Documentation</a>
                <a href="https://github.com/themeselection/sneat-html-admin-template-free/issues" target="_blank" class="footer-link">Support</a>
            </div>
        </div>
    </footer>
    <!-- / Footer -->

    <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
@endsection
