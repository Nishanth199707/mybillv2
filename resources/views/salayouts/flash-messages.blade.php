@session('success')
<div class="justify-content-center alert alert-success alert-dismissible fade show align-items-center col-md-4 my-4 p-3" role="alert" style="margin: 0 auto;">
    {{ $value }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endsession

@session('error')
<div class="justify-content-center alert alert-danger alert-dismissible fade show align-items-center col-md-4 my-4 p-3" role="alert" style="margin: 0 auto;">
    {{ $value }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endsession

@session('warning')
<div class="justify-content-center alert alert-warning alert-dismissible fade show align-items-center col-md-4 my-4 p-3" role="alert" style="margin: 0 auto;">
    {{ $value }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endsession

@session('info')
<div class="justify-content-center alert alert-info alert-dismissible fade show align-items-center col-md-4 my-4 p-3" role="alert" style="margin: 0 auto;">
    {{ $value }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endsession

@if ($errors->any())
<div class="justify-content-center alert alert-danger alert-dismissible fade show align-items-center col-md-4 my-4 p-3" role="alert" style="margin: 0 auto;">
    <strong>Please check the form below for errors</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
