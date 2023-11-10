@php
    $length = 50;
    if(request()->get('length')){
        $length = request()->get('length');
    }
    $product_attributes = App\Models\ProductAttribute::query();
    
    if(request()->get('search')){
        $product_attributes->where('id','like','%'.request()->search.'%')
        ->orWhere('name','like','%'.request()->search.'%')
        ;
    }
    
    if(AuthRole() != 'Admin') {
        $product_attributes->where('user_id',auth()->id())->orWhere('user_id');
    }

    if(request()->get('from') && request()->get('to')) {
        $product_attributes->whereBetween('created_at', [\Carbon\carbon::parse(request()->from)->format('Y-m-d'),\Carbon\Carbon::parse(request()->to)->format('Y-m-d')]);
    }

    if(request()->get('asc')){
        $product_attributes->orderBy(request()->get('asc'),'asc');
    }
    if(request()->get('desc')){
        $product_attributes->orderBy(request()->get('desc'),'desc');
    }
    $product_attributes = $product_attributes->paginate($length);

@endphp

<div class="container-fluid p-0 m-0">
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between mb-2">
                    {{-- <div>
                        <label for="">Show
                            <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                                <option value="10" {{ $product_attributes->perPage() == 10 ? 'selected' : ''}}>10</option>
                                <option value="25" {{ $product_attributes->perPage() == 25 ? 'selected' : ''}}>25</option>
                                <option value="50" {{ $product_attributes->perPage() == 50 ? 'selected' : ''}}>50</option>
                                <option value="100" {{ $product_attributes->perPage() == 100 ? 'selected' : ''}}>100</option>
                            </select>
                            entries
                        </label>
                    </div> --}}
                    <div>
                        @if(auth()->user() && session()->has("admin_user_id") && session()->has("temp_user_id"))
                            <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                        @endif
                        {{-- <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Edit Columns</button> --}}
            
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
        
                            <li class="dropdown-item p-0 col-btn" data-val="action_btn"><a href="javascript:void(0);"
                                class="btn btn-sm">Action</a></li>
            
                        </ul>
                        <a href="javascript:void(0);" id="print" data-url="{{ route('panel.product_attributes.print') }}"
                            data-rows="{{json_encode($product_attributes) }}" class="btn btn-primary btn-sm">Print</a>
                    </div>
                    {{-- <input type="text" name="search" class="form-control" placeholder="Search" id="search"
                        value="{{request()->get('search') }}" style="width:unset;"> --}}
                </div>
                <div class="table-responsive">
                    <table id="table" class="table">
                        <thead>
                            <tr>
                                <th class="text-center col_1"># 
                                    {{-- <div class="table-div">
                                        <i class="ik ik-arrow-up asc" data-val="id"></i>
                                        <i class="ik ik ik-arrow-down desc" data-val="id"></i>
                                    </div> --}}
                                </th>
            
                                <th class="col_2">Name
                                    {{-- <div class="table-div"><i class="ik ik-arrow-up  asc" data-val="name"></i><i class="ik ik ik-arrow-down desc" data-val="name"></i></div> --}}
                                </th>
            
                                <th class="col_3">Values 
                                    {{-- <div class="table-div"><i class="ik ik-arrow-up  asc" data-val="values"></i><i class="ik ik ik-arrow-down desc" data-val="values"></i></div> --}}
                                </th>
            
                                @if (AuthRole() == 'Admin')
                                <th class="col_4">Type 
                                    {{-- <div class="table-div"><i class="ik ik-arrow-up  asc" data-val="type"></i><i class="ik ik ik-arrow-down desc" data-val="type"></i></div> --}}
                                </th>
                                @endif
        
                                <th class="no-export action_btn">
                                    
                                </th>
        
                            </tr>
                        </thead>
                        <tbody>
                            @if($product_attributes->count() > 0)
                            @foreach($product_attributes as $product_attribute)
                            @if ( $product_attribute->name == 'Color')
                                @continue    
                            @endif
                                <tr>
                                    <td class="text-center col_1"> {{  $loop->iteration }}</td>
                                    <td class="col_2">{{$product_attribute->name }}</td>
                                    @php
                                        $get_value =
                                        App\Models\ProductAttributeValue::where('parent_id',$product_attribute->id)->orderBy('attribute_value','ASC')->pluck('attribute_value')->toArray();
                                    @endphp
                
                
                                    <td class="col_3 p-3">
                                        {{ implode('; ',$get_value) }}
                                    </td>
                
                
                                    @if (AuthRole() == 'Admin')
                                        <td class="col_4">{{($product_attribute->type == 1) ? "User Define" : ""}}</td>
                                    @endif
        
                                    <td class="no-export action_btn">
                                        <a href="{{ route('panel.product_attributes.edit', $product_attribute->id) }}"
                                            title="Edit Product Attribute" class="btn btn-outline-primary">
                                            Edit
                                        </a>
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
                    {{ $product_attributes->appends(request()->except('page'))->links() }}
                </div>
                <div>
                    @if($product_attributes->lastPage() > 1)
                    <label for="">Jump To:
                        <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="jumpTo">
                            @for ($i = 1; $i <= $product_attributes->lastPage(); $i++)
                                <option value="{{ $i }}" {{ $product_attributes->currentPage() == $i ? 'selected' : '' }}>{{ $i }}
                                </option>
                                @endfor
                        </select>
                    </label>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
</div>
