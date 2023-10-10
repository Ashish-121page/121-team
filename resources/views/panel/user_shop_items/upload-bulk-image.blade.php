<div class="modal fade" id="upload-image-bulk" role="dialog" aria-labelledby="addProductTitle" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="addProductTitle">Upload Bulk Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <form id="uploadBulkForm">
                @csrf
                <div class="row">
                    <div class="col-md-5 col-12"> 
                        <div class="form-group">
                            <label for="category_id">Category<span class="text-danger">*</span></label>
                            <select required name="category_id" class="form-control select2 category_id">
                                <option value="" readonly>Select Category</option>
                                @foreach(getProductCategoryByUserIndrustry(auth()->user()->industry_id)  as $option)
                                    <option value="{{ $option->id }}">{{  $option->name ?? ''}}</option> 
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-5 col-12"> 
                        <div class="form-group">
                            <label for="sub_category_id">Sub Category <span class="text-danger">*</span></label>
                            <select name="sub_category_id" class="form-control select2 sub_category_id ">
                                <option readonly>Select Sub Category </option>
                             
                            </select>
                        </div>
                    </div>
                    <div class="col-2 col-2 d-flex justify-content-center align-items-center">
                        <div class="d-flex justify-content-end mt-2">
                            <button class="btn btn-primary" id="">Search</button>
                        </div>
                    </div>
                </div>
            </form>

            <form action="{{ route('panel.user_shop_items.update.media.items') }}" method="post" class="mt-3">
                @csrf
                <input type="hidden" name="id" value="{{ $user_shop_item->id }}">

                <div class="" id="images-grid">
                    
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div>