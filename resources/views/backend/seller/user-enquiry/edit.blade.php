@extends('backend.layouts.main') 
@section('title', 'User Enquiry')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'User Enquiry', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>{{ __('Update User Enquiry')}}</h5>
                            <span>{{ __('Update Enquiry')}} #ENQ{{$seller_enquiries->id}}</span>
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
                <div class="card ">
                    <div class="card-header">
                        <h3>#ENQ{{$seller_enquiries->id}}</h3>
                    </div>
                    <div class="card-body p-3">
                        <form action="{{ route('panel.seller.enquiry.update',$seller_enquiries->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                                <label for="name" class="control-label">{{ 'Name' }} <span class="text-danger">*</span></label>
                                                <input readonly class="form-control" name="name" type="text" id="name" value="{{ $seller_enquiries->name }}" placeholder="Enter Name" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                                                <label for="email">{{ __('Email')}} <span class="text-danger">*</span> </label>
                                                <input readonly class="form-control" name="email" type="text" id="email" value="{{ $seller_enquiries->email }}" placeholder="Enter Email" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                                                <label for="status">{{ __('Status')}} <span class="text-danger">*</span> </label>
                                                <select name="status" class="form-control" id="" @if(AuthRole() != "Admin") disabled @endif>
                                                    <option value="" aria-readonly="true">Select Status</option>
                                                    @foreach (getUserEnquiryStatus() as $item)
                                                        <option @if($seller_enquiries->status == $item['id']) selected @endif value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                                    @endforeach
                                                </select>   
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('subject') ? 'has-error' : ''}}">
                                                <label for="Subject">{{ __('Subject')}} <span class="text-danger">*</span> </label>
                                                <input @if(AuthRole() != "Admin") disabled @endif class="form-control" name="subject" type="text" id="subject" value="{{ $seller_enquiries->subject }}" placeholder="Enter Subject" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                                <label for="description">{{ __('Description')}}<span class="text-red">*</span>
                                                </label>
                                                <textarea @if(AuthRole() != "Admin") disabled @endif class="form-control" name="description" type="text" id="description"  placeholder="Enter Description" required>{{ $seller_enquiries->description   }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary float-right">Update</button>
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
  
@endsection
 

