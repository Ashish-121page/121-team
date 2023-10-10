@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = $article->seo_title ?? $article->title.' | '.getSetting('app_name');		
		$meta_description = $article->short_description ?? getSetting('seo_meta_description');
		$meta_keywords = $article->seo_keywords.'' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'GRPL';		
		$meta_author_email = '' ?? 'Hello@121.page';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';		
	@endphp
@endsection

@section('content')
    <div class="container ">
        <div class="row">
            <div class="col-12">
                <div class="card" style="margin-top: 110px;border:none;">
                    <div class="d-md-flex justify-content-between">
                        <h3>{{ $article->title }}</h3>
                        <div>
                            <small><strong>Author:</strong>{{ fetchFirst('App\User',$article->user_id,'name','') }}</small>
                            <small class="ml-5"><strong>Category:</strong>{{ fetchFirst('App\Models\Category',$article->category_id,'name','') }}</small>
                        </div>
                    </div>
                    <img  src="{{ asset('storage/backend/article/'.$article->description_banner) }}" alt="">
                    <p>{!! $article->description !!}</p>
                </div>

            </div>
        </div>
    </div>
@endsection