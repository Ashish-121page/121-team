@extends('backend.layouts.main')
@section('title', $title_page)
@section('content')

    <!-- push external head elements to head -->
    @push('head')
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> --}}
    @endpush

    <div class="container-fluid">

        @php

            $user = auth()->user();
            $acc_permissions = json_decode($user->account_permission);
            $acc_permissions->mysupplier = $acc_permissions->mysupplier ?? 'no';
            $acc_permissions->quoatations = $acc_permissions->quoatations ?? 'no';

        @endphp
        <div class="row">
            <!-- Sidebar -->
            <div class="col-12 sidebar mt-3">
                <!-- Sidebar content -->

                {{-- <a href="{{ route('panel.invoice.index') . '?type=direct&type_ide=' . encrypt(auth()->id()) }}"
                    class="btn btn-outline-primary  {{ activeClassIfRoutes(['panel.invoice.index'], 'active') }}">All
                    Documents</a> --}}

                <a class="btn btn-outline-primary @if (request()->access == '') active  @endif "
                    href="{{ route('panel.Documents.Quotation', 'active') }}">Quotations</a>

                <a href="{{ route('panel.Documents.Quotation',['access'=>'pi-data']) }}" class="btn btn-outline-primary  @if (request()->access == 'pi-data') active  @endif">Proforma Invoices</a>

                {{-- <a href="{{ route('panel.Documents.secondview') }}" class="btn btn-outline-primary {{ activeClassIfRoutes(['panel.Documents.secondview'], 'active') }}">Invoice</a> --}}

            </div>

            <div class="col-lg-12 mt-3">
                <!-- Main content goes here -->
                <div class="mt-5">
                    <div class="row">
                        <div class="col-lg-8 col-md-8">
                            <div class="col-lg-4 col-md-5 input-group border rounded">
                                <input type="text" id="quicktitle" value="" name="title"
                                    class="form-control border-0" placeholder="Search Buyer name or..">
                                <button type="submit" class="input-group-text bg-white border-0" id="searchsubmit"><svg
                                        width="18" height="18" viewBox="0 0 512 512"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill="currentColor"
                                            d="m479.6 399.716l-81.084-81.084l-62.368-25.767A175.014 175.014 0 0 0 368 192c0-97.047-78.953-176-176-176S16 94.953 16 192s78.953 176 176 176a175.034 175.034 0 0 0 101.619-32.377l25.7 62.2l81.081 81.088a56 56 0 1 0 79.2-79.195M48 192c0-79.4 64.6-144 144-144s144 64.6 144 144s-64.6 144-144 144S48 271.4 48 192m408.971 264.284a24.028 24.028 0 0 1-33.942 0l-76.572-76.572l-23.894-57.835l57.837 23.894l76.573 76.572a24.028 24.028 0 0 1-.002 33.941" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="col-4 d-flex justify-content-end align-items-center">
                            <select id="filterdata" class="form-control select2">
                                <option value="1" @if (request()->get('sort') == '1') selected @endif>By Date</option>
                                <option value="2" @if (request()->get('sort') == '2') selected @endif>By Name (A to Z)</option>
                                @if (request()->get('access') != 'pi-data')
                                    <option value="3" @if (request()->get('sort') == '3') selected @endif>PI Status</option>
                                @endif
                            </select>
                            @if (request()->get('access') != 'pi-data')
                                <a href="{{ route('panel.Documents.create.Quotation.form') }}"
                                    class="btn btn-outline-primary mx-1">
                                    Create new quotation
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="mt-3">

                            @if (request()->access == 'active' || request()->access == '' || !request()->access)
                                @include('panel.Documents.pages.quote-index')
                            @elseif (request()->access == 'pi-data')
                                @include('panel.Documents.pages.pi-data')
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>





    </div>
    </div>

    <input type="hidden" id="viehdu" value="{{ $Quotation->pluck('customer_info') }}"'>


    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script src="{{ asset('backend/plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/animatedModal.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var viehdu = $('#viehdu').val();
        viehdu = JSON.parse(viehdu);




        $(document).ready(function() {




            $("#bjkhkh").click(function(e) {
                e.preventDefault();
                var url = $(this).attr('href');


                var msg = `
                    <div class='col-lg-12 col-md-12'>
                    <div class='row'>
                        <div class="col-lg-12 col-md-12 my-2">
                            <label for='basis'>Select Basis:</label><br>
                            <select id="basissd" class="select form-control">
                                <option value="newone">New Entry</option>
                                ${viehdu.map((item, index) => {
                                    return `<option value="${index}">${JSON.parse(item).buyerName}</option>`;
                                })}
                            </select>
                        </div>
                        <div class='col-lg-12 col-md-12 makemehide'>
                            <label for='buyerName'>Buyer Name:</label><br>
                            <input type='text' id='buyerName' name='buyerName' class='form-control border rounded' placeholder='Enter' required>
                        </div>
                        <div class='col-lg-12 col-md-12 makemehide'>
                            <label for='buyerEmail'>Buyer Email:</label><br>
                            <input type='text' id='buyerEmail' name='buyerEmail' class='form-control border rounded' placeholder='Enter'>
                        </div>
                        <div class='col-lg-12 col-md-12 makemehide'>
                            <label for='companyName'>Company Name (optional):</label><br>
                            <input type='text' id='companyName' name='companyName' class='form-control border rounded' placeholder='Enter'>
                        </div>
                    </div>
                    </div>
                `;


                // var msg =
                //     "<div class='col-lg-12 col-md-12'><div class='row'><div class='col-lg-12 col-md-12'><label for='buyerName'>Buyer Name:</label><br><input type='text' id='buyerName' name='buyerName' class='form-control border rounded' placeholder='Enter'></div><div class='col-lg-12 col-md-12'><label for='buyerEmail'>Buyer Email:</label><br><input type='text' id='buyerEmail' name='buyerEmail' class='form-control border rounded' placeholder='Enter'></div><div class='col-lg-12 col-md-12'><label for='companyName'>Company Name (optional):</label><br><input type='text' id='companyName' name='companyName' class='form-control border rounded' placeholder='Enter'></div></div></div>";

                $.confirm({
                    draggable: true,
                    title: 'Add buyer details',
                    content: msg,
                    type: 'blue',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Confirm',
                            btnClass: 'btn-primary',
                            action: function() {

                                const buyerName = document.getElementById('buyerName');
                                const buyerEmail = document.getElementById('buyerEmail');
                                const companyName = document.getElementById('companyName');
                                let dt = new Date();
                                const buyerObj = {
                                    buyerName: buyerName.value,
                                    buyerEmail: buyerEmail.value,
                                    companyName: companyName.value,
                                    CreatedOn: dt.toLocaleString()
                                };

                                if (buyerName.value == '') {
                                    buyerName.focus();
                                    $.alert("Please enter buyer name");
                                    return false;
                                }

                                jsonBuyerObj = JSON.stringify(buyerObj);

                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('panel.Documents.create.Quotation') }}",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        buyerObj: jsonBuyerObj
                                    },
                                    dataType: "json",
                                    success: function(response) {
                                        if (response.status != 'Error') {
                                            localStorage.setItem(
                                                'buyerObj-Quotation',
                                                jsonBuyerObj);
                                            localStorage.setItem(
                                                'record_id-Quotation', response
                                                .record_id);
                                            window.location.href =
                                                "{{ route('panel.Documents.quotation2') }}?typeId=" +
                                                response.record_id;
                                        }
                                    }
                                });
                            }
                        },
                        close: function() {
                            // Additional action if needed upon dialog close
                        }
                    }
                });
            });




            $(function() {
                $("#890out").select2()
            });


            $("#filterdata").change(function (e) {
                e.preventDefault();
                let val = $(this).val();
                if ({{ request()->access != 'pi-data' || !request()->access ? 'false' : 'true' }}) {
                    let url = "{{ route('panel.Documents.Quotation',['access'=>'pi-data']) }}&sort=" + val;
                    window.location.href = url;
                } else {
                    let url = "{{ route('panel.Documents.Quotation') }}?sort=" + val;
                    window.location.href = url;
                }
            });

        });
    </script>
    @if (request()->access != 'pi-data' || !request()->access)

    @endif



@endsection
