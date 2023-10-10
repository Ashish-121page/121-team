@extends('crudgenrator.layouts.master')

@section('title', 'Crudgen')

{{-- Push Styles --}}
@push('scopedCss')
    <style>
        @media screen and (max-width: 950px) {
            .select2-container{
                width:180px!important;
            }
        }
        @media (max-width:729px) {
            .select2-container{
                width:120px!important;
            }
        }
        .select2-container--default .select2-selection--single {
            background-color: #282C2F;
            border: 1px solid #282C2F;
            border-radius: 4px;
            color: #fff;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #fff;
            background-color: #282C2F;
            line-height: 35px;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #aaa;
            background-color: #282C2F;
            color: #fff;
        }
        .select2-container .select2-selection--single{
            height:37px;
        }
        .select2-dropdown {
            background-color: #282C2F;
            color:#ddd;
            }
        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable{
            background-color: #282C2F;
        color:#ddd;
            }
    </style>
@endpush

{{-- Main Page Content --}}
@section('content')
<div class="px-xl-5">
    <div class="container py-3 px-xl-5 px-lg-3 px-2" style="max-width: unset;">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ik ik-x"></i>
                </button>
        
            </div>
        @endif 
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="ik ik-x"></i>
                </button>
        
            </div>
        @endif 
        <form action="{{ route('crudgen.generate')  }}" method="POST" class="repeater" id="crudgen_form" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    {{-- Name --}}
                    <div class="card text-white bg-primary mb-3">
                      <div class="card-header">Crud Details</div>
                      <div class="card-body">
                          <div class="row">
                              <div class="col-12 col-md">
                                  <div class="form-group">
                                      <label class="form-control-label" for="name">Model Name <span class="text-danger">*</span></label>
                                      <input type="text" value="{{ old('model') }}" class="form-control first-upper model_name" name="model" id="model_name" placeholder="Model Name" required>
                                      <small class="text-muted">Enter model name for the crud e.g: <span class="text-accent">UserContact</span> (<span class="text-danger">Name needs to be in singular</span>)</small>
                                  </div>
                              </div>
                              <div class="col-12 col-md">
                                  <div class="form-group">
                                      <label class="form-control-label" for="name">Table Name <span class="text-danger">*</span></label>
                                      <input type="text" value="{{ old('name') }}" class="form-control lower crud_name" name="name" id="name" placeholder="Table Name" required>
                                      <small class="text-muted">Enter name for the crud e.g: <span class="text-accent">user_contacts</span> (<span class="text-danger">Name needs to be in plural</span>)</small>
                                  </div>
                              </div>
                              <div class="col-12 col-md">
                                  <div class="form-group">
                                      <label class="form-control-label" for="view_path">View Path</label>
                                      <input type="text" value="{{ old('view_path') }}" class="form-control lower" name="view_path " id="view_path" placeholder="View Path">
                                      <small class="text-muted">If you didn't specify view path it will defaultly take panel. It will generate views in <code class="text-accent">resources/views/<span id="view_path_preview">panel/</span><span id="crud_name">table_name</span> </code></small>
                                  </div>
                              </div>
                              <div class="col-12 col-md-3">
                                  {{-- Controller Namespace --}}
                                  <label for="controller_namespace">Controller Namespace</label>
                                  <div class="input-group mb-3">
                                      <div class="input-group-prepend">
                                          <span class="input-group-text">App\Http\Controllers\</span>
                                      </div>
                                      <input type="text" value="{{ old('controller_namespace') }}" class="form-control first-upper" name="controller_namespace" id="controller_namespace" placeholder="Admin">
                                      <small class="text-muted">If you didn't specify controller namespace it will defaultly take Panel </small>
                                  </div>
                              </div>
                              <div class="col-12 col-md">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">Searchable Fields <span class="text-danger">*</span></label>
                                    <input type="text" value="{{ old('search') }}" class="form-control lower" name="search" id="search" placeholder="Enter Searchable Fields" required>
                                    <small class="text-muted">Enter the fields for searching by comma seperating e.g: <span class="text-accent">name,email,phone</span></small>
                                </div>
                            </div>
                          </div>
                      </div>
                    </div>


                    {{-- Fields --}}
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header d-flex justify-content-between">
                            <span>Fields (Required)</span>
                            <div>
                                <button class="btn btn-accent btn-sm btn-add" type="button" id="addFieldsBtn">+</button>
                                <button class="btn btn-accent btn-sm btn-sub" type="button" id="removeFieldsBtn">-</button>
                            </div>
                        </div>
                        <div class="card-body fields">
                            <div class="row mb-2">
                                <div class="col">
                                    Name
                                </div>
                                <div class="col">
                                   Data Type (Column)
                                </div>
                                <div class="col">
                                    Input Type (Field)
                                </div>
                                <div class="col">
                                   Options
                                </div>
                                <div class="col">
                                   Comments
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center field">
                                <div class="col">
                                    <div class="form-group mr-1">
                                        <input required type="text" class="form-control col_name" value="{{ (old('fields') && old('fields')['name'][0] ) ? old('fields')['name'][0] : ""}}" data-id="0" id="col_name0" name="fields[name][]" placeholder="Name" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mr-1">
                                        <select required name="fields[type][]" class="form-control select2">
                                            <option value="">--Select Field Type--</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "bigIncrements") selected @endif value="bigIncrements">bigIncrements</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "bigInteger") selected @endif value="bigInteger">bigInteger</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "binary") selected @endif value="binary">binary</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "boolean") selected @endif value="boolean">boolean</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "char") selected @endif value="char">char</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "dateTimeTz") selected @endif value="dateTimeTz">dateTimeTz</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "dateTime") selected @endif value="dateTime">dateTime</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "date") selected @endif value="date">date</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "decimal") selected @endif value="decimal">decimal</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "double") selected @endif value="double">double</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "enum") selected @endif value="enum">enum</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "float") selected @endif value="float">float</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "foreignId") selected @endif value="foreignId">foreignId</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "geometryCollection") selected @endif value="geometryCollection">geometryCollection</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "geometry") selected @endif value="geometry">geometry</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "id") selected @endif value="id">id</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "increments") selected @endif value="increments">increments</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "integer") selected @endif value="integer">integer</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "ipAddress") selected @endif value="ipAddress">ipAddress</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "json") selected @endif value="json">json</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "jsonb") selected @endif value="jsonb">jsonb</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "lineString") selected @endif value="lineString">lineString</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "longText") selected @endif value="longText">longText</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "macAddress") selected @endif value="macAddress">macAddress</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "mediumIncrements") selected @endif value="mediumIncrements">mediumIncrements</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "mediumInteger") selected @endif value="mediumInteger">mediumInteger</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "mediumText") selected @endif value="mediumText">mediumText</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "morphs") selected @endif value="morphs">morphs</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "multiLineString") selected @endif value="multiLineString">multiLineString</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "multiPoint") selected @endif value="multiPoint">multiPoint</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "multiPolygon") selected @endif value="multiPolygon">multiPolygon</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "nullableMorphs") selected @endif value="nullableMorphs">nullableMorphs</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "nullableTimestamps") selected @endif value="nullableTimestamps">nullableTimestamps</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "nullableUuidMorphs") selected @endif value="nullableUuidMorphs">nullableUuidMorphs</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "point") selected @endif value="point">point</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "polygon") selected @endif value="polygon">polygon</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "rememberToken") selected @endif value="rememberToken">rememberToken</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "set") selected @endif value="set">set</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "smallIncrements") selected @endif value="smallIncrements">smallIncrements</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "smallInteger") selected @endif value="smallInteger">smallInteger</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "softDeletesTz") selected @endif value="softDeletesTz">softDeletesTz</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "softDeletes") selected @endif value="softDeletes">softDeletes</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "string") selected @endif value="string">string</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "text") selected @endif value="text">text</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "timeTz") selected @endif value="timeTz">timeTz</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "time") selected @endif value="time">time</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "timestampTz") selected @endif value="timestampTz">timestampTz</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "timestamp") selected @endif value="timestamp">timestamp</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "timestampsTz") selected @endif value="timestampsTz">timestampsTz</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "timestamps") selected @endif value="timestamps">timestamps</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "tinyIncrements") selected @endif value="tinyIncrements">tinyIncrements</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "tinyInteger") selected @endif value="tinyInteger">tinyInteger</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "tinyText") selected @endif value="tinyText">tinyText</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "unsignedBigInteger") selected @endif value="unsignedBigInteger">unsignedBigInteger</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "unsignedDecimal") selected @endif value="unsignedDecimal">unsignedDecimal</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "unsignedInteger") selected @endif value="unsignedInteger">unsignedInteger</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "unsignedMediumInteger") selected @endif value="unsignedMediumInteger">unsignedMediumInteger</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "unsignedSmallInteger") selected @endif value="unsignedSmallInteger">unsignedSmallInteger</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "unsignedTinyInteger") selected @endif value="unsignedTinyInteger">unsignedTinyInteger</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "uuidMorphs") selected @endif value="uuidMorphs">uuidMorphs</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "uuid") selected @endif value="uuid">uuid</option>
                                            <option @if(old('fields') && old('fields')['type'][0] == "year") selected @endif value="year">year</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mr-1">
                                        <select required name="fields[input][]" class="form-control select2 fields-type">
                                            <option value="">--Select Input Type--</option>
                                            <option @if(old('fields') && old('fields')['input'][0] == "text") selected @endif value="text">{{ ucfirst('text') }}</option>
                                            <option @if(old('fields') && old('fields')['input'][0] == "hidden") selected @endif value="hidden">{{ ucfirst('hidden') }}</option>
                                            <option @if(old('fields') && old('fields')['input'][0] == "date") selected @endif value="date">{{ ucfirst('date') }}</option>
                                            <option @if(old('fields') && old('fields')['input'][0] == "datetime-local") selected @endif value="datetime-local">{{ ucfirst("dateTime") }}</option>
                                            <option @if(old('fields') && old('fields')['input'][0] == "decimal") selected @endif value="decimal">{{ ucfirst("decimal ") }}</option>
                                            <option @if(old('fields') && old('fields')['input'][0] == "number") selected @endif value="number">{{ ucfirst('number') }}</option>
                                            <option @if(old('fields') && old('fields')['input'][0] == "email") selected @endif value="email">{{ ucfirst('email') }}</option>
                                            <option @if(old('fields') && old('fields')['input'][0] == "password") selected @endif value="password">{{ ucfirst('password') }}</option>
                                            <option @if(old('fields') && old('fields')['input'][0] == "url") selected @endif value="url">{{ ucfirst('url') }}</option>
                                            <option @if(old('fields') && old('fields')['input'][0] == "file") selected @endif value="file">{{ ucfirst('file') }}</option>
                                            <option @if(old('fields') && old('fields')['input'][0] == "radio") selected @endif value="radio">{{ ucfirst('radio') }}</option>
                                            <option @if(old('fields') && old('fields')['input'][0] == "checkbox") selected @endif value="checkbox">{{ ucfirst('checkbox') }}</option>
                                            <option @if(old('fields') && old('fields')['input'][0] == "textarea") selected @endif value="textarea">{{ ucfirst('textarea') }}</option>
                                            <option @if(old('fields') && old('fields')['input'][0] == "select") selected @endif value="select">{{ ucfirst('select') }}</option>
                                            <option @if(old('fields') && old('fields')['input'][0] == "select_via_table") selected @endif value="select_via_table">{{ ucfirst('select Via Table') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group d-flex justify-content-around">
                                        <select name="fields[default][]" data-id="0" id="fields0" class="form-control Options">
                                            <option @if(old('fields') && old('fields')['default'][0] == "1") selected @endif value="1">Required</option>
                                            <option @if(old('fields') && old('fields')['default'][0] == "2") selected @endif value="2">Nullable</option>
                                            <option @if(old('fields') && old('fields')['default'][0] == "3") selected @endif value="3">Default 0</option>
                                            <option @if(old('fields') && old('fields')['default'][0] == "4") selected @endif value="4">Default 1</option>
                                        </select>
                                        <textarea name="fields[select][]" rows="1" style="resize: none; opacity: 0" class="form-control d-none"></textarea>
                                        <select name="fields[table][]" class="form-control table d-none">
                                            <option @if(old('fields') && old('fields')['table'][0] == "User") selected @endif value="User">User</option>
                                            @foreach($tmpFiles as $temp)
                                                <option @if(old('fields') && old('fields')['table'][0] == $temp['filename']) selected @endif value="{{ $temp['filename'] }}">{{ $temp['filename'] }}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group ml-1">
                                        <input required type="text" class="form-control d-inline-flex" value="{{ (old('fields') && old('fields')['comment'][0] ) ? old('fields')['comment'][0] : ""}}" name="fields[comment][]" placeholder="Comment" />
                                    </div>
                                </div>
                            </div>
                            @if(old('fields') && count(old('fields')['name']) > 0)
                                @for($i = 1; $i<count(old('fields')['name']); $i++)
                                    <div class="row no-gutters align-items-center field">
                                        <div class="col">
                                            <div class="form-group mr-1">
                                                <input required type="text" class="form-control col_name" value="{{ (old('fields') && old('fields')['name'][$i] ) ? old('fields')['name'][$i] : ""}}" data-id="{{ $i }}" id="col_name{{ $i }}" name="fields[name][]" placeholder="Name" />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group mr-1">
                                                <select required name="fields[type][]" class="form-control select2">
                                                    <option value="">--Select Field Type--</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "bigIncrements") selected @endif value="bigIncrements">bigIncrements</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "bigInteger") selected @endif value="bigInteger">bigInteger</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "binary") selected @endif value="binary">binary</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "boolean") selected @endif value="boolean">boolean</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "char") selected @endif value="char">char</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "dateTimeTz") selected @endif value="dateTimeTz">dateTimeTz</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "dateTime") selected @endif value="dateTime">dateTime</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "date") selected @endif value="date">date</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "decimal") selected @endif value="decimal">decimal</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "double") selected @endif value="double">double</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "enum") selected @endif value="enum">enum</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "float") selected @endif value="float">float</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "foreignId") selected @endif value="foreignId">foreignId</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "geometryCollection") selected @endif value="geometryCollection">geometryCollection</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "geometry") selected @endif value="geometry">geometry</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "id") selected @endif value="id">id</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "increments") selected @endif value="increments">increments</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "integer") selected @endif value="integer">integer</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "ipAddress") selected @endif value="ipAddress">ipAddress</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "json") selected @endif value="json">json</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "jsonb") selected @endif value="jsonb">jsonb</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "lineString") selected @endif value="lineString">lineString</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "longText") selected @endif value="longText">longText</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "macAddress") selected @endif value="macAddress">macAddress</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "mediumIncrements") selected @endif value="mediumIncrements">mediumIncrements</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "mediumInteger") selected @endif value="mediumInteger">mediumInteger</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "mediumText") selected @endif value="mediumText">mediumText</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "morphs") selected @endif value="morphs">morphs</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "multiLineString") selected @endif value="multiLineString">multiLineString</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "multiPoint") selected @endif value="multiPoint">multiPoint</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "multiPolygon") selected @endif value="multiPolygon">multiPolygon</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "nullableMorphs") selected @endif value="nullableMorphs">nullableMorphs</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "nullableTimestamps") selected @endif value="nullableTimestamps">nullableTimestamps</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "nullableUuidMorphs") selected @endif value="nullableUuidMorphs">nullableUuidMorphs</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "point") selected @endif value="point">point</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "polygon") selected @endif value="polygon">polygon</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "rememberToken") selected @endif value="rememberToken">rememberToken</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "set") selected @endif value="set">set</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "smallIncrements") selected @endif value="smallIncrements">smallIncrements</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "smallInteger") selected @endif value="smallInteger">smallInteger</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "softDeletesTz") selected @endif value="softDeletesTz">softDeletesTz</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "softDeletes") selected @endif value="softDeletes">softDeletes</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "string") selected @endif value="string">string</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "text") selected @endif value="text">text</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "timeTz") selected @endif value="timeTz">timeTz</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "time") selected @endif value="time">time</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "timestampTz") selected @endif value="timestampTz">timestampTz</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "timestamp") selected @endif value="timestamp">timestamp</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "timestampsTz") selected @endif value="timestampsTz">timestampsTz</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "timestamps") selected @endif value="timestamps">timestamps</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "tinyIncrements") selected @endif value="tinyIncrements">tinyIncrements</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "tinyInteger") selected @endif value="tinyInteger">tinyInteger</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "tinyText") selected @endif value="tinyText">tinyText</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "unsignedBigInteger") selected @endif value="unsignedBigInteger">unsignedBigInteger</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "unsignedDecimal") selected @endif value="unsignedDecimal">unsignedDecimal</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "unsignedInteger") selected @endif value="unsignedInteger">unsignedInteger</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "unsignedMediumInteger") selected @endif value="unsignedMediumInteger">unsignedMediumInteger</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "unsignedSmallInteger") selected @endif value="unsignedSmallInteger">unsignedSmallInteger</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "unsignedTinyInteger") selected @endif value="unsignedTinyInteger">unsignedTinyInteger</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "uuidMorphs") selected @endif value="uuidMorphs">uuidMorphs</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "uuid") selected @endif value="uuid">uuid</option>
                                                    <option @if(old('fields') && old('fields')['type'][$i] == "year") selected @endif value="year">year</option>
        
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group mr-1">
                                                <select required name="fields[input][]" class="form-control select2 fields-type">
                                                    <option value="">--Select Input Type--</option>
                                                    <option @if(old('fields') && old('fields')['input'][$i] == "text") selected @endif value="text">{{ ucfirst('text') }}</option>
                                                    <option @if(old('fields') && old('fields')['input'][$i] == "hidden") selected @endif value="hidden">{{ ucfirst('hidden') }}</option>
                                                    <option @if(old('fields') && old('fields')['input'][$i] == "date") selected @endif value="date">{{ ucfirst('date') }}</option>
                                                    <option @if(old('fields') && old('fields')['input'][$i] == "datetime-local") selected @endif value="datetime-local">{{ ucfirst("dateTime") }}</option>
                                                    <option @if(old('fields') && old('fields')['input'][$i] == "decimal") selected @endif value="decimal">{{ ucfirst("decimal ") }}</option>
                                                    <option @if(old('fields') && old('fields')['input'][$i] == "number") selected @endif value="number">{{ ucfirst('number') }}</option>
                                                    <option @if(old('fields') && old('fields')['input'][$i] == "email") selected @endif value="email">{{ ucfirst('email') }}</option>
                                                    <option @if(old('fields') && old('fields')['input'][$i] == "password") selected @endif value="password">{{ ucfirst('password') }}</option>
                                                    <option @if(old('fields') && old('fields')['input'][$i] == "url") selected @endif value="url">{{ ucfirst('url') }}</option>
                                                    <option @if(old('fields') && old('fields')['input'][$i] == "file") selected @endif value="file">{{ ucfirst('file') }}</option>
                                                    <option @if(old('fields') && old('fields')['input'][$i] == "radio") selected @endif value="radio">{{ ucfirst('radio') }}</option>
                                                    <option @if(old('fields') && old('fields')['input'][$i] == "checkbox") selected @endif value="checkbox">{{ ucfirst('checkbox') }}</option>
                                                    <option @if(old('fields') && old('fields')['input'][$i] == "textarea") selected @endif value="textarea">{{ ucfirst('textarea') }}</option>
                                                    <option @if(old('fields') && old('fields')['input'][$i] == "select") selected @endif value="select">{{ ucfirst('select') }}</option>
                                                    <option @if(old('fields') && old('fields')['input'][$i] == "select_via_table") selected @endif value="select_via_table">{{ ucfirst('select Via Table') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group d-flex justify-content-around">
                                                <select name="fields[default][]" data-id="{{ $i }}" id="fields{{ $i }}" class="form-control Options">
                                                    <option @if(old('fields') && old('fields')['default'][$i] == "1") selected @endif value="1">Required</option>
                                                    <option @if(old('fields') && old('fields')['default'][$i] == "2") selected @endif value="2">Nullable</option>
                                                    <option @if(old('fields') && old('fields')['default'][$i] == "3") selected @endif value="3">Default 0</option>
                                                    <option @if(old('fields') && old('fields')['default'][$i] == "4") selected @endif value="4">Default 1</option>
                                                </select>
                                                <textarea name="fields[select][]" rows="1" style="resize: none; opacity: 0" class="form-control d-none"></textarea>
                                                <select name="fields[table][]" class="form-control table d-none">
                                                    <option @if(old('fields') && old('fields')['table'][$i] == "User") selected @endif value="User">User</option>
                                                    @foreach($tmpFiles as $temp)
                                                        <option @if(old('fields') && old('fields')['table'][$i] == $temp['filename']) selected @endif value="{{ $temp['filename'] }}">{{ $temp['filename'] }}</option>
                                                @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col ">
                                            <div class="form-group ml-1">
                                                <input required type="text" class="form-control" value="{{ (old('fields') && old('fields')['comment'][$i] ) ? old('fields')['comment'][$i] : ""}}" name="fields[comment][]" placeholder="Comment" />
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @endif
                        </div>
                    </div>

                </div>

                {{-- Right Col --}}
                <div class="col-md-8">
                    {{-- Validations --}}
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header d-flex justify-content-between">
                            <span> Server Side Validations</span>
                            <div>
                                <button class="btn btn-accent btn-sm btn-add" id="addValidations" type="button">+</button>
                                <button class="btn btn-accent btn-sm btn-sub" type="button" id="removeValidations">-</button>
                            </div>
                        </div>
                        <div class="card-body validations">
                            <div class="row mb-2">
                                <div class="col">
                                    Field
                                </div>
                                <div class="col">
                                    Rules
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center validation">
                                <div class="col">
                                    <div class="form-group mr-1">
                                        <input type="text" class="form-control" value="{{ (old('validations') && old('validations')['field'][0]) ? old('validations')['field'][0]:'' }}" name="validations[field][]" id="validation0" placeholder="Filed" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mr-1">
                                        <input type="text" class="form-control" value="{{ (old('validations') && old('validations')['rules'][0]) ? old('validations')['rules'][0]: 'required' }}" name="validations[rules][]" id="rule0" placeholder="Rules"/>
                                    </div>
                                </div>
                            </div>
                            @if(old('validations') && count(old('validations')['field']) > 0)
                                @for($vi = 1; $vi<count(old('validations')['field']); $vi++)
                                    <div class="row no-gutters align-items-center validation">
                                        <div class="col">
                                            <div class="form-group mr-1">
                                                <input type="text" class="form-control" value="{{ (old('validations') && old('validations')['field'][$vi]) ? old('validations')['field'][$vi]:'' }}" name="validations[field][]" id="validation{{ $vi }}" placeholder="Filed" />
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group mr-1">
                                                <input type="text" class="form-control" value="{{ (old('validations') && old('validations')['rules'][$vi]) ? old('validations')['rules'][$vi]:'' }}" name="validations[rules][]" id="rule{{ $vi }}" value="required" placeholder="Rules"/>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-header d-flex justify-content-between">
                            <span>Some Options</span>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col text-center">
                                    <label for="softdelete"><input type="checkbox" id="softdelete" name="softdelete" value="1" @if(old('softdelete') == 1) checked @endif /> Soft Delete</label><br>
                                    <label for="api"><input type="checkbox" id="api" name="api" value="1" @if(old('api') == 1) checked @endif /> Generate API</label><br>
                                </div>
                                <div class="col text-center">
                                    <label for="mail"><input type="checkbox" id="mail" name="mail" value="1" @if(old('mail') == 1) checked @endif /> Mail Notification</label><br>
                                    <label for="notification"><input type="checkbox" id="notification" name="notification" value="1"@if(old('notification') == 1) checked @endif  /> Site Notification</label><br>
                                </div>
                            </div>
                            {{-- <div class="row mb-2">
                                <div class="col text-center">
                                    <label for=""><input type="text" name="securecode" class="form-control" value="" placeholder="Enter Secure Code" /></label>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>


                {{-- <div class="col-md-12"> --}}
                    {{-- Relationships --}}
                    {{-- <div class="card text-white bg-primary mb-3">
                        <div class="card-header d-flex justify-content-between">
                            <span>Relationships</span>
                            <button class="btn btn-accent btn-sm btn-add" id="addRelationships" type="button">+</button>
                        </div>
                        <div class="card-body relationships">
                            <div class="row mb-2">
                                <div class="col">
                                    Name
                                </div>
                                <div class="col">
                                    Type
                                </div>
                                <div class="col">
                                    Class (Model)
                                </div>
                            </div>
                            <div class="row no-gutters align-items-center relationship">
                                <div class="col">
                                    <div class="form-group mr-1">
                                        <input type="text" class="form-control" name="relationships[name][]" placeholder="Name" />
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group mr-1">
                                        <input type="text" class="form-control" name="relationships[type][]" placeholder="Type"/>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">App\</span>
                                        </div>
                                        <input type="text" class="form-control" name="relationships[class][]" placeholder="Models\User">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div> --}}
                {{-- </div> --}}
            </div>
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <div class="form-group m-0">
                        <button type="submit" class="btn btn-accent text-grey-800">Generate</button>
                    </div>
                </div>
            </div>
        </form>
        <div id="accordion">
            <div class="accordion-header my-3" id="headingOne">
                <button class="btn accordion-button " data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <span class="text-white">Laravel Validation Rules</span> 
                </button>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="accordion-body">
                        <ul>
                            <div class="row mt-2">
                            <div class="col-md-3">  
                                <li>accepted</li>      
                                <li> active_url</li>      
                                <li>after:YYYY-MM-DD</li>
                                <li>before:YYYY-MM-DD</li>
                                <li>alpha</li>
                                <li>alpha_dash</li>
                                <li>alpha_num</li>
                                <li>array</li>
                                <li>between:1,10</li>
                                <li>confirmed</li>
                                <li>date</li>
                            </div>
                            <div class="col-md-3">
                                <li>date_format:YYYY-MM-DD</li>
                                <li>different:fieldname</li>
                                <li>digits:value</li>
                                <li>digits_between:min,max</li>
                                <li>boolean</li>
                                <li>email</li>
                                <li>exists:table,column</li>
                                <li>image</li>
                                <li>in:foo,bar,...</li>
                                <li>not_in:foo,bar,...</li>
                                <li>sometimes</li>
                            </div>
                            <div class="col-md-3">
                                <li>integer</li>
                                <li>numeric</li>
                                <li>ip</li>
                                <li>max:value</li>
                                <li>min:value</li>
                                <li>mimes:jpeg,png</li>
                                <li>regex:[0-9]</li>
                                <li>required</li>
                                <li>required_if:field,value</li>
                            </div>
                            <div class="col-md-3">
                                <li>required_with:foo,bar,...</li>
                                <li>required_with_all:foo,bar,...</li>
                                <li>required_without:foo,bar,...</li>
                                <li>required_without_all:foo,bar,...</li>
                                <li>same:field</li>
                                <li>size:value</li>
                                <li>timezone</li>
                                <li>unique:table,column,except,idColumn</li>
                                <li>url</li>
                            </div>
                        </div>
                    </ul> 
                        
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection

{{-- Push Scripts --}}
@push('scopedJs')
    <script>
        var inputval = 0;
        @if(old('fields'))
        var iteration = "{{ count(old('fields')['name']) }}";
        @else
        var iteration = 1;
        @endif


        $(document).ready(function () {
            $(document).on('click', '#addForeignKeys', function () {
                var tmp =   '<div class="row no-gutters align-items-center foreignKey">\n' +
                            '    <div class="col mr-1">\n' +
                            '        <div class="form-group">\n' +
                            '            <input type="text" class="form-control" name="foreigns[column][]" placeholder="Column" />\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '    <div class="col mr-1">\n' +
                            '        <div class="form-group">\n' +
                            '            <input type="text" class="form-control" name="foreigns[references][]" placeholder="References"/>\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '    <div class="col mr-1">\n' +
                            '        <div class="form-group">\n' +
                            '            <input type="text" class="form-control" name="foreigns[on][]" placeholder="On"/>\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '    <div class="col mr-1">\n' +
                            '        <div class="form-group">\n' +
                            '            <input type="text" class="form-control" name="foreigns[onDelete][]" placeholder="onDelete" value="cascade" readonly/>\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '</div>';

                $('.foreignKeys').append(tmp);
            });

            $(document).on('click', '#addRelationships', function () {
                var tmp =   '<div class="row no-gutters align-items-center relationship">\n' +
                            '    <div class="col">\n' +
                            '        <div class="form-group mr-1">\n' +
                            '            <input type="text" class="form-control" name="relationships[name][]" placeholder="Name" />\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '    <div class="col">\n' +
                            '        <div class="form-group mr-1">\n' +
                            '            <input type="text" class="form-control" name="relationships[type][]" placeholder="Type"/>\n' +
                            '        </div>\n' +
                            '    </div>\n' +

                            '    <div class="col">\n' +
                            '       <div class="input-group mb-3">\n' +
                            '           <div class="input-group-prepend">\n' +
                            '               <span class="input-group-text">App\</span>\n' +
                            '           </div>\n' +
                            '           <input type="text" class="form-control" name="relationships[class][]" placeholder="Models\User">\n' +
                            '       </div>\n'+
                            '    </div>\n' +

                            '    <div class="col">\n' +
                            '        <div class="form-group">\n' +
                            '            <textarea name="fields[option][]" rows="1" style="resize: none; opacity: 0" class="form-control"></textarea>\n' +
                            '        </div>\n' +
                            '    </div>\n' +

                            '</div>';

                $('.relationships').append(tmp);
            });


            $(document).on('click', '#addValidations', function () {
               
                var tmp =   '<div class="row no-gutters align-items-center validation">\n' +
                            '    <div class="col">\n' +
                            '        <div class="form-group mr-1">\n' +
                            '            <input type="text" class="form-control" id="validation'+iteration+'" name="validations[field][]" placeholder="Filed" />\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '    <div class="col">\n' +
                            '        <div class="form-group mr-1">\n' +
                            '            <input type="text" class="form-control" id="rule'+iteration+'" name="validations[rules][]" value="required" placeholder="Rules"/>\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '</div>';

                $('.validations').append(tmp); 
                
            });
            $(document).on('click', '#addFieldsBtn', function () {
                // inputval = 0;
                var html ;
                    html =' <select name="fields[default][]" data-id="'+iteration+'" id="fields'+iteration+'" class="form-control Options" id="">\n'+
                    '    <option value="1">Required</option>\n'+
                    '    <option value="2">Nullable</option>\n'+
                    '    <option value="3">Default 0</option>\n'+
                    '    <option value="4">Default 1</option>\n'+
                    ' </select>\n';
                    html +=      '  <textarea name="fields[select][]" rows="1" style="resize: none; opacity: 0" class="form-control d-none"></textarea>\n';
              
                    html += '   <select name="fields[table][]" class="form-control  table d-none" id="">\n'+
                        ' <option value="User">User</option>'+
                        @foreach($tmpFiles as $temp)
                            ' <option value="'+"{{ $temp['filename'] }}"+'">'+"{{ $temp['filename'] }}"+'</option>\n'+
                        @endforeach
                    ' </select>\n' ;
                
                var tmp =   '<div class="row no-gutters align-items-center field">\n' +
                            '    <div class="col">\n' +
                            '        <div class="form-group mr-1">\n' +
                            '            <input required type="text" class="form-control col_name" data-id="'+iteration+'" id="col_name'+iteration+'" name="fields[name][]" placeholder="Name" />\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '    <div class="col">\n' +
                            '        <div class="form-group mr-1">\n' +
                            '            <select name="fields[type][]" class="form-control select2">\n' +
                            '                <option value="">--Select Field Type--</option>\n' +
                                            '<option value="bigIncrements">bigIncrements</option>\n' +
                                            '<option value="bigInteger">bigInteger</option>\n' +
                                            '<option value="binary">binary</option>\n' +
                                            '<option value="boolean">boolean</option>\n' +
                                            '<option value="char">char</option>\n' +
                                            '<option value="dateTimeTz">dateTimeTz</option>\n' +
                                            '<option value="dateTime">dateTime</option>\n' +
                                            '<option value="date">date</option>\n' +
                                            '<option value="decimal">decimal</option>\n' +
                                            '<option value="double">double</option>\n' +
                                            '<option value="enum">enum</option>\n' +
                                            '<option value="float">float</option>\n' +
                                            '<option value="foreignId">foreignId</option>\n' +
                                            '<option value="geometryCollection">geometryCollection</option>\n' +
                                            '<option value="geometry">geometry</option>\n' +
                                            '<option value="id">id</option>\n' +
                                            '<option value="increments">increments</option>\n' +
                                            '<option value="integer">integer</option>\n' +
                                            '<option value="ipAddress">ipAddress</option>\n' +
                                            '<option value="json">json</option>\n' +
                                            '<option value="jsonb">jsonb</option>\n' +
                                            '<option value="lineString">lineString</option>\n' +
                                            '<option value="longText">longText</option>\n' +
                                            '<option value="macAddress">macAddress</option>\n' +
                                            '<option value="mediumIncrements">mediumIncrements</option>\n' +
                                            '<option value="mediumInteger">mediumInteger</option>\n' +
                                            '<option value="mediumText">mediumText</option>\n' +
                                            '<option value="morphs">morphs</option>\n' +
                                            '<option value="multiLineString">multiLineString</option>\n' +
                                            '<option value="multiPoint">multiPoint</option>\n' +
                                            '<option value="multiPolygon">multiPolygon</option>\n' +
                                            '<option value="nullableMorphs">nullableMorphs</option>\n' +
                                            '<option value="nullableTimestamps">nullableTimestamps</option>\n' +
                                            '<option value="nullableUuidMorphs">nullableUuidMorphs</option>\n' +
                                            '<option value="point">point</option>\n' +
                                            '<option value="polygon">polygon</option>\n' +
                                            '<option value="rememberToken">rememberToken</option>\n' +
                                            '<option value="set">set</option>\n' +
                                            '<option value="smallIncrements">smallIncrements</option>\n' +
                                            '<option value="smallInteger">smallInteger</option>\n' +
                                            '<option value="softDeletesTz">softDeletesTz</option>\n' +
                                            '<option value="softDeletes">softDeletes</option>\n' +
                                            '<option value="string">string</option>\n' +
                                            '<option value="text">text</option>\n' +
                                            '<option value="timeTz">timeTz</option>\n' +
                                            '<option value="time">time</option>\n' +
                                            '<option value="timestampTz">timestampTz</option>\n' +
                                            '<option value="timestamp">timestamp</option>\n' +
                                            '<option value="timestampsTz">timestampsTz</option>\n' +
                                            '<option value="timestamps">timestamps</option>\n' +
                                            '<option value="tinyIncrements">tinyIncrements</option>\n' +
                                            '<option value="tinyInteger">tinyInteger</option>\n' +
                                            '<option value="tinyText">tinyText</option>\n' +
                                            '<option value="unsignedBigInteger">unsignedBigInteger</option>\n' +
                                            '<option value="unsignedDecimal">unsignedDecimal</option>\n' +
                                            '<option value="unsignedInteger">unsignedInteger</option>\n' +
                                            '<option value="unsignedMediumInteger">unsignedMediumInteger</option>\n' +
                                            '<option value="unsignedSmallInteger">unsignedSmallInteger</option>\n' +
                                            '<option value="unsignedTinyInteger">unsignedTinyInteger</option>\n' +
                                            '<option value="uuidMorphs">uuidMorphs</option>\n' +
                                            '<option value="uuid">uuid</option>\n' +
                                            '<option value="year">year</option>\n' +

                            '            </select>\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '    <div class="col">\n' + 
                            '        <div class="form-group mr-1">\n' +
                            '               <select name="fields[input][]" class="form-control select2 fields-type">\n' +
                                            '<option value="">--Select Input Type--</option>>\n' +
                                            '<option value="text">{{ ucfirst("text") }}</option>>\n' +
                                            '<option value="hidden">{{ ucfirst("hidden") }}</option>>\n' +
                                            '<option value="date">{{ ucfirst("date") }}</option>>\n' +
                                            '<option value="datetime-local">{{ ucfirst("dateTime") }}</option>>\n' +
                                            '<option value="decimal">{{ ucfirst("decimal") }}</option>>\n' +
                                            '<option value="number">{{ ucfirst("number") }}</option>>\n' +
                                            '<option value="email">{{ ucfirst("email") }}</option>>\n' +
                                            '<option value="password">{{ ucfirst("password") }}</option>>\n' +
                                            '<option value="url">{{ ucfirst("url") }}</option>>\n' +
                                            '<option value="file">{{ ucfirst("file") }}</option>>\n' +
                                            '<option value="radio">{{ ucfirst("radio") }}</option>>\n' +
                                            '<option value="checkbox">{{ ucfirst("checkbox") }}</option>>\n' +
                                            '<option value="textarea">{{ ucfirst("textarea") }}</option>>\n' +
                                            '<option value="select">{{ ucfirst("select") }}</option>>\n' +
                                            '<option value="select_via_table">{{ ucfirst("select via table") }}</option>>\n' +
                                       ' </select>\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                                '<div class="col">\n' +
                                    '<div class="form-group d-flex justify-content-around">\n '+
                                        html
                                    +' </div>\n'+
                               ' </div>\n'+
                                '<div class="col">\n' +
                                    '<div class="form-group ml-1">\n '+
                            '            <input required type="text" class="form-control" name="fields[comment][]" placeholder="Comment"/>\n' +
                                    ' </div>\n'+
                               ' </div>\n'+
                            '</div>';
                $('.fields').append(tmp);
                selectRefresh();
                $('#addValidations').click();
                iteration = iteration+1;
            });

            
            $(document).on('click', '#removeFieldsBtn', function () {
                if(iteration >1){
                    iteration = iteration-1;
                    $('.fields').children('.row').last().remove();
                    $('.validations').children('.row').last().remove();
                }
            });
            $(document).on('click', '#removeValidations', function () {
                if(iteration >1){
                    $('.validations').children('.row').last().remove();
                }
            });

            function selectRefresh() {
                $('.select2').select2({
                    //-^^^^^^^^--- update here
                    tags: true,
                    placeholder: "Select an Option",
                    allowClear: true,
                    width: '100%'
                });
            }
            $('.deleteForeignKey').each(function () {
                var _this = $(this);
                $(this).on('click', function () {
                    alert('dsad')
                    _this.parent().parent().parent().fadeOut();
                })
            })

            $(document).on('input', '#view_path', function () {
                if ($(this).val().length <= 0 ){
                    $('#view_path_preview').html('panel/');
                } else{
                    $('#view_path_preview').html($(this).val() + '/');
                }
            })
            $(document).on('input', '#name', function () {
                if ($(this).val().length <= 0 ){
                    $('#crud_name').html('crud_name');
                } else{
                    $('#crud_name').html($(this).val().toLowerCase());
                }
            })
            $(document).on('change', '.fields-type', function () {
                var target = $(this).parent().parent().siblings().children().find('textarea');
                var target1 = $(this).parent().parent().siblings().children().find('.table');
                var target2 = $(this).parent().parent().siblings().children().find('.Options');
                // alert($(this).val());
                console.log(target);
                console.log(target1);
                console.log(target2);
                if ($(this).val() === 'select'){
                    inputval = 1;
                    target2.addClass('d-none');
                    target1.removeClass('select2').addClass('d-none').siblings('.select2').remove();
                    target.removeClass('d-none').removeClass('disabled').css('opacity', '1');
                } else if($(this).val() === 'select_via_table') {
                    inputval = 2;
                    target2.addClass('d-none');
                    target.addClass('d-none').addClass('disabled').css('opacity', '0');
                    target1.addClass('select2').removeClass('d-none');
                } else {
                    target1.removeClass('select2').addClass('d-none').siblings('.select2').remove();
                    target2.removeClass('d-none');
                    target.addClass('d-none').addClass('disabled').css('opacity', '0');
                }
                selectRefresh();
            })

            $(document).ready(function() {
                $('.select2').each(function () {
                    $(this).select2()
                });
            });

            $(document).on('input', '.first-upper', function (e) {
                firstUpper(e);
            })
            $(document).on('focusout', '.model_name', function (e) {
                singularize(e);
                var str= e.target.value;
                s = str.replace(/([a-z])([A-Z])/g, '$1_$2');
                $('.crud_name').val(s.toLowerCase());
                $('.crud_name').focus();
            })
            $(document).on('keyup', '.col_name', function(e) {
                // console.log(e.which);
                var col_id = $(this).data('id');
               text = allLower(e);
                if (e.which == 32 || e.which == 45){
                    console.log('Space or hypen Detected');
                    return false;
                }
               $('#validation'+col_id).val(text);
            });
            $(document).on('change', '.col_name', function(e) {
                // console.log(e.which);
                var col_id = $(this).data('id');
               text = allLower(e);
                if (e.which == 32 || e.which == 45){
                    console.log('Space or hypen Detected');
                    return false;
                }
               $('#validation'+col_id).val(text);
            });
            $(document).on('change', '.Options', function(e) {
                var opt_id = $(this).data('id');
                if($(this).val() != 1){
                    $('#rule'+opt_id).val('sometimes');
                }else{
                    $('#rule'+opt_id).val('required');
                }
            });

            $(document).on('input', '.lower', function (e) {
                allLower(e);
            })
            $(document).on('focusout', '.crud_name', function (e) {
                var element = e.target.value;
                if(element[element.length-1] != "s"){
                    e.target.value = pluralize(0,e.target.value);
                }
            })
            function singularize(event) {
                word = event.target.value;
                const endings = {
                    ves: 'fe',
                    ies: 'y',
                    i: 'us',
                    zes: '',
                    ses: '',
                    es: '',
                    s: ''
                };
                event.target.value = word.replace(
                    new RegExp(`(${Object.keys(endings).join('|')})$`), 
                    r => endings[r]
                );
            }

            const pluralize = (val, word, plural = word + 's') => {
                const _pluralize = (num, word, plural = word + 's') =>
                    [1, -1].includes(Number(num)) ? word : plural;
                if (typeof val === 'object') return (num, word) => _pluralize(num, word, val[word]);
                return _pluralize(val, word, plural);
            };

            function firstUpper(event) {
                var words = event.target.value.split(/\s+/g);
                var newWords = words.map(function(element){
                    return element !== "" ?  element[0].toUpperCase() + element.substr(1, element.length) : "";
                });
                event.target.value = newWords.join("");
            }
         
            function allLower(event) {
                var words = event.target.value.toLowerCase().split(/\s+/g);
     
                event.target.value = words.join("");
                return event.target.value;
            }
            
            function slugFunction() {
				var x = document.getElementById("slugInput").value;
				document.getElementById("slugOutput").innerHTML = "{{ url('/page/') }}/" + convertToSlug(x);
			}
            function convertToSlug(Text)
            {
                return Text
                    .toLowerCase()
                    .replace(/ /g,'-')
                    .replace(/[^\w-]+/g,'')
                    ;
            }

        });


    </script>
@endpush
