@extends('backend.layouts.main') 
@section('title', 'Request Under Approval')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'Enquiries', 'url'=> route('panel.admin.enquiry.index'), 'class' => 'active'],
        ['name'=>'Request Under Approval', 'url'=> "javascript:void(0);", 'class' => 'active'],
    ]
    @endphp
    <!-- push external head elements to head -->
    @push('head')
    <style>
        .daterangepicker.dropdown-menu.ltr.show-calendar.opensright{
            width: 455px !important;
        }
        .remove-ik-class{
            -webkit-box-shadow: unset !important;
            box-shadow: unset !important;
        }
        
    </style>
    @endpush


    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-flex">
                            <h5>{{ __('Request Under Approval')}}</h5>
                            @if(AuthRole() == 'User')
                                <span style="margin-top: -10px;">
                                    <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                                </span>
                            @endif
                            {{-- <span>{{ __('List of From Supplier')}}</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        <div class="row">
            {{-- @if(AuthRole() != 'Admin')
                <div class="d-flex mb-3">
                    <a href="{{ route('panel.admin.enquiry.index')."?type=enquiry"}}" class="btn @if(request()->get('type') == "enquiry")  btn-primary @else  text-secondary  @endif mr-2 tab-btn">Product Request
                        @if($pending_enq > 0)
                            <span class="badge badge-warning">{{$pending_enq}}</span>
                        @endif
                    </a>
                    <a href="{{ route('panel.seller.supplier.index')}}" class="btn mr-2 tab-btn">Request Under Approval
                        @php
                            $product_enq_requests = getAccessCataloguePendingCount(auth()->id(),0);
                        @endphp
                        @if($product_enq_requests > 0)
                            <span class="badge badge-warning">{{$product_enq_requests}}</span>
                        @endif
                    </a>
                    <a href="{{ route('panel.admin.enquiry.index')."?type=par"}}" class="btn @if(request()->get('type') == "par")  btn-primary @else  text-secondary  @endif mr-2 tab-btn">Price Request
                        @if($pending_par > 0)
                            <span class="badge badge-warning">{{$pending_par}}</span>
                        @endif
                    </a>
                    <a href="{{ route('panel.seller.enquiry.index')."?type=contact" }}" class="btn @if(request()->get('type') == "contact")  btn-primary @else  text-secondary  @endif mr-2 tab-btn">Contact
                    </a>
                    <hr>
                </div>
            @endif --}}
            <!-- start message area-->
            <!-- end message area-->
            @if(AuthRole() == 'Admin')
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3>{{ __('Request Under Approval')}}</h3> 
                            <a href="#" data-toggle="modal" data-target="#requestForCatalogue" class="btn btn-primary">Request Catalogue</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="supplier_table" class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Catalogue From</th>
                                            <th>Preview</th>
                                            <th>Products</th>
                                            <th>Location</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pending_requests as $pending_request)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="mr-2">
                                                        @php
                                                            $user = App\User::whereId($pending_request->user_id)->first();
                                                            $user_shop_item = App\Models\UserShopItem::whereUserId($pending_request->user_id)->get()->count();
                                                        @endphp
                                                        <img class="supplier-image" src="{{ $user && $user->avatar ? $user->avatar : asset('backend/default/default-avatar.png') }}"
                                                        style="object-fit: cover; width: 35px; height: 35px" alt="">
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ NameById( $pending_request->user_id) }}</h6>
                                                        <span class="text-muted">{{ getFormattedDate($pending_request->created_at) }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('panel.user_shop_items.index') }}{{ '?user_id='.$pending_request->user_id }}" class="btn btn-outline-info btn-icon"><i class="ik ik-eye"></i></a>
                                            </td>
                                            <td>{{ $user_shop_item }}</td>
                                            <td>{{ StateById($user->state) }}</td>
                                            <td><span class="badge badge-{{ getCatalogueRequestStatus($pending_request->status)['color'] }}">{{ getCatalogueRequestStatus($pending_request->status)['name'] }}</span></td>
                                            <td>
                                                <a href="#" data-id="{{ $pending_request->id }}" class="btn btn-info acceptBtn">Accept</a>
                                                <button style="background: transparent;" class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                        <a href="{{ route('panel.seller.update.request-status',['request_id'=>$pending_request->id,'status'=>3]) }}" title="Ignore" class="dropdown-item "><li class="p-0">Ignore</li></a>
                                                        {{-- <a href="{{ route('panel.seller.request-delete',$pending_request->id) }}" title="Cancel" class="dropdown-item delete-item"><li class="p-0">Cancel Request</li></a> --}}
                                                    </ul>
                                            </td>
                                        </tr>

                                            {{-- <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                            </td>
                                            <td>{{ $pending_request->number }}</td>
                                            <td><span class="badge badge-{{ getCatalogueRequestStatus($pending_request->status)['color'] }}">{{ getCatalogueRequestStatus($pending_request->status)['name'] }}</span> </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-more-vertical pl-1"></i></button>
                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                        <a href="" title="Edit Access Code" class="dropdown-item "><li class="p-0">Edit</li></a>
                                                        <a href="" title="Delete Access Code" class="dropdown-item  delete-item"><li class=" p-0">Delete</li></a>
                                                    </ul>
                                                </div> 
                                            </tr> --}}
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @else

                @php
                    $pending_catalogue_requests = \App\Models\AccessCatalogueRequest::whereUserId(auth()->id())->whereStatus(0)->count();
                    $ignore_requests = \App\Models\AccessCatalogueRequest::whereNumber(auth()->user()->phone)->whereStatus(3)->count();
                    $resellers_count = \App\Models\AccessCatalogueRequest::whereNumber(auth()->user()->phone)->whereStatus(1)->count();
                @endphp

                <div class="row m-2 py-2">
                    <div class="col">
                        <a class="btn " href="{{ route('panel.seller.my_reseller.index')}}" >My Customer</a>
                        <a class="btn btn-primary" href="{{ route('panel.seller.supplier.index')}}" >Request Under Approval
                            @php
                                $product_enq_requests = getAccessCataloguePendingCount(auth()->id(),0);
                            @endphp
                            @if($product_enq_requests > 0)
                                <span class="badge badge-warning">{{$product_enq_requests}}</span>
                            @endif
                        </a>
                        <a class="btn" href="{{ route('panel.seller.ignore.index') }}">Ignore
                            @if($ignore_requests > 0)
                                <span class="badge badge-warning">{{ $ignore_requests }}</span>
                            @endif
                        </a>
                    </div>
                </div>
                <div class="col-md-12 card_catalogue">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3>{{ __('Request Under Approval')}}</h3> 
                            <a class="btn btn-primary" href='http://localhost/project/121.page-Laravel/121.page/panel/seller/my_reseller'>Back</a>
                        </div>
                        <div class="card-body bg-white">
                            <div class="row mt-3">
                                @if($pending_requests->count() > 0)
                                    @foreach ($pending_requests as $pending_request)
                                        @php
                                            $user = App\User::whereId($pending_request->user_id)->first();
                                            $user_shop = App\Models\UserShop::whereUserId($pending_request->user_id)->first();
                                            $user_shop_item = App\Models\UserShopItem::whereUserId($pending_request->user_id)->get()->count();
                                        @endphp
                                        @if($user_shop)
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <div class="card-body text-center" style="padding: 8px 10px;">
                                                        <div class="profile-pic mb-20">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <img class="supplier-image" src="{{ $user && $user->avatar ? $user->avatar : asset('backend/default/default-avatar.png') }}"
                                                                    style="object-fit: cover; width: 55px; height: 55px;margin-left: 20px; margin-top: 25px;" alt="">
                                                                </div>
                                                                
                                                                <div class="col-6 pl-5 pt-2 text-left">
                                                                    <h6 class="mt-20 mb-0">
                                                                        <a href="{{ inject_subdomain('home', @$user_shop->slug, true, false)}}" class="text-info">
                                                                            {{ NameById( $pending_request->user_id) }} / {{ getShopDataByUserId($pending_request->user_id)->name }}
                                                                        </a>
                                                                    </h6>
                                                                
                                                                    <i title="incoming request" class="ik ik-corner-up-left"></i>
                                                                    <span>
                                                                        {{-- Items: {{ $user_shop_item ?? '' }} <br> --}}
                                                                        @php
                                                                            $address = App\Models\UserAddress::where('user_id',$pending_request->user_id)->first();
                                                                            $city = json_decode($address->details)->city;
                                                                            $city_name = App\Models\City::whereId($city)->first();
                                                                        @endphp
                                                                        City: {{ $city_name->name ?? " " }}
                                                                    </span>
                                                                   <div class="mt-1">
                                                                    <span class="text-muted mr-1 mt-3"> <i class="ik ik-clock mx-1"></i>{{ getFormattedDate($pending_request->created_at) }}</span>


                                                                    {{-- <a style="margin-top: -2px;" target="_blank" href="{{ inject_subdomain('home', @$user_shop->slug, true, false)}}" class="btn btn-outline-info btn-icon"><i class="ik ik-eye"></i></a> --}}

                                                                   </div>
                                                                </div>
                                                                <div class="col-2">
                                                                    <button style="background: transparent;margin-left: -10px;" class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                                        <a href="{{ route('panel.seller.update.request-status',['request_id'=>$pending_request->id,'status'=>3]) }}" title="Ignore" class="dropdown-item "><li class="p-0">Ignore</li></a>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="p-4 pt-1 border-top">
                                                        <div class="row text-center d-block">
                                                            <div class="mx-auto">
                                                                <a href="#" data-id="{{ $pending_request->id }}" class="dropdown-item acceptBtn btn btn-primary">Accept</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="mx-auto">
                                        <span>No Pending Request yet!</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        {{-- <div class="card-footer d-flex justify-content-between">
                            <div class="pagination">
                                {{ $pending_requests->links() }}
                            </div>
                        </div> --}}
                    </div>
                </div>
            @endif
        </div>
        @include('backend.seller.modal.catalogue-request')
        @include('backend.seller.modal.catalogue-request-accept')
    </div>
    <!-- push external js -->
    @push('script')
        <script>
            $(document).ready(function() {
                $('#filter-btn').click(function(){
                    var url = "{{ route('panel.constant_management.user_enquiry.index') }}";
                    var date = $('#date_filter').val();
                    window.location.href = url+'?date='+date;
                });

                $('.acceptBtn').on('click',function(){
                    var reqId = $(this).data('id');
                    $('#requestId').val(reqId);
                    $('#catalogueRequestAccept').modal('show');
                })

                var table = $('#supplier_table').DataTable({
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
                       
                    ]

                });
            });
        </script>
    @endpush
@endsection
