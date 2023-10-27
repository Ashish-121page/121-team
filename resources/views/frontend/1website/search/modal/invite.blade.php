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

                    @if (isset($item->phone_primary))
                        <div class="d-flex flex-column">        
                            <span><b>Verify Number</b></span>
                            <input type="hidden" name="user_id" id="user_id" value="{{ $item->id }}">
                            <div class="passcode d-flex gap-1 align-items-center justify-content-center mt-2">
                                <code style="font-size: 1rem;margin-right: 5px">{{ substr($item->phone_primary,0,4) ?? "0000" }}</code>
                                <span>XX</span>
                                <input type="tel" id="phone-1" class="form-control phone" placeholder="XXXX" maxlength="4" minlength="4">
                                {{-- <button class="btn @if ($user_name == '') btn-outline-secondary @else btn-outline-primary  @endif btn-sm chkpassds" type="button" id="chkpassds"  @if ($user_name == '') disabled @endif>Invite/Request</button> --}}
                            </div>
                        </div>
                    @endif
                        
                    @if (isset($item->phone_2) != null )
                        <div class="d-flex flex-column">
                            <input type="hidden" name="user_id" id="user_id" value="{{ $item->id }}">
                            <div class="passcode d-flex gap-1 align-items-center justify-content-center mt-2">
                                <code style="font-size: 1rem;margin-right: 5px">{{ substr($item->phone_2,0,4) ?? "0000" }}</code>
                                <span>XX</span>
                                <input type="tel" id="phone-2" class="form-control phone" placeholder="XXXX" maxlength="4" minlength="4">
                                {{-- <button class="btn @if ($user_name == '') btn-outline-secondary @else btn-outline-primary  @endif btn-sm chkpassds" type="button" id="chkpassds"  @if ($user_name == '') disabled @endif>Invite/Request</button> --}}
                            </div>
                        </div>
                    @endif
                    
                    @if (isset($item->phone_3))
                        <div class="d-flex flex-column">
                            <input type="hidden" name="user_id" id="user_id" value="{{ $item->id }}">
                            <div class="passcode d-flex gap-1 align-items-center justify-content-center mt-2">
                                <code style="font-size: 1rem;margin-right: 5px">{{ substr($item->phone_3,0,4) ?? "0000" }}</code>
                                <span>XX</span>
                                <input type="tel" id="phon3" class="form-control phone" placeholder="XXXX" maxlength="4" minlength="4">
                                {{-- <button class="btn @if ($user_name == '') btn-outline-secondary @else btn-outline-primary  @endif btn-sm chkpassds" type="button" id="chkpassds"  @if ($user_name == '') disabled @endif>Invite/Request</button> --}}
                            </div>
                        </div>
                    @endif
                    

                    @if (isset($item->phone_4) != null)
                        <div class="d-flex flex-column">
                            <input type="hidden" name="user_id" id="user_id" value="{{ $item->id }}">
                            <div class="passcode d-flex gap-1 align-items-center justify-content-center mt-2">
                                <code style="font-size: 1rem;margin-right: 5px">{{ substr($item->phone_4,0,4) ?? "0000" }}</code>
                                <span>XX</span>
                                <input type="tel" id="phone-4" class="form-control phone" placeholder="XXXX" maxlength="4" minlength="4">
                                {{-- <button class="btn @if ($user_name == '') btn-outline-secondary @else btn-outline-primary  @endif btn-sm chkpassds" type="button" id="chkpassds"  @if ($user_name == '') disabled @endif>Invite/Request</button> --}}
                            </div>
                        </div>
                    @endif

                  </div>
              </div>

              {{-- <div class="row mt-3">
                  <div class="col-12">
                      <div class="form-check mb-3">
                          <input required class="form-check-input" type="checkbox"  id="flexCheckDefault">
                          <label class="form-check-label" for="flexCheckDefault">I Accept 
                              <a href="{{url('/page/terms') }}">Terms & Conditions</a></label>
                      </div>
                  </div>
              </div> --}}
          </div>
          <div class="modal-footer">
              {{-- <button type="submit" class="btn btn-outline-primary">Invite/Request</button> --}}
              <button class="btn @if (isset($user_name) == '') btn-outline-secondary @else btn-outline-primary @endif chkpassds" type="button" id="dsfqed"  @if ($user_name == '') disabled @endif data-type="{{ $item->id ?? "" }}" onclick="chackpass(this)">Invite/Request</button>
          </div>
      </form>    
      </div>
    </div>
  </div>