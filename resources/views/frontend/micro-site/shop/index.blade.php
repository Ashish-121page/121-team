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

        $defaultCurrecy = App\Models\UserCurrency::where('User_shop_id',$user_shop->id)->where('default_currency',1)->first();
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
        max-height: 120px;
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
    .select2-container{
        width: 90% !important;
    }

    .remove-tag{
        cursor: pointer;
        padding: 5px;
    }
    .searchabletag{
        font-size: 2vh
    }
    .ashish{
        overflow: hidden;
        overflow-y: auto; 
        max-height: 50vh;
    } 
    .ashish::-webkit-scrollbar{
        width: 5px;
    }
    .ashish::-webkit-scrollbar-thumb{
        background-color: #6666cc;
        height: 10px !important;
        border-radius: 10px;
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

                    <div class="card border-0 sidebar sticky-bar">
                            {{-- Scooboo Tags filter --}}
                            <div class="selected-tags my-3">
                                @if ($alll_searches != null)
                                    @foreach ($alll_searches[0] as $key =>  $extra)
                                        @if ($extra != '')
                                        <span class="badge bg-primary searchabletag mb-1">
                                            {{-- {{ getAttruibuteValueById($extra)->attribute_value }} --}}
                                            <span class="badge bg-primary">
                                                    @if ($loop->iteration  == 1 || $loop->iteration == 2 )
                                                        {{ $key }}: {{ App\Models\Category::where('id',$extra)->first()->name ?? $extra  }}
                                                    @else
                                                        {{ $key }}: {{ $extra  }}
                                                    @endif
                                            </span>
                                            <span class="remove-tag" data-color="{{ $extra }}" title="click to Remove ">x</span>
                                        </span>
                                        @endif
                                    @endforeach
                                @endif

                                @foreach ($additional_attribute as $key => $item)
                                    @if (request()->has("searchVal_$key") && !empty(request()->get("searchVal_$key")))
                                        @foreach (request()->get("searchVal_$key") as $Color)
                                        @php
                                            $name =  getAttruibuteValueById($Color)->attribute_value;
                                            // $parent =  getAttruibuteById(getAttruibuteValueById($Color)->parent_id)->name;
                                        @endphp
                                            <span class="badge bg-primary searchabletag mb-1">
                                                {{-- {{ getAttruibuteValueById($Color)->attribute_value }} --}}
                                                <span class="badge bg-primary">
                                                     {{ $name }}
                                                </span>
                                                <span class="remove-tag" data-color="{{ $Color }}" title="click to Remove {{$name}}">x</span>
                                            </span>
                                        @endforeach
                                    @endif                                     
                                @endforeach
                            </div>
                            {{-- Scooboo Tags filter End --}}

                        <form form role="search" method="GET" id="searchform" class="card-body filter-body p-0 applyFilter d-none d-md-block mobile_filter">
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
                            <div class="widget bt-1 pt-3 pl-15 ashish">
                                <h6 class="widget-title">Categories</h6>
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
                                                        {{$item->name}} 
                                                        {{--  Category Count --}}
                                                        <span style="font-size: 11px">({{ getProductCountViaCategoryId($item->id,$user_shop->user_id) }})</span>
                                                    </label>
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
                                                                        {{$subcategorie->name}}
                                                                        {{-- Sub Category Count --}}
                                                                        <span style="font-size: 11px">
                                                                            ({{ getProductCountViaSubCategoryId($subcategorie->id,$user_shop->user_id) }})
                                                                        </span>
                                                                    </label>
                                                                </h6>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif    
                                        @endforeach
                                    @endif
                                </ul>

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
                                    <h6 class="widget-title mt-2">Price</h6>
                                    <div class="mx-2 d-flex">
                                        <input  style="width: 75px;height: 35px;" @if(request()->has('from') && request()->get('from') != null) value="{{ request()->get('from') }}" @endif type="text" name="from" class="form-control" placeholder=" ₹ Min">
                                        <input style="width: 75px;height: 35px;" @if(request()->has('to') && request()->get('to') != null) value="{{ request()->get('to') }}" @endif type="text" name="to" class="form-control ms-2" placeholder="₹ Max">
                                        <button class="price_go_btn ms-2" type="submit">GO</button>
                                    </div>

                                {{--` Make Filter As per Ashish  --}}
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
                                                    <input class="form-check-input" type="checkbox" value="{{ $mater }}" id="searchId{{ $mater }}"  name="searchVal[]"
                                                    @if(request()->has("searchVal"))  
                                                        @if(isset($mater) && in_array($mater,request()->get("searchVal")))
                                                            checked
                                                        @endif
                                                    @endif >
                                                    <label for="searchId{{ $mater }}" class="form-check-label fltr-lbl ">
                                                        {{ getAttruibuteValueById($mater)->attribute_value }}
                                                    </label>
                                                </h5>
                                            </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    @endforeach
                                @endif --}}
                                
                                {{--` Make Filter As per SB  --}}
                                {{-- @if (isset($additional_attribute) && $additional_attribute->count() >= 0)
                                    @foreach ($additional_attribute as $key => $item)
                                    @if (getAttruibuteById($item)->name ?? '' != '')
                                            <h6 class="widget-title mt-2 mytitle"> {{ getAttruibuteById($item)->name ?? ''}} </h6>
                                        @php
                                            $atrriBute_valueGet = getParentAttruibuteValuesByIds($item,$proIds);
                                        @endphp
                                        <ul class="list-unstyled mt-2 mb-0 custom-scrollbar" style="max-height: 160px;min-height: 60px">
                                            @foreach ($atrriBute_valueGet as $mater)
                                                @if($mater != '' || $mater != null)
                                                <li id="inputlist_{{$key}}">
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
                                    @endif
                                    @endforeach
                                @endif --}}

                                    {{-- Applying scoobooo layout in color and other attri --}}
                                    @if (isset($additional_attribute) && $additional_attribute->count() >= 0)
                                        @foreach ($additional_attribute as $key => $item)
                                        @if (getAttruibuteById($item)->visibility == 1)
                                                <div class="container mt-3">
                                                    <!-- Collapsible Button -->
                                                    <h6 class="collapsible" data-bs-toggle="collapse" data-bs-target="#AttributeList_{{$key}}" aria-expanded="false" aria-controls="AttributeList_{{$key}}">
                                                        {{ getAttruibuteById($item)->name }}
                                                        
                                                    <i class="fas fa-chevron-down fa-xs"></i>
                                                    </h6>
                                                    @php
                                                        $atrriBute_valueGet = getParentAttruibuteValuesByIds($item,$proIds);
                                                    @endphp
                                                    <div class="collapse" id="AttributeList_{{$key}}">
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
                                                                            <span style="font-size: 11px">
                                                                                {{ count( App\Models\ProductExtraInfo::where('attribute_value_id',$mater)->where('user_id',$user_shop->user_id)->groupBy('attribute_value_id')->get()); }}
                                                                            </span>
                                                                        </label>
                                                                    </h5>
                                                                </li>
                                                            @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                          @endforeach
                                      @endif
                                  {{-- Applying scoobooo layout in color and other attri End --}}



                                  {{-- Exclusive Products --}}

                                {{-- <h6 class="widget px-2">Exclusive Products</h6> --}}
                                <div class="mx-2 d-flex">
                                    <input type="checkbox" class="form-check-input visually-hidden" name="exclusive" id="exclusive" @if (request()->get('exclusive')) checked @endif>
                                    <label class="form-check-label mx-2" id="excl">Exclusive Items</label>
                                    @if (request()->get('exclusive') == 'on')
                                        <div class="text-success" style="font-weight: bolder"> 
                                            <i class="uil-check-circle" style="font-size: 20px"></i>
                                        </div>
                                    @else
                                        <div class="text-danger" style="font-weight: bolder"> OFF </div>
                                    @endif
                                    
                                </div>
                                
                                {{-- Exclusive Products --}}
                               
                            


                            </div>                           

                            <button type="submit" class="btn mt-2 d-block btn-primary w-100" id="filterBtn" form="searchform">Filter</button>
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
                            <select class="form-control select_box  w-auto" id="productSort" name="sort">
                                <option aria-readonly="true">Sort by<i class="fa fa-angle-down"></i></option>
                                <option @if(request()->get('sort') == 1) selected @endif value="1">Sort by latest</option>
                                <option @if(request()->get('sort') == 2) selected @endif value="2">Sort by price: low to high</option>
                                <option @if(request()->get('sort') == 3) selected @endif value="3">Sort by price: high to low</option>
                            </select>
                            {{-- <i class="fa fa-chevron-down"></i> --}}
                        </div>
                    </div>


                    @php
                        if (Session::has('Currency_id') != null) {
                            $curr = Session::get('Currency_id');
                        }else{
                            $curr = $defaultCurrecy->currency;
                        }
                    @endphp                    

                    <div class="d-flex mb-2">
                        <div class="container" id="selector" style="width: max-content !important;">
                            <select class="form-control select_box w-auto" id="changeCurrency" name="Currency">
                                <option aria-readonly="true">Change Currency</option>
                                @foreach ($currency_record as $item)
                                    <option value="{{ $item->id }}" @if ($item->id == ($curr ?? 'INR')) selected @endif > {{ $item->currency }}</option>
                                @endforeach
                            </select>
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
            var viewportWidth = $(window).width();

            @foreach($additional_attribute as $key => $item)
                if (viewportWidth < 768) {
                    $("#select2_{{$key}}").addClass('form-control')
                }
                
                if(viewportWidth > 790){
                    $("#select2_{{$key}}").select2({
                        placeholder : "Select",
                    })
                }
            @endforeach
            

              //  Add a click event handler to all the remove-tag elements
            $(".remove-tag").click(function () {
                // Get the color value associated with the tag
                var color = $(this).data("color");
                var filterdata = $(`input[value=${color}]`)

                if (filterdata.attr('type') == 'text' || filterdata.attr('type') == 'number') {
                    filterdata.val('');
                }
                $(this).parent().remove();
                filterdata.click()
                $("#searchform").submit()

            });
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
                    // 'exclusive': urlParams.get('exclusive') ?? 'off',
                    // 'category_id': urlParams.get('category_id'),
                    // 'sub_category_id': urlParams.get('sub_category_id'),
                    // 'brand': urlParams.get('brand'),
                    // 'from': urlParams.get('from'),
                    // 'to': urlParams.get('to'),
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
@endsection