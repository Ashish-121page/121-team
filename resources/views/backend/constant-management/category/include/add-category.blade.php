<div id="animatedModal">
    <div class="modal-content custom-spacing" style="hweight: 100%;display: flex;align-items: center;justify-content: center;">
        
        <div class="d-flex justify-content-between w-100 ">
            <div id="btn-close-modal" class="close-animatedModal d-flex justify-content-between w-100  custom-spacing"
            style="color:black;font-size: x-large;margin: 10px;display: flex;justify-content: space-between;background-color: white">
                <h5>Add New Categroy</h5>
                <i class="far fa-times-circle fa-rotate-270 fa-lg "></i>
            </div>
        </div>


        <form action="{{ route('panel.constant_management.category.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            {{-- Type ID 13 As Gifting --}}
            <input type="hidden" name="parent_id" value="{{ request()->get('parent_id') ?? null }}">
            <input type="hidden" name="category_type_id" value="{{ encrypt('13') }}">
            <input type="hidden" name="user_id" value="{{ encrypt(auth()->id()) }}">
            <input type="hidden" name="shop_id" value="{{ encrypt(getShopDataByUserId(auth()->id())->id) }}">

            
            <div class="row">               
                <div class="col-md-12 col-12"> 
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        <label for="name" class="control-label">Category Name<span class="text-danger">*</span></label>
                        <input required  class="form-control" name="name" type="text" id="name" value="{{old('name')}}" placeholder="Enter Name" >
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
                                            
                <div class="col-md-12 ml-auto">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
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