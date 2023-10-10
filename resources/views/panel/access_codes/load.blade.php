<div class="card-body">
        <div class="d-flex justify-content-between mb-2 flex-wrap">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="50"{{ $access_codes->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $access_codes->perPage() == 100 ? 'selected' : ''}}>100</option>
                        <option value="500"{{ $access_codes->perPage() == 500 ? 'selected' : ''}}>500</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    
                    <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Code</a></li>                   
                     <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Created By</a></li>                   
                      <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Redeemed User  </a></li>                   
                       <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Redeemed At</a></li>                                        
                </ul>
                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.access_codes.print') }}"  data-rows="{{json_encode($access_codes) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th class="no-export">Actions</th> 
                        <th  class="text-center no-export"># <div class="table-div"><i class="ik ik-arrow-up  asc" data-val="id"></i><i class="ik ik ik-arrow-down desc" data-val="id"></i></div></th>             
                                               
                        <th class="col_1">Code </th>
                            <th class="col_2">Created by<div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="creator_id"></i><i class="ik ik ik-arrow-down desc" data-val="creator_id"></i></div></th>
                             <th class="col_3">Redeemed User</th>
                             <th class="col_4">Redeemed At </th></tr>
                </thead>
                <tbody>
                    @if($access_codes->count() > 0)
                        @foreach($access_codes as  $access_code)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.access_codes.edit', $access_code->id) }}" title="Edit Access Code" class="dropdown-item "><li class="p-0">Edit</li></a>
                                            {{-- @if(!$access_code->redeemed_user_id && !$access_code->redeemed_at) --}}
                                                <a href="{{ route('panel.access_codes.destroy', $access_code->id) }}" title="Delete Access Code" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                            {{-- @endif --}}
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"> {{  $access_code->id ?? ''}}</td>
                                <td class="col_1"><span id="copyAccessCode">{{$access_code->code }} </span><a class="text-info btn-icon copy-payment-btn-{{ $access_code->code }} fz-12" onclick="copyTextToClipboard('{{ $access_code->code}}')"><i class="fa fa-copy"></i></a></td>
                                <td class="col_2">{{fetchFirst('App\User',$access_code->creator_id,'name','--')}}</td>
                                <td class="col_3">
                                    @if($access_code->redeemed_user_id == null)
                                        <span class="text-success">
                                            Available
                                        </span>
                                    @else 
                                        {{App\User::whereId($access_code->redeemed_user_id)->first()->name ?? "N/A"}}
                                    @endif
                                </td>
                                <td class="col_4">{{$access_code->redeemed_at }}</td> 
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
            {{ $access_codes->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($access_codes->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $access_codes->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $access_codes->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
