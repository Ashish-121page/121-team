@extends('backend.layouts.main') 
@section('title', 'Access Codes')
@section('content')
@php
/**
 * Access Code 
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
        ['name'=>'Access Codes', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                            <h5>Access Codes</h5>
                            {{-- <span>List of Access Codes</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        
        <form action="{{ route('panel.access_codes.index') }}" method="GET" id="TableForm">
            <div class="row">
                <!-- start message area-->
                <!-- end message area-->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex flex-wrap justify-content-between">
                            <div class="col flex-grow-1">
                                <h3>Access Codes</h3>
                            </div>
                            <div class="d-flex flex-wrap justify-content-right">
                                <div class="form-group mb-0 mr-2 mt-3 mt-lg-0">
                                    <span>From</span>
                                <label for=""><input type="date" name="from" class="form-control" value="{{request()->get('from')}}"></label>
                                </div>
                                <div class="form-group mb-0 mr-2"> 
                                    <span>To</span>
                                        <label for=""><input type="date" name="to" class="form-control" value="{{request()->get('to')}}"></label> 
                                </div>
                                <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                <a href="javascript:void(0);" id="reset" data-url="{{ route('panel.access_codes.index') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#createCode" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Access Code"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div id="ajax-container">
                            @include('panel.access_codes.load')
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @include('panel.access_codes.includes.generate-code')
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script>
            function copyTextToClipboard(text) {
                if (!navigator.clipboard) {
                    fallbackCopyTextToClipboard(text);
                    return;
                }
                navigator.clipboard.writeText(text).then(function() {
                }, function(err) {
                });
                $.toast({
                    heading: 'SUCCESS',
                    text: "Access Code copied successfully!",
                    showHideTransition: 'slide',
                    icon: 'success',
                    loaderBg: '#f96868',
                    position: 'top-right'
                });
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
            XLSX.writeFile(file, 'AccessCodeFile.' + type);
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
            //   $('#fieldId').select2('val',""); // if you use any select2 in filtering uncomment this code
           // $('#fieldId').trigger('change');// if you use any select2 in filtering uncomment this code
        });

    $(document).on('click','.create-code',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var msg = $(this).data('msg') ?? "Make New Access Code!";
        $.confirm({
            draggable: true,
            title: 'Are You Sure!',
            content: msg,
            type: 'info',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Confirm',
                    btnClass: 'btn-info',
                    action: function(){
                            window.location.href = url;
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
