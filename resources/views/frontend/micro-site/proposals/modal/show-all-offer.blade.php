<div class="modal fade" id="showalloffer" tabindex="-1" aria-labelledby="showallofferLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="showallofferLabel">Show All Offers</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ encrypt(auth()->id()) }}">
                    <input type="hidden" name="product_ids" id="collection_product_ids">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="offer_name_to_add">Select Offer <span class="text-danger">*</span></label>
                                <select name="offer_name_to_add" id="offer_name_to_add" class="form-control select2">
                                    <option>Select Offer ( Offer name - Buyer Name )</option>
                                    @forelse ($existing_offers as $offer)
                                        @php
                                            $customer_details = json_decode($offer->customer_details)->offer_name ?? 'No Offer Name';
                                            $customer_name = json_decode($offer->customer_details)->customer_name ?? 'No Buyer Name';
                                        @endphp
                                        <option value="{{ $offer->id }}"> {{ $customer_details . ' - ' . $customer_name }} </option>
                                    @empty
                                        <option value="">No Offer Found</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
