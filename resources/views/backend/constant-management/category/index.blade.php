@extends('backend.layouts.main') 
@section('title', 'Category')

@section('content')
@push('head')

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.2.0/animate.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.css">
    <style>
        .remove-ik-class {
            -webkit-box-shadow: unset !important;
            box-shadow: unset !important;
        }

        li {
            list-style: none;
            margin: 0 0 0 -30px;
        }
        .bg-none{
            background: transparent !important;
        }
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary.active {
            background-color: #6666cc;
            border: 1px solid #6666cc;
            color: #ffffff !important;
        }
        .bootstrap-tagsinput{
            width: 100%;
        }
        /* .select2-results__option */
        .select2-selection__rendered li,.select2-results__options li{
            margin: 5px !important;
        }
    </style>
@endpush


    <div class="container-fluid">

        <div class="row my-2">
            <div class="col-12 d-flex justify-content-between">
                <a href="{{ route('panel.user_shop_items.create') }}?type=direct&type_ide={{encrypt(auth()->id())}}" class="btn btn-outline-secondary"> 
                    Back
                </a>
                <div class="d-flex">
                    <a class="btn btn-outline-primary mx-1" id="addcategory" href="#animatedModal" role="button">
                        <i class="fa fa-plus" aria-hidden="true"></i> Create Category
                    </a>
                    {{-- <button type="button" class="btn btn-outline-primary openglobal mx-1" data-bs-toggle="modal" data-bs-target="#selectGlobalMOdal">
                        Select Global Category
                    </button> --}}
                </div>
            </div>
        </div>

        <div class="row">
            @if (AuthRole() == 'Admin')
                @include('backend.constant-management.category.view.admin-view')    
            @else
                @include('backend.constant-management.category.view.user-view')
            @endif
        </div>

    </div>


      

    @include('backend.constant-management.category.include.modal')
    @include('backend.constant-management.category.include.select_global')
    @include('backend.constant-management.category.include.add-category')
    @include('backend.constant-management.category.include.industry')     

    <!-- push external js -->
    @push('script')
        <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                    
                $("#addcategory").animatedModal({
                    animatedIn: 'lightSpeedIn',
                    animatedOut: 'lightSpeedOut',
                    color: 'FFFFFF',
                    height: '60%',
                    width: '60%',
                    top: '24%',
                    left: '40%',
                });
                $("#demo01").click();

                var table = $('#category_table').DataTable({
                    responsive: true,
                    fixedColumns: true,
                    fixedHeader: true,
                    scrollX: false,
                    'aoColumnDefs': [{
                        'bSortable': false,
                        'aTargets': ['nosort']
                    }],
                    dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                    buttons: [
                        {
                            extend: 'excel',
                            className: 'btn-sm btn-success',
                            header: true,
                            footer: true,
                            exportOptions: {
                                columns: ':visible',
                            }
                        },
                        'colvis',
                        {
                            extend: 'print',
                            className: 'btn-sm btn-primary',
                            header: true,
                            footer: false,
                            orientation: 'landscape',
                            exportOptions: {
                                columns: ':visible',
                                stripHtml: false
                            }
                        }
                    ]
                });

                
                $(".editchange").click(function (e) { 
                    e.preventDefault();
                    // Enabling Input Value
                    let box_parent = $(this).data('box-parent');
                    let box_edit = $(this).data('box-edit');
                    // Hide text
                    $("#"+box_parent).addClass('d-none');
                    $("#"+box_parent).removeClass('d-flex');
                    // Enable Input
                    $("#"+box_edit).removeClass('d-none');
                    $("#"+box_edit).addClass('d-flex');
                });


                $(".discardchange").click(function (e) { 
                    e.preventDefault();
                    // Enabling Input Value
                    let box_parent = $(this).data('box-parent');
                    let box_text = $(this).data('box-text');

                    // Hide text
                    $("#"+box_parent).addClass('d-none');
                    $("#"+box_parent).removeClass('d-flex');
                    // Enable Input
                    $("#"+box_text).removeClass('d-none');
                    $("#"+box_text).addClass('d-flex');
                });


                $(".updatechange").click(function (e) { 
                    e.preventDefault();
                    // {{-- ` Input Value  --}}
                    let input_parent = $(this).data('input-parent'); 

                    // {{-- ` Id Of The Category --}}
                    let typevalue = $(this).data('typevalue');
                    let text = $("#text-represent-"+input_parent.split('_')[2]);
                    let value = $("#"+input_parent).val();
                    
                    $.ajax({
                        type: "GET",
                        url: "{{ route('panel.constant_management.category.update.ajax') }}",
                        data: {
                            'task': 'update_name',
                            'value': value,
                            'id': typevalue,
                            'user_id': '{{ auth()->id()}} '
                        },
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
                            text.html(value)
                            $(".discardchange").click();
                        }
                    });
                    
                });

                                
                // Add Items
                $(".additems").click(function (e) { 
                    e.preventDefault();
                    let parent = $(this).data('parentdata');
                    let item = `<div class="col-3 my-2">
                        <div class="justify-content-between gap-2 d-flex" id="added_item">
                        <input type="text" name="changeme" class="form-control added_item-${parent}" placeholder="Enter New Value" >
                    </div>`;
                    $(`.savebtn[data-parentdata='${parent}']`).removeClass('d-none')

                    $("#"+parent).append(item);
                });


                $(".savebtn").click(function (e) { 
                    e.preventDefault();
                    let parent = $(this).data('parentdata');
                    let valuearr = [];


                    let items = document.querySelectorAll(`.added_item-${parent}`);
                    
                    items.forEach(element => {
                        valuearr.push(element.value);
                    });

                    let typevalue = $(this).data("parent-id");;



                    $.ajax({
                        type: "GET",
                        url: "{{ route('panel.constant_management.category.update.ajax') }}",
                        data: {
                            'task': 'add_new',
                            'value': valuearr,
                            'id': typevalue,
                            'user_id': '{{ auth()->id()}} '
                        },
                        dataType: "json",
                        success: function (response) {
                            // console.log(response);
                            window.location.reload();
                        }
                    });
                });


                $(".collapseicon").click(function (e) { 

                    $(this).toggleClass('btn-primary');
                    $(this).toggleClass('bg-none');
                    $(this).find('i').toggleClass('fa-angle-right')
                    $(this).find('i').toggleClass('fa-angle-down')

                });

                $("#newcatname").change(function (e) { 
                    e.preventDefault();
                    let newval = $(this).val();


                    let newvalue = newval.split(" > ")[1];
                    
                    $('#tags').tagsinput('add',newvalue);


                    
                    // $.ajax({
                    //     type: "GET",
                    //     url: "{{ route('panel.constant_management.category.check.global') }}",
                    //     data: {
                    //         "search": newval
                    //     },
                    //     success: function (response) {
                    //         response = JSON.parse(response);
                    //         console.table(response);
                    //         if (response['status'] === 'SUCCESS') {
                    //             console.log("SuccessFULL");

                    //             console.log(response['DATA']);
                    //             $("#tags").val(response['DATA']);
                                
                    //             $('#tags').tagsinput('refresh');

                    //         }
                    //     }
                    // });

                });


            });
        </script>
    @endpush

@endsection
