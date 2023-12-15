@extends('backend.layouts.main') 
@section('title', 'fourthview')
@section('content')

    <!-- push external head elements to head -->
    @push('head')

    <style>
      .table-responsive {
     overflow-x: auto;
     overflow-y: visible;
    }
    
    .sticky-col {
     position: sticky;
     position: -webkit-sticky;
     background-color: white;
     z-index: 1020;
     background-color: #f3f3f3!important;
    }
    
    .sticky-col.first-col { left: 0; }
    .sticky-col.second-col { left: 63px; } 
    .sticky-col.third-col { left: 107px; }
    .sticky-col.thirteenth-col {right: 0;}
    
    th, td { white-space: nowrap; }


    
   .input-group {
     display: flex;
     width: 40%;
   }
    
    
    
    </style>

    @endpush

    <div class="container" style="max-width:1350px !important;">
        <div class="row">
          <div class="col-12 mt-5">
            <h4>Invoice & Quotations</h1>
          </div>
          <div class="col lg-6 col-md-5">
            <!-- <div class="input-group border rounded"> -->
            <!-- <input type="text" id="quicktitle" value="" name="title" class="form-control border-0" placeholder="Search Buyer name or..">
              <button type="submit" class="input-group-text bg-white border-0" id="searchsubmit"><i class="uil uil-search"></i></button> -->
            <!-- </div> -->
    
          </div>
          <div class="col lg-6 col-md-5" style="margin-left: 12rem;">
            <div class="two" style="display: flex; align-items: center; justify-content: flex-end;">
              <div class="form-group w-100" style="margin-bottom: 0rem; display: flex; justify-content: flex-end;">
                <button class="btn btn-outline-success mx-1" type="button" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#AttriModal">
                  Choose Properties
                </button>
    
                <div class="dropdown">
                  <button class="btn btn-outline-primary dropdown-toggle mx-1" type="button" data-bs-toggle=""
                    aria-expanded="false">
                    Add Product
                  </button>
                  <!-- <ul class="dropdown-menu">
                    <li>
                      <a class="dropdown-item"
                        href="{{ route('panel.products.create') }}?action=nonbranded&single_product">Single Product</a>
                    </li>
                    <li>
                      <a class="dropdown-item"
                        href="{{ route('panel.products.create') }}?action=nonbranded&bulk_product">Bulk - by Excel</a>
                    </li>
                  </ul> -->
                </div>
    
                <button class="btn btn-dark mx-1" type="button" aria-expanded="false">
                  Generate
                </button>
              </div>
            </div>
          </div>
    
    
        </div>
        <div class="row mt-3 justify-content-end">
          <div class="col-2 d-flex align-items-end">
            <div class="form-group w-100 justify-content-between" style="display: flex; align-items: center;">
              <label for="currency" class="control-label">Currency</label>
              <div class="input-group mb-3" style="margin-left:40px; width:100%;">
                <!-- <input type="number" class="form-control" style="width:25%"  id="gst" value="" aria-label="currency" aria-describedby="currencySelect"> -->
                <select class="form-select w-100"style="width:45%; background-color: #f3f3f3" id="currencySelect" aria-label="Currency">
                  <option value="USD">USD</option>
                  <option value="EUR">EUR</option>
                  <option value="GBP">GBP</option>  
                  <option value="GBP">INR</option>              
                </select>
              </div>
              <!-- <input class="form-control" style="width:70%;" name="gst" type="text" id="gst" value=""> -->
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-lg-12 ">
            <div class="table-responsive">
              <table class="table">
                  <thead>
                      <tr>
                          <th class="sticky-col first-col">Delete</th>
                          <th class="sticky-col second-col">No.</th>
                          <th class="sticky-col third-col">Product ID</th>
                          <!-- <th style="background-color:yellow">Buyer Product Id</th> -->
                          <th>Buyer Product Id</th>
                          <!-- <th style="background-color:rgb(0, 191, 255)">Description</th> -->
                          <th>Description</th>
                          <th style="">Master Carton Dimensions</th>
                          <th>Unit</th>
                          <th>No. of pieces/Master Carton</th>
                          <th>CBM per piece</th>
                          <th>Quantity</th>
                          <th>Unit</th>
                          <th>Selling Price</th>
                          <th class="sticky-col thirteenth-col">Amount</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td class="sticky-col first-col"><input  type="checkbox"></td>
                          <td class="sticky-col second-col">1</td>
                          <td class="sticky-col third-col">T-28158</td>
                          <td><input type="text" class="form-control" style="width:60%"></td>
                          <td>IRON BAR CART</td>
                          <td class="justify-content-between"><input type="text" class="form-control" style="width:60%"></td>
                          <td>cm</td>
                          <td><input type="number" class="form-control" style="width:60%"></td>
                          <td><input type="text" class="form-control" style="width:60%"></td>
                          <td><input type="number" class="form-control"></td>
                          <td><input type="number" class="form-control"></td>
                          <td><input type="number" class="form-control"></td>
                         
                          <td class="sticky-col thirteenth-col">$0</td>
                      </tr>
                      <tr>
                        <td class="sticky-col first-col"><input type="checkbox"></td>
                        <td class="sticky-col second-col">2</td>
                        <td class="sticky-col third-col">G-3900928</td>
                        <td><input type="text" class="form-control" style="width:60%"></td>
                        <td></td>
                        <td><input type="text" class="form-control" style="width:60%"></td>
                        <td>cm</td>
                        <td><input type="number" class="form-control" style="width:60%"></td>
                        <td><input type="text" class="form-control" style="width:60%"></td>
                        <td><input type="number" class="form-control"></td>
                        <td><input type="number" class="form-control"></td>
                        <td><input type="number" class="form-control"></td>
                       
                        <td class="sticky-col thirteenth-col">$0</td>
                    </tr>
                    <tr>
                      <td class="sticky-col first-col"><input type="checkbox"></td>
                      <td class="sticky-col second-col">3</td>
                      <td class="sticky-col third-col">R-8158</td>
                      <td><input type="text" class="form-control" style="width:60%"></td>
                      <td>CART</td>
                      <td><input type="text" class="form-control" style="width:60%"></td>
                      <td>cm</td>
                      <td><input type="number" class="form-control" style="width:60%"></td>
                      <td><input type="text" class="form-control" style="width:60%"></td>
                      <td><input type="number" class="form-control"></td>
                      <td><input type="number" class="form-control"></td>
                      <td><input type="number" class="form-control"></td>
                     
                      <td class="sticky-col thirteenth-col">$0</td>
                  </tr>
                      <!-- Repeat rows as needed -->
                  </tbody>
              </table>
          </div>        
          </div>
        </div>
    
        <div class="row mt-4" style="margin-left: 3px">
          <div class="card col-lg-6 col-md-5" style="background-color:#f3f3f3">
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
          <div class="card col-lg-6 col-md-5">
            <div class="card-header">
              <div class="form-group justify-content-between" style="display: flex; align-items: center;">
                  <label for="totalAmount" class="control-label">Total Amount (pre-tax)</label>
                  <!-- <div class="input-group mb-3">
                    <input type="number" class="form-control" style="width:25%" id="totalpre" value="" aria-label="Total Amount (pre-tax)" aria-describedby="currencySelect">
                    <select class="form-select" style="width:45%; background-color: #f3f3f3" id="currencySelect" aria-label="Currency">
                      <option value="USD">USD</option>
                      <option value="EUR">EUR</option>
                      <option value="GBP">GBP</option>               
                    </select>
                  </div> -->
                  <!-- <input class="form-control" style="width:70%;" name="totalAmount" type="text" id="totalAmount" value=""> -->
                </div>
            </div>
            <div class="card-body">
              <div class="col-lg-12 col-md-5 ">
                <!-- <div class="form-group justify-content-between" style="display: flex; align-items: center;">
                  <label for="totalAmount" class="control-label">Total Amount (pre-tax)</label>
                  <div class="input-group mb-3">
                    <input type="number" class="form-control" style="width:25%" id="totalpre" value="" aria-label="Total Amount (pre-tax)" aria-describedby="currencySelect">
                    <select class="form-select" style="width:45%; background-color: #f3f3f3" id="currencySelect" aria-label="Currency">
                      <option value="USD">USD</option>
                      <option value="EUR">EUR</option>
                      <option value="GBP">GBP</option>               
                    </select>
                  </div>
                  
                </div> -->
              </div>
    
              <div class="col-lg-12 col-md-12">
                <div class="form-group justify-content-between" style="display: flex; align-items: center;">
                  <label for="gst" class="control-label">GST</label>
                  <div class="input-group mb-3" style="margin-right:70px;">
                    <input type="number" class="form-control" style="width:25%"  id="gst" value="" aria-label="GST" aria-describedby="currencySelect">
                    <select class="form-select"style="width:45%; background-color: #f3f3f3" id="currencySelect" aria-label="Currency">
                      <option value="USD">USD</option>
                      <option value="EUR">EUR</option>
                      <option value="GBP">GBP</option>               
                    </select>
                  </div>
                  <!-- <input class="form-control" style="width:70%;" name="gst" type="text" id="gst" value=""> -->
                </div>
              </div>
    
              <div class="col-lg-12 col-md-12 ">
                <div class="form-group justify-content-between" style="display: flex; align-items: center;">
                  <label for="consolidation" class="control-label">Consolidation</label>
                  <div class="input-group mb-3" style="margin-right:70px;">
                    <input type="number" class="form-control" style="width:25%"  id="Consolidation" value="" aria-label="Consolidation" aria-describedby="currencySelect">
                    <select class="form-select"style="width:45%; background-color: #f3f3f3" id="currencySelect" aria-label="Currency">
                      <option value="USD">USD</option>
                      <option value="EUR">EUR</option>
                      <option value="GBP">GBP</option>               
                    </select>
                  </div>
                  <!-- <input class="form-control" style="width:70%;" name="consolidation" type="text" id="consolidation" value=""> -->
                </div>
              </div>
              <!-- End of New fields -->
            </div>
          </div>
        </div>
    
    
    </div>


    {{-- modal --}}

    <div class="modal fade" id="AttriModal" tabindex="-1" aria-labelledby="AttriModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="background-color:#ffff; max-width:1300px !important;" >
          <div class="modal-content" style="margin-top:0%;">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="AttriModalLabel">Select Attributes</h1>
              <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
              <div class="col-md-6 col-12 my-3" style="overflow: auto; max-height: 80vh">
                <span style="margin-top: -10px;">
                    <i class="ik ik-info fa-2x text-warning ml-2 remove-ik-class" title="These Values will be Updated on All selected Products"></i>
                </span>            
                <!-- All Attributes -->
                <div class="table-responsive" style="max-height:40vh; overflow:hidden;overflow-y:auto;">                
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Property</th>
                        </tr>
                        <tr> 
                            <th scope="col">
                                <div class="form-group w-100" style="margin-bottom:0rem">
                            <input type="checkbox" id="check_all" class=" m-2">
                            <label for="check_all" style="font-size: 12.8px; font-family:Nunito Sans, sans-serif;font-weight:700;user-select: none;">Select All</label>
                          </div>
                            </th>
                        </tr>
                      </thead>
                      <tbody>                    
                            <tr>
                              <td scope="row">
                                <div class="form-group h-100" style="cursor: pointer; margin-bottom:0rem!important;">
                                  <input type="checkbox" value=" id="" class="my_attribute d-none mx-1" name="myfields[]" data-index="">
                                  <label for="attri_" class="form-label w-100 h-100" style="font-size: 12.8px;font-family:Nunito Sans, sans-serif; user-select: none;">Attribute 1 </label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td scope="row">
                                <div class="form-group h-100" style="cursor: pointer; margin-bottom:0rem!important;">
                                  <input type="checkbox" value="" id="attri_" class="my_attribute d-none mx-1" name="myfields[]" data-index="">
                                  <label for="attri_" class="form-label w-100 h-100" style="font-size: 12.8px;font-family:Nunito Sans, sans-serif; user-select: none;">Attribute 2 </label>
                                </div>
                              </td>
                            </tr>       
                            <tr>
                              <td scope="row">
                                <div class="form-group h-100" style="cursor: pointer; margin-bottom:0rem!important;">
                                  <input type="checkbox" value="" id="attri_" class="my_attribute d-none mx-1" name="myfields[]" data-index="">
                                  <label for="attri_" class="form-label w-100 h-100" style="font-size: 12.8px;font-family:Nunito Sans, sans-serif; user-select: none;">Attribute 3 </label>
                                </div>
                              </td>
                            </tr>       
                            <tr>
                              <td scope="row">
                                <div class="form-group h-100" style="cursor: pointer; margin-bottom:0rem!important;">
                                  <input type="checkbox" value="" id="attri_ class="my_attribute d-none mx-1" name="myfields[]" data-index="">
                                  <label for="attri_ class="form-label w-100 h-100" style="font-size: 12.8px;font-family:Nunito Sans, sans-serif; user-select: none;">Attribute 4 </label>
                                </div>
                              </td>
                            </tr>                            
                          <tr>
                            <td scope="row">
                              <div class="form-group">
                                <!-- <label for="attri_1" class="form-label w-100 h-100" style="font-size: large;user-select: none;">System Under Upgrade Try Again Later.</label> -->
                              </div>
                            </td>
                          </tr>
                      </tbody>
                    </table>
                </div>         
              </div>
           
            </div>
            <div class="modal-footer d-flex justify-content-between">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary ml-auto">Proceed</button>
            </div>
          
          
          </div>
        </div>
    </div>

@endsection