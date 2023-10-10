@extends('backend.layouts.main') 
@section('title', 'Package')
@section('content')
@php
/**
* Package 
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
    ['name'=>'Edit Package', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Edit Package</h5>
                            {{-- <span>Update a record for Package</span> --}}
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
                        <h3>Update Package</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.packages.update',$package->id) }}" method="post" enctype="multipart/form-data" id="PackageForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 col-12"> 
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        <label for="name" class="control-label">Name<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="name" type="text" id="name" value="{{$package->name }}">
                                        
                                    </div>
                                </div>
                                <div class="col-md-4 col-12"> 
                                    <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                                        <label for="price" class="control-label">Price<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="price" type="number" id="price" value="{{$package->price }}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12"> 
                                    <div class="form-group {{ $errors->has('duration') ? 'has-error' : ''}}">
                                        <label for="duration" class="control-label">Duration (in days)</label>
                                        <input   class="form-control" name="duration" type="number" id="duration" value="{{$package->duration }}">
                                    </div>
                                </div>
                               
                                <div class="col-md-4 col-12"> 
                                    <div class="form-group {{ $errors->has('add_to_site') ? 'has-error' : ''}}">
                                        <label for="add_to_site" class="control-label">Catalogue Access</label>
                                        {{-- <input class="form-control" name="add_to_site" type="number" id="add_to_site" value="{{$limits['add_to_site'] }}"> --}}
                                        <input name="add_to_site" 
                                                class="form-control"
                                                type="number"
                                                min="1"
                                                step="1"
                                                value="{{$limits['add_to_site'] }}"
                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                title="Numbers only">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12"> 
                                    <div class="form-group {{ $errors->has('custom_proposals') ? 'has-error' : ''}}">
                                        <label for="custom_proposals" class="control-label">Custom Proposals</label>
                                        {{-- <input class="form-control" name="custom_proposals" type="number" id="custom_proposals" value="{{$limits['custom_proposals'] }}"> --}}
                                        <input name="custom_proposals" 
                                                class="form-control"
                                                type="number"
                                                min="1"
                                                step="1"
                                                value="{{$limits['custom_proposals'] }}"
                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                title="Numbers only">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12"> 
                                    <div class="form-group {{ $errors->has('product_uploads') ? 'has-error' : ''}}">
                                        <label for="product_uploads" class="control-label">Product Uploads</label>
                                        {{-- <input class="form-control" name="product_uploads" type="number" id="product_uploads" value="{{$limits['product_uploads'] }}"> --}}
                                        <input name="product_uploads" 
                                                class="form-control"
                                                type="number"
                                                min="1"
                                                step="1"
                                                value="{{$limits['product_uploads'] }}"
                                                onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                                title="Numbers only">
                                    </div>
                                </div>
                                <div class="col-md-12 col-12"> 
                                    <div class="form-group">
                                        <label for="description" class="control-label">Description <small>(Please use new to seperate features)</small></label>
                                        <textarea  class="form-control" name="description" id="description" placeholder="Enter Description">{{$package->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('is_published') ? 'has-error' : ''}}"><br>
                                        <label for="is_published" class="control-label">Is Published</label>
                                        <input  class="js-single switch-input" @if($package->is_published) checked @endif name="is_published" type="checkbox" id="is_published" value="1">
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
        $('#PackageForm').validate();
                                                                                                                                
    </script>
    @endpush
@endsection
