@extends('backend.layouts.main')
@section('title', 'Edit Product Inventory')
@section('content')
    @php
    $breadcrumb_arr = [['name' => 'Update Inventory', 'url' => 'javascript:void(0);', 'class' => '']];
    $variations = getProductColorBySku($product->sku);
    @endphp
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <style>
            .error {
                color: red;
            }
            .product-img{
                border-radius: 10px;
                width: 100%;
                height: 100%;
                object-fit: contain;
            }
            .custom-inventory-ul{
                justify-content: space-around;
            }
        </style>
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>Update Inventory</h5>
                            {{-- <span>Update a record for Product Inventroy</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="h6">Product Name: <span><b>{{ $product->title }}</b></span></div>
                <div class="h6">Product ID: <span><b>#121_{{ $product->id }}</b></span></div>
                <div class="h6">Modal Code: <span><b>{{ $product->model_code }}</b></span></div>

                <div class="row justify-content-center my-3">
                    <div class="col-12 col-md-6 col-sm-4">
                        <img src="{{ asset(getShopProductImage($product->id)->path) }}" alt="{{ $product->title }}'s Image" height="220px" width="220px" class="img-fluid rounded border p-4">
                    </div>
                    <div class="col-12 col-md-6 col-sm-8">
                        <div class="h6">Total Stock:  <span>{{ App\Models\Inventory::where('product_sku',$product->sku)->selectRaw("sum(total_stock) as sum, product_sku")->pluck('sum','product_sku')[$product->sku] ?? "" }}</span></div>
                        <div class="h6">Varients: <span>{{ count($variations) ?? 1 }}</span></div>

                        {{-- <a href="#history" class="btn btn-primary my-2">Check Product History</a> --}}
                    </div>
                </div>

                

               <div class="row my-3">
                    <div class="col-12">
                       <form id="inventoryStoreForm" action="{{ route('panel.products.inventory.store') }}" method="post">
                            @csrf   
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            @foreach ($variations as $variation)
                                {{-- Calculate Color Varient Sum --}}
                                @php
                                    $color_sum = 0;
                                    
                                    foreach (getProductColorBySkuColor($product->sku,$variation->color) as $size) {
                                        $ashu = getinventoryByproductId($size->id)->total_stock ?? 0;
                                        $color_sum = $color_sum + $ashu;
                                    }
                                @endphp
                                <div class="form-group">
                                    <label for="" style="font-size: 1rem;">{{ $variation->color }} ( {{ $color_sum }} )</label>
                                    <ul class="list-unstyled custom-inventory-ul pb-3">
                                    @foreach (getProductColorBySkuColor($product->sku,$variation->color) as $size)
                                    <li class="">
                                        <label for="">{{ $size->size }}</label>
                                        <input name="product_ids[{{$size->id}}]" type="number" value="{{ getinventoryByproductId($size->id)->total_stock ?? 0 }}" min="0" class="form-control" placeholder="{{$size->size}} Inventory" style="width: 100px;padding: 0 5px;">
                                    </li>
                                    @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        <button type="submit" class="btn btn-primary">Submit</button>
                       </form>
                    </div>
               </div>



                
            </div>

        </div>
    </div>
    <!-- push external js -->
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
        <script>
            $('#ProductForm').validate(); 
            $('#category_id').change(function(){
                var id = $(this).val();
                if(id){
                    $.ajax({
                        url: "{{route('panel.user_shop_items.get-category')}}",
                        method: "get",
                        datatype: "html",
                        data: {
                            id:id
                        },
                        success: function(res){
                            console.log(res);
                            $('#sub_category').html(res);
                        }
                    })
                }
            });  
            $(document).on('click','.update-sku',function(e){
                e.preventDefault();
                var url = $(this).attr('href');
                var msg = $(this).data('msg') ?? "You won't be able to revert back!";
                $.confirm({
                    draggable: true,
                    title: 'Are You Sure Update SKU!',
                    content: msg,
                    type: 'info',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Update',
                            btnClass: 'btn-info',
                            action: function(){
                                    window.location.href = url;
                            }
                        },
                        close: function () {
                        }
                    }
                });
            });  
        $(document).ready(function(){
            $("#title").keypress(function(){
                var title = $('#title').val()
                $('#slug').val('/'+title)
            });
            $(".remove-img").on('click',function(){
                $('#img').val('')
                $('#img-preview').hide( )
            });
        });     
        </script>
    @endpush
@endsection
