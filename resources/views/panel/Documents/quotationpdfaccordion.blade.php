@extends('backend.layouts.main')
@section('title', 'quotationpdf')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
        <style>
            a active {

                color: white !important;
                /* background-color: #6666a3; */
                border-radius: 5%;
                position: relative;
                opacity: 86%
            }

            a active span {
                font-size: 16px;
            }


            a active::before {
                content: '';
                background-color: #8484f8;
                height: 3px;
                width: 120%;
                position: absolute;
                bottom: -7px;
                left: -4px;
            }
        </style>
    @endpush

    <div class="container-fluid">

        <div class="container py-2" style="max-width: 1350px;">
            <div class="row mb-4">
                <div class="col-1 text-end">
                    <!-- Logo -->
                    <img src="path-to-your-logo.jpg" alt="Company Logo" class="mb-4">
                </div>
                <div class="col text-start">
                    <!-- Company Name -->
                    <h4>Company Name</h4>
                    <!-- Proforma Invoice -->
                    <p>Proforma Invoice</p>
                </div>
                <div class="col text-end">
                    <!-- Date and Invoice Number -->
                    <p style="display: flex; justify-content:flex-end;"><strong>Date:</strong> 16 November 2023</p>
                    <p style="display: flex; justify-content:flex-end;"><strong>Invoice Number:</strong> #PI-003</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="card col-lg-4 col-md-4">
                    <div class="card-body" style="padding: 0px 20px ">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="row justify-content-between">
                                    {{-- Exporter Details --}}
                                    <div class="col-lg-12 col-md-12">
                                        <div class="accordion" id="accordionExporterDetails">                                           
                                            <div class="accordion-item" style="background-color:#f3f3f3">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExporterDetails" aria-expanded="true" aria-controls="collapseExporterDetails">
                                                        Exporter Details
                                                    </button>
                                                </h2>
                                            </div>
                                            <div id="collapseExporterDetails" class="accordion-collapse collapse show" aria-labelledby="" data-bs-parent="">
                                                <div class="accordion-body">
                                                    <div class="form-group w-100">
                                                        <div class="row">
                                                            <div class="" style="display:block; width:100% !important;">
                                                                <label for="expotername" style="width:100%">Exporter Name</label><br>
                                                                <input class="form-control" type="text" style="width:100%" placeholder="Enter">
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="" style="display:block; width:100% !important;">
                                                                <label for="expotername" style="width:100%">Email id</label>
                                                                <br>
                                                                <input class="form-control" type="text" style="width:100%" placeholder="Enter">
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="" style="display:block; width:100% !important;">
                                                                <label for="expotername" style="width:100%">Other Reference</label>
                                                                <br>
                                                                <input class="form-control" type="text" style="width:100%" placeholder="Enter">
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="" style="display:block; width:100% !important;">
                                                                <label for="expotername" style="width:100%">Address</label>
                                                                <br>
                                                                <input class="form-control" type="text" style="width:100%" placeholder="Enter">
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div style="display:block ;width:100% !important;">
                                                                <label for="country" style="width:100%">Country</label>
                                                                <br>
                                                                <select id="country" class="form-control" name="country" style="width:100%">
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
                                                                <input class="form-control" type="text" style="width:100%" placeholder="Enter">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                                                        
                                    {{-- Buyer Details --}}
                                    <div class="col-lg-12 col-md-12">
                                        <div class="accordion" id="accordionbuyerDetails">
                                            <div class="accordion-item" style="background-color:#f3f3f3">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsebuyerDetails" aria-expanded="true" aria-controls="collapsebuyerDetails">
                                                        Buyer Details
                                                    </button>
                                                </h2>
                                            </div>
                                            <div id="collapsebuyerDetails" class="accordion-collapse collapse show" aria-labelledby="" data-bs-parent="">
                                                <div class="accordion-body">
                                                    <div class="form-group w-100">
                                                        <div class="row">
                                                            <div class="" style="display:block; width:100% !important;">
                                            
                                                            <label for="buyername" style="width:100%">Name</label>
                                                            <br>
                                                            <input class="form-control" type="text" style="width:100%" placeholder="Enter">
                                            
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="" style="display:block; width:100% !important;">
                                                            <label for="buyermail" style="width:100%">Email</label>
                                                            <br>
                                                            <input class="form-control" type="text" style="width:100%" placeholder="Enter">
                                                            </div>
                                                        </div>                                
                                                        <div class="row mt-3">
                                                            <div class="" style="display:block; width:100% !important;">
                                                            <label for="adrsl1" style="width:100%">Address Line1</label>
                                                            <br>
                                                            <input class="form-control" type="text" style="width:100%" placeholder="Enter">
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="" style="display:block; width:100% !important;">
                                                            <label for="adrsl2" style="width:100%">Address Line2</label>
                                                            <br>
                                                            <input class="form-control" type="text" style="width:100%" placeholder="Enter">
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="" style="display:block; width:100% !important;">
                                                            <label for="buyercity" style="width:100%">City</label>
                                                            <br>
                                                            <input class="form-control" type="text" style="width:100%" placeholder="Enter">
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div style="display:block; width:100% !important;">
                                                            <label for="country" style="width:100%">Country</label>
                                                            <br>
                                                            <select id="country" class="form-control" name="country" style="width:100%">
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

                                    {{-- Consignee Details --}}
                                    <div class="col-lg-12 col-md-12" >
                                        <div class="accordion" id="accordionconsigneeDetails">
                                            <div class="accordion-item" style="background-color:#f3f3f3">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseconsigneeDetails" aria-expanded="true" aria-controls="collapseconsigneeDetails">
                                                        Consignee Details
                                                    </button>
                                                </h2>
                                            </div>
                                            <div id="collapseconsigneeDetails" class="accordion-collapse collapse show" aria-labelledby="" data-bs-parent="">
                                                <div class="accordion-body">
                                                    <div class="form-group w-100">
                                                        <div class="row">
                                                            {{-- <div class="" style="display:block; width:100% !important;">
                                            
                                                            <label for="buyername" style="width:100%">Name</label>
                                                            <br>
                                                            <input type="text" style="width:100%" placeholder="Enter">
                                            
                                                            </div> --}}
                                                        </div>
                                                        <div class="row mt-3">
                                                            {{-- <div class="" style="display:block; width:100% !important;">
                                                            <label for="buyermail" style="width:100%">Email</label>
                                                            <br>
                                                            <input type="text" style="width:100%" placeholder="Enter">
                                                            </div> --}}
                                                        </div>                                
                                                        <div class="row mt-3">
                                                            {{-- <div class="" style="display:block; width:100% !important;">
                                                            <label for="adrsl1" style="width:100%">Address Line1</label>
                                                            <br>
                                                            <input type="text" style="width:100%" placeholder="Enter">
                                                            </div> --}}
                                                        </div>
                                                        <div class="row mt-3">
                                                            {{-- <div class="" style="display:block; width:100% !important;">
                                                            <label for="adrsl2" style="width:100%">Address Line2</label>
                                                            <br>
                                                            <input type="text" style="width:100%" placeholder="Enter">
                                                            </div> --}}
                                                        </div>
                                                        <div class="row mt-3">
                                                            {{-- <div class="" style="display:block; width:100% !important;">
                                                            <label for="buyercity" style="width:100%">City</label>
                                                            <br>
                                                            <input type="text" style="width:100%" placeholder="Enter">
                                                            </div> --}}
                                                        </div>
                                                        <div class="row mt-3">
                                                            {{-- <div style="display:block; width:100% !important;">
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
                                                            </div> --}}
                                                        
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
                </div>
                {{-- invoice details --}}
                <div class="card col-lg-8 col-md-8">                    
                    <div class="accordion" id="accordioninvoicedeets">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseinvoiceDetails" aria-expanded="true" aria-controls="collapseinvoiceDetails">
                                    Invoice Details
                                </button>
                            </h2>                            
                            <div id="collapseinvoiceDetails" class="accordion-collapse collapse show" aria-labelledby="" data-bs-parent="">
                                <div class="accordion-body">
                                    <!-- Your existing form content goes here -->
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
                                                <input class="form-control" name="" type="number" id=""
                                                    value="">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-4">
                                            <div class="form-group ">
                                                <label for="mrp" class="control-label">Payment
                                                    Terms</label>
                                                <input class="form-control" name="" type="number" id=""
                                                    value="">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-4">
                                            <div class="form-group ">
                                                <label for="mrp" class="control-label">Terms of
                                                    Delivery</label>
                                                <input class="form-control" name="" type="number" id=""
                                                    value="">
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-4">
                                            <div class="form-group ">
                                                <label for="mrp" class="control-label">Delivery
                                                    Date</label>
                                                <input class="form-control" name="" type="number" id=""
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
                                </div>
                            </div>
                        </div>
                    </div>                                        
                    {{-- bank details --}} 
                    <div class="row mt-4">
                        <div class="col-lg-12">
                        <div class="accordion" id="accordionbankdeets">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingBankDetails">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseBankDetails" aria-expanded="true" aria-controls="collapseBankDetails">
                                    Bank Details
                                </button>
                                </h2>
                                <div id="collapseBankDetails" class="accordion-collapse collapse show" aria-labelledby="" data-bs-parent="">
                                <div class="accordion-body">
                                    <!-- The form starts here -->
                                    <div class="form-group w-100">
                                    <!-- Form rows here -->
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                        <label for="bankname" class="form-label">Bank name</label>
                                        </div>
                                        <div class="col-md-6">
                                        <input type="text" class="form-control" id="bankname" placeholder="Enter">
                                        </div>
                                    </div>
                            
                                    <!-- Repeat for each form row -->
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                        <label for="accnum" class="form-label">Account Number</label>
                                        </div>
                                        <div class="col-md-6">
                                        <input type="text" class="form-control" id="accnum" placeholder="Enter">
                                        </div>
                                    </div>
                                    
                                    <!-- Additional form rows for IFSC Code, SWIFT Code, Address, and Country -->
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
                                        <select id="country" class="form-control" name="country">
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
                                    <!-- The form ends here -->
                                </div>
                                </div>
                            </div>
                        </div>
                        </div>
                            
                            
                    </div>                                                                                   
                </div>                
            </div>                       
            {{-- table --}}
            <div class="row">
                <div class="col-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Product ID</th>
                        <th scope="col">Image</th>
                        <th scope="col">Buyer ID</th>
                        <th scope="col">Description</th>
                        <th scope="col">Packaging</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Rate</th>
                        <th scope="col">Amount (£)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Repeat for each product -->
                    <tr>
                        <td>T-28158</td>
                        <td><img src="path_to_image" alt="Product Image"></td>
                        <td>Buyer ID</td>
                        <td>IRON BAR CART</td>
                        <td>10 pieces/inner carton</td>
                        <td>150.0</td>
                        <td>£10.00</td>
                        <td>£1500.0</td>
                    </tr>
                    <!-- Additional product rows -->
                    </tbody>
                </table>
                </div>
            </div>
            
            <!-- Additional sections for 'Order Summary' etc. -->
            <div class="row mt-4" style="margin-left: 3px">
                <div class="card col-lg-6 col-md-5">
                  <div class="card-body" style="background-color:rga(0,0,0,.03)">
                    <h5>Order Summary</h5>
                    <div class="col-lg-12 col-md-12">
                      <div class="form-group justify-content-between" style="display: flex; align-items: center;">
                        <label for="totalqt" class="control-label">Total Quantity</label>
                        <input class="form-control justify-content-end" style="width:70%; ;" name="" type="number" id="" value="">
                      </div>
                    </div>
          
                    <div class="col-lg-12 col-md-12">
                      <div class="form-group justify-content-between" style="display: flex; align-items: center;">
                        <label for="remark" class="control-label">Remarks</label>
                        <textarea class="form-control mt-3" style="width:70%" placeholder="Leave a comment here"
                          id="floatingTextarea"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
          
          
                <!-- 2nd column -->                
                    <div class="col-lg-6 col-md-5">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Total amount (Pre Tax)</td>
                                    <td class="text-end">£ 5667.0</td>
                                </tr>
                                <tr>
                                    <td>gst</td>
                                    <td class="text-end">£ 2555.0</td>
                                </tr>
                                <tr>
                                    <td>consolidation</td>
                                    <td class="text-end">£ 0.0</td>
                                </tr>
                                <tr class="fw-bold">
                                    <td>Total Amount</td>
                                    <td class="text-end">£ 8222.0</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-uppercase">Eight thousand, two hundred and twenty-two GBP</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>                               
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="accordion" id="accordionTermsConditions">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTermsConditions" aria-expanded="true" aria-controls="collapseTermsConditions">
                                    Terms and Conditions
                                </button>
                            </h2>
                            <div id="collapseTermsConditions" class="accordion-collapse collapse show" aria-labelledby="" data-bs-parent="">
                                <div class="accordion-body">
                                    <!-- Your terms and conditions content goes here -->
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
                                    <p>More terms and conditions...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            <!-- Authorized Signatory Section -->
                <div class="row mt-4">
                    <div class="col text-end">
                        <div class="d-flex justify-content-end">
                            <h5>Authorized Signatory:</h5>
                            {{-- <img src="path-to-signature.jpg" alt="Authorized Signature" class="mb-3" style="max-width: 200px;">
                            <p>Date: December 21, 2023</p> --}}
                        </div>
                    </div>
                </div>
            
        </div>       

    </div>

    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script src="{{ asset('backend/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function proceedTothirdView() {
            // Redirect to the route for second view
            window.location.href = "{{ route('panel.Documents.quotation3') }}";
        }

        // function goBack() {
        //     window.history.back()
        // }
    </script>

@endsection
