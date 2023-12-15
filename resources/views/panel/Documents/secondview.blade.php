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
                <h1>Invoice & Quotations</h1>
            </div>
        </div>

        <!-- upper fields -->
        <div class="row mt-3">

            <div class="row">
                <div class="col-8">
                    <div class="row">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <button class="btn btn-secondary" onclick="goBack()" value="Back"
                                    type="button">Back</button>
                                <h5 class="ms-3 mt-5 mb-0" style="margin-left: 50px !important;">PI-231</h5>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-4 d-flex justify-content-end align-items-center">
                    <button type="button" onclick="proceedTothirdView()" class="btn btn-primary" id="submit1"
                        data-bs-target="">
                        Next
                    </button>
                </div>
            </div>
            <div class="row">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">1.Add Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">2. Confirm the Products</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Generate</a>
                            </li>
                            <!-- Add more steps as needed -->
                        </ul>
                    </div>
                </nav>

            </div>

            <div class="row mt-3">
                <div class="card col-lg-3 col-md-4">
                    <div class="card-body" style="padding: 0px 20px ">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="row justify-content-between">
                                  {{-- Exporter Details --}}
                                    <div class="card col-lg-12 col-md-12" style="height:fit-content;">
                                      <div class="card-header" style="background-color:#f3f3f3">
                                          <h6>Exporter Details</h6>
                                      </div>
                                      <div class="card-body" id="cardBody">
                                          <div class="form-group w-100">
                                              <div class="row">
                                                  <div class="" style="display:block; width:100% !important;">

                                                      <label for="expotername" style="width:100%">Exporter Name</label>
                                                      <br>
                                                      <input type="text" style="width:100%" placeholder="Enter">

                                                  </div>
                                              </div>
                                              <div class="row mt-3">
                                                  <div class="" style="display:block; width:100% !important;">
                                                      <label for="expotername" style="width:100%">Email id</label>
                                                      <br>
                                                      <input type="text" style="width:100%" placeholder="Enter">
                                                  </div>
                                              </div>

                                              <div class="row mt-3">
                                                  <div class="" style="display:block; width:100% !important;">
                                                      <label for="expotername" style="width:100%">Other Reference</label>
                                                      <br>
                                                      <input type="text" style="width:100%" placeholder="Enter">
                                                  </div>
                                              </div>
                                              <div class="row mt-3">
                                                  <div class="" style="display:block; width:100% !important;">
                                                      <label for="expotername" style="width:100%">Address</label>
                                                      <br>
                                                      <input type="text" style="width:100%" placeholder="Enter">
                                                  </div>
                                              </div>
                                              <div class="row mt-3">
                                                  <div style="display:block ;width:100% !important;">
                                                      <label for="country" style="width:100%">Country</label>
                                                      <br>
                                                      <select id="country" name="country" style="width:100%">
                                                          <option value="">Select a country</option>
                                                          <option value="India">India</option>
                                                          <option value="United States">United States</option>
                                                          <option value="China">China</option>
                                                          <option value="United Kingdom">United Kingdom</option>

                                                      </select>
                                                  </div>

                                              </div>
                                              <div class="row mt-3">
                                                  <div class="" style="display:block; width:100% !important;">
                                                      <label for="expotername" style="width:100%">Exporter Reference
                                                          Id(IEC Code)</label>
                                                      <br>
                                                      <input type="text" style="width:100%" placeholder="Enter">
                                                  </div>
                                              </div>
                                          </div>
                                          <!-- <div class="modal-footer d-flex justify-content-between">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                          <button type="button" class="btn btn-primary ml-auto">Proceed</button>
                                        </div> -->
                                      </div>
                                    </div>
                                    {{-- Buyer Details --}}
                                    <div class="card col-lg-12 col-md-12" style="height:fit-content;">
                                      <div class="card-header" style="background-color:#f3f3f3">
                                        <h6>Buyer Details</h6>
                                        <!-- <a href="#" class="btn btn-link">Edit</a> -->
                                      </div>
                                      <div class="card-body">
                                          <div class="form-group w-100">
                                            <div class="row">
                                              <div class="" style="display:block; width:100% !important;">
                                
                                                <label for="buyername" style="width:100%">Name</label>
                                                <br>
                                                <input type="text" style="width:100%" placeholder="Enter">
                                
                                              </div>
                                            </div>
                                            <div class="row mt-3">
                                              <div class="" style="display:block; width:100% !important;">
                                                <label for="buyermail" style="width:100%">Email</label>
                                                <br>
                                                <input type="text" style="width:100%" placeholder="Enter">
                                              </div>
                                            </div>
                                
                                            <div class="row mt-3">
                                              <div class="" style="display:block; width:100% !important;">
                                                <label for="adrsl1" style="width:100%">Address Line1</label>
                                                <br>
                                                <input type="text" style="width:100%" placeholder="Enter">
                                              </div>
                                            </div>
                                            <div class="row mt-3">
                                              <div class="" style="display:block; width:100% !important;">
                                                <label for="adrsl2" style="width:100%">Address Line2</label>
                                                <br>
                                                <input type="text" style="width:100%" placeholder="Enter">
                                              </div>
                                            </div>
                                            <div class="row mt-3">
                                              <div class="" style="display:block; width:100% !important;">
                                                <label for="buyercity" style="width:100%">City</label>
                                                <br>
                                                <input type="text" style="width:100%" placeholder="Enter">
                                              </div>
                                            </div>
                                            <div class="row mt-3">
                                              <div style="display:block; width:100% !important;">
                                                <label for="country" style="width:100%">Country</label>
                                                <br>
                                                <select id="country" name="country" style="width:100%">
                                                    <option value="">Select a country</option>
                                                    <option value="India">India</option>
                                                    <option value="United States">United States</option>
                                                    <option value="China">China</option>
                                                    <option value="United Kingdom">United Kingdom</option>
                                                    <!-- Add more countries as needed -->
                                                </select>
                                            </div>
                                            
                                            </div>
                                          </div>              
                                        <!-- <div class="modal-footer d-flex justify-content-between">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                          <button type="button" class="btn btn-primary ml-auto">Proceed</button>
                                        </div> -->                                    
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
                <div class="card col-lg-8 col-md-8">
                    <div class="card-header" style="background-color:#f3f3f3">
                        <h6>Invoice Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-lg-4 col-4">
                                <div class="form-group ">
                                    <label for="base_currency" class="control-label">Proforma Number </label>
                                    <input class="form-control" name="base_currency" type="text" id="base_currency"
                                        value="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-4">
                                <div class="form-group ">
                                    <label for="selling_price_unit" class="control-label">Buyer PO Number</label>
                                    <input class="form-control" name="selling_price_unit" type="text"
                                        id="selling_price_unit" value="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-4">
                                <div class="form-group">
                                    <label for="min_sell_pr_without_gst" class="control-label">Vessel/Flight no</label>
                                    <input class="form-control" name="min_sell_pr_without_gst" type="number"
                                        id="min_sell_pr_without_gst" value="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-4">
                                <div class="form-group ">
                                    <label for="dateinvoice" class="control-label">Date of invoice</label>
                                    <input class="form-control" name="dateinvoice" type="date" id="dateinvoice"
                                        value="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-4">
                                <div class="form-group ">
                                    <label for="reseller_group" class="control-label">Port of Loading </label>
                                    <input class="form-control" name="reseller_group" type="number" id="reseller_group"
                                        value="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-4">
                                <div class="form-group ">
                                    <label for="mrp" class="control-label">Port of Discharge</label>
                                    <input class="form-control" name="mrp" type="number" id="mrp"
                                        value="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-4">
                                <div class="form-group ">
                                    <label for="mrp" class="control-label">Payment
                                        Terms</label>
                                    <input class="form-control" name="mrp" type="number" id="mrp"
                                        value="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-4">
                                <div class="form-group ">
                                    <label for="mrp" class="control-label">Terms of
                                        Delivery</label>
                                    <input class="form-control" name="mrp" type="number" id="mrp"
                                        value="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-4">
                                <div class="form-group ">
                                    <label for="mrp" class="control-label">Delivery
                                        Date</label>
                                    <input class="form-control" name="mrp" type="number" id="mrp"
                                        value="">
                                </div>
                            </div>
                            <div class="col-lg-4 col-4">
                                <div class="form-group ">
                                    <div style="display:block">
                                        <label for="country1" style="width:100%">Country of Origin</label>
                                        <br>
                                        <select id="country1" class="form-control" name="countryorigin"
                                            style="width:100%">
                                            <option value=""></option>
                                            <option value="India">India</option>
                                            <option value="United States">United States</option>
                                            <option value="China">China</option>
                                            <option value="United Kingdom">United Kingdom</option>
                                            <!-- Add more countries as needed -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-4">
                                <div class="form-group ">

                                    <label for="country2" class="contro-label" style="width:100%">Country of
                                        Destination</label>
                                    <br>
                                    <select id="country2" class="form-control" name="countrydest" style="width:100%">
                                        <option value=""></option>
                                        <option value="India">India</option>
                                        <option value="United States">United States</option>
                                        <option value="China">China</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <!-- Add more countries as needed -->
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                          <div class="card col-lg-12 col-md-12">
                            <div class="card-header" style="background-color:#f3f3f3">
                              <h6>Bank Details</h6>
                            </div>
                            <div class="card-body">
                              <div class="form-group w-100">
                                  <div class="row mt-3">
                                      <div class="col-md-6">
                                          <label for="bankname" class="form-label">Bank name</label>
                                      </div>
                                      <div class="col-md-6">
                                          <input type="text" class="form-control" style="width:100%"
                                              placeholder="Enter">
                                      </div>
                                  </div>


                                  <div class="row mt-3">
                                      <div class="col-md-6">
                                          <label for="accnum" class="form-label">Account Number</label>
                                      </div>
                                      <div class="col-md-6">
                                          <input type="text" class="form-control" style="width:100%"
                                              placeholder="Enter">
                                      </div>
                                  </div>
                                  <div class="row mt-3">
                                      <div class="col-md-6">
                                          <label for="Ifsccode" class="form-label">IFSC Code</label>
                                      </div>
                                      <div class="col-md-6">
                                          <input type="text" class="form-control" style="width:100%"
                                              placeholder="Enter">
                                      </div>
                                  </div>
                                  <div class="row mt-3">
                                      <div class="col-md-6">
                                          <label for="swiftcode" class="form-label">SWIFT Code</label>
                                      </div>
                                      <div class="col-md-6">
                                          <input type="text" class="form-control" style="width:100%"
                                              placeholder="Enter">
                                      </div>
                                  </div>
                                  <div class="row mt-3">
                                      <div class="col-md-6">
                                          <label for="bankaddrss" class="form-label">Address</label>
                                      </div>
                                      <div class="col-md-6">
                                          <input type="text" class="form-control" style="width:100%"
                                              placeholder="Enter">
                                      </div>
                                  </div>
                                  <div class="row mt-3">
                                      <div class="col-md-6">
                                          <label for="country" class="form-label">Country</label>
                                      </div>
                                      <div class="col-md-6">
                                          <select id="country" class="form-control" name="country"
                                              style="width:100%">
                                              <option value="">Select a country</option>
                                              <option value="India">India</option>
                                              <option value="United States">United States</option>
                                              <option value="China">China</option>
                                              <option value="United Kingdom">United Kingdom</option>
                                              <!-- Add more countries as needed -->
                                          </select>
                                      </div>
                                  </div>
                              </div>
                            </div>
                          </div>
                      </div>
                    </div>
                    {{-- bank details --}}                                             
                </div>

            </div>
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
    </script>

@endsection
