@extends('backend.layouts.main') 
@section('title', 'Product')
@section('content')
@php
/**
 * Product
 * @Devloper  Ashish
 * @author    GRPL
 * @license  121.page
 * @version  <GRPL 1.1.0>
 * @link        https://121.page/
 */
    $breadcrumb_arr = [
        ['name'=>'Add/Edit', 'url'=> "javascript:void(0);", 'class' => '']
    ];

    $user = auth()->user();  
    $acc_permissions = json_decode($user->account_permission);
    $acc_permissions->bulkupload = $acc_permissions->bulkupload ??  "no"; // If Not Exist in Databse Then It Will be No By Default.

    
    // Setting Up Permissions for Team USer
    $teamDetails = App\Models\Team::where('contact_number',session()->get('phone'))->first();

    if ($teamDetails != null) {
        $permissions = json_decode($teamDetails->permission);
        if ($permissions != null) {
            $Team_bulkupload = in_array("bulkupload",$permissions);
        }else{
            $Team_bulkupload = true;
        }
    }
    else{
        $Team_bulkupload = true;
    }



    // Grouping Columns


    $default_property  = ['Model_Code','SKU Type','Product name','Category','Sub_Category','Customer_Price_without_GST','HSN Tax','HSN_Percnt'];

@endphp
<!-- push external head elements to head -->
@push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/normalize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
    <style>
        .error {
            color: red;
        }

        .product_boxes .card {
            border: 1px solid #6666CC !important;
        }

        label.create_btn {
            padding: 7px;
            background: #6666CC;
            display: table;
            color: #fff;
            margin-left: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        input[type="submit"] {
            display: none;
        }

        @media (max-width: 600px) {
            .next_btn {
                margin-top: -40px;
            }

            .previous_btn {
                margin-bottom: 10px;
            }
        }

        .image-input {
            text-align: center;
        }

        .image-input input {
            display: none;
        }

        .image-input label {
            display: block;
            color: #FFF;
            background: #7b7baf;
            padding: 0.6rem 0.6rem;
            font-size: 115%;
            cursor: pointer;
        }

        .image-input label i {
            font-size: 125%;
            margin-right: 0.3rem;
        }

        .image-input img {
            max-width: 175px;
            display: none;
        }

        .image-input span {
            display: none;
            text-align: center;
            cursor: pointer;
        }

        @keyframes shake {
            0% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(10deg);
            }

            50% {
                transform: rotate(0deg);
            }

            75% {
                transform: rotate(-10deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        .remove-ik-class {
            -webkit-box-shadow: unset !important;
            box-shadow: unset !important;
        }
        
    </style>
@endpush

<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-mail bg-blue"></i>
                    <div class="d-flex">
                        <h5>Add/Edit</h5>
                        @if(AuthRole() == 'User')
                            <span style="margin-top: -10px;">
                                <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                            </span>
                        @endif
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
                    <div class="card getSingleProduct" style="cursor: pointer;">
                        <div class="card-header">
                            <i class="fas fa-upload btn text-primary h5" style="font-size: 1.2rem;"></i>
                            <h5>Single Product</h5>
                        </div>
                        <div class="card-body wrap_equal_height">
                            <ul>
                                {{-- <li>Over 5,000 SKU ready</li> --}}
                                <li>Add on your site</li>
                                <li>Start selling</li>
                            </ul>
                        </div>
                    </div>
                </div>               

                <div class="col-md-4 product_boxes">
                    <div class="card getcustomProduct" style="cursor: pointer;">
                        <div class="card-header">
                            <i class="fas fa-upload btn text-primary h5" style="font-size: 1.2rem;"></i>
                            <h5>Custom Bulk </h5>
                        </div>
                        <div class="card-body wrap_equal_height">
                            <ul>
                                {{-- <li>Over 5,000 SKU ready</li> --}}
                                <li>Quick upload With Custom Fields</li>
                            </ul>
                        </div>
                    </div>
                </div>               


                <div class="col-md-4 product_boxes" >
                    @if ($Team_bulkupload)
                        <div class="card @if ($acc_permissions->bulkupload == "yes") bulk_upload_btn @endif" style="cursor: pointer;  @if ($acc_permissions->bulkupload == "no") background: #8080807a;cursor: default; @endif">
                            <div class="card-header">
                                <i class="fas fa-crown btn text-warning h5" style="font-size: 1.2rem;"></i>
                                <h5>Bulk Product Upload</h5>
                            </div>
                            <div class="card-body wrap_equal_height">
                                <ul>
                                    <li>200 SKU in 1 go</li>
                                    <li>Quick upload</li>
                                    {{-- <li>Start selling</li> --}}
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>

               
                
                {{-- @if(auth()->user() && session()->has("admin_user_id") && session()->has("temp_user_id")) --}}
                    {{-- <div class="col-md-4 product_boxes">  
                        <a class="card" href=" @if ($acc_permissions->bulkupload == "yes") {{ route('panel.products.search') }}?action=nonbranded @else # @endif">
                            <div class="card-header">
                                <i class="fas fa-crown btn text-warning h5" style="font-size: 1.2rem;"></i>
                                <h5>Clone Brand Product</h5>
                            </div>
                            <div class="card-body wrap_equal_height">
                                <ul>
                                    <li>Clone Brand Products</li>
                                    <li>Add to site</li>
                                    <li>Start selling</li>
                                </ul>
                            </div>
                        </a>
                    </div> --}}
                {{-- @endif --}}
           
                <div class="col-md-10 mx-auto mb-3">
                    <button class="btn btn-secondary back_btn d-none">Back</button>
                </div>
            </div>
            {{-- Card end --}}

                {{-- - new Front Card Section --}}

                <div class="row get_custom_Product d-none" >

                    <div class="col-md-6 col-12 mx-auto">
                        <div class="row p-2 card" style="height: 100%">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-cloud-upload-alt text-light bg-primary p-3 rounded-circle"
                                            style="font-size:2vh"></i>
                                    </div>
                                    <div class="col-10 d-flex flex-column justify-content-center">
                                        <form action="{{ route('panel.bulk.custom.product-upload',auth()->id()) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="content">
                                                <h5>Import file</h5>
                                                <span>Upload Excel Sheet to Upload New Products Data.</span>
                                                
                                                <input type="file" name="uploadcustomfield" id="uploadcustomfield" class="form-control my-3">                                    </div>
                                            <div class="action" style="margin: 20px 0">
                                                <button class="btn btn-outline-primary" type="submit">
                                                    Upload
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2nd Card --}}
                    
                    <div class="col-md-6 col-12 mx-auto">
                        <div class="row p-2 card" style="height: 100%">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-cloud-download-alt text-light bg-primary p-3 rounded-circle"
                                            style="font-size:2vh"></i>
                                    </div>
                                    <div class="col-10">
                                        <div class="content">
                                            <h5>Export data </h5>
                                            <span>Information will be downloaded as per - All Details. Change
                                                template.</span>
                                            <div class="alert alert-warning p-1 mt-2 invisible" style="width: fit-content;"
                                                role="alert">
                                                <i class="fas fa-info-circle text-warning mx-1"></i> Sheet will have thumbnail
                                                urls & not images
                                            </div>
                                        </div>
                                        <div class="action">
                                            <a href="{{ route('panel.bulk.product.bulk-sheet-export',auth()->id()) }}" type="button"  class="btn btn-outline-primary">Download</a>
                                            <a class="btn btn-outline-primary" id="demo01" href="#animatedModal" role="button">Create Template</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 3rd Card --}}

                    <div class="col-md-6 col-12 mx-auto my-3">
                        <div class="row p-2 card" style="height: 100%">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-cloud-upload-alt text-light bg-primary p-3 rounded-circle"
                                            style="font-size:2vh"></i>
                                    </div>
                                    <div class="col-10 d-flex flex-column justify-content-center">
                                        <form action="{{ route('panel.bulk.product.bulk-update') }}" method="post" enctype="multipart/form-data" class="">
                                            @csrf
                                            <div class="content">
                                                <h5>Update Record</h5>
                                                <span>Upload Excel Sheet to Update Products Data.</span>
                                                
                                                <input required type="file" name="file" class="form-control">
                                            </div>
                                            <div class="action" style="margin: 20px 0">
                                                <button class="btn btn-outline-primary" type="submit">
                                                    Upload
                                                </button>
                                                
                                                <a href="{{route('panel.bulk.product.bulk-export',auth()->id())}}" type="button"  class="btn btn-outline-primary">Fill & Upload</a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                {{-- - End of New Front Card Section --}}





    
            {{-- single product start --}}
                <div class="row show_single_prouduct d-none">
                    <div class="col-md-10 mx-auto">
                            @include('backend.include.message')
                        <form action="{{ route('panel.products.store') }}" method="post" enctype="multipart/form-data" id="ProductForm" class="product_form">
                            @csrf
                            <input type="hidden" name="status" value="0">
                            <input type="hidden" name="is_publish" value="0">
                            {{-- Stepper Start --}}
                            <div class="md-stepper-horizontal orange">
                                <div class="md-step active done custom_active_add-0">
                                <div class="md-step-circle"><span>1</span></div>
                                <div class="md-step-title">Vital Info</div>
                                <div class="md-step-bar-left"></div>
                                <div class="md-step-bar-right"></div>
                                </div>
                                <div class="md-step editable custom_active_add-1">
                                <div class="md-step-circle"><span>2</span></div>
                                <div class="md-step-title">Stock & HSN</div>
                                <div class="md-step-bar-left"></div>
                                <div class="md-step-bar-right"></div>
                                </div>
                                <div class="md-step editable custom_active_add-2">
                                <div class="md-step-circle"><span>3</span></div>
                                <div class="md-step-title">Public Sharing</div>
                                <div class="md-step-bar-left"></div>
                                <div class="md-step-bar-right"></div>
                                </div>
                                <div class="md-step editable custom_active_add-3">
                                <div class="md-step-circle"><span>4</span></div>
                                <div class="md-step-title">Details</div>
                                <div class="md-step-bar-left"></div>
                                <div class="md-step-bar-right"></div>
                                </div>
                            </div>
                            
                            {{--  Stepper End  --}}

                            <div class="stepper" data-index="1">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex">
                                            <div>
                                                <h3>Create Product</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
        
                                        <div class="row">
                                            <div class="col-md-6 col-12"> 
                                                <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                                                    <label for="title" class="control-label">Title<span class="text-danger">*</span> </label>
                                                    <input required class="form-control" name="title" type="text" id="title" value="{{old('title')}}" placeholder="Enter Title" >
                                                </div>
                                            </div>
        


                                            <div class="col-md-6 col-12">
                                                <div class="form-check form-switch">
                                                    <label class="control-label">Keep Inventory</label>
                                                    <br>
                                                    <input type="checkbox" name="manage_inventory" class="js-keepinventory" value="1">
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
                                            @if ((!request()->has('action') && !request()->get('action') == 'nonbranded'))
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
                                            <div class="col-md-6 col-12"> 
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
                                            <div class="col-md-6 col-12"> 
                                                <div class="form-group">
                                                    <label for="sub_category">Sub Category <span class="text-danger">*</span></label>
                                                    <select required name="sub_category" data-selected-subcategory="{{ old('sub_category') }}" id="sub_category" class="form-control select2">
                                                        <option value="" readonly>Select Sub Category </option>
                                                        @if(old('sub_category'))
                                                            <option value="{{ old('sub_category') }}" selected> {{ fetchFirst('App\Models\Category',old('sub_category'),'name','') }}</option>
                                                        @endif 
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Model Number</label>
                                                    <input type="text" class="form-control" placeholder="Enter Model Number" name="model_code"
                                                    value="{{ old('model_code') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12"> 
                                                <div class="form-group {{ $errors->has('mrp') ? 'has-error' : ''}}">
                                                    <label for="mrp" class="control-label">General Price , without GST</label>
                                                    <input class="form-control" name="mrp" type="number" id="mrp" value="{{ old('mrp') }}" >
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 d-none"> 
                                                <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                                                    <label for="price" class="control-label">MRP </label>
                                                    <input class="form-control" name="price" type="number" id="price" value="{{ old('price') ?? 0 }}" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="stepper d-none" data-index="2">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Dimensions</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <img style="height: 230px;" src="{{ asset('frontend/assets/img/product/item.jpg') }}" class="img-fluid" alt="" >
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-md-6 col-12 mt-2"> 
                                                        <label class="">{{ __('Length')}}</label>
                                                            <input class="form-control" name="length" type="number" id="length" value="{{@$shipping->length ?? old('length')}}" >
                                                    </div>
                                                    <div class="col-md-6 col-12 mt-2"> 
                                                        <label class="">{{ __('Width')}}</label>
                                                            <input class="form-control" name="width" type="number" id="width" value="{{@$shipping->width ?? old('width')}}" >
                                                    </div>
                                                    <div class="col-md-6 col-12 mt-2"> 
                                                        <label class="">{{ __('Height')}}</label>
                                                            <input class="form-control" name="height" type="number" id="height" value="{{@$shipping->height ?? old('height')}}" >  
                                                    </div>
                                                    <div class="col-md-6 col-12 mt-2"> 
                                                        <label class="">{{ __('LWH UOM')}}</label>
                                                            <select name="length_unit" id="length_unit" class="form-control">
                                                                <option @if(@$shipping->length_unit == 'mm') selected @endif value="mm">mm</option>
                                                                <option  @if(@$shipping->length_unit == 'cms') selected @endif value="cms">cms</option>
                                                                <option  @if(@$shipping->length_unit == 'inches') selected @endif value="inches">inches</option>
                                                                <option  @if(@$shipping->length_unit == 'feet') selected @endif value="feet">feet</option>
                                                            </select>
                                                            {{-- <input class="form-control" name="length_unit" type="text" id="length_unit" value="{{$shipping->length_unit ?? old('length_unit')}}" > --}}
                                                    </div>
                                                    
                                                
                                                

                                                    <div class="col-12">
                                                        <hr class="text-primary">
                                                    </div>
                                                    <div class="col-md-6 col-12 mt-2"> 
                                                        <label class="">{{ __('Weight')}}</label>
                                                            <input class="form-control" name="weight" type="number" id="weight" value="{{$shipping->weight ?? old('weight')}}" >
                                                        
                                                    </div>
                                                    
                                                    <div class="col-md-6 col-12 mt-2"> 
                                                        <label class="">{{ __('Weight UOM')}}</label>
                                                            {{-- <input class="form-control" name="unit" type="text" id="unit" value="{{$shipping->unit ?? old('unit')}}" > --}}
                                                            <select name="unit" id="unit" class="form-control">
                                                                <option @if(@$shipping->unit == 'gms') selected @endif value="gms">gms</option>
                                                                <option  @if(@$shipping->unit == 'kgs') selected @endif value="kgs">kgs</option>
                                                            </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Carton Detail</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <img src="{{ asset('frontend/assets/img/product/carton.jpg') }}" alt="" class="img-fluid">
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-md-12 col-12"> 
                                                        <label class="">{{ __('Standard Carton Pcs')}}</label>
                                                        <div class="form-group">
                                                            <input class="form-control" name="standard_carton" type="number" id="standard_carton" value="{{$carton_details->standard_carton ?? old('standard_carton')}}" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12"> 
                                                        <label class="">{{ __('Carton Actual Weight')}} (Kg's)</label>
                                                        <div class="input-group">
                                                            <input class="form-control" name="carton_weight" type="number" id="carton_weight" value="{{$carton_details->carton_weight ?? old('carton_weight')}}" >
                                                            {{-- <span class="input-group-append" id="basic-addon3">
                                                                <label class="input-group-text">In kg</label>
                                                            </span> --}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12"> 
                                                        <label class="">{{ __('UMO')}}</label>
                                                        <div class="form-group">
                                                            {{-- <input class="form-control" name="carton_unit" type="number" id="carton_unit" value="{{$carton_details->carton_unit ?? old('carton_unit')}}" >
                                                            <span class="input-group-append" id="basic-addon3">
                                                                <label class="input-group-text">In kg</label>
                                                            </span> --}}
                                                            <select name="carton_unit" id="carton_unit" class="form-control">
                                                                <option @if(@$carton_details->carton_unit == 'pcs') selected @endif value="pcs">pcs</option>
                                                                <option @if(@$carton_details->carton_unit == 'sets') selected @endif value="sets">sets</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h3>HSN Info</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12"> 
                                                <div class="form-group {{ $errors->has('hsn') ? 'has-error' : ''}}">
                                                    <label for="hsn" class="control-label">HSN </label>
                                                    <input class="form-control" name="hsn" type="number" id="hsn" value="{{ old('hsn') }}" >
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12"> 
                                                <div class="form-group {{ $errors->has('hsn_percent') ? 'has-error' : ''}}">
                                                    <label for="hsn_percent" class="control-label">HSN Percent </label>
                                                    <div class="input-group">
                                                        <input class="form-control" name="hsn_percent" type="number" id="hsn_percent" value="{{ old('hsn_percent') }}" >
                                                        <span class="input-group-append" id="basic-addon3">
                                                            <label class="input-group-text">%</label>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="stepper d-none" data-index="3">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Product Images</h3>
                                    </div>
                                    @php
                                        $colors = json_decode($colors->value,true);
                                        $sizes = json_decode($sizes->value,true);
                                        $materials = json_decode($materials->value,true);
                                    @endphp
                                    <div class="card-body">
                                        <div class="row">
                                                
                                                <div class="col-md-12 col-12 form-group {{ $errors->has('img') ? 'has-error' : ''}}">
                                                    {{-- <div class="image-input">
                                                        <input type="file" accept="image/*" id="imageInput" name="img[]" multiple value="{{old('img')}}">
                                                        <label for="imageInput" class="image-button"><i class="far fa-image"></i> Choose image</label>
                                                        <span class="change-image">Choose different image</span>
                                                    </div> --}}
                                                    <div class="form-group mb-0">
                                                        <input class="form-control" type="file" name="img[]" multiple value="{{old('img')}}"  accept=".png, .jpg, .jpeg">
                                                    </div>
                                                    <p class="pb-0"><i class="ik ik-info mr-1"></i>Multiple images can be selected at once by using the control key.</p> 
                                                </div>
                                                <div class="col-md-6 col-12"> 
                                                    <div class="form-group {{ $errors->has('artwork_url') ? 'has-error' : ''}}">
                                                        <label for="artwork_url" class="control-label">Art Work Reference</label>
                                                        <input class="form-control" name="artwork_url" type="url" id="artwork_url" value="{{old('artwork_url')}}" placeholder="Enter Artwork URL" >
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                    {{-- <div class="card">
                                        <div class="card-header">
                                            <h3>Prices</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12"> 
                                                    <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                                                        <label for="price" class="control-label">Price </label>
                                                        <input class="form-control" name="price" type="number" id="price" value="{{ old('price') ?? 0 }}" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12"> 
                                                    <div class="form-group {{ $errors->has('mrp') ? 'has-error' : ''}}">
                                                        <label for="mrp" class="control-label">MRP </label>
                                                        <input class="form-control" name="mrp" type="text" id="mrp" value="{{ old('mrp') }}" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

                                <div class="card">
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
                                            <div class="col-md-6 col-12"> 
                                                <div class="form-group mb-0">
                                                    <label for="input">{{ __('Material')}}</label>
                                                </div>
                                                <select class="form-control select2" name="material" id="material">
                                                    <option value="" readonly disabled>Select material</option>
                                                    @foreach (explode(',',$materials[0]) as $item)
                                                        <option {{in_array($item, old('material') ?: []) ? "selected": ""}}  value="{{ $item }}" >{{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="stepper d-none" data-index="4">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Content</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 d-none">
                                                <div class="form-group">
                                                    <label for="">Tag 1</label>
                                                    <select name="tag1" id="" class="form-control">
                                                        <option value="" aria-readonly="true">Select Tag 1</option>
                                                        @foreach(App\Models\Category::where('category_type_id',15)->get() as $tag1)
                                                            <option value="{{ $tag1->name }}"> {{ $tag1->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-none">
                                                <div class="form-group">
                                                    <label for="">Tag 2</label>
                                                    <select name="tag2" id="" class="form-control">
                                                        <option value="" aria-readonly="true">Select Tag 2</option>
                                                        @foreach(App\Models\Category::where('category_type_id',16)->get() as $tag2)
                                                            <option value="{{ $tag2->name }}"> {{ $tag2->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 d-none">
                                                <div class="form-group">
                                                    <label for="">Tag 3</label>
                                                    <select name="tag3" id="" class="form-control">
                                                        <option value="" aria-readonly="true">Select Tag 3</option>
                                                        @foreach(App\Models\Category::where('category_type_id',17)->get() as $tag3)
                                                            <option value="{{ $tag3->name }}"> {{ $tag3->name }}</option>
                                                        @endforeach
                                                    </select>
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
                                                    <label for="description" class="control-label">Product Description</label>
                                                    <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                                                </div>
                                            </div>
                                            {{-- <div class="col-md-12 col-lg-12 col-12">
                                                <div class="form-group {{ $errors->has('features') ? 'has-error' : ''}}">    
                                                    <label for="features" class="control-label">Features</label>
                                                    <textarea name="features" class="form-control" id="" cols="30" rows="5">{{ old('features') }}</textarea>
                                                </div>
                                            </div> --}}
                                            <div class="col-md-6 col-6">
                                                <div class="form-group {{ $errors->has('meta_description') ? 'has-error' : ''}}">
                                                    <label for="meta_description" class="control-label">Meta Description</label>
                                                    <textarea name="meta_description" class="form-control" id="" cols="30" rows="3">{{ old('meta_description') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                <div class="form-group {{ $errors->has('meta_keywords') ? 'has-error' : ''}}">
                                                    <label for="meta_keywords" class="control-label">Meta Keywords</label>
                                                    <textarea name="meta_keywords" class="form-control" id="" cols="30" rows="3">{{ old('meta_keywords') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                        
                        

                            <div class="row stepper-actions justify-content-center mx-auto">
                                <div class="col-lg-3">
                                    <a href="#" class="btn btn-outline-primary previous_btn d-none">Previous</a>
                                </div>
                                <div class="col-lg-3 form-group d-flex justify-content-center">
                                    <a href="#" class="btn btn-primary next_btn">Next</a>
                                </div>
                                <div class="col-lg-6 d-flex justify-content-end">
                                    <label class="create_btn d-none">Save & Add more
                                        <input type="submit" value="1" name="btn1" class="btn btn-primary btn-sm ">
                                    </label> 
                                    {{-- <label class="create_btn d-none">Save & Preview all
                                        <input type="submit" value="2" name="btn1" class="btn btn-primary btn-sm ml-3">
                                    </label>  --}}
                                
                                    {{-- <input type="submit" value="2" name="btn1" class="btn btn-primary btn-md create_btn d-none"> --}}
                                    {{-- <input type="submit" name="btn1" class="">Save & Add more />
                                    <button type="submit" name="btn2" class="btn btn-primary btn-md create_btn d-none ml-3">Save & Preview all</button> --}}
                                </div>
                            </div>
                        </form>    
                    </div>
                    
                </div>
            {{-- single product end --}}
    
    
            {{-- Bulk Cart start --}}
                <div class="row bulk_product d-none">
                    <div class="col-md-10 mx-auto">
                            <div class="justify-content-center mx-auto d-flex mb-3">
                                <button class="btn btn-primary" id="import-btn">Import Products</button>
                                <button class="btn ml-3" id="export-btn">Export Products</button>
                            </div>
                        <div class="card">  
                            <div class="card-header">
                                <h3>Import/Export Product</h3>
                            </div>
                            <div class="import pt-0 p-3">
                                <div class="d-flex justify-content-end">
                                    {{-- <a href="{{ asset('utility/bulk-product.xls') }}" type="button"  class="btn-link mb-3">Download Excel</a> --}}
                                    <a href="{{ route('panel.bulk.product.bulk-sheet-export',auth()->id()) }}" type="button"  class="btn-link mb-3">Download Excel</a>
                                </div>
                                <form action="{{ route('panel.bulk.product-upload') }}" method="post" enctype="multipart/form-data" class="">
                                    <input type="hidden" name="brand_id" value="{{ request()->get('id') ?? '0' }}">
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
                            <div class="export d-none pt-0 p-3">
                                <div class="d-flex justify-content-end">
                                    <a href="{{route('panel.bulk.product.bulk-export',auth()->id())}}" type="button"  class="btn-link mb-3">Fill & Upload</a>
                                </div>
                                    <form action="{{ route('panel.bulk.product.bulk-update') }}" method="post" enctype="multipart/form-data" class="">
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



            {{-- Custom Bulk Sheet Start --}}
                
            <div class="row d-none">
                <div class="col-md-10 mx-auto">
                    <div class="card">  
                        <div class="card-header">
                            <h3>Custom Upload Folders</h3>
                        </div>
                        <div class="import pt-0 p-3">
                            <div class="create">
                                <form action="{{ route('panel.bulk.product.custom.bulk-sheet-export',auth()->id()) }}" method="POST">
                                    <div class="mb-3">                                        
                                        <select name="myfields[]" id="myfields"  class="form-control select2" multiple>
                                            @foreach ($col_list as $key => $item)
                                            <option value="{{ $key }}" selected>{{ $key }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button class="btn btn-outline-primary" type="submit">Download File</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card">  
                        <div class="card-header">
                            <h3>Custom Upload Folders</h3>
                        </div>
                        <div class="import pt-0 p-3">
                            <div class="create">
                                <form action="{{ route('panel.bulk.custom.product-upload',auth()->id()) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- <div class="form-group">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <input type="text" class="form-control" name="remarks" id="remarks" placeholder="Enter Remarks for Next Time">
                                    </div> --}}
                                    <div class="mb-3">
                                      <label for="myfields" class="form-label">Select Fields</label>    
                                      <input type="file" name="uploadcustomfield" id="uploadcustomfield" class="form-control">
                                    </div>
                                    <button class="btn btn-outline-primary" type="submit">Submit</button>
                                </form>
                            </div>


                            <div class="table-responsive mt-3">
                                <table class="table table-light">
                                    <thead>
                                        <tr>
                                            <th scope="col">S no.</th>
                                            <th scope="col">File name</th>
                                            <th scope="col">Uploaded on</th>
                                            <th scope="col">Records</th>
                                            <th scope="col">Download</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $record = App\Models\Uploadrecord::where('user_id',auth()->id())->paginate(20);
                                            $user = auth()->user();
                                        @endphp
                                        
                                        @forelse ($record as $item)
                                            <tr class="">
                                                <td scope="row">{{ $loop->iteration}}</td>
                                                <td>{{ $item->sheet_name }}</td>
                                                <td>{{ $item->last_used }}</td>
                                                <td>{{ $item->records }}</td>
                                                <td>
                                                    <a href="{{ asset($item->path) }}" class="btn btn-outline-primary btn-sm">Download</a>
                                                </td>
                                            </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4">No FIle Uploaded..</td>
                                        </tr>
                                            
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            



                        </div>
                        
                    </div>



                </div>
            </div>
            
            
            {{-- Custom Bulk Sheet End --}}


            <div class="row get_custom_Product d-none mt-3">
                
                <div class="col-md-12 col-12">

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Template Name</th>
                                    <th scope="col">Action</th>
                                    <th scope="col">Created On</th>
                                </tr>
                            </thead>
                            <tbody>

                                
                                @forelse ($ExistingTemplates as $item)
                                    <tr class="">
                                        <td scope="row">{{ $loop->iteration }}</td>
                                        <td> {{ $item->template_name ?? 'No Name'}} </td>
                                        <td>
                                            <a href="{{ route('panel.products.download.template',$item->id) }}" class="btn btn-outline-primary btn-sm">Download</a>
                                            <a href="{{ route('panel.products.edit.template',$item->id) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                                        </td>
                                        <td>
                                            {{  $item->created_at }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="">
                                        <td scope="row" colspan="4">Nothing to Show Here..</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                </div>


            </div>

            
            
            
        </div>
    </div>
    @include('panel.products.include.create_template')



</div>
    <!-- push external js -->
    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{asset('backend/js/form-advanced.js') }}"></script>
    <script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
    <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>
    <script>

        $(document).ready(function () {
            $("#check_all").click(function (e) {
                $(".my_attribute").click();
            });

            $(".my_attribute").click(function (e) { 
                let keyindex = $(this).data('index');
                let tag = `<div class="form-group" id="parent_${$(this).data('index')}">
                    <input type="checkbox" value="${$(this).val()}" id="${$(this).attr('id')}" class="selected_prop m-2" checked data-parent="parent_${$(this).data('index')}">
                    <label for="${$(this).attr('id')}" class="form-label" style="font-size: large;user-select: none;">${$(this).val()}</label>
                </div>`;

                if ($(this).is(":checked")) {
                    $(".selected_tag").append(tag);
                }else{
                    $(`#parent_${$(this).data('index')}`).remove();
                }
            });

        });
    </script>
    

    <script>
        //demo 01
        $("#demo01").animatedModal({
            animatedIn: 'lightSpeedIn',
            animatedOut: 'bounceOutDown',
            color: '#f3f3f3',

        });
        

        $('tags').tagsinput('items'); 
         var options = {
                  filebrowserImageBrowseUrl: "{{ url('/laravel-filemanager?type=Images') }}",
                  filebrowserImageUploadUrl: "{{ url('/laravel-filemanager/upload?type=Images&_token='.csrf_token()) }}",
                  filebrowserBrowseUrl: "{{ url('/laravel-filemanager?type=Files') }}",
                  filebrowserUploadUrl: "{{ url('/laravel-filemanager/upload?type=Files&_token='.csrf_token()) }}"
              };
              $(window).on('load', function (){
                  CKEDITOR.replace('description', options);
              });
       
        $('#ProductForm').validate();
        
        
        // Single swithces
        var acr_btn = document.querySelector('.js-keepinventory');
        var switchery = new Switchery(acr_btn, {
            color: '#6666CC',
            jackColor: '#fff'
        });

        
        $(document).ready(function () {
            
            $('#import-btn').on('click', function () {
                $('.import').removeClass('d-none')
                $('.export').addClass('d-none')
                $('.import-div').removeClass('d-none')
                $('.export-div').addClass('d-none')
                $('#export-btn').removeClass('btn-primary')
                $(this).addClass('btn-primary')
            });
            $('#export-btn').on('click', function () {
                $('.export').removeClass('d-none')
                $('.import').addClass('d-none')
                $('.import-div').addClass('d-none')
                $('#import-btn').removeClass('btn-primary')
                $('#import-btn').addClass('')
                $(this).addClass('btn-primary')
            });


            // enable Shortcutkey for ( Ctrl + <- ) TO Back
            // $(document).keydown(function (e) {
            //     if (e.ctrlKey && e.which == 37) {
            //         $(".back_btn").click()
            //     }
            // });

        });

       
        $('.getSingleProduct').on('click',function(){
            $('.product_boxes').addClass('d-none');
            $('.show_single_prouduct').removeClass('d-none');
            $('.back_btn').removeClass('d-none');
        })

        $('.getcustomProduct').on('click',function(){
            $('.product_boxes').addClass('d-none');
            $('.get_custom_Product').removeClass('d-none');
            $('.back_btn').removeClass('d-none');
        })


        $('.back_btn').on('click',function(){
            $('.product_boxes').removeClass('d-none');
            $('.show_single_prouduct').addClass('d-none');
            $('.get_custom_Product').addClass('d-none');
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
      
        
        $(document).ready(function() {
            var steps = $('.stepper').length;
            var activeIndex = 1;

            $('.stepper-actions').on('click', '.next_btn', function (e) {
                if(activeIndex < steps){
                    var title_val =  $('#title').val();
                    var category =  $('#category_id').val();
                    var sub_category =  $('#sub_category').val();
                    var title = title_val.trim();
                    
                    if(title == ''){
                        alert('Title field is required');
                    }else if(category == ''){
                        alert('Category field is required');
                    }else if(sub_category == ''){
                        alert('Subcategory field is required');
                    }else{
                        $('[data-index='+activeIndex+']').addClass('d-none');
                        $('.custom_active_add-'+activeIndex).addClass('active');
                        activeIndex++;
                        $('[data-index='+activeIndex+']').removeClass('d-none');
                        $('.stepper-actions').find('.previous_btn').removeClass('d-none');
                    }
                  
                }
                if(activeIndex == steps){
                    $(this).hide();
                    $('.create_btn').removeClass('d-none');
                }
            });

            $('.stepper-actions').on('click', '.previous_btn', function (e) {
                if(activeIndex > 1){
                    $('[data-index='+activeIndex+']').addClass('d-none');
                    $('.create_btn').addClass('d-none');
                    activeIndex--;
                    $('.custom_active_add-'+activeIndex).removeClass('active');
                    $('[data-index='+activeIndex+']').removeClass('d-none');
                    $('.stepper-actions').find('.next_btn').show();
                }
                if(activeIndex == 1){
                    $(this).addClass('d-none');
                }
            });

           
        });
						
    $('.change-image').on('click', function() {
        $control = $(this);			
        $('#imageInput').val('');	
        $preview = $('.image-preview');
        $preview.attr('src', '');
        $preview.css('display', 'none');
        $control.css('display', 'none');
        $('.image-button').css('display', 'block');
    });
    var limit = 5;
    $(document).ready(function(){
        $('#imageInput').change(function(){
            var files = $(this)[0].files;
            if(files.length > limit){
                alert("You can select max "+limit+" images.");
                $('#imageInput').val('');
                return false;
            }else{
                return true;
            }
        });
    });
    </script>
    @endpush
@endsection
