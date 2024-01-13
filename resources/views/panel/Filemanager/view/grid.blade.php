<div class="col-md-12 col-12">

    <div class="row">
        @forelse ($paginator as $file)
            <div class="col-md-3 col-6" style="">
                <div class="card">
                    <div class="card-body d-flex align-items-center  justify-content-center flex-column text-center">
                        <div class="bx d-flex" style="position: absolute;bottom: 20px;right: 20px">
                            {{-- <button type="button" class="btn-link mx-2 editImagebtn" style="border: none" data-bs-toggle="modal" data-bs-target="#editImage" data-image_path="{{ asset(Storage::url($file)) }}" data-old_path="{{$file}}">
                                Edit
                            </button> --}}

                            <a href="{{ route('panel.image.studio',encrypt($file)) }}" class="bnt-link mx-2 ">
                                Edit
                            </a>

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
                                <span class="filename" data-oldname="{{ basename($file) }}" style="word-break: break-all;">
                                    @if (strlen(basename($file)) > 20)
                                        {{ substr(basename($file), 0, 4) }}<br>{{ substr(basename($file), 4, 11) }}...{{ substr(basename($file), -4) }}
                                    @else
                                        {{ basename($file) }}
                                    @endif
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

