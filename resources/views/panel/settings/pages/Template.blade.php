<div class="col-12">
    {{-- {{ asset('frontend/assets/img/default_ppt.svg') }} --}}
    <div class="row">
        <div class="col-lg-12 col-md-12 my-3 text-center">
            <div class="h4">Powerpoint Templates</div>
        </div>

        @foreach ($templates as $template)
            @if ($template->user_id != null && $template->user_id != auth()->id() )
                @continue
            @endif

            <div class="col-md-4 col-sm-4 col-6 d-flex justify-content-center flex-column card">
                <div class="head d-flex justify-content-between align-items-center w-100" style="height: 100px;width: 250px;object-fit: contain;">
                    <img src="{{ asset($template->thumbnail ?? '') }}" alt="test" class="img-fluid rounded"
                        style="height: 100%;width: 100%;">
                </div>

                <div class="body d-flex justify-content-center align-items-center m-2">
                    <div class="one mx-2 text-center">
                        <div class="name my-2" style="text-transform: uppercase"> {{ $template->name_key }} </div>
                        <div class="lastupdated">{{ $template->updated_at }}</div>
                    </div>
                    <div class="two mx-2">
                        <div class="action">
                            @if ($template->user_id == auth()->id())
                                <a href="{{ route('panel.settings.make.default.Template',[auth()->id(),$template->id]) }}" class="btn-link @if ($template->default == 1) text-dark @endif  mx-1">Default</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row my-2">
                    <div class="col-12 d-flex justify-content-center">
                        @if(auth()->user() && session()->has("admin_user_id") && session()->has("temp_user_id"))
                            <a href="{{ route('panel.settings.edit.Template',$template->id) }}" class="btn btn-outline-primary">Edit as a Admin</a>
                        @elseif ($template->user_id == auth()->id())
                            <a href="#edit" class="btn-link">Edit</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <div class="row">
        <div class="col-12 my-3 text-center">
            <div class="h4">PDF Templates</div>
        </div>

        @php
            $record = App\Models\Media::where('type_id',auth()->id())->where('type','OfferBanner')->get();
        @endphp
        <div class="col-12">
            <form action="{{ route('panel.settings.upload.banner') }}" enctype="multipart/form-data" method="POST">

                @csrf
                <input type="hidden" name="user_id" value="{{ encrypt(auth()->id()) }}">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="offer_logo" class="d-block">Upload File</label>
                            <input type="file" name="offer_logo" id="offer_logo" accept="image/*">
                            <span class="d-block my-2 text-danger ">Image Size should be 2100px X 300 px</span>
                            @if ($record->count() != 0 )
                                <input type="hidden" name="existing" value="{{ $record[0]->path }}">
                            @endif
                        </div>
                    </div>

                    @if ($record->count() != 0 )
                        <div class="col-12">
                            <div class="form-group">
                                <label class="d-block">Preview</label>
                                <img src="{{ asset($record[0]->path) }}" alt="Image Preview"  style="height: 100%;width: 100%;">
                            </div>
                        </div>
                    @endif


                    <div class="col-lg-12 col-md-12" >
                        <div class="d-flex justify-content-center align-content-center" style="margin-top: 5rem;">
                            <button type="submit" class="btn btn-outline-primary my-2">Save</button>
                        </div>
                    </div>


                </div>


            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12 my-3 text-center">
            <div class="h4">QR Templates</div>
        </div>
            {{-- <div class="container mt-4">
                <div class="my-2 text-center">
                    <a href="javascript:void();" onclick="window.print();" class="btn btn-primary hide-print" type="button">Print</a>
                </div>
                
                <div class="row mt-4 qr-grid justify-content-center">
                    @php
                        $page = 0;
                    @endphp
                    @foreach ($product_ids as $key => $product_id)
                    @php
                        $product = getProductDataById($product_id);
                        $user_shop = App\Models\UserShop::whereUserId(auth()->id())->first();
    
                        
                        $enc_product = encrypt($product_id);
                        $bhai = "shop/".$enc_product."?pg=&scan=1";
                        $url= inject_subdomain($bhai,$user_shop->slug,false,true);
                        $barcode_img = QrCode::size(170)->generate( $url );
                        $product = getProductDataById($product_id);
                    @endphp
                    <div class="col-lg-4 text-center mx-auto ">
                        <div class="d-flex align-items-center justify-content-center">
                            <div style="width: 40%; text-align: center;">
                                <img src="companylogo.jpg" alt="company Logo" style="height: 70px; width: 80px; padding: 0 5px;">
                            </div>
                            <div style="width: 60%; text-align: left;">
                                <h1>{{ auth()->user()->name }}</h1>                            
                            </div>
                        </div>
                        <hr>
                        <h5 style="text-decoration: underline;">{{ $user_shop->slug }}.121.page</h5>
                        
                            <h6 style="font-family:monospace">{{ 'Scan here' }}</h6>
                            <div style="border: 3px solid #6666CC; display: inline-block; padding: 5px; position: relative;">
                                <div style="position: absolute; top: -3px; left: -3px; right: -3px; bottom: -3px; border: 3px solid #6666CC; border-radius: 3px;"></div>
                                {!! $barcode_img !!}
                            </div>                                                                                                    
                            
    
                            <h6 class="mt-2" style="word-break: break-all; font-weight:600;">
                                Model Code: {{ $product->model_code }}
    
                               
                            </h6>
                            <h6 style="font-family:monospace" >{{ 'to know more' }}</h6>
                            <hr>
                           
                            <h6 class="" style="word-break: break-all; font-weight: bold;"> Powered by 121.page</h6>
                            
                        </div>
                    </div>
                    
                    @if($loop->iteration%9 == 0)
                        <span class="col-12 break-page">
                            <div class="mt-2 text-center">
                                Page {{++$page}}
                            </div>
                        </span>
                    @endif
                    @endforeach
                </div>
                
            </div> --}}
        
    </div>
        
</div>
