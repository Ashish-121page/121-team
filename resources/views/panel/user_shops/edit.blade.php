@extends('backend.layouts.main')
@section('title', 'Micro sites')
@section('content')
    @php
    /**
     * Micro sites
     *
     * @category  zStarter
     * @ref  zCURD
     * @author    GRPL
     * @license  121.page
     * @version  <GRPL 1.1.0>
     * @link        https://121.page/
     */
    $breadcrumb_arr = [['name' => 'Seller Profile', 'url' => 'javascript:void(0);', 'class' => '']];

    $user = App\User::whereId($user_shop->user_id)->first();

    if($user){
        $ekyc = json_decode($user->ekyc_info);
    }
    @endphp
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        {{--  --}}
        <style>
            .error {
                color: red;
            }
            .cross-btn{
                position: absolute !important;
                left: 96px !important;
            }
            .screen-shot-image{
                width:100%;
                height:100%;
            }
            #industry_id + .select2 .selection{
                pointer-events: none;
            }
            .sticky{
                position: sticky;
                top: 70px;
            }
            .remove-ik-class{
                -webkit-box-shadow: unset !important;
                box-shadow: unset !important;
            }

        </style>
    @endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-flex">
                            <h5>Seller Profile</h5>
                            @if(AuthRole() == 'User')
                                <span style="margin-top: -10px;">
                                    <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 mx-auto">
                <!-- start message area-->
                @include('backend.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-body">
                        <ul class="nav nav-pills custom-pills mb-3" id="pills-tab" role="tablist">
                            {{-- <li class="nav-item">
                                <a data-active="my-info" class="mr-2 active-swicher btn pills-btn text-white @if(request()->has('active') && request()->get('active') == "my-info") active  @endif" id="pills-my-info-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-my-info" aria-selected="false">{{ __('My Info')}}</a>
                            </li> --}}
                            @if(AuthRole() == 'Admin')

                                <li class="nav-item ">
                                    <a data-active="shop-details" class="mr-2 active-swicher btn btn-outline-primary @if(request()->has('active') && request()->get('active') == "shop-details") active  @endif" id="pills-general-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-general" aria-selected="false">{{ __('Account Info')}}</a>
                                </li>
                            @endif

                            @if(AuthRole() == 'User')

                                <li class="nav-item ">
                                    <a data-active="shop-details" class="mr-2 active-swicher btn btn-outline-primary @if(request()->has('active') && request()->get('active') == "shop-details") active  @endif" id="pills-general-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-general" aria-selected="false">{{ __('Account Info')}}</a>
                                </li>
                            @endif


                            {{-- <li class="nav-item ">
                                <a data-active="page-feature" class="mr-2 active-swicher  btn btn-outline-primary @if(request()->has('active') && request()->get('active') == "page-feature") active  @endif" id="pills-general-tab" data-toggle="pill" href="#page-feature" role="tab" aria-controls="pills-general" aria-selected="false">{{ __('My Page')}}</a>
                            </li> --}}

                            @if (AuthRole() == 'User')
                                <li class="nav-item">
                                    <a  data-active="business_profile" class="mr-2  active-swicher btn btn-outline-primary @if(request()->has('active') && request()->get('active') == "business_profile") active  @endif" id="pills-story-tab" data-toggle="pill" href="#user_shop_story" role="tab" aria-controls="pills-story" aria-selected="false">{{ __('E-KYC')}}</a>
                                </li>
                            @endif



                            <li class="nav-item ">
                                <a data-active="about-section" class="mr-2 active-swicher btn btn-outline-primary @if(request()->has('active') && request()->get('active') == "about-section") active  @endif" id="pills-general-tab" data-toggle="pill" href="#about-section" role="tab" aria-controls="pills-general" aria-selected="false">{{ __('Brief Intro')}}</a>
                            </li>


                            <li class="nav-item">
                                <a data-active="my-address" class="mr-2 active-swicher btn btn-outline-primary @if(request()->has('active') && request()->get('active') == "my-address") active  @endif" id="pills-my-address-tab" data-toggle="pill" href="#my-address-area" role="tab" aria-controls="pills-my-address" aria-selected="false">{{ __('Entities')}}</a>
                            </li>

                            <li class="nav-item ">
                                <a data-active="shop-passcodes" class="mr-2 active-swicher btn btn-outline-primary @if(request()->has('active') && request()->get('active') == "shop-passcodes") active  @endif" id="pills-settings2-tab" data-toggle="pill" href="#pills-settings2" role="tab" aria-controls="pills-settings2" aria-selected="false">{{ __('Passcodes')}}</a>
                            </li>



                            <li class="nav-item">
                                <a data-active="security" class="mr-2 active-swicher btn btn-outline-primary @if(request()->has('active') && request()->get('active') == "security") active  @endif" id="pills-features-tab" data-toggle="pill" href="#features" role="tab" aria-controls="pills-features" aria-selected="false">{{ __('Security')}}</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a data-active="team" class="mr-2 active-swicher btn pills-btn text-white @if(request()->has('active') && request()->get('active') == 'team') active  @endif" id="pills-team-tab" data-toggle="pill" href="#user-shop-team" role="tab" aria-controls="pills-team" aria-selected="false">{{ __('Team')}}</a>
                            </li>
                            <li class="nav-item">
                                <a  data-active="payment" class="mr-2 active-swicher btn pills-btn text-white @if(request()->has('active') && request()->get('active') == "payment") active  @endif" id="pills-payment-tab" data-toggle="pill" href="#payment" role="tab" aria-controls="pills-payment" aria-selected="false">{{ __('Payment Details')}}</a>
                            </li> --}}
                        </ul>


                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade @if(request()->has('active') && request()->get('active') == "shop-details") active show @endif" id="last-month" role="tabpanel" aria-labelledby="pills-general-tab">
                                <div class="row">
                                    <div class="col-lg-8">

                                        {{-- <form action="{{ route('panel.user_shops.update',$user_shop->id) }}" method="post" enctype="multipart/form-data" id="UserShopForm"> --}}
                                        <form action="{{ route('customer.profile.update',$user->id) }}" method="post" enctype="multipart/form-data" id="UserShopForm">
                                            <input type="hidden" name="status" value="1">
                                            @csrf
                                            {{-- <h6>Shop Details</h6> --}}
                                            {{-- <div>
                                                <div class="alert alert-info">
                                                    <p class="mb-0">This changes Shop QR & make earlier ones non-usable</p>
                                                </div>
                                            </div> --}}
                                            <div class="row mt-3">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                                        <label for="name" class="control-label">Business Name</label>
                                                        <input required class="form-control" name="name" type="text" id="name"
                                                            value="{{ $user->name }}" placeholder="Enter Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 ">
                                                    <div class="form-group">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                <label for="email">{{ __('Business Email')}}<span class="text-danger">*</span></label>
                                                            </div>
                                                        <div>
                                                        </div>
                                                        </div>

                                                        <input @if($user->email_verified_at != null) @endif type="email" placeholder="test@test.com" class="form-control" name="email" id="email" value="{{ $user->email }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 ">
                                                    <div class="form-group">
                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                <label for="phone_no">{{ __('Business Phone')}}<span class="text-danger">*</span></label>
                                                            </div>
                                                        <div>
                                                        </div>
                                                        </div>
                                                        <input @if($user->phone_no_verified_at != null) readonly @endif type="phone_no" placeholder="test@test.com" class="form-control" name="phone" id="phone_no" value="{{ $user->phone }}">
                                                    </div>
                                                </div>
                                                @if(AuthRole() == 'Admin')
                                                    <div class="col-md-12 ">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">vCards</label>
                                                            <input type="file" class="form-control" name="vcard">
                                                            @if(isset($vcard) && $vcard != null)
                                                                <img src="{{ asset($vcard->path) }}" class="mt-3 rounded" alt="vcard" style="height: 100px;">
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-12">
                                                    <div class="form-group mb-0 d-flex justify-content-center">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        @if(AuthRole() == 'Admin')
                                            <form action="{{ route('customer.update.settings') }}" method="post" class="my-4">
                                                @csrf
                                                <input type="hidden" name="type" value="setting1">
                                                <input type="hidden" name="user_shop" value="{{ $user_shop->id }}">
                                                <input type="hidden" name="slug" value="{{ $user_shop->slug }}">
                                                <div class="row mb-2">
                                                    <div class="col">
                                                        <label for="">Public Display</label> <br>
                                                        <input type="checkbox" @if($user_shop->shop_view == 1) checked @endif value="1" name="shop_view" class="js-single"/>
                                                    </div>
                                                    <div class="col">
                                                        <label for="auto_acr" title="Enable You A Feature That Auto Accepting Catelogue Request">Auto Accept Request</label> <br>
                                                        <input type="checkbox" @if($user_shop->auto_acr == 1) checked @endif value="1" name="auto_acr" id="auto_acr" class="js-acr"/>
                                                    </div>
                                                    @php
                                                        $teamdata = json_decode($user_shop->team);
                                                        $teamdata->team_visiblity = $teamdata->team_visiblity ?? 0;
                                                    @endphp

                                                    <div class="col">
                                                        <label for="public_about" title="Enable You A Feature That Auto Accepting Catelogue Request py-2">Public Team</label> <br>
                                                        <input type="checkbox" @if (isset($teamdata) && $teamdata != null && $teamdata->team_visiblity) checked @endif value="1" name="public_about" id="public_about" class="js-about"/>
                                                    </div>
                                                </div>
                                                <div class="mt-4 d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>

                                            {{-- Additional Phone Number --}}
                                            <form action="{{ route('panel.update-user-profile', $user->id) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                                                @csrf
                                                {{-- <input type="hidden" name="additional_number[]" value=""> --}}
                                                {{-- <h6>My Info</h6> --}}
                                                <div class="row mt-3">
                                                    <div class="col-md-6 d-none">
                                                        <div class="form-group">
                                                            <label for="name">{{ __('Name')}}<span class="text-red">*</span></label>
                                                            <input type="text" placeholder="Enter Name" class="form-control" name="name" id="name" value="{{ $user->name }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 d-none">
                                                        <div class="form-group">
                                                            <div class="d-flex">
                                                                <label for="email">{{ __('Email')}}<span class="text-red">*</span>
                                                                </label>
                                                                @if($user->email_verified_at == null )
                                                                    <a class="btn btn-sm text-secondary ml-auto" style="line-height: 3px;" href="{{route('verification.resend')}}">Verify Email</a>
                                                                @endif
                                                            </div>
                                                            <input @if($user->email_verified_at != null) readonly @endif type="email" placeholder="test@test.com" class="form-control" name="email" id="email" value="{{ $user->email }}">
                                                        </div>
                                                    </div>

                                                    {{-- Additioal Phone Fields --}}
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="phone">{{ __('Phone No')}}<span class="text-red">*</span> <span><i class="ik ik-info" title="Request catalogs are processed using this number"></i></span></label>
                                                            <div class="d-flex">
                                                                <input type="number" placeholder="enter Phone number" id="phone" name="phone" readonly class="form-control w-75" value="{{ $user->phone }}" required >
                                                                @if(AuthRole() != 'Admin')
                                                                    <button type="button" data-toggle="modal" data-target="#addAdditionalNumbers" class="btn btn-icon btn-primary ml-2"><i class="ik ik-plus"></i></button>
                                                                @endif
                                                            </div>
                                                            @if(AuthRole() == 'Admin')
                                                                <textarea name="phone[]" id="" cols="30" rows="10" class="form-control mt-2 additionalNumbers" placeholder="Enter Mobile Number" ></textarea>
                                                                <p class="text-danger mt-1">Enter Number then use comma seperater Ex:3215478960,3215478962</p>
                                                                <button data-user_id="{{$user_shop->user_id}}" class="btn btn-primary mt-1" id="save_additional_number">Save Additional Numbers</button>
                                                            @endif
                                                        </div>
                                                        @if($user->additional_numbers != "null")
                                                            @if(!is_null($user->additional_numbers) && $user->additional_numbers != '""')
                                                                <ul class="list-unstyled">
                                                                    @foreach (json_decode($user->additional_numbers) as $number)
                                                                        {{-- @if($number != '"' && $number != null) --}}
                                                                            <li>
                                                                                <i class="ik ik-check text-success"></i>
                                                                                {{$number}}
                                                                                @if ($number != '')
                                                                                    <a href="{{ route('panel.user.number.delete',[$user->id,$number]) }}" class="confirm-btn">
                                                                                        <i class="ml-5 ik ik-trash text-danger"></i>
                                                                                    </a>
                                                                                @endif

                                                                            </li>
                                                                        {{-- @endif --}}
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        @endif
                                                    </div>

                                                    @if (AuthRole() == 'Admin')
                                                        <div class="col-md-6">
                                                            @php
                                                                $data = App\Models\survey::where('user_id',$user_shop->user_id)->first();
                                                            @endphp
                                                            @if ($data != null)
                                                                <div class="h6">Survey Response</div>
                                                                <span><b>{{ json_decode($data->question) }}</b></span>
                                                                <br><br>
                                                                <p>
                                                                    @forelse (json_decode($data->response) ?? [] as $item)
                                                                        {{ $loop->iteration.". ". $item }} <br>
                                                                    @empty
                                                                        Didn't Filled Yet.
                                                                    @endforelse
                                                                </p>
                                                            @endif
                                                        </div>
                                                    @endif




                                                    <div class="col-md-6 d-none">
                                                        @php
                                                            $industry = json_decode($user->industry_id,true);
                                                        @endphp
                                                        <div class="form-group">
                                                            <label for="phone">{{ __('Industry')}}<span class="text-red">*</span></label>
                                                            <select aria-readonly="true" @if(UserRole($user->id)['name'] == "User") required @endif name="industry_id[]" class="form-control select2" multiple id="industry_id">
                                                                @foreach(App\Models\Category::where('category_type_id',13)->get() as $category)
                                                                    <option value="{{ $category->id }}" @if(isset($industry)) {{ in_array($category->id,$industry) ? 'selected' :'' }} @endif> {{ $category->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 d-none">
                                                        <div class="form-group">
                                                            <label for="dob">{{ __('DOB')}}<span class="text-red">*</span></label>
                                                            <input id="" class="form-control" type="date" name="dob" placeholder="Select your birth date" value="{{ $user->dob }}" />
                                                            <div class="help-block with-errors"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group d-none">
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



                                                    <div class="col-md-12 d-none">
                                                        <div class="form-group">
                                                            <label for="address">{{ __('Address')}}<span class="text-red">*</span></label>
                                                            <textarea name="address" name="address" rows="5" class="form-control" placeholder="Enter Address">{{ $user->address }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center">
                                                    {{-- <button type="submit" class="btn btn-primary">Update</button> --}}
                                                </div>
                                            </form>

                                        @endif


                                    </div>
                                     {{-- <div class="col-lg-4">
                                        <div class="sticky">
                                            <img src="{{ asset('frontend/assets/img/shop/screenshot.png') }}" alt="screenshot-img" class="screen-shot-image">
                                        </div>
                                    </div> --}}
                                </div>
                            </div>



                            {{-- New Pill 1 By Ashish --}}

                            <div class="tab-pane fade @if(request()->has('active') && request()->get('active') == "about-section") active show @endif" id="about-section" role="tabpanel" aria-labelledby="pills-general-tab">
                                <div class="row">
                                    <div class="col-lg-8">
                                        {{-- <h6 class="my-3">About Section</h6>
                                        <form action="{{ route('panel.user_shops.about',$user_shop->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @php
                                                $about = json_decode($user_shop->about,true);
                                            @endphp
                                            <div class="row d-none">
                                                <div class="col-md-6 col-12 d-none">
                                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                                        <label for="name" class="control-label">Title</label>
                                                        <input required class="form-control" name="title" type="text" id="name"
                                                            value="{{ $about['title'] ?? '' }}" placeholder="Enter Title" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group {{ $errors->has('img') ? 'has-error' : '' }}">
                                                        <label for="name" class="control-label">Image</label>
                                                        <input class="form-control" name="img" type="file"
                                                            value="{{ $about['img'] ?? '' }}">
                                                        @if(isset($about) && isset($about['img']))
                                                            <div>
                                                                <img src="{{ asset($about['img']) }}" alt="" style="height: 100px;">
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group {{ $errors->has('img') ? 'has-error' : '' }}">
                                                        <textarea name="content" id="" cols="30" rows="5" class="form-control">{{ $about['content'] ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </form> --}}

                                        {{-- brief_induction --}}
                                        @if(AuthRole() == 'Admin')
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
                                        @endif

                                        {{-- Testimonial Form --}}
                                        <h6 class="my-3 d-none">Testimonials Section</h6>
                                        <form action="{{ route('panel.user_shops.testimonial') }}" method="post" class="d-none" enctype="multipart/form-data">
                                            @csrf

                                            <input type="hidden" name="user_shop_id" value="{{ $user_shop->id }}">
                                            <div class="row mt-3">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">

                                                            <label for="title" class="control-label">Title</label>


                                                        <input class="form-control" name="title" type="text" id="title"
                                                            value="{{ $testimonial['title'] ?? '' }}" required placeholder="Enter Title">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                                        <label for="description" class="control-label">Description</label>
                                                        <textarea class="form-control" name="description" type="text" id="description" placeholder="Enter Description"
                                                            value="">{{ $testimonial['description'] ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mx-auto">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <a href="{{ inject_subdomain('home', $user_shop->slug)}}#testimonial" target="_blank" class="btn btn-outline-primary">Preview</a>
                                                    </div>
                                                </div>
                                                <div class="col-md-12"><hr></div>

                                                <div class="col-md-12">
                                                    <div class="d-flex justify-content-between my-3">
                                                        <h6>Testimonials</h6>
                                                        <a href="{{ route('panel.user_shop_testimonals.create') }}{{ '?shop_id='.$user_shop->id }}" class="mb-2 btn btn-icon btn-sm btn-outline-primary" title="Add New User Shop Testimonal"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                    </div>
                                                        @php
                                                            $items = App\Models\UserShopTestimonal::whereUserShopId($user_shop->id)->paginate(4)
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
                                                                                        <p>
                                                                                            @for ($i = 1; $i < $item->rating; $i++)
                                                                                                <i class="fa fa-star text-warning"></i>
                                                                                            @endfor
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="col-2 pl-2">
                                                                                        <button style="background: transparent;margin-left: -12px;" class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                                                            <a href="{{ route('panel.user_shop_testimonals.edit', $item->id) }}{{ '?shop_id='.$user_shop->id }}" title="Edit Testimonial"
                                                                                                class="dropdown-item ">
                                                                                                <li class="p-0">Edit</li>
                                                                                            </a>
                                                                                            <a href="{{ route('panel.user_shop_testimonals.destroy', $item->id) }}" title="Delete Testimonial"
                                                                                                class="dropdown-item  delete-item">
                                                                                                <li class=" p-0">Delete</li>
                                                                                            </a>
                                                                                        </ul>
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
                                                            {{ $items->links() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        {{-- Team Form --}}
                                        {{-- <hr> --}}
                                        <h6 class="mt-3">Team Section</h6>
                                        <form action="{{ route('panel.teams.user-shops.update') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="user_shop_id" id="" value="{{ $user_shop->id }}">
                                                <div class="row mt-3">
                                                    <div class="col-md-12 col-12">
                                                        {{-- <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                                            <label for="title" class="control-label">Title</label>
                                                            <input class="form-control" placeholder="Enter Title" name="title" required type="text" id="title" value="{{ $team['title'] ?? '' }}">
                                                        </div> --}}
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        {{-- <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                                            <label for="description" class="control-label">Description</label>
                                                            <textarea class="form-control" placeholder="Enter Descriptoin" name="description" type="text" id="description"
                                                                value="">{{ $team['description'] ?? '' }}</textarea>
                                                        </div> --}}
                                                    </div>
                                                    {{-- <div class="col-md-12">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                            <a href="{{ inject_subdomain('about-us', $user_shop->slug)}}#team" class="btn btn-outline-primary" target="_blank">Preview</a>
                                                        </div>
                                                    </div>  --}}
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-12"><hr></div>
                                                    <div class="col-md-12">
                                                        <div class="d-flex justify-content-between my-3">
                                                            <h6>Team Members</h6>
                                                            <a href="{{ route('panel.teams.create') }}{{ '?shop_id='.$user_shop->id }}" class="mb-2 btn btn-icon btn-sm btn-outline-primary" title="Add New Team Member"><i class="fa fa-plus" aria-hidden="true"></i></a>
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
                                                                                            <button style="background: transparent;margin-left: -12px;" class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                                                            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                                                                <a href="{{ route('panel.teams.edit', $item->id) }}{{ '?shop_id='.$user_shop->id }}" title="Edit Brand"
                                                                                                    class="dropdown-item ">
                                                                                                    <li class="p-0">Edit</li>
                                                                                                </a>
                                                                                                <a href="{{ route('panel.teams.destroy', $item->id) }}" title="Delete Brand"
                                                                                                    class="dropdown-item  delete-item">
                                                                                                    <li class=" p-0">Delete</li>
                                                                                                </a>
                                                                                            </ul>
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
                                     {{-- <div class="col-lg-4">
                                        <div class="sticky">
                                            <img src="{{ asset('frontend/assets/img/shop/screenshot.png') }}" alt="screenshot-img" class="screen-shot-image">
                                        </div>
                                    </div> --}}
                                </div>
                            </div>

                            {{-- New Pill 2 By Ashish --}}
                            <div class="tab-pane fade @if(request()->has('active') && request()->get('active') == "page-feature") active show @endif" id="page-feature" role="tabpanel" aria-labelledby="pills-general-tab">
                                <div class="row d-none">
                                    <div class="col-lg-8">
                                       <h6 class="my-3">Page Features</h6>
                                        {{-- <form action="{{ route('panel.user_shops.contact',$user_shop->id) }}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group">
                                                        <label for="embedded_code" class="control-label">Map Embedded Code</label>
                                                        <textarea class="form-control" name="embedded_code" id="embedded_code"
                                                            placeholder="Enter Embedded Code URL Only">{{ $user_shop->embedded_code }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12">
                                                    <div class="alert alert-danger fade show d-flex justify-content-between" role="alert">
                                                        <p>Don't know how to generate embed code? Follow the 121 guide on how to do it.</p>
                                                        <a href="https://youtu.be/R7m0e-7JCQk" target="_blank" class="btn btn-outline-danger">How to</a>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </form> --}}

                                        {{-- Meta Info --}}
                                        <form action="{{ route('panel.user_shops.other_fields.update',$user_shop->id) }}" method="post" enctype="multipart/form-data" id="UserShopForm">
                                            @csrf
                                            <div class="row">
                                                @php
                                                    $contact_info = json_decode($user_shop->contact_info)
                                                @endphp
                                                {{-- Display None Fields --}}
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                                        <label for="name" class="control-label">Display Name</label>
                                                        <small title="Shown to other business users when sending you connection request"><i class="uil-info-circle"></i></small>
                                                        <input class="form-control" name="name" type="text" id="name"
                                                            value="{{ $user_shop->name }}" placeholder="Enter Name">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12 ">
                                                    <div class="form-group">
                                                        <label for="email">Email Us</label>
                                                        <input class="form-control" type="email" name="email" value="{{ $contact_info->email ?? ' ' }}" placeholder="Enter Email">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group ">
                                                        <label for="phone">Call on Phone</label>
                                                        <input class="form-control" type="number" name="phone" value="{{ $contact_info->phone ?? ' ' }}" placeholder="Enter Phone No">
                                                    </div>
                                                </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                                                        <label for="name" class="control-label">Page Finder</label>

                                                        <input required class="form-control" name="slug" type="text" id="txtName"
                                                            value="{{ $user_shop->slug }}" placeholder="Enter Slug" @if (authrole() != 'Admin') readonly @endif >
                                                            <span class="text-danger" id="lblError"></span>

                                                    </div>
                                                </div>

                                                <div class="col-md-12 col-12 ">
                                                    <div class="form-group">
                                                        <label for="whatsapp">Whatsapp Phone</label>
                                                        <div class="input-group mb-1">
                                                            <span class="input-group-prepend">
                                                                <label class="input-group-text">https://wa.me</label>
                                                            </span>
                                                            <input type="text" class="form-control" type="url" name="whatsapp" value="{{ $contact_info->whatsapp ?? ' ' }}" placeholder="Enter Whatsapp Url">
                                                        </div>
                                                        <span class="text-dark">Number shouldn't contain '+' or country code
                                                        </span>
                                                    </div>
                                                </div>



                                                <div class="col-md-6 col-12">
                                                    <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
                                                        <label for="logo" class="control-label">Upload Business Logo</label>
                                                        <input class="form-control" name="logo_file" type="file" id="logo">
                                                        <span class="text-danger">Ideal Dimensions 147*50</span><br>
                                                        @if ($user_shop->logo !=null)
                                                            <img id="logo_file" src="{{ asset($user_shop->logo) }}" class="mt-2" style="border-radius: 10px;width:100px;height:80px;" />
                                                            <a class="btn btn-icon btn-primary cross-btn delete-item" href="{{route('panel.user_shops.remove-shop-image',[$user_shop->id,'type' => 'logo_file'])}}"><i class="fa fa-times"></i></a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group {{ $errors->has('img') ? 'has-error' : '' }}">
                                                        <label for="img" class="control-label">Upload Banner Image</label>
                                                        <input class="form-control" name="img" type="file" id="banner">
                                                        <span class="text-danger">Ideal Dimensions 1519*370</span><br>
                                                        @if ($media != null)
                                                            <img id="img" src="{{ asset($media->path) }}" class="mt-2"
                                                            style="border-radius: 10px;width:100px;height:80px;" />
                                                            <a class="btn btn-icon btn-primary cross-btn delete-item" href="{{route('panel.user_shops.remove-shop-image',[$user_shop->id,'type' => 'img'])}}"><i class="fa fa-times"></i></a>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    @php
                                                        $social = json_decode($user_shop->social_links);
                                                    @endphp
                                                    <h6>Social Links:</h6>
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <label class="input-group-text"><i class="ik ik-facebook"></i></label>
                                                        </span>
                                                        <input type="url" name="social_link[fb_link]" class="form-control" value="{{ @$social->fb_link }}" >
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <label class="input-group-text"><i class="ik ik-linkedin"></i></label>
                                                        </span>
                                                        <input type="url" name="social_link[in_link]" class="form-control" value="{{ @$social->in_link }}" >
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <label class="input-group-text"><i class="ik ik-twitter"></i></label>
                                                        </span>
                                                        <input type="url" name="social_link[tw_link]" class="form-control" value="{{ @$social->tw_link }}" >
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <label class="input-group-text"><i class="ik ik-youtube"></i></label>
                                                        </span>
                                                        <input type="url" name="social_link[yt_link]" class="form-control" value="{{ @$social->yt_link }}" >
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <label class="input-group-text"><i class="ik ik-instagram"></i></label>
                                                        </span>
                                                        <input type="url" name="social_link[insta_link]" class="form-control" value="{{ @$social->insta_link }}" >
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-prepend">
                                                            <label class="input-group-text"><i class="fab fa-pinterest-p fea icon-sm icons my-2"></i></label>
                                                        </span>
                                                        <input type="url" name="social_link[pint_link]" class="form-control" value="{{ @$social->pint_link }}" >
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>

                                        </form>



                                    </div>
                                     {{-- <div class="col-lg-4">
                                        <div class="sticky">
                                            <img src="{{ asset('frontend/assets/img/shop/screenshot.png') }}" alt="screenshot-img" class="screen-shot-image">
                                        </div>
                                    </div> --}}
                                </div>
                            </div>

                            {{-- New Pill 3 By Ashish --}}
                            <div class="tab-pane fade @if(request()->has('active') && request()->get('active') == "shop-passcodes") active show @endif" id="pills-settings2" role="tabpanel" aria-labelledby="pills-general-tab">
                                <div class="row">
                                    <div class="col-12">
                                        @php
                                            $extra_pass = json_decode($user->extra_passcode) ?? "";
                                        @endphp

                                        <form action="{{ route('customer.update.settings') }}" method="POST" class="form-horizontal">
                                            @csrf
                                            <input type="hidden" name="type" value="setting2">
                                            <input type="hidden" name="user_shop" value="{{ $user_shop->id }}">
                                            <div class="row mb-3 align-items-end">
                                                <div class="col-md-6 col-12 mt-3">
                                                    <div class="form-group">
                                                        <label for="exclsive_pass" class="control-label">{{ __('Exclusive Products')}}<span class="text-danger">*</span></label>
                                                        <input type="tel" maxlength="4" minlength="4" placeholder="Enter Exclusive Passcode" class="form-control" name="exclsive_pass" id="exclsive_pass" value="{{ $user->exclusive_pass }}" required>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-md-6 col-12 mt-3 d-none">
                                                    <div class="form-group">
                                                        <label for="offers_passcode" class="control-label">{{ __('Default offers passcode')}}<span class="text-danger">*</span></label>
                                                        <input type="tel" maxlength="4" minlength="4" placeholder="Enter Offers Passcode" class="form-control" name="offers_passcode" id="offers_passcode" value="@if (isset($extra_pass) && $extra_pass!= "" ){{ $extra_pass->offers_passcode ?? '' }}@endif">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12 mt-3">
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
                                            <button type="submit" class="btn btn-success mt-3"> Update Code</button>
                                        </form>
                                    </div>
                                </div>
                            </div>








                            <!---<div class="tab-pane fade @if(request()->has('active') && request()->get('active') == 'my-info') show active @endif" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                                <div class="row">
                                    @if($user)
                                        <div class="col-lg-8">

                                            <form action="{{ route('panel.user_shops.story',$user_shop->id) }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <h6 class="my-3">About Section</h6>
                                                <div class="row mt-3">
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                                            <label for="title" class="control-label">Title</label>
                                                            <input class="form-control" name="title" type="text" id="title"
                                                                value="{{ $story['title'] ?? '' }}" placeholder="Enter Title">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group {{ $errors->has('cta_link') ? 'has-error' : '' }}">
                                                            <label for="cta_link" class="control-label">Button Link</label>
                                                            <input class="form-control" name="cta_link" type="link" id="cta_link"
                                                                value="{{ $story['cta_link'] ?? '' }}" placeholder="Enter Button Link">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group {{ $errors->has('cta_label') ? 'has-error' : '' }}">
                                                            <label for="label" class="control-label">Buttton Label</label>
                                                            <input class="form-control" name="cta_label" type="text" id="cta_label"
                                                                value="{{ $story['cta_label'] ?? ''}}" placeholder="Enter Buttton Label">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group {{ $errors->has('video_link') ? 'has-error' : '' }}">
                                                            <label for="label" class="control-label">Video Link</label>
                                                            <input class="form-control" name="video_link" type="url" id="video_link"
                                                                value="{{ $story['video_link'] ?? '' }}" placeholder="Enter Video Link">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group {{ $errors->has('img') ? 'has-error' : '' }}">
                                                            <label for="img" class="control-label">Image</label>
                                                            <input class="form-control" name="img" type="file" id="img"
                                                                value="">
                                                                @if(isset($story['img']) && $story['img'] != null)
                                                                    <img src="{{ asset($story['img']) }}" class="mt-1" alt="img" style="width: 40%; height: 80px; object-fit: contain;">
                                                                @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                                            <label for="description" class="control-label">Description</label>
                                                            <textarea class="form-control" name="description" type="text" id="description" placeholder="Enter Description"
                                                                value="">{{ $story['description'] ?? '' }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mx-auto">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                            <a href="{{ inject_subdomain('about-us', $user_shop->slug)}}#story" target="_blank" class="btn btn-outline-primary">Preview</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    @else
                                        <p class="p-5 m-2 text-center">
                                            This shop is not connected with any user account.
                                        </p>
                                    @endif
                                    <div class="col-lg-4">
                                        <div class="sticky">
                                            <img src="{{ asset('frontend/assets/img/shop/screenshot.png') }}" alt="" class="screen-shot-image">
                                        </div>
                                    </div>
                                </div>
                            </div>--->










                            <div class="tab-pane fade @if(request()->has('active') && request()->get('active') == 'my-address') show active @endif" id="my-address-area" role="tabpanel" aria-labelledby="pills-setting-tab">

                                <div class="row">
                                    <div class="col-lg-12">
                                        {{-- <h6>Site Address</h6>
                                        <form action="{{ route('panel.user_shops.address.update', $user_shop->id) }}" method="post" id="UserShopForm" class="row">
                                            @csrf
                                            <input type="hidden" name="status" value="1">
                                            <input type="hidden" value="{{ $user_shop->user_id  }}" required name="user_id" id="user_id">

                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="flat_number">Flat/Office Number</label>
                                                    <input type="number" class="form-control" name="address[flat_number]" value="{{ $shop_address['flat_number'] ?? old('flat_number') }}" placeholder="Enter Flat/Office Number">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="floor">Floor</label>
                                                    <input type="text" class="form-control" name="address[floor]" placeholder="Enter Floor" value="{{ $shop_address['floor'] ?? old('floor') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="building_name">Building Name / Line 2</label>
                                                    <input type="text" class="form-control" name="address[building_name]" placeholder="Enter Building Name / Line 2" value="{{ $shop_address['building_name'] ?? old('building_name') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 ">
                                                <div class="form-group">
                                                    <label for="line_3_address">Line 3 of address</label>
                                                    <input type="text" class="form-control" name="address[line_3_address]" placeholder="Line 3 of address" value="{{ $shop_address['line_3_address'] ?? old('line_3_address') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="location">Landmark, if any</label>
                                                    <input type="text" class="form-control" name="address[location]" value="{{ $contact_info->location ?? ' ' }}" placeholder="Landmark, if any" >
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="country">Country</label>
                                                    <select name="address[country]" id="country" class="form-control select2">
                                                        <option aria-readonly="true" value="">Select Country</option>
                                                        @foreach (\App\Models\Country::all() as $country)
                                                            <option value="{{ $country->id }}"
                                                                @if(isset($shop_address['country'])&& $shop_address['country'] == $country->id) selected @endif>
                                                                {{ $country->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="">State</label>
                                                    <select id="state" name="address[state]" class="form-control select2">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-12">
                                                <div class="form-group">
                                                    <label for="city">City</label>
                                                    <select id="city" name="address[city]" class="form-control select2 city">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form> --}}
                                        <hr>
                                        <div class="d-flex justify-content-between my-3">
                                            <h6 class="mt-1">Entities</h6>
                                            <a href="javascript:void(0);" class="btn btn-primary addAddress" data-id="{{ auth()->id() }}">Add Entity</a>
                                        </div>

                                        <div class="row">
                                            @forelse ($addresses as $address)
                                                @php
                                                    $address_decoded = json_decode($address->details,true) ?? '';


                                                    // magicstring($account_decoded);
                                                    // return;
                                                @endphp
                                                <div class="col-lg-4 col-md-4 mb-3 pl-0 custom-height">
                                                    <div class="m-1 p-2 border rounded" style="max-height: 439px;">
                                                        <div class="mb-2">
                                                              <div class="d-flex align-items-center justify-content-between" style="background-color: #f3f3f3">
                                                                {{-- <h6 class="m-0 p-0">{{ $address->type == 0 ? "Billing" : "Site" }} Address:</h6> --}}
                                                                <h6>
                                                                    {{ substr($address_decoded['acronym'] ?? $address_decoded['entity_name'], 0, 12) . (strlen($address_decoded['acronym'] ?? $address_decoded['entity_name']) > 12 ? '..' : '') }}
                                                                </h6>
                                                                <div class="" style="width:20%;">
                                                                    {{-- <p class="text-muted mb-1"> --}}
                                                                        @if($address->type == 1)
                                                                            Site
                                                                        @else
                                                                            Entity
                                                                        @endif
                                                                    {{-- </p> --}}
                                                                    <a href="javascript:void(0)"  style="margin-left: 15px;" class="text-primary editAddress mb-0" title="Edit Address" data-id="{{ $address }}" data-original-title="Edit" ><i class="ik ik-edit"></i></a>
                                                                    {{-- <a href="{{ route('customer.address.delete',$address->id) }}" class="text-primary delete-item mb-0" title=""data-original-title="delete" ><i class="ik ik-trash"></i></a> --}}
                                                                </div>
                                                              </div>
                                                        </div>
                                                        <div class="pt-1 border-top">
                                                            <div class="d-flex align-items-center justify-content-between" style="max-height: 200px; height:200px;">
                                                                <div>


                                                                    <p class="text-muted mb-1">
                                                                        {{ $address_decoded['entity_name'] }} <br>
                                                                        {{ $address_decoded['gst_number'] }} <br>
                                                                        {{ $address_decoded['iec_number' ] ?? '' }} <br>
                                                                        {{ $address_decoded['acronym' ] ?? '' }} <br>
                                                                    </p>

                                                                    <p class="text-muted mb-1">{{ $address_decoded['address_1'] }}</p>
                                                                    <p class="text-muted mb-1">{{ $address_decoded['address_2'] }}</p>
                                                                    <p class="text-muted mb-1">
                                                                        {{ CountryById($address_decoded['country']) }},
                                                                        {{ StateById( $address_decoded['state']) }},
                                                                        {{ CityById( $address_decoded['city']) }}
                                                                    </p>
                                                                    <p class="text-muted">{{ $address_decoded['pincode'] ?? '' }}</p>


                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12" style="max-height: 200px; height:200px;">
                                                                <div class="col-lg-12 col-md-12" style="padding: 0;">
                                                                    <div class="d-flex align-items-center justify-content-center" style="background-color:#f3f3f3; padding: 5px;">
                                                                        Bank Accounts
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    @forelse ((array) json_decode($address->account_details) as $acc)
                                                                        @if($loop->index < 6)
                                                                            <div class="col-lg-6 mb-1" >
                                                                                <p class="text-muted">
                                                                                    {{ $acc->bank_name ?? '' }} ...
                                                                                    {{ substr($acc->account_number, -5) }}
                                                                                </p>
                                                                            </div>
                                                                        @endif
                                                                    @empty
                                                                        <div class="col-lg-12 justify-content-between">
                                                                            <p class="text-muted mb-1">No bank accounts found.</p>
                                                                        </div>
                                                                    @endforelse
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center mx-auto">
                                                    <p>No Addresses yet!</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>

                                     {{-- <div class="col-lg-4">
                                        <div class="sticky">
                                            <img src="{{ asset('frontend/assets/img/shop/screenshot.png') }}" alt="" class="screen-shot-image">
                                        </div>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="tab-pane fade @if(request()->has('active') && request()->get('active') == "about") active show @endif" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form action="{{ route('panel.user_shops.about',$user_shop->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                            <div class="row mt-3">
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                                        <label for="title" class="control-label">Title</label>
                                                        <input required class="form-control" name="title" type="text" id="title"
                                                            value="{{ $about['title'] ?? '' }}" placeholder="Enter Title">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group {{ $errors->has('img') ? 'has-error' : '' }}">
                                                        <label for="img" class="control-label">Image</label>
                                                        <input class="form-control" name="img" type="file" id="img"
                                                            value="">
                                                            @if(isset($about['img']) && $about['img'] != null)
                                                                <img src="{{ asset($about['img']) }}" class="mt-1" alt="img" style="width: 40%; height: 80px; object-fit: contain;">
                                                            @endif
                                                    </div>
                                                </div>


                                                {{-- <div class="col-md-12 col-12">
                                                    <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                                                        <label for="content" class="control-label">Content</label>
                                                        <textarea class="form-control" name="content" type="text" id="content" placeholder="Enter Content"
                                                            value="">{{ $about['content'] ?? '' }}</textarea>
                                                    </div>
                                                </div> --}}

                                                 <div class="col-md-12 col-12">
                                                    <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                                                        {{-- <label for="content" class="control-label">Content</label> --}}
                                                        <textarea class="form-control" name="content" type="text" id="content" placeholder="Enter Content"
                                                            value="">{{ $about['content'] ?? '' }}</textarea>
                                                    </div>
                                                </div>


                                                <div class="col-md-12 mx-auto">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <a href="{{ inject_subdomain('home', $user_shop->slug)}}#about" target="_blank" class="btn btn-outline-primary">Preview</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                    {{-- <div class="col-lg-4">
                                        <div class="sticky">
                                            <img src="{{ asset('frontend/assets/img/shop/screenshot.png') }}" alt="" class="screen-shot-image">
                                        </div>
                                    </div> --}}
                                </div>

                            </div>
                            <div class="tab-pane fade @if(request()->has('active') && request()->get('active') == "business_profile") active show @endif"  id="user_shop_story" role="tabpanel" aria-labelledby="pills-story-tab">
                                <div class="row">
                                    <div class="col-lg-8">
                                        {{-- About Form --}}
                                        <h6>e-KYC Section</h6>
                                        @if($user)
                                            <form action="{{ route('panel.update-ekyc-status', $user->id) }}" method="POST" class="form-horizontal">
                                                @if($user->ekyc_status == 0)
                                                   <div class="alert alert-info">
                                                       eKyc Request isn't submitted yet!
                                                   </div>
                                                @elseif($user->ekyc_status == 1)
                                                   <div class="alert alert-success">
                                                       User eKYC Request has been verified!
                                                   </div>
                                                @elseif($user->ekyc_status == 2)
                                                   <div class="alert alert-danger">
                                                       User eKyc Request has been rejected!
                                                   </div>
                                                @elseif($user->ekyc_status == 3)
                                                  <div class="alert alert-warning">
                                                       User submitted eKYC Request, Please validate and take appropriate action.
                                                   </div>
                                                @endif
                                               @csrf
                                               <input id="status" type="hidden" name="status" value="">
                                               <input type="hidden" name="user_id" value="{{ $user->id }}">
                                               @if($user->ekyc_status != null)
                                                   <div class="row">
                                                       <div class="col-md-6 col-6"> <label>{{ __('Document Type')}}</label>
                                                           <br>
                                                           <h5 class="strong text-muted">{{ $ekyc->document_type ?? '' }}</h5>
                                                       </div>
                                                       <div class="col-md-6 col-6"> <label>{{ __('Document Number')}}</label>
                                                           <br>
                                                           <h5 class="strong text-muted">{{ $ekyc->document_number  ?? ''}}</h5>
                                                       </div>
                                                       <div class="col-md-6 col-6"> <label>{{ __('Document Front Image')}}</label>
                                                           <br>
                                                               @if ($ekyc != null && $ekyc->document_front != null)
                                                               <a href="{{ asset($ekyc->document_front) }}" target="_blank" class="badge badge-info">View Attachment</a>
                                                               @endif
                                                       </div>
                                                       <div class="col-md-6 col-6"> <label>{{ __('Document Back Image')}}</label>
                                                           <br>
                                                           @if ($ekyc != null && $ekyc->document_back != null)
                                                               @if ($ekyc != null && $ekyc->document_back != null)
                                                                   <a href="{{ asset($ekyc->document_back) }}" target="_blank" class="badge badge-info">View Attachment</a>
                                                               @endif
                                                           @endif
                                                       </div>
                                                       @if(AuthRole() == 'Admin')
                                                       <div class="col-md-12 col-12 mt-3">
                                                            <label for="last_site" class="form-label">Existing Site</label>
                                                            <input type="text" placeholder="Existing Site" class="form-control" value="{{ $ekyc->last_site  ?? ''}}" readonly>
                                                        </div>


                                                    <div class="col-md-12 col-12 mt-3">
                                                        <label for="last_site" class="form-label">Applying For Account</label>
                                                        {{-- <input type="text" placeholder="Account Type" class="form-control" value="{{ $ekyc->account_type  ?? ''}}" name="account_type" readonly> --}}
                                                        @php
                                                            $ekyc->account_type = $ekyc->account_type ?? 'supplier';
                                                        @endphp
                                                        <select name="account_type" id="account_type" class="form-control" disabled>
                                                            <option {{ $chk = ($ekyc->account_type == 'customer') ?  "selected" : "" ; }} value="customer">Customer</option>
                                                            <option {{ $chk = ($ekyc->account_type == 'supplier') ?  "selected" : "" ; }} value="supplier">Manufacturer / stockest</option>
                                                            <option {{ $chk = ($ekyc->account_type == 'reseller ') ?  "selected" : "" ; }} value="reseller">Reseller</option>
                                                        </select>
                                                    </div>


                                                    @php
                                                        $ekyc->remarks = $ekyc->remarks ?? $ekyc->user_remark ?? "";
                                                    @endphp
                                                    <div class="col-md-12 col-12 mt-3">
                                                        <label for="remarks" class="form-label">User Remarks</label>
                                                        <input type="text" placeholder="User remarks" class="form-control" value="{{ $ekyc->remarks  ?? ''}}" name="remarks" readonly>
                                                    </div>
                                                    @endif
                                                       <hr class="m-2">
                                                       @if(AuthRole() == 'Admin')
                                                           @if($user->ekyc_status == 1)
                                                               <div class="col-md-12 col-12 mt-5">
                                                                   <label>{{ __('Note')}}</label>
                                                                   <textarea class="form-control" name="remark" type="text" >{{ $ekyc->admin_remark ?? '' }}</textarea>
                                                                   <button data-status="0" type="submit" class="btn btn-danger mt-2 btn-lg reject status-changer">Reject</button>
                                                               </div>
                                                           @elseif($user->ekyc_status == 2)
                                                               <div class="col-md-12 col-12 mt-5">
                                                                   <button data-status="1" type="submit" class="btn btn-success mt-2 btn-lg accept status-changer">Accept</button>
                                                               </div>
                                                           @elseif($user->ekyc_status == 3)
                                                               <div class="col-md-12 col-12 mt-5"> <label>{{ __('Rejection Reason (If Any)')}}</label>
                                                                   <textarea class="form-control" name="remark" type="text" >{{ $ekyc->admin_remark ?? '' }}</textarea>
                                                                   <button data-status="0"  type="submit" class="btn btn-danger mt-2 btn-lg reject status-changer">Reject</button>
                                                                   <button data-status="1" type="submit" class="btn btn-success accept ml-5 mt-2 btn-lg status-changer">Accept</button>
                                                               </div>
                                                           @endif
                                                       @endif
                                                   </div>
                                               @endif
                                            </form>

                                        @else
                                            <p class="p-5 m-2 text-center">
                                                This shop is not connected with any user account.
                                            </p>
                                        @endif

                                        <hr>

                                        {{-- Payment Section --}}
                                         <div class="row me-2 d-none">
                                            <div class="col-lg-8">
                                                   {{-- Features Form --}}
                                                <h6>Features Section</h6>
                                                <form action="{{ route('panel.user_shops.features',$user_shop->id) }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row mt-3">
                                                        <div class="col-md-12 col-12">
                                                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                                                <label for="title" class="control-label">Title</label>
                                                                <input required class="form-control" name="feature_title" type="text" id="title" value="{{ $features['feature_title'] ?? '' }}" placeholder="Enter Title">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-12">
                                                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                                                <label for="description" class="control-label">Description</label>
                                                                <textarea class="form-control" name="description" type="text" id="description"
                                                                    value="">{{ $features['description'] ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="repeater col-md-12 col-12">
                                                            <div data-repeater-list="features">
                                                                <div data-repeater-item class="row">
                                                                    <div class="col-5 form-group">
                                                                        <input type="text" name="title" class="form-control" placeholder="Title">
                                                                    </div>
                                                                    <div class="col-5 form-group">
                                                                        <select class="form-control select2" name="icon" id="icon">
                                                                            <option value=""readonly>Select Icon</option>
                                                                            <option value="fa-shopping-cart">Shopping Cart</option>
                                                                            <option value="fa-map-marker">Map Marker</option>
                                                                            <option value="fa-truck">Delivery</option>
                                                                            <option value="fa-envelope">Mail</option>
                                                                            <option value="fa-phone">Call</option>
                                                                            <option value="fa-thumbs-up">Thumbs Up</option>
                                                                            <option value="fa-reply">Reply</option>
                                                                            <option value="fa-bar-chart">Bar Chart</option>
                                                                            <option value="fa-pie-chart">Pie Chart</option>
                                                                            <option value="fa-area-chart">Area Chart</option>
                                                                            <option value="fa-address-card">Address Card</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-2 pl-1">
                                                                        <button data-repeater-delete type="button" class="btn btn-danger btn-icon mr-3" ><i class="ik ik-trash-2"></i></button>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button data-repeater-create type="button" class="btn btn-success btn-icon ml-2 mb-2"  style="position: absolute;top: 0px;"><i class="ik ik-plus"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mx-auto mt-3">
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                                <a href="{{ inject_subdomain('about-us', $user_shop->slug)}}#features" class="btn btn-outline-primary" target="_blank">Preview</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                 {{-- Payment Section --}}
                                                <h6>Payment Section</h6>
                                                <form action="{{ route('panel.user_shops.payments',$user_shop->id) }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                        <div class="row mt-3">
                                                            <div class="col-md-12 col-12">
                                                                <div class="form-group {{ $errors->has('upi') ? 'has-error' : '' }}">
                                                                    <label for="upi" class="control-label">Upload UPI QR Code</label>
                                                                    <input class="form-control" required name="upi_code" type="file" id="upi_code"
                                                                        value="">
                                                                @if ($payments != null)
                                                                    <img id="img" src="{{ asset($payments['upi']) }}" class="mt-2"
                                                                    style="border-radius: 10px;width:100px;height:80px;" />
                                                                @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 col-12">
                                                                <div class="form-group {{ $errors->has('po') ? 'has-error' : '' }}">
                                                                    <label for="po" class="control-label">PO Details</label>
                                                                    <textarea class="form-control" required name="po_details" type="text" id="po_details"
                                                                        value="">{{$payments['po'] ?? ''}}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </form>
                                            </div>
                                         </div>


                                    </div>
                                    {{-- <div class="col-lg-4">
                                        <div class="sticky">
                                            <img src="{{ asset('frontend/assets/img/shop/screenshot.png') }}" alt="" class="screen-shot-image">
                                        </div>
                                    </div> --}}
                                </div>

                            </div>
                            <div class="tab-pane fade @if(request()->has('active') && request()->get('active') == "security") active show @endif" id="features" role="tabpanel" aria-labelledby="pills-features-tab">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h5 class="">Change Password</h5>
                                    @if($user)
                                        <form action="{{ route('panel.update-password', $user->id) }}" method="post">
                                            @csrf
                                            <div class="row mt-3">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label">Old Password :</label>
                                                        <div class="form-icon position-relative">
                                                            <i data-feather="key" class="fea icon-sm icons"></i>
                                                            <input required type="password" class="form-control ps-5" name="old_password" placeholder="Old password">
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

                                                <div class="col-lg-12 mt-2 mb-2">
                                                    <button class="btn btn-primary" type="submit">Save Password</button>
                                                </div><!--end col-->
                                            </div><!--end row-->
                                        </form>
                                    @else
                                        <p class="p-5 m-2 text-center">
                                            This shop is not connected with any user account.
                                        </p>
                                    @endif
                                    </div>
                                     {{-- <div class="col-lg-4">
                                        <div class="sticky">
                                            <img src="{{ asset('frontend/assets/img/shop/screenshot.png') }}" alt="" class="screen-shot-image">
                                        </div>
                                    </div> --}}
                                </div>

                            </div>
                            <div class="tab-pane fade @if(request()->has('active') && request()->get('active') == 'team') active show @endif" id="user-shop-team" role="tabpanel" aria-labelledby="pills-team-tab">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <form action="{{ route('panel.teams.user-shops.update') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="user_shop_id" id="" value="{{ $user_shop->id }}">
                                            <div class="row mt-3">
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                                        <label for="title" class="control-label">Title</label>
                                                        <input class="form-control" placeholder="Enter Title" name="title" required type="text" id="title" value="{{ $team['title'] ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-12">
                                                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                                        <label for="description" class="control-label">Description</label>
                                                        <textarea class="form-control" placeholder="Enter Descriptoin" name="description" type="text" id="description"
                                                            value="">{{ $team['description'] ?? '' }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <a href="{{ inject_subdomain('about-us', $user_shop->slug)}}#team" class="btn btn-outline-primary" target="_blank">Preview</a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12"><hr></div>
                                                <div class="col-md-12">
                                                    <div class="d-flex justify-content-between my-3">
                                                        <h6>Team Members</h6>
                                                        <a href="{{ route('panel.teams.create') }}{{ '?shop_id='.$user_shop->id }}" class="mb-2 btn btn-icon btn-sm btn-outline-primary" title="Add New Team Member"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                                    </div>
                                                        @php
                                                            $items = App\Models\Team::whereUserShopId($user_shop->id)->paginate(4);
                                                        @endphp
                                                    <div class="row mt-3">
                                                        @if ($items->count() > 0)
                                                            @foreach($items as $item)
                                                                <div class="col-md-6    ">
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

                                                                                        <span class="mt-2"> {{\Str::limit($item->designation , 10)}}
                                                                                        </span>
                                                                                        <p>{{$item->contact_number}}</p>
                                                                                    </div>
                                                                                    <div class="col-2 pl-2">
                                                                                        <button style="background: transparent;margin-left: -12px;" class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                                                            <a href="{{ route('panel.teams.edit', $item->id) }}{{ '?shop_id='.$user_shop->id }}" title="Edit Brand"
                                                                                                class="dropdown-item ">
                                                                                                <li class="p-0">Edit</li>
                                                                                            </a>
                                                                                            <a href="{{ route('panel.teams.destroy', $item->id) }}" title="Delete Brand"
                                                                                                class="dropdown-item  delete-item">
                                                                                                <li class=" p-0">Delete</li>
                                                                                            </a>
                                                                                        </ul>
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
                                                            {{ $items->links() }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                     {{-- <div class="col-lg-4">
                                        <div class="sticky">
                                            <img src="{{ asset('frontend/assets/img/shop/screenshot.png') }}" alt="" class="screen-shot-image">
                                        </div>
                                    </div> --}}
                                </div>

                            </div>
                            <div class="tab-pane fade @if(request()->has('active') && request()->get('active') == "payment") active show @endif" id="payment" role="tabpanel" aria-labelledby="pills-payment-tab">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<form action="{{ route('panel.user.update-numbers') }}" method="post" id="updateAdditionalNumber">
    @csrf
    <input type="hidden" name="userAdditionalNoUpdate" class="userAdditionalNoUpdate" value="updateByAdmin">
    <input type="hidden" value="" name="user_id" class="userId">
</form>
@if($user)
@include('panel.user_shops.include.add-address')
@include('panel.user_shops.include.edit-address')
@include('panel.user_shops.include.add-numbers')
@else
<p class="p-5 m-2 text-center">
    This shop is not connected with any user account.
</p>
@endif
<!-- push external js -->
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
<script src="{{ asset('backend/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('backend/js/form-advanced.js') }}"></script>

<script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
<script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

    <script>
            $('tags').tagsinput('items');
                var options = {
                        filebrowserImageBrowseUrl: "{{ url('/laravel-filemanager?type=Images') }}",
                        filebrowserImageUploadUrl: "{{ url('/laravel-filemanager/upload?type=Images&_token='.csrf_token()) }}",
                        filebrowserBrowseUrl: "{{ url('/laravel-filemanager?type=Files') }}",
                        filebrowserUploadUrl: "{{ url('/laravel-filemanager/upload?type=Files&_token='.csrf_token()) }}"
                    };
                    $(window).on('load', function (){
                        CKEDITOR.replace('description', options);
            });

            // Single swithces
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

    </script>
    <script>

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
            $('#gstNumber').val(details.gst_number);
            $('#entityName').val(details.entity_name);
            $('#countryEdit').val(details.country).change();
            $('#acronym').val(details.acronym);
            $('#iec_number').val(details.iec_number);



            $('#bank-details-container_1').empty();
            jQuery.parseJSON(address.account_details).forEach(element => {
                    console.log(element);

                    let acc_tag = `<div class="col-md-6 mt-3">
                            <label for="bank_name" class="form-label">Bank Name <span class="text-danger">*</span> </label>
                            <input type="text" class="form-control" name="bank_name[]" value="${element.bank_name}" required>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="bank_address" class="form-label">Bank Address <span class="text-danger">*</span> </label>
                            <input type="text" class="form-control" name="bank_address[]" value="${element.bank_address}" required>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="swift_code" class="form-label">Swift Code</label>
                            <input type="text" class="form-control" name="swift_code[]" value="${element.swift_code}">
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="account_number" class="form-label">Account Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="account_number[]" value="${element.account_number}" required>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="account_holder_name" class="form-label">Account Holder Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="account_holder_name[]" value="${element.account_holder_name}" required>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="account_type" class="form-label">Account Type <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="account_type[]" value="${element.account_type}" required>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="ifsc_code_neft" class="form-label">IFSC Code/NEFT <span class="text-danger">*</span> </label>
                            <input type="text" class="form-control" name="ifsc_code_neft[]" value="${element.ifsc_code_neft}" required>
                        </div>

                        <div class="col-md-6 mt-3">

                            <button type="button" class=" btn btn-link mt-3" onclick="appenddata()">Add Bank Details</button>
                    </div>
                    <hr class="border border-primary border opacity-75 w-100">`;


                $('#bank-details-container_1').append(acc_tag);
                // console.log(address.account_details);


            });// end of looop




            setTimeout(() => {
                $('#stateEdit').val(details.state).change();
                setTimeout(() => {
                    $('#cityEdit').val(details.city).change();
                }, 500);
            }, 500);
            $('#editAddressModal').modal('show');
        });

        $('.status-changer').on('click',function(){
            var status = $(this).data('status');
            $('#status').val(status);
        })




        function getUserStates(countryId = 101) {

            $.ajax({
                url: "{{ route('world.get-states') }}",
                method: 'GET',
                data: {
                    country_id: countryId
                },
                success: function(res) {
                    $('#user_state').html(res).css('width', '100%');
                }
            });
        }

        function getUserCities(stateId = 101) {
            $.ajax({
                url: "{{ route('world.get-cities') }}",
                method: 'GET',
                data: {
                    state_id: stateId
                },
                success: function(res) {
                    $('#user_city').html(res).css('width', '100%');
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

        // this functionality work in edit page



            var country = "{{ $shop_address['country'] ?? ''}}";
            var state = "{{ $shop_address['state'] ?? ''}}";
            var city = "{{ $shop_address['city'] ?? ''}}";
            $(document).ready(function(){
                if(country){
                    getStateAsync(country).then(function(data){
                        $('#state').val(state).change();
                        $('#state').trigger('change').select2();
                    });
                }
                setTimeout(function(){
                    if(city){
                        getCityAsync(state).then(function(data){
                                $('#city').val(city).trigger('change');
                                $('#city').trigger('change').select2();
                        });
                    }
                },300);

                $('#user_country').on('change', function() {
                    getUserStates($(this).val());
                });

                $('#user_state').on('change', function() {
                    getUserCities($(this).val());
                });

                $('#countryEdit').on('change', function() {
                    getEditStates($(this).val());
                });

                $('#stateEdit').on('change', function() {
                    getEditCities($(this).val());
                });
            });

            $(function () {
                $("#txtName").keypress(function (e) {
                    var keyCode = e.keyCode || e.which;

                    $("#lblError").html("");

                    //Regex for Valid Characters i.e. Alphabets and Numbers.
                    var regex = /^[A-Za-z0-9]+$/;

                    //Validate TextBox value against the Regex.
                    var isValid = regex.test(String.fromCharCode(keyCode));
                    if (!isValid) {
                        $("#lblError").html("Only Alphabets and Numbers allowed.");
                    }

                    return isValid;
                });
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
             $(document).ready(function() {
                var table = $('.table').DataTable({
                    responsive: true,
                    fixedColumns: true,
                    fixedHeader: true,
                    scrollX: false,
                    'aoColumnDefs': [{
                        'bSortable': false,
                        'aTargets': ['nosort']
                    }],


                });
            });
            $('#UserShopForm').validate();

            document.getElementById('logo').onchange = function() {
                var src = URL.createObjectURL(this.files[0])
                $('#logo_file').removeClass('d-none');
                document.getElementById('logo_file').src = src
            }
            var features =  $('.repeater').repeater({

                defaultValues: {
                    'text-input': 'foo'
                },
                show: function() {
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                    $(this).slideUp(deleteElement);
                    }
                },
                isFirstItemUndeletable: true
            });

            @if(isset($features['features']))
                @if($features['features'] != null)
                    features.setList([
                        @foreach($features['features'] as $feature)
                        {
                            'title': "{{ $feature['title'] }}",
                            'icon': "{{ $feature['icon'] }}",
                        },
                        @endforeach
                    ]);
                @endif
            @endif
            // OTP Check

            $('#otpButton').on('click',function(e){
                e.preventDefault();
                var number = $('.additionalNumber').val();
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

                            $('#verifyOTP').removeClass('d-none');
                            $('.additionalNumber').attr('readonly',true);
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
            $('#save_additional_number').on('click',function(e){
                e.preventDefault();
                var phone_number = $('.additionalNumbers').val();
                var user_id = $(this).data('user_id');
                $('#updateAdditionalNumber').append(`<input type='hidden' name='additional_phone' value=${phone_number} />`);
                $('.userId').val(user_id);
                $('.userAdditionalNoUpdate').val('updateByAdmin');
                $('#updateAdditionalNumber').submit();
            });
            $('#saveBtn').on('click',function(e){
                e.preventDefault();
                var phone_number = $('.additionalNumber').val();
                $('#updateAdditionalNumber').append(`<input type='number' name='additional_phone' value=${phone_number} />`);
                $('#updateAdditionalNumber').submit();

            });
    </script>
    @endpush
@endsection
