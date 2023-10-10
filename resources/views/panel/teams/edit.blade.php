@extends('backend.layouts.main') 
@section('title', 'Team')
@section('content')
@php

$user = auth()->user();

$acc_permissions = json_decode($user->account_permission);      
$acc_permissions->mysupplier = $acc_permissions->mysupplier ?? 'no';
$acc_permissions->offers = $acc_permissions->offers ?? 'no';
$breadcrumb_arr = [
    ['name'=>'Edit Team', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <style>
        .error{
            color:red;
        }
    </style>
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>Edit Team</h5>
                            <span>Update a record for Team</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- start message area-->
               @include('backend.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-header">
                        <h3>Update Team</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.teams.update',$team->id) }}" method="post" enctype="multipart/form-data" id="TeamForm">
                            @csrf
                            <input type="hidden" name="user_shop_id" value="{{ request()->get('shop_id') }}">
                            <div class="row">
                                 
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        <label for="name" class="control-label">Name<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="name" type="text" id="name" value="{{$team->name }}">
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('designation') ? 'has-error' : ''}}">
                                        <label for="designation" class="control-label">Designation<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="designation" type="text" id="designation" value="{{$team->designation }}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
                                        <label for="image" class="control-label">Image</label>
                                        <input class="form-control" name="image_file" type="file" id="image">
                                        <img id="image_file" src="{{ asset($team->image) }}" class="mt-2" style="border-radius: 10px;width:100px;height:80px;"/>
                                    </div>
                                </div>                           
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                                        <label for="Contact" class="control-label">E-mail</label>
                                        <input class="form-control" name="email" type="email" id="email" value="{{ $team->email ?? '' }}" placeholder="Enter Email">
                                    </div>
                                </div>                           
                                
                                @php
                                    $city = App\Models\City::where('country_code',"IN")->get();
                                @endphp
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('city') ? 'has-error' : ''}}">
                                        <label for="Contact" class="control-label">City</label>
                                        {{-- <input class="form-control" name="city" type="number" id="city" value="{{ $team->city ?? '' }}" placeholder="Enter city"> --}}
                                        <select class="form-select form-control select2insidemodalTeam" id="cityEditTeam" name="city"  required>
                                                @foreach ($city as $item)
                                                    <option value="{{ $item->id }}" @if ($team->city == $item->id) selected @endif >{{ $item->name }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                                </div>                           


                                <div class="col-md-12 col-12 my-2"> 
                                    <div class="form-group {{ $errors->has('designation') ? 'has-error' : ''}}">
                                        <label for="cityEditTeamRights" class="control-label">Team Permission Rights<span class="text-danger">*</span> </label>
                                        <select class="form-select form-control select2insidemodalTeam" id="cityEditTeamRights" name="teamright[]"  required multiple>
    
                                            <option value="dashboard" @if (in_array("dashboard",json_decode($team->permission))) selected @endif> Dashboard </option>

                                            @if ($acc_permissions->mycustomer == 'yes')
                                                <option value="my-customer" @if (in_array("my-customer",json_decode($team->permission))) selected @endif> My Customer </option>
                                            @endif
    
                                            @if ($acc_permissions->mysupplier == 'yes')
                                                <option value="my-suppler" @if (in_array("my-suppler",json_decode($team->permission))) selected @endif> My Supplier </option>
                                            @endif
    
                                            @if ($acc_permissions->offers == 'yes')
                                                <option value="offer-me" @if (in_array("offer-me",json_decode($team->permission))) selected @endif> Offer Sent By Me </option>
                                                <option value="offer-other" @if (in_array("offer-other",json_decode($team->permission))) selected @endif> Offer Sent By Other </option>
                                            @endif
    
                                            @if ($acc_permissions->addandedit == 'yes')
                                                <option value="proadd" @if (in_array("proadd",json_decode($team->permission))) selected @endif> Add/Edit </option>
                                            @endif
    
                                            @if ($acc_permissions->manangebrands == 'yes')
                                                <option value="brand" @if (in_array("brand",json_decode($team->permission))) selected @endif>Manage Brands</option>
                                            @endif
    
                                            @if ($acc_permissions->pricegroup == 'yes')
                                                <option value="pricegroup" @if (in_array("pricegroup",json_decode($team->permission))) selected @endif>Manage Price Group</option>
                                            @endif
    
                                            @if ($acc_permissions->managegroup == 'yes')
                                                <option value="categorygroup" @if (in_array("categorygroup",json_decode($team->permission))) selected @endif>Manage Category Group</option>
                                            @endif
    
                                            @if ($acc_permissions->bulkupload == 'yes')
                                                <option value="bulkupload" @if (in_array("bulkupload",json_decode($team->permission))) selected @endif>Manage Bulk Upload</option>
                                            @endif

                                            @if ($acc_permissions->Filemanager == 'yes')
                                                <option value="setting" @if (in_array("setting",json_decode($team->permission))) selected @endif> Settings </option>    
                                            @endif
    
                                            <option value="profile" @if (in_array("profile",json_decode($team->permission))) selected @endif> Profile </option>
                                            
                                            
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 mx-auto">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{asset('backend/js/form-advanced.js') }}"></script>
    <script>
        $('#TeamForm').validate();
                                                                          
            document.getElementById('image').onchange = function () {
                var src = URL.createObjectURL(this.files[0])
                $('#image_file').removeClass('d-none');
                document.getElementById('image_file').src = src
            }
                                        
    </script>

    <script>
        $(document).ready(function () {
            $("#cityEditTeamRights").select2();
            $(".select2insidemodalTeam").select2();
        });
    </script>
    @endpush
@endsection
