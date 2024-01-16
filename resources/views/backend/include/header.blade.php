
<style>

.nav-item.active a{

    color: white!important;
    /* background-color: #6666a3; */
    border-radius: 5%;
    position: relative;
    opacity: 86%

}

.nav-item.active a span {
    font-size: 16px;
}

.nav-item.active a::before{
        content: '';
        background-color: #8484f8;
        height: 3px;
        width: 120%;
        position: absolute;
        bottom: -7px;
        left: -4px;
}

</style>

@php
    $permi = json_decode(auth()->user()->account_permission);
    $permi->bulkupload = $permi->bulkupload ?? 'no';
    $permi->maya = $permi->maya ?? 'no';
    $permi->manage_categories = $permi->manage_categories ?? 'no';
    $permi->mysupplier = $permi->mysupplier ?? 'no';
    $permi->manangebrands = $permi->manangebrands ?? 'no';
    $permi->offers = $permi->offers ?? 'no';
    $permi->documentaion = $permi->documentaion ?? 'no';
@endphp


<header class="header-top" header-theme="light" style="background-color: #1e1e2d">
    <div class="container-fluid">
        <div class="d-flex justify-content-between bg-soft-secondary border-0 form-control-sm text-white" >

            @if (AuthRole() !='Admin')
                <div class="top-menu d-flex align-items-center" >
                        {{-- Side Bar Action Button --}}

                    {{-- <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button> --}}
                    {{-- <a href="javascript:void(0);" onclick="history.back()" id="back" title="Back" type="button" class="nav-link mr-1" style="background-color:#ccd3e4;"><i class="ik ik-arrow-left"></i></a> --}}
                    @php
                        $user_shop = getShopDataByUserId(auth()->id());
                    @endphp

                        {{-- <div class="nav-item {{ ($segment2 == 'dashboard') ? 'active' : '' }}">
                            <a href="{{route('panel.dashboard')}}" class="a-item" ><i class="ik ik-bar-chart-2"></i><span>{{ __('Home')}}</span></a>
                        </div>

                        @can('access_by_user') --}}


                        {{-- @if ($acc_permissions->offers == "yes")
                            <div class="nav-item {{ ($segment2 == 'proposals') ? 'active' : '' }}">
                                <a href="{{ route('panel.proposals.index')}}" class="a-item" ><i class="ik ik-send"></i><span>{{ 'Send Proposal' }}</span></a>
                            </div>
                        @endif  --}}
                        <ul class="nav nav-underline">
                            <li class="nav-item">

                                <div class="nav-item  {{ activeClassIfRoutes(['panel.dashboard'] ,'active' ) }}" >
                                <a href="{{route('panel.dashboard')}}" class="a-item px-lg-3 {{ activeClassIfRoutes(['panel.dashboard'] ,'active' ) }}" style="color:#ccd3e4; " ><i class="ik ik-bar-chart-4"></i><span>{{ __('Home')}}</span></a>
                                </div>
                            </li>


                            @if ($permi->maya == 'yes')
                                <div class="nav-item ml-4 {{ activeClassIfRoutes(['panel.image.designer'] ,'active' ) }}">
                                    <a href="{{ route('panel.image.designer') }}" class="a-item px-lg-3" style="color:#ccd3e4;  " >
                                        {{-- AI GENERATE IMAGE --}}
                                        <span>{{ 'Maya' }}</span>
                                    </a>
                                </div>
                            @endif


                            <div class="nav-item ml-4 {{ activeClassIfRoutes(['panel.user_shop_items.create'] ,'active' ) }}">
                                <a href="{{ route('panel.user_shop_items.create')."?type=direct&type_ide=".encrypt(auth()->id()) }}" class="a-item px-lg-3" style="color:#ccd3e4;  " >
                                    {{-- <i class="ik ik-shopping-bag"></i> --}}
                                    <span>{{ 'Manage' }}</span>
                                    {{-- Products --}}
                                </a>
                            </div>

                            <div class="nav-item ml-4 {{ activeClassIfRoutes(['panel.check.display'] ,'active' ) }}">
                                <a href="{{ route('panel.check.display') }}" class="a-item px-lg-3" style="color:#ccd3e4; ">
                                    {{-- <i class="ik ik-upload"></i> --}}
                                    <span>{{ 'Display' }}</span>
                                </a>
                            </div>

                            <div class="nav-item ml-4 {{ activeClassIfRoutes(['panel.proposals.index','pages.proposal.picked'] ,'active' ) }}">
                                <a href="{{ route('panel.proposals.index')."?type=direct&type_ide=".encrypt(auth()->id()) }}" class="a-item px-lg-3" style="color:#ccd3e4; ">
                                    {{-- <i class="ik ik-tag"></i> --}}
                                    <span>{{ 'Offer' }}</span>
                                </a>
                            </div>


                        @if ($permi->documentaion == 'yes')
                            <div class="nav-item ml-4 {{ activeClassIfRoutes(['panel.invoice.index'] ,'active' ) }}">
                                <a href="{{ route('panel.invoice.index')."?type=direct&type_ide=".encrypt(auth()->id()) }}" class="a-item px-lg-3" style="color:#ccd3e4; " >
                                    {{-- <i class="ik ik-archive"></i> --}}
                                    <span>{{ 'Documentation' }}</span>
                                </a>
                            </div>
                        @endif



                        {{-- <div class="nav-item ml-4 {{ activeClassIfRoutes(['panel.users.show','panel.user_shops.edit'] ,'active' ) }}">
                            <a href="{{ route('panel.user_shops.edit',[$user_shop->id ?? 0,'active'=>'shop-details']) }}" class="a-item" style="color:#ccd3e4;" >
                                <i class="ik ik-user"></i>
                                <span>{{ 'Profile' }}</span>
                            </a>
                        </div> --}}



                        {{-- <div class="nav-item dropdown ml-4 {{ activeClassIfRoutes(['panel.users.show','panel.user_shops.edit'] ,'active open' ) }} ">
                            <a href="{{route('panel.users.show','panel.user_shops.edit')}}"class="nav-item dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false" style="color:#ccd3e4;">
                                <i class="ik ik-user"></i>
                                <span>{{ 'Profile' }}</span>
                            </a>
                           <div class="dropdown-menu" style="">
                               <a href="{{ route('panel.user_shops.edit',[$user_shop->id ?? 0,'active'=>'my-info']) }}" class="dropdown-item a-item" >{{ __('My Info')}}</a>
                               <a href="{{ route('panel.seller.enquiry.index') }}" class="dropdown-item a-item" >{{ __('Contact')}}</a>
                               <a href="{{ route('panel.users.show', [auth()->id(),'active'=>'my-info'])}}" class="dropdown-item a-item" >{{ __('Account')}}</a>
                           </div>
                        </div> --}}


                        {{-- <div class="nav-item {{ ($segment2 == 'orders') ? 'active' : '' }}">
                                <a href="{{ route('panel.orders.index')}}" class="a-item" ><i class="ik ik-shopping-cart"></i><span>{{ 'Orders' }}</span></a>
                            </div> --}}


                         {{-- <div class="nav-item {{ activeClassIfRoutes(['panel.users.show','panel.user_shops.edit'] ,'active open' ) }}">
                            <a href="{{ route('panel.user_shops.edit',[$user_shop->id ?? 0,'active'=>'shop-details']) }}" class="a-item" ><i class="ik ik-user"></i><span>{{ 'Profile' }}</span></a>
                        </div> --}}

                        {{-- <div class="nav-item {{ ($segment2 == 'contact') ? 'active' : '' }}">
                            <a href="{{ route('contact.index')}}" class="a-item" ><i class="ik ik-help-circle"></i><span>{{ '121 Support' }}</span></a>
                        </div> --}}


                        {{-- <div class="nav-item {{ ($segment2 == 'contact') ? 'active' : '' }}"> --}}
                            {{-- <a href="https://forms.gle/JKe6p6bic7gjnuJq5" class="a-item" ><i class="ik ik-mail"></i><span>{{ '121 Support' }}</span></a> --}}
                            {{-- <a href="{{ route('panel.support_ticket.index') }}" class="a-item" ><i class="ik ik-mail"></i><span>{{ '121 Support' }}</span></a> --}}
                        {{-- </div> --}}

                        {{-- <div class="nav-item {{ ($segment2 == 'subscription') ? 'active' : '' }}">
                            <a href="{{ route('panel.subscription.index') }}" class="a-item" ><i class="ik ik-check-square"></i><span>{{ 'Subscription Plan' }}</span></a>
                        </div> --}}
                        {{-- @endcan --}}
                        {{-- @endif     --}}
                    </ul>

                </div>
            @else
                <div class="top-menu"></div>
            @endif


            @if(getSetting('notification'))
                @php
                    $notification = App\Models\Notification::whereUserId(auth()->id())
                        ->whereIsReaded(0)
                        ->limit(5)->latest()
                        ->get();
                @endphp
            @endif


            <div class="top-menu d-flex align-items-center">
                <div class="nav-item ml-4">
                    <a href="https://forms.gle/JKe6p6bic7gjnuJq5" target="_blank" class="a-item px-lg-3" style="color:#ccd3e4;">
                        <i class="uil uil-envelope h5 align-middle me-2 mr-3"></i>
                        <span style="align-items: flex-end">{{ '121 Support' }}</span>
                    </a>
                </div>

                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="notiDropdown" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false" style="color:#ccd3e4;"><i class="ik ik-bell" style="line-height:2.3 !important"></i>
                            @if($notification->count() > 0)
                            <span class="badge bg-primary">{{ $notification->count() }}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right notification-dropdown" aria-labelledby="notiDropdown">
                            <h4 class="header">{{ __('Notifications') }}</h4>
                            <div class="notifications-wrap">
                                @forelse ($notification as $item)
                                    <a href="{{ route('panel.notification.read', $item->id) }}" class="media" style="color:#ccd3e4;">
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
                                style="top: -0.8rem;position: relative;margin-left: 8px; color:#ccd3e4;">{{ auth()->user()->name }}
                                <span class="text-muted" style="font-size: 10px;position: absolute;top: 16px;left: 0px; color:#ccd3e4;">@if ( authRole() == 'User')Seller @else {{ authRole()  }} @endif</span>
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
                                <a class="dropdown-item" href="{{ route('panel.user_shops.edit',[$user_shop->id ?? 0,'active'=>'shop-details']) }}" >
                                    <i class="ik ik-user dropdown-icon"></i>
                                    <span>{{ 'Profile' }}</span>
                                </a>
                            @endif

                            {{-- <div class="top-menu d-flex align-items-center">
                                <div class="nav-item ml-4"> --}}
                                    <a href="{{ route('panel.settings.index',encrypt(auth()->id())) }}" class="dropdown-item" >
                                        <i class="ik ik-settings dropdown-icon"></i>
                                        <span>{{ 'Settings' }}</span>
                                    </a>
                                {{-- </div> --}}

                                {{-- <a href="https://forms.gle/JKe6p6bic7gjnuJq5" target="_blank" class="dropdown-item">
                                    <i class="uil uil-envelope h5 align-middle me-2 mr-3"></i>
                                    <span style="align-items: flex-end">{{ 'Support Ticket' }}</span>
                                </a> --}}

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
