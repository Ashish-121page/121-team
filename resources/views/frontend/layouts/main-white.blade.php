<!doctype html>
<html class="no-js" lang="en">
    <head> 
    <meta charset="utf-8" />
    <title>Login | {{ getSetting('app_name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="email" content="" />
    <meta name="website" content="" />
    <meta name="Version" content="v3.8.0" />
    <!-- favicon -->
    <link rel="icon" href="{{ getBackendLogo(getSetting('app_favicon'))}}" type="image/x-icon" />
    <!-- Bootstrap -->
    <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Slider -->               
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/tiny-slider.css') }}"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css">
    <!-- Icons -->
    <link href="{{ asset('frontend/assets/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://unicons.iconscout.com/release/v3.0.6/css/line.css')"  rel="stylesheet">
    <!-- Main Css -->
    <link href="{{ asset('frontend/assets/css/style.min.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
    <link href="{{ asset('frontend/assets/css/colors/default.css') }}" rel="stylesheet" id="color-opt">
    <link href="{{ asset('frontend/assets/css/edit.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/jquery-toast-plugin/dist/jquery.toast.min.css')}}">
        <style>
            .text {
              display: table;
              margin: 20px auto;
            }
            
            
            .t-dropdown-list {
              display: none;
              background-color: #FFF;
              border: 1px solid #DDD;
              z-index: 10;
              box-shadow: 4px 4px 5px rgba(0, 0, 0, .3);
              list-style: none;
              margin: 0;
              padding: 0;
              height: 150px;
              overflow: auto;
              position: absolute;
              margin-top: 10px;
            }
            
            .t-dropdown-item {
              padding: 5px 20px;
              margin: 0;
              cursor: pointer;
            }
            .form-floating>.t-dropdown-block{
                height: calc(3.5rem + 2px);
                line-height: 1.25;
            }
            .form-control:focus #inds{
                opacity: .65;
                transform: scale(.85) translateY(-0.5rem) translateX(0.15rem);
            }
            
            .form-floating>label {
                position: absolute;
                top: 0;
                left: 0;
                height: 100%;
                padding: .55rem .75rem;
                pointer-events: none;
                border: 1px solid transparent;
                transform-origin: 0 0;
                transition: opacity .1s ease-in-out,transform .1s ease-in-out;
            }
            .t-dropdown-item:hover {
              background-color: #F1F1F1;
            }
            
            .t-dropdown-select {
              border: 1px solid #DDD;
              width: 100%;
              height: 100%;
              border-radius: 6px;
              position: relative;
              overflow: hidden;
              background-color: #FFF;
              box-sizing: content-box;
            }
            
            .t-dropdown-input {
              border: 0;
              height: 100%;
              width: 100%;
              padding: .60rem .75rem;
              box-sizing: border-box;
            }
            
            .t-select-btn {
              background-image: url(https://cdn4.iconfinder.com/data/icons/ui-indicatives/100/Indicatives-26-128.png);
              background-position: center;
              background-repeat: no-repeat;
              background-size: 7px 7px;
              position: absolute;
              width: 30px;
              top: 0;
              right: 0;
              height: 100%;
              border-left: 1px solid #DDD;
            }
            
            .t-select-btn:active {
              background-color: #F1F1F1;
            }
            .steper{
                margin:0;
                padding:0;
                position:relative;
            }
            .steper li{
                list-style: none;
                text-align: center;
                display: inline-block;
                padding-right: 90px;
                position:relative;
                z-index:9;
            }
            .steper li a i{
                font-size: 13px;
                border: 1px solid #ccc;
                border-radius: 50%;
                padding: 0px 2px;
                color:#6666CC !important;
            }
            .steper li a p{
               font-size:13px; 
               color:#6666CC !important;
            }
            .step-hr{
                margin: 0;
                padding: 0;
                position: absolute;
                top: 13px;
                left: 46.5px;
                right: 0;
                width: 77%;
                z-index: 0;
            }
        </style>
     </head>

    <body>
        
      @yield('content')

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
        <!-- SLIDER -->
        <script src="{{ asset('frontend/assets/js/tiny-slider.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/shuffle.min.js') }}"></script>
        <!-- Icons -->
        <script src="{{ asset('frontend/assets/js/feather.min.js') }}"></script>
        <!-- Switcher -->
        <!-- Switcher -->
        <script src="{{ asset('frontend/assets/js/switcher.js') }}"></script>
        <!-- Main Js -->     
        <script src="{{ asset('frontend/assets/js/plugins.init.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/app.js') }}"></script>
        <script src="{{ asset('backend/plugins/jquery-toast-plugin/dist/jquery.toast.min.js')}}"></script>  
        @stack('script')
    @if (session('success'))
        <script>
            $.toast({
            heading: 'SUCCESS',
            text: "{{ session('success') }}",
            showHideTransition: 'slide',
            icon: 'success',
            loaderBg: '#f96868',
            position: 'top-right'
            });
        </script>
        @endif


        @if(session('error'))
        <script>
            $.toast({
            heading: 'ERROR',
            text: "{{ session('error') }}",
            showHideTransition: 'slide',
            icon: 'error',
            loaderBg: '#f2a654',
            position: 'top-right'
            });
        </script>
    @endif
    </body>
</html>
  
