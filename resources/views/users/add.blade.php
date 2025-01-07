@extends('layouts.v2.app')
<link rel="stylesheet" href="{{asset('assets/datatable/responsive.bootstrap5.css') }}">
<link rel="stylesheet" href="{{asset('assets/datatable/datatables.checkboxes.css') }}">
<link rel="stylesheet" href="{{asset('assets/datatable/buttons.bootstrap5.css') }}">
<!-- Row Group CSS -->
<link rel="stylesheet" href="{{asset('assets/datatable/rowgroup.bootstrap5.css') }}">
@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span> Add User</h4>

              <!-- Basic Layout -->
              <div class="row">
                <div class="col-6">
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                      <h5 class="mb-0">Add New User</h5>
                      <!-- <small class="text-muted float-end">Default label</small> -->
                    </div>
                    <div class="card-body">



                      <form method="POST" action="{{ route('users.store') }}">
                      @csrf
                        <div class="mb-3">
                          <label class="form-label">Full Name</label>
                          <input type="text" class="form-control" name="name" value="{{ old('field_name') }}" placeholder="John Doe" />
                          @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Email</label>
                          <div class="input-group">
                                <input type="text" name="email" value="{{ old('email') }}" class="form-control"/>
                              @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @enderror
                          </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                          <label class="form-label">User Type</label>
                        <select name="usertype" id="usertype" class="form-select">
                            @php
                            $typeuser=["superadmin", "user", "manager", "staff", "admin"];
                            @endphp
                            @foreach ($typeuser as $val)
                                <option
                                 @if(old('usertype') == $val) selected @endif
                                 value="{{$val}}">{{$val}}</option>
                            @endforeach
                            <!-- <option value="">Select User Type</option>
                            <option value="user">User</option>
                            <option value="manager">Manager</option>
                            <option value="staff">Staff</option>
                            <option value="admin">Admin</option> -->
                        </select>
                        @if ($errors->has('usertype'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('usertype') }}</strong>
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

                  <a
                    href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/"
                    target="_blank"
                    class="footer-link me-4"
                    >Documentation</a
                  >

                  <a
                    href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                    target="_blank"
                    class="footer-link"
                    >Support</a
                  >
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
@endsection
