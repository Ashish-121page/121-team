
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10" {{ $city->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25" {{ $city->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50" {{ $city->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100" {{ $city->perPage() == 100 ? 'selected' : ''}}>100</option>
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
                    <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">City Name</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Created At</a></li>
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
                        <th class="col_3">City Name</th>
                        <th class="col_4">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @if($city->count() > 0)
                        @foreach($city as $item)
                        <tr>
                            <td class="col_1 text-center no-export">{{ $loop->iteration }}</td>
                            <td class="col_2 no-export">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        <li class="dropdown-item p-0"><a href="javascript:void(0);" data-row="{{ $item }}" title="Edit City" class="btn btn-sm editCity">Edit</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td class="col_3">{{ $item->name }}</td>
                            <td class="col_4">{{ getFormattedDate($item->created_at) }}</td>
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
            {{ $city->appends(request()->except('page'))->links() }}
        </div>
        <div>
            @if($city->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $city->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $city->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
            @endif
        </div>
    </div>
