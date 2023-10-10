@extends('backend.layouts.main') 
@section('title', 'Product')
@section('content')
@php
 $user_shop = App\Models\UserShop::whereUserId(request()->get('user_id'))->first();
/**
 * User Shop Item 
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    GRPL
 * @license  121.page
 * @version  <GRPL 1.1.0>
 * @link        https://121.page/
 */
    $breadcrumb_arr = [
        ['name'=> $user_shop->name ?? '' , 'url'=> route('panel.user_shops.index'), 'class' => 'active']
    ]
    @endphp
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ $user_shop->name ?? '' }}</h5>
                            {{-- <span>List of Product</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        
        <form action="{{ route('panel.user_shop_items.index') }}" method="GET" id="TableForm">
            <div class="row">
                <!-- start message area-->
                <!-- end message area-->
                <input type="hidden" name="user_id" value="{{ request()->get('user_id') }}">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex flex-wrap justify-content-between">
                            <div class="flex-grow-1 col">
                                <h3>Product</h3>
                            </div>
                            <div class="d-flex flex-wrap justicy-content-right">
                                <div class="form-group mb-0 mr-2">
                                    <span>From</span>
                                <label for=""><input type="date" name="from" class="form-control" value="{{request()->get('from')}}"></label>
                                </div>
                                <div class="form-group mb-0 mr-2"> 
                                    <span>To</span>
                                        <label for=""><input type="date" name="to" class="form-control" value="{{request()->get('to')}}"></label> 
                                </div>
                                <div class="form-group mb-0 mr-2"> 
                                    <span>Published</span>
                                        <label for="">
                                            <select name="is_published" id="" class="form-control select2">
                                                <option value="" aria-readonly="true">Select Published</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0"> No</option>
                                            </select>
                                        </label>
                                </div>
                                <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                <a href="javascript:void(0);" id="reset" data-url="{{ route('panel.user_shop_items.index')."?user_id=".request()->get('user_id') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                @if (!AuthRole() == 'Admin' && request()->has('user_id'))
                                    <a href="{{ route('panel.user_shop_items.create',['user_id='.request()->get('user_id')]) }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Product"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                @endif
                                 
                            </div>
                        </div>
                        <div id="ajax-container">
                            @include('panel.user_shop_items.load')
                        </div>
                    </div>
                </div>
            </div>
        <form>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
        <script>
           $('#isPublishedOnChange').change(function(){
                window.location.href = "{{ route('panel.user_shop_items.index') }}"+"?published="+$(this).val();
           });
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
            XLSX.writeFile(file, 'UserShopItemFile.' + type);
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
            //   $('#fieldId').select2('val',"");               // if you use any select2 in filtering uncomment this code
           // $('#fieldId').trigger('change');                  // if you use any select2 in filtering uncomment this code
        });

         
       
        </script>
    @endpush
    
@endsection
