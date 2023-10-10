@extends('backend.layouts.main') 
@section('title', 'Article')
@section('content')
@php
$breadcrumb_arr = [
    ['name'=>'View Article', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>{{ __('View Article')}}</h5>
                            {{-- <span>{{ __('View a record for Article')}}</span> --}}
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
                        <h3>Article</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{ $article->id }}</td>
                                    </tr>
                                    <tr><th> Title </th>
                                        <td> {{ $article->title }} </td>
                                    </tr>
                                    <tr>
                                        <th> User </th>
                                        <td> {{ NameById($article->user_id) }} </td>
                                    </tr>
                                    </tr>
                                    <tr>
                                        <th> Category </th>
                                        <td> {{ fetchFirst('App\Models\Category', $article->category_id, 'name' ,'') }} </td>
                                    </tr>
                                    <tr>
                                        <th> SEO Title </th>
                                        <td> {{ $article->seo_title }} </td>
                                    </tr>
                                    <tr>
                                        <th> SEO Keywords </th>
                                        <td> {{ $article->seo_keywords }} </td>
                                    </tr>
                                    <tr>
                                        <th> Short Description </th>
                                        <td> {!! $article->short_description !!} </td>
                                    </tr>
                                    <tr>
                                        <th> Description </th>
                                        <td> {!! $article->description !!} </td>
                                   
                                    </tr>
                                    <tr>
                                        <th> Banner </th>
                                        <td><img src="{{ ($article && $article->description_banner) ? asset('storage/backend/article/'.$article->description_banner) : asset('backend/default/default-avatar.png') }}" class="" width="150" style="object-fit: fill; width: 650px; height: 250px" /> </td>
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
