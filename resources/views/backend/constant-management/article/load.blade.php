
    <div class="card-body">
        <div class="d-flex flex-wrap justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        {{-- <option value="10" {{ $article->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25" {{ $article->perPage() == 25 ? 'selected' : ''}}>25</option> --}}
                        <option value="50" {{ $article->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100" {{ $article->perPage() == 100 ? 'selected' : ''}}>100</option>
                        <option value="500" {{ $article->perPage() == 500 ? 'selected' : ''}}>500</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                {{-- <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button> --}}
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Title</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Creator</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Category</a></li>
                    <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Created At</a></li>
                </ul>
                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.constant_management.article.print') }}" data-rows="{{ json_encode($article) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{ request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="article_table" class="table">
                <thead>
                    <tr>
                        <th class="text-center no-export">#</th>
                        <th class="no-export">Actions</th>
                        <th  class="col_1">Title</th>
                        <th  class="col_2">Creator</th>
                        <th  class="col_3">Category</th>
                        <th  class="col_4">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @if($article->count() > 0)
                        @foreach($article as $item)
                            <tr>
                                <td class="text-center no-export">{{ $loop->iteration }}</td>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.article.show', $item->id) }}" title="View Article" class="btn btn-sm">Show</a></li>
                                            <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.article.edit', $item->id) }}" title="Edit Article" class="btn btn-sm">Edit</a></li>
                                            <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.article.delete', $item->id) }}" title="Edit Article" class="btn btn-sm delete-item">Delete</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td class="col_1">{{ $item->title }}</td>
                                <td class="col_2">{{ NameById($item->user_id) }}</td>
                                <td class="col_3"><a class="badge badge-info" href="javascript:void(0);">{{  fetchFirst('App\Models\Category', $item->category_id, 'name','') }}</a></td>
                                <td class="col_4">{{ getFormattedDate($item->created_at) }}</td>
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
            {{ $article->appends(request()->except('page'))->links() }}
        </div>
        <div>
            @if($article->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $article->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $article->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
            @endif
        </div>
    </div>
