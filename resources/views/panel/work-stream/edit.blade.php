@extends('backend.layouts.main') 
@section('title', 'Case Workstream')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Edit Case Workstream', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>{{ __('Edit Case Workstream')}}</h5>
                            <span>{{ __('Update a record for Case Workstream')}}</span>
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
                        <h3>{{ __('Update Case Workstream')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.case_work_stream.update', $workStream->id) }}" method="post">
                            <input type="hidden" name="case_id" value="{{ $workStream->case_id }}">
                            <input type="hidden" name="author_id" value="{{ $workStream->author_id }}">
                            <input type="hidden" name="status" value="{{ $workStream->status }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        <label for="author_id" class="control-label">{{ 'Name' }}</label>
                                        <input type="text" name="name" class="form-control" id="name" value="{{ $workStream->name }}" placeholder="Enter Board Name" required>  
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                                        <label for="status" class="control-label">{{ 'Status' }}</label>
                                        <select name="status" class="form-control select2" required>
                                            <option value="0" {{ $workStream->status == 0 ? 'selected' : ''}}>{{ 'Unpublish' }}</option>
                                            <option value="1" {{ $workStream->status == 1 ? 'selected' : ''}}>{{ 'Publish' }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                        <label for="author_id" class="control-label">{{ 'Description' }}</label>
                                        <textarea type="text" name="description" class="form-control" value="{{ $workStream->description }}" id="description" placeholder="Enter Board Description">{!! $workStream->description !!}</textarea>  
                                    </div>
                                    {{-- <div class="form-group {{ $errors->has('author_id') ? 'has-error' : ''}}">
                                        <label for="author_id" class="control-label">{{ 'Counselor' }}</label>
                                        <input class="form-control" name="author_id" type="text" id="author_id" value="{{ $workStream->author_id }}" placeholder="Enter Counselor" required>
                                        <select name="author_id" id="author_id" class="form-control select2">
                                            <option readonly>{{ __('Select Doctor')}}</option>
                                            @foreach (CounselorList() as $item)
                                                <option value="{{ $item->id }}" {{ $workStream->author_id == $item['id'] ? 'selected' :'' }}>{{ $item->name }}</option> 
                                            @endforeach
                                        </select>
                                    </div> --}}
                                </div>
                                {{-- <div class="col-sm-6">
                                    <div class="form-group {{ $errors->has('case_id') ? 'has-error' : ''}}">
                                        <label for="case_id" class="control-label">{{ 'Case' }}</label>
                                        <select name="case_id" class="form-control select2" required>
                                            <option readonly>{{ 'Select Case' }}</option>
                                            @foreach (fetchAll('App\Models\UserCase') as $item)
                                                <option value="{{ $item->id }}" {{ $workStream->case_id == $item['id'] ? 'selected' :'' }}>{{ $item->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
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
