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
		$website = 1;	
	@endphp
@endsection

@section('content')
      
    @include('frontend.website.include.hero')
    {{-- @include('frontend.website.include.client')  --}}
    <div class="section">
         @include('frontend.website.include.key-features') 
        {{-- @include('frontend.website.include.analytics')
        @include('frontend.website.include.testimonial')  --}}
         {{-- @include('frontend.website.include.call-to-action') --}}
    </div>

@endsection