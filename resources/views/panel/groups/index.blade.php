@extends('backend.layouts.main') 
@section('title', 'Groups')
@section('content')
<style>
    .remove-ik-class{
        -webkit-box-shadow: unset !important;
        box-shadow: unset !important;
    }
</style>
@php
/**
 * Group 
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
        ['name'=>'Groups', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                            <h5>Groups</h5>
                            @if(AuthRole() == 'User')
                                <span style="margin-top: -10px;">
                                    <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                                </span>
                            @endif
                        </div>
                        {{-- <span>List of Groups</span> --}}
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        
        <form action="{{ route('panel.groups.index') }}" method="GET" id="TableForm">
            <div class="row">
                <!-- start message area-->
                <!-- end message area-->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex flex-wrap justify-content-between">
                            <div class="col flex-grow-1">
                                <h3 class="p-0">Groups</h3>
                            </div>
                            <div class="d-flex flex-wrap justicy-content-right">
                                <div class="form-group mb-0 mr-2 mt-3 mt-lg-0">
                                    <span>From</span>
                                <label for=""><input type="date" name="from" class="form-control" value="{{request()->get('from')}}"></label>
                                </div>
                                <div class="form-group mb-0 mr-2"> 
                                    <span>To</span>
                                        <label for=""><input type="date" name="to" class="form-control" value="{{request()->get('to')}}"></label> 
                                </div>
                                <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                <a href="javascript:void(0);" id="reset" data-url="{{ route('panel.groups.index') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                <a href="{{ route('panel.groups.create',['user='.request()->get('user')]) }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Group"><i class="fa fa-plus" aria-hidden="true"></i></a>

                                <a href="javascript:void(0);" class="btn btn-icon btn-sm btn-outline-success ml-2" data-toggle="modal" title="Upload Bulk Price Group" data-target="#BulkPriceGroupUpdateModal"><i class="fa fa-upload" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div id="ajax-container">
                            @include('panel.groups.load')
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @include('panel.groups.barcode-modal');
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
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script src="{{ asset('backend/js/html2canvas.js') }}"></script>
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
            XLSX.writeFile(file, 'GroupFile.' + type);
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

        $('#reset').click(function(){
            var url = $(this).data('url');
            getData(url);
            window.history.pushState("", "", url);
            $('#TableForm').trigger("reset");
            //   $('#fieldId').select2('val',"");               // if you use any select2 in filtering uncomment this code
           // $('#fieldId').trigger('change');                  // if you use any select2 in filtering uncomment this code
        });

        $('.barCodeModalBtn').click(function(){
            var gId = $(this).data('g_id');
            var groupName = $(this).data('group_name');
            var code_data = $('#barcode-'+gId).html();
            $('#barcode_emb').html(code_data);
            $('#user_shop_name').html($(this).data('name'));
            $('#email').html($(this).data('email'));
            $('#phone').html($(this).data('phone'));
            $('#groupName').html(groupName);
            $('#barCodeModal').modal('show');
        });

            var element = $(".barcode_emb"); // global variable
            var getCanvas; // global variable

            $("#download-qr").on('click', function () {
                var group_name = $('#groupName').html();
                html2canvas(document.getElementById("download-qr-div")).then(function (canvas) {		
                    var anchorTag = document.createElement("a");
                    document.body.appendChild(anchorTag);
                    var user_mob = "{{ auth()->user()->phone }}";

                    anchorTag.download = "GroupQR_"+group_name+'_'+user_mob+'.jpg';
                    anchorTag.href = canvas.toDataURL();
                    anchorTag.click();
                });
            });
        </script>
    @endpush
@endsection
