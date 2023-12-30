@extends('backend.layouts.main')
@section('title', 'Add User')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') }}">
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
                            <h5>{{ __('Add User')}}</h5>
                            {{-- <span>{{ __('Create new user, assign roles & permissions')}}</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{url('dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Add User')}}</a>
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
                        <h3>{{ __('Add user')}}</h3>
                    </div>
                    <div class="card-body">
                        <form class="forms-sample" method="POST" action="{{ route('panel.create-user') }}" enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label for="name">{{ __('Username')}}<span class="text-red">*</span></label>
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Enter user name" required>
                                            <div class="help-block with-errors"></div>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="email">{{ __('Email')}}<span class="text-red">*</span></label>
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter email address" required>
                                            <div class="help-block with-errors" ></div>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">{{ __('Password')}}<span class="text-red">*</span></label>
                                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter password" required>
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
                                                <label for="password-confirm">{{ __('Confirm Password')}}<span class="text-red">*</span></label>
                                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Retype password" required>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{ __('Status')}}<span class="text-red">*</span> </label>
                                                <select required name="status" class="form-control select2">
                                                    <option value="" readonly>{{ __('Select Status')}}</option>
                                                    @foreach (getStatus() as $index => $item)
                                                        <option @if($item['id'] == 1) selected @endif value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">{{ __('NBD Cat Id#')}}</label>
                                                <input type="text" name="nbdcatid" id="nbdcatid" class="form-control" placeholder="Enter NBD Cat ID#">
                                            </div>
                                        </div>

                                        {{-- Permissions --}}

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
                                                              <input class="form-check-input" type="radio" value="yes" id="mycustomeryes" name="mycustomer">
                                                            </div>
                                                          </td>
                                                          <td>
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="radio" value="no" id="mycustomerno" name="mycustomer" >
                                                            </div>
                                                          </td>
                                                        </tr>

                                                        <tr>
                                                          <th scope="row" class="sno"></th>
                                                          <td>My Supplier</td>
                                                          <td>
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="radio" value="yes" id="mysupplieryes" name="mysupplier" >
                                                            </div>
                                                          </td>
                                                          <td>
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="radio" value="no" id="mysupplierno" name="mysupplier" >
                                                            </div>
                                                          </td>
                                                        </tr>


                                                        <tr class="d-none">
                                                          <th scope="row" class="sno"></th>
                                                          <td>Settings</td>
                                                          <td>
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="radio" value="yes" id="Filemanageryes" name="Filemanager" >
                                                            </div>
                                                          </td>
                                                          <td>
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="radio" value="no" id="Filemanagerno" name="Filemanager">
                                                            </div>
                                                          </td>
                                                        </tr>

                                                        <tr>
                                                          <th scope="row" class="sno"></th>
                                                          <td>Display</td>
                                                          <td>
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="radio" value="yes" id="addandedityes" name="addandedit" >
                                                            </div>
                                                          </td>
                                                          <td>
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="radio" value="no" id="addandeditno" name="addandedit" >
                                                            </div>
                                                          </td>
                                                        </tr>

                                                        <tr>
                                                          <th scope="row" class="sno"></th>
                                                          <td>Bulk Uploads + Filemanager</td>
                                                          <td>
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="radio" value="yes" id="bulkuploadyes" name="bulkupload">
                                                            </div>
                                                          </td>
                                                          <td>
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="radio" value="no" id="bulkuploadno" name="bulkupload">
                                                            </div>
                                                          </td>
                                                        </tr>

                                                        <tr>
                                                          <th scope="row" class="sno"></th>
                                                          <td>Price Group</td>
                                                          <td>
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="radio" value="yes" id="pricegroupyes" name="pricegroup" >
                                                            </div>
                                                          </td>
                                                          <td>
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="radio" value="no" id="pricegroupno" name="pricegroup">
                                                            </div>
                                                          </td>
                                                        </tr>

                                                        <tr>
                                                          <th scope="row" class="sno"></th>
                                                          <td>Category Group</td>
                                                          <td>
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="radio" value="yes" id="managegroupyes" name="managegroup">
                                                            </div>
                                                          </td>
                                                          <td>
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="radio" value="no" id="managegroupno" name="managegroup">
                                                            </div>
                                                          </td>
                                                        </tr>

                                                        <tr>
                                                          <th scope="row" class="sno"></th>
                                                          <td>Manage Brand</td>
                                                          <td>
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="radio" value="yes" id="manangebrandsyes" name="manangebrands">
                                                            </div>
                                                          </td>
                                                          <td>
                                                            <div class="form-check">
                                                              <input class="form-check-input" type="radio" value="no" id="manangebrandsno" name="manangebrands">
                                                            </div>
                                                          </td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row" class="sno"></th>
                                                            <td>Offers</td>
                                                            <td>
                                                              <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="yes" id="offersyes" name="offers">
                                                              </div>
                                                            </td>
                                                            <td>
                                                              <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="no" id="offersno" name="offers">
                                                              </div>`
                                                            </td>
                                                          </tr>



                                                        <tr>
                                                            <th scope="row" class="sno"></th>
                                                            <td>Documentaion</td>
                                                            <td>
                                                              <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="yes" id="documentationyes" name="documentaion">
                                                              </div>
                                                            </td>
                                                            <td>
                                                              <div class="form-check">
                                                                <input class="form-check-input" type="radio" value="no" id="documentationsno" name="documentaion">
                                                              </div>`
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

                                        {{-- Permissions End--}}




                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="gender">{{ __('Gender')}}<span class="text-red">*</span></label>
                                                <div class="form-radio">
                                                    <form>
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" name="gender" value="male" checked="checked">
                                                                <i class="helper"></i>{{ __('Male')}}
                                                            </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" name="gender" value="female">
                                                                <i class="helper"></i>{{ __('Female')}}
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
                                            <label for="role">{{ __('Assign Role')}}<span class="text-red" required>*</span></label>
                                            {!! Form::select('role', $roles, null,[ 'class'=>'form-control select2', 'placeholder' => 'Select Role','id'=> 'role', 'required'=> 'required']) !!}
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="form-group  d-none isSellerContainer">
                                                <label for=""></label>
                                                <div class="form-check p-0">
                                                     <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="is_seller" class="custom-control-input isSeller" @if(old('is_seller')) id="is_seller"  checked @endif>
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
                                                <label for="img">{{ __('V-card')}}</label>
                                                <input type="file" class="form-control" name="img" >
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 pl-1 seller_option">
                                            <div class="form-group">
                                                <label for="img">{{ __('Access Code')}}</label>
                                                <input type="text" class="form-control" name="access_code" placeholder="Enter Access Code">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 industry-div d-none">
                                            <div class="form-group">
                                                <label for="phone">{{ __('Industry')}}<span class="text-red">*</span></label>
                                                <select name="industry_id[]" class="form-control select2" id="industry_id" multiple>
                                                    @foreach (App\Models\Category::whereCategoryTypeId(13)->whereParentId(null)->whereType(1)->get() as $item)
                                                        <option {{in_array($item->id, old("industry_id") ?: []) ? "selected": ""}} value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone">{{ __('Contact Number')}}<span class="text-red" required>*</span></label>
                                                <input required id="phone" type="number" class="form-control" name="phone" placeholder="Enter Contact Number" min=""  value="{{ old('phone') }}">
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="dob">{{ __('DOB')}}</label>
                                                <input  class="form-control" value="{{ old('dob') }}" max='{{ \Carbon\Carbon::now()->format('Y-m-d') }}' type="date" name="dob" placeholder="Select your date" />
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary float-right">{{ __('Submit')}}</button>
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
            $(document).ready(function(){
                $('#role').change(function(){
                    $('#industry_id').removeAttr('required');
                    $('.industry-div').addClass('d-none');
                    if($(this).val() == 3){
                        $('#industry_id').prop('required',true);
                        $('.isSellerContainer').removeClass('d-none');
                        $('.industry-div').removeClass('d-none');
                    }else{
                        $('.isSellerContainer').addClass('d-none');
                    }
                });
                $('.isSeller').click(function(){
                    $('.seller_option').toggle();
                });
            });


            $("#openop").click(function () {
              $('table').toggleClass('d-none')
            });

            // change if Check Box not Cliked
            $("#is_seller").change(function () {
                $('table').toggleClass('d-none')
            });

            //  Check If Seller Panel is On Or Not
            if($("#is_seller").attr('checked')) {
                $('table').toggleClass('d-none')
            };


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
                var arr_yes = ['mycustomeryes','Filemanageryes','addandedityes','bulkuploadyes','pricegroupyes','mysupplieryes','managegroupyes','manangebrandsyes','offersyes','documentationyes'];


                $.each(arr_yes, function (indexInArray, valueOfElement) {
                    var checkbx = $('#'+valueOfElement);
                    checkbx.prop("checked", true)
                });


            }


            function decheckall() {
                var arr_no = ['mycustomerno','Filemanagerno','addandeditno','bulkuploadno','pricegroupno','mysupplierno','managegroupno','manangebrandsno','offersno','documentationsno'];

                $.each(arr_no, function (indexInArray, valueOfElement) {
                    var checkbx = $('#'+valueOfElement);
                    checkbx.prop("checked", true)
                });
            }



            $("#usersupplier").click(function (e) {
                e.preventDefault();
                var arr_supplier = ['mycustomeryes','Filemanageryes','addandedityes','offersyes','documentationyes'];
                var arr_dealer = ['mysupplierno','manangebrandsno','pricegroupno','managegroupno','bulkuploadno','documentationsno'];


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
                var arr_dealer = ['mysupplieryes','Filemanageryes','offersyes','documentationyes' ];
                var arr_supplier = ['mycustomerno','addandeditno','pricegroupno','manangebrandsno','bulkuploadno','managegroupno','documentationsno'];

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
