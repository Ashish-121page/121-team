@extends('backend.layouts.main') 
@section('title', 'Support Tickets')

@php
    $breadcrumb_arr = [
        ['name'=>'Support Tickets', 'url'=> "javascript:void(0);", 'class' => 'active']
        ]
@endphp
@section('content')
  <style>
    .chat{
       border: none;
       border-radius: 5px;
       padding: 0.5em;
    }
   .chat-left{
       align-self: flex-start;
       background-color: rgb(244, 244, 244);
    }
   .chat-right{
       text-align: right;
       align-self: flex-end;
       background-color: #eee;
    }
   .address-check{
       position: absolute;
        top: 0;
        right: 5px;
    }
   .scroll {
        max-height: 350px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    /* body::-webkit-scrollbar {
     width: 1em;
    }
    
    body::-webkit-scrollbar-track {
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    }
    
    body::-webkit-scrollbar-thumb {
        background-color: darkgrey;
        outline: 1px solid slategrey;
    } */
    .sticky-bar { 
        position: sticky; 
        top: 80px; 
    }
  </style>
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
            <div class="col-md-12 col-lg-6">
                <div class="card ">
                    <div class="card-header d-flex justify-content-between">
                        <h3>{{getSupportTicketPrefix($support_ticket->id) }} </h3>
                        <div class="d-flex">
                            <div><span class="mr-2 badge badge-{{ getSupportTicketStatus($support_ticket->status)['color'] }}">{{ getSupportTicketStatus($support_ticket->status)['name'] }}</span>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                 
                                    @foreach (getSupportTicketStatus() as $status)
                                        @if ($support_ticket->status != $status['id'])
                                            <li class="dropdown-item p-0">
                                                <a href="{{ route('panel.constant_management.support_ticket.status',[$support_ticket->id,$status['id']]) }}" title="Update Status" class="btn btn-sm">{{ $status['name'] }}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                   
                                        {{-- <li class="dropdown-item p-0">
                                            <a href="{{ route('panel.constant_management.support_ticket.status',[$support_ticket->id,0]) }}" title="Update Status" class="btn btn-sm">Pending</a>
                                        </li> --}}
                                   
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="py-2" style="background-color:rgb(40, 40, 120);">
                        <div class="d-flex justify-content-around">
                            <div class="mr-3" style="font-size:16px; color:aliceblue;"><span style="color: antiquewhite">Customer: </span>{{ NameById($support_ticket->user_id) }}</div>
                            <div class="mr-3" style="font-size:16px; color:aliceblue;"><span style="color: antiquewhite">Created At:</span> {{ getFormattedDate($support_ticket->created_at) }}</div>
                           
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="">
                           {{-- @if($details != null) --}}

                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td>Subject:</td>
                                        <td>{{ $support_ticket->subject ?? "N\A" }}</td>
                                    </tr>
                                    <tr>
                                        <td>Message:</td>
                                        <td>{{ Str::limit($support_ticket->message,70) }}</td>
                                    </tr>
                                </tbody>
                            </table>

                           {{-- @endif --}}
                        </div>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-header">
                        <h3>Attachments</h3>
                    </div>
                    <div class="card-body">
                        <table>
                            <tbody>
                                @forelse ($medias as $media)
                                    <tr>
                                        <td>
                                            <div>
                                                {{ $media->file_name }}
                                            </div>
                                            <small class="text-sm text-muted">{{ getFormattedDateTime($media->created_at) }}</small>
                                        </td>
                                        <td><a href="{{ asset($media->path) }}" class="btn btn-link" download=""><i class="ik ik-download"></i></a></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No Images added!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 mx-auto">
                <div class="card chat-card">
                    <div class="card-header">
                        <h3>Conversations:</h3>
                    </div>
                    <div class="card-body scroll">
                        <div class="row my-1 chat">
                            @foreach (App\Models\TicketConversation::where('type_id',$support_ticket->id)->get() as $index => $item)
                                @if ($item->user_id == auth()->id())
                                    <div class="col-md-11 py-2 chat-right mb-1">
                                            <div class="p-0 m-0">
                                                <span>
                                                    {{  $item->comment }}
                                                </span>
                                            </div>
                                            <small class="text-muted">{{ getFormattedDate($item->created_at) }}</small>
                                    </div>
                                    <div class="col-md-1">
                                        <a href="{{ route('panel.admin.ticket_conversation.delete', $item->id) }}" title="Delete Enquiry" class="btn mt-2 btn-sm btn-icon btn-outline-danger delete-item" style="display: flex;align-items: center;justify-content: center;"><i class="ik ik-trash"></i></a>
                                    </div>
                                @else
                                    <div class="col-md-11 py-2 chat-left mb-1">
                                        <div class="p-0 m-0">
                                            <span>
                                                {{  $item->comment }}
                                            </span>
                                        </div>
                                        <small class="text-muted">{{ getFormattedDate($item->created_at) }}</small>
                                    </div>
                                @endif
                            @endforeach
                        </div> 
                        <div class="msg-card"></div>
                    </div>
                    <div class="card-footer">
                         @if($sender != auth()->id())
                            <div class="alert alert-info mb-0"><strong>Note:</strong> You don't have permission to send messsage to this enquiry</div>
                        @else
                            <div class="row">
                                <div class="col-md-12 col-lg-12">   
                                    <form action="{{ route('panel.admin.ticket_conversation.store') }}" method="post" class="ChatForm">                                 
                                        @csrf
                                        <input type="hidden" name="type_id" value="{{ $support_ticket->id }}" id="groupId">
                                        <input type="hidden" name="user_id" value="{{ auth()->id() }}" >
                                        <input type="hidden" name="type" value="{{ 'Support Ticket' }}">
                                        <input type="hidden" name="reciever_id" value="{{ $receiver }}" id="receiverId">
                                        <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                            <textarea class="form-control" rows="5" name="comment" id="message" type="textarea" placeholder="Send Your Reply" required>{{ isset($support_ticket->comment) ? $support_ticket->comment : ''}}</textarea>
                                        </div>
                                        <div class="form-group text-right mb-0">
                                            <button type="submit" class="btn btn-primary"><i class="ik ik-navigation"></i> Send reply</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
               
            </div>
        </div>
        
    </div>
   
@endsection


