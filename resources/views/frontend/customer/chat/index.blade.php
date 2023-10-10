@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = 'Chat | '.getSetting('app_name');		
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'GRPL';		
		$meta_author_email = '' ?? 'Hello@121.page';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';
        $customer = 1;		
	@endphp
@endsection

@section('content')
<link href="{{ asset('frontend/assets/css/simplebar.css') }}" rel="stylesheet">

     

        <!-- Profile Start -->
        <section class="section">
            <div class="container mt-lg-3">
                  <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-primary rounded-pill mb-3"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1.2em" height="1.2em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path fill="currentColor" d="M872 474H286.9l350.2-304c5.6-4.9 2.2-14-5.2-14h-88.5c-3.9 0-7.6 1.4-10.5 3.9L155 487.8a31.96 31.96 0 0 0 0 48.3L535.1 866c1.5 1.3 3.3 2 5.2 2h91.5c7.4 0 10.8-9.2 5.2-14L286.9 550H872c4.4 0 8-3.6 8-8v-60c0-4.4-3.6-8-8-8z"/></svg> Dashboard</a>
                <div class="row">

                    <div class="col-lg-8 col-12">
                       
                        <div class="card border-0 rounded shadow">
                            <div class="p-2 chat chat-list" data-simplebar style="max-height: 360px;">
                                <div class="table-responsive">
                                    <table id="enquiry_table" class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center no-export">#</th>
                                                <th class="col_4">Status</th>
                                                <th class="col_5">Title</th>
                                                <th class="col_6">Last Activity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($enquiry->count() > 0)
                                                @foreach($enquiry as $item)
                                                @php
                                                    $description = json_decode($item->description,true);
                                                @endphp
                                                    <tr>
                                                        <td class="text-center no-export"><a class="btn btn-link" href="{{ route('customer.chat.show', $item->id) }}">ENQ{{ $item->id }}</a></td>
                                                        <td class="col_4"><span class="badge bg-{{ getEnquiryStatus($item->status)['color'] }} rounded-pill">{{ getEnquiryStatus($item->status)['name'] }}</span></td>
                                                        <td class="col_5">You rasied enquiry for product {{ getProductNameById($description['product_id']) ?? ''}}</td>

                                                        <td class="col_6">{{ @getFormattedDate(getLastEnquiryConversation($item->id)->created_at) ?? getFormattedDate($item->created_at) }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                            <tr>
                                                <td class="text-center" colspan="8">No Enquiries</td>
                                            </tr>
                                            @endif 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                      
                    </div><!--end col-->
                    <div class="col-md-4">
                        <div>
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRua7jvmFpM4Xrep_A   Q1duXYDWkLZ8bDDrDzA&usqp=CAU" alt="" style="width: 100%">
                        </div>
                    </div>
                </div><!--end row-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- Profile End -->


@endsection

@push('script')

<!-- simplebar -->
        <script src="{{ asset('frontend/assets/js/simplebar.min.js') }}"></script>

@endpush