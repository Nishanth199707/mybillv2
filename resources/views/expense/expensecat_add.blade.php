@extends('layouts.v2.app')
@section('content')
<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <!-- <h4 class="py-3 mb-4"><span class="text-muted fw-light"></span> Add Product Category</h4> -->

              <!-- Basic Layout -->
              <div class="row">
                <div class="col-12">
                  <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center mb-3">
                      <h5 class="mb-0">Expense Category</h5>
                      <!-- <small class="text-muted float-end">Default label</small> -->
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('expensecategory.store') }}" enctype="multipart/form-data">
                            @csrf
                            @if(empty($category))
                            <input type="hidden" name="action_fun" value="add">
                            @else
                            <input type="hidden" name="action_fun" value="update">
                            <input type="hidden" name="id" value="{{$category->id}}">
                            @endif
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ optional($category)->name }}" placeholder="Enter the Expense Category Name" />
                                @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @enderror
                                </div>




                                <div class="mb-3 col-md-2">
                                <label class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select">
                                        @php
                                        $businessstatus=['active' => "Active", 'inactive' => "Inactive"];
                                        @endphp
                                        @foreach ($businessstatus as $key => $val)
                                            <option
                                            @if(optional($category)->status == $val) selected @endif
                                            value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class=" col-md-4 mb-3">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" name="description"  rows="4" cols="10" placeholder="Enter the description">{{ optional($category)->description }}</textarea>
                                @if ($errors->has('description'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('description') }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                <div class=" col-md-2" style="display: flex;justify-content: center;align-items: center;">
                                <button type="submit" class="btn btn-primary"> @if(empty($category)) Add @else Update @endif </button>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>

              </div>

              <div class="row">
                <div class="col-12">
                    <div class="card mb-2">
                        <div class="card-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Expense Category List</h5>
                        </div>

                        <div class="card-body">
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
                url: "{{ route('expense.category') }}",
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
          <!-- Content wrapper -->
@endsection
