@extends('backend.layouts.empty') 
@section('title', 'Packages')
@section('content')
@php
/**
 * Package 
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
                                    <th>Limit</th>
                                    <th>Price</th>
                                    <th>Duration</th>
                                    <th>Description</th>
                                    <th>Is Published</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($packages->count() > 0)
                                    @foreach($packages as  $package)
                                        <tr>
                                            <td>{{$package['name'] }}</td>
                                             <td>{{$package['limit'] }}</td>
                                             <td>{{$package['price'] }}</td>
                                             <td>{{$package['duration'] }}</td>
                                             <td>{{$package['description'] }}</td>
                                             <td>{{$package['is_published'] }}</td>
                                                 
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
