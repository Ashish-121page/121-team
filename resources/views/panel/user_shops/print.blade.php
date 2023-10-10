@extends('backend.layouts.empty') 
@section('title', 'User Shops')
@section('content')
@php
/**
 * User Shop 
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
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Logo</th>
                                    <th>Contact No</th>
                                    <th>Status</th>
                                    <th>Address</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($user_shops->count() > 0)
                                    @foreach($user_shops as  $user_shop)
                                        <tr>
                                                <td>{{fetchFirst('App\User',$user_shop['user_id'],'name','--')}}</td>
                                             <td>{{$user_shop['name'] }}</td>
                                             <td>{{$user_shop['description'] }}</td>
                                             <td><a href="{{ asset($user_shop['logo']) }}" target="_blank" class="btn-link">{{$user_shop['logo'] }}</a></td>
                                             <td>{{$user_shop['contact_no'] }}</td>
                                             <td>{{$user_shop['status'] }}</td>
                                             <td>{{$user_shop['address'] }}</td>
                                                 
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
