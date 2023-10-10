@extends('backend.layouts.main') 
@section('title', 'Case Workstream')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'Case Workstream', 'url'=> "javascript:void(0);", 'class' => 'active'],
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
                            <h5>{{ __('Case Workstream')}}</h5>
                            <span>{{ __('List of Case Workstream')}}</span>
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
                        <h3>{{ __('Case Workstream')}}</h3>
                        @if (authRole() != "Counselor")
                            <a href="{{ route('panel.case_work_stream.create', $id) }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Case Workstream"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        @endif
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                            <table id="workstream_table" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Actions</th>
                                        <th>Name</th>
                                        <th>Author Name</th>
                                        <th>Case</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Created At</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($workStream as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                        <li class="dropdown-item p-0"><a href="{{  route('panel.case_work_stream.show', $item->id) }}" title="View Case Workstream" class="btn btn-sm">View</a></li>
                                                        <li class="dropdown-item p-0"><a href="{{  route('panel.case_work_stream_participant.index', $item->id) }}" title="View Case Participant" class="btn btn-sm">Participant</a></li>
                                                        <li class="dropdown-item p-0"><a href="{{  route('panel.case_work_stream_attachment.index',$item->id) }}" title="View Case Attachment" class="btn btn-sm">Attachment</a></li>
                                                        <li class="dropdown-item p-0"><a href="{{  route('panel.case_work_stream.edit', $item->id) }}" title="Edit Case Workstream" class="btn btn-sm">Edit</a></li>
                                                        <li class="dropdown-item p-0"><a href="{{  route('panel.case_work_stream.delete', $item->id) }}" title="Edit Case Workstream" class="btn btn-sm delete-item">Delete</a></li>
                                                      </ul>
                                                </div>
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ NameById($item->author_id) }}</td>
                                            <td></td>
                                            {{-- <td>@if ($item->status == 0)  
                                                    <span class="badge badge-yellow">Unpublished</span>
                                                @else
                                                    <span class="badge badge-green">Published</span> 
                                                @endif 
                                            </td> --}}
                                            <td>{{ getFormattedDateTime($item->created_at) }}</td>
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
