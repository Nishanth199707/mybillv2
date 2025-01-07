@extends('salayouts.v2.app')
@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

            <!-- Basic Layout -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">User</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="zero-config" class="table table-bordered dt-table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->

    <script type="text/javascript">
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#zero-config')) {
                $('#zero-config').DataTable().destroy();
            }

            // Initialize DataTable
            var table = $('#zero-config').DataTable({
                searching: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('users.index') }}",
                    type: 'GET',
                },
                columns: [
                    {
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Render row index (starting from 1)
                        },
                        title: '#',
                    },
                    {
                        data: 'name',
                        title: 'Name'
                    },
                    {
                        data: 'email',
                        title: 'Email'
                    },
                    {
                        data: 'is_active',
                        title: 'Status',
                        render: function(data, type, row) {
                            return data === 1 ?
                                '<button class="btn btn-success btn-sm status-toggle" data-id="' + row.id + '" data-status="1">Active</button>' :
                                '<button class="btn btn-danger btn-sm status-toggle" data-id="' + row.id + '" data-status="0">Inactive</button>';
                        }
                    }
                ],
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                "oLanguage": {
                    "oPaginate": {
                        "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                        "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                    },
                    "sInfo": "Showing page _PAGE_ of _PAGES_",
                    "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                    "sSearchPlaceholder": "Search...",
                    "sLengthMenu": "Results :  _MENU_",
                },
                "stripeClasses": [],
                "lengthMenu": [7, 10, 20, 50],
                "pageLength": 10
            });

            $(document).on('click', '.status-toggle', function() {
                var button = $(this);
                var userId = button.data('id');
                var currentStatus = button.data('status');
                var newStatus = (currentStatus === 1) ? 0 : 1; 
                
        //    alert(currentStatus);

                $.ajax({
                    url: '/wp-admin/users/' + userId + '/status', 
                    type: 'post',
                    data: {
                        _token: "{{ csrf_token() }}", 
                        status: currentStatus
                    },
                    success: function(response) {
                        alert("Are you Sure Want to Change the Status!");
                        // console.log(response);
                        if (response.success) {
                            if (response.status === 1) {
                                button.removeClass('btn-danger').addClass('btn-success');
                                button.text('Active');
                                button.data('status', 1);
                            } else {
                                button.removeClass('btn-success').addClass('btn-danger');
                                button.text('Inactive');
                                button.data('status', 0);
                            }
                        } else {
                            alert('Error updating status.');
                        }
                    },
                    error: function() {
                        alert('Error updating status.');
                    }
                });
            });
        });
    </script>
@endsection
