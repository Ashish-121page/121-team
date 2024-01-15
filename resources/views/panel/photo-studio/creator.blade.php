@extends('backend.layouts.main')
@section('title', 'Image Designer')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
        <style>
            .container {
                /* background-color: rgba(212, 212, 212, 0.7); */
                padding: 20px;
                border-radius: 20px;
                /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); */
                height: 100%;
            }

            .row {
                /* color:#adb5bd; */
                margin: 10px;
                /* height: auto; */
            }

            .card {
                border-radius: 15px;
                /* background-color: rgba(212, 212, 212, 0.4) !important;
                                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); */
                height: 100%;
            }

            .btn-circle.btn-sm {
                width: 30px;
                height: 30px;
                padding: 6px 0px;
                border-radius: 15px;
                font-size: 8px;
                text-align: center;
            }

            .from-control {
                margin-top: 5px;
                margin-bottom: 10px;
            }

            .form-control {
                margin-top: 5px;
                margin-bottom: 10px;
            }

            .color-btn {
                width: 30px;
                height: 30px;
                border-radius: 50%;
                margin: 5px;
                display: inline-block;
            }

            .color-selected {
                border: 2px solid #fff;
            }

            .color-btn.color-selected {
                border: 2px solid #fff;
                /* Add a border for selected buttons */
            }

            .sub {
                font-size: medium;
            }

            .dropdown-menu {
                padding: 10px;
                /* background-color: #202942;
                                color: #caccd4; */
                border-radius: 15px;
            }

            .cent {
                text-align: center;
            }

            .color-picker {
                display: flex;
                justify-content: space-between;
                margin-top: 10px;
            }

            .color-circle {
                width: 30px;
                height: 30px;
                border-radius: 50%;
                cursor: pointer;
            }

            .color-circle:hover {
                border: 2px solid #fff;
            }

            .color-circle.selected {
                border: 2px solid #fff;
            }

            #imageContainer {
                height: 360px;
                width: 360px;
            }

            .image-container {
                display: flex;
                flex-direction: column;
                overflow-y: auto;
                max-height: 720px;
            }

            .generated-image {
                margin-bottom: 10px;
                border: 2px solid transparent;
                transition: border-color 0.3s ease-in-out;
                height: 100px;
                width: 100px;
                border-radius: 10px;
            }
            .generated-image-prev {
                margin-bottom: 10px;
                border: 2px solid transparent;
                transition: border-color 0.3s ease-in-out;
                height: 500px;
                width: 500px;
                border-radius: 10px;
            }

            .generated-image:hover {
                border-color: #fff;
                /* Change border color on hover */
            }

            .genimage {
                max-width: 100%;
                max-height: 100%;
                width: 450px;
                height: 450px;
                display: block;
                margin: auto;
            }
        </style>
    @endpush


    <div class="main-container">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-pills nav-fill">
                            <li class="nav-item" id="fromTextTabhead">
                                <a class="nav-link active" id="fromTextTab" href="#" style="border-radius: 15px">New PD</a>
                            </li>
                            <li class="nav-item" id="fromImageTabhead">
                                <a class="nav-link" id="fromImageTab" href="#" style="border-radius: 15px">Modifications</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <!-- <h5 class="card-title">Special title treatment</h5> -->
                        <div id="fromTextForm">
                            <form action="/generate-image-from-image" method="post" id="textForm">
                                @csrf
                                <div class="form-group">
                                    <label for="type_of_product">Type of Product :</label>
                                    {{-- <input type="text" name="type_of_product" class='form-control'
                                        style="border-radius:15px"
                                        placeholder="What kind of home decor product are you thinking about? (e.g., lamp, vase, wall art, etc.)"
                                        data-toggle="tooltip"
                                        title="What kind of home decor product are you thinking about? (e.g., lamp, vase, wall art, etc.)"
                                        required> --}}

                                    <textarea name="type_of_product" class='form-control' style="border-radius:15px" rows="3" required></textarea>



                                </div>
                                <div class="form-group">
                                    <label for="style_preferences">Style Preferences:</label>
                                    <br>
                                    <select name="style_preferences" class="form-select" style="border-radius:15px">
                                        <option selected>-- Select --</option>
                                        <option value="traditional">Traditional</option>
                                        <option value="modern">Modern</option>
                                        <option value="minimalist">Minimalist</option>
                                        <option value="indian_ethnic">Indian Ethnic</option>
                                        <option value="rustic">Rustic</option>
                                        <option value="contemporary">Contemporary</option>
                                        <option value="industrial">Industrial</option>
                                        <option value="bohemian">Bohemian</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="color_scheme">Color Scheme:</label>
                                    <br>
                                    <select name="color_scheme" class="form-select" style="border-radius:15px">
                                        <option selected>-- Select --</option>
                                        <option value="monochromatic">Monochromatic</option>
                                        <option value="analogous">Analogous</option>
                                        <option value="complementary">Complementary</option>
                                        <option value="triadic">Triadic</option>
                                        <option value="neutral">Neutral</option>
                                        <option value="warm">Warm</option>
                                        <option value="cool">Cool</option>
                                        <option value="pastel">Pastel</option>
                                    </select>
                                </div>

                                <div class="form-group">

                                    <label for="color_palette">Color:</label>
                                    <div style="padding: 2px"></div>
                                    <button class="btn btn-light dropdown-toggle" type="button" id="colorPickerButton"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        style="border-radius:15px">
                                        Select Color
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="colorPickerButton">
                                        <div class="dropdown-container">
                                            <div class="sub">Primary</div>
                                            @foreach (config('colors.primary') as $colorName => $colorValue)
                                                <a href="#" class="color-btn" data-color="{{ $colorValue }}"
                                                    data-name="{{ $colorName }}"
                                                    style="background-color:{{ $colorValue }}; border-radius:50px;color:{{ $colorValue }};"></a>
                                            @endforeach
                                        </div>
                                        <div class="dropdown-container">
                                            <div class="sub">Secondary</div>
                                            @foreach (config('colors.secondary') as $colorName => $colorValue)
                                                <a href="#" class="color-btn" data-color="{{ $colorValue }}"
                                                    data-name="{{ $colorName }}"
                                                    style="background-color:{{ $colorValue }}; border-radius:50px;color:{{ $colorValue }};"></a>
                                            @endforeach
                                        </div>
                                        <div class="dropdown-container">
                                            <div class="sub">Tertiary</div>
                                            @foreach (config('colors.tertiary') as $colorName => $colorValue)
                                                <a href="#" class="color-btn" data-color="{{ $colorValue }}"
                                                    data-name="{{ $colorName }}"
                                                    style="background-color:{{ $colorValue }}; border-radius:50px;color:{{ $colorValue }};"></a>
                                            @endforeach
                                        </div>
                                        <div class="dropdown-container">
                                            <div class="sub">Neutral</div>
                                            @foreach (config('colors.neutral') as $colorName => $colorValue)
                                                <a href="#" class="color-btn" data-color="{{ $colorValue }}"
                                                    data-name="{{ $colorName }}"
                                                    style="background-color:{{ $colorValue }}; border-radius:50px;color:{{ $colorValue }};"></a>
                                            @endforeach
                                        </div>
                                        <div class="dropdown-container">
                                            <div class="sub">Warm</div>
                                            @foreach (config('colors.warm') as $colorName => $colorValue)
                                                <a href="#" class="color-btn" data-color="{{ $colorValue }}"
                                                    data-name="{{ $colorName }}"
                                                    style="background-color:{{ $colorValue }}; border-radius:50px;color:{{ $colorValue }};"></a>
                                            @endforeach
                                        </div>
                                        <div class="dropdown-container">
                                            <div class="sub">Cool</div>
                                            @foreach (config('colors.cool') as $colorName => $colorValue)
                                                <a href="#" class="color-btn" data-color="{{ $colorValue }}"
                                                    data-name="{{ $colorName }}"
                                                    style="background-color:{{ $colorValue }}; border-radius:50px;color:{{ $colorValue }};"></a>
                                            @endforeach
                                        </div>
                                        <div class="dropdown-container">
                                            <div class="sub">Metallic</div>
                                            @foreach (config('colors.metallic') as $colorName => $colorValue)
                                                <a href="#" class="color-btn" data-color="{{ $colorValue }}"
                                                    data-name="{{ $colorName }}"
                                                    style="background-color:{{ $colorValue }}; border-radius:50px;color:{{ $colorValue }};"></a>
                                            @endforeach
                                        </div>
                                        <div class="dropdown-container">
                                            <div class="sub">Pastel</div>
                                            @foreach (config('colors.pastel') as $colorName => $colorValue)
                                                <a href="#" class="color-btn" data-color="{{ $colorValue }}"
                                                    data-name="{{ $colorName }}"
                                                    style="background-color:{{ $colorValue }}; border-radius:50px;color:{{ $colorValue }};"></a>
                                            @endforeach
                                        </div>


                                        <div>
                                            <input name="color_palette" id="selected_color" class="form-control"
                                                placeholder="Selected Color">

                                        </div>


                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="materials" style="padding-top:10px">Materials:</label>
                                    <br>
                                    <select name="materials" class="form-select" style="border-radius:15px">
                                        <option selected>-- Select --</option>
                                        <option value="leather">Leather</option>
                                        <option value="wood">Wood</option>
                                        <option value="metal">Metal</option>
                                        <option value="glass">Glass</option>
                                        <option value="plastic">Plastic</option>
                                        <option value="ceramic">Ceramic</option>
                                        <option value="bamboo">Bamboo</option>
                                        <option value="teracotta">Teracotta</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <br>
                                    <label for="remarks">Additional Remarks:</label>
                                    {{-- <input type="text" name="remarks" class='form-control' style="border-radius:15px"
                                        placeholder="What kind of home decor product are you thinking about? (e.g., lamp, vase, wall art, etc.)"
                                        data-toggle="tooltip"
                                        title="What kind of home decor product are you thinking about? (e.g., lamp, vase, wall art, etc.)"
                                        required> --}}

                                    <textarea name="remarks" class='form-control' style="border-radius:15px" rows="3" required></textarea>

                                </div>


                                <br>
                                <div class="cent">
                                    <button type="button" class="btn btn-primary" style="border-radius:15px"
                                        id="generateImage">Generate Image 1</button>
                                </div>
                            </form>
                        </div>
                        <div id="fromImageForm" style="display: none;">
                            <form method="POST" action="{{ route('panel.image.generateImageFromImage') }}"
                                enctype="multipart/form-data" id="imageform12">
                                @csrf
                                <div class="form-group">
                                    {{-- <input type="file" class="form-control" name="image" /> --}}
                                    <input type="text" class="form-control d-none" name="image" id="newimagelink" placeholder="Upload image URL"/>
                                    <label>How to tweak the image:</label>
                                    {{-- <input type="text" class="form-control" name="text" /> --}}
                                    <textarea name="text" id="textold" cols="30" rows="10" class="form-control"></textarea>
                                    <br>
                                </div>
                                <div class="cent">
                                    <button type="button" class="btn btn-outline-primary" id="generateImagebyImage" style="border-radius: 15px">Regenerate Image</button>
                                </div>

                            </form>
                            {{-- <form method="POST" action="{{ route('image.fromImage') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="file" class="form-control" name="image" />
                                <input type="text" class="form-control" name="text" />
                                <button type="submit" class="btn btn-sm">Upload</button>
                            </form> --}}
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <div class="card ">
                    <div class="card-header">
                        <h4>Generated Image:</h4>
                    </div>
                    <div class="card-body">
                        {{-- <h5 class="card-title">Generated Image</h5> --}}
                        {{-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p> --}}

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <div id="textPrompt"></div>
                        <div id="loadingIndicator" style="display: none;">
                            <!-- A spinner or any loading text -->
                            Loading...
                        </div>
                        <div id="imageContainer" class="mt-4"
                            style="display:contents; align-items:center; justify-content:center;">

                            <div id="placeholder"
                                style="height:90%; width: 100%; border: 2px dashed #000; display: flex;align-items: center; justify-content: center;">

                                <!-- Placeholder text or icon -->

                                @if (isset($imagePaths) && count($imagePaths) > 0)
                                    @foreach ($imagePaths as $path)
                                        <img src="{{ asset($path) }}" alt="Generated Image" class="genimage generated-image-prev">
                                    @endforeach
                                @else
                                    <p>
                                        Product ideas will appear here.
                                    </p>

                                @endif
                            </div>

                        </div>

                    </div>

                </div>
            </div>


            <div class="col-md-2">
                <div class="card">
                    <div class="card-header">
                        <h4>Your creations:</h4>
                    </div>
                    <div class="card-body">
                        <div class="image-container">
                            @if ($existing_image)
                                @foreach ($existing_image as $imagePath)
                                    <img src="{{ asset($imagePath->maya_path ?? '') }}" alt="Generated Image" class="generated-image">
                                @endforeach
                            @else
                                <p>No images generated yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



    @push('script')
        <script>

            document.addEventListener('DOMContentLoaded', function() {
                const colorButtons = document.querySelectorAll('.color-btn');
                const selectedColorInput = document.getElementById('selected_color');

                colorButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.stopPropagation();
                        const selectedColor = this.dataset.name;

                        // document.getElementById('selected_color').value = selectedColor;
                        this.classList.toggle('color-selected');
                        updateSelectedColors();
                        clearSelection();

                    });
                });

                function updateSelectedColors() {
                    const selectedColors = Array.from(document.querySelectorAll('.color-btn.color-selected'))
                        .map(button => button.dataset.name);

                    selectedColorInput.value = selectedColors.join(' and ');
                }

                function clearSelection() {
                    colorButtons.forEach(button => {
                        if (!button.classList.contains('color-selected')) {
                            button.classList.remove('color-selected');
                        }
                    });
                }

            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const generateImageButton = document.getElementById('generateImage');
                // You Haven't Defined the id to the Button That is the Reason This FUnction will never call
                generateImageButton.addEventListener('click', function(e) {
                    showLoadingIndicator();
                    generateImage(e);
                });

                function showLoadingIndicator() {
                    const loadingIndicator = document.getElementById('loadingIndicator');
                    loadingIndicator.style.display = 'block';
                }

                function hideLoadingIndicator() {
                    const loadingIndicator = document.getElementById('loadingIndicator');
                    loadingIndicator.style.display = 'none';
                }

                function generateImage(event) {
                    event.preventDefault();
                    const formData = new FormData(document.querySelector('form'));
                    console.log(formData);

                    fetch("{{ route('panel.image.generateImage') }}", {
                            method: 'POST',
                            body: formData,
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Update the image container with the new image
                            const imagePath = data.imagePath;

                            const imageContainer = document.getElementById('imageContainer');
                            imageContainer.innerHTML =
                                `<img src="${imagePath}" alt="Generated Image" id="created_image" class="genimage generated-image-prev">`;

                            const textPrompt = document.getElementById('textPrompt');
                            textPrompt.innerText = data.textPrompt;
                            $("#twikinput").removeClass("d-none");
                            $("#loadingIndicator").addClass("d-none");
                            $("#fromTextTabhead").addClass("d-none");
                            $("#fromImageTab").click();
                        })
                        .catch(error => {
                            console.error('Error generating image:', error);
                        })
                        .finally(() => {
                            hideLoadingIndicator();
                        });
                }

            });


        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const generateImagebyImageButton = document.getElementById('generateImagebyImage');
                generateImagebyImageButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    showLoadingIndicator();
                    generateImageFromImage(e);
                });

                function showLoadingIndicator(e) {
                    const loadingIndicator = document.getElementById('loadingIndicator');
                    loadingIndicator.style.display = 'block';
                }

                function hideLoadingIndicator() {
                    const loadingIndicator = document.getElementById('loadingIndicator');
                    loadingIndicator.style.display = 'none';
                }

                function generateImageFromImage(e) {
                    // event.preventDefault(); // Commented out, as it seems unnecessary
                    $("#newimagelink").val($("#created_image").attr('src'));
                    $("#textold").text($("#text").val());

                    const formData = new FormData(document.getElementById('imageform12'));


                    fetch("{{ route('panel.image.generateImageFromImage') }}", {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            const imagePath = data.imagePaths;
                            console.log(data.imagePaths);
                            console.log(data.imagePaths);

                            const imageContainer = document.getElementById('imageContainer');
                            imageContainer.innerHTML = `<img src="${imagePath}" alt="Generated Image" id="created_image" class="generated-image-prev">`;

                            $("#loadingIndicator").addClass("d-none");
                            $("#fromTextTabhead").addClass("d-none");
                            $("#fromImageTab").click();

                        })
                        .catch(error => {
                            console.error('Error generating image:', error);
                        });


                }
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const fromTextTab = document.getElementById('fromTextTab');
                const fromImageTab = document.getElementById('fromImageTab');

                const fromTextForm = document.getElementById('fromTextForm');
                const fromImageForm = document.getElementById('fromImageForm');

                fromTextTab.addEventListener('click', function(e) {
                    e.preventDefault();
                    fromTextForm.style.display = 'block';
                    fromImageForm.style.display = 'none';
                    fromTextTab.classList.add('active');
                    fromImageTab.classList.remove('active');
                });

                fromImageTab.addEventListener('click', function(e) {
                    e.preventDefault();
                    fromTextForm.style.display = 'none';
                    fromImageForm.style.display = 'block';
                    fromTextTab.classList.remove('active');
                    fromImageTab.classList.add('active');
                });
            });
        </script>
    @endpush
@endsection
