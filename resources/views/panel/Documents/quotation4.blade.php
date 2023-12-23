@extends('backend.layouts.main')
@section('title', 'quotation4')
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
                /* background-color: #f3f3f3!important; */
            }

            .sticky-col.first-col {
                left: 0;
            }

            .sticky-col.second-col {
                left: 37px;
            }

            .sticky-col.third-col {
                left: 82px;
            }

            .sticky-col.thirteenth-col {
                right: 0;
            }

            th,
            td {
                white-space: nowrap;
            }



            .input-group {
                display: flex;
                width: 40%;
            }
        </style>
    @endpush

    <div class="container" style="max-width:1350px !important;">
        <div class="row">
            <div class="col lg-6 col-md-6 ">
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-secondary" onclick="goBack()" type="button">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h5 class="ms-3 mt-5 mb-0" style="margin-left: 30px !important;">Quotation-231</h5>
                    </div>

                </div>
            </div>
            <div class="col-lg-6 col-md-6">                
              <div class="two" style="display: flex; align-items: center; justify-content: flex-end;">
                  <div class="form-group w-100" style="margin-bottom: 0rem; display: flex; justify-content: flex-end;">
                      <div class=" d-flex align-items-end">

                       
                          {{-- <div class="form-group w-100 justify-content-between" style="display: flex; align-items: center;">
                              <button class="btn btn-primary" type="button" id="#9uou">
                                  <span class="bi bi-currency-dollar">$</span>
                              </button>
                          </div> --}}
                      </div>
                      <div class="form-group w-100 justify-content-between" style="display: flex; align-items: center;">
                        <label for="currency" class="control-label">Currency</label>
                        <div class="input-group mb-3" style="margin-left:40px; width:100%;">
                          <!-- <input type="number" class="form-control" style="width:25%"  id="gst" value="" aria-label="currency" aria-describedby="currencySelect"> -->
                          <select class="form-select2 w-100" style="width:45%; background-color: #f3f3f3" id="currencySelect" aria-label="Currency">
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                            <option value="GBP">GBP</option>  
                            <option value="GBP">INR</option>              
                          </select>
                        </div>
                        <!-- <input class="form-control" style="width:70%;" name="gst" type="text" id="gst" value=""> -->
                      </div>
                    
                      <div class="dropdown">
                          <button class="btn btn-outline-primary dropdown-toggle mx-1" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Add more products
                          </button>                          
                      </div>
                      <button class="btn btn-outline-success mx-1" type="button" aria-expanded="false" data-bs-toggle="modal" data-bs-target="#AttriModal">
                          Customize Table
                      </button>
                      <button class="btn btn-dark mx-1" type="button" aria-expanded="false">
                          Save quotation
                      </button>
                  </div>
                  
              </div>
            </div>
        </div>
          
        
        <div class="row mt-3 text-muted mx-3" style="">
            <p> 3 Products added
            </p>

        </div>
        <div class="row mt-3">
            <div class="col-lg-12 ">
                <div class="table-responsive">
                    <table class="table ">
                        <thead>
                            <tr>
                                <th><input type="checkbox" aria-label="Checkbox for following text input"></th>
                                <!-- Checkbox header -->
                                <th>Image</th>
                                <th>Product ID</th>
                                <th>Variant ID</th>
                                <th>COO</th>
                                <th colspan="3">Selling Price</th>
                                <th>New Head</th> <!-- Your new header -->
                            </tr>
                            <tr>
                                <th></th>
                                <th></th> <!-- Image sub-header -->
                                <th></th> <!-- Product ID sub-header -->
                                <th></th> <!-- Variant ID sub-header -->
                                <th></th> <!-- COO sub-header -->
                                <th>Currency</th>
                                <th>Price</th>
                                <th>Unit</th>
                                <th></th> <!-- New Head sub-header -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="sticky-col first-col"><input type="checkbox"><span
                                        style="margin-left: 10px;">1</span></td>
                                <td class="sticky-col second-col">T-28158</td>
                                <td class="sticky-col third-col"></td>
                                <td><input type="text" class="form-control" style="width:60%"></td>
                                <td></td>
                                <td>USD</td>
                                <td>15.25</td>
                                <td>per piece</td>
                                <td></td>


                                {{-- <td class="sticky-col thirteenth-col">$0</td> --}}
                            </tr>
                            <tr>
                                <td class="sticky-col first-col"><input type="checkbox"><span
                                        style="margin-left: 10px;">2</span></td>
                                <td class="sticky-col second-col">G-3900928</td>
                                <td class="sticky-col third-col"></td>
                                <td><input type="text" class="form-control" style="width:60%"></td>
                                <td></td>
                                <td><input type="text" class="form-control" style="width:60%"></td>

                                {{-- <td class="sticky-col thirteenth-col">$0</td> --}}
                            </tr>
                            <tr>
                                <td class="sticky-col first-col"><input type="checkbox"><span
                                        style="margin-left: 10px;">3</span></td>
                                <td class="sticky-col second-col">R-8158</td>
                                <td class="sticky-col third-col"></td>
                                <td><input type="text" class="form-control" style="width:60%"></td>
                                <td></td>
                                <td><input type="text" class="form-control" style="width:60%"></td>

                                {{-- <td class="sticky-col thirteenth-col">$0</td> --}}
                            </tr>
                            <!-- Repeat rows as needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="row mt-3 justify-content-start">
          <div class="col-lg-5 col-md-5 d-flex align-items-center">
              <input type="text" class="form-control" placeholder="Add remarks here">
              {{-- <button class="btn btn-primary mx-2 ms-2">Edit</button> --}}
          </div>
      </div>


    </div>
    {{-- offcanvas --}}  
    {{-- <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasCurrency" aria-labelledby="offcanvasCurrencyLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasCurrencyLabel">Convert Currency</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div> --}}
        {{-- <div class="offcanvas-body">
            <!-- Typeable select menu (using Bootstrap 5's custom select) -->
            <input class="form-control" list="currencyList" id="currencyInput" placeholder="Type to search...">
            <datalist id="currencyList">
                <option value="USD">United States Dollar</option>
                <option value="EUR">Euro</option>
                <option value="JPY">Japanese Yen</option> 
                <!-- Add other currencies as needed -->
            </datalist>
        </div> --}}
    </div>


    {{-- modal --}}

    <div class="modal fade" id="AttriModal" tabindex="-1" aria-labelledby="AttriModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="background-color:#ffff; max-width:1300px !important;">
            <div class="modal-content" style="margin-top:0%;">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="AttriModalLabel">Select Attributes</h1>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>
                <div class="modal-body">
                    <div class="col-md-6 col-12 my-3" style="overflow: auto; max-height: 80vh">
                        <span style="margin-top: -10px;">
                            <i class="ik ik-info fa-2x text-warning ml-2 remove-ik-class"
                                title="These Values will be Updated on All selected Products"></i>
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
                                                <label for="check_all"
                                                    style="font-size: 12.8px; font-family:Nunito Sans, sans-serif;font-weight:700;user-select: none;">Select
                                                    All</label>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="row">
                                            <div class="form-group h-100"
                                                style="cursor: pointer; margin-bottom:0rem!important;">
                                                <input type="checkbox" value=" id="" class="my_attribute d-none mx-1"
                                                    name="myfields[]" data-index="">
                                                <label for="attri_" class="form-label w-100 h-100"
                                                    style="font-size: 12.8px;font-family:Nunito Sans, sans-serif; user-select: none;">Attribute
                                                    1 </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">
                                            <div class="form-group h-100"
                                                style="cursor: pointer; margin-bottom:0rem!important;">
                                                <input type="checkbox" value="" id="attri_"
                                                    class="my_attribute d-none mx-1" name="myfields[]" data-index="">
                                                <label for="attri_" class="form-label w-100 h-100"
                                                    style="font-size: 12.8px;font-family:Nunito Sans, sans-serif; user-select: none;">Attribute
                                                    2 </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">
                                            <div class="form-group h-100"
                                                style="cursor: pointer; margin-bottom:0rem!important;">
                                                <input type="checkbox" value="" id="attri_"
                                                    class="my_attribute d-none mx-1" name="myfields[]" data-index="">
                                                <label for="attri_" class="form-label w-100 h-100"
                                                    style="font-size: 12.8px;font-family:Nunito Sans, sans-serif; user-select: none;">Attribute
                                                    3 </label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="row">
                                            <div class="form-group h-100"
                                                style="cursor: pointer; margin-bottom:0rem!important;">
                                                <input type="checkbox" value="" id="attri_ class="my_attribute
                                                    d-none mx-1" name="myfields[]" data-index="">
                                                <label for="attri_ class="form-label w-100 h-100"
                                                    style="font-size: 12.8px;font-family:Nunito Sans, sans-serif; user-select: none;">Attribute
                                                    4 </label>
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
    $("#9uou").click(function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var msg = "<div class='offcanvas-body'><input class='form-control' list='currencyList' id='currencyInput' placeholder='Type to search...'><datalist id='currencyList'><option value='USD'>United States Dollar</option><option value='EUR'>Euro</option><option value='JPY'>Japanese Yen</option></datalist></div>";
        
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
                    // action: function () {
                    //     // Redirect to the second view route
                    //     window.location.href = "{{ route('panel.Documents.secondview') }}";
                    // }
                },
                close: function () {
                    // Additional action if needed upon dialog close
                }
            }
        });
    });



      
      // $(function () {
      //   $("#mybro").select2()
      // });

      


      
  });
  
</script>

    <script>
        // function proceedTothirdView() {
        //     // Redirect to the route for second view
        //     window.location.href = "{{ route('panel.Documents.thirdview') }}";
        // }


        function goBack() {
            window.history.back()
        }
    </script>

@endsection
