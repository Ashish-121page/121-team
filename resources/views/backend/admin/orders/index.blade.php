@extends('backend.layouts.main') 
@section('title', 'Orders')
@section('content')
<style>
    .remove-ik-class{
        -webkit-box-shadow: unset !important;
        box-shadow: unset !important;
    }
</style>
@php
/**
 * Order 
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
        ['name'=>'Orders', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                            <h5>Orders</h5>
                                @if(AuthRole() == 'User')
                                    <span style="margin-top: -10px;">
                                        <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                                    </span>
                                @endif
                        </div>
                        {{-- <span>List of Orders</span> --}}
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        
        <form action="{{ route('panel.orders.index') }}" method="GET" id="TableForm">
            <div class="row">
                <!-- start message area-->
                <!-- end message area-->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex no-gutters flex-wrap align-items-center justify-content-between">

                            <div class="col flex-grow-1">
                                <h3 class="p-0">Orders</h3>
                            </div>
                            <div class="col-6 col-lg">
                                <div class="form-group mb-0">
                                    <select name="status" id="status" class="form-control select2">
                                        <option value="" readonly>Select Status</option>
                                        @foreach (orderStatus() as $item)
                                        <option value="{{ $item['id'] }}" @if (request()->get('status') == $item['id']) selected @endif>{{ $item['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-lg mt-3 mt-lg-0">
                                <div class="form-group d-flex flex-wrap flex-lg-nowrap align-items-center mb-0 pl-lg-3">
                                    <span>From</span>
                                    <input type="date" name="from" class="form-control" value="{{request()->get('from')}}">
                                </div>
                            </div>
                            <div class="col-6 col-lg mt-3 mt-lg-0">
                                <div class="form-group d-flex flex-wrap flex-lg-nowrap align-items-center mb-0 pl-lg-3"> 
                                    <span>To</span>
                                    <input type="date" name="to" class="form-control" value="{{request()->get('to')}}">
                                </div>
                            </div>
                            <div>
                                <div class="d-flex mt-3 mt-lg-0 pl-lg-3">
                                    <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                    <a href="javascript:void(0);" id="reset" data-url="{{ route('panel.orders.index') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        <div id="ajax-container">
                            @include('backend.admin.orders.load')
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="orderRequest" role="dialog" aria-labelledby="orderRequestTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderRequestTitle">Resubmit Correct Transaction Details</h5>
                    <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close"
                        style="padding: 0px 20px;font-size: 20px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('panel.orders.status')}}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="order_id" value="" id="OrderId">
                        <input type="hidden" name="status" value="7">
                        @csrf
                        <div class="row">
                            <div class="row" id="new-address">
                                <div class="col-sm-12">
                                    <label for="transaction_id" class="form-label">Transaction ID <span class="text-danger">*</span></label>
                                    <input type="text" name="transaction_id" class="form-control" id="transaction_id" placeholder="Enter Transaction Id" value="" required>
                                </div>
                                <div class="col-sm-12 mt-2">
                                    <label for="transaction_file" class="form-label">Transaction Proof <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="transaction_file" name="transaction_file" placeholder="First Name" value="" required>
                                </div>
                            </div>
                            <div class="col-12 text-right mt-4">
                                <button type="submit" class="btn btn-outline-primary">Submit Appeal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="http://localhost/projects/zstarter/public_html/backend/js/index-page.js"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        <script>
      $('.appeal').click(function(){
        $('#OrderId').val($(this).data('id'));
        $('#orderRequest').modal('show');
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
            XLSX.writeFile(file, 'OrderFile.' + type);
            $("#table").html(table_core.html());
            
        }

        $(document).on('click','#export_button',function(){
            html_table_to_excel('xlsx');
        })
       
     
        $(document).on('click','.asc',function(){
            var val = $(this).data('val');
            if(checkUrlParameter('asc')){
            url = updateURLParam('asc', val);
            }else{
            url =  updateURLParam('asc', val);
            }
            getData(url);
        });
        $(document).on('click','.desc',function(){
            var val = $(this).data('val');
            if(checkUrlParameter('desc')){
            url = updateURLParam('desc', val);
            }else{
            url =  updateURLParam('desc', val);
            }
            getData(url);
        });

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
