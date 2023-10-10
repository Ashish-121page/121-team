<div class="card-body">
    <div class="d-flex justify-content-between mb-2">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    <option value="10" {{ $group_users->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $group_users->perPage() == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $group_users->perPage() == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $group_users->perPage() == 100 ? 'selected' : '' }}>100</option>
                </select>
                entries
            </label>
        </div>
        <div>
            <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">Column Visibility</button>
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">

                {{-- <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"class="btn btn-sm">Group </a></li> --}}
                <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);" class="btn btn-sm">User </a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);" class="btn btn-sm">User Shop </a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);" class="btn btn-sm">Created At</a></li>
            </ul>
            <a href="javascript:void(0);" id="print" data-url="{{ route('panel.group_users.print') }}"
                data-rows="{{ json_encode($group_users) }}" class="btn btn-primary btn-sm">Print</a>
        </div>
        <input type="text" name="search" class="form-control" placeholder="Search" id="search"
            value="{{ request()->get('search') }}" style="width:unset;">
    </div>
    <div class="table-responsive">
        <table id="table" class="table">
            <thead>
                <tr>
                    <th class="no-export">Actions</th>
                    <th class="text-center no-export">#ID  </th>

                    {{-- <th class="col_1">Group <div class="table-div"><i class="ik ik-arrow-up asc" data-val="group_id"></i><i class="ik ik ik-arrow-down desc" data-val="group_id"></i></div> --}}
                    </th>
                    <th class="col_2">User</th>
                    <th class="col_3">User Shop </th>
                    <th class="col_4">Created At</th>
                </tr>
            </thead>
            <tbody>
                @if ($group_users->count() > 0)
                    @foreach ($group_users as $group_user)
                        <tr>
                            <td class="no-export">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i
                                            class="ik ik-chevron-right"></i></button>
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        <a href="{{ route('panel.group_users.edit', $group_user->id) }}"
                                            title="Edit Group User" class="dropdown-item ">
                                            <li class="p-0">Edit</li>
                                        </a>
                                        <a href="{{ route('panel.group_users.destroy', $group_user->id) }}"
                                            title="Delete Group User" class="dropdown-item  delete-item">
                                            <li class=" p-0">Delete</li>
                                        </a>
                                    </ul>
                                </div>
                            </td>
                            <td class="text-center no-export">UGRP{{ getPrefixZeros($group_user->id) }}</td>
                            {{-- <td class="col_1">
                                {{ fetchFirst('App\Models\Group', $group_user->group_id, 'name', '--') }}</td> --}}
                            <td class="col_2">{{ fetchFirst('App\User', $group_user->user_id, 'name', '--') }}
                            </td>
                            <td class="col_3">
                                {{ fetchFirst('App\Models\UserShop', $group_user->user_shop_id, 'name', '--') }}</td>
                            <td class="col_3">{{getFormattedDateTime($group_user->created_at)}}</td>

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
        {{ $group_users->appends(request()->except('page'))->links() }}
    </div>
    <div>
        @if ($group_users->lastPage() > 1)
            <label for="">Jump To:
                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="jumpTo">
                    @for ($i = 1; $i <= $group_users->lastPage(); $i++)
                        <option value="{{ $i }}"
                            {{ $group_users->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </label>
        @endif
    </div>
</div>
