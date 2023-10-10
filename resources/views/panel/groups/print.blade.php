@extends('backend.layouts.empty') 
@section('title', 'Groups')
@section('content')
@php
/**
 * Group 
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
                                    <th>Type</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($groups->count() > 0)
                                    @foreach($groups as  $group)
                                        <tr>
                                                <td>{{fetchFirst('App\User',$group['user_id'],'name','--')}}</td>
                                             <td>{{$group['name'] }}</td>
                                             <td>{{$group['type'] }}</td>
                                                 
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
