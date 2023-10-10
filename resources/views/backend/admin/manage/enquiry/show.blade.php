@extends('backend.layouts.main') 
@section('title', 'Enquiry')

@section('firebase_head')
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
        background-color: #dfdfff;
    }
    .address-check{
        position: absolute;
    top: 0;
    right: 5px;
    }
</style>
	<script  src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
	<script  src="https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"></script>
	<script>
		const firebaseConfig = {
		apiKey: "AIzaSyA2PIANeOJzj1WKWYMVqMslmKns20koebM",
		authDomain: "zstarter-34516.firebaseapp.com",
		projectId: "zstarter-34516",
		storageBucket: "zstarter-34516.appspot.com",
		messagingSenderId: "857694002875",
		appId: "1:857694002875:web:6cd0b56c05888e9063d39e"
		};

		const appmessaging = firebase.initializeApp(firebaseConfig);
	</script>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

@endsection
@section('content')
@push('head')
<script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
<style>
    .scroll {
    height: 300px;
    overflow-y: auto;
    overflow-x: hidden;
    }
    body::-webkit-scrollbar {
    width: 1em;
    }
    
    body::-webkit-scrollbar-track {
    box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    }
    
    body::-webkit-scrollbar-thumb {
    background-color: darkgrey;
    outline: 1px solid slategrey;
    }
    .sticky-bar { 
        position: sticky; 
        top: 80px; 
    }
</style>
@endpush

@php
$breadcrumb_arr = [
    ['name'=>'Enquiry', 'url'=> route('panel.admin.enquiry.index'), 'class' => ''],
    ['name'=>'View Enquiry', 'url'=> "javascript:void(0);", 'class' => ''],
]
@endphp
    <!-- push external head elements to head -->

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('View Enquiry')}}</h5>
                            <span>{{ getMicrositeItemSKU($product->id)}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            @include('backend.include.message')
            <!-- end message area-->
            <div class="col-md-12 col-lg-6 mx-auto">
                <div class="card m-0 mb">
                    <div class="card-header pb-0">
                       <h5>Enquiry Information:</h5>
                       <div class="ml-auto">
                            {!! QrCode::size(30)->generate(inject_subdomain('shop/'.$product->id."?pg=", $user_shop->slug, false, false)) !!}
                        </div>
                    </div>
                    <div class="card-body p-2 pb-3 m-0">

                        <div class="mb-0">
                           @if($details != null)

                            <table class="table table-striped mb-0">
                                <tbody>
                                    <tr>
                                        <th colspan="2">Customer Name:</th>
                                        <td colspan="2">{{ $enquiry->client_name ?? "N\A" }}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Enquiry From:</th>
                                        <td colspan="2">{{ $enquiry->client_email ?? "N\A" }}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Product Name:</th>
                                        <td colspan="2">{{ $product->title ?? "N\A" }} </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Brand Name:</th>
                                        <td colspan="2">{{ getBrandRecordByBrandId($product->brand_id)->name ?? "N\A" }}</td>
                                    </tr>
                                    <tr>
                                        <th colspan="4">Details:</th>
                                    </tr>
                                    <tr>
                                        <th>Asked Quantity:</th>
                                        <td class="border-right">{{ $details->qty }} Piecs</td>
                                        <th>Available Quantity:</th>
                                        <td>
                                            {{ $user_shop_item->inventory }} Piecs    
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Asked Price:</th>
                                        <td class="border-right">{{ format_price($details->price) }} </td>
                                        
                                        <th>Required in:</th>
                                        <td>{{ getFormattedDate($details->required_in) }}</td>
                                    </tr>
                                    
                                    <tr>
                                        <th>Cost Price:</th>
                                        <td class="border-right">
                                            {{ $cost_price ?? 0}}    
                                        </td>
                                        <th>Shop Display Price:</th>
                                        <td>
                                            {{ format_price($user_shop_item->price) }} 
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Comment:</th>
                                        <td colspan="2">{{ $details->comment }}</td>
                                    </tr>
                                </tbody>
                            </table>
                           @endif
                        </div>
                    </div>
                </div>
                @if($product->user_id != auth()->id())
                    <div class="card mt-4 mb-0">
                        <div class="card-header d-flex justify-content-between mb-0">
                            <h3>
                                Price Ask Requests
                            </h3>
                            @if(AuthRole() != "Admin")
                            <div>
                                <a class="btn btn-primary" data-toggle="modal" data-target="#priceRequest"  href="javascript:void(0)">Request</a>
                            </div>
                            @endif
                        </div>
                    
                        <div class="card-body p-2 pb-3 m-0">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Supplier</th>
                                        <th>Status</th>
                                        <th>Ask</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($price_ask_requests as $price_ask_request)
                                        <tr>
                                            <td>
                                                <a href="{{ route('panel.price_ask_requests.show', $price_ask_request->id) }}" class="btn btn-link">PARID{{$price_ask_request->id}}</a>
                                            </td>
                                            <td>{{ UserShopNameByUserId($price_ask_request->receiver_id) }}</td>
                                            <td>
                                                <span class="text text-{{ getPriceAskRequestStatus($price_ask_request->latest_item->status)['color'] }}">
                                                    {{ getPriceAskRequestStatus($price_ask_request->latest_item->status)['name'] }}
                                                </span>
                                            </td>
                                            <td>{{ format_price($price_ask_request->latest_item->price) }} x {{ ($price_ask_request->latest_item->qty) }} Piecs</td>
                                            <td>{{ format_price($price_ask_request->latest_item->total) }}</td>
                                        </tr>
                                    @empty
                                         <td colspan="5" class="text-center">
                                            No Asks
                                        </td>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-12 col-lg-6 mx-auto">
               <input type="hidden" name="shopusername" id="shop_user_name" value="{{ UserShopNameByUserId(getEnquiryPARUsers($enquiry->id)) }}">
                <div class="card chat-card">
                    
                    <div class="card-header d-flex justify-content-between">
                         <div class="d-flex">
                            <h3 class="mr-2">#ENQID{{ $enquiry->id }}  </h3>
                            <div><span class="mr-2 badge badge-{{ getEnquiryStatus($enquiry->status)['color'] }}">{{ getEnquiryStatus($enquiry->status)['name'] }}</span>
                            </div>
                        </div>

                        <div class="d-flex">

                            @if(AuthRole() != "Admin")
                        <a class="btn btn-success mr-2" data-toggle="modal" data-target="#makeOrder"  href="javascript:void(0)">Create Custom Order</a>
                        @endif

                            @if($enquiry->status != 1)
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                    <li class="dropdown-item p-0"><a href="{{ route('panel.admin.enquiry.edit', $enquiry->id) }}" title="Update Status" class="btn btn-sm">Update Status</a></li>
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="py-2" style="background-color:rgb(40, 40, 120);">
                        <div class="d-flex justify-content-around">
                            <div class="mr-3" style="font-size:16px; color:aliceblue;"><span style="color: antiquewhite">Customer: </span>{{ $enquiry->client_name }}</div>
                            <div class="mr-3" style="font-size:16px; color:aliceblue;"><span style="color: antiquewhite">Created At:</span> {{ getFormattedDate($enquiry->created_at) }}</div>
                            <div class="mr-3" style="font-size:16px; color:aliceblue;"><span style="color: antiquewhite">Product:</span> #PRO{{ $details->product_id ?? '' }} </div>
                        </div>
                    </div>


                    
                    <div class="card-body scroll">
                        <div class="row my-1 chat">
                            @foreach (App\Models\TicketConversation::where('type',"Enquiry")->where('type_id',$enquiry->id)->orderBy('id','asc')->get() as $index => $item)
                                @if ($item->user_id == auth()->id())
                                    <div class="col-md-11 py-2 chat-right mb-1">
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
                                    <div class="col-md-11 py-2 chat-left mb-1">
                                            <div class="p-0 m-0">
                                                <span>
                                                    {{  $item->comment }}
                                                </span>
                                            </div>
                                            <small class="text-muted">{{ getFormattedDate($item->created_at) }}</small>
                                    </div>
                                @endif
                            @endforeach
                        </div> 
                        <div class="msg-card"></div>
                    </div>
                    <div class="card-footer">
                         @if($sender != auth()->id())
                            <div class="alert alert-info mb-0"><strong>Note:</strong> You don't have permission to send messsage to this enquiry</div>
                        @else
                            <div class="row">
                                <div class="col-md-12 col-lg-12">   
                                    <form action="#" method="post" class="ChatForm">                                 
                                        @csrf
                                        <input type="hidden" name="type_id" value="{{ $enquiry->id }}" id="groupId">
                                        <input type="hidden" name="type" value="{{ 'Enquiry' }}" >
                                        <input type="hidden" name="reciever_id" value="{{ $receiver }}" id="receiverId">
                                        <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                            {{-- <label for="comment" class="control-label">{{ 'Reply' }}</label> --}}
                                            <textarea class="form-control" rows="3" name="comment" id="message" type="textarea" placeholder="Send Your Reply" required>{{ isset($enquiry->comment) ? $enquiry->comment : ''}}</textarea>
                                        </div>
                                        <div class="form-group text-right mb-0">
                                            <button type="submit" class="btn btn-primary chat-btn"><i class="ik ik-navigation"></i> Send reply</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
               
            </div>
        </div>
    </div>
    {{-- Note Edit form --}}
    <div class="modal fade" id="clientReplyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterLabel">{{ __('Client Reply')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('panel.admin.ticket_conversation.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="type_id" value="{{ $enquiry->id }}">
                        <input type="hidden" name="client_name" value="{{ $enquiry->client_name }}">
                        <input type="hidden" name="client_email" value="{{ $enquiry->client_email }}">
                        <div class="row">
                            <div class="col-md-12 mx-auto">
                                <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                    <label for="comment" class="control-label">{{ 'Reply' }}</label>
                                    <textarea class="form-control" rows="5" name="comment" type="textarea" id="comment" placeholder="Enter Reply" required>{{ isset($note->comment) ? $note->comment : ''}}</textarea>
                                </div>
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                                </div>
                                
                            </div>
                        </div>
                    </form>
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
                    <form action="{{ route('panel.admin.enquiry.order') }}" method="post">
                        @csrf
                        <input type="hidden" name="type" value="Enquiry">
                        <input type="hidden" name="type_id" value="{{ $enquiry->id }}">
                        @if($details != null)
                        <input type="hidden" name="product_id" value="{{ $details->product_id }}">
                        @endif
                        <div class="row">
                           <div class="col-md-12">
                                <p>Enquiry received on {{ getFormattedDate($enquiry->created_at) }} at {{  $enquiry->created_at->format('H:i:s'); }}</p>
                           </div>
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
                                    <input min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required type="date" class="form-control" name="delivery_date"  placeholder="Enter Delivery Date">
                                </div>
                            </div>
                             <div class="col-md-12 mx-auto">
                                <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                    <label for="comment" class="control-label">{{ 'Other terms' }}</label>
                                    <textarea class="form-control" name="remarks"  placeholder="Enter Other terms"></textarea>
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
    @include('backend.admin.manage.enquiry.includes.price-request',$enquiry)
    {{-- Note Modal End --}}
    <!-- push external js -->
  
@endsection
  @section('firebase_footer')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        var enq_id = "{{ $enquiry->id }}";
        $('#Shopusername').val($('#shop_user_name').val());
                const messaging = firebase.messaging();
            navigator.serviceWorker.register("{{ url('/').'/firebase-messaging-sw.js' }}")
            .then((registration) => {
                messaging.usePublicVapidKey("BNyjs1XK08N1mdYOa1dDGkqblBu-pMZceLeyHuYbnbggW5NibJEtxstiR2CKXof98SBdmWbt7gh0lDU2yvgTe_M");
                messaging.useServiceWorker(registration);
            });

        $(document).ready(function() {
                $('.scroll').animate({
                        scrollTop: $('.msg-card').offset().top 
                }, 1000);
                $('.ChatForm').on('submit', function(e){
                    e.preventDefault();
                    $('.chat-btn').attr('disabled',true);
                    var chaturl = "{{ route('panel.admin.enquiry.api.sendMessage') }}";
                    var formdata = $(this).serialize();
                    var group_id = $('#groupId').val();
                    var msg = $('#message').val();
                
                        $.ajax({
                            url: chaturl,
                            method: "post",
                            data: formdata,
                            success: function(res){
                                console.log(res.tc_id);
                                var tc_dlt_url = "{{ url('panel/admin/manage/ticket-conversation/delete') }}"+"/"+res.tc_id;
                                $('#message').val("");
                                var html =  `<div class="col-md-11 py-2 chat-right mb-1">
                                                <h6 class="p-0 m-0">
                                                    ${msg}
                                                </span>
                                                </h6>
                                                <small class="text-muted">{{ getFormattedDate(\Carbon\Carbon::now()) }}</small>
                                        </div>    <div class="col-md-1">
                                            <a href="${tc_dlt_url}" title="Delete Enquiry" class="btn mt-2 btn-sm btn-icon btn-outline-danger delete-item"><i class="ik ik-trash"></i></a>
                                        </div>
                                `;
                                $('.chat').append(html);
                                $('.chat-btn').attr('disabled',false);
                            }
                        });
                });


                function sendTokenToServer(fcm_token) {
                    const user_id = {{ auth()->id() }};
                    console.log("Token Retrived:",fcm_token);
                    axios.post('{{ route("panel.admin.enquiry.api.token") }}', {
                        fcm_token,user_id
                    })
                    .then((response) => {
                        console.log(response);
                    })
                    .catch((error) => {
                        console.log(error);
                    });
                }
                function retreiveToken(){
                        messaging.getToken().then((currentToken) => {
                            if (currentToken) {
                                sendTokenToServer(currentToken);
                            } else {
                                alert('You should allow notification!');
                            }
                        }).catch((err) => {
                            console.log(err.message);
                        });
                    }
                retreiveToken();
                    messaging.onTokenRefresh(()=>{
                    retreiveToken();
                });
                messaging.onMessage((payload)=>{
                    console.log('d');            
                    console.log(payload);            
                    if(enq_id == payload.data.enq_id){
                        var html =  ` <div class="col-md-11 py-2 chat-left mb-1">
                                               <h6 class="p-0 m-0">
                                                    ${payload.notification.body}
                                                </span>
                                                </h6>
                                                <small class="text-muted ">{{ \Carbon\Carbon::now() }}</small>
                                        </div>`;
                                         console.log(html);
                        $('.chat').append(html);
                     
                    }   
                    // location.reload();
                });


                
            


        });
    </script>
    @endsection