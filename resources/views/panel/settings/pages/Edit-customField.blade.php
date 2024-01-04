<!-- Modal -->
<div class="modal fade" id="EditCustField" tabindex="-1" role="dialog" aria-labelledby="EditCustFieldLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form action="{{ route('panel.settings.update.custom.fields') }}" method="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="EditCustFieldLabel">Edit Column</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <input type="hidden" id="custid" name="custid">
                    <input type="hidden" value="{{ encrypt(auth()->id()) }}" name="type_id">
                    <div class="form-group mb-3">
                        <label for="custname">Name of The Field <span class="text-danger">*</span> </label>
                        <input type="text" id="custname" class="form-control" name="custname" placeholder="">
                    </div>

                    <div class="form-group mb-3 d-flex align-items-center gap-2">
                        <label for="custreq" class="mb-0 mx-2">Is Required </label>
                        <input type="checkbox" id="custreq" class="form-check" name="custreq" value="1">
                    </div>


                    <div class="form-group mb-3">
                        <label for="custattr_section" class="form-label">Section <span class="text-danger">*</span> </label>
                        <select name="attr_section" class="form-control" id="custattr_section" required readonly disabled>
                            <option value="1">Product Info > Essentials</option>
                            <option value="2">Product Info > Sale Price</option>
                            <option value="3">Product Info > Property</option>
                            <option value="4">Internal - Reference</option>
                            <option value="5">Internal - Production</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="custtags">Enter Value</label>
                        <input type="text" id="custtags" class="form-control w-100" name="custtags" value="" placeholder="Enter New Values">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline-primary">Save changes</button>
            </div>
        </form>

        </div>
    </div>
</div>
