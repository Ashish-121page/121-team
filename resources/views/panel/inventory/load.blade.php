<div class="card-body">
    <div class="d-flex justify-content-between mb-2">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    <option value="10" {{ $products->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $products->perPage() == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $products->perPage() == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $products->perPage() == 100 ? 'selected' : '' }}>100</option>
                </select>
                entries
            </label>
        </div>
        <div>
            <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">Column Visibility</button>
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">

                {{-- <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"class="btn btn-sm">Brand </a></li> --}}
                {{-- <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"class="btn btn-sm">User</a></li> --}}
                <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"class="btn btn-sm">Title</a></li>
                 {{-- <li class="dropdown-item p-0 col-btn" data-val="col_9"><a href="javascript:void(0);" class="btn btn-sm">Stock</a></li> --}}
                <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);" class="btn btn-sm">Category </a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);" class="btn btn-sm">Sub Category </a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"class="btn btn-sm">Publish</a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_7"><a href="javascript:void(0);"class="btn btn-sm">Manage Inventory</a></li>
                {{-- <li class="dropdown-item p-0 col-btn" data-val="col_8"><a href="javascript:void(0);"class="btn btn-sm">Status</a></li> --}}
            </ul>
            <a href="javascript:void(0);" id="print" data-url="{{ route('panel.products.print') }}"
                data-rows="{{ json_encode($products) }}" class="btn btn-primary btn-sm">Print</a>
        </div>
        <input type="text" name="search" class="form-control" placeholder="Search" id="search"
            value="{{ request()->get('search') }}" style="width:unset;">
    </div>
    <div class="table-responsive">
        <table id="table" class="table">
            <thead>
                <tr>
                    <th class="no-export">Actions</th>
                    <th class="text-center no-export">Product ID
                    </th>
                    <th class="text-center no-export">Model Code
                    </th>
                    <th class="text-center no-export">Image
                    </th>
                    {{-- <th class="col_3">SKU</th> --}}
                    <th class="col_3">Title</th>
                    <th class="col_3">Colors</th>
                    <th class="col_3">Sizes</th>
                    {{-- <th class="col_9">Stock</th> --}}
                    {{-- <th class="col_9">Price</th> --}}
                    <th class="col_4">Category</th>
                    <th class="col_5"> Sub Category </th>
                    <th class="col_6">Publish </th>
                    {{-- <th class="col_7"><span title="Inventory Management">MI</span> --}}
                    </th>
                    {{-- <th class="col_8">Status </th> --}}
                </tr>
            </thead>
            <tbody>
                @if ($products->count() > 0)
                    @foreach ($products as $product)
                        <tr>
                            <td class="no-export">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i
                                            class="ik ik-chevron-right"></i></button>
                                    <ul class="dropdown-menu multi-level p-2" role="menu" aria-labelledby="dropdownMenu">
                                        <a href="{{ route('panel.products.inventory.edit',$product->id) }}" class="inventoryEditbtn""
                                            title="Edit Product" class="dropdown-item ">
                                            <li class="">Edit</li>
                                        </a>
                                    </ul>
                                </div>
                            </td>
                            <td class="text-center no-export">{{$product->id }}</td>
                            <td class="text-center no-export">{{$product->model_code}}</td>
                            <td>
                                @php
                                    // $media = App\Models\Media::whereType('Product')->whereTypeId()
                                    $product_img = getShopProductImage($product->id)->path ?? null;
                                @endphp
                                @if($product_img != null)
                                    <img src="{{asset(getShopProductImage($product->id)->path)}}" alt="" style="height: 60px;width:60px;object-fit:cover;">
                                @else
                                    <img src="{{asset('frontend/assets/img/placeholder.png')}}" alt="" style="height: 60px;width:60px;object-fit:cover;">
                                @endif
                            </td>
                            {{-- <td class="col_1">{{ fetchFirst('App\Models\Brand', $product->brand_id, 'name', '--') }}</td> --}}
                            {{-- <td class="col_2">{{ fetchFirst('App\User', $product->user_id, 'name', '--') }}</td> --}}
                            {{-- <td class="col_3">{{ $product->sku }} ({{ $product->total }})</td> --}}
                            <td class="col_3">{{ $product->title }}</td>
                            @php
                                $get_colors = @implode(',',App\Models\Product::whereSku($product->sku)->groupBy('color')->pluck('color')->toArray()) ?? "--";
                                $get_sizes = @implode(',',App\Models\Product::whereSku($product->sku)->groupBy('size')->pluck('size')->toArray()) ?? "--";
                            @endphp
                            <td class="col_3">{{ $get_colors ?? '--'}}</td>
                            <td class="col_3">{{ $get_sizes ?? '--' }}</td>
                            {{-- <td class="col_9"><span>{{ getinventoryByproductId($product->id)->stock }}</span></td> --}}
                            {{-- <td class="col_9"><span>{{ format_price($product->price) }}</span></td> --}}
                            <td class="col_4">
                                {{ fetchFirst('App\Models\Category', $product->category_id, 'name', '--') }}</td>
                            <td class="col_5">
                                {{ fetchFirst('App\Models\Category', $product->sub_category, 'name', '--') }}</td>
                            <td class="col_6">@if ($product->is_publish == 1)
                            <span class="badge badge-success">Publish</span>
                            @else
                            <span class="badge badge-danger">Unpublish</span>
                            @endif</td>
                            {{-- <td class="col_7">@if ($product->manage_inventory == 1)
                            <span class="badge badge-success">Yes</span>
                            @else
                            <span class="badge badge-danger">No</span>
                            @endif</td> --}}
                            {{-- <td class="col_8"><span class="badge badge-{{ getProductStatus($product->status)['color'] }}">{{ getProductStatus($product->status)['name'] }}</span></td> --}}
                            
                            

                        </tr>
                      
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="8">
                            <span class="mx-auto">No Inventory Yet!</span> 
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="card-footer d-flex justify-content-between">
    <div class="pagination">
        {{ $products->appends(request()->except('page'))->links() }}
    </div>
    <div>
        @if ($products->lastPage() > 1)
            <label for="">Jump To:
                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="jumpTo">
                    @for ($i = 1; $i <= $products->lastPage(); $i++)
                        <option value="{{ $i }}" {{ $products->currentPage() == $i ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                </select>
            </label>
        @endif
    </div>
</div>
