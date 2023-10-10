@extends('backend.layouts.main') 
@section('title', 'Mail text Template')
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
                            <h5>{{ __('Edit Mail Text Template')}}</h5>
                            {{-- <span>{{ __('Update a record for Mail Text Template')}}</span> --}}
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
                        <h3>{{ __('Update Template')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.constant_management.mail_sms_template.update', $mail_sms->id) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('code') ? 'has-error' : ''}}">
                                        <label for="code" class="control-label">{{ 'Code' }}<span class="text-red">*</span></label>
                                        <input class="form-control" name="code" type="text" id="code" required value="{{ isset($mail_sms->code) ? $mail_sms->code : ''}}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                                        <label for="title" class="control-label">{{ 'Title' }}<span class="text-red">*</span></label>
                                        <input class="form-control" name="title" type="text" id="title"  required value="{{ isset($mail_sms->title) ? $mail_sms->title : ''}}" required>
                                    </div>
                                </div>
                                {{-- <div class="col-md-4">
                                    <div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
                                        <label for="type">{{ __('Type')}}<span class="text-red">*</span></label>
                                        <select  required name="type" id="type" value="{{ isset($mail_sms->type) ? $mail_sms->type : 'selected'}}" class="form-control select2">
                                            <option value="" readonly>{{ __('Select Type')}}</option>
                                            <option value="1" {{ $mail_sms->type == 1 ? 'selected' : ''}}>{{ __('Mail')}}</option> 
                                            <option value="2" {{ $mail_sms->type == 2 ? 'selected' : ''}}>{{ __('SMS')}}</option>
                                            <option value="2" {{ $mail_sms->type == 3 ? 'selected' : ''}}>{{ __('Whatsapp')}}</option>
                                        </select>
                                        
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="form-group {{ $errors->has('variables') ? 'has-error' : ''}}">
                                        <label for="variables" class="control-label">{{ 'Variables' }}</label>
                                        <textarea class="form-control" rows="5" name="variables" type="textarea" id="variables" >{{ isset($mail_sms->variables) ? $mail_sms->variables : ''}}</textarea>
                                        {{ "Space between Variable. Example: {name}, {id}" }}
                                    </div>
                                </div>
                                <div class="col-12 mx-auto">
                                    <div
                                        class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                                        <label for="body" class="control-label">{{ 'Body' }}</label><span class="text-danger">*</span>
                                        @if($mail_sms->type == 1)
                                            <div id="mail-content">
                                                <textarea  name="mail_body" class="form-control ckeditor description" rows="5" >{{ isset($mail_sms->body) ? $mail_sms->body : ''}}</textarea>
                                            </div>
                                        @else
                                            <div id="plain-content">
                                                <textarea  name="body" class="form-control desc ">{{ isset($mail_sms->body) ? $mail_sms->body : ''}}</textarea>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group {{ $errors->has('footer') ? 'has-error' : '' }}">
                                        <label for="footer"
                                            class="control-label">{{ 'Footer' }}</label>
                                        <textarea class="form-control" rows="5" name="footer" placeholder="Footer"
                                            type="textarea" id="footer"
                                            >{{ isset($mail_sms->footer) ? $mail_sms->footer : '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>       
                                    
                            {{-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
                                        <label for="type">{{ __('Type')}}<span class="text-red">*</span></label>
                                        <select  required name="type" id="type" value="{{ isset($mail_sms->type) ? $mail_sms->type : 'selected'}}" class="form-control select2">
                                            <option value="" readonly>{{ __('Select Type')}}</option>
                                            <option value="1" {{ $mail_sms->type == 1 ? 'selected' : ''}}>{{ __('Mail')}}</option> 
                                            <option value="2" {{ $mail_sms->type == 2 ? 'selected' : ''}}>{{ __('SMS')}}</option>
                                            <option value="2" {{ $mail_sms->type == 3 ? 'selected' : ''}}>{{ __('Whatsapp')}}</option>
                                        </select>
                                        
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                                    <div class="form-group {{ $errors->has('body') ? 'has-error' : ''}}">
                                        <label for="body" class="control-label">{{ 'Body' }}</label>
                                        <textarea class="form-control" rows="5" name="body" type="textarea" id="body" >{{ isset($mail_sms->body) ? $mail_sms->body : ''}}</textarea>
                                    </div>
                                    <div class="form-group {{ $errors->has('variables') ? 'has-error' : ''}}">
                                        <label for="variables" class="control-label">{{ 'Variables' }}</label>
                                        <textarea class="form-control" rows="5" name="variables" type="textarea" id="variables" >{{ isset($mail_sms->variables) ? $mail_sms->variables : ''}}</textarea>
                                        {{ "Space between Variable. Example: {name}, {id}" }}
                                    </div>
                                    
                                    
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div> --}}
                                    
                                
                           
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
        </script>
    @endpush
@endsection
