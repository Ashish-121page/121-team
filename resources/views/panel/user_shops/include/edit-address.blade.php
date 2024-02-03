<div class="modal fade" id="editAddressModal" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <form action="{{ route('customer.address.update') }}" method="post">
            <input type="hidden" name="id" value="" id="id">
            <input type="hidden" name="user_id" value="" id="user_id">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Update Address</h5>
                    {{-- <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close"
                        style="padding: 0px 20px;font-size: 20px;">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6" style="border-right: 1px solid #6666cccc;">

                            <div class="col-12 mb-3">
                                <div class="row" style="background-color:#f3f3f3; padding: 7px;">
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input id="homeEdit" name="type" value="0" type="radio" class="form-check-input homeInput"
                                        required="">
                                    <label class="form-check-label" for="homeEdit" style="margin-top: 3px;">Entity</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input id="officeEdit" name="type" value="1" type="radio" class="form-check-input officeInput"
                                        required="">
                                    <label class="form-check-label" for="officeEdit" style="margin-top: 3px;">Site</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- add address format --}}

                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="">Entity Name</label>
                                        <input class="form-control" type="text" name="entity_name" id="entityName" value="" placeholder="Enter Entity Name">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="">Acronym</label>
                                        <input class="form-control" type="text" name="acronym" id="acronym" value="" placeholder="Enter Acronym">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="">GST Number</label>
                                        <input class="form-control" type="text" name="gst_number" id="gstNumber" value="" placeholder="Enter GST Number">
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="">IEC Number</label>
                                        <input class="form-control" type="text" name="iec_number" id="iec_number" value="" placeholder="Enter IEC Number">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address_1" placeholder="1234 Main St" required name="address_1">
                                        <div class="invalid-feedback">
                                            Please enter your shipping address.
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="address2" class="form-label">Address 2 <span class="text-muted">(Optional)</span></label>
                                    <input type="text" class="form-control" id="address_2" placeholder="Apartment or suite" name="address_2">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="country" class="form-label">Country</label>
                                        <select class="form-select form-control select2insidemodaledit" id="countryEdit" required name="country">
                                            @foreach (\App\Models\Country::all() as $country)
                                                <option value="{{ $country->id }}"
                                                    @if ($user->country != null) {{ $country->id == $user->country ? 'selected' : '' }} @elseif($country->name == 'India') selected @endif>
                                                    {{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a valid country.
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="state" class="form-label">State</label>
                                        <select class="form-select form-control select2insidemodaledit" id="stateEdit" name="state">
                                        </select>
                                        <div class="invalid-feedback">
                                            Please provide a valid state.
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mt-3">
                                        <label for="state" class="form-label">Area</label>
                                        <select class="form-select form-control select2insidemodaledit" id="cityEdit" name="city" >
                                        </select>
                                        <div class="invalid-feedback">
                                            Please provide a valid state.
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="pincode" class="form-label">Pincode</label>
                                        <input type="number" class="form-control" name="pincode" id="pincode" value="{{ old('pincode') }}">
                                    </div>
                                </div>
                            </div>
                            {{-- format end --}}
                        </div>


                        <div class="col-lg-6">
                            <div class="col-md-12 ">
                                <div class="row" style="background-color:#f3f3f3; padding: 4px;">
                                    <div class="col-12">
                                        <h6 class="">Bank Accounts</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div id="jhsdgbjh" class="d-none">
                                    <div class="col-md-6 mt-3">
                                        <label for="bank_name" class="form-label">Bank Name <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="bank_name[]" >
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="bank_address" class="form-label">Bank Address <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="bank_address[]" >
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="swift_code" class="form-label">Swift Code</label>
                                        <input type="text" class="form-control" name="swift_code[]" >
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="account_number" class="form-label">Account Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="account_number[]">
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="account_holder_name" class="form-label">Account Holder Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="account_holder_name[]" >
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="account_type" class="form-label">Account Type <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="account_type[]" >
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="ifsc_code_neft" class="form-label">IFSC Code/NEFT <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="ifsc_code_neft[]">
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label for="default" class="form-label">Default</label>
                                        <br>
                                        <input type="checkbox" class="" id="default" name="default[]" value="1">
                                        <button type="button" class=" btn btn-link mt-3" onclick="appenddata()">Add Bank Details</button>
                                    </div>
                                </div>
                                <div id="bank-details-container_1" class="row">

                                </div>

                                <div id="bank-details-container_3" class="row">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary " data-bs-dismiss="modal" >Close</button>
                    <button type="submit" class="btn btn-outline-primary">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    function appenddata() {
        var bankDetails = $('#jhsdgbjh').html();
        $('#bank-details-container_3').append(bankDetails);
    }
</script>


