@extends('backend.layouts.empty') 
@section('title', 'Proposals')
@section('content')
@php
/**
 * Proposal 
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
                                    <th>Customer Name</th>
                                    <th>Customer Details</th>
                                    <th>User Shop  </th>
                                    <th>User  </th>
                                    <th>Proposal Note</th>
                                    <th>Slug</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($proposals->count() > 0)
                                    @foreach($proposals as  $proposal)
                                        <tr>
                                            <td>{{$proposal['customer_name'] }}</td>
                                             <td>{{$proposal['customer_details'] }}</td>
                                                 <td>{{fetchFirst('App\Models\UserShop',$proposal['user_shop_id'],'name','--')}}</td>
                                                 <td>{{fetchFirst('App\User',$proposal['user_id'],'name','--')}}</td>
                                             <td>{{$proposal['proposal_note'] }}</td>
                                             <td>{{$proposal['slug'] }}</td>
                                                 
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
