<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Register | {{ getSetting('app_name') }}</title>
        <meta name="description" content="Register Page">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="{{ getBackendLogo(getSetting('app_favicon'))}}" type="image/x-icon" />

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">
        
        <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/ionicons/dist/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/icon-kit/dist/css/iconkit.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/dist/css/theme.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
        <script src="{{ asset('backend/src/js/vendor/modernizr-2.8.3.min.js') }}"></script>
        
        @if(getSetting('recaptcha') == 1)
        {!! ReCaptcha::htmlScriptTagJsApi() !!}
        @endif
    </head>

    <body>

        <div class="auth-wrapper">
            <div class="container-fluid h-100" >
                <div class="row flex-row h-100 bg-white">
                    <div class="col-xl-8 col-lg-6 col-md-5 p-0 d-md-block d-lg-block d-sm-none d-none">
                        <div class="lavalite-bg">
                            <div class="lavalite-overlay" style="background-image:url('{{ getBackendLogo(getSetting('app_banner_i')) }}');background-size: cover;"></div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-7 my-auto p-0">
                        <div class="authentication-form mx-auto">
                            <div class="logo-centered mb-2">
                                <a href="{{url('/')}}">
                                    <img height="60" src="{{ getBackendLogo(getSetting('app_logo'))}}" class="header-brand-img" title="{{config('app.name')}}">
                                </a>
                            <p>{{ __('Join us today! It takes only few steps')}}</p>
                            <form action="{{ url('register') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <input type="name" class="form-control" placeholder="Name" name="name" value="{{ old('name') }}" required>
                                    <i class="ik ik-user"></i>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required>
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="form-group">
                                    <input type="phone" class="form-control" placeholder="Phone" name="phone" value="{{ old('phone') }}" required>
                                    <i class="ik ik-phone"></i>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                                    <i class="ik ik-lock"></i>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation" required>
                                    <i class="ik ik-eye-off"></i>
                                </div>
                                @if(getSetting('recaptcha') == 1)
                                    <div class="form-group row">
                                        <div class="col-md-6"> {!! htmlFormSnippet() !!} </div>
                                    </div>
                                 @endif
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="item_checkbox" name="item_checkbox" value="option1">
                                            <span class="custom-control-label">&nbsp;{{ __('I Accept')}} 
                                                <a href="{{ url('/page/terms') }}">{{ __('Terms and Conditions')}}</a>
                                                <a href="{{ url('/page/data-privacy') }}">{{ __('Privacy and Policy')}}</a>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="sign-btn text-center">
                                    <button class="btn btn-theme">{{ __('Create Account')}}</button>
                                </div>
                            </form>
                            <div class="register">
                                <p>{{ __('Already have an account?')}} <a href="{{url('login')}}">{{ __('Sign In')}}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="{{ asset('src/js/vendor/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('plugins/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('plugins/screenfull/dist/screenfull.js') }}"></script>
    </body>
</html>
