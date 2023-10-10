<!-- Modal -->
<div class="modal fade" id="requestForCatalogue" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
      <form action="{{ route('panel.seller.request.catalogue') }}" method="post" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off">
          @csrf
          <input type="hidden" value="" name="status" id="status-val">
          <input type="hidden" value="{{ auth()->id() }}" name="user_id">
          <div class="modal-header">
              <h5 class="modal-title" id="accessRequestTitle">Request For Catalogue</h5>
               @if(request()->routeIs('customer.dashboard') == false)
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              @endif
          </div>
          <div class="modal-body">
              <div class="row sent-catalogue-group d-none">
                  <div class="col-12">
                      <div class="form-group">
                          <label class="form-label">Enter Price Group</label>
                          <select name="price_group_id" id="price_group_id" class="form-control">
                              <option value="" aria-readonly="true">Select Group</option>
                              @foreach (App\Models\Group::where('user_id',auth()->id())->get() as $group)
                                  <option value="{{ $group->id }}">GRP{{ getPrefixZeros($group->id) }} - {{ $group->name }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div> 
              </div>
              <div class="row">
                  <div class="col-12">
                      <div class="form-group request-catalogue-group d-none">
                          <label for="">Supplier Name</label>
                          <input type="text" class="form-control supplier-input_box" placeholder="Enter Supplier Name" name="supplier_name">
                      </div>
                     
                      {{-- <div class="form-group">
                          <label class="form-label">Enter Supplier Phone Number</label>
                          <div class="form-floating mb-3 phone-input-box" style="border-style: solid;  border-radius:11px;
                          border-width: 1px; padding: 7px; border-color: #6666CC;">
                              <img src="{{ asset('frontend/assets/img/ind-flag.png') }}" width="20px">
                              <input required style="width: 30px;" name="phone[]" class="custom-input_box" type="number" id="digit-1" data-next="digit-2" maxlength="1"  max="9" style="margin-left: 10px;">
                              <input required style="width: 30px;" name="phone[]" class="custom-input_box" type="number" id="digit-2" data-next="digit-3" data-previous="digit-1" maxlength="1"  max="9">
                              <input required style="width: 30px;" name="phone[]" class="custom-input_box" type="number" id="digit-3" data-next="digit-4" data-previous="digit-2" maxlength="1"  max="9">
                              <input required style="width: 30px;" name="phone[]" class="custom-input_box" type="number" id="digit-4" data-next="digit-5" data-previous="digit-3" maxlength="1"  max="9">
                              <input required style="width: 30px;" name="phone[]" class="custom-input_box" type="number" id="digit-5" data-next="digit-6" data-previous="digit-4" maxlength="1"  max="9" style="margin-left: 10px;">
                              <input required style="width: 30px;" name="phone[]" class="custom-input_box" type="number" id="digit-6" data-next="digit-7" data-previous="digit-5" maxlength="1"  max="9">
                              <input required style="width: 30px;" name="phone[]" class="custom-input_box" type="number" id="digit-7" data-next="digit-8" data-previous="digit-6" maxlength="1"  max="9">
                              <input required style="width: 30px;" name="phone[]" class="custom-input_box" type="number" id="digit-8" data-next="digit-9" data-previous="digit-7" maxlength="1"  max="9">
                              <input required style="width: 30px;" name="phone[]" class="custom-input_box" type="number" id="digit-9" data-next="digit-10" data-previous="digit-8" maxlength="1"  max="9" style="margin-left: 10px;">
                              <input required style="width: 30px;" name="phone[]" class="custom-input_box" type="number" id="digit-10" data-next="digit-11" data-previous="digit-9" maxlength="1"  max="9">
                          </div> 
                      </div>
                      --}}
                      <div class="req_num" style="display: flex;">
                          <img src="{{ asset('frontend/assets/img/ind-flag.png') }}" width="20px" style="margin:5px; height: 23px; width: 27px;">
                          <input required type="tel" maxlength="15"  title="Please enter exactly 10 digits" class="form-control" name="phone" placeholder="Enter Phone Number">
                    </div>
                        <small class="text-muted text-start">Please do not include country code like +91  and no spaces</small>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <button type="submit" id="accessRequestbtn" class="btn btn-primary mx-auto">Request</button>
              @if(request()->routeIs('customer.dashboard') == true)
                  <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              @endif
          </div>
      </form>    
      </div>
    </div>
  </div>