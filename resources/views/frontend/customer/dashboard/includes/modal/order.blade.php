<div class="modal fade" id="orderRequest" role="dialog" aria-labelledby="orderRequestTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderRequestTitle">Resubmit Correct Transaction Details</h5>
                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close"
                    style="padding: 0px 20px;font-size: 20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('customer.order.update')}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="order_id" value="{{$order_id}}">
                    <input type="hidden" name="status" value="7">
                    @csrf
                    <div class="row">
                        <div class="row" id="new-address">
                            <div class="col-sm-12">
                                <label for="transaction_id" class="form-label">Transaction ID <span class="text-danger">*</span></label>
                                <input type="text" name="transaction_id" class="form-control" id="transaction_id" placeholder="Enter Transaction Id" value="" required>
                            </div>
                            <div class="col-sm-12 mt-2">
                                <label for="transaction_file" class="form-label">Transaction Proof <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="transaction_file" name="transaction_file" placeholder="First Name" value="" required>
                            </div>
                        </div>
                        <div class="col-12 text-right mt-4">
                            <button type="submit" class="btn btn-outline-primary">Submit Appeal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
