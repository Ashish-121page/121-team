<style>
    @media only screen and (max-width: 770px) {
        .eiodyh{
            display: block !important;
        }

    }
</style>
<header id="topnav" class="defaultscroll sticky">
    <div class="container">
      <!-- Logo container-->
      <a class="logo  list-inline-item mb-0 mt-2" href="{{ url('/') }}">
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
                    <a href="{{ url('auth/login') }}" class="btn btn-outline-primary eiodyh"> Login / Sign up </a>
                    {{-- <form class="d-sm-none d-md-block d-none" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-4 col-sm-4">
                                <input type="text" class="form-control" name="email" placeholder="Email Address/Mobile">
                            </div>
                            <div class="col-12 col-md-4 col-sm-4">
                                <input type="password" class="form-control" name="password" placeholder="Enter Password">
                            </div>
                            <div class="col-12 col-md-4 col-sm-4">
                                <button class="btn btn-outline-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </form> --}}
                </li>
                {{-- <li class="list-inline-item mb-0"><a href="{{ url('register') }}" class="btn btn-outline-primary">Signup</a></li> --}}
            @endif
        </ul><!--end login button-->
        <div id="navigation" style="display:block!important;margin-left: 0px !important;">
          <!-- Navigation Menu-->   
          @if(request()->routeIs('plan.checkout.store')  == false )
              <ul class="navigation-menu">
                  <li><a href="{{ url('/') }}" class="sub-menu-item">Product Tool</a></li>
                  {{-- <li><a href="{{ route('home.search') }}" class="sub-menu-item">Search</a></li> --}}
                  <li><a href="{{ route('about') }}" class="sub-menu-item">About</a></li>
                  {{-- <li><a href="{{ route('plan.index') }}" class="sub-menu-item">Plan</a></li> --}}
                  {{-- <li><a href="{{ route('blog.index') }}" class="sub-menu-item">Blog</a></li> --}}
                  <li>
                      <a href="{{ route('contact.index') }}" class="sub-menu-item">Contact</a>
                  </li>
              </ul><!--end navigation menu-->
            @endif
        </div><!--end navigation-->
    </div>
  <!--end container-->
</header>