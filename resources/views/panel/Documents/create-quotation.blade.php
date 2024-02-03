@php
    if (isset($quotationRecord->customer_info)) {
        $CustomerInfo = json_decode($quotationRecord->customer_info) ?? [];
        $buyerId = $CustomerInfo->Buyer_Id ?? null;
        $buyerRec = \App\Models\BuyerList::whereId($buyerId)->first() ?? null;
        if ($buyerRec != null) {
            // Buyer Records
            $buyer = json_decode($buyerRec->buyer_details) ?? null;
            $Entity_Name = $buyer->entity_name ?? '';
            $entity_details_id = $buyer->entity_details_id ?? '';
            $ref_id = $buyer->ref_id ?? '';
            $address1 = $buyer->address1 ?? '';
            $address2 = $buyer->address2 ?? '';
            $city = $buyer->city ?? '';
            $country = $buyer->country ?? '';
            $pincode = $buyer->pincode ?? '';
        }
    }

@endphp

@extends('backend.layouts.main')
@section('title', 'secondview')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
        <style>
            .row {
                width: 100% !important;
            }

            .nav-link.active {
                color: #6666cc !important;
            }
        </style>
    @endpush

    <div class="container-fluid">

        <div class="row mt-5">
            <div class="col-12">
                <h1> PI / Quotation </h1>
            </div>
        </div>

        <!-- upper fields -->
        <div class="row mt-3">
            @php
                $actionURL = route('panel.Documents.create.Quotation');
                if (isset($quotationRecord)) {
                    $actionURL = route('panel.Documents.update.Quotation', $quotationRecord->id);
                }
            @endphp

            <form action="{{ $actionURL }}" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="proposal_id" value="{{ $offer_data['proposal_id'] ?? null }}">
                <input type="hidden" name="proposal_products" value="{{ $offer_data['products'] ?? null }}">

                <div class="col-lg-12 col-md-12 mb-3">
                    <div class="row">
                        <div class="col-lg-8 col-md-8">
                            <div class="row">
                                <div class="col-lg-6 col-md-8">
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-outline-primary" onclick="goBack()" value="Back"
                                            type="button">Back</button>
                                        <h5 class="ms-3 mt-5 mb-0 quotation_number_sync"
                                            style="margin-left: 2rem !important;">
                                            PI-231</h5>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-4 col-md-4 d-flex justify-content-end align-items-center"
                            id="eufh_efreeafN_WHRU">

                            @if (isset($quotationRecord))
                                {{-- <button type="submit" class="btn btn-outline-secondary mx-2" name="submitdraft">Save as Draft</button> --}}
                                <button type="submit" class="btn btn-outline-primary mx-2">Next</button>
                            @else
                                <button type="submit" class="btn btn-outline-primary mx-2" name="submitdraft">Save as
                                    Draft</button>
                                <button type="submit" class="btn btn-outline-primary mx-2">Next</button>
                            @endif

                            {{-- <button type="button" onclick="proceedTothirdView()" class="btn btn-primary" id="submit1"
                                data-bs-target="">
                                Next
                            </button> --}}
                        </div>
                    </div>
                </div>


                <div class="container-fluid mt-5 mb-3">
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


                {{-- ` Main Form Conatiner --}}
                <div class="col-md-12 col-lg-12">

                    <div class="row mt-3 d-flex justify-content-center">
                        {{--  Side details in md screen --}}
                        <div class="card col-md-12 col-lg-4">
                            <div class="row">
                                {{-- Exporter Details --}}
                                <div class="col-lg-12 col-md-12 mb-3">
                                    <div class="card" style="height: fit-content;">
                                        <div class="card-header d-flex justify-content-between align-items-center"
                                            style="background-color: #f3f3f3">
                                            <h6>Entity Details</h6>
                                            <a href="{{ route('panel.user_shops.edit', $userShop->id) }}?active=my-address"
                                                class="btn-link">Add New</a>
                                        </div>
                                        <div class="card-body" id="cardBody">
                                            <div class="form-group mb-3">
                                                <label for="entity_details">Select Entity <span
                                                        class="text-danger">*</span></label>
                                                <select name="entity_details" class="form-control select2"
                                                    id="entity_details" name="entity_details[entityname]" required>
                                                    <option>Select Entity</option>
                                                    @forelse ($entities as $entity)
                                                        <option value="{{ $entity->id }}"
                                                            @if (($entity_details_id ?? '') == $entity->id) selected @endif>
                                                            {{ json_decode($entity->details)->entity_name ?? '' }}
                                                        </option>
                                                    @empty
                                                        <option>No saved entities found</option>
                                                    @endforelse
                                                </select>
                                            </div>

                                            <div class="form-group mb-3">
                                                <label for="entity_bank"> Select Bank <span
                                                        class="text-danger">*</span></label>
                                                <select name="entity_bank" class="form-control select2" id="entity_bank"
                                                    name="entity_details[bankname]" required>

                                                    <option value="{{ $bank_details[0]->bank_name ?? '' }}">
                                                        {{ $bank_details[0]->bank_name ?? '' }}</option>
                                                    {{-- <option>No saved entities found</option> --}}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 mb-3 d-none">
                                    <div class="card" style="height: fit-content;">
                                        <div class="card-header" style="background-color: #f3f3f3">
                                            <h6>Internal Ref</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label for="attachments">Attachments</label>
                                                    <input class="form-control" type="file" id="attachments"
                                                        name="files[]" multiple>
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label for="internal_remarks">Internal Remarks</label>
                                                    <textarea name="internal_remarks" id="internal_remarks" cols="30" name="internal_ref[remarks]"
                                                        class="form-control">{{ $additional_notes->internal_remarks ?? ($offer_data['Offer_Notes'] ?? '') }}
                                                        </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--
                                    <div class="col-lg-12 col-md-12">
                                        <div class="card" style="height: 15rem;">
                                            <div class="card-header d-flex align-items-center justify-content-between"
                                                style="background-color: #f3f3f3">
                                                <span class="d-flex">
                                                    <h6>Consignee &nbsp;</h6><span>(optional)</span>
                                                </span>
                                                <a href="#" class="btn-link" data-toggle="modal" data-target="#addconsigneeModal">Add New</a>
                                            </div>
                                            <div class="card-body">
                                                <!-- Consignee content goes here -->
                                            </div>
                                        </div>
                                    </div> --}}
                            </div>
                        </div>

                        {{-- Main Quotation details --}}
                        <div class="card col-md-12 col-lg-8">

                            <div class="row">

                                {{-- Quotation Details --}}
                                <div class="col-md-12 col-lg-12 ">
                                    <div class="card" style="height:fit-content;">

                                        <div class="card-header mb-3" style="background-color:#f3f3f3">
                                            <h6>Quotation Details</h6>
                                        </div>

                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-lg-4 col-md-6 col-12 mb-3"
                                                    style="display:block; width:100% !important;">
                                                    <label for="quotation_number">Quotation Number <span
                                                            class="text-danger">*</span> </label>
                                                    <br>
                                                    <input class="form-control" id="quotation_number"
                                                        name="quotation[number]" type="text" placeholder="Enter"
                                                        value="{{ $quotationRecord->user_slug ?? ($quotationRecord->slug ?? $quotation_number) }}"
                                                        required>
                                                    <small id="checkslug" class="d-none">Slug Exist</small>
                                                </div>

                                                <div class="col-lg-4 col-md-6 col-12 mb-3">
                                                    <label for="buyermail">Quotation Date <span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control" type="date"
                                                        value="{{ $additional_notes->date ?? date('Y-m-d') }}"
                                                        name="quotation[date]" required>
                                                </div>


                                                <div class="col-lg-4 col-md-6 col-12 mb-3">
                                                    <label for="buyermail">Delivery Date</label>
                                                    <input class="form-control" type="date"
                                                        value="{{ $additional_notes->delivery_date ?? '' }}"
                                                        name="quotation[delivery_date]">
                                                </div>


                                                @php
                                                    $chk_currency = $additional_notes->currency ?? ($offer_data['Currency'] ?? ('INR' ?? ''));
                                                @endphp
                                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                                    <label for="buyermail">Currency <span
                                                            class="text-danger">*</span></label>
                                                    <br>
                                                    <select class="form-control select2w" name="quotation[currency]"
                                                        id="currency" required>
                                                        @forelse ($currency as $curr)
                                                            <option value="{{ $curr->currency }}"
                                                                @if ($chk_currency == $curr->currency) selected @endif
                                                                data-rateofexchange="{{ $curr->exchange ?? 1 }}">
                                                                {{ $curr->currency }} </option>
                                                        @empty
                                                            <option value="INR"> INR </option>
                                                        @endforelse
                                                    </select>

                                                </div>

                                                <div class="col-lg-6 col-md-6 col-12 mb-3">
                                                    <label for="buyermail">Exchange Rate</label>
                                                    <br>
                                                    <input class="form-control" type="text" pattern="^\d*\.?\d*$"
                                                        placeholder="Enter" name="quotation[exchange]"
                                                        value="{{ $additional_notes->exchange ?? '' }}"
                                                        title="Please E    nter a valid number or decimal">

                                                </div>
                                                @php
                                                    $chk_tod = $additional_notes->term_of_delivery ?? '';
                                                @endphp
                                                <div class="col-lg-4 col-md-6 col-12 mb-3">
                                                    <label for="buyermail">Terms of Delivery</label>
                                                    <select class="form-control select2" id="term_of_delivery"
                                                        name="quotation[term_of_delivery]">
                                                        @forelse ($terms_of_delivery as $term_of_del)
                                                            <option value="{{ $term_of_del }}"
                                                                @if ($chk_tod == $term_of_del) selected @endif>
                                                                {{ $term_of_del }}</option>
                                                        @empty
                                                            <option value="FOB">FOB</option>
                                                            <option value="CIF">CIF</option>
                                                            <option value="EX-W">EX-W</option>
                                                        @endforelse

                                                    </select>
                                                </div>


                                                <div class="col-lg-4 col-md-6 col-12 mb-3">
                                                    <label for="buyermail">Port of Loading</label>
                                                    <input class="form-control" type="text" placeholder="Enter"
                                                        value="{{ $additional_notes->port_of_loading ?? '' }}"
                                                        name="quotation[port_of_loading]">
                                                </div>

                                                <div class="col-lg-4 col-md-6 col-12 mb-3">
                                                    <label for="buyermail">Port of Discharge</label>
                                                    <input class="form-control" type="text" placeholder="Enter"
                                                        value="{{ $additional_notes->port_of_discharge ?? '' }}"
                                                        name="quotation[port_of_discharge]">
                                                </div>

                                                <div class="col-lg-12 col-md-6 col-12 mb-3">
                                                    <label for="buyermail">Payment Terms</label>
                                                    <textarea class="form-control" placeholder="Enter" name="quotation[payment_term]">{{ $additional_notes->payment_term ?? '' }}</textarea>
                                                </div>

                                            </div>


                                        </div>
                                    </div>
                                </div>


                                {{-- Buyer Details --}}
                                <div class="col-md-12 col-lg-12 ">
                                    <div class="card" style="height:fit-content;">
                                        <div class="card-header mb-3" style="background-color:#f3f3f3">
                                            <h6>Buyer Details</h6>
                                        </div>

                                        <div class="card-body">
                                            <div class="form-group">

                                                @php
                                                    $is_disabled = '';
                                                    if (isset($buyerRec)) {
                                                        $is_disabled = 'readonly';
                                                    }
                                                @endphp

                                                <div class="row">
                                                    <div class="col-lg-8" style="display:block; width:100% !important;">
                                                        <label for="buyername">Entity Name <span
                                                                class="text-danger">*</span></label>
                                                        <br>
                                                        <input class="form-control" type="text" placeholder="Enter"
                                                            name="buyer[entity_name]"
                                                            value="{{ $Entity_Name ?? ($offer_data['name'] ?? '') }}"
                                                            required {{ $is_disabled }}>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <label for="buyername">ID</label>
                                                        <br>
                                                        <input class="form-control" type="text" placeholder="Enter"
                                                            name="buyer[ref_id]"
                                                            value="{{ $ref_id ?? ($offer_data['alias'] ?? '') }}"
                                                            {{ $is_disabled }}>
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col-12" style="display:block; width:100% !important;">
                                                        <label for="adrsl1" style="width:100%">Address Line1</label>
                                                        <br>
                                                        <input class="form-control" type="text" style="width:100%"
                                                            name="buyer[address1]" placeholder="Enter"
                                                            value="{{ $address1 ?? '' }}" {{ $is_disabled }}>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-12" style="display:block; width:100% !important;">
                                                        <label for="adrsl2" style="width:100%">Address Line2</label>
                                                        <br>
                                                        <input class="form-control" type="text" style="width:100%"
                                                            name="buyer[address2]" placeholder="Enter"
                                                            value="{{ $address2 ?? '' }}" {{ $is_disabled }}>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-lg-4 col-md-6 col-12"
                                                        style="display:block; width:100% !important;">
                                                        <label for="buyercity" style="width:100%">City</label>
                                                        <br>
                                                        <input class="form-control" type="text" style="width:100%"
                                                            name="buyer[city]" placeholder="Enter"
                                                            value="{{ $city ?? '' }}" {{ $is_disabled }}>
                                                    </div>

                                                    <div class="col-lg-4 col-md-6 col-12"
                                                        style="display:block; width:100% !important;">
                                                        <label for="country" style="width:100%">Country</label>
                                                        <br>
                                                        <select class="form-control select2" id="country"
                                                            {{ $is_disabled }} name="buyer[country]" style="width:100%">
                                                            <option value="">Select a country</option>
                                                            @foreach ($countries as $country_db)
                                                                <option value="{{ $country_db->name }}"
                                                                    @if ($country_db->name == ($country ?? '')) selected @endif>
                                                                    {{ $country_db->name }}
                                                                </option>
                                                            @endforeach
                                                            <!-- Add more countries as needed -->
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6 col-12"
                                                        style="display:block; width:100% !important;">
                                                        <label for="pincode">Pincode</label>
                                                        <br>
                                                        <input class="form-control" name="buyer[pincode]" id="pincode"
                                                            type="text" placeholder="Enter"
                                                            value="{{ $pincode ?? '' }}" {{ $is_disabled }}>
                                                    </div>
                                                </div>

                                                @if ($is_disabled != '')
                                                    <div class="row my-2">
                                                        <div class="col-lg-12 col-md-12">
                                                            <div class="alert alert-warning" role="alert">
                                                                To update Buyer details, visit Buyer Section
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>

                                        </div>
                                    </div>
                                </div>


                                {{-- Person Details --}}
                                <div class=" col-lg-12 col-md-12">
                                    <div class="card" style="height:fit-content;">

                                        <div class="card-header mb-3" style="background-color:#f3f3f3">
                                            <h6>Contact Person</h6>
                                        </div>

                                        <div class="card-body">
                                            @php
                                                // Person Details
                                                if (isset($buyerRec->contact_persons)) {
                                                    $contact_persons = json_decode($buyerRec->contact_persons) ?? '';
                                                } else {
                                                    $contact_persons = [];
                                                }
                                            @endphp
                                            @forelse ($contact_persons as $contact_person)
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-6 col-12 mb-3"
                                                        style="display:block; width:100% !important;">
                                                        <label for="buyername">Person Name</label>
                                                        <br>
                                                        <input class="form-control" type="text" placeholder="Enter"
                                                            name="person_name[]"
                                                            value="{{ $contact_person->person_name ?? '' ?? ($offer_data['person_name'] ?? '') }}"
                                                            {{ $is_disabled }}>
                                                    </div>

                                                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                                                        <label for="buyermail">Email</label>
                                                        <br>
                                                        <input class="form-control" type="text" placeholder="Enter"
                                                            name="person_email[]"
                                                            value="{{ $contact_person->person_email ?? '' ?? ($offer_data['Email'] ?? '') }}"
                                                            {{ $is_disabled }}>
                                                    </div>

                                                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                                                        <label for="buyermail">Contact Number</label>
                                                        <br>
                                                        <input class="form-control" type="text" placeholder="Enter"
                                                            name="person_contact[]"
                                                            value="{{ $contact_person->person_phone ?? '' ?? ($offer_data['Phone'] ?? '') }}"
                                                            {{ $is_disabled }}>
                                                    </div>
                                                </div>

                                            @empty
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-6 col-12 mb-3"
                                                        style="display:block; width:100% !important;">
                                                        <label for="buyername">Person Name</label>
                                                        <br>
                                                        <input class="form-control" type="text" placeholder="Enter"
                                                            name="person_name[]" value="{{ $offer_data['name'] ?? '' }}">
                                                    </div>

                                                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                                                        <label for="buyermail">Email</label>
                                                        <br>
                                                        <input class="form-control" type="text" placeholder="Enter"
                                                            name="person_email[]"
                                                            value="{{ $offer_data['Email'] ?? '' }}">
                                                    </div>

                                                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                                                        <label for="buyermail">Contact Number</label>
                                                        <br>
                                                        <input class="form-control" type="text" placeholder="Enter"
                                                            name="person_contact[]"
                                                            value="{{ $offer_data['Phone'] ?? '' }}">
                                                    </div>
                                                </div>
                                            @endforelse


                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- bank details --}}
                        </div>
                    </div>

                </div>
            </form>


        </div>

        @include('panel.Documents.modals.exporterDetails')
    </div>
    <!--end of container -->

    <script>
        function proceedTothirdView() {
            // Redirect to the route for second view
            window.location.href = "{{ route('panel.Documents.thirdview') }}";
        }

        function goBack() {
            window.history.back()
        }

        $(document).ready(function() {

            // $("#addconsigneeModal").modal('show');


            var Quote_num = $("#quotation_number");
            $(".quotation_number_sync").text(Quote_num.val())

            Quote_num.on('input', function() {
                $("#checkslug").removeClass("d-none");

                $(".quotation_number_sync").text(Quote_num.val())
                $.ajax({
                    type: "get",
                    url: "{{ route('panel.Documents.Quotation.check.slug') }}",
                    data: {
                        slug: Quote_num.val()
                    },
                    dataType: "JSON",
                    success: function(response) {
                        $("#checkslug").attr('class', '');
                        if (response.status === 'error') {
                            $("#eufh_efreeafN_WHRU").removeClass('d-flex');
                            $("#eufh_efreeafN_WHRU").hide();
                        } else {
                            $("#eufh_efreeafN_WHRU").show();
                            $("#eufh_efreeafN_WHRU").addClass('d-flex');
                        }
                        $("#checkslug").addClass(response.class);
                        $("#checkslug").html(response.message);
                    }
                });
            })

            $("#entity_details").change(function(e) {
                e.preventDefault();
                let vale = $(this).val();
                $.ajax({
                    type: "get",
                    url: "{{ route('panel.Entity.get') }}",
                    data: {
                        work: 'getEntityDetails',
                        id: vale
                    },
                    dataType: "JSON",
                    success: function(response) {
                        console.log(response);
                        console.table(response.account_details);
                        $("#entity_bank").empty();

                        if (response.account_details == null) {
                            $("#entity_bank").append(`<option>No Bank Details Found</option>`);
                        }

                        $.each(response.account_details, function(index, value) {
                            let selected = value.default == 1 ? 'selected' : '';
                            $("#entity_bank").append(
                                `<option value="${value.bank_name}" ${selected}>${value.bank_name}</option>`
                            );
                        });




                    }
                });
            });

        });
    </script>










@endsection
