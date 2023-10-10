@extends('backend.layouts.main') 
@section('title', 'Ignore')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'Ignore', 'url'=> "javascript:void(0);", 'class' => 'active'],
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
                            <h5>{{ __('Ignore Requests')}}</h5>
                            @if(AuthRole() == 'User')
                                <span style="margin-top: -10px;">
                                    <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                                </span>
                            @endif
                        </div>
                        {{-- <span>{{ __('List of Ignore Requests')}}</span> --}}
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        <div class="row">
            {{-- <div class="col-md-12">
                @include('backend.seller.include.tabs')
            </div> --}}
            <!-- start message area-->
            <!-- end message area-->
           
                @if(AuthRole() != 'User')
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>{{ __('Ignore Requests')}}</h3> 
                                <a class="btn btn-primary" href='http://localhost/project/121.page-Laravel/121.page/panel/seller/my_reseller'>Back</a>
                        </div>
                            <div class="card-body">
                            <div class="table-responsive">
                                    <table id="ignore_table" class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Catalogue From</th>
                                                {{-- <th>Preview</th> --}}
                                                <th>Products</th>
                                                <th>Mobile</th>
                                                <th>Location</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($ignore_requests ->count() > 0)
                                                @foreach ($ignore_requests as $ignore_request)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <div class="mr-2">
                                                                @php
                                                                    $user = App\User::whereId($ignore_request->user_id)->first();
                                                                    $user_shop_item = App\Models\UserShopItem::whereUserId($ignore_request->user_id)->get()->count();
                                                                @endphp
                                                                <img class="supplier-image" src="{{ $user && $user->avatar ? $user->avatar : asset('backend/default/default-avatar.png') }}"
                                                                style="object-fit: cover; width: 35px; height: 35px" alt="">
                                                                </div>
                                                                <div>
                                                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                                                    <span class="text-muted">{{ getFormattedDate($ignore_request->created_at) }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        {{-- <td>
                                                            <a href="{{ route('panel.user_shop_items.index') }}{{ '?user_id='.$ignore_request->user_id }}" class="btn btn-outline-info btn-icon"><i class="ik ik-eye"></i></a>
                                                        </td> --}}
                                                        <td>{{ $user_shop_item }}</td>
                                                        <td>{{ $user->phone }}</td>
                                                        <td>{{ StateById($user->state) ?? '-' }}</td>
                                                        <td><span class="badge badge-{{ getCatalogueRequestStatus($ignore_request->status)['color'] }}">{{ getCatalogueRequestStatus($ignore_request->status)['name'] }}</span> </td> 
                                                        <td>
                                                            <div class="dropdown">
                                                                <a href="{{ route('panel.seller.update.request-status',['request_id'=>$ignore_request->id,'status'=>0]) }}" class="btn btn-info recover-item" >Recover</a>
                                                            </div> 
                                                        </td>
                                                        {{-- <td>{{ $ignore_request->number }}</td>
                                                        --}}

                                                    </tr>
                                                @endforeach
                                            @else
                                                <div class="text-center">
                                                    <span>No Ignore Request Yet!</span>
                                                </div>    
                                            @endif 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @else


                <div class="row m-2 py-2">
                    <div class="col">
                        <a class="btn " href="{{ route('panel.seller.my_reseller.index')}}" >My Customer</a>
                        <a class="btn" href="{{ route('panel.seller.supplier.index')}}" >Request Under Approval</a>
                        <a class="btn btn-primary" href="{{ route('panel.seller.ignore.index') }}">Ignore</a>
                    </div>
                </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>{{ __('Ignore Requests')}}</h3> 
                                <a class="btn btn-primary" href='http://localhost/project/121.page-Laravel/121.page/panel/seller/my_reseller'>Back</a>

                            </div>
                            <div class="card-body bg-white">
                                <div class="row">
                                    @if ($ignore_requests->count() > 0)
                                        @foreach ($ignore_requests as $ignore_request)
                                            @php
                                                $user = App\User::whereId($ignore_request->user_id)->first();
                                                $user_shop_item = App\Models\UserShopItem::whereUserId($ignore_request->user_id)->get()->count();
                                            @endphp
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <div class="card-body text-center" style="padding: 8px 10px;">
                                                            <div class="profile-pic mb-20">
                                                                <div class="row">
                                                                    <div class="col-4 pr-0">
                                                                        <img class="supplier-image mt-3" src="{{ $user && $user->avatar ? $user->avatar : asset('backend/default/default-avatar.png') }}"
                                                                        style="object-fit: cover; width: 55px; height: 55px" alt="">
                                                                    </div>
                                                                    
                                                                    <div class="col-8 pl-5 pt-2 text-left">
                                                                        <h6 class="mb-0 mt-2">{{ NameById( $user->id) }}</h6>
                                                                    
                                                                        <i title="incoming request" class="ik ik-corner-up-left"></i>
                                                                        <span class="mt-2 p-2"> Avilable Items: {{ $user_shop_item }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                    </div>
                                                    <div class="p-4 border-top">
                                                        <div class="row text-center">
                                                            <div class="d-flex justify-content-between mx-auto">
                                                                <a target="_blank" href="{{ route('panel.seller.update.request-status',['request_id'=>$ignore_request->id,'status'=>0]) }}" class="btn btn-primary recover-item" >Recover</a> 
                                                            </div>
                                                        </div>
                                                    </div>
                                
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center mx-auto">
                                            <span class="text-center">No Ignore Request Yet!</span>
                                        </div>    
                                    @endif 
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <div class="pagination">
                                    {{ $ignore_requests->links() }}
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

                var table = $('#ignore_table').DataTable({
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
                        {
                            extend: 'excel',
                            className: 'btn-sm btn-success',
                            header: true,
                            footer: true,
                            exportOptions: {
                                columns: ':visible',
                            }
                        },
                        'colvis',
                        {
                            extend: 'print',
                            className: 'btn-sm btn-primary',
                            header: true,
                            footer: false,
                            orientation: 'landscape',
                            exportOptions: {
                                columns: ':visible',
                                stripHtml: false
                            }
                        }
                    ]

                });
            });
            $(document).on('click','.recover-item',function(e){
                e.preventDefault();
                var url = $(this).attr('href');
                var msg = $(this).data('msg') ?? "You won't be able to revert back!";
                $.confirm({
                    draggable: true,
                    title: 'Are You Sure!',
                    content: msg,
                    type: 'info',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Recover',
                            btnClass: 'btn-info',
                            action: function(){
                                    window.location.href = url;
                            }
                        },
                        close: function () {
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
 