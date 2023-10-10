<!-- Modal -->
<div class="modal fade" id="updatePriceGroup" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form action="{{ route('panel.seller.update.price-group') }}" >
            @csrf
            <input type="hidden" name="request_id" value="" id="requestId">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Accept Catalogue Request</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">Enter Price Group</label>
                            <select name="price_group_id" id="" class="form-control">
                                <option value="" aria-readonly="true">Select Group</option>
                                @foreach (App\Models\Group::where('user_id',[auth()->id()])->get() as $group)
                                    <option value="{{ $group->id }}">
                                        {{-- GRP{{ getPrefixZeros($group->id) }} -  --}}
                                        {{ $group->name }}</option>
                                @endforeach
                            </select>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>    
    </div>
  </div>
</div>