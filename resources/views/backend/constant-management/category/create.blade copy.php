@extends('backend.layouts.main') 
@section('title', 'Category')
@section('content')
@php
   if($level == 1){ $page_title = 'Categories';  $arr = null;}
     elseif($level == 2){ $page_title = 'Sub Categories'; $arr = ['name'=> fetchFirst('App\Models\Category',request('parent_id'),'name'), 'url'=> route('panel.constant_management.category.index',$type_id), 'class' => ''];}
     elseif($level == 3){$page_title = 'Sub Sub Categories'; $pre = request('parent_id')-1; $arr = ['name'=> fetchFirst('App\Models\Category',request('parent_id'),'name'), 'url'=> url('panel/constant-management/category/view/'.$type_id.'?level='.'2'.'&parent_id='.$pre), 'class' => ''];}
    $breadcrumb_arr = [
        ['name'=>'Constant Management', 'url'=> "javascript:void(0);", 'class' => ''],
        ['name'=> fetchFirst('App\Models\CategoryType',$type_id,'name') , 'url'=> route("panel.constant_management.category_type.index"), 'class' => 'active'],
        $arr,
            // ,
        ['name'=> $page_title, 'url'=> "javascript:void(0);", 'class' => 'active']
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
                            <h5>{{ __('Create New Category')}}</h5>
                            {{-- <span>{{ __('Add a new record for Category')}}</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            @include('backend.include.message')
            <div class="col-md-8 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h3>{{ __('Add Category')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.constant_management.category.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="category_type_id" value="{{ $type_id }}">
                            <input type="hidden" name="level" value="{{ $level }}">
                            <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    {{-- <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
                                                <label for="category_id">{{ __('Category Type')}}</label>
                                                <select name="category_type_id" id="category_type_id" class="form-control select2">
                                                    <option value="" readonly required>{{ __('Select Category Type')}}</option>
                                                    @foreach (fetchAll('App\Models\CategoryType') as $index => $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('level') ? 'has-error' : ''}}">
                                                <label for="level">{{ __('level')}}</label>
                                                <select name="level" id="level" class="form-control select2">
                                                    <option value="" readonly required>{{ __('Select Level')}}</option>
                                                    @foreach (getCategory() as $index => $item)
                                                        <option value="{{ $item['id'] }}">{{ $item['name'] }}</option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                                <label for="name" class="control-label">{{ 'Name' }}</label>
                                                <input class="form-control" name="name" type="text" id="name" value="" required>
                                            </div>
                                        </div>
                                        {{-- <div class="col-sm-6">
                                            <div class="form-group {{ $errors->has('parent_id') ? 'has-error' : ''}}">
                                                <label for="parent_id">{{ __('Parent')}}</label>
                                                <select name="parent_id" id="parent_id" class="form-control select2">
                                                    <option value="" readonly required>{{ __('Select Parent')}}</option>
                                                    @foreach (fetchGet('App\Models\Category', 'where', 'level', '=', $prev_level) as $index => $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option> 
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> --}}
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group ">
                                                <label for="logo" class=" col-form-label">{{ __('Icon')}}</label>
                                                <div class="">
                                                    <div class="input-group col-xs-12">
                                                        <input type="file" name="icon" class="file-upload-default">
                                                        <div class="input-group col-xs-12">
                                                            <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Icon">
                                                            <span class="input-group-append">
                                                            <button class="file-upload-browse btn btn-success" type="button">{{ __('Upload')}}</button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary float-right">Create</button>
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
