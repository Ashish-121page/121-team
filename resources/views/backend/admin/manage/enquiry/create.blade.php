@extends('backend.layouts.main') 
@section('title', 'Enquiry')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Add Enquiry', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>{{ __('Create New Enquiry')}}</h5>
                            {{-- <span>{{ __('Add a new record for Enquiry')}}</span> --}}
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
                        <h3>{{ __('Add Enquiry')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.admin.enquiry.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="row">
                                        
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('client_name') ? 'has-error' : ''}}">
                                                <label for="client_name" class="control-label">{{ 'Client Name' }} <span class="text-danger">*</span> </label>
                                                <input class="form-control" name="client_name" type="text" id="client_name" value="{{ isset($enquiry->client_name) ? $enquiry->client_name : ''}}" required placeholder="Enter Client Name">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('client_email') ? 'has-error' : ''}}">
                                                <label for="client_email" class="control-label">{{ 'Client Email' }} <span class="text-danger">*</span></label>
                                                <input class="form-control" name="client_email" type="email" id="client_email" value="{{ isset($enquiry->client_email) ? $enquiry->client_email : ''}}" required placeholder="Enter Client Email">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                                                <label for="title" class="control-label">{{ 'Title' }}<span class="text-danger">*</span></label>
                                                <input class="form-control" name="title" type="text" id="title" value="{{ isset($enquiry->title) ? $enquiry->title : ''}}"  placeholder="Enter Title" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('enquiry_type_id') ? 'has-error' : ''}}">
                                                <label for="enquiry_type_id" class="control-label">{{ 'Type' }}<span class="text-danger">*</span></label>
                                                <select required name="enquiry_type_id" id="enquiry_type_id" class="form-control select2">
                                                    <option value="" readonly>{{ __('Select Type')}}</option>
                                                    @foreach (fetchGet('App\Models\Category', 'where', 'category_type_id', '=', 3) as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('assigned_to') ? 'has-error' : ''}}">
                                                <label for="assigned_to">{{ __('Assigned to')}}</label>
                                                <select name="assigned_to" id="assigned_to" class="form-control select2">
                                                    <option value="" readonly>{{ __('Select User')}}</option>
                                                    @foreach (UserList() as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                                                <label for="status">{{ __('Status')}}</label>
                                                <select name="status" id="status" class="form-control select2">
                                                    <option value="" readonly>{{ __('Select Status')}}</option>
                                                    @foreach (getEnquiryStatus() as $item)
                                                        <option value="{{ $item['id'] }}">{{ $item['name'] }}</option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                                <label for="description" class="control-label">{{ 'Note' }}</label>
                                                <textarea class="form-control" name="description" id="description" value="" placeholder="Add Note">{{ isset($enquiry->description) ? $enquiry->description : ''}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-right">
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
    @endpush
@endsection
