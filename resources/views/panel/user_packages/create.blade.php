@extends('backend.layouts.main') 
@section('title', 'User Package')
@section('content')
@php
/**
 * User Package 
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
    ['name'=>'Add User Package', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Add User Package</h5>
                            {{-- <span>Create a record for User Package</span> --}}
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
                        <h3>Create User Package</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.user_packages.store') }}" method="post" enctype="multipart/form-data" id="UserPackageForm">
                            @csrf
                            <div class="row">
                                                                                                
                                <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="user_id">User <span class="text-danger">*</span></label>
                                        <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select User </option>
                                            @foreach(UserList()  as $option)
                                                <option value="{{ $option->id }}" {{  old('user_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                                                                
                                <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="package_id">Package <span class="text-danger">*</span></label>
                                        <select required name="package_id" id="package_id" class="form-control select2">
                                            <option value="" readonly>Select Package </option>
                                            @foreach(App\Models\Package::all()  as $option)
                                                <option value="{{ $option->id }}" {{  old('package_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                                                                
                                <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="order_id">Order <span class="text-danger">*</span></label>
                                        <select required name="order_id" id="order_id" class="form-control select2">
                                            <option value="" readonly>Select Order </option>
                                            @foreach(App\Models\Order::all()  as $option)
                                                <option value="{{ $option->id }}" {{  old('order_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('from') ? 'has-error' : ''}}">
                                        <label for="from" class="control-label">From</label>
                                        <input  class="form-control" name="from" type="date" id="from" value="{{old('from')}}" placeholder="Enter From" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('to') ? 'has-error' : ''}}">
                                        <label for="to" class="control-label">To</label>
                                        <input  class="form-control" name="to" type="date" id="to" value="{{old('to')}}" placeholder="Enter To" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('limit') ? 'has-error' : ''}}">
                                        <label for="limit" class="control-label">Limit</label>
                                        <input  class="form-control" name="limit" type="text" id="limit" value="{{old('limit')}}" placeholder="Enter Limit" >
                                    </div>
                                </div>
                                                            
                                <div class="col-md-12 ml-auto">
                                    <div class="form-group">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{asset('backend/js/form-advanced.js') }}"></script>
    <script>
        $('#UserPackageForm').validate();
                                                                                                                                
    </script>
    @endpush
@endsection
