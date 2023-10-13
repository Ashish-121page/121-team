@extends('backend.layouts.main')
@section('title', 'User Shop Item')
@section('content')
    @php
    /**
     * User Shop Item
     *
     * @category  zStarter
     *
     * @ref  zCURD
     * @author    GRPL
     * @license  121.page
     * @version  <GRPL 1.1.0>
     * @link        https://121.page/
     */
    $breadcrumb_arr = [['name' => 'Edit User Shop Item', 'url' => 'javascript:void(0);', 'class' => '']];
    $product = getProductDataById($user_shop_item->product_id);
    @endphp
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <style>
            .error {
                color: red;
            }
            .product-box {
                position: relative;
                overflow: hidden;
            }
            .checkmark.custom-checkmark{
                position: absolute;
                top: 3;
                left: 95px;
                height: 20px;
                width: 20px;
            }
            .checkmark.custom-checkmark:after{
                left: 8px !important;
                top: 2px !important;
                width: 7px;
                height: 16px;
                border: solid white;
                border-width: 0 3px 3px 0;
            }
            .card-box {
                background-color: #fff;
                padding: 1.5rem;
                box-shadow: 0 1px 4px 0 rgb(0 0 0 / 10%);
                margin-bottom: 24px;
                border-radius: 0.25rem;
            }
           
            .prdct-checked {
                position: absolute;
                width: 30px;
                height: 30px;
                right: 10px;
                top: 10px;
            }
            .checkmark {
                position: absolute;
                top: 0;
                left: 0;
                height: 30px;
                width: 30px;
                border-radius: 3px;
                background-color: #eee;
            }
            .checkmark:after {
                content: "";
                position: absolute;
                display: block;
            }
            .custom-chk .checkmark:after {
                left: 12px;
                top: 5px;
                width: 7px;
                height: 16px;
                border: solid white;
                border-width: 0 3px 3px 0;
                -webkit-transform: rotate(45deg);
                -ms-transform: rotate(45deg);
                transform: rotate(45deg);
            }
            .custom-chk input:checked ~ .checkmark {
                background-color: #6666cc;
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
                            <h5>Edit {{Str::limit($product->title ?? 'N/A' , 30)}}</h5>
                            {{-- <span>Update a record for User Shop Item</span> --}}
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
                        <h3>Update User Shop Item</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.user_shop_items.update', $user_shop_item->id) }}" method="post"
                            enctype="multipart/form-data" id="UserShopItemForm">
                            @csrf
                            <div class="row">
                                @php
                                    $user_shop = App\Models\UserShop::whereUserId($user_shop_item->user_id)->first();
                                @endphp 
                                @if ($user_shop_item->user_id != null)
                                    <input type="hidden" name="user_id" value="{{ $user_shop_item->user_id }}">
                                    <input type="hidden" name="user_shop_id" value="{{ $user_shop->id }}">
                                    <input type="hidden" name="product_id" value="{{ $user_shop_item->product_id }}">
                                @else
                                    <div class="col-md-12 col-12"> 
                                        <div class="form-group">
                                            <label for="user_id">User <span class="text-danger">*</span></label>
                                            <select required name="user_id" id="user_id" class="form-control select2">
                                                <option value="" readonly>Select User </option>
                                                @foreach(UserList()  as $option)
                                                    <option value="{{ $option->id }}" @if ($option->id == $user_shop_item->user_id) selected @endif>{{  $option->name ?? ''}}</option> 
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>   
                                    <div class="col-md-6 col-12"> 
                                        <div class="form-group">
                                            <label for="user_shop_id">User Shop <span class="text-danger">*</span></label>
                                            <select required name="user_shop_id" id="user_shop_id" class="form-control select2">
                                                <option value="" readonly>Select User Shop </option>
                                                @foreach(App\Models\UserShop::all()  as $option)
                                                    <option value="{{ $option->id }}" @if ($option->id == $user_shop_item->user_shop_id) selected @endif>{{  $option->name ?? ''}}</option> 
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="category_id">Category<span class="text-danger">*</span></label>
                                        <select required name="category_id" class="form-control select2 category_id">
                                            <option value="" readonly>Select Category</option>
                                            @foreach(App\Models\Category::get()  as $option)
                                                <option value="{{ $option->id }}" @if ($option->id == $user_shop_item->category_id) selected @endif>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="sub_category_id">Sub Category <span class="text-danger">*</span></label>
                                        <select required name="sub_category_id" class="form-control select2 sub_category_id">
                                            <option value="" readonly>Select Sub Category </option>
                                            @if($user_shop_item->sub_category_id)
                                            <option value="{{ $user_shop_item->sub_category_id }}" selected>{{ fetchFirst('App\Models\Category',$user_shop_item->sub_category_id,'name') }}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                                        <label for="price" class="control-label">Customer Price</label>
                                        <input class="form-control" name="price" type="number" id="price"
                                            value="{{ $user_shop_item->price }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('is_published') ? 'has-error' : '' }}"><br>
                                        <label for="is_published" class="control-label">Is Published</label>
                                        <input class="js-single switch-input"
                                            @if ($user_shop_item->is_published) checked @endif name="is_published"
                                            type="checkbox" id="is_published" value="1">
                                    </div>
                                </div>


                                
                {{-- - New Fields --}}
                
                <div class="col-md-6 col-12"> 
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                        <label for="title" class="control-label">Title</label>
                        <input  class="form-control" name="title_user" type="text" id="ptitle" value="{{ $user_shop_item->title_user }}" placeholder="Enter Title" >
                    </div>
                </div>

                <div class="col-md-6 col-12"> 
                    <div class="form-group {{ $errors->has('video_url') ? 'has-error' : ''}}">
                        <label for="video_url" class="control-label">video URL</label>
                        <input  class="form-control" name="video_url" type="url" id="video_url" value="{{ $user_shop_item->video_url }}"  placeholder="Enter Video URL" >
                    </div>
                </div>

                <div class="col-md-6 col-12"> 
                    <div class="form-group {{ $errors->has('artwork_url') ? 'has-error' : ''}}">
                        <label for="artwork_url" class="control-label">Artwork URL</label>
                        <input  class="form-control" name="artwork_url" type="url" id="artwork_url" value="{{ $user_shop_item->artwork_url }}"  placeholder="Enter Artwork URL" >
                    </div>
                </div>

                <div class="col-md-6 col-12"> 
                    <div class="form-group {{ $errors->has('model_code') ? 'has-error' : ''}}">
                        <label for="model_code" class="control-label">Model Code</label>
                        <input  class="form-control" name="model_code_user" type="text" id="model_code" value="{{ $user_shop_item->model_code_user }}"  placeholder="Enter Model Code" >
                    </div>
                </div>

                
                <div class="col-md-6 col-12"> 
                    <div class="form-group {{ $errors->has('brand_name') ? 'has-error' : ''}}">
                        <label for="brand_name" class="control-label">Brand Name</label>
                        <input  class="form-control" name="brand_name_user" type="text" id="brand_name_user" value="{{ $user_shop_item->brand_name_user }}"  placeholder="Enter Brand Name" >
                    </div>
                </div>

                      
                <div class="col-md-6 col-12"> 
                    <div class="form-group {{ $errors->has('selling_price_unit') ? 'has-error' : ''}}">
                        <label for="selling_price_unit" class="control-label">Selling Price Unit</label>
                        <input  class="form-control floatvalues" name="selling_price_unit_user" type="text" id="selling_price_unit" value="{{ $user_shop_item->selling_price_unit_user }}"  placeholder="Enter Selling Price Unit" >
                    </div>
                </div>

                <div class="col-md-6 col-12"> 
                    <div class="form-group {{ $errors->has('mrp_user') ? 'has-error' : ''}}">
                        <label for="mrp_user" class="control-label">MRP</label>
                        <input  class="form-control floatvalues" name="mrp_user" type="text" id="mrp_user" value="{{ $user_shop_item->mrp_user }}"  placeholder="Enter MRP" >
                    </div>
                </div>


                {{-- - New Fields End --}}


                                


                                
                                <div class="col-md-12 col-12">
                                    <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                                        <label for="price" class="control-label">Product Description</label>
                                            @if ($user_shop_item->description != null)
                                                <textarea name="description" id="description" cols="30" rows="10" class="form-control" placeholder="Enter Product Description">{!!  html_entity_decode(preg_replace('/_x([0-9a-fA-F]{4})_/', '&#x$1;', $user_shop_item->description)) ?? '' !!}</textarea>
                                            @elseif($product->description != null)
                                                <textarea name="description" id="description" cols="30" rows="10" class="form-control" placeholder="Enter Product Description">{!!  html_entity_decode(preg_replace('/_x([0-9a-fA-F]{4})_/', '&#x$1;', $product->description)) ?? '' !!}</textarea>
                                            @else
                                                <textarea name="description" id="description" cols="30" rows="10" class="form-control" placeholder="Enter Product Description"></textarea>
                                            @endif
                                    </div>
                                </div>

                                
                                <div class="col-md-12">
                                   <div class="d-flex justify-content-between mb-3">
                                        <h6>Images:</h6>
                                       <div>
                                            {{-- <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#upload-image-bulk">Image Picker</a> --}}
                                            <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#UploadModal"> Upload More</a>
                                       </div>
                                   </div>
                                    <div class="row">
                                        @php
                                            if($user_shop_item->images != null){
                                                $arr = explode(',',$user_shop_item->images);
                                            }else{
                                                $arr = [];
                                            }
                                            $medias = App\Models\Media::whereType('UserShopItem')->whereTypeId($user_shop_item->id)->get();
                                            $medias = $product->medias->merge($medias);
                                        @endphp
                                        @foreach($medias as $media)
                                        <div class="col-md-3 my-2">
                                            <div class="product-card product-box">
                                                <label class="custom-chk prdct-checked" data-select-all="boards">
                                                    <input type="checkbox" name="medias[]" class="input-check" value="{{ $media->id }}" @if(in_array($media->id,$arr)) checked @endif>
                                                    <span class="checkmark"></span>
                                                </label>
                                                <img src="{{ asset($media->path) }}" style="width:100%;height:125px;" alt="">
                                                @if($media->type == "UserShopItem")
                                                    <a href="{{ route('panel.medias.destroy',$media->id) }}" class="btn btn-danger btn-block">Remove</a>
                                                @else
                                                    
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
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


        {{-- 121 Changes That Are Visible --}}
        @php
            $changes121 = $changes121 ?? null;
        @endphp

        @if ($changes121 != null)
            <div class="row" id="121change">
                <div class="col-md-8 mx-auto">
                    <!-- start message area-->
                    @include('backend.include.message')
                    <!-- end message area-->
                    <div class="card ">
                        <div class="card-header">
                            <h3>Update Items With 121</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('panel.user_shop_items.update121', $user_shop_item->id) }}" method="post"
                                enctype="multipart/form-data" id="UserShopItemForm">
                                @csrf
                                <div class="row">
                                    @php
                                        $user_shop = App\Models\UserShop::whereUserId($user_shop_item->user_id)->first();
                                    @endphp 
                                    @if ($user_shop_item->user_id != null)
                                        <input type="hidden" name="user_id" value="{{ $user_shop_item->user_id }}">
                                        <input type="hidden" name="user_shop_id" value="{{ $user_shop->id }}">
                                        <input type="hidden" name="product_id" value="{{ $user_shop_item->product_id }}">
                                    @else
                                        <div class="col-md-12 col-12"> 
                                            <div class="form-group">
                                                <label for="user_id">User <span class="text-danger">*</span></label>
                                                <select required name="user_id" id="user_id" class="form-control select2">
                                                    <option value="" readonly>Select User </option>
                                                    @foreach(UserList()  as $option)
                                                        <option value="{{ $option->id }}" @if ($option->id == $user_shop_item->user_id) selected @endif>{{  $option->name ?? ''}}</option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>   
                                        <div class="col-md-6 col-12"> 
                                            <div class="form-group">
                                                <label for="user_shop_id">User Shop <span class="text-danger">*</span></label>
                                                <select required name="user_shop_id" id="user_shop_id" class="form-control select2">
                                                    <option value="" readonly>Select User Shop </option>
                                                    @foreach(App\Models\UserShop::all()  as $option)
                                                        <option value="{{ $option->id }}" @if ($option->id == $user_shop_item->user_shop_id) selected @endif>{{  $option->name ?? ''}}</option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-6 col-12"> 
                                        <div class="form-group">
                                            <label for="product_title">Product Title<span class="text-danger">*</span></label>
                                            <input type="text" name="product_title" id="product_title" class="form-control" value="{{$changes121->title ?? ""}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12"> 
                                        <div class="form-group">
                                            <label for="video_url">Video URl <span class="text-danger">*</span></label>
                                            <input type="text" name="video_url" id="video_url" class="form-control" value="{{$changes121->video_url ?? ""}}">
                                            
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12"> 
                                        <div class="form-group">
                                            <label for="artwork">ArtWork Reference<span class="text-danger">*</span></label>
                                            <input type="text" name="artwork" id="artwork" class="form-control" value="{{$changes121->artwork ?? ""}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12"> 
                                        <div class="form-group">
                                            <label for="material">Material <span class="text-danger">*</span></label>
                                            <input type="text" name="material" id="material" class="form-control" value="{{$changes121->meterials ?? ""}}">
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12"> 
                                        <div class="form-group">
                                            <label for="tagsinp">Tags <span class="text-danger">*</span></label>
                                            <input type="text" name="tagsinp" id="tagsinp" class="form-control" value="{{$changes121->tags ?? ""}}" placeholder="Enter Some Tags">                                        
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-12 col-12">
                                        <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                                            <label for="price" class="control-label">Product Description</label>
                                                <textarea name="description" id="description" cols="30" rows="10" class="form-control" placeholder="Enter Product Description">{!!  html_entity_decode(preg_replace('/_x([0-9a-fA-F]{4})_/', '&#x$1;', $changes121->desription)) ?? '' !!}</textarea>
                                        </div>
                                    </div>

                                    
                                    <div class="col-md-12">
                                    <div class="d-flex justify-content-between mb-3">
                                            <h6>Images:</h6>
                                        <div>
                                                {{-- <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#upload-image-bulk">Image Picker</a> --}}
                                                {{-- <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#UploadModal"> Upload More</a> --}}
                                        </div>
                                    </div>
                                        <div class="row">
                                            @php
                                                if($changes121->images != null){
                                                    $arr = explode(',',$changes121->images);
                                                }else{
                                                    $arr = [];
                                                }
                                                $medias = App\Models\Media::whereType('Product_admin')->whereTypeId('admin')->get();
                                            @endphp
                                            @foreach($medias as $media)
                                            @if (in_array($media->id,$arr) )
                                                <div class="col-md-3 my-2">
                                                    <div class="product-card product-box">
                                                        <label class="custom-chk prdct-checked" data-select-all="boards">
                                                            <input type="checkbox" name="medias[]" class="input-check" value="{{ $media->id }}" @if(in_array($media->id,$arr)) checked @endif>
                                                            <span class="checkmark"></span>
                                                        </label>
                                                        <img src="{{ asset($media->path) }}" style="width:100%;height:125px;" alt="">
                                                    </div>
                                                </div>
                                            @endif
                                            @endforeach
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
        @endif
        {{-- 121 Change End --}}









    </div>
        <div class="modal fade" id="UploadModal" role="dialog" aria-labelledby="addProductTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="addProductTitle">Upload Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('panel.user_shop_items.add.images') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user_shop_item->id }}">
                    <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Choose Images:</label>
                            <input type="file" name="image_files[]" class="form-control" multiple id="">
                        </div>
                    </div>
                        <div class="col-md-12 ml-auto">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
        @include('panel.user_shop_items.upload-bulk-image')
    <!-- push external js -->
    @push('script')
     <script src="{{ asset('backend/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
        <script>
            $('#UserShopItemForm').validate();

            $(document).ready(function() {
                var repeater = $('.repeatergruop_price').repeater({
                    initEmpty: false,
                    defaultValues: {
                        'text-input': 'foo'
                    },
                    show: function() {
                        $(this).slideD();
                        $(".select2").select2();
                    },
                    hide: function(deleteElement) {
                        if (confirm('Are you sure you want to delete this element?')) {
                            $(this).slideUp(deleteElement);
                        }
                    },
                    ready: function(setIndexes) {},
                    isFirstItemUndeletable: true
                });
                @if (json_decode($user_shop_item->price_group) != null)
                    repeater.setList([
                    @foreach (json_decode($user_shop_item->price_group) as $rep_item)
                        { 
                            'group_id': "{{ $rep_item->group_id }}",
                            'price': "{{ $rep_item->price }}"
                        }
                        @if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                    ]);
                    $(".select2").select2();
                @endif
            });
            $('.category_id').change(function(){
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
                            $('.sub_category_id').html(res);
                        }
                    })
                }
            }) 
            if ($('#price_checkbox').is(":checked"))
            $(".price_group").removeClass('d-none');
            else
            $(".price_group").addClass('d-none');
            $(document).ready(function() {
                $("#price_checkbox").click(function(event) {
                    if ($(this).is(":checked"))
                    $(".price_group").removeClass('d-none');
                    else
                    $(".price_group").addClass('d-none');
                });
            });
            //  Upload Images

            var category_id;
            var sub_category_id;

            $('.category_id').on('change',function(){
                 category_id = $(this).val();
            });
            $('.sub_category_id').on('change',function(){
                 sub_category_id = $(this).val();
            });
            $('#uploadBulkForm').on('submit',function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{route('panel.user_shop_items.upload.bulk.image')}}",
                    method: "get",
                    datatype: "html",
                    data: {
                        category_id:category_id,
                        sub_category_id:sub_category_id
                    },
                    success: function(res){
                        var html = '';
                        $.each(res.images.data, function (key, val) {
                            html += `
                                <div classs="image-bulk">
                                    <div class="product-box">
                                        <label class="custom-chk" data-select-all="boards">
                                            <input type="checkbox" name="medias[]" class="input-check d-none" value="${val.id}">
                                            <span class="checkmark custom-checkmark"></span>
                                        </label>
                                        <img src="${val.path}" class="product-img-grid">
                                    </div>
                                </div>
                            `;
                        });
                        $('#upload-image-bulk #images-grid').html(html);
                    }
                })
            })



            $("#showbx").on("click",function(){
                $("#121change").toggleClass("d-none");
            });


        </script>
    @endpush
@endsection
