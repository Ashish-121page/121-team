@if (request()->has('products') || request()->has('productsgrid'))

    {{-- For Products --}}
    <div class="top-menu d-flex align-items-center " id="product-action">
        <button class="btn btn-sm btn-outline-primary mx-1">Export</button>
        <button class="btn btn-sm btn-outline-danger mx-1">Delete</button>
        <a href="javascript:void(0);" data-toggle="modal" data-target="#updateQR" class="btn btn-sm btn-outline-primary mx-1" title="Upload QR Code">
            Get QR 
        </a>
    </div>
    
@elseif(request()->has('assetsafe'))
    {{-- For FileManager` --}}
    {{-- ` Nothig TO Show Here. --}}

@elseif(request()->has('properties'))

    {{-- For Propoerties --}}
    <div class="top-menu d-flex align-items-center " id="product-action">
        <button class="btn btn-sm btn-outline-primary mx-1">Edit</button>
        <button class="btn btn-sm btn-outline-danger mx-1">Delete</button>
    </div>
    
@else

    {{-- For Category --}}
    <div class="top-menu d-flex align-items-center " id="product-action">
        <button class="btn btn-sm btn-outline-primary mx-1">Edit</button>
        <button class="btn btn-sm btn-outline-danger mx-1" id="deletecatbtn">Delete</button>
        {{-- <a href="{{ route('panel.constant_management.category.delete', $item->id)  }}" title="Delete Category" class="btn btn-sm delete-item dropdown-item">Delete</a> --}}
    </div>
@endif