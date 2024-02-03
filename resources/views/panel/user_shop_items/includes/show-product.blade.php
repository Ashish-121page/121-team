{{-- @ Old Style Product View --}}
<style>

    #maincontentbxProductLIst .product-card{
        font-size: 1rem !important;
    }

    #maincontentbxProductLIst.product-card.checkmark {
        position: absolute;
        top: 20px !important;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%
    }
</style>



<div class="card-body1">
    @if (request()->get('type_id') == auth()->id())
        <form action="{{ route('panel.user_shop_items.removebulk') }}" method="post" id="removebulkform" >
    @else
        <form action="{{ route('panel.user_shop_items.addbulk') }}" method="post">    
    @endif
        @csrf
        <input type="hidden" name="user_id"  value="{{ $user_id }}">
        <input type="hidden" name="user_shop_id" value="{{ $user_shop->id }}">
        <input type="hidden" name="parent_shop_id" value="{{ $parent_shop->id ?? 0 }}">
        <input type="hidden" name="type_id" value="{{ request()->get('type_id')}}">
        <input type="hidden" name="delete_type" id="delete_type" class="delete_type">
        <input type="hidden" name="type" value="{{ request()->get('type')}}">
        <input type="hidden" name="bulk_hike" class="bulkHike" value="">
            <div class="d-flex justify-content-end mb-3">
                {{-- <h5>Catalogue ({{$scoped_products->count()}})</h5> --}}
                <div class="d-flex">
                    <div class=" input-group">
                        @if (request()->get('type_id') == auth()->id())                        
                            <button type="submit" name="delproduct" id="delproduct" class="btn btn-sm btn-danger mr-2  d-none validateMargin">Delete Products</button>
                            {{-- Delete All Button --}}
                            <input type="submit" name="delete_all" id="delete_all" value="Delete All Products" class="btn btn-outline-primary d-none"> 
                        @endif
                        {{-- <a href="{{ asset('instructions/instructions.pdf') }}" download="instructions.pdf" class="btn btn-outline-primary m-1">Download Instruction</a> --}}
                        <input type="text" placeholder="Quick Search : Name, Model Code, Keywords" id="searchValue" name="search" value="{{ request()->get('search') }}" style= "width: 350px !important;" class="form-control">
                        {{-- <div class="d-flex ml-2">
                            <button type="submit" id="filterBtn" class="btn btn-icon btn-outline-warning " title="submit"><i class="fa fa-filter" aria-hidden="true"></i></button>
                            <a href="{{ route('panel.user_shop_items.create',['type' => request()->get('type'),'type_id' => request()->get('type_id')]) }}" class="btn btn-icon btn-outline-danger ml-2" title="Refresh"><i class="fa fa-redo" aria-hidden="true"></i></a>
                        </div> --}}
                    </div>
                    @if(request()->get('type_id') == auth()->id())
                        {{-- <a href="javascript:void(0);" data-toggle="modal" data-target="#updateQR" class="btn btn-icon btn-sm btn-outline-dark ml-2" title="Upload QR Code"><i class="fa fa-qrcode" aria-hidden="true"></i></a> --}}
                    @endif
                </div>
            </div>
            @if(request()->get('type_id') != auth()->id())
                {{-- <div class="d-flex justify-content-end">
                    <div class="input-group border-0">
                        <span class="input-group-prepend">
                            <label class="input-group-text">Mark-up on sale price</label>
                        </span>
                        <input type="number" required min="0" value="10" placeholder="Enter Hike %" name="hike" id="hike" style="max-width: 25%;" class="form-control">
                        <span class="input-group-append">
                            <label class="input-group-text">%</label>
                        </span>
                        <div class="d-flex ml-2">
                            <select style="width: 140px;" name="length" id="lengthField" class="form-control">
                                <option  value="" aria-readonly="true">Show Products</option>
                                <option @if(request()->get('length') == 10) selected @endif value="10">10</option>
                                <option @if(request()->get('length') == 50) selected @endif value="50">50</option>
                                <option @if(request()->get('length') == 100) selected @endif value="100">100</option>
                                <option @if(request()->get('length') == 500) selected @endif value="500">500</option>
                            </select>
                            <input type="number"  name="length" value="{{request()->get('length')}}" class="form-control" placeholder="Enter Length">
                            <div class="ml-2">
                                <button type="button" class="btn btn-icon btn-outline-primary lengthSearch d-none"><i class="fa fa-filter"></i></button>
                            </div>
                        </div>
                    </div>
                   
                    <button type="button" class="btn btn-sm btn-primary ml-2" id="select-all">Select All</button>
                    <button type="button" class="btn btn-sm btn-primary ml-2 unSelectAll" id="">UnSelect All</button>
                    <button type="submit"  class="btn btn-sm btn-success ml-2 validateMargin">Bulk Add to Shop</button>
                    <div>
                        <span>
                            <i class="ik ik-info fa-2x  ml-2 remove-ik-class" title="Selecting or unselecting will only work with selected products on this page"></i>
                        </span>
                    </div>
                </div> --}}
            @endif
                
            @if (request()->has('category_id') && request()->get('category_id') != '')

                @php
                    if (request()->has('productsgrid')) { 
                        $view = 'productsgrid=true' ;
                    }else{
                        $view = 'products=true' ;
                    }
                @endphp
                <div class="row">
                    <div class="col-12" style="width: 80vw;overflow: hidden; overflow-x: auto">
                            <a href="?type={{ request()->get('type') }}&type_ide={{ request()->get('type_ide') }}&{{$view}}&category_id={{request()->get('category_id') }}" class="text-primary">
                                <h1 class="d-inline-block" style="font-size: medium"> 
                                <u>{{ App\Models\Category::whereId(request()->get('category_id'))->first()->name }} </u>
                                ({{ getProductCountViaCategoryIdOwner(request()->get('category_id'), decrypt(request()->get('type_ide')) ) }})
                                <i class="fas fa-chevron-right" style="font-size: small"></i> 
                            </h1>
                        </a>
                        @php
                            $products_subcat = App\Models\Product::where('user_id',auth()->id())->pluck('sub_category'); 
                            $record = App\Models\Category::whereIn('id',$products_subcat)->whereparentId(request()->get('category_id'))->get();
                            // $record_count = App\Models\Category::whereIn('id',$products_subcat)->whereparentId(request()->get('category_id'))->get()->count();
                        @endphp
                        
                        @foreach ($record as $item)
                        @php
                        $subCategoryCount = App\Models\Product::where('user_id', auth()->id())->where('sub_category', $item->id)->count();
                        @endphp
                
                            {{-- <a href="?type={{ request()->get('type') }}&type_ide={{ request()->get('type_ide') }}&{{$view}}&category_id={{request()->get('category_id') }}&sub_category_id={{ $item->id}}" class="btn btn-outline-primary @if (request()->has('sub_category_id') && request()->get('sub_category_id') == $item->id) active @endif">{{ $item->name }} {{ $item->id }}</a> --}}
                            <a href="?type={{ request()->get('type') }}&type_ide={{ request()->get('type_ide') }}&{{$view}}&category_id={{request()->get('category_id') }}&sub_category_id={{ $item->id}}" class="btn btn-outline-primary @if (request()->has('sub_category_id') && request()->get('sub_category_id') == $item->id) active @endif">
                                {{ $item->name }} ({{ $subCategoryCount }})
                            </a>
                        @endforeach
                        
                    </div>
                </div>


            @endif
        <div class="row mt-4" id="maincontentbxProductLIst">
           @include('panel.user_shop_items.includes.pages.productList')
        </div> 

    </form>
</div>
<div>    
    {{ $scoped_products->appends(request()->query())->links() }} 
</div>

<form method="get" action="{{ route('panel.bulk.product.bulk-export',auth()->id()) }}" id="products_exportform">
    <input type="hidden" name="products" id="products_export" value="">
</form>