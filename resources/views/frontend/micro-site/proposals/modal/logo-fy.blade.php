<div class="modal fade" id="logofymodal" tabindex="-1" aria-labelledby="logofymodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            {{-- <div class="modal-header">
                <h1 class="modal-title fs-5" id="logofymodalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> --}}
            <div class="modal-body">

                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                    role="tab" aria-controls="pills-home" aria-selected="true">1. Choose Logo</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link " id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                    role="tab" aria-controls="pills-profile" aria-selected="false">2. Edit Logo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-contact-tab" data-toggle="pill"
                                    href="#pills-contact" role="tab" aria-controls="pills-contact"
                                    aria-selected="false">3. Maya AI</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-visualise-tab" data-toggle="pill" href="#pills-visualise"
                                    role="tab" aria-controls="pills-visualise" aria-selected="false">4.
                                    Visualise</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">

                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="mb-3">
                                            <a href="#link" role="button"
                                                class="btn btn-link text-dark active">Image</a>
                                            <a href="#link" role="button"
                                                class="btn btn-link text-dark ">Discover</a>
                                        </div>
                                        <div class="mb-3">
                                            <span>Accept Image Formats</span>
                                            <p>
                                                .jpg, .jpeg, .png, .gif, .svg
                                            </p>
                                            <label for="uploadfiletologofy" class="btn btn-primary btn-block "
                                                style="border-radius: 20px;">Upload</label>
                                            <input type="file" id="uploadfiletologofy" name="uploadfile"
                                                class="d-none" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <img src="https://picsum.photos/150" alt="image Preview" id="logofyimagepreview"
                                            style="height: 150px;width: 150px; object-fit: contain;border-radius: 10px"
                                            class="img-fluid m-1">
                                    </div>


                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <span>Recetly Uploaded</span>
                                            </div>
                                            <div class="col-12 d-flex" style="overflow-x: auto">
                                                @for ($i = 1; $i < 16; $i++)
                                                    <img src="https://picsum.photos/250?random={{ $i }}"
                                                        alt="Recent Image {{ $i }}"
                                                        style="height: 80px;width: 80px; object-fit: contain"
                                                        class="img-fluid rounded m-1">
                                                @endfor
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>

                            <div class="tab-pane fade " id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">

                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        {{-- ` Canvas --}}
                                        <canvas id="logofycanvas"></canvas>



                                    </div>

                                    <div class="col-12 col-md-6">
                                        {{-- ` Options --}}
                                        <!-- Filters -->
                                        <label for="invert">Invert</label>
                                        <input type="range" id="invert" min="0" max="1"
                                            step="0.01" value="0" class="form-control">
                                        <label for="saturation">Saturation</label>
                                        <input type="range" id="saturation" min="0" max="100"
                                            step="1" value="0" class="form-control">
                                        <label for="brightness">brightness</label>
                                        <input type="range" id="brightness" min="-1" max="1"
                                            step="0.01" value="0" class="form-control">
                                        <!-- Add more controls as needed -->
                                        {{-- <button id="cropButton" role="button" class="btn btn-outline-dark "> cropButton</button> --}}

                                        <!-- Add Text UI Elements -->
                                        <input class="form-control " type="text" id="textInput"
                                            placeholder="Enter text">
                                        <select id="fontSelect" class="form-control ">
                                            <option value="Arial">Arial</option>
                                            <option value="Helvetica">Helvetica</option>
                                            <option value="Times New Roman">Times New Roman</option>
                                        </select>

                                        <input type="color" id="textColorInput">

                                        <input class="form-control " type="number" id="textSizeInput"
                                            placeholder="Size" value="12">
                                        <button id="addTextButton" class="btn btn-outline-dark ">Add Text</button>
                                        <br>

                                        <label for="">Change BG</label>
                                        <input type="color" id="chagebglogofy">


                                        <!-- Crop Button -->
                                    </div>

                                    <div class="col-12">
                                        <span>Effects</span>
                                    </div>
                                    <div class="col-12">
                                        @for ($i = 1; $i < 25; $i++)
                                            <img src="{{ asset('/frontend/assets/effect/effect_1 (' . $i . ').png') }}"
                                                alt="Image" style="height: 75px;width: 75px;object-fit: contain"
                                                class="img-fluid chnageeffect">
                                        @endfor
                                    </div>


                                </div>

                            </div>

                            <div class="tab-pane fade " id="pills-contact" role="tabpanel"
                                aria-labelledby="pills-contact-tab">

                                <div class="row">
                                    @for ($i = 1; $i < 5; $i++)
                                        <div class="col-3">
                                            <div class="card" style="max-width: 150px;overflow: hidden;">
                                                <div class="card-body text-center ">
                                                    <img src="https://picsum.photos/250?random={{ $i }}"
                                                        alt="product Image"
                                                        style="height: 125px;width: 125px;object-fit: contain;">
                                                    <button class="btn btn-link mt-2"> Clear Background </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endfor


                                </div>


                            </div>

                            <div class="tab-pane fade " id="pills-visualise" role="tabpanel"
                                aria-labelledby="pills-visualise-tab">

                                <div class="row">
                                    @for ($i = 1; $i < 5; $i++)
                                        <div class="col-3">
                                            <div class="card" style="max-width: 150px;overflow: hidden;">
                                                <div class="card-body" style="position: relative;">
                                                    <img src="https://picsum.photos/250?random={{ $i }}"
                                                        alt="product Image"
                                                        style="height: 125px;width: 125px;object-fit: contain;">

                                                    <img src="https://picsum.photos/250?random={{ $i }}1"
                                                        alt="product Image" class="appendlogo">

                                                </div>
                                            </div>
                                        </div>
                                    @endfor

                                    <div class="col-12">
                                        <div class="row">

                                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                                <div class="mb-3">
                                                    <label for="modifylogo-height">Logo Height</label>
                                                    <input type="number" id="modifylogo-height"
                                                        class="form-control modify-logoapply" value="70">
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                                <div class="mb-3">
                                                    <label for="modifylogo-width">Logo Width</label>
                                                    <input type="number" id="modifylogo-width"
                                                        class="form-control modify-logoapply" value="70">
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                                <div class="mb-3">
                                                    <label for="modifylogo-top">From Top</label>
                                                    <input type="number" id="modifylogo-top"
                                                        class="form-control modify-logoapply" value="87">
                                                </div>
                                            </div>


                                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                                <div class="mb-3">
                                                    <label for="modifylogo-bottom">From Left</label>
                                                    <input type="number" id="modifylogo-bottom"
                                                        class="form-control modify-logoapply" value="94">
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                                <div class="mb-3">
                                                    <label for="modifylogo-border_radius">border_radius</label>
                                                    <input type="number" id="modifylogo-border_radius"
                                                        class="form-control modify-logoapply" value="0">
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                                <div class="mb-3">
                                                    <label for="modifylogo-objectfit">Backgorund Fit</label>
                                                    <select id="modifylogo-objectfit"
                                                        class="form-control modify-logoapply">
                                                        <option value="contain" selected>contain</option>
                                                        <option value="cover">cover</option>
                                                        <option value="none">none</option>
                                                    </select>


                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>



                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
