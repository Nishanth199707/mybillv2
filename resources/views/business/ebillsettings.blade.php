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
                    <?php
                    $gst_response = json_decode($business->auth_response);
                                                    ?>
                    @if ($business->gst_auth != 1 &&  $gst_response->date != date('d-m-Y') )
                    <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-md-3">
                                    <label class="form-label">Password</label>
                                    <div>
                                        <input type="hidden" name="gst_id" id="gst_id" value="{{ $business->gstin }}">
                                        <input type="hidden" name="business_id" id="business_id" value="{{ $business->id }}">
                                        <input type="password" class="form-control" id="e_password" name="e_password" />
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                        <button id="check_athu" class="btn btn-primary">Check</button>
                                </div>
                            </div>
                    </div>
                    @else
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-md-5">
                                <span class="text-success">GST Authentication is done</span><br>
                                <span>GSTIN: {{ $business->gstin }}</span><br>
                                <span >User Name: {{ $gst_response->header->username }}</span><br>
                                <span>IP Address: {{ $gst_response->header->ip_address }}</span><br>
                                <span>GST Authentication Date: {{ $gst_response->date }}</span><br>
                                <span>Responce Status: {{ $gst_response->status_desc }}</span><br>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    <!-- / Content -->
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        $('#check_athu').click(function() {
            var e_password = $('#e_password').val();
            var gst_id  = $('#gst_id').val();
            var business_id  = $('#business_id').val();
            $.ajax({
                url: "{{ url('gst-auth') }}",
                type: 'GET',
                data: {
                    e_password: e_password,
                    business_id: business_id,
                    gst_id: gst_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    var response = JSON.parse(data);
                    // console.log(response.status_cd);
                    if (response.status_cd == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Authentication Succeeded'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Authentication Failed'
                        });
                    }
                }
            });
        });
    });
</script>
@endsection
