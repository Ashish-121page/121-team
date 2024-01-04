<table class="table" id="sdhfidsj">
    <thead>
        <tr>
            <td colspan="5"></td>
            <td colspan="3" id="four" class="text-center">Selling Price</td>

            @foreach (json_decode($user->custom_attriute_columns) as $item)
                @php
                    $tmp_name = str_replace(' ','_',$item);
                    $tmp_ID = str_replace(',','',$tmp_name);
                @endphp
                <td class="Change-{{$tmp_ID}} d-none"></td>
            @endforeach

        </tr>

        <tr>
            <th><input type="checkbox" aria-label="Checkbox for following text input"></th>
            <!-- Checkbox header -->
            <th class="sdeds">ID</th>
            <th>image</th>
            <th>Title</th>
            <th>Model Code</th>
            {{-- <th>Variant ID</th> --}}
            <th>COO</th>
            <th>Currency</th>
            <th>
                Price
                <i class="fas fa-pencil-alt"></i>
            </th>
            <th>Unit</th>
            @foreach (json_decode($user->custom_attriute_columns) as $item)
                @php
                    $tmp_name = str_replace(' ','_',$item);
                    $tmp_ID = str_replace(',','',$tmp_name);
                @endphp
                <th class="Change-{{$tmp_ID}} d-none">{{ $item }}</th>
            @endforeach
        </tr>

    </thead>
    <tbody>
        @forelse ($QuotationItems as $QuotationItem)
            @php
                $product = App\Models\Product::whereId($QuotationItem->product_id)->first();
                // $varients = getAllPropertiesofProductById($product->id)->pluck('attribute_value_id','attribute_id');
                // $varients_arr = [];
                // foreach ($varients as $varient_parent => $varient) {
                //     array_push($varients_arr,getAttruibuteValueById($varient)->attribute_value);
                // }
            @endphp
            <tr>
                <td class="sticky-col first-col">
                    <input type="checkbox">
                    <span style="margin-left: 10px;">
                        {{ $loop->iteration }}
                    </span>
                </td>
                <td class="sdeds">
                    {{ $QuotationItem->id }}
                </td>
                <td class="sticky-col second-col">
                    <img src="{{ asset(getShopProductImage($product->id)->path ?? asset('frontend/assets/img/placeholder.png')) }}" alt="" style="height: 85px; width: 85px;object-fit: contain">
                </td>
                <td class="sticky-col third-col">
                    {{ $product->title }}
                </td>
                
                <td class="sticky-col">
                    {{ $product->model_code }}
                </td>
                {{-- <td>
                    {{ ($varients_arr != [] && $varients_arr != null) ? implode(',',$varients_arr) : 'No Varient'  }}
                </td> --}}
                <td>
                    <select name="coo" id="coo" class="form-control select2">
                        @foreach ($countries as $country)
                            <option value="{{ $country->name }}" @if($country->name == 'India') selected @endif >{{ $country->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="currencySelect">
                    {{ $QuotationItem->currency ?? 'INR' }}
                </td>
                <td contenteditable="true" class="priceEdit">
                    {{ $QuotationItem->Price ?? '0' }}
                </td>
                <td>
                    {{-- {{ $QuotationItem->unit ?? 'per-piece' }} --}}
                    <select name="unit" id="unit" class="form-control" style="width: min-content !important">
                        <option value="per-piece">per-piece</option>
                        <option value="per-set">per-set</option>
                        <option value="per-box">per-box</option>
                    </select>
                </td>
                @foreach (json_decode($user->custom_attriute_columns) as $item)
                    @php
                        $tmp_name = str_replace(' ','_',$item);
                        $tmp_ID = str_replace(',','',$tmp_name);
                        $varientDetails = App\Models\ProductAttribute::where('name',$item)->first();
                        $ProductVarient = App\Models\ProductExtraInfo::where('product_id',$product->id)->where('attribute_id',$varientDetails->id)->first();
                    @endphp
                    <td class="Change-{{$tmp_ID}} d-none">
                        @if ($ProductVarient != null)
                            {{ getAttruibuteValueById($ProductVarient->attribute_value_id)->attribute_value }}
                        @else
                            -
                        @endif
                    </td>
                @endforeach

            </tr>

        @empty
            <tr>
                <td colspan="7">
                    <span>No Record Found</span>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
