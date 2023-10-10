
    <div class="card-body">
        <div class="d-flex justify-content-between flex-wrap mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        {{-- <option value="10" {{ $page->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25" {{ $page->perPage() == 25 ? 'selected' : ''}}>25</option> --}}
                        <option value="50" {{ $page->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100" {{ $page->perPage() == 100 ? 'selected' : ''}}>100</option>
                        <option value="500" {{ $page->perPage() == 500 ? 'selected' : ''}}>500</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                {{-- <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button> --}}
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Name</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Status</a></li>
                </ul>
                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.website_setting.pages.print') }}" data-rows="{{ json_encode($page) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{ request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <div class="table-responsive">
                <table id="page_table" class="table aiz-table mb-0">
                    <thead>
                        <tr>
                            <th class="text-center no-export">#</th>
                            <th class="col_1" >{{ ('Name') }}</th>
                            <th class="col_2">{{('Status')}}</th>
                            <th class="no-export">{{('Actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @if($page->count() > 0)
                            @foreach($page as $item)
                                <tr>
                                    <td class="text-center no-export">{{ $loop->iteration }}</td>
                                    <td class="col_1">{{ $item->title }}</td>
                                    <td class="col_2">@if ($item->status == 1)
                                        <span class="badge badge-success">{{ $item->status == 1 ? "Publish" : ''  }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $item->status == 0 ? "Unpublish" : '' }}</span></td>
                                    @endif
                                    <td class="no-export">
                                        <a href="{{ route('page.slug', $item->slug) }}" title="View Page" target="_blank" class="btn btn-outline-info btn-icon btn-sm"><i class="ik ik-eye" aria-hidden="true"></i></a>
                                        <a href="{{ route('panel.website_setting.pages.edit', $item->id) }}" title="Edit Page" class="btn btn-outline-warning btn-icon btn-sm"><i class="ik ik-edit" aria-hidden="true"></i></a>
                                        <a href="{{ route('panel.website_setting.pages.delete', $item->id) }}" title="Edit Page" class="btn btn-outline-danger btn-icon btn-sm delete-item"><i class="ik ik-trash" aria-hidden="true"></i></a>
                                        
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
    </div>
    <div class="card-footer d-flex justify-content-between">
        <div class="pagination">
            {{ $page->appends(request()->except('page'))->links() }}
        </div>
        <div>
            @if($page->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $page->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $page->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
            @endif
        </div>
    </div>
