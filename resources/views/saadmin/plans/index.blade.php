@extends('salayouts.v2.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Basic Layout -->
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Plans</h5>
                            <a href="{{ route('plans.create') }}" class="btn btn-primary">Create New Plan</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="Zero-config" class="table table-bordered dt-table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>No of Days</th>                                            
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-backdrop fade"></div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#Zero-config').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('plans.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'no_of_days', name: 'no_of_days' },
                 
                    { data: 'actions', name: 'actions', orderable: false, searchable: false },
                ],
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                    "<'table-responsive'tr>" +
                    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            });

          
            });
        
    </script>
@endsection
