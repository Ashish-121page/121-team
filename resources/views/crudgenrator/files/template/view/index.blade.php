{{ $data['atsign'] }}extends('backend.layouts.main') 
{{ $data['atsign'] }}section('title', '{{ $indexheading }}')
{{ $data['atsign'] }}section('content')
{{ $data['atsign'] }}php
/**
 * {{ $heading }} 
 *

 *
 * @ref zCURD
 * @author  GRPL
 * @license 121.page
 * @version <GRPL 1.1.0>
 * @link    https://121.page/
 */
    $breadcrumb_arr = [
        ['name'=>'{{ $indexheading }}', 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
    {{ $data['atsign'] }}endphp
    <!-- push external head elements to head -->
    {{ $data['atsign'] }}push('head')
    {{ $data['atsign'] }}endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ $indexheading }}</h5>
                            <span>{{ __('List of ')}}{{ $indexheading }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    {{ $data['atsign'] }}include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        
        <form action="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'].$data['name']}}.index') }}" method="GET" id="TableForm">
            <div class="row">
                <!-- start message area-->
                <!-- end message area-->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3>{{ $indexheading }}</h3>
                            <div class="d-flex justicy-content-right">
                                <div class="form-group mb-0 mr-2">
                                    <span>From</span>
                                <label for=""><input type="date" name="from" class="form-control" value="{{ $data['curlstart'] }}request()->get('from')}}"></label>
                                </div>
                                <div class="form-group mb-0 mr-2"> 
                                    <span>To</span>
                                        <label for=""><input type="date" name="to" class="form-control" value="{{ $data['curlstart'] }}request()->get('to')}}"></label> 
                                </div>
                                <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                <a href="javascript:void(0);" id="reset" data-url="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'].$data['name']}}.index') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                <a href="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'].$data['name']}}.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New {{ $heading }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div id="ajax-container">
                            {{ $data['atsign'] }}include('{{ $data['dotviewpath'] }}{{ $data['name'] }}.load')
                        </div>
                    </div>
                </div>
            </div>
        <form>
    </div>
    <!-- push external js -->
    {{ $data['atsign'] }}push('script')
    <script src="{{ $data['curlstart'] }} asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        <{{ $data['script'] }}>
           
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
            XLSX.writeFile(file, '{{ $data['model'] }}File.' + type);
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

       
        </{{ $data['script'] }}>
    {{ $data['atsign'] }}endpush
{{ $data['atsign'] }}endsection
