
@extends('backend.layouts.empty') 
@section('title', 'Article')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <table id="article_table" class="table">
                    <thead>
                        <tr>
                            <th  class="col-1">Title</th>
                            <th  class="col-2">Creator</th>
                            <th  class="col-3">Category</th>
                            <th  class="col-4">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($articles->count() > 0)
                            @foreach($articles as $item)
                                <tr>
                                    <td class="col-1">{{ $item['title'] }}</td>
                                    <td class="col-2">{{ NameById($item['user_id']) }}</td>
                                    <td class="col-3"><a class="badge badge-info" href="javascript:void(0);">{{  fetchFirst('App\Models\Category', $item['category_id'], 'name' ) }}</a></td>
                                    <td class="col-4">{{ getFormattedDate($item['created_at']) }}</td>
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