 <!--DEMO01-->
 <div id="vault_modal">
     <div class="close-vault_modal d-flex justify-content-center align-items-center my-2">
         <svg width="32" height="32" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"
             class="text-primary closeanimate">
             <path fill="currentColor"
                 d="M512 0C229.232 0 0 229.232 0 512c0 282.784 229.232 512 512 512c282.784 0 512-229.216 512-512C1024 229.232 794.784 0 512 0m0 961.008c-247.024 0-448-201.984-448-449.01c0-247.024 200.976-448 448-448s448 200.977 448 448s-200.976 449.01-448 449.01m181.008-630.016c-12.496-12.496-32.752-12.496-45.248 0L512 466.752l-135.76-135.76c-12.496-12.496-32.752-12.496-45.264 0c-12.496 12.496-12.496 32.752 0 45.248L466.736 512l-135.76 135.76c-12.496 12.48-12.496 32.769 0 45.249c12.496 12.496 32.752 12.496 45.264 0L512 557.249l135.76 135.76c12.496 12.496 32.752 12.496 45.248 0c12.496-12.48 12.496-32.769 0-45.249L557.248 512l135.76-135.76c12.512-12.512 12.512-32.768 0-45.248" />
         </svg>
         {{-- <span class="ml-2">Add Vault</span> --}}
     </div>

     <div class="modal-content">
         <div class="tab-content" id="pills-tabContent">

             <ul class="nav nav-pills d-none mb-3" id="pills-tab" role="tablist">
                 <li class="nav-item" role="presentation">
                     <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                         data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                         aria-selected="true">Home</button>
                 </li>
                 <li class="nav-item" role="presentation">
                     <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                         data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                         aria-selected="false">Profile</button>
                 </li>
                 <li class="nav-item" role="presentation">
                     <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                         data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                         aria-selected="false">Contact</button>
                 </li>
                 <li class="nav-item" role="presentation">
                     <button class="nav-link" id="pills-disabled-tab" data-bs-toggle="pill"
                         data-bs-target="#pills-disabled" type="button" role="tab" aria-controls="pills-disabled"
                         aria-selected="false">Disabled</button>
                 </li>
             </ul>

             <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                 tabindex="0">
                 <div class="row">
                     <div class="col-12 col-md-12">
                         <div class="row d-flex p-2">
                             <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                 <div class="form-group ">
                                     <label for="vaultname">
                                         Vault Name <span class="text-danger">*</span>
                                         <i class="ik ik-info mr-1"
                                             title="Give product category name or supplier name. Tip : This does not have an impact when Searching across multiple Vaults."></i>
                                     </label>
                                     <input type="text" name="vaultname" id="vaultname"
                                         class="form-control sameinput" list="existvaultname">
                                     <datalist id="existvaultname">
                                         <option value="One">
                                         <option value="Two">
                                         <option value="Three">
                                         <option value="Four">
                                         <option value="Five">
                                     </datalist>
                                 </div>
                                 {{-- <span>Tip : This does not have an impact when Searching across multiple Vaults.</span> --}}
                             </div>
                             <div class="col-12 col-md-6 col-lg-4 col-xl-3 d-none">
                                 <div class="form-group ">
                                     <label for="vaultname">
                                         Reference KW
                                         <i class="ik ik-info mr-1"
                                             title="Give product category name or supplier name."></i>
                                     </label>
                                     <input type="text" name="vaultname" id="tagsforvault"
                                         class="form-control TAGGROUP sameinput" list="existvaultname">
                                 </div>
                             </div>

                         </div>
                     </div>

                     <div class="col-12 d-flex justify-content-center align-items-center flex-column">
                         <div class="mb-3" style="height: 250px">
                             <label for="uploaddata">
                                {{-- <img src="{{ asset('frontend\assets\svg\upload.svg') }}" alt="img" style="height: 100%;object-fit: contain;"> --}}
                                <img src="{{ asset('frontend\assets\website\ASSETVAULT.png') }}" alt="img" style="height: 100%;object-fit: contain;">
                                {{-- <img src="{{ asset('frontend\assets\website\upload-assetvalu.png') }}" alt="img" style="height: 100%;object-fit: contain;"> --}}
                             </label>
                             <input type="file" id="uploaddata" name="uploaddata[]" multiple class="d-none">
                         </div>

                         <div class="mb-3">
                             {{-- <button class="btn btn-outline-primary shadow-none " type="button">Cancel</button> --}}
                             <button class="btn btn-outline-primary shadow-none draftandnext mx-3" type="button">Save
                                 for later</button>
                             <button class="btn btn-primary shadow-none saveandnext mx-3" type="button">Next</button>
                         </div>

                     </div>

                 </div>
             </div>

             <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                 tabindex="0">
                 <div class="row">
                     <div class="col-12 m-1 d-flex justify-content-end align-items-center ">
                         <button type="button" class="btn btn-primary mx-3"
                             style="clip-path: polygon(0% 0%, 75% 0%, 100% 50%, 75% 100%, 0% 100%);">&nbsp;&nbsp;&nbsp;</button>
                     </div>

                     <div class="col-12 m-1 d-flex justify-content-between align-items-center ">
                         <div class="my-3">
                             <span class="h6">Name: <span id="vaultname1">Vault Name</span> </span>
                         </div>
                         <div class="m-3">
                             <button class="btn btn-outline-primary ">Add New</button>
                         </div>

                     </div>
                     <div class="col-12 m-1">
                         <div class="row">
                             <div class="col-2">
                                 <span class="h6">Search KW:</span>
                                 <div class="d-flex flex-wrap " id="appendtags">
                                     {{-- <div class="btn btn-pills btn-primary m-1 " style="width: min-content;border-radius: 20px;">df</div> --}}
                                 </div>


                             </div>
                             <div class="col-4">
                                 <table class="table">
                                     <thead>
                                         <tr>
                                             <th>Nature</th>
                                             <th>No.</th>
                                             <th>Total Size</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <tr class="opentable" data-toggletable="type1table">
                                             <td>Catalogue & Price</td>
                                             <td>5</td>
                                             <td>5 MB</td>
                                         </tr>
                                         <tr>
                                             <td>Products <a href="#link"
                                                     class="btn-link text-primary  toslide3">(View)</a></td>
                                             <td>5</td>
                                             <td>5 MB</td>
                                         </tr>
                                         <tr class="opentable" data-toggletable="type2table">
                                             <td>Vector drawings</td>
                                             <td>5</td>
                                             <td>5 MB</td>
                                         </tr>
                                         <tr class="opentable" data-toggletable="type3table">
                                             <td>Others</td>
                                             <td>5</td>
                                             <td>5 MB</td>
                                         </tr>
                                     </tbody>
                                 </table>
                             </div>

                             <div class="col-6">

                                 <table class="table d-none prevtable" id="type1table">
                                     <thead>
                                         <tr>
                                             <th>Thumbnails</th>
                                             <th>File Name</th>
                                             <th>Last updated</th>
                                             <th></th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <tr>
                                             <td style="height: 100px">
                                                 <img src="https://picsum.photos/250?random=1" alt="Image Preview"
                                                     style="object-fit: contain;height: 100%;border-radius: 10px">
                                             </td>
                                             <td>
                                                 Catalogue Price
                                             </td>
                                             <td> </td>
                                             <td>
                                                 <a href="#download" class="btn-link text-primary ">Dowload</a>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td style="height: 100px">
                                                 <img src="https://picsum.photos/250?random=2" alt="Image Preview"
                                                     style="object-fit: contain;height: 100%;border-radius: 10px">
                                             </td>
                                             <td>
                                                 PDF 1
                                             </td>
                                             <td> </td>
                                             <td>
                                                 <a href="#download" class="btn-link text-primary ">Dowload</a>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td style="height: 100px">
                                                 <img src="https://picsum.photos/250?random=3" alt="Image Preview"
                                                     style="object-fit: contain;height: 100%;border-radius: 10px">
                                             </td>
                                             <td>
                                                 PDF 1
                                             </td>
                                             <td> </td>
                                             <td>
                                                 <a href="#download" class="btn-link text-primary ">Dowload</a>
                                             </td>
                                         </tr>
                                     </tbody>
                                 </table>
                                 <table class="table d-none prevtable" id="type2table">
                                     <thead>
                                         <tr>
                                             <th>Thumbnails</th>
                                             <th>File Name</th>
                                             <th>Last updated</th>
                                             <th></th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <tr>
                                             <td style="height: 100px">
                                                 <img src="https://picsum.photos/250?random=1" alt="Image Preview"
                                                     style="object-fit: contain;height: 100%;border-radius: 10px">
                                             </td>
                                             <td>
                                                 Vector drawings
                                             </td>
                                             <td> </td>
                                             <td>
                                                 <a href="#download" class="btn-link text-primary ">Dowload</a>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td style="height: 100px">
                                                 <img src="https://picsum.photos/250?random=2" alt="Image Preview"
                                                     style="object-fit: contain;height: 100%;border-radius: 10px">
                                             </td>
                                             <td>
                                                 PDF 1
                                             </td>
                                             <td> </td>
                                             <td>
                                                 <a href="#download" class="btn-link text-primary ">Dowload</a>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td style="height: 100px">
                                                 <img src="https://picsum.photos/250?random=3" alt="Image Preview"
                                                     style="object-fit: contain;height: 100%;border-radius: 10px">
                                             </td>
                                             <td>
                                                 PDF 1
                                             </td>
                                             <td> </td>
                                             <td>
                                                 <a href="#download" class="btn-link text-primary ">Dowload</a>
                                             </td>
                                         </tr>
                                     </tbody>
                                 </table>
                                 <table class="table d-none prevtable" id="type3table">
                                     <thead>
                                         <tr>
                                             <th>Thumbnails</th>
                                             <th>File Name</th>
                                             <th>Last updated</th>
                                             <th></th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <tr>
                                             <td style="height: 100px">
                                                 <img src="https://picsum.photos/250?random=1" alt="Image Preview"
                                                     style="object-fit: contain;height: 100%;border-radius: 10px">
                                             </td>
                                             <td>
                                                 Others
                                             </td>
                                             <td> </td>
                                             <td>
                                                 <a href="#download" class="btn-link text-primary ">Dowload</a>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td style="height: 100px">
                                                 <img src="https://picsum.photos/250?random=2" alt="Image Preview"
                                                     style="object-fit: contain;height: 100%;border-radius: 10px">
                                             </td>
                                             <td>
                                                 PDF 1
                                             </td>
                                             <td> </td>
                                             <td>
                                                 <a href="#download" class="btn-link text-primary ">Dowload</a>
                                             </td>
                                         </tr>
                                         <tr>
                                             <td style="height: 100px">
                                                 <img src="https://picsum.photos/250?random=3" alt="Image Preview"
                                                     style="object-fit: contain;height: 100%;border-radius: 10px">
                                             </td>
                                             <td>
                                                 PDF 1
                                             </td>
                                             <td> </td>
                                             <td>
                                                 <a href="#download" class="btn-link text-primary ">Dowload</a>
                                             </td>
                                         </tr>
                                     </tbody>
                                 </table>


                             </div>
                         </div>
                     </div>

                     <div class="col-12 m-1">
                         <span class="h6">Created At: <span>2024 02 05</span> </span>
                     </div>

                     <div class="col-12 m-1">
                         <span class="h6">Last Update: <span>2024 02 05</span> </span>
                     </div>



                     <div class="col-12 my-3">
                         <div class="alert alert-warning text-center" role="alert">
                             <i class="ik ik-info mr-1" title="title"></i>
                             Upgrade to Premium to search Products in PDF and excel. <br>
                             In free trial, only Products (in jpeg, png, …. formats) can be searched.
                         </div>
                     </div>
                 </div>
             </div>
             <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"
                 tabindex="0">
                 {{-- Tab 3 --}}
                 {{-- <h4>On selection, these 2 options</h4> --}}

                 <div class="row">
                     <div class="col-12 my-3 mx-2">
                         <div class="form-group ">
                             <input type="text" class="form-control w-75" placeholder="Search by File Name">
                         </div>
                     </div>

                     <div class="col-12">
                         <div class="row d-flex flex-wrap ">
                             {{-- Product Card for Loop Start --}}
                             @for ($i = 1; $i < 19; $i++)
                                 <div class="col-4 col-md-2 col-sm-3">
                                     <div class="card" style="width: min-content;height: max-content;">
                                         <div class="card-body d-flex flex-column justify-content-start text-center "
                                             style="width: min-content;">
                                             <img src="{{ asset('frontend\assets\newuiimages\vault\/'.$i.'.png') }}"
                                                 alt="Image Preview"
                                                 style="object-fit: contain;height: 100px;border-radius: 10px">
                                             <span class="my-2">GBI_04
                                                {{-- <a href="#link" class="btn-link ">Link</a> --}}
                                            </span>
                                             @php
                                                 $random = generateRandomStringNative(10);
                                             @endphp
                                             <input type="checkbox" id="checkme_{{ $random }}" class="d-none"
                                                 name="checkproduct[]">
                                             <label for="checkme_{{ $random }}"
                                                 class="btn btn-outline-primary chekpro mb-1">
                                                 Select
                                             </label>
                                         </div>
                                     </div>
                                 </div>
                             @endfor

                             {{-- Product Card for Loop End --}}



                         </div>
                     </div>
                     <div class="col-12 d-flex justify-content-center my-3">
                         {{-- <div class="btn-group dropend">
                             <button type="button" class="btn btn-primary shadow-none ">
                                 Add to Offer
                             </button>
                             <button type="button"
                                 class="btn btn-primary shadow-none  dropdown-toggle dropdown-toggle-split"
                                 data-bs-toggle="dropdown" aria-expanded="false">
                                 <span class="visually-hidden">
                                     <svg width="9" height="15" viewBox="0 0 192 512"
                                         xmlns="http://www.w3.org/2000/svg">
                                         <path fill="currentColor"
                                             d="M0 384.662V127.338c0-17.818 21.543-26.741 34.142-14.142l128.662 128.662c7.81 7.81 7.81 20.474 0 28.284L34.142 398.804C21.543 411.404 0 402.48 0 384.662" />
                                     </svg>
                                 </span>
                             </button>

                             <ul class="dropdown-menu">
                                 <li><a class="dropdown-item" href="#">Add New</a></li>
                             </ul>
                         </div> --}}

                         {{-- <button class="btn btn-secondary shadow-none  ">Add to Product</button> --}}
                         <button class="btn btn-primary shadow-none " id="showcard">Save</button>

                     </div>

                 </div>

             </div>
             <div class="tab-pane fade" id="pills-disabled" role="tabpanel" aria-labelledby="pills-disabled-tab"
                 tabindex="0">
                 Tab 4
             </div>

         </div> <!-- tab-content -->
     </div>
 </div>
