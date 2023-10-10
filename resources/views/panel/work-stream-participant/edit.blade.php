@extends('backend.layouts.main') 
@section('title', 'Case Workstream Participant')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Edit Case Workstream Participant', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>{{ __('Edit Case Workstream Participant')}}</h5>
                            <span>{{ __('Update a record for Case Workstream Participant')}}</span>
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
            <!-- end message area-->
            <div class="col-md-8 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h3>{{ __('Update Case Workstream Participant')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.case_work_stream_participant.update', $workStreamPart->id) }}" method="post">
                            @csrf
                            <input type="hidden" name="workstream_id" value="{{ $workStreamPart->workstream_id }}">
                            <div class="row">
                                {{-- <div class="col-sm-6">
                                    <div class="form-group {{ $errors->has('workstream_id') ? 'has-error' : ''}}">
                                        <label for="workstream_id" class="control-label">{{ 'Case Workstream' }}</label>
                                        <select name="workstream_id" class="form-control select2" required>
                                            <option value="" readonly>{{ 'Select Workstream' }}</option>
                                            @foreach (fetchAll('App\Models\CaseWorkstream') as $item)
                                                <option value="{{ $item->id }}" {{ $workStreamPart->workstream_id == $item['id'] ? 'selected' :'' }}>{{ $item->author_id }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-sm-6">
                                    <div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
                                        <label for="user_id" class="control-label">{{ 'Doctor' }}</label>
                                        <select name="user_id" class="form-control select2" required>
                                            <option value="" readonly>{{ 'Select Doctor' }}</option>
                                            @foreach (getDoctorList() as $item)
                                                <option value="{{ $item->id }}" {{ $workStreamPart->user_id == $item['id'] ? 'selected' :'' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group {{ $errors->has('is_chat_visible') ? 'has-error' : ''}}">
                                        <label for="is_chat_visible" class="control-label">{{ 'Chat Visible' }}</label>
                                        <select name="is_chat_visible" class="form-control select2" required>
                                            <option value="" readonly>{{ 'Select Chat Visible' }}</option>
                                            <option value="0" {{ $workStreamPart->status == 0 ? 'selected' : ''}}>{{ 'No' }}</option>
                                            <option value="1" {{ $workStreamPart->status == 1 ? 'selected' : ''}}>{{ 'Yes' }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                                        <label for="status" class="control-label">{{ 'Status' }}</label>
                                        <select name="status" class="form-control select2" required>
                                            <option value="0" {{ $workStreamPart->status == 0 ? 'selected' : ''}}>{{ 'Inactive ' }}</option>
                                            <option value="1" {{ $workStreamPart->status == 1 ? 'selected' : ''}}>{{ 'Active ' }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
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
    @push('script')
    @endpush
@endsection
