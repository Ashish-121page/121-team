@extends('backend.layouts.main') 
@section('title', 'Inventory')
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
        ['name'=>'Inventory', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                                    {{ 'Inventory Products' }}
                                @endif
                            </h5>
                            @if(AuthRole() == 'User')
                                <span style="margin-top: -10px;">
                                    <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="Update and Manage Inventory"></i>
                                </span>
                            @endif
                        </div>
                        {{-- <span>List of Inventory Products</span> --}}
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        
        <form action="{{ route('panel.products.index') }}" method="GET" id="TableForm">
            <div class="row">
                <!-- start message area-->
                <!-- end message area-->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3>
                                @if($brand_activation)
                                    {{$brand->name}}
                                @else 
                                    {{ 'Inventory Products' }}
                                @endif    
                            </h3>
                            <div class="">
                                <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-success mr-2" data-toggle="modal" data-target="#BulkStockQtyUpdateModal"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                
                                <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-primary mr-2" data-toggle="modal" data-target="#bulkdeliveryupdate"><i class="fa fa-truck" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div id="ajax-container">
                            @include('panel.inventory.load')
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- item models --}}
    {{-- @if ($products->count() > 0)
        @foreach ($products as $product)
            @include("panel.inventory.include.inventory-product-edit",[$product->id])
        @endforeach
    @endif --}}
   
    <div class="modal fade" id="BulkStockQtyUpdateModal" role="dialog" aria-labelledby="addProductTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="addProductTitle">Bulk Product Stock Update</h5>
            <div class="ml-auto">
                <a href="{{ route('panel.product.inventoryExport') }}" class="btn btn-link"><i class="fa fa-download"></i> Export Inventory Stock</a>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.inventory.group.bulk-update') }}" method="post" enctype="multipart/form-data">
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

    @include('panel.inventory.include.delivery');



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
                var active_p_id = null;
                $('.inventoryEditbtn').on('click',function(){
                    var active_p_id = $(this).data('id');
                    $('#inventoryProductEdit-'+active_p_id).modal('show');
                });
            });

            function submitInventory(temp_active_p_id){
                $('#inventoryStoreForm-'+temp_active_p_id).submit();
            }
           
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
