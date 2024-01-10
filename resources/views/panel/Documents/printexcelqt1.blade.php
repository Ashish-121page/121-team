@extends('backend.layouts.main')
@section('title', 'quotationexcel')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <style>
            th{
                vertical-align: middle !important;
                text-align: center !important;
            }
            a active {
                color: white !important;
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
            <div class="row my-3">
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
                        <tr class="myspecial">
                            <th scope="col" colspan="2">
                                <img src="{{ asset(getShopLogo($usershop->slug)->path ?? asset('frontend/assets/img/placeholder.png')) }}"
                                    alt="company logo"
                                    style="border-radius: 10px;height: 250px;width: 300px;align-items: center; padding:2px;">
                            </th>
                            <th scope="col" colspan="5"{{ '' }}</th>
                            <th scope="col" colspan="1">{{ $Userinfo->companyName ?? '' }}</th>
                            <th scope="col">{{ $Userinfo->person_name ?? '' }}</th>
                        </tr>

                        <tr>
                            @foreach ($quotationitems as $quotationitem)
                                @foreach (json_decode($quotationitem->additional_notes) as $columns => $value)
                                    @if (in_array($columns, $no_required_cols))
                                        @continue
                                    @endif
                                    <th>
                                        {{ $columns }}
                                    </th>
                                @endforeach
                                @break
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quotationitems as $quotationitem)
                            @php
                                $col = 0;
                            @endphp
                            <tr>
                                @if ($quotationitem->additional_notes != null)
                                    @foreach (json_decode($quotationitem->additional_notes) as $columns => $value)
                                        @if (in_array($columns, $no_required_cols))
                                            @continue
                                        @endif
                                        @if ($columns == 'image')
                                            <td>
                                                <img src="{{ asset(getShopProductImage($quotationitem->product_id)->path ?? asset('frontend/assets/img/placeholder.png')) }}"
                                                    alt="" style="height: 85px; width: 85px;object-fit: contain">
                                            </td>
                                            @continue
                                        @endif
                                        <td>
                                            {{ $value }}
                                        </td>

                                        @php
                                            $col++;
                                        @endphp
                                    @endforeach
                                @else
                                    @for ($i = 0; $i < $col; $i++)
                                        <td></td>
                                    @endfor
                                @endif
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
                    // Check if the cell contains an image
                    if ($(item).find('img').length > 0) {
                        // Extract the src of the image
                        arrayItem[headers[index]] = $(item).find('img').attr('src');
                    } else {
                        // Extract the text
                        // arrayItem[headers[index]] = $(item).html().trim();
                        arrayItem[headers[index]] = $(item).html().replace(/^\s+|\s+$/gm, '');
                    }
                });

                array.push(arrayItem);
            });

            return array;
        }




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
                    // 'filename': filename.replace(/\s+/g, '_')
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
