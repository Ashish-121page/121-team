@extends('backend.layouts.main') 
@section('title', 'Case Workstream Participant')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'Case Workstream Participant', 'url'=> "javascript:void(0);", 'class' => 'active'],
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
                            <h5>{{ __('Case Workstream Participant')}}</h5>
                            <span>{{ __('List of Case Workstream Participant')}}</span>
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
                        <h3>{{ __('Case Workstream Participant')}}</h3>
                        <a href="{{ route('panel.case_work_stream_participant.create', $id) }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Case Workstream Participant"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                            <table id="workstream_table" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Actions</th>
                                        <th>User</th>
                                        <th>Status</th>
                                        <th>Chat Visible</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workStreamPart as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                        {{-- <li class="dropdown-item p-0"><a href="{{  route('panel.case_work_stream_participant.show', $item->id) }}" title="View Case Workstream Participant" class="btn btn-sm">Show</a></li> --}}
                                                        <li class="dropdown-item p-0"><a href="{{  route('panel.case_work_stream_participant.edit', $item->id) }}" title="Edit Case Workstream Participant" class="btn btn-sm">Edit</a></li>
                                                        <li class="dropdown-item p-0"><a href="{{  route('panel.case_work_stream_participant.delete', $item->id) }}" title="Edit Case Workstream Participant" class="btn btn-sm delete-item">Delete</a></li>
                                                      </ul>
                                                </div>
                                            </td>
                                            {{-- <td>{{ NameById(fetchFirst('App\Models\CaseWorkstream', $item->workstream_id)->author_id)  }}</td> --}}
                                            <td>{{ NameById($item->user_id) }}</td>
                                            <td>@if ($item->status == 0)  
                                                    <span class="badge text-white badge-yellow">Inactive</span>
                                                @else
                                                    <span class="badge text-white badge-green">Active</span> 
                                                @endif 
                                            </td>
                                            <td>@if ($item->is_chat_visible == 0)  
                                                    <span class="badge text-white badge-yellow">No</span>
                                                @else
                                                    <span class="badge text-white badge-green">Yes</span> 
                                                @endif 
                                            </td>
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
