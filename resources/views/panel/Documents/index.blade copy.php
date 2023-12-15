@extends('backend.layouts.main') 
@section('title', 'Invoice')
@section('content')

    <!-- push external head elements to head -->
    @push('head')

    @endpush

<div class="container-fluid">

<div class="row">
      <!-- Sidebar -->
      <div class="col-lg-2 sidebar mt-3">
        <!-- Sidebar content -->
        <h6 style="font-weight:900">Invoices & Quotations</h2>
        
        <div class="sidebar-section mt-5">
          <h6>All Documents</h6>
         
        </div>
        <div class="sidebar-section">
          <h6>Quotations</h6>
         
        </div>
        <div class="sidebar-section">
          <h6>Performa Invoice</h6>
          
        </div>
      </div>
      
      <!-- Main Content -->
     
      <div class="col-lg-10 mt-3">
        <!-- Main content goes here -->
            <div class="mt-5">
              <div class="row">
                <div class="col-8">
                  <div class="input-group border rounded">
                    <input type="text" id="quicktitle" value="" name="title" class="form-control border-0" placeholder="Search Buyer name or..">
                    <!-- <button type="submit" class="input-group-text bg-white border-0" id="searchsubmit"><i class="uil uil-search"></i></button> -->
                  </div>
                </div>
                <div class="col-4 d-flex justify-content-end align-items-center">
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#BuyerModal">
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
                          <thead class="h5 text-muted">
                                  <tr>
                                      <td class="no-export action_btn"> 
                                          <!-- {{-- <input type="checkbox" id="checkallinp"> --}} -->
                                      </td> 
                                      <td class="col-3">Invoice Id</td>
                                      <td class="col-3">Buyer</td>
                                      <td class="col-3">Status</td>
                                      <td class="col-3">Amount</td>
                                      <td class="col-3">Created On</td>
                  
                                      
                                  </tr>
                          </thead>
                          <tbody>
                              <!-- @if ($proposals->count() > 0)
                                  @foreach ($proposals as $proposal)
                                      @php
                                          $customer_detail = json_decode($proposal->customer_details);
                                          $customer_name = $customer_detail->customer_name ?? '--';
                                          $customer_mob_no = $customer_detail->customer_mob_no ?? '--';
                                          $direct = $proposal->status == 0 ? "?direct=1" : "";
                                          $user_key = encrypt(auth()->id());
                                          $productItems = App\Models\ProposalItem::where('proposal_id',$proposal->id)->get();
                                          $product_count = App\Models\ProposalItem::where('proposal_id',$proposal->id)->get()->count();
                                      @endphp -->
                                      
                                      <tr>
                                          <td class="no-export action_btn">
                                              <!-- {{-- @if($scoped_product->user_id == auth()->id()) --}} -->
                                                  <!-- {{-- <input type="checkbox" name="exportproduct" id="exportproduct" class="input-check"> --}} -->
                                              <!-- {{-- @endif --}} -->
                                          </td>   
                                          <td class="justify-content-between">
                                              <span style="mr-3;">
                                                  <!-- {{ $customer_name }} -->
                                              </span>
                                              <div class="d-flex justify-content-between" style="">
                                                  
                                                      
                                                <div style="height: 60px;width: 60px; object-fit: contain;justify-content-end;">                                                                                                                                                                                                                                                                                                                                                           
                                                <p>invoiceid12234</p><!-- <img src="{{ asset($mediarecord->path) ?? '' }}" alt="" class="img-fluid p-1" style="border-radius: 10px;height: 100%;width: 100%;background-color: gray;align-items: center;"> -->
                                                </div>   
                                                                              
                                                            
                                            
                                          </td>
                                          
                                          <td>
                                              <div class=" py-1" > buyer23</div>
                                          </td>
                                          <td>
                                              <div class=" py-1" ><span class="text-success"> Sent </span>
                                                <!-- @else -->
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
                                            <span style="mr-3;">
                                                <!-- {{ $customer_name }} -->
                                            </span>
                                            <div class="d-flex justify-content-between" style="">
                                                
                                                    
                                              <div style="height: 60px;width: 60px; object-fit: contain;justify-content-end;">                                                                                                                                                                                                                                                                                                                                                           
                                              <p>invoiceid12234</p><!-- <img src="{{ asset($mediarecord->path) ?? '' }}" alt="" class="img-fluid p-1" style="border-radius: 10px;height: 100%;width: 100%;background-color: gray;align-items: center;"> -->
                                              </div>   
                                                                            
                                                          
                                          
                                        </td>
                                        
                                        <td>
                                            <div class=" py-1" > buyer23</div>
                                        </td>
                                        <td>
                                            <div class=" py-1" >
                                              <!-- <span class="text-success"> Sent </span> -->
                                              <!-- @else -->
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
  
   
  
</div>

@include('panel.invoice.modals.exporterDetails')
    <!-- push external js -->
    @push('script')

    <script>

        $(document).ready(function () {
          // {{--` Renaming File --}}
          $(".editable").click(function (element) {
            let oldname = $(this).text();
    
            $(this).editable("dblclick", function (e) {
              if (e.value != '') {
                console.log("You Change Value "+e.value+" From "+oldname);
                // $.ajax({
                //     type: "post",
                //     url: "{{ route('panel.filemanager.rename') }}",
                //     data: {
                //         'oldName': oldname,
                //         'newName': e.value,
                //     },
                //     dataType: "json",
                //     success: function (response) {
                //         // console.log(response);
                //     }
                // });
              }
            });
          });
        });
      </script>
    
    <script>
      $(document).ready(function() {
          $('#country').select2();
      });
    </script>
    
    <script>
    $(document).ready(function() {
      $("#saveBtn").click(function() {
          var inputText = $("#inputText").val();
          $("#cardBody").text(inputText);
          $("#exampleModal").modal('hide');
      });
    
      $.each($("input,select"), function (indexInArray, valueOfElement) { 
            $(this).addClass('form-control')
      });
    
    
    });
    </script>
    
 
    @endpush
@endsection
