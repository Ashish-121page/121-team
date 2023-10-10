@extends('backend.layouts.empty') 
@section('title', 'Orders')
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
@endphp
   

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">                     
                    <div class="table-responsive">
                        <table id="table" class="table">
                            <thead>
                                <tr>                                      
                                    <th>Customer  </th>
                                    <th>Txn No</th>
                                    <th>Items</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($orders->count() > 0)
                                    @foreach($orders as  $order)
                                        <tr>
                                                <td>{{fetchFirst('App\User',$order['user_id'],'name','--')}}</td>
                                             <td>{{$order['txn_no'] }}</td>
                                             <td>
                                                 @php
                                                    $items = App\Models\OrderItem::whereOrderId($order['id'])->get();
                                                 @endphp
                                                 <ul>
                                                     @foreach($items as $item)
                                                     <li>{{ $item->item_type.": #".$item->item_id }}</li>
                                                     @endforeach
                                                 </ul>
                                             </td>
                                             <td>{{format_price($order['total']) }}</td>
                                             <td><div class="badge badge-{{ orderStatus($order['status'])['color'] }}">{{orderStatus($order['status'])['name'] }}</div></td>
                                            <td>{{ getFormattedDate($order['date']) }}</td>
                                            <td>{{ getFormattedDateTime($order['created_at']) }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="8">No Data Found...</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
