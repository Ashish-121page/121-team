<!-- Modal -->
<div class="modal fade" id="editImage" tabindex="-1" aria-labelledby="editImageLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editImageLabel">Edit Image</h1>

            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-3" style="object-fit: contain;height: 100%;width: 100%">
                        <span class="text-center d-block">Original</span>
                        <img src="https://picsum.photos/300" alt="Demo Image" id="editOgimage_path"
                            style="height: 100%; width: 100%">
                        <input type="hidden" id="old_path">
                    </div>
                    <div class="col-6">
                        <div class="row">
                            {{-- Nav pills --}}
                            <div class="col-12">
                                <ul class="nav  justify-content-center nav-pills mb-3" id="pills-tab" role="tablist">

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link btn active" id="removebgbtn" data-bs-toggle="pill"
                                            data-bs-target="#pills-home" type="button" role="tab"
                                            aria-controls="pills-home" aria-selected="true">Background</button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link btn" id="cropimgbtn" data-bs-toggle="pill"
                                            data-bs-target="#pills-profile" type="button" role="tab"
                                            aria-controls="pills-profile" aria-selected="false">Crop</button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link btn" id="imagefilterbtn" data-bs-toggle="pill"
                                            data-bs-target="#pills-contact" type="button" role="tab"
                                            aria-controls="pills-contact" aria-selected="false">Filter</button>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link btn" id="anotationbtn" data-bs-toggle="pill"
                                            data-bs-target="#pills-anotation" type="button" role="tab"
                                            aria-controls="pills-contact" aria-selected="false">Anotation</button>
                                    </li>

                                </ul>
                            </div>

                            <div class="col-12">
                                <div class="tab-content" id="pills-tabContent">

                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                        aria-labelledby="removebgbtn" tabindex="0">


                                        <div class="col-8 d-flex mt-3">
                                            <span class="changecolorbtn" data-color="#6666cc"></span>
                                            <span class="changecolorbtn" data-color="#f1f1f1"></span>
                                            <span class="changecolorbtn" data-color="#111111"></span>
                                            <span class="changecolorbtn" data-color="#cccccc"></span>
                                            <div class="wrapper-color">
                                                <input type="color" id="colorPicker" value="#800080">
                                            </div>
                                        </div>


                                    </div>

                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                        aria-labelledby="cropimgbtn" tabindex="1">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12 my-3 d-flex justify-content-between">
                                                        <button id="setRatio1to1" type="button"
                                                            class="btn btn-outline-primary aspectratiobtn">1:1</button>
                                                        <button id="setRatio4to3" type="button"
                                                            class="btn btn-outline-primary aspectratiobtn">4:3</button>
                                                        <button id="setCustomRatio" type="button"
                                                            class="btn btn-outline-primary d-none">Custom
                                                            Ratio</button>
                                                        <button id="setFreeCrop" type="button"
                                                            class="btn btn-outline-primary aspectratiobtn active">Free
                                                            Crop</button>
                                                        <button id="LivePrevbtn" type="button"
                                                            class="btn btn-outline-primary d-none">Live
                                                            Preview</button>
                                                    </div>
                                                    <div class="col-12">
                                                        <canvas id="croppedCanvas"></canvas>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                    </div>

                                    <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                                        aria-labelledby="imagefilterbtn" tabindex="2">

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
                                                            <input type="range" id="grayscale" min="0"
                                                                max="100" value="0">
                                                            <span id="grayscaleValue">0%</span>
                                                            {{-- <input type="number" id="grayscaleInput" min="0" max="100" value="0"> --}}
                                                        </label>
                                                    </div>
                                                    <!-- Sepia -->
                                                    <div class="filter-control">
                                                        <label>Sepia:
                                                            <input type="range" id="sepia" min="0"
                                                                max="100" value="0">
                                                            <span id="sepiaValue">0%</span>
                                                            {{-- <input type="number" id="sepiaInput" min="0" max="100" value="0"> --}}
                                                        </label>
                                                    </div>
                                                    <!-- Brightness -->
                                                    <div class="filter-control">
                                                        <label>Brightness: <input type="range" id="brightness"
                                                                min="0" max="200" value="100">
                                                            <span id="brightnessValue">100%</span>
                                                            {{-- <input type="number" id="brightnessInput" min="0" max="200" value="100"> --}}
                                                        </label>
                                                    </div>
                                                    <!-- Contrast -->
                                                    <div class="filter-control">
                                                        <label>Contrast:
                                                            <input type="range" id="contrast" min="0"
                                                                max="200" value="100">
                                                            <span id="contrastValue">100%</span>
                                                            {{-- <input type="number" id="contrastInput" min="0" max="200" value="100"> --}}
                                                        </label>
                                                    </div>
                                                    <!-- Saturate -->
                                                    <div class="filter-control">
                                                        <label>Saturate:
                                                            <input type="range" id="saturate" min="0"
                                                                max="200" value="100">
                                                            <span id="saturateValue">100%</span>
                                                            {{-- <input type="number" id="saturateInput" min="0" max="200" value="100"> --}}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- <div class="col-4" style="object-fit: contain;height: 100%;width: 100%">
                                                <span>new IMage</span>
                                                <canvas id="canvasfilter" style="height: 100%;width: 100%"></canvas>
                                            </div> --}}

                                        </div>



                                    </div>

                                    <div class="tab-pane fade" id="pills-anotation" role="tabpanel"
                                        aria-labelledby="anotationbtn" tabindex="3">

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
                                                    <input type="number" id="fontSize" value="20"
                                                        class="form-control">
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
                                                <button type="button" id="AddtextonIMage"
                                                    class="btn btn-outline-primary">Add Text</button>
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
                                                    <input type="text" id="imageUrl"
                                                        placeholder="Enter image URL" class="form-control">
                                                </div>
                                                <button type="button" id="AddImageonCanvas"
                                                    class="btn btn-outline-primary">Add Image</button>

                                                <button id="deleteSelectedobjects" class="btn btn-outline-danger"
                                                    type="button">Delete Selected</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>


                    <div class="col-3" id="editpreview" style="object-fit: contain;height: 100%;width: 100%">
                        <div class="spinner-box" style="position: absolute;top: 50%;left: 50%;">
                            <div class="spinner"></div>
                        </div>
                        <span class="text-center d-block needhidemodal">Edited</span>
                        <img src="https://picsum.photos/300" alt="Demo Image" id="editpreviewimage"
                            style="height: 100%; width: 100%">

                        <canvas id="canvasfilter" style="height: 100%;width: 100%"></canvas>

                    </div>


                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="closeimageeditmodal" class="btn btn-secondary"
                    data-bs-dismiss="modal">Close</button>

                <button type="button" class="btn btn-outline-primary savebtn" id="downloadimage">Save
                    changes</button>

                <button id="saveCrop" type="button" class="btn btn-outline-primary savebtn d-none">Crop
                    Image</button>

                <button id="saveFilterbtn" class="btn btn-outline-primary savebtn d-none" type="button">Apply
                    Filter</button>

                <button id="saveAnotationbtn" class="btn btn-outline-primary savebtn d-none" type="button">Apply
                    Anotation</button>

            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

{{-- for Crop Section --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var imageUrlInput = document.getElementById('editOgimage_path');
        var loadImageButton = document.getElementById('cropimgbtn');
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

            $(".savebtn").addClass('d-none');
            $("#saveCrop").removeClass('d-none');


            var imageUrl = imageUrlInput.src;
            if (imageUrl) {
                var image = new Image();

                image.onload = function() {
                    if (cropper) {
                        cropper.destroy();
                    }

                    croppedCanvas.width = 300; // Set the desired width of the cropped image
                    croppedCanvas.height = 300; // Set the desired height of the cropped image

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

        // Live Preview for Crop Image
        document.getElementById("LivePrevbtn").addEventListener('click', function() {
            if (livePreview === false) {
                livePreview = true;
                $("#editpreview").removeClass('d-none');

                $("#editpreview").addClass('d-block');
                $("#LivePrevbtn").text('Stop Preview');
            } else {
                livePreview = false;
                $("#LivePrevbtn").text('Live Preview');
                $("#editpreview").removeClass('d-block');
                $("#editpreview").addClass('d-none');
            }
        });


        cropButton.addEventListener('click', function() {
            var croppedImageDataURL = cropper.getCroppedCanvas().toDataURL();
            console.log(croppedImageDataURL);
            $("#editpreviewimage").attr('src', croppedImageDataURL);
            $("#editpreview").removeClass('d-none');
            $("#editpreview").addClass('d-block');

            $.ajax({
                type: "POST",
                url: "{{ route('panel.image.crop.image') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    image: croppedImageDataURL,
                    old_path: $("#old_path").val(),
                },
                success: function(response) {
                    $.toast({
                        heading: 'SUCCESS',
                        text: "Image Croped Successfully",
                        showHideTransition: 'slide',
                        icon: 'success',
                        loaderBg: '#f96868',
                        position: 'top-right'
                    });
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
        const loadImageButton = document.getElementById("imagefilterbtn")
        const canvas = document.getElementById("canvasfilter");
        const imageUrlInput = document.getElementById('editOgimage_path');
        const ctx = canvasfilter.getContext("2d");
        const resetButton = document.getElementById('resetFilterButton');

        let originalImage = null;
        let imageLoaded = false;

        loadImageButton.addEventListener('click', function() {

            $(".savebtn").addClass('d-none');
            $("#saveFilterbtn").removeClass('d-none');

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
                $.ajax({
                    type: "POST",
                    url: "{{ route('panel.image.crop.image') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        image: dataUrl,
                        old_path: $("#old_path").val(),
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
            }

        });

    });
</script>

{{-- For Image Anotation --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const anotationbtn = document.getElementById("anotationbtn");
        const ImagePath = document.getElementById("editOgimage_path");

        anotationbtn.addEventListener('click', function() {

            var canvas = new fabric.Canvas('canvasfilter');
            var currentObject;

            $(".savebtn").addClass('d-none');
            $("#saveAnotationbtn").removeClass('d-none');
            $("#canvasfilter").removeClass('d-none');
            $("#editpreviewimage").addClass('d-none');
            $(".needhidemodal").addClass('invisible');
            $(".spinner-box").addClass('d-none');

            fabric.Image.fromURL(ImagePath.src, function(img) {
                canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
                    scaleX: canvas.width / img.width,
                    scaleY: canvas.height / img.height
                });
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
                $.ajax({
                    type: "POST",
                    url: "{{ route('panel.image.crop.image') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        image: dataUrl,
                        old_path: $("#old_path").val(),
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


            // {{--  ============================================== --}}

        }); //  Click Event End....


    });
</script>
