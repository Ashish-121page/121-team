@extends('backend.layouts.main') 
@section('title', 'Lead')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Add Lead', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Create New Lead')}}</h5>
                            <span>{{ __('Add a new record for Lead')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            @include('backend.include.message')
            <!-- end message area-->
            <div class="col-md-8 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h3>{{ __('Add Lead')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.admin.lead.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-4 {{ $errors->has('user_id') ? 'has-error' : ''}}">
                                            <label for="user_id" class="control-label">{{ 'User' }} <span class="text-red">*</span> </label>
                                            <select required name="user_id" id="user_id" class="form-control select2">
                                                <option value="" readonly>{{ __('Select User')}}</option>
                                                @foreach (UserList() as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option> 
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4 {{ $errors->has('lead_type_id') ? 'has-error' : ''}}">
                                            <label for="lead_type_id" class="control-label">{{ 'Type' }} <span class="text-red">*</span> </label>
                                            <select required name="lead_type_id" id="lead_type_id" class="form-control select2">
                                                <option value="" readonly>{{ __('Select Type')}}</option>
                                                @foreach (fetchGet('App\Models\Category', 'where', 'category_type_id', '=', 4) as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option> 
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4 {{ $errors->has('lead_source_id') ? 'has-error' : ''}}">
                                            <label for="lead_source_id" class="control-label">{{ 'Source' }} <span class="text-red">*</span> </label>
                                            <select required name="lead_source_id" id="lead_source_id" class="form-control select2">
                                                <option value="" readonly>{{ __('Select Source')}}</option>
                                                @foreach (fetchGet('App\Models\Category', 'where', 'category_type_id', '=', 5) as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option> 
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4 {{ $errors->has('name') ? 'has-error' : ''}}">
                                            <label for="name" class="control-label">{{ 'Name' }} <span class="text-red">*</span> </label>
                                            <input class="form-control" name="name" type="text" id="name" placeholder="Enter Name" value="{{ isset($lead->name) ? $lead->name : ''}}" required>
                                        </div>
                                        <div class="form-group col-md-4 {{ $errors->has('owner_email') ? 'has-error' : ''}}">
                                            <label for="owner_email" class="control-label">{{ 'Owner Email' }} </label>
                                            <input class="form-control" name="owner_email" type="email" id="owner_email" placeholder="Enter Owner Email" value="{{ isset($lead->owner_email) ? $lead->owner_email : ''}}" >
                                        </div>
                                        <div class="form-group col-md-4 {{ $errors->has('phone') ? 'has-error' : ''}}">
                                            <label for="phone" class="control-label">{{ 'Phone' }} </label>
                                            <input class="form-control" name="phone" type="number" id="phone" placeholder="Enter Phone" value="{{ isset($lead->phone) ? $lead->phone : ''}}" >
                                        </div>
                                        
                                      
                                        <div class="form-group col-md-4 {{ $errors->has('country') ? 'has-error' : ''}}">
                                            <label for="country">{{ __('Country')}} </label>
                                            <input class="form-control" name="country" type="text" id="country" placeholder="Enter Country" value="{{ isset($lead->country) ? $lead->country : ''}}">
                                        </div>
                                        <div class="form-group col-md-4 {{ $errors->has('state') ? 'has-error' : ''}}">
                                            <label for="state">{{ __('State')}} </label> 
                                            <input class="form-control" name="state" type="text" id="state" placeholder="Enter State" value="{{ isset($lead->state) ? $lead->state : ''}}" >
                                        </div>
                                        <div class="form-group col-md-4 {{ $errors->has('city') ? 'has-error' : ''}}">
                                            <label for="city">{{ __('City')}}</label>
                                            <input class="form-control" name="city" type="text" id="city" placeholder="Enter City" value="{{ isset($lead->city) ? $lead->city : ''}}">
                                        </div>

                                        <div class="form-group col-md-6 {{ $errors->has('website') ? 'has-error' : ''}}">
                                            <label for="website" class="control-label">{{ 'Website' }}  </label>
                                            <input class="form-control" name="website" type="link" id="website" placeholder="Enter Website" value="{{ isset($lead->website) ? $lead->website : ''}}" >
                                        </div>
                                        <div class="form-group col-md-6 {{ $errors->has('zip') ? 'has-error' : ''}}">
                                            <label for="zip" class="control-label">{{ 'Zip' }}  </label>
                                            <input class="form-control" name="zip" type="number" id="zip" value="{{ isset($lead->zip) ? $lead->zip : ''}}" >
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12 mx-auto">                                    
                                    <div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
                                        <label for="address" class="control-label">{{ 'Address' }} </label>
                                        <textarea class="form-control" rows="5" name="address" type="textarea" id="address" placeholder="Enter Address" >{{ isset($lead->address) ? $lead->address : ''}}</textarea>
                                    </div>
                                    <div class="form-group text-right">
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
    <script>
        $(document).ready(function(){
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
