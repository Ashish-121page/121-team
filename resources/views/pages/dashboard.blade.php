@extends('backend.layouts.main') 
@section('title', 'Home | Dashboard')
@section('content')
<style>
    .row{
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        margin-top: 30px;
        z-index: 3;
        position: relative;
    }

    .row .col a {
        display: flex;
        justify-content: center !important;
        align-items: center !important;
        flex-direction: column;
    }

    .row .col a p {
        text-align: center;
    }

    .circle {
        position: relative;
        height: 75px;
        width: 75px;
        border-radius: 50%;
        /* border: 2px solid red; */
    }

    .col a .circle span {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        width: 100%;
        font-size: 22px;
    }

    .progressmeter {
        position: relative;
    }

    /* .bar {
        height: 10px;
        width: 88%;
        background-color: #6666cc;
        position: absolute;
        top: 40%;
        left: 6%;
        z-index: 1;
    } */
</style>


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