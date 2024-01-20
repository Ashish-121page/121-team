<div class="row mt-4">


    @if ($showAll)

        @foreach ($products as $product)
            @if (!in_array($product->id, $QuotationItem))
                @continue
            @endif
            <!-- col1 -->
            <div class="col-lg-3 col-md-4 col mb-4">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset(getShopProductImage($product->id)->path ?? asset('frontend/assets/img/placeholder.png')) }}"
                        class="card-img-top" alt="..."
                        style="height:200px; background-color: #ffffff; object-fit: contain">

                    <div class="card-body" style="position: relative;overflow: hidden;overflow-y: auto;height: 150px;">
                        <div>
                            <b>Model Code</b>: {{ $product->model_code }}
                        </div>

                        {{-- <div style="width: 90%; word-break: break-all">
                            <b>Properties</b>:
                            @php
                                $varients = getAllPropertiesofProductById($product->id)->pluck('attribute_value_id', 'attribute_id');
                                $varients_arr = [];
                                foreach ($varients as $varient_parent => $varient) {
                                    array_push($varients_arr, getAttruibuteValueById($varient)->attribute_value ?? '');
                                }
                            @endphp
                            {{ $varients_arr != [] && $varients_arr != null ? implode(',', $varients_arr) : 'No Varient' }}
                        </div> --}}

                        {{-- My Work --}}
                        <div class="">
                            @php

                                $arraysd = App\Models\ProductExtraInfo::where('group_id', $product->sku)
                                    ->pluck('attribute_id', 'attribute_value_id')
                                    ->toArray();
                                $varient_basis = countRepetitions($arraysd);
                                arsort($varient_basis);

                                $available_products = App\Models\ProductExtraInfo::where('group_id', $product->sku)
                                    ->groupBy('product_id')
                                    ->pluck('product_id')
                                    ->toArray();

                                $product_variant_combo = [];
                                $keysToKeep = [];
                                foreach ($varient_basis as $key => $lRepeated) {
                                    if ($lRepeated > 1) {
                                        array_push($keysToKeep, $key);
                                    }
                                }
                                foreach ($available_products as $key => $products2) {
                                    $tmp = App\Models\ProductExtraInfo::where('product_id', $products2)
                                        ->pluck('attribute_value_id', 'attribute_id')
                                        ->toArray();

                                    $keysArray = array_flip($keysToKeep);
                                    $filteredArray = array_intersect_key($tmp, $keysArray);
                                    // $filteredArray = array_reverse($filteredArray);
                                    array_push($product_variant_combo, $filteredArray);
                                }
                                $tmp_props = [];
                            @endphp



                            @foreach ($product_variant_combo as $product_variant)
                                @php
                                    $tmp_props = [];
                                @endphp
                                @foreach ($product_variant as $key => $item)
                                    @php
                                        // $tmp_props[$key] = getAttruibuteValueById($item)->attribute_value ?? '';
                                        $productAttribute = App\Models\ProductExtraInfo::where('attribute_id', $key)
                                            ->where('product_id', $product->id)
                                            ->first();
                                        if ($productAttribute->attribute_value_id ?? '' == $item) {
                                            $updateval = getAttruibuteValueById($productAttribute->attribute_value_id)->attribute_value ?? '';

                                            if (!in_array($updateval, $tmp_props)) {
                                                $tmp_props[$key] = $updateval;
                                            }
                                        }
                                    @endphp
                                @endforeach
                            @endforeach

                            {{ implode(' , ', $tmp_props) }}
                            @if ($tmp_props == [])
                                <br>
                            @endif


                        </div>
                        {{-- My Work --}}



                        @if ($QuotationRecord->proposal_id != null)
                            @php
                                $proposal_item = App\Models\ProposalItem::where('proposal_id', $QuotationRecord->proposal_id)
                                    ->where('product_id', $product->id)
                                    ->first();

                                if (isset($proposal_item->note)) {
                                    $ashus = json_decode($proposal_item->note);
                                } else {
                                    // return magicstring(json_decode($proposal_item->note));
                                }
                            @endphp

                            @if (isset($proposal_item->attachment) && $proposal_item->attachment != null)
                                <div style="width: 90%; word-break: break-all;text-align: center">
                                    <a href="{{ asset(getMediaByIds([$proposal_item->attachment])->path) }}"
                                        class="btn-link text-primary">Download</a>
                                </div>
                            @else
                                <br>
                            @endif




                            @if ($ashus->remarks_offer != null)
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">

                                        <h2 class="accordion-header">
                                            <button class="btn text-primary collapsed"
                                                style="background-color: transparent;" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#accor_{{ $proposal_item->id }}" aria-expanded="false"
                                                aria-controls="collapseThree">
                                                <span
                                                    class="text-dark ">{{ Str::limit($ashus->remarks_offer, 20) }}</span>
                                                <span title="{{ $ashus->remarks_offer }}" class="btn-link">More</span>
                                            </button>
                                        </h2>

                                        <div id="accor_{{ $proposal_item->id }}" class="accordion-collapse collapse"
                                            data-bs-parent="#{{ $proposal_item->id }}">
                                            <div class="accordion-body">
                                                {!! $ashus->remarks_offer !!}
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            @endif
                        @endif


                        <div class="actionbtn" style="position: absolute;top: 20%;right: 2%;">
                            <label class="custom-chk prdct-checked" data-select-all="boards">
                                <input type="checkbox" name="delproducts[]" class="input-check invisible buddy"
                                    value="{{ $product->sku }}" data-record="{{ $product->id }}"
                                    @if (in_array($product->id, $QuotationItem)) checked @endif>
                                <span class="checkmark mr-5 mt-5"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    @endif

    @forelse ($products as $product)
        @if (in_array($product->id, $QuotationItem))
            @continue
        @endif

        <div class="col-lg-3 col-md-4 col mb-4">
            <div class="card" style="width: 18rem;">
                <img src="{{ asset(getShopProductImage($product->id)->path ?? asset('frontend/assets/img/placeholder.png')) }}"
                    class="card-img-top" alt="..."
                    style="height:200px; background-color: #ffffff; object-fit: contain">

                <div class="card-body" style="position: relative;overflow: hidden;overflow-y: auto;height: 150px;;">
                    <div>
                        <b>Model Code</b>: {{ $product->model_code }}
                    </div>

                    {{-- <div style="width: 90%; word-break: break-all">
                            <b>Properties</b>:
                            @php
                                $varients = getAllPropertiesofProductById($product->id)->pluck('attribute_value_id', 'attribute_id');
                                $varients_arr = [];
                                foreach ($varients as $varient_parent => $varient) {
                                    array_push($varients_arr, getAttruibuteValueById($varient)->attribute_value ?? '');
                                }
                            @endphp
                            {{ $varients_arr != [] && $varients_arr != null ? implode(',', $varients_arr) : 'No Varient' }}
                        </div> --}}


                    {{-- My Work --}}
                    <div class="">
                        @php

                            $arraysd = App\Models\ProductExtraInfo::where('group_id', $product->sku)
                                ->pluck('attribute_id', 'attribute_value_id')
                                ->toArray();
                            $varient_basis = countRepetitions($arraysd);
                            arsort($varient_basis);

                            $available_products = App\Models\ProductExtraInfo::where('group_id', $product->sku)
                                ->groupBy('product_id')
                                ->pluck('product_id')
                                ->toArray();

                            $product_variant_combo = [];
                            $keysToKeep = [];
                            foreach ($varient_basis as $key => $lRepeated) {
                                if ($lRepeated > 1) {
                                    array_push($keysToKeep, $key);
                                }
                            }
                            foreach ($available_products as $key => $products2) {
                                $tmp = App\Models\ProductExtraInfo::where('product_id', $products2)
                                    ->pluck('attribute_value_id', 'attribute_id')
                                    ->toArray();

                                $keysArray = array_flip($keysToKeep);
                                $filteredArray = array_intersect_key($tmp, $keysArray);
                                // $filteredArray = array_reverse($filteredArray);
                                array_push($product_variant_combo, $filteredArray);
                            }
                            $tmp_props = [];
                        @endphp



                        @foreach ($product_variant_combo as $product_variant)
                            @php
                                $tmp_props = [];
                            @endphp
                            @foreach ($product_variant as $key => $item)
                                @php
                                    // $tmp_props[$key] = getAttruibuteValueById($item)->attribute_value ?? '';
                                    $productAttribute = App\Models\ProductExtraInfo::where('attribute_id', $key)
                                        ->where('product_id', $product->id)
                                        ->first();
                                    if ($productAttribute->attribute_value_id ?? '' == $item) {
                                        $updateval = getAttruibuteValueById($productAttribute->attribute_value_id)->attribute_value ?? '';

                                        if (!in_array($updateval, $tmp_props)) {
                                            $tmp_props[$key] = $updateval;
                                        }
                                    }
                                @endphp
                            @endforeach
                        @endforeach

                        {{ implode(' , ', $tmp_props) }}


                    </div>
                    {{-- My Work --}}



                    @if ($QuotationRecord->proposal_id != null)
                        @php
                            $proposal_item = App\Models\ProposalItem::where('proposal_id', $QuotationRecord->proposal_id)
                                ->where('product_id', $product->id)
                                ->first();

                            if (isset($proposal_item->note)) {
                                $ashus = json_decode($proposal_item->note);
                            } else {
                                // return magicstring(json_decode($proposal_item->note));
                            }
                            $random = rand(1, 100000);

                        @endphp


                        @if (isset($proposal_item->attachment) && $proposal_item->attachment != null)
                            <div style="width: 90%; word-break: break-all">
                                <a href="{{ asset(getMediaByIds([$proposal_item->attachment])->path) }}"
                                    class="btn-link text-primary">Download</a>
                            </div>
                        @else
                            <br>
                        @endif
                        @if ($ashus->remarks_offer != null)
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">

                                    <h2 class="accordion-header">
                                        <button class="btn text-primary collapsed"
                                            style="background-color: transparent;" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#accor_{{ $proposal_item->id ?? $random }}"
                                            aria-expanded="false" aria-controls="collapseThree">
                                            <span class="text-dark ">{{ Str::limit($ashus->remarks_offer, 20) }}</span>
                                            <span title="{{ $ashus->remarks_offer }}" class="btn-link">More</span>
                                        </button>
                                    </h2>

                                    <div id="accor_{{ $proposal_item->id ?? $random }}"
                                        class="accordion-collapse collapse"
                                        data-bs-parent="#{{ $proposal_item->id ?? $random }}">
                                        <div class="accordion-body">
                                            {!! $ashus->remarks_offer !!}
                                        </div>
                                    </div>

                                </div>

                            </div>
                        @endif
                    @endif


                    <div class="actionbtn" style="position: absolute;top: 20%;right: 2%;">
                        <label class="custom-chk prdct-checked" data-select-all="boards">
                            <input type="checkbox" name="delproducts[]" class="input-check invisible buddy"
                                value="{{ $product->sku }}" data-record="{{ $product->id }}"
                                @if (in_array($product->id, $QuotationItem)) checked @endif>
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
