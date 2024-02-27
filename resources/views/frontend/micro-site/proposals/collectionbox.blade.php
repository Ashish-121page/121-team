<div class="actionbtn" style="position: absolute;top: 0;right: 29vw;transition: width 0.5s ease;">
    <button class="btn btn-primary " style="padding: 10px 15px;" onclick="togglecollection(this)">
        <i class="fas fa-times  "></i>
    </button>
</div>

<div class="row bg-light  " id="collectionbox1"
    style="height: 100vh; width: 30vw; position: fixed; z-index: 9; right: 0px; top: 0px; overflow: hidden auto; transition: width 0.5s ease 0s;display: flex;justify-content: start;align-content: start;">

    <div class="col-12">
        <div class="h4">Collection Box</div>
    </div>
    <div class="col-12" id="emptybox"></div>

    <div class="col-12">
        <div class="row" id="collectionbox">
            {{-- Items are Appended Here --}}
        </div>
    </div>



    <div class="col-12" id="workingcollection">
        <div class="dropdown text-end w-75">
            <button type="button" class="btn btn-outline-primary dropdown-toggle" style="width: 100%;"
                data-bs-toggle="dropdown">
                Add to
            </button>
            <ul class="dropdown-menu">
                @forelse ($existing_offers as $offer)
                    @if ($loop->iteration == 4)
                    @break
                @endif
                @php
                    $customer_details = json_decode($offer->customer_details)->offer_name ?? 'No Offer Name';
                    $customer_name = json_decode($offer->customer_details)->customer_name ?? 'No Buyer Name';
                @endphp
                <li>
                    <a href="#" class="dropdown-item addtooffer" data-offer_rec="{{ $offer->id }}"
                        data-product_id=""
                        onclick="addtooffer(this)">{{ $customer_details . ' - ' . $customer_name }}</a>
                </li>
            @empty
            @endforelse
            <li>
                <a href="#addnew" class="dropdown-item addnewoffer">Add New Offer</a>
            </li>
            <li>
                <button type="button" class="dropdown-item showalloffer"> {{ __('Show All Offers') }} </button>
            </li>
        </ul>
    </div>
</div>
</div>

@include('frontend.micro-site.proposals.modal.show-all-offer')
