@extends('backend.layouts.main') 
@section('title', 'My Customers')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'My Collections', 'url'=> "javascript:void(0);", 'class' => 'active'],
        ['name'=>'My Customers', 'url'=> "javascript:void(0);", 'class' => 'active'],
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
        
    </style>
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-flex">
                            <h5>{{ __('My Customers')}}</h5>
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
            <div class="col-md-12">
                @include('backend.seller.include.tabs')
            </div>
            <div class="col-md-12 card_catalogue">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <!--<h3>{{ __('My Customers')}}</h3> -->
                        <div class="mobile-align-right">
                            <a href="#"  data-btnlabel="Send" data-title="Sent Catalogue" data-status="1" class="btn btn-success access-request mt-lg-0 mt-md-0 mt-3">Send Catalogue</a>
                            {{-- <a href="#" data-btnlabel="Request" data-title="Request For Catalogue" data-status="0" class="btn btn-primary access-request mt-lg-0 mt-md-0 mt-3">Request Catalogue</a> --}}
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <div class="row mt-3">
                            @if($my_resellers->count() > 0)
                                @foreach ($my_resellers as $my_reseller)
                                @php
                                    $user = App\User::whereId($my_reseller->user_id)->first();
                                    if($user){
                                        $user_shop = getShopDataByUserId($user->id);
                                    }
                                @endphp
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-body text-center" style="padding: 8px 10px;">
                                            <div class="profile-pic mb-2">
                                                <div class="row">
                                                    <div class="col-3 pr-0">
                                                        <img class="supplier-image" src="{{ $user && $user->avatar ? $user->avatar : asset('backend/default/default-avatar.png') }}"
                                                        style="object-fit: cover; width: 35px; height: 35px" alt="">
                                                    </div>
                                                    <div class="col-7 pl-5 pt-2 text-left">
                                                     @if($user)
                                                        <h6 class="mb-0"> 
                                                            
                                                            <a href="{{ isset($user_shop) ? inject_subdomain('home', $user_shop->slug, true, false) : '#'  }}">{{NameById($user->id) }}</a>
                                                             
                                                        </h6>
                                                        <span class="mt-2">
                                                            <i class="ik mr-1 ik-shopping-cart"></i>
                                                            {{UserShopNameByUserId($user->id)}}
                                                        </span><br>
                                                        <span><i title="incoming request" class="ik mr-1 ik-phone"></i>  {{$user->phone }}
                                                        </span>
                                                        <br>
                                                        <i title="incoming request" class="ik ik-clock"></i>
                                                        {{ getFormattedDate($my_reseller->created_at) }}</span> 
                                                      @endif  
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-4 border-top">
                                            <div class="row text-center">
                                                <div class="d-flex justify-content-between mx-auto">
                                                    @php
                                                       $priceGroup = fetchFirst('App\Models\Group',$my_reseller->price_group_id,'name')   
                                                    @endphp
                                                    <div class="mr-2 mt-1">
                                                        <span class="@if($priceGroup == 'Customer') 
                                                            badge badge-primary
                                                        @elseif($priceGroup == 'VIP')
                                                            badge badge-success
                                                        @elseif($priceGroup == 'Reseller')
                                                            badge badge-danger
                                                        @else
                                                           
                                                        @endif">
                                                            {{ $priceGroup ?? '' }}</span>
                                                    </div>
                                                    <a href="#" data-id="{{ $my_reseller->id }}"  class="btn-link updatePriceGroupBtn"><u>Edit</u></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="mx-auto">
                                    <span>No Customers yet!</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <div class="pagination">
                            {{ $my_resellers->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('backend.seller.modal.catalogue-request')
        @include('backend.seller.modal.update-price-group')
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
                $('.updatePriceGroupBtn').on('click',function(){
                    var reqId = $(this).data('id');
                    $('#requestId').val(reqId);
                    $('#updatePriceGroup').modal('show');
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
