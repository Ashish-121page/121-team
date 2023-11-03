@extends('backend.layouts.main') 
@section('title', 'Manage Currency')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
        <style>
            .preview-img {
                height: 70px;
                width: 70px;
            }

            .preview-img img {
                height: 100%;
                width: 100%;
                object-fit: contain;
            }
        </style>
    @endpush

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6 col-12 my-2">
                <div class="d-flex justify-content-between ">
                    <button type="button" class="btn">
                        <span id="selected_count">0</span> Selected
                    </button>
                    <button type="button" class="btn">
                        <i class="fas fa-share-alt"></i>
                        Export
                    </button>
                    <button type="button" class="btn text-danger">
                        <i class="fas fa-trash"></i>
                        Delete
                    </button>
                    <button type="button" class="btn">
                        <i class="fas fa-link"></i>
                        LInk to Products
                    </button>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12 col-12">
                <table class="table">
                    <thead class="bg-primary">
                        <tr>
                            <th scope="col" class="text-light">
                                <input type="checkbox" id="checkall">
                            </th>
                            <th scope="col" class="text-light">
                                Thumbnail
                            </th>
                            <th scope="col" class="text-light">Asset Name</th>
                            <th scope="col" class="text-light">Size</th>
                            <th scope="col" class="text-light">Extension</th>
                            <th scope="col" class="text-light">File Type</th>
                            <th scope="col" class="text-light">Last Modified</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($files as $file)
                            <tr>
                                <th scope="row">
                                    <input type="checkbox" name="checkthis" id="checkthis" class="form-check checkme">
                                </th>
                                <td class="preview-img">
                                    <img src="{{ asset(Storage::url($file)) }}" alt="Thumbnail of The Image.">
                                </td>
                                <td class="filename">
                                    {{ basename($file) }}
                                </td>
                                <td>
                                    {{ number_format(Storage::size($file)/ (1024 * 1024),2) }} MB
                                </td>
                                <td>
                                    {{ pathinfo($file, PATHINFO_EXTENSION) }}
                                </td>
                                <td>
                                    {{ Storage::mimeType($file) }}
                                </td>
                                <td>
                                    <i class="far fa-edit"></i>
                                    <span>
                                        {{ date("Y-m-d H:i:s",Storage::lastModified($file)) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                        
                            <tr>
                                <td colspan="6" class="text-center">
                                    No Files are Exist
                                </td>
                            </tr>
                            
                        @endforelse
                        
                 
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    
    <!-- push external js -->
    @push('script')
    
        <script>
            $(document).ready(function () {
                $(".checkme").click(function (e) {
                    let checkall = $("#checkall");

                    checkall.prop("checked");

                    $("#selected_count").html($(".checkme:checked").length);
                });

                $("#checkall").click(function (e) {
                    $(".checkme").click();
                });

                $(".filename").click(function (element) {
                    $(this).editable("dblclick", function (e) {
                        alert(e.old_value + " : " + e.value);
                    });
                });
            });
        </script>

        
        
    @endpush
@endsection
