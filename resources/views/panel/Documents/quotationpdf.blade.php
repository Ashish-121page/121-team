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
            .header-top , .logged-in-as {
                display: none !important;
            }

            .main-content{
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

        <button onclick="window.print()" class="btn btn-primary position-absolute d-print-none " style="right: 2%"> Print </button>

        <div class="mb-4">
            <h1 class="h3 mb-3 font-weight-normal">{{ $Userrecord->buyerName ?? '' }}</h1>
            <h6>{{ $QuotationRecord->user_slug ?? ($QuotationRecord->slug ?? '') }}</h6>
            <hr>
            <p style="font-size: 0.85rem;">
                <b>Issue Date:</b> {{ $Userrecord->CreatedOn ?? '' }} <br>
                <b>Company Details:</b> {{ $Userrecord->companyName ?? '' }}
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
                        <td style="width: 350px">
                            <img src="{{ asset(getShopProductImage($QuotationItemRecord->product_id)->path ?? asset('frontend/assets/img/placeholder.png')) }}"
                                alt="Accent Coffee Table" class="img-fluid rounded"
                                style="height: 100%;width: 100%; object-fit: contain" />
                        </td>
                        <td>
                            {{ $productInfo->model_code ?? '' }}
                        </td>
                        <td>
                            @php
                                $decriptionArray = ['Title', 'COO'];
                                $UserProperties = json_decode($user->custom_attriute_columns) ?? [];
                                $decriptionArray = array_merge($decriptionArray, $UserProperties);
                            @endphp
                            {{-- {{ magicstring($decriptionArray); }} --}}

                            {{-- {{ magicstring($additional_notes); }} --}}
                            @forelse ($additional_notes as $key => $additional_note)
                                @if (in_array($key, $decriptionArray))
                                    <p>
                                        <b>{{ $key }}:</b> {{ $additional_note }}
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
                            {{ $QuotationItemRecord->Price ?? '' }}
                            {{ $QuotationItemRecord->unit ?? '' }}
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- push external js -->
    @push('script')
        <script>
            $(document).ready(function () {
                window.print();
            });
        </script>
    @endpush


@endsection
