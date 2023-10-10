@extends('backend.layouts.main') 
@section('title', 'file')
@section('content')
    <div class="container-fluid">
        {{-- <div class="row">
            <div class="col-md-12 col-sm-12">
               <textarea id="my-editor" name="content" class="form-control my-editor">{!! old('content', 'test editor content') !!}</textarea>
            </div>
        </div> --}}
        <div class="row">
            <div class="col-md-12 col-sm-12">
               <textarea  name="content" class="form-control ckeditor">{!! old('content', 'ckeditor content') !!}</textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="input-group">
                    <span class="input-group-btn">
                      <a id="lfmi" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                        <i class="ik ik-image"></i> Choose
                      </a>
                    </span>
                    <input id="thumbnail" class="form-control" type="text" name="filepath">
                </div>
                  <img id="holder" style="margin-top:15px;max-height:100px;">
                <div class="input-group">
                    <span class="input-group-btn">
                      <a id="lfmf" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                        <i class="ik ik-image"></i> Choose
                      </a>
                    </span>
                    <input id="thumbnail" class="form-control" type="text" name="filepath">
                </div>
                  <img id="holder" style="margin-top:15px;max-height:100px;">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <iframe src="{{ url('/laravel-filemanager') }}" style="width: 100%; height: 100vh; overflow: hidden; border: none;"></iframe>
            </div>
        </div>
    </div>
@endsection
@push('script') 

    {{-- normal editor js --}}
    {{-- <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script>
      
        var options = {
                filebrowserImageBrowseUrl: "{{ url('/laravel-filemanager?type=Images') }}",
                filebrowserImageUploadUrl: "{{ url('/laravel-filemanager/upload?type=Images&_token='.csrf_token()) }}",
                filebrowserBrowseUrl: "{{ url('/laravel-filemanager?type=Files') }}",
                filebrowserUploadUrl: "{{ url('/laravel-filemanager/upload?type=Files&_token='.csrf_token()) }}"
            };
            $(window).on('load', function (){
                CKEDITOR.replace('my-editor', options);
            });
    </script> --}}
    {{-- 2nd Advanced editor --}}
    
    <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script> 
    <script>
      
        var options = {
                filebrowserImageBrowseUrl: "{{ url('/laravel-filemanager?type=Images') }}",
                filebrowserImageUploadUrl: "{{ url('/laravel-filemanager/upload?type=Images&_token='.csrf_token()) }}",
                filebrowserBrowseUrl: "{{ url('/laravel-filemanager?type=Files') }}",
                filebrowserUploadUrl: "{{ url('/laravel-filemanager/upload?type=Files&_token='.csrf_token()) }}"
            };
            $(window).on('load', function (){
                CKEDITOR.replace('ckeditor', options);
            });
    </script>

        {{-- laravel button filemanager js --}}
        <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
        <script>
            var route_prefix = "url-to-filemanager";
            var route = "{{ url('/laravel-filemanager') }}";

            // for image
            $('#lfmi').filemanager('image');
            $('#lfmi').filemanager('image', {prefix:route});
            // for files
            $('#lfmf').filemanager('file');
            $('#lfmf').filemanager('file', {prefix:route});
        </script>


        {{-- for embeded filemanager --}}
        <script>
            var lfm = function(id, type, options) {
                let button = document.getElementById(id);

                button.addEventListener('click', function () {
                    var route_prefix = (options && options.prefix) ? options.prefix : "{{ url('/laravel-filemanager') }}";
                    var target_input = document.getElementById(button.getAttribute('data-input'));
                    var target_preview = document.getElementById(button.getAttribute('data-preview'));
                   
                    window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
                    window.SetUrl = function (items) {
                    var file_path = items.map(function (item) {
                        return item.url;
                    }).join(',');

                    // set the value of the desired input to image url
                    target_input.value = file_path;
                    target_input.dispatchEvent(new Event('change'));

                    // clear previous preview
                    target_preview.innerHtml = '';

                    // set or change the preview image src
                    items.forEach(function (item) {
                        let img = document.createElement('img')
                        img.setAttribute('style', 'height: 5rem')
                        img.setAttribute('src', item.thumb_url)
                        target_preview.appendChild(img);
                    });

                    // trigger change event
                    target_preview.dispatchEvent(new Event('change'));
                    };
                });
            };

            var route_prefix = "url-to-filemanager";
            lfm('lfm', 'image', {prefix: "{{ url('/laravel-filemanager') }}"});
            lfm('lfm2', 'file', {prefix: "{{ url('/laravel-filemanager') }}"});
        </script>
@endpush