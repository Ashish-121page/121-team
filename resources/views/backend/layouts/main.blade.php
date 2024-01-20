@php
	$user_shop = App\Models\UserShop::whereUserId(auth()->id())->first();
@endphp

<!doctype html lang="en">
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<head>
	<title>@yield('title','') | {{ getSetting('app_name') }}</title>
	<!-- initiate head with meta tags, css and script -->
	@include('backend.include.head')


	@if(AuthRole() != 'Admin')
		<style>
			.sidebar-mini .main-content, .sidebar-mini .header-top{
				padding-left: 0 !important;
			}

		</style>
	@endif
    <style>
        .footer{
            padding-left: 10px !important;
        }
    </style>

	<style>
		/* .fas{
			line-height: 2 !important;
		} */

		.fas .fa-cloud-upload-alt{
			line-height: 1 !important;
		}
	</style>


	@yield('firebase_head')
</head>
<body id="app" class="sidebar-mini">
    <div class="wrapper">
    	<!-- initiate header-->
    	@include('backend.include.header')
    	<div class="page-wrap">
	    	<!-- initiate sidebar-->
	    	@include('backend.include.sidebar')

	    	<div class="main-content bg-white">
				@include('backend.include.logged-in-as')
	    		<!-- yeild contents here -->
	    		@yield('content')
	    	</div>

	    	<!-- initiate chat section-->
	    	{{-- @include('backend.include.chat') --}}


	    	<!-- initiate footer section-->
	    	@include('backend.include.footer')

    	</div>
    </div>

	<!-- initiate modal menu section-->
	@include('backend.include.modalmenu')

	<!-- initiate scripts-->
	@include('backend.include.script')
    @yield('push-script')
	@yield('firebase_footer')
</body>
</html>
