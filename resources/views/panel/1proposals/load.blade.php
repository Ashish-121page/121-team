<div class="card-body">
    <div class="d-flex justify-content-between mb-2">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    <option value="10" {{ $proposals->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $proposals->perPage() == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $proposals->perPage() == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $proposals->perPage() == 100 ? 'selected' : '' }}>100</option>
                </select>
                entries
            </label>
        </div>
        <div>
            <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">Column Visibility</button>
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">

                <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"
                        class="btn btn-sm">Customer Name</a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"
                        class="btn btn-sm">Customer Phone number</a></li>
                @if(AuthRole() == "Admin")
                <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"
                        class="btn btn-sm">User Shop </a></li>
                @endif
                <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"
                        class="btn btn-sm">Status </a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"
                        class="btn btn-sm">Items</a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"
                        class="btn btn-sm">Slug</a></li>
            </ul>
            <a href="javascript:void(0);" id="print" data-url="{{ route('panel.proposals.print') }}"
                data-rows="{{ json_encode($proposals) }}" class="btn btn-primary btn-sm">Print</a>
        </div>
        <input type="text" name="search" class="form-control" placeholder="Search" id="search"
            value="{{ request()->get('search') }}" style="width:unset;">
    </div>
    <div class="table-responsive">
        <table id="table" class="table">
            <thead>
                <tr>
                    <th class="no-export">Actions</th>
                    <th class="text-center no-export"># <div class="table-div"><i class="ik ik-arrow-up  asc" data-val="id"></i><i class="ik ik ik-arrow-down desc" data-val="id"></i></div>
                    </th>

                    <th class="col_1">
                        Name <div class="table-div"><i class="ik ik-arrow-up  asc  "
                                data-val="customer_name"></i><i class="ik ik ik-arrow-down desc"
                                data-val="customer_name"></i></div>
                    </th>
                    <th class="col_2">
                        Phone number<div class="table-div"><i class="ik ik-arrow-up  asc  "
                                data-val="customer_details"></i><i class="ik ik ik-arrow-down desc"
                                data-val="customer_details"></i></div>
                    </th>
                    @if(AuthRole() == "Admin")
                    <th class="col_3">
                         Shop <div class="table-div"><i class="ik ik-arrow-up  asc  "
                                data-val="user_shop_id"></i><i class="ik ik ik-arrow-down desc"
                                data-val="user_shop_id"></i></div>
                    </th>
                    @endif
                    <th class="col_4">
                        Status <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="slug"></i><i
                                class="ik ik ik-arrow-down desc" data-val="status"></i></div>
                    </th>
                    <th class="col_5">
                        Items 
                    </th>
                    <th class="col_6">
                        Created At <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="slug"></i><i
                                class="ik ik ik-arrow-down desc" data-val="craeted_at"></i></div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($proposals->count() > 0)
                    @foreach ($proposals as $proposal)
                    @php
                        $customer_detail = json_decode($proposal->customer_details);
                        $customer_name = $customer_detail->customer_name ?? '--';
                        $customer_mob_no = $customer_detail->customer_mob_no ?? '--';
                        $direct = $proposal->status == 0 ? "?direct=1" : "";
                    @endphp
                        <tr>
                            <td class="no-export">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i
                                            class="ik ik-chevron-right"></i></button>
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        @if($proposal->status == 1)
                                            <a href="{{ route('panel.proposals.edit', $proposal->id).$direct }}"
                                                title="Show Proposal" class="dropdown-item">
                                                <li class=" p-0">Show</li>
                                            </a>
                                        @else  
                                            <a href="{{ route('panel.proposals.destroy', $proposal->id) }}"
                                                title="Delete Proposal" class="dropdown-item  delete-item">
                                                <li class=" p-0">Delete</li>
                                            </a>
                                        @endif  
                                    </ul>
                                </div>
                            </td>
                            <td class="text-center no-export"> 
                                <a href="{{ route('panel.proposals.edit', $proposal->id).$direct }}"
                                    class="btn-link" title="Edit Proposal"> #PROID{{ $proposal->id }}</a>
                            </td>
                            <td class="col_1">{{ $customer_name }}</td>
                            <td class="col_2">{{ $customer_mob_no }}</td>
                             @if(AuthRole() == "Admin")
                            <td class="col_3">
                                {{ fetchFirst('App\Models\UserShop', $proposal->user_shop_id, 'name', '--') }}</td>
                            @endif    
                            <td class="col_4"><div class="badge badge-{{ getProposalStatus($proposal->status)['color']}}">{{ getProposalStatus($proposal->status)['name']}}</div></td>
                            <td class="col_5"><span class="badge badge-pill badge-secondary">{{ $proposal->items_count }}</span></td>
                            <td class="col_6">{{ getFormattedDate($proposal->created_at) }}</td>
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
        {{ $proposals->appends(request()->except('page'))->links() }}
    </div>
    <div>
        @if ($proposals->lastPage() > 1)
            <label for="">Jump To:
                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="jumpTo">
                    @for ($i = 1; $i <= $proposals->lastPage(); $i++)
                        <option value="{{ $i }}" {{ $proposals->currentPage() == $i ? 'selected' : '' }}>
                            {{ $i }}</option>
                    @endfor
                </select>
            </label>
        @endif
    </div>
</div>
