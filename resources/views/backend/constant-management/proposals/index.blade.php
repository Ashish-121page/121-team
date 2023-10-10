@extends('backend.layouts.main')
@section('title', 'Manage Proposals')
@section('content')
<!-- push external head elements to head -->
@push('head')
@endpush
    @php
        $breadcrumb_arr = [
            ['name'=>'Manage', 'url'=> "javascript:void(0);", 'class' => ''],
            ['name'=>'Proposals', 'url'=> "javascript:void(0);", 'class' => 'active']
        ]
    @endphp
<div class="container-fluid">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-8">
                <div class="page-header-title">
                    <i class="ik ik-mail bg-blue"></i>
                    <div class="d-inline">
                        <h5>{{ __('Manage Proposals')}}</h5>
                        {{-- <span>{{ __('List of Article')}}</span> --}}
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                @include("backend.include.breadcrumb")
            </div>
        </div>
    </div>

    <form action="{{ route('panel.constant_management.article.index')}}" method="GET" id="TableForm">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex flex-wrap justify-content-between">
                            <div class="col flex-grow-1">
                                <h3>{{ __('Proposals')}}</h3>
                            </div>
                                
                            <div class="d-flex flex-wrap justicy-content-right">
                                <div class="form-group mb-0 mr-2 mt-3 mt-lg-0">
                                    <span>From</span>
                                    <label for=""><input type="date" name="from" class="form-control" value="{{request()->get('from')}}"></label>
                                {{-- <label for="From" class="control-label"><input type="date" name="from" class="form-control"> --}}
                                </div>
                                <div class="form-group mb-0 mr-2"> 
                                    <span>To</span>
                                    <label for=""><input type="date" name="to" class="form-control" value="{{ request()->get('to')}}"></label> 
                                    {{-- <label for="To" class="control-label"><input type="date" name="to" class="form-control"> --}}
                                </div>
                                    
                                <div class="form-group mb-0 mr-2">
                                    <select id="type" name="type" class="select2 form-control course-filter">
                                        <option readonly value="">{{ __('Type') }}</option>
                                        @foreach (fetchGet('App\Models\Category', 'where', 'category_type_id', '=', 6) as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == request()->get('type') ? 'selected': ''}}>{{ $item->name }}</option> 
                                        {{-- <option value="{{ $item->id }}">{{ $item->name }}</option>  --}}
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                <a href="javascript:void(0)" id="reset" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                {{-- <a href="javascript:void(0)"  </a> --}}

                                
                                {{-- <a href="javascript:void(0)" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></a>
                                <a href="{{ route('panel.constant_management.article.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Filter"><i class="fa fa-plus" aria-hidden="true"></i></a> --}}
                    
                            </div>
                        </div>
                        <div id="ajax-container">
                            @include('backend.constant-management.proposals.load')
                        </div>
                    </div>
                </div>
            </div>
        </form>




</div>
<!-- push external js -->


@push('script')
@endpush
@endsection
