@extends('backend.layouts.main')
@section('title', 'secondview')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
        <style>
            .row {
                width: 100% !important;
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
            <form action="{{ route('panel.Documents.create.Quotation') }}" method="POST" enctype="multipart/form-data">

                <div class="col-12">
                    <div class="row">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <button class="btn btn-secondary" onclick="goBack()" value="Back"
                                            type="button">Back</button>
                                        <h5 class="ms-3 mt-5 mb-0 quotation_number_sync"
                                            style="margin-left: 50px !important;">
                                            PI-231</h5>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-4 d-flex justify-content-end align-items-center">

                            <button type="submit" class="btn btn-outline-secondary mx-2" name="submitdraft">Save as
                                Draft</button>
                            <button type="submit" class="btn btn-outline-secondary mx-2">Next</button>

                            {{-- <button type="button" onclick="proceedTothirdView()" class="btn btn-primary" id="submit1"
                                data-bs-target="">
                                Next
                            </button> --}}
                        </div>
                    </div>
                </div>


                <div class="col-12">
                    <div class="row d-flex justify-content-center">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <div class="container-fluid">
                                <ul class="navbar-nav">
                                    <li class="nav-item mx-3">
                                        <a class="nav-link active" href="#">1.Add Details</a>
                                    </li>
                                    <li class="nav-item mx-3">
                                        <a class="nav-link" href="#">2. Select Items</a>
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

                {{-- ` Main Form Conatiner --}}
                <div class="col-12">

                    <div class="row mt-3 d-flex justify-content-center">
                        <div class="card col-lg-4">
                            <div class="card-body" style="padding: 0px 20px ">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="row justify-content-between">
                                            {{-- Exporter Details --}}
                                            <div class="card col-lg-12 col-md-12" style="height:fit-content;">
                                                <div class="card-header d-flex justify-content-between  align-items-center "
                                                    style="background-color:#f3f3f3">
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
                                                                <option value="{{ $entity->id }}">
                                                                    {{ json_decode($entity->details)->entity_name ?? '' }}
                                                                </option>
                                                            @empty
                                                                <option>No saved entities found</option>
                                                            @endforelse
                                                        </select>
                                                    </div>



                                                    <div class="form-group mb-3">
                                                        <label for="entity_bank" class="text-danger"> Select Bank <span
                                                                class="text-danger">*</span></label>
                                                        <select name="entity_bank" class="form-control select2"
                                                            id="entity_bank" name="entity_details[bankname]" required>
                                                            <option>No saved entities found</option>
                                                        </select>
                                                    </div>


                                                </div>
                                            </div>

                                            <div class="card col-lg-12 col-md-12" style="height:15rem;">
                                                <div class="card-header " style="background-color:#f3f3f3">
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
                                                                class="form-control"></textarea>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>



                                            <div class="card col-lg-12 col-md-12" style="height:15rem;">
                                                <div class="card-header " style="background-color:#f3f3f3">
                                                    <h6>Consignee Details</h6>
                                                    <!-- <a href="#" class="btn btn-link">Edit</a> -->
                                                </div>
                                                <div class="card-body">

                                                </div>
                                            </div>




                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>


                        {{-- invoice details --}}
                        <div class="card col-lg-8">

                            <div class="row">

                                {{-- Person Details --}}
                                <div class="card col-lg-12 col-md-12" style="height:fit-content;">

                                    <div class="card-header mb-3" style="background-color:#f3f3f3">
                                        <h6>Quotation Details</h6>
                                    </div>

                                    <div class="card-body p-0">

                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-12 mb-3"
                                                style="display:block; width:100% !important;">
                                                <label for="quotation_number">Quotation Number <span
                                                        class="text-danger">*</span> </label>
                                                <br>
                                                <input class="form-control" id="quotation_number"
                                                    name="quotation[number]" type="text" placeholder="Enter"
                                                    value="{{ $quotation_number }}" required>
                                                <small id="checkslug" class="d-none">Slug Exist</small>
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-12 mb-3">
                                                <label for="buyermail">Quotation Date <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control" type="date" value="{{ date('Y-m-d') }}"
                                                    name="quotation[date]" required>
                                            </div>


                                            <div class="col-lg-4 col-md-6 col-12 mb-3">
                                                <label for="buyermail">Delivery Date</label>
                                                <input class="form-control" type="date"
                                                    name="quotation[delivery_date]">
                                            </div>


                                            <div class="col-lg-6 col-md-6 col-12 mb-3">
                                                <label for="buyermail">Currency <span class="text-danger">*</span></label>
                                                <br>

                                                <select class="form-control select2" name="quotation[currency]"
                                                    id="currency" required>
                                                    @forelse ($currency as $curr)
                                                        <option value="{{ $curr->currency }}"
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
                                                <input class="form-control" type="number" placeholder="Enter"
                                                    name="quotation[exchange]">
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-12 mb-3">
                                                <label for="buyermail">Terms of Delivery</label>
                                                <select class="form-control select2" id="term_of_delivery"
                                                    name="quotation[term_of_delivery]">
                                                    @forelse ($terms_of_delivery as $term_of_del)
                                                        <option value="{{ $term_of_del }}">{{ $term_of_del }}</option>
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
                                                    name="quotation[port_of_loading]">
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-12 mb-3">
                                                <label for="buyermail">Port of Discharge</label>
                                                <input class="form-control" type="text" placeholder="Enter"
                                                    name="quotation[port_of_discharge]">
                                            </div>

                                            <div class="col-lg-12 col-md-6 col-12 mb-3">
                                                <label for="buyermail">Payment Terms</label>
                                                <textarea class="form-control" placeholder="Enter" name="quotation[payment_term]"></textarea>
                                            </div>

                                        </div>


                                    </div>
                                </div>

                                {{-- Buyer Details --}}
                                <div class="card col-lg-12 col-md-12" style="height:fit-content;">

                                    <div class="card-header mb-3" style="background-color:#f3f3f3">
                                        <h6>Buyer Details</h6>
                                    </div>

                                    <div class="card-body p-0">
                                        <div class="form-group">

                                            <div class="row">
                                                <div class="col-8" style="display:block; width:100% !important;">
                                                    <label for="buyername">Entity Name <span
                                                            class="text-danger">*</span></label>
                                                    <br>
                                                    <input class="form-control" type="text" placeholder="Enter"
                                                        name="buyer[entity_name]" required>
                                                </div>
                                                <div class="col-4">
                                                    <label for="buyername">ID</label>
                                                    <br>
                                                    <input class="form-control" type="text" placeholder="Enter"
                                                        name="buyer[ref_id]">
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-12" style="display:block; width:100% !important;">
                                                    <label for="adrsl1" style="width:100%">Address Line1</label>
                                                    <br>
                                                    <input class="form-control" type="text" style="width:100%"
                                                        name="buyer[address1]" placeholder="Enter">
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-12" style="display:block; width:100% !important;">
                                                    <label for="adrsl2" style="width:100%">Address Line2</label>
                                                    <br>
                                                    <input class="form-control" type="text" style="width:100%"
                                                        name="buyer[address2]" placeholder="Enter">
                                                </div>
                                            </div>
                                            <div class="row mt-3">

                                                <div class="col-lg-4 col-md-6 col-12"
                                                    style="display:block; width:100% !important;">
                                                    <label for="buyercity" style="width:100%">City</label>
                                                    <br>
                                                    <input class="form-control" type="text" style="width:100%"
                                                        name="buyer[city]" placeholder="Enter">
                                                </div>

                                                <div class="col-lg-4 col-md-6 col-12"
                                                    style="display:block; width:100% !important;">
                                                    <label for="country" style="width:100%">Country</label>
                                                    <br>
                                                    <select class="form-control select2" id="country"
                                                        name="buyer[country]" style="width:100%">
                                                        <option value="">Select a country</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->name }}">{{ $country->name }}
                                                            </option>
                                                        @endforeach
                                                        <!-- Add more countries as needed -->
                                                    </select>
                                                </div>
                                                <div class="col-lg-4 col-md-6 col-12"
                                                    style="display:block; width:100% !important;">
                                                    <label for="pincode">pincode</label>
                                                    <br>
                                                    <input class="form-control" name="buyer[pincode]" id="pincode"
                                                        type="text" placeholder="Enter">
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>


                                {{-- Person Details --}}
                                <div class="card col-lg-12 col-md-12" style="height:fit-content;">

                                    <div class="card-header mb-3" style="background-color:#f3f3f3">
                                        <h6>Contact Person</h6>
                                    </div>

                                    <div class="card-body p-0">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-12 mb-3"
                                                style="display:block; width:100% !important;">
                                                <label for="buyername">Person Name</label>
                                                <br>
                                                <input class="form-control" type="text" placeholder="Enter"
                                                    name="person_name[]">
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-12 mb-3">
                                                <label for="buyermail">Email</label>
                                                <br>
                                                <input class="form-control" type="text" placeholder="Enter"
                                                    name="person_email[]">
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-12 mb-3">
                                                <label for="buyermail">Contact Number</label>
                                                <br>
                                                <input class="form-control" type="text" placeholder="Enter"
                                                    name="person_contact[]">
                                            </div>
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
                        console.log(response);
                        $("#checkslug").attr('class', '');
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
