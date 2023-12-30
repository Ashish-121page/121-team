<div class="row mt-4">
    @forelse ($products as $product)
        <!-- col1 -->
        <div class="col-lg-3 col-md-4 col mb-4">
            <div class="card" style="width: 18rem;">
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
