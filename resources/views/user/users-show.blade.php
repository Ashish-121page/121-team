@extends('backend.layouts.main')
@section('title', 'Show User')
@section('content')

    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/fullcalendar/dist/fullcalendar.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/datedropper/datedropper.min.css') }}">
    @endpush

    <style>
        .customer-buttons {
            margin-bottom: 15px;
        }

        .note-toolbar-wrapper {
            height: 50px !important;
            overflow-x: auto;
        }

        .dgrid {
            display: grid !important;
        }

    </style>
    @php
        $ekyc = json_decode($user->ekyc_info);
        $user_shop = App\Models\UserShop::whereUserId($user->id)->first();
    @endphp 



    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fas fa-user bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ $user->name }}</h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('panel.dashboard') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Customer') }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Profile') }}</li>
                        </ol>
                    </nav>

                </div>
            </div>
        </div>

        @include('backend.include.message')

        <div class="row">
            <div class="col-lg-9 col-md-8 col-12 mx-auto justify-content-center">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills custom-pills border-0 mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">   
                                <a data-active="my-info" class="mr-2  btn pills-btn text-white @if(request()->has('active') && request()->get('active') == "my-info") active  @endif" id="pills-my-info-tab" data-toggle="pill" href="{{ route('panel.user_shops.edit',[$user_shop->id,'active'=>'my-info']) }}" role="tab" aria-controls="pills-my-info" aria-selected="false">{{ __('My Info')}}</a>
                            </li>
                            <li class="nav-item ">
                                <a   class="mr-2 text-white pills-btn btn " href="{{ route('panel.user_shops.edit',[$user_shop->id,'active'=>'about-me']) }}">{{ __('About Me')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="mr-2 btn pills-btn text-white" id="pills-my-address-tab" href="{{ route('panel.user_shops.edit',[$user_shop->id,'active'=>'my-address']) }}">{{ __('My Address')}}</a>
                            </li>
                            <li class="nav-item">
                                <a  class="mr-2  btn pills-btn text-white" href="{{ route('panel.user_shops.edit',[$user_shop->id,'active'=>'business_profile']) }}">{{ __('Business Profile')}}</a>
                            </li>
                            <li class="nav-item">
                                <a data-active="features" class="mr-2  btn pills-btn text-white" href="{{ route('panel.user_shops.edit',[$user_shop->id,'active'=>'security']) }}">{{ __('Security')}}</a>
                            </li>
                        </ul>
                        
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade   @if(request()->get('showtype') != "EKYC")show active @endif" id="current-month" role="tabpanel" aria-labelledby="pills-activity-tab">
                                <form action="{{ route('panel.update-user-profile', $user->id) }}" method="POST" class="form-horizontal">
                                    @csrf
                                    <div class="row">
    
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name">{{ __('User Name')}}<span class="text-red">*</span></label>
                                                <input type="text" placeholder="Enter Name" class="form-control" name="name" id="name" value="{{ $user->name }}">
                                            </div>  
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">{{ __('Email')}}<span class="text-red">*</span></label>
                                                <input readonly type="email" placeholder="test@test.com" class="form-control" name="email" id="email" value="{{ $user->email }}">
                                            </div>  
                                        </div>
                                            
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="phone">{{ __('Phone No')}}<span class="text-red">*</span></label>
                                                <input type="number" placeholder="123 456 7890" id="phone" name="phone" class="form-control" value="{{ $user->phone }}"required >
                                            </div>  
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dob">{{ __('DOB')}}<span class="text-red">*</span></label>
                                                <input id="" class="form-control" type="date" name="dob" placeholder="Select your birth date" required value="{{ $user->dob }}" />
                                                <div class="help-block with-errors"></div>
                                            </div>  
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Gender</label>
                                                <div class="form-radio">
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" name="gender"  required value="male" @if ($user->gender == 'male') checked @endif>
                                                                <i class="helper"></i>{{ __('Male')}}
                                                            </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" name="gender" value="female" @if ($user->gender == 'female') checked @endif>
                                                                <i class="helper"></i>{{ __('Female')}}
                                                            </label>
                                                        </div>
                                                </div>                                        
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        @if(UserRole($user->id)['name'] == "User")
                                            <div class="col-md-4">
                                                @php
                                                    $industry = json_decode($user->industry_id,true);
                                                @endphp
                                                <div class="form-group">
                                                    <label for="phone">{{ __('Industry')}}<span class="text-red">*</span></label>
                                                    <select @if(UserRole($user->id)['name'] == "User") required @endif name="industry_id[]" class="form-control select2" multiple id="industry_id">
                                                        @foreach(App\Models\Category::where('category_type_id',13)->get() as $category)
                                                            <option value="{{ $category->id }}" @if(isset($industry)) {{ in_array($category->id,$industry) ? 'selected' :'' }} @endif> {{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>  
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <button type="submit" class="btn btn-success"  >Update Profile</button>
                                </form>
                            </div>
                            <div class="tab-pane fade @if(request()->get('showtype') == "EKYC") show active @endif " id="previous-month" role="tabpanel" aria-labelledby="pills-note-tab">
                                <form action="{{ route('panel.update-ekyc-status', $user->id) }}" method="POST" class="form-horizontal">
    
                                        @if($user->ekyc_status == 0)
                                        <div class="alert alert-info">
                                            eKyc Request isn't submitted yet!
                                        </div>
                                    @elseif($user->ekyc_status == 1)
                                        <div class="alert alert-success">
                                            User eKyc Request has been verified!
                                        </div>
                                    @elseif($user->ekyc_status == 2)
                                        <div class="alert alert-danger">
                                            User eKyc Request has been rejected!
                                        </div>
                                    @elseif($user->ekyc_status == 3)
                                        <div class="alert alert-warning">
                                            User submited eKyc Request, Please validate and take appropriated action.
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

                                            <hr class="m-2">
                                            @if(AuthRole() == 'Admin')
                                                @if($user->ekyc_status == 1)
                                                    <div class="col-md-12 col-12 mt-5"> 
                                                        <label>{{ __('Note')}}</label>
                                                        <textarea class="form-control" name="remark" type="text" >{{ $ekyc->admin_remark ?? '' }}</textarea>
                                                        <button type="submit" class="btn btn-danger mt-2 btn-lg reject">Reject</button>
                                                    </div>
                                                @elseif($user->ekyc_status == 2)
                                                    <div class="col-md-12 col-12 mt-5"> 
                                                        <button type="submit" class="btn btn-success mt-2 btn-lg accept">Accept</button>
                                                    </div>
                                                @elseif($user->ekyc_status == 3)
                                                    <div class="col-md-12 col-12 mt-5"> <label>{{ __('Rejection Reason (If Any)')}}</label>
                                                        <textarea class="form-control" name="remark" type="text" >{{ $ekyc->admin_remark ?? '' }}</textarea>
                                                        <button  type="submit" class="btn btn-danger mt-2 btn-lg reject">Reject</button>
                                                        <button type="submit" class="btn btn-success accept ml-5 mt-2 btn-lg">Accept</button>
                                                    </div>
                                                @endif
                                            @endif    
                                        </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modals Start--}}
        <div class="modal fade" id="updateProfileImageModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="updateProfileImageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('panel.update-profile-img', $user->id) }}" method="POST" enctype="multipart/form-data">
                    
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateProfileImageModalLabel">Update profile image</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                            @csrf
                            <img 
                            src="{{ ($user && $user->avatar) ? $user->avatar : asset('backend/default/default-avatar.png') }}"
                                class="img-fluid w-50 mx-auto d-block" alt="" id="profile-image">
                            <div class="form-group mt-5">
                                <label for="avatar" class="form-label">Select profile image</label> <br>
                                <input type="file" name="avatar" id="avatar" accept="image/jpg,image/png,image/jpeg">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    {{-- Modals End--}}

   @push('script') 
    
    <script src="{{ asset('backend/plugins/moment/moment.js') }}"></script>
    <script src="{{ asset('backend/plugins/fullcalendar/dist/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datedropper/datedropper.min.js') }}"></script>
    <script src="{{ asset('backend/js/form-picker.js') }}"></script>

    {{-- <script src="{{ asset('backend/js/calendar.js') }}"></script> --}}
        <script>
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

            $(document).ready(function(){

                $('.accept').on('click',function(){
                   $('#status').val(1)
                });
                $('.reject').on('click',function(){
                   $('#status').val(2)
                });

                $('#state, #country, #city').css('width','100%').select2();

                function getStates(countryId =  101) {
                    $.ajax({
                    url: '{{ route("world.get-states") }}',
                    method: 'GET',
                    data: {
                        country_id: countryId
                    },
                    success: function(res){
                        $('#state').html(res).css('width','100%').select2();
                    }
                    })
                }
                getStates(101);

                function getCities(stateId =  101) {
                    $.ajax({
                    url: '{{ route("world.get-cities") }}',
                    method: 'GET',
                    data: {
                        state_id: stateId
                    },
                    success: function(res){
                        $('#city').html(res).css('width','100%').select2();
                    }
                    })
                }
                $('#country').on('change', function(e){
                getStates($(this).val());
                })

                $('#state').on('change', function(e){
                getCities($(this).val());
                })

                // alert('s');
            });
        </script>
       
    @endpush



@endsection
