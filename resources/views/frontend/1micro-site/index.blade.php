@extends('frontend.layouts.main')

@section('meta_data')
@if (request()->has('slug')) 
	<title> {{ request()->get('slug') }}</title>
	
@endif

    @php
		$meta_title =  $user_shop->meta_title. ' | ' .'Home';	
		$meta_description =  Str::limit($user_shop->meta_description,125) ?? '';	
		$meta_keywords = $user_shop->meta_keywords ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'GRPL';		
		$meta_author_email = '' ?? 'Hello@121.page';		
		$meta_reply_to = '' ?? getSetting('frontend_
        _email');		
		$meta_img = ' ';		
		$microsite = 1;		
	@endphp
@endsection

@php
	$user_id = UserShopUserIdBySlug($slug);
    $have_access_code = App\Models\AccessCode::where('redeemed_user_id',$user_id)->first();

@endphp

@section('content')
<style>
	.img::before, .img::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        z-index: 5;
    }
    .img::before {
        width: 48px;
        height: 48px;
        margin: -24px 0 0 -24px;
        background-color: #333;
        border-radius: 50%;
    }
    .img::after {
        margin: -8px 0 0 -6px;
        border-style: solid;
        border-width: 8px 0 8px 16px;
        border-color: transparent transparent transparent #fff;
    }
</style>

@php
    $contact_info = json_decode($user_shop->contact_info);
    $user_shop_social = json_decode($user_shop->social_links);
    $address = json_decode($user_shop->address);
@endphp

    @include('frontend.sections.hero')

    @include('frontend.sections.features')

    @include('frontend.sections.contact')

    @include('frontend.sections.about')

	{{-- @if($have_access_code) --}}
		{{-- @include('frontend.sections.product') --}}
		{{-- @include('frontend.sections.reviews') --}}
	{{-- @endif --}}
	@include('frontend.micro-site.about.show-video')
@endsection

@section('InlineScript')
	<script>
		$(document).ready(function(){
			var clean_uri = location.protocol +"//"+ location.host + location.pathname;
			window.history.replaceState({}, document.title, clean_uri);
		});
		$('#clipboard').on('click',function(){
			$('#socialShareModal').modal('show');
		});
		let img = document.querySelector('.img');
        function meow (){
            $('#playVideoModal').modal('show');
        }
        img.addEventListener('click', meow, false);
	</script>
@endsection