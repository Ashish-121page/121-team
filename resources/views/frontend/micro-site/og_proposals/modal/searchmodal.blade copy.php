   <!-- Modal -->
   <div class="modal fade" id="staticBackdrop" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel"
       aria-hidden="false">
       <div class="modal-dialog modal-lg">
           <div class="modal-content modal-lg">
               <div class="modal-header justify-content-center;">
                   <h1 class="modal-title fs-5" id="staticBackdropLabel">Filters</h1>
                   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                   <!-- Search bar -->
                   <div class="col-12 input-group border rounded justify-content-center">

                       <input type="text" id="quicktitle" value="" name="title"
                           class="form-control border-0" placeholder="Search Buyer name or..">
                       <button type="submit" class="input-group-text bg-white border-0" id="searchsubmit">
                           <svg width="18" height="18" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                               <path fill="currentColor"
                                   d="m479.6 399.716l-81.084-81.084l-62.368-25.767A175.014 175.014 0 0 0 368 192c0-97.047-78.953-176-176-176S16 94.953 16 192s78.953 176 176 176a175.034 175.034 0 0 0 101.619-32.377l25.7 62.2l81.081 81.088a56 56 0 1 0 79.2-79.195M48 192c0-79.4 64.6-144 144-144s144 64.6 144 144s-64.6 144-144 144S48 271.4 48 192m408.971 264.284a24.028 24.028 0 0 1-33.942 0l-76.572-76.572l-23.894-57.835l57.837 23.894l76.573 76.572a24.028 24.028 0 0 1-.002 33.941">
                               </path>
                           </svg>
                       </button>
                   </div>

                   <div class="col-lg-12 d-flex justify-content-center">

                       <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="padding: 10px;">
                           <li class="nav-item" role="presentation">
                               <button class="nav-link btn-outline-primary active mx-5" id="pills-scan_QR-tab"
                                   data-bs-toggle="pill" data-bs-target="#pills-scan_QR" type="button" role="tab"
                                   aria-controls="pills-scan_QR" aria-selected="true">Scan QR</button>
                           </li>
                           <li class="nav-item" role="presentation">
                               <button class="nav-link btn-outline-primary mx-5" id="pills-Image_Search-tab"
                                   data-bs-toggle="pill" data-bs-target="#pills-Image_Search" type="button"
                                   role="tab" aria-controls="pills-Image_Search" aria-selected="false">Image
                                   Search</button>
                           </li>
                           <li class="nav-item" role="presentation">
                               <button class="nav-link btn-outline-primary mx-5" id="pills-By_Filters-tab"
                                   data-bs-toggle="pill" data-bs-target="#pills-By_Filters" type="button"
                                   role="tab" aria-controls="pills-By_Filters" aria-selected="false">By
                                   Filters</button>
                           </li>
                       </ul>

                   </div>
                   <div class="tab-content" id="pills-tabContent">
                       <div class="tab-pane fade show active" id="pills-scan_QR" role="tabpanel"
                           aria-labelledby="pills-scan_QR-tab" tabindex="0">

                           <div class="d-flex justify-content-center">
                               <button class="btn btn-outline-secondary d-flex" id="openqr" type="button">Scan
                                   <span class="d-none d-md-block">&nbsp;QR Codes</span>
                               </button>
                           </div>

                       </div>
                       <div class="tab-pane fade" id="pills-Image_Search" role="tabpanel"
                           aria-labelledby="pills-Image_Search-tab" tabindex="1">
                           <form action="{{ route('panel.search.search.result') }}" method="POST"
                               enctype="multipart/form-data">
                               <div class="row">
                                   <div class="col-12 col-md-6 d-none">
                                       <label for="AssetVaultname"> Vaults to Search </label>
                                       <select name="AssetVaultname[]" id="AssetVaultname" class="form-control ">
                                           {{-- <option selected>All</option> --}}
                                           <option value="one">Name 1</option>
                                           <option value="two">Name 2</option>
                                           <option value="three">Name 3</option>
                                           <option value="four">Name 4</option>
                                       </select>
                                   </div>
                                   <div class="col-12 col-md-6 d-none">
                                       <label for="productcatname">Product</label>
                                       <select name="productcatname[]" id="productcatname" class="form-control">
                                           {{-- <option selected>All</option> --}}
                                           <option value="one">Category Name 1</option>
                                           <option value="two">Category Name 2</option>
                                           <option value="three">Category Name 3</option>
                                           <option value="four">Category Name 4</option>
                                       </select>
                                   </div>

                                   <div class="col-12 d-flex justify-content-center flex-column align-items-center ">
                                       <div class=" mb-2">
                                           <input type="file" id="searchimg" name="searchimg" class="d-none">
                                           <label for="searchimg" style="height: 250px">
                                               <img src="{{ asset('frontend\assets\website\ASSETVAULT.png') }}"
                                                   alt="img" style="height: 100%;object-fit: contain;"
                                                   id="mynewimage">
                                           </label>
                                       </div>

                                       <button
                                           class="btn btn-primary d-none align-items-center shadow-none mb-2 MYSEACHBTN"
                                           style="transform: scale(120%)">
                                           <span class="mx-2">Search</span>
                                           
                                       </button>

                                       <div class="alert alert-Primary my-3 mb-2" role="alert">
                                           <i class="ik ik-info mr-1" title="Search"></i>
                                           Search

                                          
                                       </div>
                                       <span class="mx-2">Upgrade to Premium to search PDF and Excel in your Vaults
                                    </span>
                                   </div>


                                   


                               </div>
                           </form>
                           {{-- <iframe src="https://example.com" width="100%" height="500px"></iframe> --}}


                       </div>


                       
                   </div>





               </div>
               <div class="modal-footer">

               </div>
           </div>
       </div>
   </div>
   @include('frontend.micro-site.proposals.modal.scanQR')
   <script>
       $('.barCodeModal').click(function() {
           html5QrcodeScanner.render(onScanSuccess);
           $('#barCodeModal').modal('show');
       });
   </script>


   <script>
       const triggerEl = document.querySelector('#pills-tab button[data-bs-target="#pills-scan_QR"]')
       bootstrap.Tab.getInstance(triggerEl).show();

       const triggerEl = document.querySelector('#pills-tab button[data-bs-target="#pills-Image_Search"]')
       bootstrap.Tab.getInstance(triggerEl).show();

       const triggerEl = document.querySelector('#pills-tab button[data-bs-target="#pills-By_Filters"]')
       bootstrap.Tab.getInstance(triggerEl).show()
   </script>
