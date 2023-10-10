<div class="card-body">
    <div class="d-flex justify-content-between mb-2">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    <option value="10" {{ $group_products->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $group_products->perPage() == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $group_products->perPage() == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $group_products->perPage() == 100 ? 'selected' : '' }}>100</option>
                </select>
                entries
            </label>
        </div>
        <div>
            {{-- <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">Column Visibility</button> --}}
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">

                {{-- <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"class="btn btn-sm">Group </a></li> --}}
                <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);" class="btn btn-sm">Product </a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);" class="btn btn-sm">Price</a></li>
                 <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);" class="btn btn-sm">Created At</a></li>
            </ul>
            <a href="javascript:void(0);" id="print" data-url="{{ route('panel.group_products.print') }}"
                data-rows="{{ json_encode($group_products) }}" class="btn btn-primary btn-sm">Print</a>
        </div>
        <input type="text" name="search" class="form-control" placeholder="Search" id="search"
            value="{{ request()->get('search') }}" style="width:unset;">
    </div>
    <div class="table-responsive">
        <table id="table" class="table">
            <thead>
                <tr>
                    
                    <th class="no-export">Actions</th>
                    <th class="text-center no-export">#ID<div class="table-div"><i class="ik ik-arrow-up asc"data-val="id"></i><i class="ik ik ik-arrow-down desc" data-val="id"></i></div>
                    </th>
                    @if(!@$group)
                    <th class="col_1">Group <div class="table-div"><i class="ik ik-arrow-up asc" data-val="group_id"></i><i class="ik ik ik-arrow-down desc" data-val="group_id"></i></div>
                    </th>
                    @endif
                    @if(!request()->get('product'))
                    <th class="col_2">Product <div class="table-div"><i class="ik ik-arrow-up asc" data-val="product_id"></i><i class="ik ik ik-arrow-down desc" data-val="product_id"></i>
                        </div>
                    </th>
                    @endif
                    <th class="col_3">Price <div class="table-div"><i class="ik ik-arrow-up asc" data-val="price"></i><i class="ik ik ik-arrow-down desc" data-val="price"></i></div>
                    </th>
                    <th class="col_4">Created At<div class="table-div"><i class="ik ik-arrow-up asc" data-val="created_at"></i><i class="ik ik ik-arrow-down desc" data-val="created_at"></i>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($group_products->count() > 0)
                    @foreach ($group_products as $group_product)
                        <tr>
                            <td class="no-export">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i
                                            class="ik ik-chevron-right"></i></button>
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        @if(@$group)
                                            <a href="{{ route('panel.group_products.edit', $group_product->id) }}"
                                                title="Edit Group Product" class="dropdown-item ">
                                                <li class="p-0">Edit</li>
                                            </a>
                                        @elseif(request()->get('product'))
                                            <a href="javascript:void(0);"
                                                title="Edit Group Product" data-rec="{{ $group_product }}" class="dropdown-item editrecord">
                                                <li class="p-0">Edit</li>
                                            </a>
                                            @if( $user_shop =  App\Models\UserShop::whereUserId(auth()->id())->first())
                                                <a href="javascript:void(0);"
                                                    title="Download QR" data-group_id="{{ $group_product->group_id }}" class="dropdown-item downloadQr">
                                                    <li class="p-0">Download QR</li>
                                                </a>
                                            @endif
                                            @if(AuthRole() == 'Admin')
                                                <a href="{{ route('panel.group_products.destroy', $group_product->id) }}"
                                                    title="Delete Group Product" class="dropdown-item  delete-item">
                                                    <li class=" p-0">Delete</li>
                                                </a>
                                            @endif
                                        @endif
                                    </ul>
                                </div>
                            </td>
                            <td class="text-center no-export">PRG{{ $group_product->id }}</td>
                            @if(!@$group)
                            <td class="col_1">
                                {{ fetchFirst('App\Models\Group', $group_product->group_id, 'name', '--') }}</td>
                            @endif
                            @if(!request()->get('product'))
                            <td class="col_2">
                                {{ fetchFirst('App\Models\Product', $group_product->product_id, 'title', '--') }}</td>
                            @endif
                            <td class="col_3">{{ format_price($group_product->price) }}</td>
                            <td class="col_4">{{getFormattedDateTime($group_product->created_at)}}</td>

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
        {{ $group_products->appends(request()->except('page'))->links() }}
    </div>
    <div>
        @if ($group_products->lastPage() > 1)
            <label for="">Jump To:
                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="jumpTo">
                    @for ($i = 1; $i <= $group_products->lastPage(); $i++)
                        <option value="{{ $i }}"
                            {{ $group_products->currentPage() == $i ? 'selected' : '' }}>{{ $i }}
                        </option>
                    @endfor
                </select>
            </label>
        @endif
    </div>
</div>
