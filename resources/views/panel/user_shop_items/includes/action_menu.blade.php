{{-- ` Menus That are Always Visible on Navbar --}}

<div class="two" style="display: flex;align-items: center;justify-content: flex-end;">
    {{-- Show Action Menu of Product Tab --}}

    @if (request()->has('products') || request()->has('productsgrid'))
        <div class="d-flex">
            <a href="?type={{ request()->get('type') }}&type_id={{ request()->get('type_id') }}&productsgrid=true" class="btn btn-icon btn-outline-primary mx-1">
                <i class="fas fa-th-large"></i>
            </a>
            <a href="?type={{ request()->get('type') }}&type_id={{ request()->get('type_id') }}&products=true" class="btn btn-icon btn-outline-primary mx-1">
                <i class="fas fa-list"></i>
            </a>
        </div>
        <a href="{{ route('panel.products.create') }}?action=nonbranded&update_record"
            class="btn btn-outline-primary  mx-1">
            Update SKUs
        </a>
        @if($acc_permissions->addandedit == "yes")
            @if ($Team_proadd)
                <a href="{{ route('panel.products.create') }}?action=nonbranded"
                    class="btn btn-outline-primary  mx-1">
                    Add Product
                </a>
            @endif
        @endif

        @if(auth()->user() && session()->has("admin_user_id") && session()->has("temp_user_id"))
            <button id="delete_all_dummy"class="btn btn-outline-danger ">Delete All Products</button>
        @endif
    


    
    @elseif(request()->has('assetsafe'))
        {{-- Show Action Menu of FileManage Tab --}}
        
    @elseif(request()->has('properties'))
        {{-- Show Action Menu of Properties Tab --}}
        <a href="{{ route('panel.product_attributes.create') }}" class="btn btn-outline-primary">Add Property</a>
    
    @else
        {{-- Show Action Menu of Category Tab --}}
        
    @endif
    
</div>