@extends('backend.layouts.main') 
@section('title', 'Website Enquiry')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Add Website Enquiry', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>{{ __('Create New Website Enquiry')}}</h5>
                            {{-- <span>{{ __('Add a new record for Website Enquiry')}}</span> --}}
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
                        <h3>{{ __('Add Website Enquiry')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.constant_management.user_enquiry.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="status" value="0">
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                                <label for="name" class="control-label">{{ 'Name' }}<span class="text-red">*</span></label>
                                                <input class="form-control" name="name" type="text" id="name" value="" placeholder="Enter Your Name" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                                                <label for="email" class="control-label">{{ 'Email' }}<span class="text-red">*</span></label>
                                                <input class="form-control" name="email" type="email" id="email" value="" placeholder="Enter Your Email" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group {{ $errors->has('contact_number') ? 'has-error' : ''}}">
                                                <label for="contact_number" class="control-label">{{ 'Contact Number' }}<span class="text-red">*</span></label>
                                                <input class="form-control" name="contact_number" type="number" id="contact_number" value="" placeholder="Enter Your Contact Number" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
                                                <label for="category_id">{{ __('Category')}}<span class="text-red">*</span></label>
                                                <select name="category_id" id="category_id" class="form-control select2" required>
                                                    <option value="" readonly required>{{ __('Select Category')}}</option>
                                                    @foreach (fetchGet('App\Models\Category', 'where', 'category_type_id', '=', 7) as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group {{ $errors->has('subject') ? 'has-error' : ''}}">
                                                <label for="subject">{{ __('Subject')}}<span class="text-red">*</span></label>
                                                <input class="form-control" name="subject" type="text" id="subject" value="" placeholder="Enter Your Subject" required>
                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                                <label for="description">{{ __('Description')}}<span class="text-red">*</span></label>
                                                <textarea class="form-control" name="description" type="text" id="description" value="" placeholder="Enter Description" required></textarea>
                                            </div>
                                        </div>
                                        {{-- <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('staff_reply') ? 'has-error' : ''}}">
                                                <label for="staff_reply">{{ __('Staff Reply')}}<span class="text-red">*</span></label>
                                                <textarea class="form-control" name="staff_reply" type="text" id="staff_reply" value="" placeholder="Enter Staff Reply" required></textarea>
                                            </div>
                                        </div> --}}
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary float-right">Create</button>
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
