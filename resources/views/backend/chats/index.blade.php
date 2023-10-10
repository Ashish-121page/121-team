@extends('backend.layouts.main') 
@section('title', 'Chats')
@section('content')
@php
    $breadcrumb_arr = [
        ['name' => 'Chats', 'url' => route('panel.chats.index'), 'class'=>'active']
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
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Chats')}}</h5>
                            <span>{{ __('You can chat with your friends here.')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card new-cust-card">
                    <div class="card-header py-3">
                        <img src="{{ asset('backend/img/users/3.jpg') }}" alt="user image" class="rounded-circle img-40 align-top mr-15">
                        <div class="input-group search my-2">
                            <input type="text" class="form-control search" placeholder="Search or start new chat" id="chat-search" onkeyup="chatListSearch()">
                            <span class="input-group-append " id="basic-addon3">
                                <label class="input-group-text search"><i class="ik ik-search"></i></label>
                            </span>
                        </div>
                    </div>
                    <div class="card-block search-block">
                    </div>
                    <div class="card-block chat-block">
                        <div class="align-middle user-area mb-25">
                            <img src="{{ asset('backend/img/users/1.jpg') }}" alt="user image" class="rounded-circle img-40 align-top mr-15">
                            <div class="d-inline-block user-block">
                                <a href="#!" data-id="1" data-name="Alex Thompson" class="chat-user"><h6>Alex Thompson</h6></a>
                                <small class="text-muted mb-0">Cheers!</small>
                            </div>
                        </div>
                        <div class="align-middle user-area mb-25">
                            <img src="{{ asset('backend/img/users/4.jpg') }}" alt="user image" class="rounded-circle img-40 align-top mr-15">
                            <div class="d-inline-block user-block">
                                <a href="#!"  data-id="2" data-name="John Doue" class="chat-user"><h6>John Doue</h6></a>
                                <small class="text-muted mb-0">Cheers!</small>
                            </div>
                        </div>
                        <div class="align-middle user-area mb-25">
                            <img src="{{ asset('backend/img/users/2.jpg') }}" alt="user image" class="rounded-circle img-40 align-top mr-15">
                            <div class="d-inline-block user-block">
                                <a href="#!"  data-id="3" data-name="John Doue" class="chat-user"><h6>John Doue</h6></a>
                                <small class="text-muted mb-0">stay hungry stay foolish!</small>
                            </div>
                        </div>
                        <div class="align-middle user-area mb-25">
                            <img src="{{ asset('backend/img/users/3.jpg') }}" alt="user image" class="rounded-circle img-40 align-top mr-15">
                            <div class="d-inline-block user-block">
                                <a href="#!"  data-id="4" data-name="Alex Thompson" class="chat-user"><h6>Alex Thompson</h6></a>
                                <small class="text-muted mb-0">Cheers!</small>
                            </div>
                        </div>
                        <div class="align-middle user-area mb-25">
                            <img src="{{ asset('backend/img/users/4.jpg') }}" alt="user image" class="rounded-circle img-40 align-top mr-15">
                            <div class="d-inline-block user-block">
                                <a href="#!"  data-id="5" data-name="John Doue" class="chat-user"><h6>John Doue</h6></a>
                                <small class="text-muted mb-0">Cheers!</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                
                <div class="card">
                    <div class="card-header">
                        <h3 id="chat-user">Recent Chat</h3>
                        <div class="card-header-right">
                            <div class="dropdown">
                                <button type="button" class="btn btn-icon btn-outline-success"><i class="ik ik-phone"></i></button>
                                <button type="button" class="btn btn-icon btn-outline-info"><i class="ik ik-video"></i></button>
                                <button type="button" class="btn btn-icon btn-outline-dark dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ik ik-more-vertical"></i>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                  <li><a class="dropdown-item" href="#!" onclick="window.location.reload()">Chat Refresh</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div  class="card-body chat-box scrollable card-300" style="height:350px;">
                        <ul class="chat-list">
                            @for($i = 1;$i <= 10; $i++)
                            <li class="chat-item">
                                {{-- <div class="chat-img"><img src="{{ asset('backend/img/users/2.jpg') }}" alt="user"></div> --}}
                                <div class="chat-content">
                                    <h6 class="font-medium">James Anderson</h6>
                                    <div class="box bg-light-info">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, fuga.
                                    </div>
                                </div>
                                <div class="chat-time">10:56 am</div>
                            </li>
                           
                            <li class="odd chat-item">
                                <div class="chat-content">
                                    <div class="box bg-light-inverse">I would love to join the team.</div>
                                    <br>
                                </div>
                                <div class="chat-time">10:56 am</div>
                            </li>
                            @endfor
                        </ul>
                    </div>
                    <div class="card-footer chat-footer">
                        <div class="input-wrap">
                            <input type="text" placeholder="Type and enter" class="form-control">
                        </div>
                        <button type="button" class="btn btn-icon btn-theme"><i class="fa fa-paper-plane"></i></button>
                    </div>
                </div>
        
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script') 
    <script>
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