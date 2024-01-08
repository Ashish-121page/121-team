<div class="modal fade" id="addAddressModal" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('customer.address.store') }}" method="post">
            <input type="hidden" name="user_id" value="" id="userId">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Entity</h5>
                    <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close"
                        style="padding: 0px 20px;font-size: 20px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Address Type</label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input id="home" name="type" value="0" type="radio" class="form-check-input"
                                            required="">
                                        <label class="form-check-label" for="home">Entity</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input id="office" name="type" value="1" type="radio" class="form-check-input"
                                            required="">
                                        <label class="form-check-label" for="office">Site</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="">Entity Name</label>
                            <input class="form-control" type="text" name="entity_name" value="{{ old('entity_name') }}" placeholder="Enter Entity Name">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Acronym</label>
                            <input class="form-control" type="text" name="acronym" value="{{ old('acronym') }}" placeholder="Enter Acronym">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">GST Number</label>
                            <input class="form-control" type="text" name="gst_number" value="{{ old('gst_number') }}" placeholder="Enter GST Number">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="">IEC Number</label>
                            <input class="form-control" type="number" name="iec_number" value="{{ old('iec_number') }}" placeholder="Enter IEC Number">
                        </div>

                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="Enter Address" required
                                name="address_1">
                            <div class="invalid-feedback">
                                Please enter your shipping address.
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="address2" class="form-label">Address 2 <span
                                    class="text-muted">(Optional)</span></label>
                            <input type="text" class="form-control" id="address2" placeholder="Enter Address"
                                name="address_2">
                        </div>

                        <div class="col-md-6">
                            <label for="country" class="form-label">Country</label>
                            <select class="form-select form-control select2insidemodal" id="user_country" required name="country">
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
                            <select class="form-select form-control select2insidemodal" required id="user_state" name="state">
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid state.
                            </div>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="state" class="form-label">City</label>
                            <select class="form-select form-control select2insidemodal" id="user_city" required name="city" >
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid state.
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="pincode" class="form-label">Pincode</label>
                            <input type="number" class="form-control" name="pincode" value="{{ old('pincode') }}">
                        </div>


                        <div class="col-md-12 d-flex justify-content-between align-items-center">
                            <h6>Add Account</h6>
                            <button id="add-bank-details" type="button" class="btn btn-primary mt-3">Add Bank Details</button>
                        </div>

                        <div class="col-12">
                            <div id="bank-details-container" class="row">
                                <div class="col-md-6 mt-3">
                                    <label for="bank_name" class="form-label">Bank Name <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" name="bank_name[]" value="{{ old('bank_name') }}" required>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="bank_address" class="form-label">Bank Address <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" name="bank_address[]" value="{{ old('bank_address') }}" required>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="swift_code" class="form-label">Swift Code</label>
                                    <input type="text" class="form-control" name="swift_code[]" value="{{ old('swift_code') }}">
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="account_number" class="form-label">Account Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="account_number[]" value="{{ old('account_number') }}" required>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="account_holder_name" class="form-label">Account Holder Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="account_holder_name[]" value="{{ old('account_holder_name') }}" required>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="account_type" class="form-label">Account Type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="account_type[]" value="{{ old('account_type') }}" required>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="ifsc_code_neft" class="form-label">IFSC Code/NEFT <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" name="ifsc_code_neft[]" value="{{ old('ifsc_code_neft') }}" required>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label for="default" class="form-label">Default</label>
                                    <br>
                                    <input type="checkbox" class="" id="default" name="default[]" value="1">
                                </div>

                            </div>
                        </div>





                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#add-bank-details').click(function() {
            var bankDetails = $('#bank-details-container').html();
            $('#bank-details-container').append(bankDetails);
        });
    });
</script>
