<div class="card-body">
    <div class="d-flex flex-wrap justify-content-between mb-2">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    {{-- <option value="10"{{ $packages->perPage() == 10 ? 'selected' : ''}}>10</option>
                    <option value="25"{{ $packages->perPage() == 25 ? 'selected' : ''}}>25</option> --}}
                    <option value="50"{{ $slider_types->perPage() == 50 ? 'selected' : ''}}>50</option>
                    <option value="100"{{ $slider_types->perPage() == 100 ? 'selected' : ''}}>100</option>
                    <option value="500"{{ $slider_types->perPage() == 500 ? 'selected' : ''}}>500</option>
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
            {{-- <a href="javascript:void(0);" id="print" data-url="{{ route('panel.slider_types.print') }}"  data-rows="{{json_encode($slider_types) }}" class="btn btn-primary btn-sm">Print</a> --}}
        </div>
        <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
    </div>
    <div class="table-responsive">
        <table id="table" class="table">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Actions</th>                                            
                    <th>Headline</th>
                    <th>Sub Headline</th>
                    <th>Total Sliders</th>
                </tr>
            </thead>
            <tbody>
                @foreach($slider_types as  $slider_type)
                    <tr>
                        <td class="text-center"> {{  $loop->iteration }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                    <li class="dropdown-item p-0"><a href="{{ route('backend.constant-management.slider_types.edit', $slider_type->id) }}" title="Edit Slider Type" class="btn btn-sm">Edit</a></li>
                                    <li class="dropdown-item p-0"><a href="{{ route('backend.constant-management.slider_types.destroy', $slider_type->id) }}" title="Delete Slider Type" class="btn btn-sm delete-item">Delete</a></li>
                                    <li class="dropdown-item p-0"><a href="{{ route('backend.constant-management.sliders.index')."?slidertype=".$slider_type->id }}" title="Manage Slider Type" class="btn btn-sm">Manage</a></li>
                                  </ul>
                            </div> 
                        </td>
                        <td>{{$slider_type->title }}</td>
                         <td>{{$slider_type->short_text }}</td>
                         <td>{{$slider_type->sliders->count() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer d-flex justify-content-between">
    <div class="pagination">
        {{ $slider_types->appends(request()->except('page'))->links() }}
    </div>
    <div>
       @if($slider_types->lastPage() > 1)
            <label for="">Jump To: 
                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                    @for ($i = 1; $i <= $slider_types->lastPage(); $i++)
                        <option value="{{ $i }}" {{ $slider_types->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </label>
       @endif
    </div>
</div>
