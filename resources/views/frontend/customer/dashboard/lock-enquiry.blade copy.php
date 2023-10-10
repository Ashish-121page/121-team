@extends('frontend.layouts.main')

@section('meta_data')
@php
		$meta_title = 'Lock Enquiry | '.getSetting('app_name');		
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
@section('content')

<section class="section">
    <div class="container mt-5">
        {{-- Code Goes Here --}}
        <form method="POST" action="{{ route('customer.lock.enquiry.store') }}">
        @csrf
        <input type="hidden" name="user_id" value="{{auth()->id()}}">
        <input type="hidden" name="proposal_id" value="{{$proposal->id}}">

        <div class="h4 text-center my-3">Lock Enquiry</div>
            <div class="row">
                <!-- First Col -->
                <div class="col-12 col-md-6 col-sm-12 col-lg-6">
                    <div class="mb-3">
                        <label for="reseller_name" class="form-label">Reseller Name</label>
                        <input type="text" class="form-control" id="reseller_name" name="reseller_name" value="{{ json_decode($proposal->customer_details)->customer_name }}"
                            placeholder="Enter Reseller Name">
                    </div>
                </div>
    
                <!-- Second Col -->
                <div class="col-12 col-md-6 col-sm-12 col-lg-6">
                    <div class="mb-3">
                        <label for="client_name" class="form-label">Client name</label>
                        <input type="text" class="form-control" id="client_name" name="client_name" value="@isset($data) {{ json_decode($data->user_info)->client_name }} @endisset"
                            placeholder="Enter Client name">
                    </div>
                </div>
    
                <!-- third Col -->
                <div class="col-12 col-md-6 col-sm-12 col-lg-6">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="{{ $data->quantity ?? "0"}}"
                         placeholder="Enter Quantity">
                    </div>
                </div>
    
                <!-- fourth Col -->
                <div class="col-12 col-md-6 col-sm-12 col-lg-6">
                    <div class="mb-3">
                        <label for="valid_upto" class="form-label">Valid upto</label>
                        <input type="datetime" class="form-control" id="valid_upto" name="valid_upto"  value="{{ $data->expiry_date ?? "" }}">
                    </div>
                </div>
    
                <!-- fifth Col -->
                <div class="col-12 col-md-6 col-sm-12 col-lg-6">
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <select name="city" id="city" class="form-control p-2 city">
                            @foreach ($city as $item)
                                <option value="{{ $item->id }}" @if (json_decode($data->user_info)->city == $item->id) selected @endif>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- sixth Col -->
                <div class="col-12 col-md-6 col-sm-12 col-lg-6">
                    <div class="mb-3">
                        <label for="" class="form-label">Pick SKU</label>
                        {{-- <input type="" class="form-control" id="" placeholder=""> --}}
                        <select name="picked_sku[]" class="form-control" id="picked_sku" multiple>
                            @foreach ($proposal_item as $item)
                                @php
                                    $product = getProductDataById($item);
                                @endphp
                                <option value="{{ $product->id ?? '' }}" @if (in_array($product->id,json_decode($data->product_id))) selected json_decode($data->product_id)@endif>
                                    {{ $product->model_code ?? '' }} - {{ $product->title ?? 'Not Available' }} - 
                                    {{ $product->color ?? '' }} - {{ $product->size ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>


            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</section>
@endsection

@section('InlineScript')
<script src="{{ asset('backend/js/qrcode.js') }}"></script>
<script src="{{ asset('frontend/assets/js/simplebar.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/simplebar.min.js') }}"></script>
<script src="{{ asset('frontend/libs/feather-icons/feather.min.js')}}"></script>
<script src="{{ asset('backend/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>

<script src="https://cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script>
<script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

<script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
<script src="{{ asset('backend/js/html2canvas.js') }}"></script>

<script>
    $(document).ready(function () {
        $("#picked_sku").select2()
        $(".city").select2()
    });
</script>

@endsection