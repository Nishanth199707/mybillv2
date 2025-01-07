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
    <link href="{{ asset('v2/src/assets/css/light/authentication/auth-cover.css') }}" rel="stylesheet" type="text/css" />

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

                <div class="col-6 d-lg-flex d-none h-100 my-auto top-0 start-0 text-center justify-content-center flex-column">
                    <div class="auth-cover-bg-image"></div>
                    <div class="auth-overlay" style="background:linear-gradient(to right,#ff746e, #ff9e6f)"></div>

                    <div class="auth-cover">

                        <div class="position-relative">

                            <img src="{{ asset('vf/images/logo.jpeg')}}" alt="auth-img">

                            <h2 class="mt-5 text-white font-weight-bolder px-2">Join the community of experts.</h2>
                            <p class="text-white px-2">It is easy to setup with great customer experience. Start your 30 days free trial</p>
                        </div>

                    </div>

                </div>

                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center ms-lg-auto me-lg-0 mx-auto">
                    <div class="card ">
                        <div class="card-body">

                            <div class="row">

                                @if(session()->has('error'))
                                <div class="alert alert-success">
                                    {{ session()->get('error') }}
                                </div>
                                @endif
                                @if (session('success'))
                                <div class="alert alert-success">
                                    <ul class="mb-0">
                                        {{ session('success') }}
                                    </ul>
                                </div>
                                @endif
                                <!-- <form method="POST" action="{{ route('login') }}" >
                                    @csrf
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control">
                                            @if ($errors->has('email'))
                                            <span class="error">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <label class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
                                            <span class="toggle-password" id="togglePassword">
                                                <i class="fas fa-eye-slash"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <div class="form-check form-check-primary form-check-inline">
                                                <input class="form-check-input me-3" type="checkbox" id="form-check-default">
                                                <label class="form-check-label" for="form-check-default">
                                                    Remember me
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-4">
                                            <button class="btn btn-secondary w-100" style="background:linear-gradient(to right,#ff746e, #ff9e6f);border:none;">SIGN IN</button>
                                        </div>
                                    </div>
                                </form> -->

                                <div id="email-login">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="col-md-12 mb-3">

                                            <h2>Sign In</h2>
                                            <p>Enter your email and password to login</p>

                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                                        </div>
                                        <div class="col-12">
                                            <div class="mt-4 ">
                                                <!-- Email Login Button -->
                                                <button type="submit" class="btn btn-secondary w-100" style="border:none;background: linear-gradient(to right, #ff746e, #ff9e6f);">SIGN IN (Email)</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>



                                <div id="otp-login" style="display: none;">
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <!-- <h3>OTP Login</h3> -->
                                        <div class="col-md-12 mb-3">

                                            <h2>Sign In</h2>
                                            <p>Enter your Mobile No and Otp to login</p>

                                        </div>
                                        <!-- Mobile Number Input -->
                                        <div class="form-group">
                                            <label for="mobileno">Mobile Number</label>
                                            <input type="text" name="mobileno" id="mobileno" class="form-control" placeholder="Enter mobile number" required>
                                        </div>

                                        <!-- OTP Input Field -->
                                        <div class="form-group" id="otp-field" style="display: none;">
                                            <label for="otp">OTP</label>
                                            <input type="text" name="otp" id="otp" class="form-control" placeholder="Enter OTP">
                                        </div>

                                        <br>
                                        <div class="text-end">
                                            <!-- Send OTP Button -->
                                            <button type="button" id="send-otp" class="btn btn-secondary" style="border:none;background: linear-gradient(to right, #ff746e, #ff9e6f);">Send OTP</button>

                                            <!-- Resend OTP Button -->
                                            <button type="button" id="resend-otp" class="btn btn-secondary" style="display: none;background: linear-gradient(to right, #ff746e, #ff9e6f);" disabled>Resend OTP</button>

                                        </div>

                                        <!-- Countdown Timer -->
                                        <p id="resend-otp-timer" style="display: none; color: red; font-size: 14px;"></p>

                                        <div class="col-12 mt-3">

                                            <!-- OTP Login Submit Button -->
                                            <button type="submit" id="sign-in" class="btn btn-secondary w-100"
                                                style="background: linear-gradient(to right, #ff746e, #ff9e6f); border: none; display: none;">
                                                SIGN IN (OTP)
                                            </button>

                                        </div>
                                    </form>
                                </div>



                                <div class="form-group mt-3">
                                    <p class="text-center" >
                                        <a href="javascript:void(0);" style="border:1px solid #ff746e;" class="btn" id="toggle-login">Switch to OTP Login</a>
                                    </p>
                                </div>
                                </form>
                                <div class="col-12">
                                    <div class="text-center">
                                        <p class="mb-0"> @if (Route::has('password.request'))
                                            <a class="text-warning" href="{{ route('password.request') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="col-12 mb-4">
                                    <div class="">
                                        <div class="seperator">
                                            <hr>
                                            <div class="seperator-text"> <span>Or continue with</span></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4 col-12">
                                    <div class="mb-4">
                                        <button class="btn  btn-social-login w-100 ">
                                            <img src="{{ asset('v2/src/assets/img/google-gmail.svg') }}" alt="" class="img-fluid">
                                            <span class="btn-text-inner">Google</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-sm-4 col-12">
                                    <div class="mb-4">
                                        <button class="btn  btn-social-login w-100">
                                            <img src="{{ asset('v2/src/assets/img/github-icon.svg') }}" alt="" class="img-fluid">
                                            <span class="btn-text-inner">Github</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-sm-4 col-12">
                                    <div class="mb-4">
                                        <button class="btn  btn-social-login w-100">
                                            <img src="{{ asset('v2/src/assets/img/twitter.svg') }}" alt="" class="img-fluid">
                                            <span class="btn-text-inner">Twitter</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="text-center">
                                        <p class="mb-0">Dont't have an account ? <a href="{{route('front_purchase_register')}}" class="text-warning">Sign Up</a></p>
                                    </div>
                                </div>


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

    <script>
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');

        togglePasswordButton.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle the 'active' class to change the icon color
            this.classList.toggle('active');

            // Toggle between the eye and eye-slash icons
            const icon = this.querySelector('i');
            if (type === 'password') {
                icon.classList.add('fa-eye-slash');
                icon.classList.remove('fa-eye');
            } else {
                icon.classList.add('fa-eye');
                icon.classList.remove('fa-eye-slash');
            }
        });
    </script>
    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailLogin = document.getElementById('email-login');
            const otpLogin = document.getElementById('otp-login');
            const toggleLogin = document.getElementById('toggle-login');
            const sendOtpButton = document.getElementById('send-otp');
            const resendOtpButton = document.getElementById('resend-otp');
            const otpField = document.getElementById('otp-field');
            const mobilenoInput = document.getElementById('mobileno');

            toggleLogin.addEventListener('click', function() {
                if (emailLogin.style.display === 'none') {
                    emailLogin.style.display = 'block';
                    otpLogin.style.display = 'none';
                    toggleLogin.textContent = 'Switch to OTP Login';
                } else {
                    emailLogin.style.display = 'none';
                    otpLogin.style.display = 'block';
                    toggleLogin.textContent = 'Switch to Email Login';
                }
            });

            sendOtpButton.addEventListener('click', function() {
                const mobileno = mobilenoInput.value;

                if (!mobileno || mobileno.length !== 10) {
                    alert('Please enter a valid 10-digit mobile number.');
                    return;
                }

                // Send OTP via AJAX
                fetch('{{ route("request.otp") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            mobileno
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('OTP sent successfully!');
                            otpField.style.display = 'block';
                            sendOtpButton.style.display = 'none';
                            resendOtpButton.style.display = 'block';
                        } else {
                            alert(data.message || 'Failed to send OTP. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            });

            resendOtpButton.addEventListener('click', function() {
                sendOtpButton.click();
            });
        });
    </script> -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailLogin = document.getElementById('email-login');
            const otpLogin = document.getElementById('otp-login');
            const toggleLogin = document.getElementById('toggle-login');
            const sendOtpButton = document.getElementById('send-otp');
            const resendOtpButton = document.getElementById('resend-otp');
            const otpField = document.getElementById('otp-field');
            const mobilenoInput = document.getElementById('mobileno');
            const otpInput = document.getElementById('otp'); // Add an input field for OTP
            const signInButton = document.getElementById('sign-in'); // Add a Sign-In button
            const resendOtpTimer = document.getElementById('resend-otp-timer'); // Display timer

            let resendOtpCooldown = 50; // Cooldown time in seconds
            let timerInterval;

            toggleLogin.addEventListener('click', function() {
                if (emailLogin.style.display === 'none') {
                    emailLogin.style.display = 'block';
                    otpLogin.style.display = 'none';
                    toggleLogin.textContent = 'Switch to OTP Login';
                } else {
                    emailLogin.style.display = 'none';
                    otpLogin.style.display = 'block';
                    toggleLogin.textContent = 'Switch to Email Login';
                }
            });

            sendOtpButton.addEventListener('click', function() {
                const mobileno = mobilenoInput.value;

                if (!mobileno || mobileno.length !== 10) {
                    alert('Please enter a valid 10-digit mobile number.');
                    return;
                }

                // Send OTP via AJAX
                fetch('{{ route("request.otp") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            mobileno
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('OTP sent successfully!');
                            otpField.style.display = 'block';
                            sendOtpButton.style.display = 'none';
                            startResendOtpCooldown();
                        } else {
                            alert(data.message || 'Failed to send OTP. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            });

            resendOtpButton.addEventListener('click', function() {
                if (resendOtpButton.disabled) return; // Prevent clicking when disabled
                sendOtpButton.click();
            });

            otpInput.addEventListener('input', function() {
                const otpValue = otpInput.value;

                // Show the Sign-In button only when a valid OTP is entered
                if (otpValue.length === 6) {
                    signInButton.style.display = 'block';
                } else {
                    signInButton.style.display = 'none';
                }
            });

            function startResendOtpCooldown() {
                resendOtpButton.disabled = true;
                resendOtpButton.style.display = 'none';
                resendOtpTimer.style.display = 'block';
                resendOtpTimer.textContent = `Resend OTP in ${resendOtpCooldown}s`;

                let remainingTime = resendOtpCooldown;

                timerInterval = setInterval(() => {
                    remainingTime -= 1;
                    resendOtpTimer.textContent = `Resend OTP in ${remainingTime}s`;

                    if (remainingTime <= 0) {
                        clearInterval(timerInterval);
                        resendOtpButton.disabled = false;
                        resendOtpButton.style.display = 'block';
                        resendOtpTimer.style.display = 'none';
                    }
                }, 1000);
            }
        });
    </script>

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