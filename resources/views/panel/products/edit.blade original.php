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
        </style>
    @endpush

    <div class="container-fluid">
        <div class="page-header">
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
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <!-- start message area-->
                        @include('backend.include.message')
                        <!-- end message area-->
                        <form action="{{ route('panel.products.update', $product->id) }}" method="post" enctype="multipart/form-data" id="ProductForm">
                            @csrf
                            <input type="hidden" name="brand_id" value="{{$product->brand_id}}">
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
                                <div class="card ">
                                    <div class="card-header">
                                        <h3>Create Product</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                                                    <label for="title" class="control-label">Title<span class="text-danger">*</span> </label>
                                                    <input required  class="form-control" name="title" type="text" id="title" value="{{$product->title}}" >
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-check form-switch">
                                                    <label class="control-label">Keep Inventory</label>
                                                    <br>
                                                    <input type="checkbox" name="manage_inventory" 
                                                        @if (getinventoryByproductId($product->id) != null)
                                                            @if (getinventoryByproductId($product->id)->status == 1) checked @endif
                                                        @endif
                                                    class="js-keepinventory" value="1">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 d-none">
                                                <div class="form-group {{ $errors->has('slug') ? 'has-error' : ''}}">
                                                    <label for="slug" class="control-label">Slug<span class="text-danger">*</span> </label>
                                                    <input required  class="form-control" name="slug" type="text" id="slug" value="{{$product->slug}}" >
                                                </div>
                                            </div>
                                             <div class="col-md-6 col-12">
                                                <div class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
                                                    <label for="category_id">Category<span class="text-danger">*</span></label>
                                                    <select required name="category_id" id="category_id" class="form-control select2">
                                                        <option value="" readonly>Select Category </option>
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
                                                    <select required name="sub_category" id="sub_category" class="form-control select2">
                                                        <option value="" readonly>Select Sub Category </option>
                                                        @if($product->sub_category)
                                                            <option value="{{ $product->sub_category }}" selected>{{ fetchFirst('App\Models\Category',$product->sub_category,'name') }}</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12 d-none">
                                                <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                                                    <label for="price" class="control-label">Price<span class="text-danger">*</span> </label>
                                                    <input required  class="form-control" name="price" type="number" id="price" value="{{ $product->price ?? 0}}" >
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group {{ $errors->has('mrp') ? 'has-error' : ''}}">
                                                    <label for="mrp" class="control-label">General Price , without GST </label>
                                                    <input class="form-control" name="mrp" type="text" id="mrp" value="{{ $product->mrp ?? old('mrp') }}" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Model Number</label>
                                                    <input type="text" class="form-control" name="model_code"
                                                     value="{{ $product->model_code ?? old('model_code') }}">
                                                </div>
                                            </div>
                                            @if ($product->user_id != null)
                                                <input type="hidden" name="user_id" value="{{$product->user_id}}">
                                            @else
                                                <div class="col-md-4 col-12">
                                                    <div class="form-group">
                                                        <label for="user_id">User<span class="text-danger">*</span></label>
                                                        <select required name="user_id" id="user_id" class="form-control select2">
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
                                                    <select required name="status" id="status" class="form-control select2">
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
                            <div class="stepper d-none" data-index="2">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Dimensions</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <img style="height: 230px;" src="{{ asset('frontend/assets/img/product/item.jpg') }}" class="img-fluid" alt="">
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
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
                                                            <select name="length_unit" id="length_unit" class="form-control">
                                                                <option @if($shipping->length_unit == 'mm') selected @endif value="mm">mm</option>
                                                                <option @if($shipping->length_unit == 'cms') selected @endif  value="cms">cms</option>
                                                                <option @if($shipping->length_unit == 'inches') selected @endif  value="inches">inches</option>
                                                                <option @if($shipping->length_unit == 'feet') selected @endif  value="feet">feet</option>
                                                            </select>
                                                            {{-- <input class="form-control" name="length_unit" type="nnumber" id="length_unit" value="{{$shipping->length_unit ?? ''}}" > --}}
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <hr class="text-primary">
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <label class="">{{ __('Weight')}}</label>
                                                       <div class="form-group">
                                                           <input class="form-control" name="weight" type="nnumber" id="weight" value="{{$shipping->weight ?? ''}}" >
                                                       </div>
                                                   </div>

                                                    <div class="col-md-6 col-12">
                                                        <label class="">{{ __('Weight UOM')}}</label>
                                                        {{-- Drop Down --}}
                                                        {{-- gms/kgs --}}
                                                        <div class="form-group">
                                                            <select name="unit" id="unit" class="form-control">
                                                                <option @if($shipping->unit == 'gms') selected @endif value="gms">gms</option>
                                                                <option @if($shipping->unit ==  'kgs') selected @endif value="kgs">kgs</option>
                                                            </select>
                                                            {{-- <input class="form-control" name="unit" type="nnumber" id="unit" value="{{$shipping->unit ?? ''}}" > --}}
                                                        </div>
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
                                                            <input class="form-control" name="standard_carton" type="text" id="standard_carton" value="{{$carton_details->standard_carton ?? ''}}" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <label class="">{{ __('Carton Actual Weight')}}</label>
                                                        <div class="form-group">
                                                            <input class="form-control" name="carton_weight" type="nnumber" id="carton_weight" value="{{$carton_details->carton_weight ?? ''}}" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <label class="">{{ __('UOM')}}</label>
                                                        {{-- DropDown --}}
                                                        {{-- pcs/ sets --}}
                                                        <div class="form-group">
                                                            {{-- <input class="form-control" name="carton_unit" type="nnumber" id="carton_unit" value="{{$carton_details->carton_unit ?? ''}}" > --}}
                                                            <select name="carton_unit" id="carton_unit" class="form-control">
                                                                <option @if($carton_details->carton_unit == 'pcs') selected @endif value="pcs">pcs</option>
                                                                <option @if($carton_details->carton_unit == 'sets') selected @endif value="sets">sets</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">HSN Info</div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group {{ $errors->has('hsn') ? 'has-error' : ''}}">
                                                        <label for="hsn" class="control-label">HSN<span class="text-danger">*</span> </label>
                                                        <input required  class="form-control" name="hsn" type="text" id="hsn" value="{{$product->hsn}}" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group {{ $errors->has('hsn_percent') ? 'has-error' : ''}}">
                                                        <label for="hsn_percent" class="control-label">HSN Percent<span class="text-danger">*</span> </label>
                                                        <input required  class="form-control" name="hsn_percent" type="number" id="hsn_percent" value="{{$product->hsn_percent}}" >
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>

                            <div class="stepper d-none" data-index="3">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Images</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                           <div class="col-md-12 col-12">
                                                <div class="form-group {{ $errors->has('img') ? 'has-error' : ''}}">
                                                    <label for="img" class="control-label">Images</label>
                                                    <input class="form-control" name="img[]" multiple type="file" id="img" value="{{$product->img}}">
                                                    <div class="row">
                                                        @forelse ($medias as $media)
                                                           <div class="col-3">
                                                               <div>
                                                                   <img id="img-preview" src="{{ asset($media->path) }}" class="mt-3 product-img" />
                                                                   <a href="{{ route('panel.products.deleteImage',$media->id) }}" style="position: absolute;right: 10px;" class="btn btn-icon btn-danger delete-item"><i class="ik ik-trash"></i></a>
                                                                </div>
                                                            </div>
                                                        @empty

                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Content</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 d-none">
                                                <div class="form-group">
                                                    <label for="">Tag 1</label>
                                                    <select name="tag1" id="" class="form-control">
                                                        <option value="" aria-readonly="true">Select Tag 1</option>
                                                        @foreach(App\Models\Category::where('category_type_id',15)->get() as $tag1)
                                                            <option value="{{ $tag1->name }}" @if($tag1->name == $product->tag1) selected @endif> {{ $tag1->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 d-none">
                                                <div class="form-group">
                                                    <label for="">Tag 2</label>
                                                    <select name="tag2" id="" class="form-control">
                                                        <option value="" aria-readonly="true">Select Tag 1</option>
                                                        @foreach(App\Models\Category::where('category_type_id',16)->get() as $tag2)
                                                            <option value="{{ $tag2->name }}" @if($tag2->name == $product->tag2) selected @endif> {{ $tag2->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 d-none">
                                                <div class="form-group">
                                                    <label for="">Tag 3</label>
                                                    <select name="tag3" id="" class="form-control">
                                                        <option value="" aria-readonly="true">Select Tag 1</option>
                                                        @foreach(App\Models\Category::where('category_type_id',17)->get() as $tag3)
                                                            <option value="{{ $tag3->name }}" @if($tag3->name == $product->tag3) selected @endif> {{ $tag3->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group {{ $errors->has('artwork_url') ? 'has-error' : ''}}">
                                                    <label for="artwork_url" class="control-label">Art Work Reference</label>
                                                    <input class="form-control" name="artwork_url" type="url" id="artwork_url" value="{{ $product->artwork_url }}" placeholder="Enter Artwork URL" >
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Video Url </label>
                                                    <input type="url" name="video_url" class="form-control" value="{{ $product->video_url }}" id="">
                                                </div>
                                            </div>

                                           <div class="col-md-12 col-12">
                                                <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                                    <label for="description" class="control-label">Product Description</label>
                                                    <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{ $product->description }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group {{ $errors->has('features') ? 'has-error' : ''}}">
                                                    <div class="alert alert-info">
                                                        Add Product Features With New Line Each
                                                    </div>
                                                    <label for="features" class="control-label">Features</label>
                                                    <textarea name="features" class="form-control" id="" cols="30" rows="5">{{ $product->features }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                <div class="form-group {{ $errors->has('meta_description') ? 'has-error' : ''}}">
                                                    <label for="meta_description" class="control-label">Meta Description</label>
                                                    <textarea name="meta_description" class="form-control" id="" cols="30" rows="3">{{ $product->meta_description ?? old('meta_description') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-6">
                                                <div class="form-group {{ $errors->has('meta_keywords') ? 'has-error' : ''}}">
                                                    <label for="meta_keywords" class="control-label">Meta Keywords</label>
                                                    <textarea name="meta_keywords" class="form-control" id="" cols="30" rows="3">{{ $product->meta_keywords ?? old('meta_keywords') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-check pl-0">
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" value="1" name="is_publish" @if($product->is_publish == 1) checked @endif >
                                                        <span class="custom-control-label">Publish</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-info">
                                <p class="mb-0">Changing any field will result in unpublishing SKUs from all linked sellers.</p>
                            </div>

                            <div class="row stepper-actions">
                                <div class="col-lg-4">
                                    <a href="#" class="btn btn-outline-primary previous_btn d-none">Previous</a>
                                </div>
                                <div class="col-lg-4 d-flex form-group justify-content-center">
                                    <button type="submit" class="btn btn-primary btn-md update_btn d-none">Update</button>
                                </div>
                                <div class="col-lg-4 d-flex form-group justify-content-end">
                                    <a href="#" class="btn btn-primary next_btn" >Next</a>
                                </div>
                            </div>
                        </form>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <h3> #PMID{{ getPrefixZeros($product->id) }} | {{ $product->color }} - {{ $product->size }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="product_type">Product Type</label>
                                            <select required name="product_type" id="product_type" class="form-control select2">
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
                           <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        Varients:
                                    </div>
                                    <form action="{{ route('panel.products.update.varient', $product->id) }}" method="post">
                                        @csrf
                                        <div class="card-body">
                                            @php
                                                $colors = json_decode($colors->value,true);
                                                $sizes = json_decode($sizes->value,true);
                                            @endphp
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mb-0">
                                                        <label for="input">{{ __('Color')}}</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-control select2" name="color" id="color">
                                                            <option value="" readonly >Select Color</option>
                                                            @foreach (explode(',',$colors[0]) as $item)
                                                                <option {{ ($item == $product->color || $item == old('color')) ? 'selected' : '' }} value="{{ $item }}">{{ $item }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group mb-0">
                                                        <label for="input">{{ __('Size')}}</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <select class="form-control select2" name="size" id="size">
                                                            <option value="" readonly >Select Size</option>
                                                            @foreach (explode(',',$sizes[0]) as $item)
                                                                <option {{ ($item == $product->size || $item == old('size'))  ? 'selected' : '' }} value="{{ $item }}" >{{ $item }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-block btn-outline-primary">Update Varients</button>
                                        </div>
                                    </form>
                                </div>
                           </div>
                           <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <h3>Variations</h3>
                                        <div>
                                            <a href="javascript:void(0);" data-toggle="modal" data-target="#editVarientModal" class="btn btn-sm btn-info">Add Varient</a>
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
    </div>
     @include('panel.products.include.varient',['product_id'=>$product->id])
    <!-- push external js -->
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
        <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
        <script>
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
                    $('.update_btn').removeClass('d-none');
                }
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
