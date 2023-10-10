<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $medias->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $medias->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $medias->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $medias->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    
                    <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Type</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Type Id</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">File Name</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Path</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">Extension</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"  class="btn btn-sm">File Type</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_7"><a href="javascript:void(0);"  class="btn btn-sm">Tag</a></li>                                        
                </ul>
                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.medias.print') }}"  data-rows="{{json_encode($medias) }}" class="btn btn-primary btn-sm">Print</a>
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
                            Type <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="type"></i><i class="ik ik ik-arrow-down desc" data-val="type"></i></div></th>
                                                    <th class="col_2">
                            Type Id <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="type_id"></i><i class="ik ik ik-arrow-down desc" data-val="type_id"></i></div></th>
                                                    <th class="col_3">
                            File Name <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="file_name"></i><i class="ik ik ik-arrow-down desc" data-val="file_name"></i></div></th>
                                                    <th class="col_4">
                            Path <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="path"></i><i class="ik ik ik-arrow-down desc" data-val="path"></i></div></th>
                                                    <th class="col_5">
                            Extension <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="extension"></i><i class="ik ik ik-arrow-down desc" data-val="extension"></i></div></th>
                                                    <th class="col_6">
                            File Type <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="file_type"></i><i class="ik ik ik-arrow-down desc" data-val="file_type"></i></div></th>
                                                    <th class="col_7">
                            Tag <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="tag"></i><i class="ik ik ik-arrow-down desc" data-val="tag"></i></div></th>
                                                                        </tr>
                </thead>
                <tbody>
                    @if($medias->count() > 0)
                                                    @foreach($medias as  $media)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.medias.edit', $media->id) }}" title="Edit Media" class="dropdown-item "><li class="p-0">Edit</li></a>
                                            <a href="{{ route('panel.medias.destroy', $media->id) }}" title="Delete Media" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"> {{  $loop->iteration }}</td>
                                <td class="col_1">{{$media->type }}</td>
                                  <td class="col_2">{{$media->type_id }}</td>
                                  <td class="col_3">{{$media->file_name }}</td>
                                  <td class="col_4">{{$media->path }}</td>
                                  <td class="col_5">{{$media->extension }}</td>
                                  <td class="col_6">{{$media->file_type }}</td>
                                  <td class="col_7">{{$media->tag }}</td>
                                  
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
            {{ $medias->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($medias->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $medias->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $medias->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
