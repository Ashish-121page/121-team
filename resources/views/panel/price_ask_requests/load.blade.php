    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $price_ask_requests->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $price_ask_requests->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $price_ask_requests->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $price_ask_requests->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    
                    {{-- <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">Workstream Id</a></li>                    
                    <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Sender Id</a></li>                    
                    <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Receiver  </a></li>                     --}}
                    <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Price</a></li>                    
                    <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">Qty</a></li>                    
                    <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"  class="btn btn-sm">Total</a></li>                    
                    {{-- <li class="dropdown-item p-0 col-btn" data-val="col_7"><a href="javascript:void(0);"  class="btn btn-sm">Comment</a></li>                    --}}
                     <li class="dropdown-item p-0 col-btn" data-val="col_8"><a href="javascript:void(0);"  class="btn btn-sm">Till Date</a></li>                    
                     {{-- <li class="dropdown-item p-0 col-btn" data-val="col_9"><a href="javascript:void(0);"  class="btn btn-sm">Details</a></li>                     --}}
                     <li class="dropdown-item p-0 col-btn" data-val="col_10"><a href="javascript:void(0);"  class="btn btn-sm">Status</a></li>                                        
                </ul>
                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.price_ask_requests.print') }}"  data-rows="{{json_encode($price_ask_requests) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th class="no-export">Actions</th> 
                        <th  class="text-center no-export"># <div class="table-div"><i class="ik ik-arrow-up  asc" data-val="id"></i><i class="ik ik ik-arrow-down desc" data-val="id"></i></div></th>                        
                        <th class="col_4">Sender <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="price"></i><i class="ik ik ik-arrow-down desc" data-val="price"></i></div></th>                       
                        <th class="col_4">Product <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="price"></i><i class="ik ik ik-arrow-down desc" data-val="price"></i></div></th>                       
                        {{-- <th class="col_4">Price <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="price"></i><i class="ik ik ik-arrow-down desc" data-val="price"></i></div></th>                       
                        <th class="col_5">Qty <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="qty"></i><i class="ik ik ik-arrow-down desc" data-val="qty"></i></div></th>                       
                        <th class="col_6">Total <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="total"></i><i class="ik ik ik-arrow-down desc" data-val="total"></i></div></th>                       
                        <th class="col_8">Till Date <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="till_date"></i><i class="ik ik ik-arrow-down desc" data-val="till_date"></i></div></th>                    --}}
                        <th class="col_10">Status <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="status"></i><i class="ik ik ik-arrow-down desc" data-val="status"></i></div></th>
                    </tr>
                </thead>
                <tbody>
                    @if($price_ask_requests->count() > 0)
                         @foreach($price_ask_requests as  $price_ask_request)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.price_ask_requests.show', $price_ask_request->id) }}" title="Show Price Ask Request" class="dropdown-item "><li class="p-0">Show</li></a>
                                            {{-- @if($price_ask_request->status != 1)
                                            <a href="{{ route('panel.price_ask_requests.status', $price_ask_request->id)."?status=1" }}" title="Accept Ask Request" class="dropdown-item confirm-btn"><li class="p-0">Accept</li></a>
                                            @endif
                                            <a href="{{ route('panel.price_ask_requests.status', $price_ask_request->id)."?status=2" }}" title="Reject Ask Request" class="dropdown-item "><li class="p-0">Reject</li></a> --}}

                                            {{-- Accepted Order --}}
                                            {{-- @if($price_ask_request->status == 1)
                                            <a href="{{ route('panel.price_ask_requests.custom-order.create',$price_ask_request->id) }}" data-rec="{{ $price_ask_request}}" data title="Create Custom Order" class="dropdown-item"><li class="p-0">Custom Order</li></a>
                                            @endif --}}

                                            <a href="{{ route('panel.price_ask_requests.destroy', $price_ask_request->id) }}" title="Delete Price Ask Request" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"> 
                                    <a class="btn btn-link  m-0 p-0" href="{{ route('panel.price_ask_requests.show', $price_ask_request->id) }}">
                                        {{  $price_ask_request->id }}
                                    </a>
                                </td>
                                <td class="col_2">{{NameById($price_ask_request->sender_id) }} - {{ NameById($price_ask_request->receiver_id) }}</td>
                                <td>
                                    @if($price_ask_request->product_id)
                                    @php
                                      $product =  fetchFirst('App\Models\Product',$price_ask_request->product_id);
                                    @endphp
                                    {{ $product->title??"--" }} Qty: {{ $product->stock_qty ?? '' }}               
                                    @endif
                                </td>
                                {{-- <td class="col_1">{{$price_ask_request->workstream_id }}</td>
                                      <td class="col_3">{{fetchFirst('App\User',$price_ask_request->receiver_id,'name','--')}}</td> --}}
                                  {{-- <td class="col_4">{{format_price($price_ask_request->price) }}</td>
                                  <td class="col_5"><span class="badge badge-secondary"> {{$price_ask_request->qty }}</span></td>
                                  <td class="col_6">{{format_price($price_ask_request->total) }}</td> --}}
                                  {{-- <td class="col_7">{{$price_ask_request->comment }}</td> --}}
                                  {{-- <td class="col_8">{{$price_ask_request->till_date }}</td> --}}
                                  {{-- <td class="col_9">{{$price_ask_request->details }}</td> --}}
                                  <td class="col_10"><span class="badge badge-{{getPriceAskRequestStatus($price_ask_request->status)['color'] }}">{{getPriceAskRequestStatus($price_ask_request->status)['name'] }}</span></td>
                                  
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
    <div class="card-body">
        <div class="table-responsive">
            <table id="table" class="table">
                <tbody>
                    @if($price_ask_requests->count() > 0)
                         @foreach($price_ask_requests as  $price_ask_request)
                            <tr>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <a href="{{ route('panel.price_ask_requests.show', $price_ask_request->id) }}" title="Show Price Ask Request" class="dropdown-item "><li class="p-0">Show</li></a>
                                            {{-- @if($price_ask_request->status != 1)
                                            <a href="{{ route('panel.price_ask_requests.status', $price_ask_request->id)."?status=1" }}" title="Accept Ask Request" class="dropdown-item confirm-btn"><li class="p-0">Accept</li></a>
                                            @endif
                                            <a href="{{ route('panel.price_ask_requests.status', $price_ask_request->id)."?status=2" }}" title="Reject Ask Request" class="dropdown-item "><li class="p-0">Reject</li></a> --}}

                                            {{-- Accepted Order --}}
                                            {{-- @if($price_ask_request->status == 1)
                                            <a href="{{ route('panel.price_ask_requests.custom-order.create',$price_ask_request->id) }}" data-rec="{{ $price_ask_request}}" data title="Create Custom Order" class="dropdown-item"><li class="p-0">Custom Order</li></a>
                                            @endif --}}

                                            <a href="{{ route('panel.price_ask_requests.destroy', $price_ask_request->id) }}" title="Delete Price Ask Request" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                        </ul>
                                    </div> 
                                </td>
                                <td  class="text-center no-export"> 
                                    <a class="btn btn-link  m-0 p-0" href="{{ route('panel.price_ask_requests.show', $price_ask_request->id) }}">
                                        {{  $price_ask_request->id }}
                                    </a>
                                </td>
                                <td class="col_2">{{NameById($price_ask_request->sender_id) }} - {{ NameById($price_ask_request->receiver_id) }}</td>
                                <td>
                                    @if($price_ask_request->product_id)
                                    @php
                                      $product =  fetchFirst('App\Models\Product',$price_ask_request->product_id);
                                    @endphp
                                    {{ $product->title??"--" }} Qty: {{ $product->stock_qty ?? '' }}               
                                    @endif
                                </td>
                                {{-- <td class="col_1">{{$price_ask_request->workstream_id }}</td>
                                      <td class="col_3">{{fetchFirst('App\User',$price_ask_request->receiver_id,'name','--')}}</td> --}}
                                  {{-- <td class="col_4">{{format_price($price_ask_request->price) }}</td>
                                  <td class="col_5"><span class="badge badge-secondary"> {{$price_ask_request->qty }}</span></td>
                                  <td class="col_6">{{format_price($price_ask_request->total) }}</td> --}}
                                  {{-- <td class="col_7">{{$price_ask_request->comment }}</td> --}}
                                  {{-- <td class="col_8">{{$price_ask_request->till_date }}</td> --}}
                                  {{-- <td class="col_9">{{$price_ask_request->details }}</td> --}}
                                  <td class="col_10"><span class="badge badge-{{getPriceAskRequestStatus($price_ask_request->status)['color'] }}">{{getPriceAskRequestStatus($price_ask_request->status)['name'] }}</span></td>
                                  
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
            {{ $price_ask_requests->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($price_ask_requests->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $price_ask_requests->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $price_ask_requests->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
