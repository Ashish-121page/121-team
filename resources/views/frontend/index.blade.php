@extends('frontend.layouts.main')

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

    @include('frontend.sections.hero')

    @include('frontend.sections.client')

    @include('frontend.sections.about')

    @include('frontend.sections.service')

    @include('frontend.sections.package')
    
    @include('frontend.sections.faq')
    
    @include('frontend.sections.testimonial')
    
    @include('frontend.sections.blog')
    
    @include('frontend.sections.subscription')
    
    @include('frontend.sections.contact')
        
@endsection