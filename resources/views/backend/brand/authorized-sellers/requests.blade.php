@extends('backend.layouts.main') 
@section('title', 'Support Tickets')

@php
    $breadcrumb_arr = [
        ['name'=>'Support Tickets', 'url'=> "javascript:void(0);", 'class' => 'active']
        ]
@endphp
  
@section('content')
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>Support Tickets</h5>
                            <span>List of Support Tickets</span>
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Support Tickets</h3>
                        <div>
                            <select name="status" class="form-control" id="ticketStatus">
                                <option value="" aria-readonly="true">Select Status</option>
                                @foreach (getSupportTicketStatus() as $status)
                                    <option value="{{ $status['id'] }}">{{ $status['name'] }}</option>                                
                                @endforeach
                            </select>
                        </div>
                        {{-- <a href="{{ route('backend.support_tickets.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Support Ticket"><i class="fa fa-plus" aria-hidden="true"></i></a> --}}
                    </div>
                    <div class="card-body">                        
                        <div class="table-responsive">
                            <table id="table" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Actions</th>                                            
                                        <th>User Name</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Subject</th>
                                        <th>Reply</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    \
@endsection

    <!-- push external js -->
    @push('script')
        <script>
            $(document).ready(function() {
                $('#ticketStatus').on('change',function(){
                    var status = $(this).val();
                    url = "{{ url('backend/support-tickets/index/') }}";
                    window.location.href = url+'?status='+status;
                });
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
    @endpush

