<div class="col-12">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('panel.settings.quot.setting') }}" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                        @php
                            $quot = json_decode(auth()->user()->settings);
                        @endphp
                        <div class="d-flex">
                            <div class="form-group mx-1">
                                <label for="quotaion_mark">Quotation Mark <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="quotaion_mark" id="quotaion_mark" placeholder="Quotaion Mark" value="{{ $quot->quotaion_mark ?? '' }}">
                            </div>
                            <div class="form-group mx-2">
                                <label for="quotaion_index">Quotation Number start Value <span class="text-danger">*</span></label>
                                <input type="number" min="1" class="form-control" name="quotaion_index" id="quotaion_index" placeholder="Quotaion index" value="{{ $quot->quotaion_index ?? '1' }}">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-outline-primary">
                            Submit
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
