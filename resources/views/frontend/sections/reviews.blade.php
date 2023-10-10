<div class="container" style="margin-bottom: 70px;" id="testimonial">
    <div class="row pt-md-5 justify-content-center">
        <div class="col-12">
            <div class="section-title text-center mb-4 pb-2">
                <h4 class="title mb-4">{{ $testimonial['title'] ?? '' }}</h4>
                <p class="text-muted para-desc mx-auto mb-0">{{ $testimonial['description'] ?? '' }}</p>
            </div>
        </div><!--end col-->
    </div><!--end row-->

    <div class="row justify-content-center mx-auto">
        <div class="col-lg-12 mt-4">
            <div class="tns-outer" id="tns1-ow"><div class="tns-liveregion tns-visually-hidden" aria-live="polite" aria-atomic="true">slide <span class="current">2 to 4</span>  of 6</div><div id="tns1-mw" class="tns-ovh"><div class="tns-inner" id="tns1-iw"><div class="tiny-three-item  tns-slider tns-carousel tns-subpixel tns-calc tns-horizontal" id="tns1" style="transform: translate3d(-16.6667%, 0px, 0px);">
                @foreach (App\Models\UserShopTestimonal::whereUserShopId($user_shop->id)->get() as $item)
                <div class="tiny-slide tns-item" id="tns1-item0" aria-hidden="true" tabindex="-1">
                    <div class="d-flex client-testi m-2">
                            @if ($item->image != null)
                                <img src="{{ asset($item->image) }}" class="avatar avatar-small client-image rounded shadow" alt="">
                            @else
                                <img src="{{ asset('frontend/assets/img/user.jpg') }}" class="avatar avatar-small client-image rounded shadow" alt="">
                            @endif
                            <div class="flex-1 content p-3 shadow rounded bg-white position-relative">
                                <ul class="list-unstyled mb-0">
                                    @for ($i = 0; $i < $item->rating; $i++)
                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                    @endfor
                                </ul>
                                <p class="text-muted mt-2">{{ $item->tesimonal }}</p>
                                <h6 class="text-primary">
                                    {{ $item->name}}
                                    <small class="text-muted">{{ Str::limit($item->designation,30)}}</small>
                                </h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div></div></div></div>
        </div><!--end col-->
    </div><!--end row-->
</div>