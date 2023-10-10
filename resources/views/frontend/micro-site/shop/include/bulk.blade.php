<div class="modal fade" id="BuyBulk" role="dialog" aria-labelledby="BuyBulkTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="BuyBulkTitle">Verify Access Code</h5>
                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close"
                    style="padding: 0px 20px;font-size: 20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="qty">Qty<span class="text-danger">*</span></label>
                                <input class="form-control" name="qty" required type="text"
                                    placeholder="Enter Code">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="offer_price">Offer Price<span class="text-danger">*</span></label>
                                <input class="form-control" name="offer_price" required type="text"
                                    placeholder="Enter Code">
                            </div>
                        </div>
                        <div class="col-12 text-right mt-4">
                            <button type="submit" class="btn btn-outline-primary">Verify</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
