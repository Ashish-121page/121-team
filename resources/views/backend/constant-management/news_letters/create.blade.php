@extends('backend.layouts.main') 
@section('title', 'Newsletter')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Add Newsletter', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Add Newsetter</h5>
                            <span>Create a record for Newsletter</span>
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
                        <h3>Create Newsletter</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('backend/constant-management.news_letters.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                                    <div class="row">    
                                            <div class="col-md-6">
                                                <label for="name" class="control-label">Name<span class="text-red">*</span></label>
                                                <input required   class="form-control" name="name" type="text" placeholder="Enter Name" id="name" value="{{old('name')}}" required>
                                             </div> 
                                   
                                    
                                            <div class="col-md-6">
                                                <label for="value" class="control-label">Value<span class="text-red">*</span></label>
                                                <input class="form-control" name="value" type="email" id="value" placeholder="Enter Value" value="{{old('value')}}" required>
                                                {{-- <input class="form-control" name="value" type="number" id="number" placeholder="Enter Number" value="{{old('value')}}">
                                                <input class="form-control" name="value" type="email" id="email" placeholder="Enter Email" value="{{old('value')}}"> --}}
                                            </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 m-3 mx-auto">
                                            <label for="type">Group <span class="text-red">*</span></label>
                                            <select required name="group_id" id="group_id" class="form-control select2">
                                                   @foreach (fetchGet('App\Models\Category','where','category_type_id','=','13') as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                   @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 m-3 mx-auto">
                                            <label for="type">Type<span class="text-red">*</span></label>
                                            <select required name="type" id="type" class="form-control select2">
                                                    <option value="1">{{ 'Email' }}</option> 
                                                    <option value="2">{{ 'Number' }}</option> 
                                            </select>
                                        </div>
                                    </div>
                                                               
                                    <div class="form-group m-2">
                                        <button type="submit" class="btn btn-primary">Create</button>
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
        $(document).ready(function() {
            $("#type").on("change", function() {
                if ($(this).val() == 0) {
                    $('#value').attr('type','email');
                }else{
                    $('#value').attr('type','number');
                }
            });
        });
    </script>
    @endpush
@endsection
