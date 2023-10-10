@extends('backend.layouts.main') 
@section('title', 'Website Pages')
@section('content')
    @php
        $breadcrumb_arr = [
            ['name'=>'Website Pages', 'url'=> "javascript:void(0);", 'class' => ''],
            ['name'=>'Pages', 'url'=> "javascript:void(0);", 'class' => 'active']
        ]
    @endphp
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Website Pages')}}</h5>
                            {{-- <span>{{ __('This setting will be automatically updated in your website.')}}</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    
                    <div>
                        @include('backend.include.breadcrumb')
                    </div>
                </div>
                @include('backend.setting.sitemodal',['title'=>"How to use",'content'=>"You need to create a unique code and call the unique code with paragraph content helper."])
            </div>
        </div>  
        
        <form action="{{ route('panel.website_setting.pages')}}" method="GET" id="TableForm">
            <div class="row">
                <div class="col-md-12">  
					<div class="card">
						<div class="card-header d-flex flex-wrap justify-content-between align-items-center">
								<div class="flex-grow-1 col">
                                    <h5 class="mb-0 fw-600">{{ ('All Pages') }}</h5>
                                </div>
                                    
                            <div class="d-flex flex-wrap justify-content-right">
                                <div class="form-group mb-0 mr-2 mt-3 mt-lg-0">
                                    <span>From</span>
                                    <input type="date" name="from" class="form-control" value="{{request()->get('from')}}">
                                {{-- <label for="From" class="control-label"><input type="date" name="from" class="form-control"> --}}
                                </div>
                                <div class="form-group mb-0 mr-2 mt-3 mt-lg-0"> 
                                    <span>To</span>
                                    <input type="date" name="to" class="form-control" value="{{ request()->get('to')}}"> 
                                    {{-- <label for="To" class="control-label"><input type="date" name="to" class="form-control"> --}}
                                </div>
                               <div class="mt-3 mt-lg-0">
                                     
                                <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning " title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                <a href="javascript:void(0)" id="reset" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                <a class="btn btn-icon btn-sm btn-outline-success mr-2" href="#" data-toggle="modal" data-target="#siteModal"><i
                                    class="fa fa-info"></i></a>
                                <a href="{{ route('panel.website_setting.pages.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Pages"><i class="fa fa-plus" aria-hidden="true"></i></a>
                               </div>
                    
                            </div>
						</div>
                        <div id="ajax-container">
                            @include('backend.website_setup.pages.load')
                        </div>
						{{-- <div class="card-body">
                            <div class="table-responsive">
                                <table id="page_table" class="table aiz-table mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>{{ ('Name') }}</th>
                                            <th>{{('Status')}}</th>
                                            <th>{{('Actions')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($page as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>{{ $item->title }}</td>
                                                <td>@if ($item->status == 1)
                                                    <span class="badge badge-success">{{ $item->status == 1 ? "Publish" : ''  }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ $item->status == 0 ? "Unpublish" : '' }}</span></td>
                                                @endif
                                                <td>
                                                    <a href="{{ route('page.slug', $item->slug) }}" title="View Page" target="_blank" class="btn btn-outline-info btn-icon btn-sm"><i class="ik ik-eye" aria-hidden="true"></i></a>
                                                    <a href="{{ route('panel.website_setting.pages.edit', $item->id) }}" title="Edit Page" class="btn btn-outline-warning btn-icon btn-sm"><i class="ik ik-edit" aria-hidden="true"></i></a>
                                                    <a href="{{ route('panel.website_setting.pages.delete', $item->id) }}" title="Edit Page" class="btn btn-outline-danger btn-icon btn-sm delete-item"><i class="ik ik-trash" aria-hidden="true"></i></a>
                                                    
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
						</div> --}}
					</div>
                </div>
            </div>
        </form>
    </div>
    
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
           
           function html_table_to_excel(type)
            {
                var table_core = $("#page_table").clone();
                var clonedTable = $("#page_table").clone();
                clonedTable.find('[class*="no-export"]').remove();
                clonedTable.find('[class*="d-none"]').remove();
                $("#page_table").html(clonedTable.html());
                // console.log(clonedTable.html());
                var data = document.getElementById('page_table');

                var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
                XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
                XLSX.writeFile(file, 'PageFile.' + type);
                $("#page_table").html(table_core.html());
            }

            $(document).on('click','#export_button',function(){
                html_table_to_excel('xlsx');
            });
  

       

        $('#reset').click(function(){
            getData("{{ route('panel.website_setting.pages') }}");
            window.history.pushState("", "", "{{ route('panel.website_setting.pages') }}");
            $('#TableForm').trigger("reset");
         });


    </script>
  
    @endpush
@endsection
