@extends('backend.layouts.main') 
@section('title', 'Faq')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Edit Faq', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Edit Faq</h5>
                            {{-- <span>Update a record for Faq</span> --}}
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
                        <h3>Update Faq</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('backend/constant-management.faqs.update',$faq->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">        
                                     <div class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
                                            <label for="category_id">{{ __('Category')}} <span class="text-danger">*</span> </label>
                                            <select required name="category_id" id="category_id" class="form-control select2">
                                                <option value="" readonly>{{ __('Select Category')}}</option>
                                                @foreach (fetchGet('App\Models\Category', 'where', 'category_type_id', '=', 12) as $item)
                                                    <option value="{{ $item->id }}" {{ $item->id == $faq->category_id ? 'selected' : ''}}>{{ $item->name }}</option> 
                                                @endforeach
                                            </select>
                                     </div>
                                </div>
                                <div class="col-md-6">   
                                    <div class="form-group ">
                                        <label for="title" class="control-label">Title</label>
                                        <input required   class="form-control" name="title" type="text" id="name" value="{{$faq->title }}">
                                    </div>
                                </div>
                                <div class="col-md-12"> 
                                    <div class="form-group ">
                                        <label for="description" class="control-label">Description</label>
                                        <textarea class="form-control" rows="5" name="description" type="textarea" id="name" placeholder="Enter remark here..." >{{$faq->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                               
                                 
                                <div>
                                     <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="is_publish" name="is_publish" value="1" @if($faq->is_publish) checked @endif>
                                                <span class="pt-1 custom-control-label">&nbsp;Publish</span>
                                            </label>
                                </div>
                                                                        
                                <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
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
