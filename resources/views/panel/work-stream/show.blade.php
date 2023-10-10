@extends('backend.layouts.main') 
@section('title', 'Workstream')
@section('content')
@php
    $breadcrumb_arr = [
        ['name' => 'Workstream', 'url' => '#', 'class'=>'active']
    ]
@endphp
    @push('head')
        <style>
            .input-group.search, .input-group.search input.search{
                border-top-left-radius: 60px;
                border-bottom-left-radius: 60px;

            }
            .input-group.search, .input-group.search label.search{
                border-top-right-radius: 60px;
                border-bottom-right-radius: 60px;
            }
            .card-block{
                height: 405px;
                overflow-y: auto;
            }
            .card-block::-webkit-scrollbar, .chat-list::-webkit-scrollbar{
                width: 6px;
            }
        </style>
    @endpush
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 id="chat-user">Workstream</h3>
                        <div class="card-header-right">
                            <div class="dropdown">
                                @if($workStream->type == 1)
                                    @if($workStream->author_id == \Auth::id())
                                        <button type="button" class="btn btn-icon btn-outline-success" data-toggle="modal" data-target="#callModalCenter"><i class="ik ik-phone"></i></button>
                                        <button type="button" class="btn btn-icon btn-outline-info" data-toggle="modal" data-target="#videoCallModalCenter"><i class="ik ik-video"></i></button>
                                    @endif
                                @else
                                    <button type="button" class="btn btn-icon btn-outline-success" data-toggle="modal" data-target="#callModalCenter"><i class="ik ik-phone"></i></button>
                                    <button type="button" class="btn btn-icon btn-outline-info" data-toggle="modal" data-target="#videoCallModalCenter"><i class="ik ik-video"></i></button>
                                @endif
                                <button type="button" class="btn btn-icon btn-outline-dark dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ik ik-more-vertical"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                  <li><a class="dropdown-item" href="#!" onClick="window.location.reload();">Chat Refresh</a></li>
                                  <li><a class="dropdown-item" href="{{  route('panel.case_work_stream_attachment.index',$workStream->id) }}" >Attachment</a></li>
                                  <li><a href="javascript:void(0);" data-id="{{ $workStream->case_id }}" class="dropdown-item showReschedulingModal">Reschedule</a></li>
                                  @if(AuthRole() == 'Doctor')
                                    <li><a class="dropdown-item" href="{{  route('panel.case_work_stream.mark.completed',$workStream->id) }}">Mark as Completed</a></li>
                                  @endif
                                  {{-- <li><a class="dropdown-item" href="{{  route('panel.case_work_stream_attachment.index',$workStream->id) }}">View Attachment</a></li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div  class="card-body chat-box scrollable card-300" style="height:440px;">
                        @if($workStream->description != null)
                            <div class="alert alert-success">
                                <h5>Agenda:</h5>
                                <p>
                                    {!! $workStream->description !!}
                                </p>
                            </div>
                        @endif
                        <ul class="chat-list">
                            @foreach ($message as $item) 
                                @if ($item->user_id == auth()->id())
                                    <li class="odd chat-item">
                                        <div class="chat-content">
                                            <div class="box bg-light-inverse text-dark" style="background: #ddd">
                                            {!! makeLinks($item->message) !!}
                                            </div>
                                            <br>
                                        </div>
                                        <div class="chat-time">{{ $item->created_at->format('h:i a') }}</div>
                                    </li>
                                @else  
                                    <li class="chat-item">
                                        {{-- <div class="chat-img"><img src="{{ asset('backend/img/users/2.jpg') }}" alt="user"></div> --}}
                                        <div class="chat-content">
                                            <h6 class="font-medium">{{ NameById($item->user_id) }}</h6>
                                            <div class="box bg-light-info">
                                                {!! makeLinks($item->message) !!}
                                            </div>
                                        </div>
                                        <div class="chat-time">{{ $item->created_at->format('h:i a') }}</div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer chat-footer">
                        <form action="{{ route('panel.case_work_stream_message.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" id="user_id" value="{{ auth()->id() }}">
                            <input type="hidden" name="type" id="type" value="0">
                            <input type="hidden" name="workstream_id" id="workstream_id" value="{{ $workStream->id }}">
                            
                            <div class="input-group input-wrap">
                                <textarea type="text" placeholder="Type and enter" name="message" id="message" rows="1" class="form-control" required></textarea>
                                {{-- <input type="file" id="imgupload" style="display:none"/> 
                                <button id="OpenImgUpload" class="btn btn-accent" style="top: 0; right: 50px" type="button">
                                    <i class="ik ik-paperclip"></i>
                                </button> --}}
                            </div>
                        <button type="submit" class="btn btn-icon btn-theme" style="top: 25px;right:25px;"><i class="fa fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>
        
            </div>
        </div>
    </div>
    {{-- Call Modal Start --}}
    <div class="modal fade" id="callModalCenter" tabindex="-1" role="dialog" aria-labelledby="callModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('panel.case_work_stream.voice.call', $workStream->id) }}" method="GET" enctype="multipart/form-data">
                    <input type="hidden" name="workstream_id" id="name" value="{{ $workStream->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="callModalLongTitle">Call</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ asset('backend/src/img/calling.svg') }}" width="60%" alt="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="sumbit" class="btn btn-primary">Call Now!!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Call Modal End --}}
    {{-- VideoCall Modal Start --}}
    <div class="modal fade" id="videoCallModalCenter" tabindex="-1" role="dialog" aria-labelledby="videoCallModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('panel.case_work_stream.video.call', $workStream->id) }}" method="GET" enctype="multipart/form-data">
                    <input type="hidden" name="workstream_id" id="name" value="{{ $workStream->id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="videoCallModalLongTitle">Video Call</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ asset('backend/src/img/video-call.svg') }}" width="60%" alt="">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Video Call Now!</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
     {{-- @include('modal.reschedule-appointment') --}}
    {{-- VideoCall Modal End --}}
    <!-- push external js -->
    @push('script') 
    
    <script>
        $('#OpenImgUpload').click(function(){ $('#imgupload').trigger('click'); });
            $('.user-area').each(function(){
                $(this).click(function(){
                    // var name = $(this).find('a').data('name');
                    $('#chat-user').html($(this).find('a').data('name'));
                });
            });
        $(".search-block").hide();
        function chatListSearch(){
            var filter, item;
            filter = $("#chat-search").val().trim().toLowerCase();
            items = $(".chat-block").find("a");
            items = items.filter(function(i,item){
                if($(item).html().trim().toLowerCase().indexOf(filter) > -1  && $(item).attr('href') !== '#'){
                    return item;
                }
            });
            if(filter !== ''){
                $(".search-block").show();
                $(".chat-block").addClass('d-none');
                $(".search-block").html('')
                if(items.length > 0){
                    for (i = 0; i < items.length; i++) {
                        const text = $(items)[i].innerText;
                        const link = $(items[i]).attr('href');
                        const id = $(items[i]).data('id');
                        const img = $(items[i]).parent().parent().find('img').attr('src');
                        const msg = $(items[i]).parent().find('small').html();
                        $(".search-block").append(` 
                            <div class="align-middle user-area mb-25">
                                <img src="${img}" alt="user image" class="rounded-circle img-40 align-top mr-15">
                                <div class="d-inline-block user-block">
                                    <a href="${link}" data-id="${id}" data-name="${text}" class="chat-user"><h6>${text}</h6></a>
                                    <small class="text-muted mb-0">${msg}</small>
                                </div>
                            </div>
                            `);
                    }
                }else{
                    $(".search-block").html(`
                            <div class="align-middle user-area text-center mb-25">
                                <div class="d-inline-block user-block text-center">
                                    <a href="#!" class="chat-user"><h6>No User Found...</h6></a>
                                </div>
                            </div>
                    `);
                }
            }else{
                $(".chat-block").removeClass('d-none');
                $(".search-block").html('')
                $(".search-block").hide();
            }
        }  
    </script>
    @endpush
@endsection