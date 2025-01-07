@include('front.header')
{{-- @php
    echo '<pre>';
    print_r($plan);
@endphp --}}

<section class="py-130 left-bg-cover"
    style="background-image: url('https://themedox.com/saasten/wp-content/uploads/2024/08/h6-awards-bg.png')">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h1>Login</h1>
                <form method="POST" action="{{ route('front.loginpost') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">


                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" />
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>






                        <button type="submit" class="btn btn-primary">Save</button>
                </form>


            </div>

        </div>
    </div>
</section>
<script>
    function toggleGSTINField() {
        const gstinContainer = document.getElementById('gstin-container');
        const gstAvailableYes = document.getElementById('inlineRadio1');

        if (gstAvailableYes.checked) {
            gstinContainer.style.display = 'block';
        } else {
            gstinContainer.style.display = 'none';
        }
    }

    document.getElementById('inlineRadio1').addEventListener('change', toggleGSTINField);
    document.getElementById('inlineRadio2').addEventListener('change', toggleGSTINField);

    toggleGSTINField();
</script>

{{-- @section('content') --}}






@include('front.footer')
