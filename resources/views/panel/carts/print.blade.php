@extends('backend.layouts.empty') 
@section('title', 'Carts')
@section('content')
@php
/**
 * Cart 
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
                                    <th>User  </th>
                                    <th>User Shop  </th>
                                    <th>Product  </th>
                                    <th>User Shop Item  </th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($carts->count() > 0)
                                    @foreach($carts as  $cart)
                                        <tr>
                                                <td>{{fetchFirst('App\User',$cart['user_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\Models\UserShop',$cart['user_shop_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\Models\Product',$cart['product_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\Models\UserShopItem',$cart['user_shop_item_id'],'name','--')}}</td>
                                             <td>{{$cart['qty'] }}</td>
                                             <td>{{$cart['price'] }}</td>
                                             <td>{{$cart['total'] }}</td>
                                                 
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
