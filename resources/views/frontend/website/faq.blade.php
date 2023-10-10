@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = "Faq's | ".getSetting('app_name');		
		$meta_description = 'If you have any query, feel free to contact us!' ?? getSetting('seo_meta_description');
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


@section('content')
<!-- Shape Start -->

        

<section class="bg-half-170 bg-light d-table w-100">
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="pages-heading">
                    <h4 class="title mb-0 page-title">@if(request()->has('category_id')) {{ fetchFirst('App\Models\Category',request()->get('category_id'),'name')  }} @else Faq's @endif</h4>
                </div>
            </div>  <!--end col-->
        </div><!--end row-->
        
        <div class="position-breadcrumb">
            <nav aria-label="breadcrumb" class="d-inline-block">
                <ul class="breadcrumb rounded shadow mb-0 px-4 py-2">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Faq</li>
                </ul>
            </nav>
        </div>
    </div> <!--end container-->
</section><!--end section-->
        <!-- Hero End -->
        <div class="position-relative">
            <div class="shape overflow-hidden text-white">
                <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
                </svg>
            </div>
        </div>
<!--Shape End-->

 <!-- Start Section -->
        <section class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-5 col-12 d-none d-md-block">
                        <div class="rounded shadow p-4 sticky-bar">
                            
                            <ul class="list-unstyled sidebar-nav mb-0 py-0" id="navmenu-nav">
                                @foreach (fetchGet('App\Models\Category', 'where', 'category_type_id', '=', 12) as $category)
                                    <li class="navbar-item p-0 pb-3   " data-id="{{$category->id}}">
                                        <a data-id="{{ $category->id }}" href="{{ route('website.faq',['category_id' => $category->id]) }}" class="h6 text-dark navbar-link faq-sidebar ">{{ $category->name }}</a> 
                                        {{-- <i class="uil uil-angle-double-right arrow-icon" id="icon{{ $category->id }}"></i> --}}
                                    </li>
                                @endforeach
                                
                            </ul>
                        </div>
                    </div><!--end col-->

                    <div class="col-lg-8 col-md-7 col-12">
                        @if (request()->has('category_id'))
                            @forelse ($categories as $category)
                                @if(App\Models\Faq::whereCategoryId($category->id)->where('is_publish',1)->get()->count() > 0)
                                    <div class="section-title" id="cat{{ $category->id }}">
                                        <div class="accordion" id="{{ $category->id }}question">
                                                <div class="accordion-item rounded">
                                                    @php
                                                        $faqs = App\Models\Faq::whereCategoryId($category->id)->where('is_publish',1)->latest()->simplePaginate(20);
                                                    @endphp
                                                    @foreach($faqs as $faq)
                                                        <h2 class="accordion-header" id="heading{{ $faq->id }}">
                                                            <button class="accordion-button border-0 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq->id }}"
                                                                aria-expanded="true" aria-controls="collapse{{ $faq->id }}">
                                                                {{ $faq->title }}
                                                            </button>
                                                        </h2>
                                                        <div id="collapse{{ $faq->id }}" class="accordion-collapse border-0 collapse @if($loop->iteration == 1) show @endif" aria-labelledby="heading{{ $faq->id }}"
                                                            data-bs-parent="#buyingquestion">
                                                            <div class="accordion-body text-muted">
                                                                {{ $faq->description }}
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                        </div>
                                    </div>
                                @else 
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mx-auto text-center">
                                            <img src="{{ asset('frontend/assets/img/empty.svg') }}" alt="Empty Image" style="width: 30%;">
                                            <p>No Records!</p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @empty     
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mx-auto text-center">
                                            <img src="{{ asset('frontend/assets/img/empty.svg') }}" alt="Empty Image" style="width: 30%;">
                                            <p>No Records!</p>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                            <div class="mx-auto text-center">
                                {{ $faqs->links() }}
                            </div>
                        @else
                            <div class="rounded shadow">
                                <div class="card">
                                    <div class="card-body text-center mx-auto">
                                        <img src="{{ asset('frontend/assets/img/welcome-cuate.png') }}" alt="Welcome Image" style=" width: 70%;">
                                        <h6>Welcome to {{ getSetting('app_name') }}</h6>
                                        <p>Please select the category you want to ask us</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        


                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->

            <div class="container mt-100 mt-60">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="d-flex align-items-center features feature-primary feature-clean shadow rounded p-4">
                            <div class="icons text-center">
                                <i class="uil uil-envelope-check d-block rounded h3 mb-0"></i>
                            </div>
                            <div class="flex-1 content ms-4">
                                <h5 class="mb-1"><a href="javascript:void(0)" class="text-dark">Get in Touch !</a></h5>
                                <p class="text-muted mb-0">This is required when, for text is not yet available.</p>
                                <div class="mt-2">
                                    <a href="{{url('contact-us')}}" class="btn btn-sm btn-soft">Submit a Request</a>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                    <div class="col-lg-6 col-md-6 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                        <div class="d-flex align-items-center features feature-primary feature-clean shadow rounded p-4">
                            <div class="icons text-center">
                                <i class="uil uil-webcam d-block rounded h3 mb-0"></i>
                            </div>
                            <div class="flex-1 content ms-4">
                                <h5 class="mb-1"><a href="javascript:void(0)" class="text-dark">Start a Meeting</a></h5>
                                <p class="text-muted mb-0">This is required when, for text is not yet available.</p>
                                <div class="mt-2">
                                    <a href="https://calendly.com/121page/double-your-b2b-business-121-now?month=2022-05" class="btn btn-sm btn-soft">Start Video Chat</a>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- End Section -->

@endsection

@push('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
<script>
    $('.navbar-item').removeClass('active');
    $(document).ready(function(){
        $('.navbar-item').removeClass('active');
        
        @if(request()->get('category_id'))
        var cat = "{{request()->get('category_id')}}";
        $('.navbar-item').each(function(){
            var cat_id = $(this).data('id');
            if(cat_id == cat){
                $(this).addClass('active');
            }
        })
        @endif
    })
</script>

@endpush        