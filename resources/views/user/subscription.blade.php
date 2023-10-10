@extends('backend.layouts.main') 
@section('title', 'Subscription')
@section('content')
<!-- push external head elements to head -->
@push('head')
<style>
    .select2-selection.select2-selection--single{
                width: 175px !important;
            }
            .table thead {
                background-color: #fff;
            }
            .remove-ik-class{
                -webkit-box-shadow: unset !important;
                box-shadow: unset !important;
            }          

            #term{
                cursor: pointer;
            }

            </style>
    @endpush
    
    
    @if ((auth()->user()->is_supplier) == 0)
        <style>
            .app-sidebar{
                display:none !important;        
            }
            .main-content , .header-top {
                padding-left: 0 !important;
            }
            .footer,{
                padding-left: 10px !important;
            }
        </style>
    @endif
    
    



    
    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-users bg-blue"></i>
                        <div class="d-flex">
                            <h5>{{ __('Subscription')}}</h5>
                            @if(AuthRole() == 'User')
                            <span style="margin-top: -10px;">
                                <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('panel.dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Users')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 mx-auto justify-content-center">
                <div class="card">
                    <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">{{ __('All Plans')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">{{ __('Current Plan')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-timeline-tab" data-toggle="pill" href="#current-month" role="tab" aria-controls="pills-timeline" aria-selected="true">{{ __('Payment History')}}</a>
                        </li>
                    </ul>
                    @php
                        $packages = App\Models\Package::where('is_published',1)->get();
                        $user_active_package = App\Models\UserPackage::whereUserId(auth()->id())->first();  
                    @endphp
                    <div class="tab-content" id="pills-tabContent">
                        
                        <div class="tab-pane fade show active" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <h1 class="heading mb-3 text-center">Catalogue Distribution service</h1>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($packages as $package)
                                    @php
                                        $limits = json_decode($package->limit,true);
                                    @endphp
                                        <form class="col-lg-4 my-2" action="{{ route('plan.checkout',$package->id ) }}" method="post">
                                            @csrf
                                            <div class="border p-3 text-center" style="height: 100%;max-height: 500px !important">
                                                <h5 class="card-title text-uppercase text-center">{{ $package->name }}</h5>
                                                <h6 class="card-price text-center">{{ format_price($package->price) }}<span class="period"> - {{ $package->duration ?? '-' }} Days</span></h6>
                                                <hr>
                                                {{-- <ul class="fa-ul">
                                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ $limits['add_to_site'] }} Add to my Site</li>
                                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ $limits['custom_proposals'] }} Custom Proposals</li>
                                                    <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ $limits['product_uploads'] }} Upload Products</li>
                                                </ul> --}}

                                                @php
                                                    $description = explode('^^',$package->description);
                                                    $limits = json_decode($package->limit,true);
                                                @endphp
  
                                              <ul class="list-unstyled mb-0 ps-0" style="margin: 0 10px;">
                                                  @forelse ($description as $item)
                                                        <li class="h6 text-muted mb-1 text-center" style="display: flex;">
                                                            <span class="icon h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>
                                                            {!! $item !!}
                                                        </li>
                                                    @empty                                                      
                                                  @endforelse
                                              </ul>
                                             


                                                @if($user_active_package)
                                                {{-- Trial --}}
                                                @if($package->id == 1 && $user_active_package)
                                                        <div style="padding: 8px 10px;" class="alert alert-danger mt-4 mb-0">
                                                            Not Eligible
                                                        </div> 
                                                {{-- Has Package --}}
                                                @elseif($user_active_package->package_id == $package->id)
                                                        
                                                    @if(\Carbon\Carbon::parse($user_active_package->to)->format('Y-m-d') < now()->format('Y-m-d'))
                                                        <button type="submit" class="btn btn-primary mt-4">Renew Now</button>
                                                    @else
                                                       <div style="padding: 8px 10px;" class="alert alert-warning mt-4 mb-0">
                                                            Current Package    
                                                        </div>
                                                        <hr>
                                                        <span class="text-center">
                                                            Plan expires on {{ \Carbon\Carbon::parse($user_active_package->to)->format('Y-m-d') }}
                                                        </span>
                                                    @endif
                                                @elseif($package->id != 1)
                                                    <form class="col-md-4 col-12 mt-4 pt-2" action="{{ route('plan.checkout',$package->id ) }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="package_id" value="{{ $package->id }}">
                                                        {{-- <a href="{{ route('plan.checkout',$package->id) }}" type="button" class="btn btn-primary mt-4">Buy Now</a> --}}
                                                        <button type="submit" class="btn btn-primary mt-4" id="buynow">Buy Now</button>
                                                    </form>
                                                @endif
                                                @elseif($package->id != 1) 
                                                    <form class="col-md-4 col-12 mt-4 pt-2" action="{{ route('plan.checkout',$package->id ) }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="package_id" value="{{ $package->id }}">
                                                        <button type="submit" class="btn btn-primary mt-4" id="buynow">Buy Now</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </form>  
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-setting-tab">
                            <div class="card-body">
                                @php
                                    $user_package = getUserPackageInfo(auth()->id());
                                    // $order_record = App\Models\Order::whereId($user_package->order_id)->first();
                                    if($user_package){
                                        $limit = json_decode($user_package->limit,true);
                                        $package_name = getPackageRecordById($user_package->package_id);
                                    }
                                        
                                @endphp
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Order Id</th>
                                            <td>#ORD{{ ($user_package->order_id) ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Plan Name</th>
                                            <td>{{ $package_name->name ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Limit</th>
                                            <td>
                                                <ul class="pl-3">
                                                    <li>Add to site : {{ $limit['add_to_site'] ?? ''}}</li>
                                                    <li>Custom Proposal{{ $limit['custom_proposals'] ?? ''}}</li>
                                                    <li>Product Upload {{ $limit['product_uploads'] ?? ''}}</li>
                                                </ul>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Expire On</th>
                                            <td>
                                                @if($user_package)
                                                    {{ getFormattedDate($user_package->to)}}
                                                @else  
                                                    <span class="badge badge-danger">Plan Expired</span>  
                                                @endif
                                            </td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="current-month" role="tabpanel" aria-labelledby="pills-timeline-tab">
                            <div class="card-body">
                                <div class="table-responsive"> 
                                    @php
                                        $invoices =  App\Models\Order::whereUserId(auth()->id())->whereFlag(0)->latest()->paginate(20);   
                                    @endphp
                                    <table id="supplier_table" class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoices as $invoice)
                                                <tr>
                                                    <td class="text-center"><a href="{{ route('panel.orders.invoice', $invoice->id) }}">#INV{{ $invoice->id }}</a></td>
                                                    <td>{{ format_price($invoice->total) }}</td>
                                                    <td class="text-{{ paymentStatus($invoice->payment_status)['color'] }}">{{ paymentStatus($invoice->payment_status)['name'] }}</td>
                                                    <td>{{ getFormattedDate($invoice->created_at) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <small style="font-size: 0.8rem; padding-left: 40px;" class="my-2">
                        <input type="checkbox" id="term" class="form-check-input pb-2" checked> Accept
                        <label for="term">
                            <a href="{{ url('page/terms') }}" class="btn-link"> Terms and Services</a>
                        </label>
                    </small>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
   
    <script>
        $(document).ready(function(){
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




        var chk = document.getElementById("term");
        chk.addEventListener("change",function () { 
            if (this.checked == true) {
                // Enable Button
                var btns = document.querySelectorAll("#buynow");
                btns.forEach(ele => {
                    ele.disabled = false;
                });
            } else {
                // Diable Button
                var btns = document.querySelectorAll("#buynow");
                btns.forEach(ele => {
                    ele.disabled = true;
                    ele.title = "Accept Terms and Services to Continue";
                });                
            }
            
            
        })

    </script>
  
    @endpush
@endsection
