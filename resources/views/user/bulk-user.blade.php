@extends('backend.layouts.main') 
@section('title', 'Bulk User Import')
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
    $breadcrumb_arr = [
        ['name'=>'Add/Edit', 'url'=> "javascript:void(0);", 'class' => '']
    ];

    $user = auth()->user();  
    $acc_permissions = json_decode($user->account_permission);
    $acc_permissions->bulkupload = $acc_permissions->bulkupload ??  "no"; // If Not Exist in Databse Then It Will be No By Default.
@endphp
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    <style>
        .error{
            color:red; 
        }
        .product_boxes .card{
            border: 1px solid #6666CC !important;
        }
        label.create_btn{
            padding: 7px;
            background: #6666CC; 
            display: table;
            color: #fff;
            margin-left:10px;
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
        .remove-ik-class{
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

    <div class="row">
        <div class="col-10 mx-auto">


    
    
            {{-- Bulk Cart start --}}
                <div class="row bulk_product ">
                    <div class="col-md-10 mx-auto">
                            <div class="justify-content-center mx-auto d-flex mb-3">
                                <button class="btn btn-primary" id="import-btn">Import Users</button>
                                <button class="btn ml-3" id="export-btn">Export Users</button>
                            </div>
                        <div class="card">  
                            <div class="card-header">
                                <h3>Import Users</h3>
                            </div>
                            <div class="import pt-0 p-3">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ asset('utility/bulk-account.xls') }}" type="button"  class="btn-link mb-3">Download Excel</a>
                                </div>
                                <form action="{{ route('panel.create.user.bulk') }}" method="post" enctype="multipart/form-data" class="">
                                    <input type="hidden" name="brand_id" value="{{ request()->get('id') ?? '0' }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 col-12"> 
                                            <div class="form-group">
                                                <label for="file">Upload Updated Excel Template<span class="text-danger">*</span></label>
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
                                        <a href="{{route('panel.user.bulk-export')}}" type="button"  class="btn-link mb-3">Fill & Upload</a>
                                    </div>
                                        <form action="{{ route('panel.user.bulk-update') }}" method="post" enctype="multipart/form-data" class="">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12 col-12"> 
                                                    <div class="form-group">
                                                        <label for="file">Upload Updated Excel Template<span class="text-danger">*</span></label>
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
        </div>
    </div>


        
</div>
    <!-- push external js -->
    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{asset('backend/js/form-advanced.js') }}"></script>
    <script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
    <script>

          $('tags').tagsinput('items'); 
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
    
        
        $(document).ready(function(){
         $('#import-btn').on('click',function(){
            $('.import').removeClass('d-none') 
            $('.export').addClass('d-none') 
            $('.import-div').removeClass('d-none') 
            $('.export-div').addClass('d-none') 
            $('#export-btn').removeClass('btn-primary')  
            $(this).addClass('btn-primary') 
         });
         $('#export-btn').on('click',function(){
            $('.export').removeClass('d-none') 
            $('.import').addClass('d-none') 
             $('.import-div').addClass('d-none') 
             $('#import-btn').removeClass('btn-primary')  
             $('#import-btn').addClass('')  
            $(this).addClass('btn-primary') 
         });
        });

       

        $('.back_btn').on('click',function(){
            $('.product_boxes').removeClass('d-none');
            $('.show_single_prouduct').addClass('d-none');
            $('.bulk_product').addClass('d-none');
            $(this).addClass('d-none');
        })


        $('.bulk_upload_btn').on('click',function(){
            $('.product_boxes').addClass('d-none');
            $('.show_single_prouduct').addClass('d-none');
            $('.bulk_product').removeClass('d-none');
             $('.back_btn').removeClass('d-none');
        });




						
 

    </script>
    @endpush
@endsection
