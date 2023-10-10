@extends('backend.layouts.main') 
@section('title', 'Enquiry')
@section('content')
@push('head')
<script src="{{ asset('backend/plugins/DataTables/datatables.min.js') }}"></script>
@endpush
    @php
    $breadcrumb_arr = [
        ['name'=>'Manage', 'url'=> "javascript:void(0);", 'class' => ''],
        ['name'=>'Enquiry', 'url'=> "javascript:void(0);", 'class' => 'active']
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
     <style>
        /* .select2-selection.select2-selection--single{
            width: 100px !important;
        } */
        @media(max-width: 600px){
            .tab-btn{
                font-size: 12px;
                padding: 6px 9px;
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
                            <h5>{{ __('Enquiries')}}</h5>
                                @if(AuthRole() == 'User')
                                    <span style="margin-top: -10px;">
                                        <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                                    </span>
                                @endif
                            </div>
                            {{-- <span>{{ __('List of Enquiries')}}</span> --}}
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        <form action="{{ route('panel.admin.enquiry.index')}}" method="GET" id="TableForm">
            <input type="hidden" name="type" value="{{ request()->get('type') }}">
            <div class="row">
                <div class="col-md-12">
                    @if(AuthRole() != 'Admin')
                        <div class="d-flex mb-3">
                            {{-- <a href="{{ route('panel.admin.enquiry.index')."?type=enquiry"}}" class="btn @if(request()->get('type') == "enquiry")  btn-primary @else  text-secondary  @endif mr-2 tab-btn">Customer Product Enquiries
                                @if($pending_enq > 0)
                                    <span class="badge badge-warning">{{$pending_enq}}</span>
                                @endif
                            </a> --}}
                            {{-- <a href="{{ route('panel.seller.supplier.index')}}" class="btn @if(Request::url() == route('panel.seller.supplier.index'))  btn-primary @else  text-secondary  @endif mr-2 tab-btn">Pending Enquiries
                                @php
                                    $product_enq_requests = getAccessCataloguePendingCount(auth()->id(),0);
                                @endphp
                                @if($product_enq_requests > 0)
                                    <span class="badge badge-warning">{{$product_enq_requests}}</span>
                                @endif
                            </a> --}}
                            {{-- <a href="{{ route('panel.admin.enquiry.index')."?type=par"}}" class="btn @if(request()->get('type') == "par")  btn-primary @else  text-secondary  @endif mr-2 tab-btn">Price Request
                                @if($pending_par > 0)
                                    <span class="badge badge-warning">{{$pending_par}}</span>
                                @endif
                            </a> --}}
                                <a href="{{ route('panel.seller.enquiry.index')."?type=contact" }}" class="btn @if(request()->get('type') == "contact")  btn-primary @else  text-secondary  @endif mr-2 tab-btn">From Website
                                
                                </a>
                            <hr>
                        </div>
                    @endif
                    <div class="card @if(request()->get('type') == "par") d-none @endif">
                        <div class="card-header d-flex no-gutters flex-wrap align-items-center justify-content-between">
                            <div class="col flex-grow-1">
                                <h3>{{ __('Enquiries')}}</h3>
                            </div>
                            <div class="col-6 col-lg">
                                <div class="form-group mb-0">
                                    <select name="status" id="" class="form-control select2">
                                        <option value="" readonly>Select Status</option>
                                        @foreach (getEnquiryStatus() as $item)
                                        <option value="{{ $item['id'] }}" @if (request()->get('status') == $item['id']) selected @endif>{{ $item['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 col-lg mt-3 mt-lg-0">
                                <div class="form-group d-flex flex-wrap flex-lg-nowrap align-items-center mb-0 pl-lg-3">
                                    <span>From</span>
                                <input type="date" name="pr_from" class="form-control" value="{{ request()->get('pr_from')}}">
                                </div>
                            </div>
                            <div class="col-6 col-lg mt-3 mt-lg-0">
                                <div class="form-group d-flex flex-wrap flex-lg-nowrap align-items-center mb-0 pl-lg-3"> 
                                    <span>To</span>
                                <input type="date" name="pr_to" class="form-control" value="{{ request()->get('pr_to')}}"> 
                                </div>
                            </div>
                            <div>
                                <div class="d-flex mt-3 mt-lg-0 pl-lg-3">
                                    <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                    
                                    <a href="javascript:void(0)" id="reset" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                        <div id="ajax-container">
                            @if(AuthRole() != 'User')
                                @include('backend.admin.manage.enquiry.load')
                            @else
                                {{-- <div class="col-md-12">
                                    <div class="card-body bg-white neha">
                                        <div class="row mt-3">
                                            @if($enquiry->count() > 0)
                                                @foreach($enquiry as $item)
                                                    @php
                                                        $description = json_decode($item->description);
                                                    @endphp
                                                    <div class="col-md-4">
                                                        <div class="card">
                                                            <div class="card-body text-center" style="padding: 8px 10px;">
                                                                <div class="profile-pic mb-20">
                                                                    <div class="row">
                                                                        <div class="col-3 pr-0 mt-3">
                                                                            @if(isset(getShopProductImage($description->product_id)->path))
                                                                            <img src="{{ asset(getShopProductImage($description->product_id)->path ?? '') }}" class="shadow rounded" style="height: 60px;width:60px;" alt="cart-image">
                                                                        @else
                                                                            <img src="{{asset('frontend/assets/img/placeholder.png')}}"  class="shadow rounded" style="height: 60px;width:60px;" alt="">
                                                                        @endif
                                                                        </div>
                                                                        
                                                                        <div class="col-9 pl-15 pt-1 text-left">
                                                                            <a class="btn btn-link pl-1" href="{{ route('panel.admin.enquiry.show', $item->id) }}">ENQ{{ $item->id }}</a>
                                                                            <div class="float-right mt-1 ml-1 badge badge-{{ getEnquiryStatus($item->status)['color'] }}">{{ getEnquiryStatus($item->status)['name'] }}</div>
                                                                        
                                                                            <br>
                                                                            <i class="ik ik-user"></i> {{ NameById($item->user_id) }}  
                                                                            <br>
                                                                            <i class="ik ik-clock"></i> {{ getFormattedDate($item->created_at) }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td class="text-center" colspan="8"><span class="mx-auto">No Enquiries Yet!</span></td>
                                                </tr>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <div class="pagination">
                                        {{ $enquiry->appends(request()->except('page'))->links() }}
                                    </div>
                                    <div>
                                        @if($enquiry->lastPage() > 1)
                                            <label for="">Jump To: 
                                                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                                                    @for ($i = 1; $i <= $enquiry->lastPage(); $i++)
                                                        <option value="{{ $i }}" {{ $enquiry->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </label>
                                        @endif
                                    </div>
                                </div> --}}
                            @endif
                        </div>    
                    </div>
                    <div class="card @if(request()->get('type') == "enquiry") d-none @endif">
                        <div class="card-header flex-wrap d-flex justify-content-between">
                            <div class="col flex-grow-1">
                                <h3>Price Ask Requests</h3>
                            </div>
                            <div class="d-flex flex-wrap justify-content-right">
                                <div class="form-group mb-0 mr-2 mt-3 mt-lg-0">
                                    <span>From</span>
                                <label for=""><input type="date" name="par_from" class="form-control" value="{{request()->get('par_from')}}"></label>
                                </div>
                                <div class="form-group mb-0 mr-2"> 
                                    <span>To</span>
                                        <label for=""><input type="date" name="par_to" class="form-control" value="{{request()->get('par_to')}}"></label> 
                                </div>
                                <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                <a href="javascript:void(0);" id="reset" data-url="{{ route('panel.price_ask_requests.index') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                            </div>
                        </div>

                        <div id="ajax-container">
                            @if(AuthRole() != 'User')
                                @include('panel.price_ask_requests.load')
                            @else 
                            <div class="col-md-12">
                                <div class="card-body bg-white">
                                    <div class="row mt-3">
                                        @if($price_ask_requests->count() > 0)
                                            @foreach($price_ask_requests as  $price_ask_request)
                                                <div class="col-md-4">
                                                    <div class="card">
                                                        <div class="card-body text-center" style="padding: 8px 10px;">
                                                            <div class="profile-pic mb-20">
                                                                <div class="row">
                                                                    <div class="col-3 pr-0 mt-3">
                                                                        @if(isset(getShopProductImage($price_ask_request->product_id)->path))
                                                                            <img src="{{ asset(getShopProductImage($price_ask_request->product_id)->path ?? '') }}" class="shadow rounded" style="height: 60px;width:60px;" alt="cart-image">
                                                                        @else
                                                                            <img src="{{asset('frontend/assets/img/placeholder.png')}}"  class="shadow rounded" style="height: 60px;width:60px;" alt="">
                                                                        @endif
                                                                    </div>
                                                                    
                                                                    <div class="col-9 pl-15 pt-1 text-left">
                                                                        <a class="btn btn-link" style="padding-left: 2px;" href="{{ route('panel.price_ask_requests.show', $price_ask_request->id) }}">
                                                                            #PAR{{ $price_ask_request->id }}
                                                                        </a>
                                                                        <div class="float-right mt-1 ml-1 badge badge-{{getPriceAskRequestStatus($price_ask_request->status)['color'] }}">{{getPriceAskRequestStatus($price_ask_request->status)['name'] }}</div>
                                                                    
                                                                        <br>
                                                                        <i class="ik ik-user"></i> @if($price_ask_request->sender_id == auth()->id())  {{NameById($price_ask_request->receiver_id) }} @else  {{NameById($price_ask_request->sender_id) }} @endif
                                                                        {{-- <i class="ik ik-user"></i>   {{NameById($price_ask_request->sender_id) }} --}}
                                                                        <br>
                                                                        @if($price_ask_request->product_id)
                                                                        @php
                                                                            $product =  fetchFirst('App\Models\Product',$price_ask_request->product_id);
                                                                        @endphp
                                                                        {{ $product->title??"--" }}, Qty: {{ $product->stock_qty }}               
                                                                        @endif
                                                                        <br>
                                                                        <i class="ik ik-clock mr-2"></i> 
                                                                            {{ getFormattedDate($price_ask_request->created_at) }} 
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="text-center" colspan="8">
                                                    <span class="mx-auto mb-3">No Price Ask Requests Yet!</span>
                                                </td>
                                            </tr>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="makeOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterLabel">{{ __('Make Order')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('panel.admin.enquiry.order') }}" method="post">
                        @csrf
                        <input type="hidden" name="type_id" value="" id="TypeID">
                            @php
                                $user_address = [];
                            @endphp 
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                    <label for="comment" class="control-label">{{ 'Qty' }}</label>
                                    <input required type="number" class="form-control" name="qty"  placeholder="Enter Qty">
                                </div>
                            </div>
                            <div class="col-md-6 mx-auto">
                                <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                    <label for="comment" class="control-label">{{ 'Price' }}</label>
                                    <input required type="number" class="form-control" name="price"  placeholder="Enter Price">
                                </div>
                            </div>
                                <hr>
                                <h6 class="col-md-12">Choose User Address:</h6>
                                @foreach($user_address as $index =>$item)
                                    @php
                                        $address_temp = json_decode($item->details);
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="card border p-2">
                                            <input  id="adres{{ $index }}" name="address" value="{{ $item->id }}" type="radio" class="form-check-input address-check">
                                            <div class="text-center mb-3">
                                                <div class="text-dark">{{ $item->type == 0 ? "Home" : "Office" }}</div>
                                                    <div class="text-muted">{{ $address_temp->address_1 }}</div>
                                                    <div class="text-muted">{{ $address_temp->address_2}}</div>
                                                    <div class="text-muted">
                                                        {{ CountryById($address_temp->country) }},
                                                        {{ StateById( $address_temp->state) }}, 
                                                        {{ CityById( $address_temp->city) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            <div class="col-md-12 mx-auto">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Make</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')

    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
           
           function html_table_to_excel(type)
            {
                var table_core = $("#enquiry_table").clone();
                var clonedTable = $("#enquiry_table").clone();
                clonedTable.find('[class*="no-export"]').remove();
                clonedTable.find('[class*="d-none"]').remove();
                $("#enquiry_table").html(clonedTable.html());
                // console.log(clonedTable.html());
                var data = document.getElementById('enquiry_table');
                var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
                XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
                XLSX.writeFile(file, 'enquiryFile.' + type);
                $("#enquiry_table").html(table_core.html());
            }

            $(document).on('click','#export_button',function(){
                html_table_to_excel('xlsx');
            });
           

        $('#reset').click(function(){
            getData("{{ route('panel.admin.enquiry.index') }}");
            window.history.pushState("", "", "{{ route('panel.admin.enquiry.index') }}");
            $('#TableForm').trigger("reset");
            $('#type').select2('val',"");           // if you use any select2 in filtering uncomment this code
            $('#type').trigger('change');           // if you use any select2 in filtering uncomment this code
        });

          $(document).ready(function(){
            $('.customOrder').on('click',function(){
                $record = $(this).data('rec');
                $('#TypeID').val($record.id);
                $('#makeOrder').modal('show')
            });
        });

    </script>
  
    @endpush
@endsection
