@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = 'Support Ticket | '.getSetting('app_name');		
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'GRPL';		
		$meta_author_email = '' ?? 'Hello@121.page';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';
        $customer = 1;	
      	
	@endphp
@endsection
<link href="{{ asset('frontend/assets/css/simplebar.css') }}" rel="stylesheet"> 
<style>
    .simplebar-wrapper{
        height: 270px;
    }
    .logo-light-mode{
        margin-top: 16px;
    }
</style>
@section('content')

        <!-- Start -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="card chat chat-person border-0 shadow rounded mb-3">
                        <div class="d-lg-flex justify-content-between border-bottom p-4">
                            <div class="d-flex">
                                <a href="{{ route('customer.dashboard') }}?active=support-ticket" ><i class="uil uil-arrow-left text-primary" style="font-size:35px;"></i></a>
                                <div class="overflow-hidden ms-3">
                                    <a href="#" class="text-dark mb-0 h6 d-block text-truncate">{{ $ticket->subject }}</a>
                                    <small class="text-muted">
                                        <span class="text-{{ getSupportTicketStatus($ticket->status)['color'] }}">{{ getSupportTicketStatus($ticket->status)['name'] }}</span>
                                    </small>
                                </div>
                            </div>

                            <div style="margin-left: 41px;">
                                <div class="d-lg-flex">
                                    <p class="m-0 p-0 me-3">{{ getSupportTicketPrefix($ticket->id)  }}</p>
                                   
                                </div>
                                <small>{{ $ticket->priority ?? '' }}</small>
                            </div>
                        </div>

                        <ul class="p-4 list-unstyled mb-0 chat" data-simplebar style="background: url('assets/images/account/bg-chat.png') center center; ">
                            @if($conversations->count() > 0)
                                @foreach ($conversations as $conversation)
                                    @php
                                        $con_time = $conversation->created_at->diffForHumans() ?? '';
                                    @endphp
                                    @if($conversation->user_id != auth()->id())
                                        <li>
                                            <div class="d-inline-block">
                                                <div class="d-flex chat-type mb-3">
                                                    <div class="chat-msg" style="max-width: 500px;">
                                                        <p class="text-muted small msg px-3 py-2 bg-light rounded mb-1">{{ $conversation->comment }}</p>
                                                        <small class="text-muted msg-time"><i class="uil uil-clock-nine me-1"></i>{{ $conversation->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        @elseif($conversation->user_id == auth()->id())
                                        <li class="chat-right">
                                            <div class="d-inline-block">
                                                <div class="d-flex chat-type mb-3">
                                                    <div class="chat-msg" style="max-width: 500px;">
                                                        <p class="text-muted small msg px-3 py-2 bg-light rounded mb-1">{{ $conversation->comment }}</p>
                                                        <small class="text-muted msg-time"><i class="uil uil-clock-nine me-1"></i>{{ $conversation->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            @else   
                                <li class="d-flex align-items-center">
                                    <div class="text-center mx-auto pt-5">
                                        <p>No conversation yet!</p>
                                    </div>  
                                </li>  
                            @endif
                            </ul>

                        <div class="p-2 rounded-bottom shadow">
                            <form action="{{ route('customer.ticket.chat.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="type_id" value="{{ $ticket->id }}">
                                <div class="row">
                                    <div class="col">
                                        <input required type="text" class="form-control" name="comment" placeholder="Enter Message...">
                                    </div>
                                    <div class="col-auto">
                                        <label for="upload" class="btn btn-icon btn-primary">
                                             <i class="uil uil-paperclip"></i>
                                            <input type="file" id="upload" name="attachment" style="display:none">
                                        </label>
                                        <button type="submit" class="btn btn-icon btn-primary"><i class="uil uil-message"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!--end col-->
                <div class="col-md-4">
                    <div class="card border-0 shadow rounded">
                        <div class="card-body" style="flex: 1 1 auto;min-height: 1px; padding: 1.5rem;">
                            <h5 class="card-title font-16 mb-3">Attachments</h5>
                            <div class="card mb-1 shadow-none border">
                                <div class="p-2">
                                    @forelse ($medias as $media)
                                        <div class="d-block position-relative">
                                            <div class="row align-items-center">
                                                @php
                                                    $size = 10;
                                                @endphp
                                                <div class="col-auto">
                                                    <div class="avatar-sm">
                                                        <span class="avatar-title badge-soft-primary text-primary rounded">
                                                            <i class="uil uil-image-download" download=""></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col p-0">
                                                    <a href="javascript:void(0);" class="text-muted font-weight-medium" download="">
                                                        {{ Str::limit($media->file_name,20) }}</a>
                                                    <div>
                                                        <small class="text-muted msg-time"><i class="uil uil-clock-nine me-1"></i>{{ getFormattedDate($media->created_at) }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="{{ asset($media->path) }}" class="d-block position-absolute" style="inset: 0; z-index: 2"></a>
                                        </div>
                                    <hr>
                                    @empty
                                        <div class="text-center mx-auto">
                                            <h6>No Attachments</h6>
                                        </div>
                                    @endforelse
                                
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($ticket->status != 2)
                    <div class="car border-0 shadow rounded mt-4">
                        <div class="card-body" style="padding: 1.5rem;">
                            <h5>Does your problem appear to be resolved?</h5>
                            <a href="{{ route('customer.ticket.status.update',[$ticket->id,2]) }}" class="btn btn-outline-danger btn-md confirm-btn mx-auto d-block" style="padding: 5px 12px;">Mark the discussion as closed</a>
                        </div>
                   </div>
                    @else
                    @endif
                </div>
            </div>
        </div><!--end container-->
    </section><!--end section-->




@endsection
@section('InlineScript')
<script src="{{ asset('frontend/assets/js/simplebar.min.js') }}"></script>
    <script>

    $(function(){
        $('#btn-upload').click(function(e){
            e.preventDefault();
            $('#file').click();}
        );
    });

    $(document).on('click','.confirm-btn',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var msg = $(this).data('msg') ?? "You won't be able to revert back!";
        $.confirm({
            draggable: true,
            title: 'Are You Sure!',
            content: msg,
            type: 'red',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'yes',
                    btnClass: 'btn-red',
                    action: function(){
                            window.location.href = url;
                    }
                },
                close: function () {
                }
            }
        });
    });
    </script>
@endsection