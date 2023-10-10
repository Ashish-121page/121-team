<div class="modal fade" id="addAdditionalNumbers" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Numbers</h5>
                <div>
                    <span id="OTP" class="d-none"></span>
                </div>
                <button type="button" class="btn close" @if(request()->routeIs('panel.user_shops.edit') == true) data-dismiss="modal" @else data-bs-dismiss="modal" @endif  aria-label="Close"
                    style="padding: 0px 20px;font-size: 20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
           <form action="{{route('panel.user.update-numbers')}}" method="post">
            <div class="modal-body">
                <label for="">Phone</label>
                <input required onkeydown="javascript: return event.keyCode == 69 ? false : true"  type="number" name="additional_numbers" class="form-control additionalNumber" placeholder="Enter Phone">
                <button id="otpButton" type="button" class="btn btn-link d-block text-right w-100">Send OTP</button>
                <div class="d-flex align-items-center">
                    <div>
                        <input type="number" name="otp" id="otpInput" class="form-control w-100" placeholder="Enter OTP">
                        
                    </div>
                    <div class="ml-2">
                        <button class="btn btn-link d-none" id="verifyOTP">Verify OTP</button>

                        <span class="check-icon d-none">
                        @if(request()->routeIs('panel.user_shops.edit') == true)
                                <i class="ik ik-check"></i>
                            @else
                                <i class="uil uil-check"></i>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="saveBtn" disabled class="btn btn-primary">Save</button>
            </div>
           </form>
        </div>
    </div>
</div>


