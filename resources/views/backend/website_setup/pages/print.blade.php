
@extends('backend.layouts.empty') 
@section('title', 'Page')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <table id="page_table" class="table">
                    <thead>
                        <tr>
                            <th class="col1" >{{ ('Name') }}</th>
                            <th class="col2">{{('Status')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($pages->count() > 0)
                            @foreach($pages as $item)
                                <tr>
                                    <td class="col1">{{ $item['title'] }}</td>
                                    <td class="col2">
                                        @if ($item['status'] == 1)
                                            {{ $item['status'] == 1 ? "Publish" : ''  }}
                                        @else
                                            {{ $item['status'] == 0 ? "Unpublish" : '' }}
                                        @endif
                                    </td>
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