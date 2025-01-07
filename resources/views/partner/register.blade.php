<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-menu-fixed layout-compact"
    dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>MyDailyBill | Partner</title>
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/logosymbol.ico') }}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #114b3a;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
            position: relative;
        }

        .container {
            display: flex;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            z-index: 10;
        }





        .right-section {
            padding: 40px;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h2 {
            color: #114b3a;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .existing-user {
            margin-bottom: 20px;
            font-size: 16px;
        }

        .input-group {
            margin-bottom: 15px;
            position: relative;
        }

        label {
            display: block;
            color: #333;
            margin-bottom: 5px;
            font-size: 14px;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 32px;
            cursor: pointer;
            font-size: 14px;
        }

        .forgot-password {
            text-align: right;
            display: block;
            margin-top: 5px;
            color: #007bff;
            text-decoration: none;
            font-size: 12px;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .terms {
            margin: 20px 0;
            text-align: center;
            font-size: 12px;
        }

        .terms a {
            color: #007bff;
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        .login-button {
            background-color: #1e624e;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        .login-button:hover {
            background-color: #16473b;
        }

        .signup-prompt {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }

        .signup-prompt a {
            color: #007bff;
            text-decoration: none;
        }

        .signup-prompt a:hover {
            text-decoration: underline;
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Wave Animation */
        .wave-container {
            width: 100%;
            height: 150px;
            position: absolute;
            bottom: 0;
            left: 0;
            overflow: hidden;
            z-index: 2;
        }

        .waves {
            position: relative;
            width: 100%;
            height: 150px;
            transform: translate3d(0, 0, 0);
        }

        .parallax>use {
            animation: move-forever 25s cubic-bezier(.55, .5, .45, .5) infinite;
        }

        .parallax>use:nth-child(1) {
            animation-delay: -2s;
            animation-duration: 7s;
        }

        .parallax>use:nth-child(2) {
            animation-delay: -3s;
            animation-duration: 10s;
        }

        .parallax>use:nth-child(3) {
            animation-delay: -4s;
            animation-duration: 13s;
        }

        .parallax>use:nth-child(4) {
            animation-delay: -5s;
            animation-duration: 20s;
        }

        @keyframes move-forever {
            0% {
                transform: translate3d(-90px, 0, 0);
            }

            100% {
                transform: translate3d(85px, 0, 0);
            }
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .full-width {
            grid-column: span 2;
        }

        .password-mismatch {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }
    </style>
</head>

<body>
    <div class="container-fluid">

        <h1 style="color: #fff">MY DAILY BILL </h1><br>
    </div>
    <div class="container">
        {{-- <div class="left-section"> --}}
        {{-- <img src="logo.png" alt="Logo" class="logo">
        </div> --}}

        <div class="right-section">
            <center>
                <h2>Partner Signup </h2>
            </center>

            <p class="existing-user">If you are an New User</p>
            <form action="{{ route('partner.signup') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="input-group full-width">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your name" required>
                    </div>

                    <div class="input-group">
                        <label for="category">Category</label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="gstp">GSTP</option>
                            <option value="ca">CA</option>
                            <option value="advocate">ADVOCATE</option>
                            <option value="accountant">ACCOUNTANT</option>
                            <option value="others">OTHERS</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="company">Company Name</label>
                        <input type="text" id="company" name="company_name" placeholder="Enter your company name"
                            required>
                    </div>
                    <div class="input-group">
                        <label for="contact">Contact No.</label>
                        <input type="tel" id="contact" name="phone_no" placeholder="Enter your contact number"
                            required>
                    </div>
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter Password" required>
                        <span class="toggle-password">
                            <i class="fas fa-eye-slash" id="eye"></i>
                        </span>
                    </div>
                    <div class="input-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" name="confirm-password"
                            placeholder="Confirm Password" required>
                        <span class="toggle-password">
                            <i class="fas fa-eye-slash" id="eye-confirm"></i>
                        </span>
                        <div class="password-mismatch" id="password-mismatch">Passwords do not match!</div>
                    </div>
                </div>
                <button type="submit" class="login-button" id="sign-up-button">Sign Up</button>
                <p class="signup-prompt">Are you a Existing User ? Please <a href="{{ route('partner.login') }}">Sign
                        In</a></p>

            </form>
        </div>
    </div>

    <div class="wave-container">
        <svg class="waves" xmlns="http://www.w3.org/2000/svg" viewBox="0 24 150 28" preserveAspectRatio="none">
            <defs>
                <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18v44h-352z" />
            </defs>
            <g class="parallax">
                <use href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
                <use href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                <use href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
                <use href="#gentle-wave" x="48" y="7" fill="#fff" />
            </g>
        </svg>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('confirm-password');
            const togglePassword = document.getElementById('eye');
            const toggleConfirmPassword = document.getElementById('eye-confirm');
            const passwordMismatch = document.getElementById('password-mismatch');
            const signUpButton = document.getElementById('sign-up-button');

            // Toggle password visibility
            togglePassword.addEventListener('click', function() {
                // Check the current type of the password field
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);

                // Toggle the icon class
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });

            toggleConfirmPassword.addEventListener('click', function() {
                // Check the current type of the confirm password field
                const type = confirmPasswordField.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordField.setAttribute('type', type);

                // Toggle the icon class
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });


            // Check if passwords match
            function validatePasswords() {
                if (passwordField.value !== confirmPasswordField.value) {
                    passwordMismatch.style.display = 'block';
                    signUpButton.disabled = true;
                } else {
                    passwordMismatch.style.display = 'none';
                    signUpButton.disabled = false;
                }
            }

            passwordField.addEventListener('input', validatePasswords);
            confirmPasswordField.addEventListener('input', validatePasswords);
        });
    </script>

</body>

</html>
