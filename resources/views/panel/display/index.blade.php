@extends('backend.layouts.main') 
@section('title', 'Product')
@section('content')

<div class="container-fluid p-0 m-0">
    <iframe src="{{ inject_subdomain('shop', $user_shop->slug) }}" style="width: 100%; height: 85vh; overflow: hidden; border: none;"></iframe>
    {{-- <iframe src="http://devtest.localhost/project/121.page-Laravel/121.page/shop" style="width: 100%; height: 85vh; overflow: hidden; border: none;"></iframe> --}}
</div>

@endsection
