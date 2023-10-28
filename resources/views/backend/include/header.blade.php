<header class="header-top" header-theme="light">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            
            <div class="top-menu d-flex align-items-center">
                    {{-- Side Bar Action Button --}}

                <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                <a href="javascript:void(0);" onclick="history.back()" id="back" title="Back" type="button" class="nav-link mr-1" style="background-color: #f0f0f0;"><i class="ik ik-arrow-left"></i></a>
                <button type="button" id="navbar-fullscreen" class="nav-link" title="Maximise"><i
                        class="ik ik-maximize"></i></button>
                <a href="{{ route('customer.dashboard') }}" title="Dashboard" type="button" id="" class="nav-link ml-1" style="background-color: #f0f0f0;"><i
                        class="ik ik-home"></i></a>
                {{-- @if (AuthRole() == 'User')
                    @if(isset($user_shop))
                    <a href="{{ inject_subdomain('home', $user_shop->slug, true, false)}}" target="_blank"  type="button" id="" title="Visit Site" class="nav-link ml-1" style="background-color: #f0f0f0;"><i
                        class="ik ik-external-link"></i></a>
                    @endif    
                @endif --}}
            </div>


        



            @if(getSetting('notification'))
                @php
                    $notification = App\Models\Notification::whereUserId(auth()->id())
                        ->whereIsReaded(0)
                        ->limit(5)->latest()
                        ->get();
                @endphp
            @endif
            <div class="top-menu d-flex align-items-center">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="notiDropdown" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"><i class="ik ik-bell"></i>
                            @if($notification->count() > 0)    
                            <span class="badge bg-primary">{{ $notification->count() }}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right notification-dropdown" aria-labelledby="notiDropdown">
                            <h4 class="header">{{ __('Notifications') }}</h4>
                            <div class="notifications-wrap">
                                @forelse ($notification as $item)
                                    <a href="{{ route('panel.notification.read', $item->id) }}" class="media">
                                        <span class="d-flex">
                                            <i class="ik ik-check"></i>
                                        </span>
                                        <span class="media-body">
                                            <span class="heading-font-family media-heading">{{ $item->title }}</span> <br>
                                            <span class="media-content">{{ $item->notification }}</span>
                                        </span>
                                    </a>
                                @empty 
                                    <h6 class="text-center mt-3">No notifications yet!</h6>
                                    <hr>
                                @endforelse
                            </div>
                            <div class="footer"><a
                                    href="{{ route('panel.constant_management.notification.readall') }}">{{ __('See all activity') }}</a>
                            </div>
                        </div>
                    </div>

                    {{-- User Dropdown --}}
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img class="avatar" src="{{ auth()->user() && auth()->user()->avatar ? auth()->user()->avatar : asset('backend/default/default-avatar.png') }}" style="object-fit: cover; width: 35px; height: 35px;border-radius: 50% !important" alt="">


                            <span class="user-name font-weight-bolder"
                                style="top: -0.8rem;position: relative;margin-left: 8px;">{{ auth()->user()->name }}
                                <span class="text-muted" style="font-size: 10px;position: absolute;top: 16px;left: 0px; ">@if ( authRole() == 'User')Seller @else {{ authRole()  }} @endif</span>
                                </span>
                        </a>
                        
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            @if (AuthRole() != 'User')
                            <a class="dropdown-item" href="{{ url('panel/user-profile') }}"><i
                                    class="ik ik-user dropdown-icon"></i> {{ __('Profile') }}</a>
                            @endif
                            {{-- <a class="dropdown-item" href="#"><i class="ik ik-navigation dropdown-icon"></i> {{ __('Message')}}</a> --}}
                            @if (auth()->user()->is_supplier == 1)
                                <a class="dropdown-item" href="{{ route('customer.dashboard') }}">
                                    <i class="ik ik-inbox dropdown-icon"></i>
                                    {{ __('Dashboard') }}
                                </a>
                            @endif
                            @if (AuthRole() == 'User')
                                {{-- <a class="dropdown-item" data-toggle="modal" data-target="#subscriptionModal" href="#subscriptionModal"><i class="ik ik-check-square dropdown-icon"></i> {{ __('Subscription')}}</a> --}}
                                {{-- <a class="dropdown-item" href="{{ route('panel.subscription.index') }}"><i class="ik ik-check-square dropdown-icon"></i> {{ __('Subscription')}}</a> --}}
                            @endif
                            <a class="dropdown-item" href="{{ url('logout') }}">
                                <i class="ik ik-power dropdown-icon"></i>
                                {{ __('Logout') }}
                            </a>
                        </div>
                    </div>

            </div>
        </div>
    </div>
</header>
@include('backend.modal.subcription')
