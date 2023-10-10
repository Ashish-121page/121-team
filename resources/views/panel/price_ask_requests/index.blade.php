@extends('backend.layouts.main') 
@section('title', 'Price Ask Requests')
@section('content')
@php
/**
 * Price Ask Request 
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
        ['name'=>'Price Ask Requests', 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
    @endphp
    <!-- push external head elements to head -->
    @push('head')
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>Price Ask Requests</h5>
                            <span>List of Price Ask Requests</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        
        <form action="{{ route('panel.price_ask_requests.index') }}" method="GET" id="TableForm">
            <div class="row">
                <!-- start message area-->
                <!-- end message area-->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3>Price Ask Requests</h3>
                            <div class="d-flex justicy-content-right">
                                <div class="form-group mb-0 mr-2">
                                    <span>From</span>
                                <label for=""><input type="date" name="from" class="form-control" value="{{request()->get('from')}}"></label>
                                </div>
                                <div class="form-group mb-0 mr-2"> 
                                    <span>To</span>
                                        <label for=""><input type="date" name="to" class="form-control" value="{{request()->get('to')}}"></label> 
                                </div>
                                <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                <a href="javascript:void(0);" id="reset" data-url="{{ route('panel.price_ask_requests.index') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                {{-- <a href="{{ route('panel.price_ask_requests.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Price Ask Request"><i class="fa fa-plus" aria-hidden="true"></i></a> --}}
                            </div>
                        </div>
                        <div id="ajax-container">
                            @include('panel.price_ask_requests.load')
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="makeOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterLabel">{{ __('Make Order')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('panel.admin.enquiry.order') }}" method="post">
                        @csrf
                        <input type="hidden" name="type_id" value="" id="TypeID">
                       
                        @php
                            
                            $user_address = [];
                        @endphp 
                        <div class="row">
                            <div class="col-md-6 mx-auto">
                                <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                    <label for="comment" class="control-label">{{ 'Qty' }}</label>
                                    <input required type="number" class="form-control" name="qty"  placeholder="Enter Qty">
                                </div>
                            </div>
                            <div class="col-md-6 mx-auto">
                                <div class="form-group {{ $errors->has('comment') ? 'has-error' : ''}}">
                                    <label for="comment" class="control-label">{{ 'Price' }}</label>
                                    <input required type="number" class="form-control" name="price"  placeholder="Enter Price">
                                </div>
                            </div>
                                <hr>
                                <h6 class="col-md-12">Choose User Address:</h6>
                                @foreach($user_address as $index =>$item)
                                    @php
                                        $address_temp = json_decode($item->details);
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="card border p-2">
                                            <input  id="adres{{ $index }}" name="address" value="{{ $item->id }}" type="radio" class="form-check-input address-check">
                                            <div class="text-center mb-3">
                                                <div class="text-dark">{{ $item->type == 0 ? "Home" : "Office" }}</div>
                                                    <div class="text-muted">{{ $address_temp->address_1 }}</div>
                                                    <div class="text-muted">{{ $address_temp->address_2}}</div>
                                                    <div class="text-muted">
                                                        {{ CountryById($address_temp->country) }},
                                                        {{ StateById( $address_temp->state) }}, 
                                                        {{ CityById( $address_temp->city) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            <div class="col-md-12 mx-auto">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Make</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
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
            XLSX.writeFile(file, 'PriceAskRequestFile.' + type);
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
            //   $('#fieldId').select2('val',"");               // if you use any select2 in filtering uncomment this code
           // $('#fieldId').trigger('change');                  // if you use any select2 in filtering uncomment this code
        });

        $(document).ready(function(){
            $('.customOrder').on('click',function(){
                $record = $(this).data('rec');
                $('#TypeID').val($record.id);
                $('#makeOrder').modal('show')
            });
        });

       
        </script>
    @endpush
@endsection
