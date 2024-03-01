@forelse ($vault_data as $item)
<div  class="cardbx col-sm-6 col-lg-3 col-md-4 ywqgqdya product-card product-box d-flex flex-column border bg-white"
    style="width: 25rem;max-width: 25rem; min-height: 13.5rem;max-height: 15rem;">
    <div class="head d-flex justify-content-between my-2" style="font-size: 1rem !important;">
        <div class="one col-10">
            <span>


            </span>
            <div style="font-weight: bold; font-size: large !important;"> {{ $item }} </div>
            @php
                $count = App\Models\Media::where('vault_name', $item)->count();
                $first_three = App\Models\Media::where('vault_name', $item)->take(3)->get();
            @endphp
            <small class="text-muted" style="font-size: medium;">{{ $count }} Assets</small>
        </div>
        <div class="two col-2 d-flex flex-column justify-content-start align-items-start">
            <a href="#" class="btn shadow-none  text-primary btn-sm editshowvault"
                data-vault_rec="{{ $item }}" >
                <i class="fas fa-caret-right"></i>
            </a>
        </div>
    </div>

    <div class="cardbody d-flex justify-content-around  w-100" style="padding: 1rem 0;">
        @forelse ($first_three as $item)
            <div class="col-4 d-flex" style="height: 5em; width: 5em; object-fit: contain; padding: 0;">
                <img src="{{ asset($item->path ?? 'frontend/assets/newuiimages/vault/19.png') }}"
                    class="img-fluid p-1"
                    style="border-radius: 10px; height: 100%; width: 100%; aspect-ratio: 1/1;object-fit: contain">
            </div>
        @empty
            <div class="col-12 d-flex" style="height: 5em; width: 5em; object-fit: contain; padding: 0;">
                Nothing Found
            </div>
        @endforelse
    </div>
</div>
@empty
<div class="cardbx col-sm-6 col-lg-3 col-md-4 ywqgqdya product-card product-box d-flex flex-column border bg-white"
    style="width: 25rem;max-width: 25rem; min-height: 13.5rem;max-height: 15rem;">
    Nothing Found
</div>
@endforelse
