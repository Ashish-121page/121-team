@extends('backend.layouts.main')
@section('title', 'quotation4')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
        <style>
            .table-responsive {
                overflow-x: auto;
                overflow-y: visible;
            }

            .sticky-col {
                position: sticky;
                position: -webkit-sticky;
                background-color: white;
                z-index: 1020;
                /* background-color: #f3f3f3!important; */
            }

            .sticky-col.first-col {
                left: 0;
            }

            .sticky-col.second-col {
                left: 37px;
            }

            .sticky-col.third-col {
                left: 82px;
            }

            .sticky-col.thirteenth-col {
                right: 0;
            }

            th,
            td {
                white-space: nowrap;
            }

            .sdeds {
                display: none
            }

            .input-group {
                display: flex;
                width: 40%;
            }
        </style>
    @endpush

    <div class="container" style="max-width:1350px !important;">
        <div class="row">
            <div class="col lg-6 col-md-6 ">
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-secondary" onclick="goBack()" type="button">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h5 class="ms-3 mt-5 mb-0" style="margin-left: 30px !important;">{{ $QuotationRecord->user_slug ?? $QuotationRecord->slug  }}</h5>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="two" style="display: flex; align-items: center; justify-content: flex-end;">
                    <div class="form-group w-100" style="margin-bottom: 0rem; display: flex; justify-content: flex-end;">
                        <div class=" d-flex align-items-end">


                            {{-- <div class="form-group w-100 justify-content-between" style="display: flex; align-items: center;">
                              <button class="btn btn-primary" type="button" id="#9uou">
                                  <span class="bi bi-currency-dollar">$</span>
                              </button>
                          </div> --}}
                        </div>
                        <div class="form-group w-100 justify-content-between" style="display: flex; align-items: center;">
                            <label for="currency" class="control-label">Currency</label>
                            <div class="input-group mb-3" style="margin-left:40px; width:100%;">
                                <!-- <input type="number" class="form-control" style="width:25%"  id="gst" value="" aria-label="currency" aria-describedby="currencySelect"> -->
                                <select class="form-control select2 w-100" style="width:45%; background-color: #f3f3f3"
                                    id="currencySelect" aria-label="Currency">
                                    <option value="INR" selected>INR</option>
                                    <option value="GBP">GBP</option>
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                </select>
                            </div>
                            <!-- <input class="form-control" style="width:70%;" name="gst" type="text" id="gst" value=""> -->
                        </div>

                        <div class="dropdown">
                            <a href="{{ route('panel.Documents.quotation3') }}?typeId={{ $QuotationRecord->id }}"
                                class="btn btn-outline-primary mx-1">
                                Add more products
                            </a>
                        </div>
                        <a href="#" class="btn btn-outline-success mx-1" role="button" aria-expanded="false"
                            data-bs-toggle="modal" data-bs-target="#AttriModal">
                            Add Fields
                        </a>
                        <a href="#" class="btn btn-dark mx-1" aria-expanded="false" id="saveQuote">
                            Save quotation
                        </a>
                        <a href="{{ route('panel.Documents.quotationpdf') }}?typeId={{  $QuotationRecord->id }}" class="btn btn-outline-dark mx-1" aria-expanded="false" id="saveQuote">
                            Print PDF
                        </a>
                    </div>

                </div>
            </div>
        </div>


        <div class="row mt-3 text-muted mx-3" style="">
            <p> {{ $QuotationItems->count() }} Products added </p>

        </div>
        <div class="row mt-3">
            <div class="col-lg-12 ">
                <div class="table-responsive">
                    @include('panel.Documents.pages.Product-Table')
                </div>
            </div>
        </div>


        <div class="row mt-3 justify-content-start">
            <div class="col-lg-5 col-md-5 d-flex align-items-center">
                <input type="text" class="form-control" placeholder="Add remarks here" id="Quotation-additional_notes" value="{{ $QuotationRecord->additional_notes ?? '' }}">
                {{-- <button class="btn btn-primary mx-2 ms-2">Edit</button> --}}
            </div>
        </div>


    </div>
    </div>
z
    {{-- Including Modal --}}
    @include('panel.Documents.modals.SelectAttribute')


    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script src="{{ asset('backend/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#9uou").click(function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var msg =
                    "<div class='offcanvas-body'><input class='form-control' list='currencyList' id='currencyInput' placeholder='Type to search...'><datalist id='currencyList'><option value='USD'>United States Dollar</option><option value='EUR'>Euro</option><option value='JPY'>Japanese Yen</option></datalist></div>";

                $.confirm({
                    draggable: true,
                    title: ' Buyer Search',
                    content: msg,
                    type: 'blue',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Proceed',
                            btnClass: 'btn-primary',
                            // action: function () {
                            //     // Redirect to the second view route
                            //     window.location.href = "{{ route('panel.Documents.secondview') }}";
                            // }
                        },
                        close: function() {
                            // Additional action if needed upon dialog close
                        }
                    }
                });
            });




            // $(function () {
            //   $("#mybro").select2()
            // });





        });
    </script>

    <script>
        $(document).ready(function() {
            // $("#AttriModal").modal('show');

            $(".choosefields").change(function(e) {
                e.preventDefault();
                // $.alert("Hello ji"+$(this).attr('id'))
                let id = $(this).attr('id').split('-')[1];
                $(".Change-" + id).toggleClass("d-none");
            });


            $("#select-All-Default").click(function(e) {
                // e.preventDefault();
                $(".choosefields").attr('checked', true);
                $(this).attr('checked', true);

                getAllCheckedCheckboxes()

            });


            function getAllCheckedCheckboxes() {
                var checkedCheckboxes = [];
                $(".choosefields:checked").each(function() {
                    checkedCheckboxes.push($(this).val());
                    let id = $(this).attr('id').split('-')[1];
                    $(".Change-" + id).toggleClass("d-none");
                });
                var table = document.getElementById('sdhfidsj');
                tableToJson(table);
                // return checkedCheckboxes;
            }

            getAllCheckedCheckboxes();

        });

        function goBack() {
            window.history.back()
        }
    </script>


    <script>
        // function tableToJson(table) {
        //     var data = [];

        //     // Function to clean string
        //     function cleanString(str) {
        //         return str.replace(/\s+/g, ' ').trim();
        //     }

        //     // Get headers text, skip headers with class 'd-none'
        //     var headers = [];
        //     table.querySelectorAll('thead th:not(.d-none)').forEach(function(header, index) {
        //         headers[index] = cleanString(header.textContent);
        //     });

        //     // Convert rows to objects, skip rows and cells with class 'd-none'
        //     Array.from(table.querySelectorAll('tbody tr:not(.d-none)')).forEach(function(row) {
        //         var rowData = {};
        //         Array.from(row.querySelectorAll('td:not(.d-none)')).forEach(function(cell, index) {
        //             if (headers[index]) {
        //                 rowData[headers[index]] = cleanString(cell.textContent);
        //             }
        //         });
        //         data.push(rowData);
        //     });

        //     return data;
        // }


        function tableToJson(table) {
    var data = [];

    // Function to clean string
    function cleanString(str) {
        return str.replace(/\s+/g, ' ').trim();
    }

    // Function to get text or select value
    function getTextOrSelectValue(element) {
        // Check if element is a select element
        if (element.tagName === "SELECT") {
            return element.options[element.selectedIndex].value;
        }
        return element.contentEditable === 'true' ? element.innerText : element.textContent;
    }

    // Get headers text, skip headers with class 'd-none'
    var headers = [];
    table.querySelectorAll('thead th:not(.d-none)').forEach(function(header, index) {
        headers[index] = cleanString(getTextOrSelectValue(header));
    });

    // Convert rows to objects, skip rows and cells with class 'd-none'
    Array.from(table.querySelectorAll('tbody tr:not(.d-none)')).forEach(function(row) {
        var rowData = {};
        Array.from(row.querySelectorAll('td:not(.d-none)')).forEach(function(cell, index) {
            var value = cell.querySelector('select') ? getTextOrSelectValue(cell.querySelector('select')) : cleanString(getTextOrSelectValue(cell));
            if (headers[index]) {
                rowData[headers[index]] = value;
            }
        });
        data.push(rowData);
    });

    return data;
}

        // Convert the table into JSON
        $("#saveQuote").click(function(e) {
            e.preventDefault();
            var table = document.getElementById('sdhfidsj');
            var json = tableToJson(table);
            console.log(JSON.stringify(json));


            $.ajax({
                type: "POST",
                url: "{{ route('panel.Documents.save.quotation') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "data": JSON.stringify(json),
                    "quotation_id": "{{ $QuotationRecord->id }}",
                    "currency": $("#currencySelect").val(),
                    "additional_notes" : $("#Quotation-additional_notes").val()
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.status == 'success') {
                        $.toast({
                            text: response.message,
                            showHideTransition: 'fade',
                            icon: response.status,
                            stack: 6,
                            position: 'bottom-right'
                        })
                    }
                },
                error: function(error) {
                    $.toast({
                        text: error.message,
                        showHideTransition: 'fade',
                        icon: error.status,
                        stack: 6,
                        position: 'bottom-right'
                    })
                }
            });
        });

        $("#currencySelect").change(function(e) {
            e.preventDefault();
            $('.currencySelect').html($(this).val());
        });


        // $(document).ready(function() {
        //     $('.priceEdit[contenteditable]').on('input', function() {
        //         $(this).text($(this).text().replace(/[^0-9.]/g, ''));                
        //     });
        // });



    </script>


@endsection
