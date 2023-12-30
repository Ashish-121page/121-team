@extends('backend.layouts.main')
@section('title', 'quotation2')
@section('content')

    <!-- push external head elements to head -->
    @push('head')
        <style>
            a active {

                color: white !important;
                /* background-color: #6666a3; */
                border-radius: 5%;
                position: relative;
                opacity: 86%
            }

            a active span {
                font-size: 16px;
            }


            a active::before {
                content: '';
                background-color: #8484f8;
                height: 3px;
                width: 120%;
                position: absolute;
                bottom: -7px;
                left: -4px;
            }
        </style>
    @endpush

    <div class="container-fluid">

        <div class="row justify-content-center">
            <!-- Main Content -->

            <div class="col-lg-10 mt-3">
                <!-- Main content goes here -->
                <div class="mt-5">
                    <div class="row">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-8">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex align-items-center gap-3 ">
                                                <button class="btn btn-secondary mx-2" onclick="goBack()" value="Back" type="button">Back</button>

                                                <h5 class="mt-5">Enquiry Details</h5>

                                                <span class="ms-auto" style="margin-left: 19px; margin-top: 5px;">
                                                    <i class="far fa-edit"></i>
                                                </span>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                {{-- <div class="col-4 d-flex justify-content-end align-items-center">
                                    <button type="button" onclick="proceedTothirdView()" class="btn btn-primary" id="submit1"
                                        data-bs-target="">
                                        Next
                                    </button>
                                </div> --}}
                            </div>
                            {{-- <div class="row">
                                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                        <div class="container-fluid">
                                            <ul class="navbar-nav">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="#">1.Add Details</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#">2. Confirm the Products</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="#">Generate</a>
                                                </li>
                                                <!-- Add more steps as needed -->
                                            </ul>
                                        </div>
                                    </nav>
                                </div> --}}

                        </div>
                        {{-- <div class="col-4 d-flex justify-content-end align-items-center">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#BuyerModal">
                            <button type="button" id="bjkhkh" class="btn btn-outline-primary mx-1">
                                Create new quotation
                            </button>
                        </div> --}}
                    </div>

                    <!-- Other elements (filter, select, buttons) -->
                    <div class="row mt-5">
                        <div class="col-12 mt-5">
                            <div class="table-responsive mt-3">
                                <table id="table text-center " class="table">
                                    <thead class="h6 text-muted">
                                        <tr>
                                            {{-- <td class="no-export action_btn">
                                                <input type="checkbox" id="checkallinp">
                                            </td> --}}
                                            <td class="col-2">Enquiry ID</td>
                                            <td class="col-2">Buyer Name</td>
                                            <td class="col-2">Buyer Email </td>
                                            <td class="col-2">Buyer Company </td>
                                            <td class="col-2">Created On</td>
                                        </tr>
                                    </thead>
                                    <tbody id="rrecordtable">

                                        @php
                                            $json = json_decode($record->customer_info) ?? '';
                                        @endphp
                                        <tr>
                                            {{-- <td class="no-export action_btn">
                                                <input type="checkbox" id="checkallinp">
                                            </td> --}}
                                            <td class="col-2">{{ $record->slug }}</td>
                                            <td class="col-2">{{ $json->buyerName }}</td>
                                            <td class="col-2"> {{ $json->buyerEmail }} </td>
                                            <td class="col-2"> {{ $json->companyName }} </td>
                                            <td class="col-2"> {{ $record->quotation_date }} </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="card-title">History (0)</h5>
                                        <!-- Placeholder for the dots -->
                                        <div class="d-flex">
                                            {{-- <span class="badge bg-secondary mx-1">&nbsp;</span>
                                  <span class="badge bg-secondary mx-1">&nbsp;</span>
                                  <span class="badge bg-secondary mx-1">&nbsp;</span> --}}
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <p class="card-text h-4">You have not added quotation for this buyer</p>
                                        <p class="card-text text-muted">Add your own quotation or create new</p>
                                        <button type="button" class="btn btn-outline-danger mx-2">Upload
                                            quotation</button>
                                        <a href="{{ route('panel.Documents.quotation3') }}?typeId={{ $record->id }}" id="nnnbk" class="btn btn-primary mx-2">Create quotation</a>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        {{-- @include('panel.Documents.modals.buyer') --}}



    </div>
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
        function goBack() {
            window.history.back()
        }
    </script>

@endsection
