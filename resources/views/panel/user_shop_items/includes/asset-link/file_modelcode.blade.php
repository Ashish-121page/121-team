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

        .btn-link {
            text-decoration: none !important;
        }

        .btn-link.active {
            color: var(--primary) !important;
        }
    </style>
@endpush
@section('content')

    <div class="container-fluid ">

        <div class="row">
            <div class="col-12">
                <a href="#back" onclick="window.history.back()" class="btn btn-secondary "> Back </a>
            </div>
        </div>

        <ul class="nav nav-pills mb-3 w-100 d-flex justify-content-center " id="pills-tab" role="tablist">

            <li class="nav-item mx-2" role="presentation">
                <button class="btn btn-link text-muted  active" id="pills-Upload-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-Upload" type="button" role="tab" aria-controls="pills-Upload"
                    aria-selected="false">
                    1. Upload to vault
                </button>
            </li>

            <li class="nav-item mx-2" role="presentation">
                <button class="btn btn-link text-muted " id="pills-profile-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                    aria-selected="false">
                    2. Group
                </button>
            </li>

            <li class="nav-item mx-2" role="presentation">
                <button class="btn btn-link text-muted " id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    3. Finish
                </button>
            </li>
        </ul>

        <div class="tab-content" id="pills-tabContent">

            <div class="tab-pane fade " id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
                tabindex="0">

                <div class="">
                    <form action="{{ route('panel.asset-link.model.filename.preview') }}" method="POST" id="splitform">
                        <div class="col-12 d-flex justify-content-between mb-3">
                            <input type="hidden" class="vault_name" name="vault_name">
                            <input type="hidden" id="fileData" name="fileData">
                            <input type="hidden" id="workingType" name="workingType" value="filename_model_code">
                            <input type="hidden" name="ignore_files" id="form_ignored" value="1">

                            <div class="h6">Vault Name: #<span class="vault_name"></span></div>

                            <div class="h6">
                                <span>File Name is Model Code</span>
                            </div>
                            <div class="">
                                <div class="h6">Uploaded: #<span id="totalUploaded">0</span> assets</div>
                                {{-- <div class="h6">New Assets: #<span class="newassetcount">0</span> </div>
                                <div class="h6 text-danger ">Rechecked File Names: #<span>0</span> </div> --}}
                            </div>
                        </div>
                    </form>

                    <div class="col-12 mb-3">
                        <div class="h6">New Assest (<span class="newassetcount">0</span>) </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="owl-carousel owl-theme" id="newasetsonly">
                            @for ($i = 1; $i < 20; $i++)
                                <div class="item text-center ">
                                    <img src="https://picsum.photos/250?random={{ $i }}"
                                        alt="Test image {{ $i }}" class="img-fluid mb-1">
                                    <span>{{ generateRandomStringNative(rand(1, 10)) }}</span>
                                </div>
                            @endfor
                        </div>
                    </div>



                    <div class="col-12 mb-3 text-start d-flex justify-content-between ">
                        <div class="h6">Duplicate Files on 121 (<span class="oldassetcount">0</span>) </div>
                        <div class="">
                            <input type="checkbox" checked id="ignored" value="1">
                            <label for="ignored">Ignore Duplicates</label>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="owl-carousel slider2 owl-theme" id="existingAsset">
                            @for ($i = 21; $i < 40; $i++)
                                <div class="item text-center ">
                                    <img src="https://picsum.photos/250?random={{ $i }}"
                                        alt="Test image {{ $i }}" class="img-fluid mb-1">
                                    <span>{{ generateRandomStringNative(rand(1, 10)) }}</span>
                                </div>
                            @endfor
                        </div>
                    </div>


                    <div class="col-12 mb-3 d-flex justify-content-center">
                        <button class="btn mx-2 btn-outline-primary">Cancel</button>
                        <button class="btn mx-2 btn-primary" form="splitform">Next</button>
                    </div>

                </div>

            </div>

            <div class="tab-pane fade show active" id="pills-Upload" role="tabpanel" aria-labelledby="pills-Upload-tab"
                tabindex="0">

                <div class="row">
                    <div class="col-12 col-md-12">
                        <div class="row d-flex justify-content-center  p-2">
                            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                                <div class="form-group ">
                                    <label for="vaultname">
                                        Vault Name <span class="text-danger">*</span>
                                        <i class="ik ik-info mr-1"
                                            title="Give product category name or supplier name. Tip : This does not have an impact when Searching across multiple Vaults."></i>
                                    </label>

                                    @php
                                        $path = 'storage/files/' . auth()->id() . '/vaults/';
                                        $vault_name = App\Models\Media::where('path', 'LIKE', $path . '%')
                                            ->groupBy('vault_name')
                                            ->pluck('vault_name');
                                    @endphp
                                    <input type="text" name="vaultname" id="vaultname" class="form-control sameinput"
                                        list="existvaultname" autocomplete="off">

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
                    </div>

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
                        <button class="btn btn-primary shadow-none saveandnext mx-3" type="button">Next</button>
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

                $("#pills-profile-tab").click();
            });


            $("#ignored").change(function(e) {
                e.preventDefault();
                $("#form_ignored").val($(this).is(':checked') ? 1 : 0);
            });
        });

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
                // $("#uploadimage").addClass('d-none');
                let max_upload = 50;
                if (this.files.length > max_upload) {
                    alert("You can upload maximum " + max_upload + " files at a time");
                    this.value = "";
                    return;
                }


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
            $(owlclass).trigger('destroy.owl.carousel').owlCarousel({
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
