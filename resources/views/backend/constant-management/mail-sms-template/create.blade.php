@extends('backend.layouts.main')
@section('title', 'Mail Text Template')
@section('content')
@php
    $breadcrumb_arr = [
    ['name'=>'Add Mail Text Template', 'url'=> "javascript:void(0);", 'class' => '']
    ]
@endphp
<!-- push external head elements to head -->
@push('head')
@endpush

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-mail bg-blue"></i>
                    <div class="d-inline">
                        <h5>{{ __('Create New Mail Text Template') }}</h5>
                        {{-- <span>{{ __('Add a new record for Mail Text Template') }}</span> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                @include('backend.include.breadcrumb')
            </div>
        </div>
    </div>
    <div class="row">
        <!-- start message area-->
        @include('backend.include.message')
        <!-- end message area-->
        <div class="col-md-8 mx-auto">
            <div class="card ">
                <div class="card-header">
                    <h3>{{ __('Add Template') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('panel.constant_management.mail_sms_template.store') }}"
                        method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div
                                    class="form-group {{ $errors->has('code') ? 'has-error' : '' }}">
                                    <label for="code" class="control-label">{{ 'Code' }}<span
                                            class="text-red">*</span></label>
                                    <input class="form-control" name="code" type="text" id="code"
                                        placeholder="Enter code"
                                        value="{{ isset($smstemplate->code) ? $smstemplate->code : '' }}"
                                        required>
                                </div>

                            </div>
                            <div class="col-md-4">

                                <div
                                    class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                    <label for="title" class="control-label">{{ 'Title' }}<span
                                            class="text-red">*</span></label>
                                    <input class="form-control" name="title" type="text" id="title"
                                        placeholder="Enter value"
                                        value="{{ isset($smstemplate->title) ? $smstemplate->title : '' }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div
                                    class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                    <label for="type">{{ __('Type') }}<span
                                            class="text-red">*</span></label>
                                    <select required name="type" id="type" class="form-control select2">
                                        <option value="1">{{ __('Mail') }}</option>
                                        <option value="2">{{ __('SMS') }}</option>
                                        <option value="3">{{ __('Whatapp') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="help-block with-errors"></div>

                            <div class="col-12">
                                <div class="form-group {{ $errors->has('variables') ? 'has-error' : '' }}">
                                    <label for="variables"
                                        class="control-label">{{ 'Variables' }}</label><span class="text-danger">*</span>
                                    <textarea class="form-control" rows="5" name="variables" placeholder="Text Info"
                                        type="textarea" id="variables"
                                        required>{{ isset($smstemplate->variables) ? $smstemplate->variables : '' }}</textarea>
                                    {{ "Space between Variable. Example: {name}, {id}" }}
                                </div>
                            </div>
                            <div class="col-12 mx-auto"> 
                                <label for="body"
                                class="control-label">{{ 'Body' }}</label><span class="text-danger">*</span>
                                <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                                    <div id="mail-content">
                                        <textarea  name="mail_body" class="form-control ckeditor description" rows="5" >{!! old('body', 'Content Body') !!}</textarea>
                                    </div>
                                    <div id="plain-content" class="d-none">
                                        <textarea  name="body" class="form-control desc ">{!! old('body', 'Content Body') !!}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group {{ $errors->has('footer') ? 'has-error' : '' }}">
                                    <label for="footer"
                                        class="control-label">{{ 'Footer' }}</label>
                                    <textarea class="form-control" rows="5" name="footer" placeholder="Footer"
                                        type="textarea" id="footer"
                                        >{{old('footer') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group mx-3 text-right">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- push external js -->
@push('script')
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
    $('#type').change(function(){
        if($('#type').val() == 1){
            $('#mail-content').removeClass('d-none');
            $('#plain-content').addClass('d-none');
          
        }else{
            $('#plain-content').removeClass('d-none');
            $('#mail-content').addClass('d-none');
        }
    });
</script>

@endpush
@endsection
