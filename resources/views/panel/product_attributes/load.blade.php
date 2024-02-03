<div class="card-body">
    <div class="d-flex flex-wrap justify-content-between mb-2">
        <div>
            <label for="">Show
                <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                    <option value="10" {{ $product_attributes->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ $product_attributes->perPage() == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ $product_attributes->perPage() == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $product_attributes->perPage() == 100 ? 'selected' : '' }}>100</option>
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
                        class="btn btn-sm">Sno.</a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"
                        class="btn btn-sm">Name</a></li>
                <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"
                        class="btn btn-sm">Value</a></li>

                @if (AuthRole() == 'Admin')
                    <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"
                            class="btn btn-sm">Type</a></li>
                @endif

            </ul>
            <a href="javascript:void(0);" id="print" data-url="{{ route('panel.product_attributes.print') }}"
                data-rows="{{ json_encode($product_attributes) }}" class="btn btn-primary btn-sm">Print</a>
        </div>
        <input type="text" name="search" class="form-control" placeholder="Search" id="search"
            value="{{ request()->get('search') }}" style="width:unset;">
    </div>
    <div class="table-responsive">
        <table id="table" class="table">
            <thead>
                <tr>
                    <th class="no-export">Actions</th>
                    <th class="text-center col_1"># <div class="table-div"><i class="ik ik-arrow-up  asc"
                                data-val="id"></i><i class="ik ik ik-arrow-down desc" data-val="id"></i></div>
                    </th>

                    <th class="col_2">Name <div class="table-div"><i class="ik ik-arrow-up  asc" data-val="name"></i><i
                                class="ik ik ik-arrow-down desc" data-val="name"></i></div>
                    </th>

                    <th class="col_3">Values <div class="table-div"><i class="ik ik-arrow-up  asc"
                                data-val="values"></i><i class="ik ik ik-arrow-down desc" data-val="values"></i></div>
                    </th>

                    @if (AuthRole() == 'Admin')
                        <th class="col_4">Type <div class="table-div"><i class="ik ik-arrow-up  asc"
                                    data-val="type"></i><i class="ik ik ik-arrow-down desc" data-val="type"></i></div>
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if ($product_attributes->count() > 0)
                    @foreach ($product_attributes as $product_attribute)
                        <tr>
                            <td class="no-export">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i
                                            class="ik ik-chevron-right"></i></button>
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        <a href="{{ route('panel.product_attributes.edit', $product_attribute->id) }}"
                                            title="Edit Product Attribute" class="dropdown-item ">
                                            <li class="p-0">Edit</li>
                                        </a>
                                        {{-- @if ($product_attribute->user_id == auth()->id())
                                                <a href="{{ route('panel.product_attributes.destroy', $product_attribute->id) }}"
                                title="Delete Product Attribute" class="dropdown-item delete-item"><li class=" p-0">
                                    Delete</li></a>
                                @endif --}}

                                        {{-- For Admin Only --}}
                                        @if (AuthRole() == 'Admin')
                                            <a href="{{ route('panel.product_attributes.destroy', $product_attribute->id) }}"
                                                title="Delete Product Attribute" class="dropdown-item  delete-item">
                                                <li class=" p-0">Delete</li>
                                            </a>
                                        @endif


                                    </ul>
                                </div>
                            </td>
                            <td class="text-center col_1"> {{ $loop->iteration }}</td>
                            <td class="col_2">{{ $product_attribute->name }}</td>
                            @php
                                $get_value = App\Models\ProductAttributeValue::where('parent_id', $product_attribute->id)
                                    ->orderBy('attribute_value', 'ASC')
                                    ->pluck('attribute_value')
                                    ->toArray();
                            @endphp


                            <td class="col_3">
                                {{ implode('^^', $get_value) }}
                            </td>


                            @if (AuthRole() == 'Admin')
                                <td class="col_4">{{ $product_attribute->type == 1 ? 'User Define' : '' }}</td>
                            @endif

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
        {{ $product_attributes->appends(request()->except('page'))->links() }}
    </div>
    <div>
        @if ($product_attributes->lastPage() > 1)
            <label for="">Jump To:
                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="jumpTo">
                    @for ($i = 1; $i <= $product_attributes->lastPage(); $i++)
                        <option value="{{ $i }}"
                            {{ $product_attributes->currentPage() == $i ? 'selected' : '' }}>{{ $i }}
                        </option>
                    @endfor
                </select>
            </label>
        @endif
    </div>
</div>
