@php
    $record = App\Models\Media::where('type_id', auth()->id())
        ->where('type', 'OfferBanner')
        ->get();
@endphp
@push('head')
    <style>
        .error {
            color: red;
        }

        .cross-btn {
            position: absolute !important;
            left: 96px !important;
        }

        .screen-shot-image {
            width: 100%;
            height: 100%;
        }

        #industry_id+.select2 .selection {
            pointer-events: none;
        }

        .sticky {
            position: sticky;
            top: 70px;
        }

        .remove-ik-class {
            -webkit-box-shadow: unset !important;
            box-shadow: unset !important;
        }

        .active {
            background-color: transparent;
            color: black;
            border-radius: 5px;
        }

        .nav-link {
            background-color: transparent;
        }

        .nav-link.active {
            background-color: #6666cc !important;
            color: whitesmoke !important;
        }
    </style>
@endpush

<div class="col-12 my-3">

    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile"
                type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Others</button>

            <button class="nav-link " id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button"
                role="tab" aria-controls="nav-home" aria-selected="true">Variants </button>

            <button class="nav-link" id="nav-disabled-tab" data-bs-toggle="tab" data-bs-target="#nav-disabled"
                type="button" role="tab" aria-controls="nav-disabled" aria-selected="false">Category</button>

            <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact"
                type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Template</button>

            <button class="nav-link" id="nav-buyer-master-tab" data-bs-toggle="tab" data-bs-target="#nav-buyer-master"
                type="button" role="tab" aria-controls="nav-buyer-master" aria-selected="false">Buyer
                Master</button>

        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
            <div class="row my-3">
                @include('panel.user_shop_items.includes.Properties')
            </div>
        </div>

        <div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"
            tabindex="0">
            <div class="row my-3">
                @include('panel.settings.pages.CustomField-others')
            </div>
        </div>

        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">
            @include('panel.settings.pages.Template')
        </div>

        <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="0">
            <div class="row my-3">
                @include('backend.constant-management.category.view.user-view')
            </div>
        </div>

        <div class="tab-pane fade" id="nav-buyer-master" role="tabpanel" aria-labelledby="nav-buyer-master-tab"
            tabindex="0">
            @include('panel.settings.pages.buyer-master')
        </div>


    </div>


</div>
