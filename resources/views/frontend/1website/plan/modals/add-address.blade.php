<div class="modal fade" id="addAddressModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Address</h5>
                    <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close"
                        style="padding: 0px 20px;font-size: 20px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="address" class="form-label">Address Type</label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input id="home" name="type" value="0" type="radio" class="form-check-input"
                                            checked >
                                        <label class="form-check-label" for="home">Billing</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input id="office" name="type" value="1" type="radio" class="form-check-input"
                                            >
                                        <label class="form-check-label" for="office">Delivery</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        

                        <div class="col-lg-6 col-md-6 col-6 mt-3 d-none">
                            <div class="form-group">
                                <label for="">UserID <span class="text-danger">*</span> </label>
                                <input type="text" name="user_id" value="{{ auth()->id() }}" id="" class="form-control">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-6 mt-3">
                            <div class="form-group">
                                <label for="">GST Number <span class="text-danger">*</span> </label>
                                <input class="form-control" type="text" name="gst_number" id="gst_number"
                                    value="{{ old('gst_number')  }}" placeholder="Enter GST Number" >
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-6 mt-3">
                            <div class="form-group">
                                <label for="">Entity Name <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="entity_name"
                                    value="{{ old('entity_name') }}" placeholder="Enter Entity Name" >
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="address" placeholder="Enter Address" 
                                name="address_1">
                            <div class="invalid-feedback">
                                Please enter your shipping address.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="address2" class="form-label">Address 2 <span
                                    class="text-muted">(Optional)</span></label>
                            <input type="text" class="form-control" id="address2" placeholder="Enter Address"
                                name="address_2">
                        </div>

                        <div class="col-md-6">
                            <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                            <select class="form-select form-control select2insidemodal" id="country" 
                                name="country">
                                @foreach (\App\Models\Country::all() as $country)
                                <option value="{{ $country->id }}" @if ($user->country != null)
                                    {{ $country->id == $user->country ? 'selected' : '' }} @elseif($country->name ==
                                    'India') selected @endif>
                                    {{ $country->name }}</option>
                                @endforeach

                            </select>
                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                            <select class="form-select form-control select2insidemodal"  id="state"
                                name="state">
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid state.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="state" class="form-label">City <span class="text-danger">*</span></label>
                            <select class="form-select form-control select2insidemodal select2" id="city"  name="city">
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid state.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="pincode" class="form-label">Pincode <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="pincode" value="{{ old('pincode') }}"
                                >
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="submitaddress">Save changes</button>
                </div>
            </div>
    </div>
</div>
