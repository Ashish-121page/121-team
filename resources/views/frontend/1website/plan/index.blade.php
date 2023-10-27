@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = 'Pricing | '.getSetting('app_name');		
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'GRPL';		
		$meta_author_email = '' ?? 'Hello@121.page';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';
		$website = 1;
        $user_active_package = App\Models\UserPackage::whereUserId(auth()->id())->first();        		
	@endphp
@endsection

<style>
    input[type=checkbox]{
        cursor:pointer;
    }

    p,li{
       color: #8492a6 !important;
    }
    /* .bg-light{
        padding: 20px 0 100px 0 !important;
    } */
    @media (max-width: 768px) {
        .section-title .title {
            font-size: 33px !important
        }
        .section{
            padding: 10px 0 10px 0 !important;
        }
        .bg-light {
            padding: 10px 0 55px 0 !important;
        }
    }
    p span{
        font-size: 1.2rem
    }
    p span b{
        /* font-weight: 400 */
    }
</style>

@section('content')

        @php
            $page_title = "Pricing";
        @endphp
        @include('frontend.website.breadcrumb')


        <div class="position-relative">
            <div class="shape overflow-hidden text-white">
                <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
                </svg>
            </div>
        </div>


      <!-- Price Start -->
        <section class="section">
            <div class="container">
                {{-- <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <div class="section-title mb-4 pb-2">
                            <h4 class="title mb-4">121.Page Subscription Plans</h4>
                            <p class="text-muted para-desc mb-0 mx-auto">Start working with <span class="text-primary fw-bold">{{ getSetting('app_name') }}</span> that can provide everything you need to generate awareness, drive traffic, connect.</p>
                        </div>
                    </div><!--end col-->
                </div><!--end row--> --}}
                {{-- <h1 class="heading mb-3 text-center">Start your Bulk Distribution Tool. Today.</h1> --}}
                <h1 class="heading mb-3 mt-5 text-center">Catalogue Distribution service</h1>

                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="row align-items-stratch">
                            @foreach ($packages as $package)
                            <form class="col-md-4 col-12 mt-4 pt-2" action="{{ route('plan.checkout',$package->id ) }}" method="post">
                                @csrf
                                <input type="hidden" name="package_id" value="{{ $package->id }}">
                                <div class="" style="height: 700px">
                                    <div class="card align-items-center pricing pricing-primary business-rate shadow bg-light rounded text-center border-0" style="height: 650px">
                                        <div class="card-body py-5" style="height: 100%">
                                            <h3>{{ $package->name }}</h3>

                                            <div class="d-flex justify-content-center mb-2">
                                                {{-- <span class="h5 mb-0 mt-1 mx-1">₹</span> --}}
                                                <span class="price h4 mb-0">{{ format_price($package->price) }} </span>
                                                <span class="h5 align-self-end mb-1 mx-2"> @if($package->price!=0) /p.a @endif</span>
                                            </div>
                                            <span class="h6 align-self-end mb-4 mx-2"> {{ format_price($package->price / 12) }} /p.m</span>

                                            @php
                                              $description = explode('^^',$package->description);
                                              $limits = json_decode($package->limit,true);
                                            @endphp

                                            <ul class="list-unstyled mb-0 ps-0 mt-3">
                                                @forelse ($description as $item)
                                                    <li class="h6 text-muted mb-0" style="display: flex;">
                                                    <span class="icon h5 me-2"><i class="uil uil-check-circle align-middle"></i></span>
                                                    {!! trim($item) !!}
                                                </li>
                                                @empty
                                                    
                                                @endforelse
                                            </ul>
                                             
                                            @if($user_active_package)
                                                {{-- Trail --}}
                                                @if($package->id == 1 && $user_active_package)
                                                        <div class="alert alert-danger mt-4">
                                                            Not Eligible
                                                        </div> 
                                                {{-- Has Package --}}
                                                @elseif($user_active_package->package_id == $package->id)
                                                        {{-- @dump(\Carbon\Carbon::parse($user_active_package->to)->format('Y-m-d') > now()->format('Y-m-d')) --}}
                                                    @if(\Carbon\Carbon::parse($user_active_package->to)->format('Y-m-d') < now()->format('Y-m-d'))
                                                        <button type="submit" class="btn btn-primary mt-4">Renew Now</button>
                                                    @else
                                                       <div class="alert alert-warning mt-4">
                                                            Current Package    
                                                        </div>
                                                        <hr>
                                                        <span class="text-center">
                                                            Plan expires on {{ \Carbon\Carbon::parse($user_active_package->to)->format('Y-m-d') }}
                                                        </span>
                                                    @endif
                                                @elseif($package->id != 1 )
                                                    <button type="submit" class="btn btn-outline-primary mt-4 mb-3" id="buynow-{{ $package->id}}">Buy Now</button>
                                                @endif
                                            @elseif($package->id != 1 )
                                                <button type="submit" class="btn btn-outline-primary mt-4 mb-3" id="buynow-{{ $package->id}}">Buy Now</button>  
                                                <button type="submit" class="btn btn-primary mt-4 mb-3" id="freetrial-{{ $package->id}}">Start Free Trial</button>  
                                            @elseif(!auth()->id())
                                                <button type="submit" class="btn btn-primary mt-4 mb-3">Sign Up</button>
                                            @endif
                                            <br>    
                                            <small><a href="{{route('demoform')}}">Know More</a></small>
                                            <hr>
                                            <input type="checkbox" name="term" id="term" value="{{ $package->id}}" class="form-check-input" checked onchange="happy(this)"> 
                                            <small style="font-size: 0.8rem; padding: 0 0 10px 0">Accept <a href="{{ url('/page/terms') }}"> Terms & Conditions </a></small>
                                        </div>
        
                                    </div>
                                </div><!--end col-->
                            </form>
                            @endforeach

                        </div>
                    </div>
                </div>
                <!--end row-->
            </div><!--end container-->
            <!-- Testi Start -->
            {{-- <div class="container" style="margin-bottom: 70px;">
                <div class="row pt-md-5 justify-content-center">
                    <div class="col-12">
                        <div class="section-title text-center mb-4 pb-2">
                            <h4 class="title mb-4">{{ $testimonial['title'] ?? '' }}</h4>
                            <p class="text-muted para-desc mx-auto mb-0">{{ $testimonial['description'] ?? '' }}</p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    <div class="col-lg-12 mt-4">
                        <div class="tns-outer" id="tns1-ow"><div class="tns-liveregion tns-visually-hidden" aria-live="polite" aria-atomic="true">slide <span class="current">2 to 4</span>  of 6</div><div id="tns1-mw" class="tns-ovh"><div class="tns-inner" id="tns1-iw"><div class="tiny-three-item  tns-slider tns-carousel tns-subpixel tns-calc tns-horizontal" id="tns1" style="transform: translate3d(-16.6667%, 0px, 0px);">
                            <div class="tiny-slide tns-item" id="tns1-item0" aria-hidden="true" tabindex="-1">
                                <div class="d-flex client-testi m-2">
                                    
                                    <img src="{{ asset('frontend/assets/img/client/01.jpg') }}" class="avatar avatar-small client-image rounded shadow" alt="">
                                    <div class="flex-1 content p-3 shadow rounded bg-white position-relative">
                                        <ul class="list-unstyled mb-0">
                                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        </ul>
                                        <p class="text-muted mt-2">Neha Baghel</p>
                                        <h6 class="text-primary">Testing mode<small class="text-muted">(Engineer)</small></h6>
                                    </div>
                                </div>
                            </div>
                        </div></div></div></div>
                    </div><!--end col-->
                </div><!--end row-->

            </div> --}}
            {{-- @include('frontend.sections.reviews') --}}
           
        </section><!--end section-->
        <!-- Testi End -->

          {{-- <!-- FAQ n Contact Start -->
        <section class="section bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="d-flex">
                            <i data-feather="help-circle" class="fea icon-ex-md text-primary me-2 mt-1"></i>
                            <div class="flex-1">
                                <h5 class="mt-0">How our <span class="text-primary">{{ getSetting('app_name') }}</span> work ?</h5>
                                <p class="answer text-muted mb-0">Due to its widespread use as filler text for layouts, non-readability is of great importance: human perception is tuned to recognize certain patterns and repetitions in texts.</p>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-md-6 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                        <div class="d-flex">
                            <i data-feather="help-circle" class="fea icon-ex-md text-primary me-2 mt-1"></i>
                            <div class="flex-1">
                                <h5 class="mt-0"> What is the main process open account ?</h5>
                                <p class="answer text-muted mb-0">If the distribution of letters and 'words' is random, the reader will not be distracted from making a neutral judgement on the visual impact</p>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-md-6 col-12 mt-4 pt-2">
                        <div class="d-flex">
                            <i data-feather="help-circle" class="fea icon-ex-md text-primary me-2 mt-1"></i>
                            <div class="flex-1">
                                <h5 class="mt-0"> How to make unlimited data entry ?</h5>
                                <p class="answer text-muted mb-0">Furthermore, it is advantageous when the dummy text is relatively realistic so that the layout impression of the final publication is not compromised.</p>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-md-6 col-12 mt-4 pt-2">
                        <div class="d-flex">
                            <i data-feather="help-circle" class="fea icon-ex-md text-primary me-2 mt-1"></i>
                            <div class="flex-1">
                                <h5 class="mt-0"> Is <span class="text-primary">{{ getSetting('app_name') }}</span> safer to use with my account ?</h5>
                                <p class="answer text-muted mb-0">The most well-known dummy text is the 'Lorem Ipsum', which is said to have originated in the 16th century. Lorem Ipsum is composed in a pseudo-Latin language which more or less corresponds to 'proper' Latin.</p>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row mt-md-5 pt-md-3 mt-4 pt-2 mt-sm-0 pt-sm-0 justify-content-center">
                    <div class="col-12 text-center">
                        <div class="section-title">
                            <h4 class="title mb-4">Have Question ? Get in touch!</h4>
                            <p class="text-muted para-desc mx-auto">Start working with <span class="text-primary fw-bold">{{ getSetting('app_name') }}</span> that can provide everything you need to generate awareness, drive traffic, connect.</p>
                            <div class="mt-4 pt-2">
                                <a href="{{ url('contact-us') }}" class="btn btn-primary">Contact us <i class="mdi mdi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- FAQ n Contact End --> --}}





@endsection

@push('script')


<script>


        function happy(item) { 
            var buybtn = document.getElementById("buynow-"+item.value);
            var freetrial = document.getElementById("freetrial-"+item.value);
            if (item.checked == true) {
                buybtn.disabled = false;
                freetrial.disabled = false;
            }else{
                buybtn.disabled = true;
                freetrial.disabled = true;
            }

        }
</script>



@endpush