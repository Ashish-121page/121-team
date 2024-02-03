
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
                        <div class="d-flex flex-wrap justify-content-between text-center ">

                            <div class="row my-2">

                                {{-- Quoation Entity DropDown Start --}}
                                @php
                                    if (($quot->quotaion_mark ?? '') && ($quot->quotaion_index ?? '') && ($quot->offer_mark ?? '') && ($quot->offer_index ?? '') && ($quot->performa_mark ?? '') && ($quot->performa_index ?? '') && ($quot->invoice_mark ?? '') && ($quot->invoice_index ?? '') ) {
                                        $isDisabled = 'disabled';
                                    } else {
                                        $isDisabled = '';
                                    }
                                @endphp


                                <div class="col-12 col-md-6 col-lg-3" style="border-right: 1px solid #eaeaea;">
                                    <div class="form-group mx-2">
                                        <label for="entity_name" class="text-danger ">Entity</label>
                                        <select class="form-control select2" id="entity_name" name="entity_name" {{ $isDisabled }}>
                                            @foreach ($address as $item)
                                                <option>{{ json_decode($item->details)->entity_name ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Quoation Entity DropDown Start --}}

                                {{-- Quoation Section Start --}}
                                <div class="col-12 col-md-6 col-lg-2" style="border-right: 1px solid #eaeaea;">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mx-1">
                                                <label for="quotaion_mark">Quotation ID Prefix <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="quotaion_mark"
                                                    id="quotaion_mark" placeholder="Quotaion Mark"
                                                    value="{{ $quot->quotaion_mark ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group mx-2">
                                                <label for="quotaion_index">Quotation ID start <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" min="1" class="form-control"
                                                    name="quotaion_index" id="quotaion_index"
                                                    placeholder="Quotaion index"
                                                    value="{{ $quot->quotaion_index ?? '1' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Quoation Section End --}}


                                {{-- Offer Section Start --}}
                                <div class="col-12 col-md-6 col-lg-2" style="border-right: 1px solid #eaeaea;">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mx-1">
                                                <label for="offer_mark">Offer ID Prefix <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="offer_mark"
                                                    id="offer_mark" placeholder="offer Mark"
                                                    value="{{ $quot->offer_mark ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mx-2">
                                                <label for="offer_index">Offer ID Start <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" min="1" class="form-control"
                                                    name="offer_index" id="offer_index" placeholder="Offer index"
                                                    value="{{ $quot->offer_index ?? '1' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Offer Section End --}}


                                {{-- PI Section Start --}}
                                <div class="col-12 col-md-6 col-lg-2" style="border-right: 1px solid #eaeaea;">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mx-1">
                                                <label for="performa_mark">PI ID Prefix <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="performa_mark"
                                                    id="performa_mark" placeholder="PI Mark"
                                                    value="{{ $quot->performa_mark ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group mx-2">
                                                <label for="performa_index">PI ID Start <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" min="1" class="form-control"
                                                    name="performa_index" id="performa_index" placeholder="PI index"
                                                    value="{{ $quot->performa_index ?? '1' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- PI Section End --}}

                                {{-- Invoice Section Start --}}
                                <div class="col-12 col-md-6 col-lg-2" >
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group mx-1">
                                                <label for="invoice_mark" class="text-danger ">Invoice ID Prefix
                                                    <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="invoice_mark"
                                                    id="invoice_mark" placeholder="Invoice Mark"
                                                    value="{{ $quot->invoice_mark ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group mx-2">
                                                <label for="invoice_index" class="text-danger ">Invoice ID Start
                                                    <span class="text-danger">*</span></label>
                                                <input type="number" min="1" class="form-control"
                                                    name="invoice_index" id="invoice_index"
                                                    placeholder="invoice index"
                                                    value="{{ $quot->invoice_index ?? '1' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Invoice Section End --}}


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
