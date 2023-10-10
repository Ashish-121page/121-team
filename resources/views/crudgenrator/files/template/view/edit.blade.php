{{ $data['atsign'] }}extends('backend.layouts.main') 
{{ $data['atsign'] }}section('title', '{{ $heading }}')
{{ $data['atsign'] }}section('content')
{{ $data['atsign'] }}php
/**
* {{ $heading }} 
*
* @category zStarter
*
* @ref zCURD
* @author  GRPL
* @license 121.page
* @version <GRPL 1.1.0>
* @link    https://121.page/
*/
$breadcrumb_arr = [
    ['name'=>'Edit {{ $heading }}', 'url'=> "javascript:void(0);", 'class' => '']
]
{{ $data['atsign'] }}endphp
    <!-- push external head elements to head -->
    {{ $data['atsign'] }}push('head')
    <link rel="stylesheet" href="{{ $data['curlstart'] }} asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <style>
        .error{
            color:red;
        }
    </style>
    {{ $data['atsign'] }}endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Edit')}} {{ $heading }}</h5>
                            <span>{{ __('Update a record for')}} {{ $heading }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    {{$data['atsign']}}include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- start message area-->
               {{$data['atsign']}}include('backend.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-header">
                        <h3>{{ __('Update')}} {{ $heading }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ $data['curlstart'] }} route('{{ $data['dotroutepath'].$data['name']}}.update',{{ $variable }}->id) }}" method="post" enctype="multipart/form-data" id="{{ $data['model'] }}Form">
                            {{$data['atsign']}}csrf
                            <div class="row">
                            @foreach($data['fields']['name'] as $index => $item)
                                @if($data['fields']['input'][$index] == 'select')

                                <div class="col-md-6 col-12"> {{-- Select --}}
                                    <div class="form-group">
                                        <label for="{{ $item }}">{{ucwords(str_replace('_',' ',$item))}}</label>
                                        <select required name="{{ $item }}" id="{{ $item }}" class="form-control select2">
                                            <option value="" readonly>Select {{ucwords(str_replace('_',' ',$item))}}</option>
                                            @if($data['fields']['select'][$index] != null)
                                            {{$data['atsign']}}php
                                                    $arr = "{{ $data['fields']['select'][$index] }}";
                                            {{$data['atsign']}}endphp
                                                {{$data['atsign']}}foreach(explode(',',$arr) as $option)
                                                    <option value=" {{ $data['curlstart'] }}  $option }}" {{ $data['curlstart'] }}   {{ $variable }}->{{ $item }}  ==  $option  ? 'selected' : ''}}>{{ $data['curlstart'] }} $option}}</option> 
                                                {{ $data['atsign'] }}endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                @elseif($data['fields']['input'][$index] == 'select_via_table')

                                <div class="col-md-6 col-12"> {{-- Select --}}
                                    @php if($data['fields']['table'][$index] == "User") $model_path = "App\\";  else $model_path = "App\Models\\"; @endphp

                                    <div class="form-group">
                                        <label for="{{ $item }}">{{str_replace('Id','',ucwords(str_replace('_',' ',$item)))}}<span class="text-danger">*</span></label>
                                        <select required name="{{ $item }}" id="{{ $item }}" class="form-control select2">
                                            <option value="" readonly>Select {{str_replace('Id','',ucwords(str_replace('_',' ',$item)))}}</option>
                                            {{$data['atsign']}}foreach({{ $model_path.$data['fields']['table'][$index] }}::all()  as $option)
                                                <option value="{{ $data['curlstart'] }} $option->id }}" {{ $data['curlstart'] }} {{ $variable }}->{{ $item }}  ==  $option->id ? 'selected' : ''}}>{{ $data['curlstart'] }}  $option->name ?? ''}}</option> 
                                            {{ $data['atsign'] }}endforeach
                                        </select>
                                    </div>
                                </div>
                                @elseif($data['fields']['input'][$index] == 'textarea')

                                <div class="col-md-6 col-12"> {{-- Textarea --}}
                                    <div class="form-group">
                                        <label for="{{ $item }}" class="control-label">{{ucwords(str_replace('_',' ',$item)) }}@if( $data['fields']['default'][$index] == 1 )<span class="text-danger">*</span> @endif</label>
                                        <textarea @if( $data['fields']['default'][$index] == 1 ) required  @endif class="form-control" name="{{ $item }}" id="{{ $item }}" placeholder="Enter {{ ucwords(str_replace('_',' ',$item))  }}">{{ $data['curlstart'] }}{{ $variable }}->{{ $item }} }}</textarea>
                                    </div>
                                </div>
                                @elseif($data['fields']['input'][$index] == 'decimal')

                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $data['curlstart'] }} $errors->has('{{ $item}}') ? 'has-error' : ''}}">
                                        <label for="{{ $item }}" class="control-label">{{ucwords(str_replace('_',' ',$item)) }}@if( $data['fields']['default'][$index] == 1 )<span class="text-danger">*</span> @endif</label>
                                        <input @if( $data['fields']['default'][$index] == 1 )required @endif  class="form-control" name="{{ $item }}" type="number" step="any" id="{{ $item }}" value="{{ $data['curlstart'] }}{{ $variable }}->{{ $item }} }}">
                                    </div>
                                </div>
                                @elseif($data['fields']['input'][$index] == 'datetime-local')

                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $data['curlstart'] }} $errors->has('{{ $item}}') ? 'has-error' : ''}}">
                                        <label for="{{ $item }}" class="control-label">{{ucwords(str_replace('_',' ',$item)) }}@if( $data['fields']['default'][$index] == 1 )<span class="text-danger">*</span> @endif</label>
                                        <input @if( $data['fields']['default'][$index] == 1 )required @endif  class="form-control" name="{{ $item }}" type="datetime-local" id="{{ $item }}" value="{{ $data['curlstart'] }}\Carbon\Carbon::parse({{ $variable }}->{{ $item }})->format('Y-m-d\TH:i') }}">
                                    </div>
                                </div>
                                @elseif($data['fields']['input'][$index] == "checkbox" ||$data['fields']['input'][$index] == "radio") 

                                <div class="col-md-6 col-12"> {{-- checkbox radio --}}
                                    <div class="form-group {{ $data['curlstart'] }} $errors->has('{{ $item}}') ? 'has-error' : ''}}"><br>
                                        <label for="{{ $item }}" class="control-label">{{ucwords(str_replace('_',' ',$item)) }}@if( $data['fields']['default'][$index] == 1 )<span class="text-danger">*</span> @endif</label>
                                        <input @if( $data['fields']['default'][$index] == 1 ) required @endif class="js-single switch-input" {{$data['atsign']}}if({{ $variable }}->{{ $item }}) checked {{$data['atsign']}}endif name="{{ $item }}" type="{{ $data['fields']['input'][$index] }}" id="{{ $item }}" value="1">
                                    </div>
                                </div>
                                @elseif($data['fields']['input'][$index] == 'file')

                                <div class="col-md-6 col-12"> {{-- file/img --}}
                                    <div class="form-group {{ $data['curlstart'] }} $errors->has('{{ $item}}') ? 'has-error' : ''}}">
                                        <label for="{{ $item }}" class="control-label">{{ucwords(str_replace('_',' ',$item)) }}</label>
                                        <input class="form-control" name="{{ $item }}_file" type="{{ $data['fields']['input'][$index] }}" id="{{ $item }}">
                                        <img id="{{ $item }}_file" src="{{ $data['curlstart'] }} asset({{ $variable}}->{{ $item }}) }}" class="mt-2" style="border-radius: 10px;width:100px;height:80px;"/>
                                    </div>
                                </div>
                                @else
                                
                                <div class="col-md-6 col-12"> {{-- Input --}}
                                    <div class="form-group {{ $data['curlstart'] }} $errors->has('{{ $item}}') ? 'has-error' : ''}}">
                                        <label for="{{ $item }}" class="control-label">{{ucwords(str_replace('_',' ',$item)) }}@if( $data['fields']['default'][$index] == 1 )<span class="text-danger">*</span> @endif</label>
                                        <input @if( $data['fields']['default'][$index] == 1 )required @endif @if($data['fields']['input'][$index] == "checkbox")@if( $data['fields']['default'][$index] == 4 )checked @endif @endif class="form-control" name="{{ $item }}" type="{{ $data['fields']['input'][$index] }}" id="{{ $item }}" value="{{ $data['curlstart'] }}{{ $variable }}->{{ $item }} }}">
                                    </div>
                                </div>
                                @endif
                            @endforeach

                                <div class="col-md-12 mx-auto">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    {{$data['atsign']}}push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{ $data['curlstart'] }}asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ $data['curlstart'] }}asset('backend/js/form-advanced.js') }}"></script>
    <{{ $data['script'] }}>
        $('#{{ $data['model'] }}Form').validate();
        @foreach($data['fields']['name'] as $index => $item)
            @if($data['fields']['input'][$index] == 'file')
              
            document.getElementById('{{ $item }}').onchange = function () {
                var src = URL.createObjectURL(this.files[0])
                $('#{{ $item }}_file').removeClass('d-none');
                document.getElementById('{{ $item }}_file').src = src
            }
            @endif
        @endforeach

    </{{ $data['script'] }}>
    {{$data['atsign']}}endpush
{{$data['atsign']}}endsection
