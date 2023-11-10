<div class="modal fade" id="selectGlobalMOdal" role="dialog" aria-labelledby="selectGlobalMOdalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form method="post" action="{{ route('panel.constant_management.category.select.global',encrypt(auth()->id())) }}">

                <div class="modal-header">
                    <h6 class="modal-title fs-5" id="selectGlobalMOdalLabel">
                        Select Global Category
                    </h6>
                    <button type="button" class="btn-close btn btn-outline-primary" data-bs-dismiss="modal"
                        aria-label="Close">
                        X
                    </button>
                </div>

                 <div class="modal-body">
                    <div class="form-group">
                        <label for="globalcategory"> Select Available Global Categories <span class="text-danger">*</span> </label>
                        <select name="globalcategory[]" id="globalcategory" class="form-control select2 ps-5" multiple required >
                            @php
                                $chkdata = array_column($category,'id');
                            @endphp
                            @foreach ($category_global as $item)
                                @if (in_array($item['id'],$chkdata))
                                    @continue
                                @endif
                                <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                
            </form>

        </div>
    </div>
</div>