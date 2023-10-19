@extends('frontend.layouts.main')
@section('meta_data')
    @php
		$meta_title = 'Shop | '.getSetting('app_name');		
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'GRPL';		
		$meta_author_email = '' ?? 'Hello@121.page';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';		
		$microsite = 1;		


        if ($proposal->status != 0) {
            $proposal_options = json_decode($proposal->options) ?? null;
            if ($proposal_options != null && isset($proposal_options)) {
                $proposal_options->show_Description  = $proposal_options->show_Description ?? 0;
                $proposal_options->Show_notes  = $proposal_options->Show_notes ?? 0;
                $proposal_options->show_color  = $proposal_options->show_color ?? 0;
                $proposal_options->show_size  = $proposal_options->show_size ?? 0;
            }else{
                $proposal_options->show_Description  = 0;
                $proposal_options->Show_notes  = 0;       
                $proposal_options->show_color  = 0;
                $proposal_options->show_size  = 0;
            }
        }else{
            return "Offer Is on Draft ! ";
            return back();
        }
        $ppt_price = [];
        $slug_guest = getShopDataByUserId(155)->slug;



        
        if (Auth::check()) {
            $slug = App\Models\Usershop::where('user_id',auth()->user()->id)->first()->slug ?? 'ASHISH';
            $user_key = encrypt(auth()->user()->id);
        }else{
            $slug = $slug_guest;
            $user_key = encrypt(155);
        }

        $offer_url = inject_subdomain("shop/proposal/$proposal->slug",$slug_guest);


	@endphp
@endsection
<style>
    @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css");
    body{
        text-align: center !important;
    }
    #topnav{
        display: none !important;
    }
    #ndfjkvnrs{
        padding: 0 !important;
    }
    .checkmark{
        height: 30px;
        width: 30px;
        background-color: #d4d4d4;
        font-weight: bolder;
        z-index: 99;
    }
    .checkmark::before{
        padding: 3px;
        font-size: large;
        content: '\F633'
    }
    input:checked + label{
        background-color: #6666cc;
        color: white;
        border: 1px solid
    }

    input[type=checkbox]{
        display: none;
    }


    .headbx{        
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }
    
    .headbx .h6{
        background-color: red;
        width: fit-content;
        height: max-content;
        padding: 8px;
        text-align: center;
        color: white;
    }
    .deleteitem {
        position: absolute;
        bottom: 5%;
        right: 0%;
        cursor: pointer;
        z-index: 1 !important;
    }
    .deleteitem i{
        font-size: 3vh
    }

    .hdfhj{
        width: 10.6vw !important;
    }

    @media only screen and (max-width: 600px) {
        .hdfhj {
            width: 140px !important;
        }
    }

</style>
<link
rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
/>
@section('content')

<section class="section mt-5 mt-md-0 mt-sm-0" id="ndfjkvnrs">
    
    {{-- <div class="headbx">
        <div class="h6">Do Not Share This Link with Client. Changes not saved. Export as pdf to save. Refresh to undo. </div>
    </div> --}}


    <div class="fixedbtn position-fixed noprint animate__animated animate__bounceInRight urehdug d-none" style="bottom: 25px; right: 25px; z-index: 999;">
        <a href="{{ request()->url() }}" class="btn d-flex gap-2 align-item-center justify-content-center" style="background-color: #283353; color: white;">
            <i class="fas fa-redo my-1"></i>
            <span class="d-none d-sm-block d-md-block">Undo Changes</span>
        </a>
    </div>

    
    

    <div class="d-none">
        {{-- <a href="https://api.whatsapp.com/send?text=Hey%2C%20{{ getShopDataByUserId($proposal->user_id)->name }}%20Share%20an%20Offer%20with%20You%2C%20you%20can%20access%20%0APasscode%3A%20{{ $proposal->password }}%0Aoffer%20LInk%3A%20
        {{ urlencode(Request::url()) }}" target="_blank" style="position: relative; right: 5rem; top: 2rem;" class="btn btn-success mx-2">
            <i class="fab fa-whatsapp" class=""></i>
        </a> --}}

        @if ($cust_details['customer_mob_no'] != null)
            <a href="https://api.whatsapp.com/send?phone=91{{ $cust_details['customer_mob_no'] }}&text=Click%20on%20link%20below%20to%20access%20offer%20and%20export%20directly%20as%20pdf%20or%20ppt%20.%0A%0AThis%20is%20confidential%20link%20ONLY%20for%20you%20-%20do%20NOT%20share%20further.%20%0A%20%0APasscode%20to%20access%20%3A%20{{ $proposal->password }}%20%20%0A{{ urlencode($offer_url) }}" target="_blank" style="position: relative; right: 5rem; top: 2rem;" class="btn btn-success mx-2">
                <i class="fab fa-whatsapp" class=""></i>
            </a>    
        @else
            <a href="https://api.whatsapp.com/send?text=Click%20on%20link%20below%20to%20access%20offer%20and%20export%20directly%20as%20pdf%20or%20ppt%20.%0A%0AThis%20is%20confidential%20link%20ONLY%20for%20you%20-%20do%20NOT%20share%20further.%20%0A%20%0APasscode%20to%20access%20%3A%20{{ $proposal->password }}%20%20%0A{{ urlencode($offer_url) }}" target="_blank" style="position: relative; right: 5rem; top: 2rem;" class="btn btn-success mx-2">
                <i class="fab fa-whatsapp" class=""></i>
            </a>
        @endif
        
        <a href="mailto:{{ $cust_details['customer_email'] ?? "no-reply@121.page" }}?subject=121.Page%20offer&body=Click%20on%20link%20below%20to%20access%20offer%20and%20export%20directly%20as%20pdf%20or%20ppt%20.%0A%0AThis%20is%20confidential%20link%20ONLY%20for%20you%20-%20do%20NOT%20share%20further.%20%0A%20%0APasscode%20to%20access%20%3A%20{{ $proposal->password }}%20%20%0A%20%20%0A{{ urlencode($offer_url) }}" target="_blank" style="position: relative; right: 5rem; top: 2rem;" class="btn btn-primary">
            <i class="far fa-envelope"></i>
        </a>
        
    </div>
    
    <div class="d-flex justify-content-center justify-content-sm-between w-100 justify-content-md-between align-items-center flex-wrap gap-3 mx-2 mt-3" style="position: sticky;top: 0%;left: 0;background-color: #fff !important;width: 100% !important;z-index: 99;padding-top: 10px !important;" >
        <div class="">
            <div class="h6">Offer To: {{ $cust_details['customer_name'] }} </div>
        </div>
        <div class="">
            <div class="d-flex gap-1 align-item-center noprint">
                {{-- <input type="number" placeholder="Enter Margin %" placeholder="&age" min="1" max="100" class="form-control hdfhj" id="magrintochnage"> --}}
                <div class="d-flex gap-3">
                    <label for="magrintochnage" class="form-label">Margin: <span id="range_bar"> 0 </span>%</label>
                    <input type="range" min="0" max="100" step="10"  class="form-range hdfhj" style="width: 150px" value="0" id="magrintochnage">
                </div>
                <div class="mx-2">
                    <button type="button" id="changemarguin" class="btn btn-outline-primary">Add</button>   
                </div>
            </div>
        </div>
        <div class="">
            @if ($proposal->valid_upto != '')
                <div class="h6">Valid Upto: {{ $proposal->valid_upto ?? '--' }} </div>
            @endif
        </div>  
    </div>
    
            <div class="container mt-5 canvas_div_pdf">  
                @if($cust_details['customer_name'] != '' || $proposal->proposal_note != null)
                    <div class="row justify-content-between">
                        <div class="col-12 col-md-12 col-lg-6">
                            <div style="position: relative;width: fit-content">
                                <input type="file" id="offericon" class="visually-hidden">
                                <label for="offericon" style="position: absolute;right: 0%" class="noprint chicon" >
                                    <i class="fas fa-pencil-alt text-primary fs-5" ></i>
                                </label>
                                <img src="{{ asset($proposal->client_logo) }}" alt="Client Logo" id="offerLogo" style="height: 150px;width: 250px;object-fit: contain;">
                            </div>

                            <div class="ms-3">
                                <h4 contenteditable="true">{{ $cust_details['customer_name'] }}</h4>
                                @if ($proposal_options->Show_notes == 1)
                                    <p contenteditable="true" style="border: 1px solid grey; border-radius: 5px">{{ nl2br($proposal->proposal_note )?? '' }}</p>
                                @endif
                            </div>
                        </div>
                       <div class="col-12 col-md-6 col-lg-6 d-flex justify-content-lg-end">
                            <div style="position: relative;width: fit-content   ">
                                <input type="file" id="clienticon" class="visually-hidden">
                                <label for="clienticon" style="position: absolute;right: 2%" class="noprint chicon" >
                                    <i class="fas fa-pencil-alt text-primary fs-5" ></i>
                                </label>
                                <img src="{{ asset('frontend/assets/img/Client_logo_placeholder.svg') }}" alt="Client Logo" id="clientLogo" style="height: 150px;width: 250px;object-fit: contain;">
                            </div>
                       </div>
                    </div>
                @endif
                <form action="{{ route('pages.proposal.samplecheckout') }}" method="POST" id="checkourform">
                    @csrf
                    <input type="hidden" name="proposal_id" value="{{ $proposal->id }}">
                <div class="row">
                    @if($products->count() > 0)
                                @foreach ($products as $key => $product)
                                                  
                                @php
                                    $user_shop = App\Models\UserShop::where('user_id',(auth()->id() ?? 155))->first();
                                    // $usi = productExistInUserShop($product->id,auth()->id(),$user_shop->id);
                                    $productId= \Crypt::encrypt($product->id);
                                    $record = (array) json_decode($proposal->currency_record);
                                    $exhangerate = $record[$proposal->offer_currency] ?? 1;
                                    $HomeCurrency = 1;
                                    $currency_symbol = $proposal->offer_currency ?? 'INR';
                                @endphp
                                    <div class="col-lg-3 col-md-4 col-12 mt-4 pt-2 d-print-none" style="position: relative;" id="contain-{{ $product->id }}">
                   

                                        <div class="sampleenquiry" style="position: absolute1; top: 10px;left: 10px;">
                                            <input type="checkbox" name="enquir[]" id="enquir-{{ $product->id }}" value="{{ $product->id }}">
                                            <label for="enquir-{{ $product->id }}" class="checkmark bi" style="position: absolute;top: -1%;right: 1%;cursor: pointer;"></label>
                                        </div>

                                        <div class="card shop-list border-0 position-relative">
                                            <div class="shop-image position-relative overflow-hidden rounded text-center">
                                                <a href="{{ inject_subdomain('shop/'. $productId,$slug) }}" target="_blank">
                                                    @if( getShopProductImage($product->id,'single') != null)
                                                        <img src="{{ asset(getShopProductImage($product->id)->path ?? asset('frontend/assets/img/placeholder.png')) }}" alt="" class="" style="height:185px;">
                                                    @else
                                                        <img src="{{ asset('backend/default/placeholder.jpg')  }}" class="img-fluid rounded" style="height:185px;">
                                                    @endif

                                                    <div class="sampleenquiry">
                                                        <label for="" data-contain="contain-{{ $product->id }}" class="deleteitem">
                                                            <i class="fas fa-trash" style="color: #ff0c0c;"></i>
                                                        </label>
                                                    </div>

                                                </a> 
                                            </div>
                                            <div class="card-body content pt-4 p-2">

                                                <a href="#" class="text-dark product-name h6" contenteditable="true">{{ $product->title }}</a>
                                                
                                                {{-- <div style="width:100%">
                                                    <span></span><small contenteditable="true">{{ fetchFirst('App\Models\Category',$product->sub_category_id,'name') }} </small>
                                                </div> --}}

                                                @if (isset($product->brand->name) && isset($product->brand->name) != '')
                                                    <p class="mb-0" contenteditable="true"><b>Brand:</b><span>{{ $product->brand->name ?? '--' }}</span></p>
                                                @endif

                                                <div style="wdith:100%">
                                                    <small contenteditable="true" >
                                                        
                                                            @if ($proposal_options->show_color)
                                                                {{ $product->color ?? '' }} 
                                                            @endif

                                                            @if ($proposal_options->show_size)
                                                                @if($product->size) , @endif 
                                                                {{ $product->size ?? ''}}
                                                            @endif                                                        
                                                    </small>
                                                </div>

                                                {{-- @if($product->user_id == auth()->id()) --}}
                                                    <span contenteditable="true">Model Code :# <span>{{ $product->model_code }}</span></span>
                                                {{-- @else 
                                                    <span>Ref ID :#{{ isset($usi) ? $usi->id : '' }}</span>
                                                @endif    --}}
                                                <div class="d-flex justify-content-between mt-1 text-center">

                                                    @php
                                                        $price = getProductProposalPriceByProposalId($proposal->id,$product->id) ?? $product->price;
                                                        $margin = App\Models\ProposalItem::whereProposalId($proposal->id)->where('product_id',$product->id)->first()->margin ?? 10;
                                                        $user_price = App\Models\ProposalItem::whereProposalId($proposal->id)->where('product_id',$product->id)->first()->user_price ?? null;
                                                        if ($user_price == null) {
                                                            $margin_factor = (100 - $margin) / 100;
                                                            $price = $price/$margin_factor;
                                                        }
                                                        else {
                                                            $price = $user_price;
                                                        }

                                                        $price = number_format(round(exchangerate($price,$exhangerate,$HomeCurrency)),2);
                                                        array_push($ppt_price,( $currency_symbol." ".$price));
                                                    @endphp

                                                    {{-- @if($proposal->enable_price_range == 1)
                                                        <h6 class="text-dark small fst-italic mb-0 mt-1 w-100">
                                                        {{ format_price(($price)-($price*10/100)) }} - {{ format_price(($price)+ ($price*10/100)) }}</h6>
                                                    @else --}}
                                                        <h6 class="text-dark small fst-italic mb-0 mt-1 w-100 product_price" contenteditable="true">
                                                            {{ $currency_symbol }}
                                                            {{ $price }}

                                                        {{-- {{ format_price($price) }} --}}
                                                    </h6>
                                                    {{-- @endif --}}
                                                    
                                                </div>
                                                @if ($proposal_options->show_Description == 1)
                                                    <span contenteditable="true">
                                                        {!! $product->description ?? "No Description" !!}
                                                    </span>
                                                @endif
                                                
                                            </div>
                                        </div>
                                        
                                    </div>

                                    @if(++$key%12==0)
                                        <div class="col-12 pdf-margin d-none" style="margin-bottom: 250px">

                                        </div>
                                    @endif
                                @endforeach
                            {{-- </div> --}}
                        {{-- </div><!--end col--> --}}
                    @else
                         <div class="col-lg-6 mx-auto text-center mt-3">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <i class="fa text-primary fa-lg fa-shopping-cart"></i>
                                        <p class="mt-4">No Products added yet!</p>
                                                                                
                                    </div>
                                </div>
                            </div>
                    @endif
                </div><!--end row-->
            </div><!--end container-->


        </form>

            <div id="printbx">
                @include('frontend.micro-site.shop.proposal.print')
            </div>


            @if (auth()->id() != $proposal->user_id)
                @include('frontend.micro-site.shop.proposal.modal.notice')                
            @endif          


            <div class="noprint">
                <p class="bg-primary px-5" style="padding: 20px 0;">
                    Edit on Page &gt; Export as PDF ; or
                    Export in ppt &gt; Edit
                    <br>
                    <b>Note 1 :</b> Do not share this link with client.
                    <br>
                    <b>Note 2 :</b> Type to edit on this page.
                    <br>
                    <b>Note 3 :</b>  Edits are NOT saved. Refresh to undo.
                </p>
            </div>


            {{-- ` Addtional Options ` --}}
            <div class="d-flex justify-content-center justify-content-sm-between justify-content-md-between align-items-center flex-wrap gap-3 my-3" style="margin-left: 100px">
                <div class=""> 
                    <button onclick="getPPT()" type="button" class="btn btn-outline-warning sdfgesd" style="position: relative; right: 5rem;"><i class="fa fa-download"></i> Save as PPT</button>
                    <button onclick="getPDF();" class="btn btn-outline-primary " style="position: relative; right: 5rem;"><i class="fa fa-download"></i> Save as PDF</button>

                    <button class="btn btn-outline-success" style="position: relative; right: 5rem;" id="export_button" type="button"><i class="fa fa-download"></i> Save as Excel</button>


                    {{-- @if ($proposal->type == 1)
                        <a href="{{ inject_subdomain('proposal/create', $slug, true, false)}}&linked_offer={{$proposal->id}}&offer_type=2&shop={{$proposal->user_shop_id}}" target="_blank" class="btn btn-outline-primary" style="position: relative; right: 5rem;"> {{ _("Make Offer") }} </a>
                    @endif --}}
                </div>
                <div class="">
                    <button class="btn btn-outline-primary" style="position: relative; right: 5rem;" form="checkourform"><i class="fa fa-ddownload"></i> Request Sample</button>
                </div>
            </div>
            
        </section>
@endsection
@section('InlineScript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pptxgenjs@3.12.0/dist/pptxgen.bundle.js"></script>

<script>
    var status = false;
    let attempt = 1;

    $(document).ready(function () {
        setTimeout(function() {
            $('#socialShareModal').modal('show');
        }, 3000); // 3 Second TimeOut


        setTimeout(function() {
            $(".urehdug").toggleClass('d-none');    
            $(".urehdug").addClass("animate__delay-7s");
        }, 6000); // 3 Second TimeOut


        
        
        
        $("#magrintochnage").change(function (e) { 
            e.preventDefault();
            $("#range_bar").html($(this).val());
        });


    });

    // function chkpass() {
    //     var pass = prompt("Enter Passcode !!",{{ $proposal->password }});
    //     if (attempt < 3) {
    //         if (pass == "{{ $proposal->password }}") {
    //             $("#ndfjkvnrs").toggleClass('d-none');
    //             status = true;
    //         } else {
    //             attempt = attempt+1;
    //             alert("Wrong Password,re-enter");
    //             console.log(attempt);
    //             chkpass();
    //         }
    //     }else{
    //         // DO Something if 3 Attempts are Over
    //         history.back();
    //     }
    // };


    $(document).ready(function () {
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#offerLogo').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#offericon").change(function (e) { 
            readURL(this);
        });

        function readClientURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#clientLogo').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#clienticon").change(function (e) { 
            readClientURL(this);
        });



        $(".deleteitem").click(function (e) { 
            e.preventDefault();
            let val = $(this).data('contain');

            console.log(val);
            $("#"+val).remove(); 
        });

        $("#changemarguin").click(function (e) { 
            e.preventDefault();
            let changemar = $("#magrintochnage").val();
            var inpch = $(".product_price");
            $.each(inpch, function (indexInArray, valueOfElement) { 
                let ashish = valueOfElement.innerHTML.split("₹")[1];
                ashish = ashish.replace(',','');
                var margin_factor = (100 - changemar) / 100;

                ashish = parseInt(ashish)/margin_factor;
                let margin = Math.abs(ashish);
                valueOfElement.innerHTML = "₹ "+Math.floor(margin);
            });

        });

    });
    
    

</script>


    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
        function html_table_to_excel(type)
        {
            var table_core = $("#printproposals").clone();
            var clonedTable = $("#printproposals").clone();
            clonedTable.find('[class*="no-export"]').remove();
            clonedTable.find('[class*="d-none"]').remove();
            $("#printproposals").html(clonedTable.html());
            var data = document.getElementById('printproposals');

            var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
            XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
            XLSX.writeFile(file, 'ProposalExport.' + type);
            $("#printproposals").html(table_core.html());
            
        }

        $(document).on('click','#export_button',function(){
            html_table_to_excel('xlsx');
        })
       

        $('#reset').click(function(){
            var url = $(this).data('url');
            getData(url);
            window.history.pushState("", "", url);
            $('#TableForm').trigger("reset");
            //   $('#fieldId').select2('val',"");               // if you use any select2 in filtering uncomment this code
           // $('#fieldId').trigger('change');                  // if you use any select2 in filtering uncomment this code
        });

       
        $(document).ready(function () {
            $("#product-name").change(function (e) { 
                e.preventDefault();
                console.log($(this).val());
            });
        });


    </script>
<script>
    function getPDF(){
        $('.sampleenquiry').addClass('d-none');
        $(".headbx").addClass('d-none');
        $(".noprint").addClass('d-none');
        $(".deleteitem").addClass('d-none');
        
        if($('.pdf-margin').hasClass('d-none')){
            $('.pdf-margin').removeClass('d-none');
        }else{
            $('.pdf-margin').addClass('d-none');
        }
        document.querySelector('meta[name=viewport]').setAttribute("content", "width=1200");

        var HTML_Width = $(".canvas_div_pdf").width();
        var HTML_Height = $(".canvas_div_pdf").height();
        var top_left_margin = 15;
        var PDF_Width = HTML_Width+(top_left_margin*2);
        var PDF_Height = (PDF_Width*1.5)+(top_left_margin*2);
        var canvas_image_width = HTML_Width;
        var canvas_image_height = HTML_Height;
        var totalPDFPages = Math.ceil(HTML_Height/PDF_Height)-1;

        html2canvas($(".canvas_div_pdf")[0],{allowTaint:true}).then(function(canvas) {
            canvas.getContext('2d');
            
            // console.log(canvas.height+"  "+canvas.width);

            var imgData = canvas.toDataURL("image/jpeg", 1.0);
            var pdf = new jsPDF('p', 'pt',  [PDF_Width, PDF_Height]);
            pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height);
            
            
            for (var i = 1; i <= totalPDFPages; i++) { 
                pdf.addPage(PDF_Width, PDF_Height);
                pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
            }
            
            $.ajax({
                type: "GET",
                url: "{{ route('pages.proposals.update.download', $proposal->id) }}",
                data: {
                    update: 1, 
                },
                success: function (response) {
                    // console.log(response);
                }
            });


            pdf.save("{{Illuminate\Support\Str::slug($proposal_slug) }}.pdf");

            setTimeout(() => {
                $('.pdf-margin').addClass('d-none');
            }, 1000);
            document.querySelector('meta[name=viewport]').setAttribute("content", "width=device-width, initial-scale=1.0");
        });


        $('.sampleenquiry').removeClass('d-none');
        $(".headbx").removeClass('d-none');
        $(".noprint").removeClass('d-none');
        $(".deleteitem").removeClass('d-none');
    };
</script>
<script>
    function getPPT() {
        let pptx = new PptxGenJS();
        let passedArray = [];
        let titleArray = [];
        let descrArray = [];
        let modelArray = [];
        let priceArray = [];
        let colorArray = [];
        let sizeArray = [];        
        let slides = [];
        let extraImageArray = [];

        @foreach ($product_ids as $item)
            passedArray.push("{{ asset(getShopProductImage($item)->path ?? asset('frontend/assets/img/placeholder.png')) }}");
        @endforeach

        @foreach ($newimag as $item)
            @foreach ($item as $item1)
                extraImageArray.push("{{  asset($item1) }}");
            @endforeach
        @endforeach


        passedArray.reverse();
        extraImageArray.reverse();

        console.log(extraImageArray);
        
        @foreach ($product_title as $item)
            titleArray.push("{{ ($item) }}");
        @endforeach

        function removeTags(str) {
            if ((str === null) || (str === ''))
                return false;
            else
                str = str.toString();
            return str.replace(/(<([^>]+)>)/ig, '');
        }


        @foreach ($product_desc as $item)
            data = `{!! Str::limit($item,630) !!}`;
            descrArray.push(removeTags(data));
        @endforeach

        @foreach ($product_model as $item)
            modelArray.push("{{ $item }}");
        @endforeach

        @foreach ($product_color as $item)
            colorArray.push("{{ $item }}");
        @endforeach

        @foreach ($product_size as $item)
            sizeArray.push("{{ $item }}");
        @endforeach

        @foreach ($ppt_price as $item)
            priceArray.push("{{ $item }}");
        @endforeach
       
        let mynum = 0;

        Array.from(passedArray).forEach((f,i) => {

            console.log(mynum);
            slides[i+1] = pptx.addSlide();
            slides[i+1].addImage({
                path: f,
                x: 0.4,
                y: 1.1,
                w: 2,
                h: 2
            });
             
            slides[i+1].addImage({
                path: extraImageArray[mynum+1],
                x: 0.2,
                y: 3.8,
                w: 0.6,
                h: 0.6
            });

            
            
            slides[i+1].addImage({
                path: extraImageArray[mynum+2],
                x: 1.0,
                y: 3.8,
                w: 0.6,
                h: 0.6
            });

            slides[i+1].addImage({
                path: extraImageArray[mynum+3],
                x: 1.8,
                y: 3.8,
                w: 0.6,
                h: 0.6
            });
            mynum = mynum + 4;


            slides[i+1].addText(titleArray[i] , { x: 0.4, y: 0.2,h: "10%",w: "25%", color: "000000", fontSize: 18 });
            // Decription Group
            slides[i+1].addText("Description", { x: "30%", y: 0.2,h: "10%",w: "15%", color: "000000", fontSize: 18 });
            slides[i+1].addText( descrArray[i], { x: "30%", y: "19%", w: "30%",h: "55%", color: "000000", fontSize: 12 });

            // Model code Group
            slides[i+1].addText("Model Code : ", { x: "65%", y: 0.2,h: "10%", w: "20%", color: "000000", fontSize: 15 });
            slides[i+1].addText(modelArray[i], { x: "80%", y: 0.2,h: "10%", w: "20%", color: "000000", fontSize: 15 });

            // Price Group
            slides[i+1].addText("Price : ", { x: "65%", y: 1,h: "10%", w: "10%", color: "000000", fontSize: 15 });
            slides[i+1].addText(priceArray[i], { x: "80%", y: 1,h: "10%", w: "20%", color: "000000", fontSize: 15 });
            
            // Color Group
            slides[i+1].addText("Color : ", { x: "65%", y: 1.5,h: "10%", w: "10%", color: "000000", fontSize: 15 });
            slides[i+1].addText(colorArray[i], { x: "80%", y: 1.5,h: "10%", w: "20%", color: "000000", fontSize: 15 });

            // Size Group
            slides[i+1].addText("Size : ", { x: "65%", y: 2,h: "10%", w: "10%", color: "000000", fontSize: 15 });
            slides[i+1].addText(sizeArray[i], { x: "80%", y: 2,h: "10%", w: "20%", color: "000000", fontSize: 15 });

            {{-- // Footer Group
            slides[i+1].addText("Powered By ", { x: "80%", y:"91%",h: "10%", w: "15%", color: "000000", fontSize: 15 });
            slides[i+1].addText("121.page", { x: "90.5%", y: "91%" ,h: "10%", w: "20%", color: "6666cc", fontSize: 15 });--}}


    
            
            
        })

        pptx.author = '{{ UserShopNameByUserId($proposal->user_id) ?? "121.page" }}';
        pptx.subject = 'Proposal {{ $cust_details['customer_name'] }}';
        pptx.company = '121.page';
        pptx.title = '{{ $cust_details['customer_name'] }}';


        $.ajax({
            type: "GET",
            url: "{{ route('pages.proposals.update.download', $proposal->id) }}",
            data: {
                update: 2,
            },
            success: function (response) {
                // console.log(response);                    
            }
        });

        pptx.writeFile({ fileName: "{{ $cust_details['customer_name'] }} Proposal.pptx" });

    }
</script>
@endsection