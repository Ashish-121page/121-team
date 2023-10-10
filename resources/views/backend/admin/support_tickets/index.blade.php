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
                            {{-- <span>List of Support Tickets</span> --}}
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
                                    @foreach($support_tickets as  $support_ticket)
                                        <tr>
                                            <td class="text-center"> {{  $loop->iteration }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                        <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.support_ticket.show',$support_ticket->id) }}" title="Reply Support Ticket" class="btn btn-sm">Reply</a></li>
                                                        <li class="dropdown-submenu">
                                                            <a  class="dropdown-item" tabindex="-1" href="#">Status</a>
                                                            <ul class="dropdown-menu">
                                                                @foreach (getSupportTicketStatus() as $status)
                                                                    @if ($support_ticket->status != $status['id'])
                                                                        <li class="dropdown-item p-0">
                                                                            <a href="{{ route('panel.constant_management.support_ticket.status',[$support_ticket->id,$status['id']]) }}" title="Update Status" class="btn btn-sm">{{ $status['name'] }}</a>
                                                                        </li>
                                                                    @endif
                                                                @endforeach    
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div> 
                                            </td>
                                            
                                            <td><a class="btn btn-link" href="{{ route('panel.constant_management.support_ticket.show',$support_ticket->id) }}" >{{fetchFirst('App\User',$support_ticket->user_id,'name','--')}}</a></td>
                                             <td>{{$support_ticket->message }}</td>
                                             <td>
                                                <span class="badge badge-{{getSupportTicketStatus($support_ticket->status)['color'] ?? 'primary'}}">
                                                    {{getSupportTicketStatus($support_ticket->status)['name'] ?? 'Not Defined'}}
                                                </span> 
                                            </td>
                                            <td>{{$support_ticket->subject }}</td>
                                            <td>{{$support_ticket->reply ?? '--' }}</td>
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

    <div class="modal" id="RaiseTicketModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Raise a new Ticket</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{route('panel.constant_management.support_ticket.reply')}}" method="post">
                @csrf
                <input type="hidden" name="id" id="Id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fname">Your Reply:</label>
                    <textarea name="reply" class="form-control" id="reply" cols="30" rows="7" placeholder="Please Enter Your Reply..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </div>   
            </form>
          </div>
        </div>
    </div>
@endsection

    <!-- push external js -->
    @push('script')
        <script>
            $('.reply').click(function(){
                $('#Id').val($(this).data('id'));
                $('#RaiseTicketModal').modal('show');
            })
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
                    // dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    // buttons: [
                    //     {
                    //         extend: 'excel',
                    //         className: 'btn-sm btn-success',
                    //         header: true,
                    //         footer: true,
                    //         exportOptions: {
                    //             columns: ':visible',
                    //         }
                    //     },
                    //     'colvis',
                    //     {
                    //         extend: 'print',
                    //         className: 'btn-sm btn-primary',
                    //         header: true,
                    //         footer: false,
                    //         orientation: 'landscape',
                    //         exportOptions: {
                    //             columns: ':visible',
                    //             stripHtml: false
                    //         }
                    //     }
                    // ]

                });
            });
        </script>
    @endpush


    