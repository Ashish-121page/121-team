@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = 'Home |'.getSetting('app_name');		
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
<section class="" style="margin-top: 15rem;">
    <div class="container text-center">
    <h1>You are currently not connected to any networks.</h1>
    </div>
</section>
@endsection