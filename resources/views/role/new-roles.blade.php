@extends('backend.layouts.main') 
@section('title', 'Roles')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
    @endpush

    
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-award bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Roles')}}</h5>
                            <span>{{ __('Define roles of user')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Roles')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row clearfix">
	        <!-- start message area-->
            @include('backend.include.message')
            <!-- end message area-->
            <!-- only those have manage_role permission will get access -->
            @can('manage_role')
			<div class="col-md-12">
	            <div class="card">
	                <div class="card-header"><h3>{{ __('Add Role')}}</h3></div>
	                <div class="card-body">
	                    <form class="forms-sample" method="POST" action="{{url('panel/role/create')}}">
	                    	@csrf
	                        <div class="row">
	                            <div class="col-sm-5">
	                                <div class="form-group">
	                                    <label for="role">{{ __('Role')}}<span class="text-red">*</span></label>
	                                    <input type="text" class="form-control is-valid" id="role" name="role" placeholder="Role Name" required>
	                                </div>
	                            </div>
	                            <div class="col-sm-7">
	                                <label for="exampleInputEmail3">{{ __('Assign Permission')}} </label>
	                                <div class="row">
	                                	@foreach($permissions as $key => $permission)
	                                	<div class="col-sm-4">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="item_checkbox" name="permissions[]" value="{{$key}}">
                                                <span class="custom-control-label">
                                                	<!-- clean unescaped data is to avoid potential XSS risk -->
                                                	{{ clean($permission,'titles')}}
                                                </span>
                                            </label>
	                                		
	                                	</div>
	                                	@endforeach 
	                                </div>
	                                
	                                <div class="form-group">
	                                	<button type="submit" class="btn btn-primary btn-rounded">{{ __('Save')}}</button>
	                                </div>
	                            </div>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
            @endcan
		</div>
		<div class="row">
	        <div class="col-md-12">
	            <div class="card p-3">
	                <div class="card-header"><h3>{{ __('Roles')}}</h3></div>
	                <div class="card-body">
	                    <table id="roles_table" class="table">
	                        <thead>
	                            <tr>
	                                <th>{{ __('Role')}}</th>
	                                <th>{{ __('Permissions')}}</th>
	                                <th>{{ __('Action')}}</th>
	                            </tr>
	                        </thead>
	                        <tbody>
								@foreach($roles as $role)
								<tr>
									<td>{{ $role->name }}</td>
									<td>
										@if($role->name == 'Super Admin')
											<span class="badge badge-success m-1">All permissions</span>
										@else
											@foreach ($role->permissions()->get() as $item)
											<span class="badge badge-dark m-1">{{ $item->name }}</span>
											@endforeach
										@endif
									</td>
									<td>
										@if(auth()->user()->can('manage_role'))
											@if($role->name != 'Super Admin')
												<a href="{{ url('/panel/role/edit/'.$role->id)}}" ><i class="ik ik-edit-2 f-16 mr-15 text-green"></i></a>
												@if($role->type == 0)
													<a href="{{ url('/panel/role/delete/'.$role->id)}}" ><i class="ik ik-trash-2 f-16 text-red"></i></a>
												@endif
											@endif
										@endif
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
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
    <!--server side roles table script-->
	<script>
		 $(document).ready(function()
    {
        var searchable = [];
        var selectable = []; 
        

        // var dTable = $('#roles_table').DataTable({

        //     order: [],
        //     lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        //     processing: true,
        //     responsive: false,
        //     serverSide: true,
        //     processing: true,
        //     language: {
        //       processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
        //     },
        //     scroller: {
        //         loadingIndicator: false
        //     },
        //     pagingType: "full_numbers",
        //     dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
        //     ajax: {
        //         url: 'role/get-list',
        //         type: "get"
        //     },
        //     columns: [
        //         {data:'name', name: 'name', orderable: false, searchable: false},
        //         {data:'permissions', name: 'permissions'},
        //         //only those have manage_role permission will get access
        //         {data:'action', name: 'action'}

        //     ],
        //     buttons: [
        //         {
        //             extend: 'copy',
        //             className: 'btn-sm btn-info',
        //             title: 'Roles',
        //             header: false,
        //             footer: true,
        //             exportOptions: {
        //                 // columns: ':visible'
        //             }
        //         },
        //         {
        //             extend: 'csv',
        //             className: 'btn-sm btn-success',
        //             title: 'Roles',
        //             header: false,
        //             footer: true,
        //             exportOptions: {
        //                 // columns: ':visible'
        //             }
        //         },
        //         {
        //             extend: 'excel',
        //             className: 'btn-sm btn-warning',
        //             title: 'Roles',
        //             header: false,
        //             footer: true,
        //             exportOptions: {
        //                 // columns: ':visible',
        //             }
        //         },
        //         {
        //             extend: 'pdf',
        //             className: 'btn-sm btn-primary',
        //             title: 'Roles',
        //             pageSize: 'A2',
        //             header: false,
        //             footer: true,
        //             exportOptions: {
        //                 // columns: ':visible'
        //             }
        //         },
        //         {
        //             extend: 'print',
        //             className: 'btn-sm btn-default',
        //             title: 'Roles',
        //             // orientation:'landscape',
        //             pageSize: 'A2',
        //             header: true,
        //             footer: false,
        //             orientation: 'landscape',
        //             exportOptions: {
        //                 // columns: ':visible',
        //                 stripHtml: false
        //             }
        //         }
        //     ],
        //     initComplete: function () {
        //         var api =  this.api();
        //         api.columns(searchable).every(function () {
        //             var column = this;
        //             var input = document.createElement("input");
        //             input.setAttribute('placeholder', $(column.header()).text());
        //             input.setAttribute('style', 'width: 140px; height:25px; border:1px solid whitesmoke;');

        //             $(input).appendTo($(column.header()).empty())
        //             .on('keyup', function () {
        //                 column.search($(this).val(), false, false, true).draw();
        //             });

        //             $('input', this.column(column).header()).on('click', function(e) {
        //                 e.stopPropagation();
        //             });
        //         });

        //         api.columns(selectable).every( function (i, x) {
        //             var column = this;

        //             var select = $('<select style="width: 140px; height:25px; border:1px solid whitesmoke; font-size: 12px; font-weight:bold;"><option value="">'+$(column.header()).text()+'</option></select>')
        //                 .appendTo($(column.header()).empty())
        //                 .on('change', function(e){
        //                     var val = $.fn.dataTable.util.escapeRegex(
        //                         $(this).val()
        //                     );
        //                     column.search(val ? '^'+val+'$' : '', true, false ).draw();
        //                     e.stopPropagation();
        //                 });

        //             $.each(dropdownList[i], function(j, v) {
        //                 select.append('<option value="'+v+'">'+v+'</option>')
        //             });
        //         });
        //     }
        // });
    });
	</script>
	@endpush
@endsection
