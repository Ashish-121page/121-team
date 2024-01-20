@extends('backend.layouts.main')
@section('title', 'Packing List')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
        <style>
            .text-success {
                color: #6666cc !important;
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
                                        <div class="form-control">
                                            <label for="item_gross_weight">Gross Weight</label>
                                            <input type="text" name="weight[gross]" id="item_gross_weight"
                                                class="form-control" placeholder="Product Length"
                                                value="{{ $shipping->gross_weight ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-control">
                                            <label for="item_net_weight">Net Weight</label>
                                            <input type="text" name="weight[net]" id="item_net_weight"
                                                class="form-control" placeholder="Product Width"
                                                value="{{ $shipping->weight ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-control">
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
                                        <div class="form-control">
                                            <label for="take-length">Product Length</label>
                                            <input type="text" name="product[length]" id="take-length"
                                                class="form-control" value="{{ $shipping->length ?? '' }}"
                                                placeholder="Product Length">
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4 col-sm-6 col-12 my-2">
                                        <div class="form-control">
                                            <label for="take-width">Product Width</label>
                                            <input type="text" name="product[width]" id="take-width" class="form-control"
                                                placeholder="Product Width" value="{{ $shipping->width ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-lg-4 col-sm-6 col-12 my-2">
                                        <div class="form-control">
                                            <label for="take-height">Product Height</label>
                                            <input type="text" name="product[height]" id="take-height"
                                                class="form-control" placeholder="Product Height"
                                                value="{{ $shipping->height ?? '' }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-lg-4 col-sm-6 col-12 my-2">
                                        <div class="form-control">
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



        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 my-3">
                                <div class="h6">Consignee Packing List</div>
                            </div>


                            {{-- ` This Will Repeat in LOOP --}}

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
                                        <input type="number" class="form-control to_carton" id="to_carton" data-rid="{{ $record->id }}">
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 d-ndone">
                                    <div class="form-group">
                                        <label for="carton_quantity_box" class="text-danger">Carton box qty</label>
                                        <input type="text" class="form-control carton_quantity_box" id="carton_quantity_box"  data-rid="{{ $record->id }}">
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="carton_quantity" class="text-success">Carton qty</label>
                                        <input type="text" class="form-control carton_quantity" id="carton_quantity"
                                            value="{{ $carton_details->standard_carton ?? '' }}"
                                            data-rid="{{ $record->id }}">
                                    </div>
                                </div>


                                <div class="col-md-4 col-lg-2 col-sm-6 col-12 ">
                                    <div class="form-group">
                                        <label for="consign_qtyitem" class="text-success">Qty - consignee </label>
                                        <input type="text" class="form-control" id="consign_qtyitem" data-rid="{{ $record->id }}" readonly value="To be computed">
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
                                        {{-- <input type="text" class="form-control take-lenuom" id="lenuom_packing"
                                            value="{{ $carton_details->Carton_Dimensions_unit ?? '' }}"
                                            data-rid="{{ $record->id }}"> --}}
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


                                {{-- New Part --}}
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

                                {{-- New Part --}}

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
        </div>


        {{-- For Total Computation --}}

        <div class="row">
            <div class="col-12">

            </div>
        </div>



    </div>


    @section('push-script')
        <script>
            // Section for Updating the Value on Load of DOM
            $(document).ready(function() {

                // console.log("%cYou Don't Have Permission to access this console!!", "color: red; background-color: yellow; font-size: x-large");


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

            function updateUOM(rid) {
                let item_gross_weight = $("#item_gross_weight").val();
                let item_new_weight = $("#item_net_weight").val();
                let item_unit_weight = $("#item_unit_weight").val();
                let carton_quantity = $("#carton_quantity[data-rid='" + rid + "']").val();

                gweight = convertToKilograms(item_gross_weight, item_unit_weight);
                nweight = convertToKilograms(item_new_weight, item_unit_weight);


                $("#gross_weight_packing[data-rid='" + rid + "']").val(gweight * carton_quantity);
                $("#net_weight_packing[data-rid='" + rid + "']").val(nweight * carton_quantity);
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
                $(".to_carton").on('input',function (e) {
                    let rid = $(this).data('rid');
                    rid = +rid + +1;
                    let nextinput = $("#from_carton[data-rid='" + rid + "']");
                    nextinput.val(+$(this).val() + 1);
                });



                $(".from_carton").on('input',function (e) {
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
                    updateUOM(rid);
                    updateCBMCarton(rid);
                    updateCBMIndv(rid);
                });

                $(".take-width,.take-height,.take-lenuom,.take-length").on('input', function(e) {
                    let rid = $(this).data('rid');
                    updateUOM(rid);
                    updateCBMCarton(rid);
                });



                $("#take-length").input(function (e) {
                    e.preventDefault();

                    $.each($("#take-length"), function (indexInArray, valueOfElement) {
                        let rid = $(this).data('rid');
                        updateCBMIndv(rid);
                    });



                });


            });
        </script>

    @endsection

@endsection
