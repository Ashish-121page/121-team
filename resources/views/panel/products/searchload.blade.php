<div class="card-body">
    <div class="d-flex felx-wrap justify-content-between mb-2">
        <div class="mr-1">
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
        <div class="d-flex flex-wrap">
            @php
                if(AuthRole() == "User"){
                    $category = getProductCategoryByUserIndrustry(auth()->user()->industry_id);
                }else{
                    $category = getProductCategory();
                }
            @endphp
            <form action="{{ route('panel.products.search') }}" method="get">

                <div class="form-group">
                    <select required name="category_id" id="category_id" class="form-control select2">
                        <option value="" readonly>Select Category </option>
                        @foreach($category as $option)
                            <option value="{{ $option->id }}" @if($option->id == request()->get('category_id')) selected @endif>{{  $option->name ?? ''}}</option> 
                        @endforeach
                    </select>
                </div>
            
                <div class="form-group mx-3 mb-0">
                    <select required name="sub_category" data-selected-subcategory="{{ old('sub_category') }}" id="sub_category" class="form-control select2">
                        <option value="" readonly>Select Sub Category </option>
                        @if(old('sub_category'))
                            <option value="{{ old('sub_category') }}" > {{ fetchFirst('App\Models\Category',old('sub_category'),'name') }}</option>
                        @endif 
                    </select>
                </div>
                <div>
                    <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                    
                    <a href="javascript:void(0);" id="reset" data-url="{{ url('panel/products/search') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                </div>
            </form>
            <div>
                <input type="text" name="search" class="form-control" placeholder="Search" id="search"
                value="{{ request()->get('search') }}" style="width:unset;">
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table id="" class="table ">
            <thead>
                <tr>
                    <th class="no-export">Actions</th>
                    <th class="text-center no-export">#ID
                    </th>
                    <th class="text-center no-export">Image
                    </th>
                    <th class="col_3">Title</th>
                    <th class="col_4">Category</th>
                    <th class="col_5">Color</th>
                    <th class="col_6">HSN </th>
                    {{-- <th class="col_7">Brand</th> --}}
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
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.products.clone',$product->id) }}"
                                                title="Print QR" class="dropdown-item confirm-btn" >
                                                <li class=" p-0">Clone</li>
                                            </a>
                                        </ul>
                                </div>
                            </td>
                            <td class="text-center no-export">PRO{{ getPrefixZeros($product->id) }}</td>
                            <td>
                                @php
                                    $product_img = getShopProductImage($product->id)->path ?? null;
                                @endphp
                                @if($product_img != null)
                                    <img src="{{asset(getShopProductImage($product->id)->path)}}" alt="" style="height: 60px;width:60px;object-fit:cover;">
                                @else
                                    <img src="{{asset('frontend/assets/img/placeholder.png')}}" alt="" style="height: 60px;width:60px;object-fit:cover;">
                                @endif
                            </td>
                            <td class="col_3">{{ Str::limit($product->title,80) }}
                            
                            </td>
                            <td class="col_4">
                                {{ fetchFirst('App\Models\Category', $product->cat_id, 'name', '--') }}
                                > {{ fetchFirst('App\Models\Category', $product->sub_category, 'name', '--') }}
                            </td>
                            <td class="col_5">
                                {{ $product->color ?? '' }} - {{ $product->size ?? '' }} <br>
                                @php
                                    $temp_count = App\Models\Product::whereSku($product->sku)->count    
                                    ();
                                    $count = $temp_count-1;
                                @endphp
                                @if($temp_count > 0)
                                    @if($count > 0)
                                        +{{$count}} Varients
                                    @endif
                                @endif
                            </td>
                            <td class="col_6">{{ $product->hsn??"--" }}:
                            {{-- <td class="col_6">{{ $product->brand_id ??"--" }}: --}}
                            
                                {{-- @if($product->hsn_percent){{ $product->hsn_percent }}% @else -- @endif
                            </td>
                            <td class="col_7">@if ($product->manage_inventory == 1)
                            <span class="badge badge-success">Yes</span>
                            @else
                            <span class="badge badge-danger">No</span>
                            @endif</td> --}}
                            {{-- <td class="col_8"><span class="badge badge-{{ getProductStatus($product->status)['color'] }}">{{ getProductStatus($product->status)['name'] }}</span></td> --}}
                            
                            

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
