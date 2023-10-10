
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10" {{ $permissions->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25" {{ $permissions->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50" {{ $permissions->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100" {{ $permissions->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                
           </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{ request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="permissions_table" class="table">
                <thead>
                    <tr>
                        <th>{{ __('Permission')}}</th>
                        <th>{{ __('Assigned Role')}}</th>
                        <th>{{ __('Action')}}</th>
                    </tr>
                </thead>
                    <tbody>
                        @if($permissions->count() > 0)
                        @foreach($permissions as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>
                                @foreach ($item->roles()->get() as $role)
                                <span class="badge badge-dark m-1">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if(auth()->user()->can('manage_permission'))
                                <a href="{{ url('panel/permission/delete/'.$item->id) }}"><i class="ik ik-trash-2 f-16 text-red"></i></a>
                                @endif
                            </td>
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
            {{ $permissions->appends(request()->except('page'))->links() }}
        </div>
        <div>
            @if($permissions->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $permissions->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $permissions->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
            @endif
        </div>
    </div>
