@php
    $vcard = App\Models\Media::whereType('UserVcard')->whereTypeId($user_shop->user_id)->first();
@endphp
<section class="section pb-2" id="about" style="margin-bottom: 30px;">
    <div class="container">
        <div class="row align-items-center mb-5" id="counter">
            <div class="col-md-6">
                <div class="@if (isset($story) && @$story['video_link'] != null) img @endif">
                    @if (isset($story) && @$story['img'] != null)
                        <img src="{{ asset($story['img']) }}" class="rounded img-fluid mx-auto d-block" alt="">
                    @elseif($vcard != null)
                        <img src="{{ asset($vcard->path) }}" class="rounded img-fluid mx-auto d-block" alt="">
                    @else 
                        <img src="{{ asset('frontend/assets/img/placeholder.png') }}" class="rounded img-fluid mx-auto d-block" alt="">
                    @endif
                </div>
            </div><!--end col-->

            <div class="col-md-6 mt-4 pt-2 mt-sm-0 pt-sm-0">
                <div class="ms-lg-4">
                    {{-- <div class="d-flex mb-2">
                        <span class="text-primary h1 mb-0">story
                    </div> --}}
                    <div class="section-title">
                        <h4 class="title">{{ $story['title'] ?? 'User Shop' }}</h4>
                        @if (isset($story['description']))
                            <p class="text-muted" style="word-break: break-all;">{!!  Str::limit( $story['description'] , 300 ) ?? 'Not Added' !!}</p>
                        @endif
                        
                        @if (auth()->user())
                            @if ($story['cta_link'] ?? "" != "")
                                <a class="btn btn-outline-primary my-3" href="{{$story['cta_link'] ?? "#"}}" download>{{ $story['cta_label'] ?? 'Catalogue' }}</a>
                            @endif
                            
                            @if ($story['prl_link'] ?? ""  != "")
                            <a class="btn btn-outline-danger my-3" href="{{$story['prl_link'] ?? "#"}}" download>{{ $story['prl_label'] ?? '' }}</a>
                            @endif                        
                        @endif
                    </div>
                    
                </div>
            </div><!--end col-->
        </div><!--end row-->

        <div class="row">
            <div class="col-12">
                @if (json_decode($user_shop->team)->team_visiblity ?? 0)
                    <!-- Team Start -->
                    <section class="section " id="team">
                        <div class="container">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <div class="section-title pb-2">
                                        <h4 class="title mb-4">{{ $team['title'] ?? 'Our Team'}}</h4>
                                        <p class="text-muted para-desc mx-auto mb-0">{{ $team['description'] ?? ' '}}</p>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->

                            <div class="row">
                                @foreach (App\Models\Team::whereUserShopId($user_shop->id)->get()->take(4) as $item)
                                    <div class="col-lg-3 col-md-6 mt-4 pt-2">
                                        <div class="card text-center border-0">
                                            <div class="card-body p-0">
                                                <div class="position-relative">
                                                @if ($item->image != null)
                                                    <img src="{{ asset($item->image) }}" class="img-fluid avatar avatar-ex-large rounded-circle" alt="">
                                                @else
                                                    <img src="{{ asset('frontend/assets/img/user.jpg') }}" class="img-fluid avatar avatar-ex-large rounded-circle" alt="">
                                                @endif
                                                    
                                                </div>
                                                <div class="content pt-3 pb-3">
                                                    <h5 class="mb-0"><a href="javascript:void(0)" class="name text-dark">{{ $item->name ?? '' }}</a></h5>
                                                    <small class="designation text-muted d-block">{{ $item->designation ?? '' }}</small>
                                                    {{-- <small class="designation text-muted">{{ $item->contact_number ?? '' }}</small> --}}
                                                    <small class="designation text-muted"><a href="tel:{{ $item->contact_number ?? '' }}">{{ $item->contact_number ?? '' }}</a></small>
                                                </div>                                
                                            </div>
                                        </div>
                                    </div><!--end col-->
                                @endforeach
                            </div><!--end row-->
                        </div><!--end container-->
                    </section>
                @endif
            </div>
        </div>
    </div><!--end container-->
</section>


{{-- {{ magicstring(session()->all()) }} --}}