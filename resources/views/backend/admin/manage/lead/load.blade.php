
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10" {{ $lead->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25" {{ $lead->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50" {{ $lead->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100" {{ $lead->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Name</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Assign To</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Type</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Source</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">Created At</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"  class="btn btn-sm">Last Activity</a></li>
                </ul>
                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.admin.lead.print') }}" data-rows="{{ json_encode($lead) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{ request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="lead_table" class="table">
                <thead>
                    <tr>
                        <th class="text-center no-export">#</th>
                        <th class="no-export">Actions</th>
                        <th class="col_1">Name</th>
                        <th class="col_2">Assign To</th>
                        <th class="col_3">Type</th>
                        <th class="col_4">Source</th>
                        <th class="col_5">Created At</th>
                        <th class="col_6">Last Activity</th>
                    </tr>
                </thead>
                    <tbody>
                        @if($lead->count() > 0)
                        @foreach($lead as $item)
                            <tr>
                                <td class="text-center no-export">{{ $loop->iteration }}</td>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <li class="dropdown-item p-0"><a href="{{ route('panel.admin.lead.show', $item->id) }}" title="View Lead" class="btn btn-sm">Show</a></li>
                                            <li class="dropdown-item p-0"><a href="{{ route('panel.admin.lead.edit', $item->id) }}" title="Edit Lead" class="btn btn-sm">Edit</a></li>
                                            <li class="dropdown-item p-0"><a href="{{ route('panel.admin.lead.delete', $item->id) }}" title="Edit Lead" class="btn btn-sm delete-item">Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td class="col_1"><a class="btn btn-link" href="{{ route('panel.admin.lead.show', $item->id) }}">{{ $item->name }}</a>
                                <td class="col_2">{{ NameById($item->user_id) }}</td>
                                </td>
                                <td class="col_3">
                                    <span class="badge badge-primary">
                                        {{fetchFirst('App\Models\Category',$item->lead_type_id,'name','--') }}</td>
                                    </span>
                                <td class="col_4">{{fetchFirst('App\Models\Category',$item->lead_source_id,'name','--') }}</td>
                                <td class="col_5">{{ getFormattedDate($item->created_at) }}</td>
                                <td class="col_6">{{ getFormattedDate($item->updated_at) }}</td>
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
            {{ $lead->appends(request()->except('page'))->links() }}
        </div>
        <div>
            @if($lead->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $lead->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $lead->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
            @endif
        </div>
    </div>
