<div class="modal fade" id="inventoryProductEdit-{{$product->id}}" role="dialog" aria-labelledby="productBulkModalTitle" aria-hidden="true" tabindex="-1">
  <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
        <div class="modal-header">
           <h5 class="modal-title" id="productBulkModalTitle">Edit Inventory Product ( {{ App\models\Inventory::where('product_sku',$product->sku)->selectRaw("sum(total_stock) as sum, product_sku")->pluck('sum','product_sku')[$product->sku] }} )</h5>
           <div class="">
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
           </div>
        </div>
        <div class="modal-body">
           <form class="row" id="inventoryStoreForm" action="{{ route('panel.products.inventory.store') }}" method="post">
              <input type="hidden" name="id" value="{{ $product->id }}">
              <div class="col-lg-12">
                 @php
                 $variations = getProductColorBySku($product->sku);
                 @endphp
                 @foreach ($variations as $variation)
                 {{-- Calculate Color Varient Sum --}}
                 @php
                     $color_sum = 0;
                     foreach (getProductColorBySkuColor($product->sku,$variation->color) as $size) {
                        $color_sum = $color_sum + getinventoryByproductId($size->id)->total_stock;
                     }
                 @endphp
                 @csrf
                  <div class="form-group">
                     <label for="" style="font-size: 1rem;">{{ $variation->color }} ( {{ $color_sum }} )</label>
                     <ul class="list-unstyled custom-inventory-ul pb-3">
                        @foreach (getProductColorBySkuColor($product->sku,$variation->color) as $size)
                        <li class="">
                           <label for="">{{ $size->size }}</label>
                           <input name="product_ids[{{$size->id}}]" type="number" value="{{ getinventoryByproductId($size->id)->total_stock }}" min="0" class="form-control" placeholder="{{$size->size}} Inventory" style="width: 100px;padding: 0 5px;">
                        </li>
                        @endforeach
                     </ul>
                  </div>
                 @endforeach
              </div>
              <div class="col-lg-12">
                 <div class="form-group">
                    <button type="submit" class="btn btn-primary inventoryBtn">Update</button>
                 </div>
              </div>
           </form>
        </div>
     </div>
  </div>
</div>