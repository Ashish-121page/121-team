@extends('frontend.layouts.main')

@section('meta_data')
@php
		$meta_title = 'Dashboard | '.getSetting('app_name');
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');
		$meta_abstract = '' ?? getSetting('site_motto');
		$meta_author_name = '' ?? 'GRPL';
		$meta_author_email = '' ?? 'Hello@121.page';
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');
		$meta_img = ' ';
        $customer = 1;

        $ekyc = json_decode($user->ekyc_info);
        $acc_permissions = json_decode($user->account_permission);
        $acc_permissions->mysupplier = $acc_permissions->mysupplier ?? 'no';
        $acc_permissions->offers = $acc_permissions->offers ?? 'no';
        $acc_permissions->addandedit  = $acc_permissions->addandedit  ?? 'no';
        $acc_permissions->manangebrands  = $acc_permissions->manangebrands  ?? 'no';
        $acc_permissions->pricegroup  = $acc_permissions->pricegroup  ?? 'no';
        $acc_permissions->managegroup  = $acc_permissions->managegroup  ?? 'no';
        $acc_permissions->bulkupload  = $acc_permissions->bulkupload  ?? 'no';
        $acc_permissions->Filemanager = $acc_permissions->Filemanager  ?? 'no';
        $user_key = encrypt(auth()->id());
        $slug = App\Models\Usershop::where('user_id',auth()->user()->id)->first()->slug;
        $teamDetails = App\Models\Team::where('contact_number',session()->get('phone'))->first();

        // magicstring($teamDetails);

        // return;
        // Setting Up Permissions for Team USer

        if ($teamDetails != null) {
            $permissions = json_decode($teamDetails->permission);
            if ($permissions) {
                $Team_mycustomer = in_array("my-customer",$permissions);
                $Team_mysupplier = in_array("my-suppler",$permissions);
                $Team_offerme = in_array("offer-me",$permissions);
                $Team_offerto = in_array("offer-other",$permissions);
                $Team_profile = in_array("profile",$permissions);
                $Team_proadd = in_array("proadd",$permissions);
                $Team_setting = in_array("setting",$permissions);
                $Team_dashboard = in_array("dashboard",$permissions);
                $Team_brand = in_array("brand",$permissions);
                $Team_pricegroup = in_array("pricegroup",$permissions);
                $Team_categorygroup = in_array("categorygroup",$permissions);
                $Team_bulkupload = in_array("bulkupload",$permissions);
            }else{
                    // Default Access to Original Supplier
                    $Team_mycustomer = true;
                    $Team_mysupplier = true;
                    $Team_offerme = true;
                    $Team_offerto = true;
                    $Team_profile = true;
                    $Team_proadd = true;
                    $Team_setting = true;
                    $Team_dashboard = true;
                    $Team_brand = true;
                    $Team_pricegroup = true;
                    $Team_categorygroup = true;
                    $Team_bulkupload = true;
            }
        }
        else{

            // Default Access to Original Supplier
            $Team_mycustomer = true;
            $Team_mysupplier = true;
            $Team_offerme = true;
            $Team_offerto = true;
            $Team_profile = true;
            $Team_proadd = true;
            $Team_setting = true;
            $Team_dashboard = true;
            $Team_brand = true;
            $Team_pricegroup = true;
            $Team_categorygroup = true;
            $Team_bulkupload = true;

        }



        @endphp
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">

<link href="{{ asset('frontend/assets/css/simplebar.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">

<style>

    .select2.select2-container{
        width: 100% !important;
    }
    .select2-container .select2-search--inline .select2-search__field {
        padding: 4px;
    }
    .check-icon{
        height: 25px;
        width: 25px;
        display: flex;
        border-radius: 50%;
        border: 1px solid #6666CC;
        text-align: center;
        align-items: center;
        justify-content: center;
        color: #6666CC;
        margin-left: 19px;
    }

    #industry_id + .select2 .selection{
        pointer-events: none;
    }
    #phone{
        pointer-events: none;
    }
    .alert-danger {
        color: #842029 !important;
        background-color: #f8d7da !important;
        border-color: #f5c2c7 !important;
    }
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #dee2e6;
        height: fit-content !important;
        overflow-y: auto;
    }
    .select2-container .select2-selection--single {
        height: 42px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 26px;
        position: absolute;
        top: 7px;
        right: 1px;
        width: 20px;
    }

    .cross-icon{
        position: absolute;
        left: 15px;
        border-radius: 37px;
        top: 93px;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        display: none !important;
    }
    .digit-group input{
        text-align: center;
    }

    #bro{
        transition: 0.3s all
    }

    #bro:hover{
        background-color: #fff;
    }

</style>


    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-4 toggle-area">
                    <div class="sticky-bar bg-white rounded shadow mb-0 pt-4">
                        <div class="mx-auto justify-content-center text-center pt-2">
                           <div style="height: 90px">
                                @if($user->avatar != null)
                                    <img src="{{$user->avatar}}" class="avatar avatar-md-md rounded-circle" alt="" style="object-fit: cover;">
                                @else
                                    <img src="{{ asset('backend/default/default-avatar.png') }}" class="avatar avatar-md-md rounded-circle" alt="" style="object-fit: cover;">
                                @endif
                                <a  class="camera-icon" id="upload-Images">
                                    <i class="uil uil-camera text-white"></i>
                                </a>
                           </div>

                            <div class="my-1">
                                <h5 class="mb-0">
                                @if (session()->get('phone') == $user->phone )
                                        {{ $user->name  }}
                                @else
                                    @if ( $teamDetails != null)
                                        {{ $teamDetails->name }} / {{ $user->name  }}
                                    @else
                                        {{ $user->name  }}
                                    @endif
                                @endif

                                    @if($user->ekyc_status == 1)
                                    <i title="eKyc Verified" class="fa fa-check-circle fa-sm text-primary"></i>
                                    @endif
                                </h5>
                                {{-- <span class="text-muted text-center">
                                    Customer
                                </span> --}}
                                <div class="progress-box mt-5 mb-3 px-3">
                                    @php
                                        $pos = 'right';
                                        if(getUserProgressStatistics(auth()->id()) < 30){
                                            $pos = 'left';
                                        }
                                    @endphp
                                    <div class="progress">
                                        <div class="progress-bar position-relative bg-primary "
                                        style="position: relative; width:{{ getUserProgressStatistics(auth()->id()) }}%;">
                                            <div class="progress-value d-block text-muted h6" style="{{ $pos == 'left' ? 'left: 100%' : '' }}">
                                            <span>Progress</span> <strong>({{getUserProgressStatistics(auth()->id())}}%)</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav nav-pills nav-justified flex-column" id="pills-tab" role="tablist">
                            @if ($Team_dashboard)
                                <li class="nav-item">
                                    <a data-active="dashboard" class="nav-link active-swicher rounded @if(request()->has('active') && request()->get('active') == "dashboard") active @endif" id="dashboard" data-bs-toggle="pill" href="#dash" role="tab" aria-controls="dash" aria-selected="false">
                                        <div class="text-start py-1 px-3">
                                            <h6 class="mb-0"><i class="uil uil-dashboard h5 align-middle me-2 mb-0"></i> Dashboard</h6>
                                        </div>
                                    </a><!--end nav link-->
                                </li><!--end nav item-->
                            @endif
                            {{-- @if(auth()->user() && session()->has("admin_user_id") && session()->has("temp_user_id")) --}}

                                @if ($acc_permissions->mycustomer == 'yes' && $acc_permissions->mysupplier == 'yes')
                                    @if ($Team_mycustomer && $Team_mysupplier)
                                        <li class="nav-item mt-2 "  >
                                            <a data-active="my-collections" class="nav-link active-swicher rounded @if(request()->has('active') && request()->get('active') == "my-collections") active @endif" id="collections" data-bs-toggle="pill" href="#my-collections" role="tab" aria-controls="my-collections" aria-selected="false">
                                                <div class="text-start py-1 px-3">
                                                    <h6 class="mb-0"><i class="uil uil-bars h5 align-middle me-2 mb-0"></i> My Collections</h6>
                                                </div>
                                            </a><!--end nav link-->
                                        </li>
                                    @endif
                                @endif

                                @if ($acc_permissions->offers == 'yes')
                                    @if ($Team_offerme || $Team_offerto)
                                        <li class="nav-item mt-2 "  >
                                            <a data-active="my-offers-sent" class="nav-link active-swicher rounded  @if(request()->has('active') && request()->get('active') == "my-offers-sent") active @endif" id="my-offers-sent" data-bs-toggle="pill" href="#my-my-offers-sent" role="tab" aria-controls="my-my-offers-sent" aria-selected="false">
                                                <div class="text-start py-1 px-3">
                                                    <h6 class="mb-0"><i class="uil uil-tag-alt h5 align-middle me-2 mb-0"></i> Offers </h6>
                                                </div>
                                            </a><!--end nav link-->
                                        </li>
                                    @endif
                                @endif

                                @if ($acc_permissions->mycustomer == 'yes' && $acc_permissions->mysupplier == 'no')
                                    @if ($Team_mycustomer && !$Team_mysupplier)
                                        <li class="nav-item mt-2" >
                                            <a class="nav-link active-swicher rounded @if(request()->has('active') && request()->get('my_customer') == "4") active @endif " id="collections" href="{{ route('customer.dashboard')."?active=my-customers&my_customer=4"}}">
                                                <div class="text-start py-1 px-3">
                                                    <h6 class="mb-0"><i class="uil uil-bars h5 align-middle me-2 mb-0"></i> My Collections</h6>
                                                </div>
                                            </a><!--end nav link-->
                                        </li>
                                    @endif
                                @endif

                                @if ($acc_permissions->mycustomer == 'no' && $acc_permissions->mysupplier == 'yes')
                                    @if (!$Team_mycustomer && $Team_mysupplier)
                                        <li class="nav-item mt-2" >
                                            <a class="nav-link active-swicher rounded @if(request()->has('active') && request()->get('active') == "my-collections") active @endif" id="collections" href="{{ route('customer.dashboard')."?active=my-collections"}}">
                                                <div class="text-start py-1 px-3">
                                                    <h6 class="mb-0"><i class="uil uil-bars h5 align-middle me-2 mb-0"></i> My Collections</h6>
                                                </div>
                                            </a><!--end nav link-->
                                        </li>
                                    @endif
                                @endif
                            {{-- @endif --}}




                            {{-- <li class="nav-item mt-2">
                                <a data-active="enquiry" class="nav-link active-swicher rounded @if(request()->has('active') && request()->get('active') == "enquiry") active @endif" id="enquiry-history" data-bs-toggle="pill" href="#enquirys" role="tab" aria-controls="enquirys" aria-selected="false">
                                    <div class="text-start py-1 px-3">
                                        <h6 class="mb-0"><i class="uil uil-hipchat h5 align-middle me-2 mb-0"></i> My Enquiry</h6>
                                    </div>
                                </a>
                                <!--end nav link-->
                            </li> --}}

                            {{-- <li class="nav-item mt-2">
                                <a data-active="order" class="nav-link active-swicher rounded @if(request()->has('active') && request()->get('active') == "order") active @endif" id="order-history" data-bs-toggle="pill" href="#orders" role="tab" aria-controls="orders" aria-selected="false">
                                    <div class="text-start py-1 px-3">
                                        <h6 class="mb-0"><i class="uil uil-shopping-cart h5 align-middle me-2 mb-0"></i>  My Orders</h6>
                                    </div>
                                </a><!--end nav link-->
                            </li><!--end nav item--> --}}

                            {{-- @if(auth()->user() && session()->has("admin_user_id") && session()->has("temp_user_id")) --}}

                            {{-- @if ($acc_permissions->addandedit == 'yes' || $acc_permissions->addandedit == 'Yes')
                                @if ($Team_proadd)
                                    <li class="nav-item mt-2">
                                        <a data-active="diaplay" class="nav-link active-swicher rounded" id="diaplay-details" href="{{ route('panel.user_shop_items.create') }}?type=direct&type_id={{ $user->id }}" >
                                            <div class="text-start py-1 px-3">
                                                <h6 class="mb-0"><i class="uil uil-sitemap h5 align-middle me-2 mb-0"></i>  Display </h6>
                                            </div>
                                        </a><!--end nav link-->
                                    </li><!--end nav item-->
                                @endif
                            @endif --}}
                            {{-- @endif --}}

                            @if ($Team_profile)

                                {{-- <li class="nav-item mt-2">
                                    <a data-active="account" class="nav-link active-swicher rounded @if(request()->has('active') && request()->get('active') == "account") active @endif" id="account-details" data-bs-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="false">
                                        <div class="text-start py-1 px-3">
                                            <h6 class="mb-0"><i class="uil uil-user h5 align-middle me-2 mb-0"></i>  My Profile</h6>
                                        </div>
                                    </a>
                                </li> --}}

                            @endif

                            {{-- @if(auth()->user() && session()->has("admin_user_id") && session()->has("temp_user_id")) --}}

                            @if($acc_permissions->Filemanager == "yes")
                                @if ($Team_setting)
                                    <li class="nav-item mt-2">
                                        <a data-active="settings" class="nav-link active-swicher rounded @if(request()->has('active') && request()->get('active') == "settings") active @endif" id="account-details" data-bs-toggle="pill" href="#settings" role="tab" aria-controls="settings" aria-selected="false">
                                            <div class="text-start py-1 px-3">
                                                <h6 class="mb-0"><i class="uil uil-key-skeleton-alt h5 align-middle me-2 mb-0"></i>  Settings</h6>
                                            </div>
                                        </a><!--end nav link-->
                                    </li><!--end nav item-->
                                @endif
                            @endif

                            {{-- @endif --}}

                            <li class="nav-item mt-2">
                                <a href="https://forms.gle/JKe6p6bic7gjnuJq5" target="_blank" class="nav-link active-swicher rounded">
                                    <div class="text-start py-1 px-3">
                                        <h6 class="mb-0">
                                            <i class="uil uil-envelope h5 align-middle me-2 mb-0"></i>
                                             Support Ticket</h6>
                                    </div>
                                </a><!--end nav link-->
                            </li><!--end nav item-->

                        </ul><!--end nav pills-->
                        <div class="">
                            {{-- @if (!App\Models\AccessCode::where('redeemed_user_id',auth()->id())->first()) --}}
                                {{-- <div class="card ">
                                   <div class="card-body">
                                        <h4 class="text-left">Become 121 Seller!</h4>
                                        <span class="text-muted text-left">Unlock the power of distributed selling</span>
                                        <a type="botton" href="javascript:void(0)" class="accees-code btn mt-2 btn-primary d-block">Have Access Code</a>
                                        <hr>
                                        <div class="text-center">
                                            <a href="{{ route('website.faq') }}" class=" m-0 p-0 btn btn-link text-dark">What is Access Code?</a>
                                        </div>
                                   </div>
                                </div> --}}
                            {{-- @elseif(auth()->user()->is_supplier == 0)
                                <div class="alert alert-info">
                                    Your Access Code has been submitted, Your profile requires admin approval.
                                </div>
                            @else --}}
                                @if(auth()->user()->is_supplier == 1)
                                    @if (auth()->user()->status == 1)
                                        <a type="submit" href="{{ route('panel.dashboard') }}" class="btn btn-outline-primary d-block">Open Seller Tools </a>
                                    @endif
                                @else
                                    <a href="{{ url('start') }}" class="btn btn-outline-primary d-block" style="color: white;">Book 7 mins Demo</a>
                                @endif
                            {{-- @endif --}}
                        </div>
                    </div>
                </div><!--end col-->
                <div class="col-lg-8 col-md-12 col-12">
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show my-1" role="alert">
                                {{ $error }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="ik ik-x"></i>
                                </button>
                            </div>
                        @endforeach
                    @endif
                    <div class="tab-content" id="pills-tabContent">

                        @if ($Team_dashboard)
                            <div class="tab-pane fade bg-white shadow rounded p-4 @if(request()->has('active') && request()->get('active') == "dashboard") active show @endif" id="dash" role="tabpanel" aria-labelledby="dashboard">

                                <div class="text-center ">
                                    <h5 class="mt-1">Dashboard</h5>
                                </div>
                                @if(getUserProgressStatistics(auth()->id()) != 100)
                                    <div class="row">
                                        <div class="col-12">
                                            {{-- <img src="{{ asset('frontend/assets/img/dashboard_banner.svg') }}" alt="Image" class="img-fluid w-100 rounded"> --}}
                                        </div>
                                    </div>
                                @endif

                                <div class="border-bottom"></div>
                                <div class="row mt-3 ">
                                    <div class="col-lg-6 col-md-6 col-12 mb-lg-0 mb-md-3 mb-3 d-none">
                                    <div class="card">
                                            <div class="card-body" style="height: 212px;">
                                                <i class="fa fa-3x text-muted fa-qrcode"></i>
                                                <h5 class="mt-2">Scan QR to get latest catalogue</h5>
                                                <div class="justify-content-center mx-auto text-center">
                                                    <a href="javascript:void(0)" class="btn mx-auto text-center btn-primary barCodeModal">Scan QR</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Create Sample QR Code --}}
                                    {{-- @php
                                        $productId = encrypt('446');
                                        // $url= route('pages.shop-show',$productId)."=?pg=&scan=1";
                                        $bhai = "shop/".$productId;
                                        $url= inject_subdomain($bhai,$slug,true,true);
                                    @endphp

                                    {!! QrCode::size(300)->generate( $url ) !!} --}}

                                    @if(getUserProgressStatistics(auth()->id()) != 100)

                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="text-center">
                                                        Account Setup
                                                    </h5>
                                                    <ul>
                                                        <li class="mb-1">
                                                            <div>
                                                                <h6 class="d-inline">Email Verified</h6>
                                                                @if($user->email_verified_at != null)
                                                                    <span class="text-success">
                                                                        <i class="fa fa-check" style="float: right;"></i>
                                                                    </span>
                                                                @else
                                                                    <span class="text-danger">
                                                                        <i class="fa fa-hourglass fa-spin" style="float: right;"></i>
                                                                    </span>
                                                                @endif

                                                            </div>
                                                        </li>
                                                        <li class="mb-1">
                                                            <div>
                                                                <h6 class="d-inline">Logo</h6>
                                                                @if($user_shop->logo != null)
                                                                <span class="text-success">
                                                                    <i class="fa fa-check" style="float: right;"></i>
                                                                </span>
                                                                @else
                                                                <span class="text-danger">
                                                                    <i class="fa fa-hourglass fa-spin" style="float: right;"></i>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </li>
                                                        <li class="mb-1">
                                                            <div>
                                                                <h6 class="d-inline">Vcard</h6>
                                                                @if($vcard)
                                                                    <span class="text-success">
                                                                        <i class="fa fa-check" style="float: right;"></i>
                                                                    </span>
                                                                @else
                                                                    <span class="text-danger">
                                                                        <i class="fa fa-hourglass fa-spin" style="float: right;"></i>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </li>
                                                        <li class="mb-1">
                                                            <div>
                                                                <h6 class="d-inline">About me</h6>
                                                                @php
                                                                    $story_decode = json_decode($user_shop->story);
                                                                    // $description = $story->description ?? null;
                                                                @endphp
                                                                @if(isset($story_decode->description) && $story_decode->description != null)
                                                                <span class="text-success">
                                                                    <i class="fa fa-check" style="float: right;"></i>
                                                                </span>
                                                                @else
                                                                <span class="text-danger">
                                                                    <i class="fa fa-hourglass fa-spin" style="float: right;"></i>
                                                                </span>
                                                                @endif
                                                                </div>
                                                        </li>
                                                        <li class="mb-1">
                                                            <div>
                                                                <h6 class="d-inline">Profile Photo</h6>
                                                                @if(!str_contains($user->avatar, 'ui-avatars.com'))
                                                                <span class="text-success">
                                                                    <i class="fa fa-check" style="float: right;"></i>
                                                                </span>
                                                                @else
                                                                <span class="text-danger">
                                                                    <i class="fa fa-hourglass fa-spin" style="float: right;"></i>
                                                                </span>
                                                                @endif
                                                                </div>
                                                        </li>
                                                        <li class="mb-1">
                                                            <div>
                                                                <h6 class="d-inline">Social Media</h6>
                                                                @if($user_shop->social_links != null)
                                                                <span class="text-success">
                                                                    <i class="fa fa-check" style="float: right;"></i>
                                                                </span>
                                                                @else
                                                                <span class="text-danger">
                                                                    <i class="fa fa-hourglass fa-spin" style="float: right;"></i>
                                                                </span>
                                                                @endif
                                                                </div>
                                                        </li>
                                                    </ul>
                                                    <div class="text-center mx-auto justify-content-center">
                                                        <a href="{{ route('customer.dashboard') }}?active=account" class="btn btn-primary mt-2 mx-auto text-center" @if(request()->has('active') && request()->get('active') == "enquiry") active @endif>Finish Profile</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    {{-- <div class="col-lg-6 col-md-6 col-12">
                                        <div class="card">
                                            <div class="card-body"> --}}
                                                {{-- <h5 class="">
                                                    Create Offer
                                                </h5> --}}
                                                {{-- <div class="text-center mx-auto justify-content-center">
                                                    <a href="{{ inject_subdomain('proposal/create', $slug, true, false)}}" class="btn btn-primary mt-2 mx-auto text-center" @if(request()->has('active') && request()->get('active') == "enquiry") active @endif id="makeoffer">Make Offer</a>
                                                    @if(getUserProgressStatistics(auth()->id()) == 100)
                                                        <a href="{{ inject_subdomain('proposal/create', $slug, true, false)}}" class="btn btn-primary mt-2 mx-auto text-center" @if(request()->has('active') && request()->get('active') == "enquiry") active @endif id="makeoffer">Scan QR</a>
                                                    @endif


                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div> --}}

                                    @if(getUserProgressStatistics(auth()->id()) == 100)
                                        <div class="col-12 border border-danger mt-4">
                                            {{-- ! code will goes here... --}}
                                            <div class="row clearfix">
                                                <div class="col-lg-6 col-md-12 mt-3 ">
                                                    <div class="card">
                                                        {{-- <div class="d-flex justify-content-end mt-1 ">
                                                            <select class="form-control w-25 mx-3 mt-1">
                                                                <option selected="">Today</option>
                                                                <option value="1">Last Week</option>
                                                                <option value="2">Last Month</option>
                                                            </select>
                                                        </div> --}}
                                                        <div class="card-header">
                                                            <h4>Feeds</h4>
                                                            {{--<div class="d-flex align-right">
                                                                <select class="form-control w-80 ml-80">
                                                                    <option selected="">Today</option>
                                                                    <option value="1">Last Week</option>
                                                                    <option value="2">Last Month</option>
                                                                </select>
                                                            </div>--}}
                                                            <div class="card-header-right">
                                                                <ul class="list-unstyled card-option">
                                                                    <li><i class="ik ik-chevron-left action-toggle"></i></li>
                                                                    <li><i class="ik ik-minus minimize-card"></i></li>
                                                                    <li><i class="ik ik-x close-card"></i></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="card-body feeds-widget">
                                                            <div class="feed-item">
                                                             <a href="{{ route('panel.constant_management.notification.readall') }}">


                                                                    <div class="feeds-left"></div>
                                                                    <div class="feeds-body float-right title text-primary">
                                                                        <i class="fas fa-rupee-sign text-primary"></i>
                                                                        {{--Rs. samples--}}
                                                                        {{ ($enquiry_amt) }} Samples pending
                                                                    </div>
                                                                </a>
                                                            </div>

                                                            <div class="feed-item">
                                                                <a href="{{route('customer.dashboard')}}?active=my-offers-sent&sortoffer=5">
                                                                    <div class="feeds-left">
                                                                        <div class=" title text-success mt-3 h6">
                                                                            <i class="fas fa-file-alt text-success"></i>
                                                                            {{ count(App\Models\Proposal::where('user_id',auth()->id())->where('view_count',0)->get()) }}<span>  </span>Proposals not used
                                                                        </div>
                                                                    </div>
                                                                </a>

                                                            </div>
                                                            <div class="feed-item" style="background-color: #ff0000;">
                                                                <a href="">
                                                                    <div class="feeds-left ">
                                                                        <div class="h6 title text-danger mt-3 ">
                                                                            <i class="fas fa-bell text-danger"></i><span>      </span>
                                                                            Pending requests
                                                                        </div>

                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="feed-item">
                                                                <a href="{{ route('panel.products.index') }}?action=nonbranded">
                                                                    <div class="feeds-left">
                                                                        <div class="h6 title text-warning mt-3">
                                                                            <i class="fas fa-cart-plus text-warning"></i>
                                                                            {{ $lastupdatediffrence ?? 0 }} days ago, Last Stock Update
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="feed-item">
                                                                <a href="https://forms.gle/JKe6p6bic7gjnuJq5">
                                                                    <div class="feeds-left">
                                                                        <div class="h6 title text-purple mt-3">
                                                                            <i class="fas fa-hands-helping text-purple"></i>
                                                                            Raise Support Ticket
                                                                        </div>

                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- member's performance -->


                                                <div class="col-xl-6 col-md-6 mt-3">
                                                    <div class="card table-card">
                                                        <div class="card-header">
                                                            <h4>{{('Member’s  performance')}}</h4>
                                                            <div class="card-header-right">
                                                                <ul class="list-unstyled card-option">
                                                                    <li><i class="ik ik-chevron-left action-toggle"></i></li>
                                                                    <li><i class="ik ik-minus minimize-card"></i></li>
                                                                    <li><i class="ik ik-x close-card"></i></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="card-block">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover mb-0 without-header">
                                                                    <thead>
                                                                        <tr>
                                                                        <th scope="col">Team Members</th>
                                                                        <th scope="col">Last login</th>
                                                                        </tr>
                                                                    </thead>

                                                                    <tbody>

                                                                        @foreach ($teams as $item)
                                                                            <tr>
                                                                                <td>
                                                                                    <div class="d-inline-block align-middle">
                                                                                        <img src="{{ ($item->image) ? asset($item->image) : asset('frontend/assets/img/placeholder.png') }}" alt="" style="height:60px;width:60px;object-fit:contain;" class="rounded-circle img-40 align-top mr-15">
                                                                                        {{-- <img src="" alt="user image"
                                                                                            class="rounded-circle img-40 align-top mr-15"> --}}
                                                                                        <div class="d-inline-block">
                                                                                            <div class="h6 mb-0">{{ $item->name ?? "--" }}</div>
                                                                                            <div class=" h6 text-muted mb-0">{{ $item->designation ?? "--" }}</div>
                                                                                            {{-- <p cass="text-muted mb-0">{{ $item->city ?? "--" }}</p> --}}
                                                                                        </div>
                                                                                    </div>
                                                                                </td>
                                                                                <td class="text">
                                                                                    <div class="h6 fw-70">{{ $item->updated_at->format('d/m/Y') }}</div>
                                                                                </td>
                                                                            </tr>
                                                                        @endforeach

                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <!-- statistics -->
                                    <div class="col-xl-6 col-md-12 mt-3">
                                        <div class="card table-card-right">
                                            <div class="card-header">
                                                <h4>{{ __('Statistics')}}</h4>
                                                <div class="card-header-right">
                                                    <ul class="list-unstyled card-option">
                                                        <li><i class="ik ik-chevron-left action-toggle"></i></li>
                                                        <li><i class="ik ik-minus minimize-card"></i></li>
                                                        <li><i class="ik ik-x close-card"></i></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-block pb-0 mb-0">
                                                <div class="table-responsive">
                                                    <table class="table  without-header">
                                                        <tbody>
                                                            <tr style="height:12px">
                                                                <td class="d-flex align-items-center mt-4 gap-3 mx-auto">
                                                                    <div class="bg-primary fs-3 mr-2" style="height: 10px;width: 10px; border-radius: 50%;"></div>
                                                                    <div class="h6">{{ format_price($enquiry_amt) }}</div>
                                                                    </li>
                                                                </td>
                                                                <td>
                                                                    <div class="h6 mt-4">Samples issued</div>
                                                                    {{-- <p>Rs. Sample value </p> --}}
                                                                </td>
                                                                <!--td class="text-right">
                                                                    <label class="badge badge-warning">43%</label>
                                                                </td-->
                                                            </tr>
                                                            <tr style="height:12px">
                                                                <td class="d-flex align-items-center mt-3 gap-3">
                                                                    <div class="bg-success fs-3 mr-2 " style="height: 10px;width: 10px; border-radius: 50%;"></div>
                                                                    <div class="h6">{{ $Numbverofoffer ?? 0 }}</div>
                                                                </td>
                                                                <td>
                                                                    <div class="h6 mt-3">No. of Offers</div>
                                                                    {{-- <p>No. of Offers </p> --}}
                                                                </td>
                                                                <!--td class="text-right">
                                                                    <label class="badge badge-success">58%</label>
                                                                </td-->
                                                            </tr>
                                                            <tr style="height:12px">
                                                                <td class="d-flex align-items-center mt-3 gap-3">
                                                                    <div class="bg-warning fs-3 mr-2 " style="height: 10px;width: 10px; border-radius: 50%;"></div>
                                                                    <div class="h6 mt-3">{{ __('--')}}</div>
                                                                </td>
                                                                <td>
                                                                    <div class="h6 mt-3">Visitors on Display</div>
                                                                    {{-- <p>Visitors on Display</p> --}}
                                                                </td>
                                                                <!--td class="text-right">
                                                                    <label class="badge badge-danger">30%</label>
                                                                </td-->
                                                            </tr>
                                                            <tr style="height:12px">
                                                                <td class="d-flex align-items-center mt-3 gap-3 ">
                                                                    <div class="bg-danger fs-3 mr-2" style="height: 10px;width: 10px; border-radius: 50%;"></div>
                                                                    <div class="h6 mt-3">{{ $productcount  }}</div>
                                                                </td>
                                                                <td>
                                                                    <div class="h6 mt-3">Products on Display</div>
                                                                    {{-- <p>Products on Display </p> --}}
                                                                </td>
                                                                <!--td class="text-right">
                                                                    <label class="badge badge-danger">30%</label>
                                                                </td-->
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endif


                                </div>


                                <div class="row d-none">
                                    <div class="h5 mt-1">Supplier Locations</div>
                                    <div class="col mx-2 w-75 d-flex justify-content-center align-items-center">
                                        <div class="owl-carousel owl-theme owl-loaded justify-content-center align-items-center d-flex">
                                            <div class="owl-stage-outer">
                                                <div class="owl-stage">
                                                    @foreach ($verify_customer as $item)
                                                        <div class="owl-item">
                                                            <div class="d-flex justify-content-center align-items-center" style="height: 100px; width: 100px; margin: 0 5px; " >
                                                                <img src="{{ asset($item->logo) }}" alt="logo" class="img-fluid"  onclick="requestCustomer()">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div><!--end teb pane-->
                        @endif

                        <div class="tab-pane fade bg-white shadow rounded p-4 @if(request()->has('active') && request()->get('active') == "order") active show @endif" id="orders" role="tabpanel" aria-labelledby="order-history">
                            <h5 class="mt-1">Orders</h5>
                           <div class="border-bottom"></div>

                             @forelse ($orders as $order)
                             <div class="border-bottom @if($loop->even) bg-light  @endif p-3">
                                <div class="row mt-2">
                                    <div class="col-auto">
                                        <i class="uil uil-envelope h5 align-middle me-2 mb-0"></i>
                                    </div>
                                    <div class="col">
                                        <div>
                                            @if($order->seller_payment_details != null)
                                            <span class="text-{{ paymentStatus($order->payment_status)['color'] }}">{{ paymentStatus($order->payment_status)['name'] }}</span>
                                            @endif
                                            <h6 class="text-dark mb-0">#ODR{{ getPrefixZeros($order->id) }}</h6>
                                            <div style="font-size: 0.88rem;">
                                                <span class="text-muted">Order Status: </span><span class=" text-{{ orderStatus($order->status)['color'] }}">{{ orderStatus($order->status)['name'] }}</span>
                                            </div>
                                            <small class="text-muted mb-0 d-inline"><i class="fa fa-calendar"></i> {{ getFormattedDateTime($order->created_at) }}</small>
                                            @if($order->delivery_date)
                                                    <br>  <small class="text-muted mb-0 d-inline"> <i class="fa fa-truck"></i> {{ getFormattedDateTime($order->delivery_date) }}</small>
                                            @endif <br>


                                            @if ($order->status == 6)
                                                <a href="javascript:void(0);" class="ms-2 appeal btn btn-sm btn-outline-danger py-1 px-3">Appeal</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col d-flex justify-content-end">
                                        <div>
                                            {{ format_price($order->sub_total) }}
                                            @if($order->status == 1)
                                                @php
                                                    $shopdata = getShopDataByShopId($order->type_id);
                                                @endphp
                                                <br>
                                                @if($order->seller_payment_details == null)
                                                    <a href="{{ inject_subdomain("post-checkout?order_id=".$order->id,$shopdata->slug)}}" class="text-primary">View <i class="uil uil-arrow-right"></i></a>
                                                @endif
                                                @if($order->payment_status == 2)
                                                    <a href="{{route('customer.invoice',$order->id)}}" class="text-primary">Invoice <i class="uil uil-arrow-right"></i></a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                             </div>
                            @include('frontend.customer.dashboard.includes.modal.order',['order_id' => $order->id])
                            @empty
                                <div class="text-center mx-auto mt-3">
                                    <h6>No Orders!</h6>
                                </div>
                            @endforelse

                            <div class="mx-auto text-center">
                                {{ $orders->appends(request()->input())->links() }}
                            </div>


                        </div><!--end teb pane-->
                        @if($Team_setting)
                            {{-- Settings Tab --}}
                            <div class="tab-pane fade bg-white shadow rounded p-4 @if(request()->has('active') && request()->get('active') == "settings") active show @endif" id="settings" role="tabpanel" aria-labelledby="order-history">
                                <h5 class="mt-1">Settings</h5>
                                <div class="border-bottom"></div>
                                <div class="card shadow mb-3 border-0" style="width: 100%; overflow-x: auto; flex-wrap: nowrap;">
                                    <ul class="nav custom-pills mb-0 wrapper_pills" id="pills-tab" role="tablist">
                                        {{-- <li class="nav-item" role="presentation">
                                            <button class="btn pills-btn active" id="pills-setting1-tab" data-bs-toggle="pill" data-bs-target="#pills-setting1" type="button" role="tab" aria-controls="pills-setting1" aria-selected="false">Public Access</button>
                                        </li> --}}
                                        <li class="nav-item" role="presentation">
                                            <button class="btn pills-btn active" id="pills-settings4-tab" data-bs-toggle="pill" data-bs-target="#pills-settings4" type="button" role="tab" aria-controls="pills-settings4" aria-selected="false">Currencies</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="btn pills-btn" id="pills-settings3-tab" data-bs-toggle="pill" data-bs-target="#pills-settings3" type="button" role="tab" aria-controls="pills-settings3" aria-selected="false">Team</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="btn pills-btn" id="pills-settings2-tab" data-bs-toggle="pill" data-bs-target="#pills-settings2" type="button" role="tab" aria-controls="pills-settings2" aria-selected="false">Passcodes</button>
                                        </li>
                                      
                                     
                                    </ul>
                                </div>

                                <div class="border-bottom bg-light  p-3" id="bro">
                                    <div class="tab-content" id="pills-tabContent">

                                        {{-- Display & My Customers List --}}

                                        {{-- <div class="tab-pane fade show active" id="pills-setting1" role="tabpanel" aria-labelledby="pills-setting1-tab" tabindex="0">
                                            <div class="card-body">
                                                <h5 class="">Public Access</h5>
                                                <form action="{{ route('customer.update.settings') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="type" value="setting1">
                                                    <input type="hidden" name="user_shop" value="{{ $user_shop->id }}">
                                                    <div class="row mb-3 align-items-end">
                                                        <div class="col-md-6 col-12 mt-3">
                                                            <div class="form-group">
                                                                <label for="slug" class="control-label">{{ __('Page Finder')}}<span class="text-danger">*</span></label>
                                                                <input type="text" placeholder="Page FInder" class="form-control" name="slug" id="slug" value="{{ $slug }}" @if ($slug != $user->phone) readonly @endif>
                                                            </div>
                                                        </div>

                                                        @if ($slug != $user->phone)
                                                            <div class="col-md-6 col-12 mb-1">
                                                                <a href="javascript:void(0)" id="download-qr" class="btn btn-outline-primary">Download QR</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    
                                                    @php
                                                        $teamdata = json_decode($user_shop->team);
                                                        $teamdata->team_visiblity = $teamdata->team_visiblity ?? 0;
                                                        $teamdata->manage_offer_guest = $teamdata->manage_offer_guest ?? 0;
                                                        $teamdata->manage_offer_verified = $teamdata->manage_offer_verified ?? 0;
                                                    @endphp
                                                    
                                                    <div class="row mb-2">
                                                        <div class="col-12 col-md-6 col-sm-12 mt-2">
                                                            <label for="">Public Display</label> <br>
                                                            <input type="checkbox" @if($user_shop->shop_view == 1) checked @endif value="1" name="shop_view" id="js-single" class="js-single"/>
                                                        </div>

                                                        <div class="col-12 col-md-6 col-sm-12 mt-2 d-none2 maneg_offer">
                                                            <label for="">Guest Offer <span><i class="uil-info-circle" title="Can Guest User Make Offer"></i></span></label> <br>
                                                            <input type="checkbox" @if($teamdata->manage_offer_guest == 1) checked @endif value="1" name="shop_view_guest" class="js-two"/>
                                                        </div>

                                                        <div class="col-12 col-md-6 col-sm-12 mt-2 d-none2 maneg_offer">
                                                            <label for="">Verified User Offer <span><i class="uil-info-circle" title="Can Verified 121 User Make Offer"></i></span></label> <br>
                                                            <input type="checkbox" @if($teamdata->manage_offer_verified == 1) checked @endif value="1" name="shop_view_login" class="js-three"/>
                                                        </div>

                                                        <div class="col-12 col-md-6 col-sm-12 mt-2">
                                                            <label for="auto_acr" title="Enable You A Feature That Auto Accepting Catelogue Request">Auto Accept Request</label> <br>
                                                            <input type="checkbox" @if($user_shop->auto_acr == 1) checked @endif value="1" name="auto_acr" id="auto_acr" class="js-acr"/>
                                                        </div>

                                                        <div class="col-12 col-md-6 col-sm-12 mt-2">
                                                            <label for="public_about" title="Enable You A Feature That Auto Accepting Catelogue Request py-2">Public Team</label> <br>
                                                            <input type="checkbox" @if (isset($teamdata) && $teamdata != null && $teamdata->team_visiblity) checked @endif value="1" name="public_about" id="public_about" class="js-about"/>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-success mt-3"> Update </button>
                                                </form>
                                            </div>
                                        </div>  --}}
                                        
                                        {{-- End Div --}}

                                        {{-- Passcodes Only --}}
                                        <div class="tab-pane fade" id="pills-settings2" role="tabpanel" aria-labelledby="pills-settings2-tab" tabindex="0">
                                            <div class="card-body">
                                                <h5 class=""> Passcodes </h5>

                                                @php
                                                    $extra_pass = json_decode($user->extra_passcode) ?? "";
                                                @endphp

                                                <form action="{{ route('customer.update.settings') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="type" value="setting2">
                                                    <input type="hidden" name="user_shop" value="{{ $user_shop->id }}">
                                                    <div class="row mb-3 align-items-end">
                                                        <div class="col-md-6 col-12 mt-3">
                                                            <div class="form-group">
                                                                <label for="exclsive_pass" class="control-label">{{ __('Exclusive Products')}}<span class="text-danger">*</span></label>
                                                                <input type="text" placeholder="Enter Exclusive Passcode" class="form-control" name="exclsive_pass" id="exclsive_pass" value="{{ $user->exclusive_pass }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12 mt-3 d-none">
                                                            <div class="form-group">
                                                                <label for="offers_passcode" class="control-label">{{ __('Default offers passcode')}}<span class="text-danger">*</span></label>
                                                                <input type="text" placeholder="Enter Offers Passcode" class="form-control" name="offers_passcode" id="offers_passcode" value="@if (isset($extra_pass) && $extra_pass!= "" ){{ $extra_pass->offers_passcode ?? '' }}@endif" required>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-md-6 col-12 mt-3">
                                                            <div class="form-group">
                                                                <label for="reseller_pass" class="control-label">{{ __('Reseller Passcode')}}<span class="text-danger">*</span></label>
                                                                <input type="text" placeholder="Enter Reseller Passcode" class="form-control" name="reseller_pass" id="reseller_pass" value="@if (isset($extra_pass) && $extra_pass!= "" ){{ $extra_pass->reseller_pass ?? '' }}@endif" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-12 mt-3">
                                                            <div class="form-group">
                                                                <label for="vip_pass" class="control-label">{{ __('VIP Passcode')}}<span class="text-danger">*</span></label>
                                                                <input type="text" placeholder="Enter VIP Passcode" class="form-control" name="vip_pass" id="vip_pass" value="@if (isset($extra_pass) && $extra_pass!= "" ){{ $extra_pass->vip_pass ?? '' }}@endif"  required>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                    <button type="submit" class="btn btn-outline-primary mt-3"> Update </button>
                                                </form>
                                            </div>
                                        </div>

                                        {{-- Team Only --}}
                                        <div class="tab-pane fade" id="pills-settings3" role="tabpanel" aria-labelledby="pills-settings3-tab" tabindex="0">
                                            <div class="card-body">
                                                {{-- <h6 class="">Team Section</h6> --}}
                                                <form action="{{ route('panel.teams.user-shops.update') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="user_shop_id" id="" value="{{ $user_shop->id }}">
                                                        <div class="row">
                                                            <div class="col-md-12 col-12 d-none">
                                                                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                                                    <label for="title" class="control-label form-label">Title</label>
                                                                    <input class="form-control" placeholder="Enter Title" name="title" required type="text" id="title" value="Team">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-12 mt-3 d-none">
                                                                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                                                    <label for="description" class="control-label form-label">Description</label>
                                                                    <textarea class="form-control" placeholder="Enter Descriptoin" name="description" type="text" id="description"
                                                                        value="">{{ $team['description'] ?? '' }}</textarea>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12 d-none">
                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-primary mt-3">Update</button>

                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12"><hr></div>
                                                            <div class="col-md-12">
                                                                <div class="d-flex justify-content-between my-3">
                                                                    <h6>Team Members</h6>
                                                                    <a href="#" id="addmember" class="mb-2 btn btn-icon btn-sm btn-outline-primary" title="Add New Team Member"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                                </div>
                                                                    @php
                                                                        $items = App\Models\Team::whereUserShopId($user_shop->id)->paginate(4);
                                                                    @endphp
                                                                <div class="row mt-3">
                                                                    @if ($items->count() > 0)
                                                                        @foreach($items as $item)
                                                                            <div class="col-md-6">
                                                                                <div class="card">
                                                                                    <div class="card-body text-center" style="padding: 8px 10px;">
                                                                                        <div class="profile-pic mb-20">
                                                                                            <div class="row">
                                                                                                <div class="col-4 pr-0">
                                                                                                    @if($item->image != null)
                                                                                                        <img src="{{ ($item->image) ? asset($item->image) : asset('frontend/assets/img/placeholder.png') }}" alt="" style="height:60px;width:60px;object-fit:contain;" class="rounded mt-2">
                                                                                                    @endif
                                                                                                </div>

                                                                                                <div class="col-6 pl-5 pt-2 text-left">
                                                                                                    <h6 class="mb-0">{{\Str::limit($item->name, 10) }}
                                                                                                    </h6>

                                                                                                    <span class="mt-2"> {{\Str::limit($item->designation, 10)}}
                                                                                                    </span>
                                                                                                    <p>{{$item->contact_number}}</p>
                                                                                                </div>
                                                                                                <div class="col-2 pl-2">
                                                                                                    <a href="{{ route('panel.teams.destroy', $item->id) }}" class="text-danger delete-item">
                                                                                                        <i class="ui uil-trash-alt"></i>
                                                                                                    </a>
                                                                                                    <a href="{{ route('panel.teams.edit' , $item->id) }}?shop_id={{$user_shop->id}}" class="text-primary editteam">
                                                                                                        <i class="ui uil-pen"></i>
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @else
                                                                    <div class="mx-auto text-center">
                                                                        <span>No records!</span>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                                <div class="card-footer d-flex justify-content-between">
                                                                    <div class="pagination">
                                                                        {{ $items->appends(request()->query())->links() }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </form>
                                            </div>
                                        </div>

                                        {{-- Currencies Only --}}
                                        <div class="tab-pane fade show active" id="pills-settings4" role="tabpanel" aria-labelledby="pills-settings4-tab" tabindex="0">
                                            <div class="card-body">
                                                @include('frontend.customer.dashboard.section.currency-load')
                                            </div>
                                        </div> 


                                    </div>
                                </div>




                            </div><!--end teb pane-->
                        @endif
                        <div class="tab-pane fade bg-white shadow rounded p-4 @if(request()->has('active') && request()->get('active') == "enquiry") active show @endif" id="enquirys" role="tabpanel" aria-labelledby="enquiry-history">
                            <div class="d-flex justify-content-between">
                                <h5 class="mt-1">My Enquiry</h5>
                                <button class="btn btn-icon refresh_btn" title="Refresh"><i class="uil uil-refresh"></i></button>
                            </div>
                           <div class="border-bottom"></div>
                                @if($enquiry->count() > 0)
                                    @foreach($enquiry as $item)
                                        @php
                                            $details = json_decode($item->description);
                                            $user_shop_image = App\Models\UserShopItem::where('product_id',$details->product_id)->where('user_shop_id',$item->micro_site_id)->first();
                                            $supplier_name = NameById($user_shop->user_id);
                                            $description = json_decode($item->description,true);
                                            if(isset($user_shop_image) && $user_shop_image->images){
                                                $image_ids = explode(',',$user_shop_image->images);
                                            }else{
                                                $image_ids = null;
                                            }
                                        @endphp
                                        <div class="border-bottom @if($loop->even) bg-light  @endif p-3">
                                            <div class="row">
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-4">
                                                    @if (isset($image_ids) && $image_ids != null)
                                                        <img src="{{ asset(getMediaByIds($image_ids)->path) }}" alt="" style="height: 50px;
                                                    width: 80px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('frontend/assets/img/placeholder.png') }}" alt="" style="height: 50px;">
                                                    @endif
                                                </div>
                                                <div class="col-xl-8 col-lg-8 col-md-8 col-8">
                                                    <h6 class="text-dark mb-0">{{ getProductDataById($details->product_id)->title ?? '' }}
                                                        <span class="ms-1 text-{{ getEnquiryStatus($item->status)['color'] }}">{{ getEnquiryStatus($item->status)['name'] }}</span>
                                                    </h6>
                                                    <small class="text-muted mb-0 d-inline"><i class="fa p-1 fa-calendar"></i>{{ @getFormattedDateTime(getLastEnquiryConversation($item->id)->created_at) ?? getFormattedDateTime($item->created_at) }}</small>
                                                </div>
                                                <div class="col-xl-2 col-lg-2 col-md-2 col-12 mt-lg-0 mt-md-0 mt-2 d-flex justify-content-end">
                                                    <a class="btn btn-link p-0" href="{{ route('customer.chat.show', $item->id) }}">Click here</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center mx-auto mt-3">
                                        <h6>No Enquiries!</h6>
                                    </div>
                                @endif
                            <div class="mx-auto text-center">
                                {{ $enquiry->appends(request()->input())->links() }}
                            </div>


                        </div><!--end teb pane-->

                        <div class="tab-pane fade bg-white shadow rounded p-4 @if(request()->has('active') && request()->get('active') == "my-collections") active show @endif" id="my-collections" role="tabpanel" aria-labelledby="collections">
                            <div class="card shadow mb-3 border-0" style="width: 100%; overflow-x: auto; flex-wrap: nowrap;">
                                <ul class="nav custom-pills mb-0 wrapper_pills" id="pills-tab" role="tablist">
                                    @if($acc_permissions->mysupplier == 'yes')
                                        @if ($Team_mysupplier)
                                            <li class="nav-item ">
                                                <a href="{{ route('customer.dashboard')."?active=my-collections"}}" class="mr-2 collection_status_tabs btn pills-btn @if(!request()->has('collection_status')  || request()->get('collection_status')  == '') active @endif @if ($acc_permissions->mycustomer == 'no') active @endif" >{{ __('My Supplier')}}</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if($acc_permissions->mycustomer == 'yes')
                                        @if ($Team_mycustomer)
                                            <li class="nav-item">
                                                <a href="{{ route('customer.dashboard')."?active=my-customers&my_customer=4"}}" class="mr-2 collection_status_tabs btn pills-btn @if(request()->get('my_customer')  == '4') active @endif @if ($acc_permissions->mysupplier == 'no') active @endif ">{{ __('My Customer')}}</a>
                                            </li>
                                        @endif
                                    @endif

                                </ul>
                            </div>
                            <div class="d-md-flex d-block justify-content-between mb-2">
                                <h5 class="mt-1 invisible">My Collections</h5>
                            <div>
                                    <a href="javascript:void(0);" class="btn btn-primary btn-md barCodeModal mb-2 d-none" ><i class="uil uil-barcode "></i> Scan QR</a>
                                    <a href="javascript:void(0);" id="requestCatalogue" class="btn btn-md btn-primary mb-2">Request Catalogue</a>
                            </div>
                            </div>

                            <!-- For Search Customer -->
                            <form action="{{url('customer/dashboard')}}">
                                <div class="row">
                                    <div class="col-12">
                                        <input type="text" placeholder="Search By Phone.." class="form-control" name="search" id="searchsup" value="{{$search}}">
                                        <input type="text" name="active" value="my-collections" class="d-none">
                                    </div>
                                    <div class="col d-none invisible">
                                        <button class="btn btn-outline-primary">Submit</button>
                                        <a href="{{ route('customer.dashboard')."?search=&active=my-collections&orders=supplier"}}" class="btn btn-outline-danger">Sort</a>
                                    </div>
                                </div>
                            </form>




                            <div class="border-bottom"></div>

                            @forelse ($collections as $collection_item)
                                @php
                                    $temp_user_data = UserByNumber($collection_item->number);
                                    $temp_shop_data = getShopDataByUserId($temp_user_data->id ?? 0);
                                    $user_number = App\User::wherePhone($collection_item->number)->first();
                                    if($user_number){
                                        $have_access_code = App\Models\AccessCode::where('redeemed_user_id',$user_number->id)->exists();
                                    }
                                @endphp

                                <div class="row ashu"></div>
                                <div class="border-bottom @if($loop->even) bg-light  @endif p-3" id="bro">
                                <div class="row">
                                        <div class="col-md-2 pr-0">
                                            <img src="{{$user_number ? $user_number->avatar : asset('backend/default/default-avatar.png') }}" style="width: 55px;border-radius: 30px;" alt="" srcset="" class="text-center mx-auto">
                                    </div>

                                        <div class="d-flex justify-content-between col-md-10 pl-0 mt-lg-0 mt-md-0 mt-3">
                                            <div class="text-muted mb-0" style="width: 57%;">
                                                <span class="text-muted">
                                                <i class="fa fa-reply"></i>

                                                {{ $collection_item->number ?? ''}} -
                                                <span>
                                                    @if($user_number)
                                                        {{$user_number->name}}
                                                    @else
                                                        {{$collection_item->supplier_name}}
                                                    @endif
                                                    {{-- {{ $temp_user_data->name ?? '########' }} --}}
                                                </span>
                                                / {{$collection_item->supplier_name}}
                                                <div ><small class="text-muted">Request sent on {{ getFormattedDateTime($collection_item->created_at)  }}</small></div>

                                            </div>
                                            <div class="">
                                                @if($temp_shop_data)
                                                {{-- @if($collection_item->status == 4 && $temp_shop_data && checkAccessCodeRedeemed($temp_user_data->id)) --}}

                                                    <a href="{{ inject_subdomain('home', $temp_shop_data->slug, true)}}" target="_blank" class="btn  btn-outline-primary btn-sm">E-card</a>
                                                    @if($user_number->is_supplier == 1 && isset($have_access_code) && $have_access_code)
                                                        <a href="{{ inject_subdomain('shop', $temp_shop_data->slug, true)}}" target="_blank" class="btn btn-outline-primary btn-sm  md-2 shop-btn-mobile">Display</a>
                                                    @endif
                                                @else
                                                    <a href="" class="text-warning"> <i class="fa fa-hourglass fa-spin fa-sm"></i></a>
                                                @endif

                                            </div>
                                        </div>
                                </div>
                                </div>
                            @empty
                                <div class="text-center mx-auto mt-3">
                                    <h6>No Collections!</h6>
                                </div>
                            @endforelse
                            <div class="mx-auto text-center">
                                {{ $collections->appends(request()->input())->links() }}
                            </div>

                        </div><!--end teb pane-->

                        {{-- For My Customer Only --}}
                        <div class="tab-pane fade bg-white shadow rounded p-4 @if(request()->has('active') && request()->get('active') == "my-customers") active show @endif" id="my-customers" role="tabpanel" aria-labelledby="collections">
                            <div class="card shadow mb-3 border-0" style="width: 100%; overflow-x: auto; flex-wrap: nowrap;">
                                <ul class="nav custom-pills mb-0 wrapper_pills" id="pills-tab" role="tablist">
                                    @if($acc_permissions->mysupplier == 'yes')
                                        @if ($Team_mysupplier)
                                            <li class="nav-item ">
                                                <a href="{{ route('customer.dashboard')."?active=my-collections"}}" class="mr-2 collection_status_tabs btn pills-btn @if(!request()->has('collection_status')  || request()->get('collection_status')  == '') active @endif @if ($acc_permissions->mycustomer == 'no') active @endif" >{{ __('My Supplier')}}</a>
                                            </li>
                                        @endif
                                    @endif

                                    @if($acc_permissions->mycustomer == 'yes')
                                        @if ($Team_mycustomer)
                                            <li class="nav-item">
                                                <a href="{{ route('customer.dashboard')."?active=my-customers&my_customer=4"}}" class="mr-2 collection_status_tabs btn pills-btn @if(request()->get('my_customer')  == '4') active @endif @if ($acc_permissions->mysupplier == 'no') active @endif ">{{ __('My Customer')}}</a>
                                            </li>
                                        @endif
                                    @endif

                                    {{-- <li class="nav-item ">
                                        <a href="{{ route('customer.dashboard')."?active=my-collections&collection_status=1"}}" class="mr-2 collection_status_tabs btn pills-btn @if(request()->get('collection_status')  == '1') active @endif" >{{ __('My Supplier')}}</a>
                                    </li> --}}
                                    {{-- <li class="nav-item">
                                        <a href="{{ route('customer.dashboard')."?active=my-collections&collection_status=0"}}" class="mr-2 collection_status_tabs btn pills-btn @if(request()->get('collection_status')  == '0') active @endif" >{{ __('Request Under Approval')}}</a>
                                    </li> --}}
                                    {{-- <li class="nav-item">
                                        <a href="{{ route('customer.dashboard')."?active=my-collections&collection_status=3"}}" class="mr-2 collection_status_tabs btn pills-btn @if(request()->get('collection_status')  == '3') active @endif">{{ __('Ignore')}}</a>
                                    </li> --}}

                                    </li>
                                </ul>
                            </div>

                            <!-- For Search Customer -->
                            <div class="d-md-flex d-block justify-content-between mb-2">
                                <h5 class="mt-1">My Customer</h5>
                            <div>
                                    <a href="javascript:void(0);" class="btn btn-primary btn-md barCodeModal mb-2 d-none" ><i class="uil uil-barcode "></i> Scan QR</a>
                                    <a href="#" class="btn btn-success send-request mt-lg-0 mt-md-0 mt-3">Sent Catalogue</a>
                            </div>
                            </div>
                            <div class="border-bottom"></div>


                            @foreach ($my_resellers as $my_reseller)
                            @php
                                $reseller = App\User::whereId($my_reseller->user_id)->first();
                                $reseller_user_number = App\User::wherePhone($my_reseller->number)->first();
                                if($user){
                                    $reseller_shop = getShopDataByUserId($user->id);
                                }

                                if($my_reseller->status == 0) {
                                        $status = "<font class='text-warning'>Pending</font>";
                                }
                                if($my_reseller->status == 1) {
                                        $status = "<font class='text-success'>Accepted</font>";
                                }
                                if($my_reseller->status == 2) {
                                        $status = "<font class='text-danger'>Rejected</font>";
                                }
                                if($my_reseller->status == 3) {
                                        $status = "<font class='text-dark'>Ignored</font>";
                                }

                            @endphp

                                <div class="border-bottom @if($loop->even) bg-light  @endif p-3">
                                <div class="row">
                                        <div class="col-md-2 pr-0">
                                            <img src="{{ $reseller && $reseller->avatar ? $reseller->avatar : asset('backend/default/default-avatar.png') }}" style="width: 55px;border-radius: 30px;" alt="" srcset="" class="text-center mx-auto">
                                    </div>
                                        <div class="d-flex justify-content-between col-md-10 pl-0 mt-lg-0 mt-md-0 mt-3">
                                            <div class="text-muted mb-0" style="width: 57%;">
                                                <span class="text-muted">
                                                <i class="fa fa-reply"></i>

                                                {{ $reseller->phone ?? ''}} - {{ $reseller->name ?? ''}} -- {!! $status !!}

                                                {{-- <div ><small class="text-muted">Received on {{ getFormattedDateTime($my_reseller->created_at)  }}</small></div> --}}
                                                {{-- <div> --}}
                                                    {{-- @php
                                                        $resellercontactinfo = json_decode($reseller_shop->contact_info) ?? '';

                                                        if ($resellercontactinfo != '') {
                                                            $resellerphone = $resellercontactinfo->phone ?? '';
                                                        }else{
                                                            $resellerphone = '';
                                                        }

                                                    @endphp
                                                    <small>{{ UserShopNameByUserId($my_reseller->user_id) ?? " " }} / {{ $resellerphone ?? " " }}</small> --}}
                                                {{-- </div> --}}
                                            </div>
                                            <div class="">
                                                @if($reseller_shop)
                                                {{-- @if($collection_item->status == 4 && $temp_shop_data && checkAccessCodeRedeemed($temp_user_data->id)) --}}

                                                    <a href="{{ inject_subdomain('home', UserShopRecordByUserId($my_reseller->user_id)->slug ?? " ", true)}}" target="_blank" class="btn  btn-outline-primary btn-sm">Display</a>

                                                    @if($status == "<font class='text-warning'>Pending</font>")
                                                        <a href="{{ route('panel.seller.supplier.index') }}" target="_blank" class="btn btn-outline-danger btn-sm  md-2 shop-btn-mobile">Action</a>
                                                    @endif

                                                @else
                                                    <a href="" class="text-warning"> <i class="fa fa-hourglass fa-spin fa-sm"></i></a>
                                                @endif

                                            </div>

                                        </div>
                                </div>
                                </div>

                            @endforeach

                        </div><!--end teb pane-->

                        <div class="tab-pane fade bg-white shadow rounded p-4 @if(request()->has('active') && request()->get('active') == "support-ticket") active show @endif" id="support-ticket" role="tabpanel" aria-labelledby="support-ticket">
                            <div class="d-flex justify-content-between mb-2">
                                <h5 class="mt-1">Support Tickets</h5>
                                <a href="javascript:void(0);"  class="btn btn-primary raiseTicket">Raise a Ticket</a>
                            </div>
                           <div class="border-bottom"></div>
                            @forelse ($tickets as $ticket)
                            <div class="border-bottom @if($loop->even) bg-light  @endif p-3">
                                <a href="{{ route('customer.ticket.show',$ticket->id) }}">
                                    <div class="d-flex ms-2">
                                        <i class="uil uil-envelope h5 align-middle me-2 mb-0 @if($ticket->status == 1) text-danger @endif"></i>
                                        <div class="ms-3">
                                           <div class="d-flex justify-content-between">
                                               <div>
                                                   <h6 class="text-dark mb-0">{{ $ticket->subject }} </h6>
                                               </div>
                                               <div style="position: absolute;right: 45px;">
                                                   <span class="badge bg-{{ getSupportTicketStatus($ticket->status)['color'] }}">{{ getSupportTicketStatus($ticket->status)['name'] }}</span>
                                               </div>
                                           </div>
                                            <p class="text-muted mb-0">{{ Str::limit($ticket->message,65) }}</p>
                                            <small class="text-muted d-block">Raised On {{ getFormattedDateTime($ticket->created_at) }} </small>
                                            <small class="text-muted">Priority : {{ $ticket->priority ?? '--' }}</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                             @empty
                                <div class="text-center mx-auto mt-3">
                                    <h6>No Tickets!</h6>
                                </div>
                            @endforelse

                            <div class="mx-auto text-center">
                                {{ $tickets->appends(request()->input())->links() }}
                            </div>
                        </div>

                        @if ($Team_offerto)
                        {{-- Offer Tab Pane Start --}}
                        <div class="tab-pane fade bg-white shadow rounded p-4 @if(request()->has('active') && request()->get('active') == "my-offers-sent") active show @endif" id="my-my-offers-sent" role="tabpanel" aria-labelledby="offer-sent">

                                <div class="my-3 d-flex justify-content-between">
                                    <h5 class="mt-1">Offers</h5>

                                    <select id="sortoffer" class="form-select w-50">
                                        <option value="0">Default (Last Access)</option>
                                        {{-- <option value="1" @if ($request->get('sortoffer') == 1) selected @endif>Sort By Last Access</option> --}}
                                        {{-- <option value="2" @if ($request->get('sortoffer') == 2) selected @endif>Sort By Last Used</option> --}}
                                        <option value="3" @if ($request->get('sortoffer') == 3) selected @endif>Sort By Name</option>
                                        <option value="4" @if ($request->get('sortoffer') == 4) selected @endif>Sort By Create Date</option>
                                        <option value="5" @if ($request->get('sortoffer') == 5) selected @endif>Sort By No. of Views</option>
                                    </select>
                                </div>

                                <div class="card shadow mb-3 border-0" style="width: 100%; overflow-x: auto; flex-wrap: nowrap;">
                                    <ul class="nav custom-pills mb-0 wrapper_pills" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="btn pills-btn active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="false">All</button>
                                        </li>

                                        @if ($Team_offerme)
                                            <li class="nav-item" role="presentation">
                                                <button class="btn pills-btn" id="pills-ownoffer-tab" data-bs-toggle="pill" data-bs-target="#pills-ownoffer" type="button" role="tab" aria-controls="pills-ownoffer" aria-selected="false">By Me</button>
                                            </li>
                                        @endif

                                        @if ($Team_offerto)
                                            <li class="nav-item" role="presentation">
                                                <button class="btn pills-btn" id="pills-sharedoffer-tab" data-bs-toggle="pill" data-bs-target="#pills-sharedoffer" type="button" role="tab" aria-controls="pills-sharedoffer" aria-selected="false">By Others</button>
                                            </li>
                                        @endif
                                    </ul>
                                </div>

                                <div class="border-bottom bg-light  p-3" id="bro">
                                <div class="tab-content" id="pills-tabContent">
                                    {{-- All Offer List --}}
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                                        <div class="row">
                                            @foreach ($proposals as $proposal)
                                                <div class="row ashu"></div>
                                                <div class="border-bottom p-3" id="bro">
                                                <div class="row">
                                                        <div class="d-flex justify-content-between col-md-10 pl-0 mt-lg-0 mt-md-0 mt-3 flex-wrap" style="width: 100%">
                                                            <div class="text-muted mb-0 " style="auto">
                                                                <span>
                                                                    {{ json_decode($proposal->customer_details)->customer_name }}
                                                                    @if ($proposal->status == 1)
                                                                        <span class="text-success"> Sent </span>
                                                                    @else
                                                                        <span class="text-danger"> Draft </span>
                                                                    @endif
                                                                </span>
                                                                <div>
                                                                    <small class="text-muted">
                                                                        <a href="{{ route("customer.checksample",$proposal->id)}}" target="_blank">
                                                                            Samples : {{ App\Models\Proposalenquiry::where('proposal_id',$proposal->id)->latest()->first()->sample_count ?? 0 }}
                                                                        </a> ,&nbsp;

                                                                    Amount : {{ @App\Models\Proposalenquiry::where('proposal_id',$proposal->id)->latest()->first()->amount ?? "0"  }}
                                                                    </small>
                                                                </div>

                                                                <div class=" py-1" ><small class="text-muted">Last Access : {{ getFormattedDateTime($proposal->updated_at)  }}</small></div>
                                                                <div class="">
                                                                    <small class="text-muted mx-1">
                                                                        View : {{ $proposal->view_count ?? '<i class="fa fa-times-circle fa-sm text-danger"></i>'  }}
                                                                    </small>
                                                                    <small class="text-muted mx-1">
                                                                        {{-- PPT : {{ $proposal->ppt_download ?? "No Open Yet"  }} --}}
                                                                        Download:
                                                                        @if ($proposal->ppt_download > 0 || $proposal->pdf_download > 0)
                                                                            <i class="fa fa-check-circle fa-sm text-success"></i>
                                                                        @else
                                                                            <i class="fa fa-times-circle fa-sm text-danger"></i>
                                                                        @endif
                                                                    </small>
                                                                </div>
                                                            </div>

                                                            {{-- @if ($proposal->relate_to == null) --}}
                                                            @if ($proposal->relate_to == $proposal->user_shop_id || $proposal->relate_to == "" || $proposal->user_id == auth()->id())
                                                                <div style="display: flex;flex-direction: row-reverse;gap: 15px;font-size: 1.6vh;text-align: center !important;">
                                                                    @php
                                                                        $product_count = App\Models\ProposalItem::where('proposal_id',$proposal->id)->get()->count();
                                                                    @endphp

                                                                        <div class="dropdown">
                                                                            <button class="btn btn-outline-primary my-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                More <i class="uil-angle-right"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu">
                                                                            @if ($proposal->status == 1)
                                                                                @if ($product_count != 0)
                                                                                    <li>
                                                                                        <button class="dropdown-item copybtn"  value="{{inject_subdomain('shop/proposal/'.$proposal->slug, $slug) }}">
                                                                                            <i class="uil-link-alt"></i> Copy Link
                                                                                        </button>
                                                                                    </li>
                                                                                @endif
                                                                                <li>
                                                                                    <a href="{{inject_subdomain('make-copy/'.$proposal->id,$slug) }}" class="dropdown-item">
                                                                                        <i class="uil-copy"></i> Duplicate
                                                                                    </a>
                                                                                </li>
                                                                            @endif
                                                                            <li>
                                                                                <a href="{{ inject_subdomain('proposal/edit/'.$proposal->id.'/'.$user_key, $slug, false, false)}}?margin={{$proposal->margin ?? 10}}" class="dropdown-item" target="_blank">
                                                                                    <i class="uil uil-comment-alt-edit h6"></i> Edit ( {{ $product_count }} )
                                                                                </a>
                                                                            </li>
                                                                            {{-- @if ($proposal->status == 1)
                                                                                <li>
                                                                                    <a href="{{ route('customer.lock.enquiry',$proposal->id) }}" class="dropdown-item">
                                                                                        <i class="uil-lock-alt h6"></i> 
                                                                                    </a>
                                                                                </li>
                                                                            @endif --}}
                                                                            @if ($proposal->status == 1)
                                                                                <li>
                                                                                    <a href="{{ route("panel.proposals.destroy",$proposal->id) }}" class="dropdown-item text-danger delete-item">
                                                                                        <i class="uil uil-trash h6"></i> Delete
                                                                                    </a>
                                                                                </li>
                                                                            @endif
                                                                            </ul>
                                                                        </div>



                                                                        {{-- <div class="d-flex gap-2 justify-content-end mb-3 d-none">
                                                                            <a href="{{inject_subdomain('make-copy/'.$proposal->id,$slug) }}" class="btn btn-danger btn-sm">Duplicate</a>
                                                                            <button class="btn btn-success btn-sm copybtn" value="{{inject_subdomain('shop/proposal/'.$proposal->slug, $slug) }}">Copy Link</button>
                                                                            <a href="{{ inject_subdomain('proposal/edit/'.$proposal->id.'/'.$user_key, $slug, false, false)}}?margin={{$proposal->margin ?? 10}}" class="btn btn-outline-primary btn-sm shop-btn-mobile md-2" target="_blank">
                                                                                <i class="uil uil-comment-alt-edit h6"></i> Edit ( {{ $product_count }} )
                                                                            </a>
                                                                        </div> --}}
                                                                        {{-- <span class="mt-3">
                                                                            Passcode: {{ $proposal->password }}
                                                                        </span> --}}
                                                                        <br>
                                                                        @if ($proposal->relate_to == $proposal->user_shop_id || $proposal->relate_to == "")
                                                                            <span class="mt-3">Expiry : {{ $proposal->valid_upto ?? "None"}} </span>
                                                                        @endif
                                                                </div>
                                                            @endif


                                                        </div>
                                                </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Own Offr Only --}}
                                    <div class="tab-pane fade" id="pills-ownoffer" role="tabpanel" aria-labelledby="pills-ownoffer-tab" tabindex="0">
                                        <div class="row">
                                            @foreach ($proposals as $proposal)
                                                @if ($proposal->relate_to == $proposal->user_shop_id || $proposal->relate_to != "")
                                                    @continue
                                                @endif
                                                <div class="row ashu"></div>
                                                <div class="border-bottom p-3" id="bro">
                                                <div class="row">
                                                        <div class="d-flex justify-content-between col-md-10 pl-0 mt-lg-0 mt-md-0 mt-3 flex-wrap" style="width: 100%">
                                                            <div class="text-muted mb-0 " style="auto">

                                                                <span>
                                                                    {{ json_decode($proposal->customer_details)->customer_name }}
                                                                    @if ($proposal->status == 1)
                                                                        <span class="text-success"> Sent </span>
                                                                    @else
                                                                        <span class="text-danger"> Draft </span>
                                                                    @endif
                                                                </span>
                                                                <div >
                                                                    {{-- <small class="text-muted">Samples : {{ App\Models\Proposalenquiry::where('proposal_id',$proposal->id)->first()->sample_count ?? 0 }} ,&nbsp; Amount : {{ @App\Models\Proposalenquiry::where('proposal_id',$proposal->id)->first()->amount ?? "0"  }} </small> --}}
                                                                    <small class="text-muted">
                                                                        <a href="{{ route("customer.checksample",$proposal->id)}}" target="_blank">
                                                                            Samples : {{ App\Models\Proposalenquiry::where('proposal_id',$proposal->id)->first()->sample_count ?? 0 }}
                                                                        </a> ,&nbsp;

                                                                    Amount : {{ @App\Models\Proposalenquiry::where('proposal_id',$proposal->id)->first()->amount ?? "0"  }}
                                                                    </small>
                                                                </div>


                                                                <div class=" py-1" ><small class="text-muted">Last Access : {{ getFormattedDateTime($proposal->updated_at)  }}</small></div>
                                                                <div class="">
                                                                    <small class="text-muted mx-1">
                                                                        View : {{ $proposal->view_count ?? '<i class="fa fa-times-circle fa-sm text-danger"></i>'  }}
                                                                    </small>
                                                                    <small class="text-muted mx-1">
                                                                        {{-- PPT : {{ $proposal->ppt_download ?? "No Open Yet"  }} --}}
                                                                        Download:
                                                                        @if ($proposal->ppt_download > 0 || $proposal->pdf_download > 0)
                                                                            <i class="fa fa-check-circle fa-sm text-success"></i>
                                                                        @else
                                                                            <i class="fa fa-times-circle fa-sm text-danger"></i>
                                                                        @endif
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <div style="display: flex;flex-direction: row-reverse;gap: 15px;font-size: 1.6vh;text-align: center !important;">
                                                                @php
                                                                    $product_count = App\Models\ProposalItem::where('proposal_id',$proposal->id)->get()->count();
                                                                @endphp
                                                                    <div class="dropdown">
                                                                        <button class="btn btn-outline-primary my-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                            More <i class="uil-angle-right"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu">
                                                                        @if ($proposal->status == 1)
                                                                            @if ($product_count != 0)
                                                                                <li>
                                                                                    <button class="dropdown-item copybtn"  value="{{inject_subdomain('shop/proposal/'.$proposal->slug, $slug) }}">
                                                                                        <i class="uil-link-alt"></i> Copy Link
                                                                                    </button>
                                                                                </li>
                                                                            @endif
                                                                            <li>
                                                                                <a href="{{inject_subdomain('make-copy/'.$proposal->id,$slug) }}" class="dropdown-item">
                                                                                    <i class="uil-copy"></i> Duplicate
                                                                                </a>
                                                                            </li>
                                                                        @endif
                                                                        <li>
                                                                            <a href="{{ inject_subdomain('proposal/edit/'.$proposal->id.'/'.$user_key, $slug, false, false)}}?margin={{$proposal->margin ?? 10}}" class="dropdown-item" target="_blank">
                                                                                <i class="uil uil-comment-alt-edit h6"></i> Edit ( {{ $product_count }} )
                                                                            </a>
                                                                        </li>
                                                                        @if ($proposal->status == 1)
                                                                            <li>
                                                                                <a href="{{ route("panel.proposals.destroy",$proposal->id) }}" class="dropdown-item text-danger delete-item">
                                                                                    <i class="uil uil-trash h6"></i> Delete
                                                                                </a>
                                                                            </li>
                                                                        @endif
                                                                        </ul>
                                                                    </div>
                                                                    <span class="mt-3">Passcode: {{ $proposal->password }}</span>
                                                                    <br>
                                                                    <span class="mt-3">Expiry : {{ $proposal->valid_upto ?? "None"}}
                                                                    </span>
                                                            </div>
                                                        </div>
                                                </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Shared Offer List --}}
                                    <div class="tab-pane fade" id="pills-sharedoffer" role="tabpanel" aria-labelledby="pills-sharedoffer-tab" tabindex="0">
                                        <div class="row">
                                            @foreach ($proposals as $proposal)
                                                @if ($proposal->relate_to == "")
                                                    @continue
                                                @endif
                                                <div class="row ashu"></div>
                                                <div class="border-bottom p-3" id="bro">
                                                <div class="row">
                                                        <div class="d-flex justify-content-between col-md-10 pl-0 mt-lg-0 mt-md-0 mt-3 flex-wrap" style="width: 100%">
                                                            <div class="text-muted mb-0 " style="auto">
                                                                <span>
                                                                    {{ json_decode($proposal->customer_details)->customer_name }}
                                                                    @if ($proposal->status == 1)
                                                                        <span class="text-success"> Sent </span>
                                                                    @else
                                                                        <span class="text-danger"> Draft </span>
                                                                    @endif
                                                                </span>
                                                                <div>
                                                                    <small class="text-muted">
                                                                        <a href="{{ route("customer.checksample",$proposal->id)}}" target="_blank">
                                                                            Samples : {{ App\Models\Proposalenquiry::where('proposal_id',$proposal->id)->latest()->first()->sample_count ?? 0 }}
                                                                        </a> ,&nbsp;

                                                                    Amount : {{ @App\Models\Proposalenquiry::where('proposal_id',$proposal->id)->latest()->first()->amount ?? "0"  }}
                                                                    </small>
                                                                </div>

                                                                <div class=" py-1" ><small class="text-muted">Last Access : {{ getFormattedDateTime($proposal->updated_at)  }}</small></div>
                                                                <div class="">
                                                                    <small class="text-muted mx-1">
                                                                        View : {{ $proposal->view_count ?? '<i class="fa fa-times-circle fa-sm text-danger"></i>'  }}
                                                                    </small>
                                                                    <small class="text-muted mx-1">
                                                                        {{-- PPT : {{ $proposal->ppt_download ?? "No Open Yet"  }} --}}
                                                                        Download:
                                                                        @if ($proposal->ppt_download > 0 || $proposal->pdf_download > 0)
                                                                            <i class="fa fa-check-circle fa-sm text-success"></i>
                                                                        @else
                                                                            <i class="fa fa-times-circle fa-sm text-danger"></i>
                                                                        @endif
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>

                                                         {{-- @if ($proposal->relate_to == null) --}}
                                                         @if ($proposal->relate_to == $proposal->user_shop_id || $proposal->relate_to == "" || $proposal->user_id == auth()->id())
                                                         <div style="display: flex;flex-direction: row-reverse;gap: 15px;font-size: 1.6vh;text-align: center !important;">
                                                             @php
                                                                 $product_count = App\Models\ProposalItem::where('proposal_id',$proposal->id)->get()->count();
                                                             @endphp

                                                                 <div class="dropdown">
                                                                     <button class="btn btn-outline-primary my-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                         More <i class="uil-angle-right"></i>
                                                                     </button>
                                                                     <ul class="dropdown-menu">
                                                                     @if ($proposal->status == 1)
                                                                         @if ($product_count != 0)
                                                                             <li>
                                                                                 <button class="dropdown-item copybtn"  value="{{inject_subdomain('shop/proposal/'.$proposal->slug, $slug) }}">
                                                                                     <i class="uil-link-alt"></i> Copy Link
                                                                                 </button>
                                                                             </li>
                                                                         @endif
                                                                         <li>
                                                                             <a href="{{inject_subdomain('make-copy/'.$proposal->id,$slug) }}" class="dropdown-item">
                                                                                 <i class="uil-copy"></i> Duplicate
                                                                             </a>
                                                                         </li>
                                                                     @endif
                                                                     <li>
                                                                         <a href="{{ inject_subdomain('proposal/edit/'.$proposal->id.'/'.$user_key, $slug, false, false)}}?margin={{$proposal->margin ?? 10}}" class="dropdown-item" target="_blank">
                                                                             <i class="uil uil-comment-alt-edit h6"></i> Edit ( {{ $product_count }} )
                                                                         </a>
                                                                     </li>
                                                                     {{-- @if ($proposal->status == 1)
                                                                         <li>
                                                                             <a href="{{ route('customer.lock.enquiry',$proposal->id) }}" class="dropdown-item">
                                                                                 <i class="uil-lock-alt h6"></i> 
                                                                             </a>
                                                                         </li>
                                                                     @endif --}}
                                                                     @if ($proposal->status == 1)
                                                                         <li>
                                                                             <a href="{{ route("panel.proposals.destroy",$proposal->id) }}" class="dropdown-item text-danger delete-item">
                                                                                 <i class="uil uil-trash h6"></i> Delete
                                                                             </a>
                                                                         </li>
                                                                     @endif
                                                                     </ul>
                                                                 </div>



                                                                 {{-- <div class="d-flex gap-2 justify-content-end mb-3 d-none">
                                                                     <a href="{{inject_subdomain('make-copy/'.$proposal->id,$slug) }}" class="btn btn-danger btn-sm">Duplicate</a>
                                                                     <button class="btn btn-success btn-sm copybtn" value="{{inject_subdomain('shop/proposal/'.$proposal->slug, $slug) }}">Copy Link</button>
                                                                     <a href="{{ inject_subdomain('proposal/edit/'.$proposal->id.'/'.$user_key, $slug, false, false)}}?margin={{$proposal->margin ?? 10}}" class="btn btn-outline-primary btn-sm shop-btn-mobile md-2" target="_blank">
                                                                         <i class="uil uil-comment-alt-edit h6"></i> Edit ( {{ $product_count }} )
                                                                     </a>
                                                                 </div> --}}
                                                                 {{-- <span class="mt-3">
                                                                     Passcode: {{ $proposal->password }}
                                                                 </span> --}}
                                                                 <br>
                                                                 @if ($proposal->relate_to == $proposal->user_shop_id || $proposal->relate_to == "")
                                                                     <span class="mt-3">Expiry : {{ $proposal->valid_upto ?? "None"}} </span>
                                                                 @endif
                                                         </div>
                                                     @endif

                                                </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--end teb pane-->
                        @endif


                        @if ($Team_profile)
                            <div class="tab-pane fade bg-white rounded @if(request()->has('active') && request()->get('active') == "account") active show @endif" id="account" role="tabpanel" aria-labelledby="account-details">

                                <div class="card shadow mb-3 border-0" style="width: 100%; overflow-x: auto; flex-wrap: nowrap;">
                                    <ul class="nav custom-pills mb-0 wrapper_pills" id="pills-tab" role="tablist">
                                        <li class="nav-item ">
                                            <a data-subactive="my_info" class="mr-2 customer_tabs btn pills-btn @if(!request()->get('subactive')  || request()->get('subactive')  == 'my_info') active @endif" >{{ __('Account Info')}}</a>
                                        </li>

                                        {{-- <li class="nav-item">
                                            <a data-subactive="site_detail" class="mr-2 customer_tabs btn pills-btn @if(request()->get('subactive')  == 'site_detail') active @endif" >{{ __('My Page')}}</a>
                                        </li> --}}

                                        <li class="nav-item">
                                            <a data-subactive="business_profile" class="mr-2 customer_tabs btn pills-btn @if(request()->get('subactive')  == 'business_profile') active @endif">{{ __('e-KYC')}}</a>
                                        </li>

                                        {{-- <li class="nav-item">
                                            <a data-subactive="about_me" class="mr-2 customer_tabs btn pills-btn @if(request()->get('subactive')  == 'about_me') active @endif" >{{ __('Brief Intro')}}</a>
                                        </li> --}}

                                        <li class="nav-item">
                                            <a data-subactive="my_address" class="mr-2 customer_tabs btn pills-btn @if(request()->get('subactive')  == 'my_address') active @endif">{{ __('My Address')}}</a>
                                        </li>
                                        <li class="nav-item">
                                            <a  data-subactive="security" class="mr-2 customer_tabs btn pills-btn @if(request()->get('subactive')  == 'security') active @endif">{{ __('Security')}}</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card shadow mb-3 border-0 card customer_card card-my_info">
                                    <div class="card-body">
                                        <h5 class="">Account Info</h5>
                                        <form action="{{ route('customer.profile.update', $user->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mb-3">
                                                <div class="col-md-6 col-12 mt-3">
                                                    <div class="form-group">
                                                        <label for="name" class="control-label">{{ __('Business Name')}}<span class="text-danger">*</span></label>
                                                        <input type="text" placeholder="Enter Name" class="form-control" name="name" id="name" value="{{ $user->name }}" @if (auth()->user()->ekyc_status == 1) readonly @endif>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 mt-3">
                                                    <div class="form-group">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                <label for="email">{{ __('Business Email')}}<span class="text-danger">*</span>
                                                                    @if($user->email_verified_at)
                                                                        <i class="fa fa-check"></i>
                                                                    @endif
                                                                </label>
                                                            </div>
                                                        <div>
                                                                @if($user->email_verified_at == null )
                                                                    <a class="btn p-0 btn-link text-sm" href="{{route('verification.resend')}}" style="font-size: 0.8rem;">Verify Email</a>
                                                                @endif
                                                        </div>
                                                        </div>

                                                        <input @if($user->email_verified_at != null) readonly @endif type="email" placeholder="test@test.com" class="form-control" name="email" id="email" value="{{ $user->email }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 mt-3">
                                                    <div class="form-group mb-2">
                                                        <label for="phone" class="form-label">{{ __('Business Phone No')}}<span class="text-danger">*</span></label>
                                                        <div class="d-flex">
                                                            <input type="number" aria-readonly="true" placeholder="123 456 7890" id="phone" name="phone" class="form-control w-75" value="{{ $user->phone }}"required  readonly>
                                                            {{-- <button type="button" id="addNumber" class="btn btn-icon btn-primary ms-2"><i class="uil uil-plus"></i></button> --}}
                                                        </div>
                                                        {{-- @dd($user->additional_numbers) --}}
                                                        {{--@if($user->additional_numbers != "null")
                                                            @if(!is_null($user->additional_numbers) && $user->additional_numbers != '')
                                                                <ul class="list-unstyled mt-2">
                                                                    @foreach (json_decode($user->additional_numbers) as $number)
                                                                        <li>
                                                                            <i class="uil uil-check text-success"></i>
                                                                            {{$number}}
                                                                            <a href="{{ route('panel.user.number.delete',[$user->id,$number]) }}" class="delete-item">
                                                                                <i class="ml-5 uil uil-trash text-danger"></i>
                                                                            </a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        @endif --}}
                                                    </div>
                                                </div>
                                                @php
                                                    $industry = json_decode($user->industry_id,true);
                                                @endphp
                                                <div class="col-md-6 col-12 mt-3">
                                                    <div class="form-group mb-2">
                                                        <label class="form-label">vCard</label>
                                                        <input type="file" class="form-control" name="vcard">
                                                        @if(isset($vcard) && $vcard != null)
                                                        <img src="{{ asset($vcard->path) }}" class="mt-3 rounded" alt="vcard" style="height: 100px;">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 mt-3 d-none">
                                                    <div class="form-group">
                                                        <label for="phone">{{ __('Industry')}}<span class=" ger">*</span></label>
                                                        <select @if(UserRole($user->id)['name'] == "User") required @endif name="industry_id[]" class="form-control select2" multiple id="industry_id" disabled>
                                                            @foreach(App\Models\Category::where('category_type_id','=' ,13)->get() as $category)
                                                                <option  value="{{ $category->id }}" @if(isset($industry)) {{ in_array($category->id,$industry) ? 'selected' :'' }} @endif> {{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 d-none">
                                                    <div class="form-group">
                                                        <label for="dob">{{ __('DOB')}}<span class="text-danger">*</span></label>
                                                        <input id="" class="form-control" type="date" name="dob" placeholder="Select your birth date" value="{{ $user->dob }}" />
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 d-none">
                                                    <div class="form-group">
                                                        <label for="">Gender</label>
                                                        <div class="form-radio">
                                                                <div class="radio radio-inline">
                                                                    <label>
                                                                        <input type="radio" name="gender" value="male" {{ $user->gender == 'male' ? 'checked' : '' }}>
                                                                        <i class="helper"></i>{{ __('Male')}}
                                                                    </label>
                                                                </div>
                                                                <div class="radio radio-inline">
                                                                    <label>
                                                                        <input type="radio" name="gender" value="female" {{ $user->gender == 'female' ? 'checked' : '' }}>
                                                                        <i class="helper"></i>{{ __('Female')}}
                                                                    </label>
                                                                </div>
                                                        </div>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-3 d-none">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Exclusive Passcode <i class="uil-info-circle" title="Passcode For Viewing You Excluisve Products In Offer."></i></label>
                                                        <input type="text" class="form-control" name="exclusive_pass" autocomplete="off" value="{{ $user->exclusive_pass ?? " " }}" required>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-6 mt-3">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Instagram Link</label>
                                                        <input type="link" class="form-control" name="instagram_link" value="{{ $user->instagram_link }}" placeholder="Enter Instagram Link">
                                                    </div>
                                                </div> --}}

                                                <div class="col-md-12 d-none">
                                                    <div class="form-group">
                                                        <label for="address">{{ __('Address')}}<span class="text-danger">*</span></label>
                                                        <textarea name="address" name="address" rows="5" class="form-control" placeholder="Enter Address">{{ $user->address }}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-success">Update Profile</button>
                                        </form>
                                    </div>
                                </div>

                                <div class="card shadow mb-3 border-0 card customer_card card-site_detail">
                                    <div class="card-body">
                                        {{-- <h5 class="mb-3">My Page</h5> --}}

                                        <form action="{{ route('panel.user_shops.updateuser', $user_shop->id) }}" method="post" class="mb-3" enctype="multipart/form-data">
                                            @csrf
                                            @php
                                                $contact_info = json_decode($user_shop->contact_info);
                                                $social = json_decode($user_shop->social_links);
                                                $full_address = json_decode($user_shop->address);
                                                $about = json_decode($user_shop->about);
                                            @endphp


                                            <div class="row mb-3">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                                        <label for="name" class="control-label">Display Name</label>
                                                        <small title="Shown to other business users when sending you connection request"><i class="uil-info-circle"></i></small>
                                                        <input class="form-control" name="name" type="text" id="name"
                                                            value="{{ $user_shop->name }}" placeholder="Enter Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 d-none">
                                                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                                        <label for="name" class="control-label">Slug</label>
                                                        <input required class="form-control" name="slug" type="text" id="txtName"
                                                            value="{{ $user_shop->slug }}" placeholder="Enter Slug">
                                                            <span class="text-danger" id="lblError"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="email">Email Us<span class="text-danger">*</span></label>
                                                        <small title="Email from Customer to your business"><i class="uil-info-circle"></i></small>
                                                        <input class="form-control" type="email" name="email" value="{{ $contact_info->email ?? ' ' }}" placeholder="Enter Email" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <div class="form-group">
                                                        <label for="phone">Call on Phone<span class="text-danger">*</span></label>
                                                        <small title="Calling number from Customer to your business"><i class="uil-info-circle"></i></small>

                                                        <input class="form-control" type="number"  name="phone" value="{{ $contact_info->phone ?? ' ' }}" placeholder="Enter Phone No" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-3">
                                                    <div class="form-group">
                                                        <label for="whatsapp">Whatsapp Phone</label>
                                                        <small title="Whatsapp For Customer to Connect your business"><i class="uil-info-circle"></i></small>
                                                        <div class="input-group">
                                                            <span class="input-group-prepend">
                                                                <label class="input-group-text">https://wa.me</label>
                                                            </span>
                                                            <input type="text" class="form-control" type="url" name="whatsapp" value="{{ $contact_info->whatsapp ?? ' ' }}" placeholder="Enter Whatsapp Url">
                                                            <span class="text-muted my-1 fs-6" style="font-size: 0.8rem !important;">Number should'nt contain + or country code</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                {{-- <div class="h5">Display Intro</div> --}}

                                                <div class="col-md-6 col-12 mt-lg-0 mt-md-0 mt-">
                                                    <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
                                                        <label for="logo" class="control-label">Upload Business Logo</label>
                                                        <input class="form-control" name="logo_file" type="file" id="logo">
                                                        <span class="text-danger">Ideal Dimensions 147*50</span><br>
                                                        @if ($user_shop->logo !=null)
                                                            <img id="logo_file" src="{{ asset($user_shop->logo) }}" class="mt-2"
                                                                style="border-radius: 10px;width:100px;height:80px;" />
                                                                <a class="btn btn-icon btn-sm btn-primary cross-icon delete-item" href="{{ route('customer.remove-img',$user_shop->id).'?type=bussiness_logo' }}"><i class="fa fa-times"></i></a>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group {{ $errors->has('img') ? 'has-error' : '' }}">
                                                        <label for="img" class="control-label">Upload Banner Image</label>
                                                        <input class="form-control" name="img" type="file" id="banner">
                                                        <span class="text-danger d-block">Ideal Dimensions 1519*370</span>
                                                        @if ($media != null)
                                                            <img id="img" src="{{ asset($media->path) }}" class="mt-2"
                                                            style="border-radius: 10px;width:100px;height:80px;" />
                                                            <a class="btn btn-icon btn-sm btn-primary cross-icon delete-item" href="{{ route('customer.remove-img',$user_shop->id).'?type=banner_img' }}"><i class="fa fa-times"></i></a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <h6 class="my-2">Social Links:
                                            <small title="Enter complete URL from each of sites"><i class="uil-info-circle"></i></small>
                                        </h6>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <label class="input-group-text"><i data-feather="facebook" class="fea icon-sm icons my-2"></i></label>
                                                        </span>
                                                        <input type="text" name="social_link[fb_link]" class="form-control" value="{{ @$social->fb_link }}" placeholder="Add Your FaceBook page" >
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-lg-0 mt-md-0 mt-3">
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <label class="input-group-text"><i data-feather="linkedin" class="fea icon-sm icons my-2"></i></label>
                                                        </span>
                                                        <input type="text" name="social_link[in_link]" class="form-control" value="{{ @$social->in_link }}" placeholder="Add Your Indeed">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <label class="input-group-text"><i data-feather="twitter" class="fea icon-sm icons my-2"></i></label>
                                                        </span>
                                                        <input type="text" name="social_link[tw_link]" class="form-control" value="{{ @$social->tw_link }}" placeholder="Add Your Twitter Page">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mt-lg-0 mt-md-0 mt-3">
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <label class="input-group-text"><i data-feather="youtube" class="fea icon-sm icons my-2"></i></label>
                                                        </span>
                                                        <input type="text" name="social_link[yt_link]" class="form-control" value="{{ @$social->yt_link }}" placeholder="Add Your Youtube Channel">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6 mt-lg-0 mt-md-0 mt-3">
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <label class="input-group-text"><i data-feather="instagram" class="fea icon-sm icons my-2"></i></label>
                                                        </span>
                                                        <input type="text" name="social_link[insta_link]" class="form-control" value="{{ @$social->insta_link ?? ""}}" placeholder="Add Your Instagram Page">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 mt-lg-0 mt-md-0 mt-3">
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <label class="input-group-text">
                                                                <i class="fab fa-pinterest-p fea icon-sm icons my-2"></i>
                                                            </label>
                                                        </span>
                                                        <input type="text" name="social_link[pint_link]" class="form-control" value="{{ @$social->pint_link ?? ""}}" placeholder="Add Your pinterest Page">
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="col-lg-12 mt-2 mb-0">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </div><!--end col-->
                                        </form>
                                    </div>
                                </div>

                                {{-- Ekyc start --}}

                                <div class="card shadow mb-3 border-0 card-business_profile customer_card" >

                                    @if (auth()->user()->ekyc_status == 0)
                                    <div style="font-size: 16px;" class="alert alert-light" role="alert">

                                        <div>
                                            <h4>Register and Start Selling</h4>
                                                <p>Please have the following ready before you begin:</p>
                                                <ul>
                                                    <li>Keep Your GST certificate & Brand certificate (if applicable) ready for upload in pdf/jpeg format</li>
                                                </ul>
                                                <p>Please ensure that all the information you submit is accurate</p>
                                                <button class="ekyc btn btn-outline-danger btn-md  text-right">Fill Now</button>
                                        </div>
                                    {{--to make brief intro visible visible --}}
                                    
                                        @if($ekyc && isset($ekyc->admin_remark))
                                            <div class="alert alert-info">
                                            Admin Remark: {{$ekyc->admin_remark}}
                                            </div>
                                        @endif
                                        </div>
                                        {{-- @dump($ekyc) --}}
                                    @elseif (auth()->user()->ekyc_status == 2)
                                        <div style="font-size: 16px;" class="alert alert-danger d-flex justify-content-between" role="alert"><span class="m-0 p-0" style="line-height: 40px;">Your KYC Verification Application has been rejected</span>
                                            <button type="button" class="ekyc btn btn-outline-light btn-md px-3 py-0 text-right">Submit Again</button>
                                        </div>
                                    @elseif(auth()->user()->ekyc_status == 1)
                                        <div style="font-size: 16px;" class="alert alert-success d-flex justify-content-between" role="alert"><span class="m-0 p-0" style="line-height: 40px;">Your KYC Verification Application has been Verified </span>
                                        </div>
                                    {{-- Submitted --}}
                                    @elseif (auth()->user()->ekyc_status == 3)
                                        <div style="font-size: 16px;" class="alert alert-warning d-flex justify-content-between" role="alert">
                                            <span class="m-0 p-0" style="line-height: 40px;">KYC request submitted successfully. Our team will revert within 24 hours.</span>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        {{-- <h5 class="">eKyc Info</h5>
                                        <form action="{{ route('panel.verify-ekyc') }}" method="post" enctype="multipart/form-data"> --}}
                                        @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Document Type</label>
                                                        <div class="form-icon position-relative">
                                                            <select disabled class="form-control" name="document_type" id="">
                                                                <option value="" aria-readonly="true">Select Document Type</option>
                                                                    <option @if(isset($ekyc) && $ekyc->document_type == "GST Certificate") selected @endif value="GST Certificate" readonly>GST Certificate</option>

                                                                <option @if(isset($ekyc) && $ekyc->document_type == "Brand Trademark certificate") selected @endif value="Brand Trademark certificate" readonly>Brand Trademark certificate</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div><!--end col-->
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Document Number</label>
                                                        <div class="form-icon position-relative">
                                                            <input disabled name="document_number" type="text" class="form-control" value="{{ $ekyc->document_number ?? ' ' }}" placeholder="Enter Document Number">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Document Front Attactment</label>
                                                        <div class="form-icon position-relative">
                                                            {{-- <input name="document_front_attachment" type="file" class="form-control" value="{{ $ekyc->document_front ?? ' ' }}" placeholder="Enter Document Number"> --}}
                                                            @if ($ekyc && $ekyc->document_front != null)
                                                                <a href="{{ asset($ekyc->document_front) ?? '' }}" target="_blank">
                                                                    <span class="badge bg-danger mt-2 p-2"><i class="uil uil-eye pr-2"></i>View Attachment</span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Document Back Attactment</label>
                                                        <div class="form-icon position-relative">
                                                            {{-- <input name="document_back_attachment" type="file" class="form-control" value="{{ $ekyc->document_back ?? ' ' }}" placeholder="Enter Document Number"> --}}
                                                            @if ($ekyc && $ekyc->document_back != null)
                                                                    <a href="{{ asset($ekyc->document_back) ?? '' }}" target="_blank">
                                                                    <span class="badge bg-danger mt-2 p-2"><i class="uil uil-eye pr-2"></i>View Attachment</span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-6">

                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Account Type</label>
                                                            <div class="form-icon position-relative">
                                                                <select name="acc_type" id="acc_type" class="form-control" disabled>
                                                                    <option {{ $chk = ($user->account_type == 'customer') ?  "selected" : "" ; }} value="customer">Customer</option>
                                                                    <option {{ $chk = ($user->account_type == 'supplier') ?  "selected" : "" ; }} value="supplier">Manufacturer / stockest</option>
                                                                    <option {{ $chk = ($user->account_type == 'reseller ') ?  "selected" : "" ; }} value="reseller">Reseller</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div> --}}

                                        {{-- </form> --}}
                                    </div>
                                    </div>
                                </div>
                                {{-- Ekyc end --}}





                                {{-- brief_induction --}}
                                <div class="card shadow mb-3 border-0 card customer_card card-about_me">
                                    <div class="card-body">
                                        <div class="h5 my-3">Brief Intro</div>
                                        <form action="{{ route('panel.user_shops.story',$user_shop->id) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row mt-3">
                                                <div class="col-md-12 col-12  d-none">
                                                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                                        <label for="title" class="control-label">Title</label>
                                                        <input class="form-control" name="title" type="text" id="title"
                                                        value="{{ $story['title'] ?? '' }}" placeholder="Enter Title">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 my-3">
                                                    <div class="form-group {{ $errors->has('cta_link') ? 'has-error' : '' }}">
                                                        <label for="cta_link" class="control-label">Catalogue</label>
                                                        <input type="file" class="form-control" name="cta_file">

                                                        @if(isset($story['cta_link']) != null)
                                                            @if ($story['cta_link'] != "")
                                                                <i title="eKyc Verified" class="fa fa-check-circle fa-sm text-success"></i>
                                                                <a href="{{ asset($story['cta_link']) }}" target="_blank" class="btn-link pt-2">Show Catalogue</a>
                                                            @endif
                                                            <input class="form-control d-none" name="cta_link" type="link" id="cta_link"
                                                            value="{{ $story['cta_link'] ?? '' }}" placeholder="Enter Button Link" readonly>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 my-3 d-none">
                                                    <div class="form-group {{ $errors->has('cta_label') ? 'has-error' : '' }}">
                                                        <label for="label" class="control-label ">Catalogue Label</label>
                                                        <input class="form-control" name="cta_label" type="text" id="cta_label"
                                                        value="{{ 'Download Catalogue' }}" placeholder="Enter Button Label">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 my-3">
                                                    <div class="form-group {{ $errors->has('prl_link') ? 'has-error' : '' }}">
                                                        <label for="prl_link" class="control-label">Price List</label>
                                                        <input type="file" class="form-control" name="prl_file">

                                                        @if(isset($story['prl_link']) != null)
                                                            @if ($story['prl_link'] != "")
                                                                <i title="eKyc Verified" class="fa fa-check-circle fa-sm text-success"></i>
                                                                <a href="{{ asset($story['prl_link']) }}" target="_blank" class="btn-link pt-2">Show Price List</a>
                                                            @endif
                                                            <input class="form-control d-none" name="prl_link" type="link" id="prl_link"
                                                            value="{{ $story['prl_link'] ?? '' }}" placeholder="Enter Button Link" readonly>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 my-3 d-none">
                                                    <div class="form-group {{ $errors->has('prl_label') ? 'has-error' : '' }}">
                                                        <label for="label" class="control-label ">Price List Label</label>
                                                        <input class="form-control" name="prl_label" type="text" id="prl_label"
                                                        value="{{ 'Download Price List'}}" placeholder="Enter Button Label">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group {{ $errors->has('video_link') ? 'has-error' : '' }}">
                                                        <label for="label" class="control-label">Video Link</label>
                                                        <input class="form-control" name="video_link" type="url" id="video_link"
                                                        value="{{ $story['video_link'] ?? '' }}" placeholder="Enter Video Link">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 mt-lg-0 md-mt-0 mt-3">
                                                    <div class="form-group {{ $errors->has('img') ? 'has-error' : '' }}">
                                                        <label for="img" class="control-label">Image</label>
                                                        <input class="form-control" name="img" type="file" id="img"
                                                        value="">
                                                        @if(isset($story['img']) && $story['img'] != null)
                                                        <img src="{{ asset($story['img']) }}" class="mt-1" alt="img" style="width: 40%; height: 80px; object-fit: contain;">
                                                        <input type="text"  class="d-none" name="old_img" value="{{ asset($story['img']) }}" readonly>
                                                        @endif
                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-12 col-12 mt-3">
                                                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                                        <label for="description" class="control-label">Description</label>
                                                        <textarea class="form-control" name="description" type="text" id="description" placeholder="Enter Description"
                                                        value="">{{ $story['description'] ?? '' }}</textarea>
                                                    </div>
                                                </div> --}}

                                                <div class="col-md-12 col-12 mt-3">
                                                    <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                                        <label for="description" class="control-label mb-2">Description</label>
                                                        <textarea name="description" class="form-control" id="description1" cols="30" rows="10">{{ $story['description'] ?? '' }}</textarea>
                                                    </div>
                                                </div>



                                                <div class="col-md-12 mt-3">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <a href="{{ inject_subdomain('about-us', $user_shop->slug)}}#story" target="_blank" class="btn btn-outline-primary">Preview</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="card shadow mb-3 border-0 card-my_address customer_card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-3">
                                            {{-- <h5 class="mt-1">Billing Addresses</h5> --}}
                                            <a href="javascript:void(0);" class="btn btn-primary addAddress" data-id="{{ auth()->id() }}">Add Address</a>
                                        </div>
                                        @if ($addresses->count() > 0)
                                            <div class="row">
                                                @foreach ($addresses as $address)
                                                    @php
                                                        $address_decoded = json_decode($address->details,true) ?? '';
                                                    @endphp
                                                    <div class="col-lg-6">
                                                        <div class="m-1 p-2 border rounded">
                                                            <div class="mb-2">
                                                                <div class="d-flex align-items-center justify-content-between">
                                                                    <h6 class="m-0 p-0">{{ $address->type == 0 ? "Billing" : "Office" }} Address:</h6>
                                                                    <div>
                                                                        <a href="javascript:void(0)" class="text-primary editAddress h5 mb-0" title="" data-id="{{ $address }}" data-original-title="Edit" ><i class="uil uil-edit"></i></a>
                                                                        <a href="{{ route('customer.address.delete',$address->id) }}" class="text-primary delete-item h5 mb-0" title=""data-original-title="delete" ><i class="uil uil-trash"></i></a>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <div class="pt-4 border-top">
                                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                                <div>
                                                                    <p class="h6 text-muted">{{ $address_decoded['address_1'] }}</p>
                                                                    <p class="h6 text-muted">{{ $address_decoded['address_2'] }}</p>
                                                                    <p class="h6 text-muted">
                                                                        {{ CountryById($address_decoded['country']) }},
                                                                        {{ StateById( $address_decoded['state']) }},
                                                                        {{ CityById( $address_decoded['city']) }}</p>
                                                                    <p class="text-muted h6">Pincode {{ $address_decoded['pincode'] ?? '---' }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                        @else
                                            <div class="mx-auto text-center mt-3">
                                                <h6 class="text-muted">No Address Yet!</h6>
                                            </div>
                                        @endif
                                        <div class="border-bottom mt-3"></div>

                                        {{-- <h5 class="mt-2">Site Addresses</h5>
                                        @php
                                            $full_address = json_decode($user_shop->address);
                                            $contact_info = json_decode($user_shop->contact_info);
                                        @endphp
                                        <form class="row mb-3" action="{{ route('panel.user_shops.address.update', $user_shop->id) }}" method="post">
                                            @csrf
                                            <div class="col-lg-4 col-md-6 col-6">
                                                <div class="form-group">
                                                    <label for="address" class="control-label">Flat Office Number</label>
                                                    <input type="text" class="form-control" name="address[flat_number]"  value="{{ $full_address->flat_number ?? old('flat_number') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-6">
                                                <div class="form-group">
                                                    <label for="floor" class="control-label">Floor</label>
                                                    <input type="text" class="form-control" name="address[floor]" placeholder="Enter Floor" value="{{ $full_address->floor ?? old('floor') }}">
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-md-6 col-6">
                                                <div class="form-group">
                                                    <label for="building_name">Building Name / Line 2</label>
                                                    <input type="text" class="form-control" name="address[building_name]" placeholder="Enter Building Name / Line 2" value="{{ $full_address->building_name ?? old('building_name') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-12 mt-3">
                                                <div class="form-group">
                                                    <label for="floor" class="control-label">Landmark, if any</label>
                                                    <input type="text" class="form-control" name="location" placeholder="Enter Location" value="{{ $contact_info->location ?? old('location') }}">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-6 mt-3">
                                                <div class="form-group">
                                                    <label for="line_3_address">Line 3 of address</label>
                                                    <input type="text" class="form-control" name="address[line_3_address]" placeholder="Line 3 of address" value="{{ $full_address->line_3_address ?? old('line_3_address') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12 mt-3">
                                                <div class="form-group">
                                                    <label for="country">Country </label>
                                                    <select name="address[country]" id="countryShop" class="form-control select2">
                                                        <option aria-readonly="true" value="">Select Country</option>
                                                        @foreach (\App\Models\Country::all() as $country)
                                                            <option value="{{ $country->id }}" @if(isset($full_address->country)&& $full_address->country == $country->id) selected @endif>
                                                                {{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12 mt-3">
                                                <div class="form-group">
                                                    <label for="">State</label>
                                                    <select id="stateShop" name="address[state]"  class="form-control select2">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12 mt-3">
                                                <div class="form-group">
                                                    <label for="city">City</label>
                                                    <select id="cityShop" name="address[city]" class="form-control select2">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-6 mt-3">
                                                <div class="form-group">
                                                    <label for="">GST Number</label>
                                                    <input class="form-control" type="number" name="address[gst_number]" value="{{ $full_address->gst_number ?? old('gst_number') }}" placeholder="Enter GST Number">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-6 mt-3">
                                                <div class="form-group">
                                                    <label for="">Entity Name</label>
                                                    <input class="form-control" type="text" name="address[entity_name]" value="{{ $full_address->entity_name ?? old('entity_name') }}" placeholder="Enter Entity Name">
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end mt-3">
                                                <button class="btn btn-primary" type="submit">Update</button>
                                            </div>
                                            <div class="col-12"><hr></div>
                                        </form>
                                        --}}


                                    </div>
                                </div>

                                <div class="card shadow mb-3 border-0 card-security customer_card">
                                    <div class="card-body">
                                        <h5 class="">Change Password</h5>
                                        <form action="{{ route('panel.update-password', $user->id) }}" method="post">
                                            @csrf
                                            <div class="row mt-3">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Old Password :</label>
                                                        <div class="form-icon position-relative">
                                                            <i data-feather="key" class="fea icon-sm icons"></i>
                                                            <input required type="password" class="form-control ps-5" placeholder="Old password" name="old_password">
                                                        </div>
                                                    </div>
                                                </div><!--end col-->

                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">New password :</label>
                                                        <div class="form-icon position-relative">
                                                            <i data-feather="key" class="fea icon-sm icons"></i>
                                                            <input type="password" max="6" class="form-control ps-5" placeholder="New password" required="" name="password">
                                                        </div>
                                                    </div>
                                                </div><!--end col-->

                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Re-type New password :</label>
                                                        <div class="form-icon position-relative">
                                                            <i data-feather="key" class="fea icon-sm icons"></i>
                                                            <input type="password" max="6" class="form-control ps-5" placeholder="Re-type New password" required="" name="confirm_password">
                                                        </div>
                                                    </div>
                                                </div><!--end col-->

                                                <div class="col-lg-12 mt-2 mb-0">
                                                    <button class="btn btn-primary" type="submit">Save Password</button>
                                                </div><!--end col-->
                                            </div><!--end row-->
                                        </form>
                                    </div>
                                </div>


                            </div><!--end teb pane-->
                        @endif

                    </div>
                </div>
                <!--end col-->
            </div><!--end row-->

        </div><!--end container-->



        <div class="cardprint visually-hidden">
            <div class="card-body" style="width: 342px;border: 1px solid;padding: 20px;">
                <div class="row">
                    @if($user_shop->slug == auth()->user()->phone)
                        <div class="col-md-12">
                            <div class="form-group mb-0">
                                <form action="{{ route('panel.seller.update.site-name',$user_shop->id) }}" method="post">
                                    @csrf
                                    <span id="lblError" class="text-danger"></span>
                                    <div class="d-flex justify-content-between">
                                        <div class="input-group">
                                            <input type="text" class="form-control"  name="shop_name" placeholder="Sitename" id="txtName" value="{{ $user_shop->slug }}">
                                            <span class="input-group-append">
                                                <label class="input-group-text">
                                                    .121.page
                                                </label>
                                            </span>
                                        </div>
                                        <button class="btn btn-sm btn-outline-danger m-1 px-2 py-1">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
                        @if($user_shop->slug == auth()->user()->phone)
                            <div class="col-md-12"> <hr></div>
                        @endif
                    <div class="col-12 dashboard-card p-2"  id="html-content-holder">
                        <div class="text-center mx-auto">
                            <div>
                                <img src="{{ getBackendLogo(getSetting('app_white_logo'))}}" alt="website Logo" style="height: 40px;" class="my-1">
                                <hr>
                                <h5 class="mt-2">
                                    <strong>
                                      {{ $user_shop->slug }}.121.Page
                                    </strong>
                                </h5>
                                <span>Scan to get latest offers</span>
                                    <div class="p-2">
                                        {!! QrCode::size(200)->generate(route('microsite.proxy')."?page=home&is_scan=1&shop=$user_shop->slug") !!}
                                    </div>
                                    <div id="previewImg" class="d-none">
                                    </div>
                                    <br>
                                <h6 class="mt-2">
                                    <i class="ik ik-phone"></i> {{ $contact_info->phone ?? '' }}</h6>
                                <h6 class="mt-2">
                                    <i class="fa fa-envelope"></i>
                                    {{ $contact_info->email ?? '' }}</h6>

                                    <hr>

                                    <label for="" class="text-center text-muted">
                                    Powered by 121.page
                                    </label>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="d-flex justify-content-center">

                   <div>
                        {{-- <a href="javascript:void(0);" onclick="copyTextToClipboard('{{ inject_subdomain('home', $user_shop->slug)}}')" class=" copy-link-btn btn btn-outline-light mt-2 text-dark">Copy Link</a> --}}
                        <a href="javascript:void(0);" onclick="exportpdf()" class="copy-link-btn btn btn-outline-light mt-2 text-dark">Export PDF</a>
                        <br>
                    </div>
                </div>
                <span class="text-center mx-4 d-flex align-items-center" style="padding-top: 10px !important">
                    <span class="ik ik-info fa-1x text-danger m-1"></span>
                    Use Desktop For Better Export Print
                </span>
            </div>

        </div>


    </section><!--end section-->
        <!-- End -->

<div class="modal" id="detailTicketModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="TicketID"></h5>
                <button type="button" class="btn btn-close" data-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="message">Message:</label>
                    <p id="msg"></p>
                </div>
                <div class="form-group">
                    <label for="subject">Reply:</label>
                    <p id="reply"></p>
                </div>
            </div>
        </div>
    </div>
</div>
<form action="{{ route('panel.user.update-numbers') }}" method="post" id="updateAdditionalNumber">
    @csrf
</form>
<form action="{{ route('customer.dashboard') }}" id="sortformoffer"  method="get">
    <input type="hidden" name="active" value="my-offers-sent" id="active">
    <input type="hidden" name="sortoffer" value="" id="shorid">
</form>
@include('frontend.customer.dashboard.includes.modal.ekyc')
@include('frontend.customer.dashboard.includes.modal.raise-ticket')
@include('frontend.customer.dashboard.includes.modal.access-code')
@include('frontend.customer.dashboard.includes.modal.add-address')
@include('frontend.customer.dashboard.includes.modal.edit-address')
@include('frontend.customer.dashboard.includes.modal.scan-qr')
@include('frontend.customer.dashboard.includes.modal.upload-image')
@include('frontend.customer.dashboard.includes.modal.request-catalogue')
@include('frontend.customer.dashboard.includes.modal.searchbx')
@include('frontend.customer.dashboard.includes.modal.send-catalogue')
@include('frontend.customer.dashboard.includes.modal.survey')
@include('frontend.customer.dashboard.includes.modal.createTeam')
@include('frontend.customer.dashboard.includes.modal.add-currencies')
@include('frontend.customer.dashboard.includes.modal.update-currency')
@include('backend.seller.modal.catalogue-request')
@include('panel.user_shops.include.add-numbers')



@endsection
@section('InlineScript')
<script src="{{ asset('backend/js/qrcode.js') }}"></script>
<script src="{{ asset('frontend/assets/js/simplebar.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/simplebar.min.js') }}"></script>
<script src="{{ asset('frontend/libs/feather-icons/feather.min.js')}}"></script>
<script src="{{ asset('backend/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>

<script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
<script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

<script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
<script src="{{ asset('backend/js/html2canvas.js') }}"></script>


@php
    $count = App\Models\survey::where('user_id',auth()->id())->get()->count();
@endphp


@if ($count == 0 )
    <script>
        $(document).ready(function () {
            $('#surverymodal').modal('show');
        });
    </script>
@endif


@if (request()->has('upload_gst') && request()->get('upload_gst') == 'true')
    <script>
        $(document).ready(function () {
            $('#ekycVerification').modal('show');
        });
    </script>
@endif

<script>


    $(document).ready(function () {
        $('.send-request').click(function(){
            $('#sendForCatalogue').modal('show');
        })

        $(".updatecurrencybtn").click(function (e) { 
            e.preventDefault();

            let crrname = $(this).data('crrname');
            let crrid = $(this).data('crrid');
            let crrvalue = $(this).data('crrvalue');
            
            $('#currencyname').val(crrname);
            $('#crrid').val(crrid);

            $('#currencyvalue').val(crrvalue);


            $("#updatecurrency").modal('show')
        });

        $("#addcurrencyopen").click(function (e) { 
            e.preventDefault();
            $('#addcurrency').modal('show');
        });
        $("#addmember").click(function (e) {
            e.preventDefault();
            $("#addTeam").modal("show");
        });

        // $(".openmicrsotesettingmodal").click(function (e) { 
        //     e.preventDefault();
        //     $("#micrsotesettingmodal").modal('show')
        // });


        // $("#micrsotesettingmodal").modal('show')

    });

        $(document).ready(function () {
            $('.access-request').click(function(){
                $('#requestForCatalogue').modal('show');
            })
        });

        $('tags').tagsinput('items');
            var options = {
                    filebrowserImageBrowseUrl: "{{ url('/laravel-filemanager?type=Images') }}",
                    filebrowserImageUploadUrl: "{{ url('/laravel-filemanager/upload?type=Images&_token='.csrf_token()) }}",
                    filebrowserBrowseUrl: "{{ url('/laravel-filemanager?type=Files') }}",
                    filebrowserUploadUrl: "{{ url('/laravel-filemanager/upload?type=Files&_token='.csrf_token()) }}"
                };


        $(window).on('load', function (){
            CKEDITOR.replace('description1', options);
        });

        // filter Offers
        $("#sortoffer").change(function (e) {
            e.preventDefault();
            var sortid = $(this).val();
            const form = $("#sortformoffer");
            $("#shorid").val(sortid);


            form.submit();

        });




</script>
<script>

        // acr swithces
        var acr_btn = document.querySelector('.js-acr');
        var switchery = new Switchery(acr_btn, {
            color: '#6666CC',
            jackColor: '#fff'
        });
        // about Switche
        var acr_btn = document.querySelector('.js-about');
        var switchery = new Switchery(acr_btn, {
            color: '#6666CC',
            jackColor: '#fff'
        });
        // Single swithces
        var acr_btn = document.querySelector('.js-single');
        var switchery = new Switchery(acr_btn, {
            color: '#6666CC',
            jackColor: '#fff'
        });
        // Guest Make offer swithces
        var acr_btn = document.querySelector('.js-two');
        var switchery = new Switchery(acr_btn, {
            color: '#6666CC',
            jackColor: '#fff'
        });

        // Verified User Make offer swithces
        var acr_btn = document.querySelector('.js-three');
        var switchery = new Switchery(acr_btn, {
            color: '#6666CC',
            jackColor: '#fff'
        });


        $(document).ready(function () {
            if ($('#js-single').is(":checked"))
            {
                $(".maneg_offer").removeClass("d-none")
            }else{
                $(".maneg_offer").addClass("d-none")
            }
            $("#js-single").change(function (e) {
                // e.preventDefault();
                if ($(this).val() === 1) {
                    $(".maneg_offer").toggleClass("d-none")
                } else {
                    $(".maneg_offer").toggleClass("d-none")
                    // $(".maneg_offer").addClass("d-none")
                }
                console.log("You Cliked On Me!");
            });
        });


</script>

<script>


    function getStates(countryId = 101) {
        $.ajax({
            url: "{{ route('world.get-states') }}",
            method: 'GET',
            data: {
                country_id: countryId
            },
            success: function(res) {
                $('#state').html(res).css('width', '100%');
            }
        })
    }

    function getCities(stateId = 101) {
        $.ajax({
            url: "{{ route('world.get-cities') }}",
            method: 'GET',
            data: {
                state_id: stateId
            },
            success: function(res) {
                $('#city').html(res).css('width', '100%');
            }
        })
    }

    function getStatesShop(countryId = 101) {
        $.ajax({
            url: "{{ route('world.get-states') }}",
            method: 'GET',
            data: {
                country_id: countryId
            },
            success: function(res) {
                $('#stateShop').html(res).css('width', '100%');
            }
        })
    }

    function getCitiesShop(stateId = 101) {
        $.ajax({
            url: "{{ route('world.get-cities') }}",
            method: 'GET',
            data: {
                state_id: stateId
            },
            success: function(res) {
                $('#cityShop').html(res).css('width', '100%');
            }
        })
    }

    function getEditStates(countryId = 101) {
        $.ajax({
            url: "{{ route('world.get-states') }}",
            method: 'GET',
            data: {
                country_id: countryId
            },
            success: function(res) {
                $('#stateEdit').html(res).css('width', '100%');
            }
        })
    }

    function getEditCities(stateId = 101) {
        $.ajax({
            url: "{{ route('world.get-cities') }}",
            method: 'GET',
            data: {
                state_id: stateId
            },
            success: function(res) {
                $('#cityEdit').html(res).css('width', '100%');
            }
        })
    }
    getStates();
    function getStateAsync(countryId) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '{{ route("world.get-states") }}',
                method: 'GET',
                data: {
                    country_id: countryId
                },
                success: function (data) {
                    $('#stateShop').html(data);
                    $('.stateshop').html(data);
                resolve(data)
                },
                error: function (error) {
                reject(error)
                },
            })
        })
    }

    function getCityAsync(stateId) {
        if(stateId != ""){
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: '{{ route("world.get-cities") }}',
                    method: 'GET',
                    data: {
                        state_id: stateId
                    },
                    success: function (data) {
                        $('#cityShop').html(data);
                        $('.cityShop').html(data);
                    resolve(data)
                    },
                    error: function (error) {
                    reject(error)
                    },
                })
            })
        }
    }

    $(document).ready(function(){
        var country = "{{ $full_address->country ?? ''}}";
        var state = "{{ $full_address->state ?? ''}}";
        var city = "{{ $full_address->city ?? ''}}";

        if(state){
            getStateAsync(country).then(function(data){
                $('#stateShop').val(state);
                $('#stateShop').trigger('change');
            });
        }
        setTimeout(() => {
            if(city){
                getCityAsync(state).then(function(data){
                    $('#cityShop').val(city).change();
                    $('#cityShop').trigger('change');
                });
            }
        }, 300);
    });
    function getUrlVars(url) {
        var vars = {};
        var parts = url.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
    }
    function getUrlParam(url, parameter, defaultvalue){
        var urlparameter = defaultvalue;
        if(url.indexOf(parameter) > -1){
            urlparameter = getUrlVars(url)[parameter];
            }
        return urlparameter;
    }

    var resultContainer = document.getElementById('qr-reader-results');
    var lastResult, countResults = 0;

    function onScanSuccess(decodedText, decodedResult) {
        var url = decodedText;
        var slug = "{{getShopSlugByUserId(auth()->id())}}";

        if(getUrlParam(url,'shop') != slug){
            var accessToken = "{{ encrypt(auth()->id()) }}";
            var collection_url = "{{ route('customer.dashboard').'?active=my-collections' }}";
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                // Handle on success condition with the decoded message.
                window.open(url+'&at='+accessToken+'&scan=1');
                window.location.href = collection_url;
                return false;
            }
        }else{
            $('#barCodeModal').modal('hide');
            $.toast({
                heading: 'ERROR',
                text: "You can not scan your own scanner",
                showHideTransition: 'slide',
                icon: 'error',
                loaderBg: '#f2a654',
                position: 'top-right'
            });
        }
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", {
            fps: 10,
            qrbox: 250
        });

    // Copy Text To Clipboard

    function copyTextToClipboard(text) {
            if (!navigator.clipboard) {
                fallbackCopyTextToClipboard(text);
                return;
            }
            navigator.clipboard.writeText(text).then(function() {
            }, function(err) {
            });
            $.toast({
                heading: 'SUCCESS',
                text: "Offer link copied.",
                showHideTransition: 'slide',
                icon: 'success',
                loaderBg: '#f96868',
                position: 'top-right'
            });
    }

    $(".copybtn").click(function (e) {
        e.preventDefault();
        var link = $(this).val();
        copyTextToClipboard(link);
    });



</script>
<script>

    $('.detail').click(function(){
        var id = $(this).data('id');
        var msg = $(this).data('msg');
        var reply = $(this).data('reply');
        $('#TicketID').html(id);
        $('#msg').html(msg);
        $('#reply').html(reply);

        $('#detailTicketModal').modal('show');
    });
            $('.uil-times').hide();
            var mobnav = 0;
            $('.toggleBtn').on('click',function(){
                $('.toggle-area').toggle(200);
                if(mobnav == 0){
                    $(this).html('<i class="uil uil-times"></i>');
                    mobnav = 1;
                }else{
                    $(this).html('<i class="uil uil-bars"></i>');
                    mobnav = 0;
                }
            });

        $(document).ready(function(){
            $(':input[readonly]').css({
                'background-color':'#f6f6f6'
            });
            $('.ekyc').click(function(){
                $('#ekycVerification').modal('show');
            });
            $('.addAddress').click(function(){
                user_id = $(this).data('id');
                $('#userId').val(user_id);
                $('#addAddressModal').removeAttr('tabindex');
                $('#addAddressModal').modal('show');
            });
            $('.editAddress').click(function(){
              var  address = $(this).data('id');
              if(address.type == 0){
                  $('.homeInput').attr("checked", "checked");
                }else{
                    $('.officeInput').attr("checked", "checked");
              }
              var details = jQuery.parseJSON(address.details);
              $('#id').val(address.id);
              $('#user_id').val(address.user_id);
              $('#type').val(address.type);
              $('#address_1').val(details.address_1);
              $('#pincode').val(details.pincode);
              $('#address_2').val(details.address_2);
              $('#countryEdit').val(details.country).change();
              $('#gstNumber').val(details.gst_number).change();
              $('#entityName').val(details.entity_name).change();

              setTimeout(() => {
                  $('#stateEdit').val(details.state).change();
                  setTimeout(() => {
                      $('#cityEdit').val(details.city).change();
                    }, 500);
                }, 500);
                $('#editAddressModal').modal('show');
            });
            $('.accees-code').click(function(){
                $('#AccessCode').modal('show');
            });
            $('#verificationBtn').click(function(){
                    $.ajax({
                        url: "{{ route('verification.resend') }}",
                        method: 'GET',
                        success: function(res) {
                             $.toast({
                            heading: "Success",
                            text: "Verification Link Sent Successfully!",
                            showHideTransition: 'slide',
                            icon: 'success',
                            loaderBg: '#f96868',
                            position: 'top-right'
                            });
                        },
                        error: function(err){
                               $.toast({
                                heading: 'ERROR',
                                text: "Something went wrong",
                                showHideTransition: 'slide',
                                icon: 'error',
                                loaderBg: '#f2a654',
                                position: 'top-right'
                               });
                        }
                    })
                $('#verificationForm').submit();
            });
             $('.appeal').click(function(){
                $('#orderRequest').modal('show');
            });
             $('.raiseTicket').click(function(){
                $('#ticketRaiseModal').modal('show');
            });
             $('.barCodeModal').click(function(){
                html5QrcodeScanner.render(onScanSuccess);
                $('#barCodeModal').modal('show');
            });

            $(document).on('hide.bs.modal','#barCodeModal', function () {
                html5QrcodeScanner.clear();
            });


             $('#upload-Images').click(function(){
                $('#UploadImages').modal('show');
            });
             $('#requestCatalogue').click(function(){
                $('#searchbx').modal('show');
            });

            // $('#requestCustomer').each(function(index){
            //     // $('#requestForCatalogue').modal('show');
            //     $(this).on('click',function () {
            //         console.log("Ashish");
            //     })
            // });
            $('.acceptrequest').click(function(){
                $('#catalogueRequestAccept').modal('show');
            });
        });

        function requestCustomer() {
            $('#requestForCatalogue').modal ('show');
        }

        $("#makeoffer").click(function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var msg = "<input type='text' id='margin' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Name'> <br> <input type='text' id='offeremail' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Email (Optional)'> <br> <input type='number' maxlength='10' id='offerphone' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Phone (Optional)'>";

            $.confirm({
                draggable: true,
                title: 'Offer for',
                content: msg,
                type: 'blue',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: 'Next',
                        btnClass: 'btn-primary',

                        action: function(){
                                let margin = $('#margin').val();
                                let offeremail = $('#offeremail').val();
                                let offerphone = $('#offerphone').val();
                                if (!margin) {
                                    $.alert('provide a valid name');
                                    return false;
                                }
                                url = url+"&offerfor="+margin+"&offerphone="+offerphone+"&offeremail="+offeremail;
                                window.location.href = url;
                                // console.log(url);
                        }
                    },
                    close: function () {
                    }
                }
            });
        });
        // confirm




</script>

<script>


        $(document).ready(function(){

            $('#country').on('change', function() {
                getStates($(this).val());
            });

            $('#state').on('change', function() {
                getCities($(this).val());
            });

            $('#countryShop').on('change', function() {
                getStatesShop($(this).val());
            });

            $('#stateShop').on('change', function() {
                getCitiesShop($(this).val());
            });

            $('#countryEdit').on('change', function() {
                getEditStates($(this).val());
            });

            $('#stateEdit').on('change', function() {
                getEditCities($(this).val());
            });


            function updateURL(key,val){
                var url = window.location.href;
                var reExp = new RegExp("[\?|\&]"+key + "=[0-9a-zA-Z\_\+\-\|\.\,\;]*");

                if(reExp.test(url)) {
                    // update
                    var reExp = new RegExp("[\?&]" + key + "=([^&#]*)");
                    var delimiter = reExp.exec(url)[0].charAt(0);
                    url = url.replace(reExp, delimiter + key + "=" + val);
                } else {
                    // add
                    var newParam = key + "=" + val;
                    if(!url.indexOf('?')){url += '?';}

                    if(url.indexOf('#') > -1){
                        var urlparts = url.split('#');
                        url = urlparts[0] +  "&" + newParam +  (urlparts[1] ?  "#" +urlparts[1] : '');
                    } else {
                        url += "&" + newParam;
                    }
                }
                window.history.pushState(null, document.title, url);
            }

            $('.active-swicher').on('click', function() {
                var active = $(this).attr('data-active');
                updateURL('active',active);
            });
            $('.customer_tabs').on('click',function(){

                $('.customer_tabs').removeClass('active');
                $(this).addClass('active');
               var data = $(this).data('subactive');
               updateURL('subactive',data);
               $('.customer_card').hide();
               $('.card-'+data).show();
            });

            $('.refresh_btn').on('click', function() {
                location.reload(true);
            });

            $('#industry_id').select2();
            $(".select2insidemodal").select2({
                dropdownParent: $("#addAddressModal")
            });

            
            $(".currselect2insidemodal").select2({
                dropdownParent: $("#addcurrency")
            });

            $(".curreditselect2insidemodal").select2({
                dropdownParent: $("#updatecurrency")
            });

            $(".select2insidemodaledit").select2({
                dropdownParent: $("#editAddressModal")
            });

            $(".select2insidemodalTeam").select2({
                dropdownParent: $("#addTeam")
            });

            $("#countryShop").select2();
            $("#stateShop").select2();
            $("#cityShop").select2();

        });


       $(document).ready(function(){
        $('.customer_card').hide();

        @if(request()->get('subactive'))
            $('.card-'+"{{request()->get('subactive')}}").show();
        @else
            $('.card-my_info').show();
        @endif

       });


        $('.digit-group').find('.custom-input_box').each(function() {
            $(this).attr('maxlength', 1);
            $(this).on('keyup', function(e) {
                var parent = $($(this).parent());

                if(e.keyCode === 8 || e.keyCode === 37) {
                    var prev = parent.find('input#' + $(this).data('previous'));

                    if(prev.length) {
                        $(prev).select();
                    }
                } else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                    var next = parent.find('input#' + $(this).data('next'));

                    if(next.length) {
                        $(next).select();
                    } else {
                        if(parent.data('autosubmit')) {
                            parent.submit();
                        }
                    }
                }
            });
        });

        $('#addNumber').on('click',function(){
            $('#addAdditionalNumbers').modal('show');
        });


        // OTP Check
        $('#otpButtonteam').on('click',function(e){
            e.preventDefault();
            var number = $('#contact_number').val();
            $.ajax({
                url: "{{ route('panel.user.send-otp') }}",
                method: 'GET',
                data: {
                    phone_no: number
                },
                success: function(response) {
                    if(response.title == 'Error'){
                        $.toast({
                            heading: response.title,
                            text: response.message,
                            showHideTransition: 'slide',
                            icon: 'error',
                            loaderBg: '#f2a654',
                            position: 'top-right'
                        });
                    }else{
                        $.toast({
                            heading: response.title,
                            text: response.message,
                            showHideTransition: 'slide',
                            icon: 'success',
                            loaderBg: '#f96868',
                            position: 'top-right'
                        });
                    }
                    $('.otpaction1').removeClass('d-none');
                    $('.otpaction2').removeClass('d-none');
                    $('.additionalNumber').attr('readonly',true);1
                    $('#OTP').html(response.otp)
                }
            })
        });

        $('#verifyOTP').on('click',function(e){
            e.preventDefault();
            $('#saveBtn').attr('disabled',false);
            $('.check-icon').removeClass('d-none');
            $(this).addClass('d-none');
            var verifyOTP = $('#otpInput').val();
            $.ajax({
                url: "{{ route('panel.user.verify-otp') }}",
                method: 'GET',
                data: {
                    otp: verifyOTP
                },
                success: function(response) {
                    if(response.title == 'Error'){
                        $.toast({
                            heading: response.title,
                            text: response.message,
                            showHideTransition: 'slide',
                            icon: 'error',
                            loaderBg: '#f2a654',
                            position: 'top-right'
                        });
                    }else{
                        $.toast({
                            heading: response.title,
                            text: response.message,
                            showHideTransition: 'slide',
                            icon: 'success',
                            loaderBg: '#f96868',
                            position: 'top-right'
                        });
                    }
                }
            })
        })





        $('#saveBtn').on('click',function(e){
            e.preventDefault();
            var phone_number = $('.additionalNumber').val();
            $('#updateAdditionalNumber').append(`<input type='number' name='additional_phone' value=${phone_number} />`);
            $('#updateAdditionalNumber').submit();
        });

        $('#industry_id').next().css('pointer-events','none');
</script>

<script>
    var element = $("#html-content-holder"); // global variable
            var getCanvas; // global variable

            $("#download-qr").on('click', function () {
                html2canvas(document.getElementById("html-content-holder")).then(function (canvas) {
                    var anchorTag = document.createElement("a");
                    document.body.appendChild(anchorTag);
                    document.getElementById("previewImg").appendChild(canvas);
                    var user_mob = "{{auth()->user()->phone}}";
                    anchorTag.download = "ShopQR_C_{{Illuminate\Support\Str::slug($user_shop->slug)  }}_"+user_mob+'.jpg';
                    anchorTag.href = canvas.toDataURL();
                    anchorTag.target = '_blank';
                    anchorTag.click();
                });
            });


            // create Image URL
            window.onload = function () {
                html2canvas(document.getElementById("html-content-holder")).then(function (canvas) {
                    document.getElementById("previewImg").appendChild(canvas);
                    var imgurl  = canvas.toDataURL();
                    document.getElementById('qr').src = imgurl
                    document.getElementById('qr2').src = imgurl
                    document.getElementById('qr3').src = imgurl
                    document.getElementById('qr4').src = imgurl

                });
            }
</script>

<script>
     // OTP Check

     $('#otpButton').on('click',function(e){
                e.preventDefault();
                var number = $('.contact_number').val();
                $.ajax({
                    url: "{{ route('panel.user.send-otp') }}",
                    method: 'GET',
                    data: {
                        phone_no: number
                    },
                    success: function(response) {

                        $('.otpaction1').removeClass('d-none');
                        $('.otpaction2').removeClass('d-none');

                        if(response.title == 'Error'){
                            $.toast({
                                heading: response.title,
                                text: response.message,
                                showHideTransition: 'slide',
                                icon: 'error',
                                loaderBg: '#f2a654',
                                position: 'top-right'
                            });
                        }else{
                            $.toast({
                                heading: response.title,
                                text: response.message,
                                showHideTransition: 'slide',
                                icon: 'success',
                                loaderBg: '#f96868',
                                position: 'top-right'
                            });

                            // $('.additionalNumber').attr('readonly',true);
                            $('#OTP').html(response.otp)
                        }
                    }
                })
            });
            $('#verifyOTP').on('click',function(e){
                e.preventDefault();
                $('#saveBtn').attr('disabled',false);
                $('.check-icon').removeClass('d-none');
                $(this).addClass('d-none');
                var verifyOTP = $('#otpInput').val();
                $.ajax({
                    url: "{{ route('panel.user.verify-otp') }}",
                    method: 'GET',
                    data: {
                        otp: verifyOTP
                    },
                    success: function(response) {
                        if(response.title == 'Error'){
                            $.toast({
                                heading: response.title,
                                text: response.message,
                                showHideTransition: 'slide',
                                icon: 'error',
                                loaderBg: '#f2a654',
                                position: 'top-right'
                            });
                            $(".activebtn").addClass('d-none');
                        }else{
                            $.toast({
                                heading: "OTP Verified",
                                text: "OTP Authenticated",
                                showHideTransition: 'slide',
                                icon: 'success',
                                loaderBg: '#f96868',
                                position: 'top-right'
                            });
                            $(".activebtn").removeClass('d-none');
                        }
                    }
                })
            })
</script>
@endsection
