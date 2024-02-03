@extends('backend.layouts.main')
@section('title', 'packinglistpdf')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <style>
            a active {

                color: white !important;
                /* background-color: #6666a3; */
                border-radius: 5%;
                position: relative;
                opacity: 86%
            }

            a active span {
                font-size: 16px;
            }


            a active::before {
                content: '';
                background-color: #8484f8;
                height: 3px;
                width: 120%;
                position: absolute;
                bottom: -7px;
                left: -4px;
            }

            @media print {

                .noprint,
                .logged-in-as,
                .header-top {
                    display: none !important;
                }

                .main-content {
                    margin-top: -40px !important;
                }
            }
        </style>
    @endpush


    <div class="mt-5" style="margin-bottom:3rem;">
        <button onclick="getPDF();" class="btn btn-outline-primary noprint" type="button"
            style="position: absolute; right: 5rem;"><i class="fa fa-download"></i>Save PDF
            {{-- <button onclick="window.print()" class="btn btn-primary position-absolute d-print-none " style="right: 2%"> Print </button> --}}
    </div>
    <div class="container-fluid mt-5">

        <table class="table table-bordered table-thick mt-5" style="border-style:double; border:1px;">
            <tbody>
                <tr style="border:none;">
                    <td colspan="6" style="text-align: center; font-weight: bold; border:none;">PACKING LIST</td>
                    <td colspan="2" style="text-align: center; font-weight: italic; border:none;">Original for recipient
                    </td>
                </tr>
                <!-- first row -->
                <tr>
                    <td colspan="1" style="width: 150px;">
                        <div>
                            <img src="{{ asset(getShopLogo($usershop->slug) ?? asset('frontend/assets/img/placeholder.png')) }}"
                                alt="Logo" style="height: 100%;width: 100%;object-fit: contain">
                        </div>
                    </td>
                    <td colspan="2">
                        <label for="remark" class="control-label mb-2" style="font-weight: bold;">Entity Name</label>
                        <input type="text" class="form-control" value="{{ $entity_details->entity_name ?? '' }}"
                            readonly>
                    </td>

                    <td colspan="1" rowspan="" style="font-weight: bold;">
                        <div>
                            <label for="invoice_num">Invoice No.</label>
                            <input type="text" id="invoice_num" class="form-control" value="{{ $invoice_num ?? '' }}"
                                readonly>
                        </div>

                    </td>
                    <td colspan="2" style="font-weight: bold;">
                        <div>
                            <label for="date">Dated</label>
                            {{-- <br> --}}
                            <span>
                                {{ $quotation->quotation_date ?? '' }}
                            </span>
                        </div>
                    </td>
                    <td colspan="1" style="font-weight: bold;" class="text-danger ">Buyer Order No.
                        {{-- <div>
                                <label for="invoice_num">Invoice No.</label>
                                <input type="text" id="invoice_num" class="form-control"  value="{{ ($invoice_deets) ?? '' }}" >
                            </div> --}}
                    </td>
                    <td colspan="1" style="font-weight: bold;">
                        <div>
                            <label for="delivery_date"  class="text-danger ">Dated</label>
                            <input type="text" id="delivery_date" class="form-control"
                                value="{{ $additional_details->delivery_date ?? '' }}"readonly>
                        </div>
                    </td>
                </tr>
                <!-- gst row start -->
                <tr>
                    <td colspan="3">
                        <div>
                            <label for="GSTIN No">GSTIN No : <span>{{ $entity_details->gst_number ?? '' }}</span></label>
                        </div>

                        <div>
                            <label for="IEC No">IEC No. : <span>{{ $entity_details->iec_number ?? '' }}</span></label>
                        </div>
                    </td>
                    <td colspan="5" rowspan="" style="font-weight: bold;">
                        <div>
                            <label for="ref">Other Ref #</label>
                            <textarea id="remarks1" class="form-control" readonly>{{ $charges_info->additional_notes ?? '' }}</textarea>
                            {{-- <textarea name="" id="" cols="" rows="10"></textarea> --}}
                        </div>
                    </td>
                </tr>


                <!-- gst row end -->
                <!-- buyer details -->
                <tr colspan="8">
                    <td colspan="3">
                        <div>
                            <label for="Buyer" readonly>
                                Buyer: <span> {{ $buyer_details->entity_name ?? '' }} </span>
                            </label>
                        </div>
                        <div>
                            {{-- <label for="entityName">Entity Name:</label> --}}
                            {{-- <input type="text" id="buyerentityName" class="form-control"  value="{{ $buyer_details->entity_name ?? '' }}" > --}}
                            {{-- {{ ($buyer_details->entity_name) ?? 'not working' }} --}}
                        </div>
                        <div>
                            {{-- {{ ($buyer_details->address1) ?? 'address1' }} --}}
                            {{-- <label for="address1">Address 1:</label> --}}
                            {{-- <input type="text" id="address1" class="form-control" value="{{ ($buyer_details->address1) ?? 'address1' }}" > --}}
                        </div>
                        <div>
                            {{-- {{ ($buyer_details->address2) ?? 'address2' }} --}}
                            {{-- <label for="address2">Address 2:</label> --}}
                            {{-- <input type="text" id="address2" class="form-control" value="{{ ($buyer_details->address2) ?? 'address2' }}" > --}}
                        </div>
                        <div>
                            <div style="display: flex;">
                                <div style="width: 50%;">
                                    {{-- {{ ($buyer_details->city) ?? 'city' }} --}}
                                    {{-- <label for="city">City:</label> --}}
                                    {{-- <input type="text" id="city" class="form-control" value="{{ ($buyer_details->city) ?? 'city' }}" > --}}
                                </div>
                                <div style="width: 50%;">
                                    {{-- {{ ($buyer_details->pincode) ?? 'pincode' }} --}}
                                    {{-- <label for="pincode">Pincode:</label> --}}
                                    {{-- <input type="text" id="pincode" class="form-control" value="{{ ($buyer_details->pincode) ?? 'pincode' }}" > --}}
                                </div>
                            </div>
                        </div>
                        <div style=" display: flex; align-items: center;">
                            <label for="country" style="display: inline-block; width: 120px; margin-right: 10px;"
                                class="text-danger ">GSTIN No.:</label>
                            <input type="text" id="country" class="form-control" value="{{ 'GST Number' }}"
                                style="display: inline-block;">
                        </div>
                    </td>
                    <td colspan="5" style="font-weight: bold;">
                        <div>
                            <label for="remarks1" >Remarks / Terms of Service</label>
                            <textarea id="remarks1" class="form-control" readonly>{{ 'Other remarks' }}</textarea>
                        </div>
                    </td>
                </tr>
                <!-- consignee details -->
                @if (request()->has('consingee'))
                    <tr>
                        <td colspan="3">
                            <div>
                                <label for="consignee">Consignee:</label>
                            </div>
                            <div>
                                {{-- <label for="entityName">Entity Name:</label> --}}
                                {{ $Consignee1->entity_name ?? '' }}
                            </div>
                            <div>
                                {{-- <label for="address1">Address 1:</label> --}}
                                {{ $Consignee1->address1 ?? 'address1' }}
                            </div>
                            <div>
                                {{-- <label for="address2">Address 2:</label> --}}
                                {{ $Consignee1->address2 ?? 'address2' }}
                            </div>
                            <div>
                                <div style="display: flex;">
                                    <div style="width: 50%;">
                                        {{-- <label for="city">City:</label> --}}
                                        {{ $Consignee1->city ?? 'city' }}
                                    </div>
                                    <div style="width: 50%;">
                                        {{-- <label for="pincode">Pincode:</label> --}}
                                        {{ $Consignee1->pincode ?? 'pincode' }}
                                    </div>
                                </div>
                            </div>
                            <div style=" display: flex; align-items: center;">
                                <label for="country" style="display: inline-block; width: 120px; margin-right: 10px;"
                                    class="text-danger '">GSTIN No.:</label>
                                <input type="text" id="country" class="form-control" value="{{ 'GST Number' }}"
                                    style="display: inline-block;">
                            </div>

                        </td>
                        <td colspan="5" style="font-weight: bold;"  class="text-danger ">
                            Remarks / Terms of Service
                            <!-- Your content goes here -->
                        </td>

                    </tr>
                @endif
                <!-- bank and other details -->
                <tr>
                    <td colspan="3" rowspan="">
                        @if (isset($bank_details[0]))
                            <span>Bank</span> <br>
                            <span>Name: {{ $bank_details[0]->bank_name ?? '' }}</span> <br>
                            <span>Account Number : {{ $bank_details[0]->account_number ?? '' }}</span> <br>
                            <span>IFSC: {{ $bank_details[0]->ifsc_code_neft ?? '' }}</span> <br>
                            <span>Swift Code: {{ $bank_details[0]->swift_code ?? '' }}</span> <br>
                            <span>Account Holder Name: {{ $bank_details[0]->account_holder_name ?? '' }} </span> <br>
                        @else
                            <span>Bank details not available</span>
                        @endif


                        <!-- Your content goes here -->
                    </td>
                    <td colspan="5" rowspan="" style="font-weight: bold;">
                        <div>
                            <label for="payment_terms"> Payment terms</label>
                            <input type="text" id="payment_terms" class="form-control"
                                value="{{ $shipment_info->payment_terms ?? 'enter payment terms' }}">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" rowspan="">

                        <!--  -->
                    </td>
                    <td colspan="1" rowspan="">

                        <div>
                            <label for="Country_of_origin">Country of origin</label>
                            <input type="text" id="Country_of_origin" class="form-control" readonly
                                value="{{ json_decode($quotationitems->first()->additional_notes)->COO ?? '' }}">
                        </div>
                    </td>
                    <td colspan="2" rowspan="">

                        <!-- Your content goes here -->
                    </td>
                    <td colspan="2" rowspan="" class="text-danger ">
                        Country of destination
                        <!-- Your content goes here -->
                    </td>

                </tr>
                </tr>
                <!-- precarriage deets -->
                <tr>
                    <td colspan="1" class="text-danger " style="font-weight: bold;">
                        Pre-carriage By

                        <!-- Your content goes here -->
                    </td>
                    <td colspan="1" style="font-weight: bold;" class="text-danger ">
                        Receipt of Pre-carrier

                        <!-- Your content goes here -->
                    </td>
                    <td colspan="1" style="font-weight: bold;" class="text-danger ">
                        Vessel/ Flight No.

                        <!-- Your content goes here -->
                    </td>
                    <td colspan="1" style="font-weight: bold;">
                        <div>
                            <label for="port_of_loading">Ports of loading</label>
                            <input type="text" id="port_of_loading" class="form-control"
                                value="{{ $additional_details->port_of_loading ?? 'enter Ports of loading' }}" readonly>
                        </div>
                    </td>
                    <td colspan="2" style="font-weight: bold;">
                        <div>
                            <label for="port_of_discharge">Port of discharge</label>
                            <input type="text" id="port_of_discharge" class="form-control"
                                value="{{ $additional_details->port_of_discharge ?? 'enter Port of discharge' }}"
                                readonly>
                        </div>
                    </td>
                    <td colspan="2" style="font-weight: bold;">

                        <div>
                            <label for="Final Destination" class="text-danger ">Final Destination</label>
                            <input type="text" id="Final Destination" class="form-control"
                                value="{{ ' enter Final Destination' }}">
                        </div>
                    </td>


                </tr>
                <tr>
                    <td colspan="1" rowspan="" style="font-weight: bold; background-color: yellow">
                        Mark
                    </td>
                    <td colspan="1" rowspan="" style="font-weight: bold; background-color: yellow"
                        class="text-danger ">
                        Nos
                    </td>
                    <td colspan="1" rowspan="" style="font-weight: bold;">
                        Item
                        <!-- Your content goes here -->
                    </td>
                    <td colspan="1" rowspan="" style="font-weight: bold;">
                        Description
                        <!-- Your content goes here -->
                    </td>
                    <td colspan="1" rowspan="" style="font-weight: bold; background-color: yellow ">
                        Total Qty ( pcs)
                        <!-- Your content goes here -->
                    </td>
                    <td colspan="1" rowspan="" style="font-weight: bold; background-color:  yellow">
                        Net Wt (kgs)
                        <!-- Your content goes here -->
                    </td>
                    <td colspan="1" rowspan="" style="font-weight: bold; background-color: yellow ">
                        Gross wt (kgs)
                        <!-- Your content goes here -->
                    </td>
                    <td colspan="1" rowspan="" style="font-weight: bold; background-color: yellow ">
                        CBM
                        <!-- Your content goes here -->
                    </td>

                </tr>
                <!-- data example row1 -->
                @php
                    $sum_quantity = 0;
                    $sum_net_weight = 0;
                    $sum_gross_weight = 0;
                    $sum_cbm = 0;
                @endphp
                @foreach ($quotationitems as $quotationitem)
                    @php

                        $packing_list_quote = json_decode($quotationitem->packing_list) ?? [];
                        $quotationItem = json_decode($quotationitem);
                        $Products_quote = App\Models\Product::whereId($quotationItem->product_id)->first();
                        $Products_quote_shipping = json_decode($Products_quote->shipping) ?? '';
                        $pcarton_details = json_decode($Products_quote->carton_details) ?? '';
                        $quote_prod = json_decode($Products_quote);
                        $qadditional_notes = json_decode($quotationItem->additional_notes);
                    @endphp
                    <tr>
                        <td colspan="1">
                            {{-- {{ $quotationItem->product_id }} - mark --}}
                            @foreach ($packing_list_quote->packing_record ?? [] as $packing_record)
                                @if ($packing_record->consignee_id == ($consignee_details->id ?? ''))
                                    <div>
                                        {{ $packing_record->consignment_from ?? '' }} --
                                        {{ $packing_record->consignment_to ?? '' }}
                                    </div>
                                @endif
                            @endforeach
                        </td>
                        <td colspan="1">
                            00
                        </td>
                        <td colspan="1">
                            {{ $quote_prod->model_code }}

                        </td>
                        <td colspan="1" rowspan="">
                            <div>
                                {{ $quote_prod->title }}
                            </div>

                            <div>
                                <label for="item_size">Item Size:</label>
                            </div>

                            <div>
                                <label for="carton_size">Carton Size:</label>
                            </div>

                        </td>
                        <td colspan="1" rowspan="">
                            @php
                                $sum_quantity += $qadditional_notes->Quantity ?? '0';
                            @endphp
                            {{ $qadditional_notes->Quantity ?? '0' }}
                        </td>
                        <td colspan="1" rowspan="">
                            @php
                                $sum_net_weight += convertToKilograms($Products_quote_shipping->weight, $Products_quote_shipping->unit) ?? '0';
                            @endphp
                            {{ convertToKilograms($Products_quote_shipping->weight, $Products_quote_shipping->unit) ?? '0' }}
                        </td>
                        <td colspan="1" rowspan="">
                            @php
                                $sum_gross_weight += convertToKilograms($Products_quote_shipping->gross_weight, $Products_quote_shipping->unit) ?? '0';
                            @endphp
                            {{ convertToKilograms($Products_quote_shipping->gross_weight, $Products_quote_shipping->unit) ?? '0' }}
                        </td>
                        <td colspan="1" rowspan="">
                            @php
                                $cbm = calculateCBM($Products_quote_shipping->length, $Products_quote_shipping->width, $Products_quote_shipping->height, $Products_quote_shipping->length_unit) ?? '0';
                                $sum_cbm += $cbm;
                            @endphp
                            {{ $cbm }}
                        </td>

                    </tr>


                    <!-- blank row before total -->
                @endforeach

                <tr>
                    <td colspan="1">


                    </td>
                    <td colspan="2" rowspan="">


                    </td>
                    <td colspan="1" rowspan="">


                    </td>
                    <td colspan="1" rowspan="">

                    </td>
                    <td colspan="1" rowspan="">

                    </td>
                    <td colspan="1" rowspan="">


                    </td>
                    <td colspan="1" rowspan="">


                    </td>
                </tr>
                <!-- row for total -->
                <tr>
                    <td colspan="4" style="text-align: center; font-weight: bold;">Total</td>
                    <td colspan="1" style="font-weight: bold;">{{ $sum_quantity }}</td>
                    <td colspan="1" style="font-weight: bold;">{{ round($sum_net_weight, 4) }}</td>
                    <td colspan="1" style="font-weight: bold;">{{ round($sum_gross_weight, 4) }} </td>
                    <td colspan="1" style="font-weight: bold;">{{ round($sum_cbm, 4) }}</td>
                </tr>
                <!-- Signatory -->
                <tr>
                    <td colspan="8">
                        <div class="row mt-4">
                            <div class="col text-end">
                                <div class="d-flex justify-content-end" style="margin-right: 1rem;">
                                    <h4>For {{ $entity_details->entity_name ?? '' }} </h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-end">
                                <div class="d-flex justify-content-end" style="margin-right: 1rem;">
                                    <h6>(Authorized Signatory)</h6>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>






    <!-- {{-- <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script src="{{ asset('backend/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}} -->

    <!-- push external js -->
    @push('script')
        <script>
            document.addEventListener("keydown", function(event) {
                // Alt + P to  print PDF Shortcut Key
                if (event.which == 80 && event.altKey == true) {
                    getPDF()
                }
            })

            function getPDF(){
                window.print()
            }


        </script>
    @endpush

@endsection
