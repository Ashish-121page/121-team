<div class="row show_single_prouduct">
    <div class="col-md-12 mx-auto">
            @include('backend.include.message')
        <form action="{{ route('panel.products.store') }}" method="post" enctype="multipart/form-data" id="ProductForm" class="product_form">
            @csrf
            <input type="hidden" name="status" value="0">
            <input type="hidden" name="is_publish" value="0">
            {{-- Stepper Start --}}
            <div class="md-stepper-horizontal orange">
                <div class="md-step active done custom_active_add-0" data-step="0">
                    <div class="md-step-circle"><span>1</span></div>
                    <div class="md-step-title">Essentials</div>
                    <div class="md-step-bar-left"></div>
                    <div class="md-step-bar-right"></div>
                </div>
                <div class="md-step editable custom_active_add-1" data-step="1">
                    <div class="md-step-circle"><span>2 </span></div>
                    <div class="md-step-title">Sale Pricing</div>
                    <div class="md-step-bar-left"></div>
                    <div class="md-step-bar-right"></div>
                </div>
                <div class="md-step editable custom_active_add-2" data-step="2">
                    <div class="md-step-circle"><span>3</span></div>
                    <div class="md-step-title">Basic Info</div>
                    <div class="md-step-bar-left"></div>
                    <div class="md-step-bar-right"></div>
                </div>
                <div class="md-step editable custom_active_add-3" data-step="3">
                    <div class="md-step-circle"><span>4</span></div>
                    <div class="md-step-title">Product Properties</div>
                    <div class="md-step-bar-left"></div>
                    <div class="md-step-bar-right"></div>
                </div>
                <div class="md-step editable custom_active_add-4" data-step="4">
                    <div class="md-step-circle"><span>5</span></div>
                    <div class="md-step-title">Internal - Production</div>
                    <div class="md-step-bar-left"></div>
                    <div class="md-step-bar-right"></div>
                </div>
                {{-- <div class="md-step editable custom_active_add-5">
                    <div class="md-step-circle"><span>6</span></div>
                    <div class="md-step-title">Custom Attributes</div>
                    <div class="md-step-bar-left"></div>
                    <div class="md-step-bar-right"></div>
                </div> --}}
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
                                <div class="form-group {{ $errors->has('group_id') ? 'has-error' : ''}}">
                                    <label for="group_id" class="control-label">Group Id<span class="text-danger">*</span> </label>
                                    <input required class="form-control" name="group_id" type="text" id="group_id" value="{{old('group_id')}}" placeholder="Enter Group Name"  list="available_group" autocomplete="off">
                                    
                                    @if ($available_groups != null)
                                        <datalist id="available_group">
                                            @foreach ($available_groups as $item)
                                                <option value="{{ $item }}"></option>
                                            @endforeach
                                        </datalist>
                                    @endif
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Model Number</label>
                                    <input type="text" class="form-control" placeholder="Enter Model Number" name="model_code"
                                    value="{{ old('model_code') }}" list="available_modelcode" autocomplete="off">
                                    @if ($available_model_code != null)
                                        <datalist id="available_modelcode">
                                            @foreach ($available_model_code as $item)
                                                <option value="{{ $item }}"></option>
                                            @endforeach
                                        </datalist>
                                    @endif


                                </div>
                            </div>


                            <div class="col-md-6 col-12"> 
                                <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                                    <label for="title" class="control-label">Product Name <span class="text-danger">*</span> </label>
                                    <input required class="form-control" name="title" type="text" id="title" value="{{old('title')}}" placeholder="Enter Title" >
                                </div>
                            </div>

                            <div class="col-md-6 col-12 d-none">
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

                {{-- IMAGES CARD --}}
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>
                                <h3>Images</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-md-12 col-12 form-group {{ $errors->has('img') ? 'has-error' : ''}}">
                            <div class="image-input">
                                <input type="file" accept="image/*" id="imageInput" name="img[]" multiple value="{{old('img')}}">
                                <label for="imageInput" class="image-button bg-primary "><i class="far fa-image"></i> Choose image</label>
                                <span class="change-image">Choose different image</span>
                            </div>
                            {{-- <div class="form-group mb-0">
                                <input class="form-control" type="file" name="img[]" multiple value="{{old('img')}}"  accept=".png, .jpg, .jpeg">
                            </div> --}}
                            <p class="pb-0"><i class="ik ik-info mr-1"></i>Multiple images can be selected at once by using the control key.</p> 
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