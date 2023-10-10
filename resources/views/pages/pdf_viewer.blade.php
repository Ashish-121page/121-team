{{-- Extends to layout file --}}
@extends('backend.layouts.main')

{{-- Set page title --}}
@section('title', 'Pdf Viewer')

{{-- Add internal css styling --}}
@push('head')
<link rel="stylesheet" href="{{ asset('backend/plugins/pdf_viewer/wow_book/normalize.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('backend/plugins/pdf_viewer/wow_book/wow_book.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ asset('backend/plugins/pdf_viewer/wow_book/main.css') }}" type="text/css" />
<script src="{{ asset('backend/plugins/pdf_viewer/wow_book_js/vendor/modernizr-2.7.1.min.js')}}"></script>
@endpush

{{-- Main page content start --}}
@section('content')
 @php
     $path = asset('storage/files/1/example.pdf');
 @endphp
<div class="container">
   <div class="row">
      <div class="col-md-12 col-xs-12">
         <div class='book_container'>
            <div id="book"></div>
         </div>
      </div>
   </div>
</div>

@endsection
{{-- // Main page content ends --}}

{{-- Add Internal scripts --}}
@push('script')

<script src="{{ asset('backend/plugins/pdf_viewer/wow_book_js/vendor/jquery-1.11.2.min.js')}}"></script>

<script src="{{ asset('backend/plugins/pdf_viewer/wow_book_js/helper.js')}}"></script>

<script type="text/javascript" src="{{ asset('backend/plugins/pdf_viewer/wow_book/pdf.combined.min.js')}}"></script>
<script src="{{ asset('backend/plugins/pdf_viewer/wow_book/wow_book.min.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function() {
     
     var path = "{{ $path }}";
   //   alert(path);
     var bookOptions = {
				 height   : 500
				,width    : 800
				// ,maxWidth : 800
				,maxHeight : 600

				,centeredWhenClosed : true
				,hardcovers : true
				,pageNumbers: false
				,toolbar : "lastLeft, left, right, lastRight, find, toc, zoomin, zoomout, slideshow, flipsound, fullscreen, thumbnails"
				,thumbnailsPosition : 'left'
				,responsiveHandleWidth : 50

				,container: window
				,containerPadding: "20px"
				// ,toolbarContainerPosition: "top" // default "bottom"
            ,pdfFind: true
				// The pdf and your webpage must be on the same domain
				,pdf: path

				
			};
     $('#book').wowBook( bookOptions ); // create the book
  });
</script>
@endpush
