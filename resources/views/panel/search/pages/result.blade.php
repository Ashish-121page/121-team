@extends('backend.layouts.main')
@section('title', 'Search ')
@section('content')

    <div class="container-fluid">

        <div class="row">
            {{-- <div class="col-12">
                <img src="{{ asset($path) }}" alt="image_preview" style="height: 150px;object-fit: contain">
            </div> --}}
            <div class="col-12">
                <div class="row">
                    <div class="col-4">
                        <img src="{{ asset($path) }}" alt="image_preview" style="height: 150px;object-fit: contain">
                    </div>

                    <div class="col-8 d-flex justify-content-center align-items-center ">
                        <h5 class="btn text-center">{{ __('Asset Vault') }}</h5>
                        @forelse ($AssetVaultname as $Assetname)
                            <span class="btn btn-outline-primary btn-pill mx-1"
                                style="border-radius: 20px">{{ $Assetname }}</span>
                        @empty
                            <span class="btn btn-outline-primary btn-pill mx-1" style="border-radius: 20px">No Asset
                                Vault</span>
                        @endforelse
                        <h5 class="btn text-center">{{ __('Product') }}</h5>
                        @forelse ($productcatname as $producname)
                            <span class="btn btn-outline-primary btn-pill mx-1"
                                style="border-radius: 20px">{{ $producname }}</span>
                        @empty
                            <span class="btn btn-outline-primary btn-pill mx-1" style="border-radius: 20px">No Asset
                                Vault</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="row">
                    <div class="col-12 d-flex align-items-center  justify-content-between "
                        style="border-bottom: 1px solid #ccc">
                        <h6 class="text-muted ">Results</h6>
                        <span class="text-muted ">38 Found</span>
                    </div>

                    <div class="row d-flex flex-wrap ">
                        {{-- Product Card for Loop Start --}}
                        <div class="col">
                            <div class="card" style="width: min-content;height: max-content;">
                                <div class="card-body d-flex flex-column justify-content-start text-center "
                                    style="width: min-content;">
                                    <img src="https://picsum.photos/100?random=1" alt="Image Preview"
                                        style="object-fit: contain;height: 100px;border-radius: 10px">
                                    <span> Title </span>
                                    <span> Model Code: Test sb </span>
                                    <span> USD: 1.37 </span>
                                    @php
                                        $random = generateRandomStringNative(10);
                                    @endphp
                                    <input type="checkbox" id="checkme_{{ $random }}" class="d-none"
                                        name="checkproduct[]">
                                    <label for="checkme_{{ $random }}" class="chekpro mb-1 ">
                                        <a id="addvault" href="#searchview_modal" role="button"
                                            class="btn btn-link addvault " data-itemtype="assetimg">
                                            View
                                        </a>
                                    </label>

                                    <input type="checkbox" id="selectme_{{ $random }}" class="d-none"
                                        name="checkproduct[]">
                                    <label for="selectme_{{ $random }}" class="chekpro my-3">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-outline-primary dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Add To Offer
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item notyou" href="#"> + New Offer</a></li>
                                                <li><a class="dropdown-item" href="#">Offer 1</a></li>
                                                <li><a class="dropdown-item" href="#">Offer 2</a></li>
                                                <li><a class="dropdown-item" href="#">Offer 3</a></li>
                                            </ul>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        {{-- Product Card for Loop Start --}}
                        <div class="col">
                            <div class="card" style="width: min-content;height: max-content;">
                                <div class="card-body d-flex flex-column justify-content-start text-center "
                                    style="width: min-content;">
                                    <img src="https://picsum.photos/100?random=2" alt="Image Preview"
                                        style="object-fit: contain;height: 100px;border-radius: 10px">
                                    <span> Title </span>
                                    <span> Model Code: Test sb </span>
                                    <span> USD: 1.37 </span>
                                    @php
                                        $random = generateRandomStringNative(10);
                                    @endphp
                                    <input type="checkbox" id="checkme_{{ $random }}" class="d-none"
                                        name="checkproduct[]">
                                    <label for="checkme_{{ $random }}" class="chekpro mb-1 ">
                                        <a id="addvault" href="#searchview_modal" role="button"
                                            class="btn btn-link addvault " data-itemtype="product">
                                            View
                                        </a>
                                    </label>

                                    <input type="checkbox" id="selectme_{{ $random }}" class="d-none"
                                        name="checkproduct[]">
                                    <label for="selectme_{{ $random }}" class="chekpro my-3">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-outline-primary dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Add To Offer
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item notyou" href="#"> + New Offer</a></li>
                                                <li><a class="dropdown-item" href="#">Offer 1</a></li>
                                                <li><a class="dropdown-item" href="#">Offer 2</a></li>
                                                <li><a class="dropdown-item" href="#">Offer 3</a></li>
                                            </ul>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12 d-flex justify-content-between  align-item-center ">
                    <button class="btn btn-outline-primary ">Clear</button>
                    <button class="btn btn-primary d-none gotonext">Next</button>
                </div>


            </div>
        </div>

    </div>



    <!-- Modal -->
    <!--DEMO01-->
    <div id="searchview_modal">
        <div class="close-searchview_modal d-flex justify-content-center align-items-center my-2">
            <svg width="32" height="32" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"
                class="text-primary closeanimate">
                <path fill="currentColor"
                    d="M512 0C229.232 0 0 229.232 0 512c0 282.784 229.232 512 512 512c282.784 0 512-229.216 512-512C1024 229.232 794.784 0 512 0m0 961.008c-247.024 0-448-201.984-448-449.01c0-247.024 200.976-448 448-448s448 200.977 448 448s-200.976 449.01-448 449.01m181.008-630.016c-12.496-12.496-32.752-12.496-45.248 0L512 466.752l-135.76-135.76c-12.496-12.496-32.752-12.496-45.264 0c-12.496 12.496-12.496 32.752 0 45.248L466.736 512l-135.76 135.76c-12.496 12.48-12.496 32.769 0 45.249c12.496 12.496 32.752 12.496 45.264 0L512 557.249l135.76 135.76c12.496 12.496 32.752 12.496 45.248 0c12.496-12.48 12.496-32.769 0-45.249L557.248 512l135.76-135.76c12.512-12.512 12.512-32.768 0-45.248" />
            </svg>
            {{-- <span class="ml-2">Add Assets</span> --}}
        </div>
        <div class="modal-content">

            <iframe
                src="{{ route('panel.user_shop_items.create', ['type' => 'direct', 'type_ide' => encrypt(auth()->id()), 'assetvault' => 'true']) }}"
                frameborder="0" style="height: 100vh;width: 100vw" id="myframe" class="d-none"></iframe>

            <iframe src="{{ route('panel.products.edit', [9, 'type' => encrypt('editmainksku')]) }}" frameborder="0"
                style="height: 100vh;width: 100vw" id="myframe2" class="d-none"></iframe>

        </div>
    </div>

    @push('script')
        <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>
        <script>
            $(".addvault").click(function(e) {
                let myframe2 = $("#myframe")
                let myframe = $("#myframe2")
                let itemtype = $(this).data('itemtype');

                if (itemtype == 'product') {
                    myframe2.addClass('d-none')
                    myframe.removeClass('d-none')
                } else {
                    myframe.addClass('d-none')
                    myframe2.removeClass('d-none')
                }
            });

            $(".addvault").animatedModal({
                color: 'FFFFFF',
            });


            $(".dropdown-item").not('.notyou').click(function(e) {
                e.preventDefault();
                let text = $(this).text();
                $(this).closest('.dropdown').find('button').text(text);
                $(this).closest('.dropdown').find('button').addClass('active');
                $(this).closest('.dropdown').find('button').addClass('opennext');
                getactivecount()
            });

            function getactivecount() {
                let count = 0;
                $('.dropdown button').each(function() {
                    if ($(this).hasClass('opennext')) {
                        count++;
                    }
                });

                if (count > 0) {
                    $('.gotonext').removeClass('d-none');
                }

                return count;
            }
        </script>
    @endpush
@endsection
