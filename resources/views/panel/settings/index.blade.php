@extends('backend.layouts.main')
@section('title', 'Settings')
@section('content')


    <!-- push external head elements to head -->
    @push('head')

    @endpush

    <div class="container-fluid">
        
        <div class="row">
            <div class="col-md-6 col-12 my-2">
                <div class="one" style="display: flex;align-items: center;justify-content: flex-start;">

                    <a href=#emplates" class="btn btn-outline-primary active mx-1">
                        Templates
                    </a>
                
                </div>
            </div>


            {{-- ` This Menu is Always Visible  --}}
            <div class="col-md-6 col-12 my-2">        
                <div class="two" style="display: flex;align-items: center;justify-content: flex-end;">
                    <a href="https://forms.gle/W7xxYt9gwzamse9TA" target="_blank" class="btn btn-outline-primary mx-1">
                        Create New
                    </a>                    
                </div>
            </div>


        </div>



        <div class="row">
            @include('panel.settings.pages.Template')
        </div>



    </div>
    <!-- push external js -->
    @push('script')

    @endpush
@endsection
