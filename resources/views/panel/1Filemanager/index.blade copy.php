@extends('backend.layouts.main') 
@section('title', 'Asset Manager')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css"> --}}
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/dropzone.min.css') }}">
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"> --}}
        <style>
            .preview-img {
                height: 70px;
                width: 70px;
            }
            @media (min-width: 576px) {
                .modal-dialog {
                    max-width: 1361px;
                    margin: 1.75rem auto;
                }
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
            /* .sidebar-mini{
                overflow: hidden !important;
            } */

            /* .frozen-part {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100px; 
            background-color: #f0f0f0; 
            z-index: 999;
            } */

            /* code from products */
            .card-body1{
                 -ms-flex:1 1 auto;
                    flex:1 1 auto;
                    padding:1.25rem;
                    max-height: 75vh;
                    overflow-y: auto;
            }
            .btn-orange{
                background-color: #fdede7;
                color: #4f3643;
            }
        </style>
    @endpush
    <div class="frozen-part">
        <div class="container-fluid">
            
                <div class="row">

                    <div class="col-md-12 col-12 my-2 d-flex align-content-right justify-content-end  ">  
                    
                        {{-- <div class="">
                            <span>
                                Total assets: <b> {{$paginator->total()}} </b> ; 
                            </span>
                            <span>
                                Storage Used: <b>{{ number_format($formattedSize/ (1024 * 1024),2) }} MB</b>
                            </span>
                        </div> --}}

                        <div class="d-flex gap-2 align-content-center">
                            <select id="file_type" class="form-control mx-2 text-capitalize ">
                                <option value="all" @if (request()->get('file_type') == 'all') selected @endif>All</option>
                                @forelse ($filetypes as $item)
                                    <option value="{{ $item }}" @if (request()->get('file_type') == $item) selected @endif>{{ $item }}</option>
                                @empty
                                    <option>No Files are Exist</option>
                                @endforelse
                            </select>
                            
                            <div class="d-flex align-content-center">
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

                    <div class="col-12 w-100 align-content-center d-none justify-content-center " id="quickactionmenu" >                        
                                <button type="button" class="btn mx-5">
                                    <span id="selected_count">0</span> Selected
                                </button>
                        <button type="button" class="btn btn-outline-primary linkproduct">
                            <i class="fas fa-link"></i>
                            Link to Products
                        </button>

                        <button type="button" class="btn btn-outline-primary deletebtn mx-1">
                            <i class="fas fa-trash"></i>
                            Delete
                        </button>
                    </div>
                    
                </div>
                <div class="card-body1">

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
    @include('panel.Filemanager.modals.Link-items')
    @include('panel.Filemanager.modals.LinkWithName')
    
    <!-- push external js -->
    @push('script')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>    --}}
    <script src="{{ asset('frontend/assets/js/dropzone.min.js') }}"></script>
    

        <script src="{{ asset('backend/js/jquery.editable.js') }}"></script>
        <script>
            $(document).ready(function () {
                
                // Store the file path in localStorage
                // var recentFilePaths = localStorage.getItem("recentFilePaths");
                // if (recentFilePaths) {
                //     recentFilePaths = JSON.parse(recentFilePaths);
                // } else {
                    recentFilePaths = [];
                    recentFileName = [];
                // }
                
                // $("#linkItems").modal('show')

                $("#openlinkfile").click(function (e) { 
                    e.preventDefault();
                    $("#uploadfiles").modal('hide');
                    $("#linkItems").modal('show');
                    let newval = JSON.stringify(recentFilePaths)
                    $("#imagestolinkjs").val(newval)
                    console.log($("#imagestolinkjs").val());

                });


                // {{--` Check File --}}
                $(".checkme").click(function (e) {
                    let checkall = $("#checkall");
                    $("#selected_count").html($(".checkme:checked").length);

                    if ($(".checkme:checked").length > 0) {
                        // any one is checked
                        checkall.prop("checked",true);
                    } else {
                        checkall.prop("checked",false);
                    }
                });

                // {{--` Check All --}}
                $("#checkall").click(function (e) {
                    
                    if ($(".checkme:checked").length < $(".checkme").length) {
                        $(".checkme").prop('checked',false)
                        $(".checkme").click()
                        $(this).prop('checked',true);
                        myfunc()
                    }else{
                        $(".checkme").prop('checked',false)
                        $(this).prop('checked',false);
                        myfunc()
                    }


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
                    // console.table(response)

                    // Add the new file Filename
                    recentFilePaths.push(response.path);
                    recentFileName.push(response.Filename);

                    // Optionally, limit the number of stored paths to avoid localStorage overflow
                    const maxPaths = 30;
                    if (recentFilePaths.length > maxPaths) {
                        recentFilePaths = recentFilePaths.slice(-maxPaths); // Keep only the last 'maxPaths' entries
                    }

                    localStorage.setItem("recentFilePaths", JSON.stringify(recentFilePaths));
                },
                error: function (file, response) { 
                    if(response.error){
                        // Create a reference to the Dropzone instance
                        var myDropzone = this;

                        // Remove the file preview
                        myDropzone.removeFile(file);

                        // Now add a new file preview with the error message
                        var mockFile = { name: file.name, size: file.size, status: Dropzone.ERROR, accepted: false };
                        myDropzone.files.push(mockFile);
                        myDropzone.emit("addedfile", mockFile);
                        myDropzone.emit("error", mockFile, response.error);
                        myDropzone.emit("complete", mockFile);
                    }
                }
            };

            $("#linkgfyusebh").click(function (e) { 
                e.preventDefault();
                $("#linkItems").modal('hide')
                $("#linkwithnameModal").modal('show')
            });
            

            $("#usdfjsd").click(function (e) { 
                e.preventDefault();
                let form  = $("#delimetersaprationform");
                $("#filepathsinp").val(JSON.stringify(recentFilePaths));
                $("#fileNameinp").val(JSON.stringify(recentFileName));
                form.submit();
            });


            $("#fjxigusd").click(function (e) { 
                e.preventDefault();
                let saperatorSymbol = '';
                switch ($("#delimiter").val()) {
                    case 'underscore':
                        saperatorSymbol = "_";
                        break;
                    case 'dash':
                        saperatorSymbol = "-";
                        break;

                    case 'dot':
                        saperatorSymbol = ".";
                        break;

                    case 'hashtag':
                        saperatorSymbol = "#";
                        break;

                    default:
                        saperatorSymbol = "_";
                        break;
                }

                if ($("#alignment").val() == '0') {
                    $("#usdhgn").html("Modal Code") // One Col
                    $("#sdhfjn").html("Filename") // Two Col
                } else {
                    $("#usdhgn").html("Filename") // One Col
                    $("#sdhfjn").html("Modal Code") // Two Col
                }


                let count = 1;
                $("#yetsidh").html('');

                recentFileName.forEach(element => {
                    element = element.replace(/\.[^/.]+$/, "");
                    let res = element.split(saperatorSymbol);

                    let htm = `
                    <tr>
                        <td> ${count} </td>
                        <td> ${res[0]} </td>
                        <td> ${res[1]} </td>
                    </tr>
                    `;
                    count++;
                    $("#yetsidh").append(htm);
                    
                });
                
                
                

            });


            $("#searchinlinking").keyup(function (e) { 
                // e.preventDefault();
                let inpval = $(this).val()
                $.ajax({
                    type: "GET",
                    url: "{{ route('panel.filemanager.index') }}",
                    data: {
                        'searchCode':inpval,
                        'workload': 'linkproductsearch'
                    },
                    dataType: "json",
                    success: function (response) {
                        $('body').find('#sdhfuyweguygd2qw').html(response);
                    },
                    error: function (response) { 
                        $('body').find('#sdhfuyweguygd2qw').html(response.responseText);

                        document.getElementById('select-all').addEventListener('click', function () {
                            toggleCheckboxes(this);
                        });
                        document.querySelectorAll('.item-checkbox').forEach(function (checkbox) {
                            checkbox.addEventListener('click', updateSelectedCount);
                        });                        
                    } 
                });



            })
            

            $(".page-linkajax").click(function (e) { 
                e.preventDefault();
                //   remove Active Class

                $.each($(".page-itemajax"), function (indexInArray, valueOfElement) { 
                     $(this).removeClass('active');
                });
                                
                $(this).parent().addClass('active')
                
                let page = $(this).data('pagenum');
                $.ajax({
                    type: "GET",
                    url: "{{ route('panel.filemanager.index') }}",
                    data: {
                        'page':page,
                        'workload': 'linkproductsearch'
                    },
                    dataType: "json",
                    success: function (response) {
                        $('body').find('#sdhfuyweguygd2qw').html(response);
                    },
                    error: function (response) { 
                        $('body').find('#sdhfuyweguygd2qw').html(response.responseText);

                        document.getElementById('select-all').addEventListener('click', function () {
                            toggleCheckboxes(this);
                        });
                        document.querySelectorAll('.item-checkbox').forEach(function (checkbox) {
                            checkbox.addEventListener('click', updateSelectedCount);
                        });                        
                    } 
                });

            });

        </script>
    @endpush
@endsection
