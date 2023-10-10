<section id="testimonial" class="spacer-double-lg bg-secondary">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="mb-5 pb-5 text-center">
                    <h2 class="display-4">Customers love Foxecoach</h2>
                    <p class="w-md-60 mx-auto mb-0 lead">Our work with clients has always been at the intersection of deep industry expertise and extensive capabilities.</p>
                </div>
            </div>
        </div>
        <div class="row">
            {{-- @foreach (fetchAll('App\Models\Testimonial', 'name') as $item)
                <div class="col-lg-4 mb-5">
                    <div class="card border-0 radius-bottom-right shadow-soft h-100">
                        <div class="card-body p-5">
                            <ul class="list-inline text-warning">
                                <li class="list-inline-item mx-0">
                                    <span class="fas fa-star"></span>
                                </li>
                                <li class="list-inline-item mx-0">
                                    <span class="fas fa-star"></span>
                                </li>
                                <li class="list-inline-item mx-0">
                                    <span class="fas fa-star"></span>
                                </li>
                                <li class="list-inline-item mx-0">
                                    <span class="fas fa-star"></span>
                                </li>
                                <li class="list-inline-item mx-0">
                                    <span class="fas fa-star"></span>
                                </li>
                            </ul>
                            <p class=" mb-0">{{ $item->description }}</p>
                        </div>
                        <div class="card-footer border-0  pt-0 px-5 pb-5">
                            <div class="media">
                                <div class="avatar-sm mr-3">
                                    <img class="img-fluid rounded-circle" src="{{ asset('frontend/assets/img/avatar-1.jpg') }}" alt="">
                                </div>
                                <div class="media-body">
                                    <h4 class="h6 mb-0">{{ $item->name }}</h4>
                                    <small class="d-block text-muted ">Business Manager</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach --}}

            {{-- <div class="col-lg-4 mb-5">
                <div class="card border-0 radius-bottom-right h-100 shadow-soft">
                    <div class="card-body p-5">
                        <ul class="list-inline text-warning">
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                        </ul>
                        <p class=" mb-0">User research focuses on understanding user behaviors, needs, and motivations through observation techniques.</p>
                    </div>
                    <div class="card-footer border-0  pt-0 px-5 pb-5">
                        <div class="media">
                            <div class="avatar-sm mr-3">
                                <img class="img-fluid rounded-circle" src="{{ asset('frontend/assets/img/avatar-2.jpg') }}" alt="">
                            </div>
                            <div class="media-body">
                                <h4 class="h6 mb-0">David Taylor</h4>
                                <small class="d-block text-muted">CEO at Slack</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-5  ">
                <div class="card border-0 radius-bottom-right h-100 shadow-soft">
                    <div class="card-body p-5">
                        <ul class="list-inline text-warning">
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                        </ul>
                        <p class=" mb-0">Content strategy focuses on the planning, creation, delivery, and governance of content.</p>
                    </div>
                    <div class="card-footer border-0  pt-0 px-5 pb-5">
                        <div class="media">
                            <div class="avatar-sm mr-3">
                                <img class="img-fluid rounded-circle" src="{{ asset('frontend/assets/img/avatar-3.jpg') }}" alt="">
                            </div>
                            <div class="media-body">
                                <h4 class="h6 mb-0">Jeremy Spivak</h4>
                                <small class="d-block text-muted">Front Pay user</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
        {{-- <div class="row">
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="card border-0 radius-bottom-right h-100 shadow-soft">
                    <div class="card-body p-5">
                        <ul class="list-inline text-warning">
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                        </ul>
                        <p class=" mb-0">User experience metrics focus on ease of use. Usability is familiar territory and something that UX teams do well so this makes sense as a starting point.</p>
                    </div>
                    <div class="card-footer border-0  pt-0 px-5 pb-5">
                        <div class="media">
                            <div class="avatar-sm mr-3">
                                <img class="img-fluid rounded-circle" src="{{ asset('frontend/assets/img/avatar-4.jpg') }}" alt="">
                            </div>
                            <div class="media-body">
                                <h4 class="h6 mb-0">David Taylor</h4>
                                <small class="d-block text-muted">Business Manager</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="card border-0 radius-bottom-right h-100 shadow-soft">
                    <div class="card-body p-5">
                        <ul class="list-inline text-warning">
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                        </ul>
                        <p class=" mb-0">Visual design is the use of imagery, color, shapes, typography, and form to enhance usability and improve the user experience.</p>
                    </div>
                    <div class="card-footer border-0  pt-0 px-5 pb-5">
                        <div class="media">
                            <div class="avatar-sm mr-3">
                                <img class="img-fluid rounded-circle" src="{{ asset('frontend/assets/img/avatar-5.jpg') }}" alt="">
                            </div>
                            <div class="media-body">
                                <h4 class="h6 mb-0">Jeremy Spivak</h4>
                                <small class="d-block text-muted">CEO at Slack</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-6 mb-lg-0">
                <div class="card border-0 radius-bottom-right h-100 shadow-soft">
                    <div class="card-body p-5">
                        <ul class="list-inline text-warning">
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                            <li class="list-inline-item mx-0">
                                <span class="fas fa-star"></span>
                            </li>
                        </ul>
                        <p class=" mb-0">User experience metrics focus on ease of use. Usability is familiar territory and something that UX teams do well so this makes sense as a starting point.</p>
                    </div>
                    <div class="card-footer border-0 pt-0 px-5 pb-5">
                        <div class="media">
                            <div class="avatar-sm mr-3">
                                <img class="img-fluid rounded-circle" src="{{ asset('frontend/assets/img/avatar-1.jpg') }}" alt="">
                            </div>
                            <div class="media-body">
                                <h4 class="h6 mb-0">Renee Mu</h4>
                                <small class="d-block text-muted">Front Pay user</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- <div class="row justify-content-lg-center align-items-center pt-6 mt-6">
            <div class="col-md-4 mb-6 mb-lg-0">
                <div class="vertical-line-divider text-center px-md-3 px-lg-5">
                    <figure class=" w-100 max-width-7 mx-auto mb-3" style="">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 111.8047 35.3251" enable-background="new 0 0 111.8047 35.3251" xml:space="preserve">
                    <g>
                        <polygon fill="#FFC107" points="58.25,0 63.9889,11.6283 76.8215,13.493 67.5357,22.5443 69.7278,35.3251 58.25,29.2908 
                            46.7722,35.3251 48.9643,22.5443 39.6785,13.493 52.5111,11.6283  "/>
                        <polygon opacity="0.5" fill="#FFC107" points="28.25,10.865 31.8979,18.2564 40.0547,19.4416 34.1523,25.195 35.5457,33.3189 
                            28.25,29.4833 20.9543,33.3189 22.3477,25.195 16.4453,19.4416 24.6021,18.2564  "/>
                        <polygon opacity="0.5" fill="#FFC107" points="86,10.865 89.6479,18.2564 97.8047,19.4416 91.9024,25.195 93.2957,33.3189 
                            86,29.4833 78.7043,33.3189 80.0976,25.195 74.1953,19.4416 82.3521,18.2564   "/>
                        <polygon opacity="0.25" fill="#FFC107" points="7,19.8606 9.1631,24.2435 14,24.9464 10.5,28.358 11.3262,33.1754 7,30.9009 
                            2.6738,33.1754 3.5,28.358 0,24.9464 4.8369,24.2435  "/>
                        <polygon opacity="0.25" fill="#FFC107" points="104.8047,19.8606 106.9678,24.2435 111.8047,24.9464 108.3047,28.358 
                            109.1309,33.1754 104.8047,30.9009 100.4785,33.1754 101.3047,28.358 97.8047,24.9464 102.6416,24.2435   "/>
                    </g>
                </svg>
                    </figure>
                    <p class="mb-0"><span class="text-dark font-weight-700">4.9 out of 5 stars</span> from 1.5k customers.</p>
                </div>
            </div>
            <div class="col-md-4 mb-6 mb-lg-0">
                <div class="vertical-line-divider text-center px-md-3 px-lg-5">
                    <ul class="list-inline mr-2">
                        <li class="list-inline-item mr-0">
                            <img class="img-fluid avatar-md avatar-bordered rounded-circle" src="{{ asset('frontend/assets/img/avatar-1.jpg') }}" alt="">
                        </li>
                        <li class="list-inline-item ml-offset-1 mr-0">
                            <img class="img-fluid avatar-md avatar-bordered rounded-circle" src="{{ asset('frontend/assets/img/avatar-2.jpg') }}" alt="">
                        </li>
                        <li class="list-inline-item ml-offset-1 mr-0">
                            <img class="img-fluid avatar-md avatar-bordered rounded-circle" src="{{ asset('frontend/assets/img/avatar-3.jpg') }}" alt="">
                        </li>
                        <li class="list-inline-item ml-offset-1 mr-0">
                            <img class="img-fluid avatar-md avatar-bordered rounded-circle" src="{{ asset('frontend/assets/img/avatar-4.jpg') }}" alt="">
                        </li>
                    </ul>
                    <p class="mb-0">An average of <span class="text-dark font-weight-700">25,000</span> users signup every month.</p>
                </div>
            </div>
            <div class="col-md-4">
                <!-- Stats -->
                <div class="text-center px-md-3 px-lg-5">
                    <a class="scroll btn btn-wide btn-radius-bottom-left btn-secondary btn-lg mb-5 mb-lg-0" href="#">
                <span class="mn-top">Get started</span>
                </a>
                </div>
            </div>
        </div> --}}
    </div>
</section>