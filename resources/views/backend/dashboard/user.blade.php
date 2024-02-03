<div class="row">
    @php
        $user = auth()->user();
        $user_shop =  App\Models\UserShop::whereUserId(auth()->id())->first();
        $team_rec = App\Models\Team::whereUserShopId($user_shop->id)->exists();
        $testimonial_rec = App\Models\UserShopTestimonal::whereUserShopId($user_shop->id)->exists();
        $user_package = App\Models\UserPackage::whereUserId(auth()->id())->first();
        $access_cat_req = App\Models\AccessCatalogueRequest::whereUserId($user->id)->whereStatus(1)->exists();
        $contact_info = json_decode($user_shop->contact_info);
        if(isset($user_shop->payment_deatils) && $user_shop->payment_deatils != null  && $user_shop->payment_deatils != 'null'){
        $payment_deatils = json_decode($user_shop->payment_deatils,true);
        }
    @endphp
    @if(isset($user_shop))
        {{-- <div class="col-xl-4 col-lg-4 col-md-12 col-12">
                <div class="card">
                    @if($user_shop->slug == auth()->user()->phone)
                        <div class="card-header d-flex justify-content-between">
                            <h6 class="mb-0">
                                Choose Your Page Name
                            </h6>
                            <i class="ik ik-info fa-2x text-info" title="Please note that the change in your site name affects your QR code, avoid changing the site name after sharing the QR code with your distributors"></i>
                        </div>
                    @endif
                    @if ($user_package)
                        @if(\Carbon\Carbon::parse($user_package->to)->format('Y-m-d') >= now()->format('Y-m-d'))
                            <div class="card-body">
                                <div class="row">
                                    @if($user_shop->slug == auth()->user()->phone)
                                        <div class="col-md-12">
                                            <div class="form-group mb-0">
                                                <form action="{{ route('panel.seller.update.site-name',$user_shop->id) }}" method="post">
                                                    @csrf
                                                    <span id="lblError" class="text-danger"></span>
                                                    <div class="d-flex justify-content-between">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"  name="shop_name" placeholder="Sitename" id="txtName" value="{{ $user_shop->slug }}">
                                                            <span class="input-group-append">
                                                                <label class="input-group-text">
                                                                    .121.page
                                                                </label>
                                                            </span>
                                                        </div>
                                                        <button class="btn btn-sm btn-outline-danger m-1 px-2 py-1">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                        @if($user_shop->slug == auth()->user()->phone)
                                            <div class="col-md-12"> <hr></div>
                                        @endif
                                    <div class="col-12 dashboard-card p-2"  id="html-content-holder">
                                        <div class="text-center mx-auto">
                                            <div>
                                                <img src="{{ getBackendLogo(getSetting('app_white_logo'))}}" alt="website Logo" style="height: 40px;" class="my-1">
                                                <hr>
                                                <h5 class="mt-2">
                                                    <strong>
                                                      {{ $user_shop->slug }}.121.Page
                                                    </strong>
                                                </h5>
                                                <span>Scan to get latest offers</span>
                                                    <div class="p-2">
                                                        {!! QrCode::size(200)->generate(route('microsite.proxy')."?page=home&is_scan=1&shop=$user_shop->slug") !!}
                                                    </div>
                                                    <div id="previewImg" class="d-none">
                                                    </div>
                                                    <br>
                                                <h6 class="mt-2">
                                                    <i class="ik ik-phone"></i> {{ $contact_info->phone ?? '' }}</h6>
                                                <h6 class="mt-2">
                                                    <i class="fa fa-envelope"></i>
                                                    {{ $contact_info->email ?? '' }}</h6>

                                                    <hr>

                                                    <label for="" class="text-center text-muted">
                                                    Powered by 121.page
                                                    </label>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="d-flex justify-content-center">
                                   <div>
                                        <a href="javascript:void(0)" id="download-qr" class="btn btn-outline-primary mt-2">Download QR</a>
                                   </div>
                                   <div>
                                        <a href="javascript:void(0);" onclick="copyTextToClipboard('{{ inject_subdomain('home', $user_shop->slug)}}')" class=" copy-link-btn btn btn-outline-light mt-2 text-dark">Copy Link</a>
                                        <a href="javascript:void(0);" onclick="exportpdf()" class="copy-link-btn btn btn-outline-light mt-2 text-dark">Export PDF</a>
                                        <br>
                                    </div>
                                </div>
                                <span class="text-center mx-4 d-flex align-items-center" style="padding-top: 10px !important">
                                    <span class="ik ik-info fa-1x text-danger m-1"></span>
                                    Use Desktop For Better Export Print
                                </span>
                            </div>
                        @else
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between alert alert-danger py-2 fade show" role="alert">
                                            <span>Your package has been expired, <br> Renew to enjoy using 121.</span>
                                            <a href="{{ route('plan.index') }}" class="btn btn-outline-danger" type="button">Renew Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between alert alert-danger py-2 fade show" role="alert">
                                        <span style="line-height: 30px;">Upgrade your account to unlock more customization options</span>
                                        <a href="{{ route('plan.index') }}" class="btn btn-outline-danger" type="button">Buy now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
        </div> --}}
        {{-- @if(getSellerProgressStatistics(auth()->id()) != 100 || $user_shop->slug == auth()->user()->phone) --}}
        @php
            // ` Current Progress
            $first =  true;
            // $first =  (auth()->user()->ekyc_status == 1) ? true : false;
            $second = ($first) ? ((count(App\Models\Category::where('user_id',auth()->id())->get()) != 0) ? true : false) : false;
            $third =  ($second) ? ((count(App\Models\Product::where('user_id',auth()->id())->get()) != 0) ? true : false) : false;
            $forth =  ($third) ? ((count(App\Models\Proposal::where('user_id',auth()->id())->get()) != 0) ? true : false) : false;
            $fifth =  false;

        @endphp

            <div class="col-xl-12 col-lg-12 col-md-12 col-12 justify-content-center  @if($first && $second && $third && $forth) d-none @endif">
                <div class="progressmeter">
                    <div class="h4">Progress</div>
                    <div class="row">
                        {{-- Step 1  --}}
                        <div class="col bg-white shadow m-1 d-none">
                            <a href="@if ($first) #complted @else {{ route('customer.dashboard') }}?active=account&subactive=business_profile&upload_gst=true @endif">

                                <div class="circle @if ($first) bg-success @else bg-primary @endif text-white">
                                    <span>
                                        @if ($first) <i class="fas fa-check-circle"></i> @else 1 @endif
                                    </span>
                                </div>
                                <div class="h6 my-2"><b>Upload GST / IEC</b></div>
                                <p>Kindly upload to activate your account</p>
                            </a>
                        </div>

                        {{-- Step 2 --}}
                        <div class="col bg-white shadow m-1"  @if (!$second) title="Complete step 1" @endif>
                            <a href="@if ($first && $second) #complted @elseif($first) {{ route('panel.user_shop_items.create') }}?type=direct&type_id={{ auth()->id() }} @else #pending @endif" @if(!$first) style="cursor: not-allowed !important" @endif>
                                <div class="circle text-white
                                @if ($first && $second) bg-success @elseif($first) bg-primary @else bg-secondary @endif
                                ">
                                    <span>
                                        @if ($first && $second) <i class="fas fa-check-circle"></i>  @else 1 @endif
                                    </span>
                                </div>
                                <div class="h6 my-2"><b>Add category</b></div>
                                <p>Create new category best suited for your products</p>
                            </a>
                        </div>

                        {{-- Step 3  --}}
                        <div class="col bg-white shadow m-1"  @if (!$third) title="Complete step 2" @endif>

                            <a href="@if ($first && $second && $third) #completed @elseif($first && $second ) {{ route('panel.user_shop_items.create') }}?type=direct&type_id={{ auth()->id() }}&productsgrid=true @else #pending @endif" @if(!$second) style="cursor: not-allowed !important" @endif>

                                <div class="circle @if ($first && $second && $third) bg-success @elseif($first && $second) bg-primary @else bg-secondary @endif text-white">

                                    <span>
                                        @if ($first && $second && $third) <i class="fas fa-check-circle"></i> @else 2 @endif
                                    </span>
                                </div>
                                <div class="h6 my-2"><b>Add Product</b></div>
                                <p>Create new product with minimum of image and model code</p>
                            </a>
                        </div>

                        {{-- Step 4  --}}
                        <div class="col bg-white shadow m-1"  @if (!$forth) title="Complete step 3" @endif>
                            <a href="@if ($first && $second && $third && $forth) #completed @elseif($first && $second && $third) {{ route('panel.proposals.index')."?type=direct&type_ide=".encrypt(auth()->id()) }} @else #pending @endif " @if(!$third) style="cursor: not-allowed !important" @endif>
                                <div class="circle @if ($first && $second && $third && $forth) bg-success @elseif($first && $second && $third) bg-primary @else bg-secondary @endif text-white">
                                    <span>
                                        @if ($first && $second && $third && $forth) <i class="fas fa-check-circle"></i> @else 3 @endif
                                    </span>
                                </div>

                                <div class="h6 my-2"><b>Make Offer</b></div>

                                <p>Create fast offers for Buyers in any of ppt, pdf, excel formats</p>
                            </a>
                        </div>


                    </div>
                    <div class="bar"></div>
                </div>
            </div>

    @endif

        {{--  three new cols for Dashboard --}}
        @if ($third && $forth)
            <div class="col-xl-12 col-lg-12 col-md-12 col-12 justify-content-center mt-3">
                <div class="progressmeter">
                    <div class="h5">
                        Dashboard
                    </div>
                    <div class="row">
                        {{-- All Products  --}}
                        <div class="col bg-white shadow m-1">
                            <a href="{{ route('panel.user_shop_items.create') }}?type=direct&type_id={{ auth()->id() }}&productsgrid=true" style="cursor: pointer !important">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="circle bg-none">
                                        {{-- <div class="circle   bg-primary text-white "> --}}
                                        <span>
                                            <svg width="72" height="72" viewBox="0 0 2048 2048" xmlns="http://www.w3.org/2000/svg">
                                                <path fill="#666ccc" d="m1344 2l704 352v785l-128-64V497l-512 256v258l-128 64V753L768 497v227l-128-64V354zm0 640l177-89l-463-265l-211 106zm315-157l182-91l-497-249l-149 75zm-507 654l-128 64v-1l-384 192v455l384-193v144l-448 224L0 1735v-676l576-288l576 288zm-640 710v-455l-384-192v454zm64-566l369-184l-369-185l-369 185zm576-1l448-224l448 224v527l-448 224l-448-224zm384 576v-305l-256-128v305zm384-128v-305l-256 128v305zm-320-288l241-121l-241-120l-241 120z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="ml-3 mt-4 mb-3">
                                        <div class="h6 my-2"><b>All Products</b></div>
                                        <p>Add, Edit or Delete products</p>                                    
                                    </div>
                                </div>
                            </a>
                        </div>

                        {{-- Offers --}}
                        <div class="col bg-white shadow m-1">
                            <a href="{{ route('panel.proposals.index') . '?type=direct&type_ide=' . encrypt(auth()->id()) }}" style="cursor: pointer !important">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="circle text-white bg-none mr-3">
                                        <span>
                                            <svg width="72" height="72" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                                <path fill="none" stroke="#666ccc" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="m7.369 28.832l30.755-5.516l5.376-9.143l-8.245-5.958L4.5 13.73z"/>
                                                <path fill="none" stroke="#666ccc" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" d="m10.494 28.272l7.997 11.513l23.522-15.73l1.487-9.882"/>
                                                <circle cx="39.339" cy="14.912" r=".75" fill="currentColor"/>
                                            </svg>
                                        </span>
                                        
                                    </div>                                    
                                        <div class="ml-3 mt-4 mb-3">
                                            <div class="h6 my-2 text-start"><b>Create Offer for a Buyer</b></div>
                                            <p class="text-right">Select products and create Offers</p>
                                        </div>
                                </div>
                            </a>
                        </div>

                        {{--` documentation  --}}
                        <div class="col bg-white shadow m-1">
                            <a href="{{ route('panel.Documents.Quotation') }}" style="cursor: pointer !important">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="circle bg-none text-white mr-3">
                                        <span>
                                            <svg width="72" height="72" viewBox="0 0 2048 2048" xmlns="http://www.w3.org/2000/svg">
                                                <path fill="#666ccc" d="M1920 512v1408H768v-256H512v-256H256V0h731l256 256h421v256zm-896-128h165l-165-165zm256 896V512H896V128H384v1152zm256 256V384h-128v1024H640v128zm257-896h-129v1024H896v128h897z"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="ml-3 mt-4 mb-3">
                                        <div class="h6 my-2"><b>Documentation</b></div>
                                        <p>Create and maintain Quotation, PI and others</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{--  end of three new cols for Dashboard --}}


    <!-- project-ticket end -->


    <div class="expdf d-none" id="expdf">
        <div style="display: flex;flex-wrap: wrap;">
            <img src="" alt="test" id="qr" style="max-width: 20rem;margin:5px; height: 25%;">
            <img src="" alt="test" id="qr2" style="max-width: 20rem;margin:5px; height: 25%;">
            <img src="" alt="test" id="qr3" style="max-width: 20rem;margin:5px; height: 25%;">
            <img src="" alt="test" id="qr4" style="max-width: 20rem;margin:5px; height: 25%;">
        </div>
    </div>

</div>

@push('script')
<script src="{{ asset('backend/js/html2canvas.js') }}"></script>
    <script>

         $(function () {
                    $("#txtName").keypress(function (e) {
                        var keyCode = e.keyCode || e.which;

                        $("#lblError").html("");

                        //Regex for Valid Characters i.e. Alphabets and Numbers.
                        var regex = /^[A-Za-z0-9]+$/;

                        //Validate TextBox value against the Regex.
                        var isValid = regex.test(String.fromCharCode(keyCode));
                        if (!isValid) {
                            $("#lblError").html("Only Alphabets and Numbers allowed.");
                        }

                        return isValid;
                    });
                });
            function copyTextToClipboard(text) {
                if (!navigator.clipboard) {
                    fallbackCopyTextToClipboard(text);
                    return;
                }
                navigator.clipboard.writeText(text).then(function() {
                }, function(err) {
                });
        }

            var element = $("#html-content-holder"); // global variable
            var getCanvas; // global variable

            $("#download-qr").on('click', function () {
                html2canvas(document.getElementById("html-content-holder")).then(function (canvas) {
                    var anchorTag = document.createElement("a");
                    document.body.appendChild(anchorTag);
                    document.getElementById("previewImg").appendChild(canvas);
                    var user_mob = "{{auth()->user()->phone}}";
                    anchorTag.download = "ShopQR_C_{{Illuminate\Support\Str::slug($user_shop->slug)  }}_"+user_mob+'.jpg';
                    anchorTag.href = canvas.toDataURL();
                    anchorTag.target = '_blank';
                    anchorTag.click();
                });
            });


            // create Image URL
            window.onload = function () {
                html2canvas(document.getElementById("html-content-holder")).then(function (canvas) {
                    document.getElementById("previewImg").appendChild(canvas);
                    var imgurl  = canvas.toDataURL();
                    document.getElementById('qr').src = imgurl
                    document.getElementById('qr2').src = imgurl
                    document.getElementById('qr3').src = imgurl
                    document.getElementById('qr4').src = imgurl

                });
            }
            // Export QR PDF
            function exportpdf() {
                var divContents = document.getElementById('expdf').innerHTML
                var a = window.open('Export QR', 'Export QR', 'height=600, width=1000');
                a.document.write('<html>');
                a.document.write("<body style='padding:20px'>");
                a.document.write(divContents);
                a.document.write('</body></html>');
                a.document.close();

                setTimeout(() => {
                    a.print()
                }, 200);
            }





    </script>
@endpush
