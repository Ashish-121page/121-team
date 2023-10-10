
@php
    $media = App\Models\Media::whereType('UserVcard')->whereTypeId($user_shop->user_id)->first();
@endphp
<div class="container" style="margin-top:30px;margin-bottom:20px;">
    <div class="row justify-content-center">
        @if ($media != null)
            <div class="col-xl-2 col-lg-3 col-md-3 col-6 text-center">
                <a type="button" download href="{{ asset($media->path) }}" style="width:100%;padding:11px 12px!important;" class="btn btn-soft-primary mob-p"><i class="mdi mdi-cloud-download"></i> Save my Card</a>
            </div>
        @endif
        <div class="col-xl-2 col-lg-3 col-md-3 col-6 text-center">
            <button type="button" id="clipboard"   style="width:100%;padding:11px 12px!important;" class="btn btn-soft-primary"><i class="mdi mdi-share"></i> Share</button>
            <div class="d-flex  gap-3 align-items-center flex-wrap" style="width: max-content; margin: 0 0 0 -120px">
                @if ($story['cta_link'] ?? "" != "")
                    <a class="btn btn-outline-primary my-3" href="{{$story['cta_link'] ?? "#"}}" download>{{ $story['cta_label'] ?? 'Catalogue' }}</a>
                @endif
                
                @if ($story['prl_link'] ?? ""  != "")
                    <a class="btn btn-outline-primary my-3" href="{{$story['prl_link'] ?? "#"}}" download>{{ $story['prl_label'] ?? '' }}</a>
                @endif
            </div>
        </div>

    </div>
    <div class="row mt-5 justify-content-center mx-auto m-2">
        @if(isset($user_shop_social->fb_link) && $user_shop_social->fb_link != null) 
        <div class="col-2">
            <a target="_blank" @if(isset($user_shop_social->fb_link)) href="{{ $user_shop_social->fb_link }}"  @else href="#" disabled @endif id="fblinkholder"  @if(isset($user_shop_social->fb_link))  @endif class="btn btn-icon btn-pills btn-lg btn-blue home-scl-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Facebook" aria-label="Facebook" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook icons"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
        </div>
        @endif

        @if(isset($user_shop_social->in_link) && $user_shop_social->in_link != null) 
        <div class="col-2">
            <a target="_blank" @if(isset($user_shop_social->in_link)) href="{{ $user_shop_social->in_link }}" @else href="#" disabled @endif id="lnlinkholder"  class="btn btn-icon btn-pills btn-lg btn-secondary home-scl-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Linkedin" aria-label="Linkedin"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-linkedin icons"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg></a>
        </div>
        @endif

        @if(isset($user_shop_social->tw_link) && $user_shop_social->tw_link != null) 
        <div class="col-2">
            <a target="_blank" @if(isset($user_shop_social->tw_link)) href="{{ $user_shop_social->tw_link }}" @else href="#" disabled @endif id="twlinkholder" class="btn btn-icon btn-pills btn-lg btn-info home-scl-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Twitter" aria-label="Twitter"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter icons"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg></a>
        </div>
        
        @endif

        @if(isset($user_shop_social->yt_link) && $user_shop_social->yt_link != null) 
            <div class="col-2">
                <a target="_blank" @if(isset($user_shop_social->yt_link)) href="{{ $user_shop_social->yt_link }}" @else href="#" disabled @endif class="btn btn-icon btn-pills btn-lg btn-danger home-scl-btn " data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Youtube" aria-label="Youtube"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="30" height="30" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><g fill="none"><g clip-path="url(#svgIDa)"><path fill="currentColor" d="M23.5 6.507a2.786 2.786 0 0 0-.766-1.27a3.05 3.05 0 0 0-1.338-.742C19.518 4 11.994 4 11.994 4a76.624 76.624 0 0 0-9.39.47a3.16 3.16 0 0 0-1.338.76c-.37.356-.638.795-.778 1.276A29.09 29.09 0 0 0 0 12c-.012 1.841.151 3.68.488 5.494c.137.479.404.916.775 1.269c.371.353.833.608 1.341.743c1.903.494 9.39.494 9.39.494a76.8 76.8 0 0 0 9.402-.47a3.05 3.05 0 0 0 1.338-.742a2.78 2.78 0 0 0 .765-1.27A28.38 28.38 0 0 0 24 12.023a26.579 26.579 0 0 0-.5-5.517ZM9.602 15.424V8.577l6.26 3.424l-6.26 3.423Z"/></g><defs><clipPath id="svgIDa"><path fill="#fff" d="M0 0h24v24H0z"/></clipPath></defs></g></svg></a>
            </div>
        @endif
        @if(isset($user_shop_social->insta_link) && $user_shop_social->insta_link != null) 
            <div class="col-2">
                <a target="_blank" @if(isset($user_shop_social->insta_link)) href="{{ $user_shop_social->insta_link }}" @else href="#" disabled @endif class="btn btn-icon btn-pills btn-lg home-scl-btn p-0" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="instagram" aria-label="instagram"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" data-name="Layer 1" viewBox="0 0 128 128"><defs><radialGradient id="a" cx="27.5" cy="121.5" r="148.5" gradientUnits="userSpaceOnUse"><stop offset="0" stop-color="#ffd676"/><stop offset=".25" stop-color="#f2a454"/><stop offset=".38" stop-color="#f05c3c"/><stop offset=".7" stop-color="#c22f86"/><stop offset=".96" stop-color="#6666ad"/><stop offset=".99" stop-color="#5c6cb2"/></radialGradient><radialGradient id="d" cx="13.87" cy="303.38" r="185.63" xlink:href="#a"/><clipPath id="b"><rect width="128" height="128" fill="none" rx="24" ry="24"/></clipPath><clipPath id="c"><circle cx="82" cy="209" r="5" fill="none"/></clipPath></defs><g clip-path="url(#b)"><circle cx="27.5" cy="121.5" r="148.5" fill="url(#a)"/></g><g clip-path="url(#c)"><circle cx="13.87" cy="303.38" r="185.63" fill="url(#d)"/></g><circle cx="82" cy="46" r="5" fill="#fff"/><path fill="#fff" d="M64 48a16 16 0 1 0 16 16 16 16 0 0 0-16-16Zm0 24a8 8 0 1 1 8-8 8 8 0 0 1-8 8Z"/><rect width="64" height="64" x="32" y="32" fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="8" rx="12" ry="12"/></svg></a>
            </div>
        @endif

        @if(isset($user_shop_social->pint_link) && $user_shop_social->pint_link != null) 
        <div class="col-2">
            <a target="_blank" @if(isset($user_shop_social->pint_link)) href="{{ $user_shop_social->pint_link }}" @else href="#" disabled @endif class="btn btn-icon btn-pills btn-lg home-scl-btn p-0" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="pinterest" aria-label="pinterest"><svg height="800px" width="800px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 291.319 291.319" xml:space="preserve"><g><path style="fill:#C8232C;" d="M145.659,0c80.45,0,145.66,65.219,145.66,145.66c0,80.45-65.21,145.659-145.66,145.659S0,226.109,0,145.66C0,65.219,65.21,0,145.659,0z"/><path style="fill:#FFFFFF;" d="M150.066,63.781c-51.327,0-77.19,35.632-77.19,65.337c0,17.989,7.028,33.993,22.122,39.956 c2.467,0.974,4.698,0.036,5.408-2.613l2.203-8.403c0.728-2.613,0.446-3.541-1.548-5.826c-4.361-4.962-7.128-11.398-7.128-20.511 c0-26.428,20.42-50.089,53.175-50.089c29.014,0,44.945,17.161,44.945,40.075c0,30.152-13.783,55.606-34.248,55.606 c-11.289,0-19.755-9.04-17.042-20.156c3.241-13.237,9.541-27.539,9.541-37.107c0-8.548-4.743-15.704-14.575-15.704 c-11.553,0-20.829,11.571-20.829,27.074c0,9.878,3.45,16.551,3.45,16.551l-13.901,56.998c-4.124,16.906-0.61,37.644-0.319,39.738 c0.182,1.238,1.821,1.529,2.567,0.601c1.065-1.347,14.821-17.798,19.5-34.239c1.329-4.652,7.602-28.75,7.602-28.75 c3.751,6.946,14.721,13.046,26.383,13.046c34.712,0,58.273-30.652,58.273-71.674C218.444,92.676,191.315,63.781,150.066,63.781z"/></g></svg></a>
        </div>
    @endif
    
    </div>
</div>

@include('frontend.micro-site.shop.include.social-share')