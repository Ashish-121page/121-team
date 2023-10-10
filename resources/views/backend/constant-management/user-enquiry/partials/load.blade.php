<div class="card-body">
    <div class="d-flex justify-content-between mb-2 flex-wrap">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    <option value="50"{{ $user_enq->perPage() == 50 ? 'selected' : ''}}>50</option>
                    <option value="100"{{ $user_enq->perPage() == 100 ? 'selected' : ''}}>100</option>
                    <option value="500"{{ $user_enq->perPage() == 500 ? 'selected' : ''}}>500</option>
                </select>
                entries
            </label>
        </div>
        <div>
            <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
            {{-- <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">Column Visibility</button> --}}
        </div>
        <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
    </div>
    <div class="table-responsive">
        <table id="table" class="table">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Actions</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Number</th>
                    <th title="Access code">Code</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user_enq as $item)
                    <tr>
                        <td class="text-center">{{ $item->id }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                    <li class="dropdown-item p-0"><a href="{{  route('panel.constant_management.user_enquiry.show', $item->id) }}" title="View Lead Contact" class="btn btn-sm">Show</a></li>
                                    <li class="dropdown-item p-0"><a href="{{  route('panel.constant_management.user_enquiry.edit', $item->id) }}" title="Edit Lead Contact" class="btn btn-sm">Edit</a></li>
                                    <li class="dropdown-item p-0"><a href="{{  route('panel.constant_management.user_enquiry.delete', $item->id) }}" title="Edit Lead Contact" class="btn btn-sm delete-item">Delete</a></li>
                                  </ul>
                            </div>
                        </td>
                        <td>{{ $item->name }}</td>
                        <td>{{fetchFirst('App\Models\Category',$item->category_id,'name','--') }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->subject }}</td>
                        <td>{{ $item->contact_number ?? '--'}}</td>
                        <td>{{ $item->code ?? '--'}}</td>
                        <td>@if ($item->status == 0)
                            <span class="badge badge-warning">Pending</span>
                            @elseif($item->status == 1)
                            <span class="badge badge-success">Solved</span>
                            @endif
                        </td>
                        <td>{{getFormattedDateTime($item->created_at)}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<div class="card-footer d-flex justify-content-between">
    <div class="pagination">
        {{ $user_enq->appends(request()->except('page'))->links() }}
    </div>
    <div>
       @if($user_enq->lastPage() > 1)
            <label for="">Jump To: 
                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                    @for ($i = 1; $i <= $user_enq->lastPage(); $i++)
                        <option value="{{ $i }}" {{ $user_enq->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </label>
       @endif
    </div>
</div>

