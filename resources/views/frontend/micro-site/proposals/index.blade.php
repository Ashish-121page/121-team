@extends('frontend.layouts.main')
@section('meta_data')
    @php
        $categoryName = fetchFirst('App\Models\Category', request()->get('category_id'), 'name') ?? 'All';
        $meta_title = ' 1. Select Items | ' . getSetting('app_name');
        $meta_description = getSetting('seo_meta_description');
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
    <style>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css");

        #selector select option {
            color: #333;
            position: relative;
            top: 5px;
        }

        #navigation {
            display: none !important;
        }

        .adwas {
            position: sticky !important;
            /* top: 50px !important; */
            background-color: #fff !important;
            z-index: 9999 !important;
        }

        /*==================================================
                                                                                                    remove the original arrow in select option dropdown
                                                                                                    ==================================================*/
        #selector {
            margin: 5px 10%;
            width: 100%;
        }

        @media(max-width: 760px) {
            #selector {
                margin: auto;
            }

            .filterMobile {
                display: block;
            }
        }

        @media(min-width: 760px) {
            .filterMobile {
                display: none;
            }
        }

        .select_box {
            -webkit-appearance: none;
            -moz-appearance: none;
            -o-appearance: none;
            appearance: none;
        }

        .select_box.input-lg {
            height: 50px !important;
            line-height: 25px !important;
        }

        .select_box+i.fa {
            float: right;
            margin-top: -32px;
            margin-right: 9px;
            pointer-events: none;
            background-color: #FFF;
            padding-right: 5px;
        }

        .custom-scrollbar {
            max-height: 500px;
            overflow-y: auto;
        }

        .shop-list .shop-image .overlay-work,
        .shop-list .shop-image .shop-icons {
            position: absolute;
            opacity: 1 !important;
            transition: all 0.5s ease
        }

        .checkmark {
            position: absolute;
            bottom: 10px;
            right: 5px;
            height: 25px;
            width: 25px;
            border-radius: 3px;
            background-color: #eee;
            cursor: pointer;
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: block;
        }

        .custom-chk .checkmark:after {
            left: 9px;
            top: 5px;
            width: 7px;
            height: 11px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .custom-chk input:checked~.checkmark {
            background-color: #6666cc;
        }

        /* custome Loader */
        .lds-roller {
            display: inline-block;
            position: absolute;
            z-index: 999;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: grayscale(1) blur(5px);
        }

        .lds-roller div {
            animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
            transform-origin: 40px 40px;
        }

        .lds-roller div:after {
            content: " ";
            display: block;
            position: absolute;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #111;
            margin: -4px 0 0 -4px;
        }

        .lds-roller div:nth-child(1) {
            animation-delay: -0.036s;
        }

        .lds-roller div:nth-child(1):after {
            top: 63px;
            left: 63px;
        }

        .lds-roller div:nth-child(2) {
            animation-delay: -0.072s;
        }

        .lds-roller div:nth-child(2):after {
            top: 68px;
            left: 56px;
        }

        .lds-roller div:nth-child(3) {
            animation-delay: -0.108s;
        }

        .lds-roller div:nth-child(3):after {
            top: 71px;
            left: 48px;
        }

        .lds-roller div:nth-child(4) {
            animation-delay: -0.144s;
        }

        .lds-roller div:nth-child(4):after {
            top: 72px;
            left: 40px;
        }

        .lds-roller div:nth-child(5) {
            animation-delay: -0.18s;
        }

        .lds-roller div:nth-child(5):after {
            top: 71px;
            left: 32px;
        }

        .lds-roller div:nth-child(6) {
            animation-delay: -0.216s;
        }

        .lds-roller div:nth-child(6):after {
            top: 68px;
            left: 24px;
        }

        .lds-roller div:nth-child(7) {
            animation-delay: -0.252s;
        }

        .lds-roller div:nth-child(7):after {
            top: 63px;
            left: 17px;
        }

        .lds-roller div:nth-child(8) {
            animation-delay: -0.288s;
        }

        .lds-roller div:nth-child(8):after {
            top: 56px;
            left: 12px;
        }

        @keyframes lds-roller {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .loader-hidden {
            display: none;
        }

        .container-fluid {
            margin: 0;
            padding: 0;
            width: 30%;
            background-color: #fff;
        }

        .container-fluid img {
            height: 100px;
            width: 120px;
        }

        .container-fluid .bx {
            text-align: center;
            text-transform: uppercase;
            font-weight: bold;
            margin: 5px;
            position: relative;
        }

        .container-fluid .bx .icon {
            position: absolute;
            top: -5%;
            right: -5%;
            cursor: pointer;
        }

        .container-fluid .bx .icon img::before {
            transition: 0.3s ease all;
        }

        .container-fluid .bx .icon i:hover::before {
            content: '\F622';
            color: red;
            font-weight: 800;
            height: min-content;
        }

        .container-fluid .bx span {
            font-size: 0.8pc;
            padding: 4px;
        }

        .container-fluid .bx small {
            font-weight: 500;
            text-transform: none;
        }

        .openbtn {
            position: absolute;
            right: 2%;
            top: 2%;
        }

        .row {
            width: 100%;
        }

        .eird {
            background-color: #6666cc;
            color: white;
        }

        .eird h2 {
            text-align: left;
            margin-left: 5%;
            padding: 8px;
            font-size: 1.3pc;
        }

        .sidebar {
            position: relative;
        }

        .sticky-bar {
            top: 0 !important;
        }

        .col {
            width: fit-content;
            margin: 5px;
        }

        .col img {
            width: 190px !important;
            height: 150px !important;
            margin: 10px;
        }

        .ashu {
            text-align: center;
        }

        .col-3,
        .col-9 {
            margin: 10px 0;
        }

        .ydfgwej {
            position: fixed;
            right: 3%;
            bottom: 40%;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 35px;
            align-content: center;
            justify-content: center;
            /* align-items: center; */
            flex-wrap: nowrap;
        }

        .defaultscroll {
            padding: 0 0 20px 0;
        }

        .modal-content custom-spacing {
            overflow-y: hidden !important;
            overflow-x: hidden !important
        }

        /* filter alignment */
        .accordion-body {
            padding: 0 0 !important
        }

        .btn-link.active {
            border-bottom: 2px solid #6666cc;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

            {
            width: 100%;
        }
    </style>
    {{-- <style>
    .topnav {
        position: fixed;
        top: 0;
        right: 0;
        background-color: #f2f2f2;
        overflow: hidden;
    }
    .topnav a {
        float: left;
        display: block;
        color: #6666cc;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
    }
    .topnav a:hover {
        background-color: #ddd;
        color: black;
    }
    .topnav .icon {
        display: none;
    }
    @media screen and (max-width: 600px) {
        .topnav a:not(:first-child) {display: none;}
        .topnav a.icon {
            float: right;
            display: block;
        }
    }
    @media screen and (max-width: 600px) {
        .topnav.responsive {position: relative;}
        .topnav.responsive .icon {
            position: absolute;
            right: 0;
            top: 0;
        }
        .topnav.responsive a {
            float: none;
            display: block;
            text-align: left;
        }
    }
</style> --}}

    {{-- <style>
            /* Style the navigation menu */
        .topnav1 {
        overflow: hidden;
        background-color: #333;
        position: relative;
        }
        /* Hide the links inside the navigation menu (except for logo/home) */
        .topnav1 #myLinks {
        display: none;
        }
        /* Style navigation menu links */
        .topnav1 a {
        color: white;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
        display: block;
        }
        /* Style the hamburger menu */
        .topnav1 a.icon {
        background: black;
        display: block;
        position: absolute;
        right: 0;
        top: 0;
        }
        /* Add a grey background color on mouse-over */
        .topnav1 a:hover {
        background-color: #ddd;
        color: black;
        }
    </style> --}}
    {{-- <section class="section"> --}}
    <section class="">
        {{-- Over The Layer Content --}}
        @if (isset($proposalid) && $proposalid != -1)
            <div class="ydfgwej">
                <button class="btn btn-outline-primary d-none " type="button" id="select-all">
                    <span class="d-none d-md-none d-sm-none">Select All</span>
                    <span class="d-block d-md-block d-sm-block">
                        <i class="fas fa-check-double"></i>
                    </span>
                </button>
                {{-- <a href="#" class="btn btn-outline-primary" type="button" class="btn btn-link text-primary mx-2 " data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <span class="d-block d-md-block d-sm-block">
                        Filters <i class="fas fa-chevron-right"></i>
                    </span>
                </a> --}}
                {{-- <a href="{{ route('pages.proposal.picked', ['proposal' => $proposalid, 'user_key' => $user_key]) }}?type=picked"
                    class="btn btn-outline-primary" target="">
                    <span class="d-block d-md-block d-sm-block">
                        Next <i class="fas fa-chevron-right"></i>
                    </span>
                </a> --}}
            </div>
        @endif

        <div class="container mt-3" style="margin: 100px; max-width:1440px!important;">
            <div class="row bg-white wdaqd ">
                {{-- original --}}
                {{-- @if (isset($user_key))
                    <div class="col-12 d-flex justify-content-center align-items-center"
                        style="position: fixed;top:0% !important;left:0%;z-index: 88;padding: 0 0 25px 0 !important;background-color: #fff;">
                        <a href="#one" class="btn btn-link text-primary mx-2 active">1. Selection</a>
                        <a href="{{ route('pages.proposal.picked', ['proposal' => $proposalid, 'user_key' => $user_key]) }}?type=picked"
                            class="btn btn-link text-primary mx-2">2. Notes</a>
                        <a href="{{ inject_subdomain('proposal/export/' . $proposal->id . '/' . $user_key, $slug, false, false) }}"
                            class="btn btn-link text-primary mx-2">3. Generate</a>
                    </div>
                @endif --}}
                @if (isset($user_key))
                    <div class="col-12 d-flex justify-content-center align-items-center"
                        style="position: fixed;top:0% !important;left:0%;z-index: 88;padding: 0 0 25px 0 !important;background-color: #fff;">
                        <a href="#" type="button" class="btn btn-link text-primary mx-2 " data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">1. Search</a>
                        <a href="{{ route('pages.proposal.picked', ['proposal' => $proposalid, 'user_key' => $user_key]) }}?type=picked"
                            class="btn btn-link text-primary mx-2">2.Update</a>
                        <a href="{{ inject_subdomain('proposal/export/' . $proposal->id . '/' . $user_key, $slug, false, false) }}"
                            class="btn btn-link text-primary mx-2">3. Generate</a>
                        <div class="dropdown text-end ml-5" style="margin-left:8rem;">
                            <button type="button" class="btn btn-outline-primary dropdown-toggle" style="width: 100%;"
                                data-bs-toggle="dropdown">
                                Add to
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#" class="dropdown-item" onclick="addToSelected('option1')">Option 1</a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item" onclick="addToSelected('option2')">Option 2</a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item" onclick="addToSelected('option3')">Option 3</a>
                                </li>
                            </ul>
                        </div>
                        <div id="selectedItemsContainer">
                            <!-- Selected items will be added here -->
                        </div>
                    </div>
                @else
                    {{-- ` Show in Microsite or Search Page --}}

                    {{-- <div class="col-12">
                        <button class="btn btn-secondary" onclick="window.history.back()" type="button">Back</button>
                    </div> --}}
                @endif
            </div>

            <div class="row mt-5 mb-2">
                <div class="col-6">
                    <div class="col-lg-4 input-group border rounded">
                        <input type="text" id="quicktitle" value="" name="title" class="form-control border-0"
                            placeholder="Search by Name or Model Code">
                        <button type="submit" class="input-group-text bg-white border-0" id="searchsubmit">
                            <svg width="18" height="18" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                <path fill="currentColor"
                                    d="m479.6 399.716l-81.084-81.084l-62.368-25.767A175.014 175.014 0 0 0 368 192c0-97.047-78.953-176-176-176S16 94.953 16 192s78.953 176 176 176a175.034 175.034 0 0 0 101.619-32.377l25.7 62.2l81.081 81.088a56 56 0 1 0 79.2-79.195M48 192c0-79.4 64.6-144 144-144s144 64.6 144 144s-64.6 144-144 144S48 271.4 48 192m408.971 264.284a24.028 24.028 0 0 1-33.942 0l-76.572-76.572l-23.894-57.835l57.837 23.894l76.573 76.572a24.028 24.028 0 0 1-.002 33.941">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="col-2">
                    <a href="#" id="openqr" class="btn btn-outline-primary ">
                        Scan QR
                    </a>
                </div>
                <div class="col-2">
                    <a href="#" id="togglefilter" class="btn btn-outline-primary">
                        Filter
                    </a>
                </div>
                <div class="col-2">
                    <a href="#home" class="btn active" style="color: #6666cc " onclick="myFunction()">
                        <i class="fa fa-bars mx-2" style="color: #6666cc"></i>
                    </a>
                    <div id="searchmenu">
                        <div class="d-grid gap-2 col-8 mx-auto  justify-content-start form-group">
                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist" style="padding: 10px;">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link btn-outline-danger" id="pills-Image_Search-tab"
                                        data-bs-toggle="pill" data-bs-target="#pills-Image_Search" type="button"
                                        role="tab" aria-controls="pills-Image_Search" style="color:red;"
                                        aria-selected="false">Image Search</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row my-2">
                <div class=" @if (count($currency_record) != 0) col-md-8 @else col-md-12 @endif col-12">
                    @if ($alll_searches != null)
                        @foreach ($alll_searches[0] as $key => $extra)
                            @if ($extra != '')
                                <span class="badge bg-primary searchabletag mb-1">
                                    {{-- {{ getAttruibuteValueById($extra)->attribute_value }} --}}
                                    <span class="badge bg-primary">
                                        @if ($loop->iteration == 1 || $loop->iteration == 2)
                                            {{ $key }}:
                                            {{ App\Models\Category::where('id', $extra)->first()->name ?? $extra }}
                                        @else
                                            {{ $key }}: {{ $extra }}
                                        @endif
                                    </span>
                                    <span class="remove-tag" data-color="{{ $extra }}"
                                        title="click to Remove ">x</span>
                                </span>
                            @endif
                        @endforeach
                    @endif

                    @foreach ($additional_attribute as $key => $item)
                        @if (request()->has("searchVal_$key") && !empty(request()->get("searchVal_$key")))
                            @foreach (request()->get("searchVal_$key") as $Color)
                                @php
                                    $name = getAttruibuteValueById($Color)->attribute_value;
                                    // $parent =  getAttruibuteById(getAttruibuteValueById($Color)->parent_id)->name;
                                @endphp
                                <span class="badge bg-primary searchabletag mb-1">
                                    {{-- {{ getAttruibuteValueById($Color)->attribute_value }} --}}
                                    <span class="badge bg-primary">
                                        {{ $name }}
                                    </span>
                                    <span class="remove-tag" data-color="{{ $Color }}"
                                        title="click to Remove {{ $name }}">x</span>
                                </span>
                            @endforeach
                        @endif
                    @endforeach

                </div>
            </div>

            <div class="row">
                {{-- Side Bar --}}
                {{-- main Content Box --}}
                <div class="col-lg-8 col-md-8 col-12 pt-2 mt-sm-0 pt-sm-0">
                    <div class="row align-items-center">
                        <div class="col-3">
                            @if (count($currency_record) != 0)
                                <div class="container" id="selector">
                                    <select class="form-control select_box changeCurrency" id="changeCurrency"
                                        name="Currency" style="width: max-content;">
                                        <option aria-readonly="true" disabled>Currency</option>
                                        @foreach ($currency_record as $item)
                                            <option value="{{ $item->id }}"
                                                @if ($item->id == (Session::get('Currency_id') ?? 'INR')) selected @endif> {{ $item->currency }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>
                        <div class="col-4 ">
                            <div class="container" id="selector">
                                <select class="form-control input-lg select_box" id="productSort" name="sort"
                                    style="width: max-content">
                                    <option @if (request()->get('sort') == 2) selected @endif value="2">Price: low
                                        to high</option>
                                    <option @if (request()->get('sort') == 1) selected @endif value="1">Latest First
                                    </option>
                                    <option @if (request()->get('sort') == 3) selected @endif value="3">Price: high
                                        to low</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 my-2 my-md-0  col-md-3 d-flex justify-content-end ">
                            <div class="d-flex gap-2">
                                <button id="gridview" class="btn btn-outline-primary"><i
                                        class="fas fa-th-large"></i></button>
                                <button id="card" class="btn btn-outline-primary active"> <i
                                        class="fas fa-list"></i></button>
                            </div>
                        </div>
                    </div>


                    @if (isset($proposalid) && $proposalid != -1)
                        @include('frontend.micro-site.proposals.load')
                    @else
                        @include('frontend.micro-site.shop.loadIndex')
                    @endif

                    {{-- <div class="d-flex justify-content-center">
                            {{ $items->appends(request()->query())->links() }}
                        </div> --}}
                    <div class="row my-3">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-outline-primary nextpage">Show More...</button>
                            </div>
                        </div>
                        {{-- <div class="col-4">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('pages.proposal.picked',['proposal' => $proposalid,'user_key' => $user_key]) }}?type=picked" class="btn btn-outline-primary" target="">Next</a>
                                </div>
                            </div> --}}
                    </div>
                </div>


                <div class="col-3">
                    @include('frontend.micro-site.proposals.filter')

                    <div class="image-search my-2">
                        {{-- TODO: Add URL for Image Search form Action --}}
                        <form action="#addUrlForImageSearch" class="d-none" id="submit_image_search">
                            <input type="file" accept="image/*" id="img_for_search" class="d-none">
                            <label for="img_for_search" class="btn btn-outline-danger">
                                Select Image
                            </label>
                        </form>
                    </div>
                </div>

                <!--end col-->
            </div><!--end row-->








        </div><!--end container-->

    </section>
    {{-- Custom Loader --}}
    <div class="lds-roller cloader">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
    {{-- Custom Loader --}}
    <div id="ajax-loading"
        style="display:none;background-color: green; color: white; position: fixed; bottom: 50px; right: 25px;padding: 10px; font-weight: 700; border-radius: 35px;">
        Please Wait...
    </div>
    @include('frontend.micro-site.proposals.collectionbox')
    @include('frontend.micro-site.proposals.modal.scanQR')
    @include('frontend.micro-site.proposals.modal.openoffer')

    {{-- @include('frontend.micro-site.og_proposals.modal.offerexpo') --}}

@endsection

<script src="{{ asset('backend/js/qrcode.js') }}"></script>
@section('InlineScript')
    {{-- @if (isset($proposalid) && $proposalid != -1) --}}
    <script>
        // Collection Script Starts Here

        function togglecollection(e) {
            var ButtonParent = $(e).parent();
            var box = $("#collectionbox1");
            if (box.width() > 0) {
                box.animate({
                    width: '0'
                }, 100);

                ButtonParent.animate({
                    right: '0'
                }, 100);
            } else {
                box.animate({
                    width: '30vw'
                }, 100);
                ButtonParent.animate({
                    right: '29vw'
                }, 200);
            }
        }

        // Loading Existing Images in Collection Box
        $(document).ready(function() {
            var data = localStorage.getItem('collectionboximages');
            if (data != null) {
                var images = data.split(',');
                images.forEach(function(image) {
                    if (image == "") {
                        imgtag =
                            `<div class="">You have not added any product to your collection box</div>`;
                        $("#emptybox").append(imgtag);

                    } else {
                        var imgtag = '<div class="col-3 my-2 text-dark text-center "><img src="' + image +
                            '" class="img-fluid rounded" style="height: 100px;width: 100px;object-fit: contain"><div class="remove-image" class="btn btn-link text-dark text-center " data-img="' +
                            image + '">Remove</div></div>';
                        $("#collectionbox").append(imgtag);
                    }
                });
            } else {
                imgtag =
                    `<div class="col-12" id='emptybox'><div class="">You have not added any product to your collection box</div></div>`;
                $("#emptybox").append(imgtag);
            }
        });

        // Remove Image from Collection Box
        $(document).on('click', '.remove-image', function() {
            var img = $(this).data('img');
            var data = localStorage.getItem('collectionboximages');
            var images = data.split(',');
            var index = images.indexOf(img);

            var data2 = localStorage.getItem('collectionboxItems');
            var items = data2.split(',');

            if (index > -1) {
                console.log(index);
                images.splice(index, 1);
                items.splice(index, 1);
            }

            if (images.length == 0) {
                $("#emptybox").removeClass('d-none');
            }


            localStorage.setItem('collectionboximages', images.join(','));
            localStorage.setItem('collectionboxItems', items.join(','));

            $(this).parent().remove();
        });

        function addtocollection(e) {
            $("#emptybox").addClass('d-none');

            let pid = $(e).data('pid');
            let img = $(e).parent().parent().find('img').attr('src');
            let imgtag = '<div class="col-3 my-2 text-dark text-center "><img src="' + img +
                '" class="img-fluid rounded" style="height: 100px;width: 100px;object-fit: contain"><div data-img="' +
                img + '" class="btn btn-link text-dark text-center  ">Remove</div></div>';

            // Retrieve and handle collectionboxItems
            let collectionItems = localStorage.getItem('collectionboxItems');
            let itemsArray = collectionItems ? collectionItems.split(',') : [];

            console.log(itemsArray, pid);

            if (!itemsArray.includes(pid.toString())) {
                itemsArray.push(pid);
                localStorage.setItem('collectionboxItems', itemsArray.join(','));

                // Handle collectionboximages separately to prevent duplicate checks on images
                let collectionImages = localStorage.getItem('collectionboximages');
                let imagesArray = collectionImages ? collectionImages.split(',') : [];
                imagesArray.push(img); // Assuming you want to add images regardless of PID duplication
                localStorage.setItem('collectionboximages', imagesArray.join(','));

                $("#collectionbox").append(imgtag);
            }
        }


        $(".showalloffer").click(function (e) {
            e.preventDefault();
            let collectionItems = localStorage.getItem('collectionboxItems');
            $("#collection_product_ids").val(collectionItems);
            $("#showalloffer").modal('show');
        });




        // Collection Script Ends Here








        $(document).ready(function() {
            $("#staticBackdrop").modal('show');
        });

        $("#filterBtn").click(function(e) {
            e.preventDefault();
            $("#searchform").submit();
        });

        $("#togglefilter").click(function(e) {
            e.preventDefault();
            $("#adwas").toggleClass('d-none');
        });

        $("#pills-Image_Search-tab").click(function(e) {
            e.preventDefault();
            $("#submit_image_search").toggleClass('d-none');
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var filterBtn = document.getElementById('filterBtn');
            filterBtn.addEventListener('click', function(event) {
                event.preventDefault();
                $('#staticBackdrop').modal('hide');
            });
        });
    </script>
    {{-- @endif --}}

    @if (isset($proposalid) && $proposalid != -1)
        <script>
            let viewarea = "List";
            $(document).ready(function() {
                $(".select2").select2()

                $("#openqr").click(function(e) {
                    e.preventDefault();
                    html5QrcodeScanner.render(onScanSuccess);
                    $("#barCodeModal").modal('show');
                });
            });
            var resultContainer = document.getElementById('qr-reader-results');
            var lastResult, countResults = 0;

            function onScanSuccess(decodedText, decodedResult) {
                var url = decodedText + "&proposalreq={{ $proposal->id }}";
                var slug = "{{ getShopSlugByUserId(auth()->id()) }}";
                $("#myofferproduct").attr('src', url);
                $("#openoffer").modal('show');
                $("#barCodeModal").modal('hide');
            }
            var html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader", {
                    fps: 10,
                    qrbox: 250
                });
            $(document).on('hide.bs.modal', '#barCodeModal', function() {
                html5QrcodeScanner.clear();
            });
        </script>
    @else
        <script>
            // script.js file


            const fileInp = document.getElementById("dosomething");
            const infoText = document.getElementById("infoText");

            function fetchRequest(file, formData) {
                infoText.innerText = "Scanning QR Code...";
                fetch("http://api.qrserver.com/v1/read-qr-code/", {
                    method: 'POST',
                    body: formData
                }).then(res => res.json()).then(result => {
                    result = result[0].symbol[0].data;
                    infoText.innerText = result ? "Upload QR Code to Scan" : "Couldn't scan QR Code";
                    if (!result) return;
                    console.log(result);

                    // Sending Data to Server for Adding Item...


                    let new_formData = new FormData();
                    new_formData.append('result', result);

                    fetch("{{ inject_subdomain('qr-action', $slug, false, false) }}", {
                        method: 'POST',
                        body: new_formData
                    }).then(res2 => res2.json()).then(result2 => {
                        // result2 = result2[0].symbol[0].data;
                        if (!result2) return;
                        console.log(result2);

                        if (result2.title == 'success') {
                            $("#quicktitle").val(result2.model_code);
                            $("#quicktitle").trigger('keyup');
                            $("#barCodeModal").modal("hide")
                        } else {
                            infoText.innerText = "Couldn't scan QR Code. Try Again.";
                        }
                    });




                }).catch(() => {
                    infoText.innerText = "Couldn't scan QR Code";
                });
            }

            fileInp.addEventListener("change", async e => {
                let file = e.target.files[0];
                if (!file) return;
                let formData = new FormData();
                formData.append('file', file);
                fetchRequest(file, formData);
            });




            // var resultContainer = document.getElementById('qr-reader-results');
            // var lastResult, countResults = 0;

            $("#openqr").click(function(e) {
                e.preventDefault();
                // html5QrcodeScanner.render(onScanSuccess,onScanFailure);
                $("#barCodeModal").modal('show');
            });

            // function onScanSuccess(decodedText, decodedResult) {
            //     console.log(`Scan result ${decodedText}`, decodedResult);
            //     // $("#myofferproduct").attr('src', url);
            //     // $("#openoffer").modal('show');
            //     // $("#barCodeModal").modal('hide');
            // }

            // function onScanFailure(error) {
            //     console.error(`Code scan error = ${error}`);
            // }

            // var html5QrcodeScanner = new Html5QrcodeScanner("qr-reader", {fps: 10,qrbox: 250});

            // $(document).on('hide.bs.modal', '#barCodeModal', function() {
            //     html5QrcodeScanner.clear();
            // });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $("#gridview").click();
        });
        // LISt View
        $("#gridview").click(function(e) {
            e.preventDefault();
            // Change Class of Columns
            $(".col-3").addClass("col-4");
            $(".col-3").removeClass("col-3");
            // UnHide Text Below Image
            $(".ashu").removeClass("d-none")
            // Hide Second Colummn
            $(".send").addClass("d-none")
            $(".ashu1").addClass("d-none")
            // Add or remove Active Class
            $(this).addClass('active');
            $("#card").removeClass('active')
            viewarea = "Grid";
        });

        $("#card").click(function(e) {
            e.preventDefault();
            $(".col-4").addClass("col-3");
            $(".col-4").removeClass("col-4");
            $(".send").removeClass("d-none")
            $(".ashu").addClass("d-none")
            $(".ashu1").removeClass("d-none")

            // Add or remove Active Class
            $(this).addClass('active');
            $("#gridview").removeClass('active')
            viewarea = "List";
        });
    </script>
    <script>
        var active_category = "{{ request()->get('category_id') }}";
        var active_sub_category = "{{ request()->get('sub_category_id') }}";
        $('.down_arrow').addClass('d-none');
        $('.filterCategory').on('click', function() {
            if (active_category == $(this).val()) {
                $(this).val(null);
                $(document).find('.filterSubCategory').val(null);
            } else {
                $(document).find('.filterSubCategory').val(null);
            }
            $('.applyFilter').submit();
        });
        $('.filterSubCategory').on('click', function() {
            if (active_sub_category == $(this).val()) {
                $(this).val(null);
            }
            $('.applyFilter').submit();
        });
        $('#productSort').on('change', function() {
            var value = $(this).val();
            $('.sortValue').val(value);
            $('.applyFilter').submit();
        });
        $('.show_mobile_filter').on('click', function() {
            $('.up_arrow').addClass('d-none');
            $('.down_arrow').removeClass('d-none');
            $('.mobile_filter').removeClass('d-none');
        });
        $('.close_mobile_filter').on('click', function() {
            $('.up_arrow').removeClass('d-none');
            $('.down_arrow').addClass('d-none');
            $('.mobile_filter').addClass('d-none');
        });
        @if (isset($proposalid) && $proposalid != -1)
            $('#categoryAll').click(function() {
                url =
                    "{{ route('pages.proposal.edit', ['proposal' => $proposalid, 'user_key' => $user_key]) }}?margin=0";
                window.location.href = url;
            });
        @else
            $('#categoryAll').click(function() {
                url = "{{ route('pages.shop-index') }}";
                window.location.href = url;
            });
        @endif
    </script>
    {{-- jaya --}}
    <script>
        /* Toggle between showing and hiding the navigation menu links when the user clicks on the hamburger menu / bar icon */
        function myFunction() {
            var x = document.getElementById("searchmenu");
            if (x.style.display === "block") {
                x.style.display = "none";
            } else {
                x.style.display = "block";
            }
        }
        document.addEventListener("DOMContentLoaded", function() {
            var x = document.getElementById("searchmenu");
            x.style.display = "none";
        });
    </script>
    <script>
        const triggerEl = document.querySelector('#pills-tab button[data-bs-target="#pills-scan_QR"]')
        // bootstrap.Tab.getInstance(triggerEl).show();
        const triggerE2 = document.querySelector('#pills-tab button[data-bs-target="#pills-Image_Search"]')
        // bootstrap.Tab.getInstance(triggerE2).show();
        const triggerE3 = document.querySelector('#pills-tab button[data-bs-target="#pills-By_Filters"]')
        // bootstrap.Tab.getInstance(triggerE3).show()
    </script>
    {{-- jaya end --}}

    <script>
        $(document).on('click', '#excl', function(e) {
            $(this).attr('checked', false);
            $.confirm({
                title: 'Password!',
                content: '' +
                    '<form action="" class="formName">' +
                    '<div class="form-group">' +
                    '<label>Enter Password for Exlusive</label>' +
                    '<input type="text" placeholder="Your name" class="name form-control" name="password" required />' +
                    '</div>' +
                    '</form>',
                buttons: {
                    formSubmit: {
                        text: 'Submit',
                        btnClass: 'btn-blue',
                        action: function() {
                            var name = this.$content.find('.name').val();
                            if (!name) {
                                $.alert('provide a valid name');
                                return false;
                            }
                            $.ajax({
                                type: "GET",
                                url: "{{ route('pages.proposal.validatepass') }}",
                                data: {
                                    'password': name,
                                },
                                success: function(response) {
                                    if (response['status'] == 'success') {
                                        $("#exclusive").attr('checked', true);
                                        $("#filterBtn").click();
                                    } else {
                                        $("#exclusive").attr('checked', false);
                                        $.alert("Wrong Password");
                                        $("#resetButton").click();
                                    }
                                    // console.log(response['status']);
                                },
                                // error: function (e) {
                                //     console.log(e);
                                // }
                            });
                        }
                    },
                    cancel: function() {
                        //close
                    },
                },
                onContentReady: function() {
                    // bind to events
                    var jc = this;
                    this.$content.find('form').on('submit', function(e) {
                        // if the user submits the form by pressing enter in the field.
                        e.preventDefault();
                        jc.$$formSubmit.trigger('click'); // reference the button and click it
                    });
                }
            });
        });
    </script>
    {{-- Api Group --}}
    <script>
        $('.input-check').click(function() {
            if ($(this).prop('checked')) {
                var route = "{{ route('pages.api.store') }}" + "?product_id=" + $(this).val() + '&proposal_id=' +
                    "{{ $proposalid }}" + "&hike=0";
                console.log(route);
                $.ajax({
                    url: route,
                    method: "get",
                    success: function(res) {
                        $("#itcont").html(res['count']);
                        console.table(res);
                        console.log(url);
                        $('.ashu').css('background-color', 'red');
                    },
                    error: function(res) {
                        console.log(res);
                    }
                });
            } else {
                var route = "{{ route('pages.api.remove') }}" + "?product_id=" + $(this).val() + '&proposal_id=' +
                    "{{ $proposalid }}";
                $.ajax({
                    url: route,
                    method: "get",
                    success: function(res) {
                        $("#itcont").html(res['count']);
                        console.table(res);
                        console.log(url);
                    }
                });
            }
        });

        $('.input-check1').click(function() {
            // console.log("You Cliked Me! 1")
            if ($(this).prop('checked')) {
                var route = "{{ route('pages.api.store') }}" + "?product_id=" + $(this).val() + '&proposal_id=' +
                    "{{ $proposalid }}" + "&hike=0";
                console.log(route);
                $.ajax({
                    url: route,
                    method: "get",
                    success: function(res) {
                        $("#itcont").html(res['count']);
                        console.table(res);
                        console.log(url);
                    }
                });
            } else {
                var route = "{{ route('pages.api.remove') }}" + "?product_id=" + $(this).val() + '&proposal_id=' +
                    "{{ $proposalid }}";
                $.ajax({
                    url: route,
                    method: "get",
                    success: function(res) {
                        $("#itcont").html(res['count']);
                        console.table(res);
                        console.log(url);
                    }
                });
            }

        });
        $('#select-all').click(function() {
            $(document).find('#ajax-loading').show();
            var interval = 10;
            $('.filterable-items').each(function() {
                if (!$(this).hasClass('d-none')) {
                    setTimeout(() => {
                        $(this).find('.input-check').trigger('click');
                    }, interval);
                    interval += 150;
                }
                setTimeout(() => {
                    $(document).find('#ajax-loading').hide();
                }, 5000);
            });
        });

        $('.unSelectAll').click(function() {
            $(document).find('#ajax-loading').show();
            var interval = 10;
            if ($('.input-check').is(':checked')) {
                $('.input-check').prop('checked', false).change();
            } else {
                $('.filterable-items').each(function() {
                    if (!$(this).hasClass('d-none')) {
                        setTimeout(() => {
                            $(this).find('.input-check').trigger('click');
                        }, interval);
                        interval += 150;
                    }
                    setTimeout(() => {
                        $(document).find('#ajax-loading').hide();
                    }, 9000);
                });
            }
        });

        // custom Loder
        window.addEventListener('load', () => {
            const cloader = $(".cloader")
            cloader.addClass('loader-hidden');
        })
        $(document).ready(function() {
            const cloader = $(".cloader")
            cloader.addClass('loader-hidden');
        });
    </script>


    @if (isset($proposalid) && $proposalid != -1)
        {{-- Ajax Scroll Load Proposal --}}
        <script>
            var URL = "{{ route('pages.proposal.edit', ['proposal' => $proposalid, 'user_key' => $user_key]) }}";
            var crr_page = 1;
            var total_page = {{ $items->lastPage() }};
            var contianer = $("#dfjrgd");
            var qsearch = false;
            $(".nextpage").click(function(e) {
                e.preventDefault();
                if (qsearch === false) {
                    if (total_page >= crr_page + 1) {
                        getData(crr_page + 1)
                    } else {
                        $(".nextpage").addClass('d-none')
                    }
                }
            });

            function getData(pages) {
                $.ajax({
                    type: "get",
                    url: URL,
                    data: {
                        'page': pages,
                    },
                    success: function(response) {
                        $(".dfjrgd").append(response);
                        crr_page++;
                        if (viewarea == 'List') {
                            $("#card").click()
                        } else {
                            $("#gridview").click();
                        }

                        // Code Start
                        $('.input-check').click(function() {
                            //
                            if ($(this).prop('checked')) {
                                var route = "{{ route('pages.api.store') }}" + "?product_id=" + $(this)
                                    .val() + '&proposal_id=' + "{{ $proposalid }}" + "&hike=0";
                                console.log(route);
                                $.ajax({
                                    url: route,
                                    method: "get",
                                    success: function(res) {
                                        $("#itcont").html(res['count']);
                                        // console.table(res);
                                        // console.log(url);
                                    },
                                    error: function(res) {
                                        // console.log(res);
                                    }
                                });
                            } else {
                                var route = "{{ route('pages.api.remove') }}" + "?product_id=" + $(this)
                                    .val() + '&proposal_id=' + "{{ $proposalid }}";
                                $.ajax({
                                    url: route,
                                    method: "get",
                                    success: function(res) {
                                        $("#itcont").html(res['count']);
                                        // console.table(res);
                                        // console.log(url);
                                    }
                                });
                            }
                        });
                        $('#select-all').click(function() {
                            $(document).find('#ajax-loading').show();
                            var interval = 10;
                            $('.filterable-items').each(function() {
                                if (!$(this).hasClass('d-none')) {
                                    setTimeout(() => {
                                        $(this).find('.input-check').trigger('click');
                                    }, interval);
                                    interval += 150;
                                }
                                setTimeout(() => {
                                    $(document).find('#ajax-loading').hide();
                                }, 5000);
                            });
                        });
                        // Code End
                    }
                });
            }

            // ! OnKey Up Load Ajax...
            $("#quicktitle").keyup(function(e) {
                let thisval = this.value;
                if (thisval == '') {
                    qsearch = false;
                    $(".nextpage").removeClass('d-none')
                    crr_page = 1;
                } else {
                    qsearch = true;
                    $(".nextpage").addClass('d-none')
                }
                $.ajax({
                    type: "get",
                    url: URL,
                    data: {
                        'title': this.value,
                        'model_code': this.value,
                        'exclusive': "{{ request()->get('exclusive') ?? 'off' }}",
                    },
                    success: function(response) {
                        $(".dfjrgd").empty().html(response);
                        if (viewarea == 'List') {
                            $("#card").click()
                        } else {
                            $("#gridview").click();
                        }
                        // Code Start
                        $('.input-check').click(function() {
                            if ($(this).prop('checked')) {
                                var route = "{{ route('pages.api.store') }}" + "?product_id=" + $(
                                        this).val() + '&proposal_id=' + "{{ $proposalid }}" +
                                    "&hike=0";
                                console.log(route);
                                $.ajax({
                                    url: route,
                                    method: "get",
                                    success: function(res) {
                                        $("#itcont").html(res['count']);
                                        // console.table(res);
                                        // console.log(url);
                                    },
                                    error: function(res) {
                                        // console.log(res);
                                    }
                                });
                            } else {
                                var route = "{{ route('pages.api.remove') }}" + "?product_id=" + $(
                                    this).val() + '&proposal_id=' + "{{ $proposalid }}";
                                $.ajax({
                                    url: route,
                                    method: "get",
                                    success: function(res) {
                                        $("#itcont").html(res['count']);
                                        // console.table(res);
                                        // console.log(url);
                                    }
                                });
                            }
                        });

                        $('#select-all').click(function() {
                            $(document).find('#ajax-loading').show();
                            var interval = 10;
                            $('.filterable-items').each(function() {
                                if (!$(this).hasClass('d-none')) {
                                    setTimeout(() => {
                                        $(this).find('.input-check').trigger(
                                            'click');
                                    }, interval);
                                    interval += 150;
                                }
                                setTimeout(() => {
                                    $(document).find('#ajax-loading').hide();
                                }, 5000);
                            });
                        });
                        // Code End
                    }
                });

            });
        </script>
    @else
        {{-- Ajax Load --}}
        <script>
            var URL = "{{ url('/') }}/shop";
            var crr_page = 1;
            var total_page = {{ $items->lastPage() }};
            var contianer = $("#dfjrgd");
            var qsearch = false;
            $(".nextpage").click(function(e) {
                e.preventDefault();
                if (qsearch === false) {
                    if (total_page >= crr_page + 1) {
                        getData(crr_page + 1)
                    } else {
                        $(".nextpage").addClass('d-none')
                    }
                }
            });

            function getData(pages) {
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                $.ajax({
                    type: "get",
                    url: URL,
                    data: {
                        'page': pages,
                        'title': urlParams.get('title'),
                        // ! Uncomment this to Enable search by Curren Filters/
                        // 'model_code': urlParams.get('model_code'),
                        // 'category_id': urlParams.get('category_id'),
                        // 'sub_category_id': urlParams.get('sub_category_id'),
                        // 'brand': urlParams.get('brand'),
                        // 'from': urlParams.get('from'),
                        // 'to': urlParams.get('to'),
                        // 'exclusive': urlParams.get('exclusive') ?? 'off',
                        @if (isset($additional_attribute) && $additional_attribute->count() >= 0)
                            @foreach ($additional_attribute as $key => $item)
                                'searchVal_{{ $key }}': urlParams.getAll("searchVal_{{ $key }}[]"),
                            @endforeach
                        @endif
                    },
                    success: function(response) {
                        $(".dfjrgd").append(response);
                        crr_page++;
                        if (viewarea == 'List') {
                            $("#card").click()
                        } else {
                            $("#gridview").click();
                        }
                    }
                });
            }
            // ! OnKey Up Load Ajax...
            $("#quicktitle").keyup(function(e) {
                const queryString = window.location.search;
                const urlParams = new URLSearchParams(queryString);
                let thisval = this.value;
                if (thisval == '') {
                    qsearch = false;
                    $(".nextpage").removeClass('d-none')
                    crr_page = 1;
                } else {
                    qsearch = true;
                    $(".nextpage").addClass('d-none')
                }
                $.ajax({
                    type: "get",
                    url: URL,
                    data: {
                        'title': this.value,
                        'model_code': this.value,
                        // 'exclusive': urlParams.get('exclusive') ?? 'off',
                        // 'category_id': urlParams.get('category_id'),
                        // 'sub_category_id': urlParams.get('sub_category_id'),
                        // 'brand': urlParams.get('brand'),
                        // 'from': urlParams.get('from'),
                        // 'to': urlParams.get('to'),
                        @if (isset($additional_attribute) && $additional_attribute->count() >= 0)
                            @foreach ($additional_attribute as $key => $item)
                                'searchVal_{{ $key }}': urlParams.getAll(
                                    "searchVal_{{ $key }}[]"),
                            @endforeach
                        @endif
                    },
                    success: function(response) {
                        $(".dfjrgd").empty().html(response);
                        if (viewarea == 'List') {
                            $("#card").click()
                        } else {
                            $("#gridview").click();
                        }
                    }
                });

            });
        </script>
    @endif


    <script>
        $(document).ready(function() {
            //  Add a click event handler to all the remove-tag elements
            $(".remove-tag").click(function() {
                // Get the color value associated with the tag
                var color = $(this).data("color");
                var filterdata = $(`input[value=${color}]`)
                if (filterdata.attr('type') == 'text' || filterdata.attr('type') == 'number') {
                    filterdata.val('');
                }
                $(this).parent().remove();
                filterdata.click()
                $("#searchform").submit()
            });
        });
    </script>

    <script>
        $(".makeoffer").click(function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            // var msg = "<input type='text' id='margin' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Name'> <br> <input type='text' id='offeremail' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Email (Optional)'> <br> <input type='number' maxlength='10' id='offerphone' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Phone (Optional)'>";
            var msg =
                "<input type='text' id='margin' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Buyer Name'> <br> <input type='text' id='alias' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Alias (optional)'> <br> <input type='text' id='offeremail' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Email (Optional)'> <br> <input type='number' maxlength='10' id='offerphone' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Phone (Optional)'>";

            $.confirm({
                draggable: true,
                title: 'Offer for',
                content: msg,
                type: 'blue',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: 'Next',
                        btnClass: 'btn-primary',
                        action: function() {
                            let margin = $('#margin').val();
                            let offeremail = $('#offeremail').val();
                            let offerphone = $('#offerphone').val();
                            let alias = $('#alias').val();
                            let personname = $('#offerpersonname').val();
                            if (!margin) {
                                $.alert('provide a valid name');
                                return false;
                            }
                            url = url + "&offerfor=" + margin + "&offerphone=" + offerphone +
                                "&offeremail=" + offeremail + "&offeralias=" + alias +
                                "&offerpersonname=" + personname;
                            window.location.href = url;
                            // console.log(url);
                        }
                    },
                    close: function() {}
                }
            });
        });
        // confirm
    </script>
    <script>
        function addToSelected(option) {
            var selectedItemsContainer = document.getElementById('selectedItemsContainer');
            var selectedItems = selectedItemsContainer.innerHTML;
            selectedItems += '<div>' + option + '</div>';
            selectedItemsContainer.innerHTML = selectedItems;
        }
    </script>
@endsection
