<div class="row show_single_prouduct d-none">
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
                {{-- <div class="md-step editable custom_active_add-1" data-step="1">
                    <div class="md-step-circle"><span>2 </span></div>
                    <div class="md-step-title">Asset Safe</div>
                    <div class="md-step-bar-left"></div>
                    <div class="md-step-bar-right"></div>
                </div> --}}
                <div class="md-step editable custom_active_add-2" data-step="2">
                    <div class="md-step-circle"><span>3 </span></div>
                    <div class="md-step-title">Sale Pricing</div>
                    <div class="md-step-bar-left"></div>
                    <div class="md-step-bar-right"></div>
                </div>
                <div class="md-step editable custom_active_add-3" data-step="3">
                    <div class="md-step-circle"><span>4</span></div>
                    <div class="md-step-title">Basic Info</div>
                    <div class="md-step-bar-left"></div>
                    <div class="md-step-bar-right"></div>
                </div>
                <div class="md-step editable custom_active_add-4" data-step="4">
                    <div class="md-step-circle"><span>5</span></div>
                    <div class="md-step-title">Product Properties</div>
                    <div class="md-step-bar-left"></div>
                    <div class="md-step-bar-right"></div>
                </div>
                <div class="md-step editable custom_active_add-5" data-step="5">
                    <div class="md-step-circle"><span>6</span></div>
                    <div class="md-step-title">Internal - Production</div>
                    <div class="md-step-bar-left"></div>
                    <div class="md-step-bar-right"></div>
                </div>
                <div class="md-step editable custom_active_add-6" data-step="6">
                    <div class="md-step-circle"><span>7</span></div>
                    <div class="md-step-title">Properties</div>
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
                                <div class="form-group {{ $errors->has('group_id') ? 'has-error' : ''}}">
                                    <label for="group_id" class="control-label">Group Id </label>
                                    <input class="form-control" name="group_id" type="text" id="group_id" value="{{old('group_id')}}" placeholder="Enter Group Name"  list="available_group" autocomplete="off">
                                    
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
                                    <label for="">Model Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter Model Number" name="model_code"
                                    value="{{ old('model_code') }}" list="available_modelcode" autocomplete="off" required>
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

                        {{-- <div class="row">
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
                        </div> --}}
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
                            {{-- <div class="image-input">
                                <input type="file" accept="image/*" id="imageInput" name="img[]" multiple>
                                <label for="imageInput" class="image-button bg-primary "><i class="far fa-image"></i> Choose image</label>
                                <span class="change-image">Choose different image</span>
                            </div> --}}
                            <div class="form-group mb-0">
                                <input class="form-control" type="file" name="img[]" multiple value="{{old('img')}}"  accept=".png, .jpg, .jpeg">
                            </div>
                            <p class="pb-0"><i class="ik ik-info mr-1"></i>Multiple images can be selected at once by using the control key.</p> 
                        </div>
                    </div>
                </div>

               


            </div>

            {{-- ` Asset Safe --}}
            {{-- <div class="stepper d-none" data-index="2">
                <div class="card mt-2">
                    <div class="card-header">
                        <h3>Upload new</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="form-group {{ $errors->has('img') ? 'has-error' : ''}}"> --}}
                                    {{-- <label for="img" class="control-label">Image_main</label> --}}
                                    {{-- <input class="form-control" name="img[]" multiple type="file" id="img" value="{{$product->img}}">
                                    <div class="row"> --}}
                                        {{-- @forelse ($medias as $media)
                                            <div class="col-3">
                                                <div>
                                                    <img id="img-preview" src="{{ asset($media->path) }}" class="mt-3 product-img" />
                                                    <a href="{{ route('panel.products.deleteImage',$media->id) }}" style="position: absolute;right: 10px;" class="btn btn-icon btn-danger delete-item"><i class="ik ik-trash"></i></a>
                                                </div>
                                            </div>
                                        @empty
                                        
                                        @endforelse --}}
                                    {{-- </div>
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
                                            <th scope="row"> --}}
                                                {{-- {{ $filename }} --}}
                                                {{-- <span class="filename" data-oldname="{{$filename }}">
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
                                                {{-- <span class="filename" data-oldname="{{$filename }}">
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
                                            <th scope="row"> --}}
                                                {{-- {{ $filename }} --}}
                                                {{-- <span class="filename" data-oldname="{{$filename }}">
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
                                                {{-- <span class="filename" data-oldname="{{$filename }}">
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
                
            </div> --}}
        
            <div class="stepper d-none" data-index="3">

                <div class="card">
                    <div class="card-header">
                        {{-- <h4>Sale Pricing</h4> --}}
                    </div>
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-4 col-6 mt-2"> 
                                <label class="">{{ __('Base Currency')}}</label>
                                {{-- <input class="form-control" name="base_currency" type="text" id="base_currency" value="{{ old('base_currency') }}" > --}}
                                @php
                                    $currencies = App\Models\UserCurrency::where('user_id',auth()->id())->get() ?? [];
                                @endphp
                                <select name="base_currency" id="base_currency" class="select2">
                                    @forelse ($currencies as $item)
                                        <option value="{{ $item->currency }}">{{ $item->currency }}</option>
                                    @empty
                                        <option value="INR">INR</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="col-md-4 col-6 mt-2"> 
                                <label class="">{{ __('Selling Price Unit')}}</label>
                                    <input class="form-control" name="selling_price_unit" type="text" id="selling_price_unit" value="{{ old('selling_price_unit') }}" >
                            </div>
                            
                            <div class="col-md-4 col-6 mt-2"> 
                                <div class="form-group {{ $errors->has('customer_price_without_gst') ? 'has-error' : ''}}">
                                    <label for="customer_price_without_gst" class="control-label">Customer Price Without GST</label>
                                    <input class="form-control" name="customer_price_without_gst" type="number" id="customer_price_without_gst" value="{{ old('customer_price_without_gst') }}" >
                                </div>
                            </div>
                            
                            <div class="col-md-4 col-6 mt-2 d-none"> 
                                <div class="form-group {{ $errors->has('vip_price') ? 'has-error' : ''}}">
                                    <label for="vip_price" class="control-label">VIP Customer Price, without GST</label>
                                    <input class="form-control" name="vip_price" type="number" id="vip_price" value="{{ old('vip_price') }}" >
                                </div>
                            </div>
                            
                            <div class="col-md-4 col-6 mt-2 d-none"> 
                                <div class="form-group {{ $errors->has('reseller_price') ? 'has-error' : ''}}">
                                    <label for="reseller_price" class="control-label"> Reseller Price, without GST </label>
                                    <input class="form-control" name="reseller_price" type="number" id="reseller_price" value="{{ old('reseller_price') }}" >
                                </div>
                            </div>
                            
                            <div class="col-md-4 col-6 mt-2"> 
                                <div class="form-group {{ $errors->has('mrp') ? 'has-error' : ''}}">
                                    <label for="mrp" class="control-label">MRP Incl. tax</label>
                                    <input class="form-control" name="mrp" type="number" id="mrp" value="{{ old('mrp') }}" >
                                </div>
                            </div>

                            <div class="col-md-4 col-6 mt-2"> 
                                <div class="form-group {{ $errors->has('hsn') ? 'has-error' : ''}}">
                                    <label for="hsn" class="control-label">HSN Tax </label>
                                    <input class="form-control" name="hsn" type="number" id="hsn" value="{{ old('hsn') }}" >
                                </div>
                            </div>
                            <div class="col-md-4 col-6 mt-2"> 
                                <div class="form-group {{ $errors->has('hsn_percent') ? 'has-error' : ''}}">
                                    <label for="hsn_percent" class="control-label">HSN Percent </label>
                                    {{-- <div class="input-group"> --}}
                                        <input class="form-control" name="hsn_percent" type="number" id="hsn_percent" value="{{ old('hsn_percent') }}" >
                                        {{-- <span class="input-group-append" id="basic-addon3">
                                            <label class="input-group-text">%</label>
                                        </span>
                                    </div> --}}
                                </div>
                            </div>
                            

                            
                        </div>

                    </div>
                </div>
                

            </div>
            
            <div class="stepper d-none" data-index="4">
                <div class="card">
                    <div class="card-header">
                        <h4>Basic Product Info</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-12"> 
                                <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                    <label for="description" class="control-label">Product Description</label>
                                    <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4 col-6">
                                <div class="form-group ">
                                    <label for="search_keywords" class="control-label">Search keywords</label>
                                    <input  class="form-control TAGGROUP" name="search_keywords" type="text" id="search_keywords" value="{{ old('search_keywords') }}">
                                </div>
                            </div>

                            <div class="col-md-4 col-6">
                                <div class="form-group">
                                    <label for="">Brand Name</label>
                                    <input type="text" name="brand_name" class="form-control" id="brand_name" value="{{ old('brand_name') }}">
                                </div>
                            </div>

                            
                            <div class="col-md-4 col-6 d-none">
                                <div class="form-group">
                                    <label for="">Video Url </label>
                                    <input type="url" name="video_url" class="form-control" id="video_url" value="{{ old('video_url') }}">
                                </div>
                            </div>
                            
                            
                            <div class="col-md-4 col-6 d-none">
                                <div class="form-group {{ $errors->has('artwork_url') ? 'has-error' : ''}}">
                                    <label for="artwork_url" class="control-label">Art Work Reference</label>
                                    <input class="form-control" name="artwork_url" type="url" id="artwork_url" value="{{old('artwork_url')}}" placeholder="Enter Artwork URL" >
                                </div>
                            </div>

                            
                            
                            
                        </div>
                    </div>
                </div>


            </div>
            
            <div class="stepper d-none" data-index="5">
                <div class="card ">
                    <div class="card-header">
                        <h3>Product Properties</h3>
                    </div>
                    <div class="card-body">
                        {{-- ` PRODUCT WEIGHT GROUP --}}
                        <div class="col-12">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <hr class="text-primary">
                                    <label for="weightbox">
                                        <div class="h6">Product Weight</div>
                                    </label> &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" data-open="weightboxbtn" id="weightbox" class="hiddenbxbtn">
                                </div>
                            </div>
                            <div class="row d-none" id="weightboxbtn">
                                <div class="col-md-4 col-4">
                                    <div class="form-group ">
                                        <label for="gross_weight" class="control-label">Gross Weight</label>
                                        <input  class="form-control" name="gross_weight" type="text" id="gross_weight" value="{{ old('gross_weight') }}">
                                    </div>
                                </div>

                                <div class="col-md-4 col-4">
                                    <label class="">{{ __('Weight')}}</label>
                                    <div class="form-group">
                                        <input class="form-control" name="weight" type="nnumber" id="weight" value="{{ old('weight') }}">
                                    </div>
                                </div>

                                <div class="col-md-4 col-4">
                                    <label class="">{{ __('Weight UOM')}}</label>
                                    {{-- Drop Down --}}
                                    {{-- gms/kgs --}}
                                    <div class="form-group">
                                        <select name="unit" id="unit" class="form-control select2">
                                            <option value="gms">gms</option>
                                            <option value="kgs">kgs</option>
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
                                    <input type="checkbox" data-open="productdimensionsbox" id="productdimensionsbx" class="hiddenbxbtn">
                                </div>
                            </div>
                            <div class="row d-none" id="productdimensionsbox">
                                
                                <div class="col-md-6 col-12">
                                    <label class="Length">{{ __('Length')}}</label>
                                    <div class="form-group">
                                        <input class="form-control" name="length" type="nnumber" id="length" value="{{ old('length') }}" >
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="">{{ __('Width')}}</label>
                                    <div class="form-group">
                                        <input class="form-control" name="width" type="nnumber" id="width" value="{{ old('width') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label class="">{{ __('Height')}}</label>
                                        <div class="form-group">
                                            <input class="form-control" name="height" type="number" id="height" value="{{ old('height') }}">
                                        </div>
                                    </div>

                                <div class="col-md-6 col-12">
                                    <label class="">{{ __('LWH UOM')}}</label>
                                    {{-- DropDown --}}
                                    {{-- mm/cms/inches/feet --}}
                                    {{-- @dd($shipping) --}}
                                    <div class="form-group">
                                        <select name="length_unit" id="length_unit" class="form-control select2">
                                            <option value="mm">mm</option>
                                            <option value="cms">cms</option>
                                            <option value="inches">inches</option>
                                            <option value="feet">feet</option>
                                        </select>
                                        {{-- <input class="form-control" name="length_unit" type="nnumber" id="length_unit" value="{{$shipping->length_unit ?? ''}}" > --}}
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- ` PRODUCT PACKING --}}
                        <div class="col-12">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <hr class="text-primary">
                                    <label for="productpackingbx">
                                        <div class="h6">Product Packing</div>
                                    </label> &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" data-open="productpackingbox" id="productpackingbx" class="hiddenbxbtn">
                                </div>
                            </div>

                            <div class="row d-none" id="productpackingbox">
                                <div class="col-md-6 col-12">
                                    <label class="">{{ __('Standard Carton Pcs')}}</label>
                                        <div class="form-group">
                                            <input class="form-control" name="standard_carton" type="text" id="standard_carton" value="{{ old('standard_carton') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <label class="">{{ __('Carton Actual Weight')}}</label>
                                        <div class="form-group">
                                            <input class="form-control" name="carton_weight" type="number" id="carton_weight" value="{{ old('carton_weight') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <label class="">{{ __('Carton Length')}}</label>
                                        <div class="form-group">
                                            <input class="form-control" name="carton_length" type="number" id="carton_length"  value="{{ old('carton_length') }}" >
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <label class="">{{ __('Carton Width')}}</label>
                                        <div class="form-group">
                                            <input class="form-control" name="carton_width" type="number" id="carton_width" alue="{{ old('carton_width') }}"  >
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <label class="">{{ __('Carton Height')}}</label>
                                        <div class="form-group">
                                            <input class="form-control" name="carton_height" type="number" id="carton_height" alue="{{ old('carton_height') }}" >
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
                                                <option value="pcs">pcs</option>
                                                <option value="sets">sets</option>
                                            </select>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        {{-- ` Shipping Details --}}
                        <div class="col-12">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <hr class="text-primary">
                                    <label for="productshippingbx">
                                        <div class="h6">Shipping Details</div>
                                    </label> &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" data-open="productshippingbox" id="productshippingbx" class="hiddenbxbtn">
                                </div>
                            </div>
                            <div class="row d-none" id="productshippingbox">
                                <div class="col-md-6 col-12">
                                    <div class="form-group ">
                                        <label for="CBM" class="control-label">CBM</label>
                                        <input  class="form-control" name="CBM" type="text" id="CBM" alue="{{ old('CBM') }}" >
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group ">
                                        <label for="production_time" class="control-label">Production time (days)</label>
                                        <input  class="form-control" name="production_time" type="number" id="production_time" alue="{{ old('production_time') }}" >
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group ">
                                        <label for="MBQ" class="control-label">MBQ</label>
                                        <input  class="form-control" name="MBQ" type="text" id="MBQ" alue="{{ old('MBQ') }}"  >
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group ">
                                        <label for="MBQ_unit" class="control-label">MBQ_units</label>
                                        <input  class="form-control" name="MBQ_unit" type="number" id="MBQ_unit" alue="{{ old('MBQ_unit') }}" >
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group ">
                                        <label for="remarks" class="control-label">Remarks</label>
                                        <input  class="form-control" name="remarks" type="text" id="remarks" alue="{{ old('remarks') }}" >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="stepper d-none" data-index="6">
                <div class="card ">
                    <div class="col-12 d-none">
                        <div class="row mb-3">
                            <div class="col-12">
                                <hr class="text-primary">
                                <label for="productexclusivebx">
                                    <div class="h6">Exclusive  </div>
                                </label> &nbsp;&nbsp;&nbsp;
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
                                    <br>
                                    <input type="checkbox" class="hiddenbxbtn" id="exclubtn" data-open="productexclusivebuyernamebox" value="1" name="exclusive" required>
                                </div>
                            </div>
                            
                                <div class="col-md-6 col-12 d-none" id="productexclusivebuyernamebox">
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
                                </label> &nbsp;&nbsp;&nbsp;
                                <input type="checkbox" data-open="productsamplebox" id="productsamplebx" class="hiddenbxbtn">
                            </div>
                        </div>

                        <div class="row d-none" id="productsamplebox">
                            <div class="col-md-4 col-4">
                                <div class="form-group ">
                                    <label for="sample_available" class="control-label">Sample / Stock available</label>
                                        <input  class="form-control" name="sample_available" type="text" id="sample_available">
                                </div>
                            </div>
                            <div class="col-md-4 col-4">
                                <div class="form-group ">
                                    <label for="sample_year" class="control-label">Sample Year</label>
                                        <select name="sample_year" id="sample_year" class="form-control select2">
                                            <option value="">Select Year</option>
                                            @for ($i = date('Y'); $i >= 1985; $i--)
                                                <option value="{{ $i }}" >{{ $i }}</option>
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
                                                <option value="{{ $monthValue }}" >{{ $monthName }}</option>
                                            @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-4 col-4">
                                <div class="form-group ">
                                    <label for="sampling_time" class="control-label">Sampling time</label>
                                    <input  class="form-control" name="sampling_time" type="text" id="sampling_time">
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
                                </label> &nbsp;&nbsp;&nbsp;
                                <input type="checkbox" data-open="productsourcedbox" id="productsourcedbx" class="hiddenbxbtn">
                            </div>
                        </div>
                        <div class="row d-none" id="productsourcedbox">                                                   
                            <div class="col-md-4 col-4">
                                <div class="form-group ">
                                    <label for="vendor_sourced_from" class="control-label">Vendor Sourced from</label>
                                    <input  class="form-control" name="vendor_sourced_from" type="text" id="vendor_sourced_from">
                                </div>
                            </div>
                            <div class="col-md-4 col-4">
                                <div class="form-group ">
                                    <label for="vendor_price" class="control-label">Vendor Price</label>
                                    <input  class="form-control" name="vendor_price" type="text" id="vendor_price" >
                                </div>
                            </div>
                            <div class="col-md-4 col-4">
                                <div class="form-group ">
                                    <label for="product_cost_unit" class="control-label">Product Cost Unit</label>
                                    <input  class="form-control" name="product_cost_unit" type="text" id="product_cost_unit" >
                                </div>
                            </div>
                            <div class="col-md-4 col-4">
                                <div class="form-group ">
                                    <label for="vendor_currency" class="control-label">Vendor Currency</label>
                                    <input  class="form-control" name="vendor_currency" type="text" id="vendor_currency" >
                                </div>
                            </div>
                            <div class="col-md-4 col-4">
                                <div class="form-group ">
                                    <label for="sourcing_year" class="control-label">Sourcing Year</label>
                                    <select name="sourcing_year" id="sourcing_year" class="form-control select2">
                                        <option value="">Select Year</option>
                                        @for ($i = date('Y'); $i >= 1985; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
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
                                                <option value="{{ $monthValue }}"   >{{ $monthName }}</option>
                                            @endforeach      
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

            <div class="stepper d-none" data-index="7">
                
                <div class="card">
                    <div class="card-header">
                        <h4>Product Properties</h4>
                    </div>
                    <div class="card-body">
                                                                
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Select Variations</label>
                                    <select name="properties_varient[]" id="properties_varient" class="form-control select2" multiple>
                                        @foreach ($user_custom_col_list as $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

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

                                    if ($records != null) {
                                        $records = App\Models\ProductAttributeValue::where('parent_id',$records->id)->get();
                                    }else{
                                        $records = [];
                                    }

                                @endphp                                

                               
                                
                               @if (count($records) != 0)
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="properties_{{$key}}">{{ $item }}</label>
                                            <select name="{{$item}}[]" id="properties_{{$key}}" class="select2" multiple>
                                                <option value="">Select One</option>
                                                @foreach ($records as $record)
                                                    <option value="{{ $record->id }}">{{ $record->attribute_value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                               @endif

                            @endforeach
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
