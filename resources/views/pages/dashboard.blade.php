@extends('backend.layouts.main') 
@section('title', 'Dashboard')
@section('content')
    <div class="container-fluid">
        @if(auth()->check())    
            @if(AuthRole() == 'Super Admin')
                @include('backend.dashboard.developer')
            @elseif(AuthRole() == 'Admin')
               @include('backend.dashboard.admin')
            @elseif(AuthRole() == 'User')
                @include('backend.dashboard.user')
            @elseif(AuthRole() == 'Brand')
                @include('backend.dashboard.brand')
            @else
                @include('backend.dashboard.marketer')
            @endif  
        @endif
    </div>
  
@endsection