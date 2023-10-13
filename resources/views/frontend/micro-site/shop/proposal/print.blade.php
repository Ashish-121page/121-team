<div class="d-none">
    <table class="table" id="printproposals">
        <thead>
            <tr>
                <th scope="col">Product Name</th>
                <th scope="col">Description</th>
                @foreach (json_decode($proposal->options)->show_Attrbute as $item)
                    <th scope="col">
                        {{ getAttruibuteById($item)->name ?? '' }}
                    </th>
                @endforeach
                <th scope="col">Model Code</th>
                <th scope="col">Price</th>
                <th scope="col">Image</th>
            </tr>
        </thead>
        <tbody>

            @if($products->count() > 0)
                @foreach ($products as $key => $product)
                        <tr class="contain-{{ $product->id }}">
                            <td scope="row"> {{ $product->title }} </td>
                            <td> {{ $product->description ?? '--' }} </td>   

                            @foreach (json_decode($proposal->options)->show_Attrbute as $item)
                                @php
                                    $value = (App\Models\ProductExtraInfo::where('product_id',$product->id)->where('attribute_id',$item)->first() != null) ? getAttruibuteValueById(App\Models\ProductExtraInfo::where('product_id',$product->id)->where('attribute_id',$item)->first()->attribute_value_id)->attribute_value : '';
                                @endphp
                                <td>
                                    {{ $value }}
                                </td>
                            @endforeach
                            
                            <td>
                                    @if($product->user_id == auth()->id())
                                    {{ $product->model_code }}
                                @else 
                                    {{ isset($usi) ? $usi->id : '' }}
                                @endif  
                            </td>
                            @php
                                $price = getProductProposalPriceByProposalId($proposal->id,$product->id) ?? $product->price;
                                $margin = App\Models\ProposalItem::whereProposalId($proposal->id)->where('product_id',$product->id)->first()->margin ?? 10;
                                $user_price = App\Models\ProposalItem::whereProposalId($proposal->id)->where('product_id',$product->id)->first()->user_price ?? null;
                                if ($user_price == null) {
                                    $margin_factor = (100 - $margin) / 100;
                                    $price = $price/$margin_factor;
                                }
                                else {
                                    $price = $user_price;
                                }
                            @endphp
                            <td> {{ format_price(($price)) }} </td>
                            <td>
                                @php
                                    $url = asset(getShopProductImage($product->id)->path ?? asset('frontend/assets/img/placeholder.png'));
                                    // $proposal_pro_img = App\Models\ProposalItem::where('proposal_id',$proposal->id)->where('product_id',$product->id)->first()->shorturl_img;
                                    $proposal_pro = App\Models\ProposalItem::where('proposal_id',$proposal->id)->where('product_id',$product->id)->first();
                                    if ($proposal_pro->shorturl_img == null) {
                                        $proposal_pro->shorturl_img = shrinkurl($url);
                                        $proposal_pro->save();
                                    }
                                @endphp
                                <pre>
                                    {{trim($proposal_pro->shorturl_img)}}
                                </pre>
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
 
