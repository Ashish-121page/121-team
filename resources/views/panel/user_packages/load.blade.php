<div class="card-body">
    <div class="d-flex flex-wrap justify-content-between mb-2">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    <option value="10"{{ $user_packages->perPage() == 10 ? 'selected' : ''}}>10</option>
                    <option value="25"{{ $user_packages->perPage() == 25 ? 'selected' : ''}}>25</option>
                    <option value="50"{{ $user_packages->perPage() == 50 ? 'selected' : ''}}>50</option>
                    <option value="100"{{ $user_packages->perPage() == 100 ? 'selected' : ''}}>100</option>
                    <option value="500"{{ $user_packages->perPage() == 500 ? 'selected' : ''}}>500</option>
                </select>
                entries
            </label>
        </div>
        <div>
            <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
            {{-- <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button> --}}
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">User  </a></li>                   
                <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Package  </a></li>                    
                <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Order  </a></li>                    
                <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">From</a></li>                    
                <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">To</a></li>                    
                <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"  class="btn btn-sm">Limit</a></li>                                        
            </ul>
            <a href="javascript:void(0);" id="print" data-url="{{ route('panel.user_packages.print') }}"  data-rows="{{json_encode($user_packages) }}" class="btn btn-primary btn-sm">Print</a>
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
                        User    
                        <div class="table-div"></th>
                    <th class="col_1">
                        Mobile No    
                        <div class="table-div"></th>
                    <th class="col_1">
                        Slug    
                        <div class="table-div"></th>
                        <th class="col_2">
                        Package    
                        <div class="table-div"></th>
                        <th class="col_3">
                        Order    <div class="table-div"></th>
                        <th class="col_4">
                        At <div class="table-div"></th>
                        <th class="col_6">
                        Limit <div class="table-div"></th>
                </tr>
            </thead>
            <tbody>
                @if($user_packages->count() > 0)
                     @foreach($user_packages as  $user_package)
                        <tr>
                            <td class="no-export">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        <a href="{{ route('panel.user_packages.edit', $user_package->id) }}" title="Edit User Package" class="dropdown-item "><li class="p-0">Change Package</li></a>
                                        <a href="{{ route('panel.user_packages.destroy', $user_package->id) }}" title="Delete User Package" class="dropdown-item  delete-item"><li class=" p-0">Remove Pacakage</li></a>
                                    </ul>
                                </div> 
                            </td>
                            <td  class="text-center no-export"> {{  $loop->iteration }}</td>
                                <td class="col_1">
                                    <a href="{{ route('panel.orders.invoice', $user_package->order_id) }}">{{$user_package->user->name ?? '--'}}</a>
                                </td>
                                <td>{{$user_package->user->phone ?? '--'}}</td>
                                <td>{{$user_package->userShop->slug ?? '--'}}</td>
                                  <td class="col_2">{{fetchFirst('App\Models\Package',$user_package->package_id,'name','--')}}
                                    <br>
                                    {{getFormattedDate($user_package->from )}} - {{getFormattedDate($user_package->to) }}
                                </td>
                                  <td class="col_3">ORID{{$user_package->order_id}}</td>
                              <td class="col_4">{{getFormattedDate($user_package->created_at )}}</td>
                              <td class="col_6">
                                @php
                                    $temp_limit = json_decode($user_package->limit);
                                @endphp  

                                @if($temp_limit != null)
                                   <ul>
                                        @foreach ($temp_limit as $index => $item)
                                            <li> {{ @str_replace('_',' ',\Str::title($index)) }} : {{ $item }}</li>
                                        @endforeach
                                   </ul>
                                @else 
                                <ul>
                                    <li> - </li>
                                </ul>
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
        {{ $user_packages->appends(request()->except('page'))->links() }}
    </div>
    <div>
       @if($user_packages->lastPage() > 1)
            <label for="">Jump To: 
                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                    @for ($i = 1; $i <= $user_packages->lastPage(); $i++)
                        <option value="{{ $i }}" {{ $user_packages->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </label>
       @endif
    </div>
</div>
