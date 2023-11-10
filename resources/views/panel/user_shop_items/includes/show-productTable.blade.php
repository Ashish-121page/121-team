<div class="card-body">
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
        <input type="hidden" name="type" value="{{ request()->get('type')}}">
        <input type="hidden" name="bulk_hike" class="bulkHike" value="">
            <div class="d-flex justify-content-end">
                {{-- <h5>Catalogue ({{$scoped_products->count()}})</h5> --}}
                <div class="d-flex">
                    <div class="d-flex">
                        @if (request()->get('type_id') == auth()->id())                        
                            <button type="submit" name="delproduct" id="delproduct" class="btn btn-sm btn-danger mr-2  d-none validateMargin">Delete Products</button>
                            {{-- Delete All Button --}}
                            <input type="submit" name="delete_all" id="delete_all" value="Delete All Products" class="btn btn-outline-primary d-none"> 
                        @endif
                        {{-- <input type="text" placeholder="Type and Enter" id="searchValue" name="search" value="{{ request()->get('search') }}"  class="form-control">
                        <div class="d-flex ml-2">
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
                <div class="d-flex justify-content-end">
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
                                {{-- <option @if(request()->get('length') == 500) selected @endif value="500">500</option> --}}
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
                </div>
                @endif
                
        @if (request()->has('category_id') && request()->get('category_id') != '')
        
        <div class="row">
            <div class="col-12" style="width: 80vw;overflow: hidden; overflow-x: auto">
                    <a href="?type={{ request()->get('type') }}&type_ide={{ request()->get('type_ide') }}&products=true&category_id={{request()->get('category_id') }}" class="text-primary">
                        <h1 class="d-inline-block" style="font-size: medium"> 
                            <u>{{ App\Models\Category::whereId(request()->get('category_id'))->first()->name }} </u>
                            <i class="fas fa-chevron-right" style="font-size: small"></i> 
                        </h1>
                    </a>
                    @php
                        $products_subcat = App\Models\Product::where('user_id',auth()->id())->pluck('sub_category'); 
                        $record = App\Models\Category::whereIn('id',$products_subcat)->whereparentId(request()->get('category_id'))->get();
                    @endphp
                    
                    @foreach ($record as $item)
                        <a href="?type={{ request()->get('type') }}&type_ide={{ request()->get('type_ide') }}&products=true&category_id={{request()->get('category_id') }}&sub_category_id={{ $item->id}}" class="btn btn-outline-primary @if (request()->has('sub_category_id') && request()->get('sub_category_id') == $item->id) active @endif">{{ $item->name }}</a>
                    @endforeach
                   
                </div>
            </div>

        @endif
        
        <div class="row mt-4">
                {{-- Todo: For On Site Product --}}
           


                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between mb-2">
                        {{-- <div>
                            <label for="">Show
                                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                                    <option value="10" {{ $scoped_products->perPage() == 10 ? 'selected' : ''}}>10</option>
                                    <option value="25" {{ $scoped_products->perPage() == 25 ? 'selected' : ''}}>25</option>
                                    <option value="50" {{ $scoped_products->perPage() == 50 ? 'selected' : ''}}>50</option>
                                    <option value="100" {{ $scoped_products->perPage() == 100 ? 'selected' : ''}}>100</option>
                                </select>
                                entries
                            </label>
                        </div> --}}
                        <div>
                            {{-- <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button> --}}
                            <button class="btn btn-secondary dropdown-toggle d-none " type="button" id="dropdownMenu1" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Edit Columns</button>
                
                            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                          
                
                                <li class="dropdown-item p-0 col-btn" data-val="col_3">
                                    <a href="javascript:void(0);" class="btn btn-sm">Model Code</a>
                                </li>
                                
                                <li class="dropdown-item p-0 col-btn" data-val="pro_image">
                                    <a href="javascript:void(0);" class="btn btn-sm"> Image </a>
                                </li>

                                <li class="dropdown-item p-0 col-btn" data-val="col_2">
                                    <a href="javascript:void(0);" class="btn btn-sm">Title</a>
                                </li>
                                
                              

                                <li class="dropdown-item p-0 col-btn" data-val="col_4">
                                    <a href="javascript:void(0);" class="btn btn-sm">Category</a>
                                </li>
                                
                                <li class="dropdown-item p-0 col-btn" data-val="col_5">
                                    <a href="javascript:void(0);" class="btn btn-sm">Varients</a>
                                </li>
                                
                                <li class="dropdown-item p-0 col-btn" data-val="col_6">
                                    <a href="javascript:void(0);" class="btn btn-sm">Shop Price</a>
                                </li>

                                <li class="dropdown-item p-0 col-btn" data-val="action_btn">
                                    <a href="javascript:void(0);" class="btn btn-sm">Action</a>
                                </li>
                                
                
                
                            </ul>
                            <a href="javascript:void(0);" id="print" data-url="{{ route('panel.product_attributes.print') }}"
                                data-rows="{{json_encode($scoped_products) }}" class="btn btn-primary btn-sm">Print</a>
                        </div>
                        {{-- <input type="text" name="search" class="form-control" placeholder="Search" id="search" --}}
                            {{-- value="{{request()->get('search') }}" style="width:unset;"> --}}
                            {{-- <input type="text" placeholder="Type and Enter" id="searchValue" name="search" value="{{ request()->get('search') }}"  class="form-control"  style="width:unset;"> --}}
                    </div>
                    <div class="table-responsive">
                        <table id="table" class="table">
                            <thead>
                                <tr>


                                    <th class="no-export action_btn">
                                        {{-- Actions --}}
                                        <input type="checkbox" id="checkallinp">
                                    </th>

                                    <th class="col_3">Model
                                        <div class="table-div">
                                            {{-- <i class="ik ik-arrow-up  asc" data-val="values"></i> --}}
                                            {{-- <i class="ik ik ik-arrow-down desc" data-val="values"></i> --}}
                                        </div>
                                    </th>

                                    <th class="pro_image no-export"> Image</th>
                
                                    <th class="col_2">Title
                                        <div class="table-div">
                                            {{-- <i class="ik ik-arrow-up  asc" data-val="name"></i> --}}
                                            {{-- <i class="ik ik ik-arrow-down desc" data-val="name"></i> --}}
                                        </div>
                                    </th>
                
                               
                
                                    <th class="col_4">Category
                                        <div class="table-div">
                                            {{-- <i class="ik ik-arrow-up  asc" data-val="type"></i> --}}
                                            {{-- <i class="ik ik ik-arrow-down desc" data-val="type"></i> --}}
                                        </div>
                                    </th>
                
                                    <th class="col_5">Variants
                                        <div class="table-div">
                                            {{-- <i class="ik ik-arrow-up  asc" data-val="type"></i> --}}
                                            {{-- <i class="ik ik ik-arrow-down desc" data-val="type"></i> --}}
                                        </div>
                                    </th>
                
                                    <th class="col_6">Price
                                        <div class="table-div">
                                            {{-- <i class="ik ik-arrow-up  asc" data-val="type"></i> --}}
                                            {{-- <i class="ik ik ik-arrow-down desc" data-val="type"></i> --}}
                                        </div>
                                    </th>


                                </tr>
                            </thead>
                            <tbody>
                               

                                @foreach ($scoped_products as $scoped_product)
                                @php
                                    if(request()->get('type') == 'direct'){
                                        // Currect Catalogue Author Shop Data
                                        $user_shop_temp = getShopDataByUserId(request()->get('type_id'));
                                        // Show Price of USI
                                        $user_shop_product =  productExistInUserShop(@$scoped_product->id,request()->get('type_id'),$user_shop_temp->id ??'');
                                        $product_exists =  productExistInUserShop($scoped_product->id,$user_id,$user_shop->id);
                                    }else{
                                        $product_exists =  productExistInUserShop($scoped_product->id,$user_id,$user_shop->id);
                                    }
                                    $usi = productExistInUserShop($scoped_product->id,auth()->id(),$user_shop->id);
                                    // Price Grouping
                                    // Current USI Author ID - For Direct Only
                                    if($access_data != null &&  auth()->id() != $access_id){
                                        if($group != 0){
                                            $price_group_data = \App\Models\GroupProduct::whereGroupId($group)->whereProductId($scoped_product->id)->latest()->first();
                                            if($price_group_data && $price_group_data->price != null && $price_group_data->price != 0){
                                                $user_shop_product['price'] = $price_group_data->price;
                                            }
                                        }
                                    }else{
                                    }
                                    $proUsiExists = productExistInUserShop($scoped_product->id,$user_id,$user_shop->id)

                                @endphp
                                @if (!$product_exists)
                                    {{-- <div class="text-center w-100">No Record Found</div> --}}
                                    @continue
                                @endif
                                @php
                                    if(isset($proUsiExists) && $proUsiExists != null){
                                        $route = inject_subdomain("shop/".encrypt($scoped_product->id),$user_shop->slug, true, false);
                                    }else{
                                        if(isset($parent_shop) && $parent_shop->user_id == auth()->id()){
                                            $route = '#';
                                        }else{
                                            if ($parent_shop) {
                                                $route = inject_subdomain("shop/".encrypt(@$scoped_product->id),$parent_shop->slug, true, false);
                                            
                                            }
                                        }
                                    }
                                @endphp
                                    <tr>
            
                                        <td class="no-export action_btn">
                                            @if($scoped_product->user_id == auth()->id())
                                                <input type="checkbox" name="exportproduct" id="exportproduct" class="input-check">
                                            @endif
                                        </td>

                                        
                                        <td class="col_3">
                                            {{ $scoped_product->model_code }}
                                        </td>
                                        
                                        <td class="pro_image no-export" style="height: 100px;width: 100px; object-fit: contain">
                                            <a href="{{ $route }}" target="_blank">
                                                <img src="{{ asset(getShopProductImage($scoped_product->id)->path ?? asset('frontend/assets/img/placeholder.png')) }}" alt="Prouc" class="custom-img" style="height: 100%;width: 100%;">
                                            </a> 
                                        </td>
                                        
                                        <td class="col_2">
                                            {{ Str::limit($scoped_product->title , 40)}}
                                        </td>

                                        <td class="col_4">
                                            {{$scoped_product->category->name ?? " *Dump Product* "}}
                                        </td>
                                        <td class="col_5">
                                            {{ $scoped_product->varient_products()->count()}} Products
                                        </td>
                                        <td class="col_6">
                                            {{  isset($usi) ? format_price($usi->price) : '--' }}
                                        </td>

                                     
                                    </tr>

                                @endforeach




                            </tbody>
                        </table>
                    </div>
                </div>
            
        </div> 
        @if(request()->get('type_id') != auth()->id())
            <div class="d-flex justify-content-end">
                <div class="input-group border-0">
                    <span class="input-group-prepend">
                        <label class="input-group-text">Mark-up on sale price</label>
                    </span>
                    <input min="1" type="number" required min="0" value="10" placeholder="Enter Hike %" name="hike" id="hike" style="max-width: 15%;" class="form-control">
                    <span class="input-group-append">
                        <label class="input-group-text">%</label>
                    </span>
                </div>
                
                <button type="submit" class="btn btn-sm btn-success ml-2 validateMargin">Bulk Add to Shop</button>
                <button type="button" class="btn btn-sm btn-primary ml-2" id="select-all">Select All</button>
                <button type="button" class="btn btn-sm btn-primary ml-2 unSelectAll" id="">UnSelect All</button>
            </div>
        @endif
    </form>
</div>
<div>
    {{ $scoped_products->appends(request()->query())->links() }} 
</div>