@extends('backend.layouts.main') 
@section('title', 'Team')
@section('content')
@php
$usershop = App\Models\UserShop::whereId(request()->get('shop_id'))->first();
$user = App\User::whereId($usershop->user_id)->first();
$acc_permissions = json_decode($user->account_permission);      
$acc_permissions->mysupplier = $acc_permissions->mysupplier ?? 'no';
$acc_permissions->offers = $acc_permissions->offers ?? 'no';
$acc_permissions->addandedit  = $acc_permissions->addandedit  ?? 'no';
$acc_permissions->manangebrands  = $acc_permissions->manangebrands  ?? 'no';
$acc_permissions->pricegroup  = $acc_permissions->pricegroup  ?? 'no';
$acc_permissions->managegroup  = $acc_permissions->managegroup  ?? 'no';
$acc_permissions->bulkupload  = $acc_permissions->bulkupload  ?? 'no';
$breadcrumb_arr = [
    ['name'=>'Add Team', 'url'=> "javascript:void(0);", 'class' => '']
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
                    {{-- <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>Add Team</h5>
                            <span>Create a record for Team</span>
                        </div>
                    </div> --}}
                </div>
                {{-- <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div> --}}
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- start message area-->
               @include('backend.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-header">
                        <h3>Create Team</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.teams.store') }}" method="post" enctype="multipart/form-data" id="TeamForm">
                            @csrf
                            <input type="hidden" name="user_shop_id" id="" value="{{ request()->get('shop_id') }}">
                            <input type="hidden" name="user" id="" value="{{ $user->id }}">
                            <div class="row">
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        <label for="name" class="control-label">Team Member<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="name" type="text" id="name" value="{{old('name')}}" placeholder="Team Member Name" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
                                        <label for="image" class="control-label">Upload Photo</label>
                                        <input class="form-control" name="image" type="file" id="image" value="{{old('image')}}" >
                                        <img id="image" class="d-none mt-2" style="border-radius: 10px;width:100px;height:80px;"/>
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('designation') ? 'has-error' : ''}}">
                                        <label for="designation" class="control-label">Designation of member<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="designation" type="text" id="designation" value="{{old('designation')}}" placeholder="Enter Designation of member" >
                                    </div>
                                </div>

                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('Email') ? 'has-error' : ''}}">
                                        <label for="Email" class="control-label">Email<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="Email" type="text" id="Email" value="{{old('Email')}}" placeholder="Enter Email of member" >
                                    </div>
                                </div>

                                @php
                                $city = App\Models\City::where('country_code',"IN")->get();
                                @endphp
                                <div class="col-md-6 col-12 my-2"> 
                                    <div class="form-group {{ $errors->has('designation') ? 'has-error' : ''}}">
                                        <label for="cityEditTeam" class="control-label">City<span class="text-danger">*</span> </label>
                                        <select class="form-select form-control select2insidemodalTeam" id="cityEditTeam" name="city"  required>
                                            <option value="all" selected>Select City</option>
                                            @foreach ($city as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('contact_number') ? 'has-error' : ''}}">
                                        <label for="contact_number" class="control-label">Contact Number(optional) </label>
                                        <input  class="form-control" name="contact_number" type="number" id="contact_number" value="{{old('contact_number')}}" placeholder="Enter Contact Number" >
                                    </div>
                                </div>
                                                            
                                <div class="col-md-12 col-12 my-2"> 
                                    <div class="form-group {{ $errors->has('designation') ? 'has-error' : ''}}">
                                        <label for="cityEditTeamRights" class="control-label">Team Permission Rights<span class="text-danger">*</span> </label>
                                        <select class="form-select form-control select2insidemodalTeam" id="cityEditTeamRights" name="teamright[]"  required multiple>
    
                                            <option value="dashboard" selected> Dashboard </option>
                                            @if ($acc_permissions->mycustomer == 'yes')
                                                <option value="my-customer" selected> My Customer </option>
                                            @endif
    
                                            @if ($acc_permissions->mysupplier == 'yes')
                                                <option value="my-suppler" selected> My Supplier </option>
                                            @endif
    
                                            @if ($acc_permissions->offers == 'yes')
                                                <option value="offer-me" selected> Offer Sent By Me </option>
                                                <option value="offer-other" selected> Offer Sent By Other </option>
                                            @endif
    
                                            @if ($acc_permissions->addandedit == 'yes')
                                                <option value="proadd" selected> Add/Edit </option>
                                            @endif
    
                                            @if ($acc_permissions->manangebrands == 'yes')
                                                <option value="brand" selected>Manage Brands</option>
                                            @endif
    
                                            @if ($acc_permissions->pricegroup == 'yes')
                                                <option value="pricegroup" selected>Manage Price Group</option>
                                            @endif
    
                                            @if ($acc_permissions->managegroup == 'yes')
                                                <option value="categorygroup" selected>Manage Category Group</option>
                                            @endif
    
                                            @if ($acc_permissions->bulkupload == 'yes')
                                                <option value="bulkupload" selected>Manage Bulk Upload</option>
                                            @endif
    
                                            <option value="profile" selected> Profile </option>
                                            @if ($acc_permissions->Filemanager == 'yes')
                                                <option value="setting" selected> Settings </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 ml-auto">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Create</button>
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
                                        

            $(document).ready(function () {
                $(".select2insidemodalTeam").select2();
            });

    </script>
    @endpush
@endsection
