@extends('backend.layouts.main')
@section('title', 'Search result')
@section('content')


<div class="menu-container">
    <div class="menu-container">
        <div class="col-12 d-flex justify-content-center align-items-center"
                style="position: fixed;top:12% !important;left:0%;z-index: 88;padding: 0 0 25px 0 !important;background-color: #fff;">
                <a href="#" class="btn btn-link text-primary mx-2 active" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    1. Search</a>
                <a href="#"
                    class="btn btn-link text-primary mx-2">2.Update</a>
                <a href="#"
                    class="btn btn-link text-primary mx-2">3. Generate</a>
        </div>
    </div>
</div>



@include('frontend.micro-site.og_proposals.modal.searchmodal')
@endsection
                 