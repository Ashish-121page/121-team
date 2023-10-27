@extends('frontend.layouts.main')

@section('meta_data')
    @php
		$meta_title = 'Search | '.getSetting('app_name');		
		$meta_description = '' ?? getSetting('seo_meta_description');
		$meta_keywords = '' ?? getSetting('seo_meta_keywords');
		$meta_motto = '' ?? getSetting('site_motto');		
		$meta_abstract = '' ?? getSetting('site_motto');		
		$meta_author_name = '' ?? 'GRPL';		
		$meta_author_email = '' ?? 'Hello@121.page';		
		$meta_reply_to = '' ?? getSetting('frontend_footer_email');		
		$meta_img = ' ';
        $website = 1;			
        $user_name = auth()->user()->name ?? "";
        $user_phone = auth()->user()->phone ?? "";
	@endphp
@endsection

@section('content')
<link rel="stylesheet" href="https://121.page/backend/plugins/jquery-toast-plugin/dist/jquery.toast.min.css">
<link href="https://fonts.googleapis.com/css?family=Source+Code+Pro:400,500" rel="stylesheet">

<style>
    .card {
        /* width: 25%; */
        background-color: rgb(255, 255, 255);
        /* height:400px; */
        border-radius: 10px;
        margin: 10px;
    }

    .cardbody {
        color: #111;
    }

    .phone {
        height: 23px;
        border: 0;
        border-radius: 0;
        margin: 0 5px;
        border-bottom: 1px solid;
        outline: none;
        width: 70px;
        text-align: center;
    }

    .phone::placeholder {
        text-align: center
    }

    /* .cardbody span{
        display: block;
    }
    .head span{
        margin: 2px 0;
    } */
    #blur {
        color: transparent;
        text-shadow: 0 0 8px #000;
        user-select: none;
    }


    p {
        margin-top: 30px;
    }

    .cntr {
        display: table;
        width: 100%;
        height: 100%;
    }

    .cntr .cntr-innr {
        display: table-cell;
        text-align: center;
        vertical-align: middle;
    }

    .search {
        display: inline-block;
        position: relative;
        height: 35px;
        width: 35px;
        /* width: fit-content; */
        box-sizing: border-box;
        margin: 0px 8px 7px 0px;
        padding: 7px 9px 0px 9px;
        border: 3px solid #000000;
        border-radius: 25px;
        transition: all 200ms ease;
        cursor: text;
    }

    .search:after {
        content: "";
        position: absolute;
        width: 3px;
        height: 20px;
        right: -5px;
        top: 21px;
        background: #000000;
        border-radius: 3px;
        transform: rotate(-45deg);
        transition: all 200ms ease;
    }

    .search.active,
    .search:hover {
        width: 400px;
        margin-right: 0px;
    }

    .search.active:after,
    .search:hover:after {
        height: 0px;
    }

    
    .search input {
        width: 100%;
        border: none;
        box-sizing: border-box;
        font-family: Helvetica;
        font-size: 15px;
        color: inherit;
        background: transparent;
        outline-width: 0px;
    }
    
    #inpt_search::focus {
        width: 100%;
    }
    #inpt_search::placeholder{
        padding-bottom: 32px !important;
    }
</style>

        @php
            $page_title = "Search";
        @endphp
        @include('frontend.website.breadcrumb')


    <div class="container-fluid border my-5">
    
        {{-- <form class="d-flex justify-content-center" action="{{ route('home.search') }}" method="GET">
            <input type="text" placeholder="Search By Name, Phone , Email , Company" value="{{ $searchQuery ?? "" }}" class="form-control w-75" name="searchquery" />
            <button class="btn btn-outline-primary mx-2">Search</button>
        </form> --}}
        <div class="cntr" id="cntr">
            <div class="cntr-innr">
                <form action="{{ route('home.search') }}">
                    <label class="search" for="inpt_search">
                        <input id="inpt_search" type="text" name="searchquery" value="{{ $searchQuery }}" placeholder="Search by any of person Name, Phone, Company" autocomplete="off" minlength="3"/>
                    </label>
                    {{-- <br> --}}
                    <button class="btn btn-outline-primary mx-2 btn-sm">Submit</button>
                </form>
                {{-- <p>Hover to see the magic.</p> --}}
            </div>
        </div>

        <section class="mt-3">
            <div class="cardbx">
                <div class="row">

                    @forelse ($data as $item)
                        <div class="col-12 col-md-3 col-sm-6">
                            <div class="card">
                                <div class="cardbody">
                                    <div class="head d-flex justify-content-between">
                                        <div class="p-2">

                                            @php
                                                $sentence1 = $item->name;
                                                $word1 = explode(" ",$searchQuery);
                                                $resid1 = Str::containsAll($sentence1, [$word1]) ? '' : 'blur';

                                                $sentence1 = $item->last_name;
                                                $word1 = explode(" ",$searchQuery);
                                                $resid_last_name = Str::containsAll($sentence1, [$word1]) ? '' : 'blur';
                                            @endphp

                                            <span id="{{ $resid1 }}">
                                            @if ($resid1)
                                                Masked
                                            @else
                                                {{ $item->name ?? ""}}
                                            @endif
                                            </span>

                                            @if ($item->last_name != null && $item->last_name != null)
                                                <span id="{{ $resid_last_name }}">
                                                    @if ($resid_last_name)
                                                    Masked
                                                    @else
                                                    {{ $item->last_name ?? ""}}
                                                    @endif
                                                </span>
                                            @endif
                                            <i class="uil-info-circle" title="On 121, work with your known supplier. No discovery of new suppliers."></i>
                                        </div>

                                        <div class="d-flex flex-column p-2 text-end">
                                            @php
                                                $sentence = $item->entity_name;
                                                $word = explode(" ",$searchQuery);
                                                $resid = Str::containsAll($sentence, [$word]) ? '' : 'blur';

                                                $sentence = $item->entity_name_middle;
                                                $resid_entity_name_middle = Str::containsAll($sentence, [$word]) ? '' : 'blur';

                                                $sentence = $item->entity_name_last;
                                                $resid_entity_name_last = Str::containsAll($sentence, [$word]) ? '' : 'blur';
                                            @endphp


                                            <span id="{{ $resid }}">
                                                @if ($resid)
                                                    Masked
                                                @else
                                                    {{ $item->entity_name ?? ""}}
                                                @endif
                                            </span>

                                            @if ($item->entity_name_middle != "" && $item->entity_name_middle != null)
                                                <span id="{{ $resid_entity_name_middle }}">
                                                    @if ($resid_entity_name_middle)
                                                    Masked
                                                    @else
                                                    {{ $item->entity_name_middle ?? ""}}
                                                    @endif
                                                </span>
                                            @endif
                                            
                                            @if ($item->entity_name_last != "" && $item->entity_name_last != null)
                                                <span id="{{ $resid_entity_name_last }}">
                                                    @if ($resid_entity_name_last)
                                                    Masked
                                                    @else
                                                    {{ $item->entity_name_last ?? ""}}
                                                    @endif
                                                </span>
                                            @endif
                                            

                                            <span>{{ $item->state ?? ""}}</span>
                                        </div>
                                    </div>
            
                                    <div class="cardbody p-2">
                                        <div class="d-flex flex-column">
                                            <span><b>Verify Number</b></span>
                                            <input type="hidden" name="user_id" id="user_id" value="{{ $item->id }}">
                                            <div class="passcode d-flex gap-1 align-items-center justify-content-center mt-2">
                                                <code style="font-size: 1rem;margin-right: 5px">{{ substr($item->phone_primary,0,4) ?? "0000" }}</code>
                                                <span>XX</span>
                                                <input type="tel" id="phone" class="form-control" placeholder="XXXX" maxlength="4" minlength="4">
                                                <button class="btn @if ($user_name == '') btn-outline-secondary @else btn-outline-primary  @endif btn-sm chkpassds" type="button" id="chkpassds"  @if ($user_name == '') disabled @endif value="{{ $item->id }}">Invite/Request</button>
                                            </div>

                                            <div class="collapse" id="collapseExample">
                                                @if ($item->phone_2 != null && $item->phone_2 != '')
                                                    <div class="passcode d-flex gap-1 align-items-center justify-content-center mt-2">
                                                        <code style="font-size: 1rem;margin-right: 5px">{{ substr($item->phone_2,0,4) ?? "0000" }}</code>
                                                        <span>XX</span>
                                                        <input type="tel" id="phone_2" class="form-control" placeholder="XXXX" maxlength="4" minlength="4">
                                                        <button class="btn @if ($user_name == '') btn-outline-secondary @else btn-outline-primary  @endif btn-sm chkpassds" type="button" id="chkpassds"  @if ($user_name == '') disabled @endif value="{{ $item->id }}">Invite/Request</button>
                                                    </div>
                                                @endif

                                                @if ($item->phone_3 != null && $item->phone_3 != '')
                                                    <div class="passcode d-flex gap-1 align-items-center justify-content-center mt-2">
                                                        <code style="font-size: 1rem;margin-right: 5px">{{ substr($item->phone_3,0,4) ?? "0000" }}</code>
                                                        <span>XX</span>
                                                        <input type="tel" id="phone_3" class="form-control" placeholder="XXXX" maxlength="4" minlength="4">
                                                        <button class="btn @if ($user_name == '') btn-outline-secondary @else btn-outline-primary  @endif btn-sm chkpassds" type="button" id="chkpassds"  @if ($user_name == '') disabled @endif value="{{ $item->id }}">Invite/Request</button>
                                                    </div>
                                                @endif

                                                @if ($item->phone_4 != null && $item->phone_4 != '')
                                                    <div class="passcode d-flex gap-1 align-items-center justify-content-center mt-2">
                                                        <code style="font-size: 1rem;margin-right: 5px">{{ substr($item->phone_4,0,4) ?? "0000" }}</code>
                                                        <span>XX</span>
                                                        <input type="tel" id="phone_4" class="form-control" placeholder="XXXX" maxlength="4" minlength="4">
                                                        <button class="btn @if ($user_name == '') btn-outline-secondary @else btn-outline-primary  @endif btn-sm chkpassds" type="button" id="chkpassds"  @if ($user_name == '') disabled @endif value="{{ $item->id }}">Invite/Request</button>
                                                    </div>
                                                @endif
                                                
                                            </div>
                                        </div>
                                    </div>
            
            
                                    <div class="foot d-flex align-items-center justify-content-between mt-2 p-2">
                                        <div class="">
                                            <input type="checkbox" id="tnc" class="form-check-input" checked>
                                            {{-- <label for="tnc" class="form-check-label"> --}}
                                                <a href="{{ url('page/terms') }}" class="text-secondary">T&C</a>
                                            {{-- </label> --}}
                                        </div>
                                        @if ($item->phone_2 != null || $item->phone_3 != null || $item->phone_4 != null)
                                            <a class="btn btn-link" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                                                Show More
                                            </a>
                                        @endif
                                        {{-- <div class="">
                                            <button class="btn btn-link btn-sm p-2" type="button" title="">Preview Request</button>
                                        </div> --}}
                                    </div>
            
            
                                </div>
                            </div>
                        </div>    

                    @empty  
                        <div class="col-12 col-md-12 col-sm-12 text-center">
                            <span>Type To Search !!</span>
                        </div>
                    @endforelse

                    
                </div>

            </div>
        </section>

        
    </div>
@if (isset($searchQuery) && $searchQuery != null)

   @include('frontend.website.search.modal.invite')

@endif
    
@endsection
@push('script')
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        if ($("#inpt_search").val() != '') {
            $(".search").css("width",'400px')
        }


        $(".chkpassds").click(function (e) { 
            e.preventDefault();
            var msg = $(this).data('msg') ?? 'Please Send your catalogue with 121.Page to work together.<br> Rgds, <br> {{ substr($user_name,0,10) ?? "" }}... {{ substr($user_phone,0,6) ?? "" }}xxxx';

            var code = $("#phone").val()
            var code2 = $("#phone_2").val()
            var code3 = $("#phone_3").val()
            var code4 = $("#phone_4").val()
            
            var user_id = $("#user_id").val();
            var csrf = "{{ csrf_token() }}";
            $.confirm({
                draggable: true,
                title: 'SMS and Whatsapp request!',
                content: msg,
                type: 'red',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: 'Send',
                        btnClass: 'btn-primary',
                        action: function(){
                            $.ajax({
                                type: "POST",
                                url: "{{route('home.searchreq')}}",
                                data: {
                                    "_token": csrf,
                                    "passcode": code,
                                    "ask_id": user_id,
                                    "passcode_2": code2,
                                    "passcode_3": code3,
                                    "passcode_4": code4,
                                },
                                success: function (response) {
                                    $.toast({
                                        heading: response['status'],
                                        text: response['msg'],
                                        showHideTransition: 'slide',
                                        icon: response['alert'],
                                        loaderBg: response['color'],
                                        position: 'top-right'
                                    });    
                                }
                            });
                        }
                    },
                    cancel: function () {
                        // Closed The Menu
                        
                    }
                }
            });
        });
    });



            
    function chackpass(e) { 
            console.log($("#phone-1").val());
            console.log($("#phone-2").val());
            console.log($("#phone-3").val());
            console.log($("#phone-4").val());
            console.log(e.dataset.type);


        }

</script>

@if ($user_name == "")    
    <script>        
        $(document).ready(function () {
            $.confirm({
            title: 'Please login to access!',
            content: '',
            buttons: {
                login: function () {
                    location.href = "{{ route('auth.login-index') }}"
                },
                cancel: function () {
                    // $.alert('Canceled!');
                }
            }
        });
        });
    </script>
@endif

@endpush