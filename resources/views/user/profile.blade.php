@extends('backend.layouts.main') 
@section('title', 'Profile')
@section('content')
@push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/datedropper/datedropper.min.css') }}">
@endpush

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-file-text bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Profile')}}</h5>
                            {{-- <span>{{ __('Update Profile')}}</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('panel.dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Pages')}}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Profile')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            @include('backend.include.message')
            <div class="col-lg-4 col-md-5">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center"> 
                            <div style="width: 150px; height: 150px; position: relative" class="mx-auto">
                                <img src="{{ ($user && $user->avatar) ? $user->avatar : asset('backend/default/default-avatar.png') }}" class="rounded-circle" width="150" style="object-fit: cover; width: 150px; height: 150px" />
                                <button class="btn btn-dark rounded-circle position-absolute" style="width: 30px; height: 30px; padding: 8px; line-height: 1; top: 0; right: 0"  data-toggle="modal" data-target="#updateProfileImageModal"><i class="ik ik-camera"></i></button>
                            </div>
                            <h4 class="card-title mt-10">{{auth()->user()->name}}</h4>
                            <p class="card-subtitle">{{ ucfirst(auth()->user()->roles[0]->name ?? '') }}</p>
                        </div>
                    </div>
                    <hr class="mb-0"> 
                    <div class="card-body"> 
                        <small class="text-muted d-block">{{ __('Email address')}} </small>
                        <h6>{{ $user->email }}</h6> 
                        <small class="text-muted d-block pt-10">{{ __('Phone')}}</small>
                        <h6>{{ $user->phone }}</h6> 
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-7">
                <div class="card">
                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">{{ __('Profile')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">{{ __('Setting')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-timeline-tab" data-toggle="pill" href="#current-month" role="tab" aria-controls="pills-timeline" aria-selected="true">{{ __('Account')}}</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" id="pills-security-tab" data-toggle="pill" href="#security" role="tab" aria-controls="pills-security" aria-selected="true">{{ __('Security')}}</a>
                        </li> --}}
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 col-6"> <strong>{{ __('Full Name')}}</strong>
                                        <br>
                                        <p class="text-muted">{{ $user->name }}</p>
                                    </div>
                                    <div class="col-md-3 col-6"> <strong>{{ __('Mobile')}}</strong>
                                        <br>
                                        <p class="text-muted">{{ $user->phone }}</p>
                                    </div>
                                    <div class="col-md-3 col-6"> <strong>{{ __('Email')}}</strong>
                                        <br>
                                        <p class="text-muted">{{ $user->email }}</p>
                                    </div>
                                    <div class="col-md-3 col-6"> <strong>{{ __('Location')}}</strong>
                                        <br>
                                        <p class="text-muted">{{ fetchFirst('App\Models\City',$user->city,'name') }} , {{ fetchFirst('App\Models\State',$user->state,'name') }}</p>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                            <div class="card-body">
                                <form action="{{ route('panel.update-user-profile', $user->id) }}" method="POST" class="form-horizontal">
                                    @csrf
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name">{{ __('Full Name')}}</label>
                                                <input type="text" placeholder="Johnathan Doe" class="form-control" name="name" id="name" value="{{ $user->name }}">
                                            </div>  
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">{{ __('Email')}}</label>
                                                <input type="email" placeholder="test@test.com" class="form-control" name="email" id="email" value="{{ $user->email }}">
                                            </div>  
                                        </div>
                                         
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="phone">{{ __('Phone No')}}</label>
                                                <input type="text" placeholder="123 456 7890" id="phone" name="phone" class="form-control" value="{{ $user->phone }}">
                                            </div>  
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="dob">{{ __('DOB')}}</label>
                                                <input id="dropper-default" class="form-control" type="text" name="dob" placeholder="Select your date" value="{{ $user->dob }}" />
                                                <div class="help-block with-errors"></div>
                                            </div>  
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gender">{{ __('Gender')}}<span class="text-red">*</span></label>
                                                <div class="form-radio">
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" name="gender" value="male" checked>
                                                                <i class="helper"></i>{{ __('Male')}}
                                                            </label>
                                                        </div>
                                                        <div class="radio radio-inline">
                                                            <label>
                                                                <input type="radio" name="gender" value="female">
                                                                <i class="helper"></i>{{ __('Female')}}
                                                            </label>
                                                        </div>
                                                </div>                                        
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="phone">{{ __('Industry')}}<span class="text-red">*</span></label>
                                                <select @if(UserRole($user->id)['name'] == "User") required @endif name="industry_id[]" class="form-control select2" multiple id="industry_id">
                                                    @foreach(App\Models\Category::where('category_type_id',13)->get() as $category)
                                                        <option value="{{ $category->id }}" @if($user->industry_id && gettype($user->industry_id) != 'string'){{in_array($category->id,json_decode($user->industry_id)) ? 'selected' :'' }} @endif> {{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>  
                                        </div>
                                        <div class="col-md-6 d-none">.
                                            <div class="form-group">
                                                <label for="country">{{ __('Country')}}</label>
                                                <select name="country" id="country" class="form-control select2">
                                                    <option value="" readonly>{{ __('Select Country')}}</option>
                                                    @foreach (\App\Models\Country::all() as  $country)
                                                        <option value="{{ $country->id }}" @if($user->country != null) {{ $country->id == $user->country ? 'selected' : '' }} @elseif($country->name == 'India') selected @endif>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                                
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-none">
                                            <div class="form-group">
                                                <label for="state">{{ __('State')}}</label> 
                                                <select name="state" id="state" class="form-control select2">
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-none">
                                            <div class="form-group">
                                                <label for="city">{{ __('City')}}</label>
                                                <select name="city" id="city" class="form-control select2">
                                                </select> 
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-none">
                                            <div class="form-group">
                                                <label for="pincode">{{ __('Pincode')}}</label>
                                                <input id="pincode" type="number" class="form-control" name="pincode" placeholder="Enter Pincode" value="{{ $user->pincode }}" >
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-none">
                                            <div class="form-group">
                                                <label for="pincode">{{ __('Timezone')}}</label>
                                                <select name="timezone" class="form-control" id="timezone">
                                                    @foreach (config('time-zone') as $zone)
                                                        <option value="{{ $zone['name'] }}" {{ $zone['name'] == $user->timezone ? 'selected' : '' }}>{{ $zone['name'] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-none">
                                            <div class="form-group">
                                                <label for="pincode">{{ __('language')}}</label>
                                                <select name="language" class="form-control" id="language">
                                                    @foreach (config('language') as $lang)
                                                        <option value="{{ $lang['code'] }}" {{ $lang['code'] == $user->language ? 'selected' : '' }}>{{ $lang['name'] }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="address">{{ __('Address')}}</label>
                                                <textarea name="address" name="address" rows="5" class="form-control">{{ $user->address }}</textarea>
                                            </div>  
                                        </div>                                    
                                    </div>
                                    
                                    <button type="submit" class="btn btn-success"  >Update Profile</button>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card-header py-2">
                                            <p class="card-title m-0">Change Password</p>
                                        </div>
                                        <form action="{{ route('panel.update-password', $user->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label class="">Old Password :</label>
                                                <input required type="password" class="form-control ps-5" placeholder="Old password" name="old_password">
                                            </div>
                                            <div class="form-group">
                                                <label for="password">New Password</label>
                                                <input type="password" class="form-control" name="password" placeholder="New Password" id="password">
                                            </div>
                                            <div class="form-group">
                                                <label for="confirm-password">Confirm Password</label>
                                                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" id="confirm-password">
                                            </div>
                                            <button class="btn btn-success" type="submit">Update Password</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="pills-security-tab">
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card">
                                            <div class="card-header py-2">
                                                <p class="card-title m-0">Change Passwordddd</p>
                                            </div>
                                            <div class="card-body">
                                                <p>Security Not Yet! </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
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
                        src="{{ ($user && $user->avatar) ? asset('storage/backend/users/'.$user->avatar) : asset('backend/default/default-avatar.png') }}"
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

    @push('script') 
        <script src="{{ asset('backend/plugins/datedropper/datedropper.min.js') }}"></script>
        <script src="{{ asset('backend/js/form-picker.js') }}"></script>

           <script>
            $(document).ready(function(){
                var country = "{{ $user->country }}";
                var state = "{{ $user->state }}";
                var city = "{{ $user->city }}";
                if(state){
                    getStateAsync([country]).then(function(data){
                        $('#state').val(state).change();
                        $('#state').trigger('change');
                    });
                }
                if(city){
                    $('#state').on('change', function(){
                        if(state == $(this).val()){
                            getCityAsync([state]).then(function(data){
                                $('#city').val(city);
                            });
                        }
                    });
                }
                $('#state, #country, #city').css('width','100%').select2();
            });
        </script>
    @endpush
    @endsection

