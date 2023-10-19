@php
    $cart = getCartData(UserShopIdBySlug($slug), auth()->id());
    $categories = getProductCategoryByShop($slug,0);

    $user_shop = App\Models\UserShop::where('slug',$slug)->first();
    $user_id = UserShopUserIdBySlug($slug);
    $user = App\User::where('id',$user_id)->first();
    $have_access_code = App\Models\AccessCode::where('redeemed_user_id',$user_id)->first();
@endphp
<header id="topnav" class="defaultscroll" style="position: inherit">
    <div class="container">
      <!-- Logo container-->
      <a class="logo" href="{{ route('pages.index') }}">
          <img src="{{ asset(getShopLogo($slug))}}" style="height: 50px;
          object-fit: contain;margin-top: 10px;" class="logo-light-mode" alt="">
          <img src="{{ asset(getShopLogo($slug))}}" style="height: 50px;
          object-fit: contain;margin-top: 10px;" class="logo-dark-mode" alt="">
      </a>
      <!-- End Logo container-->

        <ul class="buy-button list-inline mb-0">


            @if($have_access_code)
                <li class="list-inline-item mb-0">
                <div class="dropdown d-none">
                    <button type="button" class="btn btn-icon btn-pills btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @if(getCartCount(auth()->id(),$user_shop->id) > 0)
                        <span class="cart-count">{{ getCartCount(auth()->id(),$user_shop->id) }}</span>
                        @endif
                        <i data-feather="shopping-cart" class="icons"></i>
                    </button>

                        <div class="dropdown-menu dd-menu dropdown-menu-end bg-white shadow rounded border-0 mt-3 p-2" style="width: 300px;box-shadow: 0 0.5rem 1rem rgb(0 0 0 / 15%) !important;">
                            @if($cart->count() > 0)
                                @foreach ($cart as $item)
                                @php
                                    $product = App\Models\Product::where('id',$item->product_id)->first();
                                @endphp
                                    <div class="pb-2">
                                        <a href="javascript:void(0)" class="d-flex align-items-center">
                                            @if(isset(getShopProductImage($item->product_id)->path))
                                                <img src="{{ asset(getShopProductImage($item->product_id)->path ?? '') }}" class="shadow rounded" style="max-height: 50px;width:60px;" alt="cart-image">
                                            @else
                                                <img src="{{asset('frontend/assets/img/placeholder.png')}}"  class="shadow rounded" style="max-height: 50px;width:60px;" alt="">
                                            @endif
                                                <div class="flex-1 text-start ms-3">
                                                    <div class="text-dark mb-0"><strong>{{ Str::limit(getProductDataById($item->product_id)->title ?? '',20) }}</strong></div>
                                                    <small class="text-muted d-block">{{$product->color ?? ''}}-{{$product->size ?? ''}}</small>
                                                    <small class="text-muted mb-0">{{ ($item->price) }} X {{ $item->qty }} : {{ format_price($item->total) }}</small>
                                                </div>
                                        </a>
                                    </div>
                                @endforeach

                                <div class="d-flex align-items-center justify-content-between pt-4 border-top">
                                    <h6 class="text-dark mb-0">Total(₹):</h6>
                                    <h6 class="text-dark mb-0">{{ format_price($cart->sum('total') ?? '0') }}</h6>
                                </div>
                                <div class="mt-3 text-center">
                                    <a href="{{ route('pages.shop-cart') }}" class="btn btn-primary d-block">View Cart</a>
                                    {{-- <a href="{{ route('pages.shop-cart') }}" class="btn btn-primary">Checkout</a> --}}
                                </div>
                                <p class="text-muted text-center mt-3 mb-0">*T&C Apply</p>
                            @else
                                <p class="p-5 text-center">
                                    No Item in  Cart
                                </p>
                            @endif
                        </div>
                </div>
                </li>
                <li class="list-inline-item mb-0">
                 {{-- <a href="javascript:void(0)" class="btn btn-icon btn-pills btn-primary" data-bs-toggle="modal" data-bs-target="#wishlist"><i data-feather="heart" class="icons"></i></a> --}}
                </li>
            @endif
            <li class="list-inline-item mb-0">
                <div class="dropdown dropdown-primary">
                    <button type="button" class="btn btn-icon btn-pills btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i data-feather="user" class="icons"></i>
                    </button>
                    <div class="dropdown-menu dd-menu dropdown-menu-end bg-white shadow rounded border-0 mt-3 py-3" style="width: 200px;">
                        @if(\Auth::check())
                            <a class="dropdown-item text-dark" href="@if(AuthRole() == 'Admin') {{ route('panel.dashboard') }}  @else {{ route('customer.dashboard') }} @endif">
                                <i class="uil uil-dashboard align-middle me-1"></i>
                                Dashboard</a>

                            @if(auth()->user() && session()->has("admin_user_id") && session()->has("temp_user_id"))
                                <a class="dropdown-item text-dark" href="{{ route("panel.auth.logout-as") }}"><i class="uil uil-sign-in-alt align-middle me-1"></i>Re-Login as {{ NameById(session()->get("admin_user_id")) }}</a>
                            @endif
                            <div class="dropdown-divider my-3 border-top"></div>
                            @if (auth()->id() == 155 || auth()->user()->name == "GuestUser")
                                <a class="dropdown-item text-dark" href="{{ url('logout') }}"><i class="uil uil-sign-out-alt align-middle me-1"></i> Sign Up</a>
                            @else
                                <a class="dropdown-item text-dark" href="{{ url('logout') }}"><i class="uil uil-sign-out-alt align-middle me-1"></i> Logout</a>
                            @endif

                        @else
                        <a class="dropdown-item text-dark" href="{{ route('auth.login-index') }}"><i class="uil uil-sign-out-alt align-middle me-1"></i> Login</a>
                        @endif
                    </div>
                </div>
            </li>
        </ul><!--end login button-->
        <div id="navigation" style="display:block;">
          <!-- Navigation Menu-->
          <ul class="navigation-menu">
              <li><a href="{{ inject_subdomain('home', $user_shop->slug)}}" class="sub-menu-item">E-Card</a></li>

                @if(checkShopView($user_shop->slug) && $user->is_supplier == 1 && $user_shop->user_id != auth()->id())
                    <li class="has-submenu parent-menu-item">
                        <a href="{{ inject_subdomain('shop', $user_shop->slug)}}">Display</a><span class="menu-arroww"></span>
                    </li>
                @endif

                @if($user_shop->user_id == auth()->id())
                    <li class="has-submenu parent-menu-item">
                        <a href="{{ inject_subdomain('shop', $user_shop->slug)}}">Display</a><span class="menu-arroww"></span>
                    </li>
                @endif


                {{-- <li><a href="{{ inject_subdomain('about-us', $user_shop->slug)}}" class="sub-menu-item">About</a></li> --}}
                {{-- <li>
                    <a href="{{ inject_subdomain('contact', $user_shop->slug)}}">Contact</a>
                </li> --}}
          </ul><!--end navigation menu-->
        </div><!--end navigation-->
    </div>
  <!--end container-->
</header>
