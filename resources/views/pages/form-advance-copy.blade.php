@extends('backend.layouts.main') 
@section('title', 'Form Advance')
@section('content')
    <!-- push external head elements to head -->
    @push('head')

        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/summernote/dist/summernote-bs4.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">

    @endpush
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Advance')}}</h5>
                            <span>{{ __('lorem ipsum dolor sit amet, consectetur adipisicing elit')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('panel.dashboard')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">{{ __('Forms')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Advance')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Switches')}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-xl-4 mb-30">
                                <h4 class="sub-title">{{ __('Single Switche')}}</h4>
                                <input type="checkbox" class="js-single" checked />
                            </div>
                            <div class="col-sm-12 col-xl-4 mb-30">
                                <h4 class="sub-title">{{ __('Multiple Switches')}}</h4>
                                <input type="checkbox" class="js-switch" checked />
                                <input type="checkbox" class="js-switch" checked />
                                <input type="checkbox" class="js-switch" checked />
                            </div>
                            <div class="col-sm-12 col-xl-4 mb-30">
                                <h4 class="sub-title">{{ __('Enable Disable Switches')}}</h4>
                                <input type="checkbox" class="js-dynamic-state" checked />
                                <button class="btn btn-primary js-dynamic-enable">{{ __('Enable')}}</button>
                                <button class="btn btn-inverse js-dynamic-disable">{{ __('Disable')}}</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-8">
                                <h4 class="sub-title">{{ __('Color Switches')}}</h4>
                                <input type="checkbox" class="js-default" checked />
                                <input type="checkbox" class="js-primary" checked />
                                <input type="checkbox" class="js-success" checked />
                                <input type="checkbox" class="js-info" checked />
                                <input type="checkbox" class="js-warning" checked />
                                <input type="checkbox" class="js-danger" checked />
                                <input type="checkbox" class="js-inverse" checked />
                            </div>
                            <div class="col-sm-4">
                                <h4 class="sub-title">{{ __('Switch Sizes')}}</h4>
                                <input type="checkbox" class="js-large" checked />
                                <input type="checkbox" class="js-medium" checked />
                                <input type="checkbox" class="js-small" checked />
                                <input type="checkbox" class="js-large" checked />
                                <input type="checkbox" class="js-medium" checked />
                                <input type="checkbox" class="js-small" checked />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Radio')}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-xl-4 mb-30">
                                <h4 class="sub-title">{{ __('Radio Fill Button')}}</h4>
                                <div class="form-radio">
                                    <form>
                                        <div class="radio radio-inline">
                                            <label>
                                                <input type="radio" name="radio" checked="checked">
                                                <i class="helper"></i>{{ __('Radio 1')}}
                                            </label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <label>
                                                <input type="radio" name="radio">
                                                <i class="helper"></i>{{ __('Radio 2')}}
                                            </label>
                                        </div>
                                        <div class="radio radio-inline radio-disable">
                                            <label>
                                                <input type="radio" disabled="" name="radio">
                                                <i class="helper"></i>{{ __('Radio Disable')}}
                                            </label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-4 mb-30">
                                <h4 class="sub-title">{{ __('Radio outline Button')}}</h4>
                                <div class="form-radio">
                                    <form>
                                        <div class="radio radio-outline radio-inline">
                                            <label>
                                                <input type="radio" name="radio" checked="checked">
                                                <i class="helper"></i>{{ __('Radio 1')}}
                                            </label>
                                        </div>
                                        <div class="radio radio-outline radio-inline">
                                            <label>
                                                <input type="radio" name="radio">
                                                <i class="helper"></i>{{ __('Radio 2')}}
                                            </label>
                                        </div>
                                        <div class="radio radio-inline radio-disable">
                                            <label>
                                                <input type="radio" disabled="" name="radio">
                                                <i class="helper"></i>{{ __('Radio Disable')}}
                                            </label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-xl-4 mb-30">
                                <h4 class="sub-title">{{ __('Radio Button')}}</h4>
                                <div class="form-radio">
                                    <form>
                                        <div class="radio radiofill radio-inline">
                                            <label>
                                                <input type="radio" name="radio" checked="checked">
                                                <i class="helper"></i>{{ __('Radio-fill 1')}}
                                            </label>
                                        </div>
                                        <div class="radio radiofill radio-inline">
                                            <label>
                                                <input type="radio" name="radio">
                                                <i class="helper"></i>{{ __('Radio-fill 2')}}
                                            </label>
                                        </div>
                                        <div class="radio radiofill radio-inline radio-disable">
                                            <label>
                                                <input type="radio" disabled="" name="radio">
                                                <i class="helper"></i>{{ __('Radio-fill Disable')}}
                                            </label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <h4 class="sub-title">{{ __('Color Radio Button')}}</h4>
                        <div class="form-radio mb-30">
                            <form>
                                <div class="radio radiofill radio-default radio-inline">
                                    <label>
                                        <input type="radio" name="radio" checked="checked">
                                        <i class="helper"></i>{{ __('Default Color')}}
                                    </label>
                                </div>
                                <div class="radio radiofill radio-primary radio-inline">
                                    <label>
                                        <input type="radio" name="radio" checked="checked">
                                        <i class="helper"></i>{{ __('Primary Color')}}
                                    </label>
                                </div>
                                <div class="radio radiofill radio-success radio-inline">
                                    <label>
                                        <input type="radio" name="radio" checked="checked">
                                        <i class="helper"></i>{{ __('Success Color')}}
                                    </label>
                                </div>
                                <div class="radio radiofill radio-info radio-inline">
                                    <label>
                                        <input type="radio" name="radio" checked="checked">
                                        <i class="helper"></i>{{ __('Info Color')}}
                                    </label>
                                </div>
                                <div class="radio radiofill radio-warning radio-inline">
                                    <label>
                                        <input type="radio" name="radio" checked="checked">
                                        <i class="helper"></i>{{ __('Warning Color')}}
                                    </label>
                                </div>
                                <div class="radio radiofill radio-danger radio-inline">
                                    <label>
                                        <input type="radio" name="radio" checked="checked">
                                        <i class="helper"></i>{{ __('Danger Color')}}
                                    </label>
                                </div>
                                <div class="radio radiofill radio-inverse radio-inline">
                                    <label>
                                        <input type="radio" name="radio" checked="checked">
                                        <i class="helper"></i>{{ __('Inverse Color')}}
                                    </label>
                                </div>
                            </form>
                        </div>
                        <h4 class="sub-title">{{ __('Color Radio material Button')}}</h4>
                        <div class="form-radio mb-30">
                            <form>
                                <div class="radio radio-matrial radio-default radio-inline">
                                    <label>
                                        <input type="radio" name="radio" checked="checked">
                                        <i class="helper"></i>{{ __('Default Color')}}
                                    </label>
                                </div>
                                <div class="radio radio-matrial radio-primary radio-inline">
                                    <label>
                                        <input type="radio" name="radio" checked="checked">
                                        <i class="helper"></i>{{ __('Primary Color')}}
                                    </label>
                                </div>
                                <div class="radio radio-matrial radio-success radio-inline">
                                    <label>
                                        <input type="radio" name="radio" checked="checked">
                                        <i class="helper"></i>{{ __('Success Color')}}
                                    </label>
                                </div>
                                <div class="radio radio-matrial radio-info radio-inline">
                                    <label>
                                        <input type="radio" name="radio" checked="checked">
                                        <i class="helper"></i>{{ __('Info Color')}}
                                    </label>
                                </div>
                                <div class="radio radio-matrial radio-warning radio-inline">
                                    <label>
                                        <input type="radio" name="radio" checked="checked">
                                        <i class="helper"></i>{{ __('Warning Color')}}
                                    </label>
                                </div>
                                <div class="radio radio-matrial radio-danger radio-inline">
                                    <label>
                                        <input type="radio" name="radio" checked="checked">
                                        <i class="helper"></i>{{ __('Danger Color')}}
                                    </label>
                                </div>
                                <div class="radio radio-matrial radio-inverse radio-inline">
                                    <label>
                                        <input type="radio" name="radio" checked="checked">
                                        <i class="helper"></i>Inverse Color')}}
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>{{ __('Checkbox')}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-xl-6 mb-30">
                                <h4 class="sub-title">{{ __('Border Checkbox')}}</h4>
                                <div class="border-checkbox-section">
                                    <div class="border-checkbox-group border-checkbox-group-default">
                                        <input class="border-checkbox" type="checkbox" id="checkbox0">
                                        <label class="border-checkbox-label" for="checkbox0">{{ __('Do you like it?')}}</label>
                                    </div>
                                    <div class="border-checkbox-group border-checkbox-group-primary">
                                        <input class="border-checkbox" type="checkbox" id="checkbox1">
                                        <label class="border-checkbox-label" for="checkbox1">{{ __('Primary')}}</label>
                                    </div>
                                    <div class="border-checkbox-group border-checkbox-group-success">
                                        <input class="border-checkbox" type="checkbox" id="checkbox2">
                                        <label class="border-checkbox-label" for="checkbox2">{{ __('Success')}}</label>
                                    </div>
                                    <div class="border-checkbox-group border-checkbox-group-info">
                                        <input class="border-checkbox" type="checkbox" id="checkbox3">
                                        <label class="border-checkbox-label" for="checkbox3">{{ __('Info')}}</label>
                                    </div>
                                    <div class="border-checkbox-group border-checkbox-group-warning">
                                        <input class="border-checkbox" type="checkbox" id="checkbox4">
                                        <label class="border-checkbox-label" for="checkbox4">{{ __('Warning')}}</label>
                                    </div>
                                    <div class="border-checkbox-group border-checkbox-group-danger">
                                        <input class="border-checkbox" type="checkbox" id="checkbox5">
                                        <label class="border-checkbox-label" for="checkbox5">{{ __('Danger')}}</label>
                                    </div>
                                    <div class="border-checkbox-group">
                                        <input class="border-checkbox" type="checkbox" id="checkbox6" disabled>
                                        <label class="border-checkbox-label" for="checkbox6">{{ __('Disabled')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3>{{ __('Input Tag')}}</h3></div>
                    <div class="card-body">
                        <form action="">
                            <div class="form-group">
                                <label for="input">{{ __('Type to add a new tag')}}</label>
                                <input type="text" id="tags" class="form-control" value="London,Canada,Australia,Mexico,India">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header"><h3>{{ __('Form Repeater')}}</h3></div>
                    <div class="card-body">
                        <p>{{ __('Click the add button to repeat the form')}}</p>
                        <form class="form-inline repeater">
                            <div data-repeater-list="group-a">
                                <div data-repeater-item class="d-flex mb-2">
                                    <label class="sr-only" for="inlineFormInputGroup1">{{ __('Users')}}</label>
                                    <div class="form-group mb-2 mr-sm-2 mb-sm-0">
                                        <input type="text" class="form-control" placeholder="Name">
                                    </div>
                                    <div class="form-group mb-2 mr-sm-2 mb-sm-0">
                                        <input type="email" class="form-control" placeholder="Email">
                                    </div>
                                    <div class="form-group mb-2 mr-sm-2 mb-sm-0">
                                        <input type="tel" class="form-control" placeholder="Phone No">
                                    </div>
                                    <button data-repeater-delete type="button" class="btn btn-danger btn-icon ml-2" ><i class="ik ik-trash-2"></i></button>
                                </div>
                            </div>
                            <button data-repeater-create type="button" class="btn btn-success btn-icon ml-2 mb-2"><i class="ik ik-plus"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        
    </div>

    <!-- push external js -->
    @push('script')
        <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/summernote/dist/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
      
        <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
    @endpush
@endsection
    
