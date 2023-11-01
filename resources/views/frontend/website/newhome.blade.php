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
	<!-- Start -->
	<section class="bg-home pb-5 pb-sm-0 d-flex align-items-center bg-linear-gradient-primary">
		<div class="container">
			<div class="row mt-5 align-items-center">
				<div class="col-md-6">
					<div class="title-heading me-lg-4 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
						<h1 class="heading fw-bold mb-3"> 
							<span class="text-primary">Central Source   </span> <br> of all <span class="text-primary">your product information </span></h1>
							<ul style="list-style: circle!important; margin-left:0.8rem"> 
								<li>Aggregate PDF, PPT, JPEG, Excel files</li>
								<li>Search products</li>
								
								<li>Make Offers</li>
								
								<li>Boost sales</li>
							
							</ul>
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

						{{-- <div class="position-absolute top-0 start-0 translate-middle z-index-m-1">
							<img src="{{ asset('frontend/assets/img/dots.svg') }}" class="avatar avatar-xl-large" alt=""> --}}
							{{-- C:\xampp\xampp install\htdocs\project\121.page-Laravel\core\resources\views\devloper\Jaya --}}
						{{-- </div> --}}
					</div>
				</div><!--end col-->
			</div><!--end row-->
		</div><!--end container-->
	</section><!--end section-->
	<!-- End -->

	
	<!-- How It Work Start -->
	<section class="section">
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
									
									{{-- <i data-feather="user-check" class="fea icon-ex-md"></i> --}}
									<svg width="24" height="24" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
										<path fill="currentColor" d="M21.053 20.8c-1.132-.453-1.584-1.698-1.584-1.698s-.51.282-.51-.51s.51.51 1.02-2.548c0 0 1.413-.397 1.13-3.68h-.34s.85-3.51 0-4.7c-.85-1.188-1.188-1.98-3.057-2.547s-1.188-.454-2.547-.396c-1.36.058-2.492.793-2.492 1.19c0 0-.85.056-1.188.396c-.34.34-.906 1.924-.906 2.32s.283 3.06.566 3.625l-.337.114c-.284 3.283 1.13 3.68 1.13 3.68c.51 3.058 1.02 1.756 1.02 2.548s-.51.51-.51.51s-.452 1.245-1.584 1.698c-1.132.452-7.416 2.886-7.927 3.396c-.512.51-.454 2.888-.454 2.888H29.43s.06-2.377-.452-2.888c-.51-.51-6.795-2.944-7.927-3.396zm-12.47-.172c-.1-.18-.148-.31-.148-.31s-.432.24-.432-.432s.432.432.864-2.16c0 0 1.2-.335.96-3.118h-.29s.144-.59.238-1.334a10.01 10.01 0 0 1 .037-.996l.038-.426c-.02-.492-.107-.94-.312-1.226c-.72-1.007-1.008-1.68-2.59-2.16c-1.584-.48-1.01-.384-2.16-.335c-1.152.05-2.112.672-2.112 1.01c0 0-.72.047-1.008.335c-.27.27-.705 1.462-.757 1.885v.28c.048.654.26 2.45.47 2.873l-.286.096c-.24 2.782.96 3.118.96 3.118c.43 2.59.863 1.488.863 2.16s-.432.43-.432.43s-.383 1.058-1.343 1.44l-.232.092v5.234h.575c-.03-1.278.077-2.927.746-3.594c.357-.355 1.524-.94 6.353-2.862zm22.33-9.056c-.04-.378-.127-.715-.292-.946c-.718-1.008-1.007-1.68-2.59-2.16c-1.583-.48-1.007-.384-2.16-.335c-1.15.05-2.11.672-2.11 1.01c0 0-.72.047-1.008.335c-.27.272-.71 1.472-.758 1.89h.033l.08.914c.02.23.022.435.027.644c.09.666.21 1.35.33 1.59l-.286.095c-.24 2.782.96 3.118.96 3.118c.432 2.59.863 1.488.863 2.16s-.43.43-.43.43s-.054.143-.164.34c4.77 1.9 5.927 2.48 6.28 2.833c.67.668.774 2.316.745 3.595h.48V21.78l-.05-.022c-.96-.383-1.344-1.44-1.344-1.44s-.433.24-.433-.43s.433.43.864-2.16c0 0 .804-.23.963-1.84V14.66c0-.018 0-.033-.003-.05h-.29s.216-.89.293-1.862v-1.176z"/>
									</svg>
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
									{{-- <i data-feather="monitor" class="fea icon-ex-md"></i> --}}
									<svg width="24" height="24" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
										<path fill="currentColor" d="M20 20v-3a4 4 0 0 0-8 0v3a2.002 2.002 0 0 0-2 2v6a2.002 2.002 0 0 0 2 2h8a2.002 2.002 0 0 0 2-2v-6a2.002 2.002 0 0 0-2-2Zm-6-3a2 2 0 0 1 4 0v3h-4Zm-2 11v-6h8l.001 6Z"/>
										<path fill="currentColor" d="M25.829 10.115a10.007 10.007 0 0 0-7.939-7.933a10.002 10.002 0 0 0-11.72 7.933A7.502 7.502 0 0 0 7.491 25H8v-2h-.505a5.502 5.502 0 0 1-.97-10.916l1.35-.245l.259-1.345a8.01 8.01 0 0 1 15.731 0l.259 1.345l1.349.245A5.502 5.502 0 0 1 24.508 23H24v2h.508a7.502 7.502 0 0 0 1.32-14.885Z"/>
									</svg>
								</div>
								<div class="flex-1 mt-4">
									<h4 class="title">Data is private</h4>
									<p class="text-muted para mb-0">



									</p>
								</div>
							</div>
						</div>
						
						<div class="col-12 mt-4 pt-2">
							<div class="d-flex features feature-primary">
								<div class="icon text-center rounded-circle text-primary me-3 mt-2">
									{{-- <i data-feather="feather" class="fea icon-ex-md"></i> --}}
									<svg width="24" height="24" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
										<rect width="30.766" height="30.766" x="11.991" y="4.626" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" rx="3" ry="3"/>
										<path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M5.757 12.082v26.544a3 3 0 0 0 3 3h26.544m3.307-32.851h-9.081v15.749l4.541-2.811l4.54 2.811V8.775z"/>
									</svg>
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
									{{-- <i data-feather="user-check" class="fea icon-ex-md"></i>    --}}
									<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
										<path fill="currentColor" d="M5 18h6.325q.175.55.4 1.05t.55.95H3V2h18v7.65q-.475-.225-.975-.363T19 9.075V4H5v9h4.2q.225.675.75 1.175t1.175.7q-.075.5-.1 1.012t.05 1.013q-.9-.175-1.687-.663T8 15H5v3Zm0 0h6.325H5Zm12.025 3l-.3-1.5q-.3-.125-.563-.263t-.537-.337l-1.45.45l-1-1.7l1.15-1q-.05-.3-.05-.65t.05-.65l-1.15-1l1-1.7l1.45.45q.275-.2.537-.337t.563-.263l.3-1.5h2l.3 1.5q.3.125.563.263t.537.337l1.45-.45l1 1.7l-1.15 1q.05.3.05.65t-.05.65l1.15 1l-1 1.7l-1.45-.45q-.275.2-.537.338t-.563.262l-.3 1.5h-2Zm1-3q.825 0 1.413-.588T20.024 16q0-.825-.587-1.413T18.025 14q-.825 0-1.412.588T16.024 16q0 .825.588 1.413t1.412.587Z"/>
									</svg>
									{{-- <svg width="24" height="24" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
										<path fill="currentColor" d="M18.33 3.57s.27-.8-.31-1.36c-.53-.52-1.22-.24-1.22-.24c-.61.3-5.76 3.47-7.67 5.57c-.86.96-2.06 3.79-1.09 4.82c.92.98 3.96-.17 4.79-1c2.06-2.06 5.21-7.17 5.5-7.79zM1.4 17.65c2.37-1.56 1.46-3.41 3.23-4.64c.93-.65 2.22-.62 3.08.29c.63.67.8 2.57-.16 3.46c-1.57 1.45-4 1.55-6.15.89z"/>
									</svg> --}}
									{{-- <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
										<path fill="currentColor" d="M2 6c0-1.505.78-3.08 2-4c0 .845.69 2 2 2a3 3 0 0 1 3 3c0 .386-.079.752-.212 1.091a74.515 74.515 0 0 1 2.191 1.808l-2.08 2.08a75.852 75.852 0 0 1-1.808-2.191A2.977 2.977 0 0 1 6 10c-2.21 0-4-1.79-4-4zm12.152 6.848l1.341-1.341A4.446 4.446 0 0 0 17.5 12A4.5 4.5 0 0 0 22 7.5c0-.725-.188-1.401-.493-2.007L18 9l-2-2l3.507-3.507A4.446 4.446 0 0 0 17.5 3A4.5 4.5 0 0 0 13 7.5c0 .725.188 1.401.493 2.007L3 20l2 2l6.848-6.848a68.562 68.562 0 0 0 5.977 5.449l1.425 1.149l1.5-1.5l-1.149-1.425a68.562 68.562 0 0 0-5.449-5.977z"/>
									</svg> --}}
								</div>
								<div class="flex-1 mt-4">
									<h4 class="title">Customise Photo Offers, Quotes</h4>
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
									{{-- <i data-feather="monitor" class="fea icon-ex-md"></i> --}}
									<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
										<circle cx="5" cy="19" r="1" fill="currentColor"/>
										<path fill="currentColor" d="M4 4h2v9H4z"/>
										<path fill="currentColor" d="M7 2H3a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1Zm0 19H3V3h4Zm7-18v7h-3V3h3m1-1h-5v9h5V2Zm6 1v7h-3V3h3m1-1h-5v9h5V2Zm-8 12v7h-3v-7h3m1-1h-5v9h5v-9Zm6 1v7h-3v-7h3m1-1h-5v9h5v-9Z"/>
									</svg>
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
									{{-- <i data-feather="eye" class="fea icon-ex-md"></i>        --}}
									<svg width="24" height="24" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
										<g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
											<path d="M7.36 13.43h0a1 1 0 0 1-.72 0h0a9.67 9.67 0 0 1-6.14-9V1.5a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v2.92a9.67 9.67 0 0 1-6.14 9.01Z"/>
											<rect width="5" height="4" x="4.5" y="5.5" rx="1"/>
											<path d="M8.5 5.5v-1a1.5 1.5 0 1 0-3 0v1"/>
										</g>
									</svg>
									{{-- <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
										<path fill="currentColor" d="M21.8 17v-1.5a2.818 2.818 0 0 0-5.6 0V17a1.29 1.29 0 0 0-1.2 1.2v3.5a1.31 1.31 0 0 0 1.2 1.3h5.5a1.31 1.31 0 0 0 1.3-1.2v-3.5a1.31 1.31 0 0 0-1.2-1.3Zm-4.3-1.5a1.375 1.375 0 0 1 1.5-1.3a1.375 1.375 0 0 1 1.5 1.3V17h-3Z"/>
										<path fill="currentColor" d="M24 11V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v18a2 2 0 0 0 2 2h11v-2H2V2h20v9"/>
										<path fill="currentColor" d="M6 4H4v2h2V4zm14 0H8v2h12V4zm-7 12H8v2h5v-2zm-7 0H4v2h2v-2zm4-8H8v2h2V8zm10 0h-8v2h8V8zm-5.192 4H12v2h2.2v-.5a2.26 2.26 0 0 1 .608-1.5ZM10 12H8v2h2v-2z"/>
									</svg> --}}
								</div>
								<div class="flex-1 mt-4">
									<h4 class="title">Data is secure
									</h4>
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
									{{-- <i data-feather="smartphone" class="fea icon-ex-md"></i> --}}
									<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
										<path fill="currentColor" d="M1 2h22v4h-2V4H3v13h9v2H1V2Zm13 6h10v14H14V8Zm2 2v10h6V10h-6Zm1.998 6.998h2.004v2.004h-2.004v-2.004ZM5 20h7v2H5v-2Z"/>
									</svg>									
								</div>
								<div class="flex-1 mt-4">
									<h4 class="title">Access on any device
									</h4>
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
									{{-- <i data-feather="heart" class="fea icon-ex-md"></i> --}}
									<svg width="24" height="24" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
										<path fill="currentColor" d="M94.284 65.553L75.825 52.411a1.255 1.255 0 0 0-1.312-.093c-.424.218-.684.694-.685 1.173l.009 6.221H57.231c-.706 0-1.391.497-1.391 1.204v11.442c0 .707.685 1.194 1.391 1.194h16.774v6.27c0 .478.184.917.609 1.136s.853.182 1.242-.097l18.432-13.228c.335-.239.477-.626.477-1.038v-.002c0-.414-.144-.8-.481-1.04z"/>
										<path fill="currentColor" d="M64.06 78.553h-6.49a1.73 1.73 0 0 0-1.73 1.73h-.007v3.01H15.191V36.16h17.723a1.73 1.73 0 0 0 1.73-1.73V16.707h21.188v36.356h.011a1.728 1.728 0 0 0 1.726 1.691h6.49c.943 0 1.705-.754 1.726-1.691h.004V12.5h-.005V8.48a1.73 1.73 0 0 0-1.73-1.73h-32.87L5.235 32.7v58.819c0 .956.774 1.73 1.73 1.73h57.089a1.73 1.73 0 0 0 1.73-1.73v-2.448h.005v-8.79a1.729 1.729 0 0 0-1.729-1.728z"/>
										<path fill="currentColor" d="M21.525 61.862v9.231h2.795v-2.906h2.131c2.159 0 3.321-1.439 3.321-3.156c0-1.73-1.162-3.169-3.321-3.169h-4.926zm5.411 3.169c0 .484-.374.72-.844.72H24.32v-1.453h1.771c.471 0 .845.235.845.733zm4.292-3.169v9.231h4.138c2.893 0 5.052-1.675 5.052-4.623s-2.159-4.608-5.065-4.608h-4.125zm6.352 4.609c0 1.163-.83 2.187-2.228 2.187h-1.329v-4.36h1.342c1.495 0 2.215.927 2.215 2.173zm11.536-2.173v-2.436h-7.003v9.231h2.795v-3.446h4.11v-2.436h-4.11v-.913z"/>
									</svg>
								</div>
								<div class="flex-1 mt-4">
									<h4 class="title">Export in PPT, PDF, Excel</h4>
									<!-- <p class="text-muted para mb-0">Easily access your files through our desktop app.
										mobile apps or the web, anywhere and anytime.
									</p> -->
								</div>
							</div>
						</div><!--end col-->
					</div><!--end row-->
				</div><!--end col-->
			</div><!--end row-->

				{{-- table format --}}
			{{-- <table class="table table-bordered">
					<thead>
						<tr>
						  <th scope="col">Unlimited Users</th>
						  <th scope="col">Unlimited Product Properties</th>
						  
						  
						</tr>
					  </thead>
					  <tbody>
						<tr>
						  <th scope="row">Data is private</th>
						  <td>Data is secure</td>
						  
						  
						</tr>
						<tr>
						  <th scope="row">Manage Samples</th>
						  <td>Access on any device</td>
						  
						  
						</tr>
						<tr>
						  <th scope="row">Customise your Photo Offers, Quotes</th>
						  <td>Export in PPT, PDF, Excel</td>
						  
						</tr>
					  </tbody>
				</table> --}}
		
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
									<b>121</b> helps you distribute product information anywhere online using one of two main methods:<br>
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
	{{-- <div class="offcanvas offcanvas-end shadow border-0" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
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
	</div> --}}
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
@push('script')

@endpush