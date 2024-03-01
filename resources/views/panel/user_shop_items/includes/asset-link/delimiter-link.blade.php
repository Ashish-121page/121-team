@extends('backend.layouts.main')
@section('title', 'Asset Link')

<!-- push external head elements to head -->
@push('head')
    <link rel="stylesheet" href="{{ asset('backend\plugins\owl.carousel\dist\assets\owl.carousel.min.css') }}">
    <style>
        .owl-carousel .owl-item {
            height: 150px;
            width: 150px;
        }

        .owl-carousel .owl-item img {
            border-radius: 10px;
            width: 100%;
            height: 60%;
            object-fit: contain;

        }

        .owl-next {
            position: absolute;
            top: 50%;
            right: -2%;
            transform: translateY(-50%);
            font-size: 3.5rem !important;
            color: var(--primary) !important;
        }

        .owl-prev {
            position: absolute;
            top: 50%;
            left: -2%;
            transform: translateY(-50%);
            font-size: 3.5rem !important;
            color: var(--primary) !important;
        }

        .btn.active {
            color: #6666cc !important;
        }
    </style>

@endpush
@section('content')

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <a href="#back" onclick="window.history.back()" class="btn btn-secondary "> Back </a>
            </div>
        </div>

        <div class="orange mt-5 text-center"
            style="display: flex;margin: 20px auto;width: 100%;align-items: center;justify-content: center;">
            <div class=" btn active done custom_active_add-0" data-step="0">
                1. Upload
            </div>
            <div class=" btn editable custom_active_add-1">
                2. Review
            </div>
            <div class=" btn editable custom_active_add-2" id="pills-profile2-tab">
                3. Finish
            </div>
        </div>
        {{-- stepper menu end --}}

        <div class="col-12 ">
            {{-- <div class="row"> --}}
            <div class="stepper" data-index="0">
                <div class="card">
                    {{-- <div class="card-header">
                        <div class="d-flex">
                            <div>

                            </div>
                        </div>
                    </div> --}}
                    <div class="card-body">

                        <div class="row justify-content-center">
                            <form action="{{ route('panel.asset-link.split.files') }}" method="POST" id="splitform">
                                <div class="col-12  justify-content-between mb-3">
                                    <input type="hidden" class="vault_name" name="vault_name">
                                    <input type="hidden" id="fileData" name="fileData">
                                    <input type="hidden" name="ignore_files" id="form_ignored" value="1">

                                    {{-- <div class="h6">Vault Name: #<span class="vault_name"></span></div> --}}
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-12 ">
                                            <div class="form-group ">
                                                <label for="vaultname">
                                                    Vault Name <span class="text-danger">*</span>
                                                    <i class="ik ik-info mr-1"
                                                        title="Keywords help improve image search results. Can be your design or style names."></i>
                                                </label>
                                                @php
                                                    $path = 'storage/files/' . auth()->id() . '/vaults/';
                                                    $vault_name = App\Models\Media::where('path', 'LIKE', $path . '%')
                                                        ->groupBy('vault_name')
                                                        ->pluck('vault_name');
                                                @endphp
                                                <input type="text" name="vaultname" id="vaultname"
                                                    class="form-control sameinput" list="existvaultname">
                                                <datalist id="existvaultname">
                                                    @forelse ($vault_name as $vault)
                                                        <option value="{{ $vault }}">{{ $vault }} </option>
                                                    @empty
                                                        <option value="No Vault Found">
                                                    @endforelse
                                                </datalist>
                                            </div>
                                            {{-- <span>Tip : This does not have an impact when Searching across multiple Vaults.</span> --}}
                                        </div>
                                    </div>

                                    <div class="h6e">
                                        <span class="my-2 mb-4">File Name has model code On
                                            <span class="text-danger">*</span>
                                        </span>


                                        <select id="delimeter_type" name="delimeter_type" class="form-control">
                                            <option value="1">Separated by</option>
                                            <option value="1">_ (UnderScore)</option>
                                            <option value="2">- (Minus) </option>
                                            <option value="3">+ (Plus)</option>
                                            <option value="4">^ (caret)</option>
                                            <option value="5">^^ (Double caret)</option>
                                            <option value="6">, (Comma)</option>
                                            <option value="7">. (Dot)</option>
                                            <option value="8"># (Hashtag)</option>
                                            <option value="9"> (Space)</option>
                                        </select>
                                        {{-- <span class="my-2 text-center" style="width: 100%;display: block;">On </span> --}}
                                        <span class="my-2 text-center" style="width: 100%;display: block;">Separated by</span>
                                        <select id="delimeter_directiom" name="delimeter_directiom" class="form-control">
                                            <option value="0">Left</option>
                                            <option value="1">Right</option>
                                        </select>
                                    </div>
                                    {{-- <div class="">
                                            <div class="h6">Uploaded: #<span id="totalUploaded"></span> assets</div>
                                            <div class="h6">New Assets: #<span class="newassetcount">40</span> </div>
                                            <div class="h6 text-danger ">Rechecked File Names: #<span>30</span> </div>
                                        </div> --}}
                                </div>
                            </form>

                            {{-- According to UI should be here --}}
                            <div class="col-12 d-flex justify-content-center align-items-center flex-column">

                                <div class="alert alert-warning" role="alert">
                                    <i class="ik ik-info mr-1" title="You can upload 50 files at a time"></i>
                                    You can upload 50 files at a time
                                </div>

                                <div class="mb-3" style="height: 250px" id="uploadimage">
                                    <label for="uploaddata">
                                        <img src="{{ asset('frontend\assets\website\ASSETVAULT.png') }}" alt="img"
                                            style="height: 100%;object-fit: contain;">
                                    </label>
                                    <input type="file" id="uploaddata" name="uploaddata[]" multiple class="d-none">
                                </div>
                                <div class="d-flex justify-content-start flex-wrap" id="showimageprev"> </div>
                            </div>
                            <div class="col-12 d-flex justify-content-center ">
                                {{-- <button class="btn btn-outline-primary shadow-none draftandnext mx-3" type="button">Save for later</button> --}}
                                {{-- <button class="btn btn-primary shadow-none saveandnext mx-3" type="button">Next</button> --}}
                                <button class="btn btn-primary shadow-none saveandnext md-step mx-3" data-step="1"
                                    type="button" id="pills-profile-tab">Next</button>
                            </div>
                            {{-- According to UI should be till here --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="stepper d-none" data-index="1">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex">
                            <div>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">

                            <!-- Next section -->
                            <div class="col-12 my-2 col-md-3" id="saved_data">
                                <div class="h6">Vault Name: #<span class="vault_name"></span></div>
                            </div>

                            <div class="col-12 my-2 col-md-6" id="selectedOptions"></div>

                            <div class="col-12 my-2 col-md-3">
                                <div class="h6">Uploaded: #<span id="totalUploaded">0</span> assets</div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                {{-- according to UI should be here --}}
                                <div class="col-12 mb-3 text-start ">
                                    <div class="h6">New Assets (<span class="newassetcount">0</span>) </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="owl-carousel owl-theme" id="newasetsonly">
                                        @for ($i = 1; $i < 20; $i++)
                                            <div class="item text-center ">
                                                <img src="https://picsum.photos/250?random={{ $i }}"
                                                    alt="Test image {{ $i }}" class="img-fluid mb-1">
                                                <span>{{ generateRandomStringNative(rand(1, 10)) }}</span>

                                                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                    <div class="form-group ">
                                                        <label for="vaultname">
                                                            Reference KW
                                                            <i class="ik ik-info mr-1"
                                                                title="Keywords help improve image search results. Can be your design or style names."></i>
                                                        </label>
                                                        <input type="text" name="vaultname" id="tagsforvault"
                                                            class="form-control TAGGROUP sameinput">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                                <div class="form-group ">
                                                    <label for="vaultname">
                                                        Reference KW
                                                        <i class="ik ik-info mr-1"
                                                            title="Give product category name or supplier name."></i>
                                                    </label>
                                                    <input type="text" name="vaultname" id="tagsforvault"
                                                        class="form-control TAGGROUP sameinput">
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                                <div class="col-12 mb-3 text-start d-flex justify-content-between ">
                                    {{-- <div class="h6">Duplicate Assest (<span class="oldassetcount"></span>) </div> --}}
                                    {{-- <div class="h6">Invalid File Name (<span class="oldassetcount"></span>) </div> --}}
                                    <div class="h6">Duplicate Files on 121 (<span class="oldassetcount">0</span>)
                                    </div>
                                    <div class="">
                                        <input type="checkbox" checked id="ignored" value="1">
                                        <label for="ignored">Ignore Duplicates</label>
                                    </div>

                                </div>
                                <div class="col-12 mb-3">
                                    <div class="owl-carousel slider2 owl-theme" id="existingAsset">
                                    </div>
                                </div>

                            </div>

                            <div class="col-2 d-fnone">
                                <form action="{{ route('panel.asset-link.split.files') }}" method="POST"
                                    id="splitform">
                                    <div class="col-12  justify-content-between mb-3">
                                        <input type="hidden" class="vault_name" name="vault_name">
                                        <input type="hidden" id="fileData" name="fileData">

                                        {{-- <div class="h6">Vault Name: #<span class="vault_name"></span></div> --}}
                                        {{-- <div class="row d-flex p-2 justify-content-center">
                                                <div class="col-12 ">
                                                    <div class="form-group ">
                                                        <label for="vaultname">
                                                            Vault Name <span class="text-danger">*</span>
                                                                <i class="ik ik-info mr-1"
                                                                title="Keywords help improve image search results. Can be your design or style names."></i>
                                                        </label>
                                                        <input type="text" name="vaultname" id="vaultname" class="form-control sameinput"
                                                            list="existvaultname">
                                                        <datalist id="existvaultname">
                                                            <option value="One">
                                                            <option value="Two">
                                                            <option value="Three">
                                                            <option value="Four">
                                                            <option value="Five">
                                                        </datalist>
                                                    </div>
                                                </div>
                                            </div> --}}

                                        {{-- <div class="h6">
                                                File name contains model code which is separated by:<span class="text-danger">*</span>
                                                <select id="delimeter_type" name="delimeter_type" class="form-control">
                                                    <option value="1">_ (UnderScore)</option>
                                                    <option value="2">- (Minus) </option>
                                                    <option value="3">+ (caretPlus)</option>
                                                    <option value="4">^ (caret)</option>
                                                    <option value="5">^^ (Double caret)</option>
                                                    <option value="6">, (Comma)</option>
                                                    <option value="7">. (Dor)</option>
                                                </select>
                                                on<select id="delimeter_directiom" name="delimeter_directiom" class="form-control">
                                                    <option value="0">Left</option>
                                                    <option value="1">Right</option>
                                                </select>in the file name
                                            </div> --}}

                                    </div>
                                </form>
                            </div>

                            <div class="col-12 mb-3 d-flex justify-content-center">
                                <button class="btn mx-2 btn-outline-primary">Cancel</button>
                                <button class="btn mx-2 btn-primary" id="pills-profile-tab"
                                    form="splitform">Next</button>
                            </div>
                            {{-- according to UI should be till here --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

<!-- push external js -->

@push('script')
    <script src="{{ asset('backend/plugins/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script>
        $(function() {
            $('.md-step').click(function() {
                var index = $(this).data('step');
                $('.stepper').addClass('d-none');
                $('.stepper[data-index="' + index + '"]').removeClass('d-none');
                $('.custom_active_add-' + index).addClass('active');

                $('.custom_active_add-' + index).prevAll().removeClass('active');

            });


            $(".saveandnext").click(function(e) {
                e.preventDefault();
                if ($("#vaultname").val() == "") {
                    $("#vaultname").focus();
                    $("#vaultname").css("border", "1px solid red");
                    return;
                } else {
                    $("#vaultname").css("border", "none");
                }

                if ($("#uploaddata").val() == "") {
                    alert("Please upload file");
                    return;
                }

                // $("#pills-profile-tab").click();
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            $('.md-step.btn').click(function() {
                $('.md-step.btn').removeClass('active').css('background-color', '');

                $(this).addClass('active');

                $(this).css('background-color', '#666ccc');
            });
            $("#ignored").change(function(e) {
                e.preventDefault();
                $("#form_ignored").val($(this).is(':checked') ? 1 : 0);
            });

        });
    </script>


    <script>
        // Add event listeners to detect changes in dropdowns
        document.getElementById("delimeter_type").addEventListener("change", updateSelectedOptions);
        document.getElementById("delimeter_directiom").addEventListener("change", updateSelectedOptions);

        // Function to update the next section with selected options
        function updateSelectedOptions() {
            // Retrieve selected option names
            var delimeterType = document.getElementById("delimeter_type").options[document.getElementById("delimeter_type")
                .selectedIndex].text;
            var delimeterDirection = document.getElementById("delimeter_directiom").options[document.getElementById(
                "delimeter_directiom").selectedIndex].text;

            // Print selected options in the next section
            document.getElementById("selectedOptions").innerHTML =
                "File name contains model code which is separated by: <strong>" + delimeterType +
                "</strong> on : <strong>" + delimeterDirection + "</strong> in the file name";
        }
    </script>



    <script>
        $(function() {
            localStorage.removeItem('uploadedFiles');
            // Function to handle file uploads
            function uploadFile(file, url, onSuccess, onError) {
                var formData = new FormData();
                formData.append('file', file);
                formData.append('_token', $('meta[name="csrf-token"]').attr(
                    'content')); // Retrieve CSRF token from meta tag

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    processData: false, // Important for FormData
                    contentType: false, // Important for FormData
                    dataType: "json",
                    success: onSuccess,
                    error: onError
                });
            }

            function updateLocalStorage(storageName, value) {
                let data = localStorage.getItem(storageName);
                if (data) {
                    data = JSON.parse(data);
                    data.push(value);
                    localStorage.setItem(storageName, JSON.stringify(data));
                } else {
                    localStorage.setItem(storageName, JSON.stringify([value]));
                }
            }

            // Event handler for file input change
            $("#uploaddata").change(function(e) {
                e.preventDefault();
                var files = e.target.files;

                let max_upload = 50;
                if (this.files.length > max_upload) {
                    alert("You can upload maximum " + max_upload + " files at a time");
                    this.value = "";
                    return;
                }


                // $("#uploadimage").addClass('d-none');
                var url = "{{ route('panel.asset-link.store.file') }}";

                Array.from(files).forEach(file => {
                    var picReader = new FileReader();
                    picReader.onload = function(event) {
                        var picFile = event.target;
                        var div = $("#showimageprev");
                        let img =
                            `<img src="${picFile.result}" alt="preview" style="height: 100px; width: 100px; object-fit: contain" class="m-2 rounded">`;
                        div.append(img);
                        // Perform the upload
                        uploadFile(file, url,
                            function(response) {
                                // console.log("Upload successful for file:", file.name);
                                // console.log(response);
                                $(img).prop('src', response.id);
                                updateLocalStorage('uploadedFiles', {
                                    'FileName': file.name,
                                    'FileCode': response.code,
                                    'FilePath': response.path
                                });
                            },

                            function(xhr, status, error) {
                                console.error("Error in uploading file:");
                            }
                        );
                    };
                    // Read the file as Data URL for preview
                    picReader.readAsDataURL(file);
                });
            });
        });



        $(document).on("input", function(e) {
            let vaultname = $("#vaultname").val();
            $(".vault_name").text(vaultname);
            $(".vault_name").val(vaultname);
        })


        $(document).on('click', '#pills-profile-tab', function() {
            let data = localStorage.getItem('uploadedFiles');
            if (data) {
                $("#fileData").val(data);

                data = JSON.parse(data);
                let div = $('#newasetsonly');
                let Dublicate_div = $('#existingAsset');
                div.empty();
                Dublicate_div.empty();
                let countNew = 0;
                let countExist = 0;
                for (let i = 0; i < data.length; i++) {
                    let tag = `<div class="item text-center ">
                                    <img src="${data[i].FilePath}" alt="${data[i].FileName}" class="img-fluid mb-1">
                                    <span>${data[i].FileName}</span>
                                </div>`;

                    if (data[i].FileCode == 200) {
                        countNew++;
                        div.append(tag);

                    } else if (data[i].FileCode == 110) {
                        countExist++;
                        Dublicate_div.append(tag);
                    }

                    $(".oldassetcount").text(countExist);
                    $(".newassetcount").text(countNew);
                    $("#totalUploaded").text(countNew + countExist);
                }

                initowl('.owl-carousel')
                initowl('.slider2')
            }

        });



        async function initowl(owlclass) {
            $(owlclass).trigger(`destroy.${owlclass}`).owlCarousel({
                // loop: true,
                nav: true,
                margin: 10,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                        nav: true
                    },
                    300: {
                        items: 4,
                        nav: false
                    },
                    600: {
                        items: 5,
                        nav: false
                    },
                    1000: {
                        items: 8,
                        nav: true,
                        loop: false
                    }
                }
            });
        }
    </script>
@endpush
