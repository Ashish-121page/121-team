<div class="col-12">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="#" method="POST" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <b>Buyer Master</b>
                                </h4>
                            </div>
                            <div class="col-12">
                                <table class="table table-responsive ">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Buyer Details</th>
                                            <th>Shipping Details</th>
                                            <th>Contact Person Details</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($buyer_records as $record)
                                            @php
                                                $json_buyer = json_decode($record->buyer_details);
                                                $json_shipping = json_decode($record->shipment_details);
                                                $json_contact_person = json_decode($record->contact_persons);
                                                $json_payment = json_decode($record->payment_details);
                                            @endphp

                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td style="width: 300px">
                                                    <span>Entity Name: {{ $json_buyer->entity_name ?? '' }}</span> <br>
                                                    <span>ID: {{ $json_buyer->ref_id ?? '' }}</span><br>
                                                    <span>{{ $json_buyer->address1 ?? '' }}</span>
                                                    <span>{{ $json_buyer->address2 ?? '' }}</span>
                                                    <span>{{ $json_buyer->city ?? '' }}</span>
                                                    <span>{{ $json_buyer->country ?? '' }}</span>
                                                    <span>{{ $json_buyer->pincode ?? '' }}</span>
                                                </td>

                                                <td>
                                                    @if ($json_shipping->terms_of_delivery ?? '' != '')
                                                        <span>Terms of Delivery:
                                                            {{ $json_shipping->terms_of_delivery ?? '' }}</span> <br>
                                                    @endif

                                                    @if ($json_shipping->port_of_loading ?? '' != '')
                                                        <span>Port of Loading:
                                                            {{ $json_shipping->port_of_loading ?? '' }}</span><br>
                                                    @endif

                                                    @if ($json_shipping->port_of_discharge ?? '' != '')
                                                        <span>Post of Discharge:
                                                            {{ $json_shipping->port_of_discharge ?? '' }}</span><br>
                                                    @endif

                                                    @if ($json_shipping->payment_terms ?? '' != '')
                                                        <span>Payment Terms:
                                                            {{ $json_shipping->payment_terms ?? '' }}</span><br>
                                                    @endif

                                                </td>

                                                <td>
                                                    @foreach ($json_contact_person as $item)
                                                        @if ($item->person_name ?? '' != '')
                                                            <span>Name: {{ $item->person_name ?? '' }}</span><br>
                                                        @endif

                                                        @if ($item->person_email ?? '' != '')
                                                            <span>Email: {{ $item->person_email ?? '' }}</span><br>
                                                        @endif

                                                        @if ($item->person_phone ?? '' != '')
                                                            <span>Phone: {{ $item->person_phone ?? '' }}</span><br>
                                                        @endif
                                                    @endforeach
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">No Records Found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
