@extends('layouts.v2.app')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-12">
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                      <h5 class="mb-0">Create Task</h5>
                      <!-- <small class="text-muted float-end">Default label</small> -->
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('task.store') }}" enctype="multipart/form-data">
                            @csrf
                            @if(empty($task))
                            <input type="hidden" name="action_fun" value="add">
                            @else
                            <input type="hidden" name="action_fun" value="update">
                            <input type="hidden" name="id" value="{{$task->id}}">
                            @endif
                            <div class="row">
                                <div class="col-md-2 mb-2">
                                    <label class="form-label">Party Name</label>
                                            <select name="party" id="party" class="form-select expence_type">
                                                <option value="">Select Party</option>
                                                @foreach ($parties as $party)
                                                    <option value="{{ $party->id }}"  @if(!empty($task)) @if(optional($task)->party == $party->id) selected @endif @endif >{{ $party->name }}</option>
                                                @endforeach
                                            </select>
                                     @if ($errors->has('party'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('party') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class=" col-md-2 mb-3">
                                    <label class="form-label">Product</label>
                                    <select name="product" id="product" class="form-select expence_type">
                                        <option value="">Select Product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}"  @if(!empty($task)) @if(optional($task)->product == $product->id) selected @endif @endif >{{ $product->item_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('product'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('product') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class=" col-md-2 mb-3">
                                    <label class="form-label">User</label>
                                    <select name="user" id="user" class="form-select expence_type">
                                        <option value="All">All User</option>
                                        @foreach ($sub_user as $user)
                                            <option value="{{ $user->id }}"  @if(!empty($task)) @if(optional($task)->user == $user->id) selected @endif @endif >{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('product'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('product') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-2 mb-2">
                                    <label class="form-label">Status</label>
                                        <select name="status" required id="status" class="form-select expence_type">

                                            @foreach ($status as $statuses)
                                                <option @if(!empty($task)) @if(optional($task)->status == $statuses->name) selected @endif @endif
                                                    value="{{ $statuses->name }}">{{ $statuses->name }}</option>
                                            @endforeach
                                            <option value="complete">complete</option>
                                        </select>
                                        @if ($errors->has('status'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('status') }}</strong>
                                            </span>
                                        @enderror
                                </div>
                                <div class=" col-md-2 mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea class="form-control" name="description"  rows="2" cols="5" placeholder="Enter the description">@if(!empty($task)) {{ optional($task)->description }} @endif</textarea>
                                    @if ($errors->has('description'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                <div class=" col-md-2" style="display: flex;justify-content: center;align-items: center;">
                                <button type="submit" class="btn btn-primary"> @if(empty($task)) Add @else Update @endif </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-header  mb-3">
                        <h5 class="mb-0">Task List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="zero-config" class="table dt-table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Party Name</th>
                                        <th>Product Name</th>
                                        <th>User Name</th>
                                        <th>Discription</th>
                                        <th>Status</th>
                                        <th>Date</th>
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
            <!-- / Content -->

            <div class="content-backdrop fade"></div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        if ($.fn.DataTable.isDataTable('#zero-config')) {
            $('#zero-config').DataTable().destroy();
        }
        // Initialize DataTable
        $('#zero-config').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('task.index') }}",
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
                    title: 'Party Name'
                },
                {
                    data: 'item_name',
                    title: 'Product Name'
                },
                {
                    data: 'user',
                    title: 'User Name'
                },
                {
                    data: 'description',
                    title: 'Discription'
                },
                {
                    data: 'status',
                    title: 'status',
                },
                {
                    data: 'updated_at',
                    title: 'Date',
                    render: function(data) {
                        // Format the date using JavaScript
                        const date = new Date(data);
                        const formattedDate = date.toLocaleDateString('en-US', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                        });
                        return formattedDate;
                    }
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
<script type="text/javascript">
    $(document).ready(function() {

        if ($.fn.DataTable.isDataTable('#zero-config')) {
            $('#zero-config').DataTable().destroy();
        }
        // Initialize DataTable
        $('#zero-config1').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('task.copindex') }}",
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
                    title: 'Party Name'
                },
                {
                    data: 'item_name',
                    title: 'Product Name'
                },
                {
                    data: 'user',
                    title: 'User Name'
                },
                {
                    data: 'status',
                    title: 'Status'
                },
                {
                    data: 'description',
                    title: 'Discription'
                },

                {
                    data: 'updated_at',
                    title: 'Date',
                    render: function(data) {
                        // Format the date using JavaScript
                        const date = new Date(data);
                        const formattedDate = date.toLocaleDateString('en-US', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric',
                        });
                        return formattedDate;
                    }
                },

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
<script>
    $(document).ready(function() {
        $('.expence_type').select2();
    });
</script>
<script>
// Update status on change
$(document).on('change', '.status-select', function() {
    const repairId = $(this).data('id');
    const status = $(this).val();
    $.ajax({
        url: `/task/${repairId}/update_status`,
        method: 'POST',
        data: {
            _token: "{{ csrf_token() }}",
            status: status
        },
        success: function(response) {
            table.ajax.reload();
            if(status == 'delivered'){
                $(".edit"+repairId).hide();
            }
            alert(response.message);
        },
        error: function(error) {
            alert('Error updating status.');
        }
    });
});
</script>
          <!-- Content wrapper -->
@endsection
