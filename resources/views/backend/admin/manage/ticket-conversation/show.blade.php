@extends('backend.layouts.main') 
@section('title', 'Ticket Conversation')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'View Ticket Conversation', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>{{ __('View Ticket Conversation')}}</h5>
                            <span>{{ __('View a record for Ticket Conversation')}}</span>
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
                        <h3>Ticket Conversation</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $ticket_conver->id }}</td>
                                    </tr>
                                    <tr><th> Ticket </th>
                                        <td> {{ fetchFirst('App\Models\Ticket',$ticket_conver->ticket_id,'name','') }} </td>
                                    </tr>
                                    <tr>
                                        <th> User </th>
                                        <td> {{ NameById($ticket_conver->user_id) }} </td>
                                    </tr>
                                    <tr>
                                        <th> Commnet </th>
                                        <td> {{ $ticket_conver->comment }} </td>
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
