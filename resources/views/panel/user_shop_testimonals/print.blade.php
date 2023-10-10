@extends('backend.layouts.empty') 
@section('title', 'User Shop Testimonals')
@section('content')
@php
/**
 * User Shop Testimonal 
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
                                    <th>Designation</th>
                                    <th>Image</th>
                                    <th>Rating</th>
                                    <th>Tesimonal</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($user_shop_testimonals->count() > 0)
                                    @foreach($user_shop_testimonals as  $user_shop_testimonal)
                                        <tr>
                                            <td>{{$user_shop_testimonal['name'] }}</td>
                                             <td>{{$user_shop_testimonal['designation'] }}</td>
                                             <td><a href="{{ asset($user_shop_testimonal['image']) }}" target="_blank" class="btn-link">{{$user_shop_testimonal['image'] }}</a></td>
                                             <td>{{$user_shop_testimonal['rating'] }}</td>
                                             <td>{{$user_shop_testimonal['tesimonal'] }}</td>
                                                 
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
