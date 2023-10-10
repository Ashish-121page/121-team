@extends('backend.layouts.main') 
@section('title', 'User Shop Testimonal')
@section('content')
@php
/**
 * User Shop Testimonal 
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    GRPL
 * @license  121.page
 * @version  <GRPL 1.1.0>
 * @link        https://121.page/
 */
$breadcrumb_arr = [
    ['name'=>'Add User Shop Testimonal', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <style>
        .error{
            color:red;
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
                            <h5>Add User Shop Testimonal</h5>
                            <span>Create a record for User Shop Testimonal</span>
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
                        <h3>Create Client Feedback</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.user_shop_testimonals.store') }}" method="post" enctype="multipart/form-data" id="UserShopTestimonalForm">
                            @csrf
                            <input type="hidden" name="user_shop_id" value="{{ request()->get('shop_id') }}">
                            <div class="row">
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        <label for="name" class="control-label">Client Name<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="name" type="text" id="name" value="{{old('name')}}" placeholder="Enter Name" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('designation') ? 'has-error' : ''}}">
                                        <label for="designation" class="control-label">Designation or Department</label>
                                        <input  class="form-control" name="designation" type="text" id="designation" value="{{old('designation')}}" placeholder="Enter Designation" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
                                        <label for="image" class="control-label">Upload Client Logo</label>
                                        <input   class="form-control" name="file_image" type="file" id="image" value="{{old('image')}}" >
                                        <img id="image" class="d-none mt-2" style="border-radius: 10px;width:100px;height:80px;"/>
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('rating') ? 'has-error' : ''}}">
                                        <label for="rating" class="control-label">Client Feedback Rating</label>
                                        <input  class="form-control" name="rating" type="number" id="rating" value="{{old('rating')}}" placeholder="Enter Rating" min="1" max="5">
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-12 col-12"> 
                                    <div class="form-group">
                                        <label for="tesimonal" class="control-label">Feedback from Client</label>
                                        <textarea  class="form-control" name="tesimonal" id="tesimonal" placeholder="Enter Tesimonal">{{ old('tesimonal')}}</textarea>
                                    </div>
                                </div>
                                                            
                                <div class="col-md-12 ml-auto">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Create &  Post</button>
                                    </div>
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
    <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{asset('backend/js/form-advanced.js') }}"></script>
    <script>
        $('#UserShopTestimonalForm').validate();
                                                            
            document.getElementById('image').onchange = function () {
                var src = URL.createObjectURL(this.files[0])
                $('#image_file').removeClass('d-none');
                document.getElementById('image_file').src = src
            }
                                                            
    </script>
    @endpush
@endsection
