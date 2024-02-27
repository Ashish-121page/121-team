@extends('backend.layouts.main')
@section('title', 'Generate Quotation')
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
                /* left: 37px; */
            }

            .sticky-col.third-col {
                left: 82px;
            }

            .sticky-col.thirteenth-col {
                right: 0;
            }

            .sticky {
                position: fixed;
                left: 1%;
                top: 58px;
                width: 100%;
                z-index: 99999;
                background-color: #fff;
                padding: 19px 0;
                transition: all 0.3s ease-in-out; /* Adjust the duration as needed */
            }

            .sticky+.content {
                padding-top: 60px;
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

            table {
                text-align: center;
                vertical-align: middle;
            }

            td {
                border: none !important;
                border-left: 1px solid #dee2e6 !important;

            }

            select,
            input {
                min-width: 80px;
            }

            label.mb-0 {
                margin-left: -30px;
            }

            .accordion-button{
                font-size: medium;
            }

            .nav-link.active {
                color: #6666cc !important;
            }

            .choosefields {
                height: 15px !important;
                width: 15px !important;
            }


        </style>
    @endpush

    <div class="container" style="max-width:1350px !important;">
        <div class="row" id="jekfuiewbfejq">
            <div class="col lg-6 col-md-6 ">
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-secondary" onclick="goBack()" type="button">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h5 class="ms-3 mt-5 mb-0" style="margin-left: 30px !important;">
                            {{ $QuotationRecord->user_slug ?? $QuotationRecord->slug }}

                            @if ($QuotationRecord->status == 1)
                                <span class="badge rounded-pill bg-success">Saved</span>
                            @else
                                <span class="badge rounded-pill bg-warning">Draft</span>
                            @endif
                        </h5>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="two" style="display: flex; align-items: center; justify-content: flex-end;">

                    <div class="form-group w-100" style="margin-bottom: 0rem; display: flex; justify-content: flex-end;">
                        <div class="dropdown">
                            <a href="{{ route('panel.Documents.quotation3') }}?typeId={{ $QuotationRecord->id }}"
                                class="btn btn-outline-primary mx-1">
                                Add products
                            </a>
                        </div>
                        <a href="#" class="btn btn-outline-success mx-1" role="button" aria-expanded="false"
                            data-bs-toggle="modal" data-bs-target="#AttriModal">
                            <i class="fas fa-plus"></i>
                            Fields
                        </a>

                        <a href="#"
                            class="btn @if ($QuotationRecord->status == 1) btn-outline-dark @else btn-dark @endif mx-1"
                            aria-expanded="false" role="button" id="saveQuote">
                            {{-- <i class="fas fa-save"></i> --}}
                            Save
                            @if ($QuotationRecord->type_of_quote == 0)
                                Quotation
                            @else
                                PI
                            @endif
                        </a>

                        @if ($QuotationRecord->status == 1)
                            <a href="#" class="btn btn-outline-primary  mx-1" data-toggle="modal" id="openAddcongin">
                                <i class="fas fa-plus"></i>
                                Consignee
                            </a>
                            <a href="{{ route('panel.Documents.quotationpdf') }}?typeId={{ $QuotationRecord->id }}"
                                class="btn btn-primary mx-1" aria-expanded="false">
                                <i class="fas fa-download"></i>
                                PDF
                            </a>
                            <a href="{{ route('panel.Documents.printexcelqt1') }}?typeId={{ $QuotationRecord->id }}"
                                class="btn btn-primary mx-1" aria-expanded="false">
                                <i class="fas fa-download"></i>
                                Excel
                            </a>
                        @endif

                    </div>

                </div>
            </div>


            <div class="container-fluid mt-5 mb-3 ">
                <div class="row bg-light">
                    <div class="col-12 d-flex gap-3 justify-content-center ">
                        <a class="nav-link {{ activeClassIfRoutes(['panel.Documents.create.Quotation.form'], 'active') }}"
                            href="{{ route('panel.Documents.create.Quotation.form', ['typeId' => request()->get('typeId'), 'action' => request()->get('action')]) }}">
                            1. Add Details </a>

                        <a class="nav-link {{ activeClassIfRoutes(['panel.Documents.quotation3'], 'active') }}"
                            href="{{ route('panel.Documents.quotation3', ['typeId' => request()->get('typeId')]) }}"> 2.
                            Select Items </a>

                        <a class="nav-link {{ activeClassIfRoutes(['panel.Documents.quotation4'], 'active') }} "
                            href="{{ route('panel.Documents.quotation4', ['typeId' => request()->get('typeId')]) }}"> 3.
                            Generate </a>
                    </div>
                </div>
            </div>


        </div>



        <div class="row mt-3">
            <div class="col-lg-12 ">
                <div class="table-responsive accordion">
                    @include('panel.Documents.pages.Product-Table')
                </div>
            </div>
        </div>

        <div class="row my-4">
            <div class="col-6">
                <div class="col-12 d-flex justify-content-between">
                    <span class="h6">
                        <b> Order Summary </b>
                    </span>
                </div>
                <div class="card">
                    <div class="invisible ">Dummytext</div>
                    <div class="card-body">
                        <div class="d-flex">
                            <span class="mr-2">Total Quantity:</span>
                            <span id="itenQuantitycount">0</span> &nbsp; Piece
                        </div>

                        <div class="d-flex">
                            <span class="mr-4">Remarks:</span>
                            <textarea id="Quotation-additional_notes" class="form-control" cols="30" rows="6">{{ json_decode($QuotationRecord->charges_info ?? '')->additional_notes ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-6">
                <div class="col-12 d-flex justify-content-between">
                    <span class="h6">
                        <b> Total Amount (pre-tax) </b>
                    </span>
                    <span class="p-1 update_totalamt ">$0</span>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @if (json_decode($QuotationRecord->charges_info ?? '')->taxes ?? '' != '')
                                @foreach (json_decode($QuotationRecord->charges_info ?? '')->taxes as $index => $tax)
                                    @php
                                        $rand = generateRandomStringNative(10);
                                        $random = 'charge_' . $rand;
                                        $tagrandom = 'tag_' . $rand;
                                    @endphp

                                    <div class="col-4 mb-2 d-flex  align-content-center " data-rid="{{ $random }}">
                                        <button class="btn" type="button" style="background-color: transparent;"
                                            onclick="removechargesbox(this)" data-target="{{ $random }}">
                                            <i class="fas fa-trash-alt text-danger "></i>
                                        </button>
                                        <input type="text" class="form-control  teaxname"
                                            @if ($index == 0) disabled readonly @endif
                                            placeholder="Enter New Tax name" value="{{ $tax->tax_name ?? '' }}">
                                    </div>

                                    <div class="col-4 d-flex  mb-2" data-rid="{{ $random }}">
                                        <input type="number" data-id="{{ $tagrandom }}" class="form-control w-50"
                                            value="{{ trim($tax->tax_amt) ?? 0 }}" onchange="updatecharges(this)">
                                        <button class="btn" type="button" style="background-color: transparent;">
                                            <span class="currencyMark"></span>
                                        </button>
                                    </div>

                                    <div class="col-4 d-flex justify-content-end  mb-2" data-rid="{{ $random }}">
                                        <span class="currencyMark"></span> &nbsp;&nbsp; <span class="additional_taxes"
                                            id="{{ $tagrandom }}"> {{ trim($tax->tax_amt) ?? 0 }} </span>
                                    </div>
                                @endforeach
                            @else
                                {{-- Section one --}}
                                <div class="col-4 mb-2 d-flex" data-rid="charge-eidhfne">
                                    <button class="btn remvechareg" onclick="removechargesbox(this)" type="button"
                                        style="background-color: transparent;" data-target="charge-eidhfne">
                                        <i class="fas fa-trash-alt text-danger "></i>
                                    </button>
                                    <input type="text" disabled readonly value="GST"
                                        class="form-control text-dark teaxname">
                                </div>
                                <div class="col-4 d-flex  mb-2" data-rid="charge-eidhfne">
                                    <input type="number" data-id="gst_tax_amt" class="form-control w-50"
                                        onchange="updatecharges(this)" value="0">
                                    <button class="btn" type="button" style="background-color: transparent;">
                                        <span class="currencyMark"></span>
                                    </button>
                                </div>

                                <div class="col-4 d-flex justify-content-end  mb-2" data-rid="charge-eidhfne">
                                    <span class="currencyMark"></span> &nbsp;&nbsp; <span id="gst_tax_amt"
                                        class="additional_taxes">0</span>
                                </div>


                                {{-- Section THREE --}}
                                <div class="col-4 mb-2 d-flex  align-content-center" data-rid="charge-hgfhbas">
                                    <button class="btn remvechareg" onclick="removechargesbox(this)" type="button"
                                        style="background-color: transparent;" data-target="charge-hgfhbas">
                                        <i class="fas fa-trash-alt text-danger "></i>
                                    </button>
                                    <input type="text" class="form-control teaxname" placeholder="Enter New Tax name">
                                </div>

                                <div class="col-4 d-flex  mb-2" data-rid="charge-hgfhbas">
                                    <input type="number" name="" id="" class="form-control  w-50"
                                        data-id="custom_tax" onchange="updatecharges(this)" value="0">
                                    <button class="btn" type="button" style="background-color: transparent;">
                                        <span class="currencyMark"></span>
                                    </button>
                                </div>

                                <div class="col-4 d-flex justify-content-end  mb-2" data-rid="charge-hgfhbas">
                                    <span class="currencyMark"></span> &nbsp;&nbsp; <span class="additional_taxes"
                                        id="custom_tax"> 0</span>
                                </div>


                                {{-- Section End --}}
                            @endif


                            <div class="col-12" id="appendchargebefore">
                                <button class="btn btn-link text-primary " id="dhfuidbsijk" onclick="appendCharges()">
                                    <i class="fas fa-plus-circle"></i> Add Charges
                                </button>
                                <hr>
                            </div>

                            <div class="col-8 mb-2">
                                <b>Final Amount</b>
                            </div>
                            <div class="col-4 mb-2 d-flex  justify-content-end ">
                                <span class="currencyMark"></span> &nbsp;&nbsp; <span id="final_amt-eifhjc">0</span>
                            </div>


                        </div>
                    </div>
                </div>
            </div>

        </div>


        @if ($consignee_details->count() > 0)
            <div class="row">
                <div class="col-lg-4 col-md-6 col-12 my-3 border mx-3 ">
                    <div class="row">

                        <div class="col-4" style="background-color: #f6f8fb;">
                            Name
                        </div>
                        <div class="col-4" style="background-color: #f6f8fb;">
                            PID / ID
                        </div>
                        <div class="col-4" style="background-color: #f6f8fb;">

                        </div>

                        @forelse ($consignee_details as $item)
                            @php
                                $emp_json = json_decode($item->consignee_details);
                                $person_info = json_decode($item->person_info);
                            @endphp

                            <div class="col-4 my-2">
                                {{ $emp_json->entity_name ?? '' }}
                            </div>
                            <div class="col-4 my-2">
                                {{ $emp_json->p_id ?? ($emp_json->ref_id ?? '') }}
                            </div>
                            <div class="col-4 my-2">
                                <button type="button" data-person_info="{{ $item->person_info }}"
                                    data-consignee_details='{{ $item->consignee_details }}'
                                    data-recid="{{ $item->id }}" class="btn btn-link  editconsign">View /
                                    Edit</button>
                            </div>

                        @empty
                            <div class="col-12">
                                <span class="py-2">No Consignee Added</span>
                            </div>
                        @endforelse




                    </div>
                </div>
            </div>

        @endif

    </div>
    </div>
    
    {{-- Including Modal --}}
    @include('panel.Documents.modals.SelectAttribute')
    @include('panel.Documents.modals.add-consign')


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

    <script>
        function addCommasToNumber(number) {
            const numberString = number.toString();
            const formattedNumber = numberString.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            return formattedNumber;
        }

        function makeTotalAmt() {
            let amt = 0;
            let array = []
            $.each($(".totalnum"), function(indexInArray, valueOfElement) {
                let valu = $(valueOfElement).text().replaceAll(',', '');
                array.push(+valu)
            });

            amt = array.reduce((a, b) => a + b, 0);
            let currency = $(".currencySelect:first").text();
            amt = new Intl.NumberFormat().format(amt);

            $(".update_totalamt").html(currency + " " + amt);
            return amt;
        }


        function updatecharges(e) {
            let id = e.getAttribute('data-id');
            let valu = e.value;
            $("#" + id).html(valu);
            countTotal()
        }


        function updateCurrency() {
            let currency = $(".currencySelect:first").text();
            $(".currencyMark").html(currency);
        }



        function removechargesbox(element) {
            let target = $(element).attr('data-target');
            // $("#"+target).remove();
            $("[data-rid='" + target + "']").remove();
            countTotal()
        }


        function countTotal() {
            let total = 0;
            $.each($(".additional_taxes"), function(indexInArray, valueOfElement) {
                let valu = $(this).text().replaceAll(',', '');
                total += parseInt(valu);
            });

            total += +makeTotalAmt();

            $("#final_amt-eifhjc").text(addCommasToNumber(total));
            return total;
        }


        function generateRandomTagId() {
            const randomId = Math.random().toString(36).substring(2, 8);
            return `tag_${randomId}`;
        }

        function appendCharges() {
            let tag_id = generateRandomTagId();
            let Div_id = generateRandomTagId();

            tags = `<div class="col-4 mb-2 d-flex  align-content-center " data-rid="${Div_id}">
                    <button class="btn" type="button" style="background-color: transparent;" onclick="removechargesbox(this)" data-target="${Div_id}">
                        <i class="fas fa-trash-alt text-danger "></i>
                    </button>
                    <input type="text" class="form-control teaxname" placeholder="Enter New Tax name" >
                </div>

                <div class="col-4 d-flex  mb-2" data-rid="${Div_id}">
                    <input type="number" data-id="${tag_id}" class="form-control w-50" value="0"  onchange="updatecharges(this)">
                    <button class="btn" type="button" style="background-color: transparent;">
                        <span class="currencyMark"></span>
                    </button>
                </div>

                <div class="col-4 d-flex justify-content-end  mb-2" data-rid="${Div_id}">
                    <span class="currencyMark"></span> &nbsp;&nbsp; <span class="additional_taxes" id="${tag_id}"> 0</span>
                </div>`;

            $("#appendchargebefore").before(tags);
            updateCurrency()
        }


        updateCurrency()
        $(document).ready(function() {


            $("#openAddcongin").click(function(e) {
                e.preventDefault();
                $("#updaterec_btn").addClass('d-none');
                $("#new_rec_btn").removeClass('d-none');

                $("#consginaccess").attr('action',
                    "{{ route('panel.Documents.create.Quotation.consignee') }}");
                $("#addconsigneeModal").modal('show');

            });



            // make total Amount
            $(".form-control[type='number']").trigger('change');

            $(".editconsign").click(function(e) {
                e.preventDefault();
                let rec_id = $(this).attr('data-recid')
                let consignee_details = $(this).attr('data-consignee_details')
                consignee_details = JSON.parse(consignee_details);
                let person_info = $(this).attr('data-person_info')
                person_info = JSON.parse(person_info);
                $("#consign_item_id").val(rec_id);
                if (consignee_details.p_id != null) {
                    $("#consignee_p_id_name").val(consignee_details.p_id);
                }

                $("#consigneename").val(consignee_details.entity_name);
                console.log(consignee_details);

                $("#consigneref_id").val(consignee_details.ref_id);
                $("#adrsl1").val(consignee_details.address1);
                $("#adrsl2").val(consignee_details.address2);
                $("#consigneecity").val(consignee_details.city);

                $("#country option:contains('" + consignee_details.country + "')").prop("selected", true);
                $("#country").trigger('change');
                $("#country").select2();

                $("#state option:contains('" + consignee_details.state + "')").prop("selected", true);
                $("#country").trigger('change');
                $("#state").select2();

                $("#pincode").val(consignee_details.pincode);

                $("#appendpersoncong").html('');

                $.each(person_info, function(indexInArray, valueOfElement) {
                    let tags = ` <div class="col-lg-4 col-md-6 col-12 mb-3"
                            style="display:block; width:100% !important;">
                            <label for="consigneename">Person Name</label>
                            <br>
                            <input class="form-control" type="text" placeholder="Enter" value="${valueOfElement.person_name}"
                                name="consignee_person_name[]">
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <label for="consigneemail">Email</label>
                            <br>
                            <input class="form-control" type="text" placeholder="Enter" value="${valueOfElement.person_email}"
                                name="consignee_person_email[]">
                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mb-3">
                            <label for="consigneemail">Contact Number</label>
                            <br>
                            <input class="form-control" type="text" placeholder="Enter" value="${valueOfElement.person_phone}"
                                name="consignee_person_contact[]">
                        </div>`;

                    $("#appendpersoncong").append(tags);
                });

                $("#new_rec_btn").addClass('d-none');
                $("#updaterec_btn").removeClass('d-none');
                $("#consginaccess").attr('action',
                    "{{ route('panel.Documents.update.Quotation.consignee') }}");


                $("#addconsigneeModal").modal('show');
            });


            makeTotalAmt()

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

        //     // Function to get text, select value, or input value
        //     function getTextOrSelectValue(element) {
        //         // Check if element is a select element
        //         if (element.tagName === "SELECT") {
        //             return element.options[element.selectedIndex].value;
        //         }
        //         // Check if element is an input element or image
        //         if (element.tagName === "INPUT" || element.tagName === "TEXTAREA") {
        //             return element.value;
        //         }
        //         if (element.tagName === "IMG") {
        //             return element.src;
        //         }
        //         // For content editable or other elements
        //         return element.contentEditable === 'true' ? element.innerText : element.textContent;
        //     }

        //     // Get headers text, skip headers with class 'd-none'
        //     var headers = [];
        //     table.querySelectorAll('thead th:not(.d-none)').forEach(function(header, index) {
        //         headers[index] = cleanString(getTextOrSelectValue(header));
        //     });

        //     // Convert rows to objects, skip rows and cells with class 'd-none'
        //     Array.from(table.querySelectorAll('tbody tr:not(.d-none)')).forEach(function(row) {
        //         var rowData = {};
        //         Array.from(row.querySelectorAll('td:not(.d-none)')).forEach(function(cell, index) {
        //             // Check for select, input, textarea, or image elements within cell, else use cell text
        //             var value = cell.querySelector('select, input, textarea, img') ?
        //                 getTextOrSelectValue(cell.querySelector('select, input, textarea, img')) :
        //                 cleanString(getTextOrSelectValue(cell));
        //             if (headers[index]) {
        //                 rowData[headers[index]] = value;
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

            // Function to get text, select value, or input value
            function getTextOrSelectValue(element) {
                // Check if element is a select element
                if (element.tagName === "SELECT") {
                    return element.options[element.selectedIndex].value;
                }
                // Check if element is an input element or image
                if (element.tagName === "INPUT" || element.tagName === "TEXTAREA") {
                    return element.value;
                }
                if (element.tagName === "IMG") {
                    return element.src;
                }
                // For content editable or other elements
                return element.contentEditable === 'true' ? element.innerText : element.textContent;
            }

            // Get headers text, skip headers with class 'd-none'
            var headers = [];
            table.querySelectorAll('thead th:not(.d-none)').forEach(function(header, index) {
                headers[index] = cleanString(getTextOrSelectValue(header));
            });

            // Convert rows to objects, skip rows and cells with class 'd-none' and '.efddsgs'
            Array.from(table.querySelectorAll('tbody tr:not(.d-none):not(.efddsgs)')).forEach(function(row) {
                var rowData = {};
                Array.from(row.querySelectorAll('td:not(.d-none):not(.efddsgs)')).forEach(function(cell, index) {
                    // Check for select, input, textarea, or image elements within cell, else use cell text
                    var value = cell.querySelector('select, input, textarea, img') ?
                        getTextOrSelectValue(cell.querySelector('select, input, textarea, img')) :
                        cleanString(getTextOrSelectValue(cell));
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

            console.log(json);

            let taxes = [];

            $.each($(".additional_taxes"), function(indexInArray, valueOfElement) {
                let tax_name = $(".teaxname")[indexInArray].value;
                if (tax_name == "") {
                    tax_name = "Tax " + (indexInArray + 1);
                }
                let tax_amt = $(this).text();
                taxes.push({
                    "tax_name": tax_name,
                    "tax_amt": tax_amt
                })
            });


            $.ajax({
                type: "POST",
                url: "{{ route('panel.Documents.save.quotation') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "data": JSON.stringify(json),
                    "quotation_id": "{{ $QuotationRecord->id }}",
                    "currency": $("#currencySelect").val(),
                    "additional_notes": $("#Quotation-additional_notes").val(),
                    "taxes": JSON.stringify(taxes)
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.status == 'success') {
                        // $.toast({
                        //     text: response.message,
                        //     showHideTransition: 'fade',
                        //     icon: response.status,
                        //     stack: 6,
                        //     position: 'bottom-right'
                        // })
                        window.location.reload()
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
    </script>


@endsection
