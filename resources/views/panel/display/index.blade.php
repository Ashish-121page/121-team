@extends('backend.layouts.main') 
@section('title', 'Product')
@section('content')

{{-- @push('head')

    <style>
        @media (min-width: 768px) and (max-width: 991.98px) {
            .col-md-6.flex-wrap {
                flex-wrap: nowrap;
            }
        }
    </style>
    
@endpush --}}

<div class="container-fluid p-0 m-0">
    <iframe src="{{ inject_subdomain('shop', $user_shop->slug) }}" style="width: 100%; height: 85vh; overflow: hidden; border: none;"></iframe>
    {{-- <iframe src="http://devtest.localhost/project/121.page-Laravel/121.page/shop" style="width: 100%; height: 85vh; overflow: hidden; border: none;"></iframe> --}}
</div>

@endsection
