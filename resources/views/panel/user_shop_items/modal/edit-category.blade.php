<div id="animatedModal">
    <div class="modal-content custom-spacing bg-transparent" style="border: none !important; padding: 10px; >
        <form method="POST" action="{{ route('panel.constant_management.category.rename',auth()->id()) }}">
            <input type="hidden" name="catid" value="" id="catid">
            <div class="row justify-content-center " style="background-color: #f3f3f3;">
                <div class="col-md-10 col-12">
                    <div class="col-12 my-3">
                        <h1>Rename <span>Category</span></h1>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="old_name">Old Name   <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="old_name" id="old_name" value="" readonly required>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="new_name">New Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="new_name" id="new_name" value="" required>
                            </div>
                        </div>

                        <div class="col-12 d-flex align-items-center justify-content-between">
                            <button type="button" class="btn btn-outline-primary close-animatedModal" id="btn-close-modal">Cancel</button>
                            <button type="submit" class="btn btn-outline-primary"> Save </button>
                        </div>

                    </div>
                    
                </div>
            </div>
            
        </form>

    </div>
</div>
</div>
