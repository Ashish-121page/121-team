@extends('backend.layouts.main')
@section('title', $user->name)
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/jquery-minicolors/jquery.minicolors.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/datedropper/datedropper.min.css') }}">
    @endpush
    <style>
        .select2-selection.select2-selection--multiple{
            width: 200px !important;
        }
        input[type=radio]{
            cursor: pointer;
        }

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
                            <h5>{{ __('Edit User')}}</h5>
                            {{-- <span>{{ __('Create new user, assign roles & permissions')}}</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('/')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('User')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <!-- clean unescaped data is to avoid potential XSS risk -->
                                {{ clean($user->name, 'titles')}}
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
                <div class="card">
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('panel.update-user', $user->id) }}" novalidate>
                        @csrf
                            <input type="hidden" name="id" value="{{$user->id}}">
                            <div class="form-group d-none">
                                <label for="role" required >{{ __('Assign Role')}}<span class="text-red">*</span></label>
                                {!! Form::select ('role', $roles, $user_role->id ?? '' ,[ 'class'=>'form-control select2', 'placeholder' => 'Select Role','id'=> 'role', 'required'=>'required']) !!}
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">{{ __('Name')}}<span class="text-red">*</span></label>
                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ clean($user->name, 'titles')}}" required>
                                                <div class="help-block with-errors"></div>

                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="email">{{ __('Email')}}<span class="text-red">*</span></label>
                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"  required value="{{ clean($user->email, 'titles')}}" required>
                                                <div class="help-block with-errors"></div>

                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">{{ __('Password')}}</label>
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter password">
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
                                                <label for="password-confirm">{{ __('Confirm Password')}}</label>
                                                <input id="password-confirm" type="password" class="form-control" name="confirm_password" placeholder="Retype password">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{ __('Status')}}<span class="text-red">*</span>  </label>

                                                <select required name="status" class="form-control select2"  >
                                                    <option value="" readonly>{{ __('Select Status')}}</option>
                                                    @foreach (getStatus() as $index => $item)
                                                        <option value="{{ $item['id'] }}" {{ $user->status == $item['id'] ? 'selected' :'' }}>{{ $item['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        @if(UserRole($user->id)->name == 'User')
                                        @php
                                            $industry = json_decode($user->industry_id);
                                        @endphp
                                        <div class="form-group">
                                            <label for="phone">{{ __('Industry')}}<span class="text-red">*</span></label>
                                            <select name="industry_id[]" class="form-control select2" id="industry_id" multiple>
                                                @foreach (App\Models\Category::whereCategoryTypeId(13)->whereParentId(null)->whereType(1)->get() as $item)
                                                    <option @if($industry) {{ in_array($item->id,$industry ?: []) ? "selected": "" }} @endif value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="help-block with-errors"></div>
                                        </div>


                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for=""></label>
                                                <div class="form-check p-0">
                                                    <label class="custom-control custom-checkbox" for="demo_given">
                                                        <input type="checkbox" class="custom-control-input" name="demo_given" @if($user_shop->demo_given == 1) checked @endif value="1" id="demo_given">
                                                        <span class="custom-control-label" style="position: absolute;">Show carousel</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            {{--` Delete All Empty Offer --}}
                                            @php
                                              $draft_offers = App\Models\Proposal::where('user_id',$user->id)->where('status',0)->pluck('id');
                                              $blank_offers = [];
                                              foreach ($draft_offers as $key => $value) {
                                                  if (count(App\Models\ProposalItem::where('proposal_id',$value)->get()) == 0) {
                                                      array_push($blank_offers,$value);
                                                  }
                                              }
                                            @endphp

                                            <a href="{{ route('backend.constant-management.proposals.deleteDraft',$user->id) }}" class="btn btn-sm btn-outline-danger delete-item" title="Delete All Draft Offers Till Now.">
                                                Delete Empty Offer <i class="fa fa-trash" aria-hidden="true"></i> {{ count($blank_offers) }}
                                            </a>
                                        </div>


                                        @endif

                                        @php
                                            $permi = json_decode($user->account_permission);
                                            $permi->bulkupload = $permi->bulkupload ?? 'no';
                                            $permi->manage_categories = $permi->manage_categories ?? 'no';
                                            $permi->mysupplier = $permi->mysupplier ?? 'no';
                                            $permi->manangebrands = $permi->manangebrands ?? 'no';
                                            $permi->offers = $permi->offers ?? 'no';
                                            $permi->documentaion = $permi->documentaion ?? 'no';
                                            $permi->maya = $permi->maya ?? 'no';
                                        @endphp


                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="d-grid my-3">
                                                    <button class="btn btn-primary" id="openop" type="button">Panel Access</button>
                                                    <button class="btn btn-warning" type="button" id="usersupplier">Supplier Access</button>
                                                    <button class="btn btn-danger" type="button" id="userdealer">Dealer Access</button>
                                                  </div>

                                                <table class="table align-middle d-none">
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
                                                        <td>My-Customer</td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="yes" id="mycustomeryes" name="mycustomer" {{ $permi->mycustomer == 'yes' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="no" id="mycustomerno" name="mycustomer" {{ $permi->mycustomer == 'no' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                      </tr>

                                                      <tr>
                                                        <th scope="row" class="sno"></th>
                                                        <td>My Supplier</td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="yes" id="mysupplieryes" name="mysupplier" {{ $permi->mysupplier == 'yes' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="no" id="mysupplierno" name="mysupplier" {{ $permi->mysupplier == 'no' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                      </tr>


                                                      <tr>
                                                        <th scope="row" class="sno"></th>
                                                        <td>Settings</td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="yes" id="Filemanageryes" name="Filemanager" {{ $permi->Filemanager == 'yes' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="no" id="Filemanagerno" name="Filemanager" {{ $permi->Filemanager == 'no' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                      </tr>

                                                      <tr>
                                                        <th scope="row" class="sno"></th>
                                                        <td>Display</td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="yes" id="addandedityes" name="addandedit" {{ $permi->addandedit == 'yes' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="no" id="addandeditno" name="addandedit" {{ $permi->addandedit == 'no' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                      </tr>

                                                      <tr>
                                                        <th scope="row" class="sno"></th>
                                                        <td>Bulk Uploads + Filemanager</td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="yes" id="bulkuploadyes" name="bulkupload" {{ $permi->bulkupload == 'yes' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="no" id="bulkuploadno" name="bulkupload" {{ $permi->bulkupload == 'no' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                      </tr>

                                                      <tr>
                                                        <th scope="row" class="sno"></th>
                                                        <td>Price Group</td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="yes" id="pricegroupyes" name="pricegroup" {{ $permi->pricegroup == 'yes' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="no" id="pricegroupno" name="pricegroup" {{ $permi->pricegroup == 'no' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                      </tr>

                                                      <tr>
                                                        <th scope="row" class="sno"></th>
                                                        <td>Category Group</td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="yes" id="managegroupyes" name="managegroup" {{ $permi->manage_categories == 'yes' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="no" id="managegroupno" name="managegroup" {{ $permi->manage_categories == 'no' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                      </tr>

                                                      <tr>
                                                        <th scope="row" class="sno"></th>
                                                        <td>Manage Brand</td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="yes" id="manangebrandsyes" name="manangebrands" {{ $permi->manangebrands == 'yes' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="no" id="manangebrandsno" name="manangebrands" {{ $permi->manangebrands == 'no' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                      </tr>

                                                      <tr>
                                                        <th scope="row" class="sno"></th>
                                                        <td>Offers</td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="yes" id="offersyes" name="offers" {{ $permi->offers == 'yes' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="no" id="offersno" name="offers" {{ $permi->offers == 'no' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                      </tr>

                                                      <tr>
                                                        <th scope="row" class="sno"></th>
                                                        <td>Documentaion</td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="yes" id="documentationyes" name="documentaion" {{ $permi->documentaion == 'yes' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="no" id="documentationno" name="documentaion" {{ $permi->documentaion == 'no' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                      </tr>

                                                      <tr>
                                                        <th scope="row" class="sno"></th>
                                                        <td>Maya</td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="yes" id="mayayes" name="maya" {{ $permi->maya == 'yes' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                        <td>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" value="no" id="mayano" name="maya" {{ $permi->maya == 'no' ? 'checked' : '' }}>
                                                          </div>
                                                        </td>
                                                      </tr>


                                                      <tr>
                                                        <td colspan="2">
                                                            <button class="btn btn-info btn-sm" type="button" onclick="checkall()">Select All</button>
                                                            <button class="btn btn-danger btn-sm" type="button" onclick="decheckall()">Unslect All</button>
                                                        </td>

                                                      </tr>

                                                    </tbody>
                                                  </table>


                                            </div>
                                        </div>




                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gender">{{ __('Gender')}}</label>
                                                <div class="form-radio">
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" name="gender" checked="checked"  {{ $user->gender == 'Male' ? 'checked' : '' }}>
                                                                <i class="helper"></i>{{ __('Male')}}
                                                            </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" name="gender"  {{ $user->gender == 'Female' ? 'checked' : '' }}>
                                                                <i class="helper"></i>{{ __('Female')}}
                                                            </label>
                                                        </div>
                                                </div>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">{{ __('Contact Number')}}<span class="text-red">*</span></label>
                                                <input id="phone" type="number" class="form-control" name="phone" placeholder="Enter Contact Number"  required value="{{ $user->phone }}" >
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dob">{{ __('DOB')}}</label>
                                                <input class="form-control" type="date" name="dob" max='{{ \Carbon\Carbon::now()->format('Y-m-d') }}' placeholder="Select your date" value="{{ $user->dob }}" />
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for=""></label>
                                                <div class="form-check p-0">
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="is_supplier" @if($user->is_supplier == 1) checked @endif value="1" id="is_supplier">
                                                        <span class="custom-control-label" style="position: absolute;">Enable Seller Panel</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for=""></label>
                                                <div class="form-check p-0">
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="is_verified" @if($user->is_verified == 1) checked @endif value="1" id="is_verified">
                                                        <span class="custom-control-label" style="position: absolute;">Verify Email</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for=""></label>
                                                <div class="form-check p-0">
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="ekyc_status" @if($user->ekyc_status == 1) checked @endif value="1" id="ekyc_status">
                                                        <span class="custom-control-label" style="position: absolute;">Verify KYC</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary form-control-right float-right">{{ __('Update')}}</button>
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
        <script src="{{ asset('backend/js/get-role.js') }}"></script>

        <script>
            $("#openop").click(function () {
              $('table').toggleClass('d-none')
            });

            // change if Check Box not Cliked
            $("#is_supplier").change(function () {
                $('table').toggleClass('d-none')
            });

            //  Check If Seller Panel is On Or Not
             if ($("#is_supplier").attr('checked')) {
                $('table').toggleClass('d-none')
             }

            function checkall() {
                var arr_yes = ['mycustomeryes','Filemanageryes','addandedityes','bulkuploadyes','pricegroupyes','mysupplieryes','managegroupyes','manangebrandsyes','offersyes','documentationyes'];


                $.each(arr_yes, function (indexInArray, valueOfElement) {
                    var checkbx = $('#'+valueOfElement);
                    checkbx.prop("checked", true)
                });


            }


            function decheckall() {
                var arr_no = ['mycustomerno','Filemanagerno','addandeditno','bulkuploadno','pricegroupno','mysupplierno','managegroupno','manangebrandsno','offersno','documentationno'];

                $.each(arr_no, function (indexInArray, valueOfElement) {
                    var checkbx = $('#'+valueOfElement);
                    checkbx.prop("checked", true)
                });
            }

            $("#usersupplier").click(function (e) {
                e.preventDefault();
                var arr_supplier = ['mycustomeryes','Filemanageryes','addandedityes','offersyes','bulkuploadyes','managegroupyes','documentationyes'];
                var arr_dealer = ['mysupplierno','manangebrandsno','pricegroupno'];


                $.each(arr_supplier, function (indexInArray, valueOfElement) {
                    var checkbx = $('#'+valueOfElement);
                    checkbx.prop("checked", true)
                });

                $.each(arr_dealer, function (indexInArray, valueOfElement) {
                    var checkbx = $('#'+valueOfElement);
                    checkbx.prop("checked", true)
                });


            });

            $("#userdealer").click(function (e) {
                e.preventDefault();
                var arr_dealer = ['mysupplieryes','Filemanageryes','offersyes'];
                var arr_supplier = ['mycustomerno','addandeditno','pricegroupno','manangebrandsno','bulkuploadno','managegroupno','documentationno'];

                $.each(arr_dealer, function (indexInArray, valueOfElement) {
                    var checkbx = $('#'+valueOfElement);
                    checkbx.prop("checked", true)
                });

                $.each(arr_supplier, function (indexInArray, valueOfElement) {
                    var checkbx = $('#'+valueOfElement);
                    checkbx.prop("checked", true)
                });
            });



          </script>
    @endpush
@endsection
