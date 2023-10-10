@extends('frontend.layouts.main') 
@section('meta_data')
    @php
		$meta_title = 'Chat | '.getSetting('app_name');		
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'GRPL';		
		$meta_author_email = '' ?? 'Hello@121.page';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';
        $customer = 1;		
	@endphp
@endsection
@section('firebase_head')
<style>
     .chat{
        border: none;
        border-radius: 5px;
        padding: 0.5em;
    }
    .chat-left{
        align-self: flex-start;
        /* background-color: rgb(244, 244, 244); */
    }
    .chat-right{
        text-align: right;
        align-self: flex-end;
        background-color: #dfdfff;
    }
      .scroll {
    max-height: 350px;
    overflow-y: auto;
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
@php
    $slug =  getShopDataByShopId($enquiry->micro_site_id)->slug;
    $details = json_decode($enquiry->description);
    $product = getProductDataById($details->product_id);
    $price_ask_request = App\Models\PriceAskRequest::whereTypeId($enquiry->id)->first();
    $user_shop = App\Models\UserShopItem::where('product_id',$details->product_id);
    $user_shop_image = App\Models\UserShopItem::where('product_id',$details->product_id)->where('user_shop_id',$enquiry->micro_site_id)->first();
    if(isset($user_shop_image) && $user_shop_image->images){
        $image_ids = explode(',',$user_shop_image->images);
    }
                    
@endphp
    <!-- push external head elements to head -->
    <section class="section">
        <div class="container mt-5">
            <a href="{{ route('customer.dashboard',['active' => 'enquiry']) }}" class="btn btn-outline-primary rounded-pill mb-3"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1.2em" height="1.2em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path fill="currentColor" d="M872 474H286.9l350.2-304c5.6-4.9 2.2-14-5.2-14h-88.5c-3.9 0-7.6 1.4-10.5 3.9L155 487.8a31.96 31.96 0 0 0 0 48.3L535.1 866c1.5 1.3 3.3 2 5.2 2h91.5c7.4 0 10.8-9.2 5.2-14L286.9 550H872c4.4 0 8-3.6 8-8v-60c0-4.4-3.6-8-8-8z"/></svg> Chat</a>
                
            <div class="row">

                <div class="col-lg-5 col-12">
                    <div class="card border-0 shadow rounded sidebar">
                        <a href="{{ inject_subdomain('shop/'.$product->id."?pg=", $slug, true)}}" target="_blank" class="text-center mx-auto mt-3">
                            @if (isset($image_ids) && $image_ids != null)
                                <img src="{{ asset(getMediaByIds($image_ids)->path) }}" alt="" style="height: 160px;">
                            @else   
                                <img src="{{ asset('frontend/assets/img/placeholder.png') }}" alt="" style="height: 160px;">
                            @endif
                            <h6 class="mt-2">Click For Details</h6>
                        </a>
                        <div class="d-flex justify-content-between p-3">
                            <div>
                                <h6>EQ121#{{ $enquiry->id }} </h6>
                            </div>
                            <div class="d-flex">
                                <span style="line-height: 20px;" class="badge bg-{{ getEnquiryStatus($enquiry->status)['color'] }}">{{ getEnquiryStatus($enquiry->status)['name'] }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body p-0">
                        <div class="">
                            @if($details != null)

                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td>Product Name:</td>
                                            <td>{{ $product->title ?? "N\A" }}</td>
                                        </tr>
                                        <tr>
                                            <td>Quantity:</td>
                                            <td>{{ $details->qty }} Piecs</td>
                                        </tr>
                                        <tr>
                                            <td>Ask Price:</td>
                                            <td>{{ format_price($details->price) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Required Till:</td>
                                            <td>{{ getFormattedDate($details->required_in) }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                            @endif
                        </div>
                    </div>
                </div><!--end col-->
                
                <!-- start message area-->
                <!-- end message area-->
                <div class="col-md-12 col-lg-7 mx-lg-auto col-12">
                
                    <input type="hidden" name="shopusername" id="shop_user_name" value="{{ UserShopNameByUserId(getEnquiryPARUsers($enquiry->id)) }}">
                    <div class="card chat-card  border-0 shadow">
                        <div class="d-flex justify-content-between border-bottom p-4">
                        <div class="d-flex">
                                <img src="{{ ($author && $author->avatar) ? $author->avatar : asset('backend/default/default-avatar.png') }}" class="avatar avatar-md-sm rounded-circle border shadow" alt="">
                                <div class="overflow-hidden ms-3">
                                    <a href="{{ inject_subdomain('home', $slug, true)}}" target="_blank" class="text-dark mb-0 h6 d-block text-truncate">{{ $author->name }} ({{ $micro_site->name }})</a>
                                    <small class="text-muted"><i class="mdi mdi-checkbox-blank-circle text-success on-off align-text-bottom"></i> {{ $author->updated_at->diffForHumans() }}</small>
                                </div>
                            </div>

                        </div>
                        <div class="card-body scroll">
                            <div class="row my-1 chat">
                                @php
                                  $conversation =  App\Models\TicketConversation::where('type',"Enquiry")->where('type_id',$enquiry->id)->orderBy('id','asc')->get();
                                @endphp
                                @if($conversation->count() > 0)
                                    @foreach ($conversation  as $index => $item)
                                        @if ($item->user_id == auth()->id())
                                            <div class="col-md-12 py-2 chat-right mb-1" style="border-radius: 10px;">
                                                    <h6 class="p-0 m-0">
                                                        {!!  nl2br($item->comment)  !!}
                                                    </span>
                                                    </h6>
                                                    <small class="text-muted x-small">{{ $item->created_at->diffForHumans() }}</small>
                                            </div>
                                        @else
                                            <div class="col-md-11 py-2 chat-left mb-1">
                                                    <h6 class="p-0 m-0">
                                                        {!!  nl2br($item->comment)  !!}
                                                    </span>
                                                    </h6>
                                                    <small class="text-muted x-small">{{ getFormattedDate($item->created_at) }}</small>
                                            </div>
                                        @endif
                                    @endforeach
                                @else 
                                    <div class="align-items-center mx-auto text-center py-4" id="emptyMsg"> 
                                         <p>No Chats Yet!</p>
                                    </div>       
                                @endif
                            </div> 
                            <div class="msg-card"></div>
                        </div>
                    </div>
                    <div id="msg-card"></div>
                    <div class="">
                        <div class="">
                            @if($receiver != auth()->id())
                                <div class="alert alert-info mb-0"><strong>Note:</strong> You don't have permission to send messsage to this enquiry</div>
                            @else
                                <div class="row">
                                    <div class="col-md-12 col-lg-12"> 
                                        <div class="p-2 rounded-bottom shadow">
                                            <form action="#" method="post" class="ChatForm">                                 
                                                @csrf
                                                <input type="hidden" name="type" value="Enquiry" >
                                                <input type="hidden" name="type_id" value="{{ $enquiry->id }}" id="groupId">
                                                <input type="hidden" name="reciever_id" value="{{ $receiver }}" id="receiverId">
                                                <div class="row">
                                                    <div class="col">
                                                        <textarea name="comment" class="form-control" placeholder="Enter Message..." required id="message" ></textarea>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button type="submit" class="btn btn-icon btn-primary chat-btn"><i class="uil uil-message"></i></button>
                                                    </div>
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
        </div>
    </section>
  
  
@endsection
  @section('firebase_footer')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>

const messages = document.getElementsByClassName('scroll');
function scrollToBottom() {
  messages.scrollTop = messages.scrollHeight;
}


        var enq_id = "{{ $enquiry->id }}";
        $('#Shopusername').val($('#shop_user_name').val());
                const messaging = firebase.messaging();
            navigator.serviceWorker.register("{{ url('/').'/firebase-messaging-sw.js' }}")
            .then((registration) => {
                messaging.usePublicVapidKey("BNyjs1XK08N1mdYOa1dDGkqblBu-pMZceLeyHuYbnbggW5NibJEtxstiR2CKXof98SBdmWbt7gh0lDU2yvgTe_M");
                messaging.useServiceWorker(registration);
            });

            var scroll_to_bottom = function(element){
                var tries = 0, old_height = new_height = element.height();
                var intervalId = setInterval(function() {
                    if( old_height != new_height ){    
                        // Env loaded
                        clearInterval(intervalId);
                        element.animate({ scrollTop: new_height }, 'slow');
                    }else if(tries >= 30){
                        // Give up and scroll anyway
                        clearInterval(intervalId);
                        element.animate({ scrollTop: new_height }, 'slow');
                    }else{
                        new_height = element.height();
                        tries++;
                    }
                }, 100);
            }

            var chatRecord = "{{$conversation->count()}}";
        $(document).ready(function() {
                $('.scroll').animate({
                        scrollTop: $(".msg-card").offset().top
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
                                var html =  `<div class="col-md-12 py-2 chat-right mb-1">
                                                <h6 class="p-0 m-0">
                                                    ${msg}
                                                </span>
                                                </h6>
                                                <small class="text-muted">{{ getFormattedDate(\Carbon\Carbon::now()) }}</small>
                                        </div>    
                                `;
                                if(chatRecord == 0){
                                    $('#emptyMsg').hide();
                                }
                                $('.chat').append(html);
                                $('.chat-btn').attr('disabled',false);
                                setTimeout(function(){
                                    scrollToBottom();
                                }, 2000);
                           
                            },
                            error: function(err){
                                console.log(err);
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
                    console.log('s');           
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
                        if(chatRecord == 0){
                            $('#emptyMsg').hide();
                        }
                        $('.chat').append(html);
                        setTimeout(function(){
                            scrollToBottom();
                        }, 2000);
                    
                    }   
                    // location.reload();
                });

        });
    </script>
    @endsection