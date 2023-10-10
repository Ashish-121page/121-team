@extends('backend.layouts.main') 
@section('title', 'Micro Site')
@section('content')
@php
/**
 * User Shop 
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
        ['name'=>'Micro Sites', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                        <div class="d-inline">
                            <h5>Micro Sites</h5>
                            {{-- <span>List of Micro Sites</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        
        <form action="{{ route('panel.user_shops.index') }}" method="GET" id="TableForm">
            <div class="row">
                <!-- start message area-->
                <!-- end message area-->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex flex-wrap justify-content-between">
                            <div class="flex-grow-1 col d-flex">
                                <h3 class="p-0">Micro Sites</h3>
                                {{-- <button id="getqr" class="btn btn-primary mx-3" type="button">Get QR</button> --}}
                            </div>
                            

                            <div class="d-flex justicy-content-right flex-wrap mt-3 mt-lg-0">
                                <div class="form-group mb-0 mr-2">
                                    <span>From</span>
                                <input type="date" name="from" class="form-control" value="{{request()->get('from')}}">
                                </div>
                                <div class="form-group mb-0 mr-2"> 
                                    <span>To</span>
                                        <input type="date" name="to" class="form-control" value="{{request()->get('to')}}"> 
                                </div>

                                <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning mt-3 mt-lg-0" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                <a href="javascript:void(0);" id="reset" data-url="{{ route('panel.user_shops.index') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2 mt-3 mt-lg-0" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>

                                <a href="javascript:void(0);" id="getqr" class="btn btn-icon btn-sm btn-outline-info mr-2 mt-3 mt-lg-0" title="Get QR Of Micro Site"><i class="fa fa-qrcode" aria-hidden="true"></i></a>

                                {{-- <a href="{{ route('panel.user_shops.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Micro Site"><i class="fa fa-plus" aria-hidden="true"></i></a> --}}
                            </div>
                        </div>
                        <div id="ajax-container">
                            @include('panel.user_shops.load')
                        </div>
                    </div>
                </div>
            </div>
        <form>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('backend/js/index-page.js') }}"></script>
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
            XLSX.writeFile(file, 'UserShopFile.' + type);
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

        $("#getqr").click(function (e) { 
            e.preventDefault();
            var a = document.querySelectorAll("#needqr");
            let arr = [];
            a.forEach(element => {
                if (element.checked == true) {
                    arr.push(element.value);
                    // console.log(element.value);
                }
            });
            // console.log(JSON.stringify(arr));
            let ashu = JSON.stringify(arr);
            let link ="user-shops/printqr?qr="+ashu;  

            window.open(link,'_blank')
            
        });

        // Select All QR Code
        $("#getall").click(function (e) { 
            e.preventDefault();
            var a = document.querySelectorAll("#needqr");
            a.forEach(element => {
                element.checked = true;
            });
            // $("#getqr").click()

            
        });

       
        </script>
    @endpush
@endsection
