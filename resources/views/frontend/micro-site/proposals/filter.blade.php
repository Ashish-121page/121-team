<div class="col-12 d-none adwas" id="adwas">
    <div class="card border-0 sidebar custom-scrollbar">
        <form form role="search" method="GET" id="searchform"
            class="card-body filter-body p-0 applyFilter d-none d-md-block mobile_filter">
            <input type="hidden" name="sort" value="" class="sortValue">
            <h5 class="widget-title pt-3 pl-15" style="display: inline-block;">Filters
            </h5>
            <h6 class="widget-title mt-2">Price</h6>
            <div class=" d-flex">
                @php
                    $request = request();
                @endphp
                <input style="width: 70px;height: 35px;"
                    @if (request()->has('from') && request()->get('from') != null) value="{{ request()->get('from') }}" @endif type="text"
                    name="from" class="form-control" placeholder=" Min  ">
                <input style="width: 70px;height: 35px;"
                    @if (request()->has('to') && request()->get('to') != null) value="{{ request()->get('to') }}" @endif type="text"
                    name="to" class="form-control ms-2" placeholder=" Max ">
                <button class="price_go_btn ms-2" type="submit">GO</button>
            </div>
            {{-- categories Ashish --}}
            <div class="widget w-75">
                <!-- Categories -->
                <div class="widget bt-1 pt-3 ">
                    <div class="accordion-item my-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapscatrgory" aria-expanded="true" aria-controls="collapscatrgory"
                                style="height: 25px !important;">
                                <h6 class="widget-title mt-2">Categories</h6>
                            </button>
                        </h2>
                        <div id="collapscatrgory" class="accordion-collapse collapse"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul class="list-unstyled mt-1 mb-0 custom-scrollbar" style="padding-left:1rem">
                                    <li>
                                        <h5 class="form-check">
                                            <input class="form-check-input" type="radio"
                                                @if (!request()->has('category_id') || request()->get('category_id') == null) checked @endif value=""
                                                id="categoryAll" name="category_id">
                                            <label for="categoryAll" class="form-check-label fltr-lbl">
                                                All</label>
                                        </h5>
                                    </li>
                                    @if (!empty($categories))
                                        @foreach ($categories as $item)
                                            @php
                                                $sub_category = App\Models\Category::whereId(request()->get('sub_category_id'))->first();
                                            @endphp
                                            <li>
                                                <h5 class="form-check"
                                                    style="display: flex;align-items: center;gap: 6px;">
                                                    <input class="form-check-input filterCategory" type="radio"
                                                        value="{{ $item->id }}" id="category{{ $item->id }}"
                                                        name="category_id"
                                                        @if (request()->has('category_id') && request()->get('category_id') == $item->id) checked @endif>
                                                    <label for="category{{ $item->id }}"
                                                        class="form-check-label fltr-lbl mt-2">
                                                        {{ $item->name }}
                                                        {{--  Category Count --}}
                                                        <span
                                                            style="font-size: 11px">({{ getProductCountViaCategoryId($item->id, $user_shop->user_id) }})</span>
                                                    </label>
                                                </h5>
                                            </li>
                                            @if (request()->has('category_id') && request()->get('category_id') == $item->id)
                                                @php
                                                    $subcategories = getProductSubCategoryByShop($slug, $item->id, 0);
                                                @endphp
                                                <div
                                                    style="padding-left: 25px; display: flex;align-items: center;gap: 6px;">
                                                    <ul class="list-unstyled custom-scrollbar">
                                                        @foreach ($subcategories as $subcategorie)
                                                            <li>
                                                                <h5 class="form-check">
                                                                    <input class="form-check-input filterSubCategory"
                                                                        type="radio" value="{{ $subcategorie->id }}"
                                                                        id="category{{ $subcategorie->id }}"
                                                                        name="sub_category_id"
                                                                        @if (request()->has('sub_category_id') && request()->get('sub_category_id') == $subcategorie->id) checked @endif>
                                                                    <label for="category{{ $subcategorie->id }}"
                                                                        class="form-check-label fltr-lbl">
                                                                        {{ $subcategorie->name }}
                                                                        {{-- Sub Category Count --}}
                                                                        <span style="font-size: 11px">
                                                                            ({{ getProductCountViaSubCategoryId($subcategorie->id, $user_shop->user_id) }})
                                                                        </span>
                                                                    </label>
                                                                </h5>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- categories Ashish --}}

                <div class="accordion-item my-2 d-none">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapsesupplier" aria-expanded="true" aria-controls="collapsesupplier"
                            style="height: 25px !important;">
                            <h6 class="widget-title mt-2">Supplier</h6>
                        </button>
                    </h2>
                    <div id="collapsesupplier" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @if (isset($suppliers) && $suppliers->count() >= 0)
                                <ul class="list-unstyled mt-2 mb-0 custom-scrollbar" style="height: 60px;">
                                    <li>
                                        <input class="form-check-input" type="checkbox" value="yes" id="ownproduct"
                                            name="ownproduct" @if ($request->has('ownproduct') == 'yes') checked @endif>
                                        <label for="ownproduct" class="form-check-label fltr-lbl ">Own
                                            Product</label>
                                    </li>
                                    @foreach ($suppliers as $supplier)
                                        @if ($supplier != '' || $supplier != null)
                                            <li>
                                                <h5 class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="{{ $supplier->id }}"
                                                        id="supplierid{{ $supplier->id }}" name="supplier[]"
                                                        @if (request()->has('supplier')) @if (isset($supplier) && in_array($supplier->id, request()->get('supplier')))
                                             checked @endif
                                                        @endif >
                                                    <label for="supplierid{{ $supplier->id }}"
                                                        class="form-check-label fltr-lbl ">
                                                        {{ $supplier->name }}
                                                    </label>
                                                </h5>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                @if (isset($TandADeliveryPeriod) && $TandADeliveryPeriod->count() > 0)
                    <div class="accordion-item my-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseDelivery" aria-expanded="true"
                                aria-controls="collapseDelivery" style="height: 25px !important;">
                                <h6 class="widget-title mt-2">T&A</h6>
                            </button>
                        </h2>
                        <div id="collapseDelivery" class="accordion-collapse collapse"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <ul class="list-unstyled mt-2 mb-0 custom-scrollbar" style="height: 120px;">
                                    <div class="widget my-2">
                                        <input style="height: 35px; width: 75px"
                                            @if (request()->has('quantity') && request()->get('quantity') != null) value="{{ request()->get('quantity') }}" @endif
                                            type="text" name="quantity" class="form-control" placeholder="Qty">
                                    </div>
                                    @foreach ($TandADeliveryPeriod as $color)
                                        @if ($color != '' || $color != null)
                                            <li>
                                                <h5 class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="{{ $color }}"
                                                        id="deliveryID{{ $color }}" name="delivery[]"
                                                        @if (request()->has('delivery')) @if (isset($color) && in_array($color, request()->get('delivery')))
                                     checked @endif
                                                        @endif >
                                                    <label for="deliveryID{{ $color }}"
                                                        class="form-check-label fltr-lbl ">
                                                        {{ $color . ' Days' }}
                                                    </label>
                                                </h5>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- Applying scoobooo layout in color and other attri --}}
                @if (isset($additional_attribute) && $additional_attribute->count() >= 0)
                    @foreach ($additional_attribute as $key => $item)
                        @php
                            $testchk = getAttruibuteById($item);
                        @endphp
                        @if (isset($testchk) && getAttruibuteById($item)->visibility == 1)
                            <div class="container1 mt-3">
                                <!-- Collapsible Button -->
                                <h6 class="collapsible" data-bs-toggle="collapse"
                                    data-bs-target="#AttributeList_{{ $key }}" aria-expanded="false"
                                    aria-controls="AttributeList_{{ $key }}">
                                    {{ getAttruibuteById($item)->name }}
                                    <i class="fas fa-chevron-down fa-xs"></i>
                                </h6>
                                @php
                                    $atrriBute_valueGet = getParentAttruibuteValuesByIds($item, $proIds);
                                @endphp
                                <div class="collapse" id="AttributeList_{{ $key }}">
                                    <ul class="list-unstyled mt-2 mb-0 custom-scrollbar">
                                        @foreach ($atrriBute_valueGet as $mater)
                                            @if ($mater != '' || $mater != null)
                                                <li>
                                                    <h5 class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="{{ $mater }}"
                                                            id="searchId{{ $mater }}"
                                                            name="searchVal_{{ $key }}[]"
                                                            @if (request()->has("searchVal_$key")) @if (isset($mater) && in_array($mater, request()->get("searchVal_$key")))
                                                                                                         checked @endif
                                                            @endif >
                                                        <label for="searchId{{ $mater }}"
                                                            class="form-check-label fltr-lbl ">
                                                            {{ getAttruibuteValueById($mater)->attribute_value ?? '' }}
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
                {{-- <div class="mx-2 d-flex">
                    <input type="checkbox" class="form-check-input visually-hidden" name="exclusive" id="exclusive"
                        @if ($request->get('exclusive')) checked @endif>
                    <label class="form-check-label mx-2" id="excl">Exclusive
                        Items</label>
                    @if ($request->get('exclusive') == 'on')
                        <div class="text-success" style="font-weight: bolder">
                            <i class="uil-check-circle" style="font-size: 20px"></i>
                        </div>
                    @else
                        <div class="text-danger" style="font-weight: bolder"> OFF </div>
                    @endif
                </div> --}}
                <div class="mx-2 d-flex my-3">
                    <input type="checkbox" class="form-check-input " name="pinned" id="pinned"
                        @if ($request->get('pinned')) checked @endif>
                    <label class="form-check-label mx-2" id="pinnedbtn" for="pinned">Pinned Items
                        Only</label>
                    @if ($request->get('pinned') == 'on')
                        <div class="text-success" style="font-weight: bolder">
                            <i class="uil-check-circle" style="font-size: 20px"></i>
                        </div>
                    @else
                        {{-- <div class="text-danger" style="font-weight: bolder"> OFF </div> --}}
                    @endif
                </div>
                {{-- Exclusive Products --}}

            </div>
        </form>
    </div>
    {{-- <div class="col-md-3 col-lg-4"> --}}
    <div class="row ">
        <div class="col-6 col-md-6 col-lg-4">
            <button type="submit" class="btn mt-2 d-block btn-primary w-100" id="filterBtn"
                form="searchform">Filter</button>
        </div>
        <div class="col-6 col-md-6 col-lg-4">
            <a class="btn mt-2 d-block btn-primary w-100" href="{{ route('pages.shop-index') }}"
                id="resetButton">Reset</a>
        </div>
    </div>
    {{-- <button type="submit" class="btn mt-2 d-block btn-primary w-100" id="filterBtn" form="searchform">Filter</button>
    @if (isset($proposalid) && $proposalid != -1)
        <a class="btn mt-2 d-block btn-primary w-100" href="{{ route('pages.proposal.edit',['proposal' => $proposalid,'user_key' => $user_key]) }}?margin=0" id="resetButton">Reset</a>
    @else
        <a class="btn mt-2 d-block btn-primary w-100" href="{{route('pages.shop-index')}}" id="resetButton">Reset</a>
    @endif --}}
    {{-- </div> --}}

</div><!--end col-->
