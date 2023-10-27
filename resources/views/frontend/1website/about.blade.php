@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = 'About | '.getSetting('app_name');		
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
<link rel="stylesheet" href="https://121.page/backend/plugins/jquery-toast-plugin/dist/jquery.toast.min.css">
<style>
    p,li{
       color: #8492a6 !important;
    }
    /* .bg-light{
        padding: 20px 0 100px 0 !important;
    } */
    @media (max-width: 768px) {
        .section-title .title {
            font-size: 33px !important
        }
        .section{
            padding: 10px 0 10px 0 !important;
        }
        .bg-light {
            padding: 10px 0 55px 0 !important;
        }
    }
    @media(max-width: 420px) {
        .text-primary {
            font-size:3vh !important;
        }
    }

    p span{
        font-size: 1.2rem
    }
    p span b{
        /* font-weight: 400 */
    }
</style>
        @php
            $page_title = "About";
        @endphp
        @include('frontend.website.breadcrumb')


    <div class="position-relative">
        <div class="shape overflow-hidden text-white">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
            </svg>
        </div>
    </div>
        <!--Shape End-->

        <!-- About Start -->
        <section class="section">
            <div class="container">
                <div class="row align-items-center p-3">
                    {{-- <div class="col-lg-5 col-md-5 mt-4 pt-2 mt-sm-0 pt-sm-0">
                        <div class="position-relative">
                            <img src="{{ asset('frontend/assets/img/about.jpg') }}" class="rounded img-fluid mx-auto d-block" alt="">
                            <div class="play-icon">
                                <a href="#!" data-type="youtube" data-id="yba7hPeTSjk" class="play-btn lightbox border-0">
                                    <i class="mdi mdi-play text-primary rounded-circle shadow"></i>
                                </a>
                            </div>
                        </div>
                    </div><!--end col--> --}}

                    <div class="col-lg-12 col-md-12 mt-4 pt-2 mt-sm-0 pt-sm-0">
                        <div class="section-title ms-lg-4">
                            <h4 class="title mb-4-1" style="text-transform: capitalize">About <span class="text-primary"><b>121.page</b></span></h4>
                            <p style="font-size: 1.2rem">
                                &#8226; <span class="text-primary"><b>WHY :</b></span><br><br>
                                &#8226; Technology has undoubtedly made things more convenient with <span class="text-primary"><b>real-time mobile updates</b></span> and instant
                                sharing, it has also created — the <span class="text-primary"><b>problem of excess</b></span>,
                                <br>
                                &#8226; With the multiple communication platforms like <span class="text-primary"><b>WhatsApp, email, and cloud drives</b></span> - managing <span class="text-primary"><b>catalogs</b></span>
                                has become even more <span class="text-primary"><b>complicated</b></span>.
                                <br>
                                &#8226; Especially, when dealing with suppliers who use different <span class="text-primary"><b>languages of formats</b></span> like pdf, excel, jpeg, etc.
                            </p>
                            <br>
                            <p style="font-size: 1.2rem">
                                &#8226; <span class="text-primary"> <b>WHAT IS 121.PAGE :</b> </span><br><br>
                                &#8226; B2B website to <span class="text-primary"><b>simplify, to streamline your catalogue operations</b></span> and enhance your business profits in this
                                ever-evolving digital landscape.
                                <br>
                                &#8226; Stay up-to-date with <span class="text-primary">relevant products</b></span> - when you need them.
                                <br>
                                &#8226; 121.page is a tool to create <span class="text-primary"><b>effective business proposals</b></span> to respond on client inquiries.
                                <br>
                                &#8226; To support in this endeavour, 121.page is also incubated by <span class="text-primary"><b>Bincube</b></span> under aegis of <span class="text-primary"><b>Startup India</b></span>.
                            </p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <br>
                <br>
                <br>
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-5 mt-4 pt-2 mt-sm-0 pt-sm-0">
                        <div class="position-relative">
                            <img src="{{ asset('frontend/assets/img/founder.png') }}" class="rounded img-fluid mx-auto d-block" alt="">
                            <div class="h4 text-center mt-2 text-primary" style="font-weight: 800;"> CA Saurabh Biyani </div>
                            <div class="h4 text-center mt-2 text-primary" style="font-weight: 800;"> Founder </div>
                        </div>
                        <div class="d-flex justify-content-center gap-5">
                            <a href="https://www.linkedin.com/in/saurabhbiyani/ " class="fs-1 text-center" target="_blank" data-bs-toggle="tooltip" data-bs-title="Visit Linkedin Profile"> <span class="fab fa-linkedin"></span></a>
                            {{-- <a href="https://www.linkedin.com/in/saurabhbiyani/ " class="fs-1 text-center" target="_blank" data-bs-toggle="tooltip" data-bs-title="Visit Instgram Profile"> <span class="fab fa-instagram"></span></a>
                            <a href="https://www.linkedin.com/in/saurabhbiyani/ " class="fs-1 text-center" target="_blank" data-bs-toggle="tooltip" data-bs-title="Visit Twitter Profile"> <span class="fab fa-twitter"></span></a> --}}
                        </div>
                    </div><!--end col-->


                    <div class="col-lg-9 col-md-7 mt-4 pt-2 mt-sm-0 pt-sm-0">
                        <div class="section-title ms-lg-4">
                            <h4 class="title mb-4-1">Our Story</h4>
                            {{-- <h5>B2B sales is on one-to-one basis.</h5> --}}
                            <p class="fs-5">
                                &#8226; <span class="text-primary "><b>Chartered Accountant</b></span>, over <span class="text-primary "><b>15 years</b></span> of experience includes working with ICICI Bank, ICICI Prudential, and auditing for <span class="text-primary "><b>global Big 5 entities</b></span> like KPMG and Grant Thornton. 
                            </p>
                            
                            <p class="fs-5">
                                &#8226; Worked on <span class="text-primary "><b>international projects</b></span> in cities such as Riyadh, Nairobi, Brussels, Copenhagen, Paris, Edinburgh, and Manchester. 
                            </p>

                            <p class="fs-5">
                                &#8226;  <span class="text-primary "><b>Frustrated</b></span> by the limitations of  <span class="text-primary "><b>existing platforms</b></span> like Indiamart, Justdial, Salesforce, and Shopify in terms of  <span class="text-primary "><b>affordable and efficient</b></span> catalogue management, Saurabh decided to build 121.page for  <span class="text-primary "><b>all to benefit</b></span>. 
                            </p>

                            <p class="fs-5">
                                &#8226; To guarantee no-conflict with 121.page users, discontinued his family business, <span class="text-primary "><b><a href="https://giftingbazaar.com/" style="text-decoration: none" target="_blank">GiftingBazaar</a></b></span>, which <span class="text-primary "><b>was operating</b></span> in e-commerce, event management, and B2B gifting. 
                            </p> 

                        </div>

                    </div><!--end col-->
                </div>


            </div><!--end container-->

            {{-- <div class="container mt-100 mt-60">
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <div class="section-title mb-4 pb-2">
                            <h4 class="title mb-4">Key Features</h4>
                            <p class="text-muted para-desc mx-auto mb-0">Start working with <span class="text-primary fw-bold">{{ getSetting('app_name') }}ck</span> that can provide everything you need to generate awareness, drive traffic, connect.</p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    <div class="col-lg-4 col-md-6 mt-4 pt-2">
                        <div class="d-flex features feature-primary key-feature align-items-center p-3 rounded shadow">
                            <div class="icon text-center rounded-circle me-3">
                                <i data-feather="monitor" class="fea icon-ex-md"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="title mb-0">Fully Responsive</h4>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-lg-4 col-md-6 mt-4 pt-2">
                        <div class="d-flex features feature-primary key-feature align-items-center p-3 rounded shadow">
                            <div class="icon text-center rounded-circle me-3">
                                <i data-feather="heart" class="fea icon-ex-md"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="title mb-0">Browser Compatibility</h4>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-lg-4 col-md-6 mt-4 pt-2">
                        <div class="d-flex features feature-primary key-feature align-items-center p-3 rounded shadow">
                            <div class="icon text-center rounded-circle me-3">
                                <i data-feather="eye" class="fea icon-ex-md"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="title mb-0">Retina Ready</h4>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-lg-4 col-md-6 mt-4 pt-2">
                        <div class="d-flex features feature-primary key-feature align-items-center p-3 rounded shadow">
                            <div class="icon text-center rounded-circle me-3">
                                <i data-feather="bold" class="fea icon-ex-md"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="title mb-0">Based On Bootstrap 5</h4>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-lg-4 col-md-6 mt-4 pt-2">
                        <div class="d-flex features feature-primary key-feature align-items-center p-3 rounded shadow">
                            <div class="icon text-center rounded-circle me-3">
                                <i data-feather="feather" class="fea icon-ex-md"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="title mb-0">Feather Icons</h4>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-lg-4 col-md-6 mt-4 pt-2">
                        <div class="d-flex features feature-primary key-feature align-items-center p-3 rounded shadow">
                            <div class="icon text-center rounded-circle me-3">
                                <i data-feather="code" class="fea icon-ex-md"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="title mb-0">Built With SASS</h4>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-lg-4 col-md-6 mt-4 pt-2">
                        <div class="d-flex features feature-primary key-feature align-items-center p-3 rounded shadow">
                            <div class="icon text-center rounded-circle me-3">
                                <i data-feather="user-check" class="fea icon-ex-md"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="title mb-0">W3c Valid Code</h4>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-lg-4 col-md-6 mt-4 pt-2">
                        <div class="d-flex features feature-primary key-feature align-items-center p-3 rounded shadow">
                            <div class="icon text-center rounded-circle me-3">
                                <i data-feather="git-merge" class="fea icon-ex-md"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="title mb-0">Flaticon Icons</h4>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-lg-4 col-md-6 mt-4 pt-2">
                        <div class="d-flex features feature-primary key-feature align-items-center p-3 rounded shadow">
                            <div class="icon text-center rounded-circle me-3">
                                <i data-feather="settings" class="fea icon-ex-md"></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="title mb-0">Easy to customize</h4>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-12 mt-4 pt-2 text-center">
                        <a href="javascript:void(0)" class="btn btn-primary">See More <i class="mdi mdi-arrow-right"></i></a>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container--> --}}
        </section><!--end section-->
        <!-- About End -->

        <!-- Team Start -->
        <section class="section bg-light">
            {{-- <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="section-title mb-4 pb-2">
                            <h4 class="title mb-4">Our Greatest Minds</h4>
                            <p class="text-muted para-desc mx-auto mb-0">Start working with <span class="text-primary fw-bold">{{ getSetting('app_name') }}ck</span> that can provide everything you need to generate awareness, drive traffic, connect.</p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="col-lg-3 col-md-6 mt-4 pt-2">
                            <div class="card team team-primary text-center bg-transparent border-0">
                                <div class="card-body p-0">
                                    <div class="position-relative">
                                        <img src="{{ asset('frontend/assets/img/client/01.jpg') }}" class="img-fluid avatar avatar-ex-large rounded-circle" alt="">
                                        <ul class="list-unstyled mb-0 team-icon">
                                            <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="facebook" class="icons"></i></a></li>
                                            <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="instagram" class="icons"></i></a></li>
                                            <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="twitter" class="icons"></i></a></li>
                                            <li class="list-inline-item"><a href="javascript:void(0)" class="btn btn-primary btn-pills btn-sm btn-icon"><i data-feather="linkedin" class="icons"></i></a></li>
                                        </ul><!--end icon-->
                                    </div>
                                    <div class="content pt-3 pb-3">
                                        <h5 class="mb-0"><a href="javascript:void(0)" class="name text-dark">Ronny Jofra</a></h5>
                                        <small class="designation text-muted">C.E.O</small>
                                    </div>                                
                                </div>
                            </div>
                        </div><!--end col-->
                    @endfor
                </div><!--end row-->
            </div><!--end container--> --}}

            <div class="container mt-100 mt-60">
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <div class="section-title">
                            <h4 class="title mb-4">Join us to be part of India's digital distribution network.</h4>
                            <p class="text-muted para-desc mx-auto w-90">Sending CV is so old school, send your paper-less application in 1 minute. Scan below QR code now </p>
                        
                            <div class="mt-4">
                                 {!! QrCode::size(125)->generate('https://forms.gle/wCX81ah3XKY1FPzG8') !!}
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- Team End -->



@endsection

@push('script')

@endpush