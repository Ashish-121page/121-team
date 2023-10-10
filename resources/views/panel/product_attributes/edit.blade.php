@extends('backend.layouts.main') 
@section('title', 'Product Attribute')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Edit Product Attribute', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
     <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
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
                            <h5>Edit Product Attribute</h5>
                            <span>Update a record for Product Attribute</span>
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
                        <h3>Update Product Attribute</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.product_attributes.update',$product_attribute->id) }}" method="post" enctype="multipart/form-data" id="ProductAttributeForm">
                            @csrf
                            <input type="hidden" value="{{auth()->id()}}" name="user_id">
                            <input type="hidden" value="{{getShopDataByUserId(auth()->id())->id  ?? null}}" name="user_shop_id">

                            <div class="row">
                                <div class="col-md-12 col-12"> 
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        <label for="name" class="control-label">Name<span class="text-danger">*</span></label>
                                        <input required  class="form-control" name="name" type="text" id="name" value="{{$product_attribute->name}}" placeholder="Enter Name" readonly >
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
                                        @php                                        
                                            $get_value = App\Models\ProductAttributeValue::where('parent_id',$product_attribute->id)->pluck('attribute_value');
                                            $value = [];
                                            foreach ($get_value as $key => $val) {
                                                array_push($value,$val);
                                            }
                                            $value = implode(',',$value);
                                        @endphp
                                        <input style="width: 100%" name="value[]" type="text" id="tags" class="form-control" value="{{ $value ?? '' }}">
                                    </div>
                                </div>
                                                            
                                <div class="col-md-12 ml-auto">
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
     <script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{asset('backend/js/form-advanced.js') }}"></script>
    <script>
        $('#ProductAttributeForm').validate();
         $('#tags').tagsinput('items');                                                                
    </script>
    @endpush
@endsection
