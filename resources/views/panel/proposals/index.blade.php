@extends('backend.layouts.main')
@section('title', 'Offers List')
@section('content')
<style>
    .remove-ik-class{
            -webkit-box-shadow: unset !important;
            box-shadow: unset !important;
        }

    .card-body1{
            -ms-flex:1 1 auto;
            flex:1 1 auto;
            padding:1.25rem;
            max-height: 65vh;
            overflow-y: auto;
        }

</style>
@php
/**
 * Proposal
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    GRPL
 * @license  121.page
 * @version  <GRPL 1.1.0>
 * @link        https://121.page/
 */
    $breadcrumb_arr = [
        ['name'=>'Offers', 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
    @endphp
    <!-- push external head elements to head -->
    @push('head')
    @endpush

    <div class="container-fluid">
    	<div class="page-header d-none">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-flex">
                            <h1>Offers</h1>
                            @if(AuthRole() == 'User')
                                <span style="margin-top: -10px;">
                                    <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                                </span>
                            @endif
                        </div>
                        {{-- <span>List of Proposals</span> --}}
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>

        <form action="{{ route('panel.proposals.index') }}" method="GET" id="TableForm">
            <div class="row">
                <!-- start message area-->
                <!-- end message area-->
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h1>Offers</h1>
                            <div class="d-flex justicy-content-right">
                                @php
                                    $slug = App\Models\UserShop::where('user_id',auth()->user()->id)->first()->slug;
                                @endphp
                                @if(AuthRole() != 'User')
                                    <div class="form-group mb-0 mr-2">
                                        <span>From</span>
                                    <label for=""><input type="date" name="from" class="form-control" value="{{request()->get('from')}}"></label>
                                    </div>
                                    <div class="form-group mb-0 mr-2">
                                        <span>To</span>
                                            <label for=""><input type="date" name="to" class="form-control" value="{{request()->get('to')}}"></label>
                                    </div>
                                    <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                    <a href="javascript:void(0);" id="reset" data-url="{{ route('panel.proposals.index') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                @else
                                {{-- // else --}}
                                @endif
                            </div>
                        </div>
                        {{--` Quick action menu --}}
                    <div class="row d-none" id="quickaction">
                        <div class="col-12 d-flex justify-content-center" style="margin-left:50px">
                            {{-- @include('panel.user_shop_items.includes.QuickActionMenu') --}}


                                {{-- For Category --}}



                                <div class="top-menu d-flex align-items-center " id="product-action">
                                    {{-- <button class="btn btn-sm btn-outline-primary mx-1" id="export-categrory">Export</button> --}}
                                    {{-- <button class="btn btn-sm btn-outline-primary mx-1" id="delcat_dummy">Delete</button> --}}

                                    <button class="btn btn-sm btn-outline-primary mx-1" id="deleteproposal">
                                        Delete
                                    </button>
                                    {{-- <a href="{{ route('panel.constant_management.category.delete', $item->id)  }}" title="Delete Category" class="btn btn-sm delete-item dropdown-item">Delete</a> --}}
                                </div>

                            {{-- @endif --}}
                        </div>
                    </div>
                        {{-- @if(AuthRole() != 'User')
                            <div id="ajax-container">
                                @include('panel.proposals.load')

                            </div>
                        @else --}}
                        <div>

                        </div>
                        @if (request()->has('view') && request()->get('view') == 'listview')
                            @include('panel.proposals.pages.table')
                        @elseif(request()->has('view') && request()->get('view') == 'gridview')
                            @include('panel.proposals.pages.grid')
                        @else
                            @include('panel.proposals.pages.table')
                        @endif

                            {{-- @include('panel.proposals.pages.table') --}}
                            {{-- @include('panel.proposals.pages.oldView') --}}
                            {{-- @include('panel.proposals.pages.grid') --}}

                        {{-- @endif --}}
                    </div>
                </div>
                {{--` Paste table style--}}
                {{-- <div class="row">
                    <div class="col-lg-6 col-md-12  col-12 my-2">
                        <div class="one" style="display: flex; align-items: center; justify-content: flex-start;">
                            <a href="?type={{ request()->get('type') }}&type_ide={{ encrypt(request()->get('type_id')) }}"
                                class="btn btn-outline-primary mx-1
                                @if (!request()->has('products') && !request()->has('assetsafe') && !request()->has('properties') && !request()->has('productsgrid')) active @endif
                                ">
                                Categories
                            </a>
                            <a href="?type={{ request()->get('type') }}&type_ide={{ encrypt(request()->get('type_id')) }}&productsgrid=true"
                                class="btn btn-outline-primary mx-1 @if (request()->has('products') OR request()->has('productsgrid')) active @endif">
                                Products
                            </a>
                            <a href="?type={{ request()->get('type') }}&type_ide={{ encrypt(request()->get('type_id')) }}&properties=true"
                                class="btn btn-outline-primary mx-1 @if (request()->has('properties')) active @endif">
                                Properties
                            </a>
                            <a href="?type={{ request()->get('type') }}&type_ide={{ encrypt(request()->get('type_id')) }}&assetsafe=true"
                                class="btn btn-outline-primary mx-1 @if (request()->has('assetsafe')) active @endif">
                                Assets Safe
                            </a>
                        </div>
                    </div> --}}

                    {{--` This Menu is Always Visible --}}
                    {{-- <div class="col-lg-6 col-md-12 col-12 my-2">
                        <div class="two" style="display: flex; align-items: center; justify-content: flex-end;">
                            @include('panel.user_shop_items.includes.action_menu')
                        </div>
                    </div> --}}
                {{-- </div> --}}


            </div>
        </form>
            <form action="{{ route('panel.proposals.index') }}" method="GET">
                <input type="hidden" name="Sent" id="status_sent">
                <input type="hidden"  id="buyer" name="Buyer_name">

                <button type="submit" class="d-none" id="jhgfdsare"></button>

            </form>
    </div>
    @include('frontend.micro-site.og_proposals.modal.offerexpo')
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script src="{{ asset('backend/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{asset('backend/js/form-advanced.js') }}"></script>
        <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>

    <script>
        // $(document).ready(function() {
        //     $("#staticBackdrop").modal('show');
        // });
    </script>
    <script>

        function html_table_to_excel(type)
        {
            var table_core = $("#table").clone();
            var clonedTable = $("#table").clone();
            clonedTable.find('[class*="no-export"]').remove();
            clonedTable.find('[class*="d-none"]').remove();
            $("#table").html(clonedTable.html());
            var data = document.getElementById('table');

            var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
            XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
            XLSX.writeFile(file, 'ProposalFile.' + type);
            $("#table").html(table_core.html());

        }

        $(document).on('click','#export_button',function(){
            html_table_to_excel('xlsx');
        })


        $('#reset').click(function(){
            var url = $(this).data('url');
            getData(url);
            window.history.pushState("", "", url);
            $('#TableForm').trigger("reset");
        });
    </script>


    {{-- <script>
        $(document).ready(function () {
            $("#makeoffer").click(function (e) {
                e.preventDefault();
                var url = $(this).attr('href');
                // var msg = "<input type='text' id='margin' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Name'> <br> <input type='text' id='offeremail' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Email (Optional)'> <br> <input type='number' maxlength='10' id='offerphone' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Phone (Optional)'>";
                var msg = "<input type='text' id='margin' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Buyer Name'> <br> <input type='text' id='alias' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Alias (optional)'> <br> <input type='text' id='offeremail' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Email (Optional)'> <br> <input type='number' maxlength='10' id='offerphone' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Phone (Optional)'>";

                $.confirm({
                    draggable: true,
                    title: 'Offer for',
                    content: msg,
                    type: 'blue',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Next',
                            btnClass: 'btn-primary',

                            action: function(){
                                    let margin = $('#margin').val();
                                    let offeremail = $('#offeremail').val();
                                    let offerphone = $('#offerphone').val();

                                    let alias = $('#alias').val();
                                    let personname = $('#offerpersonname').val();

                                    if (!margin) {
                                        $.alert('provide a valid name');
                                        return false;
                                    }
                                    url = url+"&offerfor="+margin+"&offerphone="+offerphone+"&offeremail="+offeremail+"&offeralias="+alias+"&offerpersonname="+personname;
                                    window.location.href = url;
                                    // console.log(url);
                            }
                        },
                        close: function () {
                        }
                    }
                });
            });




            function copyTextToClipboard(text) {
                        if (!navigator.clipboard) {
                            fallbackCopyTextToClipboard(text);
                            return;
                        }

                        navigator.clipboard.writeText(text).then(function()

                    {
                            $.toast({
                                heading: 'SUCCESS',
                                text: "Offer link copied.",
                                showHideTransition: 'slide',
                                icon: 'success',
                                loaderBg: '#f96868',
                                position: 'top-right'
                            });
                        }, function(err) {
                            console.error('Failed to copy text to clipboard:', err);
                        });
                    }

                    $(".copybtn").click(function(e) {
                        e.preventDefault();
                        var link = $(this).val();
                        copyTextToClipboard(link);
                    });

            // function copyTextToClipboard(text) {
            //         if (!navigator.clipboard) {
            //             fallbackCopyTextToClipboard(text);
            //             return;
            //         }
            //         navigator.clipboard.writeText(text).then(function() {
            //         }, function(err) {
            //         });
            //         $.toast({
            //             heading: 'SUCCESS',
            //             text: "Offer link copied.",
            //             showHideTransition: 'slide',
            //             icon: 'success',
            //             loaderBg: '#f96868',
            //             position: 'top-right'
            //         });
            // }

            // $(".copybtn").click(function (e) {
            //     e.preventDefault();
            //     var link = $(this).val();
            //     copyTextToClipboard(link);

            // });



        });

    </script> --}}

    <script>
        $(document).ready(function () {
            // product-action
            function myfunc() {
                if ($(".input-check:checked").length > 0) {
                    // any one is checked
                    $("#quickaction").removeClass('d-none');
                    getValues()
                } else {
                    $("#quickaction").addClass('d-none');
                }
            }

            function getValues(){
                let selected = []
                let record = document.querySelectorAll(".input-check:checked");
                record.forEach(element => {
                    selected.push(element.dataset.record);
                });
                $(".selectedbtn").html(selected.length+' selected')
                return selected;
            }

            $("#printQrbtn").click(function (e) {
                e.preventDefault();
                $("#needqr").val(getValues());
                $("#qrform").submit()

            });


            $("#exportproductbtn").click(function (){
                $("#products_export").val(getValues());
                $("#products_exportform").submit();
            })


            $(".input-check").change(function (e) {
                myfunc()
            });


            $("#checkallinp").change(function (e) {
                $('.input-check').click();
            });

            $("#export-categrory").click(function (e) {
                e.preventDefault();

                let forminput = $('#choose_cat_ids');
                let form = $('#export_category_product');
                let arr = [];

                if ($(".input-check:checked").length > 0) {
                    $.each($(".input-check:checked"), function (indexInArray, valueOfElement) {
                        arr.push(valueOfElement.value);
                    });
                    console.log(arr);
                    forminput.val(arr)
                    form.submit()
                }


            });



            $("#deletecatbtn").click(function (e) {
                e.preventDefault();
                let forminput = $('#delete_ids');
                let form = $('#categoryDeleteForm');
                let arr = [];

                if ($(".input-check:checked").length > 0) {
                    $.each($(".input-check:checked"), function (indexInArray, valueOfElement) {
                        arr.push(valueOfElement.value);
                    });
                    console.log(arr);
                    forminput.val(arr)
                    form.submit()
                }
            });

            $("#deleteproposal").click(function (e) {
                e.preventDefault();
                let forminput = $('#delete_ids');
                let form = $('#ProposalDeleteForm');
                let arr = [];

                if ($(".input-check:checked").length > 0) {
                    $.each($(".input-check:checked"), function (indexInArray, valueOfElement) {
                        arr.push(valueOfElement.value);
                    });
                    console.log(arr);
                    forminput.val(arr)
                    form.submit()
                }
            });


            $('#status_check').change(function (e) {
                let valsdue = $(this).val();
                $("#status_sent").val(valsdue);
                $("#jhgfdsare").click();
                location.reload()

            });

            $('#search_buyer').on('input', function () {
                let val2 = $(this).val();
                $("#buyer").val(val2);
                $("#jhgfdsare").click();
                location.reload()

                });

                // function copyTextToClipboard(text) {
                //         if (!navigator.clipboard) {
                //             fallbackCopyTextToClipboard(text);
                //             return;
                //         }
                //         navigator.clipboard.writeText(text).then(function() {
                //         }, function(err) {
                //         });
                //         $.toast({
                //             heading: 'SUCCESS',
                //             text: "Offer link copied.",
                //             showHideTransition: 'slide',
                //             icon: 'success',
                //             loaderBg: '#f96868',
                //             position: 'top-right'
                //         });
                // }

                // $(".copybtn").click(function (e) {
                //     e.preventDefault();
                //     var link = $(this).val();
                //     copyTextToClipboard(link);
                // });




        });
    </script>


    @endpush
@endsection
