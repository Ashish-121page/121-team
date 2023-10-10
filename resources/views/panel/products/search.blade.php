@extends('backend.layouts.main') 
@section('title', 'Search Products')
@section('content')
@php
/**
 * Product 
 * @author    GRPL
 * @license  121.page
 * @version  <GRPL 1.1.0>
 * @link        https://121.page/
 */
    $breadcrumb_arr = [
        ['name'=>'Search Products', 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
   
    @endphp
    <!-- push external head elements to head -->
    @push('head')
    @endpush
        
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8 col-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-flex">
                            <h5> 
                                {{ 'Search & Copy' }}
                            </h5>
                            {{-- <span>List of Products</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        
        <form action="{{ route('panel.products.search') }}" method="GET" id="">
            <div class="row">   
                <!-- start message area-->
                <!-- end message area-->
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex flex-wrap justify-content-between">
                            
                        </div>
                        <div id="ajax-container">
                            @include('panel.products.searchload')
                        </div>
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
            var table_core = $("#table").clone();
            var clonedTable = $("#table").clone();
            clonedTable.find('[class*="no-export"]').remove();
            clonedTable.find('[class*="d-none"]').remove();
            $("#table").html(clonedTable.html());
            var data = document.getElementById('table');

            var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
            XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
            XLSX.writeFile(file, 'ProductFile.' + type);
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
           
        });

        function getSubCategories(id,sub_id){
            $.ajax({
                    url: "{{route('panel.user_shop_items.get-category')}}",
                    method: "get",
                    datatype: "html",
                    data: {
                        id:id,
                        selected_id:sub_id,
                    },
                    success: function(res){
                        $('#category_id').select2();
                        $('#sub_category').html(res);
                        $('#sub_category').select2();

                    }
                })
        }

        $('#category_id').change(function(){
            var id = $(this).val();
            if(id){
                $('#category_id').select2();
                $('#sub_category').select2();
                getSubCategories(id,null);
            }
        });

        setTimeout(() => {
            getSubCategories("{{request()->get('category_id')}}","{{request()->get('sub_category')}}");
        }, 1000);
       
            $(document).ready(function(){
                $('.qrPrintModal').on('click',function(){
                    var id = $(this).data('pid');
                    $('#prouductId').val(id);
                    $('#qrRequestModal').modal('show');
                });
            });
       
        </script>
    @endpush
@endsection
