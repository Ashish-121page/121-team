@extends('backend.layouts.main') 
@section('title', 'Ticket Conversation')
@section('content')
@push('head')
<script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    
@endpush
    @php
    $breadcrumb_arr = [
        ['name'=>'Constant Management', 'url'=> "javascript:void(0);", 'class' => ''],
        ['name'=>'Ticket Conversation', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                            <h5>{{ __('Ticket Conversations')}}</h5>
                            <span>{{ __('List of Ticket Conversations')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb')")
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            @include('backend.include.message')
            <!-- end message area-->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>{{ __('Ticket Conversations')}}</h3>
                        <a href="{{ route('panel.admin.ticket_conversation.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Smstemplate"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                    <div class="card-body">
                        <table id="ticket_conver_table" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Actions</th>
                                    <th>Ticket</th>
                                    <th>User</th>
                                    <th>Comment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ticket_conver as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                    <li class="dropdown-item p-0"><a href="{{ route('panel.admin.ticket_conversation.show', $item->id) }}" title="View Ticket Conversation" class="btn btn-sm">Show</a></li>
                                                    <li class="dropdown-item p-0"><a href="{{ route('panel.admin.ticket_conversation.edit', $item->id) }}" title="Edit Ticket Conversation" class="btn btn-sm">Edit</a></li>
                                                    <li class="dropdown-item p-0"><a href="{{ route('panel.admin.ticket_conversation.delete', $item->id) }}" title="Edit Ticket Conversation" class="btn btn-sm delete-item">Delete</a></li>
                                                  </ul>
                                            </div>
                                            {{-- <a href="{{ route('panel.admin.ticket_conversation.show', $item->id) }}" title="View Ticket Conversation" class="btn btn-outline-info btn-icon btn-sm"><i class="ik ik-eye" aria-hidden="true"></i></a>
                                            <a href="{{ route('panel.admin.ticket_conversation.edit', $item->id) }}" title="Edit Ticket Conversation" class="btn btn-outline-warning btn-icon btn-sm"><i class="ik ik-edit" aria-hidden="true"></i></a>
                                            <a href="{{ route('panel.admin.ticket_conversation.delete', $item->id) }}" title="Edit Ticket Conversation" class="btn btn-outline-danger btn-icon btn-sm delete-item"><i class="ik ik-trash" aria-hidden="true"></i></a> --}}
                                        </td>
                                        <td>{{ $item->ticket_id }}</td>
                                        <td>{{ $item->user_id }}</td>
                                        <td>{{ $item->comment }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
        <script>
            $(document).ready(function() {

                var table = $('#ticket_conver_table').DataTable({
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
                        'colvis',
                        {
                            extend: 'copy',
                            className: 'btn-sm btn-info',
                            header: false,
                            footer: true,
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'csv',
                            className: 'btn-sm btn-success',
                            header: false,
                            footer: true,
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'excel',
                            className: 'btn-sm btn-warning',
                            header: true,
                            footer: true,
                            exportOptions: {
                                columns: ':visible',
                            }
                        },
                        {
                            extend: 'pdf',
                            className: 'btn-sm btn-primary',
                            header: false,
                            footer: true,
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'print',
                            className: 'btn-sm btn-default',
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
