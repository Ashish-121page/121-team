@extends('backend.layouts.main') 
@section('title', 'Mail SMS Template')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'Add Mail SMS Template', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>{{ __('Edit Mail SMS Template')}}</h5>
                            <span>{{ __('Update a record for Mail SMS Template')}}</span>
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
            <div class="col-md-8 mx-auto">
                <div class="card ">
                    <div class="card-header">
                        <h3>{{ __('Update SMS Template')}}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.admin.ticket_conversation.update', $ticket_conver->id) }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mx-auto">
                                    <div class="form-group {{ $errors->has('ticket_id') ? 'has-error' : ''}}">
                                        <label for="ticket_id">{{ __('Ticket')}}</label>
                                        <select name="ticket_id" id="ticket_id" class="form-control select2">
                                            <option value="" readonly>{{ __('Select Ticket')}}</option>
                                            @foreach (fetchAll('App\Models\Ticket') as $item)
                                                <option value="{{ $item->id }}">{{ $item->title }}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group {{ $errors->has('user_id') ? 'has-error' : ''}}">
                                        <label for="user_id">{{ __('User')}}</label>
                                        <select name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>{{ __('Select User')}}</option>
                                            @foreach (fetchAll('App\User') as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                        <label for="comment" class="control-label">{{ 'Comment' }}</label>
                                        <textarea class="form-control" rows="5" name="comment" type="textarea" id="comment" required>{{ isset($ticket_conver->comment) ? $ticket_conver->comment : ''}}</textarea>
                                    </div>
                                    <div class="form-group text-right">
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
    @push('script')
    @endpush
@endsection
