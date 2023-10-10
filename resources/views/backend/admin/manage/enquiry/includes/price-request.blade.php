<div class="modal fade" id="priceRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterLabel">{{ __('Price Ask Request')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                @php
                    $enq_users = getEnquiryPARUsers($enquiry->id);
                @endphp
                @if(count($enq_users) > 0)
                <form action="{{ route('panel.price_ask_requests.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="status" value="0">
                    {{-- <input type="hidden" name="receiver_id" value="{{ getEnquiryPARUsers($enquiry->id) }}"> --}}
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="type_id" value="{{ $enquiry->id }}">
                    <input type="hidden" name="type" value="Enquiry">
                    <input type="hidden" name="sender_id" value="{{ auth()->id() }}">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group {{ $errors->has('receiver_id') ? 'has-error' : ''}}">
                                <label for="receiver_id" class="control-label">{{ 'Request Receiver' }} <span class="text-danger">*</span></label>
                            <select name="receiver_id" class="form-control" id="">
                                @foreach($enq_users as $user_id)
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
                                <input class="form-control" name="till_date" type="date" value="" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="till_date" placeholder="Enter Qty" required>
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
                @else 
                    <div class="text-center text-danger p-5 m-5">
                        No AS avilable at this movement to accept price request
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>