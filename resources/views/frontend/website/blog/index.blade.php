@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = 'Blogs | '.getSetting('app_name');		
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
    .relative.inline-flex.items-center{
        margin-right: 10px;
        box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    } 
</style>
        @php
            $page_title = 'Blogs';
        @endphp
        @include('frontend.website.breadcrumb')


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
                    @forelse ($blogs as $blog)
                        <div class="col-lg-4 col-md-6 mb-4 pb-2">
                            <div class="card blog blog-primary rounded border-0 shadow overflow-hidden">
                                <div class="position-relative">
                                    <img src="{{ getBlogImage($blog->description_banner) }}" class="card-img-top" alt="...">
                                    <div class="overlay rounded-top"></div>
                                </div>
                                <div class="card-body content">
                                    <h5><a href="{{ route('blog.show',$blog->id) }}" class="card-title title text-dark">{{ $blog->title }}</a></h5>
                                    <div class="post-meta mt-3">
                                        <p>{{ Str::limit($blog->short_description, 200, '...') }}</p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('blog.index',['category_id' =>  $blog->category_id]) }}" class="text-primary" style="font-size: 14px;">{{ categoryNameByID($blog->category_id)->name ?? '--' }}</a>
                                        <a href="{{ route('blog.show',$blog->id) }}" class="text-muted readmore">Read More <i class="uil uil-angle-right-b align-middle"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div><!--end col-->
                    @empty
                        
                    <div class="card text-center">
                        <div class="card-body">
                            <h6>No Blogs!</h6>
                        </div>
                    </div>
                        
                    @endforelse

                    <div class="mx-auto text-center mt-2">
                        {{ $blogs->links() }}
                    </div>

                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- Blog End -->



@endsection

@push('script')

@endpush