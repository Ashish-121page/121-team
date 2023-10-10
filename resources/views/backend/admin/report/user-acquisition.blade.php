@extends('backend.layouts.main')
@section('title', 'User Acquisition')
@section('content')
@push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/chartist/dist/chartist.min.css') }}">
@endpush
    @php
    /**
     * Order
     *
     * @category  zStarter
     *
     * @ref  zCURD
     * @author    GRPL
     * @license  121.page
     * @version  <GRPL 1.1.0>
     * @link        https://121.page/
     */
    $breadcrumb_arr = [['name' => 'User Acquisition', 'url' => 'javascript:void(0);', 'class' => 'active']];
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
                            <h5>User Acquisition</h5>
                            {{-- <span>List of User Acquisition</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>

        <div class="row">
            <!-- start message area-->
            <!-- end message area-->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex flex-wrap justify-content-between">
                       <div class="flex-grow-1 col">
                            <h3>User Acquisition Report</h3>
                       </div>
                        <div class="">
                            <form class="d-flex flex-wrap justify-content-right" action="{{ route('panel.report.user-acquisition') }}" method="get" >
                                
                                    <div class="form-group mb-0 mr-2 mt-3 mt-lg-0">
                                        <span>From</span>
                                        <label for=""><input type="date" name="from" class="form-control" value="{{ request()->get('from') }}"></label>
                                    </div>
                                    <div class="form-group mb-0 mr-2">
                                        <span>To</span>
                                        <label for=""><input type="date" name="to" class="form-control" value="{{ request()->get('to') }}"></label>
                                    </div>
                                    <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                    <a href="{{ route('panel.report.user-acquisition') }}" id="reset"
                                        data-url="" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                    <a href="#" id="clickToShowGraph" class="btn btn-icon btn-sm btn-outline-info mr-2" title="View Chart"><i class="fa fa-chart-pie" aria-hidden="true"></i></a>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div id="ajax-container">
                            @include('backend.admin.report.partials.user_acquisition')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->

@endsection

@push('script')
    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
   
    <script>
         function html_table_to_excel(type)
        {
            var table_core = $("#table").clone();
            var clonedTable = $("#table").clone();
            clonedTable.find('[class*="no-export"]').remove();
            clonedTable.find('[class*="d-none"]').remove();
            $("#table").html(clonedTable.html());
            var data = document.getElementById('table');

            var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
            XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
            XLSX.writeFile(file, 'AccessCodeFile.' + type);
            $("#table").html(table_core.html());
        }

        $(document).on('click','#export_button',function(){
            html_table_to_excel('xlsx');
        })
       

        $('#reset').click(function(){
            var url = $(this).data('url');
            getData(url);
            window.history.pushState("", "", url);
            $('#TableForm').trigger("reset");
            //   $('#fieldId').select2('val',""); // if you use any select2 in filtering uncomment this code
           // $('#fieldId').trigger('change');// if you use any select2 in filtering uncomment this code
        });
    </script>
@endpush