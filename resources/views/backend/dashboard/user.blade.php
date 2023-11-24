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
            $first =  (auth()->user()->ekyc_status == 1) ? true : false;
            $second = ($first) ? ((count(App\Models\Category::where('user_id',auth()->id())->get()) != 0) ? true : false) : false;
            $third =  ($second) ? ((count(App\Models\Product::where('user_id',auth()->id())->get()) != 0) ? true : false) : false;
            $forth =  ($third) ? ((count(App\Models\Proposal::where('user_id',auth()->id())->get()) != 0) ? true : false) : false;
            $fifth =  false;

        @endphp
        
            <div class="col-xl-12 col-lg-12 col-md-12 col-12 justify-content-center">
                <div class="progressmeter">
                    <div class="h4">Progress</div>
                    <div class="row">
                        {{-- Step 1  --}}
                        <div class="col bg-white shadow m-1">
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
                                        @if ($first && $second) <i class="fas fa-check-circle"></i>  @else 2 @endif
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
                                        @if ($first && $second && $third) <i class="fas fa-check-circle"></i> @else 3 @endif
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
                                        @if ($first && $second && $third && $forth) <i class="fas fa-check-circle"></i> @else 4 @endif
                                    </span>
                                </div>
                                
                                <div class="h6 my-2"><b>Make Offer</b></div>
                                
                                <p>Create fast offers for Buyers in any of ppt, pdf, excel formats</p>
                            </a>
                        </div>

                        {{-- Step 5  --}}
                        <div class="col bg-white shadow m-1"  @if (!$fifth) title="Complete step 4" @endif>
                            <a href="{{ route('panel.settings.index',encrypt(auth()->id())) }}"@if ($first && $second && $third && $forth && $fifth) #completed>
                            @elseif($first && $second && $third && $forth) 
                                <a href="https://forms.gle/JKe6p6bic7gjnuJq5" target="_blank">
                            @else 
                                <a href="{{ route('panel.settings.index',encrypt(auth()->id())) }}" @if(!$forth) style="cursor: not-allowed !important" @endif>
                            @endif
                                    <div class="circle @if ($first && $second && $third && $forth && $fifth) bg-success @elseif($first && $second && $third && $forth) bg-primary @else bg-secondary @endif text-white">
                                        <span>
                                            @if ($first && $second && $third && $forth && $fifth) <i class="fas fa-check-circle"></i> @else 5 @endif
                                        </span>
                                    </div>
                                    <div class="h6 my-2"><b>Set Template</b></div>
                                    <p>Share your templates for customising your offer</p>
                            </a>
                        </div>

                    </div>
                    <div class="bar"></div>
                </div>
            </div>
        {{-- @else
            <div class="col-xl-12 col-lg-12 col-md-12 col-12 statistics_count">
                <div class="card">
                    <div class="card-header">
                        <h3>Overview</h3>
                    </div>
                    <div class="card-body">
                        @php
                            $statistics_1 = [
                                [
                                    'title' => 'New Customers',
                                    'color' => 'red',
                                    'count' => getAccessCataloguePendingCount(auth()->id(),0),
                                    'link' =>  route('panel.seller.request.index') 
                                ],
                                [
                                    'title' => 'New Site Enquiries',
                                    'color' => 'green',
                                    'count' => getEnqCountFromWeb(auth()->id()),
                                    'link' => route('panel.seller.enquiry.index' ,['type' => 'contact'])
                                ],
                                [
                                    'title' => 'New Product Updates',
                                    'color' => 'yellow',
                                    'count' => getNewProductCount(auth()->id()),
                                    'link' => route('panel.seller.supplier.index')
                                ],
                            ];
                            $statistics_2 = [
                                [
                                    'title' => 'Customers',
                                    'color' => 'red',
                                    'count' => getAccessCataloguePendingCount(auth()->id(),1),
                                    'link' => url('panel/seller/my_reseller')
                                ],
                                [
                                    'title' => 'Draft Proposal',
                                    'color' => 'blue',
                                    'count' => getProposalSentThisMonth(auth()->id(),0),
                                    'link' => url('panel/proposals?status=0')
                                ],
                                [
                                    'title' => 'Sent Proposal',
                                    'color' => 'green',
                                    'count' => getProposalSentThisMonth(auth()->id(),1),
                                    'link' => url('panel/proposals?status=1')
                                ],
                            ];
                            $statistics_3 = [
                                [
                                    'title' => 'Total Suppliers',
                                    'color' => 'red',
                                    'count' => getMyTotalSuppliers(auth()->id(),1),
                                    'link' => route('panel.seller.my_supplier.index')
                                ],
                                [
                                    'title' => 'Own Sku',
                                    'color' => 'blue',
                                    'count' => getTotalProducts(auth()->id(),1),
                                    'link' => route('panel.user_shop_items.create',['type' => 'direct' ,'type_id' => auth()->id()]),
                                ],
                                [
                                    'title' => 'Linked Sku',
                                    'color' => 'green',
                                    'count' => getSellerLinkedCount(auth()->id(),2),
                                    'link' => route('panel.user_shop_items.create',['type' => 'direct' ,'type_id' => auth()->id()]),
                                ],
                            ];
                        @endphp

                        <div class="row">
                            
                            @foreach ($statistics_1 as $statistic_1)
                                <a class="col-xl-3 col-md-12 p-2" href="{{ $statistic_1['link'] }}">
                                    <div class="card proj-t-card mb-1">
                                        <div class="card-body">
                                            <div class="row align-items-center mb-30">
                                                <div class="col-auto">
                                                    <i class="far fa-calendar-check text-{{ $statistic_1['color'] }} f-30"></i>
                                                </div>
                                                <div class="col pl-0">
                                                    <h6 class="mb-5">{{ $statistic_1['title'] }}</h6>
                                                    <h6 class="mb-0 text-{{ $statistic_1['color'] }}"></h6>
                                                </div>
                                            </div>
                                            <div class="row align-items-center text-center">
                                                <div class="col">
                                                    <h6 class="mb-0">{{ $statistic_1['count'] }}</h6>
                                                </div>
                                                <div class="col">
                                                    <i class="fas fa-exchange-alt text-{{ $statistic_1['color'] }} f-18"></i>
                                                </div>
                                                
                                            </div>
                                            <h6 class="pt-badge bg-{{ $statistic_1['color'] }}"></h6>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                            
                            @foreach ($statistics_2 as $statistic_2)
                                <a class="col-xl-3 col-md-6 p-2" href="{{ $statistic_2['link'] }}">
                                    <div class="card ticket-card mb-1">
                                        <div class="card-body">
                                            <p class="mb-30 bg-{{ $statistic_2['color'] }} lbl-card"><i class="fas fa-folder-open"></i> {{ $statistic_2['title'] }}</p>
                                            <div class="text-center">
                                                <h2 class="mb-0 d-inline-block text-{{ $statistic_2['color'] }}">{{ $statistic_2['count'] }}</h2>
                                                <p class="mb-0 d-inline-block"></p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                            @foreach ($statistics_3 as $statistic_3)
                                <a class="col-xl-3 col-md-6 p-2" href="{{ $statistic_3['link'] }}">
                                    <div class="card prod-p-card card-{{ $statistic_3['color'] }}">
                                        <div class="card-body">
                                            <div class="row align-items-center mb-30">
                                                <div class="col">
                                                    <h6 class="mb-5 text-white">{{ $statistic_3['title'] }}</h6>
                                                    <h3 class="mb-0 fw-700 text-white">{{ $statistic_3['count'] }}</h3>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fa fa-money-bill-alt text-red f-18"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                    
                        </div>
                    </div>
                </div>
            </div>  
        @endif --}}
    @endif
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
