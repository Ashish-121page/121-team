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
            <div class="row bulk_product ">
                <div class="col-md-10 mx-auto">
                    <div class="card">  
                        <div class="card-header">
                            <div class="d-block h6"> Reorder Upload sheet </div>
                        </div>


                        <div class="import pt-0 p-3">
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('panel.bulk.product.bulk-sheet-export',auth()->id()) }}" type="button"  class="btn-link mb-3">Download Existing Excel</a>
                            </div>
                            <form action="{{ route('panel.bulk.update.bulk.excel') }}" method="post" enctype="multipart/form-data" id="upadteform">
                                <input type="hidden" name="brand_id" value="{{ request()->get('id') ?? '0' }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 col-12"> 
                                        <div class="form-group">
                                            <label for="file">Upload Updated Excel Template<span class="text-danger">*</span></label>
                                            <input required type="file" name="file" class="form-control mb-3">
                                            <span class="text-danger">Remember: </span> You  Can Order By Own. You Need to Contact Devloper to Change Name of Fields. 
                                        </div>
                                    </div>
                                    <div class="col-12 text-right">
                                        <button type="submit" class="btn btn-primary make-confirmation">Upload</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 bg-white">
            <div class="h4 text-center">Current Squence</div>
            <table class="table table-striped table-hover ">
                <tr>
                    <th>S.no</th>
                    <th>Name</th>
                    <th>Column Number</th>
                </tr>

                @foreach ($Settingvaluekeys as $key => $item)
                    <tr>
                        <td> {{ $loop->iteration  }}  </td>
                        <td>{{ $item }}</td>
                        <td>{{ $key +1 }} </td>
                    </tr>
                @endforeach

            </table>
        </div>
    </div>


    <!-- push external js -->
    @push('script')


    <script>
          $(document).on('click','.make-confirmation',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            var msg = $(this).data('msg') ?? "<span class='text-danger'>Note:</span> Remove  <br> 1. Colour, <br> 2.  Size <br> 3. Material <br> 4. Other Custom attribute <br> Fields From Excel Before Upload.";
            $.confirm({
                draggable: true,
                title: 'Are You Sure!',
                content: msg,
                type: 'blue',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: 'Confirm',
                        btnClass: 'btn-red',
                        action: function(){
                                $("#upadteform").submit()
                        }
                    },
                    close: function () {
                    }
                }
            });
        });
    </script>

    @endpush    
@endsection
