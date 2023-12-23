@extends('backend.layouts.main')
@section('title', 'Quotation')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> --}}

    @endpush

    <div class="container-fluid">


        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 sidebar mt-3">
                <!-- Sidebar content -->
                <h6 style="font-weight:900">
                    </h2>

                    <div class="sidebar-section mt-5">
                        <h6>All Documents</h6>

                    </div>
                    <div class="sidebar-section h6">
                        <a class="" href="{{ route('panel.Documents.Quotation') }}">Quotations</a>

                    </div>
                    <div class="sidebar-section h6">
                        <a href="{{ route('panel.Documents.index') }}">Invoice</a>

                    </div>
            </div>
            <div class="col-lg-10 mt-3">
                <!-- Main content goes here -->
                <div class="mt-5">
                    <div class="row">
                        <div class="col-lg-8 col-md-8">
                            <div class="col-lg-4 col-md-5 input-group border rounded">
                                <input type="text" id="quicktitle" value="" name="title"
                                    class="form-control border-0" placeholder="Search Buyer name or..">
                                <button type="submit" class="input-group-text bg-white border-0" id="searchsubmit"><svg width="18" height="18" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                    <path fill="currentColor" d="m479.6 399.716l-81.084-81.084l-62.368-25.767A175.014 175.014 0 0 0 368 192c0-97.047-78.953-176-176-176S16 94.953 16 192s78.953 176 176 176a175.034 175.034 0 0 0 101.619-32.377l25.7 62.2l81.081 81.088a56 56 0 1 0 79.2-79.195M48 192c0-79.4 64.6-144 144-144s144 64.6 144 144s-64.6 144-144 144S48 271.4 48 192m408.971 264.284a24.028 24.028 0 0 1-33.942 0l-76.572-76.572l-23.894-57.835l57.837 23.894l76.573 76.572a24.028 24.028 0 0 1-.002 33.941"/>
                                </svg>
                                </button>
                            </div>
                        </div>
                        <div class="col-4 d-flex justify-content-end align-items-center">
                            {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#BuyerModal"> --}}
                            <button type="button" id="bjkhkh" class="btn btn-outline-primary mx-1">
                                Create new quotation
                            </button>
                        </div>
                    </div>

                    <!-- Other elements (filter, select, buttons) -->
                    <div class="row mt-3 justify-content-between ">
                        {{-- <div class="col-2">
                          <input type="text" class="form-control" id="search_buyer" name="search" placeholder="Buyer Search">
                        </div> --}}
                        <!-- Filter options -->
                        {{-- <div class="col-2" style="margin-left:10rem">
                          <select name="" id="status_check" class="form-control" style="padding-right: 40px !important;">
                            <option value="status">All</option>
                            <option value="sent">Sent</option>
                            <option value="draft">Draft</option>
                          </select>
                        </div> --}}

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
                                            <td class="col-2">Enquiry ID</td>
                                            <td class="col-2">Buyer Name</td>
                                            <td class="col-2">Buyer Email </td>
                                            <td class="col-2">Created On</td>
                                            <td class="col-4"></td>
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
                                                <!-- {{-- @if ($scoped_product->user_id == auth()->id()) --}} -->
                                                <!-- {{-- <input type="checkbox" name="exportproduct" id="exportproduct" class="input-check"> --}} -->
                                                <!-- {{-- @endif --}} -->
                                            </td>
                                            <td class="justify-content-between">
                                                <div class="py-1">
                                                    1
                                                    {{-- <!-- <img src="{{ asset($mediarecord->path) ?? '' }}" alt="" class="img-fluid p-1" style="border-radius: 10px;height: 100%;width: 100%;background-color: gray;align-items: center;"> --> --}}
                                                </div>
                                            </td>

                                            <td>
                                                <div class=" py-1">jaya</div>
                                            </td>
                                            <td>
                                                <div class=" py-1">jaya@121mail.com</div>
                                            </td>
                                            <td>
                                                <div class=" py-1">12/20/2023</div>
                                            </td>
                                            <td>

                                            </td>                                            
                                        </tr>

                                        <tr>
                                            <td class="no-export action_btn">
                                                <!-- {{-- @if ($scoped_product->user_id == auth()->id()) --}} -->
                                                <!-- {{-- <input type="checkbox" name="exportproduct" id="exportproduct" class="input-check"> --}} -->
                                                <!-- {{-- @endif --}} -->
                                            </td>
                                            <td class="justify-content-between">
                                                <div class="py-1">
                                                    2
                                                    {{-- <!-- <img src="{{ asset($mediarecord->path) ?? '' }}" alt="" class="img-fluid p-1" style="border-radius: 10px;height: 100%;width: 100%;background-color: gray;align-items: center;"> --> --}}
                                                </div>
                                            </td>

                                            <td>
                                                <div class=" py-1">Pac</div>
                                            </td>
                                            <td>
                                                <div class=" py-1">pac23@gmail.com</div>
                                            </td>
                                            <td>
                                                <div class=" py-1">12/20/2023</div>
                                            </td>
                                            <td>

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
    $("#bjkhkh").click(function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var msg = "<div class='col-lg-12 col-md-12'><div class='row'><div class='col-lg-12 col-md-12'><label for='buyerName'>Buyer Name:</label><br><input type='text' id='buyerName' name='buyerName' class='form-control border rounded' placeholder='Enter'></div><div class='col-lg-12 col-md-12'><label for='buyerEmail'>Buyer Email:</label><br><input type='text' id='buyerEmail' name='buyerEmail' class='form-control border rounded' placeholder='Enter'></div><div class='col-lg-12 col-md-12'><label for='companyName'>Company Name (optional):</label><br><input type='text' id='companyName' name='companyName' class='form-control border rounded' placeholder='Enter'></div></div></div>";      
        $.confirm({
            draggable: true,
            title: ' Add buyer details',
            content: msg,
            type: 'blue',
            typeAnimated: true,
            buttons: {
                tryAgain: {
                    text: 'Confirm',
                    btnClass: 'btn-primary',
                    action: function () {
                        // Redirect to the second view route
                        window.location.href = "{{ route('panel.Documents.quotation2') }}";
                    }
                },
                close: function () {
                    // Additional action if needed upon dialog close
                }
            }
        });
    });



      
      $(function () {
        $("#890out").select2()
      });

      


      
  });
  
</script>
@endsection
