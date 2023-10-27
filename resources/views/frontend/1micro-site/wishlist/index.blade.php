@extends('frontend.layouts.main')
@section('meta_data')
    @php
		$meta_title = 'Wishlist | '.getSetting('app_name');		
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'GRPL';		
		$meta_author_email = '' ?? 'Hello@121.page';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';		
	@endphp
@endsection
@section('content')
     <section class="bg-half-170 bg-light d-table w-100 strip-bg-img">
            <div class="container">
                <div class="row mt-5 justify-content-center">
                    <div class="col-lg-12 text-center">
                        <div class="pages-heading">
                            <h4 class="title mb-0">Like </h4>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
                
                <div class="position-breadcrumb">
                    <nav aria-label="breadcrumb" class="d-inline-block">
                        <ul class="breadcrumb bg-white rounded shadow mb-3 px-4 py-2">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            
                            <li class="breadcrumb-item active" aria-current="page">Like</li>
                        </ul>
                    </nav>
                </div>
            </div> <!--end container-->
        </section><!--end section-->
        <div class="position-relative">
            <div class="shape overflow-hidden text-white">
                <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
                </svg>
            </div>
        </div>
        <!-- Hero End -->

        <!-- wislist section start -->
<!-- contactpage part1 start -->
<div class="contactpage-part1">
    <div class="container">
       <table class="table table-hover table-responsive-sm   carttable">
        <thead>
            <tr>
                <td></td>
                <td>Product</td>
                <td>Price</td>
                <td>Qty</td>
                <td>Checkout</td>
            </tr>
        </thead>
        <tbody>
            <tr class="">
                <td><a href="#" class="text-danger"><i class="fa fa-times"></i></a></td>
                <td>
                    <img src={{ asset('frontend/assets/img/shop/product/s1.jpg') }} width="40px" class="me-2" alt="">
                   T-Shirt
               </td>
               <td class="" >$255.00</td>
   
               <td>
                   
                   <a href="#" class="  "><button class="cartbtn"><i class="fa fa-minus"></i></button></a>
                   <a href="#" class="  text-white "><button class="cartbtn1"> 2</button></a>
                   <a href="#" class="  "><button class="cartbtn"><i class="fa fa-plus"></i></button></a>
               </td>
               <td>
                <a href="#" class="  text-white text-sm-start"><button class="cartbtn3"><i class="fa fa-arrow-right"></i></button></a>
                   
               </td>
            </tr>
            <tr class="">
               <td><a href="#" class="text-danger"><i class="fa fa-times"></i></a></td>
               <td>
                   <img src={{asset('frontend/assets/img/shop/product/s1.jpg') }} width="40px" class="me-2" alt="">
                  Watch
              </td>
              <td class="" >$555.00</td>
   
              <td class="">
                <a href="#" class="  "><button class="cartbtn"><i class="fa fa-minus"></i></button></a>
                <a href="#" class="  text-white "><button class="cartbtn1"> 2</button></a>
                <a href="#" class="  "><button class="cartbtn"><i class="fa fa-plus"></i></button></a>
              </td>
              <td>
                <a href="#" class="  text-white text-sm-start"><button class="cartbtn3"><i class="fa fa-arrow-right"></i></button></a>


              </td>
           </tr>
           <tr class="">
               <td><a href="#" class="text-danger"><i class="fa fa-times"></i></a></td>
               <td>
                   <img src={{asset('frontend/assets/img/shop/product/s1.jpg') }} width="40px" class="me-2" alt="">
                  T-Shirt
              </td>
              <td class="" >$255.00</td>
   
              <td>
                <a href="#" class="  "><button class="cartbtn"><i class="fa fa-minus"></i></button></a>
                <a href="#" class="  text-white "><button class="cartbtn1"> 2</button></a>
                <a href="#" class="  "><button class="cartbtn"><i class="fa fa-plus"></i></button></a>
             </td>
              <td>
                <a href="#" class="  text-white text-sm-start"><button class="cartbtn3"><i class="fa fa-arrow-right"></i></button></a>


              </td>
           </tr>
        </tbody>
         </table>
         <div class="row">
             <div class="col-lg-8 col-sm-12">
                 <a href="#" class="btn cartbtn2 text-white mt-2">Shop More</a>
   
             </div>
         
         </div>
       </div>
   </div>
@endsection