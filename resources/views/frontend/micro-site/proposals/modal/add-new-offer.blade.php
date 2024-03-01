<div class="modal fade" id="addnewoffer" tabindex="-1" aria-labelledby="addnewofferLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('pages.collection.add.offer') }}" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="addnewofferLabel">Add All Offers</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ encrypt(auth()->id()) }}">
                    <input type="hidden" name="product_id" id="collection_product_ids_new">
                    <input type="hidden" name="requestBy" value="form">
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="offer_title" class="form-label">Offer Title <span class="text-danger ">*</span></label>
                                <input type="text" name="offer_title" id="offer_title" class="form-control" required  placeholder="Enter Offer Name">
                            </div>

                            <div class="form-group">
                                <label for="buyer_name" class="form-label">Buyer Name <span class="text-danger ">*</span> </label>
                                <input type="text" name="buyer_name" id="buyer_name" class="form-control" required  placeholder="Enter Buyer Name">
                            </div>

                            <div class="form-group">
                                <label for="offer_alias" class="form-label"> Alias (optional) </label>
                                <input type="text" name="offer_alias" id="offer_alias" class="form-control" placeholder="Enter Alias (optional)">
                            </div>

                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Items</button>
                </div>
            </div>
        </form>

    </div>
</div>
