@extends('backend.layouts.main')
@section('title', 'Image Studio')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/dropzone.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.js"></script>


        @if (!request()->has('refer'))
            <style>
                .main-content {
                    padding-top: 0 !important;
                    margin-top: 0px !important;
                }

                .header-top {
                    display: none !important;
                }
            </style>
        @endif

        <style>

            .logged-in-as {
                display: none !important;
            }


            .main-container {
                overflow: hidden;
            }

            .bg-container {
                position: absolute;
                z-index: 9999;
                background-color: #fff;
                padding: 10px;
                border-radius: 5px;
                box-shadow: 0 0 5px #000;
                left: 2%;
                top: 100%;
            }

            .pill-action {
                height: 30px;
                width: 100px;
                border-radius: 50px;
                border: 1px solid #6666cc;
                background-color: #fff;
                color: #000;
                font-size: 12px;
                font-weight: 600;
                padding: 0;
                margin: 5px;
                transition: all 0.3s ease;
            }

            .pill-action:focus {
                outline: none;
            }

            .pill-action.active {
                background-color: #6666cc;
                color: #fff;
                border: none;
            }

            .pill-action:active {
                transform: scale(0.9);
                background-color: #6666cc;
                color: #fff;
                border: none;
            }

            .pill-action:hover {
                background-color: #6666cc;
                color: #fff;
                border: none;
            }

            .bgimage-btn,
            .bgcolor-btn,
            #customimg-bg {
                height: 4.5rem;
                width: 4.5rem;
                border-radius: 10px;
                /* border: 1px solid #6666cc; */
                border: none;
                background-color: #fff;
                color: #000;
                font-size: 12px;
                font-weight: 600;
                padding: 0;
                margin: 5px;
                transition: all 0.3s ease;
            }

            .bgcolor-btn {
                height: 2.5rem;
                width: 2.5rem;
                border: 1px solid #6666cc;
            }

            #customimg-bg {
                font-size: 3rem;
                color: #6666cc;
                font-weight: 400;
                display: flex;
                align-items: center;
                cursor: pointer;
                justify-content: center;
            }

            .tranparent-bg,
            #customimg-bg,
            #customcolor-bg {
                border: 1px solid #6666cc !important;
            }

            .changecolorbtn {
                border: none;
            }

            #customcolor-bg label {
                height: 100%;
                width: 100%;
                border-radius: 10px;
                border: none;
                outline: none;
                background: conic-gradient(from 0deg at 50% 50%, red, yellow, lime, aqua, blue, magenta, red);
            }

            #customcolor-bg input {
                display: none;
            }

            button img {
                height: 100%;
                width: 100%;
                object-fit: cover;
                border-radius: 10px;
            }

            .pill-v-btn {
                height: 100%;
                width: 100%;
                border-radius: 0;
                border: none;
                background-color: #fff;
                color: #000;
                font-size: 1.2rem;
                font-weight: 600;
                padding: 5px;
                transition: all 0.3s ease;
            }

            .pill-v-btn:focus {
                outline: none;
            }

            .pill-v-btn.active {
                background-color: #6666cc;
                color: #fff;
                border: none;
            }

            .pill-v-btn:active {
                transform: scale(0.8);
                background-color: #6666cc;
                color: #fff;
                border: none;
            }

            .pill-v-btn:hover {
                background-color: #6666cc;
                color: #fff;
                border: none;
            }

            #rembgCanvas {
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
            }
        </style>
    @endpush


    <div class="main-container">
        <div class="row">

            <div class="col-12 d-flex align-items-center justify-content-around flex-wrap  mb-3" style="height: 50px; background-color:#e4e4e4;">
                <a href="" id="back98" class="btn btn-outline-primary ">
                    Back
                </a>
                <div style="padding-left: 50px;">
                    <span class="filename" data-oldname="{{ basename($file_path) }}">
                        {{ basename($file_path) }}
                    </span>
                </div>
                <div class=" d-flex align-items-center justify-content-between mx-3">
                    <input type="checkbox" id="keepnamecheck" checked>
                    <label for="keepnamecheck" class="m-0 p-0 mx-2">Keep Original File</label>
                </div>
            </div>


            <div class="col-12 col-md-12">
                <div class="row">

                    {{-- ` Main Preivew Area --}}
                    <div class="col-lg-6 col-md-12" style="border: 1px">
                        <div class="bgc" style="height: 100%;width: 100%;padding-left: 50px;">

                            <div class="row" style="position: relative; width: 100%;">
                                <div class="col-lg-12 col-md-12 mt-5 mb-5" style="height: min-content;width: min-content;">

                                    {{-- <span class="filename" data-oldname="{{ basename($file_path) }}">
                                        {{ basename($file_path) }}
                                    </span> --}}
                                    <div class="previewedit" style="height: 50% !important;width: 48%;">
                                        <img src="{{ asset(Storage::url($file_path)) }}" alt="Preview Image"
                                            style="height: 100%;width: 100%;object-fit: contain;" class="img-fluid"
                                            id="editpreviewimage">


                                        <img src="" alt="" id="RemovedBackgroundimage" class="d-none">

                                        <div class="changebgcontainer d-none"
                                            style="height: 100%;width: 100%">
                                            <canvas id="changebgCanvas"></canvas>
                                        </div>

                                        <div class="cropcontain d-none" style="height: 50vh;width: 50vw">
                                            <canvas id="croppedCanvas"></canvas>
                                        </div>

                                        <div class="filtercontainer d-none" style="height: 50vh;width: 50vw">
                                            <canvas id="canvasfilter"></canvas>
                                        </div>

                                        <div class="Backgroudcontainer d-none" style="height: 50vh;width: 50vw">
                                            <canvas id="rembgCanvas"></canvas>
                                        </div>

                                        <div class="anotatecontainer d-none" style="height: 50vh;width: 50vw">
                                            <canvas id="anotateCanvas"></canvas>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 col-md-12 d-flex justify-content-start mt-5"
                                    style="position: absolute;bottom: -27%;right: -82%; padding-bottom: 15px;">
                                    <div class="previewedit" style="width: 20vh">
                                        <div class="button-container"
                                            style="background-color: black; display: flex; justify-content: center; align-items: center; height: 100%;border-radius:5px;padding: 10px;width: fit-content;">
                                            <button id="downloadimage" class="btn btn-primary" style="display: block; ">
                                                Save Image
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-12  d-flex justify-content-start mb-5"
                                    style="position: absolute;bottom: -53%;right: -83%">

                                    <div class="previewedit" style="width: 15vh; height:25vh;">

                                        <img src="{{ asset(Storage::url($file_path)) }}" alt="Preview Image"
                                            style="height: 100%;width: 100%;object-fit: contain"
                                            class="img-fluid rounded">
                                    </div>
                                </div> --}}
                            </div>
                            <div class="row" style="position: relative; width: 100%;">
                                {{-- original --}}

                                {{-- new and changed --}}
                                <div class="col-12  d-flex justify-content-start mb-5"
                                    style="position: absolute;bottom:-53%;right: -83%">

                                    <div class="previewedit" style="width: 15vh; height:25vh;">
                                        {{-- <div><p class="text-center mt-5">Original</p></div> --}}
                                        <img src="{{ asset(Storage::url($file_path)) }}" alt="Preview Image"
                                            style="height: 100%;width: 100%;object-fit: contain" class="img-fluid rounded">
                                    </div>
                                </div>


                            </div>
                        </div>


                    </div>

                    {{-- 2nd col --}}
                    <div class="col-2" style="background-color: white; height: 100vh;">
                        <div class="col-12 d-flex flex-column" style="">
                            <div class="d-flex flex-column" style="width: max-content;">
                                {{-- <button id="removebg" class="btn btn-outline-primary mt-2" style="display: block; margin-bottom: 10px;">
                                    Erase Background
                                </button> --}}
                                {{-- <button id="addbg" class="btn btn-outline-primary mt-3 my-3" style="display: block; margin-bottom: 10px;">
                                    + Add Background
                                </button> --}}





                                {{-- <button class="btn btn-primary mx-1 undo">
                                    Undo
                                </button>

                                <button class="btn btn-primary mx-1 redo">
                                    Redo
                                </button> --}}

                                <div class="bg-container d-none">

                                </div>




                            </div>
                        </div>
                        {{-- options for erasing adding background etc --}}
                        <div class="col-lg-10 col-md-12 col-sm-12">
                            <ul class="nav nav-pills mb-3 d-flex flex-column" id="pills-tab" role="tablist">
                                <li class="nav-item my-3" role="presentation">
                                    <button id="pills-removebg-tab" class="pill-v-btn" data-bs-toggle="pill"
                                        style="font-size: 0.75rem;display: flex; align-items: center;"
                                        data-bs-target="#pills-removebg" type="button" role="tab"
                                        aria-controls="pills-removebg">
                                        {{-- <svg width="16" height="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="margin-right:5px;">
                                            <path fill="currentColor" d="M3.464 3.464C2 4.93 2 7.286 2 12c0 4.714 0 7.071 1.464 8.535C4.93 22 7.286 22 12 22c4.714 0 7.071 0 8.535-1.465C22 19.072 22 16.714 22 12s0-7.071-1.465-8.536C19.072 2 16.714 2 12 2S4.929 2 3.464 3.464" opacity=".5"/>
                                            <path fill="currentColor" d="m8.988 10.289l4.723 4.723l2.619-2.618c1.113-1.114 1.67-1.67 1.67-2.362c0-.692-.557-1.249-1.67-2.362S14.66 6 13.968 6c-.692 0-1.248.557-2.362 1.67zm3.406 6.041l.257-.257l-4.724-4.724l-.257.257C6.557 12.72 6 13.276 6 13.968c0 .692.557 1.249 1.67 2.362S9.34 18 10.032 18c.692 0 1.248-.557 2.362-1.67"/>
                                        </svg>
                                         --}}
                                        <svg width="16" height="16" viewBox="0 0 48 48"
                                            xmlns="http://www.w3.org/2000/svg" style="margin-right:5px;">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M40.5 5.5h-33a2 2 0 0 0-2 2v33a2 2 0 0 0 2 2h33a2 2 0 0 0 2-2v-33a2 2 0 0 0-2-2" />
                                            <circle cx="24" cy="24" r="15" fill="white"
                                                stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        Erase Background
                                    </button>
                                </li>

                                <li class="nav-item my-3" role="presentation">
                                    <button id="pills-addbg-tab" class="pill-v-btn" data-bs-toggle="pill"
                                        style="font-size: 0.75rem; display: flex; align-items: center;"
                                        data-bs-target="#pills-addbg" type="button" role="tab"
                                        aria-controls="pills-addbg">
                                        <svg width="16" height="16" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg" style="margin-right:5px;">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2" d="M6 12h6m0 0h6m-6 0v6m0-6V6" />
                                        </svg>
                                        Add Background
                                    </button>
                                </li>
                                {{-- original content --}}
                                <li class="nav-item my-3 d-none" role="presentation">
                                    <button class="pill-v-btn" id="pills-contact-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-contact" type="button" role="tab"
                                        aria-controls="pills-contact" aria-selected="false"
                                        style="font-size: 0.75rem; display: flex; align-items: center;">
                                        <svg width="16" height="12" viewBox="0 0 8 8"
                                            xmlns="http://www.w3.org/2000/svg" style="margin-right: 15px;">
                                            <path fill="currentColor"
                                                d="M0 0v2h.5c0-.55.45-1 1-1H3v5.5c0 .28-.22.5-.5.5H2v1h4V7h-.5c-.28 0-.5-.22-.5-.5V1h1.5c.55 0 1 .45 1 1H8V0z" />
                                        </svg>
                                        Add Text
                                    </button>

                                </li>

                                <li class="nav-item my-3 d-none" role="presentation">
                                    <button class="pill-v-btn " id="pills-cropbtn" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab"
                                        aria-controls="pills-home" aria-selected="true"
                                        style="font-size: 0.75rem;display: flex; align-items: center;">
                                        <svg width="16" height="16" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg" style="margin-right: 15px;">
                                            <path fill="currentColor"
                                                d="M19 9V5h-4V3h6v6zM3 21v-6h2v4h4v2zm0-8v-2h2v2zm0-4V7h2v2zm0-4V3h2v2zm4 0V3h2v2zm4 16v-2h2v2zm0-16V3h2v2zm4 16v-2h2v2zm4 0v-2h2v2zm0-4v-2h2v2zm0-4v-2h2v2z" />
                                        </svg>
                                        Resize
                                    </button>
                                </li>

                                <li class="nav-item my-3 d-none" role="presentation">
                                    <button id="pills-profile-tab" class="pill-v-btn" data-bs-toggle="pill"
                                        style="font-size: 0.75rem;display: flex; align-items: center;"
                                        data-bs-target="#pills-profile" type="button" role="tab"
                                        aria-controls="pills-profile">
                                        <svg width="16" height="16" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg" style="margin-right: 15px;">
                                            <path fill="currentColor" d="M18 8A6 6 0 1 1 6 8a6 6 0 0 1 12 0" />
                                            <path fill="currentColor"
                                                d="M13.58 13.79a6.002 6.002 0 0 1-7.16-3.58a6 6 0 1 0 7.16 3.58"
                                                opacity=".7" />
                                            <path fill="currentColor"
                                                d="M13.58 13.79c.271.684.42 1.43.42 2.21a5.985 5.985 0 0 1-2 4.472a6 6 0 1 0 5.58-10.262a6.014 6.014 0 0 1-4 3.58"
                                                opacity=".4" />
                                        </svg>
                                        Filters
                                    </button>
                                </li>

                            </ul>
                        </div>
                    </div>

                    <div class="col-4" style=" height: 100vh;">



                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show " id="pills-removebg" role="tabpanel"
                                aria-labelledby="pills-removebg" tabindex="0">
                                <div class="col-12">
                                </div>
                            </div>
                            {{-- content of add bg --}}
                            <div class="tab-pane fade show " id="pills-addbg" role="tabpanel"
                                aria-labelledby="pills-addbg" tabindex="0">
                                <ul class="nav nav-pills mb-3 my-3" id="pills-tab" role="tablist">

                                    <li class="nav-item" role="presentation">
                                        <button class="pill-action active" id="pills-photoBackground"
                                            data-bs-toggle="pill" data-bs-target="#pills-PhotoBg" type="button"
                                            role="tab" aria-controls="pills-PhotoBg"
                                            aria-selected="true">Photo</button>
                                    </li>


                                    {{-- Hidden for a While --}}
                                    <li class="nav-item d-none" role="presentation">
                                        <button class="pill-action" id="pills-Color-background" data-bs-toggle="pill"
                                            data-bs-target="#pills-colorBg" type="button" role="tab"
                                            aria-controls="pills-colorBg" aria-selected="false">Solid Color</button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="pill-action" id="pills-custom-background" data-bs-toggle="pill"
                                            data-bs-target="#pills-customBg" type="button" role="tab"
                                            aria-controls="pills-customBg" aria-selected="false">Custom</button>
                                    </li>

                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    {{-- Background Image --}}
                                    <div class="tab-pane fade show active" id="pills-PhotoBg" role="tabpanel"
                                        aria-labelledby="pills-photoBackground" tabindex="0">
                                        <div class="row">
                                            <div class="col-12 d-flex flex-wrap justify-content-start"
                                                style="width: 23rem;height: 100vh;overflow: auto !important; margin-bottom: 10px">
                                                {{-- <button class="bgimage-btn tranparent-bg" type="button"></button>

                                                {{-- <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="https://static.remove.bg/backgrounds/person/new/pexels-shonejai-1227511-size-156.jpg"
                                                        alt="">
                                                </button>
                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="https://static.remove.bg/backgrounds/person/new/pexels-boris-ulzibat-1731660-size-156.jpg"
                                                        alt="">
                                                </button>
                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="https://static.remove.bg/backgrounds/person/new/pexels-oliver-sjostrom-1005417-size-156.jpg"
                                                        alt="">
                                                </button>
                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="https://static.remove.bg/backgrounds/person/new/pride_gradient-size-156.png"
                                                        alt="">
                                                </button>
                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="https://static.remove.bg/backgrounds/person/Urban/architecture-blur-blurred-background-1823743-size-156.jpg"
                                                        alt="">
                                                </button>
                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="https://static.remove.bg/backgrounds/person/Nature/asphalt-back-road-blurred-background-1546901-size-156.jpg"
                                                        alt="">
                                                </button>
                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="https://static.remove.bg/backgrounds/person/Winter/branch-cold-fog-839462-size-156.jpg"
                                                        alt="">
                                                </button> --}}


                                                <div class="col-12">
                                                    <h6>Office</h6>
                                                </div>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Office\office (1).jpg') }}"
                                                        alt="">
                                                </button>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Office\office (2).jpg') }}"
                                                        alt="">
                                                </button>
                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Office\office (3).jpg') }}"
                                                        alt="">
                                                </button>
                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Office\office (4).jpg') }}"
                                                        alt="">
                                                </button>
                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Office\office (5).jpg') }}"
                                                        alt="">
                                                </button>
                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Office\office (6).jpg') }}"
                                                        alt="">
                                                </button>


                                                <div class="col-12">
                                                    <h6>Home</h6>
                                                </div>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Home\home (1).jpg') }}"
                                                        alt="">
                                                </button>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Home\home (2).jpg') }}"
                                                        alt="">
                                                </button>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Home\home (3).jpg') }}"
                                                        alt="">
                                                </button>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Home\home (4).jpg') }}"
                                                        alt="">
                                                </button>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Home\home (5).jpg') }}"
                                                        alt="">
                                                </button>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Home\home (6).jpg') }}"
                                                        alt="">
                                                </button>


                                                <div class="col-12">
                                                    <h6>Desk</h6>
                                                </div>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Desk\desk (1).jpg') }}"
                                                        alt="">
                                                </button>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Desk\desk (2).jpg') }}"
                                                        alt="">
                                                </button>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Desk\desk (3).jpg') }}"
                                                        alt="">
                                                </button>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Desk\desk (4).jpg') }}"
                                                        alt="">
                                                </button>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Desk\desk (5).jpg') }}"
                                                        alt="">
                                                </button>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Desk\desk (6).jpg') }}"
                                                        alt="">
                                                </button>

                                                <div class="col-12">
                                                    <h6>Clear</h6>
                                                </div>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Clear\clear (1).jpg') }}"
                                                        alt="">
                                                </button>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Clear\clear (2).jpg') }}"
                                                        alt="">
                                                </button>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Clear\clear (3).jpg') }}"
                                                        alt="">
                                                </button>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Clear\clear (4).jpg') }}"
                                                        alt="">
                                                </button>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Clear\clear (5).jpg') }}"
                                                        alt="">
                                                </button>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Clear\clear (6).jpg') }}"
                                                        alt="">
                                                </button>

                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Clear\clear (7).jpg') }}"
                                                        alt="">
                                                </button>
                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Clear\clear (8).jpg') }}"
                                                        alt="">
                                                </button>
                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Clear\clear (9).jpg') }}"
                                                        alt="">
                                                </button>
                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Clear\clear (10).jpg') }}"
                                                        alt="">
                                                </button>
                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Clear\clear (11).jpg') }}"
                                                        alt="">
                                                </button>
                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Clear\clear (12).jpg') }}"
                                                        alt="">
                                                </button>
                                                <button id="staticImg-bg" class="bgimage-btn" type="button">
                                                    <img src="{{ asset('frontend\assets\removebg\Clear\clear (13).jpg') }}"
                                                        alt="">
                                                </button>



                                                <div class="col-12 my-5 mb-3"></div>



                                            </div>





                                        </div>
                                    </div>

                                    {{-- BAckground Color --}}
                                    <div class="tab-pane fade" id="pills-colorBg" role="tabpanel"
                                        aria-labelledby="pills-Color-background" tabindex="0">
                                        <div class="row">
                                            <div class="col-12 d-flex flex-wrap justify-content-center" id="coloringbox"
                                                style="width: 23rem;height: 50vh;overflow: auto;">
                                                <button class="tranparent-bg bgcolor-btn changecolorbtn" type="button"
                                                    data-color="transparent"></button>

                                                <button id="customcolor-bg" class="bgcolor-btn" type="button">
                                                    <label for="colorPicker"></label>
                                                    <input type="color" id="colorPicker">
                                                </button>

                                                <button id="staticcolor-bg" class="bgcolor-btn changecolorbtn"
                                                    data-color="rgb(244, 67, 54)" type="button"></button>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane fade show active" id="pills-customBg" role="tabpanel"
                                        aria-labelledby="pills-custom-background" tabindex="0">
                                        <div class="row">

                                            <div class="col-12">
                                                <h6>Add Custom Backgound</h6>
                                            </div>

                                            <div class="col-12 d-flex flex-wrap justify-content-start"
                                                style="width: 23rem;height: max-content;overflow: auto !important; margin-bottom: 10px">

                                                <input type="file" name="custombg" id="custombgsrc" class="d-none">
                                                <label id="customimg-bg" for="custombgsrc" type="button">+</label>


                                                <div id="avl_custom_bg">
                                                    {{-- ... Appending Available Custom Backgrounds From Local Storage ... --}}
                                                </div>

                                                <div class="col-12 my-5 mb-3"></div>
                                            </div>



                                        </div>
                                    </div>





                                </div>
                            </div>

                            {{-- content of resize --}}
                            <div class="tab-pane fade show " id="pills-home" role="tabpanel"
                                aria-labelledby="pills-cropbtn" tabindex="0">
                                <div class="row">
                                    <div class="col-12 my-3 d-flex justify-content-between">

                                        <button id="setRatio1to1" type="button"
                                            class="btn btn-outline-primary aspectratiobtn">1:1</button>
                                        <button id="setRatio4to3" type="button"
                                            class="btn btn-outline-primary aspectratiobtn">4:3</button>
                                        <button id="setCustomRatio" type="button"
                                            class="btn btn-outline-primary d-none">Custom Ratio</button>
                                        <button id="setFreeCrop" type="button"
                                            class="btn btn-outline-primary aspectratiobtn active">Free Crop</button>
                                        <button id="saveCrop" type="button"
                                            class="btn btn-outline-primary savebtn">Crop Image</button>

                                    </div>
                                </div>
                            </div>

                            {{-- content of filters --}}
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-12 my-3">
                                        <button id="resetFilterButton" class="btn btn-outline-danger"
                                            type="button">Reset</button>
                                    </div>

                                    <div class="col-8">
                                        <div class="filter-container my-3">
                                            <!-- Grayscale -->
                                            <div class="filter-control">
                                                <label>Grayscale:
                                                    <input type="range" id="grayscale" min="0" max="100"
                                                        value="0">
                                                    <span id="grayscaleValue">0%</span>
                                                    {{-- <input type="number" id="grayscaleInput" min="0" max="100" value="0"> --}}
                                                </label>
                                            </div>
                                            <!-- Sepia -->
                                            <div class="filter-control">
                                                <label>Sepia:
                                                    <input type="range" id="sepia" min="0" max="100"
                                                        value="0">
                                                    <span id="sepiaValue">0%</span>
                                                    {{-- <input type="number" id="sepiaInput" min="0" max="100" value="0"> --}}
                                                </label>
                                            </div>
                                            <!-- Brightness -->
                                            <div class="filter-control">
                                                <label>Brightness: <input type="range" id="brightness" min="0"
                                                        max="200" value="100">
                                                    <span id="brightnessValue">100%</span>
                                                    {{-- <input type="number" id="brightnessInput" min="0" max="200" value="100"> --}}
                                                </label>
                                            </div>
                                            <!-- Contrast -->
                                            <div class="filter-control">
                                                <label>Contrast:
                                                    <input type="range" id="contrast" min="0" max="200"
                                                        value="100">
                                                    <span id="contrastValue">100%</span>
                                                    {{-- <input type="number" id="contrastInput" min="0" max="200" value="100"> --}}
                                                </label>
                                            </div>
                                            <!-- Saturate -->
                                            <div class="filter-control">
                                                <label>Saturate:
                                                    <input type="range" id="saturate" min="0" max="200"
                                                        value="100">
                                                    <span id="saturateValue">100%</span>
                                                    {{-- <input type="number" id="saturateInput" min="0" max="200" value="100"> --}}
                                                </label>
                                            </div>
                                            <button id="saveFilterbtn" class="btn btn-outline-primary savebtn"
                                                type="button">Save</button>
                                        </div>
                                    </div>


                                </div>

                            </div>

                            {{-- content of add text --}}
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-6 my-3">
                                        <div class="mb-3">
                                            <label for="text">Text: </label>
                                            <input type="text" id="text" placeholder="Enter text"
                                                class="form-control" oninput="checkInputText()">
                                        </div>
                                    </div>
                                    <div class="col-3 my-3">
                                        <div class="mb-3">
                                            <label for="fontSize">Font Size:</label>
                                            <input type="number" id="fontSize" value="20" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-3 my-3">
                                        <div class="mb-3">
                                            <label for="textColor">Text Color</label>
                                            <input type="color" id="textColor" value="#FF0000"
                                                class="form-control form-control-color" style="width: 100%; height:50%">
                                        </div>
                                    </div>
                                </div>

                                <div class="row my-3" id="textButtons" style="display: none;">
                                    <div class="col-12">
                                        <button type="button" id="AddtextonIMage" class="btn btn-outline-primary">Add
                                            Text</button>
                                        <button type="button" id="BoldtextonIMage"
                                            class="btn btn-outline-primary">Bold</button>
                                        <button type="button" id="ItalictextonIMage"
                                            class="btn btn-outline-primary">Italic</button>
                                        <button type="button" id="UnderlinetextonIMage"
                                            class="btn btn-outline-primary">Underline</button>
                                        <button type="button" id="AddarrowtextonIMage"
                                            class="btn btn-outline-primary">Add Arrow</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 d-noe">
                                        Add Object:
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="mb-3">
                                            <label for="imageUrl">URL:</label>
                                            <input type="text" id="imageUrl" placeholder="Enter image URL"
                                                class="form-control">

                                            <input type="file" id="imagefilefeb" class="form-control">

                                        </div>
                                        <button type="button" id="AddImageonCanvas" class="btn btn-outline-primary">Add
                                            Image</button>

                                        <button id="deleteSelectedobjects" class="btn btn-outline-danger"
                                            type="button">Reset</button>
                                        <button id="saveAnotationbtn" class="btn btn-outline-primary savebtn my-2"
                                            type="button">
                                            Apply Annotation
                                        </button>

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>



                </div>
            </div>





        </div>

    </div>



    <input type="hidden" id="old_path" value="{{ $file_path }}">

    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
        <script>
            addcustombgbtn()

            function checkInputText() {
                var textInput = document.getElementById("text");
                var textButtons = document.getElementById("textButtons");

                if (textInput.value.trim() !== "") {
                    textButtons.style.display = "block";
                } else {
                    textButtons.style.display = "none";
                }
            }


            $("#custombgsrc").change(function(e) {
                e.preventDefault();

                let file = $(this)[0].files[0];
                let reader = new FileReader();

                reader.onload = function(e) {
                    let originalImageUrl = e.target.result;

                    // Compress the image before storing
                    compressImage(originalImageUrl, function(compressedImageUrl) {
                        addbginlocalstg(compressedImageUrl);
                        addcustombgbtn();
                    });
                };

                reader.readAsDataURL(file);
            });


            function compressImage(originalImageUrl, callback) {
                let img = new Image();

                img.onload = function() {
                    let canvas = document.createElement('canvas');
                    let ctx = canvas.getContext('2d');

                    // Set the canvas dimensions to the compressed size
                    canvas.width = 1080; // Set your preferred width
                    canvas.height = (canvas.width / img.width) * img.height;

                    // Draw the image onto the canvas
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                    // Convert the canvas back to a data URL with compression
                    let compressedImageUrl = canvas.toDataURL('image/jpeg', 0.7); // Adjust quality as needed

                    callback(compressedImageUrl);
                };

                img.src = originalImageUrl;
            }

            function addcustombgbtn() {
                let links = localStorage.getItem("custombg");
                links = links ? JSON.parse(links) : [];

                $("#avl_custom_bg").empty();


                $.each(links, function(indexInArray, valueOfElement) {
                    let tag = `
                        <button id="staticImg-bg" class="bgimage-btn" type="button">
                            <img src="${valueOfElement}" alt="">
                        </button>`;
                    $("#avl_custom_bg").append(tag);
                    $(".bgimage-btn").click(function(e) {
                        // e.preventDefault();

                        let backgorundImagSRC = $(this).find('img').attr('src');
                        // let forgroundImgsrc = $(".previewedit").find('img').attr('src');
                        let forgroundImgsrc = $("#RemovedBackgroundimage").attr('src');
                        let rembgCanvas = $("#rembgCanvas");
                        let Backgroudcontainer = $(".Backgroudcontainer");

                        Backgroudcontainer.removeClass('d-none');
                        $("#editpreviewimage").addClass('d-none');
                        // $("#editpreviewimage").attr('src',forgroundImgsrc)

                        $("#editpreviewimage").attr('src', '');

                        changeImageBackground('rembgCanvas', forgroundImgsrc, backgorundImagSRC, function(
                            dataURL) {
                            $("#editpreviewimage").attr('src', dataURL);
                        });

                        // $.alert(`You Are Trying to Change Background Image, Please Wait...`)
                        Backgroudcontainer.addClass('d-none');

                        $("#editpreviewimage").removeClass('d-none');
                    });




                });
            }

            function addbginlocalstg(data) {
                let links = localStorage.getItem("custombg");
                links = links ? JSON.parse(links) : [];
                links.push(data);
                localStorage.setItem("custombg", JSON.stringify(links));
            }
        </script>

    <script>
        document.getElementById('back98').addEventListener('click', function(e) {
            e.preventDefault();
            window.history.back();
        });
    </script>

        <script>
            function readycolor() {
                $(".changecolorbtn").each(function() {
                    var color = $(this).attr("data-color");
                    $(this).css("background-color", color);
                    // $(this).css("border", 'none');
                });
            }

            function createColorbtns(colorArray, appendElementId) {
                $.each(colorArray, function(indexInArray, valueOfElement) {
                    let tag =
                        `<button id="staticcolor-bg" class="bgcolor-btn changecolorbtn" data-color="${valueOfElement}" type="button"></button>`;
                    $(`#${appendElementId}`).append(tag);
                });
            }

            function changeColor(color) {
                $(`#editpreviewimage`).css("background-color", color);
                console.log(`Background color changed to ${color}`);
            }


            // Initialzing Color Buttons
            var colorArr = ["rgb(233, 30, 99)", "rgb(156, 39, 176)", "rgb(244, 67, 54)", "rgb(103, 58, 183)",
                "rgb(63, 81, 181)", "rgb(33, 150, 243)", "rgb(63, 81, 181)", "rgb(33, 150, 243)", "rgb(3, 169, 244)",
                "rgb(0, 188, 212)", "rgb(0, 150, 136)", "rgb(76, 175, 80)", "rgb(139, 195, 74)", "rgb(205, 220, 57)",
                "rgb(255, 235, 59)", "rgb(255, 193, 7)", "rgb(255, 152, 0)", "rgb(255, 87, 34)", "rgb(121, 85, 72)",
                "rgb(158, 158, 158)", "rgb(96, 125, 139)"
            ];
            createColorbtns(colorArr, "coloringbox")
            readycolor();



            // $("#addbg").click(function(e) {
            //     e.preventDefault();
            //     $(".bg-container").toggleClass("d-none");
            //     $(this).toggleClass("active");
            // });


            $("#colorPicker").on('input', function() {
                var selectedColor = $(this).val();
                changeColor(selectedColor)
            });

            $(".changecolorbtn").click(function(e) {

                let bgcolor = $("#editpreviewimage").css("background-color");
                let image_path = $("#editpreviewimage").attr('src');
                let output_path = $("#old_path").val();

                $.toast({
                    heading: 'SUCCESS',
                    text: "Changing Background, Please Wait...",
                    showHideTransition: 'slide',
                    icon: 'success',
                    loaderBg: '#f96868',
                    position: 'top-right'
                });


                $.ajax({
                    type: "POST",
                    url: "{{ route('panel.image.changebg') }}",
                    data: {
                        'image_path': image_path,
                        'bgcolor': bgcolor,
                        'output_path': output_path
                    },
                    success: function(response) {
                        // console.log(response);
                        let result = response;
                        if (result.status == 'success') {
                            $.toast({
                                text: "Background Changed,Successfully",
                                showHideTransition: 'slide',
                                icon: 'success',
                                loaderBg: '#f96868',
                                position: 'top-right'
                            });
                            changeColor($(this).attr("data-color"));

                        }
                    }
                });



            });


            // Remove Background Button
            $("#pills-removebg-tab").click(function(e) {
                e.preventDefault();
                $("button").removeClass('active')
                $(this).addClass('active')
                // $("#blankcol").removeClass('d-none');
                let editOgimage_path = $("#editpreviewimage").attr('src');
                $.toast({
                    text: "Removing Background, Please Wait...",
                    showHideTransition: 'slide',
                    icon: 'success',
                    loaderBg: '#f96868',
                    position: 'top-right'
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('panel.image.removebg') }}",
                    data: {
                        'image_path': editOgimage_path,
                    },
                    success: function(response) {
                        // console.log(response);
                        let result = JSON.parse(response);

                        $("#editpreviewimage").removeClass('d-none');
                        $("#editpreviewimage").attr('src', result.data_url);
                        $("#RemovedBackgroundimage").attr('src', result.data_url);
                        $("#canvasfilter").addClass('d-none');
                        $("#editpreview").addClass('d-block');
                        changeColor("#ffffff");

                        $.toast({
                            heading: 'SUCCESS',
                            text: "Image Background Removed Successfully",
                            showHideTransition: 'slide',
                            icon: 'success',
                            loaderBg: '#f96868',
                            position: 'top-right'
                        });

                    }
                });
            });


            $("#keepnamecheck").change(function(e) {
                if ($(this).is(':checked') === false) {
                    $.alert("Original image will be unlinked from the product");
                }
            });


            $("#downloadimage").click(function(e) {
                e.preventDefault();
                const dataUrl = $("#editpreviewimage").attr('src');
                let keepnamecheck = $("#keepnamecheck").is(':checked');
                keepnamecheck = keepnamecheck ? "keeporiginal" : "dontkeeporiginal";
                console.log(keepnamecheck);
                $.ajax({
                    type: "POST",
                    url: "{{ route('panel.image.crop.image') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        image: dataUrl,
                        old_path: $("#old_path").val(),
                        keepnamecheck: keepnamecheck
                    },

                    success: function(response) {
                        $.toast({
                            heading: 'SUCCESS',
                            text: "Image Updated Successfully",
                            showHideTransition: 'slide',
                            icon: 'success',
                            loaderBg: '#f96868',
                            position: 'top-right'
                        });

                    if (window.location.search.includes('refer=pedit')){
                        window.history.back();
                    }

                    },
                    error: function(response) {
                        $.toast({
                            heading: 'ERROR',
                            text: "Error While Updating Image, Try again later",
                            showHideTransition: 'slide',
                            icon: 'error',
                            loaderBg: '#f2a654',
                            position: 'top-right'
                        });
                    }
                });



            });
        </script>


        {{-- For Image Backgroud --}}

        <script>
            // $(".bgimage-btn").click(function(e) {
            //     // e.preventDefault();

            //     let backgorundImagSRC = $(this).find('img').attr('src');
            //     // let forgroundImgsrc = $(".previewedit").find('img').attr('src');
            //     let forgroundImgsrc = $("#RemovedBackgroundimage").attr('src');
            //     let rembgCanvas = $("#rembgCanvas");
            //     let Backgroudcontainer = $(".Backgroudcontainer");

            //     Backgroudcontainer.removeClass('d-none');
            //     $("#editpreviewimage").addClass('d-none');
            //     // $("#editpreviewimage").attr('src',forgroundImgsrc)

            //     $("#editpreviewimage").attr('src', '');

            //     changeImageBackground('rembgCanvas', forgroundImgsrc, backgorundImagSRC, function(
            //         dataURL) {
            //         $("#editpreviewimage").attr('src', dataURL);
            //     });

            //     // $.alert(`You Are Trying to Change Background Image, Please Wait...`)
            //     Backgroudcontainer.addClass('d-none');

            //     $("#editpreviewimage").removeClass('d-none');
            // });

            function changeImageBackground(canvasId, foregroundSrc, backgroundSrc, callback) {
                var canvas = document.getElementById(`${canvasId}`);
                var ctx = canvas.getContext('2d');
                var backgroundImg = new Image();
                var foregroundImg = new Image();

                // Load the foreground image first
                foregroundImg.onload = function() {
                    // Set the canvas size to match the foreground image size
                    canvas.width = this.width;
                    canvas.height = this.height;

                    // Now that the canvas is the right size, load the background image
                    backgroundImg.src = backgroundSrc;
                };

                backgroundImg.onload = function() {
                    // Draw the background image with 'cover' effect
                    drawImageCover(this, ctx, canvas);

                    // Draw the foreground image on top
                    ctx.drawImage(foregroundImg, 0, 0);

                    // Get the Data URL and call the callback
                    var dataURL = canvas.toDataURL();
                    callback(dataURL);

                    clearCanvas(canvasId);
                };

                // Set the source of the images
                foregroundImg.src = foregroundSrc;
                backgroundImg.crossOrigin = 'Anonymous'; // Use if needed for CORS
                foregroundImg.crossOrigin = 'Anonymous'; // Use if needed for CORS
            }

            function drawImageCover(img, ctx, canvas) {
                // Fill the canvas with the image
                var scale = Math.max(canvas.width / img.width, canvas.height / img.height);
                var x = (canvas.width / 2) - (img.width / 2) * scale;
                var y = (canvas.height / 2) - (img.height / 2) * scale;
                ctx.drawImage(img, x, y, img.width * scale, img.height * scale);
            }

            function clearCanvas(canvasId) {
                var canvas = document.getElementById(`${canvasId}`);
                var ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);
            }
        </script>



        {{-- Cropper JS --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var imageUrlInput = document.getElementById('editpreviewimage');
                var loadImageButton = document.getElementById('pills-cropbtn');
                var cropButton = document.getElementById('saveCrop');
                var setRatio1to1 = document.getElementById('setRatio1to1');
                var setRatio4to3 = document.getElementById('setRatio4to3');
                var setCustomRatio = document.getElementById('setCustomRatio');
                var setFreeCrop = document.getElementById('setFreeCrop');
                var croppedCanvas = document.getElementById('croppedCanvas');
                var cropper;
                var livePreview = false;



                $(".aspectratiobtn").click(function(e) {
                    e.preventDefault();
                    $(".aspectratiobtn").removeClass('active');
                    $(this).addClass('active');
                });


                loadImageButton.addEventListener('click', function() {
                    $(".cropcontain").removeClass("d-none");
                    $(".filtercontainer").addClass("d-none");
                    $(".anotatecontainer").addClass("d-none");
                    $("#editpreviewimage").addClass("d-none");

                    var imageUrl = imageUrlInput.src;
                    if (imageUrl) {
                        var image = new Image();

                        image.onload = function() {
                            if (cropper) {
                                cropper.destroy();
                            }

                            croppedCanvas.width = '500px'; // Set the desired width of the cropped image
                            croppedCanvas.height = '600px'; // Set the desired height of the cropped image

                            cropper = new Cropper(croppedCanvas, {
                                aspectRatio: 0, // Default aspect ratio
                                viewMode: 1,
                                autoCropArea: 1,
                                responsive: true,
                                crop: function(event) {
                                    // You can handle the 'crop' event if needed
                                    if (livePreview === true) {
                                        var croppedImageDataURL = cropper.getCroppedCanvas()
                                            .toDataURL();
                                        $("#editpreviewimage").attr('src', croppedImageDataURL);
                                    }
                                }
                            });

                            cropper.replace(image.src);
                        };

                        image.src = imageUrl;
                    }
                });



                cropButton.addEventListener('click', function() {
                    var croppedImageDataURL = cropper.getCroppedCanvas().toDataURL();
                    console.log(croppedImageDataURL);
                    $("#editpreviewimage").attr('src', croppedImageDataURL);
                    $("#editpreviewimage").removeClass("d-none");
                    $("#pills-cropbtn").removeClass('active');
                    $(".cropcontain").addClass("d-none");

                });

                setRatio1to1.addEventListener('click', function() {
                    cropper.setAspectRatio(1);
                });

                setRatio4to3.addEventListener('click', function() {
                    cropper.setAspectRatio(4 / 3);
                });

                setCustomRatio.addEventListener('click', function() {
                    // Prompt the user for a custom aspect ratio (you can replace this with your own UI)
                    var customRatio = prompt("Enter custom aspect ratio (e.g., 16:9):");
                    if (customRatio) {
                        var parts = customRatio.split(':');
                        if (parts.length === 2) {
                            var ratio = parseFloat(parts[0]) / parseFloat(parts[1]);
                            cropper.setAspectRatio(ratio);
                        }
                    }
                });

                setFreeCrop.addEventListener('click', function() {
                    cropper.setAspectRatio(0); // 0 means free crop (no fixed aspect ratio)
                });

            });
        </script>



        {{-- For Image Background --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const changebgbtn = document.getElementById("pills-addbg-tab");
                const ImagePath = document.getElementById("editpreviewimage");
                var canvas = new fabric.Canvas('changebgCanvas');

                // $("#editpreviewimage").addClass("border border-primary");

                changebgbtn.addEventListener("click", function() {
                    $(".changebgcontainer").toggleClass("d-none");
                    $(".filtercontainer, .cropcontain").addClass("d-none");

                    canvas.setWidth(ImagePath.width);
                    canvas.setHeight(ImagePath.height);

                    fabric.Image.fromURL(ImagePath.src, function(img) {
                        img.scaleToWidth(canvas.width);
                        img.scaleToHeight(canvas.height);
                        canvas.add(img);
                    });

                    $("#editpreviewimage").addClass("d-none");
                });

                $(".bgimage-btn").click(function(e) {
                    let backgroundImgSrc = $(this).find('img').attr('src');

                    fabric.Image.fromURL(backgroundImgSrc, function(img) {
                        img.scaleToWidth(canvas.width);
                        img.scaleToHeight(canvas.height);

                        // Set the new image as the background
                        // canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
                        canvas.setBackgroundImage(img, function() {
                            // Get Data URL after setting the background
                            let dataURL = canvas.toDataURL({
                                format: 'png',
                                quality: 0.8
                            });

                            // Updating Url to the preview image...
                            $("#editpreviewimage").attr('src', dataURL);
                        });

                        // Bring existing images to the front
                        canvas.getObjects().forEach(function(object) {
                            if (object.type === 'image') {
                                canvas.bringToFront(object);
                            }
                        });
                    });
                    $("#editpreviewimage").addClass("d-none");
                });


                // Event listener for object modification (e.g., moving)
                canvas.on('object:modified', function(event) {
                    // Log new Data URL whenever an element is moved
                    let dataURL = canvas.toDataURL({
                        format: 'png',
                        quality: 0.8
                    });
                    // console.log("Data URL after element move:", dataURL);
                    $("#editpreviewimage").attr('src', dataURL);
                });
            });
        </script>



        {{-- For Filter Section --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const loadImageButton = document.getElementById("pills-profile-tab")
                const canvas = document.getElementById("canvasfilter");
                const imageUrlInput = document.getElementById('editpreviewimage');
                const ctx = canvasfilter.getContext("2d");
                const resetButton = document.getElementById('resetFilterButton');

                let originalImage = null;
                let imageLoaded = false;

                loadImageButton.addEventListener('click', function() {


                    $(".filtercontainer").removeClass("d-none");
                    $(".cropcontain").addClass("d-none");
                    $("#editpreviewimage").addClass("d-none");
                    $(".anotatecontainer").addClass("d-none");



                    const imageUrl = imageUrlInput.src;
                    if (imageUrl) {
                        originalImage = new Image();
                        originalImage.crossOrigin = 'anonymous';
                        originalImage.onload = function() {
                            canvas.width = originalImage.width;
                            canvas.height = originalImage.height;
                            ctx.drawImage(originalImage, 0, 0);
                            updateFilters();
                            imageLoaded = true;

                            $("#canvasfilter").removeClass('d-none');
                            $("#editpreviewimage").addClass('d-none');
                            $(".needhidemodal").addClass('invisible');
                            $(".spinner-box").addClass('d-none');


                        };
                        originalImage.onerror = function() {
                            alert('Failed to load the image.');
                            imageLoaded = false;
                        };
                        originalImage.src = imageUrl;

                    } else {
                        alert('Please enter a valid image URL.');
                    }
                });

                function updateFilters() {
                    const grayscale = document.getElementById('grayscale').value;
                    const sepia = document.getElementById('sepia').value;
                    const brightness = document.getElementById('brightness').value;
                    const contrast = document.getElementById('contrast').value;
                    const saturate = document.getElementById('saturate').value;

                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    ctx.filter =
                        `grayscale(${grayscale}%) sepia(${sepia}%) brightness(${brightness}%) contrast(${contrast}%) saturate(${saturate}%)`;
                    ctx.drawImage(originalImage, 0, 0);

                    // Update the displayed values
                    document.getElementById('grayscaleValue').textContent = grayscale + '%';
                    document.getElementById('sepiaValue').textContent = sepia + '%';
                    document.getElementById('brightnessValue').textContent = brightness + '%';
                    document.getElementById('contrastValue').textContent = contrast + '%';
                    document.getElementById('saturateValue').textContent = saturate + '%';
                }


                function updateSliderValue(sliderId, valueId) {
                    const slider = document.getElementById(sliderId);
                    const valueDisplay = document.getElementById(valueId);

                    if (slider && valueDisplay) {
                        slider.addEventListener('input', function() {
                            valueDisplay.textContent = this.value + '%';
                            updateFilters();
                        });
                    }
                }
                updateSliderValue('grayscale', 'grayscaleValue');
                updateSliderValue('sepia', 'sepiaValue');
                updateSliderValue('brightness', 'brightnessValue');
                updateSliderValue('contrast', 'contrastValue');
                updateSliderValue('saturate', 'saturateValue');

                function resetFilters() {
                    if (originalImage) {
                        document.getElementById('grayscale').value = 0;
                        document.getElementById('grayscaleValue').textContent = '0%';

                        document.getElementById('sepia').value = 0;
                        document.getElementById('sepiaValue').textContent = '0%';

                        document.getElementById('brightness').value = 100;
                        document.getElementById('brightnessValue').textContent = '100%';

                        document.getElementById('contrast').value = 100;
                        document.getElementById('contrastValue').textContent = '100%';

                        document.getElementById('saturate').value = 100;
                        document.getElementById('saturateValue').textContent = '100%';
                        // Redraw the original image
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        ctx.filter = 'none';
                        ctx.drawImage(originalImage, 0, 0);
                    }
                }


                resetButton.addEventListener('click', resetFilters);


                document.getElementById('saveFilterbtn').addEventListener('click', function() {
                    const dataUrl = canvas.toDataURL('image/png');
                    if (imageLoaded === true) {
                        console.log(dataUrl);
                        $("#editpreviewimage").attr('src', dataUrl);
                        $("#editpreviewimage").removeClass("d-none");
                        $("#pills-profile-tab").removeClass('active');

                        $(".filtercontainer").addClass("d-none");
                    }

                });

            });
        </script>

        {{-- For Image Anotation --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Get elements
                const anotationbtn = document.getElementById("pills-contact-tab");
                const ImagePath = document.getElementById("editpreviewimage");
                const canvas = new fabric.Canvas('anotateCanvas');

                // Add click event for annotation button
                anotationbtn.addEventListener('click', function() {
                    // Show annotation tools and hide other elements
                    $(".anotatecontainer").removeClass("d-none");
                    // $(".anotateCanvas").addClass("border");
                    // $(".anotateCanvas").addClass("border-primary");


                    $(".filtercontainer").addClass("d-none");
                    $(".cropcontain").addClass("d-none");
                    $(".changebgcontainer").addClass("d-none");

                    canvas.setWidth(ImagePath.width);
                    canvas.setHeight(ImagePath.height);

                    fabric.Image.fromURL(ImagePath.src, function(img) {
                        img.scaleToWidth(canvas.width);
                        img.scaleToHeight(canvas.height);
                        canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
                    });

                    $("#editpreviewimage").addClass("d-none");


                    // Event listener for object modification (e.g., moving)
                    canvas.on('object:modified', function(event) {
                        // Log new Data URL whenever an element is moved
                        let dataURL = canvas.toDataURL({
                            format: 'png',
                            quality: 0.8
                        });
                        // console.log("Data URL after element move:", dataURL);
                        $("#editpreviewimage").attr('src', dataURL);
                    });


                    document.getElementById("BoldtextonIMage").addEventListener('click', function() {
                        var activeObject = canvas.getActiveObject();
                        if (activeObject && activeObject.type === 'i-text') {
                            activeObject.set('fontWeight', activeObject.fontWeight === 'bold' ? '' :
                                'bold');
                            canvas.renderAll();
                        }
                    });

                    document.getElementById("ItalictextonIMage").addEventListener('click', function() {
                        var activeObject = canvas.getActiveObject();
                        if (activeObject && activeObject.type === 'i-text') {
                            activeObject.set('fontStyle', activeObject.fontStyle === 'italic' ? '' :
                                'italic');
                            canvas.renderAll();
                        }
                    });


                    document.getElementById("UnderlinetextonIMage").addEventListener('click', function() {
                        var activeObject = canvas.getActiveObject();
                        if (activeObject && activeObject.type === 'i-text') {
                            activeObject.set('underline', !activeObject.underline);
                            canvas.renderAll();
                        }
                    });



                    // Event listener for adding text on the image
                    document.getElementById("AddtextonIMage").addEventListener('click', function() {
                        // Create text object
                        var textValue = document.getElementById('text').value;
                        var fontSize = document.getElementById('fontSize').value;
                        var textColor = document.getElementById('textColor').value;
                        var textObj = new fabric.IText(textValue, {
                            left: 100,
                            top: 100,
                            fontSize: parseInt(fontSize, 10),
                            fill: textColor
                        });
                        canvas.add(textObj);
                        canvas.setActiveObject(textObj);
                    });

                    // Other annotation functionalities...

                    // Event listener for real-time color change
                    document.getElementById('textColor').addEventListener('input', function() {
                        var selectedObject = canvas.getActiveObject();
                        if (selectedObject && selectedObject.type === 'i-text') {
                            selectedObject.set('fill', this.value);
                            canvas.renderAll();
                        }
                    });

                    // Event listener for deleting selected objects
                    document.getElementById('deleteSelectedobjects').addEventListener('click', function() {
                        var activeObject = canvas.getActiveObject();
                        if (activeObject) {
                            if (activeObject.type === 'activeSelection') {
                                activeObject.forEachObject(function(object) {
                                    canvas.remove(object);
                                });
                                canvas.discardActiveObject(); // Clear the selection
                            } else {
                                canvas.remove(activeObject);
                            }
                            canvas.requestRenderAll(); // Re-render the canvas
                        }
                    });

                    // Event listener for adding an image from file input
                    document.getElementById('imagefilefeb').addEventListener('change', function(e) {
                        var file = e.target.files[0];
                        if (file) {
                            var reader = new FileReader();
                            reader.onload = function(event) {
                                var imageUrl = event.target.result;
                                fabric.Image.fromURL(imageUrl, function(img) {
                                    canvas.add(img);
                                });
                            };
                            reader.readAsDataURL(file);
                        }
                    });

                    // Event listener for adding an image from URL
                    document.getElementById("AddImageonCanvas").addEventListener('click', function() {
                        var imageUrl = document.getElementById('imageUrl').value;
                        fabric.Image.fromURL(imageUrl, function(img) {
                            img.scaleToWidth(100);
                            img.scaleToHeight(100);
                            canvas.add(img);
                        });
                    });

                    // Event listener for saving annotation
                    document.getElementById('saveAnotationbtn').addEventListener('click', function() {
                        const dataUrl = canvas.toDataURL('image/png');
                        console.log("Data URL of the complete canvas:", dataUrl);

                        // Update preview image with annotated image
                        $("#editpreviewimage").attr('src', dataUrl);
                        $("#editpreviewimage").removeClass("d-none");
                        $(".filtercontainer").addClass("d-none");
                        $(".cropcontain").addClass("d-none");
                        $("#pills-contact-tab").removeClass('active');
                    });
                });
            });
        </script>
    @endpush
@endsection
