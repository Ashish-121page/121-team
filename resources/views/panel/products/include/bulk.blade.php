<div class="modal fade" id="productBulkModal" role="dialog" aria-labelledby="productBulkModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productBulkModalTitle"></h5>
        <div class="">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      </div>
      <div class="d-flex justify-content-around mt-2 mb-4">
          <div class="border p-3 text-center import-dev">
            <p>
              Add New Products in Bulk
            </p>
            <button class="btn btn-outline-info" id="import-btn">Import Products</button>
          </div>
          <div class="border p-3 text-center export-dev">
            <p>
              Edit Existing Product in Bulk 
            </p>
            <button class="btn btn-outline-info" id="export-btn">Export Products</button>
          </div>
      </div>
        <div class="modal-body import d-none pt-0">
          <div class="d-flex justify-content-end">
            <a href="{{ asset('utility/bulk-product.xlsx') }}" type="button"  class="btn-link mb-3">Download Template</a>
          </div>
          <form action="{{ route('panel.product-upload') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="brand_id" value="{{ $brand_id }}">
            @csrf
              <div class="row">
              <div class="col-md-6 col-12"> 
                <div class="form-group">
                    <label for="category_id">Category <span class="text-danger">*</span></label>
                    <select required name="category_id" id="bulk_category_id" class="form-control select2">
                        <option value="" readonly>Select Category </option>
                        @foreach(getProductCategory() as $option)
                            <option value="{{ $option->id }}" {{  old('category_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option> 
                        @endforeach
                    </select>
                </div>
              </div>
              <div class="col-md-6 col-12"> 
                  <div class="form-group">
                      <label for="sub_category">Sub Category <span class="text-danger">*</span></label>
                      <select required name="sub_category" data-selected-subcategory="{{ old('sub_category') }}" id="bulk_sub_category" class="form-control select2">
                          <option value="" readonly>Select Sub Category </option>
                      </select>
                  </div>
              </div>
                <div class="col-md-12 col-12"> 
                    <div class="form-group">
                        <label for="file">Upload Updated Excel Template<span class="text-danger">*</span></label>
                        <input required type="file" name="file" class="form-control">
                    </div>
                </div>
                <div class="col-12 text-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-body export d-none pt-0">
          <div class="d-flex justify-content-end">
            <a href="{{route('panel.product.bulk-export')}}" type="button" id  class="btn-link mb-3">Export Product List</a>
          </div>
          </button>
              <form action="{{ route('panel.product.bulk-update') }}" method="post" enctype="multipart/form-data">
                @csrf
                  <div class="row">
                    <div class="col-md-12 col-12"> 
                        <div class="form-group">
                            <label for="file">Upload Updated Excel Template<span class="text-danger">*</span></label>
                            <input required type="file" name="file" class="form-control">
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                            <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                  </div>
              </form>
        </div>
    </div>
  </div>
</div>
@push('script')
    <script>
      
    </script>
@endpush
