<style>
  .dropdown-icon {
    position: absolute;
    top: 68%;
    right: 27px;
    transform: translateY(-50%);
    pointer-events: none; /* Ensure the icon does not interfere with the select box */
    color: #000; /* Adjust the color as needed */
}


</style>


<div class="modal fade" id="ekycVerification" role="dialog" aria-labelledby="ekycVerificationTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ekycVerificationTitle">e-KYC Verification Form</h5>
         <button type="button" class="btn close d-none" data-bs-dismiss="modal" aria-label="Close" style="padding: 0px 20px;font-size: 20px;">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if (auth()->user()->ekyc_status == 2)
          @php
              $kyc_data = json_decode(auth()->user()->ekyc_info);
          @endphp
          @if(!is_null($kyc_data) && $kyc_data->admin_remark != null)
            <div style="font-size: 16px;" class="alert alert-danger d-flex justify-content-between" role="alert">
              <span class="m-0 p-0" style="line-height: 40px;">
                {{ $kyc_data->admin_remark ?? '' }}
              </span>
            </div>
          @endif
        @endif
          <form action="{{ route('panel.verify-ekyc') }}" method="post" enctype="multipart/form-data">
            @csrf
            {{-- @dump($kyc_data) --}}
              <div class="row">
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label for="document_type">Document Type<span class="text-danger">*</span></label>
                        <select class="form-control" name="document_type" required >
                            <option value="" readonly>Select Type</option>

                            <option @if(isset($kyc_data) && $kyc_data->document_type == "IEC Certificate") selected @endif value="IEC Certificate" readonly>IEC Certificate</option>

                            <option @if(isset($kyc_data) && $kyc_data->document_type == "GST Certificate") selected @endif value="GST Certificate" readonly>GST Certificate</option>

                            <option @if(isset($kyc_data) && $kyc_data->document_type == "Brand Trademark certificate") selected @endif value="Brand Trademark certificate" readonly>Brand Trademark certificate</option>
                            {{-- <option @if(isset($kyc_data) && $kyc_data->document_type == "Pan Card") selected @endif value="Pan Card" readonly>PAN CARD</option>
                            <option @if(isset($kyc_data) && $kyc_data->document_type == "Aadhar Card") selected @endif value="Aadhar Card" readonly>AADHAR CARD</option> --}}
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                        <label for="document_number">Document Number<span class="text-danger">*</span></label>
                         <input class="form-control" name="document_number" @if(isset($kyc_data) && $kyc_data->document_number != null) value="{{$kyc_data->document_number }}" @endif required type="text">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="mt-2" for="document_front_attachment">Side 1<span class="text-danger">*</span></label>
                      <input class="form-control" name="document_front_attachment" required type="file" accept="image/*">
                    </div>
                </div>
                <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label class="mt-2" for="document_back_attachment">Side 2</label>
                      <input class="form-control" name="document_back_attachment" type="file" accept="image/*">
                    </div>
                </div>


                
                <div class="col-md-12 col-12 mt-3">
                  <div class="form-group">
                    <label class="mt-2" for="acc_type">
                      Based on your nature of business, you are:
                      
                    </label>
                    {{-- <label class="mt-2" for="acc_type">Based on your nature of business, you are:</label> --}}
                    <select name="acc_type" id="acc_type" class="form-control">                      
                      <option {{ $chk = ($user->account_type == 'customer') ?  "selected" : "" ; }} value="customer" >Customer <i class="fa fa-angle-down"> </option>
                      <option {{ $chk = ($user->account_type == 'exporter') ?  "selected" : "" ; }} value="exporter">Exporter</option>
                      <option {{ $chk = ($user->account_type == 'supplier') ?  "selected" : "" ; }} value="supplier">Manufacturer / Stockist</option>
                      <option {{ $chk = ($user->account_type == 'reseller') ?  "selected" : "" ; }} value="reseller">Reseller</option>
                    </select>

                    <div class="dropdown-icon">
                      <i class="fa fa-angle-down"></i>
                    </div>


                  </div>
                </div>

                <div class="col-md-12 col-12 mt-3">
                  <div class="form-group">
                    <label class="mt-2 d-none" for="document_back_attachment">Your Existing Site</label>
                    <input class="form-control mb-2" name="last_site" type="text" placeholder="Your alternate website , if any">
                    {{-- <small title="Share existing website, for expedited KYC verification"><i class="uil-info-circle"></i></small> --}}

                  </div>
                </div>



                <div class="col-md-12 col-12 mt-3">
                  <div class="form-group">
                    <label class="mt-2" for="remarks">Any additional info for e-KYC:</label>
                    <input class="form-control mb-2" name="remarks" id="remarks" type="text" placeholder="">
                  </div>
                </div>
                <div class="col-12 col-md-12 col-lg-12 text-center mt-4">
                  <div class="d-flex justify-content-between">
                      <button type="button" class="btn close btn btn-primary mr-2" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                      <button type="submit" class="btn btn-primary">Verify</button>
                  </div>
              </div>
              
              </div>
          </form>
        </div>
    </div>
  </div>
</div>
