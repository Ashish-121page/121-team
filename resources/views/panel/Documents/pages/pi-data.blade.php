  
    <table id="table" class="table table-responsive">
        <thead class="h6 text-muted">
            <tr>
                <td class="col-2">PI ID</td>
                <td class="col-2">Quoation ID</td>
                <td class="col-2">Offer ID</td>
                <td class="col-2">Buyer Company </td>
                <td class="col-2"></td>
                <td class="col-2">Person Name</td>
                <td class="col-2">Created On</td>
                <td class="col-4"></td>
                <td class="col-4"></td>
            </tr>
        </thead>
        <tbody>

            @forelse ($pirecords as $record)
                @php
                    $jsonData = json_decode($record->customer_info) ?? '';
                    $prevQuote = App\Models\Quotation::where('id', $record->linked_quote)->first();
                @endphp
                <tr>

                    @php
                        $proposal_id = $record->proposal_id;
                    @endphp
                    <td>
                        {{ $record->user_slug ?? $record->slug }}
                    </td>

                    <td>
                        {{ $prevQuote->user_slug ?? $prevQuote->slug  ?? '--'}}

                    </td>

                    @if ($proposal_id == '')
                        <td class="col-2">{{ _('Direct') }}</td>
                    @else
                        @php
                            $offer_record = getProposalRecordById($record->proposal_id);
                        @endphp
                        <td class="col-2">
                            {{-- {{ $proposal_id  }} --}}
                            {{ $offer_record->user_slug ?? $offer_record->slug ?? '--' }}
                        </td>
                    @endif


                    <td>
                        {{ $jsonData->companyName ?? '-' }}
                    </td>
                    <td>
                        <a href="{{ route('panel.Documents.quotation2') }}?typeId={{ $record->id }}" class="btn-link  text-primary">
                            <i class="fas fa-eye"></i>
                            <span>({{ $record['record_count'] ?? 1 }})</span>
                        </a>
                    </td>
                    <td>
                        {{ $jsonData->buyerName ?? ($jsonData->person_name ?? '') }}
                    </td>
                    <td>
                        {{ $record->quotation_date }}
                    </td>
                    <td>
                        {{-- <a href="{{ route('panel.Documents.quotation2') }}?typeId={{ $record->id }}"
                            class="btn btn-outline-primary">
                            Edit
                        </a> --}}
                            <a href="{{ route('panel.Documents.quotation2') }}?typeId={{ $record->id }}" class="mx-1" style="font-size:18px">
                                <i class="far fa-save text-primary"></i>
                            </a>

                        <a href="{{ route('panel.Documents.create.Quotation.form') }}?typeId={{ $record->id }}&action=edit" class="mx-1" style="font-size:18px">
                            <i class="far fa-edit text-primary" title="Edit"></i>
                        </a>
                    </td>
                </tr>
            @empty
            @endforelse

        </tbody>
    </table>


