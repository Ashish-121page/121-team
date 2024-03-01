<div class="tab-content" id="pills-tabContent">
    <ul class="nav nav-pills d-none mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link btn mx-2 active" id="pills-profile-tab" data-bs-toggle="pill"
                data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                aria-selected="false">First</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link btn mx-2" id="pills-contact-tab" data-bs-toggle="pill"
                data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                aria-selected="false">Second</button>
        </li>
    </ul>

    <div class="tab-pane fade show active " id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab"
        tabindex="0">
        <div class="row">
            <div class="col-12 m-1 d-flex justify-content-end align-items-center ">
                <button type="button" id="next_vault"  class="btn btn-primary mx-3"
                    style="clip-path: polygon(0% 0%, 75% 0%, 100% 50%, 75% 100%, 0% 100%);">&nbsp;&nbsp;&nbsp;</button>
            </div>

            <div class="col-12 m-1 d-flex justify-content-between align-items-center ">
                <div class="my-3">
                    <span class="h6">Name: <span id="vaultname1"> {{ $vault_name ?? '' }} </span> </span>
                </div>
                {{-- <div class="m-3">
                    <button class="btn btn-outline-primary ">Add New</button>
                </div> --}}

            </div>
            <div class="col-12 m-1">
                <div class="row">
                    {{-- <div class="col-2">
                        <span class="h6">Search KW:</span>
                        <div class="d-flex flex-wrap " id="appendtags">
                            @for ($i = 0; $i < 10; $i++)
                                <div class="btn btn-pills btn-primary m-1 "
                                    style="width: min-content;border-radius: 20px;">
                                    {{ generateRandomStringNative(rand(10, 15)) }}</div>
                            @endfor
                        </div>
                    </div> --}}
                    <div class="col-12 col-md-4">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nature</th>
                                    <th>No.</th>
                                    <th>Total Size</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="opentable" data-toggletable="type1table">
                                    <td>PDF</td>
                                    <td id="itemcount-pdf">
                                        @isset($pdf_rec)
                                            {{ count($pdf_rec) ?? 0 }}
                                        @endisset
                                    </td>
                                    <td id="sizecount-pdf">
                                        @isset($pdf_rec)
                                            @php
                                                $size = 0;
                                                foreach ($pdf_rec as $item) {
                                                    $size += filesize(storage_path(str_replace('storage', 'app/public', $item->path)));
                                                }
                                                echo human_filesize($size);
                                            @endphp
                                        @endisset
                                    </td>

                                </tr>
                                <tr class="toslide3">
                                    <td>Images
                                        {{-- <a href="#link" class="btn-link text-primary toslide3">(View)</a> --}}
                                    </td>
                                    <td id="itemcount-product">
                                        @isset($image_rec)
                                            {{ count($image_rec) ?? 0 }}
                                        @endisset
                                    </td>
                                    <td id="sizecount-product">
                                        @isset($image_rec)
                                            @php
                                                $size = 0;
                                                foreach ($image_rec as $item) {
                                                    $size += filesize(storage_path(str_replace('storage', 'app/public', $item->path)));
                                                }
                                                echo human_filesize($size);
                                            @endphp
                                        @endisset
                                    </td>
                                </tr>
                                <tr class="opentable" data-toggletable="type2table">
                                    <td>Attachments</td>
                                    <td id="itemcount-images">
                                        @isset($attchment_rec)
                                            {{ count($attchment_rec) ?? 0 }}
                                        @endisset
                                    </td>
                                    <td id="sizecount-images">
                                        @isset($attchment_rec)
                                            @php
                                                $size = 0;
                                                foreach ($attchment_rec as $item) {
                                                    $size += filesize(storage_path(str_replace('storage', 'app/public', $item->path)));
                                                }
                                                echo human_filesize($size);
                                            @endphp
                                        @endisset
                                    </td>
                                </tr>
                                <tr class="opentable" data-toggletable="type3table">
                                    <td>Gifs</td>
                                    <td id="itemcount-other">
                                        @isset($gif_rec)
                                            {{ count($gif_rec) ?? 0 }}
                                        @endisset
                                    </td>
                                    <td id="sizecount-other">
                                        @isset($gif_rec)
                                            @php
                                                $size = 0;
                                                foreach ($gif_rec as $item) {
                                                    $size += filesize(storage_path(str_replace('storage', 'app/public', $item->path)));
                                                }
                                                echo human_filesize($size);
                                            @endphp
                                        @endisset
                                    </td>
                                </tr>
                                <tr class="opentable" data-toggletable="type4table">
                                    <td>Videos</td>
                                    <td id="itemcount-images">
                                        @isset($video_rec)
                                            {{ count($video_rec) ?? 0 }}
                                        @endisset
                                    </td>
                                    <td id="sizecount-images">
                                        @isset($video_rec)
                                            @php
                                                $size = 0;
                                                foreach ($video_rec as $item) {
                                                    $size += filesize(storage_path(str_replace('storage', 'app/public', $item->path)));
                                                }
                                                echo human_filesize($size);
                                            @endphp
                                        @endisset
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-6">

                        <table class="table d-none prevtable" id="type1table"> {{-- PDF Table --}}
                            <thead>
                                <tr>
                                    <th>Thumbnails</th>
                                    <th>File Name</th>
                                    <th>Last updated</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pdf_rec ?? [] as $pdf)
                                    <tr>
                                        <td style="height: 100px">
                                            <img src="https://placehold.co/250?text=PDF" alt="Image Preview"
                                                style="object-fit: contain;height: 100%;border-radius: 10px">
                                        </td>
                                        <td>
                                            {{ $pdf->file_name ?? '' }}
                                        </td>
                                        <td> </td>
                                        <td>
                                            <a href="{{ asset($pdf->path) }}" download="{{ $pdf->file_name }}"
                                                class="btn-link text-primary ">Download</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            No PDF Record Found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <table class="table d-none prevtable" id="type2table"> {{-- Attchment Table --}}
                            <thead>
                                <tr>
                                    <th>Thumbnails</th>
                                    <th>File Name</th>
                                    <th>Last updated</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse ($attchment_rec ?? [] as $attachment)
                                    <tr>
                                        <td style="height: 100px">
                                            <img src="https://placehold.co/250?text={{ $attachment->extension }}"
                                                alt="Image Preview"
                                                style="object-fit: contain;height: 100%;border-radius: 10px">
                                        </td>
                                        <td>
                                            {{ $attachment->file_name ?? '' }}
                                        </td>
                                        <td> </td>
                                        <td>
                                            <a href="{{ asset($attachment->path) }}"
                                                download="{{ $attachment->file_name }}"
                                                class="btn-link text-primary ">Download</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            No Attachment Record Found
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                        <table class="table d-none prevtable" id="type3table"> {{-- GIF Table --}}
                            <thead>
                                <tr>
                                    <th>Thumbnails</th>
                                    <th>File Name</th>
                                    <th>Last updated</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($gif_rec ?? [] as $gif)
                                    <tr>
                                        <td style="height: 100px">
                                            <img src="{{ asset($gif->path) }}" alt="Image Preview"
                                                style="object-fit: contain;height: 100%;border-radius: 10px">
                                        </td>
                                        <td>
                                            {{ $gif->file_name ?? '' }}
                                        </td>
                                        <td> </td>
                                        <td>
                                            <a href="{{ asset($gif->path) }}" download="{{ $gif->file_name }}"
                                                class="btn-link text-primary ">Download</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            No GIF Record Found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <table class="table d-none prevtable" id="type4table"> {{-- Video Table --}}
                            <thead>
                                <tr>
                                    <th>Thumbnails</th>
                                    <th>File Name</th>
                                    <th>Last updated</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($video_rec ?? [] as $video)
                                    <tr>
                                        <td style="height: 100px">
                                            <img src="https://placehold.co/250?text={{ $video->extension }}"
                                                alt="Image Preview"
                                                style="object-fit: contain;height: 100%;border-radius: 10px">
                                        </td>
                                        <td>
                                            {{ $video->file_name ?? '' }}
                                        </td>
                                        <td> </td>
                                        <td>
                                            <a href="{{ asset($video->path) }}" download="{{ $video->file_name }}"
                                                class="btn-link text-primary ">Download</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            No video Record Found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>


                    </div>

                    <div class="col-12">
                        <div class="h6">
                            Total : {{ $vault_data->count() }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="col-12 m-1">
                <span class="h6">Created At: <span id="vault_created">2024 02 05</span> </span>
            </div>

            <div class="col-12 m-1">
                <span class="h6">Last Update: <span id="vault_updated">2024 02 05</span> </span>
            </div> --}}

            <div class="col-12 my-3">
                <div class="alert alert-warning text-center" role="alert">
                    <i class="ik ik-info mr-1" title="title"></i>
                    Upgrade to Premium to search Products in PDF and excel. <br>
                    In free trial, only Products (in jpeg, png, …. formats) can be searched.
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab"
        tabindex="0">
        <div class="row">
            <div class="col-12 my-3 mx-2">
                <div class="form-group ">
                    <input type="text" class="form-control w-75" placeholder="Search by File Name" id="search_asset">
                </div>
            </div>

            <div class="col-12" id="easdbfhewbuj">
                @include('panel.user_shop_items.modal.load-asset')
            </div>

            <div class="col-12 d-flex justify-content-center my-3">
                <button class="btn btn-primary shadow-none " id="showcard">Save</button>
            </div>

        </div>

    </div>

</div> <!-- tab-content -->


<script>
</script>



