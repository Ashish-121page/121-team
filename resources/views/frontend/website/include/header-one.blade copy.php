<style>
    @media only screen and (max-width: 770px) {
        .eiodyh{
            display: block !important;
        }
    }
</style>
<style>
    /* Add custom class for reducing padding on xs screens */
    @media (max-width: 575.98px) {
        .sub-menu-item {
            padding: 6px 10px !important;

        }

        #khkop{
            margin-left: 0px !important;
            margin-top: 0% !important;

        }
    }

</style>

<header id="topnav" class="defaultscroll sticky">
    <div class="container">
      <!-- Logo container-->
      <a class="logo  list-inline-item mb-0 mt-2" href="{{ url('/now') }}">
          <img src="{{ getBackendLogo(getSetting('app_white_logo'))}}" class="logo-light-mode" alt="">
          <img src="{{ getBackendLogo(getSetting('app_logo'))}}" class="logo-dark-mode" alt="">
      </a>
      <!-- End Logo container-->
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
                                            <input type="text" id="help" name="name" class="border bg-white rounded-pill" required="" placeholder="Search">
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
            @auth
                <li class="list-inline-item mb-0">
                    <div class="dropdown dropdown-primary">
                        <button type="button" class="btn btn-icon btn-pills btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{-- @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/backend/users/' . auth()->user()->avatar) }}" style="border-radius: 25px; background: white;" alt="">
                            @else --}}
                                <i data-feather="user" class="icons"></i>
                            {{-- @endif --}}
                        </button>
                        <div class="dropdown-menu dd-menu dropdown-menu-end bg-white shadow rounded border-0 mt-3 py-2" style="width: 200px;">
                            <a class="dropdown-item text-dark" href="@if(AuthRole() == 'Admin') {{ route('panel.dashboard') }}  @else {{ route('customer.dashboard') }} @endif"><i class="uil uil-user align-middle me-1"></i> Dashboard</a>
                            @if(auth()->user() && session()->has("admin_user_id") && session()->has("temp_user_id"))
                                <a class="dropdown-item text-dark" href="{{ route("panel.auth.logout-as") }}"><i class="uil uil-sign-in-alt align-middle me-1"></i>Re-Login as {{ NameById(session()->get("admin_user_id")) }}</a>
                            @endif
                            <div class="dropdown-divider my-3 border-top"></div>
                            <a class="dropdown-item text-dark" href="{{ url('logout') }}"><i class="uil uil-sign-out-alt align-middle me-1"></i> Logout</a>
                        </div>
                    </div>
                </li>
            @else
                <li class="list-inline-item mb-0 mt-2">
                </li>
                {{-- <li class="list-inline-item mb-0"><a href="{{ url('register') }}" class="btn btn-outline-primary">Signup</a></li> --}}
            @endif
        </ul><!--end login button-->
        <div class="col-lg-12 njuy d-none d-lg-block" id="navigation" style="display:block!important; margin-left: 0px !important;">
            <div class="row">
                <!-- Navigation Menu-->
                @if(request()->routeIs('plan.checkout.store')  == false )
                    <ul class="navigation-menu d-flex flex-wrap justify-content-center text-center" style="margin-left: 0px !important;">
                        <li><a href="#why121" onclick="scrollToSection('#why121')">
                        Why</a></li>
                        {{-- <li><a href="{{ url('/now') }}" class="sub-menu-item" style=" margin-left: 2px;">Home</a></li>                                          --}}
                        <li><a href="#benefit" onclick="scrollToSection('#benefit')">Benefits</a></li>
                        <li>
                            <a href="#Faq" onclick="scrollToSection('#Faq')">FAQ</a>
                        </li>
                        <li>
                            <button type="submit" class="btn btn-pills btn-primary sub-menu-item" id="khkop" style="margin-top:15px; margin-left: 10rem;">
                                <a href="{{ url('auth/login') }}" class="" style="color: white;">Get Started</a>
                            </button>
                        </li>
                    </ul><!--end navigation menu-->
                @endif
            </div>
        </div><!--end navigation-->

            {{-- for mobile screen --}}

        {{-- <div class="col-12 d-lg-none d-block" id="navigation" style="display:flex!important; margin-left: 0px !important;">
            <div class="row">

                @if(request()->routeIs('plan.checkout.store')  == false )
                    <ul class="navigation-menu d-flex flex-wrap justify-content-center text-center">
                        <li><a href="{{ url('/now') }}" class="sub-menu-item">Home</a></li>

                        <li><a href="{{ route('about-one') }}" class="sub-menu-item">About</a></li>

                        <li>
                            <a href="{{ route('contact.index-one') }}" class="sub-menu-item">Contact</a>
                        </li>

                        <li>
                            <button type="submit" class="btn btn-pills btn-primary sub-menu-item" style="margin-top:15px;">
                                <a href="{{ url('auth/login') }}" class="" style="color: white;">Get Started</a>
                            </button>
                        </li>
                    </ul>
                @endif
            </div>
        </div> --}}
    </div>
  <!--end container-->
</header>
