<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Forgot Password | {{ getSetting('app_name') }}</title>
        <meta name="description" content="Forgot Page">
        <meta name="keywords" content="forgot">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="{{ asset('dze-grey.png')}}" type="image/x-icon" />

        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">
        
        <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap/dist/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css')}}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/ionicons/dist/css/ionicons.min.css')}}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/icon-kit/dist/css/iconkit.min.css')}}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}">
        <link rel="stylesheet" href="{{ asset('backend/dist/css/theme.min.css')}}">
        <link rel="stylesheet" href="{{ asset('backend/dist/css/style.css')}}">
        <link rel="stylesheet" href="{{ asset('backend/dist/css/theme-image.css')}}">
        <script src="{{ asset('backend/src/js/vendor/modernizr-2.8.3.min.js')}}"></script>
    </head>

    <body>

        <div class="auth-wrapper">
            <div class="container-fluid h-100">
                <div class="row flex-row h-100 bg-white">
                    <div class="col-xl-8 col-lg-6 col-md-5 p-0 d-md-block d-lg-block d-sm-none d-none">
                        <div class="lavalite-bg" >
                            <div class="lavalite-overlay" style="background-image:url('{{ getBackendLogo(getSetting('app_banner_i')) }}');background-size: cover;"></div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-7 my-auto p-0">
                        <div class="authentication-form mx-auto">
                            <div class="logo-centered">
                                <a href="{{ url('/') }}"><img width="200"  src="{{ getBackendLogo(getSetting('app_logo'))}}" style="position: relative; right: 80px;" alt=""></a>
                            </div>
                            <h3>{{ __('Forgot Password') }}</h3>
                            <p>{{ __('We will send you a link to reset password.') }}</p>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Your email address" name="email" value="{{ old('email') }}" required>
                                    <i class="ik ik-mail"></i>
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="sign-btn text-center">
                                    <button class="btn btn-theme">{{ __('Submit') }}</button>
                                </div>
                            </form>
                            <div class="register">
                                <p>{{ __('Not a member') }}? <a href="{{ url('register')}}">{{ __('Create an account') }}</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="{{ asset('backend/src/js/vendor/jquery-3.3.1.min.js')}}"></script>
        <script src="{{ asset('backend/plugins/popper.js')}}/dist/umd/popper.min.js')}}"></script>
        <script src="{{ asset('backend/plugins/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <script src="{{ asset('backend/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js')}}"></script>
        <script src="{{ asset('backend/plugins/screenfull/dist/screenfull.js')}}"></script>
    </body>
</html>
