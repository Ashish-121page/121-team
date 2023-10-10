@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = 'Notifications | '.getSetting('app_name');		
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
<link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
<style>
    a.text-dark:hover{
        color:rgb(232, 5, 5)!important;
    }
    .scroll {
    height: 350px;
    overflow-y: auto;
    }
</style>

    <div class="position-relative">
        <div class="shape overflow-hidden text-white">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
            </svg>
        </div>
    </div>
        <!-- Hero End -->

        <!-- Start -->
    <section class="section">
        <div class="container ">
            <div class="row">
                <div class="col-md-8 mx-auto justify-content-center">
                    <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-primary rounded-pill mb-3"><svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1.2em" height="1.2em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path fill="currentColor" d="M872 474H286.9l350.2-304c5.6-4.9 2.2-14-5.2-14h-88.5c-3.9 0-7.6 1.4-10.5 3.9L155 487.8a31.96 31.96 0 0 0 0 48.3L535.1 866c1.5 1.3 3.3 2 5.2 2h91.5c7.4 0 10.8-9.2 5.2-14L286.9 550H872c4.4 0 8-3.6 8-8v-60c0-4.4-3.6-8-8-8z"/></svg> Dashboard</a>
                    <div class="card shadow" style="">
                        <div class="card-header bg-white">
                            <h6>Notifications</h6>
                        </div>
                        <div class="card-body scroll">
                            @forelse ($notifications as $notification)
                                <div class="d-flex mb-2 justify-content-between">
                                   <div class="d-flex ">
                                    <i class="uil uil-bell"></i>
                                    <a href="javascript:void(0)" class="ms-2 text-dark">
                                        <div class="mb-0">{{ $notification->title }}</div>
                                        <small class="text-muted">{{ getFormattedDate($notification->created_at) }}</small>
                                    </a>
                                   </div>
                                    @if($notification->is_readed == 0)
                                        <div class="text-right">
                                            <i class="fa fa-circle fa-sm text-primary"></i>
                                        </div>
                                    @endif
                                </div>
                            @empty
                            @endforelse
                            
                        </div>
                    </div>
                    <div class=" mt-3 justify-content-center mx-auto">
                        <div>
                            {{ $notifications->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div><!--end container-->
    </section><!--end section-->
        <!-- End -->



@endsection
@section('InlineScript')


    <script>
       
    </script>
@endsection