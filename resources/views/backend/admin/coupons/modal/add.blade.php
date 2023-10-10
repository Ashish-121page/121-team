<div class="modal fade" id="addCouponModal" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="{{ route('backend.admin.coupons.store') }}" method="post">
            <input type="hidden" name="user_id" value="" id="userId">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Coupon</h5>
                    <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close"
                        style="padding: 0px 20px;font-size: 20px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        {{-- <div class="col-12 mb-3">
                            <label for="address" class="form-label">Address Type</label>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-check">
                                        <input id="home" name="type" value="0" type="radio" class="form-check-input"
                                            required="">
                                        <label class="form-check-label" for="home">Home</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input id="office" name="type" value="1" type="radio" class="form-check-input"
                                            required="">
                                        <label class="form-check-label" for="office">Office</label>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-12 mb-3">
                            <label for="couponsname" class="form-label">Name</label>
                            <input type="text" class="form-control" id="couponsname" placeholder="Enter Coupons Name" required
                                name="couponsname">
                        </div>

                        <div class="col-12 mb-3">
                            <label for="couponcode" class="form-label">Coupon Code
                                {{-- <span class="text-muted">(Optional)</span> --}}
                            </label>
                            <input type="text" class="form-control" id="couponcode" placeholder="Enter Coupon Code"
                                name="couponcode">
                        </div>

                        <div class="col-md-12 mt-3">
                            <label for="markupstyle" class="form-label">Coupon Amount</label>
                            <select class="form-select form-control" id="markupstyle" required name="markupstyle" required>
                                <option selected>Choose Markup Style</option>
                                <option value="flat">Add Flat Amount</option>
                                <option value="rupee">Add In Percent</option>
                                <option value="percent">Add In Rupee</option>
                            </select>
                            <div class="inp mt-3">
                                <input type="number" name="amtrupee" id="amtrupee" class="form-control d-none" placeholder="Enter Amount In Rupee">
                                <input type="number" name="amtpercent" id="amtpercent" class="form-control d-none" placeholder="Enter Amount In Percenterge">
                                <input type="number" name="flat_price" id="amtflat" class="form-control d-none" placeholder="Enter Flat Amount">
                            </div>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="appplan" class="form-label">Select Valid Plan
                                {{-- <span>Selecrt Plan Where Code will Apply</span> --}}
                            </label>
                            <select class="form-select form-control" required id="appplan" name="appplan">
                                {{-- <option value="all" selected>All Plans</option> --}}
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->name }}</option>                                    
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mt-3" >
                            <label for="appplimit" class="form-label">Select Valid Plan</label>
                                {{-- <span>How Many Times Coupon Can Use</span> --}}
                            <input type="number" name="appplimit" id="appplimit" class="form-control" placeholder="Enter Limit">

                        </div>
                        <div class="col-md-12 mt-3">
                            <label for="desc" class="form-label">Coupon Description (Optional)</label>
                            <textarea name="desc" id="desc" cols="30" rows="5" class="form-control" placeholder="Enter Coupon Description"></textarea>
                        </div>
                      
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>


