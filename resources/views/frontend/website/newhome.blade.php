@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = 'Home | '.getSetting('app_name');		
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'GRPL';		
		$meta_author_email = '' ?? 'Hello@121.page';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';	
		$website = 1;	
	@endphp
@endsection

@section('content')
       
	
   
	
	<!-- Navbar Start -->
  
	<!-- Start -->
	<section class="bg-home pb-5 pb-sm-0 d-flex align-items-center bg-linear-gradient-primary">
		<div class="container">
			<div class="row mt-5 align-items-center">
				<div class="col-md-6">
					<div class="title-heading me-lg-4 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
						<h1 class="heading fw-bold mb-3"> 
							<span class="text-primary">Central Source   </span> <br> of all <span class="text-primary">your product information </span></h1>
						<p class="para-desc text-muted">Aggregate scattered product data ;<br>
							Valuable time saved ;<br>
							Offer the right products – Boost your Sales.
						</p>

						
						<div class="subscribe-form mt-2 py-2 text-start" >
							<form class="m-0 d-inline-block" style="text-decoration-color: white">
								{{-- <a href="{{ url('start') }}" class="btn-link">  --}}
									<button type="submit" class="btn btn-pills btn-primary">
										<a href="{{ url('start') }}" class="btn-link" style="color: white;">Book 7 mins Demo</a>
										<i class="uil uil-arrow-right"></i>
									  </button>
									  
								{{-- <button type="submit" class="btn btn-pills btn-primary"> <a href="{{ url('start') }}" class="btn-link" > Book 7 mins Demo </a><i class="uil uil-arrow-right"></i></button> --}}
								{{-- </a> --}}
							</form><!--end form-->
						</div>
						

					</div>
				   
				</div><!--end col-->

				<div class="col-md-6 mt-4 pt-2 mt-sm-0 pt-sm-0">
					<div class="position-relative ms-lg-5">
						<div class="bg-half-260 overflow-hidden rounded-md shadow-md jarallax" data-jarallax data-speed="0.5" style="background: url('{{ asset('frontend/assets/img/modern-hero.jpg') }}'); background-size: cover; background-position: center;">
							<div class="py-lg-5 py-md-0 py-5"></div>
						</div>
						
						{{-- <div class="bg-half-260 overflow-hidden rounded-md shadow-md jarallax" data-jarallax data-speed="0.5" style="background: url('{{ asset('frontend/assets/img/modern-hero.jpg') }}');">
							<div class="py-lg-5 py-md-0 py-5"></div>
						</div> --}}

						{{-- <div class="modern-saas-absolute-left wow animate__animated animate__fadeInUp" data-wow-delay=".3s">
							<div class="card">
								<div class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
									<div class="d-flex align-items-center">
										<div class="icon bg-soft-primary text-center rounded-pill">
											<i class="uil uil-usd-circle fs-4 mb-0"></i>
										</div>
										<div class="flex-1 ms-3">
											<h6 class="mb-0 text-muted">Revenue</h6>
											<p class="fs-5 text-dark fw-bold mb-0">$<span class="counter-value" data-target="48575">45968</span></p>
										</div>
									</div>

									<span class="text-success ms-4"><i class="uil uil-arrow-growth"></i> 3.84%</span>
								</div>
							</div>
						</div> --}}

						{{-- <div class="modern-saas-absolute-right wow animate__animated animate__fadeInUp" data-wow-delay=".5s">
							<div class="card rounded shadow">
								<div class="p-3">
									<h5>Manage Your Software</h5>

									<div class="progress-box mt-2">
										<h6 class="title fw-normal text-muted">Work in dashboard</h6>
										<div class="progress">
											<div class="progress-bar position-relative bg-primary" style="width:84%;">
												<div class="progress-value d-block text-muted h6 mt-1">84%</div>
											</div>
										</div>
									</div><!--end process box--> --}}
								{{-- </div>
							</div>
						</div> --}}

						<div class="position-absolute top-0 start-0 translate-middle z-index-m-1">
							<img src="{{ asset('frontend/assets/img/dots.svg') }}" class="avatar avatar-xl-large" alt="">
							{{-- C:\xampp\xampp install\htdocs\project\121.page-Laravel\core\resources\views\devloper\Jaya --}}
						</div>
					</div>
				</div><!--end col-->
			</div><!--end row-->
		</div><!--end container-->
	</section><!--end section-->
	<!-- End -->

	
	<!-- How It Work Start -->
	<section class="section overflow-hidden">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 text-center">
					<div class="section-title mb-4 pb-2 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
						{{-- <img src="assets/images/logo-icon.png" class="avatar avatar-small" alt=""> --}}
						<img src="{{ getBackendLogo(getSetting('app_white_logo'))}}" class="logo-light-mode" alt="">
						<h4 class="title fw-semibold my-4">Tracking product properties in excel, power point, pdf ?<br>
							Folders piling up for different products, categories, themes, suppliers ?
							 <br> <strong class="text-primary"></strong> </h4>
						<p class="text-muted para-desc mb-0 mx-auto">With 121, seamlessly handle unlimited items across any product categories. <span class="text-primary fw-bold"></span> </p>
					</div>
				</div><!--end col-->
			</div><!--end row-->

			<div class="row">
				<div class="col-12 mt-4 pt-2">
					<div class="position-relative wow animate__animated animate__fadeInUp start-40 end-40 d-flex justify-content-center align-items-center" data-wow-delay=".3s">
						{{-- {{-- <video class="w-100 rounded" controls autoplay loop> --}}
							{{-- <source src="https://121.page/short/suppliers" type="video/mp4"> --}}
						{{-- </video> --}}

						{{-- <div class="position-absolute top-50 start-50 translate-middle"> --}}
							<iframe width="850" height="400" src="https://www.youtube.com/embed/Ydr_juFBi-A?si=GFGT-0v46JVWXd4y" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
						   
							{{-- <a href="{{ url('/short/supplier') }}" data-type="youtube" data-id="yba7hPeTSjk" class="avatar avatar-small rounded-pill shadow-md card d-flex justify-content-center align-items-center lightbox"> --}}
								{{-- <i class="mdi mdi-play mdi-24px text-primary"></i> --}}
							{{-- </a> --}}
						{{-- </div> --}}
					</div>
				</div>
			</div>
		</div><!--end container-->

			<!-- copy for app features -->
	  
		<!-- copy for app features -->
		<div class="container mt-100 mt-60">
			<div class="row justify-content-center">
				<div class="col-12 text-center">
					<div class="section-title mb-4 pb-2">
						<h3 class="title mb-4">Features of 121 </h3>
						<p class="text-muted para-desc mb-0 mx-auto">To craft custom offers for each buyer, valuable time & resources
							are wasted browsing through Excel, PDFs and Images scattered in Folders, WA, and Drives.
							Is your valuable time wasted and orders lost? 
							<span class="text-primary fw-bold"></span> 
						</p>
					</div>
				</div><!--end col-->
			</div><!--end row-->

			<div class="row justify-content-center align-items-center">
				{{-- <div class="col-lg-4 col-md-8 mt-4 text-center"> --}}
					{{-- <img src="assets/img/feature.png" class="img-fluid px-lg-0 px-md-5 px-4" alt=""> --}}
					{{-- <img src="{{ asset('frontend/assets/img/feature.png') }}" class="img-fluid px-lg-0 px-md-5 px-4" alt=""> --}}
				{{-- </div><!--end col--> --}}

				<div class="col-lg-4 col-md-6">
					<div class="row mt-0">
						<div class="col-12 mt-4 pt-2">
							<div class="d-flex features feature-primary">
								<div class="icon text-center rounded-circle text-primary me-3 mt-2 ">
									
									<i data-feather="user-check" class="fea icon-ex-md"></i>
								</div>
								<div class="flex-1 mt-4">
									<h4 class="title">Unlimited Users</h4>
									<!-- <p class="text-muted para mb-0">Composed in a pseudo-Latin language which more or less pseudo-Latin language corresponds. </p> -->
								</div>
							</div>
						</div><!--end col-->

						<div class="col-12 mt-4 pt-2">
							<div class="d-flex features feature-primary">
								<div class="icon text-center rounded-circle text-primary me-3 mt-2">
									<i data-feather="monitor" class="fea icon-ex-md"></i>
								</div>
								<div class="flex-1 mt-4">
									<h4 class="title">Aggregate</h4>
									<p class="text-muted para mb-0">



									</p>
								</div>
							</div>
						</div>
						
						<div class="col-12 mt-4 pt-2">
							<div class="d-flex features feature-primary">
								<div class="icon text-center rounded-circle text-primary me-3 mt-2">
									<i data-feather="feather" class="fea icon-ex-md"></i>
								</div>
								<div class="flex-1 mt-4">
									<h4 class="title">Manage Samples</h4>
									<p class="text-muted para mb-0">


									</p>
								</div>
							</div>
						</div><!--end col-->
						
						
						<div class="col-12 mt-4 pt-2">
							<div class="d-flex features feature-primary">
								<div class="icon text-center rounded-circle text-primary me-3 mt-2">
									<i data-feather="user-check" class="fea icon-ex-md"></i>   
								</div>
								<div class="flex-1 mt-4">
									<h4 class="title">Make Custom Offers Fast</h4>
									<p class="text-muted para mb-0">


									</p>
								</div>
							</div>
						</div><!--end col-->
					</div><!--end row-->
				</div><!--end col-->

				<div class="col-lg-4 col-md-6">
					<div class="row">
						<div class="col-12 mt-4 pt-2">
							<div class="d-flex features feature-primary">
								<div class="icon text-center rounded-circle text-primary me-3 mt-2">
									<i data-feather="monitor" class="fea icon-ex-md"></i>
								</div>
								<div class="flex-1 mt-4">
									<h4 class="title">Unlimited Product Properties</h4>
									<p class="text-muted para mb-0">
										   
									</p>
								</div>
							</div>
						</div><!--end col-->

						<div class="col-12 mt-4 pt-2">
							<div class="d-flex features feature-primary">
								<div class="icon text-center rounded-circle text-primary me-3 mt-2">
									<i data-feather="eye" class="fea icon-ex-md"></i>       
								</div>
								<div class="flex-1 mt-4">
									<h4 class="title">Your Data is Private</h4>
									<p class="text-muted para mb-0">
										<!-- unless it has been encrypted in such a way that it
										can only be processed by the user, or intended
										recipients. -->
									</p>

									<!-- <p class="text-muted para mb-0">NO MEGA data ever leaves an individual's device  -->
										<!-- unless it has been encrypted in such a way that it
										can only be processed by the user, or intended
										recipients. -->
									<!-- </p> -->
								</div>
							</div>
						</div>
						
						<div class="col-12 mt-4 pt-2">
							<div class="d-flex features feature-primary">
								<div class="icon text-center rounded-circle text-primary me-3 mt-2">
									<i data-feather="smartphone" class="fea icon-ex-md"></i>
								</div>
								<div class="flex-1 mt-4">
									<h4 class="title">Your Data is Secure</h4>
									<!-- <p class="text-muted para mb-0">MEGA protects your data from online attacks with
										zero-knowledge encryption, Simply put - your data
										is encrypted and only you hold the keys.
									</p> -->
								</div>
							</div>
						</div><!--end col-->
						
						<div class="col-12 mt-4 pt-2">
							<div class="d-flex features feature-primary">
								<div class="icon text-center rounded-circle text-primary me-3 mt-2">
									<i data-feather="heart" class="fea icon-ex-md"></i>
								</div>
								<div class="flex-1 mt-4">
									<h4 class="title">Easily Access Your Data</h4>
									<!-- <p class="text-muted para mb-0">Easily access your files through our desktop app.
										mobile apps or the web, anywhere and anytime.
									</p> -->
								</div>
							</div>
						</div><!--end col-->
					</div><!--end row-->
				</div><!--end col-->
			</div><!--end row-->
		</div><!--end container-->
		
		
		{{-- <div class="container mt-100 mt-60">
			<div class="row justify-content-center">
				<div class="col-12">
					<div class="section-title text-center mb-4 pb-2 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
						<h4 class="title mb-4">Some of our happy customers</h4> --}}
						<!-- <p class="text-muted para-desc mb-0 mx-auto"> <span class="text-primary fw-bold">72%</span> of consumers will take action only after reading a positive review.</p>
						<p class="text-muted para-desc mb-0 mx-auto"> <span class="text-primary fw-bold">Overcome an objection </span> <br>One of your benefit results </p> -->
					{{-- </div> --}}
				{{-- </div><!--end col--> --}}
			{{-- </div><!--end row--> --}}

			{{-- <div class="row justify-content-center">
				<div class="col-lg-12 mt-4">
					<div class="tiny-three-item">
						<div class="tiny-slide wow animate__animated animate__fadeInUp" data-wow-delay=".3s">
							<div class="d-flex client-testi m-1"> --}}
								{{-- <img src="assets/images/client/01.jpg" class="avatar avatar-small client-image rounded shadow" alt=""> --}}
								{{-- <img src="assets/img/client/01.jpg" class="avatar avatar-small client-image rounded shadow" alt=""> --}}

								{{-- <div class="card flex-1 content p-3 shadow rounded position-relative">
									<ul class="list-unstyled mb-0">
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
									</ul>
									<p class="text-muted mt-2">" It seems that only fragments of the original text remain in the Lorem Ipsum texts used today. "</p>
									<h6 class="text-primary">- Varun <small class="text-muted">C.E.O</small></h6>
								</div>
							</div>
						</div>
						
						<div class="tiny-slide wow animate__animated animate__fadeInUp" data-wow-delay=".5s">
							<div class="d-flex client-testi m-1">
								<img src="assets/images/client/02.jpg" class="avatar avatar-small client-image rounded shadow" alt="">
								<div class="card flex-1 content p-3 shadow rounded position-relative">
									<ul class="list-unstyled mb-0">
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star-half text-warning"></i></li>
									</ul>
									<p class="text-muted mt-2">" One disadvantage of Lorum Ipsum is that in Latin certain letters appear more frequently than others. "</p>
									<h6 class="text-primary">- Megha <small class="text-muted">M.D</small></h6>
								</div>
							</div>
						</div>

						<div class="tiny-slide wow animate__animated animate__fadeInUp" data-wow-delay=".7s">
							<div class="d-flex client-testi m-1">
								<img src="assets/images/client/03.jpg" class="avatar avatar-small client-image rounded shadow" alt="">
								<div class="card flex-1 content p-3 shadow rounded position-relative">
									<ul class="list-unstyled mb-0">
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
									</ul>
									<p class="text-muted mt-2">" The most well-known dummy text is the 'Lorem Ipsum', which is said to have originated in the 16th century. "</p>
									<h6 class="text-primary">- Wanna Party  <small class="text-muted">P.A</small></h6>
								</div>
							</div>
						</div>

						<div class="tiny-slide wow animate__animated animate__fadeInUp" data-wow-delay=".9s">
							<div class="d-flex client-testi m-1">
								<img src="assets/images/client/04.jpg" class="avatar avatar-small client-image rounded shadow" alt="">
								<div class="card flex-1 content p-3 shadow rounded position-relative">
									<ul class="list-unstyled mb-0">
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
									</ul>
									<p class="text-muted mt-2">" According to most sources, Lorum Ipsum can be traced back to a text composed by Cicero. "</p>
									<h6 class="text-primary">- Vineet <small class="text-muted">Manager</small></h6>
								</div>
							</div>
						</div>

						

						<div class="tiny-slide wow animate__animated animate__fadeInUp" data-wow-delay="1.3s">
							<div class="d-flex client-testi m-1">
								<img src="assets/images/client/06.jpg" class="avatar avatar-small client-image rounded shadow" alt="">
								<div class="card flex-1 content p-3 shadow rounded position-relative">
									<ul class="list-unstyled mb-0">
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
										<li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
									</ul>
									<p class="text-muted mt-2">" Thus, Lorem Ipsum has only limited suitability as a visual filler for German texts. "</p>
									<h6 class="text-primary">- Nikhil Gulati <small class="text-muted">Designer</small></h6>
								</div>
							</div>
						</div>
					</div> --}}
				{{-- </div><!--end col--> --}}
			{{-- </div><!--end row--> --}}
		{{-- </div><!--end container--> --}}

		<div class="container mt-100 mt-60">
			<div class="row justify-content-center">
				<div class="col-12">
					<div class="section-title text-center mb-4 pb-2 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
						<h4 class="title mb-4">Frequently Asked Questions (FAQs)</h4>
						<!-- <p class="text-muted para-desc mb-0 mx-auto">Top 5 objections that ppl need to settle before they feel comfortable taking next step</p> -->
					</div>
				</div><!--end col-->
			</div><!--end row-->
			
			<div class="row align-items-center">
				<div class="col-md-6 mt-4 pt-2">
					{{-- <div class="bg-half-260 overflow-hidden rounded-md shadow-md jarallax" data-jarallax data-speed="0.5" style="background: url('{{ asset('frontend/assets/img/cta.jpg') }}'); background-size: cover; background-position: center;">
					</div> --}}
					<div class="bg-half-260 overflow-hidden rounded-md shadow-md jarallax" data-jarallax data-speed="0.5" style="background: url('{{ asset('frontend/assets/img/cta.jpg') }}'); background-size: cover; background-position: center;">
					</div>
					
					
				</div><!--end col-->

				<div class="col-md-6 mt-4 pt-2">
					<div class="accordion" id="accordionExample">
						<div class="accordion-item rounded shadow wow animate__animated animate__fadeInUp" data-wow-delay=".3s">
							<h2 class="accordion-header" id="headingOne">
								<button class="accordion-button border-0 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
									aria-expanded="true" aria-controls="collapseOne">
									Who benefits from Catalogue distribution tool ?
								</button>
							</h2>
							<div id="collapseOne" class="accordion-collapse border-0 collapse show" aria-labelledby="headingOne"
								data-bs-parent="#accordionExample">
								<div class="accordion-body text-muted">
									121 is for you if you're selling over 100 products . 121 is the only tool specially made (and priced ! ) for small to medium-sized businesses.
								</div>
							</div>
						</div>
						
						<div class="accordion-item rounded shadow mt-3 wow animate__animated animate__fadeInUp" data-wow-delay=".5s">
							<h2 class="accordion-header" id="headingTwo">
								<button class="accordion-button border-0 bg-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
									aria-expanded="false" aria-controls="collapseTwo">
									Why should I implement catalogue tool?
								</button>
							</h2>
							<div id="collapseTwo" class="accordion-collapse border-0 collapse" aria-labelledby="headingTwo"
								data-bs-parent="#accordionExample">
								<div class="accordion-body text-muted">
									121 is essential for success today. Since each sales Buyer asks you for differently
									formatted product details, you need a place to edit and store them 
									When that place is your folders or spreadsheets, it's too easy to make costly mistakes. 121 helps you keep your data error- free and formatted in the way that you need it.
								</div>
							</div>
						</div>

						<div class="accordion-item rounded shadow mt-3 wow animate__animated animate__fadeInUp" data-wow-delay=".7s">
							<h2 class="accordion-header" id="headingThree">
								<button class="accordion-button border-0 bg-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
									aria-expanded="false" aria-controls="collapseThree">
									How can I get started ?
								</button>
							</h2>
							<div id="collapseThree" class="accordion-collapse border-0 collapse" aria-labelledby="headingThree"
								data-bs-parent="#accordionExample">
								<div class="accordion-body text-muted">
									121 offers a user-friendly and intuitive interface, eliminating the need for a developer to kickstart your usage. 
									Our onboarding team assists you in gathering data and training your team for seamless ongoing updates. We will further be available for support as needed.
								</div>
							</div>
						</div>

						<div class="accordion-item rounded shadow mt-3 wow animate__animated animate__fadeInUp" data-wow-delay=".9s">
							<h2 class="accordion-header" id="headingFour">
								<button class="accordion-button border-0 bg-light collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
									How can I share my product information outside of 121 ?
								</button>
							</h2>
							<div id="collapseFour" class="accordion-collapse border-0 collapse" aria-labelledby="headingFour"
								data-bs-parent="#accordionExample">
								<div class="accordion-body text-muted">
									<b>121</b> helps you distribute product information anywhere online using one of three main methods:<br>
									 1. <b>Custom Offers :</b> create and update PDF , Power point or Excel catalogs with accurate product data straight from your 121 account - no more copying and pasting.<br>
									 2. <b>Supplier Portal :</b> share always up-to-date online catalogs with anyone.
								</div>
							</div>
						</div>

						<div class="accordion-item rounded shadow mt-3 wow animate__animated animate__fadeInUp" data-wow-delay="1.1s">
							<h2 class="accordion-header" id="headingFive">
								<button class="accordion-button border-0 bg-light collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
									Where is my data stored and what technology does 121 run on?
								</button>
							</h2>
							<div id="collapseFive" class="accordion-collapse border-0 collapse" aria-labelledby="headingFive"
								data-bs-parent="#accordionExample">
								<div class="accordion-body text-muted">
									All files are stored in Tier 3 Data Center in Noida, Delhi-NCR. This is the cloud service with the highest security available, and allows the system to run fast in all parts of the world.

								</div>
							</div>
						</div>

						<div class="accordion-item rounded shadow mt-3 wow animate__animated animate__fadeInUp" data-wow-delay="1.3s">
							<h2 class="accordion-header" id="headingSix">
								<button class="accordion-button border-0 bg-light collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
									Do I need an IT team to use 121 ?
								</button>
							</h2>
							<div id="collapseSix" class="accordion-collapse border-0 collapse" aria-labelledby="headingSix"
								data-bs-parent="#accordionExample">
								<div class="accordion-body text-muted">
									Not at all ! You can use all of the features available on 121 without a technical team. 
									Our platform is easy to use so you don’t have to hire any specialized help to do everything you want.
								</div>
							</div>
						</div>

						<div class="accordion-item rounded shadow mt-3 wow animate__animated animate__fadeInUp" data-wow-delay="1.5s">
							<h2 class="accordion-header" id="headingSeven">
								<button class="accordion-button border-0 bg-light collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
									Why don't you charge per user?
								</button>
							</h2>
							<div id="collapseSeven" class="accordion-collapse border-0 collapse" aria-labelledby="headingSeven"
								data-bs-parent="#accordionExample">
								<div class="accordion-body text-muted">
									Catalogue Management isn’t a one-person job, but teams don’t have an efficient way to work on product content together. 
								</div>
							</div>
						</div>

						<div class="accordion-item rounded shadow mt-3 wow animate__animated animate__fadeInUp" data-wow-delay="1.7s">
							<h2 class="accordion-header" id="headingEight">
								<button class="accordion-button border-0 bg-light collapsed" type="button" data-bs-toggle="collapse"
									data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
									How much does this cost?
								</button>
							</h2>
							<div id="collapseEight" class="accordion-collapse border-0 collapse" aria-labelledby="headingEight"
								data-bs-parent="#accordionExample">
								<div class="accordion-body text-muted">
									121 service is at a fraction of the cost compared to the expenses involved in building, hosting, training a team, and keeping everything up to date, enabling you to focus on your core business while we handle the rest.
									<a href="{{ url('start') }}" class="btn-link"><b>Book your 7 mins demo</b></a> to get custom package based on your requirement. 
								</div>
							</div>
						</div>

					</div>
				</div><!--end col-->
			</div><!--end row-->

			
		</div><!--end container-->
	</section><!--end section-->
	<!-- End -->

   
	

	<!-- Offcanvas Start -->
	<div class="offcanvas offcanvas-end shadow border-0" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
		<div class="offcanvas-header p-4 border-bottom">
			<h5 id="offcanvasRightLabel" class="mb-0">
				<img src="assets/images/logo-dark.png" height="24" class="light-version" alt="">
				<img src="assets/images/logo-light.png" height="24" class="dark-version" alt="">
			</h5>
			<button type="button" class="btn-close d-flex align-items-center text-dark" data-bs-dismiss="offcanvas" aria-label="Close"><i class="uil uil-times fs-4"></i></button>
		</div>
		<div class="offcanvas-body p-4">
			<div class="row">
				<div class="col-12">
					<img src="assets/images/contact.svg" class="img-fluid d-block mx-auto" alt="">
					<div class="card border-0 mt-4" style="z-index: 1">
						<div class="card-body p-0">
							<h4 class="card-title text-center">Login</h4>  
							<form class="login-form mt-4">
								<div class="row">
									<div class="col-lg-12">
										<div class="mb-3">
											<label class="form-label">Your Email <span class="text-danger">*</span></label>
											<div class="form-icon position-relative">
												<i data-feather="user" class="fea icon-sm icons"></i>
												<input type="email" class="form-control ps-5" placeholder="Email" name="email" required="">
											</div>
										</div>
									</div><!--end col-->

									<div class="col-lg-12">
										<div class="mb-3">
											<label class="form-label">Password <span class="text-danger">*</span></label>
											<div class="form-icon position-relative">
												<i data-feather="key" class="fea icon-sm icons"></i>
												<input type="password" class="form-control ps-5" placeholder="Password" required="">
											</div>
										</div>
									</div><!--end col-->

									<div class="col-lg-12">
										<div class="d-flex justify-content-between">
											<div class="mb-3">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
													<label class="form-check-label" for="flexCheckDefault">Remember me</label>
												</div>
											</div>
											<p class="forgot-pass mb-0"><a href="auth-cover-re-password.html" class="text-dark fw-bold">Forgot password ?</a></p>
										</div>
									</div><!--end col-->

									<div class="col-lg-12 mb-0">
										<div class="d-grid">
											<button class="btn btn-primary">Sign in</button>
										</div>
									</div><!--end col-->

									<div class="col-12 text-center">
										<p class="mb-0 mt-3"><small class="text-dark me-2">Don't have an account ?</small> <a href="auth-cover-signup.html" class="text-dark fw-bold">Sign Up</a></p>
									</div><!--end col-->
								</div><!--end row-->
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="offcanvas-footer p-4 border-top text-center">
			<ul class="list-unstyled social-icon social mb-0">
				<li class="list-inline-item mb-0"><a href="https://1.envato.market/landrick" target="_blank" class="rounded"><i class="uil uil-shopping-cart align-middle" title="Buy Now"></i></a></li>
				<li class="list-inline-item mb-0"><a href="https://dribbble.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-dribbble align-middle" title="dribbble"></i></a></li>
				<li class="list-inline-item mb-0"><a href="https://www.behance.net/shreethemes" target="_blank" class="rounded"><i class="uil uil-behance align-middle" title="behance"></i></a></li>
				<li class="list-inline-item mb-0"><a href="https://www.facebook.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-facebook-f align-middle" title="facebook"></i></a></li>
				<li class="list-inline-item mb-0"><a href="https://www.instagram.com/shreethemes/" target="_blank" class="rounded"><i class="uil uil-instagram align-middle" title="instagram"></i></a></li>
				<li class="list-inline-item mb-0"><a href="https://twitter.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-twitter align-middle" title="twitter"></i></a></li>
				<li class="list-inline-item mb-0"><a href="mailto:support@shreethemes.in" class="rounded"><i class="uil uil-envelope align-middle" title="email"></i></a></li>
				<li class="list-inline-item mb-0"><a href="https://shreethemes.in" target="_blank" class="rounded"><i class="uil uil-globe align-middle" title="website"></i></a></li>
			</ul><!--end icon-->
		</div>
	</div>
	<!-- Offcanvas End -->
	<!-- Switcher Start -->
	<!-- <a href="javascript:void(0)" class="card switcher-btn shadow-md text-primary z-index-1 d-md-inline-flex d-none" data-bs-toggle="offcanvas" data-bs-target="#switcher-sidebar">
		<i class="mdi mdi-cog mdi-24px mdi-spin align-middle"></i>
	</a>

	<div class="offcanvas offcanvas-start shadow border-0" tabindex="-1" id="switcher-sidebar" aria-labelledby="offcanvasLeftLabel">
		<div class="offcanvas-header p-4 border-bottom">
			<h5 id="offcanvasLeftLabel" class="mb-0">
				<img src="assets/images/logo-dark.png" height="24" class="light-version" alt="">
				<img src="assets/images/logo-light.png" height="24" class="dark-version" alt="">
			</h5>
			<button type="button" class="btn-close d-flex align-items-center text-dark" data-bs-dismiss="offcanvas" aria-label="Close"><i class="uil uil-times fs-4"></i></button>
		</div>
		<div class="offcanvas-body p-4 pb-0">
			<div class="row">
				<div class="col-12">
					<div class="text-center">
						<h6 class="fw-bold">Select your color</h6>
						<ul class="pattern mb-0 mt-3">
							<li>
								<a class="color-list rounded color1" href="javascript: void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Primary" onclick="setColorPrimary()"></a>
							</li>
							<li>
								<a class="color-list rounded color2" href="javascript: void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Green" onclick="setColor('green')"></a>
							</li>
							<li>
								<a class="color-list rounded color3" href="javascript: void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Yellow" onclick="setColor('yellow')"></a>
							</li>
						</ul>
					</div>
					<div class="text-center mt-4 pt-4 border-top">
						<h6 class="fw-bold">Theme Options</h6>

						<ul class="text-center style-switcher list-unstyled mt-4">
							<li class="d-grid"><a href="javascript:void(0)" class="rtl-version t-rtl-light" onclick="setTheme('style-rtl')"><img src="assets/images/demos/rtl.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">RTL Version</span></a></li>
								<li class="d-grid"><a href="javascript:void(0)" class="ltr-version t-ltr-light" onclick="setTheme('style')"><img src="assets/images/demos/ltr.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">LTR Version</span></a></li>
								<li class="d-grid"><a href="javascript:void(0)" class="dark-rtl-version t-rtl-dark" onclick="setTheme('style-dark-rtl')"><img src="assets/images/demos/dark-rtl.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">RTL Version</span></a></li>
								<li class="d-grid"><a href="javascript:void(0)" class="dark-ltr-version t-ltr-dark" onclick="setTheme('style-dark')"><img src="assets/images/demos/dark.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">LTR Version</span></a></li>
								<li class="d-grid"><a href="javascript:void(0)" class="dark-version t-dark mt-4" onclick="setTheme('style-dark')"><img src="assets/images/demos/dark.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">Dark Version</span></a></li>
								<li class="d-grid"><a href="javascript:void(0)" class="light-version t-light mt-4" onclick="setTheme('style')"><img src="assets/images/demos/ltr.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">Light Version</span></a></li>
							<li class="d-grid"><a href="../../dashboard/dist/index.html" target="_blank" class="mt-4"><img src="assets/images/demos/admin.png" class="img-fluid rounded-md shadow-md d-block mx-auto" style="width: 240px;" alt=""><span class="text-dark fw-medium mt-3 d-block">Admin Dashboard</span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="offcanvas-footer p-4 border-top text-center">
			<ul class="list-unstyled social-icon social mb-0">
				<li class="list-inline-item mb-0"><a href="https://1.envato.market/landrick" target="_blank" class="rounded"><i class="uil uil-shopping-cart align-middle" title="Buy Now"></i></a></li>
				<li class="list-inline-item mb-0"><a href="https://dribbble.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-dribbble align-middle" title="dribbble"></i></a></li>
				<li class="list-inline-item mb-0"><a href="https://www.behance.net/shreethemes" target="_blank" class="rounded"><i class="uil uil-behance align-middle" title="behance"></i></a></li>
				<li class="list-inline-item mb-0"><a href="https://www.facebook.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-facebook-f align-middle" title="facebook"></i></a></li>
				<li class="list-inline-item mb-0"><a href="https://www.instagram.com/shreethemes/" target="_blank" class="rounded"><i class="uil uil-instagram align-middle" title="instagram"></i></a></li>
				<li class="list-inline-item mb-0"><a href="https://twitter.com/shreethemes" target="_blank" class="rounded"><i class="uil uil-twitter align-middle" title="twitter"></i></a></li>
				<li class="list-inline-item mb-0"><a href="mailto:support@shreethemes.in" class="rounded"><i class="uil uil-envelope align-middle" title="email"></i></a></li>
				<li class="list-inline-item mb-0"><a href="https://shreethemes.in" target="_blank" class="rounded"><i class="uil uil-globe align-middle" title="website"></i></a></li>
			</ul>
		</div>
	</div> -->
	<!-- Switcher End -->

	<!-- Back to top -->
	<a href="#" onclick="topFunction()" id="back-to-top" class="back-to-top fs-5"><i data-feather="arrow-up" class="fea icon-sm icons align-middle"></i></a>
	<!-- Back to top -->

	<!-- javascript -->
	<!-- JAVASCRIPT -->
	{{-- <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- SLIDER -->
	<script src="assets/libs/tiny-slider/min/tiny-slider.js"></script>
	<!-- Parallax -->
	<script src="assets/libs/jarallax/jarallax.min.js "></script>
	<!-- Lightbox -->
	<script src="assets/libs/tobii/js/tobii.min.js"></script>
	<!-- Animation -->
	<script src="assets/libs/wow.js/wow.min.js"></script>
	<!-- Main Js -->
	<script src="assets/libs/feather-icons/feather.min.js"></script>
	<script src="assets/js/plugins.init.js"></script><!--Note: All init (custom) js like tiny slider, counter, countdown, lightbox, gallery, swiper slider etc.-->
	<script src="assets/js/app.js"></script><!--Note: All important javascript like page loader, menu, sticky menu, menu-toggler, one page menu etc. --> --}}

	@include('frontend.include.script')

	



@endsection