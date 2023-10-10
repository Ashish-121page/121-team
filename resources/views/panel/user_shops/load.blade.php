<div class="card-body">
    <div class="d-flex flex-wrap justify-content-between mb-2">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    {{-- <option value="10" {{ $user_shops->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $user_shops->perPage() == 25 ? 'selected' : '' }}>25</option> --}}
                    <option value="50" {{ $user_shops->perPage() == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $user_shops->perPage() == 100 ? 'selected' : '' }}>100</option>
                    <option value="500" {{ $user_shops->perPage() == 500 ? 'selected' : '' }}>500</option>
                </select>
                entries
            </label>
        </div>
        <div>
            {{-- <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">Column Visibility</button> --}}
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">

                <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"
                        class="btn btn-sm">User </a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"
                        class="btn btn-sm">Name</a></li>
                {{-- <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"
                        class="btn btn-sm">Description</a></li> --}}
                {{-- <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"
                        class="btn btn-sm">Logo</a></li> --}}
                <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);" class="btn btn-sm">Contact No</a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"
                        class="btn btn-sm">Status</a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_7"><a href="javascript:void(0);"
                        class="btn btn-sm">Address</a></li> 
            </ul>
            <a href="javascript:void(0);" id="print" data-url="{{ route('panel.user_shops.print') }}"
                data-rows="{{ json_encode($user_shops) }}" class="btn btn-primary btn-sm">Print</a>
        </div>
        <input type="text" name="search" class="form-control" placeholder="Search" id="search"
            value="{{ request()->get('search') }}" style="width:unset;">
    </div>
    

    <div class="bx w-100">
        <button id="getall" class="btn btn-primary" style="float: right">Get All QR</button>
    </div>

    <div class="table-responsive">
        <table id="table" class="table">
            <thead>
                <tr>
                    <th class="no-export">Actions</th>
                    <th class="text-center no-export"># </th>
                    <th class="col_2">Business Name</th>
                    <th class="col_1">Shop  Name </th>
                    <th class="col_1"> NBD Cat ID# </th>
                    <th class="col_1">Slug</th>
                    <th class="col_2"> Products </th>
                    {{-- <th class="col_3">
                        Description <div class="table-div"><i class="ik ik-arrow-up  asc  "
                                data-val="description"></i><i class="ik ik ik-arrow-down desc"
                                data-val="description"></i></div>
                    </th> --}}
                    {{-- <th class="col_4">
                        Logo <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="logo"></i><i
                                class="ik ik ik-arrow-down desc" data-val="logo"></i></div>
                            </th> --}}
                    <th class="col_7">ORC</th>
                    <th class="col_5"> Contact No  </th>
                    <th class="col_6"> Status </th>
                    <th class="col_7"> View </th>
                    <th class="col_8"> QR </th>
                </tr>
            </thead>
            <tbody>
                @if ($user_shops->count() > 0)
                    @foreach ($user_shops as $user_shop)
                        <tr>
                            <td class="no-export">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i
                                            class="ik ik-chevron-right"></i></button>
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        <a href="{{ route('panel.user_shops.edit', [$user_shop->id,'active'=>'general']) }}"
                                            title="Edit Micro Site" class="dropdown-item">
                                            <li class="p-0">Edit</li>
                                        </a>
                                        {{-- <a href="{{ route('panel.user_shops.destroy', $user_shop->id) }}"
                                            title="Delete Micro Site" class="dropdown-item  delete-item">
                                            <li class="p-0">Delete</li>
                                        </a> --}}
                                        <a href="{{ route('panel.groups.index')."?user=". $user_shop->user_id}}" class="dropdown-item" ><li class="p-0">Price Groups</li>
                                        </a>
                                        <a href="{{ route('panel.user_shop_items.index'). "?user_id=". $user_shop->user_id}}" class="dropdown-item" ><li class="p-0">Products</li>
                                        </a>
                                    </ul>
                                </div>
                            </td>
                            <td class="text-center no-export">URSP{{ getPrefixZeros($user_shop->id) }}</td>

                            <td class="col_2">
                                <a target="_blank" href="{{ inject_subdomain('home', $user_shop->slug)}}" class="btn btn-link p-0 m-0">{{ $user_shop->name }}</a>
                            </td>
                            
                            <td class="col_1">{{ fetchFirst('App\User', $user_shop->user_id, 'name', '--') }}</td>

                            <td class="col_1">{{ fetchFirst('App\User', $user_shop->user_id, 'NBD_Cat_ID', '--') }}</td>
                            
                            <td class="col_1">{{ $user_shop->slug }}</td>
                            <td class="col_2"><a href="{{ route('panel.user_shop_items.index'). "?user_id=". $user_shop->user_id}}" class="btn btn-link">{{ getProductsCountByUserShopId($user_shop->id) ?? '0' }}</a>
                            </td>
                            {{-- <td class="col_3">{{ $user_shop->description }}</td> --}}
                            {{-- <td class="col_4"><a href="{{ asset($user_shop->logo) }}" target="_blank"
                                    class="btn-link">{{ $user_shop->logo }}</a></td> --}}
                            <td class="col_7">
                                {!! QrCode::size(50)->generate(route('pages.index',$user_shop->slug)) !!}
                            </td>
                            <td class="col_5">{{ $user_shop->contact_no ?? '--' }}</td>
                            <td class="col_6"><span class="badge badge-{{ getUserShopStatus($user_shop->status)['color'] }}">{{ getUserShopStatus($user_shop->status)['name'] }}</td>
                            <td class="col_7">
                                @php
                                    $view = App\Models\viewcount::where('micro_slug',$user_shop->slug)->get() ;
                                @endphp
                                {{ count($view) ?? 0}}
                            </td>
                            <td class="col_8">
                                <input type="checkbox" class="form-check" name="needqr" id="needqr" value="{{$user_shop->slug}}">
                            </td>

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
        {{ $user_shops->appends(request()->except('page'))->links() }}
    </div>
    <div>
        @if ($user_shops->lastPage() > 1)
            <label for="">Jump To:
                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="jumpTo">
                    @for ($i = 1; $i <= $user_shops->lastPage(); $i++)
                        <option value="{{ $i }}"
                            {{ $user_shops->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </label>
        @endif
    </div>
</div>
