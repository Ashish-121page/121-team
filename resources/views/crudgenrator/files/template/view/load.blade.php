
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $data['curlstart'] }} {{ $indexvariable }}->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $data['curlstart'] }} {{ $indexvariable }}->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $data['curlstart'] }} {{ $indexvariable }}->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $data['curlstart'] }} {{ $indexvariable }}->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    @php $i = 1; @endphp

                    @foreach ($data['fields']['name'] as $index => $item)<li class="dropdown-item p-0 col-btn" data-val="col_{{ $i }}"><a href="javascript:void(0);"  class="btn btn-sm">@if($data['fields']['input'][$index] == 'select_via_table'){{ str_replace('Id','',ucwords(str_replace('_',' ',$item))) }} @else{{ ucwords(str_replace('_',' ',$item)) }}@endif</a></li>@php ++$i; @endphp
                    @endforeach
                    
                </ul>
                <a href="javascript:void(0);" id="print" data-url="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'].$data['name']}}.print') }}"  data-rows="{{ $data['curlstart'] }}json_encode({{ $indexvariable }}) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{ $data['curlstart'] }}request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th class="no-export">Actions</th> 
                        <th  class="text-center no-export"># <div class="table-div"><i class="ik ik-arrow-up  asc" data-val="id"></i><i class="ik ik ik-arrow-down desc" data-val="id"></i></div></th>             
                        @php
                            $hi = 1;
                        @endphp                       
                        @foreach ($data['fields']['name'] as $index => $item)<th class="col_{{ $hi }}">
                            @if($data['fields']['input'][$index] == 'select_via_table'){{ str_replace('Id','',ucwords(str_replace('_',' ',$item))) }}  @else{{ ucwords(str_replace('_',' ',$item)) }}@endif <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="{{ $item }}"></i><i class="ik ik ik-arrow-down desc" data-val="{{ $item }}"></i></div></th>
                            @php ++$hi; @endphp
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    {{ $data['atsign'] }}if({{ $indexvariable }}->count() > 0)
                            @php
                                $ti = 1;
                            @endphp
                        {{ $data['atsign'] }}foreach({{ $indexvariable }} as  {{ $variable}})
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'].$data['name']}}.edit', {{ $variable}}->id) }}" title="Edit {{ $heading }}" class="dropdown-item "><li class="p-0">Edit</li></a>
                                            <a href="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'].$data['name']}}.destroy', {{ $variable}}->id) }}" title="Delete {{ $heading }}" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"> {{ $data['curlstart'] }}  $loop->iteration }}</td>
                                @foreach ($data['fields']['name'] as $index => $item)@if($data['fields']['input'][$index] == 'select_via_table')    @php
                                    if($data['fields']['table'][$index] == "User"){
                                        $model_path = "App\\";
                                    }else{
                                        $model_path = "App\Models\\";
                                    }
                                @endphp<td class="col_{{  $ti }}">{{ $data['curlstart'] }}fetchFirst('{{ $model_path.$data['fields']['table'][$index]  }}',{{ $variable}}->{{ $item }},'name','--')}}</td>
                                @elseif($data['fields']['input'][$index] == 'file')<td class="col_{{  $ti }}"><a href="{{ $data['curlstart'] }} asset({{ $variable}}->{{ $item }}) }}" target="_blank" class="btn-link">{{ $data['curlstart'] }}{{ $variable}}->{{ $item }} }}</a></td>
                                @else<td class="col_{{  $ti }}">{{ $data['curlstart'] }}{{ $variable}}->{{ $item }} }}</td>
                                @endif @php ++$ti; @endphp @endforeach

                            </tr>
                        {{ $data['atsign'] }}endforeach
                    {{ $data['atsign'] }}else 
                        <tr>
                            <td class="text-center" colspan="8">No Data Found...</td>
                        </tr>
                    {{ $data['atsign'] }}endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-between">
        <div class="pagination">
            {{ $data['curlstart'] }} {{ $indexvariable }}->appends(request()->except('page'))->links() }}
        </div>
        <div>
           {{ $data['atsign'] }}if({{ $indexvariable }}->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        {{ $data['atsign'] }}for ($i = 1; $i <= {{ $indexvariable }}->lastPage(); $i++)
                            <option value="{{ $data['curlstart'] }} $i }}" {{ $data['curlstart'] }} {{ $indexvariable }}->currentPage() == $i ? 'selected' : '' }}>{{ $data['curlstart'] }} $i }}</option>
                        {{ $data['atsign'] }}endfor
                    </select>
                </label>
           {{ $data['atsign'] }}endif
        </div>
    </div>
