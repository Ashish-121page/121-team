<meta charset="utf-8" />
<title> {{ $meta_title ?? getSetting('seo_meta_title') }} </title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8">
<meta name="description" content="{{ $meta_description ?? getSetting('seo_meta_description') }}">
<meta name="keywords" content="{{ $meta_keywords }}">
<meta name='subject' content='{{$meta_motto}}'>
<meta name='copyright' content='{{env('APP_NAME')}}'>
<meta name='language' content='IN'>
<meta name='robots' content='index,follow'>
<meta name='abstract' content='@isset($meta_abstract){{$meta_abstract}}@endisset'>
<meta name='topic' content='Business'>
<meta name='summary' content='{{$meta_motto}}'>
<meta name='Classification' content='Business'>
<meta name='author' content='@isset($meta_author_name){{$meta_author_email}}@endisset'>
<meta name='designer' content=''>
<meta name='reply-to' content='@isset($meta_author_name){{$meta_author_name}}@endisset'>
<meta name='owner' content='@isset($meta_reply_to){{$meta_reply_to}}@endisset'>
<meta name='url' content='{{url()->current()}}'>
<meta name="og:title" content="{{ $meta_title }}"/>
<meta name="Developer" content="Ashish">
<meta name="og:type" content="{{$meta_motto}}"/>
<meta name="og:url" content="{{url()->current()}}"/>
<meta name="og:image" content="@isset($meta_img){{$meta_img}}@endisset"/>
<meta name="og:site_name" content="{{env('APP_NAME')}}"/>
<meta name="og:description" content="{{ $meta_description ?? getSetting('seo_meta_description') }}"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="icon" href="{{  getBackendLogo(getSetting('app_favicon'))}}" />
{{-- <link rel="manifest" href="{{ asset('frontend/assets/manifest/manifest.webmanifest') }}"> --}}
@laravelPWA
    <!-- favicon -->
    <link rel="shortcut icon" href="{{  getBackendLogo(getSetting('app_favicon'))}}">
    <!-- Bootstrap -->
    <link href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Slider -->
    {{-- <link rel="stylesheet" href="{{ asset('backend/plugins/jquery-toast-plugin/dist/jquery.toast.min.css')}}">               --}}
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/tiny-slider.css') }}"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css">
    <!-- Icons -->
    <link href="{{ asset('frontend/assets/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="https://unicons.iconscout.com/release/v3.0.6/css/line.css" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('frontend/assets/css/zoom.css') }}" rel="stylesheet" type="text/css"/>
    <!-- Main Css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link href="{{ asset('frontend/assets/css/style.min.css') }}" rel="stylesheet" type="text/css" id="theme-opt" />
    <link href="{{ asset('frontend/assets/css/colors/default.css') }}" rel="stylesheet" id="color-opt">
    <link href="{{ asset('frontend/assets/css/edit.css') }}" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('backend/plugins/jquery-toast-plugin/dist/jquery.toast.min.css')}}">
   <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
   <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
    <style>


        .fltr-mnu p{
            font-size: 13px;
            padding: 0px 0px;
            text-align: center;
            margin: 5px 3px;
            font-weight: 700;
            width:98%;
            letter-spacing: 0.8px;
            cursor: pointer;
            line-height: 34px;
            transition: all 0.5s ease;
        }
        .fltr-mnu p:hover{
            border-color: #6666CC !important;
        }
        .active1{
           border-color: #6666CC !important;
        }
        .owl-nav{
            display:block!important;
        }
        .owl-prev{
            position: absolute;
            left: -20px;
            top: 0;
            font-size: 42px!important;
            line-height: 1!important;
            color: #6666cc!important;
        }
        .owl-next{
            position: absolute;
            right: -20px;
            top: 0;
            font-size: 42px!important;
            line-height: 1!important;
            color: #6666cc!important;
        }
        @media(max-width:420px){
            .text-primary{
                font-size:14px;
            }
            .carosud{
                text-align: center
            }


        }

        .owl-item {
            cursor: pointer;
        }


    </style>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-QGKE28888Y"></script>
        <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-QGKE28888Y');
    </script>

