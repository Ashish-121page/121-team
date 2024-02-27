 <!--DEMO01-->
 <div id="add_vault_modal">
     <div class="close-add_vault_modal d-flex justify-content-center align-items-center my-2">
         <svg width="32" height="32" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"
             class="text-primary closeanimate">
             <path fill="currentColor"
                 d="M512 0C229.232 0 0 229.232 0 512c0 282.784 229.232 512 512 512c282.784 0 512-229.216 512-512C1024 229.232 794.784 0 512 0m0 961.008c-247.024 0-448-201.984-448-449.01c0-247.024 200.976-448 448-448s448 200.977 448 448s-200.976 449.01-448 449.01m181.008-630.016c-12.496-12.496-32.752-12.496-45.248 0L512 466.752l-135.76-135.76c-12.496-12.496-32.752-12.496-45.264 0c-12.496 12.496-12.496 32.752 0 45.248L466.736 512l-135.76 135.76c-12.496 12.48-12.496 32.769 0 45.249c12.496 12.496 32.752 12.496 45.264 0L512 557.249l135.76 135.76c12.496 12.496 32.752 12.496 45.248 0c12.496-12.48 12.496-32.769 0-45.249L557.248 512l135.76-135.76c12.512-12.512 12.512-32.768 0-45.248" />
         </svg>
         {{-- <span class="ml-2">Add Vault</span> --}}
     </div>

     <div class="modal-content">
         <div class="tab-content" id="pills-tabContent">

             <div class="col-lg-12 col-md-12 mx-auto">

                 {{-- ` Work With Delimiter Card --}}

                 <div class="row justify-content-center ">
                     <div class="col-md-4 ">
                         <div class="card border-primary" id=""
                             style="cursor: pointer; border: 1px solid #6666CC !important;">
                             <a
                                 href="?type={{ request()->get('type') }}&type_ide={{ encrypt(request()->get('type_id')) }}&delimiter-link">
                                 <div class="card-header">
                                     <i class="fas fa-plus btn text-primary h5"
                                         style="font-size: 1.2rem; line-height: 1 !important;"></i>
                                     <h5>File Name contains Model code</h5>
                                 </div>
                                 <div class="card-body p-0 wrap_equal_height">
                                     <p class="card-text" style="font-size: 0.8rem">
                                     <ul>
                                         <li>
                                             Use characters ( - _ + - . # ^^ ^) in file name to get model code
                                         </li>
                                         <li>
                                             Image and other assets will be added to the Products with the same Model
                                             Code
                                         </li>
                                         <li>
                                             Duplicate files will be ignored, unless expressly specified
                                         </li>
                                     </ul>
                                     </p>
                                 </div>
                             </a>
                         </div>
                     </div>

                     <div class="col-md-4 ">
                         <div class="card border-primary" id=""
                             style="cursor: pointer; border: 1px solid #6666CC !important;">
                             <a
                                 href="?type={{ request()->get('type') }}&type_ide={{ encrypt(request()->get('type_id')) }}&file_name_is_model_code">
                                 <div class="card-header">
                                     <i class="fas fa-plus btn text-primary h5"
                                         style="font-size: 1.2rem; line-height: 1 !important;"></i>
                                     <h5>File Name is Model code</h5>
                                 </div>
                                 <div class="card-body p-0 wrap_equal_height">
                                     <p class="card-text" style="font-size: 0.8rem">
                                     <ul>
                                         <li>
                                             Image and other assets will be added to the Products with the same Model
                                             Code
                                         </li>
                                         <li>
                                             Duplicate files will be ignored, unless expressly specified
                                         </li>
                                     </ul>
                                     </p>
                                 </div>
                             </a>
                         </div>
                     </div>

                     <div class="col-md-4 ">
                         <div class="card border-primary" id=""
                             style="cursor: pointer; border: 1px solid #6666CC !important;">
                             <a
                                 href="?type={{ request()->get('type') }}&type_ide={{ encrypt(request()->get('type_id')) }}&irrelevant-file-name">
                                 <div class="card-header">
                                     <i class="fas fa-plus btn text-primary h5"
                                         style="font-size: 1.2rem; line-height: 1 !important;"></i>
                                     <h5>File Name is irrelevant</h5>
                                 </div>
                                 <div class="card-body p-0 wrap_equal_height">
                                     <p class="card-text" style="font-size: 0.8rem">
                                     <ul>
                                         <li>
                                             Only Image files will be used to create new Products
                                         </li>
                                         <li>
                                             Non image files will be ignored
                                         </li>
                                     </ul>
                                     </p>
                                 </div>
                             </a>
                         </div>
                     </div>
                 </div>


             </div>

         </div> <!-- tab-content -->
     </div>
 </div>
