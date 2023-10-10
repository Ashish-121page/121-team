<!doctype html>
<html class="no-js" lang="en">
    <head> 
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Login | {{ getSetting('app_name') }}</title>
        <meta name="description" content="">
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
            <div class="container-fluid h-100" style="background-image:url('{{ getBackendLogo(getSetting('app_banner')) }}');background-size: cover;">
                <div class="row flex-row h-100">
                    <div class="col-xl-4 col-lg-4 col-md-4 m-auto">
                        <div class="authentication-form mx-auto">
                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <i class="ik ik-x"></i>
                                    </button>
                                </div>
                            @endif
                            <div class="logo-centered m-0">
                                <a href="{{ url('/') }}" target="_blank"><img height="60" src="{{ getBackendLogo(getSetting('app_logo'))}}" alt="DZE" ></a>
                            </div>
                            <p class="text-center mt-2">Welcome back! </p>
                            <form method="POST" action="{{ route('login') }}">
                            @csrf
                                <div class="form-group">
                                    <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <i class="ik ik-user"></i>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                    <i class="ik ik-lock"></i>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @if(getSetting('recaptcha') == 1)
                                <div class="form-group row">
                                    <div class="col-md-6"> {!! htmlFormSnippet() !!} </div>
                                 </div>
                                 @endif
                                <div class="row">
                                    <div class="col text-left">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="item_checkbox" name="item_checkbox" value="option1">
                                            <span class="custom-control-label">&nbsp;Remember Me</span>
                                        </label>
                                    </div>
                                    {{-- <div class="col text-right">
                                        <a class="btn text-danger" href="{{url('password/forget')}}">
                                            {{ __('Forgot Password?') }}
                                        </a>
                                    </div> --}}
                                </div>
                                <div class="sign-btn text-center">
                                    <button class="btn btn-custom">Sign In</button>
                                </div>
                                {{-- <div class="register">
                                    <p>{{ __('No account?')}} <a href="{{url('register')}}">{{ __('Sign Up')}}</a></p>
                                </div> --}}
                                <div class="text-center template-demo">
                                    @foreach(getSocialLinks() as $link)
                                        {!! $link !!}
                                    @endforeach
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('backend/src/js/vendor/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/popper.js/dist/umd/popper.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/screenfull/dist/screenfull.js') }}"></script>
        
    </body>
</html>
