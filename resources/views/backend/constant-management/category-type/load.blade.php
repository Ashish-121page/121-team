<div class="card-body">
    <div class="d-flex flex-wrap justify-content-between mb-2">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    {{-- <option value="10"{{ $packages->perPage() == 10 ? 'selected' : ''}}>10</option>
                    <option value="25"{{ $packages->perPage() == 25 ? 'selected' : ''}}>25</option> --}}
                    <option value="50"{{ $category_type->perPage() == 50 ? 'selected' : ''}}>50</option>
                    <option value="100"{{ $category_type->perPage() == 100 ? 'selected' : ''}}>100</option>
                    <option value="500"{{ $category_type->perPage() == 500 ? 'selected' : ''}}>500</option>
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
            {{-- <a href="javascript:void(0);" id="print" data-url="{{ route('panel.category_type.print') }}"  data-rows="{{json_encode($category_type) }}" class="btn btn-primary btn-sm">Print</a> --}}
        </div>
        <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
    </div>
    <div class="table-responsive">
        <table id="category_table" class="table">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Actions</th>
                    <th>Title</th>
                    {{-- <th>Name</th>
                    <th>Level</th> --}}
                    {{-- <th>Categories Count</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($category_type as $item)
                    <tr>
                        <td class="text-center">MCT{{ $item->id }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                    {{-- <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.category_type.show', $item->id) }}" title="View Lead Contact" class="btn btn-sm">Show</a></li> --}}
                                    <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.category_type.edit', $item->id) }}" title="Edit Category Group" class="btn btn-sm">Edit</a></li>
                                    {{-- @if (AuthRole() == 'Admin')
                                        <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.category_type.delete', $item->id) }}" title="Delete Category Group" class="btn btn-sm delete-item">Delete</a></li>
                                    @endif --}}
                                    <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.category.index',$item->id) }}" title="Manage Category Group" class="btn btn-sm">Manage</a></li>
                                  </ul>
                            </div>
                        </td>
                        <td>{{ ucwords(str_replace('_',' ',$item->name)) ?? '-' }}</td>
                        {{-- <td>{{ $item->name }}</td>
                        <td>{{ $item->allowed_level }}</td> --}}
                        {{-- <td><a class="btn btn-link" href="{{ route('panel.constant_management.category.index',$item->id) }}">{{ fetchGetData('App\Models\Category',['category_type_id','level'],[$item->id,1])->count() }}</a></td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card-footer d-flex justify-content-between">
    <div class="pagination">
        {{ $category_type->appends(request()->except('page'))->links() }}
    </div>
    <div>
       @if($category_type->lastPage() > 1)
            <label for="">Jump To: 
                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                    @for ($i = 1; $i <= $category_type->lastPage(); $i++)
                        <option value="{{ $i }}" {{ $category_type->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </label>
       @endif
    </div>
</div>
