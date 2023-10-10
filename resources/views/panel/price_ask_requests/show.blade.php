@extends('backend.layouts.main') 
@section('title', 'Price Ask Request')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'View Price Ask Request', 'url'=> "javascript:void(0);", 'class' => '']
];
    if(auth()->id() == $price_ask_request->sender_id ){
        $sender = fetchFirst("App\User",$price_ask_request->receiver_id);
        $receiver = fetchFirst("App\User",$price_ask_request->sender_id);
    }else{
        $receiver = fetchFirst("App\User",$price_ask_request->receiver_id);
        $sender = fetchFirst("App\User",$price_ask_request->sender_id);
    }
@endphp
    <!-- push external head elements to head -->
    @push('head')
    <style>
    .chat{
        border: none;
        border-radius: 5px;
        padding: 0.5em;
    }
    .chat-left{
        align-self: flex-start;
        background-color: rgb(244, 244, 244);
    }
    .chat-right{
        text-align: right;
        align-self: flex-end;
        background-color: #eee;
    }
    .address-check{
        position: absolute;
    top: 0;
    right: 5px;
    }
</style>
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>View #PAR{{ $price_ask_request->id }}</h5>
                            <span>{{ __('View a record for Price Ask Request')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        @php
            $user_shop = App\Models\UserShop::whereUserId(auth()->id())->first();   
        @endphp
        <div class="row">
            <!-- start message area-->
            @include('backend.include.message')
            <!-- end message area-->
            <div class="col-md-6 mx-auto">
                <div class="card ">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Request Summary
                        </h3>
                        <div class="ml-auto">
                            {!! QrCode::size(30)->generate(inject_subdomain('shop/'.$product->id."?pg=", $user_shop->slug, false, false)) !!}
                        </div>
                        
                        {{-- Direct / Non Branded --}}
                        @if($product->brand_id == 0)
                            @if($price_ask_request->receiver_id == auth()->id() && $user_shop_item && $user_shop_item->parent_shop_id != 0)
                                <a class="btn btn-danger" data-toggle="modal" data-target="#priceRequest"  href="javascript:void(0)">Ask Price to Supllier</a>
                            @endif
                            @else 
                       @endif 
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Reseller </th>
                                        <td> {{ NameById($price_ask_request->sender_id) ?? 'N/A' }} </td>
                                    </tr>
                                    <tr>
                                        <th> Product </th>
                                        <td> {{ $product->title ?? 'N/A' }} </td>
                                    </tr>
                                    <tr>
                                        <td>Brand Name:</td>
                                        <td>{{ getBrandRecordByBrandId($product->brand_id)->name ?? "N\A" }}</td>
                                    </tr>
                                    <tr>
                                        <td>Cost Price:</td>
                                        <td>
                                            @if($parent_user_shop_item)  
                                           {{ format_price($parent_user_shop_item->price) }} 
                                          @else  
                                                {{ format_price($product->price) }} 
                                          @endif    
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Selling Price:</td>
                                        <td>
                                            {{ format_price($price_ask_request->latest_item->price ?? 0) }} 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Status:</td>
                                        <td>
                                            {{@getPriceAskRequestStatus($price_ask_request->status)['name'] }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card ">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Price Negotiation
                        </h3>
                        @if(!App\Models\PriceAskItem::where('price_ask_request_id',$price_ask_request->id)->whereIn('status',[0,1])->first())
                            <a class="btn ml-auto btn-primary mr-2" data-toggle="modal" data-target="#PARItemRequest"  href="javascript:void(0)">Make Counter Price Request</a>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        {{-- <th>SNo.</th> --}}
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                        <th>Till Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @foreach ($price_ask_request->items as $item)
                                   {{-- @dd($item) --}}
                                       <tr>
                                            {{-- <td><a href="" class="btn btn-link p-0">#PAR{{ $item->id }}</a></td> --}}
                                            <td>
                                                @if($item->sender_id == auth()->id() )
                                                    <i class="text-muted ik ik-corner-up-left"></i>
                                                    @else 
                                                    <i class="text-muted ik ik-corner-up-right"></i>
                                                @endif   
                                                {{ format_price($item->price )}}
                                            </td>
                                            <td>{{ $item->qty }}</td>
                                            <td>{{ format_price($item->total) }}</td>
                                            <td>{{ getFormattedDate($item->till_date) }}</td>
                                            <td class="text-{{ getPriceAskRequestStatus($item->status)['color'] }}">{{ getPriceAskRequestStatus($item->status)['name'] }}</td>
                                            <td>
                                                @if($item->receiver_id == auth()->id() && $item->status == 0)
                                                    <div class="d-flex">
                                                        <a href="{{ route('panel.price_ask_requests.item.status',[$item->id,1]) }}" class="btn btn-sm btn-success confirm-btn"><i class="fa fa-check"></i></a>
                                                        <a href="{{ route('panel.price_ask_requests.item.status',[$item->id,2]) }}" class="btn btn-sm btn-danger confirm-btn"><i class="fa fa-times"></i></a>
                                                    </div>
                                                @endif
                                            </td>
                                       </tr>
                                   @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mx-auto">
                <div class="card chat-card">
                    <div class="card-header d-flex justify-content-between">
                        
                         <div class="d-flex">
                            <img class="avatar" src="{{ $sender && $sender->avatar ? $sender->avatar : asset('backend/default/default-avatar.png') }}"
                            style="object-fit: cover; width: 35px; height: 35px" alt="">
                            <h3 class="ml-3 mt-2">{{ NameById($sender->id) }}</h3>
                        </div>
                        <div class="d-flex ">

                            @if(AuthRole() != "Admin" && $price_ask_request->receiver_id == auth()->id())
                                
                                @if(App\Models\PriceAskItem::where('price_ask_request_id',$price_ask_request->id)->where('status',1)->first())
                                    <a class="btn ml-auto btn-success mr-2" data-toggle="modal" data-target="#makeOrder"  href="javascript:void(0)">Create Custom Order</a>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="card-body scroll">
                        <div class="row my-1 chat">
                            @if(App\Models\TicketConversation::where('type',"PriceAskRequest")->where('type_id',$price_ask_request->id)->get()->count() > 0)
                                @foreach (App\Models\TicketConversation::where('type',"PriceAskRequest")->where('type_id',$price_ask_request->id)->get() as $index => $item)
                                    @if ($item->user_id == auth()->id())
                                        <div class="col-md-11 py-2 chat-right mb-1" style="border-radius: 10px;">
                                                <div class="p-0 m-0">
                                                    <span>
                                                        {{  $item->comment }} 
                                                    </span>
                                                </div>
                                                <small class="text-muted">{{ getFormattedDate($item->created_at) }}</small>
                                        </div>
                                        <div class="col-md-1">
                                            <a href="{{ route('panel.admin.ticket_conversation.delete', $item->id) }}" title="Delete Enquiry" class="btn mt-2 btn-sm btn-icon btn-outline-danger delete-item"><i class="ik ik-trash"></i></a>
                                        </div>
                                    @else
                                        <div class="col-md-12 py-2 chat-left mb-1">
                                            <div class="p-0 m-0">
                                                <span>
                                                    {{  $item->comment }}
                                                </span>
                                            </div>
                                            <small class="text-muted">{{ getFormattedDate($item->created_at) }}</small>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="col-12 text-center">
                                    <p>No Chats Yet!</p>
                                </div>
                            @endif
                        </div> 
                        <div class="msg-card"></div>
                    </div>
                    @if(in_array(auth()->id(),[$price_ask_request->receiver_id,$price_ask_request->sender_id]))
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">   
                                    <form action="{{ route('panel.admin.ticket_conversation.store') }}" method="post" class="ChatForm">                                 
                                        @csrf
                                        <input type="hidden" name="type_id" value="{{ $price_ask_request->id }}" id="groupId">
                                        <input type="hidden" name="type" value="{{ 'PriceAskRequest' }}" >
                                        <input type="hidden" name="enquiry_id" value="{{ $price_ask_request->type_id }}" >
                                         <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                            {{-- <label for="comment" class="control-label">{{ 'Reply' }}</label> --}}
                                            <textarea class="form-control" rows="3" name="comment" id="message" type="textarea" placeholder="Send Your Reply" required>{{ isset($enquiry->comment) ? $enquiry->comment : ''}}</textarea>
                                        </div>
                                        <div class="form-group text-right mb-0">
                                            <button type="submit" class="btn btn-primary"><i class="ik ik-navigation"></i> Send reply</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

      <div class="modal fade" id="makeOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterLabel">{{ __('Share Custom Order')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('panel.price_ask_requests.custom_order') }}" method="post">
                        @csrf
                        <input type="hidden" name="type" value="PriceAskRequest">
                        <input type="hidden" name="type_id" value="{{ $price_ask_request->id }}">
                      
                        <div class="row">
                            <div class="col-md-4 mx-auto">
                                <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                    <label for="comment" class="control-label">{{ 'Offer Price' }}</label>
                                    <input required type="number" class="form-control" name="price"  placeholder="Enter Price">
                                </div>
                            </div>
                             <div class="col-md-4 mx-auto">
                                <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                    <label for="comment" class="control-label">{{ 'Quantity' }}</label>
                                    <input required type="number" class="form-control" name="qty"  placeholder="Enter Qty">
                                </div>
                            </div>
                            <div class="col-md-4 mx-auto">
                                <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                    <label for="comment" class="control-label">{{ 'Delivery Date' }}</label>
                                    <input required type="date" class="form-control" name="delivery_date"  placeholder="Enter Delivery Date">
                                </div>
                            </div>
                             <div class="col-md-12 mx-auto">
                                <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                    <label for="comment" class="control-label">{{ 'Remark' }}</label>
                                    <textarea class="form-control" name="remarks"  placeholder="Enter your remarks"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mx-auto">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Create & Send </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="PARItemRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterLabel">{{ __('Price Ask Request')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('panel.price_ask_requests.item.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="status" value="0">
                        <input type="hidden" name="price_ask_request_id" value="{{ $price_ask_request->id }}">
                        <input type="hidden" name="sender_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="receiver_id" value="{{ $sender->id }}">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                                    <label for="price" class="control-label">{{ 'Price' }}</label>
                                    <input class="form-control" name="price" type="number" id="price" value="" placeholder="Enter Price" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group {{ $errors->has('qty') ? 'has-error' : ''}}">
                                    <label for="qty" class="control-label">{{ 'Quantity' }}</label>
                                    <input class="form-control" name="qty" type="number" id="qty" placeholder="Enter Qty" value="" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group {{ $errors->has('till_date') ? 'has-error' : ''}}">
                                    <label for="till_date" class="control-label">{{ 'Till Date' }}</label>
                                    <input class="form-control" name="till_date" type="date" value="" id="till_date" placeholder="Enter Qty" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                    <label for="comment" class="control-label">{{ 'Comment' }}</label>
                                    <textarea class="form-control" name="comment" type="number" id="comment" placeholder="Comment here.."></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                    {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button> --}}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($price_ask_request->receiver_id == auth()->id())
        <div class="modal fade" id="priceRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterLabel">{{ __('Price Ask Request')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('panel.price_ask_requests.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="status" value="0">
                            {{-- <input type="hidden" name="receiver_id" value="{{ getEnquiryPARUsers($enquiry->id) }}"> --}}
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="type_id" value="{{ $price_ask_request->id }}">
                            <input type="hidden" name="type" value="PriceAskRequest">
                            <input type="hidden" name="sender_id" value="{{ auth()->id() }}">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group {{ $errors->has('receiver_id') ? 'has-error' : ''}}">
                                        <label for="receiver_id" class="control-label">{{ 'Request Receiver' }} <span class="text-danger">*</span></label>
                                    <select name="receiver_id" class="form-control" id="">
                                        @foreach(getProductPARUsers($product->id, $user_shop_item->parent_shop_id ?? 0) as $user_id)
                                            <option value="{{ $user_id }}"> {{ UserShopNameByUserId($user_id) }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                                        <label for="price" class="control-label">{{ 'Price' }}</label>
                                        <input class="form-control" name="price" type="number" id="price" value="" placeholder="Enter Price" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group {{ $errors->has('qty') ? 'has-error' : ''}}">
                                        <label for="qty" class="control-label">{{ 'Quantity' }}</label>
                                        <input class="form-control" name="qty" type="number" id="qty" placeholder="Enter Qty" value="" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group {{ $errors->has('till_date') ? 'has-error' : ''}}">
                                        <label for="till_date" class="control-label">{{ 'Till Date' }}</label>
                                        <input class="form-control" name="till_date" type="date" value="" id="till_date" placeholder="Enter Qty" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                        <label for="comment" class="control-label">{{ 'Comment' }}</label>
                                        <textarea class="form-control" name="comment" type="number" id="comment" placeholder="Comment here.."></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Send</button>
                                        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button> --}}
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- push external js -->
    @push('script')
    @endpush
@endsection
