@extends('backend.layouts.main') 
@section('title', 'Products')
@section('content')
    <style>
        .remove-ik-class{
            -webkit-box-shadow: unset !important;
            box-shadow: unset !important;
        }
    </style>
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
        ['name'=>'Products', 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
   
    @endphp
    <!-- push external head elements to head -->
    @push('head')
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-flex">
                            <h5>
                                @if($brand_activation)
                                    {{$brand->name}}
                                @else 
                                    {{ 'Upload Products' }}
                                @endif
                            </h5>
                            @if(AuthRole() == 'User')
                                <span style="margin-top: -10px;">
                                    <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                                </span>
                            @endif
                            
                        </div>
                        {{-- <span>List of Products</span> --}}
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        
        <form action="{{ route('panel.products.index') }}" method="GET" id="TableForm">

            <input type="hidden" name='action' value="{{ request('action') }}">
            <div class="row">
                <!-- start message area-->
                <!-- end message area-->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex flex-wrap justify-content-between">
                            <h3>
                                @if($brand_activation)
                                    {{$brand->name}}
                                @else 
                                    {{ 'Upload Products' }}
                                @endif    
                            </h3>
                            <div class="d-flex flex-wrap justicy-content-right mt-2">
                                <div class="form-group mb-0 mr-2">
                                    <span>From</span>
                                <label for=""><input type="date" name="from" class="form-control" value="{{request()->get('from')}}"></label>
                                </div>
                                <div class="form-group mb-0 mr-2"> 
                                    <span>To</span>
                                        <label for=""><input type="date" name="to" class="form-control" value="{{request()->get('to')}}"></label> 
                                </div>
                                 <div class="form-group mb-0 mr-2"> 
                                    <span>Published</span>
                                        <label for="">
                                            <select name="is_published" id="isPublishedOnChange" class="form-control select2">
                                                <option value="" aria-readonly="true">Select Is Published</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0"> No</option>
                                            </select>
                                        </label>
                                </div>
                                <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                <a href="javascript:void(0);" id="reset" data-url="{{ route('panel.products.index') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                
                                @if($brand_activation == false)
                                    <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-success mr-2" data-toggle="modal" title="Upload Bulk Price Group" data-target="#BulkPriceGroupUpdateModal"><i class="fa fa-upload" aria-hidden="true"></i></a>
                                @elseif(checkBrandProductCreate(request()->get('id')))
                                    <a href="{{ route('panel.products.create') }}{{'?id='.request()->get('id')}}" class="btn btn-icon btn-sm btn-outline-primary mr-2" title="Add New Product"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                @endif
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#updateQR" class="btn btn-icon btn-sm btn-outline-dark mr-2" title="Upload QR Code"><i class="fa fa-qrcode" aria-hidden="true"></i></a>
                                
                            </div>
                        </div>
                        <div id="ajax-container">
                            @include('panel.products.load')
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
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
                <form action="{{ route('panel.products.update.qr') }}" method="get">
                @csrf
                <input type="hidden" name="brand_id" value="{{ request()->get('id') ?? '0' }}">
                    <div class="form-group" id="productsDropdown">
                        <select name="product_ids[]" class="form-control select2" id="" multiple>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->title }}</option>
                            @endforeach
                        </select> 
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
    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.qrPrintModal').on('click',function(){
                    var id = $(this).data('pid');
                    $('#prouductId').val(id);
                    $('#qrRequestModal').modal('show');
                });
            })

            $('#allProducts').on('click',function(){
                $('#productsDropdown').toggle('');
            });
           
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
            XLSX.writeFile(file, 'ProductFile.' + type);
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
    @endpush
@endsection
