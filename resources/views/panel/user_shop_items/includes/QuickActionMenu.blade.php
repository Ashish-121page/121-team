

@if (request()->has('products') || request()->has('productsgrid'))

    {{-- For Products --}}
    <div class="top-menu" style=" position:sticky;">
    
        <div class="container-fluid">
        
        <div class="top-menu d-flex align-items-center " id="product-action" style="position: sticky;top: 0; background-color: white; z-index: 100;">
            <button class="btn btn-sm mx-1 selectedbtn">0 Selected</button>

            <button class="btn btn-sm btn-outline-primary mx-1" id="exportproductbtn">Export</button>
            {{-- <button class="btn btn-sm btn-outline-danger mx-1 " id="delete_all_dummy">All Delete</button> --}}
            <button class="btn btn-sm btn-outline-primary mx-1 " id="delproduct_dummy"> Delete</button>
            {{-- <a href="javascript:void(0);" data-toggle="modal" data-target="#updateQR" class="btn btn-sm btn-outline-primary mx-1" title="Upload QR Code">
                Get QR 
            </a> --}}
            <button  id="printQrbtn" type="button" class="btn btn-outline-primary ">Get QR</button>
        </div>
        </div>

    </div>
     
@elseif(request()->has('assetsafe'))
    {{-- For FileManager` --}}
    {{-- ` Nothig TO Show Here. --}}

@elseif(request()->has('properties'))

    {{-- For Propoerties --}}
    <div class="top-menu d-flex align-items-center " id="product-action">
        {{-- <button class="btn btn-sm btn-outline-primary mx-1">Edit</button> --}}
        <button class="btn btn-sm btn-outline-danger mx-1">Delete</button>
    </div>
    
@else

    {{-- For Category --}}
    <div class="top-menu d-flex align-items-center " id="product-action">
        <button class="btn btn-sm btn-outline-primary mx-1" id="export-categrory">Export</button>
        <button class="btn btn-sm btn-outline-primary mx-1 d-none" id="deletecatbtn">Delete</button>
        <button class="btn btn-sm btn-outline-primary mx-1" id="delcat_dummy">Delete</button>
        {{-- <a href="{{ route('panel.constant_management.category.delete', $item->id)  }}" title="Delete Category" class="btn btn-sm delete-item dropdown-item">Delete</a> --}}
    </div>
@endif