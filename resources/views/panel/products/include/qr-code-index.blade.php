@extends('backend.layouts.empty') 
@section('title', 'QR Code Request')

@section('meta')
    <meta name="viewport" content="width=device-width, initial-scale=0.1">
@endsection

@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'Manage', 'url'=> "javascript:void(0);", 'class' => ''],
        ['name'=>'QR Code Request', 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
    @endphp

    <div class="container-fluid">
          <div class="row ">
            @php
                $productId = \Crypt::encrypt($product->id);
                $barcode_img = QrCode::size(150)->generate(route('pages.shop-show',[$user_shop_record->slug,$productId]));
            @endphp
            @for ($i = 1; $i <= $quantity; $i++)
                <div class="col-md-2 mb-3 p-1">
                    <div class="p-2" style="border:1px dotted rgba(0, 0, 0, 0.43);">
                        {!! $barcode_img !!}
                        <h6 class="text-center mt-1"><small>#PROID{{ ($product->id) }}</small></h6>
                    </div>
                </div>
            @endfor
        </div>
    </div>
    <!-- push external js -->
    @push('script')
        <script>
            window.onload = function () {
                window.print();
            }
        </script>
    @endpush
@endsection
