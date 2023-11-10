@extends('backend.layouts.main') 
@section('title', 'Product')
@section('content')
{{-- @dd(auth()->id()); --}}
@php
    $breadcrumb_arr = [
        ['name'=>'Add Product', 'url'=> "javascript:void(0);", 'class' => '']
    ];
    if(AuthRole() == "User"){
        $user_id = auth()->id();
        $user = auth()->user();
    }else{
        $user = App\User::find(request()->get('user_id'));
        $user_id = request()->get('user_id');
    }
    $user_shop = App\Models\UserShop::whereUserId($user_id)->first();
    $catelogue_author = @App\User::whereId(request()->type_id)->first();
    $group = @App\Models\AccessCatalogueRequest::whereNumber($catelogue_author->phone)->first()->price_group_id ?? 0;

    $user = auth()->user();  
    $acc_permissions = json_decode($user->account_permission);
    $acc_permissions->mysupplier = $acc_permissions->mysupplier ?? 'no';
    $acc_permissions->offers = $acc_permissions->offers ?? 'no';
    $acc_permissions->addandedit  = $acc_permissions->addandedit  ?? 'no';
    $acc_permissions->manangebrands  = $acc_permissions->manangebrands  ?? 'no';
    $acc_permissions->pricegroup  = $acc_permissions->pricegroup  ?? 'no';
    $acc_permissions->managegroup  = $acc_permissions->managegroup  ?? 'no';
    $acc_permissions->bulkupload  = $acc_permissions->bulkupload  ?? 'no';
    

    // Todo: Setting Up Permissions for Team USer

    $teamDetails = App\Models\Team::where('contact_number',session()->get('phone'))->first();

    if ($teamDetails != null) {
        $permissions = json_decode($teamDetails->permission);
        if ($permissions) {
            $Team_mycustomer = in_array("my-customer",$permissions);
            $Team_mysupplier = in_array("my-suppler",$permissions);
            $Team_offerme = in_array("offer-me",$permissions);
            $Team_offerto = in_array("offer-other",$permissions);
            $Team_profile = in_array("profile",$permissions);
            $Team_proadd = in_array("proadd",$permissions);
            $Team_setting = in_array("setting",$permissions);
            $Team_dashboard = in_array("dashboard",$permissions);
            $Team_brand = in_array("brand",$permissions);
            $Team_pricegroup = in_array("pricegroup",$permissions);
            $Team_categorygroup = in_array("categorygroup",$permissions);
            $Team_bulkupload = in_array("bulkupload",$permissions);
        }else{
            // Default Access to Original Supplier
            $Team_mycustomer = true;
            $Team_mysupplier = true;
            $Team_offerme = true;
            $Team_offerto = true;
            $Team_profile = true;
            $Team_proadd = true;
            $Team_setting = true;
            $Team_dashboard = true;
            $Team_brand = true;
            $Team_pricegroup = true;
            $Team_categorygroup = true;
            $Team_bulkupload = true;
            
        }
    }
    else{
        // Default Access to Original Supplier
        $Team_mycustomer = true;
        $Team_mysupplier = true;
        $Team_offerme = true;
        $Team_offerto = true;
        $Team_profile = true;
        $Team_proadd = true;
        $Team_setting = true;
        $Team_dashboard = true;
        $Team_brand = true;
        $Team_pricegroup = true;
        $Team_categorygroup = true;
        $Team_bulkupload = true;
    }

@endphp

    <!-- push external head elements to head -->
    @push('head')
   
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/normalize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">

    <style>
        .error{
            color:red;
        }
              .product-box {
                position: relative;
                overflow: hidden;
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
            }
            #checkmarkpin{
                border-radius: 3px;
                background-color: transparent !important;
            }
            
            .prdct-pinned input{
                visibility: hidden;
            }
            #checkmarkpin  img  {
                height: 30px;
                width: 30px;
            }
            .checkmark {
                position: absolute;
                top: 11px;
                left: 7px;
                height: 19px;
                width: 20px;
                border-radius: 3px;
                background-color: #eee;
            }

            .checkmark:after {
                content: "";
                position: absolute;
                display: block;
            }
            .custom-chk .checkmark:after {
                left: 6px;
                top: 2px;
                width: 7px;
                height: 12px;
                border: solid white;
                border-width: 0 3px 3px 0;
                -webkit-transform: rotate(45deg);
                -ms-transform: rotate(45deg);
                transform: rotate(45deg);
            }
            .custom-chk input:checked ~ .checkmark {
                background-color: #6666cc;
            }
            .cust-display{
                display: flex;
            }
            @media (max-width: 767px) {
                .cust-display{
                    display: block;
                }
            }
            .remove-ik-class{
                -webkit-box-shadow: unset !important;
                box-shadow: unset !important;
            }
            .dropdown-menu.multi-level.show{
                min-width: 7rem !important;
                width: 100px !important;
                position: absolute;
                transform: translate3d(112px, 250px, 0px) !important;
                top: 0px;
                left: 0px !important;
                will-change: transform;
            }

            .skeltonbtn{
                background: transparent;
                transition: 0.3s;
                position: relative;
            }
            .skeltonbtn:hover{
                background-color: #6666cc;
            }
            .card-body1{
                 -ms-flex:1 1 auto;
                    flex:1 1 auto;
                    padding:1.25rem;
                    max-height: 75vh;
                    overflow-y: auto;
            }


    </style>

    @endpush 
    <div class="container-fluid">
    	<div class="page-header d-none">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-flex" style="height: 23px;">
                            <h5>{{ $title ?? 'N/A' }}</h5>
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
            <div class="col-md-12">
                <!-- start message area-->
               @include('backend.include.message')
                <!-- end message area-->

                <div class="row">
                    <div class="col-lg-6 col-md-12  col-12 my-2">
                        <div class="one" style="display: flex; align-items: center; justify-content: flex-start;">
                            <a href="?type={{ request()->get('type') }}&type_ide={{ encrypt(request()->get('type_id')) }}"
                                class="btn btn-outline-primary mx-1 
                                @if (!request()->has('products') && !request()->has('assetsafe') && !request()->has('properties') && !request()->has('productsgrid')) active @endif
                                ">
                                Categories
                            </a>
                            <a href="?type={{ request()->get('type') }}&type_ide={{ encrypt(request()->get('type_id')) }}&productsgrid=true"
                                class="btn btn-outline-primary mx-1 @if (request()->has('products') OR request()->has('productsgrid')) active @endif">
                                Products
                            </a>
                            <a href="?type={{ request()->get('type') }}&type_ide={{ encrypt(request()->get('type_id')) }}&properties=true"
                                class="btn btn-outline-primary mx-1 @if (request()->has('properties')) active @endif">
                                Properties
                            </a>
                            <a href="?type={{ request()->get('type') }}&type_ide={{ encrypt(request()->get('type_id')) }}&assetsafe=true"
                                class="btn btn-outline-primary mx-1 @if (request()->has('assetsafe')) active @endif">
                                Assets Safe
                            </a>
                        </div>
                    </div>
                
                    {{-- This Menu is Always Visible --}}
                    <div class="col-lg-6 col-md-12 col-12 my-2">        
                        <div class="two" style="display: flex; align-items: center; justify-content: flex-end;">
                            @include('panel.user_shop_items.includes.action_menu')
                        </div>
                    </div>
                </div>
                

                    {{-- <div class="row">
                        <div class="col-md-6 col-12 my-2">
                            <div class="one" style="display: flex;align-items: center;justify-content: flex-start;">
                                <a href="?type={{ request()->get('type') }}&type_ide={{ encrypt(request()->get('type_id')) }}"
                                    class="btn btn-outline-primary  mx-1 
                                    @if (!request()->has('products') && !request()->has('assetsafe') && !request()->has('properties') && !request()->has('productsgrid')) active @endif
                                    ">
                                    Categories
                                </a>
                                <a href="?type={{ request()->get('type') }}&type_ide={{ encrypt(request()->get('type_id')) }}&productsgrid=true"
                                    class="btn btn-outline-primary mx-1 @if (request()->has('products') OR request()->has('productsgrid')) active @endif">
                                    Products
                                </a>
                                <a href="?type={{ request()->get('type') }}&type_ide={{ encrypt(request()->get('type_id')) }}&properties=true"
                                    class="btn btn-outline-primary mx-1 @if (request()->has('properties')) active @endif">
                                    Properties
                                </a>

                                <a href="?type={{ request()->get('type') }}&type_ide={{ encrypt(request()->get('type_id')) }}&assetsafe=true"
                                    class="btn btn-outline-primary mx-1 @if (request()->has('assetsafe')) active @endif">
                                    Assets Safe
                                </a>

                            </div>
                        </div> --}}

                        {{-- ` This Menu is Always Visible  --}}
                        {{-- <div class="col-md-6 col-12 my-2">        
                            <div class="two" style="display: flex;align-items: center;justify-content: flex-end;">
                                @include('panel.user_shop_items.includes.action_menu')
                            </div>
                        </div>
                    </div> --}}


                    {{-- ` This Menu Only Visible when Checkbox Is Checked  --}}
                    <div class="row d-none" id="quickaction">
                        {{-- <div class="row d-none" id="quickaction" style="position:sticky!important; overflow:hidden;"> --}}
                        <div class="col-12 d-flex justify-content-center">
                            @include('panel.user_shop_items.includes.QuickActionMenu')
                        </div>
                    </div>

                    
                    @if (request()->has('products'))
                        @include('panel.user_shop_items.includes.show-productTable')
                    @elseif(request()->has('assetsafe'))
                        @include('panel.user_shop_items.includes.Filemanager')    
                    @elseif(request()->has('productsgrid'))
                        @include('panel.user_shop_items.includes.show-product')    
                    @elseif(request()->has('properties'))
                        @include('panel.user_shop_items.includes.Properties')
                    @else
                        @include('panel.user_shop_items.includes.show-category')
                    @endif
                    

                    
                </div>
            </div>
        </div>
    </div>
    <form class="" action="{{ route('panel.user_shop_items.create',['type' => request()->get('type'),'type_id' => request()->get('type_id')]) }}" id="filterRecordsForm" method="GET">
        <input type="hidden" name="type" value="{{ request()->get('type') }}">
        <input type="hidden" name="type_ide" value="{{ encrypt(request()->get('type_id')) }}">
        <input type="hidden" value="{{ request()->get('lenght') }}" name="length" id="lengthInput">
        <input type="hidden" name="search" value="" id="searchField">
        <input type="hidden" name="category_id" value="" id="categoryId">
    </form>
    @include('panel.user_shop_items.add-product')
    <div class="modal fade" id="BulkPriceGroupUpdateModal" role="dialog" aria-labelledby="addProductTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="addProductTitle">Bulk Group Price Update</h5>
            <div class="ml-auto">
                <a href="{{ route('panel.product.group.bulk-export') }}" class="btn btn-link"><i class="fa fa-download"></i> Export Product Price Groups</a>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.product.group.bulk-update') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Upload Updated Excel Template</label>
                            <input type="file" name="file" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        </div>
                    </div>
                    <div class="col-md-12 ml-auto">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="updateQR" role="dialog" aria-labelledby="addProductTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="addProductTitle">Select Products</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('panel.products.update.qr') }}" method="get" id="qrform">
                    {{-- @csrf --}}
                    <div class="form-group" id="productsDropdown">
                        <input type="text" id="needqr" name="product_ids">
                        {{-- <select name="product_ids[]" class="form-control select2"  id="needqr" multiple>
                            @foreach ($qr_products as $qr_product)
                                <option value="{{ $qr_product->id }}">
                                    {{ "Model Code: ".$qr_product->model_code.' : '.$qr_product->title.' , '.$qr_product->color.' , '.$qr_product->size  }}
                                </option>
                            @endforeach
                        </select> --}}
                    </div>
                    <div class="form-check p-0">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="all_products" value="1" id="allProducts">
                            <span class="custom-control-label" style="position: absolute;">All Products</span>
                        </label>
                    </div>
                        <button class="btn btn-primary mt-3" type="submit">Generate Printable Product QR</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    
    <!-- push external js -->
    @push('script')
        
        <script src="{{ asset('backend/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{asset('backend/js/form-advanced.js') }}"></script>
        <script src="{{ asset('backend/js/index-page.js') }}"></script>

        <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>
        <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        <script>
            
            function html_table_to_excel(type)
            {
                var table_core = $("#table").clone();
                var clonedTable = $("#table").clone();
                clonedTable.find('[class*="no-export"]').remove();
                clonedTable.find('[class*="d-none"]').remove();
                $("#table").html(clonedTable.html());
                var data = document.getElementById('table');

                var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
                XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
                XLSX.writeFile(file, 'ProductAttributeFile.' + type);
                $("#table").html(table_core.html());
                
            }

            $(document).on('click','#export_button',function(){
                html_table_to_excel('xlsx');
            })
        

            $('#reset').click(function(){
                var url = $(this).data('url');
                getData(url);
                window.history.pushState("", "", url);
                $('#TableForm').trigger("reset");
                //   $('#fieldId').select2('val',"");               // if you use any select2 in filtering uncomment this code
            // $('#fieldId').trigger('change');                  // if you use any select2 in filtering uncomment this code
            });

        
        </script>
        <script>
            // Add Product To Pin=
            $('.input-checkpin').click(function(){
                var  id = $(this).val();
                if($(this).prop('checked')){
                    // var img = ;?
                    var route = "{{ route('panel.user_shop_items.api.addpinonsie') }}"+"?product_id="+$(this).val()+'&user_id='+"{{ $access_id }}";
                    $.ajax({
                        url: route,
                        method: "get",
                        success: function(res){
                            $("#input-checkpinimg_"+id).attr('src', "{{ asset('frontend/assets/svg/bookmark_added.svg')}}");
                        }
                    });
                    
                }else{
                    var route = "{{ route('panel.user_shop_items.api.removepinonsie') }}"+"?product_id="+$(this).val()+'&user_id='+"{{ $access_id }}";
                    $.ajax({
                        url: route,
                        method: "get",
                        success: function(res){
                            $("#input-checkpinimg_"+id).attr('src', "{{ asset('frontend/assets/svg/bookmark.svg')}}");
                        }
                    });
                }
            });
            $('#hike').on('change',function(){
                var hike = $(this).val();
                $('.bulkHike').val(hike);
            })
            $('#filterBtn').on('click',function(e){
                e.preventDefault();
                var search = $('#searchValue').val();
                var length = $('#lengthField').val(); 
                $('#lengthInput').val(length);
                $('#searchField').val(search);
                $('#filterRecordsForm').submit();
            })
            $('#searchValue').keypress(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    var search = $('#searchValue').val();
                    var length = $('#lengthField').val(); 
                    $('#lengthInput').val(length);
                    $('#searchField').val(search);
                    $('#filterRecordsForm').submit();
                }
            });
            $('.bulkHike').val($('#hike').val());
            $(document).ready(function(){
                $('.addProductBtn').on('click',function(){
                    var pid = $(this).data('pid');
                    var category_id = $(this).data('category_id');
                    var sub_category_id = $(this).data('sub_category_id');
                    var price = $(this).data('price');
                    var hike = $('#hike').val();
                    $('.priceInput').val(price);
                    $('.productID').val(pid);
                    $("#category_id").attr('disabled', 'disabled');
                    $("#category_id").val(category_id).change();
                    $("#category_id").removeAttr('disabled', 'disabled');
                    $("#sub_category_id").attr('disabled', 'disabled');
                    $("#sub_cate_loader").show();
                    setTimeout(() => {
                        $(document).find("#sub_category_id").val(sub_category_id).change();
                        $("#sub_category_id").removeAttr('disabled', 'disabled');
                        $("#sub_cate_loader").hide();
                    }, 1500);
                    $('#addProductModal').modal('show');
                });
                $('#allProducts').on('click',function(){
                    $('#productsDropdown').toggle('');
                });
            })
            $('#UserShopItemForm').validate();
                $('.repeatergruop_price').repeater({
                    initEmpty: false,
                    defaultValues: {
                        'text-input': 'foo'
                    },
                    show: function() {
                        $(this).slideDown();
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
                $(document).ready(function() {
                    user_id = "{{ $user_id }}";
                    $("#price_checkbox").click(function(event) {
                        if ($(this).is(":checked")){
                            $(".price_group").removeClass('d-none');
                            $("#group_id").attr("required", true);
                            $("#stock").attr("required", true);
                        }
                        else{
                            $(".price_group").addClass('d-none');
                            $("#group_id").attr("required", true);
                            $("#stock").attr("required", true);
                        }
                    
                    });
                    
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
                                $('#sub_category_id').html(res);
                            }
                        })
                    }
                });
                                    
            
                $('#select-all').click(function(){
                    if($('.input-check').is(':checked')){
                        $('.input-check').prop('checked',false);
                    }else{
                        $('.filterable-items').each(function(){
                            if(!$(this).hasClass('d-none')){
                                $(this).find('.input-check').prop('checked',true);
                            }
                        });
                    }
                });
                $('.unSelectAll').click(function(){
                    if($('.input-check').is(':checked')){
                        $('.input-check').prop('checked',false);
                    }else{
                        $('.filterable-items').each(function(){
                            if(!$(this).hasClass('d-none')){
                                $(this).find('.input-check').prop('checked',false);
                            }
                        });
                    }
                });
                $('.categoryFilter').click(function(e){
                e.preventDefault();
            
                    var categoryId = $(this).data('category_id');
                    $('#categoryId').val(categoryId);
                    var length = $('#lengthField').val();
                    $('#lengthInput').val(length);
                    $('#filterRecordsForm').submit();
                });    
                
                $('.lengthSearch').on('click',function(){
                    var length = $('#lengthField').val();
                    $('#lengthInput').val(length);
                    $('#filterRecordsForm').submit();
                })
                function replaceUrlParam(paramName, paramValue) {
                    var url = window.location.href;
                    if (paramValue == null) {
                        paramValue = '';
                    }
                    var pattern = new RegExp('\\b(' + paramName + '=).*?(&|#|$)');
                    if (url.search(pattern) >= 0) {
                        return url.replace(pattern, '$1' + paramValue + '$2');
                    }
                    url = url.replace(/[?#]$/, '');
                    return url + (url.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue;
                }
                $('#lengthField').on('change',function(){
                    var value = $(this).val();
                    window.history.pushState({}, '', replaceUrlParam('length', value));
                    var length = $('#lengthField').val();
                    $('#lengthInput').val(length);
                    $('#filterRecordsForm').submit();
                })
                $('.validateMargin').on('click', function(e){
                    if($('#hike').val() > 99){
                        $('#hike').val(99);
                        $.toast({
                            heading: 'ERROR',
                            text: "Margin must be less than 100",
                            showHideTransition: 'slide',
                            icon: 'error',
                            loaderBg: '#f2a654',
                            position: 'top-right'
                        });
                        e.preventDefault();
                    }
                });
                
            $(document).on('click','#delete_all_dummy',function(e){
            e.preventDefault();
            var msg = $(this).data('msg') ?? "All Product will be Deleted, And You won't be able to revert back!";
            $.confirm({
                draggable: true,
                title: 'Are You Sure!',
                content: msg,
                type: 'red',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: 'Confirm',
                        btnClass: 'btn-red',
                        action: function(){
                            $("#delete_all").click();
                        }
                    },
                    close: function () {
                    }
                }
                });
            });

            $("#delproduct_dummy").click(function (e) { 
                e.preventDefault();
                let selected = $(".input-check:checked").length;
                
                var msg = `
                <span class="text-danger">You are about to delete ${selected} products</span> <br/>
                <span>This action cannot be undone. To confirm type <b>DELETE</b></span>
                <input type='text' id='margin' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Delete'>`;

                $.confirm({
                    draggable: true,
                    title: `Delete ${selected} products`,
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
                                    $("#delproduct").click();
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


        </script>

        <script>
            $(document).ready(function () {
                // product-action
                function myfunc() {
                    if ($(".input-check:checked").length > 0) {
                        // any one is checked
                        $("#quickaction").removeClass('d-none');
                        getValues()
                    } else {
                        $("#quickaction").addClass('d-none');
                    }
                }

                function getValues(){
                    let selected = []
                    let record = document.querySelectorAll(".input-check:checked");
                    record.forEach(element => {
                        selected.push(element.dataset.record);
                    });
                    $(".selectedbtn").html(selected.length+' selected')
                    return selected;
                }

                $("#printQrbtn").click(function (e) { 
                    e.preventDefault();
                    $("#needqr").val(getValues());
                    $("#qrform").submit()
                    
                });


                $("#exportproductbtn").click(function (){
                    $("#products_export").val(getValues());
                    $("#products_exportform").submit();
                })


                $(".input-check").change(function (e) { 
                    myfunc()
                });


                $("#checkallinp").change(function (e) { 
                    $('.input-check').click();                
                });

                $("#export-categrory").click(function (e) { 
                    e.preventDefault();
                    
                    let forminput = $('#choose_cat_ids');
                    let form = $('#export_category_product');
                    let arr = [];

                    if ($(".input-check:checked").length > 0) {
                        $.each($(".input-check:checked"), function (indexInArray, valueOfElement) { 
                            arr.push(valueOfElement.value);  
                        });
                        console.log(arr);
                        forminput.val(arr)
                        form.submit()
                    }
                    

                });
                
                

                $("#deletecatbtn").click(function (e) { 
                    e.preventDefault();
                    let forminput = $('#delete_ids');
                    let form = $('#categoryDeleteForm');
                    let arr = [];

                    if ($(".input-check:checked").length > 0) {
                        $.each($(".input-check:checked"), function (indexInArray, valueOfElement) { 
                            arr.push(valueOfElement.value);  
                        });
                        console.log(arr);
                        forminput.val(arr)
                        form.submit()
                    }
                });
                
                
                
            });
        </script>
        <script>
            $("#demo01").animatedModal({
                animatedIn: 'lightSpeedIn',
                animatedOut: 'bounceOutDown',
                color: '#F6F7FB',
                width: "30%",
                height: "30%",
                transform: "translate(3%, -47%)",
                top: "70%",
                left: "70%",
                overflow: 'none',

            });

            $(".opencateedit").click(function (e) { 
                e.preventDefault();
                
                $("#catid").val($(this).data('catidchange'));
                $("#old_name").val($(this).data('catname'))

                
                $("#demo01").click()
            });
            // $("#demo01").click()

        </script>

    @endpush
@endsection
