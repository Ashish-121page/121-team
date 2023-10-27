<div class="modal fade" id="buyerBookDemoModal" tabindex="-1" role="dialog" aria-labelledby="buyerBookDemoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="buyerBookDemoModalLabel">Start with 121</h5>
          {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> --}}
        </div>
        <div class="modal-body">
          <div class="save-div w-100" style="display: block;">
            {{-- <h4></h4> --}}
            <div class="digit-group">
              <div class="form-group mb-3">
                <label for="" class="form-label">Name*</label>
                <input type="text" class="form-control" placeholder="Enter Name" id="name" name="name" required>
              </div>
              <div class="form-group mb-3">

                <div class="form-group mb-1">
                  <label for="" class="form-label">Access Code*</label>
                  <input type="text" class="form-control" placeholder="Enter Code" id="code" name="code" required>
                </div>

                  <label for="" class="form-label d-block">Phone*</label>
                  <div class="form-floating mb-3 text-center" style="border-style: solid;  border-radius:11px;
                  border-width: 1px; padding: 7px; border-color: #6666CC;">
                  <img src="{{ asset('frontend/assets/img/ind-flag.png') }}" width="20px">
                  <input required name="phone[]" class="custom-input_box" style="width: 38px;" type="number" id="digit-1" data-next="digit-2" maxlength="9" max="9">
                  <input required name="phone[]" class="custom-input_box" style="width: 38px;" type="number" id="digit-2" data-next="digit-3" data-previous="digit-1" maxlength="9" max="9">
                  <input required name="phone[]" class="custom-input_box" style="width: 38px;" type="number" id="digit-3" data-next="digit-4" data-previous="digit-2" maxlength="9" max="9">
                  <input required name="phone[]" class="custom-input_box" style="width: 38px;" type="number" id="digit-4" data-next="digit-5" data-previous="digit-3" maxlength="9" max="9">

                  <input required name="phone[]" class="custom-input_box" style="width: 38px;" type="number" id="digit-5" data-next="digit-6" data-previous="digit-4" maxlength="9" max="9">
                  <input required name="phone[]" class="custom-input_box" style="width: 38px;" type="number" id="digit-6" data-next="digit-7" data-previous="digit-5" maxlength="9" max="9">
                  <input required name="phone[]" class="custom-input_box" style="width: 38px;" type="number" id="digit-7" data-next="digit-8" data-previous="digit-6" maxlength="9" max="9">
                  <input required name="phone[]" class="custom-input_box" style="width: 38px;" type="number" id="digit-8" data-next="digit-9" data-previous="digit-7" maxlength="9" max="9">

                  <input required name="phone[]" class="custom-input_box" style="width: 38px;" type="number" id="digit-9" data-next="digit-10" data-previous="digit-8" maxlength="9" max="9">
                  <input required name="phone[]" class="custom-input_box" style="width: 38px;" type="number" id="digit-10" data-next="digit-11" data-previous="digit-9" maxlength="9" max="9">
              </div>
              
              <button type="button" class="btn btn-primary mt-2 mb-2 verify-otp" id="save">Send OTP</button>
            </div>
            <hr>
            <div class="col-12">
              <div class="form-signin d-none">
                 <form action="{{ route('join-otp-validate') }}" class="digit-group"  data-group-name="digits" data-autosubmit="false" autocomplete="off" method="post">
                  @csrf
                      <h6 class="mb-3 text-center">Verify OTP</h6>
                          {{-- <div class="text-center mb-3">
                              {{ session()->get('start_otp') }}
                          </div> --}}
                          <div class="form-floating mb-3 text-center">
                            <input required maxlength="1" class="otp" type="number" id="digit-otp-1" name="otp[]" data-next="digit-otp-2" />
                              <input required maxlength="1" class="otp" type="number" id="digit-otp-2" name="otp[]" data-next="digit-otp-3" data-previous="digit-otp-1" />
                              <input required maxlength="1" class="otp" type="number" id="digit-otp-3" name="otp[]" data-next="digit-otp-4" data-previous="digit-otp-2" />

                              <input required maxlength="1" class="otp" type="number" id="digit-otp-4" name="otp[]" data-next="digit-otp-5" data-previous="digit-otp-3" />
                          </div>
                            <div class="mx-auto text-center">
                              <a href="javascript:void(0)" id="verify_otp_btn" class="btn btn-primary text-center mx-auto">Verify OTP</a>
                            </div>
                      <hr>

                      <a href="javascript:void(0)" onclick="resendOTP()" id="sendOTP" style="text-align: center;display: block;padding-top: 5px;color: #6666cc;">Resend OTP</a>

                      <div id="Timer" class="text-muted" style="text-align: center;"></div>
                    </form>
              </div>
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>