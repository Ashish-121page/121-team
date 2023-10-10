@extends('backend.layouts.main') 
@section('title', 'Slider')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Add Slider', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>Add Slider</h5>
                            <span>Create a record for Slider</span>
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
                        <h3>Create Slider</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('backend.constant-management.sliders.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                                        <label for="title" class="control-label">Title<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="title" type="text" id="title" value="{{old('title')}}" placeholder="Enter Title">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
                                        <label for="image" class="control-label">Image<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="image_file" type="file" id="image" value="{{old('image')}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                                        <label for="status" class="control-label">Publish</label><br>
                                        <input  checked  name="status" type="checkbox" id="status" class="js-single switch-input" value=" 1 ">
                                    </div>
                                </div>
                                @if(request()->get('slidertype'))
                                <input type="hidden" name="slider_type_id" value="request()->get('slidertype')">
                                @else
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="slider_type_id">Slider Type <span class="text-danger">*</span></label>
                                        <select required name="slider_type_id" id="slider_type_id" class="form-control select2">
                                            <option value="" readonly>Select Slider Type </option>
                                            @foreach(App\Models\SliderType::all()  as $option)
                                                <option value="{{ $option->id }}">{{  $option->title ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="description" class="control-label">Description </label>
                                        <textarea  class="form-control" name="description" id="description" placeholder="Enter Description"></textarea>
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
    <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
    @endpush
@endsection
