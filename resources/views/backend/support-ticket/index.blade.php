@extends('backend.layouts.main') 
@section('title', 'Customer Support')
@section('content')
<style>
    .remove-ik-class{
        -webkit-box-shadow: unset !important;
        box-shadow: unset !important;
    }
</style>
    @php
    $breadcrumb_arr = [
        ['name'=>'Manage', 'url'=> "javascript:void(0);", 'class' => ''],
        ['name'=>'Support Ticket', 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
    @endphp

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-flex">
                            <h5>{{ __('Support Ticket')}}</h5>
                                @if(AuthRole() == 'User')
                                    <span style="margin-top: -10px;">
                                        <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                                    </span>
                                @endif
                            </div>
                            {{-- <span>{{ __('List of Support Ticket')}}</span> --}}
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        @if(AuthRole() !='User')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3>{{ __('Support Ticket')}}</h3>
                            <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#raiseTicketModal">Raise a ticket</a>
                        
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="supportTicketTable" class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                            <th>Reply</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($supports->count() > 0)
                                            @foreach ($supports as $index => $support)
                                                @php
                                                    $reply_exist = App\Models\SupportTicket::whereUserId(auth()->id())
                                                        ->whereReply($support->reply)
                                                        ->first();
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $support->subject }}</td>
                                                    <td>{{ Str::limit($support->message, 50) }}</td>
                                                    <td>{{ $support->created_at->format('d M Y') }}</td>
                                                    <td>{{ $support->reply ?? '--' }}</td>
                                                    <td>
                                                        @if($support->status == 0)
                                                            <span class="badge badge-secondary">Pending</span>
                                                        @elseif($support->status== 2)
                                                            <span class="badge badge-danger">Rejected</span>
                                                        @else
                                                            <span class="badge badge-success">Resolved</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <div class="mx-auto">
                                                <span >No Support Tickets Yet!</span>
                                            </div>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>{{ __('Support Ticket')}}</h3>
                        <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#raiseTicketModal">Raise a ticket</a>
                    </div>
                    <div class="card-body bg-white">
                        <div class="row mt-3">
                            @if($supports->count() > 0)
                                @foreach($supports as $index => $support)
                                    @php
                                        $reply_exist = App\Models\SupportTicket::whereUserId(auth()->id())
                                        ->whereReply($support->reply)
                                        ->first();
                                    @endphp
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                    <div class="profile-pic mb-20">
                                                        <div class="row">
                                                            <div class="col-12 pt-2 text-left">
                                                                <span class="badge badge-{{getSupportTicketStatus($support->status)['color']}}">{{getSupportTicketStatus($support->status)['name']}}</span>
                                                            
                                                                <h6 class="mt-3"><a href="{{route('customer.ticket.show', $support->id)}}"> {{ $support->subject }}</a></h6>
                                                                <p>{{ Str::limit($support->message, 100) }}</p>
                                                                <span><i class="ik mr-1 ik-clock"></i>{{ $support->created_at->format('d M Y') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="mx-auto">
                                    <span class="mx-auto">No Support Ticket yet!</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @include('backend.brand.include.modal.raise-ticket')
    <!-- push external js -->
    @push('script')
        <script>
            $(document).ready(function() {
                var table = $('#supportTicketTable').DataTable({
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
                        {
                            extend: 'colvis',
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
