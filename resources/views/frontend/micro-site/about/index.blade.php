@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = 'About Us | '.getSetting('app_name');		
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'GRPL';		
		$meta_author_email = '' ?? 'Hello@121.page';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';		
		$microsite = 1;		
	@endphp
@endsection
@section('content')
<style>
    .img::before, .img::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        z-index: 5;
    }
    .img::before {
        width: 48px;
        height: 48px;
        margin: -24px 0 0 -24px;
        background-color: #333;
        border-radius: 50%;
    }
    .img::after {
        margin: -8px 0 0 -6px;
        border-style: solid;
        border-width: 8px 0 8px 16px;
        border-color: transparent transparent transparent #fff;
    }

</style>
    <section class="bg-half-170 bg-light d-table w-100 strip-bg-img">
                <div class="container">
                    <div class="row mt-5 justify-content-center">
                        <div class="col-lg-12 text-center">
                            <div class="pages-heading">
                                <h4 class="title mb-0">About Us</h4>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                    
                    <div class="position-breadcrumb">
                        <nav aria-label="breadcrumb" class="d-inline-block">
                            <ul class="breadcrumb bg-white rounded shadow mb-0 px-4 py-2">
                                <li class="breadcrumb-item"><a href="{{ route('pages.index',$slug) }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">About</li>
                            </ul>
                        </nav>
                    </div>
                </div> <!--end container-->
    </section><!--end section-->
        <div class="position-relative">
            <div class="shape overflow-hidden text-white">
                <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
                </svg>
            </div>
        </div>
        <!-- Hero End -->

            
        <!-- Start Products -->
        <section class="section" id="story">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 mt-4 pt-2 mt-sm-0 pt-sm-0">
                        <div class="position-relative">
                            <div class="">
                                
                                {{-- @if (isset($about) && @$about['img'] != null)
                                    <img src="{{ asset($about['img']) }}" class="rounded img-fluid mx-auto d-block" alt="" style="height: 300px;width: 100%;object-fit: contain;">
                                @else 
                                    <img src="{{ asset('frontend/assets/img/placeholder.png') }}" class="rounded img-fluid mx-auto d-block" alt="">
                                @endif --}}

                                @php
                                    $vcard = App\Models\Media::whereType('UserVcard')->whereTypeId($user_shop->user_id)->first();
                                @endphp
                                @if (isset($story) && @$story['img'] != null)
                                    <img src="{{ asset($story['img']) }}" class="rounded img-fluid mx-auto d-block" alt="">
                                @elseif($vcard != null)
                                    <img src="{{ asset($vcard->path) }}" class="rounded img-fluid mx-auto d-block" alt="">
                                @else 
                                    <img src="{{ asset('frontend/assets/img/placeholder.png') }}" class="rounded img-fluid mx-auto d-block" alt="">
                                @endif
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="col-lg-6 col-md-6 mt-4 pt-2 mt-sm-0 pt-sm-0">
                        <div class="section-title ms-lg-4">
                            <h4 class="title mb-4">
                                {{ $story['title'] ?? 'User Shop' }}
                                {{-- {{ @$about['title'] ?? 'Our Story'}} --}}
                            </h4>
                            <p class="text-muted">
                                {!! @$story['description'] !!}
                                {{-- {!! @$about['content'] ?? ' '!!}  --}}
                            </p>
                            @if (auth()->user())
                                @if ($story['cta_link'] ?? "" != "")
                                    <a class="btn btn-outline-primary my-3" href="{{$story['cta_link'] ?? "#"}}" download>{{ $story['cta_label'] ?? 'Catalogue' }}</a>
                                @endif
                                
                                @if ($story['prl_link'] ?? ""  != "")
                                <a class="btn btn-outline-danger my-3" href="{{$story['prl_link'] ?? "#"}}" download>{{ $story['prl_label'] ?? '' }}</a>
                                @endif                        
                            @endif
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->

            {{-- <div class="container mt-100 mt-60" id="features">
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <div class="section-title mb-4 pb-2">
                            <h4 class="title mb-4">{{ @$features['title'] ?? 'Our Features' }}</h4>
                            <p class="text-muted para-desc mx-auto mb-0">{{ $features['description'] ?? ' ' }}</p>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->

                @if (isset($features) && @$features['features'])
                    <div class="row">
                        @forelse ($features['features'] as $feature)
                            <div class="col-lg-4 col-md-6 mt-4 pt-2">
                                <div class="d-flex key-feature align-items-center p-3 rounded shadow">
                                    <div class="icon text-center rounded-circle me-3">
                                        <i class="fa {{ @$feature['icon'] }} text-primary"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="title mb-0">{{ @$feature['title'] }}</h4>
                                    </div>
                                </div>
                            </div><!--end col-->
                        @empty
                            <div class="col-lg-4">
                                <div>
                                    <h6>No features added!</h6>
                                </div>
                            </div>
                        @endforelse
                        
                        <div class="col-12 mt-4 pt-2 text-center">
                            <a href="javascript:void(0)" class="btn btn-primary">See More <i class="mdi mdi-arrow-right"></i></a>
                        </div><!--end col-->
                    </div><!--end row-->
                @else
                    
                @endif --}}
            </div><!--end container-->
        </section><!--end section-->
        <!-- About End -->

        @if (json_decode($user_shop->team)->team_visiblity ?? 0)
            
            <!-- Team Start -->
            <section class="section bg-light" id="team">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="section-title pb-2">
                                <h4 class="title mb-4">{{ $team['title'] ?? 'Our Team'}}</h4>
                                <p class="text-muted para-desc mx-auto mb-0">{{ $team['description'] ?? ' '}}</p>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->

                    <div class="row">
                        @foreach (App\Models\Team::whereUserShopId($user_shop->id)->get()->take(4) as $item)
                            <div class="col-lg-3 col-md-6 mt-4 pt-2">
                                <div class="card text-center border-0">
                                    <div class="card-body p-0">
                                        <div class="position-relative">
                                        @if ($item->image != null)
                                            <img src="{{ asset($item->image) }}" class="img-fluid avatar avatar-ex-large rounded-circle" alt="">
                                        @else
                                            <img src="{{ asset('frontend/assets/img/user.jpg') }}" class="img-fluid avatar avatar-ex-large rounded-circle" alt="">
                                        @endif
                                            
                                        </div>
                                        <div class="content pt-3 pb-3">
                                            <h5 class="mb-0"><a href="javascript:void(0)" class="name text-dark">{{ $item->name ?? '' }}</a></h5>
                                            <small class="designation text-muted d-block">{{ $item->designation ?? '' }}</small>
                                            <small class="designation text-muted">{{ $item->contact_number ?? '' }}</small>
                                        </div>                                
                                    </div>
                                </div>
                            </div><!--end col-->
                        @endforeach
                    </div><!--end row-->
                </div><!--end container-->
            </section>
    @endif
    
@include('frontend.micro-site.about.show-video')
@endsection
@section('InlineScript')
    <script>
        let img = document.querySelector('.img');
        function meow (){
            $('#playVideoModal').modal('show');
        }
        img.addEventListener('click', meow, false);
    </script>
@endsection