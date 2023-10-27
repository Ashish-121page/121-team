@extends('frontend.layouts.main')
@section('meta_data')
    @php
		$meta_title = 'Thank You | '.getSetting('app_name');		
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
    <!--end section-->
        <div class="position-relative">
            <div class="shape overflow-hidden text-white">
                <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
                </svg>
            </div>
        </div>
        <!-- Hero End -->

        <!-- Start -->
        <section class="bg-home bg-light d-flex align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="text-center">
                            <div class="icon d-flex align-items-center justify-content-center bg-soft-primary rounded-circle mx-auto" style="height: 90px; width:90px;">
                                <i class="uil uil-thumbs-up align-middle h1 mb-0"></i>
                            </div>
                            <h1 class="my-4 fw-bold">Thank You</h1>
                            @if(request()->get('order_id'))
                                <p>Your order #ORD{{request()->get('order_id')}} has been placed. Once the seller approves your order it will be shipped soon.</p>
                            @endif
                            <a href={{ route('pages.index',$slug) }} class="btn btn-soft-primary mt-3">Go To Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End -->
@endsection