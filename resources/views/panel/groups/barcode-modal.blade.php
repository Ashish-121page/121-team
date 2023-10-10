<!-- Modal -->
  <div class="modal fade" id="barCodeModal" tabindex="-1" role="dialog" aria-labelledby="barCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="barCodeModalLabel">QR Code</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center" id="download-qr-div">
          <div id="groupName" class="d-none"></div>
          <div class="text-center dashboard-card mx-auto">
            <div>
                <img src="{{ getBackendLogo(getSetting('app_white_logo'))}}" alt="website Logo" style="height: 40px;" class="my-1">
                <hr>
                <h5 class="mt-2">
                  <strong>
                      <span id="user_shop_name"></span>
                  </strong>
                </h5>
                <span>Scan to get latest offers</span>
                
                <div class="p-2" id="barcode_emb">
                 
                </div>
                <div id="previewImg" class="d-none">
                </div>
               
                <br>

                
                <h6 class="mt-2">
                    <i class="ik ik-phone"></i><span id="phone"></span></h6>
                <h6 class="mt-2">
                  <i class="fa fa-envelope"></i>
                  <span id="email"></span>
                </h6>
               
                    <hr>

                    <label for="" class="text-center text-muted">
                    Powered by 121.page
                    </label>
            </div>  
        </div>
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary"  id="download-qr" data-dismiss="modal">Download</button>
        </div>
      </div>
    </div>
  </div>