<div class="modal fade" id="addSeller" role="dialog" aria-labelledby="addSellerTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSellerTitle">Add Seller</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form action="{{ route('panel.brand_user.store') }}" method="post">
            @csrf
            <input type="hidden" name="brand_id" value="{{ $brand_id }}">
              <div class="row">
                <div class="col-md-12 col-12"> 
                    <div class="form-group">
                        <label for="user_id">User <span class="text-danger">*</span></label>
                        <select required name="user_id" id="user_id" class="form-control select2">
                            <option value="" readonly>Select User </option>
                            @foreach(UserList() as $option)
                                <option value="{{ $option->id }}" {{  old('user_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option> 
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12 col-12"> 
                    <div class="form-group">
                        <label for="status">Status<span class="text-danger">*</span></label>
                        <select required name="status" class="form-control select2"  >
                            <option value="" readonly>{{ __('Select Status')}}</option>
                            @foreach (getBrandStatus() as $index => $item)
                                <option value="{{ $item['id'] }}">{{ $item['name'] }}</option> 
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12 col-12"> 
                    <div class="form-group {{ $errors->has('is_verified') ? 'has-error' : ''}}">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="is_verified" name="is_verified"
                                value="1">
                            <span class="pt-1 custom-control-label">&nbsp;Verify</span>
                        </label>
                    </div>
                </div>
                <div class="col-12 text-right">
                  <button type="submit" class="btn btn-outline-primary">Add</button>
                </div>
              </div>
          </form>
        </div>
    </div>
  </div>
</div>