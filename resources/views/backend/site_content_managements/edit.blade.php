@extends('backend.layouts.main') 
@section('title', 'Paragraph Content Management')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Edit Paragraph Content Management', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Edit Paragraph Content </h5>
                            {{-- <span>Update a record for Paragraph Content </span> --}}
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
                        <h3>Update Paragraph Content </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('backend.site_content_managements.update',$site_content_management->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                                                                                            
                                    <div class="form-group ">
                                        <label for="code" class="control-label">Code <span class="text-red">*</span></label>
                                        <input required   class="form-control" name="code" type="text" id="name" value="{{$site_content_management->code }}">
                                    </div>
                                                                                                                                                
                                    <div class="form-group">
                                        <label for="value" class="control-label">Value <span class="text-red">*</span></label>
                                        <textarea required class="form-control" name="value" id="value">{{$site_content_management->value }}</textarea>
                                    </div>
                                                                                                                                                
                                    <div class="form-group">
                                        <label for="remark" class="control-label">Remark</label>
                                        <textarea  class="form-control" name="remark" id="remark">{{$site_content_management->remark }}</textarea>
                                    </div>
                                                                        
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
