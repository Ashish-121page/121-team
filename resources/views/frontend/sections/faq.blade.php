
    <section id="faq" class="spacer-double-lg">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="mb-5 pb-5 text-center">
                        <h2 class="display-4">How can we help ? </h2>
                        <p class="w-md-60 mx-auto mb-0 lead">Our work with clients has always been at the intersection of deep industry expertise and extensive capabilities.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div id="faq-accordion">

                        @foreach(App\Models\Faq::whereIsPublish(1)->latest()->get()->take(10) as $faq)
                                       
                            <div class="card card-collapse mb-3 ">
                                <div class="card-header accordion-header">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link btn-block d-flex justify-content-between accordion-collapse-btn collapsed" data-toggle="collapse" data-target="#faq-accordion-{{ $faq->id }}" aria-expanded="false" aria-controls="faq-accordion-{{ $faq->id }}">
                                    {{$faq->title}}
                                   
                                <span class="accordion-arrow">
                                <span class="fa fa-angle-down accordion-arrow-inner"></span>
                                </span>
                                </button>
                                    </h5>
                                </div>
                                
                                <div id="faq-accordion-{{ $faq->id }}" class="collapse" data-parent="#faq-accordion" style="">
                                    <div class="card-body accordion-body">
                                
                                        @if($faq->is_publish == 1)
                                                
                                        <span>{{ $faq->description }}</span>  
                                                               
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                        @endforeach
                           
                        {{-- <div class="card card-collapse mb-3">
                            <div class="card-header accordion-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link btn-block d-flex justify-content-between accordion-collapse-btn collapsed" data-toggle="collapse" data-target="#faq-accordion-2" aria-expanded="false" aria-controls="faq-accordion-2">
                            It is worth trading forex ?
                            <span class="accordion-arrow">
                            <span class="fa fa-angle-down accordion-arrow-inner"></span>
                            </span>
                            </button>
                                </h5>
                            </div> --}}
                            {{-- <div id="faq-accordion-2" class="collapse" data-parent="#faq-accordion" style="">
                                <div class="card-body accordion-body">Web marketing refers to a broad category of advertising that takes many different forms, but generally involves any marketing activity conducted online. Marketers have shifted their efforts online because it tends to
                                    be significantly less expensive.</div>
                            </div>
                        </div>
                        <div class="card card-collapse mb-3 ">
                            <div class="card-header accordion-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link btn-block d-flex justify-content-between accordion-collapse-btn collapsed" data-toggle="collapse" data-target="#faq-accordion-3" aria-expanded="false" aria-controls="faq-accordion-3">
                            Who is the richest forex trader ?
                            <span class="accordion-arrow">
                            <span class="fa fa-angle-down accordion-arrow-inner"></span>
                            </span>
                            </button>
                                </h5>
                            </div>
                            <div id="faq-accordion-3" class="collapse" data-parent="#faq-accordion" style="">
                                <div class="card-body accordion-body">Web marketing refers to a broad category of advertising that takes many different forms, but generally involves any marketing activity conducted online. Marketers have shifted their efforts online because it tends to
                                    be significantly less expensive.</div>
                            </div>
                        </div>
                        <div class="card card-collapse mb-3">
                            <div class="card-header accordion-header">
                                <h5 class="mb-0">
                                    <button class="btn btn-link btn-block d-flex justify-content-between accordion-collapse-btn collapsed" data-toggle="collapse" data-target="#faq-accordion-4" aria-expanded="false" aria-controls="faq-accordion-4">
                            Can you get rich by trading forex ?
                            <span class="accordion-arrow">
                            <span class="fa fa-angle-down accordion-arrow-inner"></span>
                            </span>
                            </button>
                                </h5>
                            </div>
                            <div id="faq-accordion-4" class="collapse" data-parent="#faq-accordion" style="">
                                <div class="card-body accordion-body">Web marketing refers to a broad category of advertising that takes many different forms, but generally involves any marketing activity conducted online. Marketers have shifted their efforts online because it tends to
                                    be significantly less expensive.</div>
                            </div>
                        </div>
                        <div class="card card-collapse">
                            <div class="card-header accordion-header ">
                                <h5 class="mb-0">
                                    <button class="btn btn-link btn-block d-flex justify-content-between accordion-collapse-btn collapsed" data-toggle="collapse" data-target="#faq-accordion-5" aria-expanded="false" aria-controls="faq-accordion-5">
                            How much money od i need to trade ?
                            <span class="accordion-arrow">
                            <span class="fa fa-angle-down accordion-arrow-inner"></span>
                            </span>
                            </button>
                                </h5>
                            </div>
                            <div id="faq-accordion-5" class="collapse" data-parent="#faq-accordion" style="">
                                <div class="card-body accordion-body">Web marketing refers to a broad category of advertising that takes many different forms, but generally involves any marketing activity conducted online. Marketers have shifted their efforts online because it tends to
                                    be significantly less expensive.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-75 mx-auto mt-4 text-center">
                <p class="mb-0 text-muted">Didn't find what you look after ? Visit the <a href="#" class="hover-arrow text-info">Help Center
                <span class="fa fa-arrow-right"></span></a>
                </p>
            </div> --}}
        </div>
    </section>