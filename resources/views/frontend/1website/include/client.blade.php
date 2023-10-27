  <!-- Partners start -->
  <section class="section bg-light mt-0 mt-md-5">
      <div class="container">
          <div class="row justify-content-center">
              <div class="col-12 text-center">
                  <div class="section-title mb-4 pb-2">
                      <h4 class="title mb-4">Our Trusted Clients</h4>
                      <p class="text-muted para-desc mx-auto mb-0">Start working with <span
                              class="text-primary fw-bold">Landrick</span> that can provide everything you need to
                          generate awareness, drive traffic, connect.</p>
                  </div>
              </div>
              <!--end col-->
          </div>
          <!--end row-->

          <div class="row justify-content-center">
              @for ($i = 1; $i < 7; $i++)
                <div class="col-lg-2 col-md-2 col-6 text-center mt-4 pt-2">
                    <img src="{{ asset('frontend/assets/img/amazon.svg') }}" class="avatar avatar-ex-sm" alt="">
                </div>
              @endfor
              <!--end col-->
              <!--end col-->
          </div>
          <!--end row-->
      </div>
      <!--end container-->
  </section>
  <!--end section-->
  <!-- Partners End -->
