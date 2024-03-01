@extends('backend.layouts.main')

@section('title', 'Asset Link')

<!-- push external head elements to head -->
@push('head')
    <link rel="stylesheet" href="{{ asset('backend\plugins\owl.carousel\dist\assets\owl.carousel.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        .owl-carousel .owl-item {
            height: 150px;
            width: 150px;
        }

        .owl-carousel .owl-item img {
            border-radius: 10px;
            width: 100%;
            height: 60%;
            object-fit: contain;

        }

        .owl-next {
            position: absolute;
            top: 50%;
            right: -2%;
            transform: translateY(-50%);
            font-size: 3.5rem !important;
            color: var(--primary) !important;
        }

        .owl-prev {
            position: absolute;
            top: 50%;
            left: -2%;
            transform: translateY(-50%);
            font-size: 3.5rem !important;
            color: var(--primary) !important;
        }

        .swiper {
            width: 95%;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            display: flex;
            flex-direction: column;
            width: min-content !important;
            margin: 10px;
            height: min-content !important;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@endpush
@section('content')

    <div class="container-fluid ">
        <div class="orange mt-5 text-center"
            style="display: flex;margin: 20px auto;width: 100%;align-items: center;justify-content: center;">
            <div class=" btn active done custom_active_add-0" data-step="0">
                1. Upload
            </div>
            <div class=" btn editable custom_active_add-1">
                2. Review
            </div>
            <div class=" btn editable custom_active_add-2 text-primary " id="pills-profile2-tab">
                3. Finish
            </div>
        </div>


        <div class="row d-flex justify-content-between mb-3">
            <div class="h6 col-12 col-md-3 my-2">Vault: #
                <strong>
                    <span> {{ $vault_name ?? '_____' }} </span>
                </strong>
            </div>
            <div class="h6 col-12 col-md-6 my-2 ">
                File name is Model Code
            </div>
            <div class="col-12 col-md-3 my-2">
                <div class="h6">Uploaded: #<span>{{ count($File_data) }}</span> assets</div>
            </div>
        </div>
        <div class="">

            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button btn btn-outline-primary row" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                            aria-controls="collapseOne" style="height: auto;margin: 10px">
                            <span class="col-12 col-md-5 d-flex justify-content-start ">
                                Linked to Existing product on 121
                            </span>
                            <span class="col-12 col-md-5 d-flex justify-content-md-end justify-content-start   ">
                                (Products: {{ count($available_skus) ?? 0 }}, Asset: <span id="assetcount_avl">0</span> )
                            </span>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                @foreach ($available_skus as $key => $available_sku)
                                    <div class="col-12 mb-3">
                                        {{-- <div class="h6">{{ $available_sku ?? '' }}: Model Code linked to existing sku: </div> --}}
                                        <div class="h6">
                                            Model Code: {{ $available_sku ?? '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="owl-carousel owl-theme">
                                            @foreach ($File_data as $i => $files)
                                                @php
                                                    $sku = pathinfo($files->FileName, PATHINFO_FILENAME);
                                                    $sku = trim($sku);
                                                @endphp
                                                @if (!in_array($sku, $all_products_modelCodes))
                                                    @continue
                                                @endif
                                                @if ($available_sku != $sku)
                                                    @continue
                                                @endif
                                                <div class="item text-center ">
                                                    <img src="{{ $files->FilePath ?? '' }}"
                                                        alt="{{ $files->FileName ?? '' }}" class="img-fluid mb-1">
                                                    <span>
                                                        {{ Str::limit($files->FileName, 15, '...') ?? '----' }}
                                                    </span>
                                                </div>
                                                @php
                                                    $form_available_sku[] = $available_sku;
                                                    $form_available_sku_files[] = $files;
                                                @endphp
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button btn btn-outline-primary row collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                            aria-controls="collapseTwo" style="height: auto;margin: 10px">
                            <span class="col-12 col-md-5 d-flex justify-content-start ">
                                New product to create on 121
                            </span>
                            <span class="col-12 col-md-5 d-flex justify-content-md-end justify-content-start   ">
                                (Products: {{ count($Notavailable_skus) ?? 0 }}, Asset: <span
                                    id="assetcount_notavl">0</span> )
                            </span>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                @forelse ($Notavailable_skus as $Notavailable_sku)
                                    <div class="col-12 mb-3">
                                        <div class="h6">
                                            Model Code : {{ $Notavailable_sku }}
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="swiper">
                                            <!-- Additional required wrapper -->
                                            <div class="swiper-wrapper">
                                                <!-- Slides -->
                                                @foreach ($File_data as $i => $files)
                                                    @php
                                                        // $sku = explode($delimiter, pathinfo($files->FileName, PATHINFO_FILENAME))[$delimeter_directiom] ?? '';
                                                        // $sku = trim($sku);
                                                        $sku = pathinfo($files->FileName, PATHINFO_FILENAME);
                                                        $sku = trim($sku);
                                                    @endphp
                                                    @if ($Notavailable_sku != $sku)
                                                        @continue
                                                    @endif
                                                    <div class="swiper-slide text-center ">
                                                        <img src="{{ $files->FilePath ?? '' }}"
                                                            alt="{{ $files->FileName ?? '' }}" class="img-fluid mb-1">
                                                        <span>
                                                            {{-- {{ $files->FileName ?? '----' }} --}}
                                                            {{ Str::limit($files->FileName, 15, '...') ?? '----' }}
                                                        </span>
                                                    </div>
                                                    @php
                                                        $form_not_available_sku[] = $Notavailable_sku;
                                                        $form_not_available_sku_files[] = $files;
                                                    @endphp
                                                @endforeach
                                            </div>
                                            {{-- <div class="swiper-pagination"></div> --}}
                                            {{-- <div class="swiper-scrollbar"></div> --}}
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-center">
                                        <div class="h5">No New SKU Found</div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button btn btn-outline-primary row collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                            aria-controls="collapseThree" style="height: auto;margin: 10px">
                            <span class="col-12 col-md-5 d-flex justify-content-start ">
                                Ignored Due to Invalid Files Names
                            </span>
                            <span class="col-12 col-md-5 d-flex justify-content-md-end justify-content-start   ">
                                (Products: {{ 0 }}, Asset: {{ count($Invalid_files) }})
                            </span>
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-12 mb-3">

                                    <div class="swiper">
                                        <!-- Additional required wrapper -->
                                        <div class="swiper-wrapper">
                                            <!-- Slides -->
                                            @forelse ($Invalid_files as $Notavailable_sku)
                                                <div class="swiper-slide text-center ">
                                                    <img src="{{ asset('storage/files/214/vaults/' . $Notavailable_sku) }}"
                                                        alt="{{ $Notavailable_sku ?? '' }}" class="img-fluid mb-1">
                                                    <span>
                                                        {{ $Notavailable_sku ?? '----' }}
                                                    </span>
                                                </div>
                                            @empty
                                                <div class="col-12 text-center">
                                                    <div class="h5">No New SKU Found</div>
                                                </div>
                                            @endforelse
                                        </div>
                                        <div class="swiper-pagination2"></div>
                                        <div class="swiper-scrollbar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button btn btn-outline-primary row collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false"
                            aria-controls="collapseFour" style="height: auto;margin: 10px">
                            <span class="col-12 col-md-5 d-flex justify-content-start ">
                                Ignored Due to Duplicates on 121
                            </span>
                            <span class="col-12 col-md-5 d-flex justify-content-md-end justify-content-start   ">
                                (Products: {{ 0 }}, Asset: {{ count($ignored_files) }})
                            </span>
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-12 mb-3">

                                    <div class="owl-carousel slider2 owl-theme">
                                        @foreach ($File_data as $i => $files)
                                            @php
                                                $sku = explode($delimiter, pathinfo($files->FileName, PATHINFO_FILENAME))[$delimeter_directiom] ?? '';
                                                $sku = trim($sku);
                                            @endphp
                                            @if (!in_array($sku, $all_products_modelCodes))
                                                @continue
                                            @endif
                                            <div class="item text-center ">
                                                <img src="{{ $files->FilePath ?? '' }}"
                                                    alt="{{ $files->FileName ?? '' }}" class="img-fluid mb-1">
                                                <span>
                                                    {{-- {{ $files->FileName ?? '----' }} --}}
                                                    {{ Str::limit($files->FileName, 15, '...') ?? '----' }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="col-12 mb-3 d-flex justify-content-center">

                @if ($workingType == 'filename_model_code')
                    <form action="{{ route('panel.asset-link.model.filename') }}" method="POST">
                    @else
                        <form action="{{ route('panel.asset-link.irrelevant.filename') }}" method="POST">
                @endif

                <input type="hidden" id="fileData" name="fileData" value="{{ $Request_fileData ?? [] }}">

                <input type="hidden" name="form_not_available_sku" id="form_not_available_sku"
                    value="{{ json_encode($form_not_available_sku ?? []) }}">
                <input type="hidden" name="vault_name" value="{{ $vault_name }}">
                <input type="hidden" name="form_not_available_sku_files"
                    value="{{ json_encode($form_not_available_sku_files ?? [], true) }}">
                <input type="hidden" name="form_available_sku" id="form_available_sku_val"
                    value="{{ json_encode($form_available_sku ?? []) }}">
                <input type="hidden" name="form_available_sku_files"
                    value="{{ json_encode($form_available_sku_files ?? []) }}">
                <input type="hidden" name="delimeter" value="{{ $delimiter }}">
                <input type="hidden" name="delimeter_directiom" value="{{ $delimeter_directiom }}">

                <button class="btn mx-2 btn-outline-primary" type="submit" name="fill_later">Finish</button>
                {{-- <button class="btn mx-2 btn-primary" type="submit" name="fill_now">Fill Details</button> --}}
                </form>
            </div>

        </div>
    </div>


@endsection

<!-- push external js -->

@push('script')
    <script src="{{ asset('backend/plugins/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script>
        $(document).ready(function() {


            var swiper = new Swiper(".swiper", {
                slidesPerView: "auto",
                spaceBetween: 30,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
            });

            var length = $("#form_not_available_sku").val().split(',').length;
            if ($("#form_not_available_sku").val().split(',')[0] === '[]') {
                length = 0;
            }
            $('#assetcount_notavl').text(length);
            var lengt2 = $("#form_available_sku_val").val().split(',').length;
            if ($("#form_available_sku_val").val().split(',')[0] === '[]') {
                lengt2 = 0;
            }
            $('#assetcount_avl').text(lengt2);

        });


        $('.owl-carousel').owlCarousel({
            // loop: true,
            nav: true,
            margin: 10,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1 // Number of items to show on smaller screens (mobile)
                },
                600: {
                    items: 3 // Number of items to show on medium screens (tablets)
                },
                1000: {
                    items: 5 // Number of items to show on larger screens (desktops)
                }
            }
        });
        // Ensure the class name here matches your intended target for the second carousel
        $('.slider2').owlCarousel({
            // loop: true,
            margin: 10,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 3,
                    nav: false
                },
                1000: {
                    items: 5,
                    nav: true,
                    loop: false
                }
            }
        });
    </script>
@endpush
