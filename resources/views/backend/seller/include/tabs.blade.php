@php
    $pending_catalogue_requests = \App\Models\AccessCatalogueRequest::whereUserId(auth()->id())->whereStatus(0)->count();
    $ignore_requests = \App\Models\AccessCatalogueRequest::whereNumber(auth()->user()->phone)->whereStatus(3)->count();
    $resellers_count = \App\Models\AccessCatalogueRequest::whereNumber(auth()->user()->phone)->whereStatus(1)->count();
@endphp
<div class="d-flex mb-3 mobile-overflow">
    @if(request()->routeIs('panel.seller.my_reseller.index') == true)
        <a href="{{ route('panel.seller.my_supplier.index') }}" class="btn @if(request()->routeIs('panel.seller.my_reseller.index') == true)  btn-primary @else  text-secondary  @endif mr-2">My Customers
    </a>
    @else
        <a href="{{ route('panel.seller.my_supplier.index') }}" class="btn @if(request()->routeIs('panel.seller.my_supplier.index') == true)  btn-primary @else  text-secondary  @endif mr-2">My Supplier
        </a>
    @endif    
    {{-- <a href="{{ route('panel.seller.my_reseller.index') }}" class="btn @if(request()->routeIs('panel.seller.my_reseller.index') == true)  btn-primary @else  text-secondary  @endif mr-2">My Resellers
        @if($resellers_count > 0)
            <span class="badge badge-warning">{{ $resellers_count }}</span>
        @endif
    </a> --}}
    @if(request()->routeIs('panel.seller.my_reseller.index'))
        <a href="{{ route('panel.seller.supplier.index')}}" class="btn @if(Request::url() == route('panel.seller.supplier.index'))  btn-primary @else  text-secondary  @endif mr-2 tab-btn">Request Under Approval
            @php
                $product_enq_requests = getAccessCataloguePendingCount(auth()->id(),0);
            @endphp
            {{-- @if($product_enq_requests > 0)
                <span class="badge badge-warning">{{$product_enq_requests}}</span>
            @endif --}}
        </a>
        <a href="{{ route('panel.seller.ignore.index') }}" class="btn @if(request()->routeIs('panel.seller.ignore.index') == true)  btn-primary @else  text-secondary  @endif">Ignore
            {{-- @if($ignore_requests > 0)
                <span class="badge badge-warning">{{ $ignore_requests }}</span>
            @endif --}}
        </a>
    @else
        <a href="{{ route('panel.seller.request.index') }}" class="btn @if(request()->routeIs('panel.seller.request.index') == true)  btn-primary @else  text-secondary  @endif mr-2">Request Under Approval
            @if($pending_catalogue_requests > 0)
                <span class="badge badge-warning">{{ $pending_catalogue_requests }}</span>
            @endif
        </a>
    @endif
    <hr>
</div>