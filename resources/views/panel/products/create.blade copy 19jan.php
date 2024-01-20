@extends('backend.layouts.main')
@section('title', 'Product Create')
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
        $breadcrumb_arr = [['name' => 'Add/Edit', 'url' => 'javascript:void(0);', 'class' => '']];

        $user = auth()->user();
        $acc_permissions = json_decode($user->account_permission);
        $acc_permissions->bulkupload = $acc_permissions->bulkupload ?? 'no'; // If Not Exist in Databse Then It Will be No By Default.

        // Setting Up Permissions for Team USer
        $teamDetails = App\Models\Team::where('contact_number', session()->get('phone'))->first();

        if ($teamDetails != null) {
            $permissions = json_decode($teamDetails->permission);
            if ($permissions != null) {
                $Team_bulkupload = in_array('bulkupload', $permissions);
            } else {
                $Team_bulkupload = true;
            }
        } else {
            $Team_bulkupload = true;
        }

        // Grouping Columns

        $default_property = ['Model_Code', 'SKU Type', 'Product_name', 'Category', 'Sub_Category', 'Customer_Price_without_GST', 'HSN_Code', 'HSN_Percnt', 'Variation attributes'];

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

            .bootstrap-tagsinput .tag {
                text-transform: none !important;
            }

            .bootstrap-tagsinput {
                width: 100% !important;
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
                /* background: #6666cc; */
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
            /* for md stepper create */
            .md-step editable custom_active_add-::before{
                content: '';
                background-color: #8484f8;
                height: ;
                width: ;
                position: absolute;
                bottom: ;
                left: ;
            }
            .active{
                background-color: transparent;
                color: #6666cc;
                border: none;
                outline: none;
                border-bottom: 1px solid #6666cc;
            }

            @media (max-width: 820px) {
            #hztab3 #hztab3 #hztab3 {
                    height: 198px;
                    width: 225px;
                }
            }

            #animatedModal{
                font-size: 1.25rem !important;
            }

            /* font-size: 1.25rem; */

            /* @media (max-width: 1180px) {
                .card{
                    height: 198px;
                    width: 200px;
                }
            } */



        </style>
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        {{-- <i class="ik ik-mail bg-blue"></i> --}}
                        <div class="d-flex">
                            {{-- <h5>Add/Edit</h5> --}}
                            {{-- @if (AuthRole() == 'User')
                                <span style="margin-top: -10px;">
                                    <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                                </span>
                            @endif --}}
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div> --}}
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 col-md-12 mx-auto ">
                {{-- Card start --}}
                <div class="row">
                    <div class="col-md-4 product_boxes">
                        <div class="card getSingleProduct" id="hztab1" style="cursor: pointer;">
                            <div class="card-header">
                                <i class="fas fa-plus btn text-primary h5" style="font-size: 1.2rem; line-height: 1 !important;"></i>
                                <h5>Single Product</h5>
                            </div>
                            <div class="card-body wrap_equal_height">
                                <ul>
                                    <li>Add Products 1 by 1</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 product_boxes">
                        <div class="card getcustomProduct" id="hztab2" style="cursor: pointer;">
                            <div class="card-header">
                                <i class="fas fa-upload btn text-primary h5" style="font-size: 1.2rem; line-height: 1 !important;"></i>
                                <h5>Custom Bulk </h5>
                            </div>
                            <div class="card-body wrap_equal_height">
                                <ul>
                                    {{-- <li>Over 5,000 SKU ready</li> --}}
                                    <li>Use Excel to add products</li>
                                    <li>Create templates based on product category</li>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-4 product_boxes">
                        <div class="card updateproducts" id="hztab3" style="cursor: pointer;">
                            <div class="card-header">
                                <svg width="24" height="28" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"
                                    class="mx-3 my-1">
                                    <path fill="#6666cc" fill-rule="evenodd"
                                        d="M3 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h3.25a.75.75 0 0 0 0-1.5H3a.5.5 0 0 1-.5-.5V3a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 .5.5v5.25a.75.75 0 0 0 1.5 0V4.364l2.19 1.14a.25.25 0 0 1 .107.338l-1.072 2.062a.75.75 0 0 0 1.33.692l1.073-2.062a1.75 1.75 0 0 0-.745-2.36l-2.912-1.516A2 2 0 0 0 9 1H3Zm10 12a2 2 0 1 1-4 0a2 2 0 0 1 4 0Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <h5>Update SKUs</h5>
                            </div>
                            <div class="card-body wrap_equal_height">
                                <ul>
                                    <li>Updated Selected SKUs using Excel</li>
                                </ul>
                            </div>
                        </div>
                    </div>



                    {{-- @if (auth()->user() && session()->has('admin_user_id') && session()->has('temp_user_id')) --}}
                    {{-- <div class="col-md-4 product_boxes">
                        <a class="card" href=" @if ($acc_permissions->bulkupload == 'yes') {{ route('panel.products.search') }}?action=nonbranded @else # @endif">
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

                    <div class="col-12 col-md-10  mb-3 justify-content-start">
                        <button class="btn btn-secondary back_btn d-none" id="back_btn">Back</button>
                    </div>
                </div>
                {{-- Card end --}}


                {{-- single product start --}}
                @include('panel.products.pages.single-create')
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
                                    <a href="{{ route('panel.bulk.product.bulk-sheet-export', auth()->id()) }}"
                                        type="button" class="btn-link mb-3">Download Excel</a>
                                </div>
                                <form action="{{ route('panel.bulk.product-upload') }}" method="post"
                                    enctype="multipart/form-data" class="">
                                    <input type="hidden" name="brand_id" value="{{ request()->get('id') ?? '0' }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="file">Upload Updated Excel Template<span
                                                        class="text-danger">*</span></label>
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
                                    <a href="{{ route('panel.bulk.product.bulk-export', auth()->id()) }}" type="button"
                                        class="btn-link mb-3">Fill & Upload</a>
                                </div>
                                <form action="{{ route('panel.bulk.product.bulk-update') }}" method="post"
                                    enctype="multipart/form-data" class="">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="file">Upload Updated Excel Template<span
                                                        class="text-danger">*</span></label>
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

                <div class="row get_custom_Product d-none" style="margin-left: 0px!important;">

                    <div class="col-md-6 col-12 mx-auto">
                        <div class="row p-2 card" style="height: 100%">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-cloud-upload-alt text-light bg-primary p-3 rounded-circle"
                                            style="font-size:2vh; margin-bottom:38px !important;"></i>
                                    </div>
                                    <div class="col-10 d-flex flex-column justify-content-center">
                                        <form action="{{ route('panel.bulk.custom.product-upload', auth()->id()) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="content">
                                                <h5>Import file</h5>
                                                <span>Upload Excel Sheet to Upload New Products Data.</span>

                                                <input type="file" name="uploadcustomfield" id="uploadcustomfield"
                                                    class="form-control my-3">
                                            </div>
                                            <div class="action justify-content-center text-center" style="margin: 20px 0">
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
                                            <span>Information will be downloaded as per <a
                                                    href="{{ asset('instructions/instructions.pdf') }}"
                                                    download="instructions.pdf" class="btn-link text-primary">Template</a>
                                                - All Details. Change
                                                template.</span>
                                            <div class="alert alert-warning p-1 mt-2 invisible"
                                                style="width: fit-content;" role="alert">
                                                <i class="fas fa-info-circle text-warning mx-1"></i> Sheet will have
                                                thumbnail
                                                urls & not images
                                            </div>
                                        </div>
                                        <div class="action">
                                            <a href="{{ route('panel.bulk.product.bulk-sheet-export', auth()->id()) }}"
                                                type="button" class="btn btn-outline-primary">Download</a>
                                            <a class="btn btn-outline-primary" id="demo01" href="#animatedModal"
                                                role="button">Create Template</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 3rd Card --}}

                    {{-- <div class="col-md-6 col-12 mx-auto my-3">
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
                    </div> --}}

                </div>

                <div class="row get_custom_Product d-none mt-3">

                    <div class="col-12 col-md-12">

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
                                            <td> {{ $item->template_name ?? 'No Name' }} </td>
                                            <td>
                                                <a href="{{ route('panel.products.download.template', $item->id) }}"
                                                    class="btn btn-outline-primary btn-sm">Download</a>
                                                <a href="{{ route('panel.products.edit.template', $item->id) }}"
                                                    class="btn btn-outline-primary btn-sm">Edit</a>
                                            </td>
                                            <td>
                                                {{ $item->created_at }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="">
                                            {{-- <td scope="row" colspan="4">Nothing to Show Here..</td> --}}
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>

                {{-- Custom Bulk Sheet End --}}

                {{-- upload Bulk Record --}}

                <div class="row update_products d-none">
                    <div class="col-md-8 col-lg-6 col-12 mx-auto my-3">
                        <div class="row p-2 card" style="height: 100%">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-2 d-flex align-items-center justify-content-center">
                                        <i class="fas fa-cloud-upload-alt text-light bg-primary p-3 rounded-circle"
                                            style="font-size:2vh; margin-bottom: 85px"></i>
                                    </div>
                                    <div class="col-10 d-flex flex-column justify-content-center">
                                        <form action="{{ route('panel.bulk.product.bulk-update') }}" method="post"
                                            enctype="multipart/form-data" class="">
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

                                                {{-- <a href="{{ route('panel.bulk.product.bulk-export', auth()->id()) }}"
                                                    type="button" class="btn btn-outline-primary">Fill & Upload</a> --}}
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        @include('panel.products.include.create_template')
        @include('panel.products.include.LInke-assets')



    </div>
    <!-- push external js -->
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
        <script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
        <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
        <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>


        <script>
            $(document).ready(function () {



                $(".hiddenbxbtn").click(function (e) {
                    $("#"+$(this).data('open')).toggleClass('d-none');
                });

                $(".hiddenbxbtn").change(function (e){
                    $("#"+$(this).data('open')).toggleClass('d-none');
                });

                var elems = Array.prototype.slice.call(document.querySelectorAll('.hiddenbxbtn'));

                elems.forEach(function(html) {
                    var switchery = new Switchery(html,{
                        color: '#6666CC',
                        jackColor: '#fff'
                    });

                });

                $(".md-step").click(function (e) {
                    e.preventDefault();

                    let stepindex = $(this).data('step');
                    let newwindow = $(`[data-index="${stepindex+1}"]`);
                    activeIndex = (stepindex+1);

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

                    if ($(".md-step").length == (stepindex+1)) {
                        $('.create_btn').removeClass('d-none');
                    }else{
                        $('.create_btn').addClass('d-none');
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


            });


        </script>


        <script>
            $(document).ready(function() {

        $("#check_all").click(function(e) {
            $(".my_attribute").click();
        });

        $(".my_attribute").click(function(e) {
            let keyindex = $(this).data('index');
            let tag = `<div class="form-group mt-2" id="parent_${$(this).data('index')}"style="margin-bottom:0rem;">
                <input type="checkbox" value="${$(this).val()}" id="${$(this).attr('id')}" class="selected_prop d-none" checked data-parent="parent_${$(this).data('index')}">
                <label for="${$(this).attr('id')}" class="form-label" style="font-size: 12.8px;font-weight:700;user-select: none; width:80%">${$(this).val()}</label>
                <span class="close-icon align-item-end " style="margin-left:80%:width:20%" data-parent="parent_${$(this).data('index')}">&times;</span>
            </div>`;

            if ($(this).is(":checked")) {
                $("label[for='" + $(this).attr('id') + "']").css({"background-color": "#6666cc", "color": "#fff", "padding": "5px"});
                $(".selected_tag").append(tag);

                // Add event listener for the close icon to remove the corresponding tag
                $(".close-icon").click(function(e) {
                    let parentID = $(this).data('parent');
                    $(`#${parentID}`).remove();

                    // Update the corresponding label color
                    let labelID = $(this).prev().attr('id');
                    $(`label[for="${labelID}"]`).css({"background-color": "#fff", "color": "#000000", "padding": "0px"});
                    $(`#parent_${$(this).data('index')}`).remove();
                $("label[for='" + $(this).attr('id') + "']").css({"background-color": "#fff", "color": "#000000", "padding": "0px"});

                    myfunc();
                });
            } else {
                $(`#parent_${$(this).data('index')}`).remove();
                $("label[for='" + $(this).attr('id') + "']").css({"background-color": "#fff", "color": "#000000", "padding": "0px"});
            }

            myfunc();
        });

        function myfunc() {
            if ($(".my_attribute:checked").length > 0) {
                $("#tableselected").removeClass('invisible');
            } else {
                $("#tableselected").addClass('invisible');
            }
        }

        });


        </script>


        <script>
            //demo 01
            $("#demo01").animatedModal({
                animatedIn: 'lightSpeedIn',
                animatedOut: 'bounceOutDown',
                color: '#fff',
                left:'150px',
                top: '150px',
                height: '80%',
                width: '80%'


            });


            $('tags').tagsinput('items');
            var options = {
                filebrowserImageBrowseUrl: "{{ url('/laravel-filemanager?type=Images') }}",
                filebrowserImageUploadUrl: "{{ url('/laravel-filemanager/upload?type=Images&_token=' . csrf_token()) }}",
                filebrowserBrowseUrl: "{{ url('/laravel-filemanager?type=Files') }}",
                filebrowserUploadUrl: "{{ url('/laravel-filemanager/upload?type=Files&_token=' . csrf_token()) }}"
            };
            $(window).on('load', function() {
                CKEDITOR.replace('description', options);
            });

            $('#ProductForm').validate();


            $(document).ready(function() {

                $('#import-btn').on('click', function() {
                    $('.import').removeClass('d-none')
                    $('.export').addClass('d-none')
                    $('.import-div').removeClass('d-none')
                    $('.export-div').addClass('d-none')
                    $('#export-btn').removeClass('btn-primary')
                    $(this).addClass('btn-primary')
                });
                $('#export-btn').on('click', function() {
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


            $('.getSingleProduct').on('click', function() {
                $('.product_boxes').addClass('d-none');
                $('.show_single_prouduct').removeClass('d-none');
                $('.back_btn').removeClass('d-none');
            })

            $('.getcustomProduct').on('click', function() {
                $('.product_boxes').addClass('d-none');
                $('.get_custom_Product').removeClass('d-none');
                $('.back_btn').removeClass('d-none');
            })

            $('.updateproducts').on('click', function() {
                $('.update_products').removeClass('d-none')
                $('.product_boxes').addClass('d-none');
                $('.back_btn').removeClass('d-none');
            });



            $('.back_btn').on('click', function() {
                $('.product_boxes').removeClass('d-none');
                $('.show_single_prouduct').addClass('d-none');
                $('.get_custom_Product').addClass('d-none');
                $('.update_products').addClass('d-none');
                $('.bulk_product').addClass('d-none');
                $(this).addClass('d-none');
            })
            $('.bulk_upload_btn').on('click', function() {
                $('.product_boxes').addClass('d-none');
                $('.show_single_prouduct').addClass('d-none');
                $('.bulk_product').removeClass('d-none');
                $('.back_btn').removeClass('d-none');
            });

            $('#category_id').change(function() {
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        url: "{{ route('panel.user_shop_items.get-category') }}",
                        method: "get",
                        datatype: "html",
                        data: {
                            id: id
                        },
                        success: function(res) {
                            $('#sub_category').html(res);
                        }
                    })
                }
            });

            $('.TAGGROUP').tagsinput('items');


            $('#bulk_category_id').change(function() {
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        url: "{{ route('panel.user_shop_items.get-category') }}",
                        method: "get",
                        datatype: "html",
                        data: {
                            id: id
                        },
                        success: function(res) {
                            console.log(res);
                            $('#bulk_sub_category').html(res);
                        }
                    })
                }
            });

            $(document).ready(function() {
                $("#manage_inventory").click(function() {
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

                $('.stepper-actions').on('click', '.next_btn', function(e) {
                    if (activeIndex < steps) {
                        var title_val = $('#title').val();
                        var category = $('#category_id').val();
                        var sub_category = $('#sub_category').val();
                        var title = title_val.trim();

                        if (title == '') {
                            alert('Title field is required');
                        } else if (category == '') {
                            alert('Category field is required');
                        } else if (sub_category == '') {
                            alert('Subcategory field is required');
                        } else {
                            $('[data-index=' + activeIndex + ']').addClass('d-none');
                            $('.custom_active_add-' + activeIndex).addClass('active');
                            activeIndex++;
                            $('[data-index=' + activeIndex + ']').removeClass('d-none');
                            $('.stepper-actions').find('.previous_btn').removeClass('d-none');
                        }

                    }
                    if (activeIndex == steps) {
                        $(this).hide();
                        $('.create_btn').removeClass('d-none');
                    }
                });

                $('.stepper-actions').on('click', '.previous_btn', function(e) {
                    if (activeIndex > 1) {
                        $('[data-index=' + activeIndex + ']').addClass('d-none');
                        $('.create_btn').addClass('d-none');
                        activeIndex--;
                        $('.custom_active_add-' + activeIndex).removeClass('active');
                        $('[data-index=' + activeIndex + ']').removeClass('d-none');
                        $('.stepper-actions').find('.next_btn').show();
                    }
                    if (activeIndex == 1) {
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
            $(document).ready(function() {
                $('#imageInput').change(function() {
                    var files = $(this)[0].files;
                    if (files.length > limit) {
                        alert("You can select max " + limit + " images.");
                        $('#imageInput').val('');
                        return false;
                    } else {
                        return true;
                    }
                });
            });
        </script>


        @if (request()->has('update_record'))
            <script>
                $(document).ready(function() {
                    $(".updateproducts").click();
                    // $.toast({
                    //     heading: 'Success',
                    //     text: 'Upload Excel to Update SKUs',
                    //     icon: 'success',
                    //     position: 'top-right',
                    //     textAlign: 'left',
                    //     loader: true,
                    //     loaderBg: '#9EC600'
                    // })
                });
            </script>
        @endif

        @if (request()->has('single_product'))
            <script>
                $(document).ready(function() {
                    $(".getSingleProduct").click();
                });
            </script>
        @endif

        @if (request()->has('bulk_product'))
            <script>
                $(document).ready(function() {
                    $(".getcustomProduct").click();
                });
            </script>
        @endif




    @endpush
@endsection
