@extends('frontend.layouts.main')

@section('meta_data')
@php
		$meta_title = 'Dashboard | '.getSetting('app_name');		
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'GRPL';		
		$meta_author_email = '' ?? 'Hello@121.page';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';
        $customer = 1;
        $slug  = getShopSlugByUserId(auth()->id());
        @endphp
@endsection

@section('content')
<link rel="stylesheet" href="{{ asset('backend/plugins/slect2/dist/css/select2.min.css') }}">

<link href="{{ asset('frontend/assets/css/simplebar.css') }}" rel="stylesheet"> 

    <section class="section">
        <div class="container mt-5 canvas_div_pdf">
            <div class="row">
               <div class="col-12">
                <div class="my-3 d-flex justify-content-between">
                    <div class="">
                        <h5 class="mt-1">Sample required for : ( {{ $proposal_enquiry->amount ?? 0}} )</h5> 
                        <small>By: {{ $proposal_name }}</small> <br>
                        <small>Email: <a href="mailto:{{ $proposal_email }}">{{ $proposal_email }}</a></small> <br>
                        <small>Phone: <a href="tel:{{ $proposal_phone }}">{{ $proposal_phone }}</a></small>
                    </div>

                    {{-- <button type="button" onclick="getPDF();" class="btn btn-primary pull-right"><i class="fa fa-download"></i> {{ __('Download PDF')}}</button> --}}
                </div>
                <div class="row justify-content-center">
                    @foreach ($asked_sample as $item)
                        {{-- Getting Product Deltails --}}
                        @php
                            $product = App\Models\Product::whereId($item)->first();
                        @endphp                                
                        <div class="card" style="width: fit-content;border:none">
                            <div class="card-img">
                                <img src="{{ asset(getShopProductImage($product->id)->path ?? asset('frontend/assets/img/placeholder.png')) }}" alt="{{ $product->title }}'s Image" style="height: 185px; width: 185px;">
                            </div>
                            <div class="card-body ">
                                <a href="{{ inject_subdomain('shop/'. encrypt($item),$slug) }}" class="text-dark">
                                    <div class="h5 text-center">{{ $product->title }}</div>
                                    <div class="text-center">{{ $product->color }} , {{ $product->size }}</div>
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
                                    @endphp
                                    <div class="text-center">{{ format_price($price) }}</div>
                                </a>
                            </div>
                        </div>  
                    @endforeach
                </div>  
               </div>
                

            </div><!--end row-->

        </div><!--end container-->
    </section><!--end section-->
        <!-- End -->


@endsection
@section('InlineScript')
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script>
       function getPDF(){
            var HTML_Width = $(".canvas_div_pdf").width();
            var HTML_Height = $(".canvas_div_pdf").height();
            var top_left_margin = 15;
            var PDF_Width = HTML_Width+(top_left_margin*2);
            var PDF_Height = (PDF_Width*1.5)+(top_left_margin*2);
            var canvas_image_width = HTML_Width;
            var canvas_image_height = HTML_Height;

            var totalPDFPages = Math.ceil(HTML_Height/PDF_Height)-1;

            $(".pull-right").addClass('d-none');

            html2canvas($(".canvas_div_pdf")[0],{allowTaint:true}).then(function(canvas) {
                canvas.getContext('2d');
                
                console.log(canvas.height+"  "+canvas.width);
                
                
                var imgData = canvas.toDataURL("image/jpeg", 1.0);
                var pdf = new jsPDF('p', 'pt',  [PDF_Width, PDF_Height]);
                pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height);
                
                
                for (var i = 1; i <= totalPDFPages; i++) { 
                    pdf.addPage(PDF_Width, PDF_Height);
                    pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
                }
                
                pdf.save("HTML-Document.pdf");
            });

            $(".pull-right").removeClass('d-none');

        };
</script>


@endsection 