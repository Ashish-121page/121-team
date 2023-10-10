
@extends('backend.layouts.empty') 
@section('title', 'Ticket')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <table id="ticket_table" class="table">
                    <thead>
                        <tr>
                            <th class="col-1">Title</th>
                            <th class="col-2">Ticket Type</th>
                            <th class="col-3">Assign To</th>
                            <th class="col-4">Status</th>
                            <th class="col-5">Created At</th>
                            <th class="col-6">Last Activity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($tickets->count() > 0)
                            @foreach($tickets as $item)
                                <tr>
                                    <td class="col-1"><a class="btn btn-link" href="{{ route('panel.admin.ticket.show', $item['id']) }}">{{ $item['title'] }}</a></td>
                                <td class="col-1">
                                    {{fetchFirst('App\Models\Category',$item['ticket_type_id'],'name','--') }}
                                </td>
                                <td class="col-3">
                                    <a href="{{ route('panel.users.show', $item['assigned_to']) }}">{{ NameById($item['assigned_to'])}}</a>
                                </td>
                                <td class="col-4">
                                    @if ($item['is_closed'] == 1)
                                        Active
                                    @else
                                        Closed
                                    @endif
                                </td>
                                <td class="col-5">{{ getFormattedDate($item['created_at']) }}</td>
                                <td class="col-6">{{ getFormattedDate($item['updated_at']) }}</td>
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
@endsection