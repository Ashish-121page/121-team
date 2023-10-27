@extends('backend.layouts.main') 
@section('title', 'Category')

@section('content')
@push('head')

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/normalize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
    <style>
        .remove-ik-class{
                -webkit-box-shadow: unset !important;
                box-shadow: unset !important;
            }
    </style>
@endpush

    <!-- push external head elements to head -->

    <div class="container-fluid">

        
        <div class="row">
            <div class="col-12">
                <a href="{{ route('panel.constant_management.category.create',[13,3,12]) }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Category"><i class="fa fa-plus" aria-hidden="true"></i></a>
            </div>
        </div>


        <div class="row">
            
            @if (AuthRole() == 'Admin')
                @include('backend.constant-management.category.view.admin-view')    
            @else
                @include('backend.constant-management.category.view.user-view')
            @endif

            
        </div>
    </div>
    
     @include('backend.constant-management.category.include.modal')
     @include('backend.constant-management.category.include.industry')
     
     <!-- push external js -->
     @push('script')
     
    <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>
    <script>

        $(document).ready(function() {

            $("#demo01").click();


            var table = $('#category_table').DataTable({
                responsive: true,
                fixedColumns: true,
                fixedHeader: true,
                scrollX: false,
                'aoColumnDefs': [{
                    'bSortable': false,
                    'aTargets': ['nosort']
                }],
                dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                buttons: [
                    {
                        extend: 'excel',
                        className: 'btn-sm btn-success',
                        header: true,
                        footer: true,
                        exportOptions: {
                            columns: ':visible',
                        }
                    },
                    'colvis',
                    {
                        extend: 'print',
                        className: 'btn-sm btn-primary',
                        header: true,
                        footer: false,
                        orientation: 'landscape',
                        exportOptions: {
                            columns: ':visible',
                            stripHtml: false
                        }
                    }
                ]

            });
        });
    </script>
    @endpush
@endsection
