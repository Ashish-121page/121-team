@extends('backend.layouts.main') 
@section('title', 'Product')
@section('content')
@php
/**
 * Product 
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
        ['name'=>'Add Product', 'url'=> "javascript:void(0);", 'class' => '']
    ];
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
                        <h5>Add Product</h5>
                        <span>Create a record for Product</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                @include('backend.include.breadcrumb')
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-10 mx-auto">
            {{-- Card start --}}
            <div class="row">
                <div class="col-md-4 product_boxes">
                    <div class="card">
                        <div class="card-header">
                            <h5>Single Product</h5>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>1 By 1 SKU</li>
                                <li>Easy Interface</li>
                                <li>Error Free</li>
                            </ul>
                            <div class="">
                                <button class="btn btn-info getSingleProduct btn-block">Create</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 product_boxes">
                    <div class="card">
                        <div class="card-header">
                            <h5>Bulk Product Upload</h5>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>Upto 200 SKU in 1 go</li>
                                <li>Quickets Upload</li>
                                <li>Save Time</li>
                            </ul>
                            <div class="ml-4">
                                <button class="btn btn-info bulk_upload_btn  btn-block" >Upload</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 product_boxes">
                    <div class="card">
                        <div class="card-header">
                            <h5>Search Product</h5>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li>mages & specs of over 5,000 SKU</li>
                                <li>Simply add on your site </li>
                                <li>Start selling</li>
                            </ul>
                            <div class="ml-4">
                                <a href="{{ route('panel.products.search') }}?action=nonbranded" class="btn btn-info  btn-block">Search</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10 mx-auto mb-3">
                    <button class="btn btn-secondary back_btn d-none">Back</button>
                </div>
            </div>
            {{-- Card end --}}
    
            {{-- single product start --}}
            <div class="row show_single_prouduct d-none">
                <div class="col-md-10 mx-auto">
                        @include('backend.include.message')
                    <form action="{{ route('panel.products.store') }}" method="post" enctype="multipart/form-data" id="ProductForm">
                        @csrf
                        <input type="hidden" name="status" value="0">
                        <input type="hidden" name="is_publish" value="0">
                        <div class="card ">
                            <div class="card-header">
                                <div class="d-flex">
                                    <div>
                                        <h3>Create Product</h3>
                                    </div>
                                    {{-- <div style="position: absolute; right: 20px;">
                                        <a href="javascript:void(0)" data-target="#productBulkModal" data-toggle="modal" class="btn btn-sm btn-danger mr-2" title="Import/Export Product">
                                            Bulk Upload
                                        </a>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6 col-12"> 
                                        <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                                            <label for="title" class="control-label">Title<span class="text-danger">*</span> </label>
                                            <input required  class="form-control" name="title" type="text" id="title" value="{{old('title')}}" placeholder="Enter Title" >
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12 d-none"> 
                                        <div class="form-group">
                                            <label for="product_type">Product Type</label>
                                            <select required name="product_type" id="product_type" class="form-control select2">
                                                <option value="" readonly>Select Type</option>
                                                    @foreach(getProductType() as $option)
                                                        <option @if($option['active'] == 0) disabled @endif @if ($option['id'] == 1) selected @endif value="{{  $option['id'] }}" {{  old('status') == $option ? 'Selected' : '' }}>{{ $option['name']}}</option> 
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @if (!request()->has('action') && !request()->get('action') == 'nonbranded')
                                        <div class="col-md-6 col-12"> 
                                            <div class="form-group">
                                                <label for="sku">SKU<span class="text-danger">*</span></label>
                                                <input @if(!request()->has('action') && !request()->get('action') == 'nonbranded') required  @endif class="form-control" name="sku" type="text" id="sku" value="{{old('sku')}}" placeholder="Enter SKU" >
                                            </div>
                                        </div>
                                    @else
                                        
                                    @endif
                                </div>

                                <div class="row">
                                    @if($brand_activation == true)
                                        @if (isset($brand) && $brand->user_id != null)
                                            <input type="hidden" name="user_id" value="{{$brand->user_id}}">
                                        @else
                                            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">    
                                        @endif
                                        <input type="hidden" name="brand_id" value="{{request()->get('id')}}">
                                    @else 
                                        <input type="hidden" name="user_id" value="{{auth()->user()->id}}">                                    
                                        <input type="hidden" name="brand_id" value="0">
                                    @endif
                                    <div class="col-md-4 col-12"> 
                                        <div class="form-group">
                                            <label for="category_id">Category <span class="text-danger">*</span></label>
                                            <select required name="category_id" id="category_id" class="form-control select2">
                                                <option value="" readonly>Select Category </option>
                                                @foreach($category as $option)
                                                    <option value="{{ $option->id }}" {{  old('category_id') == $option->id ? 'selected' : '' }}>{{  $option->name ?? ''}}</option> 
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12"> 
                                        <div class="form-group">
                                            <label for="sub_category">Sub Category <span class="text-danger">*</span></label>
                                            <select required name="sub_category" data-selected-subcategory="{{ old('sub_category') }}" id="sub_category" class="form-control select2">
                                                <option value="" readonly>Select Sub Category </option>
                                                @if(old('sub_category'))
                                                <option value="{{ old('sub_category') }}" selected> {{ fetchFirst('App\Models\Category',old('sub_category'),'name') }}</option>
                                                @endif 
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 col-12"> 
                                        <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                                            <label for="price" class="control-label">Price </label>
                                            <input class="form-control" name="price" type="number" id="price" value="{{ old('price') }}" >
                                        </div>
                                    </div>

                                        <div class="col-md-4 col-12"> 
                                        <div class="form-group {{ $errors->has('hsn') ? 'has-error' : ''}}">
                                            <label for="hsn" class="control-label">HSN </label>
                                            <input class="form-control" name="hsn" type="text" id="hsn" value="{{ old('hsn') }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12"> 
                                        <div class="form-group {{ $errors->has('hsn_percent') ? 'has-error' : ''}}">
                                            <label for="hsn_percent" class="control-label">HSN Percent </label>
                                            <input class="form-control" name="hsn_percent" type="number" id="hsn_percent" value="{{ old('hsn_percent') }}" >
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                            <div class="card ">
                            <div class="card-header">
                                <h3>Inventory</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-12"> 
                                        <div class="form-group form-check">
                                            <input disabled checked class="form-check-input" name="manage_inventory" type="checkbox" value="{{ old('manage_inventory') }}" id="manage_inventory" {{ old('manage_inventory') == 0 ? "" : "checked" }}>
                                            <label class="form-check-label" for="manage_inventory">
                                                This inventory keeps on decreasing as per the acceptance of the order.
                                            </label>
                                            <h6>Smart Inventory</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12"> 
                                        <div class="form-group">
                                            <label for="status">Quantity In Hand</label>
                                            <input type="number" name="stock_qty" class="form-control" value="{{ old('stock_qty') }}" id="">
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    
                        <div class="card ">
                            <div class="card-header">
                                <h3>Dimensions</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                <div class="col-md-4 col-12"> 
                                    <label class="">{{ __('Height')}}</label>
                                        <div class="input-group">
                                            <input class="form-control" name="height" type="number" id="height" value="{{$shipping->height ?? old('height')}}" >
                                            <span class="input-group-append" id="basic-addon3">
                                                <label class="input-group-text">In cm</label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12"> 
                                        <label class="">{{ __('Weight')}}</label>
                                        <div class="input-group">
                                            <input class="form-control" name="weight" type="number" id="weight" value="{{$shipping->weight ?? old('weight')}}" >
                                            <span class="input-group-append" id="basic-addon3">
                                                <label class="input-group-text">In kg</label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12"> 
                                        <label class="">{{ __('Width')}}</label>
                                        <div class="input-group">
                                            <input class="form-control" name="width" type="number" id="width" value="{{$shipping->width ?? old('width')}}" >
                                            <span class="input-group-append" id="basic-addon3">
                                                <label class="input-group-text">In cm</label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12"> 
                                        <label class="">{{ __('Depth')}}</label>
                                        <div class="input-group">
                                            <input class="form-control" name="depth" type="number" id="depth" value="{{$shipping->depth ?? old('depth')}}" >
                                            <span class="input-group-append" id="basic-addon3">
                                                <label class="input-group-text">In cm</label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12"> 
                                        <label class="">{{ __('Unit')}}</label>
                                        <div class="input-group">
                                            <input class="form-control" name="unit" type="number" id="unit" value="{{$shipping->unit ?? old('unit')}}" >
                                            <span class="input-group-append" id="basic-addon3">
                                                <label class="input-group-text">In kg</label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12"> 
                                        <label class="">{{ __('Length Unit')}}</label>
                                        <div class="input-group">
                                            <input class="form-control" name="length_unit" type="number" id="length_unit" value="{{$shipping->length_unit ?? old('length_unit')}}" >
                                            <span class="input-group-append" id="basic-addon3">
                                                <label class="input-group-text">In inch</label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card ">
                            <div class="card-header">
                                <h3>Images</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                <div class="col-md-12 col-12"> 
                                        <div class="form-group {{ $errors->has('img') ? 'has-error' : ''}}">
                                            <label for="img" class="control-label">Images</label>
                                            <input class="form-control" name="img[]" multiple type="file" id="img" value="{{old('img')}}">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card ">
                            <div class="card-header">
                                <h3>Carton Detail</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                <div class="col-md-12 col-12"> 
                                    <label class="">{{ __('Standard Carton')}}</label>
                                        <div class="form-group">
                                            <input class="form-control" name="standard_carton" type="text" id="standard_carton" value="{{$carton_details->standard_carton ?? old('standard_carton')}}" >
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12"> 
                                        <label class="">{{ __('Weight')}}</label>
                                        <div class="input-group">
                                            <input class="form-control" name="carton_weight" type="number" id="carton_weight" value="{{$carton_details->carton_weight ?? old('carton_weight')}}" >
                                            <span class="input-group-append" id="basic-addon3">
                                                <label class="input-group-text">In kg</label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12"> 
                                        <label class="">{{ __('Unit')}}</label>
                                        <div class="input-group">
                                            <input class="form-control" name="carton_unit" type="number" id="carton_unit" value="{{$carton_details->carton_unit ?? old('carton_unit')}}" >
                                            <span class="input-group-append" id="basic-addon3">
                                                <label class="input-group-text">In kg</label>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card ">
                            <div class="card-header">
                                <h3>Content</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tag 1</label>
                                            <input type="text" name="tag1" class="form-control" id="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tag 2</label>
                                            <input type="text" name="tag2" class="form-control" id="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Tag 3</label>
                                            <input type="text" name="tag3" class="form-control" id="">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Video Url </label>
                                            <input type="url" name="video_url" class="form-control" id="">
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12"> 
                                        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                            <label for="description" class="control-label">Description</label>
                                            <textarea name="description" class="form-control" id="" cols="30" rows="10">{{ old('description') }}</textarea>
                                        </div>

                                        <div class="form-group {{ $errors->has('features') ? 'has-error' : ''}}">
                                            <div class="alert alert-info">
                                                Add Product Features With New Line Each 
                                            </div>
                                            <label for="features" class="control-label">Features</label>
                                            <textarea name="features" class="form-control" id="" cols="30" rows="5">{{ old('features') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        @php
                            $colors = json_decode($colors->value,true);
                            $sizes = json_decode($sizes->value,true);
                        @endphp
                        <div class="card ">
                            <div class="card-header">
                                <h3>Attributes</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-12"> 
                                        <div class="form-group mb-0">
                                            <label for="input">{{ __('Color')}}</label>
                                        </div>
                                        <div class="form-group">
                                            <select multiple class="form-control select2" name="colors[]" id="color">
                                                <option value="" readonly disabled>Select Color</option>
                                                @foreach (explode(',',$colors[0]) as $item)
                                                    <option {{in_array($item, old('colors') ?: []) ? "selected": ""}}  value="{{ $item }}">{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12"> 
                                        <div class="form-group mb-0">
                                            <label for="input">{{ __('Size')}}</label>
                                        </div>
                                        <div class="form-group"> 
                                            <select class="form-control select2" multiple name="sizes[]" id="size">
                                                <option value="" readonly disabled>Select Size</option>
                                                @foreach (explode(',',$sizes[0]) as $item)
                                                    <option {{in_array($item, old('sizes') ?: []) ? "selected": ""}}  value="{{ $item }}" >{{ $item }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mr-auto">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Create</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>    
                </div>
                
            </div>
            {{-- single product end --}}
    
    
            {{-- Bulk Cart start --}}
                <div class="row bulk_product d-none">
                    <div class="col-md-10 mx-auto">
                        <div class="card">
                            <div class="card-header">
                                <h3>Import/Export Product</h3>
                            </div>
                            <div class="d-flex justify-content-around mt-2 mb-4">
                                <div class="border p-3 text-center import-dev">
                                    <p>
                                    Add New Products in Bulk
                                    </p>
                                    <button class="btn btn-outline-info" id="import-btn">Import Products</button>
                                </div>
                                <div class="border p-3 text-center export-dev">
                                    <p>
                                    Edit Existing Product in Bulk 
                                    </p>
                                    <button class="btn btn-outline-info" id="export-btn">Export Products</button>
                                </div>
                            </div>
                            <div class="import d-none pt-0 p-3">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ asset('utility/bulk-product.xls') }}" type="button"  class="btn-link mb-3">Download Template</a>
                                </div>
                                <form action="{{ route('panel.product-upload') }}" method="post" enctype="multipart/form-data" class="">
                                    <input type="hidden" name="brand_id" value="{{ request()->get('id') ?? '0' }}">
                                    @csrf
                                    <div class="row">
                                        {{-- <div class="col-md-6 col-12"> 
                                            <div class="form-group">
                                                <label for="category_id">Category <span class="text-danger">*</span></label>
                                                <select required name="category_id" id="bulk_category_id" class="form-control select2">
                                                    <option value="" readonly>Select Category </option>
                                                    @foreach($category as $option)
                                                        <option value="{{ $option->id }}" {{  old('category_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12"> 
                                            <div class="form-group">
                                                <label for="sub_category">Sub Category <span class="text-danger">*</span></label>
                                                <select required name="sub_category" data-selected-subcategory="{{ old('sub_category') }}" id="bulk_sub_category" class="form-control select2">
                                                    <option value="" readonly>Select Sub Category </option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="col-md-12 col-12"> 
                                            <div class="form-group">
                                                <label for="file">Upload Updated Excel Template<span class="text-danger">*</span></label>
                                                <input required type="file" name="file" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-12 text-right">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Upload</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="export d-none pt-0 p-3">
                                <div class="d-flex justify-content-end">
                                    <a href="{{route('panel.product.bulk-export')}}" type="button" id  class="btn-link mb-3">Export Product List</a>
                                </div>
                                    <form action="{{ route('panel.product.bulk-update') }}" method="post" enctype="multipart/form-data" class="">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12 col-12"> 
                                                <div class="form-group">
                                                    <label for="file">Upload Updated Excel Template<span class="text-danger">*</span></label>
                                                    <input required type="file" name="file" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12 text-right">
                                                <button type="submit" class="btn btn-primary">Upload</button>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            {{-- Bulk Cart end --}}
        </div>
    </div>


        
</div>
    <!-- push external js -->
    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{asset('backend/js/form-advanced.js') }}"></script>
    <script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
    <script>
        $('#ProductForm').validate();
    
        
        $(document).ready(function(){
         $('#import-btn').on('click',function(){
            $('.import').removeClass('d-none') 
            $('.export').addClass('d-none') 
            $('.import-div').removeClass('d-none') 
            $('.export-div').addClass('d-none') 
            $('#import-btn').addClass('d-none') 
            $('#export-btn').removeClass('d-none') 
         });
         $('#export-btn').on('click',function(){
            $('.export').removeClass('d-none') 
            $('.import').addClass('d-none') 
             $('.import-div').addClass('d-none') 
            $('.export-div').removeClass('d-none') 
            $('#export-btn').addClass('d-none') 
            $('#import-btn').removeClass('d-none') 
         });
      });

       
        $('.getSingleProduct').on('click',function(){
            $('.product_boxes').addClass('d-none');
            $('.show_single_prouduct').removeClass('d-none');
            $('.back_btn').removeClass('d-none');
        })
        $('.back_btn').on('click',function(){
            $('.product_boxes').removeClass('d-none');
            $('.show_single_prouduct').addClass('d-none');
            $('.bulk_product').addClass('d-none');
            $(this).addClass('d-none');
        })
        $('.bulk_upload_btn').on('click',function(){
            $('.product_boxes').addClass('d-none');
            $('.show_single_prouduct').addClass('d-none');
            $('.bulk_product').removeClass('d-none');
             $('.back_btn').removeClass('d-none');
        });

        $('#category_id').change(function(){
            var id = $(this).val();
            if(id){
                $.ajax({
                    url: "{{route('panel.user_shop_items.get-category')}}",
                    method: "get",
                    datatype: "html",
                    data: {
                        id:id
                    },
                    success: function(res){
                        console.log(res);
                        $('#sub_category').html(res);
                    }
                })
            }
        });

        $('#bulk_category_id').change(function(){
            var id = $(this).val();
            if(id){
                $.ajax({
                    url: "{{route('panel.user_shop_items.get-category')}}",
                    method: "get",
                    datatype: "html",
                    data: {
                        id:id
                    },
                    success: function(res){
                        console.log(res);
                        $('#bulk_sub_category').html(res);
                    }
                })
            }
        });

        $(document).ready(function(){
                $("#manage_inventory").click(function(){
                    if ($(this).is(':checked')) {
                        $(".stock").removeClass('d-none');
                        $("#stock_qty").attr("required", true);
                    } else {
                        $(".stock").addClass('d-none');
                        $("#stock_qty").attr("required", false);
                    }

                });
            });
        $('tags').tagsinput('items');    
    </script>
    @endpush
@endsection
