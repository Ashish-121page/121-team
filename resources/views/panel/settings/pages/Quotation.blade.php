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
                        <div class="d-flex flex-wrap">
                            
                            <div class="form-group mx-2">
                                <label for="exampleSelect">Entity</label>
                                <select class="form-control" id="exampleSelect">
                                    <option>Entity One</option>
                                    <option>Entity Two</option>
                                    <option>Entity Three</option>
                                </select>
                            </div>

                            {{-- Quoation Section Start --}}
                            <div class="form-group mx-1">
                                <label for="quotaion_mark">Quotation ID Prefix <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="quotaion_mark" id="quotaion_mark" placeholder="Quotaion Mark" value="{{ $quot->quotaion_mark ?? '' }}">
                            </div>
                            <div class="form-group mx-2">
                                <label for="quotaion_index">Quotation ID start <span class="text-danger">*</span></label>
                                <input type="number" min="1" class="form-control" name="quotaion_index" id="quotaion_index" placeholder="Quotaion index" value="{{ $quot->quotaion_index ?? '1' }}">
                            </div>
                            {{-- Quoation Section End --}}

                            {{-- Offer Section Start --}}
                            <div class="form-group mx-1">
                                <label for="offer_mark">Offer ID Prefix <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="offer_mark" id="offer_mark" placeholder="offer Mark" value="{{ $quot->offer_mark ?? '' }}">
                            </div>
                            <div class="form-group mx-2">
                                <label for="offer_index">Offer ID Start <span class="text-danger">*</span></label>
                                <input type="number" min="1" class="form-control" name="offer_index" id="offer_index" placeholder="Offer index" value="{{ $quot->offer_index ?? '1' }}">
                            </div>
                            {{-- Offer Section End --}}

                            {{-- PI Section Start --}}
                            <div class="form-group mx-1">
                                <label for="performa_mark">PI ID Prefix <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="performa_mark" id="performa_mark" placeholder="PI Mark" value="{{ $quot->performa_mark ?? '' }}">
                            </div>
                            <div class="form-group mx-2">
                                <label for="performa_index">PI ID Start <span class="text-danger">*</span></label>
                                <input type="number" min="1" class="form-control" name="performa_index" id="performa_index" placeholder="PI index" value="{{ $quot->performa_index ?? '1' }}">
                            </div>
                            {{-- PI Section End --}}

                            {{-- Invoice Section Start --}}
                            <div class="form-group mx-1">
                                <label for="invoice_mark">Invoice ID Prefix <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="invoice_mark" id="invoice_mark" placeholder="Invoice Mark" value="{{ $quot->invoice_mark ?? '' }}">
                            </div>
                            <div class="form-group mx-2">
                                <label for="invoice_index">Invoice ID Start <span class="text-danger">*</span></label>
                                <input type="number" min="1" class="form-control" name="invoice_index" id="invoice_index" placeholder="invoice index" value="{{ $quot->invoice_index ?? '1' }}">
                            </div>
                            {{-- Invoice Section End --}}


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
