@extends('backend.layouts.main')
@section('title', 'Product Attribute')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Edit Product Attribute', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">

    <style>
        .error{
            color:red;
        }
        .bootstrap-tagsinput .tag{
            text-transform: none !important;
        }
        .bootstrap-tagsinput{
            width: 100% !important;
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
                            <h5>Edit Product Attribute</h5>
                            <span>Update a record for Product Attribute</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <a href="{{ url()->previous() }}" class="btn btn-secondary"> Back </a>
            </div>
            @php
                $get_value = App\Models\ProductAttributeValue::where('parent_id',$product_attribute->id)->orderBy('attribute_value','ASC')->get();
            @endphp


            <div class="col-md-10 mx-auto">
                <!-- start message area-->
               @include('backend.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-header">
                        <h3>Update Product Attribute ({{ count($get_value) ?? 0 }}) </h3>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('panel.product_attributes.update',$product_attribute->id) }}" method="post" enctype="multipart/form-data" id="ProductAttributeForm">

                            @csrf
                            <input type="hidden" value="{{auth()->id()}}" name="user_id">
                            <input type="hidden" value="{{getShopDataByUserId(auth()->id())->id  ?? null}}" name="user_shop_id">

                            <div class="row asded">
                                @if ($product_attribute->user_id == auth()->id() || AuthRole() == 'Admin')
                                    <div class="col-md-12 col-12">
                                @else
                                    <div class="col-md-12 col-12">
                                @endif

                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        <label for="name" class="control-label">Name<span class="text-danger">*</span></label>
                                        <input required  class="form-control" name="name" type="text" id="name" value="{{$product_attribute->name}}" placeholder="Enter Name" readonly >
                                    </div>
                                </div>

                                @if ($product_attribute->user_id == auth()->id() || AuthRole() == 'Admin')
                                    <div class="col-md-4 col-12 d-none">
                                        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                            <label for="visibility">
                                                visibility
                                                <i class="fas fa-info-circle" title="Attribute visibility in Offer and Display"></i>
                                            </label>
                                            <br>
                                            <input type="checkbox" name="visibility" id="visibility" class="form-control" value="1" @if ($product_attribute->visibility == 1) checked @endif>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-md-12 col-12">
                                    <div class="h6">Values</div>
                                </div>


                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <input type="text" id="tags" class="form-control w-100" name="newval" value="" placeholder="Enter New Values" pattern="^[a-zA-Z0-9_]*$">
                                    </div>
                                    <div class="form-group d-flex justify-content-center">
                                        <button type="submit" class="btn btn-outline-primary" name="newvalbtn">Add New </button>
                                    </div>
                                </div>


                                @foreach ($get_value as $item)
                                    @if ($item->user_id == null || $item->user_id == auth()->id() || AuthRole() == 'Admin')
                                        <div class="col-md-6 col-sm-6 col-lg-3 col-12">
                                            <div class="form-group d-flex align-items-center justify-content-center">
                                                <input class="form-control" type="text" id="name_{{$item->id}}" name="{{ "$item->id" }}" value="{{$item->attribute_value}}" placeholder="Enter Name" readonly>
                                                @if ($item->user_id == auth()->id() || AuthRole() == 'Admin')
                                                    <a href="#edit" class="btn btn-outline-primary mx-1 text-center editpen" data-hold="name_{{$item->id}}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <a href="{{ route('panel.product_attributes.destroy.value',$item->id) }}" class="btn btn-outline-danger mx-1 text-center delete-btn">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                            <div class="col-12">
                                <div class="form-group d-flex justify-content-center">
                                    <button type="submit" class="btn btn-outline-primary" name="updatevalbtn">Update</button>
                                </div>
                            </div>


                        </form>



                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
     <script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{asset('backend/js/form-advanced.js') }}"></script>

    <!-- Switcher -->
    <script src="{{ asset('frontend/assets/js/switcher.js') }}"></script>
    <script>


        $('#ProductAttributeForm').validate();
        $('#tags').tagsinput('items');

        $(document).ready(function () {
            $(".editpen").click(function (e) {
                e.preventDefault();
                let hold = "#"+ $(this).data('hold');
                let changeval =  $(hold);

                changeval.attr('readonly',false);
            });


            $("input").keyup(function (e) {
                let text = $(this).val().length - 1;
                let notin = ['@',"!","#","$","%","^","&","*","(",")","'","?","/","<",">","|","}","{","[","]","~","`","-","_","=","+",";",":",".",",",'"']

                if (notin.includes($(this).val()[text])) {
                    let newval = $(this).val().replace($(this).val()[text],"")
                    $(this).val(newval)
                    alert(" No special characters allowed in Product Property values")
                }
            });

            var acr_btn = document.querySelector('#visibility');
            var switchery = new Switchery(acr_btn, {
                color: '#6666CC',
                jackColor: '#fff'
            });




            $(".delete-btn").click(function (e) {
                e.preventDefault();
                var url = $(this).attr('href');

                var msg = `
                <span class="text-danger">You are about to delete property.</span> <br/>
                <span>This action cannot be undone. To confirm type <b>DELETE</b></span>
                <input type='text' id='margin' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='DELETE'>`;

                $.confirm({
                    draggable: true,
                    title: `Delete`,
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
                                    window.location.href = url;
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
    @endpush
@endsection
