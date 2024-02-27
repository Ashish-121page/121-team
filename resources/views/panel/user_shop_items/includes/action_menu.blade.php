{{-- ` Menus That are Always Visible on Navbar --}}

<div class="two" style="display: flex;align-items: center;justify-content: flex-end;">
    {{-- Show Action Menu of Product Tab --}}

    @if (request()->has('products') || request()->has('productsgrid'))
        <div class="d-flex">
            <a href="?type={{ request()->get('type') }}&type_ide={{ request()->get('type_ide') }}&productsgrid=true&category_id={{request()->get('category_id') }}&sub_category_id={{ request()->get('sub_category_id') }}" class="btn btn-icon btn-outline-primary mx-1 @if(request()->has('productsgrid')) active @endif">
                <i class="fas fa-th-large"></i>
            </a>
            <a href="?type={{ request()->get('type') }}&type_ide={{ request()->get('type_ide') }}&products=true&category_id={{request()->get('category_id') }}&sub_category_id={{ request()->get('sub_category_id') }}" class="btn btn-icon btn-outline-primary mx-1 @if(request()->has('products')) active @endif">
                <i class="fas fa-list"></i>
            </a>

        </div>
        {{-- <a href="{{ route('panel.products.create') }}?action=nonbranded"
            class="btn btn-outline-primary  mx-1">
            Update Products
        </a> --}}
        @if($acc_permissions->addandedit == "yes")
            @if ($Team_proadd)
                {{-- <a href="{{ route('panel.products.create') }}?action=nonbranded"
                    class="btn btn-outline-primary  mx-1">
                    Add Product
                </a> --}}
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle mx-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Add Product
                    </button>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('panel.products.create') }}?action=nonbranded&single_product">Single Product</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('panel.products.create') }}?action=nonbranded&bulk_product">Bulk - by Excel</a>
                        </li>
                    </ul>

                </div>
            @endif
        @endif

        @if(auth()->user() && session()->has("admin_user_id") && session()->has("temp_user_id"))
            <button id="delete_all_dummy"class="btn btn-outline-primary">Delete All Products</button>
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


{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#pageSelect').change(function(){
            var selectedValue = $(this).val();

            if(selectedValue !== "0") {
                window.location.href = selectedValue;
            }
        });
    });
</script> --}}
