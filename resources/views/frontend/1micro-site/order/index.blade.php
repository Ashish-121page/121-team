@extends('frontend.layouts.main')
@section('meta_data')
    @php
		$meta_title = 'Order | '.getSetting('app_name');		
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
    <section class="bg-half-170 bg-light d-table w-100">
        <div class="container">
            <div class="row mt-5 justify-content-center">
                <div class="col-lg-12 text-center">
                    <div class="pages-heading">
                        <h4 class="title mb-0">My Order </h4>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
            
            <div class="position-breadcrumb">
                <nav aria-label="breadcrumb" class="d-inline-block">
                    <ul class="breadcrumb bg-white rounded shadow mb-0 px-4 py-2">
                        <li class="breadcrumb-item"><a href="{{ route('pages.index') }}">121.Page</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('pages.shop-index') }}">Manufacturer</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Order</li>
                    </ul>
                </nav>
            </div>
        </div> <!--end container-->
    </section>
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
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="bg-white shadow rounded p-4">
                        <div class="row">
                            <div class="col-md-4 border-right">
                                <div class="del-adrs pl-15 pt-2">
                                    <h5 class="widget-title fw-bold mb-2">Order Item</h5>
                                    <div class="row mt-2">
                                        <div class="col-3">
                                            <img src="{{ asset('frontend/assets/img/shop/product/single-2.jpg') }}" class="img-fluid">
                                        </div>
                                        <div class="col-9">
                                            <p class="mb-0">Syska HT1200 Runtime: 40 min Trimmer for Men  (Black)</p>
                                            <p class="mb-0 fw-bold">₹<span>599</span></p>
                                        </div>
                                    </div>
                                    
                                    <p class="mb-0 fw-bold mt-2">Your item has been delivered</p>
                                    <p class="mb-0">Payment Method: <span class="fw-bold">Netbanking</span></p>
                                    <a href="#" class="btn btn-primary mt-2 mb-2 inv-btn" data-bs-toggle="modal" data-bs-target="#invoice">Download Invoice</a>
                                    
                                </div>
                            </div>
                            <div class="col-md-4 border-right">
                                <div class="del-adrs pl-15 pt-2">
                                    <h5 class="widget-title fw-bold mb-1">Delivery Address</h5>
                                    <p>krishnaganj bazar Subdistrict, Krishnaganj bazar Hugli District - 712122, West Bengal</p>
                                    <h6 class="widget-title fw-bold mb-0">Phone No</h6>
                                    <p>+91-123547852</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="del-adrs pl-15 pt-2">
                                    <h5 class="widget-title fw-bold mb-1">Your Rewards</h5>
                                    <div class="row mt-2">
                                        <div class="col-1">
                                            <i class="mdi mdi-gift gft-card"></i>
                                        </div>
                                        <div class="col-11">
                                            <p class="mb-0" style="line-height: 14px;">You got a Gift card</p>
                                            <p class="mb-0"><a href="javascript:void(0)">Go to the gift card zone to know more</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end row-->
        </div><!--end container-->
    </section><!--end section-->
    <!-- End -->
@endsection