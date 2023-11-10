@extends('frontend.layouts.main')
@section('meta_data')
    @php
        $meta_title = 'Shop | ' . getSetting('app_name');
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
                $proposal_options->show_Description = $proposal_options->show_Description ?? 0;
                $proposal_options->Show_notes = $proposal_options->Show_notes ?? 0;
                $proposal_options->show_color = $proposal_options->show_color ?? 0;
                $proposal_options->show_size = $proposal_options->show_size ?? 0;
            } else {
                $proposal_options->show_Description = 0;
                $proposal_options->Show_notes = 0;
                $proposal_options->show_color = 0;
                $proposal_options->show_size = 0;
            }
        } else {
            return 'Offer Is on Draft ! ';
            return back();
        }
        $ppt_price = [];
        $slug_guest = getShopDataByUserId(155)->slug;

        if (Auth::check()) {
            $slug = App\Models\UserShop::where('user_id', auth()->user()->id)->first()->slug ?? 'ASHISH';
            $user_key = encrypt(auth()->user()->id);
        } else {
            $slug = $slug_guest;
            $user_key = encrypt(155);
        }

        $offer_url = inject_subdomain("shop/proposal/$proposal->slug", $slug_guest);

    @endphp
@endsection
{{-- Animated modal --}}
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
<style>
    @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css");

    body {
        /* text-align: center !important; */
    }

    #topnav {
        display: none !important;
    }

    #ndfjkvnrs {
        padding: 0 !important;
    }

    .checkmark {
        height: 30px;
        width: 30px;
        background-color: #d4d4d4;
        font-weight: bolder;
        z-index: 99;
    }

    .checkmark::before {
        padding: 3px;
        font-size: large;
        content: '\F633'
    }

    input:checked+label {
        background-color: #6666cc;
        color: white;
        border: 1px solid
    }

    input[type=checkbox] {
        display: none;
    }


    .headbx {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    .headbx .h6 {
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

    .deleteitem i {
        font-size: 3vh
    }

    .hdfhj {
        width: 10.6vw !important;
    }

    @media only screen and (max-width: 600px) {
        .hdfhj {
            width: 140px !important;
        }
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@section('content')
    <section class="section mt-5 mt-md-0 mt-sm-0" id="ndfjkvnrs">

        {{-- <div class="headbx">
        <div class="h6">Do Not Share This Link with Client. Changes not saved. Export as pdf to save. Refresh to undo. </div>
    </div> --}}


        <div class="fixedbtn position-fixed noprint animate__animated animate__bounceInRight urehdug d-none"
            style="bottom: 25px; right: 25px; z-index: 999;">
            <a href="{{ request()->url() }}" class="btn d-flex gap-2 align-item-center justify-content-center"
                style="background-color: #283353; color: white;">
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
                <a href="https://api.whatsapp.com/send?phone=91{{ $cust_details['customer_mob_no'] }}&text=Click%20on%20link%20below%20to%20access%20offer%20and%20export%20directly%20as%20pdf%20or%20ppt%20.%0A%0AThis%20is%20confidential%20link%20ONLY%20for%20you%20-%20do%20NOT%20share%20further.%20%0A%20%0APasscode%20to%20access%20%3A%20{{ $proposal->password }}%20%20%0A{{ urlencode($offer_url) }}"
                    target="_blank" style="position: relative; right: 5rem; top: 2rem;" class="btn btn-success mx-2">
                    <i class="fab fa-whatsapp" class=""></i>
                </a>
            @else
                <a href="https://api.whatsapp.com/send?text=Click%20on%20link%20below%20to%20access%20offer%20and%20export%20directly%20as%20pdf%20or%20ppt%20.%0A%0AThis%20is%20confidential%20link%20ONLY%20for%20you%20-%20do%20NOT%20share%20further.%20%0A%20%0APasscode%20to%20access%20%3A%20{{ $proposal->password }}%20%20%0A{{ urlencode($offer_url) }}"
                    target="_blank" style="position: relative; right: 5rem; top: 2rem;" class="btn btn-success mx-2">
                    <i class="fab fa-whatsapp" class=""></i>
                </a>
            @endif

            <a href="mailto:{{ $cust_details['customer_email'] ?? 'no-reply@121.page' }}?subject=121.Page%20offer&body=Click%20on%20link%20below%20to%20access%20offer%20and%20export%20directly%20as%20pdf%20or%20ppt%20.%0A%0AThis%20is%20confidential%20link%20ONLY%20for%20you%20-%20do%20NOT%20share%20further.%20%0A%20%0APasscode%20to%20access%20%3A%20{{ $proposal->password }}%20%20%0A%20%20%0A{{ urlencode($offer_url) }}"
                target="_blank" style="position: relative; right: 5rem; top: 2rem;" class="btn btn-primary">
                <i class="far fa-envelope"></i>
            </a>

        </div>

        <div class="d-flex justify-content-center justify-content-sm-between w-100 justify-content-md-between align-items-center flex-wrap gap-3 mx-2 mt-3"
            style="position: sticky;top: 0%;left: 0;background-color: #fff !important;width: 100% !important;z-index: 99;padding-top: 10px !important;">
            <div class="">
                <div class="h6">Offer To: {{ $cust_details['customer_name'] }} </div>
            </div>
            <div class="">

                {{-- ` Addtional Options ` --}}
                <div class="d-flex justify-content-center justify-content-sm-between justify-content-md-between align-items-center flex-wrap gap-3 my-3"
                    style="margin-left: 100px">
                    <div class="">


                        @if (request()->has('download') && request()->get('download') == 'ppt')
                            <button type="button" class="btn btn-outline-warning sdfgesd"
                                style="position: relative; right: 5rem;"><i class="fa fa-download"></i> Save as PPT</button>
                        @endif

                        @if (!request()->has('download') || request()->get('download') == null)
                            <button onclick="getPDF();" class="btn btn-outline-primary " type="button"
                                style="position: relative; right: 5rem;"><i class="fa fa-download"></i> Save as PDF</button>
                        @endif

                        @if (request()->has('download') && request()->get('download') == 'excel')
                            <button class="btn btn-outline-success" style="position: relative; right: 5rem;"
                                id="export_button" type="button"><i class="fa fa-download"></i> Save as Excel</button>
                        @endif

                        {{-- @if ($proposal->type == 1)
                        <a href="{{ inject_subdomain('proposal/create', $slug, true, false)}}&linked_offer={{$proposal->id}}&offer_type=2&shop={{$proposal->user_shop_id}}" target="_blank" class="btn btn-outline-primary" style="position: relative; right: 5rem;"> {{ _("Make Offer") }} </a>
                    @endif --}}
                    </div>
                    {{-- <div class="">
                    <button class="btn btn-outline-primary" style="position: relative; right: 5rem;" form="checkourform"><i class="fa fa-ddownload"></i> Request Sample</button>
                </div> --}}
                </div>
                {{-- <div class="d-flex gap-1 align-item-center noprint"> --}}
                {{-- <input type="number" placeholder="Enter Margin %" placeholder="&age" min="1" max="100" class="form-control hdfhj" id="magrintochnage"> --}}
                {{-- <div class="d-flex gap-3">
                    <label for="magrintochnage" class="form-label">Margin: <span id="range_bar"> 0 </span>%</label>
                    <input type="range" min="0" max="100" step="10"  class="form-range hdfhj" style="width: 150px" value="0" id="magrintochnage">
                </div>
                <div class="mx-2">
                    <button type="button" id="changemarguin" class="btn btn-outline-primary">Add</button>   
                </div>
            </div> --}}
            </div>
            {{-- <div class="">
            @if ($proposal->valid_upto != '')
                <div class="h6">Valid Upto: {{ $proposal->valid_upto ?? '--' }} </div>
            @endif
        </div>   --}}
        </div>

        <div class="container mt-5 canvas_div_pdf">
            @if ($cust_details['customer_name'] != '' || $proposal->proposal_note != null)
                <div class="row justify-content-center">
                    {{-- <div class="col-12 col-md-12 col-lg-6">
                        <div style="position: relative;width: fit-content">
                            <input type="file" id="offericon" class="visually-hidden">
                            <label for="offericon" style="position: absolute;right: 0%" class="noprint chicon">
                                <i class="fas fa-pencil-alt text-primary fs-5"></i>
                            </label>
                            <img src="{{ asset($proposal->client_logo) }}" alt="Client Logo" id="offerLogo"
                                style="height: 150px;width: 250px;object-fit: contain;">
                        </div>

                        <div class="ms-3">
                            <h4 contenteditable="true">{{ $cust_details['customer_name'] }}</h4>
                            @if ($proposal_options->Show_notes == 1)
                                <p contenteditable="true" style="border: 1px solid grey; border-radius: 5px">
                                    {{ nl2br($proposal->proposal_note) ?? '' }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 d-flex justify-content-lg-end">
                        <div style="position: relative;width: fit-content   ">
                            <input type="file" id="clienticon" class="visually-hidden">
                            <label for="clienticon" style="position: absolute;right: 2%" class="noprint chicon">
                                <i class="fas fa-pencil-alt text-primary fs-5"></i>
                            </label>
                            <img src="{{ asset('frontend/assets/img/Client_logo_placeholder.svg') }}" alt="Client Logo"
                                id="clientLogo" style="height: 150px;width: 250px;object-fit: contain;">
                        </div>
                    </div> --}}

                    @php
                        $offerbanner = App\Models\Media::where('type_id', $proposal->user_id)
                            ->where('type', 'OfferBanner')
                            ->get();
                        if ($offerbanner->count() != 0) {
                            $offerbannerPath = asset($offerbanner[0]->path);
                        } else {
                            $offerbannerPath = asset('frontend/assets/img/Client_logo_placeholder.svg');
                        }
                    @endphp
                    <div
                        class="col-12 justify-content-center mx-auto d-flex @if (request()->get('view') == 'latest-view') takebottom @endif">
                        <div style="position: relative;width: fit-content">
                            <input type="file" id="clienticon" class="visually-hidden">
                            <label for="clienticon" style="position: absolute;right: 2%" class="noprint chicon">
                                <i class="fas fa-pencil-alt text-primary fs-5"></i>
                            </label>
                            {{-- <img src="{{ asset('frontend/assets/img/Client_logo_placeholder.svg') }}" alt="Client Logo" id="clientLogo" style="height: 150px;width: 250px;object-fit: contain;"> --}}
                            <img src="{{ $offerbannerPath }}" alt="Client Logo" id="clientLogo"
                                style="height:200px;width: 1100px;object-fit: contain;">
                        </div>
                    </div>

                </div>
            @endif
            <form action="{{ route('pages.proposal.samplecheckout') }}" method="POST" id="checkourform">
                @csrf
                <input type="hidden" name="proposal_id" value="{{ $proposal->id }}">

                <div class="row justify-content-between">
                    {{-- <div class="col-12"> --}}

                    @if (request()->has('view') && request()->get('view') == 'firstview')
                        @include('frontend.micro-site.shop.proposal.include.firstview')
                    @elseif(request()->has('view') && request()->get('view') == 'secondView')
                        @include('frontend.micro-site.shop.proposal.include.secondView')
                    @elseif(request()->has('view') && request()->get('view') == 'row-view')
                        @include('frontend.micro-site.shop.proposal.include.row-view')
                    @elseif(request()->has('view') && request()->get('view') == 'thirdview')
                        @include('frontend.micro-site.shop.proposal.include.thirdview')
                    @elseif(request()->has('view') && request()->get('view') == 'latest-view')
                        @include('frontend.micro-site.shop.proposal.include.latest-view')
                    @elseif(request()->has('view') && request()->get('view') == 'hz-secondview')
                        @include('frontend.micro-site.shop.proposal.include.hz-secondview')
                    @else
                        @include('frontend.micro-site.shop.proposal.include.firstview')
                    @endif
                    {{-- </div> --}}
                </div>


        </div><!--end container-->


        </form>

        <div id="printbx">
            @include('frontend.micro-site.shop.proposal.print')
        </div>


        {{-- @if (auth()->id() != $proposal->user_id)
                @include('frontend.micro-site.shop.proposal.modal.notice')                
            @endif --}}


        <div class="noprint">
            <p class="bg-primary px-5" style="padding: 20px 0;">
                Edit on Page &gt; Export as PDF ; or
                Export in ppt &gt; Edit
                <br>
                <b>Note 1 :</b> Do not share this link with client.
                <br>
                <b>Note 2 :</b> Type to edit on this page.
                <br>
                <b>Note 3 :</b> Edits are NOT saved. Refresh to undo.
            </p>
        </div>

        <a class="btn btn-outline-primary d-none mx-1" id="jaya1" href="#animatedModal3" role="button">Change Style</a>


        @include('frontend.micro-site.shop.proposal.modal.pdfcustom')

    </section>
@endsection
@section('InlineScript')
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pptxgenjs@3.12.0/dist/pptxgen.bundle.js"></script>
    <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>

    <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>


    <script>
        $("#jaya1").animatedModal({
            animatedIn: 'lightSpeedIn',
            animatedOut: 'lightSpeedOut',
            color: 'fffff',
            height: '80%',
            width: '80%',
            top: '10%',
            left: '10%',
        });

        $("#jaya1").click(function() {
            $(".close-animatedModal2").click();
        })
    </script>


    @if ($selectedProp == [] && $selectedProp == null)
        <script>
            $("#jaya1").click();
        </script>
    @endif



    <script>
        var status = false;
        let attempt = 1;

        $(document).ready(function() {



            $("#chooseprop").select2({
                dropdownParent: $("#animatedModal3"),
                placeholder: "Select Properties"
            });




            setTimeout(function() {
                $('#socialShareModal').modal('show');
            }, 3000); // 3 Second TimeOut


            setTimeout(function() {
                $(".urehdug").toggleClass('d-none');
                $(".urehdug").addClass("animate__delay-7s");
            }, 6000); // 3 Second TimeOut


            $("#magrintochnage").change(function(e) {
                e.preventDefault();
                $("#range_bar").html($(this).val());
            });




        });

        document.addEventListener("keydown", function(event) {
            // Alt + P to  print PDF Shortcut Key
            if (event.which == 80 && event.altKey == true) {
                getPDF();
            }
        })


        $(document).ready(function() {
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#offerLogo').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#offericon").change(function(e) {
                readURL(this);
            });

            $(".openmennu").click(function (e) { 
                e.preventDefault();
                $.confirm({
                    title: 'Confirm!',
                    content: 'Simple confirm!',
                    buttons: {
                        confirm: function () {
                            $.alert('Confirmed!');
                        },
                        cancel: function () {
                            $.alert('Canceled!');
                        },
                        somethingElse: {
                            text: 'Something else',
                            btnClass: 'btn-blue',
                            keys: ['enter', 'shift'],
                            action: function(){
                                $.alert('Something else?');
                            }
                        }
                    }
                });
            });

            function readClientURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#clientLogo').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#clienticon").change(function(e) {
                readClientURL(this);
            });



            $(".deleteitem").click(function(e) {
                e.preventDefault();
                let val = $(this).data('contain');

                console.log(val);
                $("#" + val).remove();
            });

            $("#changemarguin").click(function(e) {
                e.preventDefault();
                let changemar = $("#magrintochnage").val();
                var inpch = $(".product_price");
                $.each(inpch, function(indexInArray, valueOfElement) {
                    let ashish = valueOfElement.innerHTML.split("₹")[1];
                    ashish = ashish.replace(',', '');
                    var margin_factor = (100 - changemar) / 100;

                    ashish = parseInt(ashish) / margin_factor;
                    let margin = Math.abs(ashish);
                    valueOfElement.innerHTML = "₹ " + Math.floor(margin);
                });

            });

        });
    </script>


    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
        function html_table_to_excel(type) {
            var table_core = $("#printproposals").clone();
            var clonedTable = $("#printproposals").clone();
            clonedTable.find('[class*="no-export"]').remove();
            clonedTable.find('[class*="d-none"]').remove();
            $("#printproposals").html(clonedTable.html());
            var data = document.getElementById('printproposals');

            var file = XLSX.utils.table_to_book(data, {
                sheet: "sheet1"
            });
            XLSX.write(file, {
                bookType: type,
                bookSST: true,
                type: 'base64'
            });
            XLSX.writeFile(file, 'ProposalExport.' + type);
            $("#printproposals").html(table_core.html());

        }

        $(document).on('click', '#export_button', function() {
            html_table_to_excel('xlsx');
        })


        $('#reset').click(function() {
            var url = $(this).data('url');
            getData(url);
            window.history.pushState("", "", url);
            $('#TableForm').trigger("reset");
            //   $('#fieldId').select2('val',"");               // if you use any select2 in filtering uncomment this code
            // $('#fieldId').trigger('change');                  // if you use any select2 in filtering uncomment this code
        });


        $(document).ready(function() {
            $("#product-name").change(function(e) {
                e.preventDefault();
                console.log($(this).val());
            });
        });
    </script>
    <script>
        function getPDF() {
            $('.sampleenquiry').addClass('d-none');
            $(".headbx").addClass('d-none');
            $(".noprint").addClass('d-none');
            $(".deleteitem").addClass('d-none');

            $(".takebottom").css('margin-bottom', '400px');


            if ($('.pdf-margin').hasClass('d-none')) {
                $('.pdf-margin').removeClass('d-none');
            } else {
                $('.pdf-margin').addClass('d-none');
            }
            document.querySelector('meta[name=viewport]').setAttribute("content", "width=1200");

            var HTML_Width = $(".canvas_div_pdf").width();
            var HTML_Height = $(".canvas_div_pdf").height();
            var top_left_margin = 15;
            var PDF_Width = HTML_Width + (top_left_margin * 2);
            var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
            var canvas_image_width = HTML_Width;
            var canvas_image_height = HTML_Height;
            var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

            html2canvas($(".canvas_div_pdf")[0], {
                allowTaint: true
            }).then(function(canvas) {
                canvas.getContext('2d');

                // console.log(canvas.height+"  "+canvas.width);

                var imgData = canvas.toDataURL("image/jpeg", 1.0);
                var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);

                // Added a blank page as first
                // pdf.addPage(PDF_Width, PDF_Height);

                pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width,
                    canvas_image_height);

                for (var i = 1; i <= totalPDFPages; i++) {
                    pdf.addPage(PDF_Width, PDF_Height);
                    pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height * i) + (top_left_margin * 4),
                        canvas_image_width, canvas_image_height);
                }
                // pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height);


                // for (var i = 1; i <= totalPDFPages; i++) { 
                //     pdf.addPage(PDF_Width, PDF_Height);
                //     pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
                // }

                $.ajax({
                    type: "GET",
                    url: "{{ route('pages.proposals.update.download', $proposal->id) }}",
                    data: {
                        update: 1,
                    },
                    success: function(response) {
                        // console.log(response);
                    }
                });


                pdf.save("{{ Illuminate\Support\Str::slug($proposal_slug) }}.pdf");

                setTimeout(() => {
                    $('.pdf-margin').addClass('d-none');
                }, 1000);
                document.querySelector('meta[name=viewport]').setAttribute("content",
                    "width=device-width, initial-scale=1.0");
            });


            $('.sampleenquiry').removeClass('d-none');
            $(".headbx").removeClass('d-none');
            $(".noprint").removeClass('d-none');
            $(".takebottom").css('margin-bottom', '0px');
            $(".deleteitem").removeClass('d-none');
        };
    </script>

    {{-- {!! $pptTesmplate[0]->data !!} --}}

    <script>
        function limitCharacters(inputString, limit) {
            if (inputString.length > limit) {
                return inputString.slice(0, limit);
            }
            return inputString; 
        }

        $(document).ready(function() {
            $(".sdfgesd").click(function(e) {
                e.preventDefault();
                let titleArray = [];
                let descrArray = [];
                let modelArray = [];
                let priceArray = [];
                let Additional1Array = [];
                let Additional2Array = [];
                let Additional3Array = [];
                let passedArray = []; // Images
                let slides = [];
                let mynum = 0;
                let author = '{{ UserShopNameByUserId($proposal->user_id) ?? '121.page' }}';
                let subject = 'Proposal {{ $cust_details['customer_name'] }}';
                let company = '121.page';
                let titlefile = '{{ $cust_details['customer_name'] }}';
                let fileNamegiven = "{{ $cust_details['customer_name'] }} Proposal.pptx";
                let sizeArray = [];
                let colorArray = [];
                let extraImageArray = [];


                // ` Making Array Of Price 
            document.querySelectorAll(".product_price").forEach(element => {
                let price = element.innerHTML.replace(/^\s+|\s+$/gm, '');
                price = price.replace('\n', ' ');
                priceArray.push(price);
            });

            // ` Making Array Of product-name 
                document.querySelectorAll(".product-name").forEach(element => {
                    let title = element.innerHTML.replace(/^\s+|\s+$/gm, '');
                    title = title.replace('\n', ' ');

                    titleArray.push(title);
                });

                // ` Making Array Of product-description 
            document.querySelectorAll(".product-description").forEach(element => {
                let desc = element.innerHTML.replace(/^\s+|\s+$/gm, '');
                desc = desc.replace('\n', ' ');

                descrArray.push(desc);
            });

            // ` Making Array Of product-model 
                document.querySelectorAll(".product-model").forEach(element => {
                    let model = element.innerHTML.replace(/^\s+|\s+$/gm, '');
                    model = model.replace('\n', ' ');

                    modelArray.push(model);
                });

                // ` Making Array Of shop-image 
            document.querySelectorAll(".shop-image > a > img").forEach(element => {
                let img = element.src.replace(/^\s+|\s+$/gm, '');
                img = img.replace('\n', ' ');
                passedArray.push(img);
            });

            // ` Making Array Of shop-image 
                document.querySelectorAll(".print_content0").forEach(element => {
                    let model = element.innerHTML.replace(/^\s+|\s+$/gm, '');
                    model = model.replace('\n', ' ');
                    Additional1Array.push(model);
                });
                // ` Making Array Of shop-image 
            document.querySelectorAll(".print_content1").forEach(element => {
                let model = element.innerHTML.replace(/^\s+|\s+$/gm, '');
                model = model.replace('\n', ' ');
                Additional2Array.push(model);
            });
            // ` Making Array Of shop-image 
                document.querySelectorAll(".print_content2").forEach(element => {
                    let model = element.innerHTML.replace(/^\s+|\s+$/gm, '');
                    model = model.replace('\n', ' ');
                    Additional3Array.push(model);
                });

                $.ajax({
                    type: "GET",
                    url: "{{ route('pages.proposals.update.download', $proposal->id) }}",
                    data: {
                        update: 2,
                    },
                    // success: function(response) {
                    //     console.log(response);                    
                    // }
                });

                let pptx = new PptxGenJS();

                let firstpage = pptx.addSlide("Front Page");
                let secondpage = pptx.addSlide("Second Page");
                let thirdpage = pptx.addSlide("Third Page");             
                let logo = document.querySelector("#clientLogo").src;
                let rows = [];


                let firstImage = "https://images.unsplash.com/photo-1475776408506-9a5371e7a068?auto=format&fit=crop&q=80&w=1516&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D";
                
                let SecondImage = "https://images.unsplash.com/photo-1499748926165-1085fc69e9fc?auto=format&fit=crop&q=80&w=1470&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D";

                let thirdImage = "https://images.unsplash.com/photo-1485970247670-34cd80f5a996?auto=format&fit=crop&q=80&w=1548&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D";

                let LastImage = "https://images.unsplash.com/photo-1536759808958-bcc29b661ec6?auto=format&fit=crop&q=80&w=1470&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D";
                
                let BackgroundImage = "https://images.unsplash.com/photo-1506057213367-028a17ec52e5?auto=format&fit=crop&q=80&w=1470&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D";
                
                firstpage.addImage({
                    path: firstImage,
                    x: 0,
                    y: 0,
                    w: '100%',
                    h: '100%'
                });
                
                // Put Second Cover Image
                secondpage.addImage({
                    path: SecondImage,
                    x: 0,
                    y: 0,
                    w: '100%',
                    h: '100%'
                });

                // Put Third Cover Image
                thirdpage.addImage({
                    path: thirdImage,
                    x: 0,
                    y: 0,
                    w: '100%',
                    h: '100%'
                });

                // code for 1X1 loop
                for (let index = 0; index < passedArray.length; index += 1) {
                    slides[index] = pptx.addSlide();

                    slides[index].addImage({
                        path: BackgroundImage,
                        x: '0',
                        y: '0',
                        w: '100%',
                        h: '100%'
                    })
                    slides[index].addImage({
                        path: logo,
                        x: '0.25',
                        y: '0.157',
                        w: '2.1',
                        h: '0.566'
                    });

                    slides[index].addImage({
                        path: passedArray[index],
                        x: '0.09',
                        y: '0.25',
                        w: '4.99',
                        h: '5.10'
                    });

                    // Adding Up Product Info
                    rows = [];
                        if (titleArray != null) {
                            if (titleArray[i] ?? '' != '') {
                                rows.push(["Product TITLE", ":", titleArray[index]]);
                            }
                        }
                        if (modelArray != null) {
                            if (modelArray[i] ?? '' != '') {
                                rows.push(["Model Code", ":", modelArray[index]]);
                            }
                        }
                        if (modelArray != null) {
                            if (modelArray[i] ?? '' != '') {
                                rows.push(["Description", ":", limitCharacters (modelArray[index],80 )]);
                            }
                        }
                        
                        if (priceArray != null) {
                            if (priceArray[i] ?? '' != '') {
                                rows.push(["Price", ":", priceArray[index]]);
                            }
                        }

                        {{--// selected custom fields from modal--}}
                        if (Additional1Array != null) {
                            if (Additional1Array[index] ?? '' != '') {
                                rows.push([ `${ $(".print_content0").text().split(":")[0].trim() }`, ":" , Additional1Array[index].split(":")[1].trim()?? '']);    
                            }
                        }
                        if (Additional2Array != null) {
                            if (Additional2Array[index] ?? '' != '') {
                                rows.push([ `${ $(".print_content1").text().split(":")[0].trim() }`, ":" , Additional2Array[index].split(":")[1].trim() ?? '']);
                            }
                        }
                        if (Additional3Array != null) {
                            if (Additional3Array[index] ?? '' != '') {
                                rows.push([ `${ $(".print_content2").text().split(":")[0].trim() }`, ":" , Additional3Array[index].split(":")[1].trim() ?? '']);
                            }
                        }

                        if (rows != null) {
                            slides[index].addTable(rows, {
                                x: 5.37,
                                y: 0.25,
                                w: 4.34,
                                h: 5.10
                            });
                        }

                } //  End of Loop

                let lastslide = pptx.addSlide("Last slide");
                // Put last slide Cover Image
                    lastslide.addImage({
                    path: LastImage,
                    x: 0,
                    y: 0,
                    w: '100%',
                    h: '100%'
                });

                // Put Logo on last slide  Cover Image
                // lastslide.addImage({
                //     path: logo,
                //     x: '0.25',
                //     y: '0.157',
                //     w: '2.1',
                //     h: '0.566'
                // });


                pptx.writeFile({
                    fileName: "Proposal.pptx"
                });




                console.log("Somethig Happened..");
            });
        });
    </script>
@endsection
