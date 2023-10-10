

@extends('backend.layouts.main') 
@section('title', 'Lead')
@section('content')

@push('head')
    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <style>
        .select2-selection.select2-selection--single{
            width: 100px !important;
        }
    </style>
@endpush
    @php
    $breadcrumb_arr = [
        ['name'=>'Manage', 'url'=> "javascript:void(0);", 'class' => ''],
        ['name'=>'Leads', 'url'=> "{{ javascript:void(0); }}", 'class' => 'active']
    ]
    @endphp
     

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Leads')}}</h5>
                            <span>{{ __('List of Leads')}}</span>
                            
                        </div>
                     </div>
                   <div class="div"></div>
                </div>
                
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>

        
        <form action="{{ route('panel.admin.lead.index') }}" method="GET" id="TableForm">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3>{{ __('Leads')}}</h3>
                            <div class="d-flex justicy-content-right">
                                <div class="form-group mb-0 mr-2">
                                    <span>From</span>
                                <label for=""><input type="date" name="from" class="form-control" value="{{request()->get('from')}}"></label>
                                </div>
                                <div class="form-group mb-0 mr-2"> 
                                    <span>To</span>
                                        <label for=""><input type="date" name="to" class="form-control" value="{{ request()->get('to')}}"></label> 
                                </div>
                                <div class="form-group mb-0 mr-2">
                                    <select id="lead_type_id" name="lead_type_id" class="select2 form-control course-filter">
                                        <option readonly value="">{{ __('Type') }}</option>
                                        @foreach (fetchGet('App\Models\Category', 'where', 'category_type_id', '=', 4) as $item)
                                        {{-- <option value="{{ $item->id }}">{{ $item->name }}</option>  --}}
                                        <option value="{{ $item->id }}" {{ $item->id == request()->get('lead_type_id') ? 'selected': ''}}>{{ $item->name }}</option> 
                                        
                                    @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                <a href="javascript:void(0)" id="reset" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                {{-- <a href="javascript:void(0)"  </a> --}}
                                <a href="{{ route('panel.admin.lead.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Filter"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        <div id="ajax-container">
                            @include('backend.admin.manage.lead.load')
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- push external js -->
    @push('script')
        <script src="{{ asset('backend/js/index-page.js') }}"></script>
        <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        <script>
               
               function html_table_to_excel(type)
                {
                    var table_core = $("#lead_table").clone();
                    var clonedTable = $("#lead_table").clone();
                    clonedTable.find('[class*="no-export"]').remove();
                    clonedTable.find('[class*="d-none"]').remove();
                    $("#lead_table").html(clonedTable.html());
                    // console.log(clonedTable.html());
                    var data = document.getElementById('lead_table');

                    var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
                    XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
                    XLSX.writeFile(file, 'leadFile.' + type);
                    $("#lead_table").html(table_core.html());
                }

                $(document).on('click','#export_button',function(){
                    html_table_to_excel('xlsx');
                });
                $('#reset').click(function(){
                    getData("{{ route('panel.admin.lead.index') }}");
                    window.history.pushState("", "", "{{ route('panel.admin.lead.index') }}");
                    $('#TableForm').trigger("reset");
                    $('#lead_type_id').select2('val',"");           // if you use any select2 in filtering uncomment this code
                    $('#lead_type_id').trigger('change');           // if you use any select2 in filtering uncomment this code
                });


       
        </script>
      
    @endpush
@endsection
