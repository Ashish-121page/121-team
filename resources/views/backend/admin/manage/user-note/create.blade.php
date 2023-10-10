@extends('backend.layouts.main') 
@section('title', 'User Note')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Add User Note', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>{{ __('Create New User Note')}}</h5>
                            <span>{{ __('Add a new record for User Note')}}</span>
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
                        <h3>{{ __('Add User Note')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.admin.user_note.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                                        <label for="title" class="control-label">{{ 'Title' }}</label>
                                        <input class="form-control" name="title" type="text" id="title" placeholder="Enter Title" value="{{ isset($smstemplate->title) ? $smstemplate->title : ''}}" required>
                                    </div>
                                    <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                        <label for="description" class="control-label">{{ 'Description' }}</label>
                                        <textarea class="form-control" rows="5" name="description" type="textarea" id="description" placeholder="Enter Description" required>{{ isset($smstemplate->description) ? $smstemplate->description : ''}}</textarea>
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
