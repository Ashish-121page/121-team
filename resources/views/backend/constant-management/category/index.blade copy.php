@extends('backend.layouts.main') 
@section('title', 'Category')

@section('content')
@push('head')

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/normalize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
    <style>
        .remove-ik-class{
                -webkit-box-shadow: unset !important;
                box-shadow: unset !important;
            }
    </style>
@endpush
    @php

     if($level == 1){ $page_title = 'Categories';  $arr = null;}
     elseif($level == 2){ $page_title = 'Sub Categories'; $arr = ['name'=> fetchFirst('App\Models\Category',request('parent_id'),'name','--'), 'url'=> route('panel.constant_management.category.index',$type_id), 'class' => ''];}
     elseif($level == 3){$page_title = 'Sub Sub Categories'; $pre = request('parent_id')-1; $arr = ['name'=> fetchFirst('App\Models\Category',request('parent_id'),'name','--'), 'url'=> url('panel/constant-management/category/view/'.$type_id.'?level='.'2'.'&parent_id='.$pre), 'class' => ''];}

     
     $parent = App\Models\CategoryType::whereId($type_id)->first();

      if($parent->id == 13){
        if($level == 1) $page_title = "Industry";
        elseif($level == 2) $page_title = "Category";
        elseif($level == 3) $page_title = "Sub Category";
    }

    if (Authrole() == 'User') {
            $breadcrumb_arr = [
                $arr,
                    // ,
                ['name'=> $page_title, 'url'=> "javascript:void(0);", 'class' => 'active']
     ];
        }else{
            $breadcrumb_arr = [
                ['name'=>'Constant Management', 'url'=> "javascript:void(0);", 'class' => ''],
                ['name'=>'Category', 'url'=> route("panel.constant_management.category_type.index"), 'class' => 'active'],
                $arr,
                ['name'=> $page_title, 'url'=> "javascript:void(0);", 'class' => 'active']
        ];
     }
    @endphp
    <!-- push external head elements to head -->


    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-flex">
                            <h5>
                               {{$page_title}} 
                            </h5>
                            @if(AuthRole() == 'User')
                                <span style="margin-top: -10px;">
                                    <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                                </span>
                            @endif
                        </div>
                        {{-- <span>{{ __('List of')}} {{$page_title}} </span> --}}
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex justify-content-between">
                        <h3>
                            {{ $page_title }}
                        </h3>
                        <div class="">
                            @if (AuthRole() == 'Admin' && $level == 1)
                                <a href="{{ route('panel.constant_management.category.create',[$type_id,$level,request('parent_id')]) }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Category"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            @elseif (AuthRole() == 'User' && $level > 1 || AuthRole() == 'Admin' )
                                <a href="{{ route('panel.constant_management.category.create',[$type_id,$level,request('parent_id')]) }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Category"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            @endif
                        @if (AuthRole() == 'User' && $level == 1)
                            <a href="javascript:void(0)" data-target="#editIndustry" data-toggle="modal" class="btn btn-icon btn-sm btn-outline-danger" title="Add Industry"><i class="fa fa-edit" aria-hidden="true"></i></a>
                        @endif  
                        @if (AuthRole() == 'Admin' && $level == 1)
                            <a href="javascript:void(0)" data-target="#categoryBulkModal" data-toggle="modal" class="btn btn-icon btn-sm btn-outline-danger" title="Upload Bulk Category"><i class="fa fa-upload" aria-hidden="true"></i></a>
                            <a href="{{ route('panel.constant_management.category.change') }}"  class="btn btn-icon btn-sm btn-outline-success" title="Edit categories"><i class="fa fa-edit" aria-hidden="true"></i></a>
                        @endif
                        </div>
                    </div>
                    <div class="card-body ">
                        <div class="table-responsive">
                            <table id="category_table" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Actions</th>
                                        <th>Name</th>
                                        <th>Parent Category</th>
                                        @if(fetchFirst('App\Models\CategoryType',$type_id,'allowed_level','1') > $level)
                                            <th>Child Category Count</th> 
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if($category->count() > 0)
                                        @foreach($category as $item)
                                        <tr>
                                            <td class="text-center">MC00{{ $loop->iteration }}</td>
                                          
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                                @if($item->user_id == auth()->id())
                                                                    <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.category.edit', $item->id)  }}" title="Edit Lead Contact" class="btn btn-sm">Edit</a></li>
                                                                @endif 
                                                                @if(AuthRole() == "Admin")
                                                                <li class="dropdown-item p-0"><a href="{{ route('panel.constant_management.category.delete', $item->id)  }}" title="Delete Category" class="btn btn-sm delete-item">Delete</a></li>
                                                                @endif
                                                                <li class="dropdown-item p-0"><a href="{{url('panel/constant-management/category/view/'.$item->category_type_id.'?level='.$nextlevel.'&parent_id='.$item->id)}}" title="Delete Category" class="btn btn-sm">Show</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                           

                                                <td>{{ $item->name }} {{ $item->type == 1 ? "" : "(Self)" }}</td>
                                                {{-- <td>{{ $item->level }}</td> --}}
                                                {{-- <td><a href="javascript:void(0);">{{ ucwords(str_replace('_',' ',fetchFirst('App\Models\CategoryType',$item->category_type_id,'name','--'))) }}</a></td> --}}
                                                <td>
                                                    {{ $parent->name }}
                                                </td>
                                                
                                                @if(fetchFirst('App\Models\CategoryType',$type_id,'allowed_level','1') > $level)
                                                    <td>
                                                        @if($nextlevel <= 3)
                                                        <a class="btn btn-link"href="{{url('panel/constant-management/category/view/'.$item->category_type_id.'?level='.$nextlevel.'&parent_id='.$item->id)}}">@if (AuthRole() != 'Admin')
                                                            {{ fetchGetData('App\Models\Category',['category_type_id','level','parent_id','user_id'],[$item->category_type_id,$nextlevel,$item->id,auth()->id()])->count() }}
                                                        @else
                                                            {{ fetchGetData('App\Models\Category',['category_type_id','level','parent_id'],[$item->category_type_id,$nextlevel,$item->id])->count() }}
                                                        @endif
                                                        </a>
                                                        @else 
                                                        ---
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @else
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
     @include('backend.constant-management.category.include.modal')
     @include('backend.constant-management.category.include.industry')
     
     <!-- push external js -->
     @push('script')
     
     <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>
        <script>

            $(document).ready(function() {

                $("#demo01").click();


                var table = $('#category_table').DataTable({
                    responsive: true,
                    fixedColumns: true,
                    fixedHeader: true,
                    scrollX: false,
                    'aoColumnDefs': [{
                        'bSortable': false,
                        'aTargets': ['nosort']
                    }],
                    dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [
                        {
                            extend: 'excel',
                            className: 'btn-sm btn-success',
                            header: true,
                            footer: true,
                            exportOptions: {
                                columns: ':visible',
                            }
                        },
                        'colvis',
                        {
                            extend: 'print',
                            className: 'btn-sm btn-primary',
                            header: true,
                            footer: false,
                            orientation: 'landscape',
                            exportOptions: {
                                columns: ':visible',
                                stripHtml: false
                            }
                        }
                    ]

                });
            });
        </script>
    @endpush
@endsection
