@extends('backend.layouts.empty') 
@section('title', 'Invoice')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9 mx-auto">
                <div class="card canvas_div_pdf">
                    <div class="card-header"><h3 class="d-block w-100"> <img class="mb-0 header-logo" src="{{  getFrontendLogo(getSetting('frontend_logo'))}}"  alt="" style="width:120px;"><small class="float-right">{{ __('Date: 12/11/2018')}} {{ $order->created_at->format('d/m/Y') }}</small></h3></div>
                    <div class="card-body">
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                From
                                <address>
                                    <strong>{{config('app.name')}},</strong><br>
                                    @if($order->from != null)
                                        @php
                                            $from = json_decode($order->from);
                                        @endphp
                                        <span>{{ $from->type == 0 ? "Home":"Office"}} {{ $from->address_1 }},</span> <br>
                                        <span>{{ $from->address_2 }}</span><br>
                                        <span>{{ fetchFirst("App\Models\City",$from->city,'name','') }}, </span>
                                        <span>{{ fetchFirst("App\Models\State",$from->state,'name','') }}, </span>
                                        <span>{{ fetchFirst("App\Models\Country",$from->country,'name','') }}</span>
                                    @endif
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                To
                                <address>
                                    <strong>{{ $order->user->name}}</strong><br>
                                    @if($order->to != null)
                                            @php
                                            $to = json_decode($order->to);
                                        @endphp
                                        <span>{{ $to->type == 0 ? "Home":"Office"}} {{ $to->address_1 }},</span> <br>
                                        <span>{{ $to->address_2 }}</span><br>
                                        <span>{{ fetchFirst("App\Models\City",$to->city,'name','') }}, </span>
                                        <span>{{ fetchFirst("App\Models\State",$to->state,'name','') }}, </span>
                                        <span>{{ fetchFirst("App\Models\Country",$to->country,'name','') }}</span>
                                    @endif
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <b>{{ __('Invoice #')}}{{ $order->txn_no }}</b><br>
                                <br>
                                <b>{{ __('Order ID:')}}</b> {{ "ORD".$order->id}}<br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Item Type')}}</th>
                                            <th>{{ __('Product')}}</th>
                                            <th>{{ __('Qty')}}</th>
                                            <th>{{ __('Price')}}</th>
                                            <th>{{ __('GST')}}</th>
                                            <th>{{ __('Amount (Excl GST)')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->items as $item)
                                            @php
                                               if($item->item_type == "Package"){
                                                $product = App\Models\Package::where('id', $item->item_id)->first();
                                                $product_name = "#PCK".$product->id.": ".$product->name;
                                               }else{
                                                $product = App\Models\Product::where('id', $item->item_id)->first();
                                                $product_name = "#Pro".$product->id.": ".$product->title;
                                               }
                                            @endphp
                                            <tr>
                                                <td> {{ $item->item_type }} </td>
                                                <td>{{ $product_name }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{format_price($item->price) }}</td>
                                                <td>{{$item->tax }}% - {{ format_price($item->tax_amount) }}</td>
                                                <td>{{ format_price($item->price * $item->qty) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
            
                        <div class="row">
                            <div class="col-6">
                            </div>
                            <div class="col-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th class="th-50">{{ __('Subtotal')}}:</th>
                                            <td>{{ format_price($order->sub_total)}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('GST ')}}</th>
                                            <td>{{format_price(round($order->tax))}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Total')}}:</th>
                                            <td>{{format_price($order->total)}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button style="position: absolute; bottom: 3rem; left: 2rem;" type="button" onclick="getPDF();" class="btn btn-primary pull-right"><i class="fa fa-download"></i> {{ __('Download PDF')}}</button>
            </div>
        </div>
    </div>
    @push('script')
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

    };
    </script>
    @endpush
@endsection

