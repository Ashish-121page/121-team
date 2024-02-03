@push('head')
    <style>
        .error {
            color: red;
        }

        .cross-btn {
            position: absolute !important;
            left: 96px !important;
        }

        .screen-shot-image {
            width: 100%;
            height: 100%;
        }

        #industry_id+.select2 .selection {
            pointer-events: none;
        }

        .sticky {
            position: sticky;
            top: 70px;
        }

        .remove-ik-class {
            -webkit-box-shadow: unset !important;
            box-shadow: unset !important;
        }

        .active {
            background-color: transparent;
            color: black
        }

        .nav-link {
            background-color: transparent;
        }

        .nav-link.active {
            background-color: #6666cc !important;
            color: whitesmoke !important;
        }
    </style>
@endpush
<div class="card ">
    <div class="card-body">


        <div class="nav nav-tabs " id="nav-tab" role="tablist">
            <button class="nav-link btn shadow-none  active" id="nav-home-tab" data-bs-toggle="tab"
                data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                Info </button>


            <button class="nav-link btn shadow-none " id="nav-profile-tab" data-bs-toggle="tab"
                data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile"
                aria-selected="false">e-KYC</button>

            <button class="nav-link btn shadow-none " id="nav-contact-tab" data-bs-toggle="tab"
                data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact"
                aria-selected="false">Security</button>

        </div>

        <div class="tab-content" id="nav-tabContent">
            {{-- First / Account Info --}}
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
                tabindex="0">
                <div class="row my-3">
                    <div class="col-lg-8">


                        <form action="{{ route('customer.profile.update', $user->id) }}" method="post"
                            enctype="multipart/form-data" id="UserShopForm">
                            <input type="hidden" name="status" value="1">
                            @csrf

                            <div class="row mt-3">
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <label for="name" class="control-label">Business Name</label>
                                        <input required class="form-control" name="name" type="text"
                                            id="name" value="{{ $user->name }}" placeholder="Enter Name">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 ">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <label for="email">{{ __('Business Email') }}<span
                                                        class="text-danger">*</span></label>
                                            </div>
                                            <div>
                                            </div>
                                        </div>

                                        <input @if ($user->email_verified_at != null)  @endif type="email"
                                            placeholder="test@test.com" class="form-control" name="email"
                                            id="email" value="{{ $user->email }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12 ">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <label for="phone_no">{{ __('Business Phone') }}<span
                                                        class="text-danger">*</span></label>
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                        <input @if ($user->phone_no_verified_at != null) readonly @endif type="number"
                                            placeholder="test@test.com" class="form-control" name="phone"
                                            maxlength="10" id="phone_no" value="{{ $user->phone }}">
                                    </div>
                                </div>
                                @if (AuthRole() == 'Admin')
                                    <div class="col-md-12 ">
                                        <div class="form-group mb-3">
                                            <label class="form-label">vCards</label>
                                            <input type="file" class="form-control" name="vcard">
                                            @if (isset($vcard) && $vcard != null)
                                                <img src="{{ asset($vcard->path) }}" class="mt-3 rounded" alt="vcard"
                                                    style="height: 100px;">
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

                        @if (AuthRole() == 'Admin')
                            <form action="{{ route('customer.update.settings') }}" method="post" class="my-4">
                                @csrf
                                <input type="hidden" name="type" value="setting1">
                                <input type="hidden" name="user_shop" value="{{ $user_shop->id }}">
                                <input type="hidden" name="slug" value="{{ $user_shop->slug }}">
                                <div class="row mb-2">
                                    <div class="col">
                                        <label for="">Public Display</label> <br>
                                        <input type="checkbox" @if ($user_shop->shop_view == 1) checked @endif
                                            value="1" name="shop_view" class="js-single" />
                                    </div>
                                    <div class="col">
                                        <label for="auto_acr"
                                            title="Enable You A Feature That Auto Accepting Catelogue Request">Auto
                                            Accept Request</label> <br>
                                        <input type="checkbox" @if ($user_shop->auto_acr == 1) checked @endif
                                            value="1" name="auto_acr" id="auto_acr" class="js-acr" />
                                    </div>
                                    @php
                                        $teamdata = json_decode($user_shop->team);
                                        $teamdata->team_visiblity = $teamdata->team_visiblity ?? 0;
                                    @endphp

                                    <div class="col">
                                        <label for="public_about"
                                            title="Enable You A Feature That Auto Accepting Catelogue Request py-2">Public
                                            Team</label> <br>
                                        <input type="checkbox" @if (isset($teamdata) && $teamdata != null && $teamdata->team_visiblity) checked @endif
                                            value="1" name="public_about" id="public_about" class="js-about" />
                                    </div>
                                </div>
                                <div class="mt-4 d-flex justify-content-center">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>

                            {{-- Additional Phone Number --}}
                            <form action="{{ route('panel.update-user-profile', $user->id) }}" method="POST"
                                class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                {{-- <input type="hidden" name="additional_number[]" value=""> --}}
                                {{-- <h6>My Info</h6> --}}
                                <div class="row mt-3">
                                    <div class="col-md-6 d-none">
                                        <div class="form-group">
                                            <label for="name">{{ __('Name') }}<span
                                                    class="text-red">*</span></label>
                                            <input type="text" placeholder="Enter Name" class="form-control"
                                                name="name" id="name" value="{{ $user->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-none">
                                        <div class="form-group">
                                            <div class="d-flex">
                                                <label for="email">{{ __('Email') }}<span
                                                        class="text-red">*</span>
                                                </label>
                                                @if ($user->email_verified_at == null)
                                                    <a class="btn btn-sm text-secondary ml-auto"
                                                        style="line-height: 3px;"
                                                        href="{{ route('verification.resend') }}">Verify Email</a>
                                                @endif
                                            </div>
                                            <input @if ($user->email_verified_at != null) readonly @endif type="email"
                                                placeholder="test@test.com" class="form-control" name="email"
                                                id="email" value="{{ $user->email }}">
                                        </div>
                                    </div>

                                    {{-- Additioal Phone Fields --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">{{ __('Phone No') }}<span class="text-red">*</span>
                                                <span><i class="ik ik-info"
                                                        title="Request catalogs are processed using this number"></i></span></label>
                                            <div class="d-flex">
                                                <input type="number" placeholder="enter Phone number" id="phone"
                                                    name="phone" readonly class="form-control w-75"
                                                    value="{{ $user->phone }}" required>
                                                @if (AuthRole() != 'Admin')
                                                    <button type="button" data-toggle="modal"
                                                        data-target="#addAdditionalNumbers"
                                                        class="btn btn-icon btn-primary ml-2"><i
                                                            class="ik ik-plus"></i></button>
                                                @endif
                                            </div>
                                            @if (AuthRole() == 'Admin')
                                                <textarea name="phone[]" id="" cols="30" rows="10" class="form-control mt-2 additionalNumbers"
                                                    placeholder="Enter Mobile Number"></textarea>
                                                <p class="text-danger mt-1">Enter Number then use comma seperater
                                                    Ex:3215478960,3215478962</p>
                                                <button data-user_id="{{ $user_shop->user_id }}"
                                                    class="btn btn-primary mt-1" id="save_additional_number">Save
                                                    Additional Numbers</button>
                                            @endif
                                        </div>
                                        @if ($user->additional_numbers != 'null')
                                            @if (!is_null($user->additional_numbers) && $user->additional_numbers != '""')
                                                <ul class="list-unstyled">
                                                    @foreach (json_decode($user->additional_numbers) as $number)
                                                        {{-- @if ($number != '"' && $number != null) --}}
                                                        <li>
                                                            <i class="ik ik-check text-success"></i>
                                                            {{ $number }}
                                                            @if ($number != '')
                                                                <a href="{{ route('panel.user.number.delete', [$user->id, $number]) }}"
                                                                    class="confirm-btn">
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
                                                $data = App\Models\survey::where('user_id', $user_shop->user_id)->first();
                                            @endphp
                                            @if ($data != null)
                                                <div class="h6">Survey Response</div>
                                                <span><b>{{ json_decode($data->question) }}</b></span>
                                                <br><br>
                                                <p>
                                                    @forelse (json_decode($data->response) ?? [] as $item)
                                                        {{ $loop->iteration . '. ' . $item }} <br>
                                                    @empty
                                                        Didn't Filled Yet.
                                                    @endforelse
                                                </p>
                                            @endif
                                        </div>
                                    @endif




                                    <div class="col-md-6 d-none">
                                        @php
                                            $industry = json_decode($user->industry_id, true);
                                        @endphp
                                        <div class="form-group">
                                            <label for="phone">{{ __('Industry') }}<span
                                                    class="text-red">*</span></label>
                                            <select aria-readonly="true"
                                                @if (UserRole($user->id)['name'] == 'User') required @endif name="industry_id[]"
                                                class="form-control select2" multiple id="industry_id">
                                                @foreach (App\Models\Category::where('category_type_id', 13)->get() as $category)
                                                    <option value="{{ $category->id }}"
                                                        @if (isset($industry)) {{ in_array($category->id, $industry) ? 'selected' : '' }} @endif>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-none">
                                        <div class="form-group">
                                            <label for="dob">{{ __('DOB') }}<span
                                                    class="text-red">*</span></label>
                                            <input id="" class="form-control" type="date" name="dob"
                                                placeholder="Select your birth date" value="{{ $user->dob }}" />
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group d-none">
                                            <label for="">Gender</label>
                                            <div class="form-radio">
                                                <div class="radio radio-inline">
                                                    <label>
                                                        <input type="radio" name="gender" value="male"
                                                            {{ $user->gender == 'male' ? 'checked' : '' }}>
                                                        <i class="helper"></i>{{ __('Male') }}
                                                    </label>
                                                </div>
                                                <div class="radio radio-inline">
                                                    <label>
                                                        <input type="radio" name="gender" value="female"
                                                            {{ $user->gender == 'female' ? 'checked' : '' }}>
                                                        <i class="helper"></i>{{ __('Female') }}
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>



                                    <div class="col-md-12 d-none">
                                        <div class="form-group">
                                            <label for="address">{{ __('Address') }}<span
                                                    class="text-red">*</span></label>
                                            <textarea name="address" name="address" rows="5" class="form-control" placeholder="Enter Address">{{ $user->address }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        @endif


                    </div>
                </div>
            </div>

            {{-- Second / E-KYC --}}
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"
                tabindex="0">
                <div class="row my-3">
                    <div class="col-lg-8">
                        {{-- About Form --}}
                        <h6>e-KYC Section</h6>
                        @if ($user)
                            @php
                                $ekyc = json_decode($user->ekyc_info);
                            @endphp
                            <form action="{{ route('panel.update-ekyc-status', $user->id) }}" method="POST"
                                class="form-horizontal">
                                @if ($user->ekyc_status == 0)
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
                                @if ($user->ekyc_status != null)
                                    <div class="row">
                                        <div class="col-md-6 col-6"> <label>{{ __('Document Type') }}</label>
                                            <br>
                                            <h5 class="strong text-muted">{{ $ekyc->document_type ?? '' }}</h5>
                                        </div>
                                        <div class="col-md-6 col-6"> <label>{{ __('Document Number') }}</label>
                                            <br>
                                            <h5 class="strong text-muted">{{ $ekyc->document_number ?? '' }}</h5>
                                        </div>
                                        <div class="col-md-6 col-6"> <label>{{ __('Document Front Image') }}</label>
                                            <br>
                                            @if ($ekyc != null && $ekyc->document_front != null)
                                                <a href="{{ asset($ekyc->document_front) }}" target="_blank"
                                                    class="badge badge-info">View Attachment</a>
                                            @endif
                                        </div>
                                        <div class="col-md-6 col-6"> <label>{{ __('Document Back Image') }}</label>
                                            <br>
                                            @if ($ekyc != null && $ekyc->document_back != null)
                                                @if ($ekyc != null && $ekyc->document_back != null)
                                                    <a href="{{ asset($ekyc->document_back) }}" target="_blank"
                                                        class="badge badge-info">View Attachment</a>
                                                @endif
                                            @endif
                                        </div>
                                        @if (AuthRole() == 'Admin')
                                            <div class="col-md-12 col-12 mt-3">
                                                <label for="last_site" class="form-label">Existing Site</label>
                                                <input type="text" placeholder="Existing Site"
                                                    class="form-control" value="{{ $ekyc->last_site ?? '' }}"
                                                    readonly>
                                            </div>


                                            <div class="col-md-12 col-12 mt-3">
                                                <label for="last_site" class="form-label">Applying For Account</label>
                                                {{-- <input type="text" placeholder="Account Type" class="form-control" value="{{ $ekyc->account_type  ?? ''}}" name="account_type" readonly> --}}
                                                @php
                                                    $ekyc->account_type = $ekyc->account_type ?? 'supplier';
                                                @endphp
                                                <select name="account_type" id="account_type" class="form-control"
                                                    disabled>
                                                    <option
                                                        {{ $chk = $ekyc->account_type == 'customer' ? 'selected' : '' }}
                                                        value="customer">Customer</option>
                                                    <option
                                                        {{ $chk = $ekyc->account_type == 'supplier' ? 'selected' : '' }}
                                                        value="supplier">Manufacturer / stockest</option>
                                                    <option
                                                        {{ $chk = $ekyc->account_type == 'reseller ' ? 'selected' : '' }}
                                                        value="reseller">Reseller</option>
                                                </select>
                                            </div>


                                            @php
                                                $ekyc->remarks = $ekyc->remarks ?? ($ekyc->user_remark ?? '');
                                            @endphp
                                            <div class="col-md-12 col-12 mt-3">
                                                <label for="remarks" class="form-label">User Remarks</label>
                                                <input type="text" placeholder="User remarks" class="form-control"
                                                    value="{{ $ekyc->remarks ?? '' }}" name="remarks" readonly>
                                            </div>
                                        @endif
                                        <hr class="m-2">
                                        @if (AuthRole() == 'Admin')
                                            @if ($user->ekyc_status == 1)
                                                <div class="col-md-12 col-12 mt-5">
                                                    <label>{{ __('Note') }}</label>
                                                    <textarea class="form-control" name="remark" type="text">{{ $ekyc->admin_remark ?? '' }}</textarea>
                                                    <button data-status="0" type="submit"
                                                        class="btn btn-danger mt-2 btn-lg reject status-changer">Reject</button>
                                                </div>
                                            @elseif($user->ekyc_status == 2)
                                                <div class="col-md-12 col-12 mt-5">
                                                    <button data-status="1" type="submit"
                                                        class="btn btn-success mt-2 btn-lg accept status-changer">Accept</button>
                                                </div>
                                            @elseif($user->ekyc_status == 3)
                                                <div class="col-md-12 col-12 mt-5">
                                                    <label>{{ __('Rejection Reason (If Any)') }}</label>
                                                    <textarea class="form-control" name="remark" type="text">{{ $ekyc->admin_remark ?? '' }}</textarea>
                                                    <button data-status="0" type="submit"
                                                        class="btn btn-danger mt-2 btn-lg reject status-changer">Reject</button>
                                                    <button data-status="1" type="submit"
                                                        class="btn btn-success accept ml-5 mt-2 btn-lg status-changer">Accept</button>
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
                                <form action="{{ route('panel.user_shops.features', $user_shop->id) }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mt-3">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                                                <label for="title" class="control-label">Title</label>
                                                <input required class="form-control" name="feature_title"
                                                    type="text" id="title"
                                                    value="{{ $features['feature_title'] ?? '' }}"
                                                    placeholder="Enter Title">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div
                                                class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                                <label for="description" class="control-label">Description</label>
                                                <textarea class="form-control" name="description" type="text" id="description" value="">{{ $features['description'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="repeater col-md-12 col-12">
                                            <div data-repeater-list="features">
                                                <div data-repeater-item class="row">
                                                    <div class="col-5 form-group">
                                                        <input type="text" name="title" class="form-control"
                                                            placeholder="Title">
                                                    </div>
                                                    <div class="col-5 form-group">
                                                        <select class="form-control select2" name="icon"
                                                            id="icon">
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
                                                        <button data-repeater-delete type="button"
                                                            class="btn btn-danger btn-icon mr-3"><i
                                                                class="ik ik-trash-2"></i></button>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button data-repeater-create type="button"
                                                        class="btn btn-success btn-icon ml-2 mb-2"
                                                        style="position: absolute;top: 0px;"><i
                                                            class="ik ik-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mx-auto mt-3">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                                <a href="{{ inject_subdomain('about-us', $user_shop->slug) }}#features"
                                                    class="btn btn-outline-primary" target="_blank">Preview</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                {{-- Payment Section --}}
                                <h6>Payment Section</h6>
                                <form action="{{ route('panel.user_shops.payments', $user_shop->id) }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mt-3">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group {{ $errors->has('upi') ? 'has-error' : '' }}">
                                                <label for="upi" class="control-label">Upload UPI QR Code</label>
                                                <input class="form-control" required name="upi_code" type="file"
                                                    id="upi_code" value="">
                                                @if ($payments != null)
                                                    <img id="img" src="{{ asset($payments['upi']) }}"
                                                        class="mt-2"
                                                        style="border-radius: 10px;width:100px;height:80px;" />
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group {{ $errors->has('po') ? 'has-error' : '' }}">
                                                <label for="po" class="control-label">PO Details</label>
                                                <textarea class="form-control" required name="po_details" type="text" id="po_details" value="">{{ $payments['po'] ?? '' }}</textarea>
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

            {{-- Third / Security --}}
            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab"
                tabindex="0">
                <div class="row my-3">
                    <div class="col-lg-8">
                        <h5 class="">Change Password</h5>
                        @if ($user)
                            <form action="{{ route('panel.update-password', $user->id) }}" method="post">
                                @csrf
                                <div class="row mt-3">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Old Password :</label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="key" class="fea icon-sm icons"></i>
                                                <input required type="password" class="form-control ps-5"
                                                    name="old_password" placeholder="Old password">
                                            </div>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">New password :</label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="key" class="fea icon-sm icons"></i>
                                                <input type="password" max="6" class="form-control ps-5"
                                                    placeholder="New password" required="" name="password">
                                            </div>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Re-type New password :</label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="key" class="fea icon-sm icons"></i>
                                                <input type="password" max="6" class="form-control ps-5"
                                                    placeholder="Re-type New password" required=""
                                                    name="confirm_password">
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

        </div>

    </div>
</div>
</div>
