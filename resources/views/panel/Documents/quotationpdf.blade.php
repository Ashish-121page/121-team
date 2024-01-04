<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quotation Format</title>
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">

    @php
        $Userrecord = json_decode($QuotationRecord->customer_info) ?? null;
    @endphp
  <div class="mb-4">
    <h1 class="h3 mb-3 font-weight-normal">{{ $Userrecord->buyerName ?? '' }}</h1>
    <h6>{{ $QuotationRecord->user_slug ?? $QuotationRecord->slug ?? '' }}</h6>
    <hr>
    <p style="font-size: 0.85rem;">
      <b>Issue Date:</b> {{ $Userrecord->CreatedOn ?? '' }} <br>
      <b>Company Details:</b> {{ $Userrecord->companyName ?? '' }}
      @if ($QuotationRecord->additional_notes ?? '' != '')
        <br>
        <b>Remarks:</b> {{ $QuotationRecord->additional_notes ?? '' }}
      @endif
    </p>
  </div>

  <table class="table table-bordered">
    <thead class="thead-light">
      <tr>
        <th scope="col"></th>
        <th scope="col">MODEL CODE</th>
        <th scope="col">Description</th>
        <th scope="col">Amount</th>
      </tr>
    </thead>
    <tbody>



        @foreach ($QuotationItemRecords as $QuotationItemRecord)
            @php
                $additional_notes = json_decode($QuotationItemRecord->additional_notes) ?? [];
                $productInfo = App\Models\Product::where('id', $QuotationItemRecord->product_id)->first();
            @endphp

            <tr>

            <td>
                <img src="{{ asset(getShopProductImage($QuotationItemRecord->product_id)->path ?? asset('frontend/assets/img/placeholder.png')) }}" alt="Accent Coffee Table" class="img-fluid rounded" style="height: 150px;width: 150px; object-fit: contain"/>
            </td>
            <td>
                {{ $productInfo->model_code ?? ''}}
            </td>
            <td>
                @php
                    $decriptionArray = ['Title','COO'];
                    $UserProperties = json_decode($user->custom_attriute_columns) ?? [];
                    $decriptionArray = array_merge($decriptionArray, $UserProperties);
                @endphp
                    {{-- {{ magicstring($decriptionArray); }} --}}

                {{-- {{ magicstring($additional_notes); }} --}}
                @forelse ($additional_notes as $key => $additional_note)
                    @if (in_array($key, $decriptionArray))
                        <p>
                            <b>{{ $key }}:</b> {{ $additional_note }}
                        </p>
                    @endif

                @empty
                    <p>
                        <b>Additional Notes:</b> No additional notes
                    </p>
                @endforelse
            </td>
            <td>
                {{ $QuotationItemRecord->currency ?? ''}}
                {{ $QuotationItemRecord->Price ?? ''}}
                {{ $QuotationItemRecord->unit ?? ''}}

            </td>

            </tr>

        @endforeach









    </tbody>
  </table>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.9/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script>
    $(document).ready(function () {
        window.print();
    });
</script>


</body>
</html>
