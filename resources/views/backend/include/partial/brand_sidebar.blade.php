@can('access_by_brand')
    @php
        $brand_id = getBrandByOwner(auth()->id())->id ?? 0;
    @endphp
    <div
        class="nav-item {{ activeClassIfRoutes(['panel.brands.products.create','panel.products.create', 'panel.brands.products.index','panel.products.index'], 'active open') }} has-sub">
        <a href="#"><i class="ik ik-box"></i><span>{{ __('Products') }}</span></a>
        <div class="submenu-content">
            <a href="{{ route('panel.products.create') }}{{'?id='.$brand_id}}"
                class="menu-item a-item {{ activeClassIfRoutes(['panel.products.create'], 'active') }}">{{ __('Add new') }}</a>
            <a href="{{ route('panel.products.index') }}{{'?id='.$brand_id}}"
                class="menu-item a-item {{ activeClassIfRoute('panel.products.index', 'active') }}">{{ __('Manage') }}</a>
        </div>
    </div>

    <div
        class="nav-item {{ activeClassIfRoutes(['panel.brand_user.index', 'panel.brand_user.index'], 'active open') }} has-sub">
        <a href="#"><i class="ik ik-user"></i><span>{{ __('Authorized Sellers') }}</span></a>
        <div class="submenu-content">
            <a href="{{ route('panel.brand_user.index') }}{{ '?id='.$brand_id.'&status=1' }}"
                class="menu-item a-item @if(request()->has('status') && request()->get('status') == 1) active @endif">{{ __('Manage') }}</a>
            <a href="{{ route('panel.brand_user.index') }}{{ '?id='.$brand_id.'&status=0' }}"
                class="menu-item a-item @if(request()->has('status') && request()->get('status') == 0) active @endif">{{ __('Seller Requests') }}</a>
        </div>
    </div>

    <div class="nav-item {{ $segment2 == 'user-shops' ? 'active' : '' }}">
        <a href="{{ route('panel.brands.edit',$brand_id) }}{{ '?active=appearance' }}" class="a-item"><i
            class="ik ik-command"></i><span>Appearance</span></a>
    </div>

    {{-- <div class="nav-item {{ $segment2 == 'user-shops' ? 'active' : '' }}">
        <a href="{{ route('panel.brands.edit',$brand_id) }}{{ '?active=legal' }}" class="a-item"><i
            class="ik ik-check-square"></i><span>Legal</span></a>
    </div> --}}

    <div class="nav-item {{ $segment2 == 'user-shops' ? 'active' : '' }}">
        <a href="https://forms.gle/JKe6p6bic7gjnuJq5" class="a-item">
            <i class="ik ik-help-circle"></i><span>Support</span>
        </a>
        {{-- <a href="{{ route('panel.support_ticket.index') }}" class="a-item">
            <i class="ik ik-help-circle"></i><span>Support</span>
        </a> --}}
    </div>
@endcan
