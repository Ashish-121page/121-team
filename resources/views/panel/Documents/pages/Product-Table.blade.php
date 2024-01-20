<table class="table" id="sdhfidsj">
    <thead>
        <tr>
            {{-- <th><input type="checkbox" aria-label="Checkbox for following text input"></th> --}}
            <!-- Checkbox header -->
            <th>Packing List</th>
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

            @foreach ($custom_inputs as $item)
                @php
                    $tmp_name = str_replace(' ', '_', $item->id);
                    $tmp_ID = str_replace(',', '', $tmp_name);
                @endphp
                <th class="Change-{{ $tmp_ID }} d-none">{{ $item->text }}</th>
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
                $toggle_id = encrypt($QuotationItem->id);
            @endphp

            <tr>
                {{-- <td class="sticky-col first-col">
                    <input type="checkbox">
                    <span style="margin-left: 10px;">
                        {{ $loop->iteration }}
                    </span>
                </td> --}}
                <td>
                    <a href="{{ route('panel.Documents.Quotation.item.packingList', ['item_id' => $QuotationItem->id]) }}"
                        class="btn btn-outline-primary ">Packing List</a>
                </td>
                <td class="sdeds">
                    {{ $QuotationItem->id }}
                </td>
                <td class="sticky-col second-col">
                    <img src="{{ asset(getShopProductImage($product->id)->path ?? asset('frontend/assets/img/placeholder.png')) }}"
                        alt="" style="height: 85px; width: 85px;object-fit: contain">
                </td>
                <td class="sticky-col third-col openconsginee" style="width: 250px;text-wrap: wrap;text-align: left;"
                    data-toggleId="{{ $toggle_id }}">
                    {{ $product->title }}
                    {{-- {{ Str::limit($product->title, 20, '...') }} --}}
                </td>

                <td class="sticky-col">
                    {{ $product->model_code }}
                </td>
                {{-- <td>
                    {{ ($varients_arr != [] && $varients_arr != null) ? implode(',',$varients_arr) : 'No Varient'  }}
                </td> --}}
                <td>
                    <select name="coo" id="coo" class="form-control">
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
                        @php
                            $curr = json_decode($QuotationRecord->additional_notes)->currency ?? 'INR';
                        @endphp
                    @else
                        INR
                        @php
                            $curr = 'INR';
                        @endphp
                    @endif

                </td>
                <td class="priceEdit">
                    @if ($curr != $product->base_currency)
                        @php
                            $exchange = App\Models\UserCurrency::where('user_id', $user->id)
                                ->where('currency', $curr)
                                ->first();
                        @endphp
                        <input type="number" value="{{ round($QuotationItem->Price / ($exchange->exchange ?? 1),4) ?? '0' }}"
                            class="form-control pricenum" id="pricenum_{{ $index }}">
                    @else
                        <input type="number" value="{{ $QuotationItem->Price ?? '0' }}" class="form-control pricenum"
                            id="pricenum_{{ $index }}">
                    @endif

                </td>
                {{-- <td>
                    {!! magicstring($exchange); !!}
                </td> --}}

                <td class="qunatitynum">
                    <small class="d-none">
                        <i class="fas fa-check text-primary"></i>
                    </small>
                    <input type="number" id="qunatitynum_{{ $index }}" class="form-control qunatitynum"
                        value="{{ $QuotationItem->quantity ?? 1 }}" pattern="^\d+$" step='1'
                        data-matchwith="{{ $toggle_id }}_quantity">
                </td>

                <td>
                    {{-- {{ $QuotationItem->unit ?? 'per-piece' }} --}}
                    <select name="unit" id="unit" class="form-control" style="width: min-content !important">
                        <option value="per-piece" @if ($QuotationItem->unit == 'per-piece') selected @endif>per-piece</option>
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
                            {{ getAttruibuteValueById($ProductVarient->attribute_value_id)->attribute_value ?? '' }}
                        @else
                            -
                        @endif
                    </td>
                @endforeach



                @foreach ($custom_inputs as $item)
                    @php
                        $tmp_name = str_replace(' ', '_', $item->id);
                        $tmp_ID = str_replace(',', '', $tmp_name);
                    @endphp
                    <td class="Change-{{ $tmp_ID }} d-none">

                        @if (getCustomFieldValueById($item->id, $product->id) != null)
                            @if (is_base64_encoded(getCustomFieldValueById($item->id, $product->id)->value))
                                @php
                                    $com = implode('x', (array) json_decode(base64_decode(getCustomFieldValueById($item->id, $product->id)->value)));
                                @endphp
                                @if ($com != 'xxx')
                                    {{ $com }}
                                @endif
                            @else
                                {{ getCustomFieldValueById($item->id, $product->id)->value }}
                            @endif
                        @else
                            {{ _('--') }}
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
        $(".openconsginee").click(function(e) {
            e.preventDefault();
            let toggleId = $(this).attr('data-toggleId');
            $("." + toggleId).toggleClass('d-none');
        });


        $(".qunatitynum").keyup(function(e) {
            // e.preventDefault();
            let toggleId = $(this).attr('data-matchwith');
            $('.' + toggleId).trigger('keyup');
        });


        $(".consign_quantity").keyup(function(e) {
            e.preventDefault();
            let toggleId = $(this).attr('class').split(' ')[0];
            let og_quantity = $(`[data-matchwith="${toggleId}"]`).val();
            let total = 0;

            $.each($(`.${toggleId}`), function(indexInArray, valueOfElement) {
                total += parseInt($(valueOfElement).val());
            });


            $(`[data-matchwith="${toggleId}"]`).parent().find('small').removeClass('d-none');

            if (total == og_quantity) {
                $(`[data-matchwith="${toggleId}"]`).css('border', '1px solid green');
                $(`[data-matchwith="${toggleId}"]`).parent().find('small').find('i').removeClass(
                    'fa-times').addClass('fa-check');
            } else {
                $(`[data-matchwith="${toggleId}"]`).css('border', '1px solid red');
                $(`[data-matchwith="${toggleId}"]`).parent().find('small').find('i').removeClass(
                    'fa-check').addClass('fa-times');
            }



        });





        $('.qunatitynum').on('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');

            let newquan = parseFloat($(this).val());
            let price = $("#pricenum_" + $(this).attr('id').split('_')[1]).val();
            let total = newquan * price;

            let formattedTotal = total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');



            makeTotalAmt()

            $("#totalnum_" + $(this).attr('id').split('_')[1]).html(formattedTotal);
        });



        $('.pricenum').on('input', function(e) {
            let newquan = parseFloat($(this).val());
            let price = $("#qunatitynum_" + $(this).attr('id').split('_')[1]).val();
            let total = newquan * price;
            let formattedTotal = total.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            makeTotalAmt()

            $("#totalnum_" + $(this).attr('id').split('_')[1]).html(formattedTotal);
        });


        // Update Total
        $(".pricenum").trigger('input');

    });
</script>
