@extends('backend.layouts.main') 
@section('title', 'File Manager')
@section('content')
@php
/**
 * Price Ask Request 
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    GRPL
 * @license  121.page
 * @version  <GRPL 1.1.0>
 * @link        https://121.page/
 */
    $breadcrumb_arr = [
        ['name'=>'File Manager', 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
    @endphp
    <!-- push external head elements to head -->
    @push('head')
    @endpush
    <div class="container-fluid p-0 m-0">
        <iframe src="{{ url('/laravel-filemanager') }}" style="width: 100%; height: 85vh; overflow: hidden; border: none;"></iframe>
    </div>
     @push('script')
    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        
    <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script> 

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
@endsection
