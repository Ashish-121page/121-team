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
        <div class="row">
            <!-- start message area-->
            <!-- end message area-->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>{{ $indexheading }}</h3>
                        <a href="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'].$data['name']}}.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New {{ $heading }}"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                    <div class="card-body">                        
                        <div class="table-responsive">
                            <table id="table" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Actions</th>                                            
                                        @foreach ($data['fields']['name'] as $index => $item)<th>@if($data['fields']['input'][$index] == 'select_via_table'){{ str_replace('Id','',ucwords(str_replace('_',' ',$item))) }} @else{{ ucwords(str_replace('_',' ',$item)) }}@endif</th>
                                        @endforeach

                                    </tr>
                                </thead>
                                <tbody>
                                    {{ $data['atsign'] }}foreach({{ $indexvariable }} as  {{ $variable}})
                                        <tr>
                                            <td class="text-center"> {{ $data['curlstart'] }}  $loop->iteration }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                        <li class="dropdown-item p-0"><a href="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'].$data['name']}}.edit', {{ $variable}}->id) }}" title="Edit {{ $heading }}" class="btn btn-sm">Edit</a></li>
                                                        <li class="dropdown-item p-0"><a href="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'].$data['name']}}.destroy', {{ $variable}}->id) }}" title="Delete {{ $heading }}" class="btn btn-sm delete-item">Delete</a></li>
                                                      </ul>
                                                </div> 
                                            </td>
                                            @foreach ($data['fields']['name'] as $index => $item)@if($data['fields']['input'][$index] == 'select_via_table')    @php
                                                if($data['fields']['table'][$index] == "User"){
                                                    $model_path = "App\\";
                                                }else{
                                                    $model_path = "App\Models\\";
                                                }
                                            @endphp<td>{{ $data['curlstart'] }}fetchFirst('{{ $model_path.$data['fields']['table'][$index]  }}',{{ $variable}}->{{ $item }},'name','--')}}</td>
                                            @elseif($data['fields']['input'][$index] == 'file')<td><a href="{{ $data['curlstart'] }} asset({{ $variable}}->{{ $item }}) }}" target="_blank" class="btn-link">{{ $data['curlstart'] }}{{ $variable}}->{{ $item }} }}</a></td>
                                            @else<td>{{ $data['curlstart'] }}{{ $variable}}->{{ $item }} }}</td>
                                            @endif @endforeach

                                        </tr>
                                    {{ $data['atsign'] }}endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    {{ $data['atsign'] }}push('script')
        <script>
            $(document).ready(function() {

                var table = $('#table').DataTable({
                    responsive: true,
                    fixedColumns: true,
                    fixedHeader: true,
                    scrollX: false,
                    'aoColumnDefs': [{
                        'bSortable': false,
                        'aTargets': ['nosort']
                    }],
                    dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [
                        {
                            extend: 'excel',
                            className: 'btn-sm btn-success',
                            header: true,
                            footer: true,
                            exportOptions: {
                                columns: ':visible',
                            }
                        },
                        'colvis',
                        {
                            extend: 'print',
                            className: 'btn-sm btn-primary',
                            header: true,
                            footer: false,
                            orientation: 'landscape',
                            exportOptions: {
                                columns: ':visible',
                                stripHtml: false
                            }
                        }
                    ]

                });
            });
        </script>
    {{ $data['atsign'] }}endpush
{{ $data['atsign'] }}endsection
