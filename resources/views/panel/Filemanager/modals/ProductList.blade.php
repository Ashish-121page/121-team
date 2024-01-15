<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">
                <input type="checkbox" id="select-all">
            </th>
            <th scope="col">SKU</th>
            <th scope="col">PRODUCT GALLERY</th>
            <th scope="col">PRICE</th>
            <th scope="col">PRODUCT VARIANT</th>
        </tr>
    </thead>
    <tbody>

        
        @foreach ($Products as $product)
            @php
                $images = App\Models\Media::whereType('Product')->whereTypeId($product->id)->whereTag('Product_Image')->get();
                $varient = App\Models\ProductExtraInfo::where('product_id',$product->id)->groupBy('attribute_value_id')->get(); 
            @endphp
        
            <tr>
                <td><input type="checkbox" class="item-checkbox" name="product_id[]" value="{{ encrypt($product->id) }}"></td>
                <td> {{ $product->model_code }} </td>
                <td>

                    <div class="d-flex align-items-center justify-content-start">
                        @foreach ($images as $key => $image)

                            @if ($key <= 4)
                                <img src="{{ asset($image->path) }}" style="height: 50px; width: 50px" alt="test Image" class="img-fluid mx-1">
                            @endif

                        @endforeach
                        <span class="mx-1">
                            @if (count($images) > 6)
                                + {{ count($images) - 5 }}
                            @else
                                {{ count($images) }}
                            @endif
                        </span>
                    </div>
                    
                </td>
                <td>
                    {{ $product->base_currency ?? 'INR' }}
                    {{ $product->price }}
                </td>
                <td>   
                    @forelse ($varient as $item)
                        <span class=" text-dark ">{{ getAttruibuteValueById($item->attribute_value_id)->attribute_value ?? ''}}</span> ,
                    @empty
                        No Varient
                    @endforelse
                </td>
            </tr>
        @endforeach
    </tbody>
</table>