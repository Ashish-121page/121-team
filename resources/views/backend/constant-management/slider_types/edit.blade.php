@extends('backend.layouts.main') 
@section('title', 'Slider Group')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Edit Slider Group', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Edit Slider Group</h5>
                            {{-- <span>Update a record for Slider Group</span> --}}
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
                        <h3>Update Slider Group</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('backend.constant-management.slider_types.update',$slider_type->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                                        <label for="title" class="control-label">Headline<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="title" type="text" id="title" value="{{$slider_type->title }}">
                                    </div>
                                </div>
                                <div class="col-md-12 col-12">                
                                    <div class="form-group">
                                        <label for="short_text" class="control-label">Sub Headline</label>
                                        <textarea  class="form-control" name="short_text" id="short_text" placeholder="Enter Sub Headline">{{$slider_type->short_text }}</textarea>
                                    </div>
                                </div>
                                 <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="remark" class="control-label">Remark <span class="text-danger">(private)</span></label>
                                        <textarea  class="form-control" name="remark" id="remark" placeholder="Enter Remark">{{$slider_type->remark }}</textarea>
                                    </div>
                                </div>
                                                                            
                                <div class="col-md-12 mx-auto">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
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
    @endpush
@endsection
