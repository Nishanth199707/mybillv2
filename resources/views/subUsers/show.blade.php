@extends('layouts.v2.app')

@section('content')

<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span> Add User</h4>

              <!-- Basic Layout -->
              <div class="row">
                <div class="col-12">
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                      <h5 class="mb-0">Add New User</h5>
                      <!-- <small class="text-muted float-end">Default label</small> -->
                    </div>
                    <div class="card-body">

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a class="btn btn-primary btn-sm" href="{{ route('users.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong> <br/>
                                    {{ $user->name }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                                <div class="form-group">
                                    <strong>Email:</strong> <br/>
                                    {{ $user->email }}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-2">
                                <div class="form-group">
                                    <strong>User Type</strong> <br/>
                                    {{ $user->usertype }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                </div>
                </div>


  </div>
@endsection
