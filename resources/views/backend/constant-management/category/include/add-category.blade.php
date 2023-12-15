<div id="animatedModal12" style="overflow: hidden">
    <div class="modal-content custom-spacing" style="hweight: 100%;display: flex;align-items: center;justify-content: center;padding: 10px">
        
        <div class="d-flex justify-content-between w-100 ">
            <div class="h5 m-3">Add New Category</div>
            {{-- <div id="btn-close-modal" class="close-animatedModal12 d-flex justify-content-between w-100  custom-spacing"
            style="color:black;font-size: x-large;margin: 10px;display: flex;justify-content: space-between;background-color: white">
                <i class="far fa-times-circle fa-rotate-270 fa-lg "></i>
            </div> --}}
        </div>


        <form action="{{ route('panel.constant_management.category.store') }}" method="post" enctype="multipart/form-data" class="my-3">
            @csrf
            {{-- Type ID 13 As Gifting --}}
            <input type="hidden" name="parent_id" value="{{ request()->get('parent_id') ?? null }}">
            <input type="hidden" name="category_type_id" value="{{ encrypt('13') }}">
            <input type="hidden" name="user_id" value="{{ encrypt(auth()->id()) }}">
            <input type="hidden" name="shop_id" value="{{ encrypt(getShopDataByUserId(auth()->id())->id) }}">

            
            <div class="row" style="width: 37rem"> 
                <div class="col-md-12 col-12"> 
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        <label for="name" class="control-label">Category Name<span class="text-danger">*</span></label>
                        <input class="form-control" name="name" id="newcatname" type="text" id="name" value="{{old('name')}}" placeholder="Enter Name"  list="availablecategory" required autocomplete="off">

                        <datalist id="availablecategory">
                            @php
                                if (!isset($sub_category)) {
                                    $sub_category = App\Models\Category::where('level',3)->get();
                                }
                            @endphp
                            @foreach ($sub_category as $item)
                                @if ($item->name == 'Sub Sub')
                                    @continue   
                                @endif
                                @php
                                    $parentname = App\Models\Category::where('id',$item->parent_id)->first();
                                @endphp
                                <option value="{{ $parentname->name }} > {{ $item->name }}">{{ $parentname->name }} > {{ $item->name }}</option>
                            @endforeach
                        </datalist>
                    </div>
                </div>
                                                                            
            
                <div class="col-md-12 col-12"> 
                    <div class="form-group mb-0">
                        <label for="input">{{ __('Sub Categories')}} <span class="text-danger">*</span> </label>
                    </div>
                    <div class="alert alert-warning" style="widtdsh: fit-content" role="alert">
                        <i class="fas fa-info-circle mx-2"></i> Enter multiple values, seperated by comma (,)
                    </div>
                    <div class="form-group">
                        <input style="width: 100%" name="value[]" type="text" id="tags" class="form-control" value="" required>
                    </div>
                    
                </div>
                                            
                <div class="col-md-12 ml-auto d-flex justify-content-between align-items-center ">
                    <button type="button" class="btn btn-outline-primary close-animatedModal12">Cancel</button>
                    <button type="submit" class="btn btn-outline-primary">Create</button>
                </div>
            </div>
        </form>


        
    </div> {{-- Modal Body End --}}
</div>

<script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#tags').tagsinput('items');
    });
</script>