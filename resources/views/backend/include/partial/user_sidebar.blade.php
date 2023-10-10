
@can('access_by_user')
{{-- <div class="nav-item {{ activeClassIfRoutes(['panel.seller.my_supplier.index','panel.seller.explore.index','panel.seller.request.index','panel.seller.ignore.index'] ,'active open' ) }}  has-sub">
    <a href="#"><i class="ik ik-layers"></i><span>{{ 'My Collections' }}</span></a>
    <div class="submenu-content" style=""> --}}
        {{-- <a href="{{ route('panel.seller.explore.index') }}" class="menu-item a-item">{{ __('Explore')}}</a> --}}

        {{-- @php
            $pending_requests = getAccessCataloguePendingCount(auth()->id(),0);
        @endphp
        <a href="{{ route('panel.seller.my_supplier.index') }}" class="menu-item a-item">{{ __('My Suppliers')}}  --}}
            {{-- @if($pending_requests > 0)
                <span class="badge badge-warning">{{ $pending_requests }}</span>
            @endif --}}
        {{-- </a>  --}}
        {{-- <a href="{{ route('panel.seller.supplier.index') }}" class="menu-item a-item">{{ __('From Suppliers')}}</a> --}}
        {{-- <a href="{{ route('panel.seller.request.index') }}" class="menu-item a-item">{{ __('Request Under Approval')}}</a>
        <a href="{{ route('panel.seller.ignore.index') }}" class="menu-item a-item">{{ __('Ignore')}}</a> --}}
    {{-- </div>
</div> --}}



@php
    $user = auth()->user();  
    $acc_permissions = json_decode($user->account_permission);
    $acc_permissions->mysupplier = $acc_permissions->mysupplier ?? 'no';
    $acc_permissions->offers = $acc_permissions->offers ?? 'no';
    $acc_permissions->addandedit  = $acc_permissions->addandedit  ?? 'no';
    $acc_permissions->manangebrands  = $acc_permissions->manangebrands  ?? 'no';
    $acc_permissions->pricegroup  = $acc_permissions->pricegroup  ?? 'no';
    $acc_permissions->managegroup  = $acc_permissions->managegroup  ?? 'no';
    $acc_permissions->bulkupload  = $acc_permissions->bulkupload  ?? 'no';
    

    // Todo: Setting Up Permissions for Team USer

    $teamDetails = App\Models\Team::where('contact_number',session()->get('phone'))->first();

    if ($teamDetails != null) {
        $permissions = json_decode($teamDetails->permission);
        if ($permissions) {
            $Team_mycustomer = in_array("my-customer",$permissions);
            $Team_mysupplier = in_array("my-suppler",$permissions);
            $Team_offerme = in_array("offer-me",$permissions);
            $Team_offerto = in_array("offer-other",$permissions);
            $Team_profile = in_array("profile",$permissions);
            $Team_proadd = in_array("proadd",$permissions);
            $Team_setting = in_array("setting",$permissions);
            $Team_dashboard = in_array("dashboard",$permissions);
            $Team_brand = in_array("brand",$permissions);
            $Team_pricegroup = in_array("pricegroup",$permissions);
            $Team_categorygroup = in_array("categorygroup",$permissions);
            $Team_bulkupload = in_array("bulkupload",$permissions);
        }else{
            // Default Access to Original Supplier
            $Team_mycustomer = true;
            $Team_mysupplier = true;
            $Team_offerme = true;
            $Team_offerto = true;
            $Team_profile = true;
            $Team_proadd = true;
            $Team_setting = true;
            $Team_dashboard = true;
            $Team_brand = true;
            $Team_pricegroup = true;
            $Team_categorygroup = true;
            $Team_bulkupload = true;
            
        }
    }
    else{
        // Default Access to Original Supplier
        $Team_mycustomer = true;
        $Team_mysupplier = true;
        $Team_offerme = true;
        $Team_offerto = true;
        $Team_profile = true;
        $Team_proadd = true;
        $Team_setting = true;
        $Team_dashboard = true;
        $Team_brand = true;
        $Team_pricegroup = true;
        $Team_categorygroup = true;
        $Team_bulkupload = true;
    }

@endphp

{{-- @if($acc_permissions->manangebrands == "yes")
    <div class="nav-item {{ ($segment2 == 'brands') ? 'active' : '' }}">
        <a href="{{ route('panel.brands.index')}}" class="a-item" ><i class="ik ik-command"></i><span>My Brands</span></a>
    </div>
@endif --}}


{{-- @if($acc_permissions->mysupplier == "yes")
    <div class="nav-item {{ ($segment2 == 'my_supplier') ? 'active' : '' }}">
        <a href="{{ route('panel.seller.my_supplier.index') }}" class="menu-item a-item"><i class="ik ik-layers"></i><span>{{ __('My Suppliers')}}</span>  --}}
            {{-- @if($pending_requests > 0)
                <span class="badge badge-warning">{{ $pending_requests }}</span>
            @endif --}}
        {{-- </a> 
    </div>
@endif --}}

{{-- @if($acc_permissions->mycustomer == "yes")
    <div class="nav-item {{ ($segment2 == 'my_reseller') ? 'active' : '' }}">
        <a href="{{ route('panel.seller.my_reseller.index') }}" class="a-item" ><i class="ik ik-users"></i><span>My Customers</span></a>
    </div>
@endif

@if ($acc_permissions->offers == "yes")
    <div class="nav-item {{ ($segment2 == 'proposals') ? 'active' : '' }}">
        <a href="{{ route('panel.proposals.index')}}" class="a-item" ><i class="ik ik-send"></i><span>{{ 'Send Proposal' }}</span></a>
    </div>
@endif --}}

{{-- <div class="nav-item {{ activeClassIfRoutes(['panel.seller.supplier.index','panel.price_ask_requests.index','panel.admin.enquiry.index','panel.seller.enquiry.index'] ,'active' )  }}">
    <a href="{{ route('panel.seller.enquiry.index')."?type=contact" }}" class="a-item" ><i class="ik ik-clipboard"></i><span>{{ 'Enquiries' }}</span></a>
</div> --}}
{{-- <div class="nav-item {{ activeClassIfRoutes(['panel.price_ask_requests.index','panel.admin.enquiry.index'] ,'active open' ) }} has-sub">
    <a href="#"><i class="ik ik-clipboard"></i><span>{{ 'Enquiries' }}</span></a>
    <div class="submenu-content" style="">
        <a href="{{ route('panel.price_ask_requests.index') }}" class="menu-item a-item">{{ __('Price Request')}}</a>
        <a href="{{ route('panel.admin.enquiry.index') }}" class="menu-item a-item">{{ __('Product Request')}}</a>
    </div>
</div> --}}
<div class="nav-item {{ activeClassIfRoutes(['panel.user_shop_items.create','panel.user_shop_items.index','panel.seller.category.index','panel.products.create','panel.filemanager.index','panel.products.index','panel.products.inventory.index','panel.groups.index','panel.product_attributes.index','panel.product_attributes.edit','panel.product_attributes.create','panel.product_attributes.show'] ,'active open' ) }} has-sub">
    <a href="#"><i class="ik ik-shopping-bag"></i><span>{{ 'Display' }}</span></a>
    <div class="submenu-content" style="">

        @if($acc_permissions->addandedit == "yes")
            @if ($Team_proadd)
                <a href="{{ route('panel.products.create') }}?action=nonbranded" class="menu-item a-item">{{ __('Add/Edit')}}</a>
            @endif
        @endif

        
        @if($acc_permissions->bulkupload == "yes")
            @if ($Team_bulkupload)
                <a href="{{ route('panel.filemanager.index') }}" class="menu-item a-item">{{ __('File Manager')}}</a>   
            @endif
        @endif


        {{-- <a href="{{ route('panel.products.index') }}?action=nonbranded" class="menu-item a-item">{{ __('Manage')}}</a> --}}
        <a href="{{ route('panel.products.inventory.index') }}?action=nonbranded" class="menu-item a-item">{{ __('Inventory')}}</a>
        {{-- <a href="{{ route('panel.user_shop_items.create') }}" class="menu-item a-item">{{ __('Add Items')}}</a> --}}

        <a href="{{ route('panel.user_shop_items.create')."?type=direct&type_id=".auth()->id() }}" class="menu-item a-item">{{ __('On site products')}}</a>


        @if($acc_permissions->managegroup == "yes")
            @if ($Team_categorygroup)
                <a href="{{ route('panel.seller.category.index','13') }}" class="menu-item a-item">{{ __('Manage Categories')}}</a>
            @endif
        @endif

        <a href="{{ route('panel.product_attributes.index') }}" class="menu-item a-item {{ activeClassIfRoutes(['panel.product_attributes.index','panel.product_attributes.edit','panel.product_attributes.create','panel.product_attributes.show'] ,'active open' ) }}">{{ __('Product Attributes')}}</a>


        @if($acc_permissions->pricegroup == "yes")
            @if ($Team_pricegroup)
                <a href="{{ route('panel.groups.index')."?user=". auth()->id()}}" class="menu-item a-item" >Price Group</a>
            @endif
        @endif
        
        
    </div>
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