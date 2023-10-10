@extends('frontend.layouts.main')

@section('meta_data')
@php
		$meta_title =  ($page->page_meta_title) ? $page->page_meta_title : getSetting('app_name');		
		$meta_description = ($page->page_meta_description) ? $page->page_meta_description : '';		
		$meta_keywords = ($page->page_keywords) ? $page->page_keywords : getSetting('app_name');		
		$meta_motto = (false) ? $page->page_keywords : getSetting('app_name');		
		// $meta_abstract = false ?? getSetting('site_motto');		
		// $meta_author_name = false ?? 'Defenzelite';		
		// $meta_author_email = false ?? 'Hello@121.page';		
		// $meta_reply_to = false ?? getSetting('contact_email');		
		// $meta_img = ' ';		
	@endphp
@endsection

@section('content')
  <!-- Start of breadcrumb section
        ============================================= -->
        <section id="breadcrumb" class="breadcrumb-section relative-position backgroud-style">
            <div class="blakish-overlay"></div>
            <div class="container">
                <div class="page-breadcrumb-content text-center">
                    <div class="page-breadcrumb-title">
                        <h2 class="breadcrumb-head black bold"><span>{{$page->title}}</span></h2>
                    </div>
                </div>
            </div>
        </section>
        <!-- End of breadcrumb section
            ============================================= -->
    
        <section id="about-page" class="about-page-section">
            <div class="container">
                <div class="row">
                    <div class=" col-md-12 ">
                        <div class="about-us-content-item">
                            @if($page->image != "")
                                <div class="about-gallery w-100 text-center">
                                    <div class="about-gallery-img d-inline-block float-none">
                                        <img src="{{asset('storage/uploads/'.$page->image)}}" alt="">
                                    </div>
                                </div>
                            @endif
                        <!-- /gallery -->
    
                            <div class="about-text-item">
                                <div class="section-title-2  headline text-left">
                                    <h2>{{$page->title}}</h2>
                                </div>
                               {!! $page->content !!}
                            </div>
                            <!-- /about-text -->
                        </div>
                    </div>
                </div>  
               
            </div>
        </section>
    
@endsection