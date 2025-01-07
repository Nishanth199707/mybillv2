@extends('partnerlayout.app')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper d-flex justify-content-center">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y text-center">
            <!-- Welcome Card -->
            <div class="card mb-4 mx-auto" style="max-width: 800px;">
                <div class="card-body">
                    <div class="row">
                        <!-- Left Side: Congratulations Message -->
                        <div class="col-md-6">
                            <h5 class="card-title text-primary">Congratulations 🎉
                                @if (Auth::user())
                                    {{ Auth::user()->name }}
                                @endif
                            </h5>
                        </div>
                        <!-- Right Side: Partner Code -->
                        <div class="col-md-6 text-end">
                            <h5>PARTNER CODE : {{ $partner->partner_code }}</h5>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Row with 4 Cards in 2x2 Layout -->
            <div class="row justify-content-center">
                <!-- Card 1: Apply DSC -->
                <div class="col-lg-5 col-md-5 mb-4 mx-2">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Apply DSC</h5>
                            <p class="card-text">Apply for your Digital Signature Certificate easily.</p>
                            <a href="#" class="btn btn-outline-primary">Apply Now</a>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Compress Image -->
                <div class="col-lg-5 col-md-5 mb-4 mx-2">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Compress Image</h5>
                            <p class="card-text">Quickly compress your images for optimal performance.</p>
                            <a href="#" class="btn btn-outline-primary">Compress Now</a>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Buy Tokens -->
                <div class="col-lg-5 col-md-5 mb-4 mx-2">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Buy Tokens</h5>
                            <p class="card-text">Purchase tokens to access premium features.</p>
                            <a href="#" class="btn btn-outline-primary">Buy Now</a>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Billing Software -->
                <div class="col-lg-5 col-md-5 mb-4 mx-2">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">Billing Software</h5>
                            <p class="card-text">Get the best billing software for your business.</p>
                            <a href="#" class="btn btn-outline-primary">Get Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="content-footer footer bg-footer-theme mt-auto">
            <div class="container-xxl d-flex flex-wrap justify-content-center py-2 flex-column text-center">
                <div class="mb-2 mb-md-0">
                    <p style="font-size: 0.875rem;">
                        ©
                        <script>
                            document.write(new Date().getFullYear());
                        </script>, made with ❤️ by
                        <a href="#" target="_blank" class="footer-link fw-medium">RED</a>
                    </p>
                </div>
            </div>
        </footer>
        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
    </div>
    <!-- Content wrapper -->
@endsection
