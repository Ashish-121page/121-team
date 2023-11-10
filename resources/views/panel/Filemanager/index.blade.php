@extends('backend.layouts.main') 
@section('title', 'Asset Manager')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css">

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
            .header-top{
                display: none !important;
            }
            .filterbtn{
                cursor: pointer;
                margin: 0 5px;
            }
            .filterbtn.active{
                color: black;
            }
            .wrapper .page-wrap .main-content{
                padding: 0px !important;
            }
        </style>
    @endpush

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-2 col-12 my-2">
                <div class="d-flex justify-content-start ">
                    <button type="button" class="btn mx-1">
                        <span id="selected_count">0</span> Selected
                    </button>
                    {{-- <button type="button" class="btn exportbtn mx-1">
                        <i class="fas fa-share-alt"></i>
                        Export
                    </button> --}}
                   
                </div>
            </div>

            <div class="col-md-10 col-12 my-2 d-flex align-content-center justify-content-between  ">  
             
                <div class="">
                    <span>
                        Total assets: <b> {{$paginator->total()}} </b> ; 
                    </span>
                    <span>
                        Storage Used: <b>{{ number_format($formattedSize/ (1024 * 1024),2) }} MB</b>
                    </span>
                </div>

                <div class="d-flex gap-2 align-content-center">
                    <select id="file_type" class="form-control mx-2 text-capitalize ">
                        <option value="all" @if (request()->get('file_type') == 'all') selected @endif>All</option>
                        @forelse ($filetypes as $item)
                            <option value="{{ $item }}" @if (request()->get('file_type') == $item) selected @endif>{{ $item }}</option>
                        @empty
                            <option>No Files are Exist</option>
                        @endforelse
                    </select>
                    
                    <div class="d-flex align-content-center ">
                        <a href="{{ route('panel.filemanager.new.view') }}?view=grid&page={{ request()->get('page') ?? 1}}" class="btn btn-icon btn-outline-primary mx-1 @if (request()->get('view','default') == 'grid') active @endif">
                            <i class="fas fa-th-large"></i>
                        </a>
                        <a href="{{ route('panel.filemanager.new.view') }}?view=default&page={{ request()->get('page') ?? 1 }}" class="btn btn-icon btn-outline-primary mx-1 @if (request()->get('view','default') == 'default') active @endif">
                            <i class="fas fa-list"></i>
                        </a>                   

                        <button type="button" class="btn btn-outline-primary mx-1 openupload" data-bs-toggle="modal"
                            data-bs-target="#uploadfiles" title="Upload Assets">
                            <i class="fas fa-cloud-upload-alt"></i> Upload
                        </button>
                        
                    </div>

                </div>
            </div>

            <div class="col-12 w-100 align-content-center d-none justify-content-center " id="quickactionmenu">
                <button type="button" class="btn btn-outline-primary linkproduct">
                    <i class="fas fa-link"></i>
                    LInk to Products
                </button>

                <button type="button" class="btn btn-outline-primary deletebtn mx-1">
                    <i class="fas fa-trash"></i>
                    Delete
                </button>
            </div>
            
        </div>

        <div class="row">
            
            @if (request()->has('view') && request()->get('view') == 'default' )
                @include('panel.Filemanager.view.table')
            @elseif(request()->has('view') && request()->get('view') == 'grid')
                @include('panel.Filemanager.view.grid')
            @else
                @include('panel.Filemanager.view.table')
            @endif

            <div class="col-12">
                {{-- ` Pagination --}}
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        
                        @php
                            $currentPage = request()->get('page',1);
                            $previousPage = ($currentPage != 1) ? $currentPage -1 : 1;
                            $lastPage = ($currentPage != $paginator->lastpage()) ? $currentPage + 1 : $paginator->lastpage();
                            $view = request()->get('view','default');
                        @endphp
                        
                    <li class="page-item">
                        <a class="page-link" href="{{ request()->url() }}?view={{$view}}&page={{$previousPage}}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    
                    @for ($i = 1; $i <= $paginator->lastpage(); $i++)
                        <li class="page-item @if ($i == $currentPage) active @endif ">
                            <a class="page-link" href="{{ request()->url() }}?view={{$view}}&page={{$i}}">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor
                    
                    <li class="page-item">
                        <a class="page-link" href="{{ request()->url() }}?view={{$view}}&page={{$lastPage}}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    </ul>
                </nav>
            </div>

        </div>



    </div>


    <form action="{{ route('panel.filemanager.delete') }}" id="deletefileform">
        <input type="hidden" name="user_id" id="user_id" value="{{ encrypt(auth()->id()) }}">
        <input type="hidden" name="files" id="filesId" value="{{ encrypt(auth()->id()) }}">
    </form>

    <form action="{{ route('panel.filemanager.downloadZip') }}" id="downloadZipform" method="POST">
        <input type="hidden" name="user_id" id="user_id" value="{{ encrypt(auth()->id()) }}">
        <input type="hidden" name="files" id="downloadZipfilesId" value="{{ encrypt(auth()->id()) }}">
    </form>

    <form action="{{ request()->url('/') }}" id="filterform" method="GET">
        <input type="hidden" name="filtertype" id="filtertypeinp" value="{{ encrypt(auth()->id()) }}">
        <input type="hidden" name="filtername" id="filteranameinp" value="{{ encrypt(auth()->id()) }}">
        <input type="hidden" name="view" id="filterviewinp" value="{{ request()->get('view','default') }}">

    </form>

    
    <form action="{{ request()->url('/') }}" id="file_typeForm" method="GET">
        <input type="hidden" name="file_type" id="file_typeinp" value="">
        <input type="hidden" name="view" id="filterviewinp" value="{{ request()->get('view','default') }}">

    </form>


    @include('panel.Filemanager.modals.upload')
    @include('panel.Filemanager.modals.link-product')
    
    <!-- push external js -->
    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>

    

        <script src="{{ asset('backend/js/jquery.editable.js') }}"></script>
        <script>
            $(document).ready(function () {

                // {{--` Check File --}}
                $(".checkme").click(function (e) {
                    let checkall = $("#checkall");
                    checkall.prop("checked");
                    $("#selected_count").html($(".checkme:checked").length);
                });

                // {{--` Check All --}}
                $("#checkall").click(function (e) {
                    $(".checkme").click();
                });

                $(".checkme").change(function (e) { 
                    myfunc();
                });
                
                function myfunc() {
                    if ($(".checkme:checked").length > 0) {
                        // any one is checked
                        $("#quickactionmenu").removeClass('d-none');
                        $("#quickactionmenu").addClass('d-flex');
                    } else {
                        $("#quickactionmenu").addClass('d-none');
                        $("#quickactionmenu").removeClass('d-flex');
                    }
                }
                
                // myfunc();
                
                // {{--` Delete Item --}}
                $(".deletebtn").click(function (e) { 
                    e.preventDefault();
                    let selected = $(".checkme:checked").length;
                    
                    var msg = `
                    <span class="text-danger">You are about to delete ${selected} asset(s)</span> <br/>
                    <span>This action cannot be undone. To confirm type <b>DELETE</b></span>
                    <input type='text' id='margin' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='DELETE'>`;

                    $.confirm({
                        draggable: true,
                        title: `Delete ${selected} asset(s)`,
                        content: msg,
                        type: 'blue',
                        typeAnimated: true,
                        buttons: {
                            tryAgain: {
                                text: 'DELETE',
                                btnClass: 'btn-danger',
                                action: function(){
                                    let margin = $('#margin').val();
                                    if (margin == 'DELETE') {

                                        var arr = [];
                                        $('input.checkme:checkbox:checked').each(function () {
                                            arr.push($(this).val());
                                        });
                                        $("#filesId").val(arr);
                                        $("#action").val('deleteFile');
                                        $("#deletefileform").submit();
                                        
                                    } else {
                                        $.alert('Type DELETE to Proceed');
                                    }

                                    
                                }
                            },
                            close: function () {

                            }
                        }
                    });
                });





                // {{--` Export Item --}}
                $(".exportbtn").click(function (e) { 
                    e.preventDefault();
                    var arr = [];
                    $('input.checkme:checkbox:checked').each(function () {
                        arr.push($(this).val());
                    });
                                        
                    $("#downloadZipfilesId").val(arr);
                    $("#downloadZipform").submit();

                });


                // {{--` linkproduct Button--}}
                
                $(".linkproduct").click(function (e) { 
                    e.preventDefault();
                    $("#linkproductModal").modal('show')
                    
                    var arr = [];
                    $('input.checkme:checkbox:checked').each(function () {
                        arr.push($(this).val());
                    });
                    $("#imagelinkModel").val(arr);
                    console.table(arr);
                    
                });
                

                $(".filterbtn").click(function (e) { 
                    e.preventDefault();
                    let filtertype = $(this).data('filtertype');
                    let filteraname = $(this).data('filteraname');
                    let filterform = $("#filterform");
                    let filterviewinp = $("#filterviewinp");
                    let filteranameinp = $("#filteranameinp");
                    let filtertypeinp = $("#filtertypeinp");


                    filtertypeinp.val(filtertype);
                    filteranameinp.val(filteraname);
                    filterform.submit();


                });

                $("#file_type").change(function (e) { 
                    e.preventDefault();
                    let formview = $("#file_typeForm");
                    let forminp = $("#file_typeinp");

                    forminp.val($(this).val());
                    formview.submit();
                });



                // {{--` Renaming File --}}
                $(".filename").click(function (element) {
                    let oldname = $(this).data('oldname');

                    $(this).editable("dblclick", function (e) {
                       if (e.value != '') {
                        $.ajax({
                            type: "post",
                            url: "{{ route('panel.filemanager.rename') }}",
                            data: {
                                'oldName': oldname,
                                'newName': e.value,
                            },
                            dataType: "json",
                            success: function (response) {
                                // console.log(response);
                            }
                        });
                       }
                    });
                });

            });
        </script>

        
        {{-- ` Upload Script --}}
        <script>
            Dropzone.options.myDropzone = {
                paramName: 'file', // The name of the file input field
                maxFilesize: 500, // Max file size in MB
                // acceptedFiles: '.jpg, .jpeg, .png, .gif, .avif, .webp, .svg, .mkv, .mp4', // Accepted file types
                dictDefaultMessage: 'Drag and drop your files here or click to upload',
                success: function (file, response) {
                    // console.log('File uploaded to: ' + response.path);
                },
                error: function (response) { 
                    console.log(response);
                }
            };
        </script>
    @endpush
@endsection
