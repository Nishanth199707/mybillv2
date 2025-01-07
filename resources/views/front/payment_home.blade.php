<!DOCTYPE html>
<html class="no-js" lang="ZXX">

<head>
	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="Site keywords here">
	<meta name="description" content="#">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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

	<style>
		.pricing-area .row {
			display: flex;
			flex-wrap: wrap;
			justify-content: center;
		}

		.pricing-single {
			display: flex;
			flex-direction: column;
			justify-content: space-between;
			height: 100%;
			/* Ensures the card stretches to match the tallest card */
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
			padding: 20px;
			border-radius: 10px;
		}

		.pricing-single .price-decs ul {
			list-style: none;
			padding: 0;
			margin: 0;
		}
	</style>
</head>

<body>
	<bod data-bs-spy="scroll" data-bs-target="#navigation" data-bs-offset="0" tabindex="0" y="">


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
						<a class="navbar-brand" href="#"><img src="{{ asset('vf/images/logo.jpeg')}}" width="50" height="50" alt="logo" class="img-responsive"><h2>MY DAILY BILL</h2></a>
					</div>
					<div class="collapse navbar-collapse" id="navigation">

					</div>
				</div>
			</nav>
		</header>
		<!-- header area end -->

		<!-- Pricing Plan Area Start -->
		<section id="pricing" class="pricing-area pt-130 pb-100">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body text-center">
								<h3 class="card-title text-primary">
									Welcome
									@if (Auth::user())
									{{ Auth::user()->name }}
									@endif
									🎉
								</h3>
								<h5 class="mb-4">
									We’re excited to have you here! <br>
									<strong>Choose a subscription plan to unlock all features and continue your journey with us.</strong>
								</h5>
							</div>
						</div>
						<br>
						<div class="section-heading pb-55 text-center">
							<h2>Pricing Plan</h2>
							<!-- <p>Lorem Ipsum is slechts een proeftekst uit het drukkerij- en zetterijwezen. Lorem Ipsum is de
						standaard proeftekst in deze bedrijfstak sinds.</p> -->
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-4 col-md-6">
						<div class="pricing-single white-bg text-center mb-30">
							<div class="price-titel uppercase">
								<h4>{{$plan[3]->name}}</h4>
							</div>
							<div class="pricing-price">
								<span>Free</span>
							</div>
							<div class="price-decs">
								<ul>
									<!-- <li>Single User </li> -->
									<li>Up To 100 Bills </li>
									<li>Normal Support</li>
									<li>Only One Active User </li>
									<li>No Payment Schedule</li>
									<li></li>
									<li></li>

								</ul>
							</div>
							<div class="ordr-btn uppercase">
								<a href="{{ route('add.to.cart', $plan[3]->id) }}">Purchase Now</a>
							</div>
						</div>
					</div>
					<!-- {{-- <div class="col-lg-3 col-md-6">
				<div class="pricing-single white-bg text-center mb-30">
					<div class="price-titel uppercase">
						<h4>{{$plan[0]->name}}</h4>
					</div>
					<div class="pricing-price">
						<span>₹{{$plan[0]->offer_price}}</span>
					</div>
					<div class="price-decs">
						<ul>
							<li>Five Website</li>
							<li>Five User</li>
							<li>100 GB Bandwidth</li>
							<li>2 GB Storage</li>
						</ul>
					</div>
					<div class="ordr-btn uppercase">
						<a href="{{ route('add.to.cart', $plan[0]->id) }}">Purchase Now</a>
					</div>
				</div>
			</div> --}} -->
					<div class="col-lg-4 col-md-6">
						<div class="pricing-single active white-bg text-center mb-30">
							<div class="price-titel uppercase">
								<h4>{{$plan[1]->name}}</h4>
							</div>
							<div class="pricing-price">
								<span>₹{{$plan[1]->offer_price}}</span>
							</div>
							<div class="price-decs">
								<ul>
									<li>Unlimited Bills </li>
									<li>Normal Support</li>
									<li>Three Active User </li>
									<li>Upto Three Firms</li>
									<li>Payment Schedules</li>
									<li></li>
								</ul>
							</div>
							<div class="ordr-btn uppercase">
								<a href="{{ route('add.to.cart', $plan[1]->id) }}">Purchase Now</a>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-6">
						<div class="pricing-single white-bg text-center mb-30">
							<div class="price-titel uppercase">
								<h4>{{$plan[2]->name}}</h4>
							</div>
							<div class="pricing-price">
								<span>₹{{$plan[2]->offer_price}}</span>

							</div>
							<div class="price-decs">
								<ul>
									<li>Unlimited Bills </li>
									<li>Exclusive Support</li>
									<li>Unlimited User </li>
									<li>Upto Five Firms</li>
									<li>Payment Schedules</li>
									<li>Staff Management</li>
								</ul>
							</div>
							<div class="ordr-btn uppercase">
								<a href="{{ route('add.to.cart', $plan[2]->id) }}">Purchase Now</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- Pricing Plan Area End -->




		<script src="{{ asset('vf/js/jquery-3.6.0.min.js') }}"></script>
		<script src="{{ asset('vf/js/jquery-migrate-3.3.2.min.js') }}"></script>
		<script src="{{ asset('vf/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('vf/js/owl.carousel.min.js') }}"></script>
		<script src="{{ asset('vf/js/slick.min.js') }}"></script>
		<script src="{{ asset('vf/js/jquery.ajaxchimp.min.js') }}"></script>
		<script src="{{ asset('vf/js/plugins.js') }}"></script>
		<script src="{{ asset('vf/js/main.js') }}"></script>
</body>

</html>