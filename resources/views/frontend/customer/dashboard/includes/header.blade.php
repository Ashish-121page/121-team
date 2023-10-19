

<header id="topnav" class="defaultscroll sticky">
    <div class="container d-flex justify-content-between">
        
        <div class="logo">
            @if (request()->routeIs('customer.dashboard') == true)
                <span class="">
                    <button class="toggleBtn">
                        <i class="uil uil-bars"></i>
                    </button>
                </span>
            @endif
            <a>
                <img src="{{ getBackendLogo(getSetting('app_white_logo'))}}" class="logo-light-mode" alt="" style=" height: 35px;">
                <img src="{{ getBackendLogo(getSetting('app_logo'))}}" class="logo-dark-mode" alt="" style=" height: 35px;">
            </a>
        </div>
        @php
            $user_shop = App\Models\UserShop::whereUserId(auth()->id())->first();
        @endphp
        <div class="mt-3 e-card-wrapper">
            <a href="{{ inject_subdomain('home', $user_shop->slug, true, false)}}" class="btn btn-primary" target="_blank">My Page</a>
        </div>
  
        
        <ul class="buy-button list-inline mb-0">
            @php
                $notifications = App\Models\Notification::whereUserId(auth()->id())->latest()->where('is_readed',0)->take(6)->get()
            @endphp
            @auth
                <li class="list-inline-item mb-0">
                    <div class="dropdown dropdown-primary">
                        <button type="button" class="btn btn-icon btn-pills text-dark dropdown-toggle mt-1" data-bs-toggle="dropdown" style="background: #f5f5f5;" aria-haspopup="true" aria-expanded="false"><i class="uil uil-bell"></i>
                        </button>
                        @if($notifications->count() > 0)    
                        <span class="badge bg-primary" style="position: relative;top: -13px;left: -20px;
                        border-radius: 50%;">{{ $notifications->count() }}</span>
                        @endif
                         <div class="dropdown-menu dd-menu dropdown-menu-end bg-white shadow rounded border-0 mt-3 py-2" style="width: 275px;">
                            @forelse ($notifications as $notification)
                                <div class="dropdown-item p-2" style="display: contents;white-space: inherit;">
                                   <a href="{{ route('customer.notification.show',$notification->id) }}" class="d-flex text-dark my-1 p-1" style="font-size: 0.8rem;"><i class="uil pr-2 uil-check-circle" style="font-size: 1.5rem;"></i> 
                                        <div style="margin-left: 5px;">
                                            <span class="d-block">{{ $notification->title }}</span>
                                            <span class="text-muted">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</span>
                                        </div>
                                    </a>
                                </div>
                                @if(!$loop->last)
                                <hr class="m-0">
                                @endif
                            @empty 
                                
                                <div class="dropdown-item">
                                    <div class="text-center mx-auto">
                                        <span>No Notifications yet!</span>
                                    </div>
                                </div>
                            @endforelse
                            <hr class="m-0">
                            @if($notifications->count() > 0)
                                <div class="mx-auto text-center py-2">
                                    <a href="{{ route('customer.notification') }}" class="text-center text-primary">See all notifications</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </li>
                <li class="list-inline-item mb-0">
                    <div class="dropdown dropdown-primary">
                        {{-- <button type="button" class="btn btn-icon btn-pills btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="user" class="icons"></i></button> --}}
                        <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img class="avatar" src="{{ auth()->user() && auth()->user()->avatar ? auth()->user()->avatar : asset('frontend/default/default-avatar.png') }}"
                            style="object-fit: cover; width: 35px; height: 35px" alt="">
                        <span class="user-name font-weight-bolder"
                            style="top: -0.8rem;position: relative;margin-left: 8px;">{{ auth()->user()->name }}
                            <span class="text-muted" style="font-size: 10px;position: absolute;top: 16px;left: 0px;">@if ( authRole() == 'User')Seller @else {{ authRole()  }} @endif</span>
                            </span>
                        </a>
                        <div class="dropdown-menu dd-menu dropdown-menu-end bg-white shadow rounded border-0 mt-3 py-2" style="width: 200px;">
                            @if (AuthRole() == 'Admin')
                                <a class="dropdown-item text-dark" href="{{ route('panel.dashboard') }}"><i class="uil uil-dashboard align-middle me-1"></i>Dashboard</a>
                            @else  
                                <a class="dropdown-item text-dark" href="{{ route('customer.dashboard') }}"><i class="uil uil-dashboard align-middle me-1"></i>Dashboard</a>

                                {{-- @if (auth()->user()->status == 1)
                                    <a class="dropdown-item" href="{{ route('panel.subscription.index') }}"><i class="uil uil-check-square dropdown-icon"></i> {{ __('Subscription')}}</a>                                
                                @endif --}}

                                @if(!App\Models\AccessCode::where('redeemed_user_id',auth()->id())->exists())
                                    <a class="dropdown-item text-dark accees-code" href="javascript:void(0)"><i class="uil uil-lock-access align-middle me-1"></i>Have Access Code</a>
                                @endif
                            @endif
                            @if(auth()->user() && session()->has("admin_user_id") && session()->has("temp_user_id"))
                                <a class="dropdown-item text-dark" href="{{ route("panel.auth.logout-as") }}"><i class="uil uil-sign-in-alt align-middle me-1"></i>Re-Login as {{ NameById(session()->get("admin_user_id")) }}</a>
                            @endif
                            <div class="dropdown-divider my-3 border-top"></div>
                            <a class="dropdown-item text-dark" href="{{ url('logout') }}"><i class="uil uil-sign-out-alt align-middle me-1"></i> Logout</a>
                        </div>
                    </div>
                </li>
            @else    
                <li class="list-inline-item mb-0"><a href="{{ url('auth/login') }}" class="btn btn-primary">SignIn</a></li>
                {{-- <li class="list-inline-item mb-0"><a href="{{ url('register') }}" class="btn btn-outline-primary">Signup</a></li> --}}
            @endif
        </ul><!--end login button-->
        
    </div>
  <!--end container-->
</header>