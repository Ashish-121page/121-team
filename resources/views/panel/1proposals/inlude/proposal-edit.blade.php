<div class="modal fade" id="pickedProductEdit" tabindex="-1" role="dialog" aria-labelledby="pickedProductEditLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="pickedProductEditLabel">Picked Products Edit</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('panel.proposals.update-price',$proposal->id)}}" method="post">
              @csrf
              <div class="col-md-12 col-12">
                <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                  <input type="hidden"  name="product_id" value="" class="productId">
                    <label for="price" class="control-label">Price</label>
                    <input class="form-control" name="price" min="0" type="number" id="price" placeholder="Enter price">
                </div>
                <button type="submit" class="btn btn-primary float-right">Update</button>
              </div>
            </form>
        </div> 
      </div>
    </div>
  </div>