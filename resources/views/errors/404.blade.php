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
                    <img src="{{ asset('frontend/assets/img/404.svg') }}" class="img-fluid" alt="" style="height:40%;padding-top: 90px!important;">
                    <div class="text-uppercase display-3">Oh ! no</div>
                    <div class="text-capitalize text-dark mb-4 error-page">Page Not Found</div>
                    <p class="mx-auto text-center"><span class="text-primary fw-bold">{{ getSetting('app_name') }}</span></p>
                    <p class="text-muted para-desc mx-auto">This page does't exist & no longer available.</p>
                    <div class="col-md-12 text-center">  
                        <a href="javascript:void(0);" onclick="history.back()" id="back" title="Back" type="button" class="btn btn-primary mt-4 ms-2 mt-4">Go Back</a>
                        <a href="{{url('/')}}" class="btn btn-primary mt-4 ms-2">Go To Home</a>
                        {{-- <a href="javascript:void(0);" onclick="history.back()" id="back" title="Back" type="button" class="nav-link mr-1" style="background-color: #f0f0f0;"><i class="ik ik-arrow-left"></i></a> --}}
                    </div>
                </div><!--end col-->
            </div><!--end row-->

            <!--end row-->
        </div><!--end container-->
    </section><!--end section-->
    <!-- ERROR PAGE -->
@endsection