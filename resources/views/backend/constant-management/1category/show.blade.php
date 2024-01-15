@extends('backend.layouts.main') 
@section('title', 'Mail SMS Template')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'View Mail SMS Template', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>{{ __('View Mail SMS Template')}}</h5>
                            {{-- <span>{{ __('View a record for Mail SMS Template')}}</span> --}}
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
                        <h3>Mail SMS Template</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $mail_sms->id }}</td>
                                    </tr>
                                    <tr><th> Code </th>
                                        <td> {{ $mail_sms->code }} </td>
                                    </tr>
                                    <tr>
                                        <th> Title </th>
                                        <td> {{ $mail_sms->title }} </td>
                                    </tr>
                                    </tr>
                                    <tr>
                                        <th> Type </th>
                                        <td> {{ $mail_sms->type }} </td>
                                    </tr>
                                    <tr>
                                        <th> Body </th>
                                        <td> {{ $mail_sms->body }} </td>
                                    </tr>
                                    <tr>
                                        <th> Variables </th>
                                        <td> {{ $mail_sms->variables }} </td>
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
