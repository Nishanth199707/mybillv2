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
                            <a class="btn btn-primary btn-sm mb-3" href="{{ route('subusers.create') }}">
                                <i class="fa fa-plus"></i> Add New Sub-User
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Permissions</th>
                                    <th>Parent User</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- DataTable dynamically renders rows -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Backdrop -->
    <div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->

<!-- DataTable Script -->
<script type="text/javascript">
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('subusers.index') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { 
                    data: 'permissions', 
                    name: 'permissions', 
                    render: function(data) {
                        return JSON.stringify(data); // Show permissions in JSON format
                    }
                },
                { 
                    data: 'parent_user', 
                    name: 'parent_user', 
                    render: function(data) {
                        return data.name; // Render parent user's name
                    }
                },
                { 
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false 
                },
            ],
            language: {
                "processing": "<span>Loading...</span>",
                "emptyTable": "No sub-users available"
            }
        });
    });
</script>

@endsection
