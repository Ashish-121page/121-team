@extends('backend.layouts.empty') 
@section('title', 'Group Users')
@section('content')
@php
/**
 * Group User 
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
                                    <th>User  </th>
                                    <th>User Shop  </th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($group_users->count() > 0)
                                    @foreach($group_users as  $group_user)
                                        <tr>
                                                <td>{{fetchFirst('App\Models\Group',$group_user['group_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\User',$group_user['user_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\Models\UserShop',$group_user['user_shop_id'],'name','--')}}</td>
                                                 
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
