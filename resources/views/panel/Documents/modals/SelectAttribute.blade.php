<div class="modal fade" id="AttriModal" tabindex="-1" aria-labelledby="AttriModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="background-color:#ffff; max-width:1300px !important;">
        <div class="modal-content" style="margin-top:0%;">
            <div class="modal-header">
                <h6 class="modal-title fs-5" id="AttriModalLabel">Select Columns</h6>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <div class="col-lg-12 col-md-6 col-12 my-3" style="overflow: auto; max-height: 80vh">

                    <div class="row">
                        <div class="col-12 col-lg-12 col-md-12 my-3">
                            <div class="h5">Default Attribute</div>
                        </div>
                        <div class="-12 col-lg-12 col-md-12">
                            <div class="row">
                                <div class="col-3">
                                    <div style="display: flex;align-content: center;justify-content: start;margin: 10px">
                                        <input type="checkbox" name="column-Default[]" id="column-model_code" class="mx-2" checked>
                                        <label for="column-model_code" class="mb-0">{{ __("Model Code") }}</label>
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div style="display: flex;align-content: center;justify-content: start;margin: 10px">
                                        <input type="checkbox" name="column-Default[]" id="column-product_img" class="mx-2" checked>
                                        <label for="column-product_img" class="mb-0">{{ __("Product Image") }}</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 col-lg-12 col-md-12 my-3 d-flex align-items-center">
                            <div class="form-group">
                                <label for="select-All-Default" class="mx-2 h6"> Default Attribute </label>
                                <input type="checkbox" id="select-All-Default">
                            </div>

                        </div>
                        <div class="-12 col-lg-12 col-md-12">
                            <div class="row">
                                @foreach (json_decode($user->custom_attriute_columns) as $item)
                                    @php
                                        $tmp_name = str_replace(' ','_',$item);
                                        $tmp_ID = str_replace(',','',$tmp_name);
                                    @endphp
                                    <div class="col-3">
                                        <div style="display: flex;align-content: center;justify-content: start;margin: 10px">
                                            <input type="checkbox" name="column-{{ $tmp_name }}[]" id="column-{{ $tmp_ID }}" class="choosefields mx-2">
                                            <label for="column-{{ $tmp_ID }}" class="mb-0">{{ $item }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary ml-auto"  data-bs-dismiss="modal">Proceed</button>
            </div>


        </div>
    </div>
</div>
