@extends('frontend.layouts.main-white')
@section('content')
    <section class="bg-home bg-circle-gradiant d-flex align-items-center">
        <div class="bg-overlay bg-overlay-white">
            </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="form-signin p-4 bg-white rounded shadow mt-3 mb-3">
                        <form action="{{ route('auth.signup-validate') }}" method="post" class="mt-3 mb-3">
                            @csrf
                                <input type="hidden" name="phone" value="{{ $phone }}">
                            <a href=""><img src="{{ asset('frontend/assets/img/logo-icon.png') }}" class="avatar avatar-small mb-4 d-block mx-auto" alt=""></a>

                            <div class="position-relative">
                                <div class="position-absolute w-100 " style="top: 50%; transform: translateY(-50%); background: #6c636338; height: 5px; z-index: 1"></div>
                                <div class="position-relative d-flex justify-content-between align-items-center" style="z-index: 10">
                                    @if(request()->routeIs('auth.signup') == true)
                                        <span class="d-flex align-items-center text-white justify-content-center p-1 bg-primary" style="border-radius: 100%; height: 24px; width: 24px ">
                                            <i class="mdi mdi-check"></i>
                                        </span>
                                    @endif
                                    <span class="d-flex align-items-center text-white justify-content-center p-1 bg-primary" style="border-radius: 100%; height: 24px; width: 24px ">
                                        @if(!request()->routeIs('auth.signup') == true)
                                            <i class="mdi mdi-check"></i>
                                        @endif
                                    </span>
                                    <span class="d-flex align-items-center text-white justify-content-center p-1  @if(!request()->routeIs('auth.signup') == true) bg-primary @else bg-gray @endif"  style="border-radius: 100%; height: 24px; width: 24px ">
                                        @if(!request()->routeIs('auth.signup') == true)
                                            <i class="mdi mdi-check"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4 mt-1" style="font-size: 14px">
                                <span class="text-center">OTP<br>Verified</span>
                                <span class="text-center">Register</span>
                                <span class="text-center">Finish</span>
                            </div>


                            {{-- <ul class="steper mb-4">
                                <hr class="step-hr">
                                <li><a href="#"><i class="mdi mdi-check"></i>
                                    <p class="mb-0">OTP Verified</p>
                                </a></li>
                                <li><a href="#"><i class="mdi mdi-check" style="background:#6666CC !important"></i>
                                    <p class="mb-0">Register</p>
                                </a></li>
                                <li style="padding-right:0"><a href="#"><i class="mdi mdi-check" style="color:#fff!important;"></i>
                                    <p class="mb-0" style="color:#444!important;">Finish</p>
                                </a></li>
                                
                            </ul> --}}
                            
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="mb-2">
                                        <input type="text" required name="name" class="form-control" id="name" placeholder="Business Name" value="{{ old('name') }}">
                                    </div>
                                    <div class="mb-2">
                                        <input type="email" required name="email" class="form-control" id="Email" placeholder="Business Email" value="{{ old('email') }}">
                                    </div>
                                    <div class="mb-2">
                                        <input type="password" required name="password" class="form-control" id="Password" placeholder="Enter Password" value="{{ old('password') }}">
                                    </div>
                                    <div class="form-check mb-3">
                                        <input required class="form-check-input" type="checkbox"  id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault"><a href="{{ url('page/terms') }}" class="text-primary">Terms And Conditions <span class="text-danger">*</span></a></label>
                                    </div>
                                    <button class="btn btn-primary w-100" type="submit">Create Account</button>
                                </div>
                            </div>
                            <p class="mb-0 text-muted mt-3 text-center" style="position:relative"><span style="position:absolute;left:0;">© {{ date('Y') }}</span> 121.Page</p>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!--end container-->
    </section>
@endsection
