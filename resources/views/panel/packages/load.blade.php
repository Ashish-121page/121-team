<div class="card-body">
        <div class="d-flex flex-wrap justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        {{-- <option value="10"{{ $packages->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $packages->perPage() == 25 ? 'selected' : ''}}>25</option> --}}
                        <option value="50"{{ $packages->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $packages->perPage() == 100 ? 'selected' : ''}}>100</option>
                        <option value="500"{{ $packages->perPage() == 500 ? 'selected' : ''}}>500</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                {{-- <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button> --}}
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Name</a></li> 
                    <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Price</a></li>                    
                    <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Duration</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">Add to Site</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"  class="btn btn-sm">Custom Proposals</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_7"><a href="javascript:void(0);"  class="btn btn-sm">Product Uploads</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_8"><a href="javascript:void(0);"  class="btn btn-sm">Is Published</a></li>                                        
                </ul>
                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.packages.print') }}"  data-rows="{{json_encode($packages) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th class="no-export">Actions</th> 
                        <th  class="text-center no-export"># <div class="table-div"><i class="ik ik-arrow-up  asc" data-val="id"></i><i class="ik ik ik-arrow-down desc" data-val="id"></i></div></th>             
                                               
                        <th class="col_1">Name</th>
                            <th class="col_3">Price </th>
                            <th class="col_4">Duration </th>
                            <th class="col_5">Add to Site </th>
                            <th class="col_6">Custom Proposals </th>
                            <th class="col_7">Product Uploads </th>
                            <th class="col_8">Is Published </th>
                    </tr>
                </thead>
                <tbody>
                    @if($packages->count() > 0)
                        @foreach($packages as  $package)
                        @php
                            $limits = json_decode($package->limit,true);
                        @endphp
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.packages.edit', $package->id) }}" title="Edit Package" class="dropdown-item "><li class="p-0">Edit</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"> {{  $loop->iteration }}</td>
                                <td class="col_1">{{$package->name }}</td>
                                  <td class="col_3">{{format_price($package->price )}}</td>
                                  <td class="col_4">{{$package->duration }}</td>
                                  <td class="col_5">{{$limits['add_to_site'] }}</td>
                                  <td class="col_6">{{$limits['custom_proposals'] }}</td>
                                  <td class="col_7">{{$limits['product_uploads'] }}</td>
                                    <td class="col_6">
                                        @if ($package->is_published == 1)
                                            <span class="badge badge-success">Published</span> 
                                        @else
                                            <span class="badge badge-danger">Unpublished</span> 
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
            {{ $packages->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($packages->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $packages->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $packages->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
