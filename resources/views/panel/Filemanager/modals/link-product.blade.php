<!-- Modal -->
<div class="modal fade" id="linkproductModal" tabindex="-1" aria-labelledby="linkproductLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-title d-flex justify-content-between">
                <div class="h5 m-2">Link Product</div>
                <button type="button" class="btn btn-outline-primary m-2" data-bs-dismiss="modal" aria-label="Close">
                    X
                </button>
            </div>
            <div class="modal-body">
                
                <form method="POST" action="{{ route('panel.filemanager.link.product',encrypt(auth()->id()) ) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="images" id="imagelinkModel">

                    <label for="productid">Select Product</label>
                    
                    <select name="product_id[]" id="productidModal" class="form-control select2" multiple>
                        @foreach ($Products as $Product)
                            <option value="{{ encrypt($Product->id) }}">Model: {{ $Product->model_code." - ".$Product->title }} - Main </option>
                        @endforeach

                        @foreach ($Products_attribute as $Product)
                            @php
                                $pdata = App\Models\Product::where('id',$Product->product_id)->first();
                                $dump = getAttruibuteValueById($Product->attribute_value_id)->attribute_value ?? '';
                            @endphp
                            @if ($dump != '')
                                <option value="{{ encrypt($Product->product_id) }}"> Model: {{ $pdata->model_code." - ".$pdata->title }} - {{ $dump }} </option>
                            @endif
                        @endforeach

                    </select>
                    <button type="submit" class="btn btn-outline-primary my-3">Submit</button>

                </form>
            </div>
        </div>
    </div>
</div>