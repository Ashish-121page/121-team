@extends('frontend.layouts.assets')
@if(getSetting('recaptcha') == 1)
    {!! ReCaptcha::htmlScriptTagJsApi() !!}
@endif

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
	@endphp
@endsection

@section('content')
       <!-- ERROR PAGE -->
    <section class="bg-home d-flex align-items-center mt-4">
        <div class="container">
            <div class="row justify-content-center mt-4">
                <div class="col-lg-8 col-md-12 text-center">
                    <img src="{{ asset('frontend/assets/img/404.svg') }}" class="img-fluid p-4" alt="" style="height:50%;">
                    <div class="text-uppercase mt-4 display-3">Oh ! no</div>
                    <div class="text-capitalize text-dark mb-4 error-page">Page Not Found</div>
                    <p class="text-muted para-desc mx-auto">Start working with <span class="text-primary fw-bold">{{ getSetting('app_name') }}</span> that can provide everything you need to generate awareness, drive traffic, connect.</p>
                </div><!--end col-->
            </div><!--end row-->

            <div class="row">
                <div class="col-md-12 text-center">  
                    <a href="" class="btn btn-outline-primary mt-4">Go Back</a>
                    <a href="" class="btn btn-primary mt-4 ms-2">Go To Home</a>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
    </section><!--end section-->
    <!-- ERROR PAGE -->
@endsection