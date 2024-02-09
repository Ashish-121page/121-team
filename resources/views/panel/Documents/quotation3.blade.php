@extends('backend.layouts.main')
@section('title', 'Quotation Product Selection')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/normalize.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
        <style>
            .prdct-checked {
                position: absolute;
                width: 30px;
                height: 30px;
                right: 10px;
                cursor: pointer;
            }

            .checkmark {
                position: absolute;
                top: 11px;
                left: 7px;
                height: 19px;
                width: 20px;
                border-radius: 3px;
                background-color: #eee;
            }

            .checkmark:after {
                content: "";
                position: absolute;
                display: block;
            }

            .custom-chk .checkmark:after {
                left: 6px;
                top: 2px;
                width: 7px;
                height: 12px;
                border: solid white;
                border-width: 0 3px 3px 0;
                -webkit-transform: rotate(45deg);
                -ms-transform: rotate(45deg);
                transform: rotate(45deg);
            }

            .custom-chk input:checked~.checkmark {
                background-color: #6666cc;
            }

            .card-body::-webkit-scrollbar {
                width: 4px
            }

            .card-body::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            .card-body::-webkit-scrollbar-thumb {
                background: #6666CC;
            }

            .nav-link.active {
                color: #6666cc !important;
            }

            .sticky {
                position: fixed;
                top: 56px;
                width: 100%;
                z-index: 99999;
                background-color: #fff;
                padding: 19px 0;
                left: 15px;
            }
        </style>
    @endpush

    <div class="container" style="max-width:1350px !important;">

        <div class="col-12 mb-3">
            <div class="row" id="jekfuiewbfejq">

                <div class="col-8">
                    <div class="row">
                        <div class="col-lg-6 col-md-8">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-outline-primary" value="Back" onclick="goBack()"
                                    type="button">Back</button>
                                <h5 class="ms-3 mt-5 mb-0 quotation_number_sync" style="margin-left: 2rem !important;">
                                    {{ $QuotationRecord->user_slug ?? ($QuotationRecord->slug ?? '--') }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4  col-md-4 d-flex justify-content-end align-items-center">
                    <a id="createvariant" href="#animatedModal12" role="button" class="btn btn-outline-primary mx-2"> Add
                        New Product </a>

                    <a href="{{ route('panel.Documents.quotation4') }}?typeId={{ request()->get('typeId') }}"
                        class="btn btn-outline-primary">
                        Next
                    </a>
                </div>

                <div class="col-12">
                    <div class="container-fluid mt-5 mb-3">
                        <div class="row bg-light">
                            <div class="col-12 d-flex gap-3 justify-content-center ">
                                <a class="nav-link {{ activeClassIfRoutes(['panel.Documents.create.Quotation.form'], 'active') }}"
                                    href="{{ route('panel.Documents.create.Quotation.form', ['typeId' => request()->get('typeId'), 'action' => request()->get('action')]) }}">
                                    1. Add Details </a>

                                <a class="nav-link {{ activeClassIfRoutes(['panel.Documents.quotation3'], 'active') }}"
                                    href="{{ route('panel.Documents.quotation3', ['typeId' => request()->get('typeId')]) }}">
                                    2. Select
                                    Items </a>

                                <a class="nav-link {{ activeClassIfRoutes(['panel.Documents.quotation4'], 'active') }} "
                                    href="{{ route('panel.Documents.quotation4', ['typeId' => request()->get('typeId')]) }}">
                                    3.
                                    Generate </a>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>



        <div class="col lg-6 col-md-5 d-flex justify-content-between align-items-center mt-5">
            <div class=" mx-1">
                <input type="text" placeholder=" Search here  " id="searchValue" name="search"
                    style="width: 350px !important;" value="{{ request()->get('search') }}" class="form-control">
                <button type="submit" class="input-group-text bg-white border-0" id="searchsubmit"><i
                        class="uil uil-search"></i></button>
            </div>

            @if (!$showAll)
                {{-- <a href="?typeId={{ request()->get('typeId') }}&show_all=true&page={{request()->get('page',1)}}" class="btn btn-outline-danger mb-3 mx-1 @if (request()->get('show_all', false) == true) active @endif" >Show All</a> --}}
            @endif


        </div>

        <div class="container-fluid" id="loadproduct">
            @include('panel.Documents.pages.products')
        </div>


    </div>

    <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>
    @include('panel.Documents.pages.addProduct')

    <script>
        $(document).ready(function() {
            $(".custom-chk").click(function(e) {
                e.preventDefault();
                console.log("Adding a product to the quotation");
                const precord = $(this).children('input').data('record');
                const pvalue = $(this).children('input').val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('panel.Documents.create.Quotation.item') }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'precord': precord,
                        'pid': pvalue,
                        'quotation_id': "{{ $QuotationRecord->id }}",
                        'currency': "{{ json_decode($QuotationRecord->additional_notes)->currency ?? 'INR' }}"
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 'success') {
                            $.toast({
                                text: response.message,
                                showHideTransition: 'fade',
                                icon: response.status,
                                stack: 6,
                                position: 'bottom-right'
                            })
                        }
                    }
                });

                if ($(this).children('input').attr('checked') == 'checked') {
                    $(this).children('input').removeAttr('Checked');
                } else {
                    $(this).children('input').attr('checked', 'Checked');
                }

            });


            // Ajax Search
            $("#searchValue").on('input', function() {
                let loadproductbx = $("#loadproduct");
                if ($(this).val() != '') {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('panel.Documents.quotation3') }}",
                        data: {
                            searchProduct: $(this).val()
                        },
                        success: function(response) {
                            loadproductbx.html(response);
                            // Recalling Funcion
                            $(".custom-chk").click(function(e) {
                                e.preventDefault();
                                console.log("Adding a product to the quotation");
                                const precord = $(this).children('input').data(
                                    'record');
                                const pvalue = $(this).children('input').val();

                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('panel.Documents.create.Quotation.item') }}",
                                    data: {
                                        '_token': "{{ csrf_token() }}",
                                        'precord': precord,
                                        'pid': pvalue,
                                        'quotation_id': "{{ $QuotationRecord->id }}",
                                        'currency': "{{ json_decode($QuotationRecord->additional_notes)->currency ?? 'INR' }}"
                                    },
                                    dataType: "json",
                                    success: function(response) {
                                        if (response.status == 'success') {
                                            $.toast({
                                                text: response
                                                    .message,
                                                showHideTransition: 'fade',
                                                icon: response
                                                    .status,
                                                stack: 6,
                                                position: 'bottom-right'
                                            })
                                        }
                                    }
                                });
                                if ($(this).children('input').attr('checked') ==
                                    'checked') {
                                    // $(this).children('input').attr('checked', false);
                                    $(this).children('input').removeAttr('Checked');
                                } else {
                                    $(this).children('input').attr('checked',
                                        'Checked');

                                }

                            });


                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                } else {
                    loadproductbx.empty();
                }
            });

            $("#createvariant").animatedModal();
        });

        function goBack() {
            window.history.back()
        }
    </script>

    <script>
        window.onscroll = function() {
            fixmynav()
        };
        var tablehead = document.getElementById("jekfuiewbfejq");

        function fixmynav() {
            if (window.pageYOffset >= 80) {
                tablehead.classList.add("sticky")
            } else {
                tablehead.classList.remove("sticky");
            }
        }
    </script>

@endsection
