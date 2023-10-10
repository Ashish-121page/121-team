@extends('frontend.layouts.main')

@section('content')
    <div class="container ">
        <div class="row justify-content-center m-5">
            
            <div class="col-md-12 m-5 mt-5 text-center">
                <h1 class="m-5">This is your homepage!</h1>
                <a href="{{url('login')}}" class="btn btn-success">Go to Admin</a>
                <a href="https://documenter.getpostman.com/view/11223504/Szmh1vqc?version=latest" class="btn btn-danger">API Endpoint</a>
                
            </div>

            </div>
        </div>
    </div>
@endsection
