<div class="card-body">
    <div class="d-flex justify-content-between flex-wrap mb-2">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    {{-- <option value="10" {{ $brands->perPage() == 10 ? 'selected' : '' }}>10</option> --}}
                    {{-- <option value="25" {{ $brands->perPage() == 25 ? 'selected' : '' }}>25</option> --}}
                    <option value="50" {{ $brands->perPage() == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $brands->perPage() == 100 ? 'selected' : '' }}>100</option>
                    <option value="500" {{ $brands->perPage() == 500 ? 'selected' : '' }}>500</option>
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
                        class="btn btn-sm">Name</a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"
                        class="btn btn-sm">Products</a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"
                        class="btn btn-sm">Managed By </a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"
                        class="btn btn-sm">Logo</a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"
                        class="btn btn-sm">Status</a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"
                        class="btn btn-sm">Created At</a></li>
                {{-- <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"
                        class="btn btn-sm">Short Text</a></li> --}}
            </ul>
            <a href="javascript:void(0);" id="print" data-url="{{ route('panel.brands.print') }}"
                data-rows="{{ json_encode($brands) }}" class="btn btn-primary btn-sm">Print</a>
        </div>
        <input type="text" name="search" class="form-control" placeholder="Search" id="search"
            value="{{ request()->get('search') }}" style="width:unset;">
    </div>
    <div class="table-responsive">
        <table id="table" class="table">
            <thead>
                <tr>
                    <th class="no-export">Actions</th>
                    <th>logo</th>
                    <th class="text-center no-export">#ID
                    </th>

                    <th class="col_1">Name 
                    </th>
                    <th class="col_3">Products 
                    </th>
                    <th class="col_2">Managed By</th>
                    <th class="col_5">Request</th>
                    <th class="col_4">Status </th>
                    <th class="col_7">Verified </th>
                    <th class="col_6">Created At 
                    </th>
                    {{-- <th class="col_5">Short Text<div class="table-div"><i class="ik ik-arrow-up  asc"data-val="short_text"></i><i class="ik ik ik-arrow-down desc" data-val="short_text"></i>
                        </div>
                    </th> --}}
                </tr>
            </thead>
            <tbody>
                @if ($brands->count() > 0)
                    @foreach ($brands as $brand)
                        <tr>
                            <td class="no-export">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i
                                            class="ik ik-chevron-right"></i></button>
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        <a href="{{ route('panel.brands.edit', [$brand->id,'active' => 'appearance' ]) }}" title="Edit Brand"
                                            class="dropdown-item ">
                                            <li class="p-0">Edit</li>
                                        </a>
                                        @if(AuthRole() == "Admin")
                                            <a href="{{ route('panel.brands.destroy', $brand->id) }}" title="Delete Brand"
                                                class="dropdown-item  delete-item">
                                                <li class=" p-0">Delete</li>
                                            </a>
                                            @if($brand->user_id != null)
                                            <a href="{{ url('panel/user/login-as/'.$brand->user_id)}}"><li class="dropdown-item">Login As</li></a>
                                            @endif
                                        @endif
                                        <a href="{{ route('panel.products.index') }}{{'?id='.$brand->id}}" title="Manage Product"
                                            class="dropdown-item">
                                            <li class=" p-0">Manage Product</li>
                                        </a>
                                        <a href="{{ route('panel.products.create')."?action=branded&id=".$brand->id}}" title="Manage Product"
                                            class="dropdown-item">
                                            <li class=" p-0">Add Product</li>
                                        </a>
                                         @if(AuthRole() == "Admin")
                                            <a href="{{ route('panel.brand_user.index') }}{{'?id='.$brand->id.'&status=1'}}" title="Authorized Seller"
                                                class="dropdown-item">
                                                <li class=" p-0">Authorized Seller</li>
                                            </a>
                                        @endif
                                        @if(AuthRole() == "User")
                                            <a href="{{ route('panel.brand.claim.create',$brand->id) }}" title="Claim Brand"
                                                class="dropdown-item">
                                                <li class=" p-0">Claim</li>
                                            </a>
                                        @endif
                                        @if(AuthRole() == "User" && auth()->user()->is_supplier == 1 && isBrandBO($brand->id, auth()->id()))
                                        <a href="{{ route('panel.brand_user.index') }}{{'?id='.$brand->id.'&status=0'}}" title="Authorized Seller"
                                            class="dropdown-item">
                                            <li class=" p-0">Owner Request</li>
                                        </a>
                                        @elseif(AuthRole() == "Admin")
                                        <a href="{{ route('panel.brand_user.index') }}{{'?id='.$brand->id.'&status=0'}}" title="Authorized Seller"
                                            class="dropdown-item">
                                            <li class=" p-0">Owner Request</li>
                                        </a>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                            <td>
                                @php
                                    $brand_logo = App\Models\Media::whereType('Brand')->whereTypeId($brand->id)->first();
                                @endphp
                                @if($brand_logo != null)
                                    <img src="{{ ($brand_logo && $brand_logo->path) ? asset($brand_logo->path) : asset('frontend/assets/img/placeholder.png') }}" alt="" style="height:60px;width:60px;object-fit:contain;" class="rounded">
                                @endif
                            </td>
                            <td class="text-center no-export">BRND{{ getPrefixZeros($brand->id) }}
                            
                                @if(AuthRole() == "User" && auth()->user()->is_supplier == 1 && isBrandBO($brand->id, auth()->id()))
                                    @if(App\Models\BrandUser::whereBrandId($brand->id)->whereStatus(0)->get()->count() > 0)
                                        <a href="{{ route('panel.brand_user.index') }}{{'?id='.$brand->id.'&status=0'}}" class="ml-1">
                                                <i title="New Seller Requests" class="fa fa-hourglass fa-spin text-danger fa-sm"></i>
                                        </a>
                                    @endif
                                @elseif(AuthRole() == "Admin")
                                        @if(App\Models\BrandUser::whereBrandId($brand->id)->whereStatus(0)->get()->count() > 0)
                                        <a href="{{ route('panel.brand_user.index') }}{{'?id='.$brand->id.'&status=0'}}" class="ml-1">
                                                <i title="New Seller Requests" class="fa fa-hourglass fa-spin text-danger fa-sm"></i>
                                        </a>
                                    @endif
                                @endif

                               
                            </td>
                            <td class="col_1">{{ $brand->name }}</td>
                            <td class="col_3">{{ getProductByBrandId($brand->id, 'count') }}</td>
                            <td class="col_2">{{ fetchFirst('App\User', $brand->user_id, 'name', '--') }} </td>
                            <td class="col_5">{{ getBrandUserRequestType($brand->id) }}</td>
                           
                            {{-- @dd(getBrandStatus(1)) --}}
                            {{-- <td class="col_3"><a href="{{ asset($brand->logo) }}" target="_blank"class="btn-link">{{ $brand->logo }}</a></td> --}}
                            <td class="col_4"><span class="badge badge-{{ getBrandStatus($brand->status)['color']}}">{{ getBrandStatus($brand->status)['name']}}</span></td> 
                            <td class="col_7"><span class="badge badge-{{ $brand->is_verified ? "success" : "danger"}}">{{ $brand->is_verified == 1 ? "Verified" : "Not Verified"}}</span></td>
                            <td class="col_6">{{ getFormattedDateTime($brand->created_at) }}</td>
                            {{-- <td class="col_5">{{ $brand->short_text }}</td> --}}

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
        {{ $brands->appends(request()->except('page'))->links() }}
    </div>
    <div>
        @if ($brands->lastPage() > 1)
            <label for="">Jump To:
                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="jumpTo">
                    @for ($i = 1; $i <= $brands->lastPage(); $i++)
                        <option value="{{ $i }}" {{ $brands->currentPage() == $i ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                </select>
            </label>
        @endif
    </div>
</div>
