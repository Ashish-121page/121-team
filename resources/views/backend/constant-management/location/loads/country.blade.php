
    <div class="card-body p-0">
        <div class="d-flex flex-wrap justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10" {{ $country->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25" {{ $country->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50" {{ $country->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100" {{ $country->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">S No.</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Action</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Customer</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Role</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">Email</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"  class="btn btn-sm">Status</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_7"><a href="javascript:void(0);"  class="btn btn-sm">Join At</a></li>
                </ul>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{ request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="user_table" class="table p-0">
                <thead>
                    <tr>
                        <th class="col_1 text-center  no-export">#</th>
                        <th class="col_2  no-export">Actions</th>
                        <th class="col_3">Country Name</th>
                        <th class="col_4">Country Code</th>
                        <th class="col_5">Country Currency</th>
                        <th class="col_6">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @if($country->count() > 0)
                        @foreach($country as $item)
                            <tr>
                                <td class="text-center col_1 no-export">{{ $loop->iteration }}</td>
                                <td  class="col_2 no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.location.edit', $item->id) }}" title="Edit Country" class="btn btn-sm">Edit</a></li>
                                            <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.location.state')."?country= $item->id" }}" title="Manage States" class="btn btn-sm">States</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td  class="col_3">{{ $item->name }}</td>
                                <td  class="col_4">{{ $item->iso2 }}</td>
                                <td  class="col_5">{{ $item->currency }}</td>
                                <td  class="col_6">{{ getFormattedDate($item->created_at) }}</td>
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
            {{ $country->appends(request()->except('page'))->links() }}
        </div>
        <div>
            @if($country->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $country->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $country->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
            @endif
        </div>
    </div>
