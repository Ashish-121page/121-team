<div class="modal fade" id="editAddressModal" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('customer.address.update') }}" method="post">
            <input type="hidden" name="id" value="" id="id">
            <input type="hidden" name="user_id" value="" id="user_id">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Update Address</h5>
                    <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close"
                        style="padding: 0px 20px;font-size: 20px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-check">
                                <input id="homeEdit" name="type" value="0" type="radio" class="form-check-input homeInput"
                                    required="">
                                <label class="form-check-label" for="homeEdit">Billing</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input id="officeEdit" name="type" value="1" type="radio" class="form-check-input officeInput"
                                    required="">
                                <label class="form-check-label" for="officeEdit">Delivery</label>
                            </div>
                        </div>
                        <div class="col-12 my-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address_1" placeholder="1234 Main St" required name="address_1">
                            <div class="invalid-feedback">
                                Please enter your shipping address.
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="address2" class="form-label">Address 2 <span
                                    class="text-muted">(Optional)</span></label>
                            <input type="text" class="form-control" id="address_2" placeholder="Apartment or suite"
                                name="address_2">
                        </div>

                        <div class="col-md-6 mb-3">
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
                       
                        <div class="col-md-6 mb-3">
                            <label for="state" class="form-label">State</label>
                            <select class="form-select form-control select2insidemodaledit" id="stateEdit" name="state">
                                {{-- <option value="">MP</option> --}}
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid state.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="state" class="form-label">City</label>
                            <select class="form-select form-control select2insidemodaledit" id="cityEdit" name="city" >
                                {{-- <option value="">Seoni</option> --}}
                            </select>
                            <div class="invalid-feedback">
                                Please provide a valid state.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="pincode" class="form-label">Pincode</label>
                            <input type="number" class="form-control" name="pincode" id="pincode" value="{{ old('pincode') }}">
                        </div>
                        <div class="col-lg-6 col-md-6 col-6 mt-3">
                            <label for="">GST Number</label>
                            <input class="form-control" type="text" name="gst_number" id="gstNumber" value="" placeholder="Enter GST Number">
                        </div>
                        <div class="col-lg-6 col-md-6 col-6 mt-3">
                            <label for="">Entity Name</label>
                            <input class="form-control" type="text" name="entity_name" id="entityName" value="" placeholder="Enter Entity Name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>


