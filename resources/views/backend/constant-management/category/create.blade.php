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
    <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    <style>
        .error{
            color:red;
        }
        .bootstrap-tagsinput{
            width: 100%;
        }
    </style>
    @endpush

    <div class="container-fluid">
        <div class="row justify-content-center">
            @include('backend.include.message')
    
            <div class="col-12">
                <a href="{{ route('panel.constant_management.category.index',13,2,12) }}" class="btn btn-outline-secondary">
                    Back
                </a>
            </div>
            <div class="col-md-8 col-12">
                <div class="card ">
                    <div class="card-header">
                        <h3>Create Product Category</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.constant_management.category.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            {{-- Type ID 13 As Gifting --}}
                            <input type="hidden" name="parent_id" value="{{ request()->get('parent_id') ?? null }}">
                            <input type="hidden" name="category_type_id" value="{{ encrypt('13') }}">
                            <input type="hidden" name="user_id" value="{{ encrypt(auth()->id()) }}">
                            <input type="hidden" name="shop_id" value="{{ encrypt(getShopDataByUserId(auth()->id())->id) }}">

                            
                            <div class="row">               
                                <div class="col-md-12 col-12"> 
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                        <label for="name" class="control-label">Name Of the Category<span class="text-danger">*</span></label>
                                        <input required  class="form-control" name="name" type="text" id="name" value="{{old('name')}}" placeholder="Enter Name" >
                                    </div>
                                </div>
                                                                                            
                            
                                <div class="col-md-12 col-12"> 
                                    <div class="form-group mb-0">
                                        <label for="input">{{ __('Sub Categories')}} <span class="text-danger">*</span> </label>
                                    </div>
                                    <div class="form-group">
                                        <input style="width: 100%" name="value[]" type="text" id="tags" class="form-control" value="" required>
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
    <script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#tags').tagsinput('items');
        });
    </script>
      
    @endpush
@endsection
