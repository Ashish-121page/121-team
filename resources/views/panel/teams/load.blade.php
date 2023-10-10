<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $teams->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $teams->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $teams->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $teams->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    
                    <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">User Shop  </a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Name</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Image</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Designation</a></li>                                        
                </ul>
                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.teams.print') }}"  data-rows="{{json_encode($teams) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th class="no-export">Actions</th> 
                        <th  class="text-center no-export"># <div class="table-div"><i class="ik ik-arrow-up  asc" data-val="id"></i><i class="ik ik ik-arrow-down desc" data-val="id"></i></div></th>             
                                               
                        <th class="col_1">
                            User Shop    <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="user_shop_id"></i><i class="ik ik ik-arrow-down desc" data-val="user_shop_id"></i></div></th>
                                                    <th class="col_2">
                            Name <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="name"></i><i class="ik ik ik-arrow-down desc" data-val="name"></i></div></th>
                                                    <th class="col_3">
                            Image <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="image"></i><i class="ik ik ik-arrow-down desc" data-val="image"></i></div></th>
                                                    <th class="col_4">
                            Designation <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="designation"></i><i class="ik ik ik-arrow-down desc" data-val="designation"></i></div></th>
                                                                        </tr>
                </thead>
                <tbody>
                    @if($teams->count() > 0)
                                                    @foreach($teams as  $team)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.teams.edit', $team->id) }}" title="Edit Team" class="dropdown-item "><li class="p-0">Edit</li></a>
                                            <a href="{{ route('panel.teams.destroy', $team->id) }}" title="Delete Team" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"> {{  $loop->iteration }}</td>
                                    <td class="col_1">{{fetchFirst('App\Models\UserShop',$team->user_shop_id,'name','--')}}</td>
                                  <td class="col_2">{{$team->name }}</td>
                                  <td class="col_3"><a href="{{ asset($team->image) }}" target="_blank" class="btn-link">{{$team->image }}</a></td>
                                  <td class="col_4">{{$team->designation }}</td>
                                  
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
            {{ $teams->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($teams->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $teams->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $teams->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
