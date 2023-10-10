@extends('backend.layouts.main') 
@section('title', 'Microsite Enquiry')
@section('content')
    <style>
        .remove-ik-class{
            -webkit-box-shadow: unset !important;
            box-shadow: unset !important;
        }
    </style>
    @php
    $breadcrumb_arr = [
        ['name'=>'Manage', 'url'=> "javascript:void(0);", 'class' => ''],
        ['name'=>'Microsite Enquiry', 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
    @endphp

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-flex">
                            <h5>{{ __('Microsite Enquiry')}}</h5>
                            @if(AuthRole() == 'User')
                                <span style="margin-top: -10px;">
                                    <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                                </span>
                            @endif
                        </div>
                        {{-- <span>{{ __('List of Microsite Enquiry')}}</span> --}}
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        @if(AuthRole() != 'User')
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3>{{ __('Microsite Enquiry')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Actions</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                            {{-- <th>Reply</th> --}}
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($seller_enquiries->count() > 0)
                                            @foreach ($seller_enquiries as $seller_enquiry)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                                                id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">Action<i
                                                                    class="ik ik-chevron-right"></i></button>
                                                            <ul class="dropdown-menu multi-level" role="menu"
                                                                aria-labelledby="dropdownMenu">
                                                                <li class="dropdown-item p-0"><a
                                                                    href="{{ route('panel.seller.enquiry.edit',$seller_enquiry->id) }}"
                                                                    title="Edit Site Content Management"
                                                                    class="btn btn-sm">Edit</a></li>
                                                                <li class="dropdown-item p-0"><a
                                                                    href="{{ route('panel.seller.enquiry.delete',$seller_enquiry->id) }}"
                                                                    title="Delete Site Content Management"
                                                                    class="btn btn-sm delete-item">Delete</a></li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <td>{{ Str::limit($seller_enquiry->subject,20) }}</td>
                                                    <td>{{ Str::limit($seller_enquiry->description,20) }}</td>
                                                    <td>{{ getFormattedDate($seller_enquiry->created_at) }}</td>
                                                    {{-- <td>{{ $seller_enquiry->reply ?? '--'}}</td> --}}
                                                    <td> 
                                                        <span class="badge badge-{{ $seller_enquiry->status == 0 ? 'secondary' : 'success'}}">{{ $seller_enquiry->status == 0 ? 'Pending' : 'Solved'}}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <div class="mx-auto">
                                                <span>No User Enquiries Yet!</span>
                                            </div>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>{{ __('Microsite Enquiry')}}</h3>
                    </div>
                    <div class="card-body bg-white">
                        <div class="row mt-3">
                            @if($seller_enquiries->count() > 0)
                                @foreach ($seller_enquiries as $seller_enquiry)
                                    <div class="col-md-4">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                    <div class="profile-pic mb-20">
                                                        <div class="row">
                                                            <div class="col-12 pt-2 text-left">
                                                                <span class="badge badge-{{ $seller_enquiry->status == 0 ? 'secondary' : 'success'}}">{{ $seller_enquiry->status == 0 ? 'Pending' : 'Solved'}}</span>
                                                                    <button style="background: transparent;margin-right: -20px;margin-top: -8px;" class="btn dropdown-toggle float-right" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                                        <a href="{{ route('panel.seller.enquiry.edit',$seller_enquiry->id) }}" title="Edit Site Content Management"class="btn btn-sm">Edit</a></li>
                                                                        </a>
                                                                        <li class="dropdown-item p-0"><a
                                                                            href="{{ route('panel.seller.enquiry.delete',$seller_enquiry->id) }}"
                                                                            title="Delete Site Content Management"
                                                                            class="btn btn-sm delete-item">Delete</a>
                                                                        </li>
                                                                    
                                                                    </ul>
                                                                <h5 class="mt-2 ">{{ Str::limit($seller_enquiry->subject,20) }}</h5>
                                                                <p>{{ Str::limit($seller_enquiry->description,100) }}</p>
                                                                <span><i class="ik ik-clock"></i>{{ getFormattedDate($seller_enquiry->created_at) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                        
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="mx-auto">
                                    <span>No User Enquiries Yet!</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <div class="pagination">
                            {{ $seller_enquiries->appends(request()->except('page'))->links() }}
                        </div>
                        <div>
                            @if ($seller_enquiries->lastPage() > 1)
                                <label for="">Jump To:
                                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="jumpTo">
                                        @for ($i = 1; $i <= $seller_enquiries->lastPage(); $i++)
                                            <option value="{{ $i }}" {{ $seller_enquiries->currentPage() == $i ? 'selected' : '' }}>
                                                {{ $i }}</option>
                                        @endfor
                                    </select>
                                </label>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- push external js -->
    @push('script')
        <script>
            $(document).ready(function() {
                var table = $('.table').DataTable({
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
                        {
                             extend: 'colvis',
                            header: true,
                            footer: true,
                            orientation: 'landscape',
                            exportOptions: {
                                columns: ':visible',
                            }
                        }
                    ]

                });
            });
        </script>
    @endpush
@endsection


