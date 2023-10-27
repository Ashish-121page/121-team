@php
    $user_shop = getShopDataByUserId(auth()->id());
@endphp

<div class="nav-item {{ ($segment2 == 'dashboard') ? 'active' : '' }}">
    <a href="{{route('panel.dashboard')}}" class="a-item" ><i class="ik ik-bar-chart-2"></i><span>{{ __('Home')}}</span></a>
</div>         

@can('access_by_user')


{{-- @if ($acc_permissions->offers == "yes")
    <div class="nav-item {{ ($segment2 == 'proposals') ? 'active' : '' }}">
        <a href="{{ route('panel.proposals.index')}}" class="a-item" ><i class="ik ik-send"></i><span>{{ 'Send Proposal' }}</span></a>
    </div>
@endif  --}}


<div class="nav-item {{ activeClassIfRoutes(['panel.user_shop_items.create'] ,'active open' ) }}">
    <a href="{{ route('panel.user_shop_items.create')."?type=direct&type_id=".auth()->id() }}" class="a-item" >
        <i class="ik ik-upload"></i>
        <span>{{ 'Products' }}</span>
    </a>
</div>

<div class="nav-item {{ activeClassIfRoutes(['panel.check.display'] ,'active open' ) }}">
    <a href="{{ route('panel.check.display') }}" class="a-item">
        <i class="ik ik-shopping-bag"></i>
        <span>{{ 'Display' }}</span>
    </a>
</div>

<div class="nav-item {{ activeClassIfRoutes(['panel.proposals.index'] ,'active open' ) }}">
    <a href="{{ route('panel.proposals.index')."?type=direct&type_id=".auth()->id() }}" class="a-item" >
        <i class="ik ik-tag"></i>
        <span>{{ 'Offer' }}</span>
    </a>
</div>

<div class="nav-item">
    <a href="{{ route('panel.user_shop_items.create')."?type=direct&type_id=".auth()->id() }}" class="a-item" >
        <i class="ik ik-archive"></i>
        <span>{{ 'Quotes' }}</span>
    </a>
</div>


{{-- <div class="nav-item {{ ($segment2 == 'orders') ? 'active' : '' }}">
    <a href="{{ route('panel.orders.index')}}" class="a-item" ><i class="ik ik-shopping-cart"></i><span>{{ 'Orders' }}</span></a>
</div> --}}
{{-- <div class="nav-item {{ activeClassIfRoutes(['panel.users.show','panel.user_shops.edit'] ,'active open' ) }} has-sub"> --}}
    {{-- <a href="#"><i class="ik ik-user"></i><span>{{ 'Profile' }}</span></a> --}}
    {{-- <div class="submenu-content" style=""> --}}
        {{-- <a href="{{ route('panel.user_shops.edit',[$user_shop->id ?? 0,'active'=>'my-info']) }}" class="menu-item a-item">{{ __('My Info')}}</a> --}}
        {{-- <a href="{{ route('panel.seller.enquiry.index') }}" class="menu-item a-item">{{ __('Contact')}}</a> --}}
        {{-- <a href="{{ route('panel.users.show', [auth()->id(),'active'=>'my-info'])}}" class="menu-item a-item">{{ __('Account')}}</a> --}}
    {{-- </div> --}}
{{-- </div> --}}


<div class="nav-item {{ activeClassIfRoutes(['panel.users.show','panel.user_shops.edit'] ,'active open' ) }}">
    <a href="{{ route('panel.user_shops.edit',[$user_shop->id ?? 0,'active'=>'shop-details']) }}" class="a-item" ><i class="ik ik-user"></i><span>{{ 'Profile' }}</span></a>
</div>

{{-- <div class="nav-item {{ ($segment2 == 'contact') ? 'active' : '' }}">
    <a href="{{ route('contact.index')}}" class="a-item" ><i class="ik ik-help-circle"></i><span>{{ '121 Support' }}</span></a>
</div> --}}
<div class="nav-item {{ ($segment2 == 'contact') ? 'active' : '' }}">
    <a href="https://forms.gle/JKe6p6bic7gjnuJq5" class="a-item" ><i class="ik ik-mail"></i><span>{{ '121 Support' }}</span></a>
    {{-- <a href="{{ route('panel.support_ticket.index') }}" class="a-item" ><i class="ik ik-mail"></i><span>{{ '121 Support' }}</span></a> --}}
</div>
{{-- <div class="nav-item {{ ($segment2 == 'subscription') ? 'active' : '' }}">
    <a href="{{ route('panel.subscription.index') }}" class="a-item" ><i class="ik ik-check-square"></i><span>{{ 'Subscription Plan' }}</span></a>
</div> --}}
@endcan
{{-- @endif     --}}