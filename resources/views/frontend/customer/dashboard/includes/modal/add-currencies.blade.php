<div class="modal fade" id="addcurrency" role="dialog" aria-labelledby="addcurrencyTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addcurrencyTitle">Add Currencies</h5>
                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close"
                    style="padding: 0px 20px;font-size: 20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('panel.currency.upload.single',auth()->id())}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3 ">
                        @php
                            $record = App\Models\Country::where('currency','!=','')->groupBy('currency')->get();
                        @endphp
                        <label for="nameofcr">Name of Currency <span class="text-danger">*</span></label>
                        <select name="nameofcr" id="nameofcr" class="form-control currselect2insidemodal" required>
                            <option >Select Currency</option>
                            @foreach ($record as $item)
                                <option value="{{ $item->currency }}"> {{ $item->currency }}  {{  " - ".$item->name }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="exchangerate">Exchange Rate <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Enter Exchange Rate" name="exchangerate" id="exchangerate" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="remarks">Remarks</label>
                        <input type="text" class="form-control" placeholder="Enter Exchange Rate" name="remarks" id="remarks">
                    </div>

                    <button type="submit" class="btn btn-outline-primary mb-3">Submit</button>
                   
                </form>
            </div>
        </div>
    </div>
</div>
