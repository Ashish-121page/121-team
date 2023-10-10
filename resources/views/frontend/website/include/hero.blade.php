<style>
    @media only screen and (max-width: 600px) {
        .title-heading{
            margin-top: 4.5rem;
        }

    }
</style>

   <!-- Hero Start -->
   <section class="bg-home d-flex align-items-center"
       style="background: url('frontend/assets/img/home-shape.png') center center; height: auto;" id="home">
       <div class="container">
           <div class="row justify-content-center">
               <div class="col-lg-12 text-center mt-0 mt-md-5 pt-0 pt-md-5">
                   <div class="title-heading">
                       <h1 class="heading mb-3">Start your Bulk Distribution Tool. Today.</h1>
                       <p class="para-desc mx-auto text-muted">Using our B2B platform, you can serve customers quicker -
                           while saving time & money - sell more - and increase profits.</p>

                       <div class="d-flex justify-content-center">
                           <div class="mt-4 pt-2 me-3">
                               <a href="{{ url('/short/supplier') }}" class="btn btn-outline-secondary"> Benefit Supplier <i
                                       class="uil uil-angle-right-b"></i></a>
                           </div>
                           <div class="mt-4 pt-2">
                               <a href="{{ url('/short/dealers') }}" class="btn btn-outline-secondary"> Benefit Dealer <i
                                       class="uil uil-angle-right-b"></i></a>
                           </div>
                       </div>

                   </div>

                   <div class="d-flex justify-content-center">
                       <div class="mt-2 pt-2">
                           <a href="{{ url('start') }}" class="btn-link"> <u>Know More</u> 
                                {{-- <i class="uil uil-angle-right-b"></i> --}}
                            </a>
                       </div>
                   </div>

                   <div class="home-dashboard">
                       <img src="{{ asset('frontend/assets/img/site.webp') }}" alt="" class="img-fluid">
                   </div>
               </div>
               <!--end col-->
           </div>
           <!--end row-->
       </div>
       <!--end container-->
   </section>
   <!--end section-->
   <!-- Hero End -->
