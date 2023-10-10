@extends('backend.layouts.empty') 
@section('title', 'Products')
@section('content')
@php
/**
 * Product 
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
                                    <th>Brand  </th>
                                    <th>User  </th>
                                    <th>Title</th>
                                    <th>Category  </th>
                                    <th>Sub Category </th>
                                    <th>Is Publish</th>
                                    <th>Manage Inventory</th>
                                    <th>Status</th>
                                    <th>Stock Qty</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($products->count() > 0)
                                    @foreach($products as  $product)
                                        <tr>
                                                <td>{{fetchFirst('App\Models\Brand',$product['brand_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\User',$product['user_id'],'name','--')}}</td>
                                             <td>{{$product['title'] }}</td>
                                                 <td>{{fetchFirst('App\Models\Category',$product['category_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\Models\CategoryType',$product['sub_category'],'name','--')}}</td>
                                             <td>{{$product['is_publish'] }}</td>
                                             <td>{{$product['manage_inventory'] }}</td>
                                             <td>{{$product['status'] }}</td>
                                             <td>{{$product['stock_qty'] }}</td>
                                                 
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
