{{ $data['atsign'] }}extends('backend.layouts.empty') 
{{ $data['atsign'] }}section('title', '{{ $indexheading }}')
{{ $data['atsign'] }}section('content')
{{ $data['atsign'] }}php
/**
 * {{ $heading }} 
 *

 *
 * @ref zCURD
 * @author  GRPL
 * @license 121.page
 * @version <GRPL 1.1.0>
 * @link    https://121.page/
 */
{{ $data['atsign'] }}endphp
   

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">                     
                    <div class="table-responsive">
                        <table id="table" class="table">
                            <thead>
                                <tr>                                      
                                    @foreach ($data['fields']['name'] as $index => $item)<th>@if($data['fields']['input'][$index] == 'select_via_table'){{ str_replace('Id','',ucwords(str_replace('_',' ',$item))) }} @else{{ ucwords(str_replace('_',' ',$item)) }}@endif</th>
                                    @endforeach

                                </tr>
                            </thead>
                            <tbody>
                                {{ $data['atsign'] }}if({{ $indexvariable }}->count() > 0)
                                    {{ $data['atsign'] }}foreach({{ $indexvariable }} as  {{ $variable}})
                                        <tr>
                                            @foreach ($data['fields']['name'] as $index => $item)@if($data['fields']['input'][$index] == 'select_via_table')    @php
                                                if($data['fields']['table'][$index] == "User"){
                                                    $model_path = "App\\";
                                                }else{
                                                    $model_path = "App\Models\\";
                                                }
                                            @endphp<td>{{ $data['curlstart'] }}fetchFirst('{{ $model_path.$data['fields']['table'][$index]  }}',{{ $variable}}['{{ $item }}'],'name','--')}}</td>
                                            @elseif($data['fields']['input'][$index] == 'file')<td><a href="{{ $data['curlstart'] }} asset({{ $variable}}['{{ $item }}']) }}" target="_blank" class="btn-link">{{ $data['curlstart'] }}{{ $variable}}['{{ $item }}'] }}</a></td>
                                            @else<td>{{ $data['curlstart'] }}{{ $variable}}['{{ $item }}'] }}</td>
                                            @endif @endforeach
    
                                        </tr>
                                    {{ $data['atsign'] }}endforeach
                                {{ $data['atsign'] }}else
                                    <tr>
                                        <td class="text-center" colspan="8">No Data Found...</td>
                                    </tr>
                                {{ $data['atsign'] }}endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{ $data['atsign'] }}endsection
