@extends('backend.layouts.main') 
@section('title', 'Invoice')
@section('content')

    <!-- push external head elements to head -->
    @push('head')

    <style>

     a active{
      
          color: white!important;
          /* background-color: #6666a3; */
          border-radius: 5%;
          position: relative;
          opacity: 86%
          
      }
      
      a active span {
          font-size: 16px; 
      }
      
      
      a active::before{
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

    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-2 sidebar mt-3">
          <!-- Sidebar content -->
          <h6 style="font-weight:900"></h2>
          
          <div class="sidebar-section mt-5">
            <h6>All Documents</h6>
           
          </div>
          <div class="sidebar-section h6">
            <a class="" href="{{route('panel.Documents.Quotation','active')}}">Quotations</a>
           
          </div>
          <div class="sidebar-section h6">
            <a href="{{route('panel.Documents.secondview')}}">Invoice</a>
            
          </div>
        </div>
        
        <!-- Main Content -->
       
        <div class="col-lg-10 mt-3">
          <!-- Main content goes here -->
              <div class="mt-5">
                <div class="row">
                  <div class="col-8">
                    {{-- <div class="input-group border rounded"> --}}
                      {{-- <input type="text" id="quicktitle" value="" name="title" class="form-control border-0" placeholder="Search Buyer name or.."> --}}
                      <!-- <button type="submit" class="input-group-text bg-white border-0" id="searchsubmit"><i class="uil uil-search"></i></button> -->
                    {{-- </div> --}}
                  </div>
                  <div class="col-4 d-flex justify-content-end align-items-center">
                    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#BuyerModal"> --}}
                      <button type="button" id="jwhdssu" class="btn btn-outline-primary mx-1">
                      Create Invoice
                    </button>
                  </div>
                </div>
        
                <!-- Other elements (filter, select, buttons) -->
                <div class="row mt-3 justify-content-between ">
                  <div class="col-2">
                    <input type="text" class="form-control" id="search_buyer" name="search" placeholder="Buyer Search">
                  </div>
                  <!-- Filter options -->
                  <div class="col-2" style="margin-left:10rem">
                    <select name="" id="status_check" class="form-control" style="padding-right: 40px !important;">
                      <option value="status">All</option>
                      <option value="sent">Sent</option>
                      <option value="draft">Draft</option>
                    </select>
                  </div>
        
                  <!-- Loop through proposals -->
                  <div class="col-6">
                    <!-- Your PHP loop logic for proposals -->
                  </div>
                </div>
                <div class="row mt-5">
                  <div class="col-12">
                    <div class="table-responsive mt-3">
                        <table id="table" class="table">
                            <thead class="h6 text-muted">
                                    <tr>
                                        <td class="no-export action_btn"> 
                                            <!-- {{-- <input type="checkbox" id="checkallinp"> --}} -->
                                        </td> 
                                        <td class="col-2">Invoice No.</td>
                                        <td class="col-2">Buyer</td>
                                        <td class="col-2">Company Name</td>
                                        <td class="col-2">Status</td>
                                        <td class="col-2">Amount</td>
                                        <td class="col-2">Created On</td>
                    
                                        
                                    </tr>
                            </thead>
                            <tbody>
                                {{-- <!-- @if ($proposals->count() > 0)
                                    @foreach ($proposals as $proposal)
                                        @php
                                            $customer_detail = json_decode($proposal->customer_details);
                                            $customer_name = $customer_detail->customer_name ?? '--';
                                            $customer_mob_no = $customer_detail->customer_mob_no ?? '--';
                                            $direct = $proposal->status == 0 ? "?direct=1" : "";
                                            $user_key = encrypt(auth()->id());
                                            $productItems = App\Models\ProposalItem::where('proposal_id',$proposal->id)->get();
                                            $product_count = App\Models\ProposalItem::where('proposal_id',$proposal->id)->get()->count();
                                        @endphp --> --}}
                                        
                                        <tr>
                                            <td class="no-export action_btn">
                                                <!-- {{-- @if($scoped_product->user_id == auth()->id()) --}} -->
                                                    <!-- {{-- <input type="checkbox" name="exportproduct" id="exportproduct" class="input-check"> --}} -->
                                                <!-- {{-- @endif --}} -->
                                            </td>   
                                            <td class="justify-content-between">
                                              
                                              
                                                  
                                                      
                                              <div class="py-1" >                                                                                                                                                                                                                                                                                                                                                           
                                              invoiceid12234
                                              {{-- <!-- <img src="{{ asset($mediarecord->path) ?? '' }}" alt="" class="img-fluid p-1" style="border-radius: 10px;height: 100%;width: 100%;background-color: gray;align-items: center;"> --> --}}
                                              </div>   
                                                                            
                                                          
                                          
                                        </td>
                                            
                                            <td>
                                                <div class=" py-1" > buyer23</div>
                                            </td>
                                            <td>
                                              <div class=" py-1" >comp</div>
                                            </td>
                                            <td>
                                                <div class=" py-1" ><span class="text-success"> Sent </span>
                                                  <!-- @ else -->
                                                      <!-- <span class="text-danger"> Draft </span></div> -->
                                            </td>
                                            <td>
                                                
                                            </td>
                              
                                            <td>
                                                
                                              9/8/2023
                                            </td>
                                        </tr>
  
                                        <tr>
                                          <td class="no-export action_btn">
                                              <!-- {{-- @if($scoped_product->user_id == auth()->id()) --}} -->
                                                  <!-- {{-- <input type="checkbox" name="exportproduct" id="exportproduct" class="input-check"> --}} -->
                                              <!-- {{-- @endif --}} -->
                                          </td>   
                                          <td class="justify-content-between">
                                              
                                              
                                                  
                                                      
                                                <div class="py-1" >                                                                                                                                                                                                                                                                                                                                                           
                                                invoiceid12234
                                                {{-- <!-- <img src="{{ asset($mediarecord->path) ?? '' }}" alt="" class="img-fluid p-1" style="border-radius: 10px;height: 100%;width: 100%;background-color: gray;align-items: center;"> --> --}}
                                                </div>   
                                                                              
                                                            
                                            
                                          </td>
                                          
                                          <td>
                                              <div class=" py-1" > buyer23</div>
                                          </td>
                                          <td>
                                            <div class=" py-1" >comp</div>
                                          </td>
                                          <td>
                                              <div class=" py-1" >
                                                <!-- <span class="text-success"> Sent </span> -->
                                                <!-- @ else -->
                                                <span class="text-danger"> Draft </span>
                                              </div>
                                          </td>
                                          <td>
                                              
                                          </td>
                            
                                          <td>
                                              
                                            9/8/2023
                                          </td>
                                      </tr>
                    
                                                                    
                            </tbody>
                        </table>
                    </div>
                  </div>
                </div>
    
              </div>
        </div>
    </div>
    {{-- @include('panel.Documents.modals.buyer') --}}
  
    
  
</div>
<script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script src="{{ asset('backend/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{asset('backend/js/form-advanced.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function () {
    $("#jwhdssu").click(function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var msg = "<div class='dropdown w-100'><h5></h5><select class='form-select' id='mybro' aria-label='Default select example'><option selected>Buyer name</option><option value='1'>One</option><option value='2'>Two</option><option value='3'>Three</option></select></div>";
        
        $.confirm({
            draggable: true,
            title: ' Buyer Search',
            content: msg,
            type: 'blue',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Proceed',
                    btnClass: 'btn-primary',
                    action: function () {
                        // Redirect to the second view route
                        window.location.href = "{{ route('panel.Documents.secondview') }}";
                    }
                },
                close: function () {
                    // Additional action if needed upon dialog close
                }
            }
        });
    });



      
      $(function () {
        $("#mybro").select2()
      });

      


      
  });
  
</script>
@endsection


