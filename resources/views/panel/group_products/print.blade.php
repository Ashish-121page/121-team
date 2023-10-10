@extends('backend.layouts.empty') 
@section('title', 'Group Products')
@section('content')
@php
/**
 * Group Product 
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
                                    <th>Group  </th>
                                    <th>Product  </th>
                                    <th>Price</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($group_products->count() > 0)
                                    @foreach($group_products as  $group_product)
                                        <tr>
                                                <td>{{fetchFirst('App\User',$group_product['group_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\Models\Product',$group_product['product_id'],'name','--')}}</td>
                                             <td>{{$group_product['price'] }}</td>
                                                 
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
