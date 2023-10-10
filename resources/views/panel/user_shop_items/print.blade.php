@extends('backend.layouts.empty') 
@section('title', 'User Shop Items')
@section('content')
@php
/**
 * User Shop Item 
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
                                    <th>Price</th>
                                    <th>Product  </th>
                                    <th>Price Group</th>
                                    <th>Is Published</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($user_shop_items->count() > 0)
                                    @foreach($user_shop_items as  $user_shop_item)
                                        <tr>
                                                <td>{{fetchFirst('App\User',$user_shop_item['user_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\Models\UserShop',$user_shop_item['user_shop_id'],'name','--')}}</td>
                                             <td>{{$user_shop_item['price'] }}</td>
                                                 <td>{{fetchFirst('App\Models\Product',$user_shop_item['product_id'],'name','--')}}</td>
                                             <td>{{$user_shop_item['price_group'] }}</td>
                                             <td>{{$user_shop_item['is_published'] }}</td>
                                                 
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
