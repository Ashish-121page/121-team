@extends('backend.layouts.empty')
<title>QR | {{ getSetting('app_name') }}</title>
{{-- <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ getBackendLogo(getSetting('app_white_logo'))}}" alt="website Logo" style="height: 55px;">
            </a>
        </div>
    </nav>
</header> --}}
@section('content')
    <style>
        @media print {
            .hide-print {
                display: none;
            }
           
            .qr-grid:nth-child(9n){
                break-after:  page;
            }
            .row {
                display: -ms-flexbox;
                display: flex;
                -ms-flex-wrap: wrap;
                flex-wrap: wrap;
                margin-right: -15px;
                margin-left: -15px;
            }
            .col-lg-4 {
                margin: 5px;
                -ms-flex: 0 0 30.333333%;
                flex: 0 0 30.333333%;
                max-width: 30.333333%;
            }
        }

        .col-lg-4 {
                margin: 5px !important;
                -ms-flex: 0 0 30.333333% !important;
                flex: 0 0 30.333333%;
                max-width: 30.333333%;
            }
        
        @page {
        size: A4;
        }

        @media print {
            .break-page { 
                height: 150px;
            }   
        }

        .break-page { 
                height: 150px;
            }  

            .qr-grid > div{
                padding: 10px;
                border: 3px solid #6666CC;
                width: 100%;
            }
    </style>
    <section>
        <div class="container mt-4">
            <div class="my-2 text-center">
                <a href="javascript:void();" onclick="window.print();" class="btn btn-primary hide-print" type="button">Print</a>
            </div>
            <div class="row qr-grid">
                @php
                    $page = 0;
                @endphp
                @foreach ($product_ids as $key => $product_id)
                @php
                    $product = getProductDataById($product_id);
                    $user_shop = App\Models\UserShop::whereUserId(auth()->id())->first();

                    // $barcode_img = QrCode::size(170)->generate(route('microsite.proxy')."?page=shop/$product->id&is_scan=1&shop=$user_shop->slug");
                    $enc_product = encrypt($product_id);
                    $bhai = "shop/".$enc_product."?pg=&scan=1";
                    $url= inject_subdomain($bhai,$user_shop->slug,false,true);
                    $barcode_img = QrCode::size(170)->generate( $url );
                    $product = getProductDataById($product_id);
                @endphp

                <div class="col-lg-4 text-center mx-auto ">
                    <div>
                        {{-- <img src="{{ getBackendLogo(getSetting('app_white_logo'))}}" alt="website Logo" style="height: 40px;"> --}}
                        <h1>{{ auth()->user()->name }}</h1>
                        <hr>
                        <h5>{{ $user_shop->slug }}.121.page</h5>
                        {{-- <h6>{!! $user_shop->name !!}</h6> --}}
                        <h6>{{ 'Scan for details' }}</h6>
                        {!! $barcode_img !!}
                        {{--<h6 class="mt-2">{{ Str::limit($product->title,100) ?? '' }}</h6>--}}

                        <h6 class="mt-2" style="word-break: break-all;">
                            Model Code: {{ $product->model_code }}

                            {{-- @if($product->user_id == auth()->id()) --}}
                                {{-- {{ getMicrositeItemSKU($product->model_code) }} --}}
                            {{-- @else
                                {{ getMicrositeItemSKU($product->id) }}
                            @endif --}}
                        </h6>
                        <hr>
                        <h6 class="mt-2" style="word-break: break-all;"> Powered by 121.page</h6>
                        {{--<h6 class="mt-2" style="word-break: break-all;">Color :{{ $product->color ?? '' }} @if(isset($product->size)) , @endif {{ $product->size }}</h6>--}}
                    </div> 
                </div>
                @if($loop->iteration%9 == 0)
                    <span class="col-12 break-page">
                        <div class="mt-2 text-center">
                            Page {{++$page}}
                        </div>
                    </span>
                @endif
                @endforeach
            </div>
            {{-- <div>
                {{ $product_ids->appends(request()->query())->links() }}
            </div> --}}
        </div>
    </section>
@endsection