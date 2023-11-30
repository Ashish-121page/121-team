<div class="modal fade" id="updatecurrency" role="dialog" aria-labelledby="updatecurrencyTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatecurrencyTitle">Update Currency</h5>
                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close"
                    style="padding: 0px 20px;font-size: 20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('panel.currency.update.single') }}" method="POST">
                    @csrf
                    @php
                        $record = App\Models\Country::where('currency','!=','')->groupBy('currency')->get();
                    @endphp
                    <input type="hidden" name="crrid" id="crrid">
                    <input type="hidden" name="userid" id="userid" value="{{ auth()->id() }}">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="form-group mb-3">
                                <label for="currencyname" class="form-label">Currency</label>
                                <select name="currencyname" id="currencyname" class="form-control curreditselect2insidemodal-">
                                    <option >Select Currency</option>
                                    @foreach ($record as $item)
                                        <option value="{{ $item->currency }}"> {{ $item->currency }}  {{  " - ".$item->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="currencyvalue" class="form-label">Exchange Rate <span class="text-danger">*</span></label>
                                <input class="form-control" name="currencyvalue" required type="text" id="currencyvalue"
                                    placeholder="Enter Rate">
                            </div>


                        </div>
                        
                        
                        
                        <div class="col-12 text-right mt-4">
                            <button type="submit" class="btn btn-outline-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
