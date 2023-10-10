<div class="modal fade" id="AccessCode" role="dialog" aria-labelledby="AccessCodeTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AccessCodeTitle">Enter Access Code</h5>
                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close"
                    style="padding: 0px 20px;font-size: 20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('customer.access-code-validate') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="form-group">
                                <div class="alert alert-warning">
                                   Contact 121 Help Center incase of any trouble.
                                </div>
                                <label for="access_code">Access Code<span class="text-danger">*</span></label>
                                <input class="form-control" name="access_code" required type="text"
                                    placeholder="Enter Code">
                            </div>
                        </div>
                        <div class="col-12 text-right mt-4">
                            <button type="submit" class="btn btn-outline-primary">Activate Seller Account</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
