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
                width: max-content !important;
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
                            class="img-fluid " style="height: 250px;width: 100%;object-fit: contain;" alt="">
                    </div>
                </div>
            </div>

            <div class="col-lg-10 col-12">
                {{-- for Data   --}}
                <div class="card">
                    <div class="card-head">
                        {{-- Keep Naviagtion --}}
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-12">
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

                                            <select name="weight[uom]" id="item_unit_weight" class="form-control select2">
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

                            <div class="col-12 my-3">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="h6">Product Dimensions</div>
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-sm-6 col-12 my-2">
                                        <div class="form-group">
                                            <label for="take-length">Product Length</label>
                                            <input type="text" name="product[length]" id="take-length"
                                                class="form-control" value="{{ $shipping->length ?? '' }}"
                                                placeholder="Product Length">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-sm-6 col-12 my-2">
                                        <div class="form-group">
                                            <label for="take-width">Product Width</label>
                                            <input type="text" name="product[width]" id="take-width" class="form-control"
                                                placeholder="Product Width" value="{{ $shipping->width ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-lg-4 col-sm-6 col-12 my-2">
                                        <div class="form-group">
                                            <label for="take-height">Product Height</label>
                                            <input type="text" name="product[height]" id="take-height"
                                                class="form-control" placeholder="Product Height"
                                                value="{{ $shipping->height ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-lg-4 col-sm-6 col-12 my-2">
                                        <div class="form-group">
                                            <label for="take-lenuom">LWH UOM</label>
                                            {{-- <input type="text" name="product[height]" id="take-lenuom"
                                                class="form-control" placeholder="Product Height"
                                                value="{{ $shipping->length_unit ?? '' }}"> --}}

                                            <select name="product[height]" id="take-lenuom" class="form-control select2">
                                                @foreach ($length_uom as $item)
                                                    <option value="{{ $item }}"
                                                        @if ((Str::lower($shipping->length_unit) ?? '') == $item) selected @endif>
                                                        {{ $item }}</option>
                                                @endforeach
                                            </select>


                                        </div>
                                    </div>

                                </div>




                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>



        {{-- <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 my-3">
                                <div class="h6">Consignee Packing List</div>
                            </div>

                            @forelse ($consignee_record as $record)
                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="from_carton">Consignee</label>
                                        <input type="text" class="form-control" id="consinee_name"
                                            value="{{ json_decode($record->consignee_details)->entity_name ?? '' }}"
                                            readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="from_carton" class="text-success">FROM</label>
                                        <input type="number" class="form-control from_carton" id="from_carton"
                                            data-rid="{{ $record->id }}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="to_carton" class="text-success">TO</label>
                                        <input type="number" class="form-control to_carton" id="to_carton"
                                            data-rid="{{ $record->id }}">
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 d-ndone">
                                    <div class="form-group">
                                        <label for="carton_quantity_box" class="text-danger">Carton box qty</label>
                                        <input type="text" class="form-control carton_quantity_box"
                                            id="carton_quantity_box" data-rid="{{ $record->id }}">
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="carton_quantity" class="text-success">Pcs in each Carton</label>
                                        <input type="text" class="form-control carton_quantity" id="carton_quantity"
                                            value="{{ $carton_details->standard_carton ?? '' }}"
                                            data-rid="{{ $record->id }}">
                                    </div>
                                </div>


                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="consign_qtyitem" class="text-success">Qty - consignee </label>
                                        <input type="text" class="form-control" id="consign_qtyitem"
                                            data-rid="{{ $record->id }}" readonly value="To be computed">
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="length_packing" class="text-success">L </label>
                                        <input type="text" class="form-control take-length" id="length_packing"
                                            value="{{ $carton_details->carton_length ?? 0 }}"
                                            data-rid="{{ $record->id }}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="width_packing" class="text-success">B</label>
                                        <input type="text" class="form-control take-width" id="width_packing"
                                            value="{{ $carton_details->carton_width ?? 0 }}"
                                            data-rid="{{ $record->id }}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="height_packing" class="text-success">H</label>
                                        <input type="text" class="form-control take-height" id="height_packing"
                                            value="{{ $carton_details->carton_height ?? 0 }}"
                                            data-rid="{{ $record->id }}">
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="lenuom_packing" class="text-success">UOM</label>
                                        <select class="form-control take-lenuom" id="lenuom_packing"
                                            data-rid="{{ $record->id }}">
                                            @foreach ($length_uom as $item)
                                                <option value="{{ $item }}"
                                                    @if ((Str::lower($carton_details->Carton_Dimensions_unit) ?? '') == $item) selected @endif>
                                                    {{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="gross_weight_packing" class="text-success">Total gross weight</label>
                                        <input type="text" class="form-control" id="gross_weight_packing" readonly
                                            value="To be computed" data-rid="{{ $record->id }}">
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="gross_unit_weight_packing" class="text-success ">UOM</label>
                                        <input type="text" class="form-control take-weight-uom"
                                            id="gross_unit_weight_packing" readonly value="To be computed"
                                            data-rid="{{ $record->id }}">
                                    </div>
                                </div>


                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="net_weight_packing" class="text-success">Total net weight</label>
                                        <input type="text" class="form-control" id="net_weight_packing" readonly
                                            value="To be computed" data-rid="{{ $record->id }}">
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="net_unit_weight_packing" class="text-success ">UOM</label>
                                        <input type="text" class="form-control take-weight-uom"
                                            id="net_unit_weight_packing" readonly value="To be computed"
                                            data-rid="{{ $record->id }}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="consign_qty" class="text-success ">CBM ( INDIV )</label>
                                        <input type="text" class="form-control" id="consign_qty_indiv" readonly
                                            value="To be computed" data-rid="{{ $record->id }}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="consign_qty" class="text-success ">CBM ( Indiv - Carton )</label>
                                        <input type="text" class="form-control" id="consign_qty_carton" readonly
                                            value="To be computed" data-rid="{{ $record->id }}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="consign_qty" class="text-success ">CBM ( Batch - Mastor Carton
                                            )</label>
                                        <input type="text" class="form-control" id="consign_qty_master" readonly
                                            value="To be computed" data-rid="{{ $record->id }}">
                                    </div>
                                </div>
                                <hr class="border border-primary border-2 opacity-50 w-100 my-3">
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-danger">No Consignee Found</div>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </div> --}}


        {{-- For Total Computation --}}

        <div class="row">
            <div class="col-12 table-responsive ">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" style="display: none">Consignee Id</th>
                            <th scope="col">Consignee</th>
                            <th scope="col">FROM</th>
                            <th scope="col">TO</th>
                            <th scope="col">Carton box qty</th>
                            <th scope="col">Carton qty</th>
                            <th scope="col">Qty - consignee</th>
                            <th scope="col">L</th>
                            <th scope="col">B</th>
                            <th scope="col">H</th>
                            <th scope="col">UOM</th>
                            <th scope="col">Total gross weight</th>
                            <th scope="col">UOM</th>
                            <th scope="col">Total net weight</th>
                            <th scope="col">UOM</th>
                            <th scope="col">CBM ( INDIV )</th>
                            <th scope="col">CBM ( Indiv - Carton )</th>
                            <th scope="col">CBM ( Batch - Mastor Carton )</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($consignee_record as $record)
                            <tr>
                                <td style="display: none">
                                    {{ $record->id }}
                                </td>
                                <td scope="row">
                                    <input type="text" class="form-control" id="consinee_name"
                                        value="{{ json_decode($record->consignee_details)->entity_name ?? '' }}" readonly>
                                </td>
                                <td>
                                    <input type="number" class="form-control from_carton" id="from_carton"
                                        data-rid="{{ $record->id }}">
                                </td>
                                <td>
                                    <input type="number" class="form-control to_carton" id="to_carton"
                                        data-rid="{{ $record->id }}">
                                </td>
                                <td>
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
                                        data-rid="{{ $record->id }}" readonly value="To be computed">
                                </td>
                                <td>
                                    <input type="text" class="form-control take-length" id="length_packing"
                                        value="{{ $carton_details->carton_length ?? 0 }}"
                                        data-rid="{{ $record->id }}">
                                </td>

                                <td>
                                    <input type="text" class="form-control take-width" id="width_packing"
                                        value="{{ $carton_details->carton_width ?? 0 }}" data-rid="{{ $record->id }}">
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
                                        id="gross_weight_packing" readonly value="To be computed"
                                        data-rid="{{ $record->id }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control take-weight-uom"
                                        id="gross_unit_weight_packing" readonly value="To be computed"
                                        data-rid="{{ $record->id }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control net_weight_packing" id="net_weight_packing"
                                        readonly value="To be computed" data-rid="{{ $record->id }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control take-weight-uom"
                                        id="net_unit_weight_packing" readonly value="To be computed"
                                        data-rid="{{ $record->id }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="consign_qty_indiv" readonly
                                        value="To be computed" data-rid="{{ $record->id }}">
                                </td>
                                <td>
                                    <input type="text" class="form-control consign_qty_carton" id="consign_qty_carton"
                                        readonly value="To be computed" data-rid="{{ $record->id }}">
                                </td>

                                <td>
                                    <input type="text" class="form-control" id="consign_qty_master" readonly
                                        value="To be computed" data-rid="{{ $record->id }}">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="18">
                                    <div class="alert alert-danger">No Consignee Found</div>
                                </td>
                            </tr>
                        @endforelse

                        <tr id="calc_total">
                            <td style="display: none"></td>
                            <td>
                                <button type="button" class="btn btn-outline-primary addcosign">Add+</button>
                                Total
                            </td>
                            <td></td>
                            <td>
                                <span id="total_count-to">TO</span>
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <span id="total_count-qty_consignee">Qty - consignee</span>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <span id="total_count-gross_weight">Total gross weight</span>
                            </td>
                            <td></td>
                            <td>
                                <span id="total_count-net_weight">Total net weight</span>
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <span id="total_count-cbn_ind">CBM ( INDIV )</span>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>



    </div>


    @section('push-script')
        <script>
            // Section for Updating the Value on Load of DOM
            $(document).ready(function() {

                // console.log("%cYou Don't Have Permission to access this console!!", "color: red; background-color: yellow; font-size: x-large");

                $(".addcosign").click(function (e) {
                    e.preventDefault();
                    appendTable();
                });

                // For Length
                $('#take-length').on('keyup', function() {
                    $('.take-length').val($(this).val());
                    $.each($('.take-lenuom'), function(indexInArray, valueOfElement) {
                        let rid = $(this).data('rid');
                        updateUOM(rid);
                        updateCBMIndv(rid);
                    });
                });

                // For Width
                $('#take-width').on('keyup', function() {
                    $('.take-width').val($(this).val());
                    $.each($('.take-lenuom'), function(indexInArray, valueOfElement) {
                        let rid = $(this).data('rid');
                        updateUOM(rid);
                        updateCBMIndv(rid);
                    });
                });

                // For Height
                $('#take-height').on('keyup', function() {
                    $('.take-height').val($(this).val());
                    $.each($('.take-lenuom'), function(indexInArray, valueOfElement) {
                        let rid = $(this).data('rid');
                        updateUOM(rid);
                        updateCBMIndv(rid);
                    });
                });

                // For Lenuom
                $('#take-lenuom').on('change', function() {
                    $('.take-lenuom').val($(this).val());
                    $.each($('.take-lenuom'), function(indexInArray, valueOfElement) {
                        let rid = $(this).data('rid');
                        updateUOM(rid);
                        updateCBMIndv(rid);
                    });
                });

                $('#item_unit_weight').on('change', function() {
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


                $('#item_net_weight,#item_gross_weight').on('keyup', function() {
                    $.each($('.take-weight-uom'), function(indexInArray, valueOfElement) {
                        let rid = $(this).data('rid');
                        updateUOM(rid);
                    });
                });

                // updateUOM(rid);

                // For Carton Quantity
                $("#item_unit_weight").trigger("change");
                $("#take-lenuom").trigger("change");
                $("#take-height").trigger("keyup");
                $("#take-length").trigger("keyup");
                $("#take-width").trigger("keyup");

            });

            function appendTable() {
                let rid = +$(".from_carton").last().data('rid') + +1;
                let takeuomtag = `<select class="form-control take-lenuom" id="lenuom_packing" data-rid="${rid}">
                                        @foreach ($length_uom as $item)
                                            <option value="{{ $item }}"
                                                @if ((Str::lower($carton_details->Carton_Dimensions_unit) ?? '') == $item) selected @endif>
                                                {{ $item }}</option>
                                        @endforeach
                                    </select>`;

                let consinee_data = `<select class="form-control take-lenuom append_element " id="lenuom_packing" data-rid="${rid}">
                                        @foreach ($consign_select as $key => $item)
                                            <option value="{{ $key }}" >
                                                {{ $item ?? '' }}</option>
                                        @endforeach
                                    </select>`;


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
                    <td>
                        <input type="text" class="form-control carton_quantity_box" id="carton_quantity_box"  data-rid="${rid}">
                    </td>
                    <td>
                        <input type="text" class="form-control carton_quantity" id="carton_quantity"  data-rid="${rid}">
                    </td>

                    <td>
                        <input type="text" class="form-control consign_qtyitem" id="consign_qtyitem" readonly value="To be computed"  data-rid="${rid}">
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
                            value="To be computed"  data-rid="${rid}">
                    </td>
                    <td>
                        <input type="text" class="form-control take-weight-uom" id="gross_unit_weight_packing" readonly
                            value="To be computed"  data-rid="${rid}">
                    </td>
                    <td>
                        <input type="text" class="form-control net_weight_packing" id="net_weight_packing" readonly
                            value="To be computed"  data-rid="${rid}">
                    </td>
                    <td>
                        <input type="text" class="form-control take-weight-uom" id="net_unit_weight_packing" readonly
                            value="To be computed"  data-rid="${rid}">
                    </td>
                    <td>
                        <input type="text" class="form-control" id="consign_qty_indiv" readonly value="To be computed"  data-rid="${rid}">
                    </td>
                    <td>
                        <input type="text" class="form-control consign_qty_carton" id="consign_qty_carton" readonly
                            value="To be computed"  data-rid="${rid}">
                    </td>

                    <td>
                        <input type="text" class="form-control" id="consign_qty_master" readonly value="To be computed">
                    </td>


                </tr>`;

                // $("tbody").prepend(data);
                $('table tr:last').before(data);

            }



            function updateTotal(update_id, getvalue_id, round = 4) {
                let to_carton = $("." + update_id);
                let to_carton_count = 0;
                $.each(to_carton, function(indexInArray, valueOfElement) {
                    to_carton_count += +$(this).val();
                });
                to_carton_count = to_carton_count.toFixed(round);
                $("#" + getvalue_id).html(to_carton_count);
            }



            function updateUOM(rid) {
                let item_gross_weight = $("#item_gross_weight").val();
                let item_new_weight = $("#item_net_weight").val();
                let item_unit_weight = $("#item_unit_weight").val();
                let carton_quantity = $("#carton_quantity[data-rid='" + rid + "']").val();

                gweight = convertToKilograms(item_gross_weight, item_unit_weight);
                nweight = convertToKilograms(item_new_weight, item_unit_weight);


                $("#gross_weight_packing[data-rid='" + rid + "']").val(gweight * carton_quantity);
                $("#net_weight_packing[data-rid='" + rid + "']").val(nweight * carton_quantity);



                updateTotal('net_weight_packing', 'total_count-net_weight');
                updateTotal('gross_weight_packing', 'total_count-gross_weight');

            }



            function updateCBMCarton(rid) {
                // Carton Detials
                let length_packing = $("#length_packing[data-rid='" + rid + "']").val();
                let width_packing = $("#width_packing[data-rid='" + rid + "']").val();
                let height_packing = $("#height_packing[data-rid='" + rid + "']").val();
                let lenuom_packing = $("#lenuom_packing[data-rid='" + rid + "']").val();

                clength_update = convertToCentimeters(length_packing, lenuom_packing);
                cwidth_update = convertToCentimeters(width_packing, lenuom_packing);
                cheight_update = convertToCentimeters(height_packing, lenuom_packing);

                ind_calc = ((clength_update / 100) * (cwidth_update / 100) * (cheight_update / 100));
                ind_calc = ind_calc.toFixed(4);
                $("#consign_qty_carton[data-rid='" + rid + "']").val(ind_calc);

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
            // For Updating the Value on Change Events of Input
            $(document).ready(function() {

                // Complute NExt To Value
                $(".to_carton").on('input', function(e) {
                    let rid = $(this).data('rid');
                    rid = +rid + +1;
                    let nextinput = $("#from_carton[data-rid='" + rid + "']");
                    nextinput.val(+$(this).val() + 1);
                });



                $(".from_carton").on('input', function(e) {
                    let rid = $(this).data('rid');
                    if (rid == 1) {
                        return;
                    }

                    rid = +rid - 1;
                    let previnput = $("#to_carton[data-rid='" + rid + "']").val();

                    if (previnput === $(this).val()) {
                        alert('Please Enter Different Value');
                        $(this).val('');
                        // $(this).val(previnput+1);
                    }
                });


                // Update Carton Quantity
                $(".from_carton,.to_carton,.carton_quantity").on('input', function(e) {
                    let rid = $(this).data('rid');
                    let from = $("#from_carton[data-rid='" + rid + "']").val();
                    let to = $("#to_carton[data-rid='" + rid + "']").val();

                    let carton_quantity = (to - from + 1);
                    $("#carton_quantity_box[data-rid='" + rid + "']").val(carton_quantity);

                    let consign_qtyitem = $("#consign_qtyitem[data-rid='" + rid + "']");
                    let carton_piece_quantity = $("#carton_quantity[data-rid='" + rid + "']").val();

                    consign_qtyitem.val(carton_piece_quantity * carton_quantity);


                    updateTotal('carton_quantity_box', 'total_count-to', 1);
                    updateTotal('consign_qtyitem', 'total_count-qty_consignee');


                    updateUOM(rid);
                    updateCBMCarton(rid);
                    updateCBMIndv(rid);
                });

                $(".take-width,.take-height,.take-lenuom,.take-length").on('input', function(e) {
                    let rid = $(this).data('rid');
                    updateUOM(rid);
                    updateCBMCarton(rid);
                });



                $("#take-length").input(function(e) {
                    e.preventDefault();

                    $.each($("#take-length"), function(indexInArray, valueOfElement) {
                        let rid = $(this).data('rid');
                        updateCBMIndv(rid);
                    });

                });


            });
        </script>

    @endsection

@endsection
