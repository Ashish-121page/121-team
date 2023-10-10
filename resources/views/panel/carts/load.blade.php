<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $carts->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $carts->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $carts->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $carts->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    
                    <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">User  </a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">User Shop  </a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Product  </a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">User Shop Item  </a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">Qty</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"  class="btn btn-sm">Price</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_7"><a href="javascript:void(0);"  class="btn btn-sm">Total</a></li>                                        
                </ul>
                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.carts.print') }}"  data-rows="{{json_encode($carts) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th class="no-export">Actions</th> 
                        <th  class="text-center no-export"># <div class="table-div"><i class="ik ik-arrow-up  asc" data-val="id"></i><i class="ik ik ik-arrow-down desc" data-val="id"></i></div></th>             
                                               
                        <th class="col_1">
                            User    <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="user_id"></i><i class="ik ik ik-arrow-down desc" data-val="user_id"></i></div></th>
                                                    <th class="col_2">
                            User Shop    <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="user_shop_id"></i><i class="ik ik ik-arrow-down desc" data-val="user_shop_id"></i></div></th>
                                                    <th class="col_3">
                            Product    <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="product_id"></i><i class="ik ik ik-arrow-down desc" data-val="product_id"></i></div></th>
                                                    <th class="col_4">
                            User Shop Item    <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="user_shop_item_id"></i><i class="ik ik ik-arrow-down desc" data-val="user_shop_item_id"></i></div></th>
                                                    <th class="col_5">
                            Qty <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="qty"></i><i class="ik ik ik-arrow-down desc" data-val="qty"></i></div></th>
                                                    <th class="col_6">
                            Price <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="price"></i><i class="ik ik ik-arrow-down desc" data-val="price"></i></div></th>
                                                    <th class="col_7">
                            Total <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="total"></i><i class="ik ik ik-arrow-down desc" data-val="total"></i></div></th>
                                                                        </tr>
                </thead>
                <tbody>
                    @if($carts->count() > 0)
                                                    @foreach($carts as  $cart)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.carts.edit', $cart->id) }}" title="Edit Cart" class="dropdown-item "><li class="p-0">Edit</li></a>
                                            <a href="{{ route('panel.carts.destroy', $cart->id) }}" title="Delete Cart" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"> {{  $loop->iteration }}</td>
                                    <td class="col_1">{{fetchFirst('App\User',$cart->user_id,'name','--')}}</td>
                                      <td class="col_2">{{fetchFirst('App\Models\UserShop',$cart->user_shop_id,'name','--')}}</td>
                                      <td class="col_3">{{fetchFirst('App\Models\Product',$cart->product_id,'name','--')}}</td>
                                      <td class="col_4">{{fetchFirst('App\Models\UserShopItem',$cart->user_shop_item_id,'name','--')}}</td>
                                  <td class="col_5">{{$cart->qty }}</td>
                                  <td class="col_6">{{$cart->price }}</td>
                                  <td class="col_7">{{$cart->total }}</td>
                                  
                            </tr>
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
            {{ $carts->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($carts->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $carts->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $carts->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
