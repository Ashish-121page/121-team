@extends('backend.layouts.main')
@section('title', 'Faqs')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'Faqs', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                            <h5>Faqs</h5>
                            {{-- <span>List of Faqs</span> --}}
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
                        <h3>Faqs</h3>
                        <a href="{{ route('backend/constant-management.faqs.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Faq"><i class="fa fa-plus" aria-hidden="true"></i></a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="table" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Actions</th>
                                        <th>Title</th>
                                        <th>Catagery</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($faqs as  $faq)
                                        <tr>
                                            <td class="text-center"> {{  $loop->iteration }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                        <li class="dropdown-item p-0"><a href="{{ route('backend/constant-management.faqs.edit', $faq->id) }}" title="Edit Faq" class="btn btn-sm">Edit</a></li>
                                                        <li class="dropdown-item p-0"><a href="{{ route('backend/constant-management.faqs.destroy', $faq->id) }}" title="Delete Faq" class="btn btn-sm delete-item">Delete</a></li>
                                                      </ul>
                                                </div>
                                            </td>
                                            <td>{{$faq->title }}</td>

                                             <td>{{fetchFirst('App\Models\Category',$faq->category_id,'name','--') }}</td>
                                              <td>
                                                @if($faq->is_publish == 1)

                                                     <span class="badge badge-success">Published</span>

                                                   @else

                                                    <span class="badge badge-danger">Unpublished</span>

                                                @endif
                                                    {{-- class="badge badge-{{ $faq->is_published == 0 ? 'danger' : 'success' }}">
                                                    {{ $faq->is_published == 1 ? 'Unpublished' : 'Published' }} --}}
                                             </td>


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
                

                });
            });
        </script>
    @endpush
@endsection
