@extends('layouts.v2.app')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span> Manage Sub-Users</h4>

            <!-- Sub-User Management -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Sub-User List</h5>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a class="btn btn-primary btn-sm mb-3" href="{{ route('subuser.create') }}">
                                    <i class="fa fa-plus"></i> Add New Sub-User
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="subuser-table" class="table dt-table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Permissions</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Backdrop -->
        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->

    <script type="text/javascript">
        $(document).ready(function() {
            $('#subuser-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('subuser.index') }}",
                    error: function(xhr, error, code) {
                        console.error('Error fetching data:', error);
                        alert('Failed to load data.');
                    }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Row index
                        },
                        title: '#'
                    },
                    {
                        data: 'name',
                        title: 'name'
                    },
                    {
                        data: 'email',
                        title: 'email'
                    },
                    {
                        data: 'permissions',
                        render: function(data) {
                            try {
                                // Parse JSON data received from the server
                                let permissions = JSON.parse(data);

                                // Format permissions as badges
                                let formattedPermissions = permissions.map(permission => {
                                    return `<span class="badge bg-success">${permission}</span>`;
                                });

                                return formattedPermissions.join(' ') ||
                                    '<span class="badge bg-secondary">No Permissions</span>';
                            } catch (e) {
                                console.error('Error parsing permissions:', e);
                                return '<span class="badge bg-danger">Invalid Permissions</span>';
                            }
                        },
                        title: 'Permissions',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        title: 'Action'
                    }
                ]
            });
        });
    </script>
@endsection
