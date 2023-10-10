@extends('backend.layouts.empty') 
@section('title', 'Price Ask Requests')
@section('content')
@php
/**
 * Price Ask Request 
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
                                    <th>Workstream Id</th>
                                    <th>Sender Id</th>
                                    <th>Receiver  </th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Total</th>
                                    <th>Comment</th>
                                    <th>Till Date</th>
                                    <th>Details</th>
                                    <th>Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($price_ask_requests->count() > 0)
                                    @foreach($price_ask_requests as  $price_ask_request)
                                        <tr>
                                            <td>{{$price_ask_request['workstream_id'] }}</td>
                                             <td>{{$price_ask_request['sender_id'] }}</td>
                                                 <td>{{fetchFirst('App\User',$price_ask_request['receiver_id'],'name','--')}}</td>
                                             <td>{{$price_ask_request['price'] }}</td>
                                             <td>{{$price_ask_request['qty'] }}</td>
                                             <td>{{$price_ask_request['total'] }}</td>
                                             <td>{{$price_ask_request['comment'] }}</td>
                                             <td>{{$price_ask_request['till_date'] }}</td>
                                             <td>{{$price_ask_request['details'] }}</td>
                                             <td>{{$price_ask_request['status'] }}</td>
                                                 
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
