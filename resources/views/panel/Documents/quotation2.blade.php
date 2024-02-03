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
    @php
        $nameofpage = $record->type_of_quote == '1' ? 'PI' : 'Quotations';
    @endphp

    <div class="container-fluid">

        <div class="row justify-content-center">
            <!-- Main Content -->

            <div class="col-lg-12 mt-3">
                <!-- Main content goes here -->
                <div class="mt-5">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-flex align-items-center justify-content-between  ">
                                                <div class="d-flex">
                                                    <button class="btn btn-outline-primary mx-2" onclick="goBack()" value="Back"
                                                        type="button">Back</button>

                                                    <h5 class="mt-5">
                                                        {{ json_decode($entity_details->buyer_details)->entity_name ?? '' }}
                                                        -
                                                        {{ $nameofpage }} View</h5>
                                                </div>

                                                <div class="d-flex justify-content-between ">
                                                    <select id="filterdata" class="form-control select2">
                                                        <option value="1" @if (request()->get('sort') == '1') selected @endif>By Date</option>
                                                        <option value="2" @if (request()->get('sort') == '2') selected @endif>By Name</option>
                                                        <option value="3" @if (request()->get('sort') == '3') selected @endif>PI Status</option>
                                                    </select>
                                                    <button type="button" class="btn btn-outline-primary   mx-2 "
                                                        data-toggle="modal" data-target="#uploadModal">
                                                        Upload History
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Other elements (filter, select, buttons) -->
                    <div class="row mt-5">
                        <div class="col-12 mt-5">
                            <div class="table-responsive-sm table-responsive-md mt-3">
                                <table id="table text-center " class="table">
                                    <thead class="h6 text-muted">
                                        <tr>
                                            {{-- <td class="no-export action_btn">
                                                <input type="checkbox" id="checkallinp">
                                            </td> --}}

                                            @if ($record->type_of_quote == '1')
                                                <th scope="col">Quotation ID</th>
                                            @else
                                                <th scope="col">Offer ID</th>
                                            @endif

                                            <th scope="col">{{ $nameofpage }} ID</th>
                                            {{-- <th scope="col">Buyer Email </th> --}}
                                            <th scope="col">Person Name </th>
                                            <th scope="col"> No. of Product </th>
                                            <th scope="col">Created On</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="rrecordtable">

                                        @foreach ($similar_records as $recorddb)
                                            <tr>

                                                @php
                                                    $proposal_id = $recorddb->proposal_id;
                                                    $json_customer_info = json_decode($recorddb->customer_info) ?? '';
                                                    $QuotationItem = App\Models\QuotationItem::where('quotation_id', $recorddb->id)->get();
                                                @endphp
                                                @if ($record->type_of_quote == '1')
                                                    @php
                                                        $linked_quote = App\Models\Quotation::where('id',$recorddb->linked_quote)->first();
                                                    @endphp
                                                    <td>
                                                        {{ $linked_quote->user_slug ?? $linked_quote->slug ?? ''}}
                                                    </td>
                                                @else
                                                    @if ($proposal_id == '')
                                                        <td>{{ _('Direct') }}</td>
                                                    @else
                                                        @php
                                                            $offer_record = getProposalRecordById($recorddb->proposal_id);
                                                        @endphp
                                                        <td>
                                                            {{-- {{ $proposal_id  }} --}}
                                                            {{ $offer_record->user_slug ?? ($offer_record->slug ?? '--') }}
                                                        </td>
                                                    @endif
                                                @endif

                                                <td>{{ $recorddb->user_slug ?? $recorddb->slug }}</td>

                                                <td>{{ $json_customer_info->buyerName ?? ($json_customer_info->person_name ?? '') }}
                                                </td>

                                                <td> {{ count($QuotationItem) ?? 0 }} </td>
                                                <td> {{ $recorddb->quotation_date ?? '' }} </td>

                                                <td>
                                                    <div class="row">
                                                        <a href="{{ route('panel.Documents.quotation3') }}?typeId={{ $recorddb->id }}"
                                                            id="nnnbk" class="mx-1">
                                                            <i class="far fa-save text-primary"></i>
                                                        </a>
                                                        <a href="{{ route('panel.Documents.create.Quotation.form') }}?typeId={{ $recorddb->id }}&action=edit"
                                                            class="mx-1">
                                                            <i class="far fa-edit text-primary" title="Edit"></i>
                                                        </a>


                                                        @if ($recorddb->type_of_quote == '0')
                                                            @php
                                                                $chkrec = App\Models\Quotation::where('linked_quote', $recorddb->id)->get();
                                                            @endphp

                                                            @if ($chkrec->count() == 0)
                                                                <a href="{{ route('panel.Documents.make.quote.perfoma', $recorddb->id) }}"
                                                                    class="mx-1 btn-link" style="font-size: 13px"> Make PI
                                                                </a>
                                                            @else
                                                                <h6><i class="fas fa-check text-primary "></i></h6>
                                                            @endif
                                                        @endif

                                                    </div>
                                                    {{-- <a href="{{ route('panel.Documents.quotation3') }}?typeId={{ $recorddb->id }}" id="nnnbk" class="mx-1" ><i class="far fa-save text-primary"></i></a>

                                                <a href="{{ route('panel.Documents.create.Quotation.form') }}?typeId={{ $recorddb->id }}&action=edit" class="mx-1" >
                                                    <i class="far fa-edit text-primary" title="Edit"></i>
                                                </a> --}}
                                                </td>

                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-12">
                            @if ($quote_flles->count() != 0)
                                <div class="col-12">

                                    <div class="h5  m-2">History</div>
                                    <table class="table">
                                        <thead>
                                            <th>#</th>
                                            <th>Quotation Id</th>
                                            <th>Person Name</th>
                                            <th>File Name</th>
                                            <th>Upload on</th>
                                            <th>File Download</th>

                                        </thead>

                                        <tbody>
                                            @forelse ($quote_flles as $quote_flle)
                                                @php
                                                    $misc_notes = json_decode($quote_flle->misc_notes) ?? '';
                                                @endphp
                                                <tr>
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    <td>
                                                        {{ $misc_notes->quotation_id ?? '--' }}
                                                    </td>
                                                    <td>
                                                        {{ $misc_notes->buyerperson ?? '' }}
                                                    </td>
                                                    <td>
                                                        {{ $quote_flle->file_name }}
                                                    </td>
                                                    <td>
                                                        {{ $quote_flle->created_at }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ asset($quote_flle->file_path) }}"
                                                            download="{{ $quote_flle->file_name }}"
                                                            class="btn btn-outline-primary mx-2">Download</a>
                                                    </td>

                                                </tr>
                                            @empty
                                                Nothing to show Here...
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            @endif



                        </div>

                    </div>
                </div>
            </div>
            {{-- @include('panel.Documents.modals.buyer') --}}
        </div>



        @include('panel.Documents.modals.upload')


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

            $("#filterdata").change(function (e) {
                e.preventDefault();
                let val = $(this).val();
                let url = "{{ route('panel.Documents.quotation2') }}?typeId={{ $record->id }}&sort=" + val;
                window.location.href = url;
            });
        </script>

    @endsection
