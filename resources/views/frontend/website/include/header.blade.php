<style>
    @media only screen and (max-width: 770px) {
        .eiodyh {
            display: block !important;
        }

    }
</style>
<style>
    /* Add custom class for reducing padding on xs screens */
    @media (max-width: 770px) {
        .sub-menu-item {
            padding: 10px 10px !important;
        }

        .desktop-nav {
            display: none !important;
        }

        .logo img {
            width: 70px !important
        }

        .mobile-nav .item-menu {
            position: absolute;
            top: 100%;
            left: 100%;
            height: calc(100vh - 100%);
            width: 100%;
            background-color: #fff !important;
            color: #111;
            padding: 2%;
            transition: all 0.5s ease-in-out;
            border-top: 1px solid #ddd;
        }

        .mobile-nav .item-menu.active {
            position: absolute;
            top: 100%;
            height: calc(100vh - 100%);
            width: 100%;
            left: 0;
            background-color: #fff;
            color: #111;
            padding: 2%;
            transition: all 0.5s ease-in-out;
        }

        .btn-link.openmenu {
            font-size: 35px !important;
            /* font-weight: 600 !important; */
            border-bottom: 1px solid;
            margin: 10px 0px;
            width: 100%;
            text-align: left;
        }

        #animatedButton {
            cursor: pointer;
            outline: none;
            transition: background-color 0.3s;
        }

        .bar {
            width: 25px;
            height: 3px;
            background-color: #6666cc;
            margin: 6px 0;
            transition: transform 0.3s;
        }

        #animatedButton.active .bar:nth-child(1) {
            transform: rotate(-45deg) translate(-6px, 6px);
        }

        #animatedButton.active .bar:nth-child(2) {
            opacity: 0;
        }

        #animatedButton.active .bar:nth-child(3) {
            transform: rotate(45deg) translate(-6px, -7px);
        }

    }
</style>
<header id="topnav" class="defaultscroll sticky">
    {{-- container Start --}}
    <div class="container desktop-nav">
        <!-- Logo container-->
        <a class="logo  list-inline-item mb-0 mt-2" href="{{ url('/') }}">
            <img src="{{ getBackendLogo(getSetting('app_white_logo')) }}" class="logo-light-mode" alt="">
            <img src="{{ getBackendLogo(getSetting('app_logo')) }}" class="logo-dark-mode" alt="">
        </a>

        <!-- Offcanvas Start -->
        <div class="offcanvas bg-white offcanvas-top" tabindex="-1" id="offcanvasTop">
            <div class="offcanvas-body d-flex align-items-center align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                <h4>Search now.....</h4>
                                <div class="subcribe-form mt-4">
                                    <form>
                                        <div class="mb-0">
                                            <input type="text" id="help" name="name"
                                                class="border bg-white rounded-pill" required=""
                                                placeholder="Search">
                                            <button type="submit" class="btn btn-pills btn-primary">Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end container-->
            </div>
        </div>

        <ul class="buy-button list-inline mb-0">
            <li class="list-inline-item">
                <button type="submit" class="btn btn-pills btn-primary sub-menu-item" id="khkop"
                    style=" margin-left: 10rem;">
                    <a href="{{ url('auth/login') }}" class="" style="color: white;">Login</a>
                </button>
            </li>

        </ul><!--end login button-->


        <div id="navigation" class="d-lg-block d-flex justify-content-center " style="margin-left: 0px !important;">
            <!-- Navigation Menu-->
            @if (request()->routeIs('plan.checkout.store') == false)
                <ul class="navigation-menu">

                    <li><a href="#why-121" class="sub-menu-item">why 121 ?</a></li>
                    <li><a href="#benefits" class="sub-menu-item">Benefits</a></li>
                    <li><a href="#faq" class="sub-menu-item">FAQ</a></li>

                    {{-- <li><a href="{{ url('/now') }}" class="sub-menu-item">Home</a></li> --}}
                    {{-- <li><a href="{{ url('/') }}" class="sub-menu-item">why 121 ?</a></li> --}}
                    {{-- <li><a href="{{ route('home.search') }}" class="sub-menu-item">Search</a></li> --}}
                    {{-- <li><a href="{{ route('about') }}" class="sub-menu-item">About</a></li> --}}
                    {{-- <li><a href="{{ route('plan.index') }}" class="sub-menu-item">Plan</a></li> --}}
                    {{-- <li><a href="{{ route('blog.index') }}" class="sub-menu-item">Blog</a></li> --}}
                    {{-- <li><a href="{{ route('contact.index') }}" class="sub-menu-item">Contact</a></li> --}}
                </ul><!--end navigation menu-->
            @endif

        </div><!--end navigation-->
    </div>
    <!--end container-->

    <div class="container mobile-nav d-flex d-md-none justify-content-between align-content-center ">
        <a class="logo  list-inline-item mb-0 mt-2" href="{{ url('/') }}">
            {{-- <img src="{{ getBackendLogo(getSetting('app_white_logo')) }}" class="logo-light-mode" alt=""> --}}
            {{-- <img src="{{ asset('storage/backend/logos/favicon-188.ico') }}" class="logo-light-mode" alt=""> --}}
            <span style="font-family: Arial;font-size: 2.2rem !important;font-weight: 500"
                class="text-primary">121</span>
            {{-- <img src="{{ getBackendLogo(getSetting('app_logo')) }}" class="logo-dark-mode" alt=""> --}}
        </a>

        <div class="my-auto ml-auto">
            <a href="{{ route('login') }}" class="btn btn-primary btn-pills mx-3">Login</a>
        </div>


        <button class="btn text-dark openmenu" type="button" id="animatedButton">
            {{-- <svg width="32" height="32" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill="currentColor" fill-rule="evenodd" d="M2 4.75A.75.75 0 0 1 2.75 4h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 4.75m7 10.5a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5a.75.75 0 0 1-.75-.75M2 10a.75.75 0 0 1 .75-.75h14.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 10" clip-rule="evenodd"/>
                </svg> --}}

            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </button>

        <div class="item-menu rdgfjkcm" data-btn-parent="openmenu">

            <div class="row">
                {{-- <div class="col-12 d-flex justify-content-between mb-3">
                        <img src="{{ getBackendLogo(getSetting('app_white_logo')) }}" class="logo-light-mode" alt="Logo full" style="width: max-content ">
                        <button class="btn openmenu" data-ash-dismiss="openmenu" type="button">
                            <svg width="32" height="32" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m11.25 4.75l-6.5 6.5m0-6.5l6.5 6.5"/>
                            </svg>
                        </button>
                    </div> --}}
                @if (request()->routeIs('plan.checkout.store') == false)
                    <div class="col-12">
                        <a href="#why-121"
                            class="btn btn-link text-primary openmenu d-flex justify-content-between align-items-center ">
                            Why 121 ?
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </div>

                    <div class="col-12">
                        <a href="#benefits"
                            class="btn btn-link text-primary openmenu d-flex justify-content-between align-items-center ">
                            Benefits
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </div>

                    <div class="col-12">
                        <a href="#faq"
                            class="btn btn-link text-primary openmenu d-flex justify-content-between align-items-center ">
                            FAQs
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </div>

                    <div class="col-12">
                        <a href="{{ route('about') }}"
                            class="btn btn-link text-primary openmenu d-flex justify-content-between align-items-center ">
                            About
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('contact.index') }}"
                            class="btn btn-link text-primary openmenu d-flex justify-content-between align-items-center ">
                            Contact
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </div>

                    <div class="col-12 d-flex justify-content-center align-items-center "
                        style="position: absolute;bottom: 90px;">
                        <a href="{{ route('login') }}" class="btn btn-primary  btn-pills">Login</a>
                    </div>
                @endif
            </div>




        </div>

    </div>


</header>
