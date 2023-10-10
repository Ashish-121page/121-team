@extends('backend.layouts.main') 
@section('title', 'Contact')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Add Contact', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>{{ __('Create New Contact')}}</h5>
                            <span>{{ __('Add a new record for Contact')}}</span>
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
                        <h3>{{ __('Add Contact')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.admin.contact.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-6 {{ $errors->has('first_name') ? 'has-error' : ''}}">
                                            <label for="first_name" class="control-label">{{ 'Name' }}</label>
                                            <input class="form-control" name="first_name" type="text" id="first_name" placeholder="Enter First Name" value="{{ isset($contact->name) ? $contact->name : ''}}" required>
                                        </div>
                                        <div class="form-group col-md-6 {{ $errors->has('last_name') ? 'has-error' : ''}}">
                                            <label for="last_name" class="control-label">{{ 'Last Name' }}</label>
                                            <input class="form-control" name="last_name" type="text" id="last_name" placeholder="Enter Last Name"  value="{{ isset($contact->last_name) ? $contact->last_name : ''}}" required>
                                        </div>
                                        <div class="form-group col-md-6 {{ $errors->has('job_title') ? 'has-error' : ''}}">
                                            <label for="job_title" class="control-label">{{ 'Job Title' }}</label>
                                            <input class="form-control" name="job_title" type="text" id="job_title" placeholder="Enter Job Title" value="{{ isset($contact->job_title) ? $contact->job_title : ''}}" required>
                                        </div>
                                        <div class="form-group col-md-6 {{ $errors->has('email') ? 'has-error' : ''}}">
                                            <label for="email" class="control-label">{{ 'Email' }}</label>
                                            <input class="form-control" name="email" type="email" id="email" placeholder="Enter Email" value="{{ isset($contact->email) ? $contact->email : ''}}" required>
                                        </div>
                                        <div class="form-group col-md-6 {{ $errors->has('Phone') ? 'has-error' : ''}}">
                                            <label for="phone" class="control-label">{{ 'phone' }}</label>
                                            <input class="form-control" name="phone" type="number" id="phone" placeholder="Enter Phone" value="{{ isset($contact->phone) ? $contact->phone : ''}}" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="gender">{{ __('Gender')}}<span class="text-red">*</span></label>
                                            <div class="form-radio form-group">
                                                <div class="radio radio-inline">
                                                    <label>
                                                            <input type="radio" name="gender" value="male" checked>
                                                            <i class="helper"></i>{{ __('Male')}}
                                                        </label>
                                                    </div>
                                                    <div class="radio radio-inline">
                                                        <label>
                                                            <input type="radio" name="gender" value="female">
                                                            <i class="helper"></i>{{ __('Female')}}
                                                        </label>
                                                    </div>
                                                </div> 
                                            </div>   
                                        </div>

                                </div>
                                <div class="col-md-12 mx-auto"> 
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
