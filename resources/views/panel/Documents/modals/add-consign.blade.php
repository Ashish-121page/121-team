<!-- Modal -->
<div class="modal fade" id="addconsigneeModal" tabindex="-1" role="dialog" aria-labelledby="addconsigneeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('panel.Documents.create.Quotation.consignee') }}" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addconsigneeModalLabel">Add Consignee</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    @csrf
                    {{-- Quote ID --}}
                    <input type="hidden" name="{{ __('quote_id') }}" value="{{ encrypt($QuotationRecord->id) }}">

                    {{-- consignee Details --}}
                    <div class="card col-lg-12 col-md-12" style="height:fit-content;">
                        <div class="card-header mb-3" style="background-color:#f3f3f3">
                            <h6>Consignee Details</h6>
                        </div>

                        <div class="card-body p-0">
                            <div class="form-group">

                                <div class="row">
                                    <div class="col-8" style="display:block; width:100% !important;">
                                        <label for="consigneename">Consignee Name <span
                                                class="text-danger">*</span></label>
                                        <br>
                                        <input class="form-control" type="text" placeholder="Enter"
                                            name="consignee[entity_name]" required>
                                    </div>
                                    <div class="col-4">
                                        <label for="consigneename">Consignee ID</label>
                                        <br>
                                        <input class="form-control" type="text" placeholder="Enter"
                                            name="consignee[ref_id]">
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12" style="display:block; width:100% !important;">
                                        <label for="adrsl1" style="width:100%">Address Line1</label>
                                        <br>
                                        <input class="form-control" type="text" style="width:100%"
                                            name="consignee[address1]" placeholder="Enter">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12" style="display:block; width:100% !important;">
                                        <label for="adrsl2" style="width:100%">Address Line2</label>
                                        <br>
                                        <input class="form-control" type="text" style="width:100%"
                                            name="consignee[address2]" placeholder="Enter">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-4 col-md-6 col-12" style="display:block; width:100% !important;">
                                        <label for="consigneecity" style="width:100%">City</label>
                                        <br>
                                        <input class="form-control" type="text" style="width:100%"
                                            name="consignee[city]" placeholder="Enter">
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-12" style="display:block; width:100% !important;">
                                        <label for="country" style="width:100%">Country</label>
                                        <br>
                                        <select class="form-control select2" id="country" name="consignee[country]"
                                            style="width:100%">
                                            <option value="">Select a country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->name }}">{{ $country->name }}
                                                </option>
                                            @endforeach
                                            <!-- Add more countries as needed -->
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-12" style="display:block; width:100% !important;">
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

                            <div class="row">
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
                    <button type="button" class="btn btn-outline-secondary " data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-outline-primary ">Save changes</button>
                </div>
            </form>

        </div>
    </div>
</div>
