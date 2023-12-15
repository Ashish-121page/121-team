@extends('backend.layouts.main') 
@section('title', 'secondview')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
    <style>
      .row{
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
                    <button class="btn btn-secondary" type="button">Back</button>
                    <h5 class="ms-3 mb-0">PI-231</h5>
                  </div>
                </div>
              </div>
              
            </div>
            <div class="col-4 d-flex justify-content-end align-items-center">
              <button type="button" onclick="proceedTothirdView()" class="btn btn-primary" id="submit1" data-bs-target="">
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
    
          <div class="row mt-3 ">
            <div class="card ">
    
              <div class="card-body">
                <div class="row">
    
                  <div class="col-lg-4 col-4">
                    <div class="form-group ">
                      <label for="base_currency" class="control-label">Proforma Number </label>
                      <input class="form-control" name="base_currency" type="text" id="base_currency" value="">
                    </div>
                  </div>
                  <div class="col-lg-4 col-4">
                    <div class="form-group ">
                      <label for="selling_price_unit" class="control-label">Buyer PO Number</label>
                      <input class="form-control" name="selling_price_unit" type="text" id="selling_price_unit" value="">
                    </div>
                  </div>
                  <div class="col-lg-4 col-4">
                    <div class="form-group">
                      <label for="min_sell_pr_without_gst" class="control-label">Vessel/Flight no</label>
                      <input class="form-control" name="min_sell_pr_without_gst" type="number" id="min_sell_pr_without_gst"
                        value="">
                    </div>
                  </div>
    
    
    
                  <div class="col-lg-4 col-4">
                    <div class="form-group ">
                      <label for="dateinvoice" class="control-label">Date of invoice</label>
                      <input class="form-control" name="dateinvoice" type="date" id="dateinvoice" value="">
                    </div>
                  </div>
                  <div class="col-lg-4 col-4">
                    <div class="form-group ">
                      <label for="reseller_group" class="control-label">Port of Loading </label>
                      <input class="form-control" name="reseller_group" type="number" id="reseller_group" value="">
                    </div>
                  </div>
                  <div class="col-lg-4 col-4">
                    <div class="form-group ">
                      <label for="mrp" class="control-label">Port of Discharge</label>
                      <input class="form-control" name="mrp" type="number" id="mrp" value="">
                    </div>
                  </div>
    
    
    
    
    
                  <div class="col-lg-6">
    
                  </div>
    
    
    
    
                </div>
              </div>
            </div>
          </div>
    
          <div class="row mt-5">
            <div class="card">
              <div class="card-body">
                  <div class="row">
                    <div class="col-lg-8">
                      <div class="row justify-content-between">
                        
                        <div class="card col-lg-6" style="height:fit-content;">
                          <div class="card-header " style="background-color:#f3f3f3">
                            <h6>Exporter Details</h6>
                          </div>
                          <div class="card-body" id="cardBody">  
                            
                            
                                <div class="form-group w-100">
                                  <div class="row">
                                    <div class="" style="display:block">
                      
                                      <label for="expotername" style="width:100%">Exporter Name</label>
                                      <br>
                                      <input type="text" style="width:100%" placeholder="Enter">
                      
                                    </div>
                                  </div>
                                  <div class="row mt-3">
                                    <div class="" style="display:block">
                                      <label for="expotername" style="width:100%">Email id</label>
                                      <br>
                                      <input type="text" style="width:100%" placeholder="Enter">
                                    </div>
                                  </div>
                      
                                  <div class="row mt-3">
                                    <div class="" style="display:block">
                                      <label for="expotername" style="width:100%">Other Reference</label>
                                      <br>
                                      <input type="text" style="width:100%" placeholder="Enter">
                                    </div>
                                  </div>
                                  <div class="row mt-3">
                                    <div class="" style="display:block">
                                      <label for="expotername" style="width:100%">Address</label>
                                      <br>
                                      <input type="text" style="width:100%" placeholder="Enter">
                                    </div>
                                  </div>
                                  <div class="row mt-3">
                                    <div style="display:block">
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
                                    <div class="" style="display:block">
                                      <label for="expotername" style="width:100%">Exporter Reference Id(IEC Code)</label>
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
    
    
                        <div class="card col-lg-6" style="height:fit-content;">
                          <div class="card-header" style="background-color:#f3f3f3">
                            <h6>Buyer Details</h6>
                            <!-- <a href="#" class="btn btn-link">Edit</a> -->
                          </div>
                          <div class="card-body">
                              <div class="form-group w-100">
                                <div class="row">
                                  <div class="" style="display:block">
                    
                                    <label for="buyername" style="width:100%">Name</label>
                                    <br>
                                    <input type="text" style="width:100%" placeholder="Enter">
                    
                                  </div>
                                </div>
                                <div class="row mt-3">
                                  <div class="" style="display:block">
                                    <label for="buyermail" style="width:100%">Email</label>
                                    <br>
                                    <input type="text" style="width:100%" placeholder="Enter">
                                  </div>
                                </div>
                    
                                <div class="row mt-3">
                                  <div class="" style="display:block">
                                    <label for="adrsl1" style="width:100%">Address Line1</label>
                                    <br>
                                    <input type="text" style="width:100%" placeholder="Enter">
                                  </div>
                                </div>
                                <div class="row mt-3">
                                  <div class="" style="display:block">
                                    <label for="adrsl2" style="width:100%">Address Line2</label>
                                    <br>
                                    <input type="text" style="width:100%" placeholder="Enter">
                                  </div>
                                </div>
                                <div class="row mt-3">
                                  <div class="" style="display:block">
                                    <label for="buyercity" style="width:100%">City</label>
                                    <br>
                                    <input type="text" style="width:100%" placeholder="Enter">
                                  </div>
                                </div>
                                <div class="row mt-3">
                                  <div style="display:block">
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
                        
                        <div class="card col-lg-6" style="height:fit-content;">
                          <div class="card-header " style="background-color:#f3f3f3">
                            <h6>Bank Details</h6>
                            <!-- <a href="#" class="btn btn-link">Edit</a> -->
                          </div>
                          <div class="card-body">
                            <div class="form-group w-100">
                              <div class="row">
                                <div class="" style="display:block">
                  
                                  <label for="bankaddrss" style="width:100%">Address</label>
                                  <br>
                                  <input type="text" style="width:100%" placeholder="Enter">
                  
                                </div>
                              </div>
                              <div class="row">
                                <div class="" style="display:block">
                                  <label for="bankname" style="width:100%">Name</label>
                                  <br>
                                  <input type="text" style="width:100%" placeholder="Enter">
                                </div>
                              </div>
                  
                              <div class="row">
                                <div class="" style="display:block">
                                  <label for="accnum" style="width:100%">Account Number</label>
                                  <br>
                                  <input type="text" style="width:100%" placeholder="Enter">
                                </div>
                              </div>
                              <div class="row">
                                <div class="" style="display:block">
                                  <label for="Ifsccode" style="width:100%">IFSC Code </label>
                                  <br>
                                  <input type="text" style="width:100%" placeholder="Enter">
                                </div>
                              </div>
                              <div class="row">
                                <div class="" style="display:block">
                                  <label for="swiftcode" style="width:100%">SWIFT Code </label>
                                  <br>
                                  <input type="text" style="width:100%" placeholder="Enter">
                                </div>
                              </div>
                              <div class="row">
                                <div style="display:block">
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
    
                        <div class="card col-lg-6" style="height:15rem;  ">
                          <div class="card-header " style="background-color:#f3f3f3">
                            <h6>Consignee Details</h6>
                            <!-- <a href="#" class="btn btn-link">Edit</a> -->
                          </div>
                          <div class="card-body">
    
    
                          </div>
                        </div>
    
                      </div>
                    </div>
                    
                    <div class="col-lg-4">
                      <div class="card">
                        <div class="card-header" style="background-color:#f3f3f3">
                          <div class="input-group border-rounded">
                            <h4>Additional Details</h4>
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="form-group w-100">
                            <div class="row">
                              <div class="" style="display:block">
    
                                <span style="width:100%">Payment
                                  Terms</span>
                                <br>
                                <input type="text" style="width:100%" placeholder="Enter">
    
                              </div>
                            </div>
                            <div class="row mt-3">
                              <div class="" style="display:block">
                                <span style="width:100%">Terms of
                                  Delivery</span>
                                <br>
                                <input type="text" style="width:100%" placeholder="Enter">
                              </div>
                            </div>
    
                            <div class="row mt-3">
                              <div class="" style="display:block">
                                <label for="expotername" style="width:100%">Delivery
                                  Date</label>
                                <br>
                                <input type="text" style="width:100%" placeholder="Enter">
                              </div>
                            </div>
                            <div class="row mt-3">
                              <div class="" style="display:block">
                                <label for="expotername" style="width:100%">Terms &
                                  Conditions</label>
                                <br>
                                <input type="text" style="width:100%" placeholder="Enter">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
    
                    </div>
                  </div>
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
    </script>
@endsection