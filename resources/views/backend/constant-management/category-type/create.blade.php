@extends('backend.layouts.main') 
@section('title', 'Category Group')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Add Category Group', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>{{ __('Create New Category Group')}}</h5>
                            {{-- <span>{{ __('Add a new record for Category Group')}}</span> --}}
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
                        <h3>{{ __('Add Category Group')}}</h3>
                  </div>
                    <div class="card-body">
                        <form action="{{ route('panel.constant_management.category_type.store') }}" method="post">
                            @csrf
                            @if (AuthRole() == 'User')
                                <input type="hidden" name="defined_by" value="1">
                            @endif
                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        <label for="name" class="control-label">{{ ' Display Name' }}<span class="text-red">*</span></label>
                                        <input class="form-control" name="name" type="text" id="name" placeholder="Display Name" value="" required>
                                    </div>
                                </div>

                                {{-- <div class="col-md-4">   
                                    <div class="form-group {{ $errors->has('code') ? 'has-error' : ''}}">
                                        <label for="code" class="control-label">{{ 'Code' }}<span class="text-red">*</span></label>
                                        <input class="form-control" name="code" type="text" id="code" placeholder="code" value="" required>
                                    </div>
                                </div> --}}
                             
                                <div class="col-md-6">     
                                    <div class="form-group {{ $errors->has('allowed_level') ? 'has-error' : ''}}">
                                        <label for="allowed_level">{{ __('Allowed Level')}}<span class="text-red">*</span></label>
                                        <select  required name="allowed_level" id="allowed_level" class="form-control select2">
                                            <option value="" readonly>{{ __('Select Allowed Level')}}</option>
                                            <option value="1">{{ __('1')}}</option> 
                                            <option value="2">{{ __('2')}}</option>
                                            <option value="3">{{ __('3')}}</option>
                                        </select>
                                    </div> 
                                </div>  
                                <div class="col-md-12">     
                                    <div class="form-group {{ $errors->has('remark') ? 'has-error' : ''}}">
                                    <label for="remark" class="control-label">{{ 'Remark' }}</label>
                                    <textarea class="form-control" rows="5" name="remark" type="textarea" id="remark" placeholder="Enter remark here..." ></textarea>
                                    </div>
                                </div>
                            </div> 

                                    
                                <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Create</button>
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
