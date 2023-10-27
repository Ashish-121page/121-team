<div class="card-body">
   <div class="d-flex gap-2 flex-wrap">

        @if($acc_permissions->managegroup == "yes")
            @if ($Team_categorygroup)
            <div class="cardbx d-flex flex-column border bg-white m-2" style="width: 25rem;height: 200px;">
                <a href="{{ route('panel.seller.category.index','13') }}" class="bg-primary text-danger" style="color:white;height: 100%;width: 100%;display: flex;align-items: center;justify-content: center;font-size: larger;background-color: #6e6ee683;">
                    + Add Category
                </a>
            </div>
            @endif
        @endif

        @foreach ($categories as $item)
            <div class="cardbx d-flex flex-column border bg-white m-2" style="width: 25rem;;max-width: 25rem;">
                <div class="head d-flex justify-content-between mx-3 my-2">
                    <div class="one">
                        <div style="font-weight: bold"> {{ $item->name }} </div>
                        <small class="text-muted"> {{ getProductCountViaCategoryIdOwner($item->id,auth()->id(),1) }} Product</small>
                    </div>
                    <div class="two">
                        <a href="#one" class="btn text-primary btn-sm invisible">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#one" class="btn text-primary btn-sm invisible">
                            <i class="fas fa-trash"></i>
                        </a>
                        <a href="?type={{ request()->get('type') }}&type_id={{ request()->get('type_id') }}&products=true&category_id={{ $item->id }}" class="btn text-primary btn-sm">
                            <i class="fas fa-caret-right"></i>
                        </a>
                    </div>
                </div>

                <div class="cardbody d-flex gap-2 p-4">
                    {{-- getting Last 3 Record of Product --}}
                    @php
                        $last_Records = App\Models\Product::where('category_id',$item->id)->orderBy('id','DESC')->limit(3)->get();
                    @endphp

                    @foreach ($last_Records as $last_Record)
                        <div style="height: 100px; width: 100px;object-fit: contain">
                            <img src="{{ asset(getShopProductImage($last_Record->id)->path) }}"  class="img-fluid p-1" style="border-radius: 10px;height: 100%; width: 100%;">
                        </div>    
                    @endforeach                    
                    
                    
                </div>
                <div style="display: flex;align-items: flex-end;justify-content: end;margin: 10px;">
                    <input type="checkbox" name="editcat" class="input-check" id="editcat" value="{{ $item->id }}">
                </div>                
            </div>
        @endforeach


        {{-- Own Category --}}
        @php
            $own_categories = App\Models\Category::whereNotIn('id',$categories->pluck('id'))->where('user_id',auth()->id())->where('level',2)->get();
        @endphp
        
        @foreach ($own_categories as $item)            
            <div class="cardbx d-flex flex-column border bg-white m-2" style="width: 25rem;;max-width: 25rem;">
                <div class="head d-flex justify-content-between mx-3 my-2">
                    <div class="one">
                        <div style="font-weight: bold"> {{ $item->name }} </div>
                        <small class="text-muted"> {{ getProductCountViaCategoryIdOwner($item->id,auth()->id(),1) }} Product</small>
                    </div>
                    <div class="two">
                        <a href="#one" class="btn text-primary btn-sm invisible">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#one" class="btn text-primary btn-sm invisible">
                            <i class="fas fa-trash"></i>
                        </a>
                        <a href="?type={{ request()->get('type') }}&type_id={{ request()->get('type_id') }}&products=true&category_id={{ $item->id }}" class="btn text-primary btn-sm">
                            <i class="fas fa-caret-right"></i>
                        </a>
                    </div>
                </div>

                <div class="cardbody d-flex gap-2 p-4">
                    {{-- getting Last 3 Record of Product --}}
                    @php
                        $last_Records = App\Models\Product::where('category_id',$item->id)->orderBy('id','DESC')->limit(3)->get();
                    @endphp

                    @foreach ($last_Records as $last_Record)
                        <div style="height: 100px; width: 100px;object-fit: contain">
                            <img src="{{ asset(getShopProductImage($last_Record->id)->path) }}"  class="img-fluid p-1" style="border-radius: 10px;height: 100%; width: 100%;">
                        </div>    
                    @endforeach                    
                    
                    
                </div>
                <div style="display: flex;align-items: flex-end;justify-content: end;margin: 10px;">
                    <input type="checkbox" name="editcat" class="input-check" id="editcat" value="{{ $item->id }}">
                </div>                
            </div>
        @endforeach
        
   </div>


    <form action="{{ route('panel.constant_management.category.bulk.delete',auth()->id()) }}" method="POST" id="categoryDeleteForm">
        <input type="hidden" name="delete_ids" id="delete_ids">
    </form>
    
</div>