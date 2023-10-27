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

     
@endphp
@section('content')

<section class="section">
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="tab-pane shadow rounded p-4">

    {{-- Code Goes Here --}}
    <form method="POST" action="{{route('pages.proposal.samplecheckout')  }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="user_id" value="{{auth()->id()}}">
    <input type="hidden" name="proposal_id" value="{{$proposal->id}}">
    <div class="d-flex">
        <a href="{{ url()->previous() }}" class="btn  btn-outline-primary">Back</a>
    </div>
    <div class="h4 text-center my-3"> Sample Request </div>
        <div class="row">
            <!-- First Col -->
            {{-- <div class="col-12 col-md-6 col-sm-12 col-lg-6">
                <div class="mb-3">
                    <label for="reseller_name" class="form-label">Reseller Name</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" id="reseller_name" name="reseller_name" value="{{ json_decode($proposal->customer_details)->customer_name }}"
                        placeholder="Enter Reseller Name" autofocus="on" required>
                </div>
            </div>

            <!-- Second Col -->
            <div class="col-12 col-md-6 col-sm-12 col-lg-6">
                <div class="mb-3">
                    <label for="client_name" class="form-label">Client name</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" id="client_name" name="client_name" value="@isset($data) {{ json_decode($data->user_info)->client_name }} @endisset"
                        placeholder="Enter Client name" required>
                </div>
            </div>

            <!-- third Col -->
            <div class="col-12 col-md-6 col-sm-12 col-lg-6">
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label><span class="text-danger">*</span>
                    <input type="number" class="form-control" id="quantity" name="quantity" value="@isset($data) {{$data->quantity}} @endisset"
                        placeholder="Enter Quantity"required>
                </div>
            </div>

            <!-- fourth Col -->
            <div class="col-12 col-md-6 col-sm-12 col-lg-6">
                <div class="mb-3">
                    <label for="estimate_delivery" class="form-label">Estimated Delivery</label><span class="text-danger">*</span>
                    <input type="date" class="form-control" id="estimate_delivery" name="estimate_delivery" value="@isset($data) {{$data->expiry_date}} @endisset"
                        placeholder="Enter date till valid" required>
                </div>
            </div> --}}

            <!-- fifth Col -->
            {{-- <div class="col-12 col-md-6 col-sm-12 col-lg-6">
                <div class="mb-3">
                    <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                    <select name="city" id="city" class="form-control p-2 city">
                        @foreach ($city as $item)
                            <option value="{{ $item->id }}" @isset($data) @if( json_decode($data->user_info)->city == $item->id ) selected @endif @endisset>{{ $item->name }}</option>
                        @endforeach
                </select>
                </div>
            </div> --}}
            <!-- sixth Col -->
            <div class="col-12 col-md-12 col-sm-12 col-lg-12">
                <div class="mb-3 visually-hidden">
                    <label for="" class="form-label">Pick SKU</label>
                    {{-- <input type="" class="form-control" id="" placeholder=""> --}}
                    <select name="picked_sku[]" class="form-control" id="picked_sku" multiple>
                        @foreach ($proposal_item as $item)
                            @php
                                $product = getProductDataById($item);
                            @endphp
                            <option value="{{ $product->id ?? '' }}">
                                {{ $product->model_code ?? '' }} - {{ $product->title ?? 'Not Available' }} -
                                {{ $product->color ?? '' }} - {{ $product->size ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>


            @foreach ($products as $product)
                @php
                    // $product = getProductDataById($item);
                    $title = $product->title ?? null;
                    $colors = getProductColorBySku($product->sku);
                @endphp

                @if ($title != null)
                    <div class="col-md-3 col-sm-4 col-6 my-5">
                        {{-- <div class="h2">{{  $product->artwork_url ?? '' }}</div> --}}
                        <div class="d-none d-md-block d-sm-none">
                            {{--<img src="{{ asset('backend/img/move.png') }}" alt="" height="20px" style="margin-top: 15px;
                            margin-left: 15px;">--}}
                        </div>
                        {{-- <img src="{{ (isset($product) && (getShopProductImage($product->id,'single') != null)  ? asset(getShopProductImage($product->id,'single')->path) : asset('frontend/assets/img/placeholder.png')) }}" alt="" class="custom-img" style="object-fit: contain;"> --}}
                        <img src="{{ (isset($product) && (getShopProductImage($product->changeit,'single') != null)  ? asset(getShopProductImage($product->id,'single')->path) : asset('frontend/assets/img/placeholder.png')) }}" alt="" class="custom-img" style="object-fit: contain;">

                        <div class="text-center m-1" >{{  $title ?? '' }}</div>

                        <div class="text-center my-1">Model Code: {{ $product->model_code ?? '' }}</div>

                        <div class="my-1">
                            <select name="color[]" id="color" class="form-select form-control select2">
                                <option value="" selected>Select Colour</option>
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}"> {{ $color->color }} - {{ $color->size }} - {{ $color->id }} </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <div class="my-1">
                            <select name="size[]" id="size" class="form-select form-control select2">
                                <option value="" selected>Select Size</option>
                                @foreach ($colors as $size)
                                    @if ($size->size != '' && $size->size != Null)
                                        <option value="{{ $size->id }}"> {{ $size->size }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div> --}}

                    </div>
                @endif

            @endforeach



        </div>
        <div class=" gap-4 d-md-flex justify-content-left">
        <button type="submit" name="submitform" class="btn btn-outline-primary">Submit Form</button>
        </div>
    </form>
                </div>
            </div>
        </div>
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


        // $(".select2").select2();


    });
</script>

@endsection
