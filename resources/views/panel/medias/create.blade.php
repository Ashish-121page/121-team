@extends('backend.layouts.main') 
@section('title', 'Media')
@section('content')
@php
/**
 * Media 
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
    ['name'=>'Add Media', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <style>
        .error{
            color:red;
        }
    </style>
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>Add Media</h5>
                            <span>Create a record for Media</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- start message area-->
               @include('backend.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-header">
                        <h3>Create Media</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.medias.store') }}" method="post" enctype="multipart/form-data" id="MediaForm">
                            @csrf
                            <div class="row">
                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
                                        <label for="type" class="control-label">Type<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="type" type="text" id="type" value="{{old('type')}}" placeholder="Enter Type" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('type_id') ? 'has-error' : ''}}">
                                        <label for="type_id" class="control-label">Type Id<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="type_id" type="number" id="type_id" value="{{old('type_id')}}" placeholder="Enter Type Id" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('file_name') ? 'has-error' : ''}}">
                                        <label for="file_name" class="control-label">File Name<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="file_name" type="text" id="file_name" value="{{old('file_name')}}" placeholder="Enter File Name" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('path') ? 'has-error' : ''}}">
                                        <label for="path" class="control-label">Path<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="path" type="text" id="path" value="{{old('path')}}" placeholder="Enter Path" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('extension') ? 'has-error' : ''}}">
                                        <label for="extension" class="control-label">Extension</label>
                                        <input  class="form-control" name="extension" type="text" id="extension" value="{{old('extension')}}" placeholder="Enter Extension" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('file_type') ? 'has-error' : ''}}">
                                        <label for="file_type" class="control-label">File Type</label>
                                        <input  class="form-control" name="file_type" type="text" id="file_type" value="{{old('file_type')}}" placeholder="Enter File Type" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('tag') ? 'has-error' : ''}}">
                                        <label for="tag" class="control-label">Tag</label>
                                        <input  class="form-control" name="tag" type="text" id="tag" value="{{old('tag')}}" placeholder="Enter Tag" >
                                    </div>
                                </div>
                                                            
                                <div class="col-md-12 ml-auto">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Create</button>
                                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{asset('backend/js/form-advanced.js') }}"></script>
    <script>
        $('#MediaForm').validate();
                                                                                                                                                    
    </script>
    @endpush
@endsection
