@extends('backend.layouts.main')
@section('title', 'quotation3')
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
        </style>
    @endpush

    <div class="container" style="max-width:1350px !important;">

        <div class="col-12">
            <div class="row">

                <div class="col-8">
                    <div class="row">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-secondary" value="Back" onclick="goBack()" type="button">Back</button>
                                <h5 class="ms-3 mt-5 mb-0 quotation_number_sync" style="margin-left: 50px !important;">
                                    {{ $QuotationRecord->user_slug ?? ($QuotationRecord->slug ?? '--') }}
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-4 d-flex justify-content-end align-items-center">
                    <a id="createvariant" href="#animatedModal12" role="button" class="btn btn-outline-primary mx-2"> Add
                        Product </a>

                    <a href="{{ route('panel.Documents.quotation4') }}?typeId={{ request()->get('typeId') }}"
                        class="btn btn-outline-primary">
                        Next
                    </a>
                </div>
            </div>
        </div>


        <div class="col-12">
            <div class="row d-flex justify-content-center">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <ul class="navbar-nav">
                            <li class="nav-item mx-3">
                                <a class="nav-link " href="#">1.Add Details</a>
                            </li>
                            <li class="nav-item mx-3">
                                <a class="nav-link active" href="#">2. Select Items</a>
                            </li>
                            <li class="nav-item mx-3">
                                <a class="nav-link" href="#">Generate</a>
                            </li>
                            <!-- Add more steps as needed -->
                        </ul>
                    </div>
                </nav>

            </div>
        </div>

        <div class="col lg-6 col-md-5 d-flex justify-content-between align-items-center mt-5">
            <div class=" mx-1">
                <input type="text" placeholder=" Search here  " id="searchValue" name="search"
                    style="width: 350px !important;" value="{{ request()->get('search') }}" class="form-control">
                <button type="submit" class="input-group-text bg-white border-0" id="searchsubmit"><i
                        class="uil uil-search"></i></button>
            </div>
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
                        'currency': "{{ json_decode($QuotationRecord->additional_notes)->currency ?? 'INR'}}"
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
                    $(this).children('input').attr('checked', false);
                } else {
                    $(this).children('input').attr('checked', true);

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
                                        'currency': "{{ json_decode($QuotationRecord->additional_notes)->currency ?? 'INR'}}"
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
                                    $(this).children('input').attr('checked', false);
                                } else {
                                    $(this).children('input').attr('checked', true);

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

@endsection
