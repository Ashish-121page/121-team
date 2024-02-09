@extends('backend.layouts.main')
@section('title', 'Search ')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/normalize.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
        <style>
            .closeanimate {
                transition: 0.3s ease-in-out;
            }

            .closeanimate:hover {
                transform: rotate(180deg);
                cursor: pointer;
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background-color: #6666cc !important;
                border: 1px solid #6666cc !important;
                color: white !important;
            }
        </style>
    @endpush

    <div class="container-fluid">
        @if (isset($search))
            @include('panel.search.pages.result')
        @else
            @include('panel.search.pages.home')
        @endif
    </div>


    @push('script')
    {{-- mynewimage --}}
    <script>
        $(document).ready(function () {
            $("#searchimg").change(function (e) {
                e.preventDefault();
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#mynewimage').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);

                $(".MYSEACHBTN").removeClass('d-none');
                $(".MYSEACHBTN").addClass('d-flex');

            });
        });
    </script>
    @endpush

@endsection
