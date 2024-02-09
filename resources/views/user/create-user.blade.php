@extends('backend.layouts.main')
@section('title', 'Add User')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet"
            href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/jquery-minicolors/jquery.minicolors.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/datedropper/datedropper.min.css') }}">
    @endpush
    <style>
        body {
            counter-reset: ashu;
        }

        .sno::before {
            content: counter(ashu) ". ";
            counter-increment: ashu;
        }
    </style>


    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-user-plus bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Add User') }}</h5>
                            {{-- <span>{{ __('Create new user, assign roles & permissions')}}</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('dashboard') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Add User') }}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            @include('backend.include.message')
            <!-- end message area-->
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h3>{{ __('Add user') }}</h3>
                    </div>
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('panel.create-user') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label for="name">{{ __('Username') }}<span
                                                    class="text-red">*</span></label>
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}" placeholder="Enter user name" required>
                                            <div class="help-block with-errors"></div>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="email">{{ __('Email') }}<span
                                                    class="text-red">*</span></label>
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" placeholder="Enter email address" required>
                                            <div class="help-block with-errors"></div>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">{{ __('Password') }}<span
                                                        class="text-red">*</span></label>
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" placeholder="Enter password" required>
                                                <div class="help-block with-errors"></div>

                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password-confirm">{{ __('Confirm Password') }}<span
                                                        class="text-red">*</span></label>
                                                <input id="password-confirm" type="password" class="form-control"
                                                    name="password_confirmation" placeholder="Retype password" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{ __('Status') }}<span class="text-red">*</span>
                                                </label>
                                                <select required name="status" class="form-control select2">
                                                    <option value="" readonly>{{ __('Select Status') }}</option>
                                                    @foreach (getStatus() as $index => $item)
                                                        <option @if ($item['id'] == 1) selected @endif
                                                            value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{ __('NBD Cat Id#') }}</label>
                                                <input type="text" name="nbdcatid" id="nbdcatid" class="form-control"
                                                    placeholder="Enter NBD Cat ID#">
                                            </div>
                                        </div>

                                        {{-- Permissions --}}

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="d-grid my-3">
                                                    {{-- <button class="btn btn-outline-primary" id="openop" type="button">Panel Access</button> --}}
                                                    <button class="btn btn-outline-primary" type="button"
                                                        id="usersupplier">Supplier Access</button>
                                                    <button class="btn btn-outline-primary" type="button"
                                                        id="userdealer">Dealer
                                                        Access</button>
                                                    <button class="btn btn-outline-primary " type="button"
                                                        id="userexporter">Exporter Access</button>
                                                </div>

                                                @php
                                                    $user = auth()->user();
                                                    $permi = json_decode($user->account_permission);
                                                    $permi->bulkupload = $permi->bulkupload ?? 'no';
                                                    $permi->manage_categories = $permi->manage_categories ?? 'no';
                                                    $permi->mysupplier = $permi->mysupplier ?? 'no';
                                                    $permi->manangebrands = $permi->manangebrands ?? 'no';
                                                    $permi->offers = $permi->offers ?? 'no';
                                                    $permi->documentaion = $permi->documentaion ?? 'no';
                                                    $permi->maya = $permi->maya ?? 'no';
                                                @endphp

                                                <table class="table align-middle d-ndone">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Access</th>
                                                            <th scope="col">Enable</th>
                                                            <th scope="col">Disable</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                        <tr>
                                                            <th scope="row" class="sno"></th>
                                                            <td>Category Group</td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="yes" id="managegroupyes"
                                                                        name="managegroup"
                                                                        {{ $permi->manage_categories == 'yes' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="no" id="managegroupno"
                                                                        name="managegroup"
                                                                        {{ $permi->manage_categories == 'no' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                        </tr>



                                                        <tr>
                                                            <th scope="row" class="sno"></th>
                                                            <td>Bulk Uploads + Filemanager</td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="yes" id="bulkuploadyes"
                                                                        name="bulkupload"
                                                                        {{ $permi->bulkupload == 'yes' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="no" id="bulkuploadno"
                                                                        name="bulkupload"
                                                                        {{ $permi->bulkupload == 'no' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <th scope="row" class="sno"></th>
                                                            <td>Settings</td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="yes" id="Filemanageryes"
                                                                        name="Filemanager"
                                                                        {{ $permi->Filemanager == 'yes' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="no" id="Filemanagerno"
                                                                        name="Filemanager"
                                                                        {{ $permi->Filemanager == 'no' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row" class="sno"></th>
                                                            <td>Offers</td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="yes" id="offersyes" name="offers"
                                                                        {{ $permi->offers == 'yes' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="no" id="offersno" name="offers"
                                                                        {{ $permi->offers == 'no' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row" class="sno"></th>
                                                            <td>Display</td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="yes" id="addandedityes"
                                                                        name="addandedit"
                                                                        {{ $permi->addandedit == 'yes' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="no" id="addandeditno"
                                                                        name="addandedit"
                                                                        {{ $permi->addandedit == 'no' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row" class="sno"></th>
                                                            <td>Documentaion</td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="yes" id="documentationyes"
                                                                        name="documentaion"
                                                                        {{ $permi->documentaion == 'yes' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="no" id="documentationno"
                                                                        name="documentaion"
                                                                        {{ $permi->documentaion == 'no' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row" class="sno"></th>
                                                            <td>Maya</td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="yes" id="mayayes" name="maya"
                                                                        {{ $permi->maya == 'yes' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="no" id="mayano" name="maya"
                                                                        {{ $permi->maya == 'no' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <th scope="row" class="sno"></th>
                                                            <td>My-Customer</td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="yes" id="mycustomeryes"
                                                                        name="mycustomer"
                                                                        {{ $permi->mycustomer == 'yes' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="no" id="mycustomerno"
                                                                        name="mycustomer"
                                                                        {{ $permi->mycustomer == 'no' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row" class="sno"></th>
                                                            <td>My Supplier</td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="yes" id="mysupplieryes"
                                                                        name="mysupplier"
                                                                        {{ $permi->mysupplier == 'yes' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="no" id="mysupplierno"
                                                                        name="mysupplier"
                                                                        {{ $permi->mysupplier == 'no' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                        </tr>






                                                        <tr>
                                                            <th scope="row" class="sno"></th>
                                                            <td>Price Group</td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="yes" id="pricegroupyes"
                                                                        name="pricegroup"
                                                                        {{ $permi->pricegroup == 'yes' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="no" id="pricegroupno"
                                                                        name="pricegroup"
                                                                        {{ $permi->pricegroup == 'no' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row" class="sno"></th>
                                                            <td>Manage Brand</td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="yes" id="manangebrandsyes"
                                                                        name="manangebrands"
                                                                        {{ $permi->manangebrands == 'yes' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        value="no" id="manangebrandsno"
                                                                        name="manangebrands"
                                                                        {{ $permi->manangebrands == 'no' ? 'checked' : '' }}>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="2">
                                                                <button class="btn btn-info btn-sm" type="button"
                                                                    onclick="checkall()">Select All</button>
                                                                <button class="btn btn-danger btn-sm" type="button"
                                                                    onclick="decheckall()">Unslect All</button>
                                                            </td>

                                                        </tr>

                                                    </tbody>
                                                </table>


                                            </div>
                                        </div>

                                        {{-- Permissions End --}}




                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gender">{{ __('Gender') }}<span
                                                        class="text-red">*</span></label>
                                                <div class="form-radio">
                                                    <form>
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" name="gender" value="male"
                                                                    checked="checked">
                                                                <i class="helper"></i>{{ __('Male') }}
                                                            </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" name="gender" value="female">
                                                                <i class="helper"></i>{{ __('Female') }}
                                                            </label>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-lg-7 form-group">
                                            <label for="role">{{ __('Assign Role') }}<span class="text-red"
                                                    required>*</span></label>
                                            {!! Form::select('role', $roles, null, [
                                                'class' => 'form-control select2',
                                                'placeholder' => 'Select Role',
                                                'id' => 'role',
                                                'required' => 'required',
                                            ]) !!}
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="form-group  d-none isSellerContainer">
                                                <label for=""></label>
                                                <div class="form-check p-0">
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="is_seller"
                                                            class="custom-control-input isSeller"
                                                            @if (old('is_seller')) id="is_seller"  checked @endif>
                                                        <span class="custom-control-label">&nbsp; Seller</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-4 pr-1 seller_option">
                                            <div class="form-group">
                                                <label for="sitename">{{ __('Site Name')}}</label>
                                                <input id="sitename" type="text" class="form-control" name="site_name" placeholder="Enter Site Name" >
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div> --}}
                                        <div class="col-md-6 px-1 seller_option">
                                            <div class="form-group">
                                                <label for="img">{{ __('V-card') }}</label>
                                                <input type="file" class="form-control" name="img">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-1 seller_option">
                                            <div class="form-group">
                                                <label for="img">{{ __('Access Code') }}</label>
                                                <input type="text" class="form-control" name="access_code"
                                                    placeholder="Enter Access Code">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 industry-div d-none">
                                            <div class="form-group">
                                                <label for="phone">{{ __('Industry') }}<span
                                                        class="text-red">*</span></label>
                                                <select name="industry_id[]" class="form-control select2"
                                                    id="industry_id" multiple>
                                                    @foreach (App\Models\Category::whereCategoryTypeId(13)->whereParentId(null)->whereType(1)->get() as $item)
                                                        <option
                                                            {{ in_array($item->id, old('industry_id') ?: []) ? 'selected' : '' }}
                                                            value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">{{ __('Contact Number') }}<span class="text-red"
                                                        required>*</span></label>
                                                <input required id="phone" type="number" class="form-control"
                                                    name="phone" placeholder="Enter Contact Number" min=""
                                                    value="{{ old('phone') }}">
                                                <div class="help-block with-errors" id="phone-error"></div>
                                                <a href="#" class="btn-link" id="getdummynum">Generate Number for test</a>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dob">{{ __('DOB') }}</label>
                                                <input class="form-control" value="{{ old('dob') }}"
                                                    max='{{ \Carbon\Carbon::now()->format('Y-m-d') }}' type="date"
                                                    name="dob" placeholder="Select your date" />
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit"
                                            class="btn btn-primary float-right">{{ __('Submit') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
        <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
        <!--get role wise permissiom ajax script-->
        <script src="{{ asset('backend/js/get-role.js') }}"></script>
        <script src="{{ asset('backend/plugins/moment/moment.js') }}"></script>
        <script>
            $('.seller_option').hide();
            $(document).ready(function() {
                $('#role').change(function() {
                    $('#industry_id').removeAttr('required');
                    $('.industry-div').addClass('d-none');
                    if ($(this).val() == 3) {
                        $('#industry_id').prop('required', true);
                        $('.isSellerContainer').removeClass('d-none');
                        $('.industry-div').removeClass('d-none');
                    } else {
                        $('.isSellerContainer').addClass('d-none');
                    }
                });
                $('.isSeller').click(function() {
                    $('.seller_option').toggle();
                });

                $("#userexporter").click()
            });

            $(document).on('input', "#phone", function() {
                if ($(this).val().length < 10) {
                    $(this).addClass('is-invalid');
                } else if ($(this).val().length > 10) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
                let msg = $(this).val().length < 10 ? 'Phone number must be 10 digit' : '';
                $("#phone-error").text(msg);
            });


            $(document).on('click', '#getdummynum', function(e) {
                e.preventDefault();
                $('#phone').val(generateRandomNumber());
            });



            function generateRandomNumber() {
                // Generate a random digit between 1 and 4 for the first position
                const firstDigit = Math.floor(Math.random() * 4) + 1;

                // Generate the remaining 9 digits randomly
                const remainingDigits = Array.from({
                    length: 9
                }, () => Math.floor(Math.random() * 10)).join('');

                // Concatenate the first digit and the remaining digits
                const randomNumber = `${firstDigit}${remainingDigits}`;

                return randomNumber;
            }

            // Example usage
            const random10DigitNumber = generateRandomNumber();
            console.log(random10DigitNumber);



            // $("#openop").click(function() {
            //     $('table').toggleClass('d-none')
            // });

            // // change if Check Box not Cliked
            // $("#is_seller").change(function() {
            //     $('table').toggleClass('d-none')
            // });

            // //  Check If Seller Panel is On Or Not
            // if ($("#is_seller").attr('checked')) {
            //     $('table').toggleClass('d-none')
            // };


            // function checkall() {
            //     var chk = document.querySelectorAll('#yes');
            //     for (let i = 0; i < chk.length; i++) {
            //         if (chk[i].checked == true) {
            //             chk[i].checked = false
            //         }else{
            //             chk[i].checked = true
            //         }
            //     }
            // }





            function checkall() {
                var arr_yes = ['mycustomeryes', 'Filemanageryes', 'addandedityes', 'bulkuploadyes', 'pricegroupyes',
                    'mysupplieryes', 'managegroupyes', 'manangebrandsyes', 'offersyes', 'documentationyes', 'mayayes'
                ];


                $.each(arr_yes, function(indexInArray, valueOfElement) {
                    var checkbx = $('#' + valueOfElement);
                    checkbx.prop("checked", true)
                });


            }


            function decheckall() {
                var arr_no = ['mycustomerno', 'Filemanagerno', 'addandeditno', 'bulkuploadno', 'pricegroupno', 'mysupplierno',
                    'managegroupno', 'manangebrandsno', 'offersno', 'documentationno', 'mayano'
                ];

                $.each(arr_no, function(indexInArray, valueOfElement) {
                    var checkbx = $('#' + valueOfElement);
                    checkbx.prop("checked", true)
                });
            }

            $("#usersupplier").click(function(e) {
                e.preventDefault();
                $(".btn").removeClass('active');
                $(this).toggleClass('active');
                var arr_supplier = ['Filemanageryes', 'offersyes', 'bulkuploadyes', 'managegroupyes'];
                var arr_dealer = ['mysupplierno', 'manangebrandsno', 'pricegroupno', 'mycustomerno', 'addandeditno',
                    'documentationno', 'mayano'
                ];


                $.each(arr_supplier, function(indexInArray, valueOfElement) {
                    var checkbx = $('#' + valueOfElement);
                    checkbx.prop("checked", true)
                });

                $.each(arr_dealer, function(indexInArray, valueOfElement) {
                    var checkbx = $('#' + valueOfElement);
                    checkbx.prop("checked", true)
                });


            });

            $("#userdealer").click(function(e) {
                e.preventDefault();

                $(".btn").removeClass('active');
                $(this).toggleClass('active');
                var arr_supplier = ['Filemanageryes', 'offersyes', 'managegroupyes', 'addandedityes'];
                var arr_dealer = ['mysupplierno', 'manangebrandsno', 'pricegroupno', 'mycustomerno', 'documentationno',
                    'mayano', 'bulkuploadno'
                ];



                $.each(arr_dealer, function(indexInArray, valueOfElement) {
                    var checkbx = $('#' + valueOfElement);
                    checkbx.prop("checked", true)
                });

                $.each(arr_supplier, function(indexInArray, valueOfElement) {
                    var checkbx = $('#' + valueOfElement);
                    checkbx.prop("checked", true)
                });
            });


            $("#userexporter").click(function(e) {
                e.preventDefault();
                $(".btn").removeClass('active');
                $(this).toggleClass('active');

                var arr_supplier = ['Filemanageryes', 'offersyes', 'managegroupyes', 'bulkuploadyes'];
                var arr_dealer = ['mysupplierno', 'manangebrandsno', 'pricegroupno', 'mycustomerno', 'documentationno',
                    'mayano', 'addandeditno'
                ];



                $.each(arr_dealer, function(indexInArray, valueOfElement) {
                    var checkbx = $('#' + valueOfElement);
                    checkbx.prop("checked", true)
                });

                $.each(arr_supplier, function(indexInArray, valueOfElement) {
                    var checkbx = $('#' + valueOfElement);
                    checkbx.prop("checked", true)
                });
            });
        </script>
    @endpush
@endsection
