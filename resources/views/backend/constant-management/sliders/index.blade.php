@extends('backend.layouts.main') 
@section('title', 'Sliders')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>fetchFirst('App\Models\SliderType',request()->get('slidertype'),'title',''), 'url'=> route('backend.constant-management.slider_types.index'), 'class' => 'active'],
        ['name'=>'Sliders', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                            <h5>Sliders</h5>
                            <span>List of Sliders @if(request()->get('slidertype'))of  {{ fetchFirst('App\Models\SliderType',request()->get('slidertype'),'title','') }}@endif</span>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Sliders</h3>
                        <a href="{{ route('backend.constant-management.sliders.create')."?slidertype=".request()->get('slidertype') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Slider"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                    <div class="card-body">                        
                        <div class="table-responsive">
                            <table id="table" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Actions</th>                                            
                                        <th>Title</th>
                                        {{-- <th>Image</th> --}}
                                        <th>Publish</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sliders as  $slider)
                                        <tr>
                                            <td class="text-center"> {{  $loop->iteration }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                        <li class="dropdown-item p-0"><a href="{{ route('backend.constant-management.sliders.edit', $slider->id) }}" title="Edit Slider" class="btn btn-sm">Edit</a></li>
                                                        <li class="dropdown-item p-0"><a href="{{ route('backend.constant-management.sliders.destroy', $slider->id) }}" title="Delete Slider" class="btn btn-sm delete-item">Delete</a></li>
                                                      </ul>
                                                </div> 
                                            </td>
                                            <td>{{$slider->title }}</td>
                                             {{-- <td><a href="{{ asset('storage/backend/constant-management/sliders/'.$slider->image) }}" target="_blank" class="btn-link">{{$slider->image }}</a></td> --}}
                                             <td>{{$slider->status == 1 ? 'Published':'Unpublished'}}</td>
                                             <td>{{$slider->description }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
        <script>
            $(document).ready(function() {

                var table = $('#table').DataTable({
                    responsive: true,
                    fixedColumns: true,
                    fixedHeader: true,
                    scrollX: false,
                    'aoColumnDefs': [{
                        'bSortable': false,
                        'aTargets': ['nosort']
                    }],
                    // dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    // buttons: [
                    //     {
                    //         extend: 'excel',
                    //         className: 'btn-sm btn-success',
                    //         header: true,
                    //         footer: true,
                    //         exportOptions: {
                    //             columns: ':visible',
                    //         }
                    //     },
                    //     'colvis',
                    //     {
                    //         extend: 'print',
                    //         className: 'btn-sm btn-primary',
                    //         header: true,
                    //         footer: false,
                    //         orientation: 'landscape',
                    //         exportOptions: {
                    //             columns: ':visible',
                    //             stripHtml: false
                    //         }
                    //     }
                    // ]

                });
            });
        </script>
    @endpush
@endsection
