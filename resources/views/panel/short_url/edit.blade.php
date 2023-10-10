@extends('backend.layouts.main')
@section('title', 'Newsletter')
@section('content')
@php
$breadcrumb_arr = [
['name'=>'Edit Short URL', 'url'=> "javascript:void(0);", 'class' => '']
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
                        <h5>Edit Short URL</h5>
                        <span>Update a record for Short URL</span>
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
                    <h3>Update Short URL</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('panel.short_url.update_url',$short_url->id) }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label for="name" class="control-label">Destination URL<span class="text-red">*</span></label>
                                    <input class="form-control" name="newurl" type="text" id="name"
                                        value="{{$short_url->destination_url }}" required>
                                </div>
                            </div>
                        </div>


                        <div class="form-group m-2">
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
