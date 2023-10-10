<div class="modal fade" id="editVarientModal" role="dialog" aria-labelledby="editVarientModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editVarientModalTitle">Add Varient</h5>
        <div class="">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      </div>
      @php
            $product = App\Models\Product::whereId($product_id)->first();
            $attributes = App\Models\ProductAttribute::get();
            $colors = $attributes->where('name','Color')->first();
            $sizes = $attributes->where('name','Size')->first();
            $colors = json_decode($colors->value,true);
            $sizes = json_decode($sizes->value,true);
      @endphp
        <div class="modal-body">
          <form action="{{ route('panel.products.varient') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product_id }}">
              <div class="row">
                <div class="col-md-6 col-12"> 
                    <div class="form-group mb-0">
                        <label for="input">{{ __('Color')}}</label>
                    </div>
                    <div class="form-group">
                        <select class="form-control select2" name="color" id="color">
                            <option value="" readonly>Select Color</option>
                            @foreach (explode(',',$colors[0]) as $item)
                                <option value="{{ $item }}" @if ($item == $product->color) selected @endif>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-12"> 
                    <div class="form-group mb-0">
                        <label for="input">{{ __('Size')}}</label>
                    </div>
                    <div class="form-group">
                        <select class="form-control select2" name="size" id="size">
                            <option value="" readonly>Select Size</option>
                            @foreach (explode(',',$sizes[0]) as $item)
                                <option value="{{ $item }}" @if ($item == $product->size) selected @endif>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 text-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
          </form>
        </div>
    </div>
  </div>
</div>