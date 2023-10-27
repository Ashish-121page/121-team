@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = 'Contact | '.getSetting('app_name');		
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'GRPL';		
		$meta_author_email = '' ?? 'Hello@121.page';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';		
		$microsite = 1;		
	@endphp
@endsection

@section('content')
<style>
    .magic {
    padding: 20px 0;
    background-size: cover;
    align-self: center;
    position: relative;
    background-position: center center
    }
</style>
<section class="bg-half-170 bg-light d-table w-100 strip-bg-img">
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="pages-heading">
                    <h4 class="title mb-0"> Contact Us </h4>
                </div>
            </div><!--end col-->
        </div><!--end row-->
        
        <div class="position-breadcrumb">
            <nav aria-label="breadcrumb" class="d-inline-block">
                <ul class="breadcrumb bg-white rounded shadow mb-0 px-4 py-2">
                    <li class="breadcrumb-item"><a href="{{ route('pages.index',$slug) }}">Home</a></li>
                    
                    <li class="breadcrumb-item active" aria-current="page">Contact</li>
                </ul>
            </nav>
        </div>
    </div> <!--end container-->
</section><!--end section-->
    <div class="position-relative">
        <div class="shape overflow-hidden text-white">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
            </svg>
        </div>
    </div>
    @php
        $contact_info = json_decode($user_shop->contact_info);
        $address = json_decode($user_shop->address);
        $user = App\User::whereId($user_shop->user_id)->first();
    @endphp
    <section class="section pb-0">


        @if ($user->ekyc_status == 1)
            @if (json_decode($user->ekyc_info)->document_number ?? "" != null)
                <div class="text-center">
                    <p style="text-transform: uppercase">
                        <i title="eKyc Verified" class="fa fa-check-circle fa-sm text-success"></i>
                        <b>{{ $user_shop->name }}</b>
                    </p>
                    <p>Verified GST # <b>{{ json_decode($user->ekyc_info)->document_number}}</b></p>
                </div>
            @endif
        @endif

        
        @include('frontend.sections.features')
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
                                    <form method="post" action="{{ route('pages.contact.store',$slug) }}">
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
                                                    <label class="form-label">Subject</label>
                                                    <div class="form-icon position-relative">
                                                        <i data-feather="book" class="fea icon-sm icons"></i>
                                                        <input name="subject" id="subject" class="form-control ps-5" placeholder="Subject :">
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
                    <div class="card map border-0">
                        <div class="card-body p-0">
                            {{-- @if (isset($user_shop->embedded_code))
                                {!! $user_shop->embedded_code !!}
                            @endif --}}

                            @if (isset($user_shop->embedded_code))  
                                <iframe src="{!! urldecode($user_shop->embedded_code) !!}" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>                                
                            @endif
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
    </section>
@endsection    