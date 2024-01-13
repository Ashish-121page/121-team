@php
    $record = App\Models\Media::where('type_id', auth()->id())
        ->where('type', 'OfferBanner')
        ->get();
@endphp

<div class="col-12">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

        <li class="nav-item" role="presentation">
            <button class="btn btn-outline-primary mx-2 my-3 active" id="pills-home-tab" data-bs-toggle="pill"
                data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                aria-selected="true">Others</button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="btn btn-outline-primary mx-2 my-3" id="pills-profile-tab" data-bs-toggle="pill"
                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                aria-selected="false">Variants</button>
        </li>


    </ul>



    <div class="tab-content" id="pills-tabContent">


        <div class="tab-pane fade text-dark" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
        tabindex="0" style="background-color: transparent !important;">
            <div class="row">
                @include('panel.user_shop_items.includes.Properties')
            </div>
        </div>


        <div class="tab-pane fade text-dark show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
            tabindex="0" style="background-color: transparent !important;">
            <div class="row">
                @include('panel.settings.pages.CustomField-others')
            </div>
        </div>



    </div>

</div>
