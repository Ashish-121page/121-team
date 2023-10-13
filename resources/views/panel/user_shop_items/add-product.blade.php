
<div class="modal fade" id="addProductModal" role="dialog" aria-labelledby="addProductTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addProductTitle">Add Product</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('panel.user_shop_items.store') }}" method="post">
              @csrf
              <input type="hidden" name="product_id" class="productID" value="">
              <input type="hidden" name="product_price" class="priceInput" value="">
              <input type="hidden" name="user_id"  value="{{ $user_id }}">
              <input type="hidden" name="user_shop_id" value="{{ $user_shop->id }}">
              <input type="hidden" name="parent_shop_id" value="{{ $parent_shop->id ?? 0 }}">
              <input type="hidden" name="type_id" value="{{ request()->get('type_id')}}">
              <input type="hidden" name="type" value="{{ request()->get('type')}}">
              <div class="row">
                <div class="col-md-6 col-12"> 
                    <div class="form-group">
                        <label for="category_id">Category<span class="text-danger">*</span></label>
                        <select required name="category_id" id="category_id" class="form-control select2">
                            <option value="" readonly>Select Category</option>
                            @if($user->industry_id != null)
                                {{-- @foreach(getProductCategoryByUserIndrustry($user->industry_id)  as $option) --}} 
                                {{-- Get Category of User Industry   --}}
                                @foreach(getProductCategory()  as $option)
                                    <option value="{{ $option->id }}" {{  old('category_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? $prod}}</option> 
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-12"> 
                    <div class="form-group">
                        <label for="sub_category_id">Sub Category <span class="text-danger">*</span>
                            <i id="sub_cate_loader" style="display: none;" class="text-primary fa fa-spinner fa-spin"></i>
                        </label>
                        <select required name="sub_category_id" id="sub_category_id" class="form-control select2">
                            <option value="" readonly>Select Sub Category </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-12"> 
                    <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                        <label for="price" class="control-label">Shop Price</label>
                        <input  class="form-control" name="price" type="number" id="price" value="{{old('price')}}" placeholder="Enter Price" >
                    </div>
                </div>

                <div class="col-md-6 col-12"> 
                    <div class="form-group {{ $errors->has('is_published') ? 'has-error' : ''}}"><br>
                        <label for="is_published" class="control-label">Published</label>
                        <input class="js-single switch-input" @if(old('is_published')) @endif name="is_published" checked type="checkbox" id="is_published" value="1" >
                    </div>
                    <hr>
                </div>
                <div class="form-group form-check ml-3 mb-2 d-none">
                    <input class="form-check-input" style="position: absolute; top: -3px;" type="checkbox" id="price_checkbox" name="price_checkbox" value="1">
                    <label class="form-check-label" for="price_checkbox">
                       I also want to add Price Groups
                    </label>
                </div>
                <div class="col-md-12 price_groups d-none">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12 repeatergruop_price">
                                <div class="form-group p-0" data-repeater-list="price_groups">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="row p-0" data-repeater-item>
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label for="">Group</label>
                                                        <select name="group_id" id="group_id" class="form-control select2">
                                                        <option value="" readonly>Select Group </option>
                                                        @foreach(App\Models\Group::whereUserId($user_id)->get()  as $option)
                                                            <option value="{{ $option->id }}" {{  old('group_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option> 
                                                        @endforeach
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-5">
                                                    <div class="form-group">
                                                        <label for="">Price</label>
                                                        <input id="price" type="text" class="form-control"
                                                            name="price">
                                                    </div>
                                                </div>
                                                <div class="col-lg-1">
                                                    <button style="margin-top: 30px;" data-repeater-delete
                                                        type="button" class="btn btn-danger btn-icon"><i
                                                            class="ik ik-trash-2"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                                <button data-repeater-create type="button"
                                                    style="margin-top: 28px;"
                                                    class="btn btn-success btn-icon"><i
                                                        class="ik ik-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 ml-auto">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </div>

              </div>
            </form>
          </div>
      </div>
    </div>
  </div>