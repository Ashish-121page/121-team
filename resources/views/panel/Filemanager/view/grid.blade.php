<div class="col-md-12 col-12">

    <div class="row">
        @forelse ($paginator as $file)
            <div class="col-md-3 col-6">
                <div class="card">
                    <div class="card-body d-flex align-items-center  justify-content-center flex-column text-center">
                        <div class="bx" style="position: absolute;bottom: 20px;right: 20px">
                            <input type="checkbox" name="checkthis" id="checkthis" class="form-check checkme" value="{{ encrypt($file) }}">
                        </div>
                        <div class="" style="height: 200px; width: 250px">

                            @if (explode("/",Storage::mimetype($file))[0] == 'image')
                                <img src="{{ asset(Storage::url($file)) }}" alt="" style="object-fit:contain;height:100%;width:100%">
                            @else
                                <img src="https://placehold.co/250x150?text={{ explode("/",Storage::mimetype($file))[0] }}" alt="{{ explode("/",Storage::mimetype($file))[0] }}" style="object-fit:contain;height:100%;width:100%">
                            @endif
                            
                        </div>
                        <div class="mt-2">
                            <div class="h6">
                                <span class="filename" data-oldname="{{ basename($file) }}">
                                    {{ basename($file) }}
                                </span>
                            </div>
                            <small>
                                {{ number_format(Storage::size($file)/ (1024 * 1024),2) }} MB
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            
            
        @endforelse
    </div>


    
    
</div>

