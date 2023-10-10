@extends('backend.layouts.main') 
@section('title', 'Location')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'Manage', 'url'=> "javascript:void(0);", 'class' => ''],
        ['name'=>'Location', 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
    @endphp

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Location')}}</h5>
                            {{-- <span>{{ __('List of Countries')}}</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>{{ __('Location')}}</h3>
                       
                    {{-- <form action="{{ route('panel.constant_management.location.country')}}" method="GET" class="d-flex justicy-content-right">
                        <div class="form-group mb-0 mr-2">
                            <span>From</span>
                            <label for=""><input type="date" name="from" class="form-control" value="{{request()->get('from')}}"></label>
                        </div>
                        <div class="form-group mb-0 mr-2"> 
                            <span>To</span>
                            <label for=""><input type="date" name="to" class="form-control" value="{{ request()->get('to')}}"></label> 
                        </div>
                            
                        <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                        <a href="{{ route('panel.constant_management.location.country') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                    </form> --}}
                    <a href="{{ route('panel.constant_management.location.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Filter"><i class="fa fa-plus" aria-hidden="true"></i></a>
                </div>
        {{-- 
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>{{ __('Article')}}</h3>
                        <a href="{{ route('panel.constant_management.article.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Article"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div> --}}
                    <div class="card-body">
                        <div id="ajax-container">
                            @include('backend.constant-management.location.loads.country')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
           
           function html_table_to_excel(type)
            {
                var table_core = $("#user_table").clone();
                var clonedTable = $("#user_table").clone();
                clonedTable.find('[class*="no-export"]').remove();
                clonedTable.find('[class*="d-none"]').remove();
                $("#user_table").html(clonedTable.html());
                // console.log(clonedTable.html());
                var data = document.getElementById('user_table');

                var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
                XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
                XLSX.writeFile(file, 'UserFile.' + type);
                $("#user_table").html(table_core.html());
            }

            $(document).on('click','#export_button',function(){
                html_table_to_excel('xlsx');
            });
            $('#reset').click(function(){
                getData("{{ route('panel.constant_management.location.country') }}");
                window.history.pushState("", "", "{{ route('panel.constant_management.location.country') }}");
                $('#TableForm').trigger("reset");
                $('#lead_type_id').select2('val',"");           // if you use any select2 in filtering uncomment this code
                $('#lead_type_id').trigger('change');           // if you use any select2 in filtering uncomment this code
            });

            $('#getDataByRole').change(function(){
                if(checkUrlParameter('role')){
                    url = updateURLParam('role', $(this).val());
                }else{
                    url =  updateURLParam('role', $(this).val());
                }
                getData(url);
            });
   
    </script>
    @endpush
@endsection
