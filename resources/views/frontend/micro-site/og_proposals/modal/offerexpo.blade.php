   @push('head')
       <style>
           /* Style the navigation menu */
           .topnav {
               overflow: hidden;
               background-color: #333;
               position: relative;
           }

           /* Hide the links inside the navigation menu (except for logo/home) */
           .topnav #myLinks {
               display: none;
           }

           /* Style navigation menu links */
           .topnav a {
               color: white;
               padding: 14px 16px;
               text-decoration: none;
               font-size: 17px;
               display: block;
           }

           /* Style the hamburger menu */
           .topnav a.icon {
               background: black;
               display: block;
               position: absolute;
               right: 0;
               top: 0;
           }

           /* Add a grey background color on mouse-over */
           .topnav a:hover {
               background-color: #ddd;
               color: black;
           }
       </style>
   @endpush


   <!-- Modal -->
   <div class="modal fade" id="staticBackdrop" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel"
       aria-hidden="false">
       <div class="modal-dialog modal-lg" style="position:fixed; right:5px; top:0%">
           <div class="modal-content modal-lg">

               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

               {{-- <div class="modal-header justify-content-center;">
                        <div class="col-10 d-flex justify-content-center align-items-center"
                            style="background-color: #fff;">
                            <a href="#one" class="btn btn-link text-primary mx-2 active">1. Selection</a>                        
                        </div>
                    </div>  --}}
               <div class="modal-body">


                   <!-- Load an icon library to show a hamburger menu (bars) on small screens -->
                   {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}

                   <!-- Top Navigation Menu -->
                   <div class="topnav">
                       <a href="#home" class="active">Search</a>
                       <div id="myLinks">

                           <div class="col-lg-12 d-flex justify-content-center">
                               <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="padding: 10px;">
                                   <li class="nav-item" role="presentation">
                                       <a href="" id="openqr">
                                           <button class="nav-link btn-outline-primary active mx-5"
                                               id="pills-scan_QR-tab" data-bs-toggle="pill"
                                               data-bs-target="#pills-scan_QR" role="tab"
                                               aria-controls="pills-scan_QR" aria-selected="true">Scan QR</button>
                                       </a>
                                   </li>
                                   <li class="nav-item" role="presentation">
                                       <button class="nav-link btn-outline-danger mx-5" id="pills-Image_Search-tab"
                                           data-bs-toggle="pill" data-bs-target="#pills-Image_Search" type="button"
                                           role="tab" aria-controls="pills-Image_Search" style="color:red;"
                                           aria-selected="false">Image
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


                           {{-- <a href="#news">
                            <button class="nav-link btn-outline-primary  mx-5" id="pills-scan_QR-tab"
                            data-bs-toggle="pill" data-bs-target="#pills-scan_QR"  role="tab"
                            aria-controls="pills-scan_QR" aria-selected="true">Scan QR</button>
                        </a>                    
                        <a href="#contact">
                            <button class="nav-link btn-outline-danger mx-5" id="pills-Image_Search-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-Image_Search" type="button"
                                    role="tab" aria-controls="pills-Image_Search" style="color:red;" aria-selected="false">Image
                                    Search</button>
                        </a>
                        <a href="#about">
                            <button class="nav-link btn-outline-primary mx-5" id="pills-By_Filters-tab"
                                    data-bs-toggle="pill" data-bs-target="#pills-By_Filters" type="button"
                                    role="tab" aria-controls="pills-By_Filters" aria-selected="false">By
                                    Filters</button>
                        </a> --}}
                       </div>
                       <!-- "Hamburger menu" / "Bar icon" to toggle the navigation links -->
                       <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                           <i class="fa fa-bars"></i>
                       </a>
                   </div>


                   <!-- Search bar -->
                   {{-- <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="col-lg-4 input-group border rounded">
                
                                <input type="text" id="quicktitle" value="" name="title" class="form-control border-0"
                                    placeholder="Search by Name or Model Code">
                                <button type="submit" class="input-group-text bg-white border-0" id="searchsubmit">
                                    <svg width="18" height="18" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="currentColor"
                                            d="m479.6 399.716l-81.084-81.084l-62.368-25.767A175.014 175.014 0 0 0 368 192c0-97.047-78.953-176-176-176S16 94.953 16 192s78.953 176 176 176a175.034 175.034 0 0 0 101.619-32.377l25.7 62.2l81.081 81.088a56 56 0 1 0 79.2-79.195M48 192c0-79.4 64.6-144 144-144s144 64.6 144 144s-64.6 144-144 144S48 271.4 48 192m408.971 264.284a24.028 24.028 0 0 1-33.942 0l-76.572-76.572l-23.894-57.835l57.837 23.894l76.573 76.572a24.028 24.028 0 0 1-.002 33.941">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div> --}}


                   <div class="tab-content" id="pills-tabContent">
                       <div class="tab-pane fade show active" id="pills-scan_QR" role="tabpanel"
                           aria-labelledby="pills-scan_QR-tab" tabindex="0">

                           <div class="d-flex justify-content-center">
                               <button class="btn btn-outline-secondary d-flex d-none" id="openqr"
                                   type="button">Scan
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


                       <div class="tab-pane fade" id="pills-By_Filters" role="tabpanel"
                           aria-labelledby="pills-By_Filters-tab" tabindex="2">
                           <div class="col-12 adwas">

                               <div class="card border-0 sidebar custom-scrollbar">
                                   <form form role="search" method="GET" id="searchform"
                                       class="card-body filter-body p-0 applyFilter d-none d-md-block mobile_filter">
                                       <input type="hidden" name="sort" value="" class="sortValue">
                                       <h5 class="widget-title pt-3 pl-15" style="display: inline-block;">Filters
                                       </h5>

                                       <h6 class="widget-title mt-2">Price</h6>
                                       <div class=" d-flex">
                                           @php
                                               $request = request();
                                           @endphp
                                           <input style="width: 70px;height: 35px;"
                                               @if (request()->has('from') && request()->get('from') != null) value="{{ request()->get('from') }}" @endif
                                               type="text" name="from" class="form-control"
                                               placeholder=" Min  ">
                                           <input style="width: 70px;height: 35px;"
                                               @if (request()->has('to') && request()->get('to') != null) value="{{ request()->get('to') }}" @endif
                                               type="text" name="to" class="form-control ms-2"
                                               placeholder=" Max ">
                                           <button class="price_go_btn ms-2" type="submit">GO</button>
                                       </div>

                                       {{-- categories Ashish --}}
                                       <div class="widget">
                                           <!-- Categories -->
                                           <div class="widget bt-1 pt-3">
                                               <div class="accordion-item my-2">
                                                   <h2 class="accordion-header">
                                                       <button class="accordion-button collapsed" type="button"
                                                           data-bs-toggle="collapse" data-bs-target="#collapscatrgory"
                                                           aria-expanded="true" aria-controls="collapscatrgory"
                                                           style="height: 25px !important;">
                                                           <h6 class="widget-title mt-2">Categories</h6>
                                                       </button>
                                                   </h2>
                                                   <div id="collapscatrgory" class="accordion-collapse collapse"
                                                       data-bs-parent="#accordionExample">
                                                       <div class="accordion-body">
                                                           <ul class="list-unstyled mt-1 mb-0 custom-scrollbar"
                                                               style="padding-left:1rem">
                                                               <li>
                                                                   <h5 class="form-check">
                                                                       <input class="form-check-input" type="radio"
                                                                           @if (!request()->has('category_id') || request()->get('category_id') == null) checked @endif
                                                                           value="" id="categoryAll"
                                                                           name="category_id">
                                                                       <label for="categoryAll"
                                                                           class="form-check-label fltr-lbl">
                                                                           All</label>
                                                                   </h5>
                                                               </li>
                                                               @if (!empty($categories))
                                                                   @foreach ($categories as $item)
                                                                       @php
                                                                           $sub_category = App\Models\Category::whereId(request()->get('sub_category_id'))->first();
                                                                       @endphp
                                                                       <li>
                                                                           <h5 class="form-check"
                                                                               style="display: flex;align-items: center;gap: 6px;">
                                                                               <input
                                                                                   class="form-check-input filterCategory"
                                                                                   type="radio"
                                                                                   value="{{ $item->id }}"
                                                                                   id="category{{ $item->id }}"
                                                                                   name="category_id"
                                                                                   @if (request()->has('category_id') && request()->get('category_id') == $item->id) checked @endif>
                                                                               <label for="category{{ $item->id }}"
                                                                                   class="form-check-label fltr-lbl mt-2">
                                                                                   {{ $item->name }}
                                                                                   {{--  Category Count --}}
                                                                                   <span
                                                                                       style="font-size: 11px">({{ getProductCountViaCategoryId($item->id, $user_shop->user_id) }})</span>
                                                                               </label>
                                                                           </h5>
                                                                       </li>
                                                                       @if (request()->has('category_id') && request()->get('category_id') == $item->id)
                                                                           @php
                                                                               $subcategories = getProductSubCategoryByShop($slug, $item->id, 0);
                                                                           @endphp
                                                                           <div
                                                                               style="padding-left: 25px; display: flex;align-items: center;gap: 6px;">
                                                                               <ul
                                                                                   class="list-unstyled custom-scrollbar">
                                                                                   @foreach ($subcategories as $subcategorie)
                                                                                       <li>
                                                                                           <h5 class="form-check">
                                                                                               <input
                                                                                                   class="form-check-input filterSubCategory"
                                                                                                   type="radio"
                                                                                                   value="{{ $subcategorie->id }}"
                                                                                                   id="category{{ $subcategorie->id }}"
                                                                                                   name="sub_category_id"
                                                                                                   @if (request()->has('sub_category_id') && request()->get('sub_category_id') == $subcategorie->id) checked @endif>
                                                                                               <label
                                                                                                   for="category{{ $subcategorie->id }}"
                                                                                                   class="form-check-label fltr-lbl">
                                                                                                   {{ $subcategorie->name }}
                                                                                                   {{-- Sub Category Count --}}
                                                                                                   <span
                                                                                                       style="font-size: 11px">
                                                                                                       ({{ getProductCountViaSubCategoryId($subcategorie->id, $user_shop->user_id) }})
                                                                                                   </span>
                                                                                               </label>
                                                                                           </h5>
                                                                                       </li>
                                                                                   @endforeach
                                                                               </ul>
                                                                           </div>
                                                                       @endif
                                                                   @endforeach
                                                               @endif
                                                           </ul>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                           {{-- categories Ashish --}}


                                           <div class="accordion-item my-2 d-none">
                                               <h2 class="accordion-header">
                                                   <button class="accordion-button collapsed" type="button"
                                                       data-bs-toggle="collapse" data-bs-target="#collapsesupplier"
                                                       aria-expanded="true" aria-controls="collapsesupplier"
                                                       style="height: 25px !important;">
                                                       <h6 class="widget-title mt-2">Supplier</h6>
                                                   </button>
                                               </h2>
                                               <div id="collapsesupplier" class="accordion-collapse collapse"
                                                   data-bs-parent="#accordionExample">
                                                   <div class="accordion-body">
                                                       @if (isset($suppliers) && $suppliers->count() >= 0)
                                                           <ul class="list-unstyled mt-2 mb-0 custom-scrollbar"
                                                               style="height: 60px;">
                                                               <li>
                                                                   <input class="form-check-input" type="checkbox"
                                                                       value="yes" id="ownproduct"
                                                                       name="ownproduct"
                                                                       @if ($request->has('ownproduct') == 'yes') checked @endif>
                                                                   <label for="ownproduct"
                                                                       class="form-check-label fltr-lbl ">Own
                                                                       Product</label>
                                                               </li>
                                                               @foreach ($suppliers as $supplier)
                                                                   @if ($supplier != '' || $supplier != null)
                                                                       <li>
                                                                           <h5 class="form-check">

                                                                               <input class="form-check-input"
                                                                                   type="checkbox"
                                                                                   value="{{ $supplier->id }}"
                                                                                   id="supplierid{{ $supplier->id }}"
                                                                                   name="supplier[]"
                                                                                   @if (request()->has('supplier')) @if (isset($supplier) && in_array($supplier->id, request()->get('supplier')))
                                                                        checked @endif
                                                                                   @endif >
                                                                               <label
                                                                                   for="supplierid{{ $supplier->id }}"
                                                                                   class="form-check-label fltr-lbl ">
                                                                                   {{ $supplier->name }}
                                                                               </label>
                                                                           </h5>
                                                                       </li>
                                                                   @endif
                                                               @endforeach
                                                           </ul>
                                                       @endif
                                                   </div>
                                               </div>
                                           </div>

                                           @if (isset($TandADeliveryPeriod) && $TandADeliveryPeriod->count() > 0)
                                               <div class="accordion-item my-2">
                                                   <h2 class="accordion-header">
                                                       <button class="accordion-button collapsed" type="button"
                                                           data-bs-toggle="collapse"
                                                           data-bs-target="#collapseDelivery" aria-expanded="true"
                                                           aria-controls="collapseDelivery"
                                                           style="height: 25px !important;">
                                                           <h6 class="widget-title mt-2">T&A</h6>
                                                       </button>
                                                   </h2>
                                                   <div id="collapseDelivery" class="accordion-collapse collapse"
                                                       data-bs-parent="#accordionExample">
                                                       <div class="accordion-body">
                                                           <ul class="list-unstyled mt-2 mb-0 custom-scrollbar"
                                                               style="height: 120px;">
                                                               <div class="widget my-2">
                                                                   <input style="height: 35px; width: 75px"
                                                                       @if (request()->has('quantity') && request()->get('quantity') != null) value="{{ request()->get('quantity') }}" @endif
                                                                       type="text" name="quantity"
                                                                       class="form-control" placeholder="Qty">
                                                               </div>
                                                               @foreach ($TandADeliveryPeriod as $color)
                                                                   @if ($color != '' || $color != null)
                                                                       <li>
                                                                           <h5 class="form-check">
                                                                               <input class="form-check-input"
                                                                                   type="checkbox"
                                                                                   value="{{ $color }}"
                                                                                   id="deliveryID{{ $color }}"
                                                                                   name="delivery[]"
                                                                                   @if (request()->has('delivery')) @if (isset($color) && in_array($color, request()->get('delivery')))
                                                                checked @endif
                                                                                   @endif >
                                                                               <label
                                                                                   for="deliveryID{{ $color }}"
                                                                                   class="form-check-label fltr-lbl ">
                                                                                   {{ $color . ' Days' }}
                                                                               </label>
                                                                           </h5>
                                                                       </li>
                                                                   @endif
                                                               @endforeach
                                                           </ul>
                                                       </div>
                                                   </div>
                                               </div>
                                           @endif

                                           {{-- Applying scoobooo layout in color and other attri --}}
                                           @if (isset($additional_attribute) && $additional_attribute->count() >= 0)
                                               @foreach ($additional_attribute as $key => $item)
                                                   @php
                                                       $testchk = getAttruibuteById($item);
                                                   @endphp
                                                   @if (isset($testchk) && getAttruibuteById($item)->visibility == 1)
                                                       <div class="container1 mt-3">
                                                           <!-- Collapsible Button -->
                                                           <h6 class="collapsible" data-bs-toggle="collapse"
                                                               data-bs-target="#AttributeList_{{ $key }}"
                                                               aria-expanded="false"
                                                               aria-controls="AttributeList_{{ $key }}">
                                                               {{ getAttruibuteById($item)->name }}
                                                               <i class="fas fa-chevron-down fa-xs"></i>
                                                           </h6>
                                                           @php
                                                               $atrriBute_valueGet = getParentAttruibuteValuesByIds($item, $proIds);
                                                           @endphp
                                                           <div class="collapse"
                                                               id="AttributeList_{{ $key }}">
                                                               <ul class="list-unstyled mt-2 mb-0 custom-scrollbar">
                                                                   @foreach ($atrriBute_valueGet as $mater)
                                                                       @if ($mater != '' || $mater != null)
                                                                           <li>
                                                                               <h5 class="form-check">
                                                                                   <input class="form-check-input"
                                                                                       type="checkbox"
                                                                                       value="{{ $mater }}"
                                                                                       id="searchId{{ $mater }}"
                                                                                       name="searchVal_{{ $key }}[]"
                                                                                       @if (request()->has("searchVal_$key")) @if (isset($mater) && in_array($mater, request()->get("searchVal_$key")))
                                                                                                                                    checked @endif
                                                                                       @endif >
                                                                                   <label
                                                                                       for="searchId{{ $mater }}"
                                                                                       class="form-check-label fltr-lbl ">
                                                                                       {{ getAttruibuteValueById($mater)->attribute_value ?? '' }}
                                                                                   </label>
                                                                               </h5>
                                                                           </li>
                                                                       @endif
                                                                   @endforeach
                                                               </ul>
                                                           </div>
                                                       </div>
                                                   @endif
                                               @endforeach
                                           @endif
                                           {{-- Applying scoobooo layout in color and other attri End --}}
                                           {{-- Exclusive Products --}}

                                           {{-- <h6 class="widget px-2">Exclusive Products</h6> --}}
                                           <div class="mx-2 d-flex">
                                               <input type="checkbox" class="form-check-input visually-hidden"
                                                   name="exclusive" id="exclusive"
                                                   @if ($request->get('exclusive')) checked @endif>
                                               <label class="form-check-label mx-2" id="excl">Exclusive
                                                   Items</label>
                                               @if ($request->get('exclusive') == 'on')
                                                   <div class="text-success" style="font-weight: bolder">
                                                       <i class="uil-check-circle" style="font-size: 20px"></i>
                                                   </div>
                                               @else
                                                   {{-- <div class="text-danger" style="font-weight: bolder"> OFF </div> --}}
                                               @endif
                                           </div>

                                           <div class="mx-2 d-flex my-3">
                                               <input type="checkbox" class="form-check-input " name="pinned"
                                                   id="pinned" @if ($request->get('pinned')) checked @endif>
                                               <label class="form-check-label mx-2" id="pinnedbtn"
                                                   for="pinned">Pinned Items
                                                   Only</label>
                                               @if ($request->get('pinned') == 'on')
                                                   <div class="text-success" style="font-weight: bolder">
                                                       <i class="uil-check-circle" style="font-size: 20px"></i>
                                                   </div>
                                               @else
                                                   {{-- <div class="text-danger" style="font-weight: bolder"> OFF </div> --}}
                                               @endif
                                           </div>

                                           {{-- Exclusive Products --}}



                                       </div>
                                   </form>
                               </div>
                               {{-- <div class="col-md-3 col-lg-4"> --}}
                               <div class="row justify-content-between">
                                   <div class="col-6 col-md-6 col-lg-6">
                                       <button type="submit" class="btn btn-sm mt-2 d-block btn-primary w-100"
                                           id="filterBtn" form="searchform">Filter</button>
                                   </div>
                                   <div class="col-6 col-md-6 col-lg-6">
                                       <a class="btn btn-sm mt-2 d-block btn-primary w-100"
                                           href="{{ route('pages.shop-index') }}" id="resetButton">Reset</a>
                                   </div>

                               </div>
                               {{-- <button type="submit" class="btn mt-2 d-block btn-primary w-100" id="filterBtn" form="searchform">Filter</button>
                                                                            @if (isset($proposalid) && $proposalid != -1)
                                                                                <a class="btn mt-2 d-block btn-primary w-100" href="{{ route('pages.proposal.edit',['proposal' => $proposalid,'user_key' => $user_key]) }}?margin=0" id="resetButton">Reset</a>
                                                                            @else
                                                                                <a class="btn mt-2 d-block btn-primary w-100" href="{{route('pages.shop-index')}}" id="resetButton">Reset</a>
                                                                            @endif --}}
                               {{-- </div> --}}


                           </div><!--end col-->
                       </div>
                   </div>

               </div>
               {{-- <div class="modal-footer">

                                                                       </div> --}}
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
   {{-- <script>
       
       function myFunction() {
           var x = document.getElementById("myLinks");
           if (x.style.display === "block") {
               x.style.display = "none";
           } else {
               x.style.display = "block";
           }
       }
   </script> --}}

   <script>
       document.addEventListener("DOMContentLoaded", function() {
           const scanQRButton = document.getElementById("pills-scan_QR-tab");
           const imageSearchButton = document.getElementById("pills-Image_Search-tab");
           const filtersButton = document.getElementById("pills-By_Filters-tab");

           scanQRButton.classList.add("active");

           imageSearchButton.addEventListener("click", function() {
               scanQRButton.classList.remove("active");
               imageSearchButton.classList.add("active");
               filtersButton.classList.remove("active");
           });

           filtersButton.addEventListener("click", function() {
               scanQRButton.classList.remove("active");
               imageSearchButton.classList.remove("active");
               filtersButton.classList.add("active");
           });
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
