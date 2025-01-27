<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>SignIn | MyDailyBill</title>
    <meta name="robots" content="noindex,nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/logosymbol.ico') }}" />
    <link href="{{ asset('v2/layouts/vertical-light-menu/css/light/loader.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('v2/layouts/vertical-light-menu/css/dark/loader.css') }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('v2/layouts/vertical-light-menu/loader.js') }}"></script>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('v2/src/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('v2/layouts/vertical-light-menu/css/light/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('v2/src/assets/css/light/authentication/auth-cover.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('v2/layouts/vertical-light-menu/css/dark/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('v2/src/assets/css/dark/authentication/auth-cover.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

</head>

<body class="form">

    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <div class="auth-container d-flex" style="background-color: #fff;">

        <div class="container mx-auto align-self-center">

            <div class="row">

                <div
                    class="col-6 d-lg-flex d-none h-100 my-auto top-0 start-0 text-center justify-content-center flex-column">
                    <div class="auth-cover-bg-image"></div>
                    <div class="auth-overlay" style="background:linear-gradient(to right,#ff746e, #ff9e6f)"></div>

                    <div class="auth-cover">

                        <div class="position-relative">

                            <img src="{{ asset('vf/images/logo.jpeg') }}" alt="auth-img">

                            <h2 class="mt-5 text-white font-weight-bolder px-2">Join the community of experts.</h2>
                            <p class="text-white px-2">It is easy to setup with great customer experience. Start your 30
                                days free trial</p>
                        </div>

                    </div>

                </div>

                <div
                    class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center ms-lg-auto me-lg-0 mx-auto">
                    <div class="card ">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12 mb-3">

                                    <h2>Password Reset</h2>
                                    <p>Enter your email to recover your ID</p>
                                    
                                    </div>
                                    <form method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="col-md-12">
                                        <div class="mb-4">
                                            <label class="form-label">Email</label>
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <button type="submit" class="btn btn-secondary w-100">
                                                {{ __('Send Password Reset Link') }}
                                            </button>
                                        </div>
                                    </div>
                                    
                                    </form>

                            </div>

                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('v2/src/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->




    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Function to clear local storage, session storage, and cookies
            function clearAllClientSideData() {
                // Clear Local Storage
                localStorage.clear();

                // Clear Session Storage
                sessionStorage.clear();

                // Clear Cookies
                // Loop through all cookies and delete them
                document.cookie.split(";").forEach(function(cookie) {
                    let cookieName = cookie.split("=")[0];
                    document.cookie = cookieName + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
                });
            }

            // Call this function after logout or when session should be cleared
            clearAllClientSideData();

            if (window.location.href.includes('login')) {
                clearAllClientSideData();
            }

        });
    </script>

</body>

</html>
