

<section class="bg-half-170 bg-light d-table w-100">
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="pages-heading">
                    <h4 class="title mb-0"> {{ $page_title }} </h4>
                </div>
            </div>  <!--end col-->
        </div><!--end row-->
        
        <div class="position-breadcrumb">
            <nav aria-label="breadcrumb" class="d-inline-block">
                <ul class="breadcrumb rounded shadow mb-0 px-4 py-2">
                    <li class="breadcrumb-item"><a href="{{ url('/now') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $page_title }}</li>
                </ul>
            </nav>
        </div>
    </div> <!--end container-->
</section><!--end section-->
        <!-- Hero End -->