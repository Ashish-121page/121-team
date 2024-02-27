@extends('frontend.layouts.main')

@section('meta_data')
    @php
        $meta_title = 'B2B tool to Manage Products, Offers, Documentation & more ... ' . getSetting('app_name');
        // $meta_title = 'Home | ' . getSetting('app_name');
        $meta_description = '' ?? getSetting('seo_meta_description');
        $meta_keywords = '' ?? getSetting('seo_meta_keywords');
        $meta_motto = '' ?? getSetting('site_motto');
        $meta_abstract = '' ?? getSetting('site_motto');
        $meta_author_name = '' ?? 'GRPL';
        $meta_author_email = '' ?? 'Hello@121.page';
        $meta_reply_to = '' ?? getSetting('frontend_footer_email');
        $meta_img = ' ';
        $website = 1;
    @endphp
@endsection


@section('styling')
    <style>
        .feature-primary {
    display: flex;
    align-items: center;
}
        .section {
            padding: 0 !important;
        }

        .defaultscroll {
            height: 80px !important;
        }

        @media(max-width:420px) {
            .defaultscroll {

                height: 80px !important;
            }

            .text-primary {
                font-size: inherit !important;
            }

            .carosud {
                text-align: center
            }

            #benefits {
                padding-top: 100px !important;
            }

            #why-121 {
                padding-top: 120px !important;
            }

            #benefits {
                padding-top: 120px !important;
            }

            .title-heading {
                display: flex;
                align-items: center;
                flex-direction: column;
            }

            .title-heading .heading {
                margin-left: 50px;
            }

            #hkhjdso {
                width: 850px !important;
                height: 700px !important;
            }
        }

        .features .icon,
        .key-feature .icon {
            height: 40px !important;
        }
    </style>
@endsection

@section('content')
    <!-- Start -->
    <section class="bg-home pb-5 pb-sm-0 d-flex align-items-center bg-linear-gradient-primary">
        <div class="container">
            <div class="row mt-5 align-items-center">
                <div class="col-md-6">
                    <div class="title-heading me-lg-4 wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                        <h1 class="heading fw-bold mb-3">
                            <span class="text-primary">Searchify </span> <br>your product
                                <br> <span> <span class="invisible ">h</span>
                                <span class="typer text-primary " id="main" data-words="Images, Catalogues,PDF + PPT " data-delay="100" data-deleteDelay="500"></span>
                                <span class="cursor text-primary " data-owner="main"></span>

                            </span>
                        </h1>
                        <ul style="list-style: circle!important; margin-left:0.8rem">
                            <li>Search model codes from images</li>
                            <li>Centralise PDF, JPG, PPT, Excel</li>
                            <li>Manage Offers and Documentation</li>
                            <li>Boost Exports</li>
                        </ul>
                        <div class="subscribe-form mt-2 py-2 text-start">
                            <form class="m-0 d-inline-block" style="text-decoration-color: white">

                                    <a href="{{ url('register') }}" class="btn btn-pills btn-primary" style="color: white;">
                                        Know More
                                        <i class="uil uil-arrow-right"></i>
                                    </a>


                            </form><!--end form-->
                        </div>


                    </div>

                </div><!--end col-->

                <div class="col-md-6 mt-4 pt-2 mt-sm-0 pt-sm-0">
                    <div class="position-relative ms-lg-5">
                        <div class="bg-half-260 overflow-hidden rounded-md shadow-md jarallax" data-jarallax
                            data-speed="0.5"
                            style="background: url('{{ asset('frontend/assets/img/modern-hero.jpg') }}'); background-size: cover; background-position: center;">
                            <div class="py-lg-5 py-md-0 py-5"></div>
                        </div>

                        {{-- <div class="bg-half-260 overflow-hidden rounded-md shadow-md jarallax" data-jarallax data-speed="0.5" style="background: url('{{ asset('frontend/assets/img/modern-hero.jpg') }}');">
							<div class="py-lg-5 py-md-0 py-5"></div>
						</div> --}}

                        {{-- <div class="modern-saas-absolute-left wow animate__animated animate__fadeInUp" data-wow-delay=".3s">
							<div class="card">
								<div class="features feature-primary d-flex justify-content-between align-items-center rounded shadow p-3">
									<div class="d-flex align-items-center">
										<div class="icon bg-soft-primary text-center rounded-pill">
											<i class="uil uil-usd-circle fs-4 mb-0"></i>
										</div>
										<div class="flex-1 ms-3">
											<h6 class="mb-0 text-muted">Revenue</h6>
											<p class="fs-5 text-dark fw-bold mb-0">$<span class="counter-value" data-target="48575">45968</span></p>
										</div>
									</div>

									<span class="text-success ms-4"><i class="uil uil-arrow-growth"></i> 3.84%</span>
								</div>
							</div>
						</div> --}}

                        {{-- <div class="modern-saas-absolute-right wow animate__animated animate__fadeInUp" data-wow-delay=".5s">
							<div class="card rounded shadow">
								<div class="p-3">
									<h5>Manage Your Software</h5>

									<div class="progress-box mt-2">
										<h6 class="title fw-normal text-muted">Work in dashboard</h6>
										<div class="progress">
											<div class="progress-bar position-relative bg-primary" style="width:84%;">
												<div class="progress-value d-block text-muted h6 mt-1">84%</div>
											</div>
										</div>
									</div><!--end process box--> --}}
                        {{-- </div>
							</div>
						</div> --}}

                        {{-- <div class="position-absolute top-0 start-0 translate-middle z-index-m-1">
							<img src="{{ asset('frontend/assets/img/dots.svg') }}" class="avatar avatar-xl-large" alt=""> --}}
                        {{-- C:\xampp\xampp install\htdocs\project\121.page-Laravel\core\resources\views\devloper\Jaya --}}
                        {{-- </div> --}}
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
    </section><!--end section-->
    <!-- End -->


    <!-- How It Work Start -->
    <section class="section">
        <div class="container" id="why-121" style="padding-top: 70px; margin-bottom: 0px !important; padding-bottom: 0px !important;">
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <div class="section-title wow animate__animated animate__fadeInUp" data-wow-delay=".1s">
                        {{-- <img src="assets/images/logo-icon.png" class="avatar avatar-small" alt=""> --}}
                        {{-- <img src="{{ getBackendLogo(getSetting('app_white_logo')) }}" class="logo-light-mode" alt=""> --}}
                        <div class="h1 text-primary" style="font-weight: 900;">
                            <h1 class="heading fw-bold mb-3" style="color:#666ccc;">Why 121 ?</h1>
                        </div>
                        <div class="text-start justify-content-center;" >
                        {{-- <div class="text-start justify-content-center;" style="margin-left: 15rem;"> --}}

                            <ul class="d-none d-lg-block" style="list-style: circle!important; margin-left: 15rem;">
                                <li>Tons of product & category folders pile up on Email, drives and WhatsApp? </li>
                                <li>Searching products at Buyer request becomes a headache?</li>
                                <li>Images are backbone of orders - Keeping track of detailed info is too much of bother?</li>
                            </ul>


                            <ul class="d-lg-none" style="list-style: circle!important; margin-left: 0.5rem; text-align:justify;">
                                <li class="text-justify">Tons of product & category folders pile up on Email, drives and WhatsApp?</li>
                                <li class="text-justify">Searching products at Buyer request becomes a headache?</li>
                                <li class="text-justify">Images are backbone of orders - Keeping track of detailed info is too much of bother?</li>
                            </ul>
                        {{-- </div> --}}
                        <br> <strong class="text-primary"></strong>
                    </div>
                </div><!--end col-->
            </div><!--end row-->


            <div class="row">
                <div class="col-12 mt-4 pt-2">
                    <div class="position-relative wow animate__animated animate__fadeInUp start-40 end-40 d-flex justify-content-center align-items-center"
                        data-wow-delay=".3s">
                        {{-- {{-- <video class="w-100 rounded" controls autoplay loop> --}}
                        {{-- <source src="https://121.page/short/suppliers" type="video/mp4"> --}}
                        {{-- </video> --}}

                        {{-- <div class="position-absolute top-50 start-50 translate-middle"> --}}
                            <iframe width="850" id="hkhjdso" height="400" src="https://www.youtube.com/embed/m8NTbT1BIrw?si=9wzif8-C5soKJLdM" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

                        {{-- <a href="{{ url('/short/supplier') }}" data-type="youtube" data-id="yba7hPeTSjk" class="avatar avatar-small rounded-pill shadow-md card d-flex justify-content-center align-items-center lightbox"> --}}
                        {{-- <i class="mdi mdi-play mdi-24px text-primary"></i> --}}
                        {{-- </a> --}}
                        {{-- </div> --}}
                    </div>
                </div>
            </div>

        {{-- </div><!--end container--> --}}



        <!-- copy for app features -->
        <div class="container" id="benefits" style="padding-top: 80px; margin-bottom: 0">
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <div class="section-title mb-4 pb-2">
                        <h1 class="heading " style="color:#666ccc;">Benefits</h1>
                        {{-- <p class="text-muted para-desc mb-0 mx-auto">To craft custom offers for each buyer, valuable time &
                            resources
                            are wasted browsing through Excel, PDFs and Images scattered in Folders, WA, and Drives.
                            Is your valuable time wasted and orders lost?
                            <span class="text-primary fw-bold"></span>
                        </p> --}}
                    </div>
                </div><!--end col-->

                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-4 col-md-4">
                        <div class="row mt-0">
                            <div class="col-12 mt-2 pt-2">
                                <div class="d-flex features feature-primary justify-content-center">
                                    <div
                                        style="height: 150px; display: flex; justify-content: center; align-items: center; width: 100%; margin-left:25px;">
                                        <svg width="206" height="150" viewBox="0 0 512 512"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill="#666ccc"
                                                d="M453.547 273.449H372.12v-40.714h81.427zm0 23.264H372.12v40.714h81.427zm0-191.934H372.12v40.713h81.427zm0 63.978H372.12v40.713h81.427zm0 191.934H372.12v40.714h81.427zm56.242 80.264c-2.326 12.098-16.867 12.388-26.58 12.796H302.326v52.345h-36.119L0 459.566V52.492L267.778 5.904h34.548v46.355h174.66c9.83.407 20.648-.291 29.197 5.583c5.991 8.608 5.41 19.543 5.817 29.43l-.233 302.791c-.29 16.925 1.57 34.2-1.978 50.892m-296.51-91.256c-16.052-32.57-32.395-64.909-48.39-97.48c15.82-31.698 31.408-63.512 46.937-95.327c-13.203.64-26.406 1.454-39.55 2.385c-9.83 23.904-21.288 47.169-28.965 71.888c-7.154-23.323-16.634-45.774-25.3-68.515c-12.796.698-25.592 1.454-38.387 2.21c13.493 29.78 27.86 59.15 40.946 89.104c-15.413 29.081-29.837 58.57-44.785 87.825c12.737.523 25.475 1.047 38.212 1.221c9.074-23.148 20.357-45.424 28.267-69.038c7.096 25.359 19.135 48.798 29.023 73.051c14.017.99 27.976 1.862 41.993 2.676M484.26 79.882H302.326v24.897h46.53v40.713h-46.53v23.265h46.53v40.713h-46.53v23.265h46.53v40.714h-46.53v23.264h46.53v40.714h-46.53v23.264h46.53v40.714h-46.53v26.897H484.26z" />
                                        </svg>
                                        {{-- <svg width="384" height="512" viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="currentColor" d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34M332.1 128H256V51.9zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288zm212-240h-28.8c-4.4 0-8.4 2.4-10.5 6.3c-18 33.1-22.2 42.4-28.6 57.7c-13.9-29.1-6.9-17.3-28.6-57.7c-2.1-3.9-6.2-6.3-10.6-6.3H124c-9.3 0-15 10-10.4 18l46.3 78l-46.3 78c-4.7 8 1.1 18 10.4 18h28.9c4.4 0 8.4-2.4 10.5-6.3c21.7-40 23-45 28.6-57.7c14.9 30.2 5.9 15.9 28.6 57.7c2.1 3.9 6.2 6.3 10.6 6.3H260c9.3 0 15-10 10.4-18L224 320c.7-1.1 30.3-50.5 46.3-78c4.7-8-1.1-18-10.3-18"/>
                                    </svg> --}}
                                    </div>
                                </div>


                                {{-- <div class="d-flex features feature-primary justify-content-center">
                                <div style="height: 150px; display: flex; justify-content: center; align-items: center; width: 100%; margin-left:25px;">
                                    <svg width="206.75" height="150.75" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="red" d="M453.547 273.449H372.12v-40.714h81.427zm0 23.264H372.12v40.714h81.427zm0-191.934H372.12v40.713h81.427zm0 63.978H372.12v40.713h81.427zm0 191.934H372.12v40.714h81.427zm56.242 80.264c-2.326 12.098-16.867 12.388-26.58 12.796H302.326v52.345h-36.119L0 459.566V52.492L267.778 5.904h34.548v46.355h174.66c9.83.407 20.648-.291 29.197 5.583c5.991 8.608 5.41 19.543 5.817 29.43l-.233 302.791c-.29 16.925 1.57 34.2-1.978 50.892m-296.51-91.256c-16.052-32.57-32.395-64.909-48.39-97.48c15.82-31.698 31.408-63.512 46.937-95.327c-13.203.64-26.406 1.454-39.55 2.385c-9.83 23.904-21.288 47.169-28.965 71.888c-7.154-23.323-16.634-45.774-25.3-68.515c-12.796.698-25.592 1.454-38.387 2.21c13.493 29.78 27.86 59.15 40.946 89.104c-15.413 29.081-29.837 58.57-44.785 87.825c12.737.523 25.475 1.047 38.212 1.221c9.074-23.148 20.357-45.424 28.267-69.038c7.096 25.359 19.135 48.798 29.023 73.051c14.017.99 27.976 1.862 41.993 2.676M484.26 79.882H302.326v24.897h46.53v40.713h-46.53v23.265h46.53v40.713h-46.53v23.265h46.53v40.714h-46.53v23.264h46.53v40.714h-46.53v23.264h46.53v40.714h-46.53v26.897H484.26z"/>
                                    </svg>
                                </div>
                            </div> --}}

                                <div class="flex-1 mt-4">
                                    <h4 class="title text-center">No data entry</h4>

                                    <p class="text-muted para mb-0 text-center">
                                        Search all your PDF-JPG-Excel <br>on 1 page
                                    </p>
                                </div>
                            </div><!--end col-->

                        </div><!--end row-->
                    </div><!--end col-->

                    <div class="col-lg-4 col-md-4">
                        <div class="row mt-0">
                            <div class="col-12 mt-2 pt-2">

                                <div class="d-flex features feature-primary justify-content-center">
                                    <div
                                        style="height: 150px; display: flex; justify-content: center; align-items: center; width: 100%; margin-left:25px;">
                                        <svg width="206.75" height="150.75" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill="#666ccc"
                                                d="M19 13a1 1 0 0 0-1 1v.39l-1.48-1.48a2.79 2.79 0 0 0-3.93 0l-.7.7l-2.48-2.49a2.87 2.87 0 0 0-3.93 0L4 12.61V7a1 1 0 0 1 1-1h4a1 1 0 0 0 0-2H5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-5a1 1 0 0 0-1-1M5 20a1 1 0 0 1-1-1v-3.57l2.9-2.89a.79.79 0 0 1 1.09 0l3.17 3.17L15.45 20Zm13-1a1 1 0 0 1-.18.54L13.31 15l.7-.69a.77.77 0 0 1 1.1 0L18 17.22Zm3.71-8.71L20 8.57a4.31 4.31 0 1 0-6.72.79a4.27 4.27 0 0 0 3 1.26a4.34 4.34 0 0 0 2.29-.62l1.72 1.73a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.44M18 8a2.32 2.32 0 1 1 0-3.27A2.32 2.32 0 0 1 18 8" />
                                        </svg>
                                    </div>
                                </div>

                                <div class="flex-1 mt-4">
                                    <h4 class="title text-center">Image Search</h4>
                                    <p class="text-muted para mb-0 text-center">
                                        With 121-AI Support search across all vendors and products
                                    </p>
                                </div>

                            </div><!--end col-->

                        </div><!--end row-->
                    </div><!--end col-->


                    <div class="col-lg-4 col-md-4">
                        <div class="row">
                            <div class="col-12 mt-2 pt-2">
                                {{-- <div class=" features feature-primary"> --}}
                                    {{-- <div style="height: 150px;justify-content: center;width: 100%">
                                        <img src="{{ asset('frontend\assets\website\client.png') }}"
                                            alt="image-search.png"
                                            style="object-fit: contain;height: 100%;width: 100%;margin: auto">
                                    </div> --}}
                                    <div class="d-flex features feature-primary justify-content-center">
                                        <div
                                            style="height: 150px; display: flex; justify-content: center; align-items: center; width: 100%; margin-left:25px;">
                                            {{-- <svg width="206.75" height="150.75" viewBox="0 0 34 32" xmlns="http://www.w3.org/2000/svg">
                                                <g fill="#666ccc">
                                                    <path d="M1.512 28H19.5c.827 0 1.5-.673 1.5-1.5v-19c0-.023-.01-.043-.013-.065a.426.426 0 0 0-.013-.062a.488.488 0 0 0-.122-.227L13.853.147a.507.507 0 0 0-.289-.135C13.543.01 13.523 0 13.5 0H1.506C.676 0 0 .673 0 1.5v25c0 .827.678 1.5 1.512 1.5M14 1.707L19.293 7H14.5a.5.5 0 0 1-.5-.5zM1 1.5c0-.276.227-.5.506-.5H13v5.5c0 .827.673 1.5 1.5 1.5H20v18.5a.5.5 0 0 1-.5.5H1.512A.506.506 0 0 1 1 26.5z"/>
                                                    <path d="M4.5 12h12a.5.5 0 0 0 0-1h-12a.5.5 0 0 0 0 1m0 4h12a.5.5 0 0 0 0-1h-12a.5.5 0 0 0 0 1m0-8h5a.5.5 0 0 0 0-1h-5a.5.5 0 0 0 0 1m0 12h12a.5.5 0 0 0 0-1h-12a.5.5 0 0 0 0 1m0 4h12a.5.5 0 0 0 0-1h-12a.5.5 0 0 0 0 1"/>
                                                    <path d="M21.5 5H26v5.5c0 .827.673 1.5 1.5 1.5H33v18.5a.5.5 0 0 1-.5.5H14.512a.506.506 0 0 1-.512-.5v-1a.5.5 0 0 0-1 0v1c0 .827.678 1.5 1.512 1.5H32.5c.827 0 1.5-.673 1.5-1.5v-19c0-.023-.01-.043-.013-.065a.426.426 0 0 0-.013-.062a.488.488 0 0 0-.122-.227l-6.999-6.999a.491.491 0 0 0-.289-.134C26.543 4.01 26.523 4 26.5 4h-5a.5.5 0 0 0 0 1m6 6a.5.5 0 0 1-.5-.5V5.707L32.293 11z"/>
                                                    <path d="M23.5 16h6a.5.5 0 0 0 0-1h-6a.5.5 0 0 0 0 1m0 4h6a.5.5 0 0 0 0-1h-6a.5.5 0 0 0 0 1m0 4h6a.5.5 0 0 0 0-1h-6a.5.5 0 0 0 0 1m0 4h6a.5.5 0 0 0 0-1h-6a.5.5 0 0 0 0 1"/>
                                                </g>
                                            </svg> --}}
                                            <svg width="206.75" height="150.75" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                                <path fill="#666ccc" fill-rule="evenodd" d="M13.5 6v5.5h-8v-10H9v2.75C9 5.216 9.784 6 10.75 6zm-3-4.379L13.379 4.5H10.75a.25.25 0 0 1-.25-.25zM5 0a1 1 0 0 0-1 1v2H2.25C1.56 3 1 3.56 1 4.25v10.5c0 .69.56 1.25 1.25 1.25h8.25c.69 0 1.25-.56 1.25-1.25v-1.67a.756.756 0 0 0-.004-.08H14a1 1 0 0 0 1-1V4.414a1 1 0 0 0-.293-.707L11.293.293A1 1 0 0 0 10.586 0zM4 12V4.5H2.5v10h7.75v-1.42c0-.027.001-.054.004-.08H5a1 1 0 0 1-1-1" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                {{-- </div> --}}
                                <div class="flex-1 mt-4">
                                    <h4 class="title text-center">Fast Custom Offers </h4>
                                    <p class="text-muted para mb-0 text-center">
                                        Generate Tailored Offers in PDF, PPT, Excel.
                                    </p>
                                    <br>

                                </div>

                            </div><!--end col-->

                        </div><!--end row-->
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end row-->

            <div class="row justify-content-center align-items-center">
                <div class="container mt-50  mb-5">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-lg-4 col-md-6 col-6 d-none d-lg-block">
                            <div class="row mt-0">
                                <div class="col-12 mt-4 pt-2">
                                    <div class="d-flex features feature-primary">
                                        <div class="icon text-center rounded-circle text-primary me-3 mt-2 ">
                                            <svg width="24" height="24" style="line-height: 55px !important;"
                                                viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                                <path fill="currentColor"
                                                    d="M21.053 20.8c-1.132-.453-1.584-1.698-1.584-1.698s-.51.282-.51-.51s.51.51 1.02-2.548c0 0 1.413-.397 1.13-3.68h-.34s.85-3.51 0-4.7c-.85-1.188-1.188-1.98-3.057-2.547s-1.188-.454-2.547-.396c-1.36.058-2.492.793-2.492 1.19c0 0-.85.056-1.188.396c-.34.34-.906 1.924-.906 2.32s.283 3.06.566 3.625l-.337.114c-.284 3.283 1.13 3.68 1.13 3.68c.51 3.058 1.02 1.756 1.02 2.548s-.51.51-.51.51s-.452 1.245-1.584 1.698c-1.132.452-7.416 2.886-7.927 3.396c-.512.51-.454 2.888-.454 2.888H29.43s.06-2.377-.452-2.888c-.51-.51-6.795-2.944-7.927-3.396zm-12.47-.172c-.1-.18-.148-.31-.148-.31s-.432.24-.432-.432s.432.432.864-2.16c0 0 1.2-.335.96-3.118h-.29s.144-.59.238-1.334a10.01 10.01 0 0 1 .037-.996l.038-.426c-.02-.492-.107-.94-.312-1.226c-.72-1.007-1.008-1.68-2.59-2.16c-1.584-.48-1.01-.384-2.16-.335c-1.152.05-2.112.672-2.112 1.01c0 0-.72.047-1.008.335c-.27.27-.705 1.462-.757 1.885v.28c.048.654.26 2.45.47 2.873l-.286.096c-.24 2.782.96 3.118.96 3.118c.43 2.59.863 1.488.863 2.16s-.432.43-.432.43s-.383 1.058-1.343 1.44l-.232.092v5.234h.575c-.03-1.278.077-2.927.746-3.594c.357-.355 1.524-.94 6.353-2.862zm22.33-9.056c-.04-.378-.127-.715-.292-.946c-.718-1.008-1.007-1.68-2.59-2.16c-1.583-.48-1.007-.384-2.16-.335c-1.15.05-2.11.672-2.11 1.01c0 0-.72.047-1.008.335c-.27.272-.71 1.472-.758 1.89h.033l.08.914c.02.23.022.435.027.644c.09.666.21 1.35.33 1.59l-.286.095c-.24 2.782.96 3.118.96 3.118c.432 2.59.863 1.488.863 2.16s-.43.43-.43.43s-.054.143-.164.34c4.77 1.9 5.927 2.48 6.28 2.833c.67.668.774 2.316.745 3.595h.48V21.78l-.05-.022c-.96-.383-1.344-1.44-1.344-1.44s-.433.24-.433-.43s.433.43.864-2.16c0 0 .804-.23.963-1.84V14.66c0-.018 0-.033-.003-.05h-.29s.216-.89.293-1.862v-1.176z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 mt-4">
                                            <h4 class="title">No data feeding</h4>
                                        </div>
                                    </div>
                                </div><!--end col-->

                                <div class="col-12 mt-4 pt-2">
                                    <div class="d-flex features feature-primary">
                                        <div class="icon text-center rounded-circle text-primary me-3 mt-2">
                                            {{-- <i data-feather="monitor" class="fea icon-ex-md"></i> --}}
                                            <svg width="24" height="24" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill="currentColor"
                                                    d="M5 18h6.325q.175.55.4 1.05t.55.95H3V2h18v7.65q-.475-.225-.975-.363T19 9.075V4H5v9h4.2q.225.675.75 1.175t1.175.7q-.075.5-.1 1.012t.05 1.013q-.9-.175-1.687-.663T8 15H5v3Zm0 0h6.325H5Zm12.025 3l-.3-1.5q-.3-.125-.563-.263t-.537-.337l-1.45.45l-1-1.7l1.15-1q-.05-.3-.05-.65t.05-.65l-1.15-1l1-1.7l1.45.45q.275-.2.537-.337t.563-.263l.3-1.5h2l.3 1.5q.3.125.563.263t.537.337l1.45-.45l1 1.7l-1.15 1q.05.3.05.65t-.05.65l1.15 1l-1 1.7l-1.45-.45q-.275.2-.537.338t-.563.262l-.3 1.5h-2Zm1-3q.825 0 1.413-.588T20.024 16q0-.825-.587-1.413T18.025 14q-.825 0-1.412.588T16.024 16q0 .825.588 1.413t1.412.587Z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 mt-4">
                                            <h4 class="title">Place Logos on Products
                                            </h4>
                                            <p class="text-muted para mb-0">
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-4 pt-2">
                                    <div class="d-flex features feature-primary">
                                        <div class="icon text-center rounded-circle text-primary me-3 mt-2">
                                            <i class="fab fa-opera fa-lg"></i>
                                        </div>
                                        <div class="flex-1 mt-4">
                                            <h4 class="title">No app install</h4>
                                            <p class="text-muted para mb-0">
                                            </p>
                                        </div>
                                    </div>
                                </div><!--end col-->


                                <div class="col-12 mt-4 pt-2">
                                    <div class="d-flex features feature-primary">
                                        <div class="icon text-center rounded-circle text-primary me-3 mt-2">
                                            <svg width="24" height="24" viewBox="0 0 32 32"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill="currentColor"
                                                    d="M20 20v-3a4 4 0 0 0-8 0v3a2.002 2.002 0 0 0-2 2v6a2.002 2.002 0 0 0 2 2h8a2.002 2.002 0 0 0 2-2v-6a2.002 2.002 0 0 0-2-2Zm-6-3a2 2 0 0 1 4 0v3h-4Zm-2 11v-6h8l.001 6Z" />
                                                <path fill="currentColor"
                                                    d="M25.829 10.115a10.007 10.007 0 0 0-7.939-7.933a10.002 10.002 0 0 0-11.72 7.933A7.502 7.502 0 0 0 7.491 25H8v-2h-.505a5.502 5.502 0 0 1-.97-10.916l1.35-.245l.259-1.345a8.01 8.01 0 0 1 15.731 0l.259 1.345l1.349.245A5.502 5.502 0 0 1 24.508 23H24v2h.508a7.502 7.502 0 0 0 1.32-14.885Z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 mt-4">
                                            <h4 class="title">Data is private</h4>
                                            <p class="text-muted para mb-0">


                                            </p>
                                        </div>
                                    </div>
                                </div><!--end col-->


                            </div><!--end row-->
                        </div><!--end col-->

                        <div class="col-lg-4 col-md-6 d-none d-lg-block">
                            <div class="row">
                                <div class="col-12 mt-4 pt-2">
                                    <div class="d-flex features feature-primary">
                                        <div class="icon text-center rounded-circle text-primary me-3 mt-2">
                                            <svg width="24" height="24" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="5" cy="19" r="1" fill="currentColor" />
                                                <path fill="currentColor" d="M4 4h2v9H4z" />
                                                <path fill="currentColor"
                                                    d="M7 2H3a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1Zm0 19H3V3h4Zm7-18v7h-3V3h3m1-1h-5v9h5V2Zm6 1v7h-3V3h3m1-1h-5v9h5V2Zm-8 12v7h-3v-7h3m1-1h-5v9h5v-9Zm6 1v7h-3v-7h3m1-1h-5v9h5v-9Z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 mt-4">
                                            <h4 class="title">Unlimited products</h4>
                                            <p class="text-muted para mb-0">


                                            </p>
                                        </div>
                                    </div>
                                </div><!--end col-->



                                <div class="col-12 mt-4 pt-2">
                                    <div class="d-flex features feature-primary">
                                        <div class="icon text-center rounded-circle text-primary me-3 mt-2">
                                            <i class="fas fa-users-cog fa-lg"></i>
                                        </div>
                                        <div class="flex-1 mt-4">
                                            <h4 class="title">Team access controls</h4>
                                        </div>
                                    </div>
                                </div><!--end col-->

                                <div class="col-12 mt-4 pt-2">
                                    <div class="d-flex features feature-primary">
                                        <div class="icon text-center rounded-circle text-primary me-3 mt-2">
                                            {{-- <i data-feather="smartphone" class="fea icon-ex-md"></i> --}}
                                            <svg width="24" height="24" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill="currentColor"
                                                    d="M1 2h22v4h-2V4H3v13h9v2H1V2Zm13 6h10v14H14V8Zm2 2v10h6V10h-6Zm1.998 6.998h2.004v2.004h-2.004v-2.004ZM5 20h7v2H5v-2Z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 mt-4">
                                            <h4 class="title">Access on any device
                                            </h4>
                                            <!-- <p class="text-muted para mb-0">MEGA protects your data from online attacks with
                                                                    zero-knowledge encryption, Simply put - your data
                                                                    is encrypted and only you hold the keys.
                                                                </p> -->
                                        </div>
                                    </div>
                                </div><!--end col-->


                                <div class="col-12 mt-4 pt-2">
                                    <div class="d-flex features feature-primary">
                                        <div class="icon text-center rounded-circle text-primary me-3 mt-2">
                                            <i class="fab fa-android fa-lg"></i>
                                        </div>
                                        <div class="flex-1 mt-4">
                                            <h4 class="title">121 AI Assistant</h4>
                                        </div>
                                    </div>
                                </div><!--end col-->
                            </div>
                        </div><!--end col-->

                        <div class="col-lg-4 col-md-6 d-none d-lg-block">
                            <div class="row">
                                <div class="col-12 mt-4 pt-2">
                                    <div class="d-flex features feature-primary">
                                        <div class="icon text-center rounded-circle text-primary me-3 mt-2">
                                            {{-- <i data-feather="monitor" class="fea icon-ex-md"></i> --}}
                                            <svg width="24" height="24" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="5" cy="19" r="1" fill="currentColor" />
                                                <path fill="currentColor" d="M4 4h2v9H4z" />
                                                <path fill="currentColor"
                                                    d="M7 2H3a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1Zm0 19H3V3h4Zm7-18v7h-3V3h3m1-1h-5v9h5V2Zm6 1v7h-3V3h3m1-1h-5v9h5V2Zm-8 12v7h-3v-7h3m1-1h-5v9h5v-9Zm6 1v7h-3v-7h3m1-1h-5v9h5v-9Z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 mt-4">
                                            <h4 class="title">Searchable PDF, JPEG</h4>
                                            <p class="text-muted para mb-0">

                                            </p>
                                        </div>
                                    </div>
                                </div><!--end col-->

                                <div class="col-12 mt-4 pt-2">
                                    <div class="d-flex features feature-primary">
                                        <div class="icon text-center rounded-circle text-primary me-3 mt-2">
                                            <svg width="24" height="24" viewBox="0 0 48 48"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <rect width="30.766" height="30.766" x="11.991" y="4.626" fill="none"
                                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    rx="3" ry="3" />
                                                <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5.757 12.082v26.544a3 3 0 0 0 3 3h26.544m3.307-32.851h-9.081v15.749l4.541-2.811l4.54 2.811V8.775z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 mt-4">
                                            <h4 class="title">Manage samples
                                            </h4>
                                            <p class="text-muted para mb-0">
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mt-4 pt-2">
                                    <div class="d-flex features feature-primary" style="align-items:center;">
                                        <div class="icon text-center rounded-circle text-primary me-3 mt-2 mb-2">
                                            <svg width="24" height="24" viewBox="0 0 14 14"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g fill="none" stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path
                                                        d="M7.36 13.43h0a1 1 0 0 1-.72 0h0a9.67 9.67 0 0 1-6.14-9V1.5a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v2.92a9.67 9.67 0 0 1-6.14 9.01Z" />
                                                    <rect width="5" height="4" x="4.5" y="5.5" rx="1" />
                                                    <path d="M8.5 5.5v-1a1.5 1.5 0 1 0-3 0v1" />
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="flex-1 mt-4">
                                            <h4 class="title">Data is secure</h4>
                                        </div>
                                    </div>
                                </div><!--end col-->






                                <div class="col-12 mt-4 pt-2">
                                    <div class="d-flex features feature-primary">
                                        <div class="icon text-center rounded-circle text-primary me-3 mt-2">
                                            <i class="fas fa-headset fa-lg"></i>
                                            {{-- <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path fill="currentColor" d="M5 18h6.325q.175.55.4 1.05t.55.95H3V2h18v7.65q-.475-.225-.975-.363T19 9.075V4H5v9h4.2q.225.675.75 1.175t1.175.7q-.075.5-.1 1.012t.05 1.013q-.9-.175-1.687-.663T8 15H5v3Zm0 0h6.325H5Zm12.025 3l-.3-1.5q-.3-.125-.563-.263t-.537-.337l-1.45.45l-1-1.7l1.15-1q-.05-.3-.05-.65t.05-.65l-1.15-1l1-1.7l1.45.45q.275-.2.537-.337t.563-.263l.3-1.5h2l.3 1.5q.3.125.563.263t.537.337l1.45-.45l1 1.7l-1.15 1q.05.3.05.65t-.05.65l1.15 1l-1 1.7l-1.45-.45q-.275.2-.537.338t-.563.262l-.3 1.5h-2Zm1-3q.825 0 1.413-.588T20.024 16q0-.825-.587-1.413T18.025 14q-.825 0-1.412.588T16.024 16q0 .825.588 1.413t1.412.587Z"/>
                                            </svg> --}}
                                            {{-- <svg width="24" height="24" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill="currentColor" d="M18.33 3.57s.27-.8-.31-1.36c-.53-.52-1.22-.24-1.22-.24c-.61.3-5.76 3.47-7.67 5.57c-.86.96-2.06 3.79-1.09 4.82c.92.98 3.96-.17 4.79-1c2.06-2.06 5.21-7.17 5.5-7.79zM1.4 17.65c2.37-1.56 1.46-3.41 3.23-4.64c.93-.65 2.22-.62 3.08.29c.63.67.8 2.57-.16 3.46c-1.57 1.45-4 1.55-6.15.89z"/>
                                            </svg> --}}
                                            {{-- <svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path fill="currentColor" d="M2 6c0-1.505.78-3.08 2-4c0 .845.69 2 2 2a3 3 0 0 1 3 3c0 .386-.079.752-.212 1.091a74.515 74.515 0 0 1 2.191 1.808l-2.08 2.08a75.852 75.852 0 0 1-1.808-2.191A2.977 2.977 0 0 1 6 10c-2.21 0-4-1.79-4-4zm12.152 6.848l1.341-1.341A4.446 4.446 0 0 0 17.5 12A4.5 4.5 0 0 0 22 7.5c0-.725-.188-1.401-.493-2.007L18 9l-2-2l3.507-3.507A4.446 4.446 0 0 0 17.5 3A4.5 4.5 0 0 0 13 7.5c0 .725.188 1.401.493 2.007L3 20l2 2l6.848-6.848a68.562 68.562 0 0 0 5.977 5.449l1.425 1.149l1.5-1.5l-1.149-1.425a68.562 68.562 0 0 0-5.449-5.977z"/>
                                            </svg> --}}
                                        </div>
                                        <div class="flex-1 mt-4">
                                            <h4 class="title">121 Support</h4>
                                            <p class="text-muted para mb-0">


                                            </p>
                                        </div>
                                    </div>
                                </div><!--end col-->


                            </div><!--end row-->
                        </div><!--end col-->


                        {{-- for mobile view --}}
                        <div class="row">

                            <div class="col-6 d-lg-none d-block">
                                <div class="row">
                                    <div class="col-12 mt-4 pt-2">
                                        <div class="d-flex features feature-primary" style="align-items:center;">
                                            <div class="icon text-center rounded-circle text-primary me-3 mt-2 ">
                                                <svg width="24" height="24" style="line-height: 55px !important;"
                                                    viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill="currentColor"
                                                        d="M21.053 20.8c-1.132-.453-1.584-1.698-1.584-1.698s-.51.282-.51-.51s.51.51 1.02-2.548c0 0 1.413-.397 1.13-3.68h-.34s.85-3.51 0-4.7c-.85-1.188-1.188-1.98-3.057-2.547s-1.188-.454-2.547-.396c-1.36.058-2.492.793-2.492 1.19c0 0-.85.056-1.188.396c-.34.34-.906 1.924-.906 2.32s.283 3.06.566 3.625l-.337.114c-.284 3.283 1.13 3.68 1.13 3.68c.51 3.058 1.02 1.756 1.02 2.548s-.51.51-.51.51s-.452 1.245-1.584 1.698c-1.132.452-7.416 2.886-7.927 3.396c-.512.51-.454 2.888-.454 2.888H29.43s.06-2.377-.452-2.888c-.51-.51-6.795-2.944-7.927-3.396zm-12.47-.172c-.1-.18-.148-.31-.148-.31s-.432.24-.432-.432s.432.432.864-2.16c0 0 1.2-.335.96-3.118h-.29s.144-.59.238-1.334a10.01 10.01 0 0 1 .037-.996l.038-.426c-.02-.492-.107-.94-.312-1.226c-.72-1.007-1.008-1.68-2.59-2.16c-1.584-.48-1.01-.384-2.16-.335c-1.152.05-2.112.672-2.112 1.01c0 0-.72.047-1.008.335c-.27.27-.705 1.462-.757 1.885v.28c.048.654.26 2.45.47 2.873l-.286.096c-.24 2.782.96 3.118.96 3.118c.43 2.59.863 1.488.863 2.16s-.432.43-.432.43s-.383 1.058-1.343 1.44l-.232.092v5.234h.575c-.03-1.278.077-2.927.746-3.594c.357-.355 1.524-.94 6.353-2.862zm22.33-9.056c-.04-.378-.127-.715-.292-.946c-.718-1.008-1.007-1.68-2.59-2.16c-1.583-.48-1.007-.384-2.16-.335c-1.15.05-2.11.672-2.11 1.01c0 0-.72.047-1.008.335c-.27.272-.71 1.472-.758 1.89h.033l.08.914c.02.23.022.435.027.644c.09.666.21 1.35.33 1.59l-.286.095c-.24 2.782.96 3.118.96 3.118c.432 2.59.863 1.488.863 2.16s-.43.43-.43.43s-.054.143-.164.34c4.77 1.9 5.927 2.48 6.28 2.833c.67.668.774 2.316.745 3.595h.48V21.78l-.05-.022c-.96-.383-1.344-1.44-1.344-1.44s-.433.24-.433-.43s.433.43.864-2.16c0 0 .804-.23.963-1.84V14.66c0-.018 0-.033-.003-.05h-.29s.216-.89.293-1.862v-1.176z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 mt-4">
                                                <h4 class="title">No data feeding</h4>
                                            </div>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-12 mt-4 pt-2">
                                        <div class="d-flex features feature-primary" style="align-items:center;">
                                            <div class="icon text-center rounded-circle text-primary me-3 mt-2">
                                                {{-- <i data-feather="monitor" class="fea icon-ex-md"></i> --}}
                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill="currentColor"
                                                        d="M5 18h6.325q.175.55.4 1.05t.55.95H3V2h18v7.65q-.475-.225-.975-.363T19 9.075V4H5v9h4.2q.225.675.75 1.175t1.175.7q-.075.5-.1 1.012t.05 1.013q-.9-.175-1.687-.663T8 15H5v3Zm0 0h6.325H5Zm12.025 3l-.3-1.5q-.3-.125-.563-.263t-.537-.337l-1.45.45l-1-1.7l1.15-1q-.05-.3-.05-.65t.05-.65l-1.15-1l1-1.7l1.45.45q.275-.2.537-.337t.563-.263l.3-1.5h2l.3 1.5q.3.125.563.263t.537.337l1.45-.45l1 1.7l-1.15 1q.05.3.05.65t-.05.65l1.15 1l-1 1.7l-1.45-.45q-.275.2-.537.338t-.563.262l-.3 1.5h-2Zm1-3q.825 0 1.413-.588T20.024 16q0-.825-.587-1.413T18.025 14q-.825 0-1.412.588T16.024 16q0 .825.588 1.413t1.412.587Z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 mt-4">
                                                <h4 class="title">Place Logos on Products
                                                </h4>
                                                <p class="text-muted para mb-0">
                                                </p>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-12 mt-4 pt-2">
                                        <div class="d-flex features feature-primary" style="align-items:center;">
                                            <div class="icon text-center rounded-circle text-primary me-3 mt-2 mb-2">
                                                <i class="fas fa-users-cog fa-lg"></i>
                                            </div>
                                            <div class="flex-1 mt-4">
                                                <h4 class="title">Team access controls</h4>
                                            </div>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-12 mt-4 pt-2">
                                        <div class="d-flex features feature-primary" style="align-items:center;">
                                            <div class="icon text-center rounded-circle text-primary me-3 mt-2">
                                                <i class="fab fa-opera fa-lg"></i>
                                            </div>
                                            <div class="flex-1 mt-4">
                                                <h4 class="title">No app install</h4>
                                                <p class="text-muted para mb-0">
                                                </p>
                                            </div>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-12 mt-4 pt-2">
                                        <div class="d-flex features feature-primary">
                                            <div class="icon text-center rounded-circle text-primary me-3 mt-2">
                                                <svg width="24" height="24" viewBox="0 0 14 14"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path
                                                            d="M7.36 13.43h0a1 1 0 0 1-.72 0h0a9.67 9.67 0 0 1-6.14-9V1.5a1 1 0 0 1 1-1h11a1 1 0 0 1 1 1v2.92a9.67 9.67 0 0 1-6.14 9.01Z" />
                                                        <rect width="5" height="4" x="4.5" y="5.5" rx="1" />
                                                        <path d="M8.5 5.5v-1a1.5 1.5 0 1 0-3 0v1" />
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="flex-1 mt-4">
                                                <h4 class="title">Data is secure</h4>
                                            </div>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-12 mt-4 pt-2">
                                        <div class="d-flex features feature-primary mt-3" style="align-items:center;">
                                            <div class="icon text-center rounded-circle text-primary me-3 mt-2 mb-2">
                                                <i class="fab fa-android fa-lg"></i>
                                            </div>
                                            <div class="flex-1 mt-4">
                                                <h4 class="title">121 AI Assistant</h4>
                                            </div>
                                        </div>
                                    </div><!--end col-->

                                </div><!--end row-->
                            </div><!--end col-->


                            <div class="col-6 d-lg-none d-block">
                                <div class="row">
                                    <div class="col-12 mt-4 pt-2">
                                        <div class="d-flex features feature-primary" style="align-items:center;">
                                            <div class="icon text-center rounded-circle text-primary me-3 mt-2">
                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="5" cy="19" r="1" fill="currentColor" />
                                                    <path fill="currentColor" d="M4 4h2v9H4z" />
                                                    <path fill="currentColor"
                                                        d="M7 2H3a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1Zm0 19H3V3h4Zm7-18v7h-3V3h3m1-1h-5v9h5V2Zm6 1v7h-3V3h3m1-1h-5v9h5V2Zm-8 12v7h-3v-7h3m1-1h-5v9h5v-9Zm6 1v7h-3v-7h3m1-1h-5v9h5v-9Z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 mt-4">
                                                <h4 class="title">Unlimited products</h4>

                                            </div>
                                        </div>
                                    </div><!--end col-->


                                    <div class="col-12 mt-4 pt-2">
                                        <div class="d-flex features feature-primary" style="align-items:center;">
                                            <div class="icon text-center rounded-circle text-primary me-3 mt-2">
                                                {{-- <i data-feather="monitor" class="fea icon-ex-md"></i> --}}
                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="5" cy="19" r="1" fill="currentColor" />
                                                    <path fill="currentColor" d="M4 4h2v9H4z" />
                                                    <path fill="currentColor"
                                                        d="M7 2H3a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1Zm0 19H3V3h4Zm7-18v7h-3V3h3m1-1h-5v9h5V2Zm6 1v7h-3V3h3m1-1h-5v9h5V2Zm-8 12v7h-3v-7h3m1-1h-5v9h5v-9Zm6 1v7h-3v-7h3m1-1h-5v9h5v-9Z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 mt-4">
                                                <h4 class="title">Searchable PDF, JPEG</h4>
                                                <p class="text-muted para mb-4">

                                                </p>
                                            </div>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-12 mt-4 pt-2">
                                        <div class="d-flex features feature-primary" style="align-items:center;">
                                            <div class="icon text-center rounded-circle text-primary me-3 mt-2">
                                                <svg width="24" height="24" viewBox="0 0 48 48"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect width="30.766" height="30.766" x="11.991" y="4.626" fill="none"
                                                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                        rx="3" ry="3" />
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M5.757 12.082v26.544a3 3 0 0 0 3 3h26.544m3.307-32.851h-9.081v15.749l4.541-2.811l4.54 2.811V8.775z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 mt-4">
                                                <h4 class="title">Manage samples
                                                </h4>
                                                <p class="text-muted para mb-0">
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4 pt-2">
                                        <div class="d-flex features feature-primary" style="align-items:center;">
                                            <div class="icon text-center rounded-circle text-primary me-3 mt-4  ">
                                                {{-- <i data-feather="smartphone" class="fea icon-ex-md"></i> --}}
                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill="currentColor"
                                                        d="M1 2h22v4h-2V4H3v13h9v2H1V2Zm13 6h10v14H14V8Zm2 2v10h6V10h-6Zm1.998 6.998h2.004v2.004h-2.004v-2.004ZM5 20h7v2H5v-2Z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 mt-4 text-justify">
                                                <h4 class="title">Access on any device
                                                </h4>
                                                <!-- <p class="text-muted para mb-0">MEGA protects your data from online attacks with
                                                                        zero-knowledge encryption, Simply put - your data
                                                                        is encrypted and only you hold the keys.
                                                                    </p> -->
                                            </div>
                                        </div>
                                    </div><!--end col-->


                                    <div class="col-12 mt-4 pt-2">
                                        <div class="d-flex features feature-primary" style="align-items:center;">
                                            <div class="icon text-center rounded-circle text-primary me-3 mt-2">
                                                <svg width="24" height="24" viewBox="0 0 32 32"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill="currentColor"
                                                        d="M20 20v-3a4 4 0 0 0-8 0v3a2.002 2.002 0 0 0-2 2v6a2.002 2.002 0 0 0 2 2h8a2.002 2.002 0 0 0 2-2v-6a2.002 2.002 0 0 0-2-2Zm-6-3a2 2 0 0 1 4 0v3h-4Zm-2 11v-6h8l.001 6Z" />
                                                    <path fill="currentColor"
                                                        d="M25.829 10.115a10.007 10.007 0 0 0-7.939-7.933a10.002 10.002 0 0 0-11.72 7.933A7.502 7.502 0 0 0 7.491 25H8v-2h-.505a5.502 5.502 0 0 1-.97-10.916l1.35-.245l.259-1.345a8.01 8.01 0 0 1 15.731 0l.259 1.345l1.349.245A5.502 5.502 0 0 1 24.508 23H24v2h.508a7.502 7.502 0 0 0 1.32-14.885Z" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 mt-4">
                                                <h4 class="title">Data is private</h4>
                                                <p class="text-muted para mb-0">


                                                </p>
                                            </div>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-12 mt-4 pt-2">
                                        <div class="d-flex features feature-primary mt-3" style="align-items:center;">
                                            <div
                                                class="icon text-center rounded-circle text-primary justify-content-center me-3 mt-2 mb-2">
                                                <i class="fas fa-headset fa-lg"></i>
                                            </div>
                                            <div class="flex-1 mt-4">
                                                <h4 class="title">121 Support</h4>

                                            </div>
                                        </div>
                                    </div><!--end col-->


                                </div><!--end row-->
                            </div><!--end col-->
                        </div>
                    </div><!--end row-->

                </div><!--end container-->
            </div>



        </div><!--end container-->


        <div class="container " id="faq" style="padding-top: 80px; margin-bottom: 0">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="section-title text-center pb-2 wow animate__animated animate__fadeInUp"
                        data-wow-delay=".1s">
                        <h4 class="title text-primary ">Frequently Asked Questions (FAQs)</h4>
                        <!-- <p class="text-muted para-desc mb-0 mx-auto">Top 5 objections that ppl need to settle before they feel comfortable taking next step</p> -->
                    </div>
                </div><!--end col-->
            </div><!--end row-->

            <div class="row align-items-center">
                <div class="col-md-6 mt-4 pt-2">
                    {{-- <div class="bg-half-260 overflow-hidden rounded-md shadow-md jarallax" data-jarallax data-speed="0.5" style="background: url('{{ asset('frontend/assets/img/cta.jpg') }}'); background-size: cover; background-position: center;">
					</div> --}}
                    <div class="bg-half-260 overflow-hidden rounded-md shadow-md jarallax" data-jarallax data-speed="0.5"
                        style="background: url('{{ asset('frontend/assets/img/cta.jpg') }}'); background-size: cover; background-position: center; height: 300px; overflow: scroll;">
                    </div>


                </div><!--end col-->

                <div class="col-md-6 mt-4 pt-2">
                    <div class="accordion" id="accordionExample">

                        <div class="accordion-item rounded shadow wow animate__animated animate__fadeInUp"
                            data-wow-delay=".5s">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button border-0 bg-light" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                    aria-controls="collapseOne">
                                    Do I need to install app on my phone or laptop/PC?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse border-0 collapse show"
                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body text-muted">
                                    <p>No need for installations on your mobile, laptop, or PC</p>

                                    {{-- <p>121 still supports Windows, Apple iOS and Android.</p> --}}

                                </div>
                            </div>
                        </div>

                        <div class="accordion-item rounded shadow mt-3 wow animate__animated animate__fadeInUp"
                        data-wow-delay=".7s">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button border-0 bg-light collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                    aria-controls="collapseTwo">
                                    Do I need to upload and enter catalogue and price list?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse border-0 collapse"
                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body text-muted">
                                <p>No need! </p>

                                    <p>Just upload your product images - old and new products when developed. </p>

                                <p>Then, find products easily with image search. </p>
                                <p>With Asset Vault, store and searchify all your assets including images, pdf, design files.</p>


                                </div>
                            </div>
                        </div>

                        <div class="accordion-item rounded shadow mt-3 wow animate__animated animate__fadeInUp"
                        data-wow-delay="0.9">
                            <h2 class="accordion-header" id="headingthree">
                                <button class="accordion-button border-0 bg-light collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapsethree" aria-expanded="false"
                                    aria-controls="collapsethree">
                                    If I currently organize data using folders and internal WhatsApp groups - how can 121
                                    benefit me?
                                </button>
                            </h2>
                            <div id="collapsethree" class="accordion-collapse border-0 collapse"
                                aria-labelledby="headingthree" data-bs-parent="#accordionExample">
                                <div class="accordion-body text-muted">
                                <p> Whether you're managing data on the cloud or a pen drive - dealing with catalogues in
                                    different formats across various mediums can be challenging and prone to errors.</p>

                                    With 121, we simplify this process by keeping all your catalogues searchable and ready
                                    for use, eliminating the need for manual data entry.


                                </div>
                            </div>
                        </div>


                        <div class="accordion-item rounded shadow mt-3 wow animate__animated animate__fadeInUp"
                            data-wow-delay="1.1s">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button border-0 bg-light collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false"
                                    aria-controls="collapseFour">
                                    If I majorly get orders from trade expo, will 121 benefit me?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse border-0 collapse"
                                aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                <div class="accordion-body text-muted">
                                    <p>Definitely! 121 will help if your product range exceeds 100 items.
                                   </p>
                                    <p>With 121, organise your product images and track samples ahead of the next trade expo.
                                    </p>
                                    <p>Not just this, search across old and new product images to answer you buyer inquiries all year round. All this, without the need for manual data entry - not even once.</p>
                                    <p>121 stands out as the unique solution crafted (and priced) for small to medium-sized business owners.
                                    </p>
                                </div>
                            </div>
                        </div>


                        <div class="accordion-item rounded shadow mt-3 wow animate__animated animate__fadeInUp"
                        data-wow-delay="1.3s">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button border-0 bg-light collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false"
                                aria-controls="collapseFive">
                                Will 121 sell or share my business data?

                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse border-0 collapse"
                            aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                            <div class="accordion-body text-muted">
                            <p> Your data's privacy is super important to us! (be it products, vendors, pricing or any
                                other information you save on 121). </p>
                            <p>  Just so you know, we're a SAAS tool (Software as a Service), not a business directory.</p>
                                <p> We won't ever sell or share your precious info with marketers or anyone else.</p>
                            </div>
                        </div>
                    </div>



                    <div class="accordion-item rounded shadow mt-3 wow animate__animated animate__fadeInUp"
                        data-wow-delay="1.5s">
                        <h2 class="accordion-header" id="headingSix">
                            <button class="accordion-button border-0 bg-light collapsed" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false"
                                aria-controls="collapseSix">
                                Do I need an IT team to use 121 ?
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse border-0 collapse"
                            aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                            <div class="accordion-body text-muted">
                                Not at all ! You can use all of the features available on 121 without a technical team.
                                Our platform is easy to use so you don’t have to hire any specialized help to do
                                everything you want.
                            </div>
                        </div>
                    </div>

                        <div class="accordion-item rounded shadow mt-3 wow animate__animated animate__fadeInUp"
                            data-wow-delay="1.7s">
                            <h2 class="accordion-header" id="headingSeven">
                                <button class="accordion-button border-0 bg-light collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false"
                                    aria-controls="collapseSeven">
                                    Where is my data stored and what technology does 121 run on?
                                </button>
                            </h2>
                            <div id="collapseSeven" class="accordion-collapse border-0 collapse"
                                aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                <div class="accordion-body text-muted">
                                    All files are stored in Tier 3 Data Center in Noida, Delhi-NCR. This is the cloud
                                    service with the highest security available, and allows the system to run fast in all
                                    parts of the world.

                                </div>
                            </div>
                        </div>



                        <div class="accordion-item rounded shadow mt-3 wow animate__animated animate__fadeInUp"
                            data-wow-delay="1.9s">
                            <h2 class="accordion-header" id="headingEight">
                                <button class="accordion-button border-0 bg-light collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="false"
                                    aria-controls="collapseEight">
                                    How much does this cost?
                                </button>
                            </h2>
                            <div id="collapseEight" class="accordion-collapse border-0 collapse"
                                aria-labelledby="headingEight" data-bs-parent="#accordionExample">
                                <div class="accordion-body text-muted">
                                    121 service is at a fraction of the cost compared to the expenses involved in building,
                                    hosting, training a team, and keeping everything up to date, enabling you to focus on
                                    your core business while we handle the rest.
                                    <a href="{{ url('start') }}" class="btn-link"><b>Book your 7 mins demo</b></a> to get
                                    custom package based on your requirement.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item rounded shadow mt-3 wow animate__animated animate__fadeInUp"
                            data-wow-delay="2.1s">
                            <h2 class="accordion-header" id="headingNine">
                                <button class="accordion-button border-0 bg-light collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="false"
                                    aria-controls="collapseNine">
                                    How can I get started ?
                                </button>
                            </h2>
                            <div id="collapseNine" class="accordion-collapse border-0 collapse"
                                aria-labelledby="headingNine" data-bs-parent="#accordionExample">
                                <div class="accordion-body text-muted">
                                    <p> 121 offers a user-friendly and intuitive interface from mobile.</p>
                                    <p>Sign-up and know more on how to get started for Free.</p>
                                    <p class="mt-2" style="text-decoration:underline;">
                                        <a href="{{ url('register') }}" class="btn-link"><b>Get Started - for Free</b></a>.
                                    </p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div><!--end col-->


                <div class="subscribe-form mt-2 py-2 text-center">
                    <form class="m-0 d-inline-block" style="text-decoration-color: white">

                            <a href="{{ url('register') }}" class="btn btn-pills btn-primary" style="color: white;">
                                Know More
                                <i class="uil uil-arrow-right"></i>
                            </a>


                    </form><!--end form-->
                </div>

            </div><!--end row-->


        </div><!--end container-->
    </section><!--end section-->
    <!-- End -->




   

    <!-- Back to top -->
    <a href="#" onclick="topFunction()" id="back-to-top" class="back-to-top fs-5"><i data-feather="arrow-up"
            class="fea icon-sm icons align-middle"></i></a>
    <!-- Back to top -->
@endsection

@push('script')
    <script async src="https://unpkg.com/typer-dot-js@0.1.0/typer.js"></script>
    <script src="https://unpkg.com/jarallax@1.12.0/dist/jarallax.min.js"></script>
@endpush
