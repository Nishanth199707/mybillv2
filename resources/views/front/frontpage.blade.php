@include('front.header')
<style>.pricing-area .row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.pricing-single {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%; /* Ensures the card stretches to match the tallest card */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 20px;
    border-radius: 10px;
}

.pricing-single .price-decs ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

/* .ordr-btn a {
    text-decoration: none;
    background: #007bff; Primary button color
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    display: inline-block;
} */

/* .ordr-btn a:hover {
    background: #0056b3;
} */
</style>
<!-- hero area start -->
<div class="hero-area slider-4" id="slider-area">
	<div class="slider">
		<div class="container">
			<div class="row">
				<div class="offset-md-5 col-md-7">
					<div class="hero-text mr-ri-l">
						<h2 style="color: #fff;">MY DAILY BILL </h2>
						<h3 style="color: #fff;">MODERN AND CREATIVE BILLING COMPANION <br>WE PROVIDE WHAT YOU NEED FOR YOUR BUSINESS
						</h3>
						<a href="#pricing" class="hero-btn"> START FREE TRAIL</a>
					</div>
				</div>
			</div>
		</div>
		<div class="slide-animation wow slideInLeft" data-wow-duration="2s" data-wow-delay="1s">
			<img src="{{ asset('vf/images/10.png')}}" alt="">
		</div>
	</div>
</div>
<!-- hero area end -->
<!-- service area start -->
<!-- <section class="service-area gray-bg">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-6">
				<div class="single-service">
					<div class="service-icon">
						<img src="{{ asset('vf/images/service-icon-1.png')}}" alt="">
					</div>
					<div class="service-content">
						<h2>Transparent Billing</h2>
						<p>Understand your costs clearly. No hidden fees or surprises.
							We provide itemized bills and detailed explanations.</p>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="single-service">
					<div class="service-icon">
						<img src="{{ asset('vf/images/service-icon-2.png')}}" alt="">
					</div>
					<div class="service-content">
						<h2>Flexible Options</h2>
						<p>Choose from a variety of payment methods to suit your needs.
							We accept credit cards, debit cards, and online payments.</p>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="single-service">
					<div class="service-icon">
						<img src="{{ asset('vf/images/service-icon-3.png')}}" alt="">
					</div>
					<div class="service-content">
						<h2>Dedicated Support</h2>
						<p>Our support team is available to assist you with any billing questions or concerns.
							Contact us anytime.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section> -->
<!-- service area start -->
<!-- About area start -->
<section id="about" class="about-area pt-60">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="about-content">
					<h2>About MY DAILY BILL</h2>
					<h5>Take Control of Your Business with MY DAILY BILL</h5>
					<p>Simplify your business life with MY DAILY BILL. Our intuitive app empowers you to effortlessly track your income, expenses, and savings. With features like:</p>

					<h6>Providing a sense of security for consumers</h6><br>
					<h6>Saves time one of the most obvious benefits</h6><br>
					<h6>Secure and reliable from low risk of theft</h6><br>

					<p>MY DAILY BILL provides you with the insights you need to make informed financial decisions and achieve your financial goals.</p>
					<a class="hero-btn video-popup" href="#"><i class="icofont icofont-play-alt-2"></i> Watch Our Video</a>
				</div>
			</div>
			<div class="col-md-6">
				<div class="about-img">
					<img src="{{ asset('vf/images/about.png')}}" alt="">
				</div>
			</div>
		</div>
	</div>
</section>
<!-- About area End -->
<!-- Feature area start -->
<section id="features" class="feature-area gray-bg pt-128 pb-70">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-heading pb-55 text-center">
					<h2>Discover Powerful Features</h2>
					<!-- <p>Lorem Ipsum is slechts een proeftekst uit het drukkerij- en zetterijwezen. Lorem Ipsum is de
						standaard proeftekst in deze bedrijfstak sinds.</p> -->
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4 col-md-6">
				<div class="awesome-feature text-center">
					<div class="awesome-feature-icon">
						<span><i class="icofont icofont-alarm"></i></span>
					</div>
					<div class="awesome-feature-details">
						<h5>Fully functional</h5>
						<p>Experience seamless operations with our robust platform. Our intuitive interface and efficient processes ensure smooth performance, minimizing downtime and maximizing productivity.
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="awesome-feature text-center">
					<div class="awesome-feature-icon">
						<span><i class="icofont icofont-light-bulb"></i></span>
					</div>
					<div class="awesome-feature-details">
						<h5>Secure Data</h5>
						<p>Your data is our priority. Benefit from our state-of-the-art security measures, including advanced encryption and firewalls, to safeguard your sensitive information.</p>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="awesome-feature text-center">
					<div class="awesome-feature-icon">
						<span><i class="icofont icofont-code"></i></span>
					</div>
					<div class="awesome-feature-details">
						<h5>Dedicated Customer Support</h5>
						<p>Our support team is available to assist you with any billing questions or concerns.
							Contact us anytime.
						</p>
					</div>
				</div>
			</div>
		</div>
		<!-- <div class="row">
			<div class="col-lg-4 col-md-6">
				<div class="awesome-feature text-center">
					<div class="awesome-feature-icon">
						<span><i class="icofont icofont-ui-video-chat"></i></span>
					</div>
					<div class="awesome-feature-details">
						<h5>Full Free Video Call</h5>
						<p>Lorem Ipsum is slechts een proeftekst uit het drukkerij- en zetterijwezen. Lorem stand
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="awesome-feature text-center">
					<div class="awesome-feature-icon">
						<span><i class="icofont icofont-ui-head-phone"></i></span>
					</div>
					<div class="awesome-feature-details">
						<h5>Great Support</h5>
						<p>Lorem Ipsum is slechts een proeftekst uit het drukkerij- en zetterijwezen. Lorem stand
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="awesome-feature text-center">
					<div class="awesome-feature-icon">
						<span><i class="icofont icofont-heart"></i></span>
					</div>
					<div class="awesome-feature-details">
						<h5>Unlimited Features</h5>
						<p>Lorem Ipsum is slechts een proeftekst uit het drukkerij- en zetterijwezen. Lorem stand
						</p>
					</div>
				</div>
			</div>
		</div> -->
		<div class="row">
			<div class="col-lg-4 col-md-6">
				<div class="awesome-feature text-center">
					<div class="awesome-feature-icon">
						<span><i class="icofont icofont-alarm"></i></span>
					</div>
					<div class="awesome-feature-details">
						<h5>Transparent Billing</h5>
						<p>Understand your costs clearly. No hidden fees or surprises.
							We provide itemized bills and detailed explanations.
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="awesome-feature text-center">
					<div class="awesome-feature-icon">
						<span><i class="icofont icofont-light-bulb"></i></span>
					</div>
					<div class="awesome-feature-details">
						<h5>Flexible Payment Options</h5>
						<p>Choose from a variety of payment methods to suit your needs.
							We accept credit cards, debit cards, and online payments.
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-6">
				<div class="awesome-feature text-center">
					<div class="awesome-feature-icon">
						<span><i class="icofont icofont-code"></i></span>
					</div>
					<div class="awesome-feature-details">
						<h5>Data Analyses</h5>
						<p>Gain valuable insights from your data. Our powerful analytics tools provide actionable insights to help you make informed decisions and drive growth.
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Feature feature area end -->
<!-- How it work start -->
<section class="how-work-area pt-130 pb-125 bg-1">
	<div class="container">
		<div class="row">
			<div class="col-lg-6">
				<div class="how-work-right text-center">
					<img src="{{ asset('vf/images/work.png')}}" alt="">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="how-work-left mt-90">
					<h2>How It Work?</h2>
					<div class="how-work-tab mt-55">
						<ul class="nav">
							<li><a class="active" data-bs-toggle="tab" href="#home">1. Sign Up</a></li>
							<li><a data-bs-toggle="tab" href="#menu1">2. Business Setup</a></li>
							<li><a data-bs-toggle="tab" href="#menu2">3. Run</a></li>
						</ul>
						<div class="tab-content">
							<div id="home" class="mt-45 tab-pane fade show active">

								<h5> Secure and easy sign-up process.</h5><br>
								<h5>Start managing your Business today. </h5><br>

							</div>
							<div id="menu1" class="mt-45 tab-pane fade">


								<h5>Connect your bank accounts.</h5><br>
								<h5>Set up budgets and goals.</h5><br>
								<h5>Categorize your transactions.</h5>
							</div>
							<div id="menu2" class="mt-45 tab-pane fade">


							<h5>Monitor your spending habits.</h5><br>
							<h5>Receive personalized financial advice.</h5><br>
							<h5>Achieve your Business goals.</h5><br>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- How it work End -->
<!-- fun fact area start -->
<section class="funfact-area bg-2 pt-125 pb-130">
	<div class="container">
		<div class="row">
			<!-- <div class="col-md-3">
				<div class="single-fact text-center">
					<h2 class="counter">200</h2>
					<h5>Downloads</h5>
				</div>
			</div> -->
			<div class="col-md-4">
				<div class="single-fact text-center">
					<h2 class="counter">1000</h2>
					<h5>Active Installs</h5>
				</div>
			</div>
			<div class="col-md-4">
				<div class="single-fact text-center">
					<h2 class="counter">800 </h2>
					<h5>Happy Clients</h5>
				</div>
			</div>
			<div class="col-md-4">
				<div class="single-fact text-center">
					<h2 class="counter">100</h2>
					<h5>Total App Rat</h5>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- fun fact area end -->
<!-- app screenshot area start -->
<!-- <section class="screenshot-area pt-130 pb-130">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-heading pb-55 text-center">
					<h2>App Screenshots</h2>
					<p>Lorem Ipsum is slechts een proeftekst uit het drukkerij- en zetterijwezen. Lorem Ipsum is de
						standaard proeftekst in deze bedrijfstak sinds.</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="screenshot-slider">
					<div class="single-screenshot">
						<div class="image">
							<img src="{{ asset('vf/images/1.png')}}" alt="">
						</div>
					</div>
					<div class="single-screenshot">
						<div class="image">
							<img src="{{ asset('vf/images/2_1.png')}}" alt="">
						</div>
					</div>
					<div class="single-screenshot">
						<div class="image">
							<img src="{{ asset('vf/images/3_1.png')}}" alt="">
						</div>
					</div>
					<div class="single-screenshot">
						<div class="image">
							<img src="{{ asset('vf/images/4_1.png')}}" alt="">
						</div>
					</div>
					<div class="single-screenshot">
						<div class="image">
							<img src="{{ asset('vf/images/5.png')}}" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section> -->
<!-- app screenshot area end -->
<!-- Download Area Start -->
<section class="download-area bg-3 ptb-130">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-heading text-center pb-45">
					<h2>Download Now Available</h2>
					<!-- <p>Lorem Ipsum is slechts een proeftekst uit het drukkerij- en zetterijwezen. Lorem Ipsum is de
						standaard proeftekst in deze bedrijfstak sinds.</p> -->
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="download-option-btn text-center">
					<ul>
						<li>
							<a href="#"><i class="icofont icofont-brand-apple"></i> App Store</a>
							<a class="active" href="#"><i class="icofont icofont-brand-windows"></i> Windows
								store</a>
							<a href="#"><i class="icofont icofont-brand-android-robot"></i> Android</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Download Area End -->
<!-- Pricing Plan Area Start -->
<section id="pricing" class="pricing-area pt-130 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading pb-55 text-center">
                    <h2>Pricing Plan</h2>
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
                            <li>Up To 100 Bills </li>
                            <li>Normal Support</li>
                            <li>Only One Active User </li>
                            <li>No Payment Schedule</li>
                        </ul>
                    </div>
                    <div class="ordr-btn uppercase">
                        <a href="{{route('front_purchase_register')}}">Purchase Now</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="pricing-single active white-bg text-center mb-30">
                    <div class="price-titel uppercase">
                        <h4>{{$plan[1]->name}}</h4>
                    </div>
                    <div class="pricing-price">
                        <span>₹{{$plan[1]->sale_price}}</span>
                    </div>
                    <div class="price-decs">
                        <ul>
                            <li>Unlimited Bills </li>
                            <li>Normal Support</li>
                            <li>Three Active User </li>
                            <li>Upto Three Firms</li>
                            <li>Payment Schedules</li>
                        </ul>
                    </div>
                    <div class="ordr-btn uppercase">
                        <a href="{{route('front_purchase_register')}}">Purchase Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="pricing-single white-bg text-center mb-30">
                    <div class="price-titel uppercase">
                        <h4>{{$plan[2]->name}}</h4>
                    </div>
                    <div class="pricing-price">
                        <span>₹{{$plan[2]->sale_price}}</span>
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
                        <a href="{{route('front_purchase_register')}}">Purchase Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Plan Area End -->
<!-- Testimonial Area Start -->
<!-- <section id="client" class="testimonial-area pt-120 pb-130 bg-4">
	<div class="container">
		<div class="row">
			<div class="testimonial-active owl-carousel">
				<div class="col-12">
					<div class="testimonial-desc text-center">
						<p>Mauris pharetra eget turpis at gravida. Praesent diam neque, varius at mi eget, molestie
							scelerisque eros. Quisque eget nunc et ligula interdum finibus. Nullam id tincidunt
							metus, </p>
						<h4>Sathi Bhuiyan</h4>
					</div>
				</div>
				<div class="col-12">
					<div class="testimonial-desc text-center">
						<p>Mauris pharetra eget turpis at gravida. Praesent diam neque, varius at mi eget, molestie
							scelerisque eros. Quisque eget nunc et ligula interdum finibus. Nullam id tincidunt
							metus, </p>
						<h4>Al Mamun</h4>
					</div>
				</div>
				<div class="col-12">
					<div class="testimonial-desc text-center">
						<p>Mauris pharetra eget turpis at gravida. Praesent diam neque, varius at mi eget, molestie
							scelerisque eros. Quisque eget nunc et ligula interdum finibus. Nullam id tincidunt
							metus, </p>
						<h4>Salim Rana</h4>
					</div>
				</div>
			</div>
		</div>
	</div>
</section> -->
<!-- Testimonial Area End -->
<!-- Team Area Start -->
<!-- <section id="team" class="team-area ptb-130">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-heading pb-55 text-center">
					<h2>Lovely Team Member</h2>
					<p>Lorem Ipsum is slechts een proeftekst uit het drukkerij- en zetterijwezen. Lorem Ipsum is de
						standaard proeftekst in deze bedrijfstak sinds.</p>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-3 col-md-6">
				<div class="team-single">
					<img src="{{ asset('vf/images/1_1.png')}}" alt="">
					<div class="team-overlay text-center">
						<h5>Sathi Bhuiyan</h5>
						<h6>Lovely Designer</h6>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="team-single">
					<img src="{{ asset('vf/images/2.png')}}" alt="">
					<div class="team-overlay text-center">
						<h5>Kausar Al Mamun</h5>
						<h6>Lovely Designer</h6>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="team-single">
					<img src="{{ asset('vf/images/3.png')}}" alt="">
					<div class="team-overlay text-center">
						<h5>Nirob Khan</h5>
						<h6>Lovely Designer</h6>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="team-single">
					<img src="{{ asset('vf/images/4.png')}}" alt="">
					<div class="team-overlay text-center">
						<h5>Salim Rana</h5>
						<h6>Lovely Designer</h6>
					</div>
				</div>
			</div>
		</div>
	</div>
</section> -->
<!-- Team Area End -->
<!-- Subcribe Area Start -->
<section class="subcribe-area pt-130 pb-115 bg-6">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-heading pb-35 text-center">
					<h2>Subscribe a free update</h2>
					<!-- <p>Lorem Ipsum is slechts een proeftekst uit het drukkerij- en zetterijwezen. Lorem Ipsum is de
						standaard proeftekst in deze bedrijfstak sinds.</p> -->
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="subcribe-form text-center">
					<form id="mc-form">
						<input autocomplete="off" placeholder="Enter Your Email" type="text">
						<button type="submit">Subscribe</button>
						<!-- mailchimp-alerts Start -->
						<div class="mailchimp-alerts text-centre">
							<div class="mailchimp-submitting"></div>
							<div class="mailchimp-success"></div>
							<div class="mailchimp-error"></div>
						</div>
						<!-- mailchimp-alerts end -->
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Subcribe Area End -->
<!-- Contact Area Start -->
<div id="contact" class="contact-area pt-130">
    <div class="container">
        <div class="row">
            <!-- Contact Form Section -->
            <div class="col-md-6">
               
                    <!-- Contact Form -->
                    <form id="contact-form" class="form " action="https://whizthemes.com/mail-php/other/mail.php">
                        <h3>Request Demo</h3>
                        <div class="row">
                            <!-- Name Input -->
                            <div class="form-group col-md-12">
                                <input type="text" name="con_name" class="form-control" id="first-name" placeholder="Name" required>
                            </div>
                            <!-- Email Input -->
                            <div class="form-group col-12 mt-4">
                                <input type="email" name="con_email" class="form-control" id="email" placeholder="Email" required>
                            </div>
                            <!-- Message Input -->
                            <div class="form-group description col-12 mt-4">
                                <textarea rows="3" name="con_message" class="form-control" id="description" placeholder="Message" required></textarea>
                            </div>
                            <!-- Submit Button -->
                            <div class="col-12 mt-4">
                                <div class="actions text-center">
                                    <button type="submit" name="submit" class="btn btn-lg btn-contact-bg" title="Submit Your Message!">Submit</button>
                                    <p class="form-messege"></p>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- End Contact Form -->
                
            </div>
            <!-- End Contact Form Section -->

            <!-- Image Section -->
            <div class="col-md-6">
                <div class="auth-cover text-center">
                    <img src="https://mydailybill.com/vf/images/logo.jpeg" alt="auth-img" style="max-width: 80%; height: auto;">
                </div>
            </div>
            <!-- End Image Section -->
        </div>
    </div>
</div>
<br>
<!-- Contact Area End -->

@include('front.footer')