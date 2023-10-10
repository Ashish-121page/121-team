
@extends('backend.layouts.empty') 
@section('title', 'Lead')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <table id="lead_table" class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Assign to</th>
                            <th>Type</th>
                            <th>Source</th>
                            <th>Created At</th>
                            <th>Last Activity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($lead->count() > 0)
                            @foreach($lead as $item)
                                <tr>
                                    <td><a class="btn btn-link" href="{{ route('panel.admin.lead.show', $item['id']) }}">{{ $item['name'] }}</a>
                                    <td>{{ NameById($item['user_id']) }}</td>
                                    </td>
                                    <td>{{fetchFirst('App\Models\Category',$item['lead_type_id'],'name','--') }}</td>
                                    <td>{{fetchFirst('App\Models\Category',$item['lead_source_id'],'name','--') }}</td>
                                    <td>{{ getFormattedDate($item['created_at']) }}</td>
                                    <td>{{ getFormattedDate($item['updated_at']) }}</td>
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