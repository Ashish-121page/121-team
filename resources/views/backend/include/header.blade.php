<style>
    .nav-item.active a {
        color: white !important;
        /* background-color: #6666a3; */
        border-radius: 5%;
        position: relative;
        opacity: 86%
    }

    .nav-item.active a span {
        font-size: 16px;
    }

    .nav-item.active a::before {
        content: '';
        background-color: #8484f8;
        height: 3px;
        width: 120%;
        position: absolute;
        bottom: -7px;
        left: -4px;
    }

    .nav-item a i {
        display: none;
    }

    .mobile-menu .nav-item {
        font-size: 2rem;
    }

    .mobile-menu .nav-item.active a span {
        font-size: 2rem !important;
    }

    .mobile-menu .nav-item a {
        margin-left: 10%;
    }

    .mobile-menu .nav-item a i {
        display: contents !important;
        font-size: 22px;
    }

    .mobile-menu .nav-item a span {
        margin: 0 16px;
    }

    .mobile-menu {
        height: 100vh;
        width: 100vw;
        position: fixed;
        z-index: 99;
        top: 0%;
        left: 0%;
        background-color: #1e1e2d;
        flex-direction: column;
    }

    .mobile-menu .nav {
        display: flex !important;
        flex-direction: column;
    }

    .mobile-menu .nav .nav-item {
        width: 100%;
        height: max-content !important;
        margin: 10px 0px !important;
        padding: 10px;
        height: 10px;
    }

    .mobile-menu .nav .nav-item .a-item {
        display: block;
        border: none !important;
    }

    .mobile-menu .nav-item.active a::before {
        content: '';
        background-color: #8484f8;
        height: 3px;
        width: 50%;
        position: absolute;
        bottom: -7px;
        left: -4px;
    }

    .EFD {
        z-index: 999;
    }


    .bar {
        width: 25px;
        height: 3px;
        background-color: #fff;
        margin: 6px 0;
        transition: transform 0.3s;
    }

    #animatedButton.active .bar:nth-child(1) {
        transform: rotate(-45deg) translate(-6px, 6px);
    }

    #animatedButton.active .bar:nth-child(2) {
        opacity: 0;
    }

    #animatedButton.active .bar:nth-child(3) {
        transform: rotate(45deg) translate(-6px, -7px);
    }
</style>
<script>
    $(document).ready(function() {
        function toggleNav() {
            var $menu = $('.hdsgfweyfb');
            var $toggleBtn = $('.toggle-menubtn');

            if ($(window).width() < 768) {
                $menu.removeClass('desktop-menu d-flex').addClass('mobile-menu d-none');
                $toggleBtn.removeClass('d-none');
            } else {
                $menu.removeClass('mobile-menu d-none').addClass('desktop-menu');
                setTimeout(function() {
                    $menu.addClass('d-flex');
                }, 500);

                $toggleBtn.addClass('d-none');
            }
        }

        $('.toggle-menubtn').click(function() {
            var $mobileMenu = $('.mobile-menu');
            var isVisible = $mobileMenu.is(':visible');
            $("#animatedButton").toggleClass('active');

            if (isVisible) {
                $mobileMenu.slideUp(500, function() {
                    $mobileMenu.removeClass('d-flex').addClass('d-none');
                });
            } else {
                $mobileMenu.removeClass('d-none').addClass('d-flex').hide().slideDown(500);
            }
        });


        window.addEventListener("resize", (e) => {
            toggleNav();
        });

        toggleNav();

    });
</script>
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
        <div class="d-flex justify-content-between bg-soft-secondary border-0 form-control-sm text-white dusfwhehu">
            @if (AuthRole() != 'Admin')
                {{-- ` Menu For Desktop --}}
                <div class="top-menu d-flex desktop-menu hdsgfweyfb">
                    @php
                        $user_shop = getShopDataByUserId(auth()->id());
                    @endphp
                    <ul class="nav nav-underline">
                        <div class="d-flex justify-content-start invisible  ml-4 align-items-center w-100 ">
                            <button class="btn p-0  toggle-menubtn m-3" style="background-color: transparent;">
                                <i class="fas fa-home"></i>
                            </button>

                        </div>
                        <li class="nav-item {{ activeClassIfRoutes(['panel.dashboard'], 'active') }}">
                            <a href="{{ route('panel.dashboard') }}"
                                class="a-item px-lg-3 {{ activeClassIfRoutes(['panel.dashboard'], 'active') }}"
                                style="color:#ccd3e4; ">
                                <i class="fas fa-home"></i>
                                <span>{{ __('Home') }}</span>
                            </a>
                        </li>

                        @if ($permi->maya == 'yes')
                            <div
                                class="nav-item ml-4 {{ activeClassIfRoutes(['panel.image.designer'], 'active') }} d-none">
                                <a href="{{ route('panel.image.designer') }}" class="a-item px-lg-3"
                                    style="color:#ccd3e4;  ">
                                    {{-- AI GENERATE IMAGE --}}
                                    <i class="fas fa-image"></i>
                                    <span>{{ 'Maya' }}</span>
                                </a>
                            </div>
                        @endif

                        <div
                            class="nav-item ml-4 {{ activeClassIfRoutes(['panel.user_shop_items.create'], 'active') }}">
                            <a href="{{ route('panel.user_shop_items.create') . '?type=direct&type_ide=' . encrypt(auth()->id()) }}&assetvault=true"
                                class="a-item px-lg-3" style="color:#ccd3e4;  ">
                                <i class="ik ik-shopping-bag"></i>
                                <span>{{ 'Manage' }}</span>
                                {{-- Products --}}
                            </a>
                        </div>

                        <div class="nav-item ml-4 {{ activeClassIfRoutes(['panel.search.index'], 'active') }}">
                            <a href="{{ route('panel.search.index') }}" class="a-item px-lg-3"
                                style="color:#ccd3e4;  ">
                                <i class="ik ik-shopping-bag"></i>
                                <span>{{ 'Search Image' }}</span>
                            </a>
                        </div>
                        @php
                            $request = request();
                            $user_shop = getShopDataByUserId(auth()->id());
                            $slug = $user_shop->slug;
                        @endphp

                        <div class="nav-item ml-4 {{ activeClassIfRoutes([ 'pages.proposal.picked'], 'active') }}">
                        {{-- <div class="nav-item ml-4 {{ activeClassIfRoutes([ 'panel.check.display'], 'active') }}"> --}}
                            {{-- <a href="{{ route('panel.check.display') }}" class="a-item px-lg-3"
                                style="color:#ccd3e4; "> --}}
                            <a href="{{ inject_subdomain('shop', $slug, true, false) }}" class="a-item px-lg-3"
                                style="color:#ccd3e4; ">
                                <i class="ik ik-upload"></i>
                                {{-- <span>{{ 'Display' }}</span> --}}
                                <span>{{ 'Search' }}</span>
                            </a>
                        </div>

                        <div
                            class="nav-item ml-4 {{ activeClassIfRoutes(['panel.proposals.index', 'pages.proposal.picked'], 'active') }}">
                            <a href="{{ route('panel.proposals.index') . '?type=direct&type_ide=' . encrypt(auth()->id()) }}"
                                class="a-item px-lg-3" style="color:#ccd3e4; ">
                                <i class="ik ik-tag"></i>
                                <span>{{ 'Offer' }}</span>
                                {{-- <span>{{ 'Search' }}</span> --}}
                            </a>
                        </div>

                        @if ($permi->documentaion == 'yes')
                            <div
                                class="nav-item ml-4 {{ activeClassIfRoutes(['panel.Documents.Quotation'], 'active') }}">
                                <a href="{{ route('panel.Documents.Quotation') }}" class="a-item px-lg-3"
                                    style="color:#ccd3e4; ">
                                    <i class="ik ik-archive"></i>
                                    <span>{{ 'Documentation' }}</span>
                                </a>
                            </div>
                        @endif
                    </ul>
                </div>
            @else
            <div class="top-menu d-flex desktop-menu hdsgfweyfb d-none">
                @php
                    $user_shop = getShopDataByUserId(auth()->id());
                @endphp
                <ul class="nav nav-underline d-none">
                    <div class="d-flex justify-content-start invisible  ml-4 align-items-center w-100 ">
                        <button class="btn p-0  toggle-menubtn m-3" style="background-color: transparent;">
                            <i class="fas fa-home"></i>
                        </button>

                    </div>
                    <li class="nav-item {{ activeClassIfRoutes(['panel.dashboard'], 'active') }}">
                        <a href="{{ route('panel.dashboard') }}"
                            class="a-item px-lg-3 {{ activeClassIfRoutes(['panel.dashboard'], 'active') }}"
                            style="color:#ccd3e4; ">
                            <i class="fas fa-home"></i>
                            <span>{{ __('Home') }}</span>
                        </a>
                    </li>

                    @if ($permi->maya == 'yes')
                        <div
                            class="nav-item ml-4 {{ activeClassIfRoutes(['panel.image.designer'], 'active') }} d-none">
                            <a href="{{ route('panel.image.designer') }}" class="a-item px-lg-3"
                                style="color:#ccd3e4;  ">
                                {{-- AI GENERATE IMAGE --}}
                                <i class="fas fa-image"></i>
                                <span>{{ 'Maya' }}</span>
                            </a>
                        </div>
                    @endif

                    <div
                        class="nav-item ml-4 {{ activeClassIfRoutes(['panel.user_shop_items.create'], 'active') }}">
                        <a href="{{ route('panel.user_shop_items.create') . '?type=direct&type_ide=' . encrypt(auth()->id()) }}&assetvault=true"
                            class="a-item px-lg-3" style="color:#ccd3e4;  ">
                            <i class="ik ik-shopping-bag"></i>
                            <span>{{ 'Manage' }}</span>
                            {{-- Products --}}
                        </a>
                    </div>

                    <div class="nav-item ml-4 {{ activeClassIfRoutes(['panel.search.index'], 'active') }}">
                        <a href="{{ route('panel.search.index') }}" class="a-item px-lg-3"
                            style="color:#ccd3e4;  ">
                            <i class="ik ik-shopping-bag"></i>
                            <span>{{ 'Search Image' }}</span>
                        </a>
                    </div>
                    @php

                        $request = request();
                    $slug = $request->subdomain ?? 'ashish';
                    @endphp

                    <div class="nav-item ml-4 {{ activeClassIfRoutes([ 'pages.proposal.picked'], 'active') }}">
                    {{-- <div class="nav-item ml-4 {{ activeClassIfRoutes([ 'panel.check.display'], 'active') }}"> --}}
                        {{-- <a href="{{ route('panel.check.display') }}" class="a-item px-lg-3"
                            style="color:#ccd3e4; "> --}}
                        <a href="{{ inject_subdomain('proposal/create', $slug, true, false) }}" class="a-item px-lg-3"
                            style="color:#ccd3e4; ">
                            <i class="ik ik-upload"></i>
                            {{-- <span>{{ 'Display' }}</span> --}}
                            <span>{{ 'Search' }}</span>
                        </a>
                    </div>

                    <div
                        class="nav-item ml-4 {{ activeClassIfRoutes(['panel.proposals.index', 'pages.proposal.picked'], 'active') }}">
                        <a href="{{ route('panel.proposals.index') . '?type=direct&type_ide=' . encrypt(auth()->id()) }}"
                            class="a-item px-lg-3" style="color:#ccd3e4; ">
                            <i class="ik ik-tag"></i>
                            <span>{{ 'Offer' }}</span>
                            {{-- <span>{{ 'Search' }}</span> --}}
                        </a>
                    </div>

                    @if ($permi->documentaion == 'yes')
                        <div
                            class="nav-item ml-4 {{ activeClassIfRoutes(['panel.Documents.Quotation'], 'active') }}">
                            <a href="{{ route('panel.Documents.Quotation') }}" class="a-item px-lg-3"
                                style="color:#ccd3e4; ">
                                <i class="ik ik-archive"></i>
                                <span>{{ 'Documentation' }}</span>
                            </a>
                        </div>
                    @endif
                </ul>
            </div>
            @endif

            @if (getSetting('notification'))
                @php
                    $notification = App\Models\Notification::whereUserId(auth()->id())->whereIsReaded(0)->limit(5)->latest()->get();
                @endphp
            @endif

            <div class="top-menu d-flex align-items-center">

                <div class="nav-item EFD">
                    <button class="btn p-0 shadow-none  toggle-menubtn m-3" style="background-color: transparent;"
                        id="animatedButton">
                        <div class="bar"></div>
                        <div class="bar"></div>
                        <div class="bar"></div>
                    </button>
                </div>
                <div class="nav-item ml-4 EFD">
                    {{-- <a href="https://forms.gle/JKe6p6bic7gjnuJq5" target="_blank" class="a-item px-lg-3"
                        style="color:#ccd3e4;">
                        <i class="uil uil-envelope h5 align-middle me-2 mr-3"></i>
                        <span style="align-items: flex-end">{{ '121 Support' }}</span>
                    </a> --}}

                    <a href="{{ route('panel.support_ticket.index') }}" target="" class="a-item px-lg-3"
                    style="color:#ccd3e4;">
                        <i class="uil uil-envelope h5 align-middle me-2 mr-3"></i>
                        <span style="align-items: flex-end">{{ '121 Support' }}</span>
                    </a>

                </div>
                <div class="dropdown EFD">
                    <a class="nav-link dropdown-toggle" href="#" id="notiDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#ccd3e4;"><i
                            class="ik ik-bell" ></i>
                        @if ($notification->count() > 0)
                            <span class="badge bg-primary">{{ $notification->count() }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right notification-dropdown" aria-labelledby="notiDropdown">
                        <h4 class="header">{{ __('Notifications') }}</h4>
                        <div class="notifications-wrap">
                            @forelse ($notification as $item)
                                <a href="{{ route('panel.notification.read', $item->id) }}" class="media"
                                    style="color:#ccd3e4;">
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
                <div class="dropdown EFD">
                    <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img class="avatar"
                            src="{{ auth()->user() && auth()->user()->avatar ? auth()->user()->avatar : asset('backend/default/default-avatar.png') }}"
                            style="object-fit: cover; width: 35px; height: 35px;border-radius: 50% !important"
                            alt="">

                        <span class="user-name font-weight-bolder"
                            style="top: -0.8rem;position: relative;margin-left: 8px; color:#ccd3e4;">{{ auth()->user()->name }}
                            <span class="text-muted"
                                style="font-size: 10px;position: absolute;top: 16px;left: 0px; color:#ccd3e4;">
                                @if (authRole() == 'User')
                                    Seller
                                @else
                                    {{ authRole() }}
                                @endif
                            </span>
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
                        <a href="{{ route('panel.settings.index', [encrypt(auth()->id()), 'open' => 'acc_info', 'active' => 'shop-details']) }}"
                            class="dropdown-item">
                            <i class="ik ik-settings dropdown-icon"></i>
                            <span>{{ 'Settings' }}</span>
                        </a>
                        {{-- <a href="https://forms.gle/JKe6p6bic7gjnuJq5" target="_blank" class="dropdown-item">
                            <i class="uil uil-envelope h5 align-middle me-2 mr-3"></i>
                            <span style="align-items: flex-end">{{ 'Support Ticket' }}</span>
                        </a>
                        @if (AuthRole() == 'User')
                            <a class="dropdown-item" data-toggle="modal" data-target="#subscriptionModal"
                                href="#subscriptionModal"><i class="ik ik-check-square dropdown-icon"></i>
                                {{ __('Active Subscription') }}</a>
                            <a class="dropdown-item" href="{{ route('panel.subscription.index') }}"><i
                                    class="ik ik-check-square dropdown-icon"></i> {{ __('Subscription Plan') }}</a>
                        @endif --}}
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
