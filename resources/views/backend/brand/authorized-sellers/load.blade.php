<div class="card-body">
    <div class="d-flex justify-content-between mb-2">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    <option value="10" {{ $brand_users->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $brand_users->perPage() == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $brand_users->perPage() == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $brand_users->perPage() == 100 ? 'selected' : '' }}>100</option>
                </select>
                entries
            </label>
        </div>
        <div>
            <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">Column Visibility</button>
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"
                        class="btn btn-sm">Name</a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"
                        class="btn btn-sm">Status </a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"
                        class="btn btn-sm">Verified</a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"
                        class="btn btn-sm">Created At</a></li>
            </ul>
        </div>
        <input type="text" name="search" class="form-control" placeholder="Search" id="search"
            value="{{ request()->get('search') }}" style="width:unset;">
    </div>
    <div class="table-responsive">
        <table id="table" class="table">
            <thead>
                <tr>
                    <th class="no-export">Actions</th>
                    <th class="text-center no-export">#ID<div class="table-div"><i class="ik ik-arrow-up asc"
                                data-val="id"></i><i class="ik ik ik-arrow-down desc" data-val="id"></i></div>
                    </th>

                    <th class="col_1">Name</th>
                    <th class="col_2">Status</th>
                    <th class="col_4">Verified</th>
                    <th class="col_6">Created At</th>
                </tr>
            </thead>
            <tbody>
                @if ($brand_users->count() > 0)
                    @foreach ($brand_users as $brand_user)
                        <tr>
                            <td class="no-export">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i
                                            class="ik ik-chevron-right"></i></button>
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        <a href="{{ route('panel.brand_user.edit', $brand_user->id) }}"
                                            title="Edit Brand" class="dropdown-item ">
                                            <li class="p-0">Edit</li>
                                        </a>
                                        <a href="{{ route('panel.brand_user.delete', $brand_user->id) }}"
                                            title="Delete Authorized Seller" class="dropdown-item  delete-item">
                                            <li class=" p-0">Delete</li>
                                        </a>
                                    </ul>
                                </div>
                            </td>
                            <td class="text-center no-export">ASLR{{ getPrefixZeros($brand_user->id) }}</td>
                            <td class="col_2">
                                {{ fetchFirst('App\User', $brand_user->user_id, 'name', '--') }}</td>
                            <td class="col_4"><span
                                    class="badge badge-{{ getBrandStatus($brand_user->status)['color'] }}">{{ getBrandStatus($brand_user->status)['name'] }}</span>
                            </td>
                            <td class="col_1">
                                @if ($brand_user->is_verified == 1)
                                    <span class="badge badge-success">Yes</span>
                                @else
                                    <span class="badge badge-danger">No</span>
                                @endif
                            </td>
                            <td class="col_6">{{ getFormattedDateTime($brand_user->created_at) }}</td>

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
        {{ $brand_users->appends(request()->except('page'))->links() }}
    </div>
    <div>
        @if ($brand_users->lastPage() > 1)
            <label for="">Jump To:
                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="jumpTo">
                    @for ($i = 1; $i <= $brand_users->lastPage(); $i++)
                        <option value="{{ $i }}"
                            {{ $brand_users->currentPage() == $i ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                </select>
            </label>
        @endif
    </div>
</div>
