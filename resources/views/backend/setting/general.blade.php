@extends('backend.layouts.main')
@section('title', 'General Settings')
@section('content')
    @php
    $breadcrumb_arr = [['name' => 'Setting', 'url' => 'javascript:void(0);', 'class' => ''], ['name' => 'General', 'url' => 'javascript:void(0);', 'class' => 'active']];
    @endphp
    <style>
        .radio-toolbar-cus {
            margin: 10px;
        }

        .radio-toolbar-cus input[type="radio"] {
            opacity: 0;
            position: fixed;
            width: 0;
        }

        .radio-toolbar-cus label {
            display: inline-block;
            background-color: #ddd;
            margin-top: 0;
            padding: 6px 12px;
            font-family: sans-serif, Arial;
            font-size: 14px;
            border: 2px solid rgb(255, 255, 255);
            border-radius: 4px;
        }

        .radio-toolbar-cus label:hover {
            background-color: rgb(194, 192, 192);
        }

        .radio-toolbar-cus input[type="radio"]:focus+label {
            border: 2px #444;
            background: #444;
        }

        .radio-toolbar-cus input[type="radio"]:checked+label {
            background-color: rgb(13, 110, 253);
            color: #ffffff;
            border: #444;
        }

    </style>
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('General Setting') }}</h5>
                            {{-- <span>{{ __('This setting will be automatically updated in your website.') }}</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div>
                        {{-- <a style="margin-left: 129px;" class="btn btn-icon btn-sm btn-outline-success" href="#" data-toggle="modal" data-target="#siteModal"><i
                            class="fa fa-info"></i></a> --}}
                        @include('backend.include.breadcrumb')
                    </div>
                    @include('backend.setting.sitemodal', [
                        'title' => 'How to use',
                        'content' =>
                            'You need to create a unique code and call the unique code with paragraph content helper.',
                    ])
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card card-484">
                    <div role="tabpanel">
                        <div class="card-header" style="border:none;">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a href="#general" class="nav-link active" aria-controls="general" role="tab"
                                        data-toggle="tab">General</a>
                                </li>

                                <li class="nav-item">
                                    <a href="#currency" class="nav-link" aria-controls="currency" role="tab"
                                        data-toggle="tab">Currency</a>
                                </li>

                                <li class="nav-item">
                                    <a href="#datetime" class="nav-link" aria-controls="datetime" role="tab"
                                        data-toggle="tab">Date & Time</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#verification" class="nav-link" aria-controls="verification" role="tab"
                                        data-toggle="tab">Verification</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#troubleshoot" class="nav-link" aria-controls="troubleshoot" role="tab"
                                        data-toggle="tab">Troubleshoot</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="#plugins" class="nav-link" aria-controls="plugins" role="tab"
                                        data-toggle="tab">Plugins</a>
                                </li> --}}
                            </ul>
                        </div>
                        <div class="card-body pt-0">
                            <div class="tab-content">

                                <!--tab panel general-->
                                <div role="tabpanel" class="tab-pane fade show active pt-3" id="general"
                                    aria-labelledby="general-tab">

                                    <form class="forms-sample" action="{{ route('panel.setting.general.store') }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="group_name" value="{{ 'general_setting' }}">
                                        <div class="form-group row">
                                            <label for="exampleInputUsername2"
                                                class="col-sm-3 col-form-label">{{ __('App Name') }}<span
                                                    class="text-red">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="app_name" class="form-control"
                                                    placeholder="App Name" required
                                                    value="{{ getSetting('app_name') }}" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputUsername2"
                                                class="col-sm-3 col-form-label">{{ __('Site Motto') }}<span
                                                    class="text-red">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" name="site_motto" class="form-control" required
                                                    value="{{ getSetting('site_motto') }}"
                                                    placeholder="Best eCommerce Website">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputEmail2"
                                                class="col-sm-3 col-form-label">{{ __('App Url') }}<span
                                                    class="text-danger">*</label>
                                            <div class="col-sm-9">
                                                <input type="url" name="app_url" class="form-control" required
                                                    value="{{ getSetting('app_url') }}" placeholder="App Url">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputUsername2"
                                                class="col-sm-3 col-form-label">{{ __('Global Meta Title') }}<span
                                                    class="text-danger">*</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="global_meta_title" class="form-control" required
                                                    value="{{ getSetting('global_meta_title') }}"
                                                    placeholder="Global Meta Title">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="logo"
                                                class="col-sm-3 col-form-label">{{ __('App Logo') }}</label>
                                            <div class="col-sm-9">
                                                <input type="file" name="app_logo" class="file-upload-default">
                                                <div class="input-group col-xs-12">
                                                    <input type="text" class="form-control file-upload-info" disabled
                                                        placeholder="Upload Logo">
                                                    <span class="input-group-append">
                                                        <button class="file-upload-browse btn btn-success"
                                                            type="button">{{ __('Upload') }}</button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3"> </div>
                                            <div class="col-sm-9">
                                                <div class="card m-0 p-2">
                                                    <div class="mx-auto">
                                                        <img src="{{ asset('storage/backend/logos/' . getSetting('app_logo')) }}"
                                                            alt="App Logo" width="120px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="logo"
                                                class="col-sm-3 col-form-label">{{ __('White Logo') }}</label>
                                            <div class="col-sm-9">
                                                <input type="file" name="app_white_logo" class="file-upload-default">
                                                <div class="input-group col-xs-12">
                                                    <input type="text" class="form-control file-upload-info" disabled
                                                        placeholder="Upload Logo">
                                                    <span class="input-group-append">
                                                        <button class="file-upload-browse btn   btn-success"
                                                            type="button">{{ __('Upload') }}
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-9">
                                                <div class="card m-0 p-2">
                                                    <div class="mx-auto">
                                                        <img src="{{ asset('storage/backend/logos/' . getSetting('app_white_logo')) }}"
                                                            alt="App White Logo" width="120px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="logo"
                                                class="col-sm-3 col-form-label">{{ __('App Favicon') }}</label>
                                            <div class="col-sm-9">
                                                <input type="file" name="app_favicon" class="file-upload-default">
                                                <div class="input-group col-xs-12">
                                                    <input type="text" class="form-control file-upload-info" disabled
                                                        placeholder="Upload Favicon">
                                                    <span class="input-group-append">
                                                        <button class="file-upload-browse btn btn-success"
                                                            type="button">{{ __('Upload') }}</button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-9">
                                                <div class="card m-0 p-2">
                                                    <div class="mx-auto">
                                                        <img src="{{ asset('storage/backend/logos/' . getSetting('app_favicon')) }}"
                                                            alt="Favicon" width="40px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="logo" class="col-sm-3 col-form-label">{{ __('App Banner - I') }}
                                                <small>(Login Page Background Image)</small></label>
                                            <div class="col-sm-9">
                                                <input type="file" name="app_banner" class="file-upload-default">
                                                <div class="input-group col-xs-12">
                                                    <input type="text" class="form-control file-upload-info" disabled
                                                        placeholder="Upload Banner Image">
                                                    <span class="input-group-append">
                                                        <button class="file-upload-browse btn btn-success"
                                                            type="button">{{ __('Upload') }}</button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-9">
                                                <div class="card m-0 p-2">
                                                    <div class="mx-auto">
                                                        <img src="{{ asset('storage/backend/logos/' . getSetting('app_banner')) }}"
                                                            alt="App Banner - I" width="80px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="logo" class="col-sm-3 col-form-label">{{ __('App Banner - II') }}
                                                <small>(Regisgter and Forgot Page Background Image)</small></label>
                                            <div class="col-sm-9">
                                                <input type="file" name="app_banner_i" class="file-upload-default">
                                                <div class="input-group col-xs-12">
                                                    <input type="text" class="form-control file-upload-info" disabled
                                                        placeholder="Upload Banner Image">
                                                    <span class="input-group-append">
                                                        <button class="file-upload-browse btn btn-success"
                                                            type="button">{{ __('Upload') }}</button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-9">
                                                <div class="card m-0 p-2">
                                                    <div class="mx-auto">
                                                        <img src="{{ asset('storage/backend/logos/' . getSetting('app_banner_i')) }}"
                                                            alt="App Banner - II" width="80px">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputUsername2"
                                                class="col-sm-3 col-form-label">{{ __('Language') }}</label>
                                            <div class="col-sm-9">
                                                <select name="app_language" class="form-control" id="lang" required>
                                                    <option value="en">English</option>
                                                </select>
                                            </div>
                                        </div>
                                        {{-- <div class="form-group row">
                                            <label for="exampleInputUsername2"
                                                class="col-sm-3 col-form-label">{{ __('Maintainance Mode') }}</label>
                                            <div class="col-sm-9">
                                                <select name="maintainance_mode" class="form-control" required>
                                                    <option value="1">ON</option>
                                                    <option value="0">OFF</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputUsername2"
                                                class="col-sm-3 col-form-label">{{ __('Notifications') }}</label>
                                            <div class="col-sm-9">
                                                <select name="notification" class="form-control" required>
                                                    <option value="1"
                                                        {{ getSetting('notification') == '1' ? 'selected' : '' }}>Enable
                                                    </option>
                                                    <option value="0"
                                                        {{ getSetting('notification') == '0' ? 'selected' : '' }}>Disable
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputUsername2"
                                                class="col-sm-3 col-form-label">{{ __('ReCaptcha') }}</label>
                                            <div class="col-sm-9">
                                                <select name="recaptcha" class="form-control" required>
                                                    <option value="1"
                                                        {{ getSetting('recaptcha') == '1' ? 'selected' : '' }}>Enable
                                                    </option>
                                                    <option value="0"
                                                        {{ getSetting('recaptcha') == '0' ? 'selected' : '' }}>Disable
                                                    </option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="card-footer text-right">
                                            <button type="submit"
                                                class="btn btn-primary mr-2">{{ __('Update') }}</button>
                                        </div>
                                    </form>

                                </div>
                                <!--tab panel general-->

                                <!--tab panel currency-->
                                <div role="tabpanel" class="tab-pane fade show pt-3" id="currency"
                                    aria-labelledby="currency-tab">
                                    <form class="forms-sample" action="{{ route('panel.setting.currency.store') }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="group_name" value="{{ 'general_setting_currency' }}">
                                        <div class="form-group row">
                                            <label for="exampleInputUsername2"
                                                class="col-sm-3 col-form-label">{{ __('Select Currency') }}<span
                                                    class="text-red">*</span>
                                            </label>
                                            <div class="col-sm-9">
                                                <select required name="app_currency" class="form-control" id="currency">
                                                    @foreach (config('currencies') as $currency)
                                                        <option value="{{ $currency['symbol'] }}"
                                                            {{ $currency['symbol'] == getSetting('app_currency') ? 'selected' : '' }}>
                                                            {{ $currency['symbol'] . ' - ' . $currency['name'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex m-0">
                                            <label for="thousand_separator"
                                                class="col-sm-3 pl-0 col-form-label">{{ __('Number Of Decimals') }}<span
                                                    class="text-red">*</span>
                                            </label>
                                            <select required name="no_of_decimal" class="form-control" id="">
                                                <option value="0"
                                                    {{ getSetting('no_of_decimal') == 0 ? ' selected' : '' }}>1234
                                                </option>
                                                <option value="1"
                                                    {{ getSetting('no_of_decimal') == 1 ? ' selected' : '' }}>123.4
                                                </option>
                                                <option value="2"
                                                    {{ getSetting('no_of_decimal') == 2 ? ' selected' : '' }}>12.34
                                                </option>
                                                <option value="3"
                                                    {{ getSetting('no_of_decimal') == 3 ? ' selected' : '' }}>1.234
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group d-flex m-0">
                                            <label for="decimal_separator"
                                                class="col-sm-3 pl-0 col-form-label">{{ __('Decimal separator') }}</label>
                                            <div class="radio-toolbar-cus col-sm-9 m-0 pl-1 col-form-label">
                                                <input type="radio" id="radiodot" name="decimal_separator" value="1"
                                                    @if (getSetting('decimal_separator') == 1) checked @endif>
                                                <label for="radiodot">DOT(.)</label>

                                                <input type="radio" id="radiocomma" name="decimal_separator" value="2"
                                                    @if (getSetting('decimal_separator') == 2) checked @endif>
                                                <label for="radiocomma">COMMA(,)</label>
                                            </div>
                                        </div>
                                        <div class="form-group d-flex m-0">
                                            <label for="currency_positon"
                                                class="col-sm-3 pl-0 col-form-label">{{ __('Currency position') }}</label>
                                            <div class="radio-toolbar-cus col-sm-9 m-0 pl-1 col-form-label">
                                                <input type="radio" id="radioposition1" name="currency_position" value="1"
                                                    @if (getSetting('currency_position') == 1) checked @endif>
                                                <label for="radioposition1">$1,100.00</label>
                                                <input type="radio" id="radioposition4" name="currency_position" value="2"
                                                    @if (getSetting('currency_position') == 2) checked @endif>
                                                <label for="radioposition4">1,100 $</label>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit"
                                                class="btn btn-primary mr-2">{{ __('Update') }}</button>
                                        </div>
                                    </form>
                                </div>
                                <!--tab panel currency-->

                                <!--tab panel datetime-->
                                <div role="tabpanel" class="tab-pane fade show pt-3" id="datetime"
                                    aria-labelledby="datetime-tab">
                                    <form class="forms-sample" action="{{ route('panel.setting.dnt.store') }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="group_name" value="{{ 'general_setting_date_time' }}">
                                        <div class="form-group d-flex">
                                            <label for="" class="col-sm-3">{{ __('Date format') }}<span
                                                    class="text-red">*</span>
                                            </label>
                                            <select required name="date_format" class="form-control select2 col-sm-9">
                                                <option value="" readonly>{{ __('Select Date Format') }}</option>
                                                @foreach (getDateFormat() as $index => $item)
                                                    <option value="{{ $item['id'] }}"
                                                        {{ getSetting('date_format') == $item['id'] ? ' selected="selected"' : '' }}>
                                                        {{ $item['name'] }} | {{ $item['ex'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group d-flex">
                                            <label for="" class="col-sm-3">{{ __('Date/Time format') }}<span class="text-red">*</span>
                                            </label>
                                            <select required name="date_time_format" class="form-control select2 col-sm-9" style="overflow: auto">
                                                <option value="" readonly>{{ __('Select Date Format') }}</option>
                                                @foreach (getDateTimeFormat() as $index => $item)
                                                    <option value="{{ $item['id'] }}"
                                                        {{ getSetting('date_time_format') == $item['id'] ? ' selected="selected"' : '' }}>
                                                        {{ $item['name'] }} | {{ $item['ex'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group d-flex ">
                                            <label for="" class="col-sm-3">{{ __('Time Zone') }}<span
                                                    class="text-red">*</span>
                                            </label>
                                            <select required name="time_zone" class="form-control select2 col-sm-9">
                                                @foreach (config('time-zone') as $zone)
                                                    <option value="{{ $zone['name'] }}"
                                                        {{ getSetting('time_zone') == $zone['name'] ? ' selected' : '' }}>
                                                        {{ $zone['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit"
                                                class="btn btn-primary mr-2">{{ __('Update') }}</button>
                                        </div>
                                    </form>
                                </div>
                                <!--tab panel datetime-->

                                <!--tab panel verification-->
                                <div role="tabpanel" class="tab-pane fade show pt-3" id="verification"
                                    aria-labelledby="verification-tab">
                                    <form class="forms-sample"
                                        action="{{ route('panel.setting.verification.store') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="group_name"
                                            value="{{ 'general_setting_verification' }}">
                                        <div class="form-group row">
                                            <label for="exampleInputUsername2"
                                                class="col-sm-3 col-form-label">{{ __('Email Verification') }}</label>
                                            <div class="col-sm-9">
                                                <select name="email_verify" class="form-control" id="email">
                                                    <option value="1"
                                                        {{ getSetting('email_verify') == '1' ? ' selected' : '' }}>ON
                                                    </option>
                                                    <option value="0"
                                                        {{ getSetting('email_verify') == '0' ? ' selected' : '' }}>OFF
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="exampleInputUsername2"
                                                class="col-sm-3 col-form-label">{{ __('SMS Verification') }}</label>
                                            <div class="col-sm-9">
                                                <select name="sms_verify" class="form-control" id="sms">
                                                    <option value="1"
                                                        {{ getSetting('sms_verify') == '1' ? ' selected' : '' }}>ON
                                                    </option>
                                                    <option value="0"
                                                        {{ getSetting('sms_verify') == '0' ? ' selected' : '' }}>OFF
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit"
                                                class="btn btn-primary mr-2">{{ __('Update') }}</button>
                                        </div>
                                    </form>
                                </div>
                                <!--tab panel verification-->

                                <!--tab panel troubleshoot-->
                                <div role="tabpanel" class="tab-pane fade show pt-3" id="troubleshoot"
                                    aria-labelledby="troubleshoot-tab">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <div class="card troubleshoot bg-light">
                                                <h4>Storage Link</h4>
                                                <p>This will remove old storage and create a new storage link.
                                                </p>
                                                <a href="{{ route('panel.setting.storage_link') }}"
                                                    class="btn btn-outline-dark">{{ __('Storage Link') }}</a>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card troubleshoot bg-light">
                                                <h4>Optimize Clear</h4>
                                                <p>This will clear your project cache and provides you high performance.</p>
                                                <a href="{{ route('panel.setting.optimize_clear') }}"
                                                    class="btn btn-outline-dark">{{ __('Optimize Clear') }}</a>
                                            </div>
                                        </div>
                                        {{-- <div class="col-md-4">
                                            <div class="card troubleshoot bg-light">
                                                <h4>Backup</h4>
                                                <p>This untility provide you ability to download letest database.</p>
                                                <a href="{{ route('panel.setting.backup') }}"
                                                    class="btn btn-outline-dark">{{ __('Downlode Now') }}</a>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                                <!--tab panel troubleshoot-->

                                <!--tab panel plugins-->
                                {{-- <div role="tabpanel" class="tab-pane fade show pt-3" id="plugins"
                                    aria-labelledby="plugins-tab">
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <form action="{{ route('panel.setting.plugin.store') }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="group_name" value="{{ 'custom_plugin' }}">
                                                <div class="form-group">
                                                    <label for="plugin_css">Plugin CSS</label>
                                                    <textarea class="form-control" id="plugin_css" name="plugin_css" rows="3"
                                                        placeholder="Enter Plugin Css">{{ getSetting('plugin_css') }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="plugin_script">Java Script</label>
                                                    <textarea class="form-control" id="plugin_script" name="plugin_script" rows="3"
                                                        placeholder="Enter Java Script">{{ getSetting('plug_script') }}</textarea>
                                                </div>
                                                <div class=" text-right">
                                                    <button type="submit"
                                                        class="btn btn-primary mr-2">{{ __('Update') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> --}}
                                <!--tab panel plugins-->

                            </div>
                            <!--tab content-->
                        </div>
                    </div>
                    <!--tab panel-->
                </div>
            </div>
        </div>
    </div>

    <!-- push external js -->
@endsection
