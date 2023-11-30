@extends('backend.layouts.main')
@section('title', 'edit Template')
@section('content')


    <!-- push external head elements to head -->
    @push('head')

    @endpush

    <div class="container-fluid">
        
        <div class="row d-flex justify-content-center align-items-center ">
            <div class="col-8">
                <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                    <label for="description" class="control-label">Edit Template</label>
                    <textarea name="description" class="form-control" id="description" cols="30" rows="10">{!! old('description') ?? $template->data !!}</textarea>
                </div>
            </div>    
        </div>      

    </div>
    <!-- push external js -->
    @push('script')
    <script src="{{asset('backend/js/form-advanced.js') }}"></script>


    <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>

    <script>
        var options = {
            filebrowserImageBrowseUrl: "{{ url('/laravel-filemanager?type=Images') }}",
            filebrowserImageUploadUrl: "{{ url('/laravel-filemanager/upload?type=Images&_token='.csrf_token()) }}",
            filebrowserBrowseUrl: "{{ url('/laravel-filemanager?type=Files') }}",
            filebrowserUploadUrl: "{{ url('/laravel-filemanager/upload?type=Files&_token='.csrf_token()) }}"
        };
        $(window).on('load', function (){
            CKEDITOR.replace('description', options);
        });
    </script>
    

    @endpush
@endsection
