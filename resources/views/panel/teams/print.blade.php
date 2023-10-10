@extends('backend.layouts.empty') 
@section('title', 'Teams')
@section('content')
@php
/**
 * Team 
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
                                    <th>User Shop  </th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Designation</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($teams->count() > 0)
                                    @foreach($teams as  $team)
                                        <tr>
                                                <td>{{fetchFirst('App\Models\UserShop',$team['user_shop_id'],'name','--')}}</td>
                                             <td>{{$team['name'] }}</td>
                                             <td><a href="{{ asset($team['image']) }}" target="_blank" class="btn-link">{{$team['image'] }}</a></td>
                                             <td>{{$team['designation'] }}</td>
                                                 
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
