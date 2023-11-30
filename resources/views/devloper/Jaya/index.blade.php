@extends('frontend.layouts.main')


@section('meta_data')	
    @php
        $user_shop = getShopDataByUserId(auth()->id());
		$meta_title =  $user_shop->meta_title. ' | ' .'Home';	
		$meta_description =  Str::limit($user_shop->meta_description,125) ?? '';	
		$meta_keywords = $user_shop->meta_keywords ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'GRPL';		
		$meta_author_email = '' ?? 'Hello@121.page';		
		$meta_reply_to = '' ?? getSetting('frontend_
        _email');		
		$meta_img = ' ';		
		$microsite = 1;		
	@endphp
@endsection


@section('content')

<section>

	<div class="container mt-5 border">

	<div class="row mt-5">
		<div class="col-sm-6 mb-3 mb-sm-0">
		  <div class="card">
			<img src="asset('frontend/assets/img/placeholder.png') }}" alt="" style="height:185px;" class="rounded-circle img-40 align-top mr-15" class="card-img-top" alt="...">
			{{-- <div class="card-body">
			  <h5 class="card-title">Special title treatment</h5>
			  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
			  <a href="#" class="btn btn-primary">Go somewhere</a>
			</div> --}}

			<div class="card-body content pt-4 p-2">

				<a href="#" class="text-dark product-name h6" contenteditable="true">{{ $product->title }}</a>
				
				{{-- <div style="width:100%">
					<span></span><small contenteditable="true">{{ fetchFirst('App\Models\Category',$product->sub_category_id,'name') }} </small>
				</div> --}}

				@if (isset($product->brand->name) && isset($product->brand->name) != '')
					<p class="mb-0" contenteditable="true"><b>Brand:</b><span>{{ $product->brand->name ?? '--' }}</span></p>
				@endif

				<div style="wdith:100%">
					<small contenteditable="true" >
						
							@if ($proposal_options->show_color)
								{{ $product->color ?? '' }} 
							@endif

							@if ($proposal_options->show_size)
								@if($product->size) , @endif 
								{{ $product->size ?? ''}}
							@endif                                                        
					</small>
				</div>

				{{-- @if($product->user_id == auth()->id()) --}}
					<span contenteditable="true">Model Code :# <span>{{ $product->model_code }}</span></span>
				{{-- @else 
					<span>Ref ID :#{{ isset($usi) ? $usi->id : '' }}</span>
				@endif    --}}
				<div class="d-flex justify-content-between mt-1 text-center">

					@php
						$price = getProductProposalPriceByProposalId($proposal->id,$product->id) ?? $product->price;
						$margin = App\Models\ProposalItem::whereProposalId($proposal->id)->where('product_id',$product->id)->first()->margin ?? 10;
						$user_price = App\Models\ProposalItem::whereProposalId($proposal->id)->where('product_id',$product->id)->first()->user_price ?? null;
						if ($user_price == null) {
							$margin_factor = (100 - $margin) / 100;
							$price = $price/$margin_factor;
						}
						else {
							$price = $user_price;
						}

						$price = number_format(round(exchangerate($price,$exhangerate,$HomeCurrency)),2);
						array_push($ppt_price,( $currency_symbol." ".$price));
					@endphp

					{{-- @if($proposal->enable_price_range == 1)
						<h6 class="text-dark small fst-italic mb-0 mt-1 w-100">
						{{ format_price(($price)-($price*10/100)) }} - {{ format_price(($price)+ ($price*10/100)) }}</h6>
					@else --}}
						<h6 class="text-dark small fst-italic mb-0 mt-1 w-100 product_price" contenteditable="true">
							{{ $currency_symbol }}
							{{ $price }}

						{{-- {{ format_price($price) }} --}}
					</h6>
					{{-- @endif --}}
					
				</div>
				@if ($proposal_options->show_Description == 1)
					<span contenteditable="true">
						{!! $product->description ?? "No Description" !!}
					</span>
				@endif
				
			</div>
			
		  </div>
		</div>
		<div class="col-sm-6">
		  <div class="card">
			<img src="asset('frontend/assets/img/placeholder.png') }}" alt="" style="height:60px;width:60px;object-fit:contain;" class="rounded-circle img-40 align-top mr-15" class="card-img-top" alt="...">
			<div class="card-body">
			  <h5 class="card-title">Special title treatment</h5>
			  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
			  <a href="#" class="btn btn-primary">Go somewhere</a>
			</div>
		  </div>
		</div>
	  </div>
	  <div class="row mt-3">
		<div class="col-sm-6 mb-3 mb-sm-0">
		  <div class="card">
			<img src="..." class="card-img-top" alt="...">
			<div class="card-body">
			  <h5 class="card-title">Special title treatment</h5>
			  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
			  <a href="#" class="btn btn-primary">Go somewhere</a>
			</div>
		  </div>
		</div>
		<div class="col-sm-6">
		  <div class="card">
			<img src="..." class="card-img-top" alt="...">
			<div class="card-body">
			  <h5 class="card-title">Special title treatment</h5>
			  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
			  <a href="#" class="btn btn-primary">Go somewhere</a>
			</div>
		  </div>
		</div>
	  </div>
	  <div class="row">
		<div class="col-sm-6 mb-3 mb-sm-0">
		  <div class="card">
			<img src="asset('frontend/assets/img/placeholder.png') }}" alt="" style="height:60px;width:60px;object-fit:contain;" class="rounded-circle img-40 align-top mr-15" class="card-img-top" alt="...">
			<div class="card-body">
			  <h5 class="card-title">Special title treatment</h5>
			  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
			  <a href="#" class="btn btn-primary">Go somewhere</a>
			</div>
		  </div>
		</div>
		<div class="col-sm-6 mb-5">
		  <div class="card">
			<img src="asset('frontend/assets/img/placeholder.png') }}" alt="" style="height:60px;width:60px;object-fit:contain;" class="rounded-circle img-40 align-top mr-15" class="card-img-top" alt="...">
			<div class="card-body">
			  <h5 class="card-title">Special title treatment</h5>
			  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
			  <a href="#" class="btn btn-primary">Go somewhere</a>
			</div>
		  </div>
		</div>
	  </div>
	</div>
</section>



@endsection

@section('InlineScript')

@endsection