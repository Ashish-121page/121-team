@extends('backend.layouts.main') 
@section('title', 'Product')
@section('content')

<div class="container-fluid p-0 m-0">
    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
    <iframe src="http://devtest.localhost/project/121.page-Laravel/121.page/shop/{{ $encid }}" style="width: 100%; height: 85vh; overflow: hidden; border: none;"></iframe>
</div>

@endsection
