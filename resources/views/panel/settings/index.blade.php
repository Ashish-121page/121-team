@extends('backend.layouts.main')
@section('title', 'Settings')
@section('content')

    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
    <link href="{{ asset('frontend/assets/css/simplebar.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">

    <!-- push external head elements to head -->
    @push('head')
        <style>
            .page-item.active {
                background-color: transparent;
            }


            .bootstrap-tagsinput .tag {
                text-transform: none !important;
            }

            .bootstrap-tagsinput {
                width: 100% !important;
            }

            .cust_input label {
                height: 75px;
                width: 95px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 8px;
                margin: 10px;
                transition: 0.3s;
                cursor: pointer;
                gap: 10px;
            }

            .active {
                background-color: #6666cc;
                color: white;
            }

            .cust_input input {
                display: none;
            }

            .cust_input label:hover {
                background-color: #6666cc;
                color: white;
                fill: white;
            }

            .cust_input label:active {
                transform: scale(0.8);
            }
        </style>
    @endpush

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6 col-12 my-2">
                <div class="one" style="display: flex;align-items: center;justify-content: flex-start;">

                    <a href="{{ request()->url() }}?open=acc_info&active=shop-details"
                        class="btn btn-outline-primary @if (request()->get('open') == 'acc_info') active @endif mx-1">
                        Account Info
                    </a>
                    <a href="{{ request()->url() }}?open=entities"
                        class="btn btn-outline-primary @if (request()->get('open') == 'entities') active @endif mx-1">
                        Entity
                    </a>

                    <a href="{{ request()->url() }}?open=custinp"
                        class="btn btn-outline-primary @if (request()->get('open') == 'custinp') active @endif mx-1">
                        Custom
                    </a>

                    <a href="{{ request()->url() }}?open=team"
                        class="btn btn-outline-primary @if (request()->get('open') == 'team') active @endif mx-1">
                        Team
                    </a>
                </div>
            </div>


            {{-- ` This Menu is Always Visible  --}}

            <div class="col-md-6 col-12 my-2">
                @if (!request()->has('open'))
                    <div class="two" style="display: flex;align-items: center;justify-content: flex-end;">
                        <a href="https://forms.gle/W7xxYt9gwzamse9TA" target="_blank" class="btn btn-outline-primary mx-1">
                            Create New
                        </a>
                    </div>
                @endif
            </div>


        </div>

        <div class="row">

            @if (request()->has('open') && request()->get('open') == 'offers')
                @include('panel.settings.pages.Offers')

            @elseif (request()->has('open') && request()->get('open') == 'acc_info')
                @include('panel.settings.pages.acc_info')

            @elseif (request()->has('open') && request()->get('open') == 'team')
                @include('panel.settings.pages.Team')


            @elseif (request()->has('open') && request()->get('open') == 'custinp')
                @include('panel.settings.pages.CustomField')

            @elseif (request()->has('open') && request()->get('open') == 'entities')
                @include('panel.settings.pages.Entity')
            @else
                @include('panel.settings.pages.Template')
            @endif
        </div>

    </div>


    @include('frontend.customer.dashboard.includes.modal.add-currencies')
    @include('frontend.customer.dashboard.includes.modal.update-currency')
    @include('frontend.customer.dashboard.includes.modal.update-currency')
    @include('panel.settings.pages.Edit-customField')


    <!-- push external js -->
    @push('script')
        <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

        <script src="{{ asset('backend/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
        <script src="{{ asset('backend/js/form-advanced.js') }}"></script>

        <script>
            function html_table_to_excel(type) {
                var table_core = $("#table").clone();
                var clonedTable = $("#table").clone();
                clonedTable.find('[class*="no-export"]').remove();
                clonedTable.find('[class*="d-none"]').remove();
                $("#table").html(clonedTable.html());
                var data = document.getElementById('table');

                var file = XLSX.utils.table_to_book(data, {
                    sheet: "sheet1"
                });
                XLSX.write(file, {
                    bookType: type,
                    bookSST: true,
                    type: 'base64'
                });
                XLSX.writeFile(file, 'Excel_export.' + type);
                $("#table").html(table_core.html());

            }

            $(document).on('click', '#export_button', function() {
                html_table_to_excel('xlsx');
            })


            $('#reset').click(function() {
                var url = $(this).data('url');
                getData(url);
                window.history.pushState("", "", url);
                $('#TableForm').trigger("reset");
                //   $('#fieldId').select2('val',"");               // if you use any select2 in filtering uncomment this code
                // $('#fieldId').trigger('change');                  // if you use any select2 in filtering uncomment this code
            });
        </script>
        <script>
            $(document).ready(function() {
                $(".updatecurrencybtn").click(function(e) {
                    e.preventDefault();

                    let crrname = $(this).data('crrname');
                    let crrid = $(this).data('crrid');
                    let crrvalue = $(this).data('crrvalue');

                    $('#currencyname').val(crrname);
                    $('#crrid').val(crrid);

                    $('#currencyvalue').val(crrvalue);


                    $("#updatecurrency").modal('show')
                });

                $("#addcurrencyopen").click(function(e) {
                    e.preventDefault();
                    $('#addcurrency').modal('show');
                });
                $("#addmember").click(function(e) {
                    e.preventDefault();
                    $("#addTeam").modal("show");
                });

                $(".select2insidemodalTeam").select2({
                    dropdownParent: $("#addTeam")
                });

                $('#otpButtonteam').on('click', function(e) {
                    e.preventDefault();
                    var number = $('#contact_number').val();
                    if (number != '' && number != null) {
                        $.ajax({
                            url: "{{ route('panel.user.send-otp') }}",
                            method: 'GET',
                            data: {
                                phone_no: number
                            },
                            success: function(response) {
                                if (response.title == 'Error') {
                                    $.toast({
                                        heading: response.title,
                                        text: response.message,
                                        showHideTransition: 'slide',
                                        icon: 'error',
                                        loaderBg: '#f2a654',
                                        position: 'top-right'
                                    });
                                } else {
                                    $.toast({
                                        heading: response.title,
                                        text: response.message,
                                        showHideTransition: 'slide',
                                        icon: 'success',
                                        loaderBg: '#f96868',
                                        position: 'top-right'
                                    });
                                }
                                $('.otpaction1').removeClass('d-none');
                                $('.otpaction2').removeClass('d-none');
                                $('.additionalNumber').attr('readonly', true);
                                1
                                $('#OTP').html(response.otp)
                            }
                        });
                    } else {
                        $.toast({
                            heading: "Error",
                            text: "The number is required",
                            showHideTransition: 'slide',
                            icon: 'error',
                            loaderBg: '#f2a654',
                            position: 'top-right'
                        });
                    }
                });

                $('#verifyOTP').on('click', function(e) {
                    e.preventDefault();
                    $('#saveBtn').attr('disabled', false);
                    $('.check-icon').removeClass('d-none');
                    var verifyOTP = $('#otp_num').val();
                    $.ajax({
                        url: "{{ route('panel.user.verify-otp') }}",
                        method: 'GET',
                        data: {
                            "otp": verifyOTP
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.title == 'Error') {
                                $.toast({
                                    heading: response.title,
                                    text: response.message,
                                    showHideTransition: 'slide',
                                    icon: 'error',
                                    loaderBg: '#f2a654',
                                    position: 'top-right'
                                });
                            } else {
                                $.toast({
                                    heading: response.title,
                                    text: response.message,
                                    showHideTransition: 'slide',
                                    icon: 'success',
                                    loaderBg: '#f96868',
                                    position: 'top-right'
                                });
                                $(this).addClass('d-none');

                                $("#TeamForm").submit();
                            }
                        }
                    })
                })
            });
        </script>

        <script>
            $(".editchange").click(function(e) {
                e.preventDefault();
                // Enabling Input Value
                let box_parent = $(this).data('box-parent');
                let box_edit = $(this).data('box-edit');
                // Hide text
                $("#" + box_parent).addClass('d-none');
                $("#" + box_parent).removeClass('d-flex');
                // Enable Input
                $("#" + box_edit).removeClass('d-none');
                $("#" + box_edit).addClass('d-flex');
            });

            $(".discardchange").click(function(e) {
                e.preventDefault();
                // Enabling Input Value
                let box_parent = $(this).data('box-parent');
                let box_text = $(this).data('box-text');

                // Hide text
                $("#" + box_parent).addClass('d-none');
                $("#" + box_parent).removeClass('d-flex');
                // Enable Input
                $("#" + box_text).removeClass('d-none');
                $("#" + box_text).addClass('d-flex');
            });

            $(".updatechange").click(function(e) {
                e.preventDefault();
                // {{-- ` Input Value  --}}
                let input_parent = $(this).data('input-parent');

                // {{-- ` Id Of The Category --}}
                let typevalue = $(this).data('typevalue');
                let text = $("#text-represent-" + input_parent.split('_')[2]);
                let value = $("#" + input_parent).val();

                $.ajax({
                    type: "GET",
                    url: "{{ route('panel.constant_management.category.update.ajax') }}",
                    data: {
                        'task': 'update_name',
                        'value': value,
                        'id': typevalue,
                        'user_id': '{{ auth()->id() }} '
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        text.html(value)
                        $(".discardchange").click();
                    }
                });

            });

            // Add Items
            $(".additems").click(function(e) {
                e.preventDefault();
                let parent = $(this).data('parentdata');
                let item = `<div class="col-3 my-2">
                    <div class="justify-content-between gap-2 d-flex" id="added_item">
                    <input type="text" name="changeme" class="form-control added_item-${parent}" placeholder="Enter New Value" >
                </div>`;
                $(`.savebtn[data-parentdata='${parent}']`).removeClass('d-none')

                $("#" + parent).append(item);

                $("input").keypress(function(e) {
                    console.log(e.target.value);
                    var keyCode = e.which;
                    var keyChar = String.fromCharCode(keyCode);
                    var specialChars = ["#", '$', '=', '{', '}', '|', '\\', ';', '"', "'", '?', '/', '~', '`',
                '!'
            ]; // Array of special characters

            if (specialChars.includes(keyChar)) {
                e.preventDefault(); // Prevent entering special characters
            }
        });

    });

    $(".savebtn").click(function(e) {
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
                        'user_id': '{{ auth()->id() }} '
                    },
                    dataType: "json",
                    success: function(response) {
                        // console.log(response);
                        window.location.reload();
                    }
                });
            });

            $(".collapseicon").click(function(e) {

                $(this).toggleClass('btn-primary');
                $(this).toggleClass('bg-none');
                $(this).find('i').toggleClass('fa-angle-right')
                $(this).find('i').toggleClass('fa-angle-down')

            });
        </script>

        <script>
            $(document).ready(function() {

                $('#custtags').tagsinput('items');

                var hideitif = ['text', 'interger', 'dimension', 'uom'];


                $(".editCust").click(function(e) {
                    e.preventDefault();
                    let values = $(this).data('values');
                    let custname = $(this).data('custname');
                    let custid = $(this).data('custid');
                    let attr_section = $(this).data('attr_section');
                    let custreq = $(this).data('required');
                    let data_type = $(this).data('data_type');

                    $("#custtags").tagsinput('add', values)
                    $("#custattr_section").val(attr_section);
                    $("#custname").val(custname);
                    $("#custid").val(custid);
                    $("#custreq").val(custreq)
                    $("#dattype").val(data_type)

                    if (hideitif.includes(data_type)) {
                        $("#modalitevaluie").addClass('d-none');
                    } else {
                        $("#modalitevaluie").removeClass('d-none');
                    }



                    $("#EditCustField").modal('show')
                    $(".select2").trigger("change")
                    $('#custtags').tagsinput('refresh');

                });


                $(".delete-btn").click(function(e) {
                    e.preventDefault();
                    var url = $(this).attr('href');

                    var msg =
                        `
                    <span class="text-danger">You are about to delete Custom Field</span> <br/>
                    <span>This action cannot be undone. To confirm type <b>DELETE</b></span>
                    <input type='text' id='margin' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='DELETE'>`;

                    $.confirm({
                        draggable: true,
                        title: `Delete`,
                        content: msg,
                        type: 'blue',
                        typeAnimated: true,
                        buttons: {
                            tryAgain: {
                                text: 'DELETE',
                                btnClass: 'btn-danger',
                                action: function() {
                                    let margin = $('#margin').val();
                                    if (margin == 'DELETE') {
                                        window.location.href = url;
                                    } else {
                                        $.alert('Type DELETE to Proceed');
                                    }
                                }
                            },
                            close: function() {

                            }
                        }
                    });
                });
            });




            $("#attr_section").change(function(e) {
                e.preventDefault();
                let ref = $(this).val();

                if (ref === '3') {
                    $("input[name='data_type'][value='diamension']").parent().addClass('d-none');
                    $("input[name='data_type'][value='multi_select']").parent().addClass('d-none');
                    $("input[name='data_type'][value='interger']").parent().addClass('d-none');
                    // $("input[name='data_type'][value='date']").parent().addClass('d-none');
                    // $("input[name='data_type'][value='html']").parent().addClass('d-none');
                    // $("input[name='data_type'][value='long_text']").parent().addClass('d-none');
                    // $("input[name='data_type'][value='price']").parent().addClass('d-none');
                    // $("input[name='data_type'][value='uom']").parent().addClass('d-none');
                    // $("input[name='data_type'][value='url']").parent().addClass('d-none');
                } else {
                    $("input[name='data_type'][value='diamension']").parent().removeClass('d-none');
                    $("input[name='data_type'][value='multi_select']").parent().removeClass('d-none');
                    $("input[name='data_type'][value='interger']").parent().removeClass('d-none');
                    // $("input[name='data_type'][value='date']").parent().removeClass('d-none');
                    // $("input[name='data_type'][value='html']").parent().removeClass('d-none');
                    // $("input[name='data_type'][value='long_text']").parent().removeClass('d-none');
                    // $("input[name='data_type'][value='price']").parent().removeClass('d-none');
                    // $("input[name='data_type'][value='uom']").parent().removeClass('d-none');
                    // $("input[name='data_type'][value='url']").parent().removeClass('d-none');
                }
            });
        </script>
    @endpush
@endsection
