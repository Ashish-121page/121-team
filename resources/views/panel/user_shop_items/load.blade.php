<div class="card-body">
    <div class="d-flex flex-wrap justify-content-between mb-2">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    <option value="10"{{ $user_shop_items->perPage() == 10 ? 'selected' : ''}}>10</option>
                    <option value="25"{{ $user_shop_items->perPage() == 25 ? 'selected' : ''}}>25</option>
                    <option value="50"{{ $user_shop_items->perPage() == 50 ? 'selected' : ''}}>50</option>
                    <option value="100"{{ $user_shop_items->perPage() == 100 ? 'selected' : ''}}>100</option>
                </select>
                entries
            </label>
        </div>
        <div>
            <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
 
            @if (authrole() == 'Admin')
                <a href="{{ route('panel.user_shop_items.update.product')}}" target="_blank" id="update_products" class="btn btn-warning btn-sm">Update Product</a>
            @endif

            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                
                {{-- <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">User  </a></li> --}}
                {{-- <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">User Shop</a></li>  --}}
                <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Price</a></li>                    
                <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Product  </a></li>               
                <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">Category</a></li>                    
                <li class="dropdown-item p-0 col-btn" data-val="col_7"><a href="javascript:void(0);"  class="btn btn-sm">Sub Category</a></li>                    
                <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"  class="btn btn-sm">Published</a></li>                                        
            </ul>
            <a href="javascript:void(0);" id="print" data-url="{{ route('panel.user_shop_items.print') }}"  data-rows="{{json_encode($user_shop_items) }}" class="btn btn-primary btn-sm">Print</a>
        </div>
        <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
    </div>
    <div class="table-responsive">
        <table id="table" class="table">
            <thead>
                <tr>
                    <th class="no-export">Actions</th> 
                    <th  class="text-center no-export"># </th>             
                    {{-- <th class="col_1">User  </th> --}}
                    {{-- <th class="col_2">User Shop </th> --}}
                    <th class="col_4">Product</th>
                    <th class="col_4">Supplier</th>
                    <th class="col_3">Price </th>
                    <th class="col_5">Brand</th>
                    <th class="col_5">Category</th>
                    <th class="col_7">SubCategory</th>
                    <th class="col_6">Published </th>
                    </tr>
            </thead>
            <tbody>
                @if($user_shop_items->count() > 0)
                     @foreach($user_shop_items as  $user_shop_item)
                    @php
                        $temp_product = getProductDataById($user_shop_item->product_id);
                    @endphp
                        @if($temp_product)
                        <tr>
                            <td class="no-export">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        <a href="{{ route('panel.user_shop_items.edit', $user_shop_item->id) }}" title="Edit Product" class="dropdown-item "><li class="p-0">Edit Price/Category</li></a>
                                        <a href="{{ route('panel.user_shop_items.destroy', $user_shop_item->id) }}" title="Delete Product" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                    </ul>
                                </div> 
                            </td>
                            <td  class="text-center no-export"> {{  $loop->iteration }}</td>
                                  <td class="col_4">
                                    <img style="height: 55px;width: 55px;object-fit:contain;" class="mr-2 rounded" src="{{ asset(getShopProductImage($temp_product->id)->path ?? asset('frontend/assets/img/placeholder.png')) }}" alt="" srcset="">

                                    {{$temp_product->title ?? '--'}}
                                    ( {{ $temp_product->color }} - {{ $temp_product->size }})
                                </td>
                              <td class="col_3">{{fetchFirst('App\Models\Product',$user_shop_item->parent_shop_id,'name','Self') }}</td>
                              <td class="col_3">{{format_price($user_shop_item->price) }}</td>
                                <td class="col_4">
                                    @if(isset($user_shop_item->product_id))
                                        {{ (getBrandRecordByProductId($user_shop_item->product_id)->name ?? '--') }} 
                                    @else 
                                        <span>--</span>  
                                    @endif 
                                </td> 
                                  
                              <td class="col_5">{{fetchFirst('App\Models\Category',$user_shop_item->category_id,'name','--')}}</td>
                              <td class="col_7">{{fetchFirst('App\Models\Category',$user_shop_item->sub_category_id,'name','--')}}</td>
                              {{-- @dd($user_shop_item->is_published); --}}
                              <td class="col_6">@if($user_shop_item->is_published == 1)
                                    <span class="badge badge-success">Yes</span> 
                                @else
                                    <span class="badge badge-danger">No</span> 
                                @endif</td>
                              
                              
                        </tr>
                        @endif
                    @endforeach
                @else 
                    <tr>
                        <td class="text-center" colspan="8">No Data Found...</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer d-flex justify-content-between">
    <div class="pagination">
        {{ $user_shop_items->appends(request()->except('page'))->links() }}
    </div>
    <div>
       @if($user_shop_items->lastPage() > 1)
            <label for="">Jump To: 
                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                    @for ($i = 1; $i <= $user_shop_items->lastPage(); $i++)
                        <option value="{{ $i }}" {{ $user_shop_items->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </label>
       @endif
    </div>
</div>

