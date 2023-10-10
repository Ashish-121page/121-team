
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10" {{ $ticket->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25" {{ $ticket->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50" {{ $ticket->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100" {{ $ticket->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Title</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Ticket Type</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Assign To</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Status</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">Created At</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"  class="btn btn-sm">Last Activity</a></li>
                </ul>
                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.admin.ticket.print') }}" data-rows="{{ json_encode($ticket) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{ request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="ticket_table" class="table">
                <thead>
                    <tr>
                        <th class="text-center no-export">#</th>
                        <th class="col_1">Title</th>
                        <th class="col_2">Ticket Type</th>
                        <th class="col_3">Assign To</th>
                        <th class="col_4">Status</th>
                        <th class="col_5">Created At</th>
                        <th class="col_6">Last Activity</th>
                    </tr>
                </thead>
                <tbody>
                    @if($ticket->count() > 0)
                        @foreach($ticket as $item)
                            <tr>
                                <td class="text-center no-export">{{ $loop->iteration }}</td>
                                <td class="col_1"><a class="btn btn-link" href="{{ route('panel.admin.ticket.show', $item->id) }}">{{ $item->title }}</a></td>
                                <td class="col_2">
                                    <span class="badge badge-primary">{{fetchFirst('App\Models\Category',$item->ticket_type_id,'name','--') }}</span>
                                </td>
                                <td class="col_3">
                                    <a href="{{ route('panel.users.show', $item->assigned_to) }}">{{ NameById($item->assigned_to)}}</a>
                                </td>
                                <td class="col_4">
                                    @if ($item->is_closed == 1)
                                        <span class="badge badge-success">{{ 'Active' }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ 'Closed' }}</span>
                                    @endif
                                </td>
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
            {{ $ticket->appends(request()->except('page'))->links() }}
        </div>
        <div>
            @if($ticket->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $ticket->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $ticket->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
            @endif
        </div>
    </div>
