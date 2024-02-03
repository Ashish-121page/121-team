
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        {{-- <option value="10" {{ $users->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25" {{ $users->perPage() == 25 ? 'selected' : ''}}>25</option> --}}
                        <option value="50" {{ $users->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100" {{ $users->perPage() == 100 ? 'selected' : ''}}>100</option>
                        <option value="500" {{ $users->perPage() == 500 ? 'selected' : ''}}>500</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">S No.</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Action</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Customer</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Role</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">Email</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"  class="btn btn-sm">Status</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_7"><a href="javascript:void(0);"  class="btn btn-sm">Join At</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_8"><a href="javascript:void(0);"  class="btn btn-sm">NBD Cat ID#</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_9"><a href="javascript:void(0);"  class="btn btn-sm">User Type</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_10"><a href="javascript:void(0);"  class="btn btn-sm">Last Login</a></li>
                </ul>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{ request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="user_table" class="table p-0">
                <thead>
                    <tr>
                        <th class="col_1 text-center no-export">{{ __('S No.')}}</th>
                        <th class="col_2 no-export">{{ __('Action')}}</th>
                        <th class="col_3">{{ __('Customer')}}</th>
                        <th class="col_8">{{ __('NBD Cat ID#')}}</th>
                        <th class="col_10">{{ __('Last Login')}}</th>
                        <th class="col_4">{{ __('Role')}}</th>
                        <th class="col_5">{{ __('eKyc')}}</th>
                        <th class="col_6">{{ __('Email')}}</th>
                        <th class="col_6">{{ __('Mobile')}}</th>
                        <th class="col_7">{{ __('Status')}}</th>
                        <th class="col_8">{{ __('Join At')}}</th>
                        <th class="col_9">{{ __('User Type')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @if($users->count() > 0)
                        @foreach ($users as $item)
                        <tr>
                            <td class="col_1 text-center no-export">{{ $loop->iteration }}</td>
                            <td class="col_2 no-export">
                                @if(Auth::user()->can('manage_user') && $item->name != 'Super Admin')
                                <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action<i class="ik ik-chevron-right"></i>
                                        </button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ url('panel/user/'.$item->id)}}"><li class="dropdown-item">Edit</li></a>
                                            @if (authRole() == "Admin" || authRole() == "Super Admin")
                                                <a class="delete-item" href="{{ url('panel/user/delete/'.$item->id)}}"><li class="dropdown-item">Delete</li></a>
                                                @if(UserRole($item->id)['name'] != "Marketer")
                                                    <a href="{{ route('panel.user_shop_items.index')."?user_id=".$item->id}}" class="a-item dropdown-item" ><li class="">Products</li></a>
                                                @endif
                                                <a href="{{ url('panel/user/login-as/'.$item->id)}}"><li class="dropdown-item">Login As</li></a>
                                            @endif
                                            <li class="dropdown-submenu">
                                                <a class="dropdown-item" tabindex="-1" href="#">Status</a>
                                                <ul class="dropdown-menu">
                                                    @if ($item->status != 0)
                                                        <a tabindex="-1" href="{{ route('panel.user.status.update', [$item->id,0])}}"><li class="dropdown-item">Inactive</li></a>
                                                    @endif
                                                    @if($item->status != 1)
                                                        <a tabindex="-1" href="{{ route('panel.user.status.update', [$item->id,1])}}"><li class="dropdown-item">Active</li></a>
                                                    @endif
                                                    {{-- @if($item->status != 2)
                                                    <a tabindex="-1" href="{{ route('panel.user.status.update', [$item->id,2])}}"><li class="dropdown-item">Lock</li></a>
                                                    @endif
                                                    @if($item->status != 3)
                                                    <a tabindex="-1" href="{{ route('panel.user.status.update', [$item->id,3])}}"><li class="dropdown-item">Block</li></a>
                                                    @endif --}}
                                                </ul>
                                            </li>
                                        </ul>
                                </div>
                                @endif
                            </td>
                            @php
                                $user  = App\User::with('roles', 'permissions')->find($item->id);
                                $user_role = $user->roles->first();
                                $user_rec = App\User::whereId($item->id)->first();
                                $user_shop = App\Models\UserShop::whereUserId($item->id)->first();
                            @endphp
                            <td class="col_3">
                               <a class="@if($user_role->name == 'User') btn btn-link m-0 p-1 @endif" @if($user_role->name == 'User')  href="{{ route('panel.user_shops.edit', $user_shop->id) }}?active=shop-details" @else href="#" @endif>{{ $item->name}}
                                @if ($item->ekyc_status == 1) <i class="fa fa-check-circle text-success fa-sm"></i> @endif
                                @if ($item->is_supplier == 1) <i class="fas fa-store-alt text-danger fa-sm"></i> @endif</a>
                            </td>

                            <td class="col_3">
                                <span>{{ __($item->NBD_Cat_ID) ?? "-" }}</span>
                            </td>

                            <td class="col_10">
                                <span class="d-flex flex-wrap justify-content-center ">
                                    {{-- {{ $item->last_login_at ? getFormattedDate($item->last_login_at) : "Not Logged In Yet" }} --}}

                                    @if ($item->last_login_at)
                                        {{ getFormattedDate($item->last_login_at) }}
                                        <button class="btn btn-outline-info" type="button">
                                            {{ $item->last_login_at ? \Carbon\Carbon::parse($item->last_login_at)->diffForHumans() : "" }}
                                        </button>
                                    @else
                                        <button class="btn btn-outline-danger" type="button">
                                            Not Logged In Yet
                                        </button>
                                    @endif

                                </span>
                            </td>

                            <td class="col_4">{{ implode(' , ', $item->getRoleNames()->toArray()) }}</td>
                            <td class="col_5">

                                <span class="badge badge-{{ getEkycStatus($item->ekyc_status)['color'] }} m-1">
                                   {{ getEkycStatus($item->ekyc_status)['name'] }}
                                </span>
                            </td>
                            <td class="col_6">{{ $item->email }}</td>
                            <td class="col_6">{{ $item->phone }}</td>
                            <td class="col_7">
                                <span class="badge badge-{{ getStatus($item->status)['color']}} m-1">
                                    {{ getStatus($item->status)['name']}}
                                </span>
                            </td>
                            <td class="col_8">{{ getFormattedDate($item->created_at) }}</td>
                            <td class="col_8">{{ $item->account_type ?? "--" }}</td>
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
            {{ $users->appends(request()->except('page'))->links() }}
        </div>
        <div>
            @if($users->lastPage() > 1)
                <label for="">Jump To:
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $users->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $users->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
            @endif
        </div>
    </div>
