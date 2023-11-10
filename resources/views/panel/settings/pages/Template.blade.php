<div class="col-12">
    {{-- {{ asset('frontend/assets/img/default_ppt.svg') }} --}}
    <div class="row">
        <div class="col-12 my-3 text-center">
            <div class="h4">Powerpoint Templates</div>
        </div>
        
        @foreach ($templates as $template)
            @if ($template->user_id != null && $template->user_id != auth()->id() )
                @continue
            @endif
            
            <div class="col-md-3 col-sm-4 col-6 d-flex justify-content-center flex-column card">
                <div class="head d-flex justify-content-between align-items-center w-100" style="height: 250px;width: 250px;object-fit: contain;">
                    <img src="{{ asset($template->thumbnail ?? '') }}" alt="test" class="img-fluid rounded"
                        style="height: 100%;width: 100%;">
                </div>
                
                <div class="body d-flex justify-content-between align-items-center m-2">
                    <div class="one">
                        <div class="name my-2" style="text-transform: uppercase"> {{ $template->name_key }} </div>
                        <div class="lastupdated">{{ $template->updated_at }}</div>
                    </div>
                    <div class="two">
                        <div class="action">

                            
                            @if(auth()->user() && session()->has("admin_user_id") && session()->has("temp_user_id"))
                                <a href="{{ route('panel.settings.edit.Template',$template->id) }}">Edit as a Admin</a>
                            @elseif ($template->user_id == auth()->id())
                                <a href="#edit" class="btn-link">Edit</a>
                            @endif

                            @if ($template->user_id == auth()->id())
                                <a href="{{ route('panel.settings.make.default.Template',[auth()->id(),$template->id]) }}" class="btn-link @if ($template->default == 1) text-dark @endif  mx-1">Default</a>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <div class="row">
        <div class="col-12 my-3 text-center">
            <div class="h4">PDF Templates</div>
        </div>
        
        @php
            $record = App\Models\Media::where('type_id',auth()->id())->where('type','OfferBanner')->get();
        @endphp
        <div class="col-12">
            <form action="{{ route('panel.settings.upload.banner') }}" enctype="multipart/form-data" method="POST">
                
                @csrf
                <input type="hidden" name="user_id" value="{{ encrypt(auth()->id()) }}">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="offer_logo" class="d-block">Upload File</label>
                            <input type="file" name="offer_logo" id="offer_logo" accept="image/*">
                            <span class="d-block my-2 text-danger ">Image Size should be 2100px X 300 px</span>
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
                            <button type="submit" class="btn btn-outline-primary my-2">Save</button>
                        </div>
                    </div>

                    
                </div>
                
                
            </form>
        </div>
    </div>
</div>
