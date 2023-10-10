@extends('backend.layouts.main') 
@section('title', 'Case Workstream')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Add Case Workstream', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>{{ __('Create New Case Workstream')}}</h5>
                            <span>{{ __('Add a new record for Case Workstream')}}</span>
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
                        <h3>{{ __('Add Case Workstream')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.case_work_stream.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="status" value="0">
                            <input type="hidden" name="case_id" value="1">
                            <input type="hidden" name="author_id" value="{{ auth()->user()->id }}">
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                                <label for="author_id" class="control-label">{{ 'Name' }}</label>
                                                <input type="text" name="name" class="form-control" value="" id="name" placeholder="Enter Board Name" required>  
                                            </div>
                                            <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                                <label for="author_id" class="control-label">{{ 'Description' }}</label>
                                                <textarea type="text" name="description" class="form-control" value="" id="description" placeholder="Enter Board Description"></textarea>  
                                            </div>
                                            {{-- <div class="form-group {{ $errors->has('author_id') ? 'has-error' : ''}}">
                                                <label for="author_id" class="control-label">{{ 'Counselor' }}</label>
                                                <select name="author_id" id="author_id" class="form-control select2" required>
                                                    <option value="" readonly>{{ __('Select Doctor')}}</option>
                                                    @foreach (CounselorList() as $item)
                                                        <option value="{{ $item->id }}" @if($item->id == \Auth::id()) selected @endif>{{ $item->name }}</option> 
                                                    @endforeach
                                                </select>       
                                            </div> --}}
                                        </div>
                                        {{-- <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('case_id') ? 'has-error' : ''}}">
                                                <label for="case_id" class="control-label">{{ 'Case' }}</label>
                                                <select name="case_id" class="form-control select2" required>
                                                    <option value="" readonly>{{ 'Select Case' }}</option>
                                                    @foreach (fetchAll('App\Models\UserCase') as $item)
                                                        <option value="{{ $item->id }}" {{ $workStream->case_id == $item['id'] ? 'selected' :'' }}>{{ $item->title }}</option>
                                                    @endforeach
                                                </select>
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
