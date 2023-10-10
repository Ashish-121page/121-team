@extends('backend.layouts.main') 
@section('title', 'My Brands')
@section('content')
<style>
    .remove-ik-class{
        -webkit-box-shadow: unset !important;
        box-shadow: unset !important;
    }
</style>
@php
/**
 * Brand 
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
        ['name'=>'Brands', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                        <i class="ik ik-mail bg-blue" title="help Text"></i>
                        <div class="d-flex">
                            <h5>
                                @if(AuthRole() != 'User')
                                    Brands
                                @else
                                    My Brands
                                @endif
                            </h5>
                                
                            @if(AuthRole() == 'User')
                            <span style="margin-top: -10px;">
                                <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        
        <form action="{{ route('panel.brands.index') }}" method="GET" id="TableForm">
            <div class="row">
                <!-- start message area-->
                <!-- end message area-->
           
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="flex-grow-1 col">
                                <h3 style="width: 100px;">Brands</h3>
                            </div>
                            <div class="d-flex justicy-content-right flex-wrap no-gutter">
                            @if(AuthRole() == 'Admin')
                                <div class="form-group mb-0 mr-2">
                                    <span>Verified</span>
                                    <label for="">
                                        <select name="is_verified" id="" class="form-control  select2">
                                            <option value="" aria-readonly="true">Select Verified Brand</option> 
                                            @foreach(getVerifiedStatus() as $option)
                                                <option value="{{ $option['id'] }}" @if ($option['id'] == $request->get('is_verified')) selected @endif>{{$option['name']}}</option> 
                                            @endforeach
                                        </select>
                                    </label>
                                </div>
                                <div class="form-group mb-0 mr-2">
                                    <span>Status</span>
                                    <label for="">
                                        <select name="status" id="" class="form-control select2">
                                            <option value="" aria-readonly="true">Select Status</option> 
                                            @foreach(getBrandStatus() as $status)
                                                <option value="{{ $status['id'] }}" @if ($status['id'] == $request->get('status')) selected @endif>{{$status['name']}}</option> 
                                            @endforeach
                                        </select>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                <a href="javascript:void(0);" id="reset" data-url="{{ route('panel.brands.index') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                            @endif
                            <a href="{{ route('panel.brands.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Brand"><i class="fa fa-plus" aria-hidden="true"></i></a>
                            </div>
                        </div>
                        @if(AuthRole() != 'User')
                            <div id="ajax-container">
                                @include('panel.brands.load')
                            </div>
                        @else
                            <div class="col-md-12">
                                <div class="row mt-3">
                                    @if ($brands->count() > 0)
                                        @foreach ($brands as $brand)
                                            @php
                                                $brand_logo = App\Models\Media::whereType('Brand')->whereTypeId($brand->id)->first();
                                                // $brand_user_as = App\Models\BrandUser::whereUserId(auth()->id())->whereBrandId($brand->id)->whereType(1)->whereStatus(1)->exists();
                                                // $brand_user_bo = App\Models\BrandUser::whereUserId(auth()->id())->whereBrandId($brand->id)->whereType(0)->whereStatus(1)->exists();
                                            @endphp
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <div class="card-body text-center" style="padding: 8px 10px;">
                                                        <div class="profile-pic mb-20">
                                                            <div class="row">
                                                                <div class="col-4 pr-0">
                                                                    @if($brand_logo != null)
                                                                        <img src="{{ ($brand_logo && $brand_logo->path) ? asset($brand_logo->path) : asset('frontend/assets/img/placeholder.png') }}" alt="" style="height:60px;width:60px;object-fit:contain;" class="rounded mt-2">
                                                                    @endif
                                                                </div>
                                                                
                                                                <div class="col-6 pl-5 pt-2 text-left">
                                                                    <h6 class="mb-0">{{ $brand->name }}
                                                                        @if($brand->is_verified)
                                                                            <span title="Email Verified"><i class="fas fa-sm fa-check-circle" style="color: #6666cc;"></i></span>
                                                                        @endif
                                                                    </h6>
                                                                
                                                                    <i title="incoming request" class="ik ik-corner-up-left"></i>
                                                                    <span class="mt-2 p-1">Items: {{ getProductByBrandId($brand->id, 'count') }}
                                                                    </span><br>
                                                                    <span><i class="ik pr-1 ik-clock"></i>{{ getFormattedDate($brand->created_at) }}</span>
                                                                </div>
                                                                <div class="col-2 pl-2">
                                                                    <button style="background: transparent;" class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                                        <a href="{{ route('panel.brands.edit', [$brand->id,'active' => 'appearance' ]) }}" title="Edit Brand"
                                                                            class="dropdown-item ">
                                                                            <li class="p-0">Edit</li>
                                                                        </a>
                                                                        @if(AuthRole() == "Admin")
                                                                            <a href="{{ route('panel.brands.destroy', $brand->id) }}" title="Delete Brand"
                                                                                class="dropdown-item  delete-item">
                                                                                <li class=" p-0">Delete</li>
                                                                            </a>
                                                                            @if($brand->user_id != null)
                                                                            <a href="{{ url('panel/user/login-as/'.$brand->user_id)}}"><li class="dropdown-item">Login As</li></a>
                                                                            @endif
                                                                        @endif
                                                                        <a href="{{ route('panel.products.index') }}{{'?id='.$brand->id}}" title="Manage Product"
                                                                            class="dropdown-item">
                                                                            <li class=" p-0">Manage Products</li>
                                                                        </a>
                                                                        <a href="{{ route('panel.products.create')."?action=branded&id=".$brand->id}}" title="Manage Product"
                                                                            class="dropdown-item">
                                                                            <li class=" p-0">Add Product</li>
                                                                        </a>
                                                                        @if(AuthRole() == "Admin")
                                                                            <a href="{{ route('panel.brand_user.index') }}{{'?id='.$brand->id.'&status=1'}}" title="Authorized Seller"
                                                                                class="dropdown-item">
                                                                                <li class=" p-0">Authorized Seller</li>
                                                                            </a>
                                                                        @endif
                                                                        @if(AuthRole() == "User")
                                                                        {{-- @dump(($brand->user_id)) --}}
                                                                            @if((!$brand->hasAuthSeller() || !$brand->hasBrandOwner()) && $brand->is_verified != 1)
                                                                                <a href="{{ route('panel.brand.claim.create',$brand->id) }}" title="Claim Brand"
                                                                                class="dropdown-item">
                                                                                    <li class="p-0">Claim</li>
                                                                                </a>
                                                                            @endif
                                                                        @endif
                                                                        @if(AuthRole() == "User" && auth()->user()->is_supplier == 1 && isBrandBO($brand->id, auth()->id()))
                                                                        <a href="{{ route('panel.brand_user.index') }}{{'?id='.$brand->id.'&status=0'}}" title="Authorized Seller"
                                                                            class="dropdown-item">
                                                                            <li class=" p-0">Seller Request</li>
                                                                        </a>
                                                                        @elseif(AuthRole() == "Admin")
                                                                        <a href="{{ route('panel.brand_user.index') }}{{'?id='.$brand->id.'&status=0'}}" title="Authorized Seller"
                                                                            class="dropdown-item">
                                                                            <li class=" p-0">Seller Request</li>
                                                                        </a>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="mx-auto mb-3">
                                            <span class="text-center">No Brands yet!</span>
                                        </div>
                                    @endif         
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <div class="pagination">
                                        {{ $brands->links() }}
                                    </div>
                                </div>
                            </div>
                        @endif
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
            XLSX.writeFile(file, 'BrandFile.' + type);
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

       
        </script>
    @endpush
@endsection
