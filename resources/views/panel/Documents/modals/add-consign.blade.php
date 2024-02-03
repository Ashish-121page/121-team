<!-- Modal -->
<div class="modal fade" id="addconsigneeModal" tabindex="-1" role="dialog" aria-labelledby="addconsigneeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('panel.Documents.create.Quotation.consignee') }}" method="POST" id="consginaccess">
                <div class="modal-header">
                    <h5 class="modal-title" id="addconsigneeModalLabel">Add Consignee</h5>
                    {{-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>

                <div class="modal-body">

                    @php
                        $settings = json_decode(auth()->user()->settings);
                    @endphp
                    @csrf
                    {{-- Quote ID --}}
                    <input type="hidden" name="{{ __('quote_id') }}" value="{{ encrypt($QuotationRecord->id) }}">
                    <input type="hidden" name="{{ __('item_id') }}" value="{{ encrypt($QuotationRecord->id) }}" id="consign_item_id">

                    {{-- consignee Details --}}
                    <div class="card col-lg-12 col-md-12" style="height:fit-content;">
                        <div class="card-header mb-3" style="background-color:#f3f3f3">
                            <h6>Consignee Details</h6>
                        </div>

                        <div class="card-body p-0">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-12 mb-3" style="display:block; width:100% !important;">
                                        <label for="consignee_p_id_name"> P ID #
                                            <span class="text-danger">*</span></label>
                                        <br>
                                        <input class="form-control" type="text" placeholder="Enter"
                                            name="consignee[p_id]" required id="consignee_p_id_name"
                                            value="{{ $new_consignee_slug ?? '' }}">
                                        <small class="text-danger mt-2 d-none" id="checkslug">Slug Already Exist</small>
                                    </div>


                                    <div class="col-8" style="display:block; width:100% !important;">
                                        <label for="consigneename">Consignee Name <span
                                                class="text-danger">*</span></label>
                                        <br>
                                        <input class="form-control" type="text" placeholder="Enter" id="consigneename"
                                            name="consignee[entity_name]" required>
                                    </div>
                                    <div class="col-4">
                                        <label for="consigneref_id">Consignee ID</label>
                                        <br>
                                        <input class="form-control" type="text" placeholder="Enter" id="consigneref_id"
                                            name="consignee[ref_id]">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12" style="display:block; width:100% !important;">
                                        <label for="adrsl1" style="width:100%">Address Line1</label>
                                        <br>
                                        <input class="form-control" type="text" style="width:100%" id="adrsl1"
                                            name="consignee[address1]" placeholder="Enter">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12" style="display:block; width:100% !important;">
                                        <label for="adrsl2" style="width:100%">Address Line2 (optional)</label>
                                        <br>
                                        <input class="form-control" type="text" style="width:100%" id="adrsl2"
                                            name="consignee[address2]" placeholder="Enter">
                                    </div>
                                </div>


                                <div class="row mt-3">
                                    <div class="col-lg-6 col-md-6 col-12" style="display:block; width:100% !important;">
                                        <label for="country" style="width:100%">Country</label>
                                        <br>
                                        <select class="form-control select2" id="country" name="consignee[country]"
                                            style="width:100%">
                                            <option value="" data-db_r="none">Select a country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}" data-db_r="{{ $country->id }}">{{ $country->name }}
                                                </option>
                                            @endforeach
                                            <!-- Add more countries as needed -->
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="state" class="form-label">State</label>
                                        <select class="form-select form-control select2insidemodal" required id="state" name="consignee[state]">
                                        </select>
                                        <div class="invalid-feedback">
                                            Please provide a valid state.
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-12 mt-3" style="display:block; width:100% !important;">
                                        <label for="city" style="width:100%">City</label>
                                        <br>
                                        {{-- <select class="form-select form-control select2insidemodal" required id="city" name="consignee[city]">
                                        </select> --}}
                                        <input class="form-control" type="text" style="width:100%" id="consigneecity"
                                            name="consignee[city]" placeholder="Enter">
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12 mt-3" style="display:block; width:100% !important;">
                                        <label for="pincode">pincode</label>
                                        <br>
                                        <input class="form-control" name="consignee[pincode]" id="pincode"
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

                            <div class="row" id="appendpersoncong">
                                <div class="col-lg-4 col-md-6 col-12 mb-3"
                                    style="display:block; width:100% !important;">
                                    <label for="consigneename">Person Name</label>
                                    <br>
                                    <input class="form-control" type="text" placeholder="Enter"
                                        name="consignee_person_name[]">
                                </div>

                                <div class="col-lg-4 col-md-6 col-12 mb-3">
                                    <label for="consigneemail">Email</label>
                                    <br>
                                    <input class="form-control" type="text" placeholder="Enter"
                                        name="consignee_person_email[]">
                                </div>

                                <div class="col-lg-4 col-md-6 col-12 mb-3">
                                    <label for="consigneemail">Contact Number</label>
                                    <br>
                                    <input class="form-control" type="text" placeholder="Enter"
                                        name="consignee_person_contact[]">
                                </div>
                            </div>


                        </div>
                    </div>


                </div> {{-- modal body end --}}

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel </button>
                    <button type="submit" class="btn btn-outline-primary" name="newrec" id="new_rec_btn">Save changes</button>
                    <button type="submit" class="btn btn-outline-primary d-none" name="updaterec" id="updaterec_btn">Save Record</button>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    var Quote_num = $("#consignee_p_id_name");

    Quote_num.on('input', function() {
        $("#checkslug").removeClass("d-none");

        $.ajax({
            type: "get",
            url: "{{ route('panel.Documents.Quotation.check.slug') }}",
            data: {
                slug: Quote_num.val()
            },
            dataType: "JSON",
            success: function(response) {
                $("#checkslug").attr('class', '');
                $("#checkslug").addClass(response.class);
                $("#checkslug").html(response.message);
            }
        });
    })


    // $("#country").change(function (e) {
    //     e.preventDefault();
    //     let country = $(this).find(':selected').data('db_r');
    //     if (country) {
    //         getStateAsync(country).then(function(data) {
    //             $('#user_state').val(state).change();
    //             $('#user_state').trigger('change').select2();
    //         });
    //     }
    //     // setTimeout(function() {
    //     //     if (city) {
    //     //         getCityAsync(state).then(function(data) {
    //     //             $('#consigneecity').val(city).trigger('change');
    //     //             $('#consigneecity').trigger('change').select2();
    //     //         });
    //     //     }
    //     // }, 300);
    // });
</script>
