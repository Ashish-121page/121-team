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
    $breadcrumb_arr = [['name' => 'Edit Product', 'url' => 'javascript:void(0);', 'class' => '']];
    @endphp
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">    
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <style>
            .error {
                color: red;
            }
            .product-img{
                border-radius: 10px;
                width: 100%;
                height: 100%;
                object-fit: contain;
            }
            .bootstrap-tagsinput .tag{
                text-transform: none !important;
            }
            .bootstrap-tagsinput{
                width: 100% !important;
            }

            .hoverbtn{
                position: fixed;
                bottom: 30%;
                right: 2%;
                z-index: 9999;
            }

            .click1{
                cursor: pointer;
            }

            .active{
                background-color: transparent;
                color: #6666cc;
                border: none;
                outline: none;
                border-bottom: 1px solid #6666cc;
            }
            
        </style>
    @endpush

    <div class="container-fluid">
        <div class="page-header d-none">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>Edit Product</h5>
                            {{-- <span>Update a record for Product</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>

        <div class="hoverbtn">
            <a href="{{ route('panel.user_shop_items.create') }}?type=direct&type_id={{auth()->id()}}&productsgrid=true" class="btn btn-xl btn-outline-secondary">Discard</a>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12 mx-auto">
                        <!-- start message area-->
                        @include('backend.include.message')
                        <!-- end message area-->
                        <form action="{{ route('panel.products.update', $product->id) }}" method="post" enctype="multipart/form-data" id="ProductForm">
                            @csrf
                            <input type="hidden" name="brand_id" value="{{$product->brand_id}}">
                            <div class="row mb-5">
                                <div class="col-6" style="margin-bottom: 4%">
                                    <a href="{{ route('panel.user_shop_items.create') }}?type=direct&type_ide={{ encrypt(auth()->id()) }}&productsgrid=true" class="btn btn-secondary">Back</a>
                                </div>
                                
                                <div class="col-6">
                                    <a href="{{ route('panel.products.update.qr') }}?product_ids={{$product->id}}" target="_blank" class="btn btn-outline-primary btn-sm mx-1">Get QR</a>

                                    <a href="{{ route('panel.bulk.product.bulk-export',auth()->id()) }}?products={{$product->id}}" target="_blank" class="btn btn-outline-primary btn-sm mx-1"> Export </a>
                                </div>
                            </div>

                            {{-- <div class="row">
                                <div class="col-12 d-flex justify-content-end w-100">
                                    <button type="button" class="chaneview btn btn-outline-primary mx-1" data-work="next" >Next</button>
                                    <button type="button" class="chaneview btn btn-outline-primary mx-1" data-work="prev" >Prev</button>
                                </div>
                            </div> --}}

                    

                            <div class="row stepper-actions">
                                <div class="col-lg-4">
                                    <a href="#" class="btn btn-outline-primary previous_btn d-none">Previous</a>
                               </div>
                                <div class="col-lg-4 d-flex form-group justify-content-center">
                                    <button type="submit" class="btn btn-primary btn-md update_btn ">Save & Exit</button>
                                </div>
                                <div class="col-lg-4 d-flex form-group justify-content-end">
                                    <a href="#" class="btn btn-primary next_btn" >Next</a>
                                </div>
                            </div>

                            {{-- Stepper Start --}}
                            {{-- <div class="md-stepper-horizontal orange mt-5 d-none">
                                <div class="md-step active done custom_active_add-0" data-step="0">
                                    <div class="md-step-circle"><span>1</span></div>
                                    <div class="md-step-title">Essentials</div>
                                    <div class="md-step-bar-left"></div>
                                    <div class="md-step-bar-right"></div>
                                </div>
                                <div class="md-step editable custom_active_add-1" data-step="1">
                                    <div class="md-step-circle"><span>2 </span></div>
                                    <div class="md-step-title">Asset Safe</div>
                                    <div class="md-step-bar-left"></div>
                                    <div class="md-step-bar-right"></div>
                                </div>
                                <div class="md-step editable custom_active_add-2" data-step="2">
                                    <div class="md-step-circle"><span>4</span></div>
                                    <div class="md-step-title">Basic Info</div>
                                    <div class="md-step-bar-left"></div>
                                    <div class="md-step-bar-right"></div>
                                </div>
                                <div class="md-step editable custom_active_add-4" data-step="3">
                                    <div class="md-step-circle"><span>6</span></div>
                                    <div class="md-step-title">Internal - Production</div>
                                    <div class="md-step-bar-left"></div>
                                    <div class="md-step-bar-right"></div>
                                </div>
                            
                            </div> --}}
                            <div class="orange mt-5" style="display: flex;margin: 0 auto;width: 100%;gap : 10px;align-items: center;justify-content: center;">
                                <div class="md-step  btn active done custom_active_add-0" data-step="0"> Product Info </div>
                                <div class="md-step btn  editable custom_active_add-1" data-step="1"> Assets </div>
                                <div class="md-step  btn editable custom_active_add-2" data-step="2"> Internal - Reference </div>
                                <div class="md-step btn  editable custom_active_add-4" data-step="3"> Internal - Production </div>
                            
                            </div>
                            {{--  Stepper End  --}}
                           

                            @php
                                $image_ids = $user_shop_item->images != null ? explode(',',$user_shop_item->images) : [];
                            @endphp

                            <div class="row">
                                {{-- Side Bar --}}
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <img src="{{ asset(getMediaByIds($image_ids)->path ?? asset('frontend/assets/img/placeholder.png')) }}" class="img-fluid " style="height: 250px;width: 100%;object-fit: contain;" alt="">                                        
                                        </div>
                                        <div class="col-12">

                                            <div class="row my-1">
                                                <div class="col-4"> Model Code </div>
                                                <div class="col-8">
                                                    <input type="text" class="form-control" name="model_code" value="{{ $product->model_code ?? old('model_code') }}" required>
                                                </div>
                                            </div>

                                            <div class="row my-1">
                                                <div class="col-4">
                                                    Title: 
                                                </div>
                                                <div class="col-8">
                                                    <input  class="form-control" name="title" type="text" id="title" value="{{$product->title}}" required >
                                                </div>
                                            </div>
                                            
                                            <div class="row my-1">
                                                <div class="col-4">
                                                    Group Id: 
                                                </div>
                                                <div class="col-8">
                                                    <select name="Cust_tag_group" class="form-control changegroup" id="Cust_tag_group">
                                                        @foreach ($groupIds_all as $key => $item)
                                                            <option value="{{$key ?? ''}}" @if (in_array($item,$groupIds,true)) selected @endif>{{$item}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row my-1">
                                                <div class="col-4">
                                                    <span>Modified </span>
                                                </div>
                                                <div class="col-8">
                                                    <input type="datetime" class="form-control" value="{{ $product->updated_at }}" style="border: none">                                                    
                                                </div>
                                            </div>
                                            
                                            <div class="row my-1">
                                                <div class="col-4">
                                                    <span>Created</span>
                                                </div>
                                                <div class="col-8">
                                                    <input type="datetime" class="form-control" value="{{ $product->created_at }}" style="border: none">
                                                </div>
                                            </div>

                                            <div class="row my-1">
                                                <div class="col-4">
                                                    Variants Basis
                                                </div>
                                                <div class="col-8">
                                                    {{ getAttruibuteById( getAttruibuteValueById($leastRepeated)->parent_id)->name ?? '' }}
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-12">
                                            <h5>Variants</h5>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Variants</th>
                                                        <th scope="col">Edit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>    
                                                       @foreach ($product_variant_combo as $product_variant)
                                                            <tr>
                                                                <td> {{ $loop->iteration }} </td>
                                                                <td>
                                                                    @foreach ($product_variant as $key => $item)
                                                                        {{ getAttruibuteValueById($item)->attribute_value }}
                                                                        @if ($key < count($product_variant) - 1)
                                                                            , 
                                                                        @endif
                                                                    @endforeach
                                                                </td>
                                                                <td>
                                                                    @php
                                                                       $proid =  App\Models\ProductExtraInfo::whereIn('attribute_value_id',$product_variant)->wherein('product_id',$available_products)->where('user_id',$product->user_id)->where('group_id',$product->sku)->first();
                                                                       @endphp
                                                                    @if ($proid != null)
                                                                        <a href="{{ route('panel.products.edit',$proid->product_id) }}" class="btn btn-outline-primary">
                                                                            View / Edit
                                                                        </a>
                                                                        <a href="{{ route('panel.products.delete.sku',encrypt($proid->product_id)) }}" class="btn btn-outline-danger delete-btn">
                                                                            <i class="fa fa-trash"></i>
                                                                        </a>
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            @php
                                                                if ($proid != null) {
                                                                    $available_products = array_diff($available_products, [$proid->product_id]);
                                                                }
                                                            @endphp
                                                       @endforeach                                                      
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
    
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                        <div class="stepper" data-index="1">
                                            <div class="card ">
                                                <div class="card-header mx-2">
                                                    {{-- <h3>Edit Product</h3> --}}
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">                                                       
                                                
                                                         <div class="col-md-6 col-12">
                                                            <div class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
                                                                <label for="category_id">Category<span class="text-danger">*</span></label>
                                                                <select name="category_id" id="category_id" class="form-control select2" required >
                                                                    <option value="" readonly>Select Category  <span class="text-danger">*</span> </option>
                                                                    @foreach($category  as $option)
                                                                        <option value="{{ $option->id }}" @if ($option->id == $product->category_id) selected
                                                                        @endif>{{  $option->name ?? ''}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12">
                                                            <div class="form-group {{ $errors->has('sub_category') ? 'has-error' : ''}}">
                                                                <label for="sub_category">Sub Category <span class="text-danger">*</span></label>
                                                                <select name="sub_category" id="sub_category" class="form-control select2" required>
                                                                    <option value="" readonly>Select Sub Category </option>
                                                                    @if($product->sub_category)
                                                                        <option value="{{ $product->sub_category }}" selected>{{ fetchFirst('App\Models\Category',$product->sub_category,'name') }}</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>

                                                        {{-- --Moved --}}
                                                        <div class="col-12 my-2">
                                                            <div class="card-header">
                                                                <h3>Sale Pricing</h3>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4 col-4">
                                                            <div class="form-group ">
                                                                <label for="base_currency" class="control-label">Base currency </label>
                                                                {{-- <input  class="form-control" name="base_currency" type="text" id="base_currency" value="{{$product->base_currency}}" > --}}
                                                                @php
                                                                    $currencies = App\Models\UserCurrency::where('user_id',auth()->id())->get();
                                                                @endphp
                                                                <select name="base_currency" id="base_currency" class="select2">
                                                                    @forelse ($currencies as $item)
                                                                        <option value="{{ $item->currency }}" @if ($product->base_currency == $item->currency) selected @endif>{{ $item->currency }}</option>
                                                                    @empty
                                                                        <option value="INR">INR</option>
                                                                    @endforelse
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-4">
                                                            <div class="form-group ">
                                                                <label for="selling_price_unit" class="control-label">Selling Price Unit </label>
                                                                <input  class="form-control" name="selling_price_unit" type="text" id="selling_price_unit" value="{{$product->selling_price_unit}}" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-4">
                                                            <div class="form-group">
                                                                <label for="min_sell_pr_without_gst" class="control-label">Customer Price, without GST </label>
                                                                <input class="form-control" name="min_sell_pr_without_gst" type="number" id="min_sell_pr_without_gst" value="{{ $product->min_sell_pr_without_gst ?? '' }}" >
                                                            </div>
                                                        </div>
            
                                                        @php
                                                            $vip_group = getPriceGroupByGroupName(auth()->id(),"VIP");
                                                            $reseller_group = getPriceGroupByGroupName(auth()->id(),"Reseller");
                                                        @endphp
            
                                                        
                                                        <div class="col-md-4 col-4 d-none">
                                                            <div class="form-group ">
                                                                <label for="vip_group" class="control-label">VIP Customer Price, without GST  </label>
                                                
                                                                <input  class="form-control" name="vip_group" type="number" id="vip_group" value="{{ getPriceByGroupIdProductId($vip_group->id,$product->id,0) ?? '0' }}" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-4 d-none">
                                                            <div class="form-group ">
                                                                <label for="reseller_group" class="control-label">Reseller Price, without GST </label>
                                                                <input  class="form-control" name="reseller_group" type="number" id="reseller_group"  value="{{ getPriceByGroupIdProductId($reseller_group->id,$product->id,0) ?? '0' }}" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-4">
                                                            <div class="form-group ">
                                                                <label for="mrp" class="control-label">MRP Incl. tax </label>
                                                                <input  class="form-control" name="mrp" type="number" id="mrp" value="{{ $product->mrp  }}" >
                                                            </div>
                                                        </div>                                               
            
            
                                                        <div class="col-md-4 col-4">
                                                            <div class="form-group {{ $errors->has('hsn') ? 'has-error' : ''}}">
                                                                <label for="hsn" class="control-label">HSN Tax</label>
                                                                <input  class="form-control" name="hsn" type="text" id="hsn" value="{{$product->hsn}}" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-4">
                                                            <div class="form-group {{ $errors->has('hsn_percent') ? 'has-error' : ''}}">
                                                                <label for="hsn_percent" class="control-label">HSN Percent </label>
                                                                <input  class="form-control" name="hsn_percent" type="number" id="hsn_percent" value="{{$product->hsn_percent}}" >
                                                            </div>
                                                        </div>
                                                        



                                                        {{-- --Moved --}}
                                                        <div class="col-12 my-2">
                                                            <div class="card-header">
                                                                <h3>Properties</h3>
                                                            </div>
                                                        </div>
                                                        {{-- ` PRODUCT WEIGHT GROUP --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                    <hr class="text-primary">
                                                                    <label for="weightbox">
                                                                        <div class="h6">Product Weight</div>
                                                                    </label> &nbsp;&nbsp;&nbsp;
            
            
                                                                    <input type="checkbox" data-open="weightboxbtn" id="weightbox" class="hiddenbxbtn" @if ($shipping->gross_weight ?? '' != '' || $shipping->weight ?? '' != '' ) checked @endif>
                                                                </div>
                                                            </div>
                                                            <div class="row d-none" id="weightboxbtn">
                                                                <div class="col-md-4 col-4">
                                                                    <div class="form-group ">
                                                                        <label for="gross_weight" class="control-label">Gross Weight</label>
                                                                        <input  class="form-control" name="gross_weight" type="text" id="gross_weight" value="{{ $shipping->gross_weight ?? ''}}" >
                                                                    </div>
                                                                </div>
                
                                                                <div class="col-md-4 col-4">
                                                                    <label class="">{{ __('Weight')}}</label>
                                                                    <div class="form-group">
                                                                        <input class="form-control" name="weight" type="nnumber" id="weight" value="{{ $shipping->weight ?? ''}}" >
                                                                    </div>
                                                                </div>
                
                                                                <div class="col-md-4 col-4">
                                                                    <label class="">{{ __('Weight UOM')}}</label>
                                                                    {{-- Drop Down --}}
                                                                    {{-- gms/kgs --}}
                                                                    <div class="form-group">
                                                                        <select name="unit" id="unit" class="form-control select2">
                                                                            <option @if(($shipping->unit ?? '') == 'gms') selected @endif value="gms">gms</option>
                                                                            <option @if(($shipping->unit ?? '') ==  'kgs') selected @endif value="kgs">kgs</option>
                                                                        </select>
                                                                        {{-- <input class="form-control" name="unit" type="nnumber" id="unit" value="{{$shipping->unit ?? ''}}" > --}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
            
                                                        {{-- ` PRODUCT DIMENSION GROUP --}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                    <hr class="text-primary">
                                                                    <label for="productdimensionsbx">
                                                                        <div class="h6">Product Dimensions</div>
                                                                    </label> &nbsp;&nbsp;&nbsp;
                                                                    <input type="checkbox" data-open="productdimensionsbox" id="productdimensionsbx" class="hiddenbxbtn" @if ($shipping->length ?? '' != '' || $shipping->width ?? '' != '' || $shipping->height ?? '' != '' ) checked @endif >
                                                                </div>
                                                            </div>
                                                            <div class="row d-none" id="productdimensionsbox">
                                                                
                                                                <div class="col-md-6 col-12">
                                                                    <label class="Length">{{ __('Length')}}</label>
                                                                    <div class="form-group">
                                                                        <input class="form-control" name="length" type="nnumber" id="length" value="{{$shipping->length ?? ''}}" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <label class="">{{ __('Width')}}</label>
                                                                    <div class="form-group">
                                                                        <input class="form-control" name="width" type="nnumber" id="width" value="{{$shipping->width ?? ''}}" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <label class="">{{ __('Height')}}</label>
                                                                        <div class="form-group">
                                                                            <input class="form-control" name="height" type="nnumber" id="height" value="{{$shipping->height ?? ''}}" >
                                                                        </div>
                                                                    </div>
            
                                                                <div class="col-md-6 col-12">
                                                                    <label class="">{{ __('LWH UOM')}}</label>
                                                                    {{-- DropDown --}}
                                                                    {{-- mm/cms/inches/feet --}}
                                                                    {{-- @dd($shipping) --}}
                                                                    <div class="form-group">
                                                                        <select name="length_unit" id="length_unit" class="form-control select2">
                                                                            <option @if(($shipping->length_unit ?? '') == 'mm') selected @endif value="mm">mm</option>
                                                                            <option @if(($shipping->length_unit ?? '') == 'cms') selected @endif  value="cms">cms</option>
                                                                            <option @if(($shipping->length_unit ?? '') == 'inches') selected @endif  value="inches">inches</option>
                                                                            <option @if(($shipping->length_unit ?? '') == 'feet') selected @endif  value="feet">feet</option>
                                                                        </select>
                                                                        {{-- <input class="form-control" name="length_unit" type="nnumber" id="length_unit" value="{{$shipping->length_unit ?? ''}}" > --}}
                                                                    </div>
                                                                </div>
            
                                                            </div>
                                                        </div>
            
                                                        {{--`PRODUCT PACKING--}}
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                    <hr class="text-primary">
                                                                    <label for="productpackingbx">
                                                                        <div class="h6">Product Packing</div>
                                                                    </label> &nbsp;&nbsp;&nbsp;
                                                                    <input type="checkbox" data-open="productpackingbox" id="productpackingbx" class="hiddenbxbtn" @if ($carton_details->standard_carton ?? '' != '' || $carton_details->carton_weight ?? '' != '' || $carton_details->carton_length ?? '' != '' || $carton_details->carton_width ?? '' != '' || $carton_details->carton_height ?? '' != '' ) checked @endif>
                                                                </div>
                                                            </div>
            
                                                            <div class="row d-none" id="productpackingbox">
                                                                <div class="col-md-6 col-12">
                                                                    <label class="">{{ __('Standard Carton Pcs')}}</label>
                                                                        <div class="form-group">
                                                                            <input class="form-control" name="standard_carton" type="text" id="standard_carton" value="{{$carton_details->standard_carton ?? ''}}" >
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-12">
                                                                        <label class="">{{ __('Carton Actual Weight')}}</label>
                                                                        <div class="form-group">
                                                                            <input class="form-control" name="carton_weight" type="number" id="carton_weight" value="{{$carton_details->carton_weight ?? ''}}" >
                                                                        </div>
                                                                    </div>
                
                                                                    <div class="col-md-6 col-12">
                                                                        <label class="">{{ __('Carton Length')}}</label>
                                                                        <div class="form-group">
                                                                            <input class="form-control" name="carton_length" type="number" id="carton_length" value="{{$carton_details->carton_length ?? ''}}" >
                                                                        </div>
                                                                    </div>
                
                                                                    <div class="col-md-6 col-12">
                                                                        <label class="">{{ __('Carton Width')}}</label>
                                                                        <div class="form-group">
                                                                            <input class="form-control" name="carton_width" type="number" id="carton_width" value="{{$carton_details->carton_width ?? ''}}" >
                                                                        </div>
                                                                    </div>
                
                                                                    <div class="col-md-6 col-12">
                                                                        <label class="">{{ __('Carton Height')}}</label>
                                                                        <div class="form-group">
                                                                            <input class="form-control" name="carton_height" type="number" id="carton_height" value="{{$carton_details->carton_height ?? ''}}" >
                                                                        </div>
                                                                    </div>
                
                                                                    <div class="col-md-6 col-12">
                                                                        <label class="">{{ __('Carton Dimension Unit')}}</label>
                                                                        <div class="form-group">
                                                                        {{-- <input class="form-control" name="Carton_Dimensions_unit" type="nnumber" id="Carton_Dimensions_unit" value="{{$carton_details->Carton_Dimensions_unit ?? ''}}" > --}}
            
                                                                        <select name="Carton_Dimensions_unit" class="select2" id="Carton_Dimensions_unit">
                                                                            <option value="mm">mm</option>
                                                                            <option value="cms">cms</option>
                                                                            <option value="inches">inches</option>
                                                                            <option value="feet">feet</option>
                                                                        </select>
            
                                                                        </div>
                                                                    </div>
                
                                                                    
                                                                    <div class="col-md-6 col-12">
                                                                        <label class="">{{ __('UOM')}}</label>
                                                                        {{-- DropDown --}}
                                                                        {{-- pcs/ sets --}}
                                                                        <div class="form-group">
                                                                            {{-- <input class="form-control" name="carton_unit" type="nnumber" id="carton_unit" value="{{$carton_details->carton_unit ?? ''}}" > --}}
                                                                            <select name="carton_unit" id="carton_unit" class="form-control select2">
                                                                                <option @if(($carton_details->carton_unit ?? '') == 'pcs') selected @endif value="pcs">pcs</option>
                                                                                <option @if(($carton_details->carton_unit ?? '') == 'sets') selected @endif value="sets">sets</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </div>
            
                                                        {{--`Shipping Details--}}
            
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                    <hr class="text-primary">
                                                                    <label for="productshippingbx">
                                                                        <div class="h6">Shipping Details</div>
                                                                    </label> &nbsp;&nbsp;&nbsp;
                                                                    <input type="checkbox" data-open="productshippingbox" id="productshippingbx" class="hiddenbxbtn" @if ($prodextra->CBM ?? ''  != '' || $prodextra->production_time ?? '' != '' || $prodextra->MBQ ?? '0' != '' || $prodextra->MBQ_unit ?? '0' != '' || $prodextra->remarks ?? '' != '' ) checked @endif>
                                                                </div>
                                                            </div>
                                                            <div class="row d-none" id="productshippingbox">
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form-group ">
                                                                        <label for="CBM" class="control-label">CBM</label>
                                                                        <input  class="form-control" name="CBM" type="text" id="CBM" value="{{$prodextra->CBM ?? '' }}" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form-group ">
                                                                        <label for="production_time" class="control-label">Production time (days)</label>
                                                                        <input  class="form-control" name="production_time" type="number" id="production_time" value="{{$prodextra->production_time ?? '' }}" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form-group ">
                                                                        <label for="MBQ" class="control-label">MBQ</label>
                                                                        <input  class="form-control" name="MBQ" type="text" id="MBQ" value="{{$prodextra->MBQ ?? '0' }}" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form-group ">
                                                                        <label for="MBQ_unit" class="control-label">MBQ_units</label>
                                                                        <input  class="form-control" name="MBQ_unit" type="number" id="MBQ_unit" value="{{$prodextra->MBQ_unit ?? '0' }}" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form-group ">
                                                                        <label for="remarks" class="control-label">Remarks</label>
                                                                        <input  class="form-control" name="remarks" type="text" id="remarks" value="{{$prodextra->remarks ?? '' }}" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
            
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                {{-- <div class="col-12">
                                                                    <div class="h4">
                                                                        Used
                                                                    </div>
                                                                </div> --}}
            
                                                                {{-- custom variations --}}
                                                                @foreach ($custom_attribute as $item)
                                                                
                                                                @php
                                                                $tmp_var = []; 
            
                                                                if (is_object($prodextra) && property_exists($prodextra, 'Cust_tag_group')){
                                                                    $myvar = App\Models\ProductExtraInfo::where('Cust_tag_group',$prodextra->Cust_tag_group)->where('attribute_id',$item->id)->groupBy('attribute_value_id')->pluck('attribute_value_id')->toArray();
                                                                    // $tmp_var = []; 
                                                                    
            
                                                                    foreach ($myvar as $key => $value) {
                                                                        array_push($tmp_var,getAttruibuteValueById($value)->attribute_value);
                                                                    }
                                                                }
            
                                                                @endphp                                           
                                                                    @if (!empty($tmp_var))
                                                                        <div class="col-md-4 col-12">
                                                                            <div class="form-group ">
                                                                                <label for="{{$item->name ?? '' }}" class="control-label">{{$item->name ?? '' }}</label>
                                                                                <input  class="form-control TAGGROUP" name="custom_attri_{{ $loop->iteration }}" type="text" id="{{$item->name ?? '' }}" value="{{ implode(",",$tmp_var) }}" >
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    
            
                                                        <div class="col-12">
                                                            <div class="row mb-3 mx-1">
                                                                <div class="col-12">
                                                                    <hr class="text-primary">
                                                                    <label for="productpropertiesbx">
                                                                        <div class="h6">Properties</div>
                                                                    </label> &nbsp;&nbsp;&nbsp;
                                                                    <input type="checkbox" data-open="productpropertiesbox" id="productpropertiesbx" class="hiddenbxbtn" @if ($attribute_value_id != null) checked @endif>
                                                                </div>
                                                                <div class="row d-none" id="productpropertiesbox">                                                                  
                                                                    @foreach ($user_custom_col_list as $key => $item)
                                                                        {{-- ` Getting Product Property Values --}}
                                                                        @php
                                                                            $system = App\Models\ProductAttribute::where('name',$item)->where('user_id',null)->first();
                                                                            $own = App\Models\ProductAttribute::where('name',$item)->where('user_id',auth()->id())->first();
                                                                            if ($system != null) {
                                                                                $records = $system;
                                                                            }else{
                                                                                $records = $own;
                                                                            }
                                                                            $records = App\Models\ProductAttributeValue::where('parent_id',$records->id)->get();
                                                                        @endphp
                                                                        
                                                                        <div class="col-md-6 col-12">
                                                                            <div class="form-group">
                                                                                <label for="properties_{{$key}}">{{ $item }}</label>
                                                                                {{-- <select name="{{$item}}[]" id="properties_{{$key}}" class="select2" multiple> --}}
                                                                                <select name="properties[]" id="properties_{{$key}}" class="select2" multiple>
                                                                                    <option value="">Select One</option>
                                                                                    @foreach ($records as $record)
                                                                                        <option value="{{ $record->id }}" @if (in_array($record->id,$attribute_value_id))
                                                                                            selected
                                                                                        @endif >{{ $record->attribute_value }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                                
                                                                            </div>
                                                                        </div>
                                        
                                                                    @endforeach                                                                
                                                                </div>
                                                            </div>                           
                                                        </div>
                                                    
                                                        
                                                        <div class="col-md-4 col-4 d-none">
                                                            <div class="form-group ">
                                                                <label for="allow_resellers" class="control-label mx-2">Allow Resellers  <span class="text-danger">*</span> </label>
            
                                                                <input  class="form-control" value="no" name="allow_resellers" type="checkbox" id="allow_resellers" 
                                                                checked required>
                                                                
                                                            </div> 
                                                        </div>
                                                        
                                                        <div class="col-md-4 col-4 d-none">
                                                            <div class="form-group">
                                                                <label for="is_publish" class="control-label mx-2">Live / Active </label>
                                                                <input class="form-control" name="is_publish" type="checkbox" id="is_publish" value="1" checked required>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-4 col-4 d-none">
                                                            <div class="form-check form-switch">
                                                                <label class="control-label mx-2">Inventory</label>            
                                                                <input type="checkbox" name="manage_inventory" class="js-keepinventory" value="1">
                                                            </div>
                                                        </div>
            
                                                        <div class="col-md-4 col-12 d-none">
                                                            <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                                                                <label for="price" class="control-label">Price</label>
                                                                <input  class="form-control" name="price" type="number" id="price" value="{{ $product->price ?? 0}}" >
                                                            </div>
                                                        </div>
            
                                                        <div class="col-md-6 col-12 d-none">
                                                            <div class="form-group {{ $errors->has('mrp') ? 'has-error' : ''}}">
                                                                <label for="mrp" class="control-label">General Price , without GST </label>
                                                                <input class="form-control" name="mrp" type="number" id="mrp" value="{{ $product->mrp ?? old('mrp') }}" >
                                                            </div>
                                                        </div>
                                                        
                                                        @if ($product->user_id != null)
                                                            <input type="hidden" name="user_id" value="{{$product->user_id}}">
                                                        @else
                                                            <div class="col-md-4 col-12">
                                                                <div class="form-group">
                                                                    <label for="user_id">User<span class="text-danger">*</span></label>
                                                                    <select name="user_id" id="user_id" class="form-control select2">
                                                                        <option value="" readonly>Select User </option>
                                                                        @foreach(UserList()  as $option)
                                                                            <option value="{{ $option->id }}" {{  old('user_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="col-md-4 col-12 d-none">
                                                             <div class="form-group">
                                                                <label for="status">Status</label>
                                                                <select name="status" id="status" class="form-control select2">
                                                                    <option value="" readonly>Select Status</option>
                                                                        @foreach(getProductStatus() as $option)
                                                                            <option value="{{  $option['id'] }}" @if ($option['id'] == $product->status) selected @endif>{{ $option['name']}}</option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>            
            
                                        </div>
                                        {{-- ` Asset Safe --}}
                                        <div class="stepper w-100 d-none" data-index="2">
                                            <div class="card mt-2">
                                                <div class="card-header">
                                                    <h3>Upload new</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12 col-12">
                                                            <div class="form-group {{ $errors->has('img') ? 'has-error' : ''}}">
                                                                <input class="form-control" name="img[]" multiple type="file" id="img" value="{{$product->img}}">
                                                            </div>
                                                        </div>
                                                    </div>  
                                                </div>
                                            </div>
                                            
                                            <div class="card ">
                                                <div class="row">
                                                    <div class="col-4">
            
                                                      <table class="table">
                                                        <thead>
                                                          <tr>
                                                            <th scope="col-1"> File Type</th>
                                                            <th scope="col-2"> # </th>
                                                            <th scope="col-3">Total Size</th>
                                                          </tr>
                                                        </thead>
                                                        <tbody>
                                                          <tr class="click1" data-table="tableimage">
                                                            <th scope="row">Images</th>
                                                            <td> {{count($medias)}}</td>
                                                            <td> {{ number_format($mediaSize_Image/(1024 * 1024),2) }} MB</td>
                                                          </tr>
                                                          <tr class="click1" data-table="tableattchment">
                                                            <th scope="row">Attachments</th>
                                                            <td> {{count($mediaAssets)}}</td>
                                                            <td> {{ number_format($mediaSize_attachment/(1024 * 1024),2) }} MB</td>
                                                          </tr>
                                                          <tr class="click1" data-table="tablegif">
                                                            <th scope="row">Gifs</th>
                                                            <td> {{count($medias_gif)}}</td>
                                                            <td> {{ number_format($mediaSize_gif/(1024 * 1024),2) }} MB</td>
                                                          </tr>
                                                          <tr class="click1" data-table="tablevideo">
                                                            <th scope="row">Videos</th>
                                                            <td> {{count($media_Video)}}</td>
                                                            <td> {{ number_format($mediaSize_video/(1024 * 1024),2) }} MB</td>
                                                          </tr>
                                                        </tbody>
                                                      </table>
            
                                                    </div>
                                              
                                              
                                                    <div class="col-8 justify-content-between">
                                                        <table class="table table-bordered d-none" id="tableimage">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col-6">Asset Name</th>
                                                                    <th scope="col-6">File Size</th>
                                                                    <th scope="col-3">Last Updated</th>
                                                                    <th scope="col-6">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($medias as $media)
                                                                    @php
                                                                        $path = str_replace("storage","public",$media->path);
                                                                        if (Storage::exists($path)) {   
                                                                            $filename = basename($path);                                                                
                                                                        }else{
                                                                            continue;
                                                                        }
            
                                                                        if ($media->file_type != "Image") {
                                                                            continue;
                                                                        }
            
                                                                    @endphp
                                                                    <tr>
                                                                        <th scope="row">
                                                                            {{-- {{ $filename }} --}}
                                                                            <span class="filename" data-oldname="{{$filename }}">
                                                                                {{$filename }}
                                                                            </span>
                                                                        </th>
                                                                        <td>
                                                                            {{ number_format(Storage::size($path)/ (1024 * 1024),2) }} MB
                                                                        </td>
                                                                        <td>
                                                                            {{ date("Y-m-d H:i:s",Storage::lastModified($path)) }}
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{ asset($media->path) }}" download="{{ $media->file_name }}" class="btn btn-link">Download</a>
            
                                                                            <a href="{{ route('panel.products.unlink.asset',[encrypt($product->id),encrypt($media->path) ]) }}?product={{ encrypt($product->id) }}" class="btn btn-link">Unlink</a>
                                                                            
                                                                            
                                                                            
                                                                            <button type="button" class="btn btn-link deletebtn" data-filepath="{{ encrypt($path) }}">Delete</button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                        
                                                        <table class="table table-bordered d-none" id="tableattchment">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col-6">Asset Name</th>
                                                                    <th scope="col-6">File Size</th>
                                                                    <th scope="col-3">Last Updated</th>
                                                                    <th scope="col-6">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
            
                                                                @forelse ($mediaAssets as $media)
                                                                    @php
                                                                        $path = str_replace("storage","public",$media->path);
                                                                        if (Storage::exists($path)) {   
                                                                            $filename = basename($path);                                                                
                                                                        }else{
                                                                            continue;
                                                                        }
                                                                                                                               
                                                                    @endphp
                                                                    <tr>
                                                                        <th scope="row">
                                                                            {{-- {{ $filename }} --}}
                                                                            <span class="filename" data-oldname="{{$filename }}">
                                                                                {{$filename }}
                                                                            </span>
                                                                        </th>
                                                                        <td>
                                                                            {{ number_format(Storage::size($path)/ (1024 * 1024),2) }} MB
                                                                        </td>
                                                                        <td>
                                                                            {{ date("Y-m-d H:i:s",Storage::lastModified($path)) }}
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{ asset($media->path) }}" download="{{ $media->file_name }}" class="btn btn-link">Download</a>
                                                                            <a href="{{ route('panel.products.unlink.asset',[encrypt($product->id),encrypt($media->path) ]) }}" class="btn btn-link">Unlink</a>
                                                                            <button type="button" class="btn btn-link deletebtn" data-filepath="{{ encrypt($path) }}">Delete</button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    
                                                                @endforelse
                                                            </tbody>
                                                        </table>
            
                                                        <table class="table table-bordered d-none" id="tablegif">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col-6">Asset Name</th>
                                                                    <th scope="col-6">File Size</th>
                                                                    <th scope="col-3">Last Updated</th>
                                                                    <th scope="col-6">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
            
                                                                @forelse ($medias_gif as $media)
                                                                    @php
                                                                        $path = str_replace("storage","public",$media->path);
                                                                        if (Storage::exists($path)) {   
                                                                            $filename = basename($path);                                                                
                                                                        }else{
                                                                            continue;
                                                                        }
                                                                        
                                                                        if (explode("/",\Storage::mimeType($path))[1] != 'gif') {
                                                                            continue;
                                                                        }
                                                                                                                               
                                                                    @endphp
                                                                    <tr>
                                                                        <th scope="row">
                                                                            {{-- {{ $filename }} --}}
                                                                            <span class="filename" data-oldname="{{$filename }}">
                                                                                {{$filename }}
                                                                            </span>
                                                                        </th>
                                                                        <td>
                                                                            {{ number_format(Storage::size($path)/ (1024 * 1024),2) }} MB
                                                                        </td>
                                                                        <td>
                                                                            {{ date("Y-m-d H:i:s",Storage::lastModified($path)) }}
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{ asset($media->path) }}" download="{{ $media->file_name }}" class="btn btn-link">Download</a>
                                                                            <a href="{{ route('panel.products.unlink.asset',[encrypt($product->id),encrypt($media->path) ]) }}" class="btn btn-link">Unlink</a>
                                                                            <button type="button" class="btn btn-link deletebtn" data-filepath="{{ encrypt($path) }}">Delete</button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    
                                                                @endforelse
                                                            </tbody>
                                                        </table>
            
                                                        <table class="table table-bordered d-none" id="tablevideo">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col-6">Asset Name</th>
                                                                    <th scope="col-6">File Size</th>
                                                                    <th scope="col-3">Last Updated</th>
                                                                    <th scope="col-6">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
            
                                                                @forelse ($media_Video as $media)
                                                                    @php
                                                                        $path = str_replace("storage","public",$media->path);
                                                                        if (Storage::exists($path)) {   
                                                                            $filename = basename($path);                                                                
                                                                        }else{
                                                                            continue;
                                                                        }
                                            
                                                                        if (explode("/",\Storage::mimeType($path))[0] != 'video') {
                                                                            continue;
                                                                        }
            
                                                                    @endphp
                                                                    <tr>
                                                                        <th scope="row">
                                                                            {{-- {{ $filename }} --}}
                                                                            <span class="filename" data-oldname="{{$filename }}">
                                                                                {{$filename }}
                                                                            </span>
                                                                        </th>
                                                                        <td>
                                                                            {{ number_format(Storage::size($path)/ (1024 * 1024),2) }} MB
                                                                        </td>
                                                                        <td>
                                                                            {{ date("Y-m-d H:i:s",Storage::lastModified($path)) }}
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{ asset($media->path) }}" download="{{ $media->file_name }}" class="btn btn-link">Download</a>
                                                                            <a href="{{ route('panel.products.unlink.asset',[encrypt($product->id),encrypt($media->path) ]) }}" class="btn btn-link">Unlink</a>
                                                                            <button type="button" class="btn btn-link deletebtn" data-filepath="{{ encrypt($path) }}">Delete</button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @empty
                                                                    
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
            
                                                </div>
                                                                
                                                                                                    
                                            </div>
                                            
                                        </div> 
                                        
                                        <div class="stepper d-none" data-index="3">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3>Basic Product Info</h3>
                                                </div>
                                                <div class="row">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 col-12">
                                                                <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                                                    <label for="description" class="control-label">Product Description</label>
                                                                    <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{ $product->description }}</textarea>
                                                                </div>
                                                            </div>
            
                                                            <div class="col-md-4 col-4">
                                                                <div class="form-group ">
                                                                    <label for="search_keywords" class="control-label">Search keywords</label>
                                                                    <input  class="form-control TAGGROUP" name="search_keywords" type="text" id="search_keywords" value="{{$product->search_keywords ?? ''}}" >
                                                                </div>
                                                            </div>
                                                            
                                                            
            
                                                            <div class="col-md-4 col-4">
                                                                <div class="form-group ">
                                                                    <label for="brand_name" class="control-label">Brand Name</label>
                                                                    <input  class="form-control" name="brand_name" type="text" id="brand_name" value="{{$prodextra->brand_name ?? ''}}" >
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-4 col-4 d-none">
                                                                <div class="form-group">
                                                                    <label for="video_url">Video Url </label>
                                                                    <input type="url" name="video_url" class="form-control" value="{{ $product->video_url }}" id="video_url">
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                            <div class="col-md-4 col-4 d-none">
                                                                <div class="form-group {{ $errors->has('artwork_url') ? 'has-error' : ''}}">
                                                                    <label for="artwork_url" class="control-label">Art Work Reference</label>
                                                                    <input class="form-control" name="artwork_url" type="url" id="artwork_url" value="{{ $product->artwork_url }}" placeholder="Enter Artwork URL" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>                                           
                                                </div>
                                            </div>
                                            {{-- plotting basic header fields end --}}
                                            <div class="card d-none">
                                                <div class="card-header">
                                                    <h3>Content</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group {{ $errors->has('features') ? 'has-error' : ''}}">
                                                                <div class="alert alert-info">
                                                                    Add Product Features With New Line Each
                                                                </div>
                                                                <label for="features" class="control-label">Features</label>
                                                                <textarea name="features" class="form-control" id="features cols="30" rows="5">{{ $product->features }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <div class="form-group {{ $errors->has('meta_description') ? 'has-error' : ''}}">
                                                                <label for="meta_description" class="control-label">Meta Description</label>
                                                                <textarea name="meta_description" class="form-control" id="meta_description" cols="30" rows="3">{{ $product->meta_description ?? old('meta_description') }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-6">
                                                            <div class="form-group {{ $errors->has('meta_keywords') ? 'has-error' : ''}}">
                                                                <label for="meta_keywords" class="control-label">Meta Keywords</label>
                                                                <textarea name="meta_keywords" class="form-control" id="meta_keywords" cols="30" rows="3">{{ $product->meta_keywords ?? old('meta_keywords') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                
                                        </div> 
                                            
                                        <div class="stepper d-none" data-index="4">
                                            <div class="card ">
                                                <div class="col-12 d-none">
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                    <hr class="text-primary">
                                                                    <label for="productexclusivebx">
                                                                        <div class="h6">Exclusive  </div>
                                                                    </label>
                                                                    <br>
                                                                    <input type="checkbox" data-open="productexclusivebox" id="productexclusivebx" class="hiddenbxbtn">
                                                                </div>
                                                            </div>
                                                            <div class="row d-none" id="productexclusivebox">
                                                                <div class="col-md-6 col-12">
                                                                    <div class="form-check pl-0">
                                                                        <label for="exclubtn" class="mr-3">
                                                                            Copyright/ Exclusive item  
                                                                            <span class="text-danger">*</span>
                                                                        </label>                                      
                                                                        <input type="checkbox" class="custom-control-input" id="exclubtn" data-open="productexclusivebuyernamebox" value="1" name="exclusive" @if($product->exclusive == 1) checked @endif required>
                                                                    </div>
                                                                </div>
                                                                
                                                                    <div class="col-md-6 col-12 @if($product->exclusive != 1) d-none @endif" id="productexclusivebuyernamebox">
                                                                        <div class="form-group">
                                                                            <label for="exclusive_buyer_name">Exclusive Buyer Name</label>
                                                                            <input  class="form-control" name="exclusive_buyer_name" type ="col-md-6 col-12"text" id="exclusive_buyer_name" value="{{$prodextra->exclusive_buyer_name ?? '' }}" >                                                       
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                        </div>
                                                
                                                
                                                {{-- ` PRODUCT SAMPLE DETAILS GROUP --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <hr class="text-primary">
                                                            <label for="productsamplebx">
                                                                <div class="h6">Sample Details</div>
                                                            </label>
                                                            <br>
                                                            <input type="checkbox" data-open="productsamplebox" id="productsamplebx" class="hiddenbxbtn" @if ($prodextra->sample_available ?? '' != '' || $prodextra->sampling_time ?? ''!= '')checked  @endif >
                                                        </div>
                                                    </div>
            
                                                    <div class="row d-none" id="productsamplebox">
                                                        <div class="col-md-4 col-4">
                                                            <div class="form-group ">
                                                                <label for="sample_available" class="control-label">Sample / Stock available</label>
                                                                    <input  class="form-control" name="sample_available" type="text" id="sample_available" value="{{$prodextra->sample_available ?? ''}}" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-4">
                                                            <div class="form-group ">
                                                                <label for="sample_year" class="control-label">Sample Year</label>
                                                                {{-- <input  class="form-control" name="sample_year" type="text" id="sample_year" value="{{$prodextra->sample_year ?? ''}}" > --}}
                                                                    <select name="sample_year" id="sample_year" class="form-control select2">
                                                                        <option value="">Select Year</option>
                                                                        {{-- <option value="{{ $option->id }}" @if ($option->id == $prodextra->season_year) selected
                                                                            @endif>{{  $option->name ?? ''}}</option> --}}
                                                                        @php
                                                                            $selectedYear = $prodextra->sample_year ?? '';
                                                                        @endphp
                                                                        @for ($i = date('Y'); $i >= 1985; $i--)
                                                                            <option value="{{ $i }}" @if ($selectedYear == $i) selected @endif>{{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-4">
                                                            <div class="form-group ">
                                                                <label for="sample_month" class="control-label">Sample Month</label>
                                                                {{-- <input  class="form-control" name="sample_month" type="text" id="sample_month" value="{{$prodextra->sample_month ?? ''}}" > --}}
            
                                                                <select name="sample_month" id="sample_month" class="select2">
                                                                    
                                                                    <option value="">Select Sample Month</option>
                                                                        @php
                                                                            $selectedMonth = $prodextra->sample_month ?? '';
                                                                        @endphp
                                                                        @foreach ([
                                                                            'January' => 'January',
                                                                            'February' => 'February',
                                                                            'March' => 'March',
                                                                            'April' => 'April',
                                                                            'May' => 'May',
                                                                            'June' => 'June',
                                                                            'July' => 'July',
                                                                            'August' => 'August',
                                                                            'September' => 'September',
                                                                            'October' => 'October',
                                                                            'November' => 'November',
                                                                            'December' => 'December',
                                                                        ] as $monthValue => $monthName)
                                                                            <option value="{{ $monthValue }}" @if ($selectedMonth == $monthValue) selected @endif>{{ $monthName }}</option>
                                                                        @endforeach
                                                                </select>
            
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-4">
                                                            <div class="form-group ">
                                                                <label for="sampling_time" class="control-label">Sampling time</label>
                                                                <input  class="form-control" name="sampling_time" type="text" id="sampling_time" value="{{$prodextra->sampling_time ?? ''}}" >
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
            
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <hr class="text-primary">
                                                            <label for="productsourcedbx">
                                                                <div class="h6">Sourced from Outside</div>
                                                            </label>
                                                            <br>
                                                            <input type="checkbox" data-open="productsourcedbox" id="productsourcedbx" class="hiddenbxbtn" @if ($prodextra->vendor_sourced_from ?? '' != '' || $prodextra->vendor_price ?? '' != ''  || $prodextra->vendor_currency ?? ''!= '' || $prodextra->product_cost_unit ?? '' != '' ) checked  @endif>
                                                        </div>
                                                    </div>
                                                    <div class="row d-none" id="productsourcedbox">                                                   
                                                        <div class="col-md-4 col-4">
                                                            <div class="form-group ">
                                                                <label for="vendor_sourced_from" class="control-label">Vendor Sourced from</label>
                                                                <input  class="form-control" name="vendor_sourced_from" type="text" id="vendor_sourced_from" value="{{$prodextra->vendor_sourced_from ?? '' }}" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-4">
                                                            <div class="form-group ">
                                                                <label for="vendor_price" class="control-label">Vendor Price</label>
                                                                <input  class="form-control" name="vendor_price" type="text" id="vendor_price" value="{{$prodextra->vendor_price ?? '' }}" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-4">
                                                            <div class="form-group ">
                                                                <label for="product_cost_unit" class="control-label">Product Cost Unit</label>
                                                                <input  class="form-control" name="product_cost_unit" type="text" id="product_cost_unit" value="{{$prodextra->product_cost_unit ?? '' }}" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-4">
                                                            <div class="form-group ">
                                                                <label for="vendor_currency" class="control-label">Vendor Currency</label>
                                                                <input  class="form-control" name="vendor_currency" type="text" id="vendor_currency" value="{{$prodextra->vendor_currency ?? '' }}" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 col-4">
                                                            <div class="form-group ">
                                                                <label for="sourcing_year" class="control-label">Sourcing Year</label>
                                                                {{-- <input  class="form-control" name="sourcing_year" type="number" id="sourcing_year" value="{{$prodextra->sourcing_year ?? '' }}" > --}}
                                                                <select name="sourcing_year" id="sourcing_year" class="form-control select2">
                                                                    <option value="">Select Year</option>
                                                                    {{-- <option value="{{ $option->id }}" @if ($option->id == $prodextra->season_year) selected
                                                                        @endif>{{  $option->name ?? ''}}</option> --}}
                                                                    @php
                                                                        $selectedYear = $prodextra->sourcing_year ?? '';
                                                                    @endphp
                                                                    @for ($i = date('Y'); $i >= 1985; $i--)
                                                                        <option value="{{ $i }}" @if ($selectedYear == $i) selected @endif>{{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>                                                   
                                                        <div class="col-md-4 col-4">
                                                            <div class="form-group ">
                                                                <label for="sourcing_month" class="control-label">Sourcing Month</label>
                                                                {{-- <input  class="form-control" name="sourcing_month" type="text" id="sourcing_month" value="{{$prodextra->sourcing_month ?? '' }}" > --}}
            
                                                                <select name="sourcing_month" id="sourcing_month" class="select2">
                                                                    <option >Select Sourcing Month</option>
                                                                    @php
                                                                            $selectedMonth = $prodextra->sourcing_month ?? '';
                                                                        @endphp
                                                                        @foreach ([
                                                                            'January' => 'January',
                                                                            'February' => 'February',
                                                                            'March' => 'March',
                                                                            'April' => 'April',
                                                                            'May' => 'May',
                                                                            'June' => 'June',
                                                                            'July' => 'July',
                                                                            'August' => 'August',
                                                                            'September' => 'September',
                                                                            'October' => 'October',
                                                                            'November' => 'November',
                                                                            'December' => 'December',
                                                                        ] as $monthValue => $monthName)
                                                                            <option value="{{ $monthValue }}" @if ($selectedMonth == $monthValue) selected @endif>{{ $monthName }}</option>
                                                                        @endforeach      
                                                                    {{-- <option value="January" @if (($prodextra->sourcing_month ?? '') == 'January' ) checked @endif>January</option>
                                                                    <option value="February"  @if (($prodextra->sourcing_month ?? '') == 'February' ) checked @endif>February</option>
                                                                    <option value="March" @if (($prodextra->sourcing_month ?? '') == 'March' ) checked @endif>March</option>
                                                                    <option value="April" @if (($prodextra->sourcing_month ?? '') == 'April' ) checked @endif>April</option>
                                                                    <option value="May" @if (($prodextra->sourcing_month ?? '') == 'May' ) checked @endif>May</option>
                                                                    <option value="June" @if (($prodextra->sourcing_month ?? '') == 'June' ) checked @endif>June</option>
                                                                    <option value="July" @if (($prodextra->sourcing_month ?? '') == 'July' ) checked @endif>July</option>
                                                                    <option value="August" @if (($prodextra->sourcing_month ?? '') == 'August' ) checked @endif>August</option>
                                                                    <option value="September" @if (($prodextra->sourcing_month ?? '') == 'September' ) checked @endif>September</option>
                                                                    <option value="October" @if (($prodextra->sourcing_month ?? '') == 'October' ) checked @endif>October</option>
                                                                    <option value="November" @if (($prodextra->sourcing_month ?? '') == 'November' ) checked @endif>November</option>
                                                                    <option value="December" @if (($prodextra->sourcing_month ?? '') == 'December' ) checked @endif>December</option> --}}
                                                                </select>
            
            
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>  
                                                 {{--`Theme Collection from essentials  --}}
                                                 <div class="card">
                                                    <div class="card-header">
                                                        <h3>Theme Collection</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">  
                                                                <div class="col-md-4 col-4"required >
                                                                    <div class="form-group ">
                                                                        <label for="collection_name" class="control-label">Theme / Collection Name</label >
                                                                        <input  class="form-control" name="collection_name" type="text" id="collection_name" value="{{$prodextra->collection_name ?? '' }}" >
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-4">
                                                                    <div class="form-group">
                                                                        <label for="season_month" class="control-label">Season / Month</label >
                                                                        {{-- <input  class="form-control" name="season_month" type="text" id="season_month" value="{{$prodextra->season_month ?? '' }}" > --}}
                                                                        <select name="season_month" id="season_month" class="select2">
                                                                            <option value="">Select Sourcing Month</option>
                                                                            @php
                                                                                $selectedMonth = $prodextra->season_month ?? '';
                                                                            @endphp
                                                                            @foreach ([
                                                                                'January' => 'January',
                                                                                'February' => 'February',
                                                                                'March' => 'March',
                                                                                'April' => 'April',
                                                                                'May' => 'May',
                                                                                'June' => 'June',
                                                                                'July' => 'July',
                                                                                'August' => 'August',
                                                                                'September' => 'September',
                                                                                'October' => 'October',
                                                                                'November' => 'November',
                                                                                'December' => 'December',
                                                                            ] as $monthValue => $monthName)
                                                                                <option value="{{ $monthValue }}" @if ($selectedMonth == $monthValue) selected @endif>{{ $monthName }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-4">
                                                                    <div class="form-group ">
                                                                        <label for="season_year">Theme / Collection Year</label label >
                                                                        {{-- <input class="form-control" name="season_year" type="number" id="season_year" value= "{{ $prodextra->season_year ?? '0' }}"  required> --}}
                                                                        {{-- <select id="season_year"></select> --}}
                                                                        <select name="season_year" id="season_year" class="form-control select2">
                                                                            <option value="">Select Year</option>
                                                                            {{-- <option value="{{ $option->id }}" @if ($option->id == $prodextra->season_year) selected
                                                                                @endif>{{  $option->name ?? ''}}</option> --}}
                                                                            @php
                                                                                $selectedYear = $prodextra->season_year ?? '';
                                                                            @endphp
                                                                            @for ($i = date('Y'); $i >= 1985; $i--)
                                                                                <option value="{{ $i }}" @if ($selectedYear == $i) selected @endif>{{ $i }}</option>
                                                                            @endfor
                                                                        </select>
                                                                               
                                                                        
                                                                        
                
                                                                    </div>
                                                                </div>                                          
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                           
                                        @if ($product->user_id != null)
                                            <input type="hidden" name="user_id" value="{{$product->user_id}}">
                                        @else
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="user_id">User</label>
                                                    <select name="user_id" id="user_id" class="form-control select2 </div>
                                                        <option value="" readonly>Select User </option>
                                                        @foreach(UserList()  as $option)
                                                            <option value="{{ $option->id }}" {{  old('user_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-4 col-12 d-none">
                                                <div class="form-group">
                                                <label for="status">Status</label>
                                                <select name="status" id="status" class="form-control select2" required >
                                                    <option value="" readonly>Select Status</option>
                                                        @foreach(getProductStatus() as $option)
                                                            <option value="{{  $option['id'] }}" @if ($option['id'] == $product->status) selected @endif>{{ $option['name']}}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        
                                        {{-- <div class="stepper d-none" data-index="7">
                                            <div class="card ">
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col-md-10 col-12">
                                        
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col">Varients</th>
                                                                    <th scope="col">Edit</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>    
                                                                   @foreach ($product_variant_combo as $product_variant)
                                                                        <tr>
                                                                            <td> {{ $loop->iteration }} </td>
                                                                            <td>
                                                                                @foreach ($product_variant as $key => $item)
                                                                                    {{ getAttruibuteValueById($item)->attribute_value }}
                                                                                    @if ($key < count($product_variant) - 1)
                                                                                        , 
                                                                                    @endif
                                                                                @endforeach
                                                                            </td>
                                                                            <td>
                                                                                @php
                                                                                   $proid =  App\Models\ProductExtraInfo::whereIn('attribute_value_id',$product_variant)->wherein('product_id',$available_products)->where('user_id',$product->user_id)->where('group_id',$product->sku)->first();
                                                                                   @endphp
                                                                                @if ($proid != null)
                                                                                    <a href="{{ route('panel.products.delete.sku',encrypt($proid->product_id)) }}" class="btn btn-outline-danger delete-btn">
                                                                                        Delete
                                                                                    </a>
            
                                                                                    <a href="{{ route('panel.products.edit',$proid->product_id) }}" class="btn btn-outline-primary">
                                                                                        Edit
                                                                                    </a>
                                                                                @endif
                                                                            </td>
                                                                        </tr>
            
                                                                        @php
                                                                            if ($proid != null) {
                                                                                $available_products = array_diff($available_products, [$proid->product_id]);
                                                                            }
                                                                        @endphp
                                                                   @endforeach                                                      
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>                                                                                                                                                                       
                                                </div>
                                        </div> --}}
                                            
                                        <div class="alert alert-info d-none">
                                            <p class="mb-0">Changing any field will result in unpublishing SKUs from all linked sellers.</p>
                                        </div>
            
                                    </div>
                                </div>
                            </div>


                           

                        </form>
                        <div class="row mt-4 d-none">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <h3> #PMID{{ getPrefixZeros($product->id) }} | {{ $product->color }} - {{ $product->size }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="product_type">Product Type</label>
                                            <select name="product_type" id="product_type" class="form-control select2">
                                                <option value="" readonly>Select Type</option>
                                                    @foreach(getProductType() as $option)
                                                        <option @if ($option['id'] == $product->product_type) selected @endif value="{{  $option['id'] }}">{{ $option['name']}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        @if($product->brand_id != 0 || $product->brand_id != null)
                                            <form action="{{ route('panel.products.update-sku',$product->id) }}" method="post">
                                                @csrf
                                                <input type="hidden" name="old_sku" value="{{$product->sku}}">
                                                <div class="alert alert-warning">
                                                Please make sure your SKU is correct and validated.
                                                </div>
                                                <div class="form-group">
                                                    <label for="sku">SKU</label>
                                                    <input class="form-control" name="sku" type="text" id="sku" value="{{$product->sku}}" placeholder="Enter SKU" >
                                                </div>

                                                <div class="form-group">
                                                <button type="submit" class="btn btn-block btn-outline-danger">Update SKU</button>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                           <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <h3>Variations</h3>
                                        <div>
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#editVarientModal" class="btn btn-sm btn-info">Add Variant</a>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="ignore_table" class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Color</th>
                                                        <th>Stock</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($variations as $variation)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td> <a class="text-link @if($product->id == $variation->id) text-danger @endif" href="{{ route('panel.products.edit', $variation->id) }}">
                                                                {{ $variation->color }} - {{ $variation->size }}
                                                            </a>
                                                            </td>
                                                            @if($variation->manage_inventory == 1)
                                                                <td>{{ $variation->stock ?? 0 }}</td>
                                                            @else
                                                                <td>-</td>
                                                            @endif
                                                            <td><strong class="text-{{ getProductStatus($variation->status)['color'] }}">{{ getProductStatus($variation->status)['name'] }}</strong></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        {{-- <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-12">

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Varients</th>
                            <th scope="col">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        

                            @foreach ($productVarients as $item)
                            @php
                                $ashudata = App\Models\ProductExtraInfo::where('group_id',$product->sku)->where('attribute_id',$item)->groupBy('attribute_value_id')->get();
                            @endphp

                            @foreach ($ashudata as $item1)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ getAttruibuteValueById($item1->attribute_value_id)->attribute_value }} ( {{ getAttruibuteById($item)->name }} ) </td>
                                    <td>
                                        <a href="{{ route('panel.products.delete.sku',[encrypt($item1->product_id),encrypt($item1->attribute_value_id)]) }}" class="btn btn-outline-danger">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            
                            
                            
                            @endforeach
                            
                    </tbody>
                </table>
            </div>
        </div> --}}



        <form action="{{ route('panel.filemanager.delete') }}" id="deletefileform">
            <input type="hidden" name="user_id" id="user_id" value="{{ encrypt(auth()->id()) }}">
            <input type="hidden" name="files" id="filesId" value="{{ encrypt(auth()->id()) }}">
        </form>

    </div>
     @include('panel.products.include.varient',['product_id'=>$product->id])
    <!-- push external js -->
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
        <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
        <script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
        <script src="{{ asset('backend/js/jquery.editable.js') }}"></script>
        <script>
            $(document).ready(function () {

        
              $(".click1").click(function () {

                  $.each($(".click1"), function (indexInArray, valueOfElement) {
                    let alldata = valueOfElement.dataset.table;
                    $("#"+alldata).addClass('d-none');
                    $(this).removeClass('bg-primary text-light');
                  });

                  $(this).addClass('bg-primary text-light')

                  $("#" + $(this).data('table')).toggleClass("d-none");

              });

                // {{--` Renaming File --}}
                $(".filename").click(function (element) {
                    let oldname = $(this).data('oldname');

                    $(this).editable("dblclick", function (e) {
                       if (e.value != '') {
                        $.ajax({
                            type: "post",
                            url: "{{ route('panel.filemanager.rename') }}",
                            data: {
                                'oldName': oldname,
                                'newName': e.value,
                            },
                            dataType: "json",
                            success: function (response) {
                                // console.log(response);
                            }
                        });
                       }
                    });
                });


              // {{--` Delete Item --}}
              $(".deletebtn").click(function (e) { 
                    e.preventDefault();
                    let selected = $(this).data('filepath');
                    
                    var msg = `
                    <span class="text-danger">You are about to delete 1 asset(s)</span> <br/>
                    <span>This action cannot be undone. To confirm type <b>DELETE</b></span>
                    <input type='text' id='margin' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='DELETE'>`;

                    $.confirm({
                        draggable: true,
                        title: `Delete 1 asset(s)`,
                        content: msg,
                        type: 'blue',
                        typeAnimated: true,
                        buttons: {
                            tryAgain: {
                                text: 'DELETE',
                                btnClass: 'btn-danger',
                                action: function(){
                                    let margin = $('#margin').val();
                                    if (margin == 'DELETE') {

                                        $("#filesId").val(selected);
                                        $("#action").val('deleteFile');
                                        $("#deletefileform").submit();
                                        
                                    } else {
                                        $.alert('Type DELETE to Proceed');
                                    }

                                    
                                }
                            },
                            close: function () {

                            }
                        }
                    });
                });

        



            });
          </script>
        <script>


            $('.TAGGROUP').tagsinput('items');
            $(document).ready(function () {
                
                // $(".changegroup").change(function (e) { 
                //     e.preventDefault();
                //     let key = $(this).val();
                //     let url = "http://{{ ENV('APP_URL') }}/panel/products/edit/"+key;
                //     window.location.href = url;
                // });
            });      

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


            // Single swithces
            var acr_btn = document.querySelector('.js-keepinventory');
            var switchery = new Switchery(acr_btn, {
                color: '#6666CC',
                jackColor: '#fff'
            });

            var acr_btn = document.querySelector('#is_publish');
            var switchery = new Switchery(acr_btn, {
                color: '#6666CC',
                jackColor: '#fff'
            });

            var acr_btn = document.querySelector('#allow_resellers');
            var switchery = new Switchery(acr_btn, {
                color: '#6666CC',
                jackColor: '#fff'
            });

            var hiddenbxbtn = document.querySelector('#productexclusivebx');
            var switchery = new Switchery(hiddenbxbtn, {
                color: '#6666CC',
                jackColor: '#fff'
            });

            var hiddenbxbtn = document.querySelector('#weightbox');
            var switchery = new Switchery(hiddenbxbtn, {
                color: '#6666CC',
                jackColor: '#fff'
            });

            var productdimensionsbx = document.querySelector('#productdimensionsbx');
            var switchery = new Switchery(productdimensionsbx, {
                color: '#6666CC',
                jackColor: '#fff'
            });

            var productdimensionsbx = document.querySelector('#productpackingbx');
            var switchery = new Switchery(productdimensionsbx, {
                color: '#6666CC',
                jackColor: '#fff'
            });

            var productdimensionsbx = document.querySelector('#productshippingbx');
            var switchery = new Switchery(productdimensionsbx, {
                color: '#6666CC',
                jackColor: '#fff'
            });

            var productdimensionsbx = document.querySelector('#productpropertiesbx');
            var switchery = new Switchery(productdimensionsbx, {
                color: '#6666CC',
                jackColor: '#fff'
            });


            var productdimensionsbx = document.querySelector('#productsamplebx');
            var switchery = new Switchery(productdimensionsbx, {
                color: '#6666CC',
                jackColor: '#fff'
            });

            var productdimensionsbx = document.querySelector('#productsourcedbx');
            var switchery = new Switchery(productdimensionsbx, {
                color: '#6666CC',
                jackColor: '#fff'
            });


            var productdimensionsbx = document.querySelector('#exclubtn');
            var switchery = new Switchery(productdimensionsbx, {
                color: '#6666CC',
                jackColor: '#fff'
            });

            var productdimensionsbx = document.querySelector('#weightboxbtn');
            var switchery = new Switchery(productdimensionsbx, {
                color: '#6666CC',
                jackColor: '#fff'
            });

            var productdimensionsbx = document.querySelector('#productexclusivebox');
            var switchery = new Switchery(productdimensionsbx, {
                color: '#6666CC',
                jackColor: '#fff'
            });


            


            $(".hiddenbxbtn").change(function (e) { 
                e.preventDefault();
                let hiddenbx = $(this).data('open');
                $("#"+hiddenbx).toggleClass('d-none');
            });

            $.each($(".hiddenbxbtn"), function (indexInArray, valueOfElement) { 
                
                 if (valueOfElement.checked == true) {
                    let hiddenbx = $(this).data('open');
                    $("#"+hiddenbx).toggleClass('d-none');
                 }
            });



            $(document).on('click','.update-sku',function(e){
                e.preventDefault();
                var url = $(this).attr('href');
                var msg = $(this).data('msg') ?? "You won't be able to revert back!";
                $.confirm({
                    draggable: true,
                    title: 'Are You Sure Update SKU!',
                    content: msg,
                    type: 'info',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Update',
                            btnClass: 'btn-info',
                            action: function(){
                                    window.location.href = url;
                            }
                        },
                        close: function () {
                        }
                    }
                });
            });
        $(document).ready(function(){
            function convertToSlug(Text)
				{
					return Text
						.toLowerCase()
						.replace(/ /g,'-')
						.replace(/[^\w-]+/g,'')
						;
				}

			$('#title').on('keyup', function (){
                $('#slug').val(convertToSlug($('#title').val()));
			});

            // $("#title").keypress(function(){
            //     var title = $('#title').val()
            //     $('#slug').val('/'+title)
            // });
            $(".remove-img").on('click',function(){
                $('#img').val('')
                $('#img-preview').hide( )
            });
        });


        $(document).ready(function() {
            var steps = $('.stepper').length;
            var activeIndex = 1;

            $('.stepper-actions').on('click', '.next_btn', function (e) {
                if(activeIndex < steps){
                    $('[data-index='+activeIndex+']').addClass('d-none');
                    $('.custom_active_add-'+activeIndex).addClass('active');
                    activeIndex++;
                    $('[data-index='+activeIndex+']').removeClass('d-none');
                    $('.stepper-actions').find('.previous_btn').removeClass('d-none');
                }
                if(activeIndex == steps){
                    $(this).hide();
                }
            });


            
            $(".md-step").click(function (e) { 
                e.preventDefault();

                let stepindex = $(this).data('step');
                let newwindow = $(`[data-index="${stepindex+1}"]`);
                activeIndex = stepindex+1;

                
                $.each($('.md-step'), function (i, v) {
                     $(this).removeClass('active');
                });
                

                
                $(this).addClass('active');
                $(".stepper").addClass('d-none');
                $('.stepper-actions').find('.previous_btn').addClass('d-none');
                
                if (activeIndex != 1) {
                    $('.stepper-actions').find('.previous_btn').removeClass('d-none');
                }
                
                if(activeIndex == steps){
                    $(".next_btn").addClass('d-none');
                }
                
                $(".next_btn").removeClass('d-none');
                newwindow.removeClass('d-none')            
            });

            $('.stepper-actions').on('click', '.previous_btn', function (e) {
                if(activeIndex > 1){
                    $('[data-index='+activeIndex+']').addClass('d-none');
                    $('.update_btn').addClass('d-none');
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
        </script>
        
    @endpush
@endsection