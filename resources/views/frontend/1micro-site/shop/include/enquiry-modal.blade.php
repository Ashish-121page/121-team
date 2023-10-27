<div class="modal fade" id="enquiryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded shadow-lg border-0 overflow-hidden">
            <div class="modal-header">
                <h5>Make Enquiry</h5>
                <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close" style="padding: 0px 20px;font-size: 20px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('pages.store-enquiry',$slug) }}" method="post" enctype="multipart/form-data" id="enquiryForm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="row">
                        <div class="col-md-4 col-12"> 
                            <div class="form-group">
                                <label for="price">Price<span class="text-danger">*</span></label>
                                {{-- <input class="form-control" name="price" value="{{ $product->price }}" required type="number" placeholder="Enter Price"> --}}
                                <input class="form-control"  step="0.01" name="price" value="{{ $price }}" id="price" required type="number" placeholder="Enter Price">
                            </div>
                        </div>
                        <div class="col-md-4 col-12"> 
                            <div class="form-group">
                                <label for="qty">Quantity<span class="text-danger">*</span></label>
                                <input class="form-control" id="enq-qty" name="qty" value="" required type="number" placeholder="Enter Quantity">
                            </div>
                        </div>
                        <div class="col-md-4 col-12"> 
                            <div class="form-group">
                                <label for="date">Required In<span class="text-danger">*</span></label>
                                <input class="form-control" name="date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" id="requiredIn" required type="date" placeholder="Enter Required In">
                            </div>
                        </div>
                        <div class="col-md-12 col-12 mt-3"> 
                            <div class="form-group">
                                <label for="comment">Comment<span class="text-danger">*</span></label>
                                <textarea class="form-control" name="comment" placeholder="Enter Comment" type="text" id="comment"></textarea>
                            </div>
                        </div>
                        <div class="col-12 text-right mt-4">
                        <button id="enquiryBtn" type="submit" class="btn btn-outline-primary">Submit Enquiry</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>