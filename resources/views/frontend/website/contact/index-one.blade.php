@extends('frontend.layouts.new-main')

@section('meta_data')
    @php
		$meta_title = 'Contact us | '.getSetting('app_name');		
		$meta_description = 'If you have any query, feel free to contact us!' ?? getSetting('seo_meta_description');
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
    p span{
        font-size: 1.2rem
    }
    p span b{
        /* font-weight: 400 */
    }
</style>


<!-- Shape Start -->
<!-- Shape Start -->

        @php
            $page_title = "Contact";
        @endphp
        @include('frontend.website.breadcrumb-one')
        <div class="position-relative">
            <div class="shape overflow-hidden text-white">
                <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
                </svg>
            </div>
        </div>
<!--Shape End-->

<!-- Start Contact -->
        <section class="section pb-0">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card border-0 text-center features feature-primary feature-clean">
                            <div class="icons text-center mx-auto">
                                <i class="uil uil-phone d-block rounded h3 mb-0"></i>
                            </div>
                            <div class="content mt-4">
                                <h5 class="fw-bold">Phone</h5>
                                {{-- <p class="text-muted">Start working with 121.page that can provide everything</p> --}}
                                <a href="tel:+{{ getSetting('frontend_footer_phone') }}" class="read-more">{{ getSetting('frontend_footer_phone') }}</a>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-md-4 mt-4 mt-sm-0 pt-2 pt-sm-0">
                        <div class="card border-0 text-center features feature-primary feature-clean">
                            <div class="icons text-center mx-auto">
                                <i class="uil uil-envelope d-block rounded h3 mb-0"></i>
                            </div>
                            <div class="content mt-4">
                                <h5 class="fw-bold">Email</h5>
                                {{-- <p class="text-muted">Start working with 121.page that can provide everything</p> --}}
                                <a href="mailto:{{ getSetting('frontend_footer_email') }}" class="read-more">{{ getSetting('frontend_footer_email') }}</a>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-md-4 mt-4 mt-sm-0 pt-2 pt-sm-0">
                        <div class="card border-0 text-center features feature-primary feature-clean">
                            <div class="icons text-center mx-auto">
                                <i class="uil uil-map-marker d-block rounded h3 mb-0"></i>
                            </div>
                            <div class="content mt-4">
                                <h5 class="fw-bold">Location</h5>
                                {{-- <p class="text-muted">{{nl2br(getSetting('frontend_footer_address'))}}</p> --}}
                                <a href="#map-location"
                                    data-type="iframe" class="video-play-icon read-more lightbox">View on Google map</a>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
            <div class="container mt-100 mt-60">
                <div class="row align-items-center">
                    <div class="col-lg-7 col-md-6 pt-2 pt-sm-0 order-2 order-md-1">
                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success','Thank you for contacting us! Our team of experts
                                will get in touch with you shortly.') }}
                            </div>
                        @endif
                        <div class="card shadow rounded border-0">
                            <div class="card-body py-5">
                                <h4 class="card-title">Get In Touch !</h4>
                                <div class="custom-form mt-3">
                                    <form method="post" action="{{ route('contact-us.store') }}">
                                        @csrf
                                        <p id="error-msg" class="mb-0"></p>
                                        <div id="simple-msg"></div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Your Name <span class="text-danger">*</span></label>
                                                    <div class="form-icon position-relative">
                                                        <i data-feather="user" class="fea icon-sm icons"></i>
                                                        <input required name="name" id="name" type="text" class="form-control ps-5" placeholder="Name :">
                                                    </div>
                                                </div>
                                            </div>
        
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Your Email <span class="text-danger">*</span></label>
                                                    <div class="form-icon position-relative">
                                                        <i data-feather="mail" class="fea icon-sm icons"></i>
                                                        <input required name="email" id="email" type="email" class="form-control ps-5" placeholder="Email :">
                                                    </div>
                                                </div> 
                                            </div><!--end col-->
        
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Subject <span class="text-danger">*</span></label>
                                                    <div class="form-icon position-relative">
                                                        <i data-feather="book" class="fea icon-sm icons"></i>
                                                        <input name="subject" id="subject" class="form-control ps-5" placeholder="Subject :" required>
                                                    </div>
                                                </div>
                                            </div><!--end col-->
        
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Comments <span class="text-danger">*</span></label>
                                                    <div class="form-icon position-relative">
                                                        <i data-feather="message-circle" class="fea icon-sm icons clearfix"></i>
                                                        <textarea required name="description" id="comments" rows="4" class="form-control ps-5" placeholder="Message :"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" id="submit" name="send" class="btn btn-primary">Send Message</button>
                                                </div>
                                            </div><!--end col-->
                                        </div><!--end row-->
                                    </form>
                                </div><!--end custom-form-->
                            </div>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-5 col-md-6 order-1 order-md-2">
                        <div class="card border-0">
                            <div class="card-body p-0">
                                <img src="{{ asset('frontend/assets/img/contact.svg') }}" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->

            <div class="container-fluid mt-100 mt-60">
                <div class="row">
                    <div class="col-12 p-0">
                        <div class="card map border-0" id="map-location">
                            <div class="card-body p-0">
                                {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d39206.002432144705!2d-95.4973981212445!3d29.709510002925988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8640c16de81f3ca5%3A0xf43e0b60ae539ac9!2sGerald+D.+Hines+Waterwall+Park!5e0!3m2!1sen!2sin!4v1566305861440!5m2!1sen!2sin" style="border:0" allowfullscreen></iframe> --}}

                                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d28015.221528783575!2d77.28332800000001!3d28.632678400000003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1653294602737!5m2!1sen!2sin" style="border:0;width:100%!important" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- End contact -->

@endsection

@push('script')

@endpush        