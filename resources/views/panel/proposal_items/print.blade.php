@extends('backend.layouts.empty') 
@section('title', 'Proposal Items')
@section('content')
@php
/**
 * Proposal Item 
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
                                    <th>Proposal  </th>
                                    <th>Product  </th>
                                    <th>User Shop Item  </th>
                                    <th>Price</th>
                                    <th>Note</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($proposal_items->count() > 0)
                                    @foreach($proposal_items as  $proposal_item)
                                        <tr>
                                                <td>{{fetchFirst('App\Models\Proposal',$proposal_item['proposal_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\Models\Product',$proposal_item['product_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\Models\UserShopItem',$proposal_item['user_shop_item_id'],'name','--')}}</td>
                                             <td>{{$proposal_item['price'] }}</td>
                                             <td>{{$proposal_item['note'] }}</td>
                                                 
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
