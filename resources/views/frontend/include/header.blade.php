<header class="header default border-bottom">
  <div class="header-section">
      <div class="container ">
          <nav class="navbar navbar-expand-lg header-navbar ">
              <a class=" navbar-brand navbar-logo scroll">
           <img class="mb-0 header-logo" src="{{  getFrontendLogo(getSetting('frontend_logo'))}}"  alt="" style=" height: 35px;">
           </a>
              <button class="navbar-toggler btn-navbar-toggler" type="button" data-toggle="collapse" data-target=".nav-menu" aria-expanded="true" aria-label="Toggle navigation"> <span class="fa fa-bars"></span>
           </button>
              <div class="nav-menu collapse navbar-collapse navbar-collapse justify-content-end py-0 ">
                  <ul class=" navbar-nav  header-navbar-nav">
                      <li><a class="nav-link scroll" href="{{ url('/') }}">Home</a>
                      </li>
                      <li><a class="nav-link scroll" href="#about">About</a>
                      </li>
                      <li><a class="nav-link scroll" href="#changeyourlife">Consulting</a>
                      </li>
                      <li><a class="nav-link scroll" href="#packages">Packages</a>
                      </li>
                      <li><a class="nav-link scroll" href="#faq">Faq</a>
                      </li>
                      <li class="mb-3 mb-lg-0"><a class="nav-link scroll" href="#contact">Contact</a>
                      </li>
                      @if(auth()->check())
                        <div class="dropdown">
                          <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ auth()->user()->name }}
                          </button>
                          <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                              <li class="dropdown-item"><a href="{{ route('panel.dashboard') }}">Dashboard</a></li>
                              <li class="dropdown-item"><a href="{{ url('/logout') }}">logout</a></li>
                            </ul>
                        </div>
                      @else
                        <li><a class="nav-link scroll" href="{{url('login')}}">Login</a>
                        </li>
                      @endif
                  </ul>
              </div>
          </nav>
      </div>
  </div>
</header>