@extends('backend.layouts.empty') 
@section('title', 'User Packages')
@section('content')
@php
/**
 * User Package 
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
                                    <th>Package  </th>
                                    <th>Order  </th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Limit</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($user_packages->count() > 0)
                                    @foreach($user_packages as  $user_package)
                                        <tr>
                                                <td>{{fetchFirst('App\User',$user_package['user_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\Models\Package',$user_package['package_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\Models\Order',$user_package['order_id'],'name','--')}}</td>
                                             <td>{{$user_package['from'] }}</td>
                                             <td>{{$user_package['to'] }}</td>
                                             <td>{{$user_package['limit'] }}</td>
                                                 
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
