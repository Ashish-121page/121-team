@extends('backend.layouts.main') 
@section('title', 'Product')
@section('content')

<div class="container-fluid p-0 m-0">
    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
    <iframe src="{{ inject_subdomain('shop', $user_shop->slug) }}/{{ $encid }}" style="width: 100%; height: 85vh; overflow: hidden; border: none;"></iframe>
</div>

@endsection
