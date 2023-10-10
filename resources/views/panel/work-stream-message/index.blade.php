@extends('backend.layouts.main') 
@section('title', 'Case Workstream Message')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'Case Workstream Message', 'url'=> "javascript:void(0);", 'class' => 'active'],
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
                            <h5>{{ __('Case Workstream Message')}}</h5>
                            <span>{{ __('List of Case Workstream Message')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            <!-- end message area-->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>{{ __('Case Workstream Message')}}</h3>
                        <a href="{{ route('panel.case_work_stream_message.create',$id) }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Case Workstream Message"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                            <table id="workstream_table" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Actions</th>
                                        <th>Author</th>
                                        <th>User</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($caseMessage as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                        {{-- <li class="dropdown-item p-0"><a href="{{  route('panel.case_work_stream_message.show', $item->id) }}" title="View Case Workstream Message" class="btn btn-sm">Show</a></li> --}}
                                                        <li class="dropdown-item p-0"><a href="{{  route('panel.case_work_stream_message.edit', $item->id) }}" title="Edit Case Workstream Message" class="btn btn-sm">Edit</a></li>
                                                        <li class="dropdown-item p-0"><a href="{{  route('panel.case_work_stream_message.delete', $item->id) }}" title="Edit Case Workstream Message" class="btn btn-sm delete-item">Delete</a></li>
                                                      </ul>
                                                </div>
                                            </td>
                                            <td>{{ fetchFirst('App\Models\CaseWorkstream', $item->workstream_id)->author_id  }}</td>
                                            <td>{{ NameById($item->user_id) }}</td>
                                            {{-- <td>@if ($item->status == 0)  
                                                    <span class="badge badge-yellow">Message</span>
                                                @else
                                                    <span class="badge badge-green">Log</span> 
                                                @endif 
                                            </td> --}}
                                            <td>@if ($item->type == 0)Message  @else Log @endif </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
        <script>
            $(document).ready(function() {

                var table = $('#workstream_table').DataTable({
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
    @endpush
@endsection
