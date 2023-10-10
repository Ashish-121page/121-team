@extends('frontend.layouts.main')
@section('meta_data')
    @php
        $categoryName = fetchFirst('App\Models\Category',request()->get('category_id'),'name') ?? 'All';
		$meta_title = $user_shop->name .' - '.$categoryName  ?? '' .' | '.getSetting('app_name');
		$meta_description = $user_shop->description ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');
		$meta_abstract = '' ?? getSetting('site_motto');
		$meta_author_name = '' ?? 'GRPL';
		$meta_author_email = '' ?? 'Hello@121.page';
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');
		$meta_img = ' ';
		$microsite = 1;

        $team = json_decode($user_shop->team);
        $manage_offer_verified = $team->manage_offer_verified ?? 0;
        $manage_offer_guest = $team->manage_offer_guest ?? 0;
	@endphp
@endsection
@section('content')
<style>

    #selector select option {
    color: #333;
    position: relative;
    top: 5px;
    }

    /*==================================================
    remove the original arrow in select option dropdown
    ==================================================*/

    #selector {
    margin: 5px 10%;
    width: 100%;
    }

    @media(max-width: 760px){
        #selector {
        margin: auto;
        }
        .filterMobile{
            display: block;
        }
    }
    @media(min-width: 760px){
        .filterMobile{
            display: none;
        }
    }
    .select_box {
    -webkit-appearance: none;
    -moz-appearance: none;
    -o-appearance:none;
    appearance:none;
    }

    .select_box.input-lg {
    height: 50px !important;
    line-height:25px !important;
    }

    .select_box + i.fa {
    float: right;
    margin-top: -32px;
    margin-right: 9px;
    pointer-events: none;
    background-color: #FFF;
    padding-right: 5px;
    }
    .custom-scrollbar{
        max-height: 500px;
        overflow-y: auto;
    }
    .col{
      width: fit-content;
      margin: 5px;
    }
    .col img{
        width: 190px !important;
        height: 150px !important;
        margin: 10px;
    }
    .ashu{
      text-align: center;
    }
    .col-3,.col-9{
      margin: 10px 0;
    }
    .custom-scrollbar_attri{
        height: 250px;
        overflow-y: auto;
    }

.range_container {
  display: flex;
  flex-direction: column;
  width: 80%;
  margin: 35% auto;
}

.sliders_control {
  position: relative;
  min-height: 30px;
}

.form_control {
  position: relative;
  display: flex;
  justify-content: space-between;
  font-size: 15px;
  color: #635a5a;
}

input[type=range]::-webkit-slider-thumb {
  -webkit-appearance: none;
  pointer-events: all;
  width: 24px;
  height: 24px;
  background-color: #fff;
  border-radius: 50%;
  box-shadow: 0 0 0 1px #C6C6C6;
  cursor: pointer;
}

input[type=range]::-moz-range-thumb {
  -webkit-appearance: none;
  pointer-events: all;
  width: 24px;
  height: 24px;
  background-color: #fff;
  border-radius: 50%;
  box-shadow: 0 0 0 1px #C6C6C6;
  cursor: pointer;  
}

input[type=range]::-webkit-slider-thumb:hover {
  background: #f7f7f7;
}

input[type=range]::-webkit-slider-thumb:active {
  box-shadow: inset 0 0 3px #387bbe, 0 0 9px #387bbe;
  -webkit-box-shadow: inset 0 0 3px #387bbe, 0 0 9px #387bbe;
}

input[type="number"] {
  color: #8a8383;
  width: 50px;
  height: 30px;
  font-size: 10px;
  border: none;
}

input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button {  
   opacity: 1;
}

input[type="range"] {
  -webkit-appearance: none; 
  appearance: none;
  height: 2px;
  width: 100%;
  position: absolute;
  background-color: #C6C6C6;
  pointer-events: none;
}

#fromSlider {
  height: 0;
  z-index: 1;
}









</style>
<section class="section">
    <div class="container mt-3">
        <div class="row">
                {{-- Side Bar --}}
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="text-right pl-3 filterMobile" style="margin-top: 10%;">
                        <i title="filter" class="uil uil-bars up_arrow show_mobile_filter" style="    font-size: 23px;"></i>
                        <i class="uil uil-times down_arrow close_mobile_filter" style="    font-size: 23px;"></i>
                    </div>
                    <div class="card border-0 sidebar sticky-bar custom-scrollbar">
                        <!-- Selected Attribute Tags -->
                        <div class="selected-tags">
                            {{-- @foreach ($additional_attribute as $key => $item)
                                @if(request()->has("searchVal_$key") && !empty(request()->get("searchVal_$key")))
                                    @foreach(request()->get("searchVal_$key") as $Color)
                                        <span class="badge bg-primary">{{ getAttruibuteValueById($Color)->attribute_value }}</span>
                                    @endforeach
                                @endif
                            @endforeach --}}

                                @foreach ($additional_attribute as $key => $item)
                                    @if (request()->has("searchVal_$key") && !empty(request()->get("searchVal_$key")))
                                        @foreach (request()->get("searchVal_$key") as $Color)
                                            <span class="badge bg-primary">
                                                {{-- {{ getAttruibuteValueById($Color)->attribute_value }} --}}
                                                <span class="badge bg-primary" data-color="{{ $Color }}" onclick="unsetColor(this)">{{ getAttruibuteValueById($Color)->attribute_value }}</span>
                                                <span class="remove-tag" data-color="{{ $Color }}">x</span>
                                            </span>
                                        @endforeach
                                    @endif
                                @endforeach


                                {{-- @foreach($categories as $key => $item)
                                    @if(request()->has('category_id') && !empty(request()->get('category_id')))
                                        @foreach(request()->get('category_id') as $category)
                                            <span class="badge bg-primary">{{ getProductCategory($category)->name }}</span>

                                        @endforeach
                                    @endif
                                @endforeach --}}





                        </div>
                        <form form role="search" method="GET" id="" class="card-body filter-body p-0 applyFilter d-none d-md-block mobile_filter">
                            <input type="hidden" name="sort" value="" class="sortValue">
                            <h5 class="widget-title pt-3 pl-15" style="display: inline-block;">Filters
                            </h5>
                            {{-- <div class="widget px-2">
                                <div>
                                    <div class="input-group mb-3 border rounded">
                                        <input type="text" id="title" value="{{ request()->get('title') }}" name="title" class="form-control border-0" placeholder="Search Product Name...">
                                        <button type="submit" class="input-group-text bg-white border-0" id="searchsubmit"><i class="uil uil-search"></i></button>
                                    </div>
                                </div>
                            </div>  --}}
                            <!-- SEARCH -->

                            <!-- Categories -->
                            <div class="widget bt-1 pt-3 pl-15">
                                <div class="container">
                                    <!-- Collapsible Button -->
                                    <h6 class="collapsible" data-bs-toggle="collapse" data-bs-target="#categoryList" aria-expanded="false" aria-controls="categoryList">
                                      Categories
                                    <i class="fas fa-chevron-down fa-xs"></i>
                                    </h6>
                                    <div class="collapse" id="categoryList">
                                        <ul class="list-unstyled mt-2 mb-0 custom-scrollbar">
                                            <li>
                                                <h5 class="form-check">
                                                    <input class="form-check-input" type="radio" @if(!request()->has('category_id') ||request()->get('category_id') == null ) checked @endif  value="" id="categoryAll" name="category_id">
                                                    <label for="categoryAll" class="form-check-label fltr-lbl">
                                                        All</label>
                                                </h5>
                                            </li>
                                            @if(!empty($categories))
                                                @foreach ($categories as $item)
                                                    @php
                                                    $sub_category = App\Models\Category::whereId(request()->get('sub_category_id'))->first();
                                                    @endphp
                                                    <li>
                                                        <h5 class="form-check">
                                                            <input class="form-check-input filterCategory" type="radio" value="{{ $item->id }}" id="category{{ $item->id }}" name="category_id" @if((request()->has('category_id') && request()->get('category_id') ==  $item->id )) checked @endif>
                                                            <label for="category{{ $item->id }}" class="form-check-label fltr-lbl   ">
                                                                {{$item->name}}</label>
                                                        </h5>
                                                    </li>
                                                    @if(request()->has('category_id') && request()->get('category_id') ==  $item->id )
                                                        @php
                                                            $subcategories = getProductSubCategoryByShop($slug, $item->id, 0);
                                                        @endphp
                                                        <div style="padding-left: 25px">
                                                            <ul class="list-unstyled custom-scrollbar">
                                                                @foreach ($subcategories as $subcategorie)

                                                                <li>
                                                                    <h6 class="form-check">
                                                                        <input class="form-check-input filterSubCategory" type="radio" value="{{ $subcategorie->id }}" id="category{{ $subcategorie->id }}" name="sub_category_id" @if(request()->has('sub_category_id') && request()->get('sub_category_id') ==  $subcategorie->id) checked @endif>
                                                                        <label for="category{{ $subcategorie->id }}" class="form-check-label fltr-lbl">
                                                                            {{$subcategorie->name}}</label>
                                                                    </h6>
                                                                </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </ul>
                                        {{-- <ul class="list-unstyled mt-2 mb-0 custom-scrollbar">
                                          <li>
                                            <h5 class="form-check">
                                              <input class="form-check-input" type="radio" @if(!request()->has('category_id') || request()->get('category_id') == null ) checked @endif value="" id="categoryAll" name="category_id">
                                              <label for="categoryAll" class="form-check-label fltr-lbl">
                                                All</label>
                                            </h5>
                                          </li>
                                          @if(!empty($categories))
                                            @foreach ($categories as $item)
                                              @php
                                                $sub_category = App\Models\Category::whereId(request()->get('sub_category_id'))->first();
                                              @endphp
                                              <li>
                                                <h5 class="form-check">
                                                  <input class="form-check-input filterCategory" type="radio" value="{{ $item->id }}" id="category{{ $item->id }}" name="category_id" @if((request()->has('category_id') && request()->get('category_id') ==  $item->id )) checked @endif>
                                                  <label for="category{{ $item->id }}" class="form-check-label fltr-lbl   ">
                                                    {{$item->name}}</label>
                                                </h5>
                                              </li>
                                              @if(request()->has('category_id') && request()->get('category_id') ==  $item->id )
                                                @php
                                                  $subcategories = getProductSubCategoryByShop($slug, $item->id, 0);
                                                @endphp
                                                <div style="padding-left: 25px">
                                                  <ul class="list-unstyled custom-scrollbar">
                                                    @foreach ($subcategories as $subcategorie)
                                                      <li>
                                                        <h6 class="form-check">
                                                          <input class="form-check-input filterSubCategory" type="radio" value="{{ $subcategorie->id }}" id="category{{ $subcategorie->id }}" name="sub_category_id" @if(request()->has('sub_category_id') && request()->get('sub_category_id') ==  $subcategorie->id) checked @endif>
                                                          <label for="category{{ $subcategorie->id }}" class="form-check-label fltr-lbl">
                                                            {{$subcategorie->name}}</label>
                                                        </h6>
                                                      </li>
                                                    @endforeach
                                                  </ul>
                                                </div>
                                              @endif
                                            @endforeach
                                          @endif
                                        </ul> --}}
                                    </div>

                                </div>

                                @if(isset($brands) && $brands->count() >= 1)
                                    <h6 class="widget-title mt-2">Brands</h6>
                                    <ul class="list-unstyled mt-2 mb-0 custom-scrollbar">
                                        @foreach ($brands as $brand)
                                            <li>
                                                <h5 class="form-check">
                                                    <input class="form-check-input" type="radio" value="{{ $brand->id }}" id="brandID" name="brand" @if(request()->has('brand') && request()->get('brand') == $brand->id) checked @endif>
                                                    <label for="brandID" class="form-check-label fltr-lbl ">
                                                        {{ $brand->name }}
                                                    </label>
                                                </h5>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                                 {{-- price scooboo --}}
                                <div class="container mt-3">
                                    <!-- Collapsible Button for Price-->
                                    <h6 class="collapsible" data-bs-toggle="collapse" data-bs-target="#PriceList" aria-expanded="false" aria-controls="PriceList">
                                      Price
                                     <i class="fas fa-chevron-down fa-xs"></i>
                                    </h6>
                                    <!-- Collapsible Content (Price List) -->
                                    <div class="collapse" id="PriceList">
                                        {{-- <div class="slidecontainer">
                                            <input type="range" min="1" max="100" value="50" class="slider" id="priceRange">

                                          </div> --}}
                                        {{-- <div class="mx-3 d-flex">
                                            <input  style="width: 75px;height: 35px;" @if(request()->has('from') && request()->get('from') != null) value="{{ request()->get('from') }}" @endif type="number" min="0" name="from" class="form-control" placeholder=" ₹ Min">
                                            <input style="width: 75px;height: 35px;" @if(request()->has('to') && request()->get('to') != null) value="{{ request()->get('to') }}" @endif type="number" min="0" name="to" class="form-control ms-2" placeholder="₹ Max">
                                            {{-- <button class="price_go_btn ms-2" type="submit">GO</button> --}}
                                        {{-- </div> --}}
                                        <div class="range_container">
                                            <div class="sliders_control">
                                                <input id="fromSlider" type="range" value="{{ $minID }}" min="{{ $minID }}" max="{{ $maxID }}"/>
                                                <input id="toSlider" type="range" value="{{ $maxID }}" min="{{ $minID }}" max="{{ $maxID }}"/>
                                            </div>
                                            <div class="form_control">
                                                <div class="form_control_container">
                                                    <div class="form_control_container__time">Min</div>
                                                    <input class="form_control_container__time__input" type="number" id="fromInput" value="{{ $minID }}" min={{ $minID }} max={{ $maxID }}/>
                                                </div>
                                                <div class="form_control_container">
                                                    <div class="form_control_container__time">Max</div>
                                                    <input class="form_control_container__time__input" type="number" id="toInput" value="{{ $maxID }}" min={{ $minID }} max={{ $maxID }}/>
                                                </div>
                                            </div>
                                        </div>
                                        


                                    </div>


                                </div>
                                
                                {{-- Applying scoobooo layout in color and other attri --}}
                                @if (isset($additional_attribute) && $additional_attribute->count() >= 0)
                                    @foreach ($additional_attribute as $key => $item)
                                <div class="container mt-3">
                                    <!-- Collapsible Button -->
                                    <h6 class="collapsible" data-bs-toggle="collapse" data-bs-target="#AttributeList_{{ $item }}" aria-expanded="false" aria-controls="AttributeList_{{ $item }}">
                                        {{ getAttruibuteById($item)->name }}
                                    <i class="fas fa-chevron-down fa-xs"></i>
                                    </h6>
                                    @php
                                        $atrriBute_valueGet = getParentAttruibuteValuesByIds($item,$proIds);
                                    @endphp
                                    <div class="collapse" id="AttributeList_{{ $item }}">
                                        <ul class="list-unstyled mt-2 mb-0 custom-scrollbar">
                                            @foreach ($atrriBute_valueGet as $mater)
                                            @if($mater != '' || $mater != null)
                                            <li>
                                                <h5 class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $mater }}" id="searchId{{ $mater }}"  name="searchVal_{{ $key }}[]"
                                                    @if(request()->has("searchVal_$key"))
                                                        @if(isset($mater) && in_array($mater,request()->get("searchVal_$key")))
                                                            checked
                                                        @endif
                                                    @endif >
                                                    <label for="searchId{{ $mater }}" class="form-check-label fltr-lbl ">
                                                        {{ getAttruibuteValueById($mater)->attribute_value ?? ''}}
                                                    </label>
                                                </h5>
                                            </li>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                    @endforeach
                                @endif
                                {{-- Applying scoobooo layout in color and other attri End --}}

                                {{--` Make Filter As per SB  --}}

                                {{-- @if (isset($additional_attribute) && $additional_attribute->count() >= 0)
                                    @foreach ($additional_attribute as $key => $item)
                                    <h6 class="widget-title mt-2"> {{ getAttruibuteById($item)->name }} </h6>
                                    @php
                                        $atrriBute_valueGet = getParentAttruibuteValuesByIds($item,$proIds);
                                    @endphp
                                    <ul class="list-unstyled mt-2 mb-0 custom-scrollbar" style="height: 60px;">
                                        @foreach ($atrriBute_valueGet as $mater)
                                            @if($mater != '' || $mater != null)
                                            <li>
                                                <h5 class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="{{ $mater }}" id="searchId{{ $mater }}"  name="searchVal_{{ $key }}[]"
                                                    @if(request()->has("searchVal_$key"))
                                                        @if(isset($mater) && in_array($mater,request()->get("searchVal_$key")))
                                                            checked
                                                        @endif
                                                    @endif >
                                                    <label for="searchId{{ $mater }}" class="form-check-label fltr-lbl ">
                                                        {{ getAttruibuteValueById($mater)->attribute_value ?? ''}}
                                                    </label>
                                                </h5>
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    @endforeach
                                @endif --}}


                                  {{-- Exclusive Products --}}

                                {{-- <h6 class="widget px-2">Exclusive Products</h6> --}}
                                {{-- <div class="mx-2 d-flex mt-3">
                                    <input type="checkbox" class="form-check-input visually-hidden" name="exclusive" id="exclusive" @if (request()->get('exclusive')) checked @endif>
                                    <label class="form-check-label mx-2" id="excl">Exclusive Items</label>
                                    @if (request()->get('exclusive') == 'on')
                                        <div class="text-success" style="font-weight: bolder">
                                            <i class="uil-check-circle" style="font-size: 20px"></i>
                                        </div>
                                    @else
                                        <div class="text-danger" style="font-weight: bolder"> OFF </div>
                                    @endif
                                </div> --}}

                                {{-- Exclusive Products --}}




                            </div>
                            <button type="submit" class="btn mt-2 d-block btn-primary w-100" id="filterBtn">Filter</button>
                            <a class="btn mt-2 d-block btn-primary w-100" href="{{route('pages.shop-index')}}" id="resetButton">Reset</a>



                        </form>
                    </div>
                </div><!--end col-->
                <div class="col-lg-9 col-md-8 col-12 pt-2 mt-sm-0 pt-sm-0">
                    <div class="row align-items-center">

                        <div class="col-lg-8 col-md-8">
                            {{-- <div class="section-title">
                                <h5 class="mb-0">Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of {{ $items->total() }} Result</h5>
                            </div> --}}
                        </div><!--end col-->

                        {{-- <div class="col-lg-4 col-md-4 mt-sm-0 pt-2 pt-sm-0 mb-3">
                            <div class="row">
                                @if ($manage_offer_guest || $manage_offer_verified)
                                    @if (auth()->id() == 155)
                                        @if ($manage_offer_guest)
                                            <div class="col-5 col-sm-3 col-md-5">
                                                <a class="btn mt-2 d-block btn-outline-primary w-auto float-end makeoffer" href="{{ route('pages.proposal.create') }}?shop={{$user_shop->id}}" style="width: max-content !important;">
                                                    Make Offer
                                                </a>
                                            </div>
                                        @endif
                                    @else
                                        <div class="col-5 col-sm-3 col-md-5">
                                            <a class="btn mt-2 d-block btn-outline-primary w-auto float-end makeoffer" href="{{ route('pages.proposal.create') }}?shop={{$user_shop->id}}" style="width: max-content !important;">
                                                Make Offer
                                            </a>
                                        </div>
                                    @endif
                                @endif

                                <div class="col-7 col-sm-9 col-md-7">
                                    <div class="container" id="selector" style="width: max-content !important;">
                                        <select class="form-control input-lg select_box" id="productSort" name="sort">
                                            <option aria-readonly="true">Sort by<i class="fa fa-angle-down"></i>
                                            </option>
                                            <option @if(request()->get('sort') == 1) selected @endif value="1">Sort by latest</option>
                                            <option @if(request()->get('sort') == 2) selected @endif value="2">Sort by price: low to high</option>
                                            <option @if(request()->get('sort') == 3) selected @endif value="3">Sort by price: high to low</option>
                                        </select>
                                        <i class="fa fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                {{-- Side Bar End --}}
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">

                    <div class="input-group mb-3 border rounded w-md-25">
                        <input type="text" id="quicktitle" value="{{ request()->get('title') }}" name="title" class="form-control border-0"  placeholder="Quick Search : Name or Model Code">
                        <button type="submit" class="input-group-text bg-white border-0" id="searchsubmit"><i class="uil uil-search"></i></button>
                    </div>

                    <div class="d-flex mb-2">
                        <div class="container" id="selector" style="width: max-content !important;">
                            <select class="form-control select_box" id="productSort" name="sort">
                                <option aria-readonly="true">Sort by<i class="fa fa-angle-down"></i></option>
                                <option @if(request()->get('sort') == 1) selected @endif value="1">Sort by latest</option>
                                <option @if(request()->get('sort') == 2) selected @endif value="2">Sort by price: low to high</option>
                                <option @if(request()->get('sort') == 3) selected @endif value="3">Sort by price: high to low</option>
                            </select>
                            <i class="fa fa-chevron-down"></i>
                        </div>
                    </div>

                    <div class="m-2 d-flex justify-content-end gap-2">
                        <button id="gridview" class="btn btn-outline-primary "><i class="fas fa-th-large"></i></button>
                        <button id="card" class="btn btn-outline-primary active "> <i class="fas fa-list"></i></button>
                    </div>

                    <div class="d-flex  mb-2">
                        @if ($manage_offer_guest || $manage_offer_verified)
                            @if (auth()->id() == 155)
                                @if ($manage_offer_guest)
                                    <a class="btn mt-2 d-block btn-outline-primary   w-auto float-end makeoffer" href="{{ route('pages.proposal.create') }}?shop={{$user_shop->id}}" style="width: max-content !important;">
                                        Make Offer
                                    </a>
                                @endif
                            @else
                                <a class="btn mt-2 d-block btn-outline-primary w-auto   float-end makeoffer" href="{{ route('pages.proposal.create') }}?shop={{$user_shop->id}}" style="width: max-content !important;">
                                    Make Offer
                                </a>
                            @endif
                        @endif
                    </div>


                </div>

                @include('frontend.micro-site.shop.loadIndex')

                <div class="col-8">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-outline-primary nextpage">Show More...</button>
                    </div>
                </div>

            </div>
            <!--end col-->
        </div>
        </div><!--end row-->
    </div><!--end container-->
</section>
@endsection


@section('InlineScript')
    <script>
        var active_category = "{{request()->get('category_id') }}";
        var active_sub_category = "{{request()->get('sub_category_id') }}";
            $('.down_arrow').addClass('d-none');

            $('.filterCategory').on('click', function(){
                if(active_category == $(this).val()){
                    $(this).val(null);
                    $(document).find('.filterSubCategory').val(null);
                }else{
                    $(document).find('.filterSubCategory').val(null);
                }
                $('.applyFilter').submit();
        });



            $('.filterSubCategory').on('click', function(){
                if(active_sub_category == $(this).val()){
                    $(this).val(null);
                }
                $('.applyFilter').submit();
        });

        $('#productSort').on('change', function(){
                var value = $(this).val();
                $('.sortValue').val(value);
                $('.applyFilter').submit();
        });
        $('.show_mobile_filter').on('click',function(){
                $('.up_arrow').addClass('d-none');
                $('.down_arrow').removeClass('d-none');
                $('.mobile_filter').removeClass('d-none');
        });
        $('.close_mobile_filter').on('click',function(){
                $('.up_arrow').removeClass('d-none');
                $('.down_arrow').addClass('d-none');
                $('.mobile_filter').addClass('d-none');
        });

        $('#categoryAll').click(function(){
            url = "{{route('pages.shop-index')}}";
            window.location.href = url;
        });
    </script>

    <script>

        $(".makeoffer").click(function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var msg = "<input type='text' id='margin' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Name'> <br> <input type='text' id='offeremail' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Email (Optional)'> <br> <input type='number' maxlength='10' id='offerphone' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Phone (Optional)'>";

            $.confirm({
                draggable: true,
                title: 'Offer for',
                content: msg,
                type: 'blue',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: 'Next',
                        btnClass: 'btn-primary',

                        action: function(){
                                let margin = $('#margin').val();
                                let offeremail = $('#offeremail').val();
                                let offerphone = $('#offerphone').val();
                                if (!margin) {
                                    $.alert('provide a valid name');
                                    return false;
                                }
                                url = url+"&offerfor="+margin+"&offerphone="+offerphone+"&offeremail="+offeremail;
                                window.location.href = url;
                                // console.log(url);
                        }
                    },
                    close: function () {
                    }
                }
            });
        });
        // confirm

    </script>

    <script>
        let viewarea = "List";

        $(document).ready(function () {
            $("#gridview").click();
        });


        // Grid View
       // LISt View
       $("#gridview").click(function (e) {
            e.preventDefault();
            // Change Class of Columns
            $(".col-3").addClass("col-4");
            $(".col-3").removeClass("col-3");

            // UnHide Text Below Image
            $(".ashu").removeClass("d-none")
            // Hide Second Colummn
            $(".send").addClass("d-none")
            $(".ashu1").addClass("d-none")

            // Add or remove Active Class
            $(this).addClass('active');
            $("#card").removeClass('active')
            viewarea = "Grid";
        });


        $("#card").click(function (e) {
            e.preventDefault();
            $(".col-4").addClass("col-3");
            $(".col-4").removeClass("col-4");
            $(".send").removeClass("d-none")
            $(".ashu").addClass("d-none")
            $(".ashu1").removeClass("d-none")

            // Add or remove Active Class
            $(this).addClass('active');
            $("#gridview").removeClass('active')
            viewarea = "List";

        });
    </script>

    {{-- Ajax Load --}}
    <script>
        var URL = "{{ url('/') }}/shop";
        var crr_page = 1;
        var total_page = {{ $items->lastPage() }};
        var contianer = $("#dfjrgd");
        var qsearch = false;

        $(".nextpage").click(function (e) {
            e.preventDefault();
            if (qsearch === false) {
                if (total_page >= crr_page+1) {
                    getData(crr_page+1)
                }else{
                    $(".nextpage").addClass('d-none')
                }
            }
        });

        function getData(pages) {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);

            $.ajax({
                type: "get",
                url: URL,
                data: {
                    'page':pages,
                    'title': urlParams.get('title'),
                    // ! Uncomment this to Enable search by Curren Filters/
                    // 'model_code': urlParams.get('model_code'),
                    // 'category_id': urlParams.get('category_id'),
                    // 'sub_category_id': urlParams.get('sub_category_id'),
                    // 'brand': urlParams.get('brand'),
                    // 'from': urlParams.get('from'),
                    // 'to': urlParams.get('to'),
                    // 'exclusive': urlParams.get('exclusive') ?? 'off',
                    @if (isset($additional_attribute) && $additional_attribute->count() >= 0)
                        @foreach ($additional_attribute as $key => $item)
                            'searchVal_{{$key}}' : urlParams.getAll("searchVal_{{$key}}[]"),
                        @endforeach
                    @endif
                },
                success: function (response) {
                    $(".dfjrgd").append(response);
                    crr_page++;
                    if (viewarea == 'List') {
                        $("#card").click()
                    }else{
                        $("#gridview").click();
                    }
                }
            });
        }
        // ! OnKey Up Load Ajax...
        $("#quicktitle").keyup(function (e) {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            let thisval = this.value;
            if (thisval == '') {
                qsearch = false;
                $(".nextpage").removeClass('d-none')
                crr_page = 1;
            }else{
                qsearch = true;
                $(".nextpage").addClass('d-none')
            }
            console.log(urlParams.get('exclusive') ?? 'off');

            $.ajax({
                type: "get",
                url: URL,
                data: {
                    'title':this.value,
                    'model_code':this.value,
                    'exclusive': urlParams.get('exclusive') ?? 'off',
                    'category_id': urlParams.get('category_id'),
                    'sub_category_id': urlParams.get('sub_category_id'),
                    'brand': urlParams.get('brand'),
                    'from': urlParams.get('from'),
                    'to': urlParams.get('to'),
                    @if (isset($additional_attribute) && $additional_attribute->count() >= 0)
                        @foreach ($additional_attribute as $key => $item)
                            'searchVal_{{$key}}' : urlParams.getAll("searchVal_{{$key}}[]"),
                        @endforeach
                    @endif

                },
                success: function (response) {
                    $(".dfjrgd").empty().html(response);
                    if (viewarea == 'List') {
                        $("#card").click()
                    }else{
                        $("#gridview").click();
                    }
                }
            });


        });


    </script>

    <script>
        $(document).on('click','#excl',function(e){
            $(this).attr('checked',false);
            $.confirm({
                title: 'Password!',
                content: '' +
                '<form action="" class="formName">' +
                '<div class="form-group">' +
                '<label>Enter Password for Exlusive</label>' +
                '<input type="text" placeholder="Your name" class="name form-control" name="password" required />' +
                '</div>' +
                '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function () {
                            var name = this.$content.find('.name').val();
                            if(!name){
                                $.alert('provide a valid name');
                                return false;
                            }

                            $.ajax({
                                type: "GET",
                                url: "{{ route('pages.proposal.validatepass') }}",
                                data: {
                                    'password' :name,
                                },
                                success: function (response) {
                                    if (response['status'] == 'success') {
                                        $("#exclusive").attr('checked',true);
                                        $("#filterBtn").click();
                                    }else{
                                        $("#exclusive").attr('checked',false);
                                        $.alert("Wrong Password");
                                        $("#resetButton").click();
                                    }
                                    // console.log(response['status']);
                                },
                                // error: function (e) {
                                //     console.log(e);
                                // }
                            });
                        }
                    },
                    cancel: function () {
                        //close
                    },
                },
                onContentReady: function () {
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function (e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        });

    </script>
    <script>

//   Add a click event handler to all the remove-tag elements
     $(".remove-tag").click(function () {
        // Get the color value associated with the tag
        var color = $(this).data("color");

        // Remove the tag from the DOM
        $(this).parent().remove();

        // You can add additional logic here to update the search criteria or perform other actions.
    });

</script>

// price Range double slider
<script>
    function controlFromInput(fromSlider, fromInput, toInput, controlSlider) {
    const [from, to] = getParsed(fromInput, toInput);
    fillSlider(fromInput, toInput, '#C6C6C6', '#25daa5', controlSlider);
    if (from > to) {
        fromSlider.value = to;
        fromInput.value = to;
    } else {
        fromSlider.value = from;
    }
}
    
function controlToInput(toSlider, fromInput, toInput, controlSlider) {
    const [from, to] = getParsed(fromInput, toInput);
    fillSlider(fromInput, toInput, '#C6C6C6', '#25daa5', controlSlider);
    setToggleAccessible(toInput);
    if (from <= to) {
        toSlider.value = to;
        toInput.value = to;
    } else {
        toInput.value = from;
    }
}

function controlFromSlider(fromSlider, toSlider, fromInput) {
  const [from, to] = getParsed(fromSlider, toSlider);
  fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
  if (from > to) {
    fromSlider.value = to;
    fromInput.value = to;
  } else {
    fromInput.value = from;
  }
}

function controlToSlider(fromSlider, toSlider, toInput) {
  const [from, to] = getParsed(fromSlider, toSlider);
  fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
  setToggleAccessible(toSlider);
  if (from <= to) {
    toSlider.value = to;
    toInput.value = to;
  } else {
    toInput.value = from;
    toSlider.value = from;
  }
}

function getParsed(currentFrom, currentTo) {
  const from = parseInt(currentFrom.value, 10);
  const to = parseInt(currentTo.value, 10);
  return [from, to];
}

function fillSlider(from, to, sliderColor, rangeColor, controlSlider) {
    const rangeDistance = to.max-to.min;
    const fromPosition = from.value - to.min;
    const toPosition = to.value - to.min;
    controlSlider.style.background = `linear-gradient(
      to right,
      ${sliderColor} 0%,
      ${sliderColor} ${(fromPosition)/(rangeDistance)*100}%,
      ${rangeColor} ${((fromPosition)/(rangeDistance))*100}%,
      ${rangeColor} ${(toPosition)/(rangeDistance)*100}%, 
      ${sliderColor} ${(toPosition)/(rangeDistance)*100}%, 
      ${sliderColor} 100%)`;
}

function setToggleAccessible(currentTarget) {
  const toSlider = document.querySelector('#toSlider');
  if (Number(currentTarget.value) <= 0 ) {
    toSlider.style.zIndex = 2;
  } else {
    toSlider.style.zIndex = 0;
  }
}

const fromSlider = document.querySelector('#fromSlider');
const toSlider = document.querySelector('#toSlider');
const fromInput = document.querySelector('#fromInput');
const toInput = document.querySelector('#toInput');
fillSlider(fromSlider, toSlider, '#C6C6C6', '#25daa5', toSlider);
setToggleAccessible(toSlider);

fromSlider.oninput = () => controlFromSlider(fromSlider, toSlider, fromInput);
toSlider.oninput = () => controlToSlider(fromSlider, toSlider, toInput);
fromInput.oninput = () => controlFromInput(fromSlider, fromInput, toInput, toSlider);
toInput.oninput = () => controlToInput(toSlider, fromInput, toInput, toSlider);
</script>




@endsection
