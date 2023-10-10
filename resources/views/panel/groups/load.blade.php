<div class="card-body">
    <div class="d-flex flex-wrap justify-content-between mb-2">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    <option value="10" {{ $groups->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $groups->perPage() == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $groups->perPage() == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $groups->perPage() == 100 ? 'selected' : '' }}>100</option>
                </select>
                entries
            </label>
        </div>
        <div>
            {{-- <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">Column Visibility</button> --}}
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">

                {{-- <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"
                        class="btn btn-sm">User </a></li> --}}
                <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"
                        class="btn btn-sm">Name</a></li>
                {{-- <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"
                        class="btn btn-sm">Type</a></li> --}}
                <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"
                        class="btn btn-sm">Product</a></li>
            </ul>
            <a href="javascript:void(0);" id="print" data-url="{{ route('panel.groups.print') }}"
                data-rows="{{ json_encode($groups) }}" class="btn btn-primary btn-sm">Print</a>
        </div>
        <input type="text" name="search" class="form-control" placeholder="Search" id="search"
            value="{{ request()->get('search') }}" style="width:unset;">
    </div>
    <div class="table-responsive">
        <table id="table" class="table">
            <thead>
                <tr>
                    <th class="no-export">Actions</th>
                    <th class="text-center no-export"># <div class="table-div"><i class="ik ik-arrow-up asc" data-val="id"></i><i class="ik ik ik-arrow-down desc" data-val="id"></i></div>
                    </th>
                    <th class="col_2">Name </th> 
                    @if(AuthRole() != 'Admin')    
                        <th class="col_2">QRcode</th>    
                    @endif 
                </tr>
            </thead>
            <tbody>
                @if ($groups->count() > 0)
                    @foreach ($groups as $group)
                        <tr>
                            <td class="no-export">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i
                                            class="ik ik-chevron-right"></i></button>
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        @if ($group->user_id == request()->get('user') || !request()->has('user'))
                                            <a href="{{ route('panel.groups.edit', $group->id)}}{{ '?user='.request()->get('user') }}" title="Edit Group"
                                                class="dropdown-item ">
                                                <li class="p-0">Edit</li>
                                            </a>
                                            <a href="{{ route('panel.groups.destroy',$group->id) }}" title="Delete Group"
                                                class="dropdown-item  delete-item">
                                                <li class=" p-0">Delete</li>
                                            </a>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                            <td class="text-center no-export">GRP{{ getPrefixZeros($group->id) }}</td>
                            <td class="col_2">{{ $group->name ?? ''}} </td>
                            @if(AuthRole() != 'Admin')
                                <td>
                                    @php
                                        $user_shop = App\Models\UserShop::whereUserId(auth()->id())->first();
                                        $barcode_img_sm = QrCode::size(70)->generate(route('microsite.proxy')."?page=home&is_scan=1&shop=$user_shop->slug&g_id=".$group->id);
                                        $barcode_img_lg = QrCode::size(250)->generate(route('microsite.proxy')."?page=home&is_scan=1&shop=$user_shop->slug&g_id=".$group->id);
                                        // $barcode_img_sm = QrCode::size(70)->generate(inject_subdomain('home', $user_shop->slug, false, false)."?g_id=".$group->id);
                                        // $barcode_img_lg = QrCode::size(250)->generate(inject_subdomain('home', $user_shop->slug, false, false)."?g_id=".$group->id);
                                    @endphp
                                    <a data-g_id="{{$group->id}}" data-email="{{auth()->user()->email }}" data-phone="{{auth()->user()->phone}}" data-group_name="{{ $group->name }}" data-name="{{$user_shop->name}}" class="barCodeModalBtn btn btn-outline-secondary btn-sm" href="javascript:void(0)" type="button">
                                        Show
                                        <div class="text-center d-none" id="barcode-{{$group->id}}">
                                            {!! $barcode_img_lg !!}
                                        </div> 
                                    </a>
                                    {{-- <p>{{inject_subdomain('home', $user_shop->slug, false, false)."?g_id=".$group->id}}</p> --}}
                                </td>
                            @endif 
                            
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="8">
                            <span class="mx-auto">No Groups Yet! </span>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer d-flex justify-content-between">
    <div class="pagination">
        {{ $groups->appends(request()->except('page'))->links() }}
    </div>
    <div>
        @if ($groups->lastPage() > 1)
            <label for="">Jump To:
                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="jumpTo">
                    @for ($i = 1; $i <= $groups->lastPage(); $i++)
                        <option value="{{ $i }}" {{ $groups->currentPage() == $i ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                </select>
            </label>
        @endif
    </div>
</div>
