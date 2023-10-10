@extends('backend.layouts.empty') 
@section('title', 'Product Attributes')
@section('content')
@php
/**
 * Product Attribute 
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
                                    <th>Type</th>
                                    <th>Value</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($product_attributes->count() > 0)
                                    @foreach($product_attributes as  $product_attribute)
                                        <tr>
                                            <td>{{$product_attribute['name'] }}</td>
                                             <td>{{$product_attribute['type'] }}</td>
                                             <td>{{$product_attribute['value'] }}</td>
                                                 
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
