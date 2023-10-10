
@extends('backend.layouts.empty') 
@section('title', 'User')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive">
                    <table id="user_table" class="table p-0">
                        <thead>
                            <tr>
                                <th class="col_3">{{ __('Customer')}}</th>
                                <th class="col_4">{{ __('Role')}}</th>
                                <th class="col_5">{{ __('Email')}}</th>
                                <th class="col_6">{{ __('Status')}}</th>
                                <th class="col_7">{{ __('Join At')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($users->count() > 0)
                                @foreach ($users as $item)
                                <tr>
                                    <td class="col_3">{{ $item['name']}}</td>
                                    <td class="col_4">{{UserRole($item['id'])['name'] }}</td>
                                    <td class="col_5">{{ $item['email'] }}</td>
                                    <td class="col_6">{{ getStatus($item['status'])['name']}} </td>
                                    <td class="col_7">{{ getFormattedDate($item['created_at']) }}</td>
                                </tr>
                                @endforeach
                            @else
                            <tr>
                                <td class="text-center" colspan="8">No Data Found...</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection