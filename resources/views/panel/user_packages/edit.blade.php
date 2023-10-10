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
    ['name'=>'Edit User Package', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Edit User Package</h5>
                            {{-- <span>Update a record for User Package</span> --}}
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
                        <h3>Update User Package</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.user_packages.update',$user_package->id) }}" method="post" enctype="multipart/form-data" id="UserPackageForm">
                            @csrf
                            <div class="row">

                                <input type="hidden" name="package_id" value="{{ $user_package->package_id }}">
                                                            
                                <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="user_id">User <span class="text-danger">*</span></label>
                                        <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select User </option>
                                            @foreach(App\User::all()  as $option)
                                                <option value="{{ $option->id }}" {{ $user_package->user_id  ==  $option->id ? 'selected' : ''}}>{{  $option->name ?? ''}}</option> 
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
                                                <option value="{{ $option->id }}" {{ $user_package->package_id  ==  $option->id ? 'selected' : ''}}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                            
                                {{-- <div class="col-md-6 col-12">  
                                    <div class="form-group">
                                        <label for="order_id">Order <span class="text-danger">*</span></label>
                                        <select required name="order_id" id="order_id" class="form-control select2">
                                            <option value="" readonly>Select Order </option>
                                            @foreach(App\Models\Order::all()  as $option)
                                                <option value="{{ $option->id }}" {{ $user_package->order_id  ==  $option->id ? 'selected' : ''}}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}

                                <input type="text" value="{{$user_package->id}}" class="d-none" name="user_id">                                                            

                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('from') ? 'has-error' : ''}}">
                                        <label for="from" class="control-label">From</label>
                                        <input   class="form-control" name="from" type="date" id="from" value="{{$user_package->from }}">
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('to') ? 'has-error' : ''}}">
                                        <label for="to" class="control-label">To</label>
                                        <input   class="form-control" name="to" type="date" id="to" value="{{$user_package->to }}">
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12 d-none"> 
                                    <div class="form-group {{ $errors->has('limit') ? 'has-error' : ''}}">
                                        <label for="limit" class="control-label">Limit</label>
                                        <input   class="form-control" name="limit" type="text" id="limit" value="{{$user_package->limit }}">
                                    </div>
                                </div>

                                @php
                                    $package = json_decode($user_package->limit);
                                @endphp

                                <div class="col-md-6 col-12 "> 
                                    <div class="form-group {{ $errors->has('add_to_site') ? 'has-error' : ''}}">
                                        <label for="add_to_site" class="control-label">Add To Site </label>
                                        <input   class="form-control" name="add_to_site" type="text" id="add_to_site" value="{{$package->add_to_site}}">
                                    </div>
                                </div>

                                                                                                                            
                                <div class="col-md-6 col-12 "> 
                                    <div class="form-group {{ $errors->has('custom_proposals') ? 'has-error' : ''}}">
                                        <label for="custom_proposals" class="control-label">Custom Proposal</label>
                                        <input   class="form-control" name="custom_proposals" type="text" id="custom_proposals" value="{{$package->custom_proposals }}">
                                    </div>
                                </div>

                                                                                                                            
                                <div class="col-md-6 col-12 "> 
                                    <div class="form-group {{ $errors->has('product_uploads') ? 'has-error' : ''}}">
                                        <label for="product_uploads" class="control-label">Product Upload</label>
                                        <input   class="form-control" name="product_uploads" type="text" id="product_uploads" value="{{$package->product_uploads }}">
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
        $('#UserPackageForm').validate();


    </script>
    @endpush
@endsection
