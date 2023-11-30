<!DOCTYPE html>
<html lang="en">

<head>
	@yield('meta_data')
   @include('frontend.include.head')
   {{-- @laravelPWA --}}

	@yield('firebase_head')
</head>

	<body id="app" class="">
		<div class="wrapper">
			<!-- initiate header-->
			@if(isset($website))
				@include('frontend.website.include.header')
			@elseif(isset($customer))
				@include('frontend.customer.dashboard.includes.header')
			@elseif(isset($microsite))		
				{{-- @include('frontend.micro-site.include.header')	 --}}
			@elseif(isset($proposal))		
				@include('frontend.micro-site.include.proposal.header')	
			@endif
				<div class="main-content pl-0">
					<!-- yeild contents here -->
					@yield('content')
					@include('frontend.micro-site.wishlist.modal')
				</div>	
				<!-- initiate footer section-->
			@if(isset($website))
				@include('frontend.website.include.footer')
			@elseif(isset($customer))
				@include('frontend.customer.dashboard.includes.footer')
			@elseif(isset($microsite) || isset($proposal))
				@include('frontend.micro-site.include.footer')	
			@endif
		</div>
		<!-- initiate scripts-->
		@include('frontend.include.script')
		@yield('InlineScript')	
		@yield('firebase_footer')


		<script>
			$('.owl-carousel').owlCarousel({
			loop:true,
			margin:10,
			responsiveClass:true,
			autoplay: true,
			autoplayTimeout:5000,
			autoplayHoverPause:false,
			dotsData:false,
			responsive:{
					0:{
						items:2,
						nav:true
					},
					600:{
						items:3,
						nav:false
					},
					1000:{
						items:5,
						nav:true,
						loop:false
					}
				}
			})


			$(document).ready(function () {
				$("#changeCurrency").change(function (e) { 
					e.preventDefault();
					$.ajax({
						type: "get",
						url: "{{ route('pages.change.currency') }}",
						data: {
							"currency_Id": $(this).val()
						},
						success: function (response) {
							window.location.reload(true);
						}
					});
				});

			});
		</script>
			

			
		 <!-- Loader -->
		 {{-- <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
            </div>
        </div> --}}
        <!-- Loader -->
	</body>
</html>