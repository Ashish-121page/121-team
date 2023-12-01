<div id="animatedModal">
    <div id="btn-close-modal" class="close-animatedModal custom-spacing" style="color:black;font-size: 1.3rem;cursor: pointer;">
        <i class="far fa-times-circle fa-rotate-270 fa-lg "></i>
    </div>
    <div class="modal-content custom-spacing bg-transparent" style="border: none !important;">
        <form method="POST" action="{{ route('panel.constant_management.category.rename',auth()->id()) }}">
            <input type="hidden" name="catid" value="" id="catid">
            <div class="row justify-content-center ">
                <div class="col-md-10 col-12">
                    <div class="col-12 my-3">
                        <h1>Rename <span>Category</span></h1>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="old_name">Old Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="old_name" id="old_name" value="" required>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="new_name">New Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="new_name" id="new_name" value="" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="submit" class="btn btn-outline-primary">submit</button>
                        </div>

                    </div>
                    
                </div>
            </div>
            
        </form>

    </div>
</div>
</div>
