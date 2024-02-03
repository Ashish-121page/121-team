<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer-py-60 pb-1">
                    <div class="row">
                        <div class="col-lg-4 col-12 mb-0 mb-md-4 pb-0 pb-md-2">
                            <a href="{{url('/')}}" class="logo-footer text-white">
                                <img src="{{ getBackendLogo(getSetting('app_white_logo'))}}" alt="">
                            </a>
                            <p class="mt-4">{{ getSetting('frontend_footer_description') }}</p>
                            <ul class="list-unstyled social-icon foot-social-icon mb-0 mt-4">
                                <li class="list-inline-item"><a target="_blank" href="{{ getSetting('facebook_link') }}" class="rounded"><i data-feather="facebook" class="fea icon-sm fea-social"></i></a></li>
                                <li class="list-inline-item"><a target="_blank" href="{{ getSetting('instagram_link') }}" class="rounded"><i data-feather="instagram" class="fea icon-sm fea-social"></i></a></li>
                                <li class="list-inline-item">
                                    <a target="_blank" href="{{ getSetting('twitter_link') }}" class="rounded">
                                        <svg width="12" height="12" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                            <path fill="#fff" d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07l-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                                        </svg>
                                    </a>
                                </li>
                                <li class="list-inline-item"><a target="_blank" href="{{ getSetting('linkedin_link') }}" class="rounded"><i data-feather="linkedin" class="fea icon-sm fea-social"></i></a></li>
                            </ul><!--end icon-->
                        </div><!--end col-->
                        <div class="col-lg-2">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <h5 class="footer-head mb-0">Company</h5>
                                </div><!--end col-->

                                <div class="col-lg-12 col-md-12 col-12 mt-2 mt-sm-0">
                                    <ul class="list-unstyled footer-list">
                                            <li><a href="{{ route('about') }}" class="text-foot"><i class="uil uil-angle-right-b me-1"></i>About</a></li>
                                            {{-- <li><a href="{{ route('plan.index') }}" class="text-foot"><i class="uil uil-angle-right-b me-1"></i>Plan</a></li> --}}
                                            <li class="pb-3"><a href="{{ route('contact.index') }}" class="text-foot"><i class="uil uil-angle-right-b me-1"></i>Contact</a></li>
                                    </ul>
                                </div>
                            </div><!--end row-->
                        </div><!--end col-->
                        <div class="col-lg-2">
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <h5 class="footer-head mb-0">Quick Links</h5>
                                </div><!--end col-->

                                <div class="col-lg-12 col-md-12 col-12 mt-2 mt-sm-0">
                                    <ul class="list-unstyled footer-list">

                                            <li><a href="@if (auth()->check()){{ route('customer.dashboard') }} @else {{ route('auth.login-index') }} @endif" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> My account </a></li>
                                        {{-- <li><a href="{{ route('customer.order-history') }}" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Order History </a></li> --}}
                                        {{-- <li><a href="#" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> Enquiries </a></li> --}}
                                        {{-- <li><a href="{{ route('website.faq') }}" class="text-foot"><i class="uil uil-angle-right-b me-1"></i> FAQs </a></li> --}}
                                    </ul>
                                </div>
                            </div><!--end row-->
                        </div><!--end col-->

                        {{-- Newsletter --}}
                        {{-- <div class="col-lg-4 col-md-6 col-12 mt-4 mt-lg-0 pt-2 pt-lg-0">
                            <h5 class="footer-head">Newsletter</h5>
                            <p class="mt-3">Sign up and receive the latest tips via email.</p>
                            <form action="{{ route('newsletter.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="foot-subscribe mb-3">
                                            <div class="form-icon position-relative">
                                                <i data-feather="mail" class="fea icon-sm icons"></i>
                                                <input type="text" name="name" id="namesubscribe" class="form-control ps-5 rounded" placeholder="Your Name : " required>
                                            </div>

                                            <div class="form-icon position-relative mt-3">
                                                <i data-feather="mail" class="fea icon-sm icons"></i>
                                                <input type="email" name="email" id="emailsubscribe" class="form-control ps-5 rounded" placeholder="Your email : " required>
                                            </div>
                                            @php
                                                $country = App\Models\Country::get();
                                            @endphp
                                            <div class="row mt-2">
                                                <div class="col-4 mt-2">
                                                    <select name="countrycode" id="country" class="form-select select2 countrycode" style="background-color: transparent">
                                                        <option value="91" selected> India </option>
                                                        @foreach ($country as $item)
                                                            <option value="{{$item->phonecode}}"> {{$item->name}} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-8">
                                                    <div class="form-icon position-relative">
                                                        <i data-feather="phone" class="fea icon-sm icons"></i>
                                                        <input type="tel" maxlength="15" name="number" id="numbersubscribe" class="form-control ps-5 rounded" placeholder="Your Mobile Number" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="d-grid">
                                            <input type="submit" id="submitsubscribe" class="btn btn-soft-primary" value="Subscribe">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div> --}}


                        <div class="col-lg-4 col-md-6 col-12 mt-4 mt-lg-0 pt-2 pt-lg-0">
                            <h5 class="footer-head">Book A Demo</h5>
                            <p class="mt-3">Schedule a live demo with our
                                representative.</p>
                            <div class="col-lg-12">
                                <div class="d-grid">
                                    <a href="{{ url('start') }}" class="btn btn-soft-primary">Book Demo</a>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div><!--end container-->

    {{-- <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer-py-30 footer-border">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="uil uil-truck align-middle h5 mb-0 me-2"></i>
                                    <h6 class="mb-0">Free delivery</h6>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="uil uil-archive align-middle h5 mb-0 me-2"></i>
                                    <h6 class="mb-0">Non-contact shipping</h6>
                                </div>
                            </div>

                            <!--<div class="col-lg-3">
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="uil uil-transaction align-middle h5 mb-0 me-2"></i>
                                    <h6 class="mb-0">Money-back quarantee</h6>
                                </div>
                            </div>-->

                            <div class="col-lg-4">
                                <div class="d-flex align-items-center justify-content-center">
                                    <i class="uil uil-shield-check align-middle h5 mb-0 me-2"></i>
                                    <h6 class="mb-0">Secure payments</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="footer-py-30 footer-border">
                    <div class="container text-center">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="text-sm-start">
                                    <p class="mb-0">Copyright © <script>document.write(new Date().getFullYear())</script> All Rights Reserved</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <p class="mb-0 text-center">{{ getSetting('app_name') }}</p>
                            </div>
                            <div class="col-md-4">
                                    <ul class="policy-menu d-flex justify-content-center">
                                        <li class="m-2"><a class="text-muted" href="{{ url('page/privacy-policy') }}">Privacy Policy</a></li>
                                        <li class="m-2"><a class="text-muted" href="{{ url('page/terms') }}">Terms & Conditions</a></li>
                                    </ul>
                            </div>
                        </div><!--end row-->
                    </div><!--end container-->
                </div>
            </div>
        </div>
    </div><!--end container-->
</footer>
