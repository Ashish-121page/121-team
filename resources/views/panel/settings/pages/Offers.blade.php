@php
    $record = App\Models\Media::where('type_id',auth()->id())->where('type','OfferBanner')->get();
@endphp

<div class="card-body">
    @include('frontend.customer.dashboard.section.currency-load')
</div>