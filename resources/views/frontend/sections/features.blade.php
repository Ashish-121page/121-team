<section class="bg-half-170 w-100 strip-bg-img magic mt-3">
    <div class="container mt-3"  style="">
        <div class="row justify-content-center mx-auto m-1">
            @if (isset($contact_info) && @$contact_info->phone)
                <div class="col-md-2 col-4">
                    <div class="card border-0 text-center features feature-clean">
                        <a href="tel:{{ $contact_info->phone ?? '#' }}">
                        <div class="icons text-primary text-center mx-auto">
                            <i class="uil uil-phone d-block rounded h3 mb-0 mx-auto"></i>
                        </div>
                        <div class="content mt-2">
                            <p class="text-primary">Phone</p>
                        </div>
                        </a>
                    </div>
                </div><!--end col-->
            @endif
            
            @if (isset($contact_info) && @$contact_info->email)
                <div class="col-md-2 col-4">
                    <div class="card border-0 text-center features feature-clean">
                        <a href="mailto:{{ $contact_info->email ?? '#' }}">
                        <div class="icons text-primary text-center mx-auto">
                            <i class="uil uil-envelope d-block rounded h3 mb-0 mx-auto"></i>
                        </div>
                        <div class="content mt-2">
                            <p class="text-primary">Email</p>
                        </div>
                        </a>
                    </div>
                </div><!--end col-->
            @endif
            
            @if (isset($address) && @$address != null)
            @php
                $addresses =  (array)$address;
                $fullAddress = '';
                foreach($addresses as $address){
                    $fullAddress .= $address.',';
                }
            @endphp
                
                <div class="col-md-2 col-4">
                    <div class="card border-0 text-center features feature-clean">
                        <a href="https://www.google.co.in/maps/search/{{ $fullAddress ?? '#' }}" target="_blank">
                        <div class="icons text-primary text-center mx-auto">
                            <i class="uil uil-map-marker d-block rounded h3 mb-0 mx-auto"></i>
                        </div>
                        <div class="content mt-2">
                            <p class="text-primary">Location</p>
                        </div>
                        </a>
                    </div>
                </div><!--end col-->
            @endif
            
            @if (isset($contact_info) && @$contact_info->whatsapp)
                <div class="col-md-2 col-4">
                    <div class="card border-0 text-center features feature-clean">
                        <a href="https://api.whatsapp.com/send?phone={{$contact_info->whatsapp ?? '' }}&text=Hello" target="_blank">
                            <div class="icons text-primary text-center mx-auto">
                                <i class="uil uil-whatsapp d-block rounded h3 mb-0 mx-auto"></i>
                            </div>
                            <div class="content mt-2">
                                <p class="text-primary">WhatsApp</p>
                            </div>
                        </a>
                    </div>
                </div><!--end col-->
            @endif

            {{-- @if (isset($user_shop_social) && @$user_shop_social->insta_link)
                <div class="col-md-2 col-4">
                    <div class="card border-0 text-center features feature-clean">
                        <a href="{{ $user_shop_social->insta_link }}" target="_blank">
                            <div class="icons text-primary text-center mx-auto">
                                <i class="uil uil-instagram d-block rounded h3 mb-0 mx-auto"></i>
                            </div>
                            <div class="content mt-2">
                                <p class="text-primary">Instagram</p>
                            </div>
                        </a>
                    </div>
                </div><!--end col-->
            @endif --}}
        </div><!--end row-->
    </div>
</section>