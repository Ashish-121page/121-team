@extends('backend.layouts.main') 
@section('title', 'Buttons')
@section('content')
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-box bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Buttons')}}</h5>
                            <span>{{ __('lorem ipsum dolor sit amet, consectetur adipisicing elit')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{route('panel.dashboard')}}rd')}}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('UI')}}</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Basic')}}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Buttons')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-header"><h3>{{ __('Normal buttons')}}</h3></div>
                            <div class="card-body template-demo">
                                <button type="button" class="btn btn-primary">{{ __('Primary')}}</button>
                                <button type="button" class="btn btn-secondary">{{ __('Secondary')}}</button>
                                <button type="button" class="btn btn-success">{{ __('Success')}}</button>
                                <button type="button" class="btn btn-danger">{{ __('Danger')}}</button>
                                <button type="button" class="btn btn-warning">{{ __('Warning')}}</button>
                                <button type="button" class="btn btn-info">{{ __('Info')}}</button>
                                <button type="button" class="btn btn-light">{{ __('Light')}}</button>
                                <button type="button" class="btn btn-dark">{{ __('Dark')}}</button>
                                <button type="button" class="btn btn-link">{{ __('Link')}}</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-header"><h3>{{ __('Fab Buttons')}}</h3></div>
                            <div class="card-body template-demo">
                                <button type="button" class="btn btn-icon btn-dark"><i class="ik ik-image"></i></button>
                                <button type="button" class="btn btn-icon btn-secondary"><i class="ik ik-settings"></i></button>
                                <button type="button" class="btn btn-icon btn-success"><i class="ik ik-mail"></i></button>
                                <button type="button" class="btn btn-icon btn-primary"><i class="ik ik-star"></i></button>
                                <button type="button" class="btn btn-icon btn-warning"><i class="ik ik-map-pin"></i></button>
                                <button type="button" class="btn btn-icon btn-info"><i class="ik ik-refresh-cw"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-header"><h3>{{ __('Outlined buttons')}}</h3></div>
                            <div class="card-body template-demo">
                                <button type="button" class="btn btn-outline-primary">{{ __('Primary')}}</button>
                                <button type="button" class="btn btn-outline-secondary">{{ __('Secondary')}}</button>
                                <button type="button" class="btn btn-outline-success">{{ __('Success')}}</button>
                                <button type="button" class="btn btn-outline-danger">{{ __('Danger')}}</button>
                                <button type="button" class="btn btn-outline-warning">{{ __('Warning')}}</button>
                                <button type="button" class="btn btn-outline-info">{{ __('Info')}}</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-header"><h3>{{ __('Rounded Outlines')}}</h3></div>
                            <div class="card-body template-demo">
                                <button type="button" class="btn btn-icon btn-outline-dark"><i class="ik ik-image"></i></button>
                                <button type="button" class="btn btn-icon btn-outline-secondary"><i class="ik ik-settings"></i></button>
                                <button type="button" class="btn btn-icon btn-outline-success"><i class="ik ik-mail"></i></button>
                                <button type="button" class="btn btn-icon btn-outline-primary"><i class="ik ik-star"></i></button>
                                <button type="button" class="btn btn-icon btn-outline-warning"><i class="ik ik-map-pin"></i></button>
                                <button type="button" class="btn btn-icon btn-outline-info"><i class="ik ik-refresh-cw"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-header"><h3>{{ __('Rounded filled Buttons')}}</h3></div>
                            <div class="card-body template-demo">
                                <button type="button" class="btn btn-primary btn-rounded">{{ __('Primary')}}</button>
                                <button type="button" class="btn btn-secondary btn-rounded">{{ __('Secondary')}}</button>
                                <button type="button" class="btn btn-success btn-rounded">{{ __('Success')}}</button>
                                <button type="button" class="btn btn-danger btn-rounded">{{ __('Danger')}}</button>
                                <button type="button" class="btn btn-warning btn-rounded">{{ __('Warning')}}</button>
                                <button type="button" class="btn btn-info btn-rounded">{{ __('Info')}}</button>
                                <button type="button" class="btn btn-light btn-rounded">{{ __('Light')}}</button>
                                <button type="button" class="btn btn-dark btn-rounded">{{ __('Dark')}}</button>
                                <button type="button" class="btn btn-link btn-rounded">{{ __('Link')}}</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-header"><h3>{{ __('Rounded Outlines')}}</h3></div>
                            <div class="card-body template-demo">
                                <button type="button" class="btn btn-outline-primary btn-rounded">{{ __('Primary')}}</button>
                                <button type="button" class="btn btn-outline-secondary btn-rounded">{{ __('Secondary')}}</button>
                                <button type="button" class="btn btn-outline-success btn-rounded">{{ __('Success')}}</button>
                                <button type="button" class="btn btn-outline-danger btn-rounded">{{ __('Danger')}}</button>
                                <button type="button" class="btn btn-outline-warning btn-rounded">{{ __('Warning')}}</button>
                                <button type="button" class="btn btn-outline-info btn-rounded">{{ __('Info')}}</button>
                                <button type="button" class="btn btn-outline-light btn-rounded">{{ __('Light')}}</button>
                                <button type="button" class="btn btn-outline-dark btn-rounded">{{ __('Dark')}}</button>
                                <button type="button" class="btn btn-outline-link btn-rounded">{{ __('Link')}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-header"><h3>{{ __('Button Block')}}</h3></div>
                            <div class="card-body template-demo">
                                <button type="button" class="btn btn-info btn-block">{{ __('Block Button')}}</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-header"><h3>{{ __('Icons Buttons')}}</h3></div>
                            <div class="card-body template-demo">
                                <button type="button" class="btn btn-light"><i class="ik ik-heart"></i>{{ __('Default')}}</button>
                                <button type="button" class="btn btn-primary"><i class="ik ik-star"></i>{{ __('Primary')}}</button>
                                <button type="button" class="btn btn-success"><i class="ik ik-check-circle"></i>{{ __('Success')}}</button>
                                <button type="button" class="btn btn-secondary"><i class="ik ik-clipboard"></i>{{ __('Submit')}}</button>
                                <button type="button" class="btn btn-dark"><i class="ik ik-edit-2"></i>{{ __('Edit')}}</button>
                                <button type="button" class="btn btn-danger"><i class="ik ik-info"></i>{{ __('Warning')}}</button>
                                <button type="button" class="btn btn-info"><i class="ik ik-share"></i>{{ __('Upload')}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-header"><h3>{{ __('Grouped buttons')}}</h3></div>
                            <div class="card-body template-demo">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-outline-secondary">1</button>
                                    <button type="button" class="btn btn-outline-secondary">2</button>
                                    <button type="button" class="btn btn-outline-secondary">3</button>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-primary">1</button>
                                    <button type="button" class="btn btn-primary">2</button>
                                    <button type="button" class="btn btn-primary">3</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-header"><h3>{{ __('Social Buttons')}}</h3></div>
                            <div class="card-body template-demo">
                                <button type="button" class="btn social-btn btn-facebook"><i class="fab fa-facebook-f"></i></button>
                                <button type="button" class="btn social-btn btn-twitter"><i class="fab fa-twitter"></i></button>
                                <button type="button" class="btn social-btn btn-dribbble"><i class="fab fa-dribbble"></i></button>
                                <button type="button" class="btn social-btn btn-linkedin"><i class="fab fa-linkedin"></i></button>
                                <button type="button" class="btn social-btn btn-google"><i class="fab fa-google"></i></button>
                                <button type="button" class="btn social-btn btn-youtube"><i class="fab fa-youtube"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-header">
                                <h3>Group Button</h3>
                            </div>
                            <div class="card-body d-flex">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                      Dropdown button
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                      <li><a class="dropdown-item" href="#">Action</a></li>
                                      <li><a class="dropdown-item" href="#">Another action</a></li>
                                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                                {{-- linkable --}}
                                <div class="dropdown">
                                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                      Dropdown link
                                    </a>
                                  
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                      <li><a class="dropdown-item" href="#">Action</a></li>
                                      <li><a class="dropdown-item" href="#">Another action</a></li>
                                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                                {{-- split Button --}}
                                <!-- Example split danger button -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-danger">Action</button>
                                    <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Separated link</a></li>
                                    </ul>
                                </div>
                                {{-- dark Button --}}
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                      Dropdown button
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
                                      <li><a class="dropdown-item active" href="#">Action</a></li>
                                      <li><a class="dropdown-item" href="#">Another action</a></li>
                                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                                      <li><hr class="dropdown-divider"></li>
                                      <li><a class="dropdown-item" href="#">Separated link</a></li>
                                    </ul>
                                </div>
                                {{-- DropRight --}}
                                <!-- Default dropend button -->
                                <div class="btn-group dropend">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    Dropright
                                    </button>
                                    <ul class="dropdown-menu">
                                    <!-- Dropdown menu links -->
                                    </ul>
                                </div>
                                
                                <!-- Split dropend button -->
                                <div class="btn-group dropend">
                                    <button type="button" class="btn btn-secondary">
                                    Split dropend
                                    </button>
                                    <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropright</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                    <!-- Dropdown menu links -->
                                    </ul>
                                </div>
                                {{-- Responsive Alignment --}}
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                      Left-aligned but right aligned when large screen
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-lg-end">
                                      <li><button class="dropdown-item" type="button">Action</button></li>
                                      <li><button class="dropdown-item" type="button">Another action</button></li>
                                      <li><button class="dropdown-item" type="button">Something else here</button></li>
                                    </ul>
                                  </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-header"><h3>{{ __('Grouped buttons')}}</h3></div>
                            <div class="card-body template-demo">
                                {{-- <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Tutorials
                                    <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                      <li><a tabindex="-1" href="#">HTML</a></li>
                                      <li><a tabindex="-1" href="#">CSS</a></li>
                                      <li class="dropdown-submenu">
                                        <a class="test" tabindex="-1" href="#">New dropdown <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                          <li><a tabindex="-1" href="#">2nd level dropdown</a></li>
                                          <li><a tabindex="-1" href="#">2nd level dropdown</a></li>
                                          <li class="dropdown-submenu">
                                            <a class="test" href="#">Another dropdown <span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                              <li><a href="#">3rd level dropdown</a></li>
                                              <li><a href="#">3rd level dropdown</a></li>
                                            </ul>
                                          </li>
                                        </ul>
                                      </li>
                                    </ul>
                                </div> --}}
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Dropdown
                                    </button>
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        <li class="dropdown-item"><a href="#">Some action</a></li>
                                        <li class="dropdown-item"><a href="#">Some other action</a></li>
                                        <li class="dropdown-divider"></li>
                                        <li class="dropdown-submenu">
                                          <a  class="dropdown-item" tabindex="-1" href="#">Hover me for more options</a>
                                          <ul class="dropdown-menu">
                                            <li class="dropdown-item"><a tabindex="-1" href="#">Second level</a></li>
                                            <li class="dropdown-submenu">
                                              <a class="dropdown-item" href="#">Even More..</a>
                                              <ul class="dropdown-menu">
                                                  <li class="dropdown-item"><a href="#">3rd level</a></li>
                                                    <li class="dropdown-submenu"><a class="dropdown-item" href="#">another level</a>
                                                    <ul class="dropdown-menu">
                                                        <li class="dropdown-item"><a href="#">4th level</a></li>
                                                        <li class="dropdown-item"><a href="#">4th level</a></li>
                                                        <li class="dropdown-item"><a href="#">4th level</a></li>
                                                    </ul>
                                                  </li>
                                                    <li class="dropdown-item"><a href="#">3rd level</a></li>
                                              </ul>
                                            </li>
                                            <li class="dropdown-item"><a href="#">Second level</a></li>
                                            <li class="dropdown-item"><a href="#">Second level</a></li>
                                          </ul>
                                        </li>
                                      </ul>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Dropdown
                                    </button>
                                    <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        <li class="dropdown-item"><a href="#">Some action</a></li>
                                        <li class="dropdown-item"><a href="#">Some other action</a></li>
                                      </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
                