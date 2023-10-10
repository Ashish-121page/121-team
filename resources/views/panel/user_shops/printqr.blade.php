<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print Qr Codes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <style>
        .qrbox{
            height: 25%;
            padding: 15px;
            text-align: center;
            margin: 7px;
            width: 280px !important;
        }
        .qr-code svg{
            height: 10rem !important;
        }
        @media screen and (max-width: 600px){
            body{
                background-color: #1e1e1e;
                color: #fff;
            }
            .qrbox{
                height: 25%;
                padding: 10px;
                text-align: center;
                margin: 5px;
            }
        }
    </style>
  </head>
  <body>
    
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-center flex-wrap w-100">

            @foreach ($qr as $item)
                {{-- 1st QR --}}
                <div class="qrbox border border-primary">
                    <div class="log d-flex justify-content-center align-items-center">
                        <img src="{{ getFrontendLogo(getSetting('frontend_logo')) }}" alt="Site Logo" height="40px" class="py-1">
                    </div>
                    <hr>
                    <div class="slug fw-bold p-2">
                        {{ $item }}.121.Page
                    </div>
                    <div class="slogan text-center">
                        <small>Scan to get latest offers</small>
                    </div>
                    <div class="qr-code d-flex justify-content-center p-2" style="height: 25%;">
                        <!--?xml version="1.0" encoding="UTF-8"?-->
                        {{-- {!! QrCode::size(200)->generate(route('microsite.proxy')."?page=home&is_scan=1&shop=$item") !!} --}}
                        {!! QrCode::size(200)->generate(url('/short/supplier')) !!}
                    </div>

                    <div class="details mt-4 text-center">
                        <div class="phone">{{ getSellerPhoneBySlug($item) }}</div>
                        @php
                            $user_id = UserShopUserIdBySlug($item);
                        @endphp
                        <div class="email">{{  App\User::whereId($user_id)->first()->email  }}</div>
                    </div>
                    
                    <hr>
                    
                    <div class="slogan text-center text-muted m-0 p-0" style="font-size: 0.8rem;">
                        Powered by 121.page
                    </div>
                </div>

                {{-- 2nd QR --}}
                <div class="qrbox border border-primary">
                    <div class="log d-flex justify-content-center align-items-center">
                        <img src="{{ getFrontendLogo(getSetting('frontend_logo')) }}" alt="Site Logo" height="40px" class="py-1">
                    </div>
                    <hr>
                    <div class="slug fw-bold p-2">
                        {{ $item }}.121.Page
                    </div>
                    <div class="slogan text-center">
                        <small>Scan to get latest offers</small>
                    </div>
                    <div class="qr-code d-flex justify-content-center p-2" style="height: 25%;">
                        <!--?xml version="1.0" encoding="UTF-8"?-->
                        {!! QrCode::size(200)->generate(route('microsite.proxy')."?page=home&is_scan=1&shop=$item") !!}
                    </div>

                    <div class="details mt-4 text-center">
                        <div class="phone">{{ getSellerPhoneBySlug($item) }}</div>
                        @php
                            $user_id = UserShopUserIdBySlug($item);
                        @endphp
                        <div class="email">{{  App\User::whereId($user_id)->first()->email  }}</div>
                    </div>
                    
                    <hr>
                    
                    <div class="slogan text-center text-muted m-0 p-0" style="font-size: 0.8rem;">
                        Powered by 121.page
                    </div>
                </div>

                {{-- 3rd QR --}}
                <div class="qrbox border border-primary">
                    <div class="log d-flex justify-content-center align-items-center">
                        <img src="{{ getFrontendLogo(getSetting('frontend_logo')) }}" alt="Site Logo" height="40px" class="py-1">
                    </div>
                    <hr>
                    <div class="slug fw-bold p-2">
                        {{ $item }}.121.Page
                    </div>
                    <div class="slogan text-center">
                        <small>Scan to get latest offers</small>
                    </div>
                    <div class="qr-code d-flex justify-content-center p-2" style="height: 25%;">
                        <!--?xml version="1.0" encoding="UTF-8"?-->
                        {!! QrCode::size(200)->generate(route('microsite.proxy')."?page=home&is_scan=1&shop=$item") !!}
                    </div>

                    <div class="details mt-4 text-center">
                        <div class="phone">{{ getSellerPhoneBySlug($item) }}</div>
                        @php
                            $user_id = UserShopUserIdBySlug($item);
                        @endphp
                        <div class="email">{{  App\User::whereId($user_id)->first()->email  }}</div>
                    </div>
                    
                    <hr>
                    
                    <div class="slogan text-center text-muted m-0 p-0" style="font-size: 0.8rem;">
                        Powered by 121.page
                    </div>
                </div>

                {{-- 4th  QR --}}
                <div class="qrbox border border-primary">
                    <div class="log d-flex justify-content-center align-items-center">
                        <img src="{{ getFrontendLogo(getSetting('frontend_logo')) }}" alt="Site Logo" height="40px" class="py-1">
                    </div>
                    <hr>
                    <div class="slug fw-bold p-2">
                        {{ $item }}.121.Page
                    </div>
                    <div class="slogan text-center">
                        <small>Scan to get latest offers</small>
                    </div>
                    <div class="qr-code d-flex justify-content-center p-2" style="height: 25%;">
                        <!--?xml version="1.0" encoding="UTF-8"?-->
                        {!! QrCode::size(200)->generate(route('microsite.proxy')."?page=home&is_scan=1&shop=$item") !!}
                    </div>

                    <div class="details mt-4 text-center">
                        <div class="phone">{{ getSellerPhoneBySlug($item) }}</div>
                        @php
                            $user_id = UserShopUserIdBySlug($item);
                        @endphp
                        <div class="email">{{  App\User::whereId($user_id)->first()->email  }}</div>
                    </div>
                    
                    <hr>
                    
                    <div class="slogan text-center text-muted m-0 p-0" style="font-size: 0.8rem;">
                        Powered by 121.page
                    </div>
                </div>
                <p style="page-break-after: always;">&nbsp;</p>
           @endforeach

            
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        window.print()
    </script>
  </body>
</html>