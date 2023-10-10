{{-- Extends to layout file --}}
@extends('backend.layouts.main')

{{-- Set page title --}}
@section('title', 'Image Cropper')

{{-- Add internal css styling --}}
@push('head')

<link rel="stylesheet" href="{{ asset('backend/plugins/image-cropper/imagecrop.min.css') }}">
@endpush

{{-- Main page content start --}}
@section('content')
<div class="container">
   <div class="row">
      <div class="col-12 col-md-4">
         <h5> Square/Rectangle Image </h5>
			<div class="example-1"></div>
      </div>
      <div class="col-12 col-md-4">
         <h5> Square/Rectangle with minimal Size</h5>
			<div class="example-2"></div>
      </div>
      <div class="col-12 col-md-4">
         <h5> Cicular Image with minimal Size</h5>
			<div class="example-3"></div>
      </div>
   </div>
   <div class="row mt-3">
      <div class="col-12 col-md-4">
         <h5> Square Image with minimal Size</h5>
			<div class="example-4"></div>
      </div>
      <div class="col-12 col-md-4">
         <h5> Horizontal Banner Image</h5>
			<div class="example-5"></div>
      </div>
      <div class="col-12 col-md-4">
         <h5> Vertical Banner Image</h5>
			<div class="example-6"></div>
      </div>
      <div class="col-12">
         <button onclick="callme();"> click me!</button>
      </div>
   </div>
</div>

@endsection
{{-- // Main page content ends --}}

{{-- Add Internal scripts --}}
@push('script')
<script type="text/javascript" src="{{ asset('backend/plugins/image-cropper/imagecrop.min.js') }}"></script>
<script>
  
   !function(){
      "use strict";
      new ImageCropper(".example-1","{{ asset('backend/img/portfolio-8.jpg') }}",{
         max_width:300,
         max_height:300
      }),
      new ImageCropper(".example-2","{{ asset('backend/img/portfolio-9.jpg') }}",{
         max_width:300,
         max_height:300,
         min_crop_width:50,
         min_crop_height:50
      }),
      new ImageCropper(".example-3","{{ asset('backend/img/portfolio-7.jpg') }}",{
         max_width:300,
         max_height:300,
         mode:"circular",
         min_crop_width:50,
         min_crop_height:50
      }),
      new ImageCropper(".example-4","{{ asset('backend/img/portfolio-1.jpg') }}",{
         max_width:300,
         max_height:300,
         fixed_size:!0,
         min_crop_width:50,
         min_crop_height:50
      }),
      new ImageCropper(".example-5","{{ asset('backend/img/portfolio-10.jpg') }}",{
         max_width:300,
         max_height:300,
         min_crop_width:150,
         min_crop_height:100,
      }),
      new ImageCropper(".example-6","{{ asset('backend/img/portfolio-5.jpg') }}",{
         max_width:300,
         max_height:300,
         min_crop_width:125,
         min_crop_height:200
      }),
      hljs.initHighlightingOnLoad()
}();
</script>
@endpush
