<div class="modal fade" id="pickedProductEdit" tabindex="-1" role="dialog" aria-labelledby="pickedProductEditLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pickedProductEditLabel">Offer Price</h5>
                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close"
                    style="padding:20px;font-size: 30px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('pages.proposal.update-price',$proposal->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12 col-12">
                        <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                            <input type="hidden" name="product_id" value="" class="productId">
                            <label for="price" class="control-label">Offer Price</label>
                            <input class="form-control" name="price" min="0" type="number" id="price" placeholder="Enter price">


                            <label for="remarks_offer">Customisation</label>
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Customisation requested by buyer" id="remarks_offer" name="remarks_offer"></textarea>
                            </div>

                            <label for="attachment">Attachment</label>
                            <input type="file" class="form-control" name="attachment" name="attachment">


                            <label for="Customise_product" class="d-none">Customise</label>
                            <input type="text" class="form-control d-none" name="Customise_product" name="Customise_product" placeholder="Customise">

                        </div>

                        <button type="submit" class="btn btn-primary mx-1 float-right">Update</button>
                        <button type="button" class="btn btn-outline-primary mx-1 float-right" data-bs-dismiss="modal" aria-label="Close">Cancel</button>


                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
