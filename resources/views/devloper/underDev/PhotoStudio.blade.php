@extends('backend.layouts.main')
@section('title', 'Image Studio')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/dropzone.min.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.5.0/fabric.min.js"></script>

        <style>

        </style>


        <style>
            .main-content {
                padding-top: 0 !important;
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
            .bgcolor-btn {
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
                border-radius: 20px;
                color: #000;
                font-size: 1.2rem;
                font-weight: 600;
                padding: 5px;
                margin: 5px;
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

            ..pill-v-btn:hover {
                background-color: #6666cc;
                color: #fff;
                border: none;
            }
        </style>
    @endpush


    <div class="main-container">
        <div class="row">

            <div class="col-12 d-flex align-items-center" style="height: 50px; background-color: #111;">
                <div>
                    <button id="addbg" class="btn btn-outline-primary ml-3">
                        + Add Background
                    </button>
                    <button id="removebg" class="btn btn-secondary ml-3">
                        Remove Background
                    </button>

                    {{-- <button class="btn btn-primary mx-1 undo">
                        Undo
                    </button>

                    <button class="btn btn-primary mx-1 redo">
                        Redo
                    </button> --}}

                    <div class="bg-container d-none">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                            <li class="nav-item" role="presentation">
                                <button class="pill-action active" id="pills-photoBackground" data-bs-toggle="pill"
                                    data-bs-target="#pills-PhotoBg" type="button" role="tab"
                                    aria-controls="pills-PhotoBg" aria-selected="true">Photo</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="pill-action" id="pills-Color-background" data-bs-toggle="pill"
                                    data-bs-target="#pills-colorBg" type="button" role="tab"
                                    aria-controls="pills-colorBg" aria-selected="false">Color</button>
                            </li>

                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            {{-- Background Image --}}
                            <div class="tab-pane fade show active" id="pills-PhotoBg" role="tabpanel"
                                aria-labelledby="pills-photoBackground" tabindex="0">
                                <div class="row">
                                    <div class="col-12 d-flex flex-wrap justify-content-start"
                                        style="width: 23rem;height: 50vh;overflow: auto;">
                                        <button class="bgimage-btn tranparent-bg" type="button"></button>

                                        <button id="customimg-bg" class="bgimage-btn" type="button">+</button>

                                        <button id="staticImg-bg" class="bgimage-btn" type="button">
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
                                        </button>
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
                        </div>
                    </div>


                </div>
            </div>


            <div class="col-12">
                <div class="row">
                    <div class="col-1" style="background-color: #11111194; height: 100vh;">
                        <ul class="nav nav-pills mb-3 d-flex flex-column" id="pills-tab" role="tablist">

                            <li class="nav-item my-3" role="presentation">
                                <button class="pill-v-btn " id="pills-cropbtn" data-bs-toggle="pill"
                                    data-bs-target="#pills-home" type="button" role="tab"
                                    aria-controls="pills-home" aria-selected="true">Crop</button>
                            </li>


                            <li class="nav-item my-3" role="presentation">
                                <button class="pill-v-btn" id="pills-contact-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-contact" type="button" role="tab"
                                    aria-controls="pills-contact" aria-selected="false">Anotation</button>
                            </li>
                            <li class="nav-item my-3" role="presentation">
                                <button class="pill-v-btn" id="pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-profile" type="button" role="tab"
                                    aria-controls="pills-profile" aria-selected="false">Filters</button>
                            </li>

                        </ul>
                    </div>

                    <div class="col-3" style="background-color: #f1f1f1; height: 100vh;">

                        <div class="tab-content" id="pills-tabContent">

                            {{-- Crop Tab --}}
                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
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

                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-12">
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
                                                type="button">Apply
                                                Filter</button>
                                        </div>
                                    </div>


                                </div>

                            </div>

                            <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab" tabindex="0">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="text">Text: </label>
                                            <input type="text" id="text" placeholder="Enter text"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="mb-3">
                                            <label for="fontSize">Font Size:</label>
                                            <input type="number" id="fontSize" value="20" class="form-control">
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="mb-3">
                                            <label for="textColor">Text Color</label>
                                            <input type="color" id="textColor" value="#FF0000"
                                                class="form-control form-control-color">
                                        </div>
                                    </div>
                                </div>

                                <div class="row my-3">
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
                                    <div class="col-12">
                                        Add Object:
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="mb-3">
                                            <label for="imageUrl">URL:</label>
                                            <input type="text" id="imageUrl" placeholder="Enter image URL"
                                                class="form-control">
                                        </div>
                                        <button type="button" id="AddImageonCanvas" class="btn btn-outline-primary">Add
                                            Image</button>

                                        <button id="deleteSelectedobjects" class="btn btn-outline-danger"
                                            type="button">Delete Selected</button>
                                        <button id="saveAnotationbtn" class="btn btn-outline-primary savebtn my-2" type="button">
                                            Apply Anotation
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- ` Main Preivew Area --}}
                    <div class="col-8" style="background-color: #df0d0d;">
                        <div class="bgc" style="height: 100%;width: 100%">
                            <div class="row" style="position: relative; width: 100%;">

                                <div class="col-12 mt-5" style="height: min-content;width: min-content;">
                                    <div class="previewedit" style="height: 50% !important;width: 48%;">
                                        <img src="http://localhost/project/121.page-Laravel/121.page/storage/files/174/FOOCBKSWMTWN71662D.jpg"
                                            alt="Preview Image" style="height: 100%;width: 100%;object-fit: contain;"
                                            class="img-fluid" id="editpreviewimage">

                                        <div class="cropcontain d-none" style="height: 50vh;width: 50vw">
                                            <canvas id="croppedCanvas"></canvas>
                                        </div>

                                        <div class="filtercontainer d-none" style="height: 50vh;width: 50vw">
                                            <canvas id="canvasfilter"></canvas>
                                        </div>

                                        {{-- <div class="anotatecontainer d-none" style="height: 50vh;width: 50vw">
                                            <canvas id="canvasfilter"></canvas>
                                        </div> --}}


                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-start"
                                    style="position: absolute;bottom: -23%;right: -83%">
                                    <div class="previewedit" style="width: 15vh">
                                        <img src="http://localhost/project/121.page-Laravel/121.page/storage/files/174/FOOCBKSWMTWN71662D.jpg"
                                            alt="Preview Image" style="height: 100%;width: 100%;object-fit: contain"
                                            class="img-fluid rounded">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>



                </div>
            </div>





        </div>

    </div>





    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
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



            $("#addbg").click(function(e) {
                e.preventDefault();
                $(".bg-container").toggleClass("d-none");
                $(this).toggleClass("active");
            });


            $("#colorPicker").on('input', function() {
                var selectedColor = $(this).val();
                changeColor(selectedColor)
            });

            $(".changecolorbtn").click(function(e) {
                changeColor($(this).attr("data-color"));
            });
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
                    $("#editpreviewimage").addClass("d-none");

                    var imageUrl = imageUrlInput.src;
                    if (imageUrl) {
                        var image = new Image();

                        image.onload = function() {
                            if (cropper) {
                                cropper.destroy();
                            }

                            croppedCanvas.width = 800; // Set the desired width of the cropped image
                            croppedCanvas.height = '800px'; // Set the desired height of the cropped image

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
                const anotationbtn = document.getElementById("pills-contact-tab");
                const ImagePath = document.getElementById("editpreviewimage");

                anotationbtn.addEventListener('click', function() {


                    $(".filtercontainer").removeClass("d-none");
                    $(".cropcontain").addClass("d-none");
                    $("#editpreviewimage").addClass("d-none");

                    var canvas = new fabric.Canvas('canvasfilter');
                    canvas.setWidth(500); // Set the width to 500 pixels
                    canvas.setHeight(600); // Set the height to 600 pixels
                    var currentObject;

                    // fabric.Image.fromURL(ImagePath.src, function(img) {
                    //     canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
                    //         scaleX: canvas.width / img.width,
                    //         scaleY: canvas.height / img.height
                    //     });
                    // });

                    fabric.Image.fromURL(ImagePath.src, function(img) {
                        // Set the original size of the image
                        img.scaleToWidth(canvas.width);
                        img.scaleToHeight(canvas.height);

                        canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas));
                    });


                    document.getElementById("AddtextonIMage").addEventListener('click', function() {
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
                        currentObject = textObj;
                    })


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

                    document.getElementById("AddarrowtextonIMage").addEventListener('click', function() {
                        var points = [50, 100, 200, 100];
                        var options = {
                            stroke: 'black',
                            strokeWidth: 5,
                            fill: 'black',
                            selectable: true
                        };
                        var line = new fabric.Line(points, options);
                        var triangle = new fabric.Triangle({
                            width: 20,
                            height: 15,
                            fill: 'black',
                            left: 200,
                            top: 95,
                            angle: 90
                        });

                        var group = new fabric.Group([line, triangle], {});
                        canvas.add(group);
                    });



                    document.getElementById("AddImageonCanvas").addEventListener('click', function() {
                        var imageUrl = document.getElementById('imageUrl').value;
                        fabric.Image.fromURL(imageUrl, function(img) {
                            img.scaleToWidth(100);
                            img.scaleToHeight(100);
                            canvas.add(img);
                        });
                    });

                    // Event listener for real-time color change
                    document.getElementById('textColor').addEventListener('input', function() {
                        var selectedObject = canvas.getActiveObject();
                        if (selectedObject && selectedObject.type === 'i-text') {
                            selectedObject.set('fill', this.value);
                            canvas.renderAll();
                        }
                    });

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



                    document.getElementById('saveAnotationbtn').addEventListener('click', function() {
                        const dataUrl = canvas.toDataURL('image/png');
                        console.log(dataUrl);
                        $("#editpreviewimage").attr('src', dataUrl);
                        $("#editpreviewimage").removeClass("d-none");
                        $("#pills-contact-tab").removeClass('active');


                    });


                    // {{--  ============================================== --}}

                }); //  Click Event End....


            });
        </script>
    @endpush
@endsection
