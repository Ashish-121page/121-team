<table class="table" id="sdhfidsj">
    <thead>


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
            </th>
            <th>Quantity</th>
            <th>Unit</th>
            <th>Total</th>
            @foreach (json_decode($user->custom_attriute_columns) as $item)
                @php
                    $tmp_name = str_replace(' ', '_', $item);
                    $tmp_ID = str_replace(',', '', $tmp_name);
                @endphp
                <th class="Change-{{ $tmp_ID }} d-none">{{ $item }}</th>
            @endforeach
        </tr>

    </thead>
    <tbody>
        @forelse ($QuotationItems as $index => $QuotationItem)
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
                    <img src="{{ asset(getShopProductImage($product->id)->path ?? asset('frontend/assets/img/placeholder.png')) }}"
                        alt="" style="height: 85px; width: 85px;object-fit: contain">
                </td>
                <td class="sticky-col third-col" style="width: 250px;text-wrap: wrap;text-align: left;">
                    {{-- {{ Str::limit($product->title, 20, '...') }} --}}
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
                        @php
                            $tmp = json_decode($QuotationItem->additional_notes);
                        @endphp
                        <option value="{{ $country->name }}" @if ($country->name == ($tmp->COO ?? 'India')) selected @endif>
                            {{ $country->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td class="currencySelect">
                    @if (isset($QuotationRecord->additional_notes) && $QuotationRecord->additional_notes != null)
                        {{ json_decode($QuotationRecord->additional_notes)->currency ?? 'INR' }}
                    @else
                        INR
                    @endif

                </td>
                <td  class="priceEdit">
                    <input type="number" value="{{ $QuotationItem->Price ?? '0' }}" class="form-control pricenum" id="pricenum_{{ $index }}">
                </td>

                <td class="qunatitynum">
                    <input type="number" id="qunatitynum_{{ $index }}" class="form-control qunatitynum" value="{{ $QuotationItem->quantity ?? 1 }}" pattern="^\d+$" step='1'>
                </td>

                <td>
                    {{-- {{ $QuotationItem->unit ?? 'per-piece' }} --}}
                    <select name="unit" id="unit" class="form-control" style="width: min-content !important">
                        <option value="per-piece" @if ($QuotationItem->unit == 'per-piece') selected @endif >per-piece</option>
                        <option value="per-set" @if ($QuotationItem->unit == 'per-set') selected @endif>per-set</option>
                        <option value="per-box" @if ($QuotationItem->unit == 'per-box') selected @endif>per-box</option>
                    </select>
                </td>

                <td class="totalnum" id="totalnum_{{ $index }}">
                    {{ '0' }}
                </td>

                @foreach (json_decode($user->custom_attriute_columns) as $item)
                    @php
                        $tmp_name = str_replace(' ', '_', $item);
                        $tmp_ID = str_replace(',', '', $tmp_name);
                        $varientDetails = App\Models\ProductAttribute::where('name', $item)->first();
                        $ProductVarient = App\Models\ProductExtraInfo::where('product_id', $product->id)
                            ->where('attribute_id', $varientDetails->id)
                            ->first();
                    @endphp
                    <td class="Change-{{ $tmp_ID }} d-none">
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


<script>
    $(document).ready(function() {


        $('.qunatitynum').on('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');


            let newquan = parseFloat($(this).val());
            let price = $("#pricenum_" + $(this).attr('id').split('_')[1]).val();
            let total = newquan * price;

            let formattedTotal = total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            $("#totalnum_" + $(this).attr('id').split('_')[1]).html(formattedTotal);
        });


        $('.pricenum').on('input', function(e) {
            let newquan = parseFloat($(this).val());
            let price = $("#qunatitynum_" + $(this).attr('id').split('_')[1]).val();
            let total = newquan * price;
            let formattedTotal = total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            $("#totalnum_" + $(this).attr('id').split('_')[1]).html(formattedTotal);
        });


        // Update Total
        $(".pricenum").trigger('input');

    });
</script>
