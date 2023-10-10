@extends('backend.layouts.main') 
@section('title', 'User Log')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'Administrator', 'url'=> "javascript:void(0);", 'class' => ''],
        ['name'=>'User Log', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                            <h5>{{ __('User Log')}}</h5>
                            {{-- <span>{{ __('List of User Log')}}</span> --}}
                        </div>
                    </div>
                </div> 
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>{{ __('User Log')}}</h3>
                        {{-- <div class="form-group">
                            <select id="getDataByRole" required class="select2 form-control course-filter">
                                <option value="">--{{ __('Select User Type') }}--</option>
                                @foreach($roles as $index => $user)
                                    <option value="{{ $user}}" @isset($role) @if($role == $user) selected @endif @endisset>{{ $user }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="user_log_table" class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        {{-- <th>Actions</th> --}}
                                        <th>Name</th>
                                        <th>Ip Address</th>
                                        <th>Activity</th>
                                        <th>Broswer Name</th>
                                        <th>Platform</th>
                                        <th>Activity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user_log as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ NameById($item->user_id) }}</td>
                                            <td>{{ $item->ip_address }}</td>
                                            <td>{{ $item->activity }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->platform }}</td>
                                            <td>{{ getFormattedDateTime($item->created_at) }}</td>
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
            $('#getDataByRole').on('change', function(){
                    var val = $(this).val();
                    var route = "{{url('/panel/user-log/')}}";
                    window.location.href = route+'/'+val;
            });
        </script>
        <script>
            $(document).ready(function() {

                var table = $('#user_log_table').DataTable({
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
