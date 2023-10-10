@extends('backend.layouts.main') 
@section('title', 'Newsletter')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Edit Newsletter', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Edit Newsletter</h5>
                            <span>Update a record for Newsletter</span>
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
                        <h3>Update Newsletter</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('backend/constant-management.news_letters.update',$news_letter->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                    <div class="col-md-6">
                                                <div class="form-group ">
                                                <label for="name" class="control-label">Name<span class="text-red">*</span></label>
                                                <input  class="form-control" name="name" type="text" id="name" value="{{$news_letter->name }}" required>
                                                </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label for="value" class="control-label">Value<span class="text-red">*</span></label>
                                            <input class="form-control" name="value"  id="value" value="{{$news_letter->value }}"required>
                                        </div>
                                    </div>
                            </div>

                                 <div class="row">
                                    <div class="col-md-6 mx-auto">
                                        <label for="type">Group <span class="text-red">*</span></label>
                                        <select required name="group_id" id="group_id" class="form-control select2">
                                               @foreach (fetchGet('App\Models\Category','where','category_type_id','=','13') as $item)
                                                    <option value="{{ $item->id }}" {{ $news_letter->group_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                               @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mx-auto">
                                        <label for="type">Type<span class="text-red">*</span></label>
                                        <select required name="type" id="type" class="form-control select2">
                                        <option value="" readonly>Select Type</option>
                                            <option value="1"  {{ ($news_letter->type == 1 ? 'selected' : '') }} >{{ 'Email' }}</option> 
                                            <option value="0"  {{ ($news_letter->type == 2 ? 'selected' : '') }} >{{ 'Number' }}</option>
                                        </select>
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
    <script>
        	
				function slugFunction() {
        var type = "{{ $news_letter->type }}";
        if(type == 0){                    
            $('#value').attr('type','email');
        }else if(type == 1) {
            $('#value').attr('type','number');
        }
        $(document).ready(function() {
            $("#type").on("change", function() {
                if ($(this).val() == 0) {
                    $('#value').attr('type','email');
                }else if($(this).val() == 1){
                    $('#value').attr('type','number');
                }
            });
        });
    </script>
    @endpush
@endsection
