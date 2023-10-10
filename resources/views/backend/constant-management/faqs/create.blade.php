@extends('backend.layouts.main') 
@section('title', 'FAQ')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Add FAQ', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Add FAQ</h5>
                            {{-- <span>Create a record for FAQ</span> --}}
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
                        <h3>Create FAQ</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('backend/constant-management.faqs.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                   <div class="col-md-6">   
                                        <div class="form-group ">
                                            <div class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
                                                <label for="category_id">{{ __('Category')}} <span class="text-danger">*</span> </label>
                                                <select required name="category_id" id="category_id" class="form-control select2">
                                                    <option value="" readonly>{{ __('Select Category')}}</option>
                                                    @foreach (fetchGet('App\Models\Category', 'where', 'category_type_id', '=', 12) as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                                                                                 
                                        <div class="form-group">
                                            <label for="title" class="control-label">Title</label>
                                            <input required  class="form-control" name="title" type="text" id="name" value="{{old('title')}}">
                                        </div>
                                    </div>
                                    <div class="col-md-12   mx-auto">                                           
                                        <div class="form-group ">
                                            <label for="description" class="control-label">Description</label>
                                            <textarea class="form-control" rows="5" name="description" type="textarea" id="name" placeholder="Enter remark here..." value="{{old('description')}}"></textarea>
                                            {{-- <input required  class="form-control" name="description" type="text" id="name" value="{{old('description')}}"> --}}
                                        </div>
                                    </div>       
                            </div>

                                    
                             <div class="col-md-6 text-left mb-2">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="is_published"
                                                   name="is_published" value="1">
                                            <span class="pt-1 custom-control-label">&nbsp;Publish</span>
                                        </label>
                             </div>
                                 
                                                                        
                            <div class="form-group">
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
    @endpush
@endsection
