<!DOCTYPE html>
<html class="no-js" lang="ZXX">

<head>
  <!-- Meta Tags -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="keywords" content="Site keywords here">
  <meta name="description" content="#">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Site Title -->
  <title>MyDailyBill</title>

  <!-- Fav Icon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/logosymbol.ico') }}" />

  <!-- Plugins CSS -->
  {{-- <link rel="stylesheet" href="{{asset('vone/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{asset('vone/css/animate.min.css') }}">
  <link rel="stylesheet" href="{{asset('vone/css/aos.min.css') }}">
  <link rel="stylesheet" href="{{asset('vone/css/font-awesome-all.min.css') }}">
  <link rel="stylesheet" href="{{asset('vone/css/slick-bundle.min.css') }}">
  <link rel="stylesheet" href="{{asset('vone/css/video-popup.min.css') }}"> --}}

  <!-- Main CSS -->
  {{-- <link rel="stylesheet" href="{{asset('vone/css/theme-default.css') }}">
  <link rel="stylesheet" href="{{asset('vone/css/style.css') }}"> --}}


  <link rel="stylesheet" href="{{ asset('vf/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('vf/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('vf/css/icofont.css') }}">
	<link rel="stylesheet" href="{{ asset('vf/css/meanmenu.min.css') }}">
	<link rel="stylesheet" href="{{ asset('vf/css/slick.css') }}">
	<link rel="stylesheet" href="{{ asset('vf/css/owl.carousel.css') }}">
	<link rel="stylesheet" href="{{ asset('vf/css/magnific-popup.css') }}">
	<link rel="stylesheet" href="{{ asset('vf/css/animate.min.css') }}">
	<link rel="stylesheet" href="{{ asset('vf/css/animated-headlines.css') }}">
	<link rel="stylesheet" href="{{ asset('vf/css/shortcodes.css') }}">
	<link rel="stylesheet" href="{{ asset('vf/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('vf/css/responsive.css') }}">
	<script src="{{ asset('vf/js/modernizr-3.11.2.min.js') }}"></script>
 </head>
<body><bod data-bs-spy="scroll" data-bs-target="#navigation" data-bs-offset="0" tabindex="0" y="">
	<!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

	<!-- header area start -->
	<header>
		<nav id="" class="navbar navbar-expand-md navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="{{ route('frontpage')}}"><img src="{{ asset('vf/images/logo.jpeg')}}" width="50" height="50" alt="logo" class="img-responsive"><strong style="color:white; padding: 20px 0 0 20px;font-size:22px;">MY DAILY BILL</strong></a>
				</div>
				<div class="collapse navbar-collapse" id="navigation">
					<ul class="nav nav-pills navbar-nav navbar-right">
						<li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ route('frontpage')}}">Home</a>
						</li>
						<li class="nav-item"><a class="nav-link" href="#about">About</a></li>
						<li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
						<li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
						<!-- <li class="nav-item"><a class="nav-link" href="#client">Client</a></li>
						<li class="nav-item"><a class="nav-link" href="#team">Team</a></li> -->
						<li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
						<li class="nav-item"><a class="nav-link download-btn" href="{{route('login')}}">Login</a></li>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<!-- <li class="nav-item"><a class="nav-link download-btn" href="https://onlinev2.mydailybill.com/register">Sign Up</a></li> -->
						 <li class="nav-item"><a class="nav-link download-btn" href="{{route('front_purchase_register')}}">Sign Up</a></li> 
						
						<!-- <li class="nav-item"><a class="nav-link download-btn" href="#pricing">Get Started Free</a></li> -->
					</ul>
				</div>
			</div>
		</nav>
	</header>
	<!-- header area end -->