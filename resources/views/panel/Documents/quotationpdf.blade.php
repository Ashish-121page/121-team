@extends('backend.layouts.main')
@section('title', $pageTitle)
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <style>
            th {
                vertical-align: middle !important;
                text-align: center !important;
            }

            .header-top,
            .logged-in-as {
                display: none !important;
            }

            .main-content {
                margin-top: 0px !important;
            }

            a active {
                color: white !important;
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
        </style>
    @endpush

    <div class="container-fluid mt-5">

        <div class="position-absolute d-flex justify-content-between" style="right: 2%;width: 96%">
            <button onclick="goBack()" class="btn btn-secondary   d-print-none "> Back </button>

            <button onclick="window.print()" class="btn btn-primary  d-print-none "> Print </button>
        </div>


        <div class="mb-4">
            {{-- <h1 class="h3 mb-3 font-weight-normal">{{ $Userrecord->companyName ?? '' }}</h1> --}}
            <div class="d-flex justify-content-between align-items-center ">
                <h6>{{ $QuotationRecord->user_slug ?? ($QuotationRecord->slug ?? '') }}</h6>
                <div class="h3">{{ $type }}</div>
                <img src="{{ asset(getShopLogo($usershop->slug) ?? asset('frontend/assets/img/placeholder.png')) }}"
                    alt="company logo" class="img-thumbnail "
                    style="border-radius: 10px;height: 180px;width: auto;align-items: center;padding:2px;object-fit: contain;">

            </div>


            <hr>
            <p style="font-size: 0.85rem;">
                <b>Issue Date: </b> {{ $Userrecord->CreatedOn ?? '' }} <br>
                <b>Company Details: </b> {{ $Userrecord->companyName ?? '' }}
                {{-- @if ($QuotationRecord->additional_notes ?? '' != '')
              <br>
              <b>Remarks:</b> {{ $QuotationRecord->additional_notes ?? '' }}
            @endif --}}
            </p>
        </div>

        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">MODEL CODE</th>
                    <th scope="col">Description</th>
                    <th scope="col">Amount</th>
                </tr>
            </thead>
            <tbody>



                @foreach ($QuotationItemRecords as $QuotationItemRecord)
                    @php
                        $additional_notes = json_decode($QuotationItemRecord->additional_notes) ?? [];
                        $productInfo = App\Models\Product::where('id', $QuotationItemRecord->product_id)->first();
                    @endphp

                    <tr>
                        <td style="width: 250px;height: 250px;">
                            <img src="{{ asset(getShopProductImage($QuotationItemRecord->product_id)->path ?? asset('frontend/assets/img/placeholder.png')) }}"
                                alt="Accent Coffee Table" class="img-fluid rounded"
                                style="height: 100%;width: 100%; object-fit: contain" />
                        </td>
                        <td>
                            {{ $productInfo->model_code ?? '' }}
                        </td>
                        <td>
                            @php
                                $decriptionArray = ['ID', 'Image', 'Price', 'Currency', 'Model Code'];
                                $UserProperties = json_decode($user->custom_attriute_columns) ?? [];
                                $decriptionArray = array_merge($decriptionArray, $UserProperties);
                            @endphp

                            {{-- {{ magicstring($additional_notes); }} --}}
                            @forelse ($additional_notes as $key => $additional_note)
                                @if (!in_array($key, $decriptionArray))
                                    <p>
                                        {{ $key }}: {{ Str::limit($additional_note, 150, '...') }}
                                    </p>
                                @endif

                            @empty
                                <p>
                                    <b>Additional Notes:</b> No additional notes
                                </p>
                            @endforelse
                        </td>
                        <td>
                            {{ $QuotationItemRecord->currency ?? '' }}
                            {{ number_format($QuotationItemRecord->Price, 2) ?? '' }}
                            {{ $QuotationItemRecord->unit ?? '' }}
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>



        <div class="row justify-content-between ">
            @if ($charges_info->additional_notes ?? '' != '')
                <div class="col-6 col-md-4">
                    <div class="h5">Remarks: </div>
                    <p class="text-justify ">
                        {{ $charges_info->additional_notes ?? '' }}
                    </p>
                </div>
            @endif

            @if (count((array) $charges_info->taxes ?? []) > 0)
                <div class="col-6 col-md-6">
                    <div class="h5">Additional Charges</div>
                    <table class="table" style="width: max-content;">
                        {{-- <thead>
                            <tr>
                                <th>Charges: </th>
                                <th></th>
                            </tr>
                        </thead> --}}
                        <tbody>
                            @foreach ($charges_info->taxes as $item)
                                <tr class="text-center ">
                                    <td>
                                        {{ $item->tax_name ?? '' }}
                                    </td>
                                    <td>
                                        {{ $QuotationItemRecord->currency ?? '' }}
                                        {{ number_format($item->tax_amt, 2) ?? '' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>


    </div>

    <!-- push external js -->
    @push('script')
        <script>
            $(document).ready(function() {
                window.print();
            });


            function goBack() {
                window.history.back()
            }
        </script>
    @endpush


@endsection
