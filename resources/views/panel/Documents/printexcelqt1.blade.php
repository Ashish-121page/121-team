@extends('backend.layouts.main')
@section('title', 'quotationexcel')
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
        <div class="container py-2" style="max-width: 1350px;">
            <div class="row">
                <div class="col-12">
                    <button type="button" id="printExcel" class="btn btn-outline-primary">Print Excel</button>
                </div>
            </div>

            <div class="row mb-4">
                @php
                    $Userinfo = json_decode($quotation->customer_info) ?? null;
                    $count = 0;
                @endphp

                <table class="table table-bordered" id="printquotations">
                    <thead>
                        <tr>
                            <th scope="col">
                                <img src="{{ asset(getShopLogo($usershop->slug)->path ?? asset('frontend/assets/img/placeholder.png')) }}"
                                    alt="company logo"
                                    style="border-radius: 10px;height: 250px;width: 300px;align-items: center; padding:2px;">
                            </th>
                            <th scope="col">{{''}}</th>
                            <th scope="col" colspan="7">{{ $Userinfo->buyerName ?? '' }}</th>
                            <th scope="col">{{ $Userinfo->companyName ?? '' }}</th>
                            @foreach ($userAttribute as $item)
                                @if (in_array($item, array_keys((array) $First_additional_notes)))
                                    @php
                                        $count++;
                                    @endphp
                                @endif
                            @endforeach

                            <th colspan="{{ $count - 4 }}"></th>


                        </tr>
                        {{-- <tr>
                            <th scope="col" colspan="2"></th>      
                            <th scope="col" colspan="4"></th>
                            @foreach ($userAttribute as $item)
                            @if (in_array($item, array_keys((array) $First_additional_notes)))
                                <th></th>
                            @endif
                        @endforeach

                                                  
                        </tr> --}}
                        <tr>
                            <th scope="col">Model Code</th>
                            <th scope="col">Image</th>
                            <th scope="col">COO</th>
                            <th scope="col">Name</th>
                            <th scope="col">Selling Price</th>
                            <th scope="col"> Incoterms</th>

                            @foreach ($userAttribute as $item)
                                @if (in_array($item, array_keys((array) $First_additional_notes)))
                                    <th>
                                        {{ $item }}
                                    </th>
                                @endif
                            @endforeach




                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quotationitems as $quotationitem)
                            @php
                                $product = App\Models\Product::where('id', $quotationitem->product_id)->first();
                                $shipping = json_decode($product->shipping) ?? [];

                                $additional_notes = json_decode($quotationitem->additional_notes) ?? [];
                                $extraproduct = App\Models\ProductExtraInfo::where('product_id', $quotationitem->product_id)->first();
                                $productInfos = App\Models\Product::where('id', $quotationitem->product_id)->first();
                                // $extrainfo = $extraproduct->where
                            @endphp
                            <tr>
                                <td>{{ $productInfos->model_code ?? '' }}</td>

                                <td>
                                    {{-- <div style="height: 80px;width: 80px; object-fit: contain;justify-content-end;"> --}}
                                    {{-- <img src="{{ asset(getShopProductImage($quotationitem->product_id)->path ?? asset('frontend/assets/img/placeholder.png')) }}" alt="Image" class="img-fluid " style="border-radius: 10px;height: 100%;width: 100%;align-items: center; padding:2px;"> --}}
                                    {{ asset(getShopProductImage($quotationitem->product_id)->path ?? asset('frontend/assets/img/placeholder.png')) }}
                                    {{-- </div> --}}
                                </td>
                                <td>{{ json_decode($quotationitem->additional_notes)->COO ?? '' }}</td>
                                <td>{{ $quotationitem->product_name }}</td>
                                <td>{{ $quotationitem->selling_price }}</td>
                                <td></td>

                                @foreach ($userAttribute as $item)
                                    @if (in_array($item, array_keys((array) $First_additional_notes)))
                                        <td>
                                            {{ $additional_notes->$item ?? '' }}
                                        </td>
                                    @endif
                                @endforeach






                                {{-- <td>{{ $shipping->length ?? '' }}</td>
                                <td>{{ $shipping->width ?? '' }}</td>
                                <td>{{ $shipping->height ?? '' }}</td>
                                <td> {{ $additional_notes->Unit ?? '' }}</td> --}}

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
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
        // function getTableData(tabelId) {
        //     var array = [];
        //     var headers = [];
        //     $('#'+tabelId+' th').each(function (index, item) {
        //         headers[index] = $(item).html().replace(/^\s+|\s+$/gm, '');
        //     });

        //     $('#'+tabelId+' tr').has('td').each(function () {
        //         var arrayItem = {};
        //         $('td', $(this)).each(function (index, item) {
        //             arrayItem[headers[index]] = $(item).html().replace(/^\s+|\s+$/gm, '');
        //         });
        //         array.push(arrayItem);

        //     });

        //     return array;
        // }

        // working perfectly without image and first row
        function getTableData(tableId) {
            var array = [];
            var headers = [];

            // trying to fetch data for 1st row

            $('#' + tableId + ' tr:eq(0) th').each(function(index, item) {
                headers[index] = $(item).html().replace(/^\s+|\s+$/gm, '');
            });

            // Fetch the second row of headers
            $('#' + tableId + ' tr:eq(1) th').each(function(index, item) {
                headers[index] = $(item).html().replace(/^\s+|\s+$/gm, '');
            });

            // Loop through the table rows starting from the third row
            $('#' + tableId + ' tr:gt(1)').each(function() {
                var arrayItem = {};

                $('td', $(this)).each(function(index, item) {
                    arrayItem[headers[index]] = $(item).html().replace(/^\s+|\s+$/gm, '');
                });

                array.push(arrayItem);
            });

            return array;
        }

        


//         function getTableData(tableId) {
//         var data = [];
//         var headers = [];
//         var secondHeaders = [];

//         // Fetch the first row of headers
//         $('#' + tableId + ' tr:eq(0) th').each(function(index, item) {
//             headers[index] = $(item).text().trim();
//         });

//         // Fetch the second row of headers
//         $('#' + tableId + ' tr:eq(1) th').each(function(index, item) {
//             secondHeaders[index] = $(item).text().trim();
//         });

//         // Add both header rows to the data array
//         data.push(headers);
//         data.push(secondHeaders);

//         // Loop through the table rows starting from the third row
//         $('#' + tableId + ' tr:gt(1)').each(function() {
//             var rowData = {};
//             $('td', $(this)).each(function(index, item) {
//                 // Use the first row headers as keys if the second row headers are not set
//                 var header = secondHeaders[index] || headers[index];
//                 rowData[header] = $(item).text().trim();
//             });
//             data.push(rowData);
//         });

//         return data;
//     }

// // Usage
// var tableData = getTableData('myTableId');
// console.log(JSON.stringify(tableData, null, 2));




        // {{-- ` Script for Excel Export --}}
        $(document).on('click', '#printExcel', function() {
            // html_table_to_excel('xlsx');
            let tabledata = getTableData('printquotations');
            let filename = "{{ 'Excel_export' }}_{{ Carbon\Carbon::now() }}.xlsx";

            $.ajax({
                type: "POST",
                url: "{{ route('panel.Documents.printexcelqt1') }}",
                data: {
                    'tabelcontent': JSON.stringify(tabledata),
                    'filename': filename,
                },
                success: function(result) {
                    let response = JSON.parse(result);
                    if (response.message == 'File created') {
                        var url = response.downloadLink;
                        var fileName = 'downloaded_file.xlsx';

                        // Create a new anchor element dynamically
                        var downloadLink = $('<a></a>')
                            .attr('href', url)
                            .attr('download', fileName)
                            .appendTo('body');

                        // Trigger click and remove element
                        downloadLink[0].click();
                        downloadLink.remove();
                    } else {
                        alert('Something went wrong. While Creating Excel File');
                    }
                }
            });

        })
    </script>




@endsection
