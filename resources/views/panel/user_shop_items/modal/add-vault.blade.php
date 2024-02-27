 <!--DEMO01-->
 <div id="edit_vault_modal">
     <div class="close-edit_vault_modal d-flex justify-content-center align-items-center my-2">
         <svg width="32" height="32" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"
             class="text-primary closeanimate">
             <path fill="currentColor"
                 d="M512 0C229.232 0 0 229.232 0 512c0 282.784 229.232 512 512 512c282.784 0 512-229.216 512-512C1024 229.232 794.784 0 512 0m0 961.008c-247.024 0-448-201.984-448-449.01c0-247.024 200.976-448 448-448s448 200.977 448 448s-200.976 449.01-448 449.01m181.008-630.016c-12.496-12.496-32.752-12.496-45.248 0L512 466.752l-135.76-135.76c-12.496-12.496-32.752-12.496-45.264 0c-12.496 12.496-12.496 32.752 0 45.248L466.736 512l-135.76 135.76c-12.496 12.48-12.496 32.769 0 45.249c12.496 12.496 32.752 12.496 45.264 0L512 557.249l135.76 135.76c12.496 12.496 32.752 12.496 45.248 0c12.496-12.48 12.496-32.769 0-45.249L557.248 512l135.76-135.76c12.512-12.512 12.512-32.768 0-45.248" />
         </svg>
         {{-- <span class="ml-2">Add Vault</span> --}}
     </div>

     <div class="modal-content" id="eidhfiusdh">
         @include('panel.user_shop_items.modal.add-vault-modal-content')
     </div>
 </div>


 @push('script')
 @endpush
