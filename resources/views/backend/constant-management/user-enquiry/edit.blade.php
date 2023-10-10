@extends('backend.layouts.main') 
@section('title', 'Website Enquiry')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Edit Website Enquiry', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>{{ __('Edit Website Enquiry')}}</h5>
                            {{-- <span>{{ __('Update a record for Website Enquiry')}}</span> --}}
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
            <!-- end message area-->
            <div class="col-md-8 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h3>{{ __('Update Website Enquiry')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.constant_management.user_enquiry.update', $user_enq->id) }}" method="post">
                            @csrf
                            <input type="hidden" name="category_id" value="{{ $user_enq->category_id }}">
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                                <label for="name" class="control-label">{{ 'Name' }}<span class="text-red">*</span></label>
                                                <input class="form-control" name="name" readonly type="text" id="name" value="{{ @$user_enq->name }}" placeholder="Enter Your Name" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                                                <label for="email" class="control-label">{{ 'Email' }}<span class="text-red">*</span></label>
                                                <input class="form-control" name="email" readonly type="email" id="email" value="{{ $user_enq->email }}" placeholder="Enter Your Email" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group {{ $errors->has('contact_number') ? 'has-error' : ''}}">
                                                <label for="contact_number" class="control-label">{{ 'Contact Number' }}<span class="text-red">*</span></label>
                                                <input class="form-control" name="contact_number" readonly type="text" id="contact_number" value="{{ $user_enq->contact_number }}" placeholder="Enter Your Contact Number" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
                                                <label for="category_id">{{ __('Category')}}<span class="text-red">*</span></label>
                                                <select  required name="category_id" disabled id="category_id" class="form-control select2">
                                                    <option value="" readonly required>{{ __('Select Category')}}</option>
                                                    @foreach (fetchGet('App\Models\Category', 'where', 'category_type_id', '=', 7) as $item)
                                                        <option value="{{ $item->id }}" {{ $user_enq->category_id == $item['id'] ? 'selected' :'' }}>{{ $item->name }}</option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group {{ $errors->has('subject') ? 'has-error' : ''}}">
                                                <label for="subject">{{ __('Subject')}}<span class="text-red">*</span></label>
                                                <input class="form-control" name="subject" type="text" id="subject" value="{{ @$user_enq->subject }}" placeholder="Enter Your subject" readonly required>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                                                <label for="status">{{ __('Status')}}<span class="text-red">*</span></label>
                                                <select required name="status" id="status" class="form-control select2">
                                                    <option value="0" {{ $user_enq->status == 0 ? 'selected' : ''}} >{{ __('Pending')}}</option>
                                                    <option value="1" {{ $user_enq->status == 1 ? 'selected' : ''}} >{{ __('Solved')}}</option>

                                                    {{-- @foreach (getUserEnquiryStatus() as $index => $item)
                                                        <option value="{{ $item['id'] }}" {{ $item['id'] == $user_enq->status ? 'selected' :''}}>{{ $item['name'] }}</option> 
                                                    @endforeach --}}
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                                                <label for="description">{{ __('Description')}}<span class="text-red">*</span></label>
                                                <textarea class="form-control" name="description" readonly type="text" id="description" value="" placeholder="Enter Description" rows="5" required>{{ @$user_enq->description }}</textarea>
                                            </div>
                                        </div>
                                        {{-- <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('staff_reply') ? 'has-error' : ''}}">
                                                <label for="staff_reply">{{ __('Staff Reply')}}</label>
                                                <textarea class="form-control" name="staff_reply" type="text" id="staff_reply" value="" placeholder="Enter Staff Reply" req>{{ @$user_enq->staff_reply }}</textarea>
                                            </div>
                                        </div> --}}
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary float-right">Update</button>
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
    @endpush
@endsection
