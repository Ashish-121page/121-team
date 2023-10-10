    @extends('backend.layouts.main') 
    @section('title', 'Order')
    @section('content')
    @php
    /**
    * Order 
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
        ['name'=>'Orders', 'url'=> route('panel.orders.index'), 'class' => ''],
        ['name'=>'Show Order', 'url'=> "javascript:void(0);", 'class' => '']
    ]
    @endphp
        <!-- push external head elements to head -->
        @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <style>
            .error{
                color:red;
            }
        </style>
        @endpush

        <div class="container-fluid">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="ik ik-mail bg-blue"></i>
                            <div class="d-inline">
                                <h5>Show Order: #ORD{{ $order->id }}</h5>
                                {{-- <span>Show Order Details of #ORD{{ $order->id }}</span> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        @include('backend.include.breadcrumb')
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <!-- start message area-->
                @include('backend.include.message')
                    <!-- end message area-->
                    <div class="card mb-2">
                        <div class="card-header d-flex justify-content-between">
                            <h3>Order Summary</h3>
                            <div class="d-flex ">

                                

                                @if($order->payment_status == 2)
                                        @if ($order->status == 2)
                                        <a href="{{ route('panel.orders.update-status',[$order->id,'status' => 3]) }}" title="Shipped Order" class="btn confirm-btn mx-1 btn-primary btn-sm">Shipped</a>
                                        @elseif ($order->status == 3)
                                            <a href="{{ route('panel.orders.update-status',[$order->id,'status' => 4]) }}" title="Delivered Order" class="btn confirm-btn mx-1 btn-primary btn-sm">Delivered</a>
                                            <a href="{{ route('panel.orders.update-status',[$order->id,'status' => 5]) }}" title="Completed Order" class="btn confirm-btn mx-1 btn-primary btn-sm">Completed</a>
                                        @elseif($order->status == 4)
                                            <a href="{{ route('panel.orders.update-status',[$order->id,'status' => 3]) }}" title="Shipped Order" class="btn confirm-btn mx-1 btn-primary btn-sm">Shipped</a>
                                            <a href="{{ route('panel.orders.update-status',[$order->id,'status' => 5]) }}" title="Completed Order" class="btn confirm-btn mx-1 btn-primary btn-sm">Completed</a>
                                        @elseif($order->status == 5)
                                            {{-- <a href="{{ route('panel.orders.update-status',[$order->id,'status' => 3]) }}" title="Shipped Order" class="btn confirm-btn mx-1 btn-primary btn-sm">Shipped</a>
                                            <a href="{{ route('panel.orders.update-status',[$order->id,'status' => 4]) }}" title="Delivered Order" class="btn confirm-btn mx-1 btn-primary btn-sm">Delivered</a> --}}
                                            <div class="badge badge-success">
                                                Order Completed
                                            </div>
                                        @endif
                                    @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Order Id</th>
                                        <td>ORD{{ $order->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Status</th>
                                        <td>{{ paymentStatus($order->payment_status)['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order Status</th>
                                        <td>{{ orderStatus($order->status)['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>User</th>
                                        <td>{{ $order->user->name ?? 'User Deleted' }}</td>
                                    </tr>
                                    <tr>
                                        <th>SubTotal</th>
                                        <td>{{ format_price($order->sub_total) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tax</th>
                                        <td>{{ $order->tax }}</td>
                                    </tr>
                                    <tr>
                                        <th>Discount</th>
                                        <td>{{ $order->discount }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total</th>
                                        <td>{{ format_price($order->total) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Payment Gateway</th>
                                        <td>{{ $order->payment_gateway }}</td>
                                    </tr>
                                </thead>
                            </table>
                            
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <h5>Order Items:</h5>
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Item Type')}}</th>
                                                <th>{{ __('Product')}}</th>
                                                <th>{{ __('Qty')}}</th>
                                                <th>{{ __('Price')}}</th>
                                                <th>{{ __('Amount')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order->items as $item)
                                                <tr>
                                                    <td> Product Type (Product, Service, etc) </td>
                                                    <td>{{ $item->item_id }} (Product Name or title from table)</td>
                                                    <td>{{ $item->qty }}</td>
                                                    <td>{{format_price($item->price) }}</td>
                                                    <td>{{ format_price($item->price * $item->qty) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($order->seller_payment_details != null && ($order->status == 1 || $order->status == 7) && $order->user_id != auth()->id())
                    <div class="card">
                        <div class="card-header pb-0">
                        <h5>Order Approval</h5>
                        </div>
                        <div class="card-body">
                            @php
                            $details = json_decode($order->seller_payment_details,true);
                            @endphp
                            <div class="row">
                                <div class="col-md-3 col-6">
                                    <h6>{{ __('Transaction Id')}}</h6>
                                </div>
                                <div class="col-md-3">
                                    <p class="text-muted text-bold">{{ $details['transaction_id'] ?? '--' }}</p>
                                </div>
                                <div class="col-md-3">
                                    <h6>{{ __('Transaction Proof')}}</h6>
                                </div>
                                <div class="col-md-3 col-6">
                                    <p class="text-muted">
                                        @if (isset($details) && $details != null && $details['transaction_file'] != null && $details['transaction_file'] != 'null')
                                            <a href="{{ asset($details['transaction_file']) ?? '' }}" target="_blank">
                                                <span class="badge bg-danger p-2 text-white"><i class="ik ik-eye pr-2"></i>View Attachment</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <hr class="m-0">
                            <div class="mt-3">
                                {{-- 1:Pending 2:Accepted 3:Shipped 4:Delivered 5:Completed 6:Cancelled 7:Resubmitted --}}
                                @if($order->user_id != auth()->id())
                                    @if ($order->status != 2)
                                        <a href="{{ route('panel.orders.update-status', [$order->id,'status' => 2]) }}" type="button" class="btn btn-outline-success m-1 confirm-btn">Accept</a>
                                    @endif
                                    @if ($order->status != 6)
                                        <a href="{{ route('panel.orders.update-status', [$order->id,'status' => 6]) }}" type="button" class="btn btn-outline-danger m-1 confirm-btn">Reject</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    @else
                        @if($order->user_id != auth()->id())
                            <div class="alert alert-info">
                                <ul>
                                    <li>Payment receipt has not yet been submitted by the customer.</li>
                                    <li>Do not ship the product until you receive payment from the customer</li>
                                </ul>
                            </div>
                        @endif    
                    @endif
                </div>
            </div>
        </div>
        <!-- push external js -->
        @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{asset('backend/js/form-advanced.js') }}"></script>
        <script>
            $('#OrderForm').validate();
        </script>
        @endpush
    @endsection
