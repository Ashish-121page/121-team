@extends('backend.layouts.main')
@section('title', 'Packing List')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
        <style>
            .text-success {
                color: #6666cc !important;
            }

            table {
                vertical-align: middle !important;
                text-align: center !important;
            }

            .form-group {
                border: none !important;
            }


            table input,
            select {
                width: 65px !important;
            }

            .maintabel tr:nth-child(-n+4) {
                widows: 150px !important;
            }

            .maintabel th:nth-child(-n+2),
            .maintabel td:nth-child(-n+2) {
                position: sticky;
                left: 0;
                background-color: #f2f2f2;
                z-index: 1;
                width: 150px !important;
            }
        </style>
    @endpush

    <div class="container" style="max-width:1350px !important;">

        <div class="row">
            <div class="col-lg-2 col-12">
                {{-- For Image --}}
                <div class="card">
                    <div class="card-body">
                        <img src="{{ asset(getShopProductImage($ProductRecord->id)->path ?? asset('frontend/assets/img/placeholder.png')) }}"
                            class="img-fluid my-2" style="height: 100px;width: 100%;object-fit: contain;" alt="">
                        <span>
                            <p class="text-center ">
                                {{ $ProductRecord->model_code ?? '' }}
                                @php
                                    $rec = [];
                                @endphp
                                @foreach ($product_variant_combo as $loop1)
                                    @foreach ($loop1 as $item)
                                        @php
                                            array_push($rec, getAttruibuteValueById($item)->parent_id);
                                        @endphp
                                    @endforeach
                                @endforeach

                                @foreach (array_unique($rec) as $item)
                                    - {{ getAttruibuteValueById(getParentAttruibuteValuesByIds($item, [$ProductRecord->id]))->attribute_value }}
                                @endforeach

                            </p>
                        </span>
                    </div>
                </div>
            </div>



            <div class="col-lg-10 col-12">
                <form method="GET" action="{{ route('panel.Documents.Quotation.item.packingList.save') }}">
                    <input type="hidden" name="quote_id" value="{{ encrypt($Quotation->id) }}">
                    <input type="hidden" name="quote_id_item" value="{{ encrypt($QuotationItem->id) }}">
                    <input type="hidden" name="product_item" value="{{ encrypt($ProductRecord->id) }}">

                    <input type="submit" id="submitshow" class="d-none" value="submit">

                    {{-- for Data   --}}
                    <div class="card">
                        <div class="card-head">
                            {{-- Keep Naviagtion --}}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12 my-3">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <div class="h6">Product Weight</div>
                                        </div>
                                        <div class="col-md-4 col-12 ">
                                            <div class="form-group">
                                                <label for="item_gross_weight">Gross Weight</label>
                                                <input type="text" name="weight[gross]" id="item_gross_weight"
                                                    class="form-control" placeholder="Product Length"
                                                    value="{{ $shipping->gross_weight ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="item_net_weight">Net Weight</label>
                                                <input type="text" name="weight[net]" id="item_net_weight"
                                                    class="form-control" placeholder="Product Width"
                                                    value="{{ $shipping->weight ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-12">
                                            <div class="form-group">
                                                <label for="item_unit_weight">Weight UOM</label>
                                                {{-- <input type="text" name="weight[uom]" id="item_unit_weight"
                                                class="form-control" placeholder="Product Height"
                                                value="{{ $shipping->unit ?? '' }}"> --}}

                                                <select name="weight[uom]" id="item_unit_weight"
                                                    class="form-control select2">
                                                    @foreach ($weight_uom as $item)
                                                        <option value="{{ $item }}"
                                                            @if ((Str::lower($shipping->unit) ?? '') == $item) selected @endif>
                                                            {{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12 my-3">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <div class="h6">Product Dimensions</div>
                                        </div>
                                        <div class="col-md-4 col-lg-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="take-length">Product Length</label>
                                                <input type="text" name="product[length]" id="take-length"
                                                    class="form-control" value="{{ $shipping->length ?? '' }}"
                                                    placeholder="Product Length">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-lg-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="take-width">Product Width</label>
                                                <input type="text" name="product[width]" id="take-width"
                                                    class="form-control" placeholder="Product Width"
                                                    value="{{ $shipping->width ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-lg-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="take-height">Product Height</label>
                                                <input type="text" name="product[height]" id="take-height"
                                                    class="form-control" placeholder="Product Height"
                                                    value="{{ $shipping->height ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-lg-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label for="take-lenuom">LWH UOM</label>
                                                {{-- <input type="text" name="product[height]" id="take-lenuom"
                                                class="form-control" placeholder="Product Height"
                                                value="{{ $shipping->length_unit ?? '' }}"> --}}

                                                <select name="product[height]" id="take-lenuom"
                                                    class="form-control select2">
                                                    @foreach ($length_uom as $item)
                                                        <option value="{{ $item }}"
                                                            @if ((Str::lower($shipping->length_unit) ?? '') == $item) selected @endif>
                                                            {{ $item }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-lg-4 col-sm-6 col-12 my-2 d-none ">
                                            <label for="tabledata">Json Data</label>
                                            <textarea name="tabledata" id="tabledata" class="form-control" cols="50" rows="1"></textarea>
                                        </div>

                                        <div class="col-md-4 col-lg-4 col-sm-6 col-12 my-2 d-none ">
                                            <label for="summary-tabledata">Total Summary Json Data</label>
                                            <textarea name="summary-tabledata" id="summary-tabledata" class="form-control" cols="50" rows="1"></textarea>
                                        </div>

                                        <div class="col-md-4 col-lg-4 col-sm-6 col-12 my-2 d-none ">
                                            <label for="consignee-tabledata">Conginee conclude Json Data</label>
                                            <textarea name="consignee-tabledata" id="consignee-tabledata" class="form-control" cols="50" rows="1"></textarea>
                                        </div>


                                    </div>




                                </div>

                            </div>
                        </div>
                    </div>

                </form>
            </div>


        </div>


        <div class="row">
            <div class="col-12" id="working_table">
                <table class="table table-responsive maintabel">
                    <thead>
                        <tr>
                            <th scope="col" style="display: none" data-dbf="consignee_id">Consignee Id</th>
                            <th scope="col" data-dbf="consignee_ref_id">Consignee</th>
                            <th scope="col" data-dbf="consignment_from">FROM</th>
                            <th scope="col" data-dbf="consignment_to">TO</th>
                            <th scope="col" style="display: none" data-dbf="consignment_carton_box_qty">Carton box qty
                            </th>
                            <th scope="col" data-dbf="consignment_carton_qty">Carton qty</th>
                            <th scope="col" data-dbf="consignment_qty_consignment">Qty - consignee</th>
                            <th scope="col" data-dbf="consignment_length">L</th>
                            <th scope="col" data-dbf="consignment_width">B</th>
                            <th scope="col" data-dbf="consignment_height">H</th>
                            <th scope="col" data-dbf="consignment_lwnuom">LWH UOM</th>
                            <th scope="col" data-dbf="consignment_gross_weight_total">Total gross weight</th>
                            <th scope="col" data-dbf="consignment_gross_weight_uom">Gross UOM</th>
                            <th scope="col" data-dbf="consignment_net_weight_total">Total net weight</th>
                            <th scope="col" data-dbf="consignment_newt_weight_uom">Net UOM</th>
                            <th scope="col" data-dbf="consignment_cbm_indiv">CBM ( INDIV )</th>
                            <th scope="col" data-dbf="consignment_cbm_indiv_caton">CBM ( Indiv - Carton )</th>
                            <th scope="col" data-dbf="consignment_cbm_batch_master">CBM ( Batch - Mastor Carton )</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($QuotationItem->packing_list != null || $QuotationItem->packing_list != '')

                            @php
                                $tmp_ids_arr = [];
                            @endphp
                            @foreach ($avl_packinglist as $pindex => $record_packinglist)
                                @php
                                    $tmp_id = generateRandomStringNative(10);
                                    array_push($tmp_ids_arr, $tmp_id);
                                @endphp
                                <tr>
                                    <td style="display: none">
                                        {{ $record_packinglist->consignee_id ?? '' }}
                                    </td>
                                    <td scope="row">
                                        <input type="text" class="form-control" id="consinee_name"
                                            value="{{ $record_packinglist->consignee_ref_id ?? '' }}"
                                            @if ($record_packinglist->consignee_id ?? '' === '') readonly @endif>
                                    </td>
                                    <td>
                                        <input type="number" min="0"  class="form-control from_carton" id="from_carton"
                                            value="{{ $record_packinglist->consignment_from ?? '' }}"
                                            data-rid="{{ $tmp_id }}">
                                    </td>
                                    <td>
                                        <input type="number" min="0" class="form-control to_carton" id="to_carton"
                                            value="{{ $record_packinglist->consignment_to ?? '' }}"
                                            data-rid="{{ $tmp_id }}">
                                    </td>
                                    <td style="display: none">
                                        <input type="text" class="form-control carton_quantity_box"
                                            value="{{ $record_packinglist->consignment_carton_box_qty ?? '' }}"
                                            id="carton_quantity_box" data-rid="{{ $tmp_id }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control carton_quantity" id="carton_quantity"
                                            value="{{ $record_packinglist->consignment_carton_qty ?? '' }}"
                                            value="{{ $carton_details->standard_carton ?? '' }}"
                                            data-rid="{{ $tmp_id }}">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control consign_qtyitem" id="consign_qtyitem"
                                            data-rid="{{ $tmp_id }}" readonly
                                            value="{{ $record_packinglist->consignment_qty_consignment ?? 0 }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control take-length" id="length_packing"
                                            value="{{ $record_packinglist->consignment_length ?? ($carton_details->carton_length ?? 0) }}"
                                            data-rid="{{ $tmp_id }}">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control take-width" id="width_packing"
                                            value="{{ $record_packinglist->consignment_width ?? ($carton_details->carton_width ?? 0) }}"
                                            data-rid="{{ $tmp_id }}">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control take-height" id="height_packing"
                                            value="{{ $record_packinglist->consignment_height ?? ($carton_details->carton_height ?? 0) }}"
                                            data-rid="{{ $tmp_id }}">
                                    </td>

                                    <td>
                                        <select class="form-control take-lenuom" id="lenuom_packing"
                                            data-rid="{{ $tmp_id }}">
                                            @foreach ($length_uom as $item)
                                                <option value="{{ $item }}"
                                                    @if (
                                                        (Str::lower($record_packinglist->consignment_lwnuom) ??
                                                            (Str::lower($carton_details->Carton_Dimensions_unit) ?? '')) ==
                                                            $item) selected @endif>
                                                    {{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control gross_weight_packing"
                                            id="gross_weight_packing" readonly
                                            value="{{ $record_packinglist->consignment_gross_weight_total ?? 0 }}"
                                            data-rid="{{ $tmp_id }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control take-weight-uom"
                                            id="gross_unit_weight_packing" readonly
                                            value="{{ $record_packinglist->consignment_gross_weight_uom ?? 0 }}"
                                            data-rid="{{ $tmp_id }}" style="width:50px !important;">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control net_weight_packing"
                                            id="net_weight_packing" readonly
                                            value="{{ $record_packinglist->consignment_net_weight_total ?? 0 }}"
                                            data-rid="{{ $tmp_id }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control take-weight-uom"
                                            id="net_unit_weight_packing" readonly
                                            value="{{ $record_packinglist->consignment_newt_weight_uom ?? 0 }}"
                                            data-rid="{{ $tmp_id }}" style="width:50px !important;">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="consign_qty_indiv" readonly
                                            value="{{ $record_packinglist->consignment_cbm_indiv ?? 0 }}"
                                            data-rid="{{ $tmp_id }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control consign_qty_carton"
                                            id="consign_qty_carton" readonly
                                            value="{{ $record_packinglist->consignment_cbm_indiv_caton ?? 0 }}"
                                            data-rid="{{ $tmp_id }}">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" id="consign_qty_master" readonly
                                            value="{{ $record_packinglist->consignment_cbm_batch_master ?? 0 }}"
                                            data-rid="{{ $tmp_id }}">
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @forelse ($consignee_record as $record)
                                <tr>
                                    <td style="display: none">
                                        {{ $record->id }}
                                    </td>
                                    <td scope="row">
                                        <input type="text" class="form-control" id="consinee_name"
                                            value="{{ json_decode($record->consignee_details)->ref_id ?? '' }}" readonly>
                                    </td>
                                    <td>
                                        <input type="number" min="0" class="form-control from_carton" id="from_carton"
                                            data-rid="{{ $record->id }}">
                                    </td>
                                    <td>
                                        <input type="number" min="0" class="form-control to_carton" id="to_carton"
                                            data-rid="{{ $record->id }}">
                                    </td>
                                    <td style="display: none">
                                        <input type="text" class="form-control carton_quantity_box"
                                            id="carton_quantity_box" data-rid="{{ $record->id }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control carton_quantity" id="carton_quantity"
                                            value="{{ $carton_details->standard_carton ?? '' }}"
                                            data-rid="{{ $record->id }}">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control consign_qtyitem" id="consign_qtyitem"
                                            data-rid="{{ $record->id }}" readonly value="0">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control take-length" id="length_packing"
                                            value="{{ $carton_details->carton_length ?? 0 }}"
                                            data-rid="{{ $record->id }}">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control take-width" id="width_packing"
                                            value="{{ $carton_details->carton_width ?? 0 }}"
                                            data-rid="{{ $record->id }}">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control take-height" id="height_packing"
                                            value="{{ $carton_details->carton_height ?? 0 }}"
                                            data-rid="{{ $record->id }}">
                                    </td>

                                    <td>
                                        <select class="form-control take-lenuom" id="lenuom_packing"
                                            data-rid="{{ $record->id }}">
                                            @foreach ($length_uom as $item)
                                                <option value="{{ $item }}"
                                                    @if ((Str::lower($carton_details->Carton_Dimensions_unit) ?? '') == $item) selected @endif>
                                                    {{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control gross_weight_packing"
                                            id="gross_weight_packing" readonly value="0"
                                            data-rid="{{ $record->id }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control take-weight-uom"
                                            id="gross_unit_weight_packing" readonly value="0"
                                            data-rid="{{ $record->id }}" style="width:50px !important;">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control net_weight_packing"
                                            id="net_weight_packing" readonly value="0"
                                            data-rid="{{ $record->id }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control take-weight-uom"
                                            id="net_unit_weight_packing" readonly value="0"
                                            data-rid="{{ $record->id }}" style="width:50px !important;">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" id="consign_qty_indiv" readonly
                                            value="0" data-rid="{{ $record->id }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control consign_qty_carton"
                                            id="consign_qty_carton" readonly value="0"
                                            data-rid="{{ $record->id }}">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" id="consign_qty_master" readonly
                                            value="0" data-rid="{{ $record->id }}">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="18">
                                        <div class="alert alert-danger">No Consignee Found</div>
                                    </td>
                                </tr>
                            @endforelse
                        @endif




                        <tr id="calc_total">
                            <td style="display: none"></td>
                            <td>
                                <button type="button" class="btn btn-outline-primary addcosign">Add+</button>
                                Total
                            </td>
                            <td></td>
                            <td>
                                <span class="total_count-to">No. of cartons</span>
                            </td>
                            <td style="display: none"></td>
                            <td></td>
                            <td>
                                <span class="total_count-qty_consignee">Qty - consignee</span>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <span class="total_count-gross_weight">Total gross weight</span>
                            </td>
                            <td></td>
                            <td>
                                <span class="total_count-net_weight">Total net weight</span>
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <span class="total_count-cbn_ind">CBM ( INDIV )</span>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        {{-- For Summary --}}

        <div class="row">
            <div class="col-12">
                <div class="h4">Summary</div>
            </div>


            <div class="col-md-6 col-lg-4 col-12">
                <div class="h6">Total order</div>
                <table class="table table-responsive" id="summary-tabellast">
                    <thead>
                        <tr>
                            <th data-dbf="text"> text </th>
                            <th data-dbf="value"> value </th>
                            <th data-dbf="unit"> unit </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $data = json_decode($QuotationItem->packing_summary ?? '');
                            if ($data != null) {
                                $data = $data->overall;
                            }
                            $classArray = ['total_count-qty_consignee', 'total_count-gross_weight', 'total_count-net_weight', 'total_count-cbn_ind', 'total_count-to', 'number_of_consingee'];
                        @endphp

                        @if ($data != null)
                            @foreach ($data as $inc => $item)
                                <tr>
                                    <td>{{ $item->text ?? '' }}</td>
                                    <td class="{{ $classArray[$inc] ?? '' }}">{{ $item->value ?? '' }}</td>
                                    <td> {{ $item->unit ?? '' }} </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>Total quantity</td>
                                <td class="total_count-qty_consignee">0</td>
                                <td>
                                    < PI </td>
                            </tr>
                            <tr>
                                <td>Gross weight</td>
                                <td class="total_count-gross_weight">0</td>
                                <td>kgs</td>
                            </tr>
                            <tr>
                                <td>Net weight</td>
                                <td class="total_count-net_weight">0</td>
                                <td>kgs</td>
                            </tr>
                            <tr>
                                <td>CBM - cartons</td>
                                <td class="total_count-cbn_ind">0</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>No. of cartons</td>
                                <td class="total_count-to">0</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>No. of consignee</td>
                                <td>{{ number_format($consignee_record->count(), 2) ?? 0 }}</td>
                                <td></td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>


            <div class="col-md-6 col-lg-8 col-12 ">
                <div class="h6">Consginee-wise</div>
                <table class="table table-responsive " id="consinee-tabellast">
                    <thead>
                        <tr>
                            <th data-dbf="ref_id">ID</th>
                            <th data-dbf="consign_qty_total">Quantity</th>
                            <th data-dbf="consign_gross_weight">Gross weight (kg)</th>
                            <th data-dbf="consignment_net_weight">Net weight (kg)</th>
                            <th data-dbf="consignment_cbm_carton">CBM - cartons</th>
                            <th data-dbf="consignment_number_of_carton">No. of cartons</th>
                        </tr>
                    </thead>
                    <tbody>


                        @if (json_decode($QuotationItem->packing_summary ?? '') ?? [] != [])
                            @foreach (json_decode($QuotationItem->packing_summary)->consignee_wise ?? [] as $ind => $consinee_summ)
                                @php
                                    $tmo_id = $tmp_ids_arr[$ind] ?? '';
                                @endphp
                                <tr>
                                    <td>{{ $consinee_summ->ref_id ?? '' }}</td>
                                    <td class="update_quantity" data-rid="{{ $tmo_id }}">110</td>
                                    <td class="update_grossweight" data-rid="{{ $tmo_id }}">220</td>
                                    <td class="update_newtweight" data-rid="{{ $tmo_id }}">154</td>
                                    <td class="update_cbm" data-rid="{{ $tmo_id }}">0.0250</td>
                                    <td class="update_num-carton" data-rid="{{ $tmo_id }}">10</td>
                                </tr>
                            @endforeach
                        @else
                            @forelse ($consignee_record as $record)
                                @php
                                    $json = json_decode($record->consignee_details) ?? '';
                                @endphp
                                <tr>
                                    <td>{{ $json->ref_id ?? '' }}</td>
                                    <td class="update_quantity" data-rid="{{ $record->id }}">110</td>
                                    <td class="update_grossweight" data-rid="{{ $record->id }}">220</td>
                                    <td class="update_newtweight" data-rid="{{ $record->id }}">154</td>
                                    <td class="update_cbm" data-rid="{{ $record->id }}">0.0250</td>
                                    <td class="update_num-carton" data-rid="{{ $record->id }}">10</td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="alert alert-danger">No Consignee Found</div>
                                    </td>
                                </tr>
                            @endforelse
                        @endif



                    </tbody>
                </table>
            </div>

            <div class="col-12 d-flex  justify-content-center align-items-center ">
                <button type="button" class="btn btn-outline-primary  saveinfolast">Save</button>
            </div>
        </div>


    </div>



    @section('push-script')

        @if (isset($data) && $data != null)
            <script>
                $(document).ready(function() {
                    $(".from_carton").trigger("input");
                });
            </script>
        @endif

        <script>
            // Section for Updating the Value on Load of DOM

            // console.log("%cYou Don't Have Permission to access this console!!", "color: red; background-color: yellow; font-size: x-large");

            $(document).on('click', '.addcosign', function(e) {
                e.preventDefault();
                appendTable();
            });

            $(document).on('click', '.saveinfolast', function(e) {
                e.preventDefault();
                let tabledata = $("#tabledata")
                tabledata.val(JSON.stringify(tableToJson(document.getElementById('working_table'))));
                console.log(tabledata.val());

                let summary_tabel = $("#summary-tabledata")
                summary_tabel.val(JSON.stringify(tableToJson(document.getElementById('summary-tabellast'))));

                let consignee_tabledata = $("#consignee-tabledata")
                consignee_tabledata.val(JSON.stringify(tableToJson(document.getElementById('consinee-tabellast'))));
                $("#submitshow").trigger("click");
            });

            // For Length
            $(document).on('keyup', '#take-length', function() {
                $('.take-length').val($(this).val());
                $.each($('.take-lenuom'), function(indexInArray, valueOfElement) {
                    let rid = $(this).data('rid');
                    updateUOM(rid);
                    updateCBMIndv(rid);
                });
            });

            // For Width
            $(document).on('keyup', '#take-width', function() {
                $('.take-width').val($(this).val());
                $.each($('.take-lenuom'), function(indexInArray, valueOfElement) {
                    let rid = $(this).data('rid');
                    updateUOM(rid);
                    updateCBMIndv(rid);
                });
            });

            // For Height
            $(document).on('keyup', '#take-height', function() {
                $('.take-height').val($(this).val());
                $.each($('.take-lenuom'), function(indexInArray, valueOfElement) {
                    let rid = $(this).data('rid');
                    updateUOM(rid);
                    updateCBMIndv(rid);
                });
            });

            // For Lenuom
            $(document).on('change', '#take-lenuom', function() {
                $('.take-lenuom').val($(this).val());
                $.each($('.take-lenuom'), function(indexInArray, valueOfElement) {
                    let rid = $(this).data('rid');
                    updateUOM(rid);
                    updateCBMIndv(rid);
                });
            });


            $(document).on('change', '#item_unit_weight', function() {
                // $('.take-weight-uom').val($(this).val());
                $('.take-weight-uom').val('kg');
                $.each($('.take-weight-uom'), function(indexInArray, valueOfElement) {
                    let rid = $(this).data('rid');
                    updateUOM(rid);
                    updateCBMCarton(rid);
                    updateCBMIndv(rid);
                    $("#item_net_weight").trigger("change");
                });
            });



            $(document).on('keyup', '#item_net_weight,#item_gross_weight', function() {
                $.each($('.take-weight-uom'), function(indexInArray, valueOfElement) {
                    let rid = $(this).data('rid');
                    updateUOM(rid);
                });
            });


            $(document).on('input', '.to_carton', function(e) {
                let rid = $(this).data('rid');
                rid = +rid + 1;
                let nextinput = $("#from_carton[data-rid='" + rid + "']");
                nextinput.val(+$(this).val() + 1);
            });

            $(document).on('input', '.from_carton', function(e) {
                let rid = $(this).data('rid');
                if (rid == 1) {
                    return;
                }

                rid = +rid - 1;
                let previnput = $("#to_carton[data-rid='" + rid + "']").val();

                if (+previnput === +$(this).val()) {
                    alert('Please Enter incremental Value');
                    $(this).val('');
                }
            });


            $(document).on('change', '.from_carton', function(e) {
                let rid = $(this).data('rid');
                if (rid == 1) {
                    return;
                }

                rid = +rid - 1;
                let previnput = $("#to_carton[data-rid='" + rid + "']").val();

                if (+previnput > +$(this).val()) {
                    alert('Please Enter incremental Value');
                    $(this).val('');
                }
            })


            $(document).on('input', ".from_carton,.to_carton,.carton_quantity", function(e) {
                let rid = $(this).data('rid');
                let from = $("#from_carton[data-rid='" + rid + "']").val();
                let to = $("#to_carton[data-rid='" + rid + "']").val();

                let carton_quantity = (to - from + 1);
                $("#carton_quantity_box[data-rid='" + rid + "']").val(carton_quantity);


                $(".update_num-carton[data-rid='" + rid + "']").html(carton_quantity);


                let consign_qtyitem = $("#consign_qtyitem[data-rid='" + rid + "']");
                let carton_piece_quantity = $("#carton_quantity[data-rid='" + rid + "']").val();

                consign_qtyitem.val(carton_piece_quantity * carton_quantity);

                $(".update_quantity[data-rid='" + rid + "']").html(carton_piece_quantity * carton_quantity);


                updateTotal('carton_quantity_box', 'total_count-to', 1);
                updateTotal('consign_qtyitem', 'total_count-qty_consignee');


                updateUOM(rid);
                updateCBMCarton(rid);
                updateCBMIndv(rid);
            });


            $(document).on('input', '.take-width,.take-height,.take-lenuom,.take-length', function(e) {
                let rid = $(this).data('rid');
                updateUOM(rid);
                updateCBMCarton(rid);
            });



            $(document).on('input', "#take-length", function(e) {
                e.preventDefault();

                $.each($("#take-length"), function(indexInArray, valueOfElement) {
                    let rid = $(this).data('rid');
                    updateCBMIndv(rid);
                });

            });

            // For Carton Quantity
            $("#item_unit_weight").trigger("change");
            $("#take-lenuom").trigger("change");
            // $("#take-height").trigger("keyup");
            // $("#take-length").trigger("keyup");
            // $("#take-width").trigger("keyup");

            function tableToJson(table) {
                var data = [];

                // Function to clean string
                function cleanString(str) {
                    return str.replace(/\s+/g, " ").trim();
                }

                // Function to get text, select value, or input value
                function getTextOrSelectValue(element) {
                    // Check if element is a select element
                    if (element.tagName === "SELECT") {
                        return element.options[element.selectedIndex].value;
                    }
                    // Check if element is an input element or image
                    if (element.tagName === "INPUT" || element.tagName === "TEXTAREA") {
                        return element.value;
                    }
                    if (element.tagName === "IMG") {
                        return element.src;
                    }
                    // For content editable or other elements
                    return element.contentEditable === "true" ?
                        element.innerText :
                        element.textContent;
                }

                // Get headers text, skip headers with class 'd-none'
                var headers = [];
                table
                    .querySelectorAll("thead th:not(.d-none)")
                    .forEach(function(header, index) {
                        headers[index] = header.getAttribute('data-dbf');
                    });

                // Convert rows to objects, skip rows and cells with class 'd-none'
                Array.from(table.querySelectorAll("tbody tr:not(.d-none)")).forEach(function(
                    row
                ) {
                    var rowData = {};
                    Array.from(row.querySelectorAll("td:not(.d-none)")).forEach(function(
                        cell,
                        index
                    ) {
                        // Check for select, input, textarea, or image elements within cell, else use cell text
                        var value = cell.querySelector("select, input, textarea, img") ?
                            getTextOrSelectValue(
                                cell.querySelector("select, input, textarea, img")
                            ) :
                            cleanString(getTextOrSelectValue(cell));
                        if (headers[index]) {
                            rowData[headers[index]] = value;
                        }
                    });
                    data.push(rowData);
                });

                return data;
            }


            function updateTotal(update_id, getvalue_id, round = 4) {
                let to_carton = $("." + update_id);
                let to_carton_count = 0;
                $.each(to_carton, function(indexInArray, valueOfElement) {
                    to_carton_count += +$(this).val();
                });
                to_carton_count = to_carton_count.toFixed(round);

                $("." + getvalue_id).html(to_carton_count);
            }

            function updateUOM(rid) {
                let item_gross_weight = $("#item_gross_weight").val();
                let item_new_weight = $("#item_net_weight").val();
                let item_unit_weight = $("#item_unit_weight").val();
                let carton_quantity = $("#carton_quantity[data-rid='" + rid + "']").val();

                gweight = convertToKilograms(item_gross_weight, item_unit_weight);
                nweight = convertToKilograms(item_new_weight, item_unit_weight);


                finalgweight = gweight * carton_quantity
                finalgweight = finalgweight.toFixed(2);


                $("#gross_weight_packing[data-rid='" + rid + "']").val(finalgweight);
                $(".update_grossweight[data-rid='" + rid + "']").html(finalgweight);

                finalnweight = nweight * carton_quantity;
                finalnweight = finalnweight.toFixed(2);

                $("#net_weight_packing[data-rid='" + rid + "']").val(finalnweight);
                $(".update_newtweight[data-rid='" + rid + "']").html(finalnweight);


                updateTotal('net_weight_packing', 'total_count-net_weight');
                updateTotal('gross_weight_packing', 'total_count-gross_weight');

            }



            function updateCBMCarton(rid) {
                // Carton Detials
                let length_packing = $("#length_packing[data-rid='" + rid + "']").val();
                let width_packing = $("#width_packing[data-rid='" + rid + "']").val();
                let height_packing = $("#height_packing[data-rid='" + rid + "']").val();
                let lenuom_packing = $("#lenuom_packing[data-rid='" + rid + "']").val();

                // console.log(rid, length_packing, width_packing, height_packing, lenuom_packing);



                clength_update = convertToCentimeters(length_packing, lenuom_packing);
                cwidth_update = convertToCentimeters(width_packing, lenuom_packing);
                cheight_update = convertToCentimeters(height_packing, lenuom_packing);

                ind_calc = ((clength_update / 100) * (cwidth_update / 100) * (cheight_update / 100));


                ind_calc = ind_calc.toFixed(4);
                $("#consign_qty_carton[data-rid='" + rid + "']").val(ind_calc);
                $(".update_cbm[data-rid='" + rid + "']").html(ind_calc);

                updateTotal('consign_qty_carton', 'total_count-cbn_ind');
                updateCBMBatchcarton(rid)

            }

            function updateCBMIndv(rid) {
                let length = $("#take-length").val();
                let width = $("#take-width").val();
                let height = $("#take-height").val();
                let uom = $("#take-lenuom").val();

                plen = convertToCentimeters(length, uom);
                pwidth = convertToCentimeters(width, uom);
                pheight = convertToCentimeters(height, uom);

                ind_calc = ((plen / 100) * (pwidth / 100) * (pheight / 100));

                ind_calc = ind_calc.toFixed(4);
                $("#consign_qty_indiv[data-rid='" + rid + "']").val(ind_calc);

                updateCBMBatchcarton(rid);


            }

            function updateCBMBatchcarton(rid) {
                let carton_quantity = $("#carton_quantity_box[data-rid='" + rid + "']").val();
                let consign_qty_carton = $("#consign_qty_carton[data-rid='" + rid + "']").val();
                let result = carton_quantity * consign_qty_carton;

                result = result.toFixed(4);

                $("#consign_qty_master[data-rid='" + rid + "']").val(result);
            }


            function convertToCentimeters(value, unit) {
                switch (unit.toLowerCase()) {
                    case 'mm':
                        return value / 10; // 1 cm = 10 mm
                    case 'cm':
                        return value;
                    case 'mtr':
                        return value * 100; // 1 m = 100 cm
                    case 'km':
                        return value * 100000; // 1 km = 100,000 cm
                    case 'ft':
                        return value * 30.48; // 1 ft = 30.48 cm
                    case 'inches':
                        return value * 2.54; // 1 in = 2.54 cm
                    case 'dia':
                        return value; // Assuming diameter is already in cm
                    default:
                        return 'Invalid unit';
                }
            }


            function convertToKilograms(value, unit) {
                switch (unit.toLowerCase()) {
                    case 'gm':
                        return value / 1000; // 1 kg = 1000 gm
                    case 'kg':
                        return value;
                    case 'mg':
                        return value / 1000000; // 1 kg = 1,000,000 mg
                    case 'tonnes':
                        return value * 1000; // 1 tonne = 1000 kg
                    case 'carats':
                        return value / 5000; // 1 kg = 5000 carats (approximate conversion)
                    case 'ltr':
                        return value; // Assuming liters represent a liquid, not weight
                    default:
                        return 'Invalid unit';
                }
            }
        </script>

        <script>
            function appendTable() {
                let rid = +$(".from_carton").last().data('rid') + +1;
                let takeuomtag = `<select class="form-control take-lenuom" id="lenuom_packing" data-rid="${rid}">
                                        @foreach ($length_uom as $item)
                                            <option value="{{ $item }}"
                                                @if ((Str::lower($carton_details->Carton_Dimensions_unit) ?? '') == $item) selected @endif>
                                                {{ $item }}</option>
                                        @endforeach
                                    </select>`;

                let consinee_data = `<select class="form-control append_element " id="consignee_deatails" data-rid="${rid}">
                                        @foreach ($consign_select as $key => $item)
                                            <option value="{{ $item }}" >
                                                {{ $item ?? '' }}</option>
                                        @endforeach
                                    </select>`;


                // Your existing code to create new table row
                let data = `<tr>
                    <td style="display: none"></td>
                    <td scope="row">
                        ${consinee_data}
                    </td>
                    <td>
                        <input type="number" class="form-control from_carton" id="from_carton" data-rid="${rid}">
                    </td>
                    <td>
                        <input type="number" class="form-control to_carton" id="to_carton"  data-rid="${rid}">
                    </td>
                    <td style='display:none;'>
                        <input type="text" class="form-control carton_quantity_box" id="carton_quantity_box"  data-rid="${rid}">
                    </td>
                    <td>
                        <input type="text" class="form-control carton_quantity" id="carton_quantity"  data-rid="${rid}">
                    </td>

                    <td>
                        <input type="text" class="form-control consign_qtyitem" id="consign_qtyitem" readonly value="0"  data-rid="${rid}">
                    </td>
                    <td>
                        <input type="text" class="form-control take-length" id="length_packing"  data-rid="${rid}">
                    </td>

                    <td>
                        <input type="text" class="form-control take-width" id="width_packing"  data-rid="${rid}">
                    </td>

                    <td>
                        <input type="text" class="form-control take-height" id="height_packing"  data-rid="${rid}">
                    </td>

                    <td>
                        ${takeuomtag}
                    </td>
                    <td>
                        <input type="text" class="form-control gross_weight_packing" id="gross_weight_packing" readonly
                            value="0"  data-rid="${rid}">
                    </td>
                    <td>
                        <input type="text" class="form-control take-weight-uom" id="gross_unit_weight_packing" readonly
                            value="kg"  data-rid="${rid}" style="width:50px !important;">
                    </td>
                    <td>
                        <input type="text" class="form-control net_weight_packing" id="net_weight_packing" readonly
                            value="0"  data-rid="${rid}">
                    </td>
                    <td>
                        <input type="text" class="form-control take-weight-uom" id="net_unit_weight_packing" readonly
                            value="kg"  data-rid="${rid}" style="width:50px !important;">
                    </td>
                    <td>
                        <input type="text" class="form-control" id="consign_qty_indiv" readonly value="0"  data-rid="${rid}">
                    </td>
                    <td>
                        <input type="text" class="form-control consign_qty_carton" id="consign_qty_carton" readonly
                            value="0"  data-rid="${rid}">
                    </td>

                    <td>
                        <input type="text" class="form-control" id="consign_qty_master" readonly value="0"  data-rid="${rid}">
                    </td>


                </tr>`;

                // Append the new row to the table
                $('#working_table tr:last').before(data);


                let data2 = `<tr>
                                <td>
                                    ${consinee_data}
                                </td>
                                <td class="update_quantity" data-rid="${rid}">0</td>
                                <td class="update_grossweight" data-rid="${rid}" >0</td>
                                <td class="update_newtweight" data-rid="${rid}" >0</td>
                                <td class="update_cbm" data-rid="${rid}" >0</td>
                                <td class="update_num-carton" data-rid="${rid}" >0</td>
                            </tr>`;


                $("select.append_element").change(function(e) {
                    e.preventDefault();
                    let tmprid = $(this).data('rid');
                    let value = $(this).val();

                    $.each($("select.append_element[data-rid='" + tmprid + "']"), function(indexInArray,
                        valueOfElement) {
                        $(valueOfElement).val(value);
                    });

                });

                $('#consinee-tabellast tbody').append(data2);





                // Delegated event handler for dynamically added elements
                $(document).on('input', '.to_carton', function(e) {
                    let rid = $(this).data('rid');
                    rid = +rid + 1;
                    let nextinput = $("#from_carton[data-rid='" + rid + "']");
                    nextinput.val(+$(this).val() + 1);
                });

                $(document).on('input', '.from_carton', function(e) {
                    let rid = $(this).data('rid');
                    if (rid == 1) {
                        return;
                    }

                    rid = +rid - 1;
                    let previnput = $("#to_carton[data-rid='" + rid + "']").val();

                    if (previnput === $(this).val()) {
                        alert('Please Enter incremental Value');
                        $(this).val('');
                    }
                });


                // For Length
                $(document).on('keyup', '#take-length', function() {
                    $('.take-length').val($(this).val());
                    $.each($('.take-lenuom'), function(indexInArray, valueOfElement) {
                        let rid = $(this).data('rid');
                        updateUOM(rid);
                        updateCBMIndv(rid);
                    });
                });

                // For Width
                $(document).on('keyup', '#take-width', function() {
                    $('.take-width').val($(this).val());
                    $.each($('.take-lenuom'), function(indexInArray, valueOfElement) {
                        let rid = $(this).data('rid');
                        updateUOM(rid);
                        updateCBMIndv(rid);
                    });
                });

                // For Height
                $(document).on('keyup', '#take-height', function() {
                    $('.take-height').val($(this).val());
                    $.each($('.take-lenuom'), function(indexInArray, valueOfElement) {
                        let rid = $(this).data('rid');
                        updateUOM(rid);
                        updateCBMIndv(rid);
                    });
                });

                // For Lenuom
                $(document).on('change', '#take-lenuom', function() {
                    $('.take-lenuom').val($(this).val());
                    $.each($('.take-lenuom'), function(indexInArray, valueOfElement) {
                        let rid = $(this).data('rid');
                        updateUOM(rid);
                        updateCBMIndv(rid);
                    });
                });


                $(document).on('change', '#item_unit_weight', function() {
                    // $('.take-weight-uom').val($(this).val());
                    $('.take-weight-uom').val('kg');
                    $.each($('.take-weight-uom'), function(indexInArray, valueOfElement) {
                        let rid = $(this).data('rid');
                        updateUOM(rid);
                        updateCBMCarton(rid);
                        updateCBMIndv(rid);
                        $("#item_net_weight").trigger("change");
                    });
                });



                $(document).on('keyup', '#item_net_weight,#item_gross_weight', function() {
                    $.each($('.take-weight-uom'), function(indexInArray, valueOfElement) {
                        let rid = $(this).data('rid');
                        updateUOM(rid);
                    });
                });


                $(document).on('input', '.to_carton', function(e) {
                    let rid = $(this).data('rid');
                    rid = +rid + 1;
                    let nextinput = $("#from_carton[data-rid='" + rid + "']");
                    nextinput.val(+$(this).val() + 1);
                });

                $(document).on('input', '.from_carton', function(e) {
                    let rid = $(this).data('rid');
                    if (rid == 1) {
                        return;
                    }

                    rid = +rid - 1;
                    let previnput = $("#to_carton[data-rid='" + rid + "']").val();

                    if (previnput === $(this).val()) {
                        alert('Please Enter incremental Value');
                        $(this).val('');
                    }
                });

                $(document).on('input', ".from_carton,.to_carton,.carton_quantity", function(e) {
                    let rid = $(this).data('rid');
                    let from = $("#from_carton[data-rid='" + rid + "']").val();
                    let to = $("#to_carton[data-rid='" + rid + "']").val();

                    let carton_quantity = (to - from + 1);
                    $("#carton_quantity_box[data-rid='" + rid + "']").val(carton_quantity);


                    $(".update_num-carton[data-rid='" + rid + "']").html(carton_quantity);

                    let consign_qtyitem = $("#consign_qtyitem[data-rid='" + rid + "']");
                    let carton_piece_quantity = $("#carton_quantity[data-rid='" + rid + "']").val();

                    consign_qtyitem.val(carton_piece_quantity * carton_quantity);


                    updateTotal('carton_quantity_box', 'total_count-to', 1);
                    updateTotal('consign_qtyitem', 'total_count-qty_consignee');


                    updateUOM(rid);
                    updateCBMCarton(rid);
                    updateCBMIndv(rid);
                });


                $(document).on('input', '.take-width,.take-height,.take-lenuom,.take-length', function(e) {
                    let rid = $(this).data('rid');
                    updateUOM(rid);
                    updateCBMCarton(rid);
                });



                $(document).on('input', "#take-length", function(e) {
                    e.preventDefault();

                    $.each($("#take-length"), function(indexInArray, valueOfElement) {
                        let rid = $(this).data('rid');
                        updateCBMIndv(rid);
                    });

                });


                function updateCBMBatchcarton(rid) {
                    let carton_quantity = $("#carton_quantity_box[data-rid='" + rid + "']").val();
                    let consign_qty_carton = $("#consign_qty_carton[data-rid='" + rid + "']").val();
                    let result = carton_quantity * consign_qty_carton;

                    result = result.toFixed(4);

                    $("#consign_qty_master[data-rid='" + rid + "']").val(result);
                }


            }
        </script>
    @endsection


@endsection
