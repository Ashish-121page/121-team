<div class="d-none table-responsive ">
    <table class="table" id="edfdsfarfqwe">
        <thead>
            <tr>
                <th>image</th>
                <th>Title</th>
            </tr>
        </thead>
        <tbody>
            <tr></tr>
            <tr>
                <td>
                    <img src="{{ asset('frontend/assets/img/placeholder.png') }}" alt="Product Image" style="height: 250px; width: 250px; object-fit: contain;" class="img-fluid">
                </td>
                <td>
                    Offer Id
                </td>
            </tr>
        </tbody>

    </table>



    <table class="table" id="printproposals">
        <thead>
            <tr>
                <th scope="col">Model Code</th>
                <th scope="col">image</th>
                <th scope="col">Product Name</th>
                <th scope="col">Description</th>
                @if ($selectedProp != [] && $selectedProp != null)
                    @foreach ($selectedProp as $index => $item)
                        <th>{{ getAttruibuteById($item)->name }}</th>
                    @endforeach
                @endif
                <th scope="col">Price</th>

            </tr>
        </thead>
        <tbody>
            <tr></tr>
            @if ($products->count() > 0)
                @foreach ($products as $key => $product)
                    <tr class="">
                        <td>
                            {{-- @if ($product->user_id == auth()->id()) --}}
                            {{ $product->model_code }}
                            {{-- @else
                                        {{ isset($usi) ? $usi->id : '' }}
                                    @endif   --}}
                        </td>
                        <td style="width: 250px">
                            @php
                                $url = asset(getShopProductImage($product->id)->path ?? asset('frontend/assets/img/placeholder.png'));
                                // $proposal_pro_img = App\Models\ProposalItem::where('proposal_id',$proposal->id)->where('product_id',$product->id)->first()->shorturl_img;
                                // $proposal_pro = App\Models\ProposalItem::where('proposal_id',$proposal->id)->where('product_id',$product->id)->first();
                                // if ($proposal_pro->shorturl_img == null) {
                                //     $proposal_pro->shorturl_img = shrinkurl($url);
                                //     $proposal_pro->save();
                                // }
                            @endphp
                            <img src="{{ Str::replaceFirst("$slug.", '', $url) }}" alt="Product Image" style="height: 250px; width: 250px; object-fit: contain;" class="img-fluid">
                        </td>
                        <td scope="row"> {{ $product->title }} </td>
                        <td> {{ $product->description ?? '--' }} </td>

                        @if ($selectedProp != [] && $selectedProp != null)
                            @foreach ($selectedProp as $index => $item)
                                @php
                                    $ids_attri = getParentAttruibuteValuesByIds($item, [$product->id]);
                                    $attri_count = count($ids_attri);
                                @endphp
                                @if ($attri_count != 0)
                                    @foreach ($ids_attri as $key1 => $value)
                                        <td>
                                            {{ trim(getAttruibuteValueById($value)->attribute_value ?? '') }}
                                            @if ($attri_count != 1 && $key1 < $attri_count - 1)
                                                ,
                                            @endif
                                        </td>
                                    @endforeach
                                @else
                                    <td> </td>
                                @endif
                            @endforeach
                        @endif
                        @php
                            $price = getProductProposalPriceByProposalId($proposal->id, $product->id) ?? $product->price;
                            $margin =
                                App\Models\ProposalItem::whereProposalId($proposal->id)
                                    ->where('product_id', $product->id)
                                    ->first()->margin ?? 10;
                            $user_price =
                                App\Models\ProposalItem::whereProposalId($proposal->id)
                                    ->where('product_id', $product->id)
                                    ->first()->user_price ?? null;
                            if ($user_price == null) {
                                $margin_factor = (100 - $margin) / 100;
                                $price = $price / $margin_factor;
                            } else {
                                $price = $user_price;
                            }

                            $record = (array) json_decode($proposal->currency_record);
                            $exhangerate = $record[$proposal->offer_currency] ?? 1;
                            $HomeCurrency = 1;
                            $currency_symbol = $proposal->offer_currency ?? 'INR';
                        @endphp
                        <td>
                            {{ $currency_symbol }}
                            {{ number_format(round(exchangerate($price, $exhangerate, $HomeCurrency)), 2) }}
                        </td>

                    </tr>
                @endforeach
            @else
                <div class="col-lg-6 mx-auto text-center mt-3">
                    <div class="card">
                        <div class="card-body">

                            <i class="fa text-primary fa-lg fa-shopping-cart">
                            </i>
                            <p class="mt-4">No Products added yet!</p>
                        </div>
                    </div>
                </div>
            @endif
        </tbody>
    </table>
</div>
