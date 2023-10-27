@extends('frontend.layouts.main')

@section('meta_data')
{{-- <title> {{ $blog->title }} </title> --}}
    @php
		$meta_title =  $blog->title. ' | ' .getSetting('app_name');		
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

@section('content')
<style>
    blockquote{
        font-size: 13px;
    }
</style>

    <div class="position-relative">
        <div class="shape overflow-hidden text-white">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
            </svg>
        </div>
    </div>
  
    
        <!-- Blog STart -->
        <section class="section">
            <div class="container">
                <div class="row">
                    <!-- BLog Start -->
                    <div class="col-lg-8 mx-auto">
                        <div class="card blog blog-detail border-0 shadow rounded">
                            <img src="{{ getBlogImage($blog->description_banner) }}" class="img-fluid rounded-top" alt="">
                            <div class="card-body content">
                                <h3>{{ $blog->title }}</h3>
                                <h6><i class="mdi mdi-tag text-primary me-1"></i><a href="javscript:void(0)" class="text-primary">{{ fetchFirst('App\Models\Category',$blog->category_id,'name') }}</a>
                                <p class="text-muted">{!! $blog->short_description !!}</p>
                                <p class="text-muted my-3">{!! $blog->description !!}</p>
                                <hr>
                                <div class="d-flex mb-2">
                                    @php
                                        $authorRecord = App\User::whereId($blog->user_id)->first();
                                    @endphp
                                    <div style="width:80px">
                                        <img src="{{ ($authorRecord && $authorRecord->avatar) ? $authorRecord->avatar : asset('backend/default/default-avatar.png') }}" class="img-fluid avatar avatar-small rounded-pill shadow-md d-block mx-auto" alt="Author Image">
                                    </div>
                                    <div>
                                        <a href="" class="text-primary h5 mt-4 mb-0 d-block">{{ $authorRecord->name ?? '' }}</a>
                                        <small class="text-muted d-block">Author</small>
                                    </div>
                                </div>
                                <div>
                                    <blockquote class="quote">{{ $authorRecord->bio ?? '' }}</blockquote>
                                </div>
                            </div>
                        </div>
                        @if ($relatedBlogs->count() > 0)
                            <div class="card shadow rounded border-0 mt-4">
                                <div class="card-body">
                                    <h5 class="card-title mb-0">Related Posts :</h5>

                                    <div class="row">
                                        @foreach ($relatedBlogs as $relatedBlogs)
                                            <div class="col-lg-6 mt-4 pt-2">
                                                <div class="card blog blog-primary rounded border-0 shadow">
                                                    <div class="position-relative">
                                                        <img src="{{ getBlogImage($relatedBlogs->description_banner) }}" class="card-img-top rounded-top" alt="...">
                                                    <div class="overlay rounded-top"></div>
                                                    </div>
                                                    <div class="card-body content">
                                                        <h5><a href="javascript:void(0)" class="card-title title text-dark">{{ $blog->title }}</a></h5>
                                                        <div class="post-meta d-flex justify-content-between mt-3">
                                                        
                                                            <a href="{{ route('blog.show',$relatedBlogs->id) }}" class="text-muted readmore">Read More <i class="uil uil-angle-right-b align-middle"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--end col-->
                                        @endforeach
                                        
                                    </div><!--end row-->
                                </div>
                            </div>
                        @endif
                    </div>
                    <!-- BLog End -->

                    <!-- START SIDEBAR -->
                    @if ($recentBlogs->count() > 0)
                        <div class="col-lg-4 col-md-6 col-12 mt-4 mt-sm-0 pt-2 pt-sm-0">
                            <div class="card border-0 sticky-bar ms-lg-4 shadow">
                                <div class="card-body p-0">
                                    <!-- RECENT POST -->
                                    <div class="widget mt-4">
                                        <span class="bg-light d-block py-2 rounded shadow text-center h6 mb-0">
                                            Recent Posts
                                        </span>
                                        <div class="mt-4">
                                            @foreach ($recentBlogs as $recentBlog)
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ getBlogImage($recentBlog->description_banner) }}" class="avatar avatar-small rounded" style="width: auto;" alt="">
                                                    <div class="flex-1 ms-3">
                                                        <a href="javascript:void(0)" class="d-block title text-dark">{{ $recentBlog->title }}</a>
                                                        <span class="text-muted">{{ getFormattedDate($recentBlog->created_at) }}</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <!-- RECENT POST -->
                                </div>
                            </div>
                        </div><!--end col-->
                        <!-- END SIDEBAR -->
                    @endif
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- Blog End -->



@endsection

@push('script')

@endpush