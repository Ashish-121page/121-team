


<div class="row  "style= "overflow-x: wrap !important; flex-flow:wrap !important;">
    @forelse ($image_rec ?? [] as $image)
        {{-- <div class="col-lg-2 col-6 col-md-2 col-sm-3"> --}}
        <div class=" col-6 col-lg-2 col-md-3 col-sm-6 " >
            <div class="card" style="width: min-content;height: max-content;">
                <div class="card-body d-flex flex-column justify-content-start text-center "
                    style="width: min-content;">
                    <label class="custom-chk prdct-checked" data-select-all="boards">
                        <input type="checkbox" name="selected_file[]" class="input-check invisible buddy" value="{{ encrypt($image->path)}}" data-record="{{ encrypt($image->id)}}">
                        <span class="checkmark mr-5 mt-5" style="top: 0px !important; height: 25px !important; width: 25px !important;"></span>
                    </label>

                    <img src="{{ asset($image->path) }}" alt="Image Preview"
                        style="object-fit: contain;height: 100px;border-radius: 10px;width: 150px">

                    <span class="my-2" title="{{ $image->file_name }}">
                        {{ Str::limit($image->file_name, 15, '...') ?? '' }} </span>

                    <div class="d-flex justify-content-center align-items-center ">
                        <a href="{{ route('panel.image.studio', encrypt(str_replace('storage', '', $image->path))) }}"
                            target="_blank" class="btn btn-link text-primary ">Edit</a><!-- Button trigger modal -->

                        <button type="button" class="btn btn-link text-primary  openmod" data-recid="{{ encrypt($image->id) }}" data-currval="{{ $image->keywords ?? '' }}">
                            Add Keywords
                            @if ($image->keywords != null)
                                <i class="fas fa-check"></i>
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="d-flex justify-content-center">
            <h6>Nothing to Show Here..</h6>
        </div>
    @endforelse
    {{-- Product Card for Loop End --}}
</div>
