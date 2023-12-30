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
        ['name'=>'Edit / Template', 'url'=> "javascript:void(0);", 'class' => '']
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

    $default_property  = ['Model_Code','SKU Type','Product name','Category','Sub_Category','Customer_Price_without_GST','HSNTax','HSN_Percnt', 'Variation attributes' ];

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

    <form action="{{ route('panel.products.update.template',$template->id) }}" method="POST">
        <div class="row m-2">
            <div class="col-12" style="display: flex;align-items: center;justify-content: center;gap: 10px;margin: 40px 0;">
                {{-- 1st Column --}}
                <div class="col-md-6 col-12 " style="overflow: auto; max-height: 80vh">

                    <h5>Select Properties You Wish to Edit</h5>
                    <div class="">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Template Name" required name="template_name" id="template_name" value="{{ $template->template_name }}">
                        </div>
                    </div>
                    {{-- <p>These Values will be Updated on All selected Products</p> --}}

                    {{-- <div class="form-group w-100">
                        <input type="checkbox" id="check_all" class=" m-2" @if (count((array) $col_list) == count(json_decode($template->columns_values)))checked @endif>
                        <label for="check_all"  style="font-size: large;user-select: none;">Select All</label>
                    </div>   --}}

                    {{-- All Attributes Except System --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseallattribute"
                                aria-expanded="false" aria-controls="collapseallattribute">
                                All Properties ( {{count((array) $col_list) - count((array) $default_property)}} )
                            </button>
                        </h2>
                        <div id="collapseallattribute" class="accordion-collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body" style="max-height:80%; overflow:hidden;overflow-y:auto;">
                                <div class="form-group w-100" style="margin-bottom:0rem">
                                    <input type="checkbox" id="check_all" class=" m-2" @if (count((array) $col_list) == count(json_decode($template->columns_values)))checked @endif>
                                    <label for="check_all"  style="font-size: 14px; font-family:Nunito Sans, sans-serif;font-weight:700; user-select: none;">Select All</label>
                                </div> 

                                <div class="table-responsive" style="max-height:40vh; overflow:hidden;overflow-y:auto;">
                                    <table class="table">
                                        <tbody>
                                            @forelse ($col_list as $item => $key)
                                                @if (!in_array($item,$default_property))
                                                    <tr class="">
                                                        <td scope="row" style="padding:0px! important">
                                                            <div class="form-group h-100" style="cursor: pointer; margin-bottom:0rem!important; ">
                                                                {{-- <input type="checkbox" value="{{$item}}" style="10%" id="attri_{{$item}}" class="my_attribute mx-1" name="myfields[]" data-index="{{ $key }}" @if (in_array($item,json_decode($template->columns_values))) checked @endif> --}}
                                                                <input type="checkbox" value="{{$item}}" id="attri_{{$item}}" class="my_attribute d-none mx-1" name="myfields[]" data-index="{{ $key }}" @if (in_array($item,json_decode($template->columns_values))) checked @endif>
                                                                <label for="attri_{{$item}}" class="form-label w-100" style="font-size: 12.8px;font-family:Nunito Sans, sans-serif;font-weight:700; user-select: none;">{{$item}}</label>
                                                                {{-- <label for="attri_{{$item}}" class="form-label" style="font-size: 12.8px;user-select: none; width:90%">{{$item}}</label> --}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr class="">
                                                    <td scope="row">
                                                        <div class="form-group">
                                                            <label for="attri_1" class="form-label w-100 h-100" style="font-size: large;user-select: none;">System Under Upgrade Try Again Later.</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- System Attribute Accordation --}}
                    {{-- <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesystemattri"
                                aria-expanded="false" aria-controls="collapsesystemattri">
                                System Properties ( {{count((array) $default_property)}} )
                            </button>
                        </h2>
                        <div id="collapsesystemattri" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                        
                                <div class="table-responsive" style="max-height:80%; overflow:hidden;overflow-y:auto;">
                                    <table class="table">
                                        <tbody>
                                            @forelse ($col_list as $item => $key)
                                                @if (in_array($item,$default_property))
                                                    <tr class="">
                                                        <td scope="row">
                                                            <div class="form-group">
                                                                <label for="attri_{{$item}}" class="form-label" style="font-size: large;user-select: none;">{{$item}}</label>
                                                                <input type="checkbox" value="{{$item}}" id="attri_{{$item}}" class="sys_attribute m-2 invisible" checked name="systemfiels[]">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr class="">
                                                    <td scope="row">
                                                        <div class="form-group">
                                                            <label for="attri_1" class="form-label" style="font-size: large;user-select: none;">System Under Upgrade Try Again Later.</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div> --}}

                    <div class="actionbtn mt-2 d-flex justify-content-between align-items-center my-2">
                        
                        <a class="btn btn-outline-primary px-5 close-button" href="{{ route('panel.products.create') }}?action=nonbranded&bulk_product">Cancel</a>

                        <button class="btn btn-primary px-5">Save and Download</button>
                    </div>
                </div>

                {{-- 2nd column --}}
                <div class="col-md-6 col-12 h-100 invisible" style="overflow: auto; max-height: 80vh" id="tableselected">
                    <div class="accordion-item" style="margin-top: 5rem">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsesystemattri"
                                aria-expanded="false" aria-controls="collapsesystemattri">
                                System Properties ( {{count((array) $default_property)}} )
                            </button>
                        </h2>
                        <div id="collapsesystemattri" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                        
                                <div class="table-responsive" style="max-height:80%; overflow:hidden;overflow-y:auto;">
                                    <table class="table">
                                        <tbody>
                                            @forelse ($col_list as $item => $key)
                                                @if (in_array($item,$default_property))
                                                    <tr class="">
                                                        <td scope="row" style="padding:0px! important">
                                                            <div class="form-group h-100" style="margin-bottom: 0rem!important;">
                                                                <label for="attri_{{$item}}" class="form-label" style="font-size: 12.8px; font-family:Nunito Sans, sans-serif;font-weight:700; user-select: none;">{{$item}}</label>
                                                                <input type="checkbox" value="{{$item}}" id="attri_{{$item}}" class="sys_attribute m-2 invisible" checked name="systemfiels[]">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr class="">
                                                    <td scope="row">
                                                        <div class="form-group">
                                                            <label for="attri_1" class="form-label" style="font-size: large;user-select: none;">System Under Upgrade Try Again Later.</label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- <div class="my-3">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Template Name" required name="template_name" id="template_name" value="{{ $template->template_name }}">
                        </div>
                    </div> --}}
                    <div class="d-flex flex-column gap-3 align-items-start justify-content-start">
                        <div class="heading w-100" style="background-color: #f6f8fb; color:#879099;">
                            <h5>Selected Tags</h5>
                        </div>
                        <div class="selected_tag" style="width:100%">
                            {{-- Append Element Are shown Here --}}
                        </div>
                    </div>
                    
                </div>  
            </div>      
        </div>    
    </form>

    



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

                let tag = `<div class="form-group" id="parent_${$(this).data('index')}"style="margin-bottom:0rem;">
                    <input type="checkbox" value="${$(this).val()}" id="${$(this).attr('id')}" class="selected_prop m-2" checked data-parent="parent_${$(this).data('index')}">
                    <label for="${$(this).attr('id')}" class="form-label" style="font-size: 12.8px;font-family:Nunito Sans, sans-serif;font-weight:700; user-select: none;">${$(this).val()}</label>
                    <span class="close-icon" style=" width:20%;" data-parent="parent_${$(this).data('index')}">&times;</span>   
                </div>`;

                if ($(this).is(":checked")) {
                    $(`label[for="${$(this).attr('id')}"]`).css({"background-color": "#6666cc", "color": "#fff"});       
                    $(".selected_tag").append(tag);
                    
                }else{
                    $(`#parent_${$(this).data('index')}`).remove();
                    $(`label[for="${$(this).attr('id')}"]`).css({"background-color": "#fff", "color": "#000000"});
                }
                
            });
            



            $(".my_attribute").each(function(i,elem){
                
                if (elem.checked == true) {
                    let value = elem.value;
                    let index = elem.dataset.index;
                    let eleid = elem.id;
                    
                    let tag = `<div class="form-group" id="parent_${index}" style="margin-bottom: 0rem;">
                            <input type="checkbox" value="${value}" id="${eleid}" class="selected_prop m-2" checked data-parent="parent_${index}">
                            <label for="${eleid}" class="form-label" style="font-size: 12.8px;font-family:Nunito Sans, sans-serif;font-weight:700; user-select: none;">${value}</label>
                            <span class="close-icon" style=" width:20%;" data-parent="parent_${$(this).data('index')}">&times;</span>
                        </div>`;
                    
                    if ($(this).is(":checked")) {
                        let labelId = $(this).attr("for");
                        $(`label[for="${eleid}"]`).css({
                            "background-color": "#6666cc",
                            "color": "#fff"
                    });
                        
                        $(".selected_tag").append(tag);
                        
                    }else{
                        $(`#parent_${$(this).data('index')}`).remove();
                        $(`label[for="${eleid}"]`).css({
                            "background-color": "#fff",
                            "color": "#000000"
                    });
                        
                    }
                }
                myfunc();

            })
            function myfunc() {
                if ($(".my_attribute:checked").length > 0) {
                    // any one is checked
                    $("#tableselected").removeClass('invisible');
                } else {
                    $("#tableselected").addClass('invisible');
                }
            }


        });
    </script>
    

    @endpush
@endsection
