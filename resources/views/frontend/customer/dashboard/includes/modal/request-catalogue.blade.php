<!-- Modal -->
<div class="modal fade" id="requestForCatalogue" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
      <form action="{{ route('customer.request.catalogue') }}" method="post" class="" data-group-name="digits" data-autosubmit="false" autocomplete="off">
          @csrf
          <input type="hidden" value="{{ auth()->id() }}" name="user_id">
          <input type="hidden" value="0" name="status">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Request For Catalogue</h5>
             <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close"
                          style="padding: 0px 20px;font-size: 20px;">
                          <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <div class="col-12">
                      <div class="form-group">
                          <label for="">Supplier Name</label>
                          <input type="text" class="form-control" placeholder="Enter Supplier Name" name="supplier_name" required>
                      </div>
                      <div class="form-group  my-3">
                          <label class="form-label">Enter Supplier Phone Number</label>
                          {{-- <div class="form-floating mb-3 digit-group" style="border-style: solid;  border-radius:11px;
                          border-width: 1px; padding: 7px; border-color: #6666CC;">
                              <img src="{{ asset('frontend/assets/img/ind-flag.png') }}" width="20px">
                              <input required name="number[]" class="custom-input_box" type="tel" id="digit-1" data-next="digit-2" maxlength="1" max="9" style="margin-left: 10px;">
                              <input required name="number[]" class="custom-input_box" type="tel" id="digit-2" data-next="digit-3" data-previous="digit-1" maxlength="1" max="9">
                              <input required name="number[]" class="custom-input_box" type="tel" id="digit-3" data-next="digit-4" data-previous="digit-2" maxlength="1" max="9">
                              <input required name="number[]" class="custom-input_box" type="tel" id="digit-4" data-next="digit-5" data-previous="digit-3" maxlength="1" max="9">
                              <input required name="number[]" class="custom-input_box" type="tel" id="digit-5" data-next="digit-6" data-previous="digit-4" maxlength="1" max="9" style="    margin-left: 10px;">
                              <input required name="number[]" class="custom-input_box" type="tel" id="digit-6" data-next="digit-7" data-previous="digit-5" maxlength="1" max="9">
                              <input required name="number[]" class="custom-input_box" type="tel" id="digit-7" data-next="digit-8" data-previous="digit-6" maxlength="1" max="9">
                              <input required name="number[]" class="custom-input_box" type="tel" id="digit-8" data-next="digit-9" data-previous="digit-7" maxlength="1" max="9">
                              <input required name="number[]" class="custom-input_box" type="tel" id="digit-9" data-next="digit-10" data-previous="digit-8" maxlength="1" max="9" style="margin-left: 10px;">
                              <input required name="number[]" class="custom-input_box" type="tel" id="digit-10" data-next="digit-11" data-previous="digit-" maxlength="1" max="9">
                          </div> --}}
                          <div class="req_num" style="display: flex;">
                              <img src="{{ asset('frontend/assets/img/ind-flag.png') }}" width="20px" style="margin:5px; height: 23px; width: 27px;">
                              <input type="tel" maxlength="15" title="Please enter exactly 10 digits" class="form-control" name="number" placeholder="Enter Phone Number" required>
                        </div>
                        <small class="text-muted text-start">Copy-paste / type. Should NOT include spaces, country code like +91, 91</small>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-12">
                      <div class="form-check mb-3">
                          <input required class="form-check-input" type="checkbox"  id="flexCheckDefault">
                          <label class="form-check-label" for="flexCheckDefault">I Accept 
                              <a href="{{url('/page/terms') }}">Terms & Conditions</a></label>
                      </div>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Request</button>
          </div>
      </form>    
      </div>
    </div>
  </div>