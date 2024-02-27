@extends('backend.layouts.main')
@section('title', '3. Review and Generate Offer')
@section('content')
    @php
        $breadcrumb_arr = [['name' => 'Edit Proposal', 'url' => 'javascript:void(0);', 'class' => '']];
        $user = auth()->user();
        $proposal_options = json_decode($proposal->options);
        $slug_guest = getShopDataByUserId(155)->slug;
        $offer_url = inject_subdomain("shop/proposal/$proposal->slug", $slug_guest);
        $make_offer_link = inject_subdomain('proposal/create', $slug_guest, false, false) . '?linked_offer=' . $proposal->id . '&offer_type=2&shop=' . $proposal->user_shop_id;
        if ($proposal->type == 1) {
            $offer_url = $make_offer_link;
        }
        $user_shop_record = App\Models\UserShop::whereId($proposal->user_shop_id)->first();
        $user_key = encrypt(auth()->id());
        $slug = $user_shop_record->slug;
    @endphp
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.6/css/line.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
        <style>
            .btn-link.active {
                border-bottom: 2px solid #6666cc;
                border-bottom-left-radius: 0;
                border-bottom-right-radius: 0;
            }

            .accordion-button {
                padding: 10px;
                background-color: transparent;
                border: 1px solid #6666cc;
                text-align: center;
                vertical-align: middle;
            }
            .openstylemenu{
                cursor: pointer;
                /* padding: 10px; */
            }
            .openstylemenu.active{
                /* background-color: #f1f1f1; */
            }
            input[type="radio"] {
                accent-color: #6666cc;
            }

        </style>

        <style>
            .spacer {
                margin-right: 20px;
            }
        </style>
    @endpush


    <div class="container-fluid ">
        <div class="row">

            <div class="col-12 d-flex justify-content-center align-items-center mb-3">
                <a href="{{ inject_subdomain('proposal/edit/' . $proposal->id . '/' . $user_key, $slug, false, false) }}?margin={{ $proposal->margin ?? 10 }}"
                    class="btn btn-link text-primary mx-2">1. Selection</a>
                <a href="{{ route('pages.proposal.picked', ['proposal' => $proposal->id, 'user_key' => $user_key]) }}?type=picked"
                    class="btn btn-link text-primary mx-2 ">2. Notes</a>
                <a href="{{ inject_subdomain('proposal/export/' . $proposal->id . '/' . $user_key, $slug, false, false) }}"
                    class="btn btn-link text-primary mx-2 active">3. Generate</a>
            </div>



            @php
                $customer_details = json_decode($proposal->customer_details) ?? '';
                $customer_name = $customer_details->customer_name ?? '';

                if ($customer_name == auth()->user()->name) {
                    $customer_name = '';
                }

                $customer_mob_no = $customer_details->customer_mob_no ?? '';
                $customer_email = $customer_details->customer_email ?? '';
                $customer_alias = $customer_details->customer_alias ?? '';
                $person_name = $customer_details->person_name ?? '';
                $sample_charge = json_decode($proposal->customer_details)->sample_charge ?? '';
                $user_shop_record = App\Models\UserShop::whereId($proposal->user_shop_id)->first();
                $user_key = encrypt(auth()->id());
                $slug = $user_shop_record->slug;

            @endphp

            <div class="col-6 d-flex justify-content-start my-2">
                <div class="col-6" style="padding-right: 10px;">
                    <div class="d-flex align-items-center">
                        <span style="background-color: red">{{ __('Offer Name:') }}</span> 
                        <span class="spacer"> </span>                       
                        <span></span>
                    </div>
                </div>

                <div class="col-6" style="padding-right: 10px;">
                    <span>{{ __('Buyer Entity:') }}</span> 
                    <span class="spacer"> </span>                       
                    <span>{{ $customer_name }}</span>
                </div>

            
                <div class="col-4" style="padding-left: 10px;">
                    <div class="d-flex align-items-center">
                        <span>{{ __('No. of items:') }}</span>
                        <span class="spacer"> </span>
                        <span>{{ count($added_products) }}</span>
                        

                    </div>
                </div>
                
            </div>
            

            <div class="col-6 d-flex justify-content-end my-2">
                {{-- <a href="{{route('frontend.micro-site.proposals.edit') }}" class="btn btn-outline-primary mx-1">Add Product</a> --}}
                <a href="{{ inject_subdomain('proposal/edit/' . $proposal->id . '/' . $user_key, $slug, false, false) }}?margin={{ $proposal->margin ?? 10 }}" class="btn btn-outline-primary mx-1">Add Product</a>
                {{-- <a href="#add" class="btn btn-outline-success mx-1">+ Fields</a> --}}
                <a href="#" class="btn btn-outline-success mx-1" role="button" aria-expanded="false"
                            data-bs-toggle="modal" data-bs-target="#AttriModal">
                            <i class="fas fa-plus"></i>
                            Fields
                        </a>
                <a href="#add" class="btn btn-dark mx-1">Save Offer</a>
                <a id="export_offermodalbtn" href="#export_offermodal" class="btn btn-outline-primary mx-1">Export</a>
            </div>

            <div class="col-12">
                <table class="table table-responsive ">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Colour</th>
                            <th>Size</th>
                            <th>Finish</th>
                            <th>MOQ</th>
                            <th>Material</th>
                            <th>Remarks</th>
                            <th>Offer price</th>   
                            <th>Attachment</th>                        
                            <th>Others</th>
                            
                            {{-- <th>Model Code</th>
                            <th>COO</th>                            
                            <th>Currency</th>
                            <th>Price</th>
                            <th>Quality</th>
                            <th>Unit</th>
                            <th>Total</th> --}}
                            <th>Buyer Specific</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($added_products as $ptiem)
                            @php
                                $item = \App\Models\Product::find($ptiem->product_id);
                            @endphp

                            <tr>
                                <td><img src="{{ asset(getShopProductImage($item->id)->path ?? asset('frontend/assets/img/placeholder.png')) }}"
                                        alt="" width="50"></td>
                                <td>
                                    {{ $item->title }} <br>
                                    {{-- @if ($item->vault_type === 'asset') --}}
                                        Vault Name: {{ $item->vault_name }} <br>
                                        File Name: {{ $item->file_name }}
                                    {{-- @endif --}}
                                </td> 
                                <td></td>    
                                <td></td>  
                                <td></td>
                                <td></td>  
                                <td></td>  
                                <td></td>  
                                <td></td>  
                                <td></td>
                                <td></td>                                                             
                                {{-- <td>{{ $item->model_code }}</td>
                                <td>
                                    <select name="coo" id="coo" class="form-control">
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->name }}"
                                                @if ($country->name == ($tmp->COO ?? 'India')) selected @endif>
                                                {{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>{{ $item->currency ?? 'INR' }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->quality ?? 1 }}</td>
                                <td>
                                    
                                    <select name="unit" id="unit" class="form-control"
                                        style="width: min-content !important">
                                        <option value="per-piece"> per-piece </option>
                                        <option value="per-set"> per-set </option>
                                        <option value="per-box"> per-box </option>
                                    </select>
                                </td>
                                <td>{{ $item->total ?? '100' }}</td> --}}
                                <td>
                                    <a href="#buyer" class="btn btn-link ">
                                        + Buyer Exclusive
                                    </a> <br>
                                    <a href="#saveproduct" class="btn btn-link ">
                                        + Save to products
                                    </a>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>




    @include('frontend.micro-site.proposals.modal.export_offer')
    @include('panel.Documents.modals.SelectAttribute')

    @push('script')
        <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>
        <script>
            $("#export_offermodalbtn").animatedModal({
                color: '#fff',
            });

            $(document).on('click', '.openstylemenu', function() {
                $(".openstylemenu").removeClass('active');
                $(".aval_style").removeClass('d-flex');
                $(".aval_style").addClass('d-none');
                let menuId = $(this).data('menuid');
                $("#" + menuId).removeClass('d-none');
                $("#" + menuId).addClass('d-flex');
                $(this).addClass('active');
            });


        </script>

       
    @endPush

@endsection
