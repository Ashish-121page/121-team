@extends('backend.layouts.main') 
@section('title', 'My Supplier')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'My Collections', 'url'=> "javascript:void(0);", 'class' => 'active'],
        ['name'=>'My Supplier', 'url'=> "javascript:void(0);", 'class' => 'active'],
    ]
    @endphp
    <!-- push external head elements to head -->
    @push('head')
        <style>
            .daterangepicker.dropdown-menu.ltr.show-calendar.opensright{
                width: 455px !important;
            }
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            /* Firefox */
            input[type=number] {
                -moz-appearance: textfield;
            } 
            .remove-ik-class{
                -webkit-box-shadow: unset !important;
                box-shadow: unset !important;
            }
            @media (max-width: 420px){
                .phone-input-box {
                    border: 1px solid #6666CC;
                    border-radius: 11px !important;
                    padding: 7px 1px 10px 1px !important;
                }
                .custom-input_box{
                    width: 25px !important;
                }
            }
            @media (min-width: 500px){
                .custom-input_box{
                    width: 37px !important;
                }
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
                            <h5>{{ __('My Supplier')}}</h5>
                            @if(AuthRole() == 'User')
                                <span style="margin-top: -10px;">
                                    <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                                </span>
                            @endif
                        </div>
                        {{-- <span>{{ __('List of My Supplier')}}</span> --}}
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

            @if(AuthRole() != "User")
                <div class="col-md-12">
                    <div class="card table_catalogue">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3>{{ __('My Supplier')}}</h3> 
                            <div class="mobile-align-right">
                                {{-- <a href="#" data-title="Sent Catalogue" data-status="1" class="btn btn-success access-request mt-lg-0 mt-md-0 mt-3">Sent Catalogue</a>
                                <a href="#" data-title="Request For Catalogue" data-status="0" class="btn btn-primary access-request mt-lg-0 mt-md-0 mt-3">Request Catalogue</a> --}}
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">  
                                <table id="supplier_table" class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Catalogue From</th>
                                            <th>Shop</th>
                                            <th>Products</th>
                                            <th>Location</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($requests->count() > 0)
                                            @foreach ($requests as $request)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    @if($request->status == 1)
                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="mr-2">
                                                                @php
                                                                    $user = App\User::wherePhone($request->number)->first();
                                                                
                                                                    $product_ids = App\Models\UserShopItem::whereUserId($user->id)->whereIsPublished(1)->pluck('product_id');
                                                                    $user_shop_item = App\Models\Product::whereIn('id',$product_ids)->groupBy('sku')->get()->count();
                                                                    $user_shop = App\Models\UserShop::whereUserId($user->id)->first();
                                                                @endphp
                                                                
                                                                <img class="supplier-image" src="{{ $user && $user->avatar ? $user->avatar : asset('backend/default/default-avatar.png') }}"
                                                                style="object-fit: cover; width: 35px; height: 35px" alt="">
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">{{ isset($user) ?  NameById( $user->id) : 'Not Available' }}</h6>
                                                                <span class="mb-0"><i class="fa fa-users text-muted"></i> {{ fetchFirst('App\Models\Group',$request->price_group_id,'name','') }}</span><br>
                                                                <span class="text-muted">
                                                                    <i title="Outgoing Request" class="ik ik-corner-up-right"></i>
                                                                    {{ getFormattedDate($request->created_at) }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a target="_blank" href="{{ inject_subdomain('home', $user_shop->slug)}}">{{ $user_shop->name ?? 'N/A' }}</a>
                                                    </td>
                                                    <td>
                                                        {{ $user_shop_item }}
                                                    </td>
                                                    <td>
                                                        {{ StateById($user->state) ?? "Not Added" }}
                                                    
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-{{ getCatalogueRequestStatus($request->status)['color'] }}">{{ getCatalogueRequestStatus($request->status)['name'] }}</span></td>
                                                    <td>
                                                        <a href="{{ route('panel.user_shop_items.create')."?type=direct&type_id=$user->id" }}" class="btn btn-outline-info">Access Catalogue</a>
                                                    </td>

                                                    @elseif($request->status == 0)
                                                    <td>
                                                        <div class="d-flex">
                                                            <div class="mr-2">
                                                                @php
                                                                    $user = App\User::whereId($request->user_id)->first();
                                                                    $user_shop_item = App\Models\UserShopItem::whereUserId($request->user_id)->get()->count();
                                                                    $user_shop = App\Models\UserShop::whereUserId($user->id)->first();
                                                                @endphp
                                                                <img class="supplier-image" src="{{ $user && $user->avatar ? $user->avatar : asset('backend/default/default-avatar.png') }}"
                                                                style="object-fit: cover; width: 35px; height: 35px" alt="">
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">{{ isset($user) ? NameById( $user->id) : 'Not Available' }}</h6>
                                                                <span class="text-muted">
                                                                    <i title="incoming request" class="ik ik-corner-up-left"></i>
                                                                    {{ getFormattedDate($request->created_at) }}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a target="_blank" href="{{ inject_subdomain('home', $user_shop->slug)}}">{{ $user_shop->name ?? 'N/A' }}</a>
                                                    </td>
                                                    <td>
                                                        {{ $user_shop_item }}
                                                    </td>
                                                    <td>
                                                        {{ StateById($user->state) }}
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-{{ getCatalogueRequestStatus($request->status)['color'] }}">{{ getCatalogueRequestStatus($request->status)['name'] }}</span>
                                                    </td>

                                                    <td>
                                                        <a href="#"  data-id="{{ $request->id }}" class="btn btn-purple acceptBtn">Accept</a>
                                                        <button style="background: transparent;" class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                                <form action="{{ route('panel.seller.update.request-status') }}" method="get">
                                                                    <input type="hidden" name="request_id" value="{{ $request->id }}">
                                                                    <input type="hidden" name="status" value="3">
                                                                    <button title="Ignore" class="dropdown-item "><li class="p-0">Ignore</li></button>
                                                                </form>
                                                            </ul>
                                                    </td>

                                                    @endif
                                                </tr>
                                            @endforeach
                                        @else
                                            <div class="mx-auto">
                                                <span>No My Supplier yet!</span>
                                            </div>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-12 card_catalogue">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            {{-- <h3>{{ __('My Supplier')}}</h3>  --}}
                            <div class="mobile-align-right">
                                <!--<a href="#"  data-btnlabel="Send" data-title="Sent Catalogue" data-status="1" class="btn btn-success access-request mt-lg-0 mt-md-0 mt-3">Sent Catalogue</a>-->
                                <a href="#" data-btnlabel="Request" data-title="Request For Catalogue" data-status="0" class="btn btn-primary access-request mt-lg-0 mt-md-0 mt-3">Request Catalogue</a>
                            </div>
                        </div>
                        <div class="card-body bg-white">
                            <div class="row mt-3">
                                @if($requests->count() > 0)
                                    @foreach ($requests as $request)
                                        @if($request->status == 1)
                                        {{-- @dd($request) --}}
                                            @php
                                            $number = $request->number;
                                            $user = App\User::where(function($query) use($number) {
                                                $query->where('phone',$number)->orWhereJsonContains('additional_numbers',$number);
                                            })
                                            ->first();
                                                if($user != null){
                                                    // $product_ids = App\Models\UserShopItem::whereUserId($user->id)->groupBy('product_id')->whereIsPublished(1)->pluck('product_id');
                                                    // $user_shop_item = App\Models\Product::whereIn('id',$product_ids)->groupBy('sku')->count();

                                                    // @dd($user_shop_item)
                                                    $user_shop_item = App\Models\UserShopItem::whereHas('product')->whereUserId($user->id)->groupBy('product_id')->whereIsPublished(1)->get()->count();
                                                    
                                                    $user_shop = App\Models\UserShop::whereUserId($user->id)->first();
                                                    $added_user_shop_item = App\Models\UserShopItem::whereHas('product')->whereUserId(auth()->id())->whereParentShopId($user_shop->id)->groupBy('product_id')->whereIsPublished(1)->where('deleted_at',null)->get()->count();
                                                    
                                                    $seller_shop_id = App\Models\UserShop::whereUserId(auth()->id())->first();

                                                }
                                            @endphp
                                            {{-- @dd($product_ids) --}}
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <div class="card-body text-center" style="padding: 8px 10px;">
                                                        <div class="dropdown">
                                                            <button class="btn float-end dropdown-toggle" type="button" style="background: transparent;margin-left: -10px; position: absolute; right: 0"  data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ik ik-more-vertical pl-1"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                              <li><a class="dropdown-item" href="{{ route('panel.seller.delete.acr',$request->id).'?check='.$added_user_shop_item ?? 0}}">Delete</a></li>
                                                            </ul>
                                                          </div>

                                                        <div class="profile-pic mb-20">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <img class="supplier-image" src="{{ $user && $user->avatar ? $user->avatar : asset('backend/default/default-avatar.png') }}"
                                                                    style="object-fit: cover; width: 55px; height: 55px;margin-left: 20px; margin-top: 25px;" alt="">
                                                                </div>
                                                                
                                                                <div class="col-6 pl-5 pt-2 text-left">
                                                                    <h6 class="mt-20 mb-0">{{ isset($user) ? NameById( $user->id) : 'Not Available' }}</h6>
                                                                    <i title="incoming request" class="ik ik-corner-up-left"></i>
                                                                    <span class="">
                                                                        @if(isset($user))
                                                                         {{$added_user_shop_item}} / {{ $user_shop_item }} items on shop
                                                                        @endif
                                                                    </span>
                                                                    <p class="">
                                                                        <i class="ik ik-phone"></i> {{ $request->number }} 
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="p-3 border-top">
                                                        <div class="text-center">
                                                            <div class="d-flex justify-content-between mx-auto">
                                                                <a target="_blank" href="{{ isset($user_shop) ? inject_subdomain('home', $user_shop->slug, true, true) : '#'}}" class="btn btn-sm p-1 btn-primary mr-1 pr-1 w-50 d-block">Display</a>
                                                                <a target="_blank" href="{{isset($user_shop) ?  inject_subdomain('shop', $user_shop->slug, true, true) : '#'}}" class="btn btn-sm p-1 btn-primary mr-1 pr-1 w-50 d-block">View Display</a>
                                                                @if(isset($user_shop) && $user_shop != null && isset($user))
                                                                <a href="{{ isset($user_shop)  ? route('panel.user_shop_items.create')."?type=direct&type_id=$user->id&acr" : '#' }}" class="btn btn-primary">Access Catalogue</a> 
                                                               @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($request->status == 0)
                                            @php
                                                $user = App\User::whereId($request->user_id)->first();
                                                $user_shop_item = App\Models\UserShopItem::whereUserId($request->user_id)->get()->count();
                                                $user_shop = App\Models\UserShop::whereUserId($user->id)->first();
                                            @endphp
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
                                                                    <h6 class="mt-20 mb-0">{{ isset($user) ? NameById( $user->id) : 'Not Available' }}</h6>
                                                                
                                                                    <i title="incoming request" class="ik ik-corner-up-left"></i>
                                                                    <span>Items: {{ $user_shop_item }}
                                                                    </span>
                                                                </div>
                                                                <div class="col-2">
                                                                    @if($request->status == 0)
                                                                        <button style="background: transparent;padding: 6px 6px;" class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                                        <form action="{{ route('panel.seller.update.request-status') }}" method="get">
                                                                            <input type="hidden" name="request_id" value="{{ $request->id }}">
                                                                            <input type="hidden" name="status" value="3">
                                                                            <button title="Ignore" class="dropdown-item "><li class="p-0">Ignore</li></button>
                                                                        </form>
                                                                    @endif
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="p-3 border-top">
                                                        <div class="row text-center">
                                                            <div class="d-flex justify-content-between mx-auto">
                                                                <a target="_blank" href="{{ inject_subdomain('home', $user_shop->slug, true, true)}}" class="btn btn-sm p-1 btn-primary mr-1 pr-1">E-card</a>
                                                                <a target="_blank" href="{{ inject_subdomain('shop', $user_shop->slug, true, true)}}" class="btn btn-sm p-1 btn-primary mr-1 pr-1">View Shop</a>
                                                                <a href="#"  data-id="{{ $request->id }}" class="btn btn-primary acceptBtn">Accept</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="mx-auto">
                                        <span>No My Supplier yet!</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <div class="pagination">
                                {{ $requests->links() }}
                            </div>
                        </div>
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
                $('.access-request').click(function(){
                    $('#accessRequestTitle').html($(this).data('title'));
                    $('#accessRequestbtn').html($(this).data('btnlabel'));
                    $('#status-val').val($(this).data('status'));
                    if($(this).data('status') == 1){
                        $('#price_group_id').prop('required', true);
                        $('.sent-catalogue-group').removeClass('d-none');
                        $('.request-catalogue-group').addClass('d-none');
                    }else{
                        $('#price_group_id').removeAttr('required');
                        $('.sent-catalogue-group').addClass('d-none');
                        $('.request-catalogue-group').removeClass('d-none');
                    }
                    $('#requestForCatalogue').modal('show');
                })

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

            $('.digit-group').find('.custom-input_box').each(function() {
                $(this).attr('maxlength', 1);
                $(this).on('keyup', function(e) {
                var parent = $($(this).parent());
                
                if(e.keyCode === 8 || e.keyCode === 37) {
                    var prev = parent.find('input#' + $(this).data('previous'));
                    
                    if(prev.length) {
                        $(prev).select();
                    }
                } else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105)) { 
                    var next = parent.find('input#' + $(this).data('next'));
                    
                    if(next.length) {
                        $(next).select();
                    } else {
                        if(parent.data('autosubmit')) {
                            parent.submit();
                        }
                    }
                }
            });
            });

        
        $('.custom-input_box').on('click keyup paste', function(){
            var input_val = $(this).val();
            console.log(input_val);
            if(input_val.length > 1){
                $(this).val(input_val.slice(0, 1));
            }
        });
        $('.supplier-input_box').on('click', function(){
            $('.custom-input_box')
        })
        </script>
    @endpush
@endsection
