@extends('backend.layouts.empty') 
@section('title', 'Medias')
@section('content')
@php
/**
 * Media 
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
                                    <th>Type</th>
                                    <th>Type Id</th>
                                    <th>File Name</th>
                                    <th>Path</th>
                                    <th>Extension</th>
                                    <th>File Type</th>
                                    <th>Tag</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($medias->count() > 0)
                                    @foreach($medias as  $media)
                                        <tr>
                                            <td>{{$media['type'] }}</td>
                                             <td>{{$media['type_id'] }}</td>
                                             <td>{{$media['file_name'] }}</td>
                                             <td>{{$media['path'] }}</td>
                                             <td>{{$media['extension'] }}</td>
                                             <td>{{$media['file_type'] }}</td>
                                             <td>{{$media['tag'] }}</td>
                                                 
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
