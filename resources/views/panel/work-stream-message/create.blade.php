@extends('backend.layouts.main') 
@section('title', 'Case Workstream Message')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Add Case Workstream Message', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">

    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Create New Case Workstream Message')}}</h5>
                            <span>{{ __('Add a new record for Case Workstream Message')}}</span>
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
                        <h3>{{ __('Add Case Workstream Message')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.case_work_stream_message.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('workstream_id') ? 'has-error' : ''}}">
                                                <label for="workstream_id" class="control-label">{{ 'Case Workstream' }}</label>
                                                <select name="workstream_id" class="form-control select2" required>
                                                    <option value="" readonly>{{ 'Select Workstream' }}</option>
                                                    @foreach (fetchAll('App\Models\CaseWorkstream') as $item)
                                                        <option value="{{ $item->id }}" {{ $item->workstream_id == $item['id'] ? 'selected' :'' }}>{{ $item->author_id }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
                                                <label for="user_id" class="control-label">{{ 'Doctor' }}</label>
                                                <select name="user_id" class="form-control select2" required>
                                                    <option value="" readonly>{{ 'Select Doctor' }}</option>
                                                    @foreach (getDoctorList() as $item)
                                                        <option value="{{ $item->id }}" {{ $item->user_id == $item['id'] ? 'selected' :'' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
                                                <label for="type" class="control-label">{{ 'Type' }}</label>
                                                <select name="type" class="form-control select2" required>
                                                    <option value="" readonly>{{ 'Select Type' }}</option>
                                                    <option value="0">{{ 'Message' }}</option>
                                                    <option value="1">{{ 'Log' }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('type') ? 'has-error' : ''}}">
                                                <label for="type" class="control-label">{{ 'Message' }}</label>
                                                <textarea class="form-control" name="message" id="message" cols="30" rows="1"></textarea>
                                            </div>
                                        </div>
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
        <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('backend/js/form-advanced.js') }}"></script>

    @endpush
@endsection
