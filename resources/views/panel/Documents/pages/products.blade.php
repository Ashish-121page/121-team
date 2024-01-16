<div class="row mt-4">
    @forelse ($products as $product)
        <!-- col1 -->
        <div class="col-lg-3 col-md-4  mb-4">
            <div class="card" style="max-width: 18rem; width: fit-content;">
                <img src="{{ asset(getShopProductImage($product->id)->path ?? asset('frontend/assets/img/placeholder.png')) }}" class="card-img-top" alt="..." style="height:200px; background-color: #ffffff; object-fit: contain">

                <div class="card-body" style="position: relative">
                    <div>
                        <b>Model Code</b>: {{ $product->model_code }}
                    </div>

                    <div style="width: 90%; word-break: break-all">
                        <b>Properties</b>:
                        @php
                            $varients = getAllPropertiesofProductById($product->id)->pluck('attribute_value_id','attribute_id');
                            $varients_arr = [];
                            foreach ($varients as $varient_parent => $varient) {
                                array_push($varients_arr,(getAttruibuteValueById($varient)->attribute_value ?? ''));
                            }
                        @endphp
                        {{ ($varients_arr != [] && $varients_arr != null) ? implode(',',$varients_arr) : 'No Varient'  }}
                    </div>

                    @if ($QuotationRecord->proposal_id != null )
                        @php
                            $proposal_item  = App\Models\ProposalItem::where('proposal_id',$QuotationRecord->proposal_id)->where('product_id',$product->id)->first();

                            if (isset($proposal_item->note)) {
                                $ashus = json_decode($proposal_item->note);
                            }else {
                                // return magicstring(json_decode($proposal_item->note));
                            }
                        @endphp



                        @if (isset($proposal_item->note) && $proposal_item->note != null)
                            <div style="width: 90%; word-break: break-all">
                                <b>Offer Notes</b>:
                                <span>{!! $ashus->remarks_offer !!}</span>
                            </div>
                        @endif

                        @if (isset($proposal_item->attachment) &&  $proposal_item->attachment != null)
                            <div style="width: 90%; word-break: break-all">
                                <b>Offer Attachment</b>:
                                <a href="{{ asset(getMediaByIds([$proposal_item->attachment])->path) }}" class="btn-link text-primary">Download</a>
                            </div>
                        @endif

                    @endif


                    <div class="actionbtn" style="position: absolute;top: 20%;right: 2%;">
                        <label class="custom-chk prdct-checked" data-select-all="boards">
                            <input type="checkbox" name="delproducts[]" class="input-check invisible buddy"
                                value="{{ $product->sku }}" data-record="{{ $product->id }}" @if (in_array($product->id,$QuotationItem)) checked @endif>
                            <span class="checkmark mr-5 mt-5"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center">
            <div class="h5">No Products are Available...</div>
        </div>
    @endforelse
</div> {{-- -- End of Row --}}

<div class="row mt-4">
    <div class="col-12">
        {{ $products->links() }}
    </div>
</div>


