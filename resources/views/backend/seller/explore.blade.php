@extends('backend.layouts.main') 
@section('title', 'Explore')
@section('content')
    @php
    $breadcrumb_arr = [
        ['name'=>'Explore', 'url'=> "javascript:void(0);", 'class' => 'active'],
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
                            <h5>{{ __('Explore')}}</h5>
                            @if(AuthRole() == 'User')
                                <span style="margin-top: -10px;">
                                    <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                                </span>
                            @endif
                        </div>
                        {{-- <span>{{ __('List of Explore')}}</span> --}}
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
            
                @if(AuthRole() != 'User')
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3>{{ __('Explore')}}</h3> 
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="explore_table" class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Brand Logo</th>
                                                <th>Brand Name</th>
                                                <th>Preview</th>
                                                <th>Products</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if($verifyed_brands->count() > 0)
                                            @foreach ($verifyed_brands as $item)
                                                @php
                                                    $as_access = isBrandAS($item->id, auth()->id());
                                                    $bo_access = isBrandBO($item->id, auth()->id());
                                                    $brand_logo = App\Models\Media::whereType('Brand')->whereTypeId($item->id)->first();
                                                @endphp
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td>
                                                            @if($brand_logo != null)
                                                                <img src="{{ ($brand_logo && $brand_logo->path) ? asset($brand_logo->path) : asset('frontend/assets/img/placeholder.png') }}" alt="" style="height:60px;width:60px;object-fit:contain;" class="rounded">
                                                            @endif
                                                        </td>
                                                        <td>{{ $item->name }}</td>
                                                        <td><a href="" class="btn btn-outline-info btn-icon"><i class="ik ik-eye"></i></a></td>
                                                        <td>
                                                            {{ getMyProductOfBrand($slug,$item->id)->count() }} / {{ getBrandProductsBySku($item->id)->count() }}
                                                        </td>
                                                        
                                                        <td>Active</td>
                                                        <td>
                                                            <a href="{{ route('panel.user_shop_items.create')."?type=brand&type_id=$item->id" }}" class="btn btn-info">Access Catalogue</a>    
                                                            <button style="background: transparent;" class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                                <a href="{{ route('panel.brand.claim.create',$item->id) }}" title="Claim Brand" class="dropdown-item "><li class="p-0">Claim</li></a>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                            @endforeach
                                        @else
                                            <div class="mx-auto">
                                                <span>No data yet!</span>
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
                                <h3>{{ __('Explore')}}</h3> 
                            </div>
                            <div class="card-body bg-white">
                                <div class="row mt-3">
                                    @if($verifyed_brands->count() > 0)
                                        @foreach ($verifyed_brands as $item)
                                            @php
                                                $as_access = isBrandAS($item->id, auth()->id());
                                                $bo_access = isBrandBO($item->id, auth()->id());
                                                $brand_logo = App\Models\Media::whereType('Brand')->whereTypeId($item->id)->first();
                                            @endphp
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <div class="card-body text-center" style="padding: 8px 10px;">
                                                            <div class="profile-pic mb-20">
                                                                <div class="row">
                                                                    <div class="col-4 pr-0">
                                                                        @if($brand_logo != null)
                                                                            <img src="{{ ($brand_logo && $brand_logo->path) ? asset($brand_logo->path) : asset('frontend/assets/img/placeholder.png') }}" alt="" style="height:70px;width:80px;object-fit:contain;" class="rounded mt-2">
                                                                        @endif
                                                                    </div>
                                                                    
                                                                    <div class="col-6 pl-5 pt-2 text-left">
                                                                        <h6 class="mb-0 mt-2">{{ $item->name }}</h6>
                                                                    
                                                                        <i title="incoming request" class="ik ik-corner-up-left"></i>
                                                                        <span class="mt-2 p-2"> {{ getMyProductOfBrand($slug,$item->id)->count() }} / {{ getBrandProductsBySku($item->id)->count() }} items linked
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-2">
                                                                    
                                                                        <button style="background: transparent;margin-left: -10px;" class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                                            <a href="{{ route('panel.brand.claim.create',$item->id) }}" title="Claim Brand" class="dropdown-item "><li class="p-0">Claim</li></a>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                    </div>
                                                    <div class="p-4 border-top">
                                                        <div class="row text-center">
                                                            <div class="d-flex justify-content-between mx-auto">
                                                                <a target="_blank" href="{{ route('panel.user_shop_items.create')."?type=brand&type_id=$item->id" }}" class="btn btn-primary">Access Catalogue</a>     
                                                            </div>
                                                        </div>
                                                    </div>
                                
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="mx-auto">
                                            <span>No data yet!</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <div class="pagination">
                                    {{  $verifyed_brands->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
        
        </div>
    </div>
    <div class="modal fade" id="priceRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterLabel">{{ __('Price Ask Request')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.price_ask_requests.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="status" value="0">
                    <input type="hidden" name="type_id" value="0">
                    <input type="hidden" name="type" value="Direct">
                    <input type="hidden" name="sender_id" value="{{ auth()->id() }}">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group {{ $errors->has('receiver_id') ? 'has-error' : ''}}">
                                <label for="receiver_id" class="control-label">{{ 'Request Receiver' }} <span class="text-danger">*</span></label>
                              <select name="receiver_id" class="form-control select2" id="receiver">

                              </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                                <label for="price" class="control-label">{{ 'Price' }}</label>
                                <input class="form-control" name="price" type="number" id="price" value="" placeholder="Enter Price" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group {{ $errors->has('qty') ? 'has-error' : ''}}">
                                <label for="qty" class="control-label">{{ 'Quantity' }}</label>
                                <input class="form-control" name="qty" type="number" id="qty" placeholder="Enter Qty" value="" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group {{ $errors->has('till_date') ? 'has-error' : ''}}">
                                <label for="till_date" class="control-label">{{ 'Till Date' }}</label>
                                <input class="form-control" name="till_date" type="date" value="" id="till_date" placeholder="Enter Qty" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                <label for="comment" class="control-label">{{ 'Comment' }}</label>
                                <textarea class="form-control" name="comment" type="number" id="comment" placeholder="Comment here.."></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Send</button>
                                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button> --}}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    {{-- @include('backend.admin.manage.enquiry.includes.price-request',['brand' => $item]) --}}
    <!-- push external js -->
    @push('script')
        <script>
            $(document).ready(function() {
                $('.request').click(function(){
                    $('#receiver').html("");
                    var brand_id = $(this).data('brand_id');
                      $.ajax({
                            url: "{{ route('panel.seller.api.brand.users') }}",
                            method: "get",
                            data: {brand_id:brand_id},
                            success: function(res){
                                $('#receiver').html(res.html);
                                $('#priceRequest').modal('show');
                            }
                        });
                })
                $('#filter-btn').click(function(){
                    var url = "{{ route('panel.constant_management.user_enquiry.index') }}";
                    var date = $('#date_filter').val();
                    window.location.href = url+'?date='+date;
                });

                var table = $('#explore_table').DataTable({
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
