@extends('backend.layouts.main') 
@section('title', 'Access Code')
@section('content')
@php
/**
* Access Code 
*
* @category  zStarter
*
* @ref  zCURD
* @author    GRPL
* @license  121.page
* @version  <GRPL 1.1.0>
* @link        https://121.page/
*/
$breadcrumb_arr = [
    ['name'=>'Edit Access Code', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <style>
        .error{
            color:red;
        }
    </style>
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>Edit Access Code</h5>
                            {{-- <span>Update a record for Access Code</span> --}}
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
                <!-- start message area-->
               @include('backend.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-header">
                        <h3>Update Access Code</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.access_codes.update',$access_code->id) }}" method="post" enctype="multipart/form-data" id="AccessCodeForm">
                            @csrf
                            <input type="hidden" name="creator_id" value="{{ $access_code->creator_id }}">
                            <div class="row">
                                <div class="col-md-4 col-12"> 
                                    <div class="form-group {{ $errors->has('code') ? 'has-error' : ''}}">
                                        <label for="code" class="control-label">Code<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="code" type="text" id="code" value="{{$access_code->code }}">
                                    </div>
                                </div>
                                {{-- <div class="col-md-4 col-12"> 
                                    <div class="form-group">
                                        <label for="creator_id">Creator <span class="text-danger">*</span></label>
                                        <select required name="creator_id" id="creator_id" class="form-control select2">
                                            <option value="" readonly>Select Creator </option>
                                            @foreach(App\User::all()  as $option)
                                                <option value="{{ $option->id }}" {{ $access_code->creator_id  ==  $option->id ? 'selected' : ''}}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                                                                            
                                <div class="col-md-4 col-12"> 
                                    <div class="form-group">
                                        <label for="redeemed_user_id">Redeemed User</label>
                                        <select name="redeemed_user_id" id="redeemed_user_id" class="form-control select2">
                                            <option value="" readonly>Select Redeemed User </option>
                                            @foreach(App\User::all()  as $option)
                                                <option value="{{ $option->id }}" {{ $access_code->redeemed_user_id  ==  $option->id ? 'selected' : ''}}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-4 col-12">
                                    <div class="form-group {{ $errors->has('redeemed_at') ? 'has-error' : ''}}">
                                        <label for="redeemed_at" class="control-label">Redeemed At</label>
                                        <input   class="form-control" name="redeemed_at" type="datetime-local" id="redeemed_at" value="{{\Carbon\Carbon::parse($access_code->redeemed_at)->format('Y-m-d\TH:i') }}">
                                    </div>
                                </div>
                                                            
                                <div class="col-md-12 mx-auto">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{asset('backend/js/form-advanced.js') }}"></script>
    <script>
        $('#AccessCodeForm').validate();
                                                                                        
    </script>
    @endpush
@endsection
