@extends('backend.layouts.main') 
@section('title', 'Product Attribute')
@section('content')
@php
/**
 * Product Attribute 
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
    ['name'=>'Add Product Properties', 'url'=> "javascript:void(0);", 'class' => '']
]

@endphp
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/summernote/dist/summernote-bs4.css') }}">
    <style>
        .error{
            color:red;
        }
        .bootstrap-tagsinput{
            width: 100%;
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
                            <h5>Add Product Properties</h5>
                            {{-- <span>Create a record for Product Attribute</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="{{ route('panel.user_shop_items.create') }}?type=direct&type_ide={{ encrypt(auth()->id()) }}&properties=true" class="btn btn-secondary">Back</a>
            </div>
            <div class="col-md-8 mx-auto">
                <!-- start message area-->
               @include('backend.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-header">
                        <h3>Create Product Properties</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.product_attributes.store') }}" method="post" enctype="multipart/form-data" id="ProductAttributeForm">
                            @csrf
                            <input type="hidden" value="{{auth()->id()}}" name="user_id">
                            <input type="hidden" value="{{getShopDataByUserId(auth()->id())->id ?? null}}" name="user_shop_id">

                            <div class="row">
                                                            
                                <div class="col-md-12 col-12"> 
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        <label for="name" class="control-label">Name<span class="text-danger">*</span></label>
                                        <input required  class="form-control" name="name" type="text" id="name" value="{{old('name')}}" placeholder="Enter Name" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12 d-none"> 
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <select required name="type" id="type" class="form-control select2">
                                            <option value="" readonly>Select Type</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12"> 
                                    <div class="form-group mb-0">
                                        <label for="input">{{ __('Values')}}</label>
                                    </div>
                                    <div class="form-group">
                                        <input style="width: 100%" name="value[]" type="text" id="tags" class="form-control" value="">
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
     <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/summernote/dist/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
        <script>
            $('#ProductAttributeForm').validate();
            $('#tags').tagsinput('items');                                      
        </script>
    @endpush
@endsection
