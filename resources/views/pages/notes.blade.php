@extends('backend.layouts.main') 
@section('title', 'Dev Notes')
@section('content')

    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-edit bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Notes')}}</h5>
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
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Notes')}}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header"><h3>{{ __('Notes')}}</h3></div>
                    <div class="card-body">
                        <ul>
                            <li><strong>For changing env file:</strong> Take reference from : <a href="https://github.com/JackieDo/Laravel-Dotenv-Editor">click here</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <!-- push external js -->
    @push('script')
        <script src="{{ asset('backend/js/form-components.js') }}"></script>
    @endpush
@endsection