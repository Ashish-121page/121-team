@php
    use App\Models\UserAddress;

    $addresses = UserAddress::whereUserId($user_shop->user_id)->get();
@endphp
@push('head')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/dropzone.min.css') }}">

    <style>
        .error {
            color: red;
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

        .sq {
            height: 200px;
            width: 200px;
            background-position: center center;
            background-size: cover;
            background-repeat: no-repeat;
            overflow: hidden;
            border-radius: 10px;
            /* border: none; */

        }

        .rec {
            height: 200px;
            width: 600px;
            background-image: url("https://placehold.co/600x200?text=900x300");
            background-position: center center;
            background-size: cover;
            background-repeat: no-repeat;
            overflow: hidden;
            border-radius: 10px;
        }
    </style>
@endpush

<div class="card-body">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                role="tab" aria-controls="nav-home" aria-selected="true">Entity</button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Branding</button>
            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Documentation</button>
            <button class="nav-link" id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled"
                type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">Currency</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">


        {{-- ` First --}}
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"
            tabindex="0">
            <div class="col-lg-10 justify-content-center" style="margin-left: 4rem;">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <hr>
                        <div class="d-flex justify-content-between my-3">
                            <h5 class="mt-1">Entities</h5>
                            <a href="javascript:void(0);" class="btn btn-primary addAddress"
                                data-id="{{ auth()->id() }}">Add Entity</a>
                        </div>

                        <div class="row">
                            @forelse ($addresses as $address)
                                @php
                                    $address_decoded = json_decode($address->details, true) ?? '';
                                @endphp
                                <div class="col-lg-4 col-md-4 mb-3 pl-0 custom-height">
                                    <div class="m-1 p-2 border rounded" style="max-height: 469px;">
                                        <div class="mb-2">
                                            <div class="d-flex align-items-center justify-content-between"
                                                style="background-color: #f3f3f3">
                                                <h6>
                                                    {{ substr($address_decoded['acronym'] ?? $address_decoded['entity_name'], 0, 12) . (strlen($address_decoded['acronym'] ?? $address_decoded['entity_name']) > 12 ? '..' : '') }}
                                                </h6>
                                                <div class="d-flex d-lg d-none align-items-center" style="width:23%;">
                                                    @if ($address->type == 1)
                                                        <span class="mr-2">Site</span>
                                                    @else
                                                        <span class="mr-2">Entity</span>
                                                    @endif
                                                    <a href="javascript:void(0)" class="text-primary editAddress mb-0"
                                                        title="Edit Address" data-id="{{ $address }}"
                                                        data-original-title="Edit"><i class="ik ik-edit"></i></a>
                                                    {{-- <a href="{{ route('customer.address.delete',$address->id) }}" class="text-primary delete-item mb-0" title=""data-original-title="delete" ><i class="ik ik-trash"></i></a> --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pt-1 border-top">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div style="max-height: 200px; height:200px;  overflow: auto;">


                                                    <p class="text-muted mb-1">
                                                        {{ $address_decoded['entity_name'] }} <br>
                                                        {{ $address_decoded['gst_number'] }} <br>
                                                        {{ $address_decoded['iec_number'] ?? '' }} <br>
                                                        {{ $address_decoded['acronym'] ?? '' }} <br>
                                                    </p>

                                                    <p class="text-muted mb-1">{{ $address_decoded['address_1'] }}</p>
                                                    <p class="text-muted mb-1">{{ $address_decoded['address_2'] }}</p>
                                                    <p class="text-muted mb-1">
                                                        {{ CountryById($address_decoded['country']) }},
                                                        {{ StateById($address_decoded['state']) }},
                                                        {{ CityById($address_decoded['city']) }}
                                                    </p>
                                                    <p class="text-muted">{{ $address_decoded['pincode'] ?? '' }}</p>


                                                </div>
                                            </div>

                                            <div class="">
                                                <div class="col-lg-12 col-md-12" style="padding: 0;">
                                                    <div class="d-flex align-items-center justify-content-center"
                                                        style="background-color:#f3f3f3; padding: 5px;">
                                                        Bank Accounts
                                                    </div>
                                                </div>
                                                <div
                                                    class="row scrollable"style="max-height: 200px; height:200px; overflow: auto;">
                                                    @forelse ((array) json_decode($address->account_details) as $acc)
                                                        @if ($loop->index < 6)
                                                            <div class="col-lg-6 col-md-6 mb-1">
                                                                <p class="text-muted" style="background-color:white;">
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
                </div>
            </div>
        </div>

        {{-- ` Branding --}}
        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">

            <div class="row my-3">

                @php
                    $user_shop = App\Models\UserShop::whereUserId(auth()->id())->first();
                    $rec = getShopLogo($user_shop->slug);
                @endphp
                <div class="col-6">
                    <div class="h4">
                        Logo
                    </div>
                    <form action="{{ route('panel.settings.upload.logo') }}" method="POST"
                        enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="upload_log" class="form-label sq mx-2"
                                style="background-image: url('{{ asset($rec) }}')">
                            </label>
                            <input type="file" id="upload_log" class="form-control d-none" name='upload_log'
                                accept='image/*' onchange="loadFile(event)">

                            <p>Recomemded Size: 150px X 150px</p>
                        </div>
                        <input type="submit" value="Save" name="uploadLogo" class="btn btn-outline-primary ">

                    </form>
                </div>

                <div class="col-6">
                    <div class="h4">
                        Cover Image
                    </div>
                    @php
                        $record = App\Models\Media::where('type_id', auth()->id())
                            ->where('type', 'OfferBanner')
                            ->get();
                    @endphp
                    <form action="{{ route('panel.settings.upload.banner') }}" enctype="multipart/form-data"
                        method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ encrypt(auth()->id()) }}">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    @if ($record->count() != 0)
                                        <label for="offer_logo" class="d-block rec"
                                            style="background-image: url('{{ asset($record[0]->path) }}');">
                                        </label>
                                    @else
                                        <label for="offer_logo" class="d-block rec">
                                        </label>
                                    @endif
                                    <input type="file" name="offer_logo" class="d-none" id="offer_logo"
                                        accept="image/*">

                                    <p>
                                        Recomemded Size: 900px X 300 px
                                    </p>
                                    @if ($record->count() != 0)
                                        <input type="hidden" name="existing" value="{{ $record[0]->path }}">
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-outline-primary my-2">Save</button>

                            </div>


                        </div>


                    </form>

                </div>

            </div>



        </div>

        {{-- Documenation --}}
        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab"
            tabindex="0">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('panel.settings.quot.setting') }}" method="POST"
                                enctype="multipart/form-data">
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                                @php
                                    $quot = json_decode(auth()->user()->settings);
                                    $address = UserAddress::where('user_id', auth()->id())->get();
                                @endphp
                                <div class="d-flex flex-wrap justify-content-between text-center ">

                                    <div class="row my-2">

                                        {{-- Quoation Entity DropDown Start --}}
                                        @php
                                            if (($quot->quotaion_mark ?? '') && ($quot->quotaion_index ?? '') && ($quot->offer_mark ?? '') && ($quot->offer_index ?? '') && ($quot->performa_mark ?? '') && ($quot->performa_index ?? '') && ($quot->invoice_mark ?? '') && ($quot->invoice_index ?? '')) {
                                                $isDisabled = 'disabled';
                                            } else {
                                                $isDisabled = '';
                                            }
                                        @endphp


                                        <div class="col-12 col-md-6 col-lg-3 d-none d-lg-block"
                                            style="border-right: 1px solid #eaeaea;">
                                            <div class="form-group mx-2">
                                                <label for="entity_name" class="text-danger " style="height:38.38px;">Entity</label>
                                                <select class="form-control select2" id="entity_name"
                                                    name="entity_name" {{ $isDisabled }}>
                                                    @foreach ($address as $item)
                                                        <option>
                                                            {{ json_decode($item->details ?? '')->entity_name ?? '' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>


                                        {{-- mobile view --}}

                                        <div class="col-12 col-md-6 col-lg-3 d-lg-none"
                                            style="border-right: 1px solid #eaeaea;">
                                            <div class="form-group mx-2">
                                                <label for="entity_name" class="text-danger ">Entity</label>
                                                <select class="form-control select2" id="entity_name"
                                                    name="entity_name" {{ $isDisabled }}>
                                                    @foreach ($address as $item)
                                                        <option>
                                                            {{ json_decode($item->details ?? '')->entity_name ?? '' }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        {{-- mobile view end --}}
                                        {{-- Quoation Entity DropDown Start --}}

                                        {{-- Quoation Section Start --}}
                                        <div class="col-12 col-md-6 col-lg-2"
                                            style="border-right: 1px solid #eaeaea;">
                                            <div class="row">
                                                <div class="col-6 col-lg-12">
                                                    <div class="form-group mx-1">
                                                        <label for="quotaion_mark">Quotation ID Prefix <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                        @if ($quot)
                                                        @readonly(true)
                                                        readonly
                                                    @endif
                                                        class="form-control"
                                                            name="quotaion_mark" id="quotaion_mark"
                                                            placeholder="Quotaion Mark"
                                                            value="{{ $quot->quotaion_mark ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="col-6 col-lg-12">
                                                    <div class="form-group mx-2">
                                                        <label for="quotaion_index">Quotation ID start <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number" min="1"
                                                        @if ($quot)
                                                        @readonly(true)
                                                        readonly
                                                    @endif
                                                        class="form-control"
                                                            name="quotaion_index" id="quotaion_index"
                                                            placeholder="Quotaion index"
                                                            value="{{ $quot->quotaion_index ?? '1' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Quoation Section End --}}


                                        {{-- Offer Section Start --}}
                                        <div class="col-12 col-md-6 col-lg-2"
                                            style="border-right: 1px solid #eaeaea;">
                                            <div class="row">
                                                <div class="col-6 col-lg-12">
                                                    <div class="form-group mx-1">
                                                        <label for="offer_mark">Offer ID Prefix <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                        @if ($quot)
                                                        @readonly(true)
                                                        readonly
                                                    @endif
                                                        class="form-control" name="offer_mark"
                                                            id="offer_mark" placeholder="offer Mark"
                                                            value="{{ $quot->offer_mark ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-12">
                                                    <div class="form-group mx-2">
                                                        <label for="offer_index">Offer ID Start <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number"
                                                        @if ($quot)
                                                        @readonly(true)
                                                        readonly
                                                    @endif
                                                        min="1" class="form-control"
                                                            name="offer_index" id="offer_index"
                                                            placeholder="Offer index"
                                                            value="{{ $quot->offer_index ?? '1' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Offer Section End --}}


                                        {{-- PI Section Start --}}
                                        <div class="col-12 col-md-6 col-lg-2 d-none d-lg-block"
                                            style="border-right: 1px solid #eaeaea;">
                                            <div class="row">
                                                <div class="col-6 col-lg-12">
                                                    <div class="form-group mx-1">
                                                        <label for="performa_mark" style="height:18px;">PI ID Prefix <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                        @if ($quot)
                                                        @readonly(true)
                                                        readonly
                                                    @endif
                                                        class="form-control"
                                                            name="performa_mark_lg" id="performa_mark"
                                                            placeholder="PI Mark"
                                                            value="{{ $quot->performa_mark ?? '' }}">

                                                    </div>
                                                </div>

                                                <div class="col-6 col-lg-12">
                                                    <div class="form-group mx-2">
                                                        <label for="performa_index" style="height:18px;">PI ID Start <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number"
                                                        @if ($quot)
                                                        @readonly(true)
                                                        readonly
                                                    @endif
                                                        min="1" class="form-control"
                                                            name="performa_index" id="performa_index"
                                                            placeholder="PI index"
                                                            value="{{ $quot->performa_index ?? '1' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- PI Section End --}}

                                        {{-- mobile View --}}

                                        <div class="col-12 col-md-6 col-lg-2 d-lg-none"
                                            style="border-right: 1px solid #eaeaea;">
                                            <div class="row">
                                                <div class="col-6 col-lg-12">
                                                    <div class="form-group ">
                                                        <label for="performa_mark">PI ID Prefix <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"

                                                        @if ($quot)
                                                        @readonly(true)
                                                        readonly
                                                    @endif
                                                        class="form-control"
                                                            name="performa_mark" id="performa_mark"
                                                            placeholder="PI Mark"
                                                            value="{{ $quot->performa_mark ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="col-6 col-lg-12">
                                                    <div class="form-group" id="pid">
                                                        <label  id="pp" for="performa_index" > ID Start <span
                                                                class="text-danger">*</span></label>
                                                        <input type="number"

                                                        @if ($quot)
                                                        @readonly(true)
                                                        readonly
                                                        @endif
                                                        min="1" class="form-control"
                                                            name="performa_index" id="performa_index"
                                                            placeholder="PI index"
                                                            value="{{ $quot->performa_index ?? '1' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-2 d-lg-nosne"
                                            style="border-right: 1px solid #eaeaea;">
                                            <div class="row">
                                                <div class="col-6 col-lg-12">
                                                    <div class="form-group mx-1">
                                                        <label for="model_code_mark">Model Code Prefix <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"

                                                         @if ($quot)
                                                        @readonly(true)
                                                        readonly
                                                         @endif
                                                        class="form-control"
                                                            name="model_code_mark" id="model_code_mark"
                                                            placeholder="Model Start"
                                                            value="{{ $quot->model_code_mark ?? '' }}">
                                                    </div>
                                                </div>

                                                <div class="col-6 col-lg-12">
                                                    <div class="form-group mx-2">
                                                        <label for="model_code_index" >Model Code Start></label>
                                                        <input type="number" min="1" class="form-control"
                                                            name="model_code_index" id="model_code_index"
                                                            placeholder="Model Code Start"
                                                            @if ($quot)
                                                        @readonly(true)
                                                        readonly
                                                    @endif
                                                            value="{{ $quot->model_code_index ?? '1' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Invoice Section Start --}}
                                        <div class="col-12 col-md-6 col-lg-2">
                                            <div class="row">
                                                <div class="col-6 col-lg-12">
                                                    <div class="form-group mx-1">
                                                        <label for="invoice_mark" class="text-danger ">Invoice ID
                                                            Prefix
                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control"
                                                            name="invoice_mark" id="invoice_mark"
                                                            placeholder="Invoice Mark"
                                                            @if ($quot)
                                                        @readonly(true)
                                                        readonly
                                                    @endif
                                                            value="{{ $quot->invoice_mark ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-12">
                                                    <div class="form-group mx-2">
                                                        <label for="invoice_index" class="text-danger ">Invoice ID
                                                            Start
                                                            <span class="text-danger">*</span></label>
                                                        <input type="number"
                                                        @if ($quot)
                                                        @readonly(true)
                                                        readonly
                                                    @endif
                                                         min="1" class="form-control"
                                                            name="invoice_index" id="invoice_index"
                                                            placeholder="invoice index"
                                                            value="{{ $quot->invoice_index ?? '1' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Invoice Section End --}}


                                    </div>
                                </div>


                                @if (! $quot)


                                <button type="submit" class="btn btn-outline-primary">
                                    Submit
                                </button>
                                @endif

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ` Currency --}}

        <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab"
            tabindex="0">

            @php
                $record = App\Models\Media::where('type_id', auth()->id())
                    ->where('type', 'OfferBanner')
                    ->get();
            @endphp

            <div class="card-body">
                @include('frontend.customer.dashboard.section.currency-load')
            </div>

        </div>
    </div>


</div>



@if ($user)
    @include('panel.user_shops.include.add-address')
    @include('panel.user_shops.include.edit-address')
    @include('panel.user_shops.include.add-numbers')
@else
    <p class="p-5 m-2 text-center">
        This shop is not connected with any user account.
    </p>
@endif

@push('script')
    <script src="{{ asset('frontend/assets/js/dropzone.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('backend/js/form-advanced.js') }}"></script>

    <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
    <script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>



    <script>
        $('.addAddress').click(function() {
            user_id = $(this).data('id');
            $('#userId').val(user_id);
            $('#addAddressModal').removeAttr('tabindex');
            $('#addAddressModal').modal('show');
        });

        $('.editAddress').click(function() {
            var address = $(this).data('id');

            if (address.type == 0) {
                $('.homeInput').attr("checked", "checked");
            } else {
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


            }); // end of looop




            setTimeout(() => {
                $('#stateEdit').val(details.state).change();
                setTimeout(() => {
                    $('#cityEdit').val(details.city).change();
                }, 500);
            }, 500);
            $('#editAddressModal').modal('show');
        });

        $('.status-changer').on('click', function() {
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



        var country = "{{ $shop_address['country'] ?? '' }}";
        var state = "{{ $shop_address['state'] ?? '' }}";
        var city = "{{ $shop_address['city'] ?? '' }}";
        $(document).ready(function() {
            if (country) {
                getStateAsync(country).then(function(data) {
                    $('#state').val(state).change();
                    $('#state').trigger('change').select2();
                });
            }
            setTimeout(function() {
                if (city) {
                    getCityAsync(state).then(function(data) {
                        $('#city').val(city).trigger('change');
                        $('#city').trigger('change').select2();
                    });
                }
            }, 300);

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

        $(function() {
            $("#txtName").keypress(function(e) {
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

        function updateURL(key, val) {
            var url = window.location.href;
            var reExp = new RegExp("[\?|\&]" + key + "=[0-9a-zA-Z\_\+\-\|\.\,\;]*");

            if (reExp.test(url)) {
                // update
                var reExp = new RegExp("[\?&]" + key + "=([^&#]*)");
                var delimiter = reExp.exec(url)[0].charAt(0);
                url = url.replace(reExp, delimiter + key + "=" + val);
            } else {
                // add
                var newParam = key + "=" + val;
                if (!url.indexOf('?')) {
                    url += '?';
                }

                if (url.indexOf('#') > -1) {
                    var urlparts = url.split('#');
                    url = urlparts[0] + "&" + newParam + (urlparts[1] ? "#" + urlparts[1] : '');
                } else {
                    url += "&" + newParam;
                }
            }
            window.history.pushState(null, document.title, url);
        }

        $('.active-swicher').on('click', function() {
            var active = $(this).attr('data-active');
            updateURL('active', active);
        });
        // $(document).ready(function() {
        //     var table = $('.table').DataTable({
        //         responsive: true,
        //         fixedColumns: true,
        //         fixedHeader: true,
        //         scrollX: false,
        //         'aoColumnDefs': [{
        //             'bSortable': false,
        //             'aTargets': ['nosort']
        //         }],


        //     });
        // });
        $('#UserShopForm').validate();

        document.getElementById('logo').onchange = function() {
            var src = URL.createObjectURL(this.files[0])
            $('#logo_file').removeClass('d-none');
            document.getElementById('logo_file').src = src
        }
        var features = $('.repeater').repeater({

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

        @if (isset($features['features']))
            @if ($features['features'] != null)
                features.setList([
                    @foreach ($features['features'] as $feature)
                        {
                            'title': "{{ $feature['title'] }}",
                            'icon': "{{ $feature['icon'] }}",
                        },
                    @endforeach
                ]);
            @endif
        @endif
        // OTP Check

        $('#otpButton').on('click', function(e) {
            e.preventDefault();
            var number = $('.additionalNumber').val();
            $.ajax({
                url: "{{ route('panel.user.send-otp') }}",
                method: 'GET',
                data: {
                    phone_no: number
                },
                success: function(response) {
                    if (response.title == 'Error') {
                        $.toast({
                            heading: response.title,
                            text: response.message,
                            showHideTransition: 'slide',
                            icon: 'error',
                            loaderBg: '#f2a654',
                            position: 'top-right'
                        });
                    } else {
                        $.toast({
                            heading: response.title,
                            text: response.message,
                            showHideTransition: 'slide',
                            icon: 'success',
                            loaderBg: '#f96868',
                            position: 'top-right'
                        });

                        $('#verifyOTP').removeClass('d-none');
                        $('.additionalNumber').attr('readonly', true);
                        $('#OTP').html(response.otp)
                    }
                }
            })
        });
        $('#verifyOTP').on('click', function(e) {
            e.preventDefault();
            $('#saveBtn').attr('disabled', false);
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
                    if (response.title == 'Error') {
                        $.toast({
                            heading: response.title,
                            text: response.message,
                            showHideTransition: 'slide',
                            icon: 'error',
                            loaderBg: '#f2a654',
                            position: 'top-right'
                        });
                    } else {
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
        $('#save_additional_number').on('click', function(e) {
            e.preventDefault();
            var phone_number = $('.additionalNumbers').val();
            var user_id = $(this).data('user_id');
            $('#updateAdditionalNumber').append(
                `<input type='hidden' name='additional_phone' value=${phone_number} />`);
            $('.userId').val(user_id);
            $('.userAdditionalNoUpdate').val('updateByAdmin');
            $('#updateAdditionalNumber').submit();
        });
        $('#saveBtn').on('click', function(e) {
            e.preventDefault();
            var phone_number = $('.additionalNumber').val();
            $('#updateAdditionalNumber').append(
                `<input type='number' name='additional_phone' value=${phone_number} />`);
            $('#updateAdditionalNumber').submit();

        });
    </script>
@endpush
