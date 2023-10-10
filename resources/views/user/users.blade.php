@extends('backend.layouts.main') 
@section('title', 'Users')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
        <style>
            .select2-selection.select2-selection--single{
                width: 175px !important;
            }
        </style>
    @endpush

    
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-users bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Users')}}</h5>
                            {{-- <span>{{ __('List of users')}}</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('panel.dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Users')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card p-3">
                    <div class="card-header d-flex  justify-content-between">
                        <h3>{{ __('Users')}}</h3>
                        <div class="form-group">
                            <select id="getDataByRole" required class="select2 form-control course-filter">
                                <option value="">--{{ __('Select User Type') }}--</option>
                                @foreach($roles as $index => $user)
                                    <option value="{{ $user}}" @isset($role) @if($role == $user) selected @endif @endisset>{{ $user }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- <div class="table-responsive"> --}}
                            <table id="user_table" class="table p-0">
                                <thead>
                                    <tr>
                                        <th>{{ __('S No.')}}</th>
                                        <th>{{ __('Action')}}</th>
                                        <th>{{ __('Customer')}}</th>
                                        <th>{{ __('Role')}}</th>
                                        <th>{{ __('Email')}}</th>
                                        <th>{{ __('Status')}}</th>
                                        <th>{{ __('Join At')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
    <!--server side users table script-->
    {{-- <script src="{{ asset('backend/js/custom.js') }}"></script> --}}
    <script>
        $('#getDataByRole').on('change', function(){
                var val = $(this).val();
                var route = "{{url('/panel/users/index/')}}";
                window.location.href = route+'/'+val;
           });

           (function($) {

            //users data table
            $(document).ready(function()
            {
                var i = 1;
                var searchable = [];
                var selectable = []; 
                var route = "{{ url('panel/user/get-list') }}";
                var dTable = $('#user_table').DataTable({

                    order: [],
                    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    processing: true,
                    responsive: false,
                    serverSide: true,
                    processing: true,
                    language: {
                    processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
                    },
                    scroller: {
                        loadingIndicator: false
                    },
                    pagingType: "full_numbers",
                    dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    ajax: {
                        url: route,
                        type: "get",
                        data: {'filter' : $('#getDataByRole').val()}
                    },
                    columns: [
                        {
                            "render": function(data, type, row, meta) {
                            return i++;
                            }
                        },
                        {data:'action', name: 'action'},
                        {data:'name', name: 'name', orderable: false, searchable: false},
                        {data:'roles', name: 'roles'},
                        {data:'email', name: 'email'},
                        {data:'status', name: 'status'},
                        {data:'join_at', name: 'join_at'},
                        //only those have manage_user permission will get access

                    ],
                    buttons: [
                        // {
                        //     extend: 'copy',
                        //     className: 'btn-sm btn-info',
                        //     title: 'Users',
                        //     header: false,
                        //     footer: true,
                        //     exportOptions: {
                        //         // columns: ':visible'
                        //     }
                        // },
                        // {
                        //     extend: 'csv',
                        //     className: 'btn-sm btn-warning',
                        //     title: 'Users',
                        //     header: false,
                        //     footer: true,
                        //     exportOptions: {
                        //         // columns: ':visible'
                        //     }
                        // },
                        {
                            extend: 'excel',
                            className: 'btn-sm btn-success',
                            title: 'Users',
                            header: false,
                            footer: true,
                            exportOptions: {
                                columns: ':visible',
                            }
                        },'colvis',
                        // {
                        //     extend: 'pdf',
                        //     className: 'btn-sm btn-default',
                        //     title: 'Users',
                        //     pageSize: 'A2',
                        //     header: false,
                        //     footer: true,
                        //     exportOptions: {
                        //         // columns: ':visible'
                        //     }
                        // },
                        {
                            extend: 'print',
                            className: 'btn-sm btn-primary',
                            title: 'Users',
                            // orientation:'landscape',
                            pageSize: 'A2',
                            header: true,
                            footer: false,
                            orientation: 'landscape',
                            exportOptions: {
                                // columns: ':visible',
                                stripHtml: false
                            }
                        }
                    ],
                    initComplete: function () {
                        var api =  this.api();
                        api.columns(searchable).every(function () {
                            var column = this;
                            var input = document.createElement("input");
                            input.setAttribute('placeholder', $(column.header()).text());
                            input.setAttribute('style', 'width: 140px; height:25px; border:1px solid whitesmoke;');

                            $(input).appendTo($(column.header()).empty())
                            .on('keyup', function () {
                                column.search($(this).val(), false, false, true).draw();
                            });

                            $('input', this.column(column).header()).on('click', function(e) {
                                e.stopPropagation();
                            });
                        });

                        api.columns(selectable).every( function (i, x) {
                            var column = this;

                            var select = $('<select style="width: 140px; height:25px; border:1px solid whitesmoke; font-size: 12px; font-weight:bold;"><option value="">'+$(column.header()).text()+'</option></select>')
                                .appendTo($(column.header()).empty())
                                .on('change', function(e){
                                    var val = $.fn.dataTable.util.escapeRegex(
                                        $(this).val()
                                    );
                                    column.search(val ? '^'+val+'$' : '', true, false ).draw();
                                    e.stopPropagation();
                                });

                            $.each(dropdownList[i], function(j, v) {
                                select.append('<option value="'+v+'">'+v+'</option>')
                            });
                        });
                    }
                });
            });
    $('select.select2').select2();
})(jQuery);
    </script>
    @endpush
@endsection
