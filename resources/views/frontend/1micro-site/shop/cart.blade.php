@extends('frontend.layouts.main')
@section('meta_data')
    @php
		$meta_title = 'Shop-Cart | '.getSetting('app_name');		
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'GRPL';		
		$meta_author_email = '' ?? 'Hello@121.page';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';
        $microsite = 1;			
	@endphp
@endsection
@section('content')
<section class="section" style="min-height:600px;">
    <div class="container">

            <div class="row">
                @csrf
                <div class="col-lg-8 col-12">
                    <div class="table-responsive bg-white shadow rounded">
                        <table class="table mb-0 table-center">
                            <thead>
                                <tr>
                                    <th class="border-bottom py-3" style="min-width:20px "></th>
                                    <th class="border-bottom text-start py-3" style="min-width: 150px">Product</th>
                                    <th class="border-bottom text-center py-3" style="min-width: 80px">Unit Price<br> <span style="font-size: 11px;">(excl GST)</span></th>
                                    <th class="border-bottom text-center py-3" style="min-width: 150px">Qty<br><span style="font-size: 11px;">(in pxs/sets)</span></th>
                                    <th class="border-bottom text-center py-3" style="min-width: 100px">GST<br><span style="font-size: 11px;">(in % : amount)</span></th>
                                    <th class="border-bottom text-end py-3 pe-4" style="min-width: 80px;">Total Price<br><span style="font-size: 11px;">(excl GST)</span></th>
                                </tr>
                            </thead>

                            <tbody>
                                @php
                                    $subtotal = 0;
                                    $subtotaltax = 0;
                                @endphp
                                @foreach ($cart_items as $item)
                                @php
                                   $tax_percent = 0;
                                   $tax_amount = 0;
                                   $product = getProductDataById($item->product_id);
                                   if($product->hsn_percent != null && $product->hsn_percent != 0){
                                       $tax_percent = $product->hsn_percent;
                                        $tax_amount = round(($item->total * $product->hsn_percent)/100,2);
                                   }
                                @endphp
                                <tr class="shop-list">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <td class="h6 text-center">
                                        @if(getShopProductImage($item->product_id))
                                            <img src="{{ asset(getShopProductImage($item->product_id)->path ?? '') }}" class="img-fluid avatar avatar-small rounded shadow " style="height:auto;width:60px" alt="">
                                        @endif
                                    </td>
                                    <td>
                                        <div class=" align-items-center">
                                            <h6 class="mb-0">{{ Str::limit($product->title,15) ?? ''}}</h6>
                                            
                                            <div style="padding-left: 3px;">
                                              
                                                <p class="mb-0" style="line-height: 1.2;font-size: 14px;">From: <span>{{ NameById(UserShopUserIdBySlug($slug)) }}</span></p>
                                                <p class="mb-0" style="line-height: 1.2;font-size: 14px;"> <span>{{ getBrandRecordByProductId($item->product_id)->name??""}}</span></p>
                                                <p class="mb-0" style="line-height: 1.2;font-size: 14px;">MRP: <span>{{ format_price($item->price) }}</span></p>
                                                <p class="mb-0 mt-1" style="line-height: 1.2;font-size: 11px;"><a href="{{route('pages.remove-cart',$item->id)}}" style="margin-right:6px">Remove</a> </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ format_price($item->price) }} </td>
                                    <td class="text-center qty-icons">
                                        <button data-id="{{ $item->id }}" data-shop="{{ $item->user_shop_id }}" class="btn btn-icon btn-soft-primary minus">-</button>
                                        <input type="hidden">
                                        <input min="1" name="quantity" value="{{ $item->qty }}" type="number" class="btn btn-icon btn-soft-primary px-0 qty-btn quantity" style="width:55px">
                                        <button data-id="{{ $item->id }}" class="btn btn-icon btn-soft-primary plus">+</button> 
                                    </td>
                                    <td class="text-end fw-bold pe-4" >{{ $tax_percent }}% : <br> {{ format_price($tax_amount) }}</td>
                                    <td class="text-end fw-bold pe-4" >{{ format_price($item->total) }}</td>
                                </tr>
                                @php
                                    $subtotal += $item->total;
                                    $subtotaltax += $tax_amount;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!--end col-->
                <div class="col-lg-4 mt-lg-0 mt-md-5 mt-5">
                    <div class="table-responsive bg-white rounded shadow">
                        <table class="table table-center table-padding mb-0 bg-light">
                            <thead>
                                <tr>
                                    <th class="border-bottom py-3 ps-4" colspan="2" style="min-width:20px ">PRICE DETAILS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="h6 ps-4 py-3">Subtotal <span>({{ count($cart_items) }} Items)</span></td>
                                    <td class="text-end fw-bold pe-4">{{ format_price($subtotal) }}</td>
                                </tr>
                                <tr>
                                    <td class="h6 ps-4 py-3">GST </td>
                                    <td class="text-end fw-bold pe-4">{{ format_price($subtotaltax) }}</td>
                                </tr>
                                <tr class="bg-light">
                                    <td class="h6 ps-4 py-3">Total</td>
                                    <td class="text-end fw-bold pe-4">{{ format_price($subtotal+ $subtotaltax) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2 pt-0 text-end">
                        @if($cart_items->count() > 0)
                        <a  href="{{ route('pages.shop-pre-checkout',$slug) }}" class="btn btn-primary d-block">Checkout</a>
                        @endif
                    </div>
                </div>
            </div><!--end row-->
    </div>
</section>
@endsection
@push('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> 
<script>
        $('.minus').click(function(){
          var id =  $(this).data('id');
          var curr_qty =  +$(this).parent().find('input[type=number]').val();
          if(curr_qty <= 1){
              window.location.href = "{{url('/remove-cart')}}"+'/'+id;
          }else{
            window.location.href = "{{route('pages.update-cart')}}"+"?id="+id+"&type=minus";
          }
        });
        $('.plus').click(function(){
            var id =  $(this).data('id');
            var curr_qty =  +$(this).parent().find('input[type=number]').val();

            window.location.href = "{{route('pages.update-cart')}}"+"?id="+id+"&type=plus";
           
        });
</script>
@endpush