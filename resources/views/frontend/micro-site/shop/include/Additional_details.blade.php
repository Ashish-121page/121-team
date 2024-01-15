@php
    $productExtraInfo = App\Models\ProductExtraInfo::where('product_id', $product->id)->first();
@endphp
<div id="animatedModal">
    <div id="btn-close-modal" class="close-animatedModal custom-spacing" style="color:black">
        <i class="far fa-times-circle fa-rotate-270 fa-lg "></i>
    </div>
    <div class="modal-content custom-spacing" style="background-color:#f3f3f3">
        <div class="row">
            <div class="col-md-6 col-12 my-2">
                <div class="accordion" id="accordionInternalCollection">
                    {{-- <div class="col-3 d-flex align-items-center justify-content-center"> --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseInternalCollection" aria-expanded="false"
                                aria-controls="collapseInternalCollection">
                                Internal Collection Details
                            </button>
                        </h2>
                        <div id="collapseInternalCollection" class="accordion-collapse collapse show"
                            data-bs-parent="">
                            <div class="accordion-body">

                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table table-striped" style="width: 100%;">
                                                <tbody>
                                                    <tr>
                                                        <th>Allow Resellers</th>
                                                        <td>{{ $productExtraInfo->allow_resellers ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Live / Active</th>
                                                        <td>{{ ($product->is_publish == 1) ? "Yes" : "No"}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Copyright/ Exclusive item</th>
                                                        <td>{{ ($product->exclusive == 1) ? "Yes" : "No" }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Exclusive Buyer Name</th>
                                                        <td>{{ $productExtraInfo->exclusive_buyer_name ?? '--' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Theme / Collection Name</th>
                                                        <td>{{ $productExtraInfo->collection_name ?? '--' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Season / Month</th>
                                                        <td>{{ $productExtraInfo->season_month ?? '--' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Theme / Collection Year</th>
                                                        <td>{{ $productExtraInfo->season_year ?? '--' }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    {{-- </div> --}}
                </div>
            </div>
            <div class="col-md-6 col-12 my-2">
                <div class="accordion" id="accordionSample">
                    {{-- <div class="col-2 d-flex align-items-center "> --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSample" aria-expanded="false"
                                aria-controls="collapseSample">
                                Sample
                            </button>
                        </h2>
                        <div id="collapseSample" class="accordion-collapse collapse show" data-bs-parent="">
                            <div class="accordion-body">

                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th>Sample / Stock available</th>
                                                        <td>{{ ($product->manage_inventory == 1) ? "Yes" : "No" }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Sample Year</th>
                                                        <td>{{ ($product->manage_inventory == 1) ? "Yes" : "No" }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Sample Month</th>
                                                        <td>{{ $productExtraInfo->sample_month ?? '--' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Sampling time </th>
                                                        <td>{{ $productExtraInfo->sampling_time ?? '--' }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                    {{-- </div> --}}
                </div>
            </div>
            <div class="col-md-6 col-12 my-2">
                <div class="accordion" id="accordionProduction">
                    {{-- <div class="col-3 d-flex align-items-center"> --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseProduction" aria-expanded="false"
                                aria-controls="collapseProduction">
                                Production Details
                            </button>
                        </h2>
                        <div id="collapseProduction" class="accordion-collapse collapse show" data-bs-parent="">
                            <div class="accordion-body">

                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table table-striped" style="width: 100%;">
                                                <tbody>
                                                    <tr>
                                                        <th>CBM</th>
                                                        <td>{{ $productExtraInfo->CBM ?? '--' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Production time (days)</th>
                                                        <td>{{ $productExtraInfo->production_time ?? '--' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>MBQ</th>
                                                        <td>{{ $productExtraInfo->MBQ ?? '--' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>MBQ_units</th>
                                                        <td>{{ $productExtraInfo->MBQ_unit ?? '--' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Remarks</th>
                                                        <td>{{ $productExtraInfo->remarks ?? '--' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Vendor Sourced from</th>
                                                        <td>{{ $productExtraInfo->vendor_sourced_from ?? '--' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Vendor price</th>
                                                        <td>{{ $productExtraInfo->vendor_price ?? '--' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Product Cost_Unit</th>
                                                        <td>{{ $productExtraInfo->product_cost_unit ?? '--' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Vendor currency</th>
                                                        <td>{{ $productExtraInfo->vendor_currency ?? '--' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Sourcing Year</th>
                                                        <td>{{ $productExtraInfo->sourcing_year ?? '--' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Sourcing month</th>
                                                        <td>{{ $productExtraInfo->sourcing_month ?? '--' }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                    {{-- </div> --}}
                </div>
            </div>
            <div class="col-md-6 col-12 my-2">
                <div class="accordion" id="accordionProduction">
                    {{-- <div class="col-3 d-flex align-items-center"> --}}
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseColumns" aria-expanded="false"
                                aria-controls="collapseColumns">
                                Custom Columns
                            </button>
                        </h2>
                        <div id="collapseColumns" class="accordion-collapse collapse show" data-bs-parent="">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Column Name</th>
                                                    <th>Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($custom_columns as $item)
                                                    <tr>
                                                        <td>
                                                            {{ getFieldNameById($user_shop->user_id,$item->relatation_name) }}
                                                        </td>
                                                        <td>
                                                            @if (is_base64_encoded($item->value))
                                                                @if (json_decode(base64_decode($item->value)) != null)
                                                                    @foreach (json_decode(base64_decode($item->value)) as $key => $item)
                                                                        {{ $key.":".$item }}
                                                                    @endforeach
                                                                @endif
                                                            @else
                                                                {{$item->value}}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

