@extends('backend.layouts.main') 
@section('title', 'State')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=> fetchFirst('App\Models\Country',request()->get('country'),'name','') , 'url'=> route('panel.constant_management.location.country'), 'class' => ''],
        ['name'=>'State', 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
    @endphp

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('State')}}</h5>
                            {{-- <span>{{ __('List of States')}} @if(request()->get('country'))of {{ fetchFirst('App\Models\Country',request()->get('country'),'name','') }} @endif</span> --}}
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
                        <h3>{{ __('State')}}</h3>
                    <a href="javasript:void(0);" data-toggle="modal" data-target="#AddStateModal" class="btn btn-icon btn-sm btn-outline-primary" title="Filter"><i class="fa fa-plus" aria-hidden="true"></i></a>
                </div>
                    <div class="card-body">
                        <div id="ajax-container">
                            @include('backend.constant-management.location.loads.state')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="AddStateModal" tabindex="-1" role="dialog" aria-labelledby="AddStateModalTitle"
    aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('panel.constant_management.location.state.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="country_id" value="{{ request()->get('country') }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"> Add State</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">State Name*</label>
                            <input required type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter State Name"id="">
                        </div>
                        <div class="form-group">
                            <label for="">State Code*</label>
                            <input required type="text" name="iso2" class="form-control" value="{{ old('iso2') }}" placeholder="Enter State Code"id="">
                        </div>
                        <div class="form-group">
                            <label for="">Fips Code</label>
                            <input  type="text" name="fips_code" class="form-control" value="{{ old('fips_code') }}" placeholder="Enter Fips Code"id="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="EditStateModal" tabindex="-1" role="dialog" aria-labelledby="EditStateModalTitle"
    aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('panel.constant_management.location.state.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="Id">
                    <input type="hidden" name="country_id" value="{{ request()->get('country') }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"> Edit State</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">State Name*</label>
                            <input required type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter State Name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="">State Code*</label>
                            <input required type="text" name="iso2" class="form-control" value="{{ old('iso2') }}" placeholder="Enter State Code" id="iso2">
                        </div>
                        <div class="form-group">
                            <label for="">Fips Code</label>
                            <input  type="text" name="fips_code" class="form-control" value="{{ old('fips_code') }}" placeholder="Enter Fips Code" id="fips_code">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
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
                getData("{{ route('panel.constant_management.location.state') }}");
                window.history.pushState("", "", "{{ route('panel.constant_management.location.state') }}");
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
