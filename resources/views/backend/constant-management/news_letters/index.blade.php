@extends('backend.layouts.main') 
@section('title', 'Newsletters')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'Newsletters', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                            <h5>Newsletters</h5>
                            <span>List of Newsletters</span>
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
                        <h3>Newsletters</h3>
                        <div>
                            <a href="{{ route('backend/constant-management.news_letters.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New NewsLetter"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            <a href="{{ route('backend/constant-management.news_letters.launchcampaign.show') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Launch Campaign"><i class="ik ik-send" aria-hidden="true"></i></a>
                        </div>
                    </div>
                    <div class="card-body">                        
                        <div class="table-responsive">
                            <table id="table" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Actions</th>                                            
                                        <th>Type</th>
                                        <th>Email</th>  
                                        <th>Phone</th>  
                                        <th>Name</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($news_letters as  $news_letter)
                                        <tr>
                                            <td class="text-center"> {{  $loop->iteration }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                        <li class="dropdown-item p-0"><a href="{{ route('backend/constant-management.news_letters.edit', $news_letter->id) }}" title="Edit NewsLetter" class="btn btn-sm">Edit</a></li>
                                                        <li class="dropdown-item p-0"><a href="{{ route('backend/constant-management.news_letters.destroy', $news_letter->id) }}" title="Delete NewsLetter" class="btn btn-sm delete-item">Delete</a></li>
                                                      </ul>
                                                </div> 
                                            </td>
                                            <td>
                                                @if ($news_letter->type == 1)
                                                    {{ 'Email' }}
                                                @else
                                                    {{ 'Number' }}
                                                @endif
                                            </td>
                                            <td>{{$news_letter->value }}</td>
                                            <td>{{$news_letter->phone ?? "--" }}</td>
                                            <td>{{$news_letter->name }}</td>
                                             
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
