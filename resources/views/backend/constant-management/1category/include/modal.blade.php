<div class="modal fade" id="editIndustry" role="dialog" aria-labelledby="editIndustryTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editIndustryTitle">Add Industries</h5>
        <div class="">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      </div>
      <div class="modal-body">
          <form action="{{ route('customer.industry.update',auth()->id()) }}" method="post">
            @csrf
              <div class="row">
                <div class="col-md-12 col-12"> 
                    <div class="form-group">
                        <label class="form-label">Industry</label>
                          <select name="industry_id[]" id="industry_id" class="form-control select2 ps-5" multiple data-placeholder="Select" required>
                              @php
                                  $user = auth()->user();
                                  $industry_id = json_decode($user->industry_id,true);
                              @endphp
                              @foreach(App\Models\Category::whereCategoryTypeId(13)->whereType(1)->whereParentId(null)->get();  as $option)
                                  <option {{in_array($option->id, $industry_id ?: []) ? "selected": ""}} value="{{ $option->id }}" {{  old('industry_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option> 
                              @endforeach
                          </select>
                    </div>
                </div>
                <div class="col-12 text-right">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
          </form>
        </div>
    </div>
  </div>
</div>