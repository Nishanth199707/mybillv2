@extends('layouts.v2.app')

@section('content')
<br>
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">E-Way Bill Setup</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 row">
                                <div class="col-md-3">
                                    <label class="form-label">Password</label>
                                    <div>
                                        <input type="password" class="form-control" id="e_password" name="e_password" />
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                   <button type="submit" class="btn btn-primary">Check</button>
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
@endsection
