{{-- Extends to layout file --}}
@extends('backend.layouts.main')

{{-- Set page title --}}
@section('title', 'Image Drag & Drop & Cropper')

{{-- Add internal css styling --}}
@push('head')

<link rel="stylesheet" type="text/css" href="{{ asset('backend/css/imgareaselect.css') }}" />
@endpush

{{-- Main page content start --}}
@section('content')
<div class="container">
   <div class="row">
      <div class="col-12 ">
          <div class="card">
              <div class="card-header">
                  Please drag and image on file upload and crop it from the preview.
              </div>
              <div class="card-body">
                    <form action="{{ route('dev.drag.cropper.post') }}" enctype="multipart/form-data" method="post" onsubmit="return checkCoords();">
                        @csrf
                        <p>Image: 
                        <input name="image" id="fileInput" class="form-control" size="30" type="file" /></p>
                        <input type="hidden" id="x" name="x" />
                        <input type="hidden" id="y" name="y" />
                        <input type="hidden" id="w" name="w" />
                        <input type="hidden" id="h" name="h" />
                        <input name="upload" type="submit" value="Upload" />
                    </form>
                 <div class="mt-2">
                    <p><img id="filePreview" style="display:none;"/></p>
                 </div>

              </div>
          </div>
      </div>
   </div>
</div>

@endsection
{{-- // Main page content ends --}}

{{-- Add Internal scripts --}}
@push('script')
<script type="text/javascript" src="{{ asset('backend/js/jquery.imgareaselect.js') }}"></script>
<script>
    //set image coordinates
    function updateCoords(im,obj){
      $('#x').val(obj.x1);
      $('#y').val(obj.y1);
      $('#w').val(obj.width);
      $('#h').val(obj.height);
  }
  
  //check coordinates
  function checkCoords(){
      if(parseInt($('#w').val())) return true;
      alert('Please select a crop region then press submit.');
      return false;
  }
  
  $(document).ready(function(){
      //prepare instant image preview
      var p = $("#filePreview");
      $("#fileInput").change(function(){
          //fadeOut or hide preview
          p.fadeOut();
  
          //prepare HTML5 FileReader
          var oFReader = new FileReader();
          oFReader.readAsDataURL(document.getElementById("fileInput").files[0]);
  
          oFReader.onload = function (oFREvent) {
              p.attr('src', oFREvent.target.result).fadeIn();
          };
      });
  
      //implement imgAreaSelect plugin
      $('img#filePreview').imgAreaSelect({
          // set crop ratio (optional)
          //aspectRatio: '2:1',
          onSelectEnd: updateCoords
      });
  });
</script>
@endpush
