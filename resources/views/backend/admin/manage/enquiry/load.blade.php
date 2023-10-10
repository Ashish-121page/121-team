
    <div class="card-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        {{-- <option value="10" {{ $enquiry->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25" {{ $enquiry->perPage() == 25 ? 'selected' : ''}}>25</option> --}}
                        <option value="50" {{ $enquiry->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100" {{ $enquiry->perPage() == 100 ? 'selected' : ''}}>100</option>
                        <option value="100" {{ $enquiry->perPage() == 100 ? 'selected' : ''}}>100</option>
                        
                    </select>
                    entries
                </label>
            </div>
            <div>
                {{-- <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button> --}}
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Title</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Enquiry Type</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Assign To</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Status</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">Created At</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"  class="btn btn-sm">Last Activity</a></li>
                </ul>
                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.admin.enquiry.print') }}" data-rows="{{ json_encode($enquiry) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{ request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="enquiry_table" class="table">
                <thead>
                    <tr>
                        <th class="text-center no-export">#</th>
                        <th class="col_1">ID</th>
                        {{-- <th class="col_1">Access Code</th> --}}
                        {{-- <th class="col_2">Enquiry Type</th>
                        <th class="col_3">Assign To</th> --}}
                        <th class="col_3">Customer</th>
                        <th class="col_4">Status</th>
                        <th class="col_5">Created At</th>
                        <th class="col_6">Last Activity</th>
                    </tr>
                </thead>
                <tbody>
                
                    @if($enquiry->count() > 0)
                        @foreach($enquiry as $item)
                        {{-- @dd( $item) --}}
                            <tr>
                                <td class="text-center no-export">{{ $loop->iteration }}</td>
                                <td class="col_1"><a class="btn btn-link" href="{{ route('panel.admin.enquiry.show', $item->id) }}">ENQ{{ $item->id }}</a></td>
                                <td class="col_5">{{ NameById($item->user_id) }}</td>
                                {{-- <td class="col_4">{{ $item->code}}</td> --}}
                                {{-- <td class="col_2">
                                    <span class="badge badge-secondary">{{fetchFirst('App\Models\Category',$item->enquiry_type_id,'name','--') }}</span>
                                </td>
                                <td class="col_3">
                                    <a href="{{ route('panel.users.show', $item->assigned_to) }}">{{ NameById($item->assigned_to)}}</a>
                                </td> --}}
                                <td class="col_4"><span class="badge badge-{{ getEnquiryStatus($item->status)['color'] }}">{{ getEnquiryStatus($item->status)['name'] }}</span></td>
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
            {{ $enquiry->appends(request()->except('page'))->links() }}
        </div>
        <div>
            @if($enquiry->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $enquiry->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $enquiry->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
            @endif
        </div>
    </div>
