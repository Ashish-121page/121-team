<div class="card-body1 mt-5" style="padding:30px  0px ! important;" id="hztab">
   <div class=" col-md-12 col-lg-12 col-sm-12  d-flex flex-wrap justify-content-between gap-1"  style="padding: 0px ;">

        @if($acc_permissions->managegroup == "yes")
            @if ($Team_categorygroup)
            <div class="cardbx col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 ywqgqdya product-card product-box d-flex flex-column border bg-white"  style="width: 25rem;;max-width: 25rem; min-height: 13.5rem;max-height: 15rem;outline: none !important">
                <a id="addcategory" href="#animatedModal12" role="button" class="text-dark btn btn-outline-primary" style="display: block;height: 92%;width: 100%;position: absolute;left: 0;text-align: center;">
                    <span style="height: 100%;display: flex;width: 100%;justify-content: center;align-items: center;">+ Add Category</span>
                </a>

            </div>
            @endif
        @endif

        @foreach ($categories as $item)
            <div class="cardbx col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 ywqgqdya product-card product-box d-flex flex-column border bg-white"  style="width: 25rem;;max-width: 25rem; min-height: 13.5rem;max-height: 15rem;">
                <div class="head d-flex justify-content-between  my-2" style="font-size: .rem !important;">
                    <div class="one col-10">
                        <div style="font-weight: bold; font-size: large !important;" > {{ $item->name }} </div>
                        <small class="text-muted" style="font-size: medium;"> {{ getProductCountViaCategoryIdOwner($item->id,auth()->id(),1) }} Products</small>
                    </div>
                    <div class="two col-2 d-flex flex-column justify-content-start align-items-start" col-2 d-flex flex-column justify-content-start align-items-start">
                        {{-- <a href="#one" class="btn text-primary btn-sm invisible">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#one" class="btn text-primary btn-sm invisible">
                            <i class="fas fa-trash"></i>
                        </a> --}}
                        @if (auth()->id() == $item->user_id)
                            <a href="#edit" class="btn text-primary border border-primary btn-icon btn-sm opencateedit" data-catidchange="{{ $item->id }}"  data-catname="{{ $item->name }}">
                                <i class="fas fa-pencil-alt" style="line-height: 2 !important;"></i>
                            </a>
                        @endif
                        <a href="?type={{ request()->get('type') }}&type_ide={{ request()->get('type_ide') }}&productsgrid=true&category_id={{ $item->id }}" class="btn text-primary btn-sm">
                            <i class="fas fa-caret-right"></i>
                        </a>
                    </div>
                </div>

                <div class="cardbody d-flex gap-2" style="padding-bottom: 1rem; padding-top: 1rem;">
                    {{-- getting Last 3 Record of Product --}}
                    @php
                        $last_Records = App\Models\Product::where('category_id',$item->id)->orderBy('id','DESC')->limit(3)->get();
                    @endphp

                    @foreach ($last_Records as $last_Record)
                        <div class="col-6 col-md-4 col-lg-3 justify-content-between d-flex" style="height: 100px; width: 100px;object-fit: contain; padding:0px;">
                            <img src="{{ asset(getShopProductImage($last_Record->id)->path ?? '')  ?? ''}}"  class="img-fluid p-1" style="border-radius: 10px;height: 100%; width: 100%;">
                        </div>
                    @endforeach


                </div>
                {{-- <div class="custom-chk prdct-checked" style="display: flex;align-items: flex-end;justify-content: end;margin: 10px;">
                    <input type="checkbox" name="editcat" class="input-check" id="editcat" value="{{ $item->id }}">
                    <span class="checkmark"></span>
                </div> --}}

                <label class="custom-chk prdct-checked" data-select-all="boards" style="bottom: 0; right: 20px; display: block  ">
                    <input type="checkbox" name="editcat" class="input-check d-none" id="editcat" value="{{ $item->id }}">
                    <span class="checkmark"></span>
                    {{-- @if (auth()->id() == $item->user_id)
                        <a href="#edit" style="position: absolute;left: -30px;top: 10px;" class="btn-link opencateedit" data-catidchange="{{ $item->id }}"  data-catname="{{ $item->name }}">Edit</a>
                    @endif --}}
                </label>

            </div>
        @endforeach

        {{-- Own Category --}}
        @php
            $own_categories = App\Models\Category::whereNotIn('id',$categories->pluck('id'))->where('user_id',auth()->id())->where('level',2)->orderBy('name','ASC')->get();
        @endphp

        @foreach ($own_categories as $item)
            <div class="cardbx col-12 col-sm-12 col-md-6 col-lg-4 col-xl-3 ywqgqdya product-card product-box d-flex flex-column border bg-white" style="width: 25rem;;max-width: 25rem; min-height: 13.5rem;max-height: 15rem;">
                <div class="head d-flex justify-content-between my-2">
                    <div class="one col-10">
                        <div style="font-weight: bold"> {{ $item->name }} </div>
                        <small class="text-muted"> {{ getProductCountViaCategoryIdOwner($item->id,auth()->id(),1) }} Product</small>
                    </div>
                    <div class="two col-2 d-flex flex-column justify-content-start align-items-start"">
                        {{-- <a href="#one" class="btn text-primary btn-sm invisible">
                            <i class="fas fa-edit"></i>
                        </a> --}}
                        @if (auth()->id() == $item->user_id)
                            <a href="#edit" class="btn text-primary border border-primary btn-icon btn-sm opencateedit" data-catidchange="{{ $item->id }}"  data-catname="{{ $item->name }}">
                                <i class="fas fa-pencil-alt" style="line-height: 2 !important;"></i>
                            </a>
                        @endif
                        <a href="?type={{ request()->get('type') }}&type_ide={{ request()->get('type_ide') }}&products=true&category_id={{ $item->id }}" class="btn text-primary btn-sm">
                            <i class="fas fa-caret-right"></i>
                        </a>
                    </div>
                </div>

                <div class="cardbody d-flex gap-2" style="padding-bottom: 1rem; padding-top: 1rem;">
                    {{-- getting Last 3 Record of Product --}}
                    @php
                        $last_Records = App\Models\Product::where('category_id',$item->id)->groupBy('model_code')->orderBy('id','DESC')->limit(3)->get();
                    @endphp
                    @foreach ($last_Records as $last_Record)
                        <div class=" col-6 col-md-5 col-lg-3" style="height: 100px; width: 100px;object-fit: contain">
                            <img src="{{ asset(getShopProductImage($last_Record->id)->path) }}"  class="img-fluid p-1" style="border-radius: 10px;height: 100%; width: 100%;">
                        </div>
                    @endforeach


                </div>
                <label class="custom-chk prdct-checked" data-select-all="boards" style="bottom: 0; right: 20px; display: block  ">
                    <input type="checkbox" name="editcat" class="input-check d-none" id="editcat" value="{{ $item->id }}">
                    <span class="checkmark"></span>
                </label>
            </div>
        @endforeach

   </div>


    <form action="{{ route('panel.constant_management.category.bulk.delete',auth()->id()) }}" method="POST" id="categoryDeleteForm">
        <input type="hidden" name="delete_ids" id="delete_ids">
    </form>




    <form id="export_category_product" action="{{ route('panel.bulk.product.bulk-export',auth()->id()) }}">

        <div class="form-control ">
            <input type="hidden" name="choose_cat_ids" id="choose_cat_ids" value="">
        </div>

    </form>


</div>
<a class="btn btn-outline-primary d-none" id="demo01" href="#animatedModal" role="button"></a>

@if($acc_permissions->managegroup == "yes")
    @if ($Team_categorygroup)
        @include('panel.user_shop_items.modal.edit-category')
        @include('backend.constant-management.category.include.add-category')
    @endif
@endif
