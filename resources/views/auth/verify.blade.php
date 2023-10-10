@extends('backend.layouts.app')

@section('content')
<style>
    .verify-card{
        position: fixed;top: 40%;left: 50%;transform: translate(-50%, -50%);
    }
    @media only screen and (max-width: 767px) {
    .verify-card {
        position: relative;
        top:100px;
        left:0;
        transform: none;
    }
}
</style>
<div class="container">
    <div class="card py-5 verify-card">
        <div class="row text-align-center">
            <div class="col-12 col-lg-8 mx-auto text-center">
                <img src="{{ getBackendLogo(getSetting('app_logo'))}}" alt="">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 mx-auto mt-3">
                <div class="card p-3 " style="border: none;">
                    <h3 class="text-center">{{ __('Verify Your Email Address') }}</h3>
    
                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif
    
                       <span style="font-size:17px;"> {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }},</span>
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
