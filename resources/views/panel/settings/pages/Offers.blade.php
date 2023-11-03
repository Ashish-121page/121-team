@php
    $record = App\Models\Media::where('type_id',auth()->id())->where('type','OfferBanner')->get();
@endphp

<div class="col-12">
    <div class="row">
        <div class="col-12 my-3 text-center">
            <div class="h4">Offer</div>
        </div>
        
        <div class="col-md-10 col-12">

            <div class="card">
                <div class="card-header">
                    <h5>Offers</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('panel.settings.upload.banner') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ encrypt(auth()->id()) }}">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="offer_logo" class="d-block">Upload File</label>
                                    <input type="file" name="offer_logo" id="offer_logo" accept="image/*">
                                    <span class="d-block my-2 text-danger ">Image Size should be 1100px X 300 px</span>
                                    @if ($record->count() != 0 )
                                        <input type="hidden" name="existing" value="{{ $record[0]->path }}">
                                    @endif
                                </div>    
                            </div>
                            
                            @if ($record->count() != 0 )
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="d-block">Preview</label>
                                        <img src="{{ asset($record[0]->path) }}" alt="Image Preview"  style="height: 100%;width: 100%;">
                                    </div>    
                                </div>
                            @endif
                                
    
                            <div class="col-12">
                                <div class="d-flex justify-content-center align-content-center">
                                    <button type="submit" class="btn btn-outline-primary my-2">Submit</button>
                                </div>
                            </div>

                            
                        </div>
                        
                        
                    </form>
                </div>
            </div>

        </div>
    

    </div>
</div>
