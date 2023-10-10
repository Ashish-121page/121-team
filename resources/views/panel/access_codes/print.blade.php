@extends('backend.layouts.empty') 
@section('title', 'Access Codes')
@section('content')
@php
/**
 * Access Code 
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
                                    <th>Code</th>
                                    <th>Creator  </th>
                                    <th>Redeemed User  </th>
                                    <th>Redeemed At</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($access_codes->count() > 0)
                                    @foreach($access_codes as  $access_code)
                                        <tr>
                                            <td>{{$access_code['code'] }}</td>
                                                 <td>{{fetchFirst('App\User',$access_code['creator_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\User',$access_code['redeemed_user_id'],'name','--')}}</td>
                                             <td>{{$access_code['redeemed_at'] }}</td>
                                                 
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
