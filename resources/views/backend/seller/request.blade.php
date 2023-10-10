@extends('backend.layouts.main') 
@section('title', 'Request Under Approval')
@section('content')
    @php
    $breadcrumb_arr = [
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
                @include('backend.seller.include.tabs')
            </div>
            @if(AuthRole() != 'User')
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3>{{ __('Request Under Approval')}}</h3> 
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
                                <table id="request_table" class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Catalogue</th>
                                            <th>Number</th>
                                            <th>Shop</th>
                                            <th>Status</th>
                                            <th>Access</th>
                                            <th>Sent on</th>
                                            <th>Actions</th>
                                            <th>Send Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($pending_requests->count() > 0)
                                            @foreach ($pending_requests as $pending_request)
                                                @php
                                                    $temp_collection_shop = UserByNumber($pending_request->number);
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>CT{{ getPrefixZeros($pending_request->id) }}</td>
                                                    <td>{{ $pending_request->number }}</td>
                                                    <td>
                                                        @if(isset($temp_collection_shop) &&  $temp_collection_shop != null) {{ UserShopNameByUserId($temp_collection_shop->id) ?? 'N/A' }} @else N/A @endif
                                                    </td>
                                                    <td><span class="badge badge-{{ getCatalogueRequestStatus($pending_request->status)['color'] }}">{{ getCatalogueRequestStatus($pending_request->status)['name'] }}</span></td>
                                                    <td> @if($pending_request->status == 4 && $temp_collection_shop)
                                                            <a href="{{ inject_subdomain('home', $pending_request->contact_no)}}" target="_blank" class="text-primary">Access <i class="uil uil-arrow-right"></i></a>
                                                            @else
                                                                <a href="" class="text-warning"> <i class="fa fa-hourglass fa-spin fa-sm"></i></a>
                                                            @endif</td>
                                                    <td>{{ getFormattedDate($pending_request->created_at) }}</td>
                                                    <td>
                                                        <a href="{{ route('panel.seller.send.request-reminder',$pending_request->id)}}" class="btn btn-info">Send Reminder</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <div class="mx-auto">
                                                <span>No Pending Request yet!</span>
                                            </div>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>{{ __('Request Under Approval')}}</h3> 
                    </div>
                    <div class="card-body bg-white">
                        {{-- <a href="{{ route('panel.user_shop_items.create')."?type=direct&type_id=$user->id" }}" class="btn btn-primary">Access Catalogue</a>  --}}
                        <div class="row align-items-stretch">
                            @if($pending_requests->count() > 0)
                                @foreach ($pending_requests as $pending_request)
                                    @php
                                        $user = App\User::whereId($pending_request->user_id)->first();
                                        $temp_collection_shop = UserByNumber($pending_request->number);
                                        if(isset($temp_collection_shop) && $temp_collection_shop != null){
                                            $supplier_shop = UserShopRecordByUserId($temp_collection_shop->id);
                                        }else{
                                            $supplier_shop = null;
                                        }
                                    @endphp
                                    <div class="col-md-4 px-2 d-flex align-items-stretch">
                                        <div class="card">
                                            <div class="card-body text-center" style="padding: 8px 10px;">
                                                <div class="profile-pic">
                                                    <div class="row">
                                                        <div class="col-lg-3 pr-0">
                                                            <img class="supplier-image mt-2" src="{{ $temp_collection_shop && $temp_collection_shop->avatar ? $temp_collection_shop->avatar : asset('backend/default/default-avatar.png') }}"
                                                            style="object-fit: cover; width: 55px; height: 55px" alt="">
                                                        </div>
                                                        <div class="col-7 pl-5 pt-2 text-left">
                                                            <span class="mt-2"> 
                                                                <i class="ik mr-1 ik-shopping-cart"></i>
                                                                @if(isset($temp_collection_shop) &&  $temp_collection_shop != null) {{ UserShopNameByUserId($temp_collection_shop->id) ?? $pending_request->supplier_name }} 
                                                                @else 
                                                                {{$pending_request->supplier_name}}  (Not Available)
                                                                @endif
                                                            </span><br>
                                                            <span><i title="incoming request" class="ik mr-1 ik-phone"></i>{{ $pending_request->number }}
                                                            </span> 
                                                                <br>
                                                            <i title="incoming request" class="ik ik-clock"></i>
                                                            {{ getFormattedDateTime($pending_request->created_at) }}    
                                                        </div>
                                                        
                                                        <div class="col-2">
                                                            @if($pending_request->status == 4 && $temp_collection_shop)
                                                                <a href="{{ inject_subdomain('home', $pending_request->contact_no)}}" target="_blank" class="text-primary">Access <i class="uil uil-arrow-right"></i></a>
                                                            @else
                                                                <a href="" class="text-warning"> <i class="fa fa-hourglass fa-spin fa-sm"></i></a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center m-1">
                                                @if(isset($supplier_shop) && checkShopView($supplier_shop->slug))
                                                <a href="{{ isset($supplier_shop) ? inject_subdomain('home', $supplier_shop->slug, true, false) : '#'}}" class="btn btn-primary mr-1">Shop</a>
                                               
                                                @endif
                                                @if (isset($supplier_shop) && $supplier_shop->slug != null)
                                                        <a href="{{ isset($supplier_shop) ? (inject_subdomain('home', $supplier_shop->slug, true, false)) : '#'}}" class="btn btn-primary mr-1">Display</a>
                                                        
                                                    {{-- <a href="{{ isset($supplier_shop) ? (route('panel.user_shop_items.create')."?type=direct&type_id=$supplier_shop->user_id") : '#' }}" class="btn btn-primary mr-1">Access Catalogue</a> --}}
                                                @endif
                                                
                                            </div>
                                            <div class="p-2 border-top">
                                                <div class="row text-center">
                                                    <div class="d-flex justify-content-between mx-auto">
                                                        <a href="{{ route('panel.seller.send.request-reminder',$pending_request->id)}}" class="btn btn-primary mr-1">Send Reminder</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="mx-auto">
                                    <span>No Pending Request yet!</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <div class="pagination">
                            {{ $pending_requests->links() }}
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
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

                var table = $('#request_table').DataTable({
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
