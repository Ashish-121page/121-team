@extends('backend.layouts.main')
@section('title', 'Quotation')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
    @endpush

    <div class="container-fluid">


        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 sidebar mt-3">
                <!-- Sidebar content -->
                <h6 style="font-weight:900">
                    </h2>

                    <div class="sidebar-section mt-5">
                        <h6>All Documents</h6>

                    </div>
                    <div class="sidebar-section h6">
                        <a class="" href="{{ route('panel.Documents.Quotation') }}">Quotations</a>

                    </div>
                    <div class="sidebar-section h6">
                        <a href="{{ route('panel.Documents.index') }}">Invoice</a>

                    </div>
            </div>

            <!-- Main Content -->






        </div>
    @endsection
