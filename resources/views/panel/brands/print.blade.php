@extends('backend.layouts.empty') 
@section('title', 'Brands')
@section('content')
@php
/**
 * Brand 
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
                                    <th>Name</th>
                                    <th>User  </th>
                                    <th>Logo</th>
                                    <th>Status</th>
                                    <th>Short Text</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($brands->count() > 0)
                                    @foreach($brands as  $brand)
                                        <tr>
                                            <td>{{$brand['name'] }}</td>
                                                 <td>{{fetchFirst('App\User',$brand['user_id'],'name','--')}}</td>
                                             <td><a href="{{ asset($brand['logo']) }}" target="_blank" class="btn-link">{{$brand['logo'] }}</a></td>
                                             <td>{{$brand['status'] }}</td>
                                             <td>{{$brand['short_text'] }}</td>
                                                 
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
