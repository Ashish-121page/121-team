<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<head>
	<title>
		@yield('title','') | Ashish
	</title>
	<!-- initiate head with meta tags, css and script -->
	@include('backend.include.head')
</head>
<body id="app">
    <div class="wrapper">
    	<!-- initiate header-->
    	<div class="page-wrap ">
	    	<!-- initiate sidebar-->

	    	<div class="main-content pl-0 mt-0">
	    		<!-- yeild contents here -->
	    		@yield('content')
	    	</div>



	    	<!-- initiate footer section-->

    	</div>
    </div>
    
	<!-- initiate modal menu section-->

	<!-- initiate scripts-->
	@include('backend.include.script')	
</body>
</html>