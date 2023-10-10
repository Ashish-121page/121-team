@extends('frontend.layouts.main')
@section('meta_data')
    @php
		$meta_title = 'Categories | '.getSetting('app_name');		
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

<section class="section" style="min-height: 88vh;">
    <div class="container mt-5">
        @if(isset($categories) && $categories->count() > 0 && $categories != null)
            <form action="{{ inject_subdomain('shop', $user_shop->slug)}}" method="get" id="" class="row mt-4 p-0 applyFilter">
                <input type="hidden" name="category_id" id="catId">

                @forelse ($categories as $category)
                <div class="col-lg-4 @if($loop->first) mt-lg-0 mt-md-3 mt-5 @endif">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h6>
                                <a href="{{ inject_subdomain('shop', $user_shop->slug, false, false)}}{{'?category_id='.$category->id}}">{{ $category->name ?? '' }}</a>
                            </h6>
                            @php
                                $subcategories = getProductSubCategoryByShop($slug, $category->id, 0)
                            @endphp 
                            <ul class="list-unstyled blog-categories category_list_view">
                                @foreach ($subcategories as $subcategorie)
                                <li>
                                    <h6 class="form-check">
                                            <input class="form-check-input filterCategory" type="radio" value="{{ $subcategorie->id }}" data-cat_id="{{$category->id}}" id="category{{ $subcategorie->id }}" name="sub_category_id" @if(request()->has('sub_category_id') && request()->get('sub_category_id') ==  $subcategorie->id ) checked @endif>
                                            <label for="category{{ $subcategorie->id }}" class="form-check-label fltr-lbl">
                                                {{$subcategorie->name}}</label>
                                    </h6>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @empty
            
                @endforelse
            </form>
        @else
            <div class="text-center mt-5 pt-5">
                <div class="mb-3" style="font-size:40px;">
                    <x-icon name="shopping-cart" style="    height: 60px;
                    width: 130px;" class="feather feather-shopping-cart icons text-primary" />
                </div>
                <p class="text-muted">No Products added yet!</p>
            </div>  
        @endif
    </div>
</section>
@endsection


@section('InlineScript')
    <script>
        $('.filterCategory').on('click', function(){
            $('#catId').val($(this).data('cat_id'))
            $('.applyFilter').submit();
       });
    </script>
@endsection