@extends('layouts.v2.app')
@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card mb-2">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">View Product Category</h5>
                    </div>

                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-1">
                            <!-- Add New Product Category Button aligned to the left -->
                            <a class="btn btn-primary btn-sm" href="{{ route('productcategory.create') }}">
                                <i class="fa fa-arrow-left"></i> Add New Product Category
                            </a>

                            <!-- Add Product Sub Category Button aligned to the right -->
                            <a class="btn btn-primary btn-sm" href="{{ route('productsubcategory.create') }}">
                                <i class="fa fa-arrow-left"></i> Add Product Sub Category
                            </a>
                        </div>

                        <div class="table-responsive">
                            <table id="zero-config" class="table dt-table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
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

    <div class="content-backdrop fade"></div>
</div>
@if(session()->get('user_type') == 'admin')
<input type="hidden" id="category_url" value="{{ route('productcategory.index') }}">
@else
<input type="hidden" id="category_url" value="{{ route('sproductcategory.index') }}">
@endif
<!-- Content wrapper -->

<script type="text/javascript">
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#zero-config')) {
            $('#zero-config').DataTable().destroy();
        }
        var url1 = $("#category_url").val();
        // Initialize DataTable
        $('#zero-config').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url1,
                error: function(xhr, error, code) {
                    console.error('Error fetching data:', error);
                    alert('Failed to load data.');
                }
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.settings._iDisplayStart + meta.row + 1;
                    },
                    title: '#'
                },
                {
                    data: 'name',
                    title: 'Name'
                },
                {
                    data: 'description',
                    title: 'Description'
                },
                {
                    data: 'status',
                    title: 'Status'
                },
                {
                    data: 'action',
                    title: 'Action',
                    orderable: false,
                    searchable: false
                }
            ],
            dom: "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count mb-sm-0 mb-3'i><'dt--pagination'p>>",
            oLanguage: {
                oPaginate: {
                    sPrevious: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    sNext: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                sInfo: "Showing page _PAGE_ of _PAGES_",
                sSearch: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                sSearchPlaceholder: "Search...",
                sLengthMenu: "Results : _MENU_",
            },
            lengthMenu: [7, 10, 20, 50],
            pageLength: 10
        });
    });
</script>
@endsection
