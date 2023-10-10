@extends('backend.layouts.main') 
@section('title', 'Case Workstream Message')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'View Case Workstream Message', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('View Case Workstream Message')}}</h5>
                            <span>{{ __('View a record for Case Workstream Message')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            @include('backend.include.message')
            <!-- end message area-->
            <div class="col-md-12 mx-auto">
                <div class="card ">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Case Workstream Message</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $user_enq->id }}</td>
                                    </tr>
                                    <tr>
                                        <th> Name </th>
                                        <td> {{ $user_enq->name }} </td>
                                    </tr>
                                    <tr>
                                        <th> Category </th>
                                        <td>{{fetchFirst('App\Models\Category',$user_enq->category_id,'name','--') }}</td>
                                    </tr>
                                    <tr>
                                        <th> Email </th>
                                        <td> {{ $user_enq->email }} </td>
                                    </tr>
                                    <tr>
                                        <th> Subject </th>
                                        <td> {{ $user_enq->subject }} </td>
                                    </tr>
                                    <tr>
                                        <th> Contact No. </th>
                                        <td> {{ $user_enq->contact_number }} </td>
                                    </tr>
                                    <tr>
                                        <th> Status </th>
                                        <td> {{ $user_enq->status == 0 ? 'Pending' : ''}}
                                            {{ $user_enq->status == 1 ? 'Solved' : ''}} </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    @endpush
@endsection
