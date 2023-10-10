@extends('backend.layouts.main') 
@section('title', 'LaunchCampaign')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'LaunchCampaign', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                            <h5>Launch Campaign</h5>
                            <span>List of Launch Campaign</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            <!-- end message area-->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Launch Campaign</h3>
                        {{-- <a href="{{ route ('panel.launchcampaign.show') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New LaunchCampaign"><i class="fa fa-plus" aria-hidden="true"></i></a> --}}
                    </div>
                    <div class="card-body">                        
                        <form action="{{ route('backend/constant-management.news_letters.run.campaign') }}"
                            method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                               <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="title" class="control-label">Subject<span class="text-danger">*</span></label>
                                        <input required class="form-control" name="title" type="text" id="name"
                                            value="">
                                    </div>
                               </div>
                               <div class="col-md-6">
                                    <div class="form-group ">
                                        <label for="title" class="control-label">Group</label>
                                        <select name="group_id" id="group_id" class="form-control select2">
                                                <option value="" readonly> All Group</option>
                                                @foreach (fetchGet('App\Models\Category','where','category_type_id','=','13') as $item) <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                        </select>
                                    </div>
                               </div>
    
                               <div class="col-md-12">
                                <div class="form-group ">
                                    <label for="body" class="control-label">Body</label>
                                    <textarea name="body" id="" class="form-control ckeditor"></textarea>
                                </div>
                               </div>
                               <div class="col-md-12">
                                    <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Run Campaign</button>
                                </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex justify-content-center">
                        <img src="{{ asset('frontend/assets/img/Emails-amico.png') }}" width="100%" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    {{-- normal editor js --}}
    <script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
    <script>
      
        var options = {
                filebrowserImageBrowseUrl: "{{ url('/laravel-filemanager?type=Images') }}",
                filebrowserImageUploadUrl: "{{ url('/laravel-filemanager/upload?type=Images&_token='.csrf_token()) }}",
                filebrowserBrowseUrl: "{{ url('/laravel-filemanager?type=Files') }}",
                filebrowserUploadUrl: "{{ url('/laravel-filemanager/upload?type=Files&_token='.csrf_token()) }}"
            };
            $(window).on('load', function (){
                  CKEDITOR.replace('description', options);
            });
    </script>
    @endpush
@endsection