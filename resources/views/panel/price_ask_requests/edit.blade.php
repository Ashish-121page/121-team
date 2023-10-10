@extends('backend.layouts.main') 
@section('title', 'Price Ask Request')
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
    ['name'=>'Edit Price Ask Request', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <style>
        .error{
            color:red;
        }
    </style>
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-inline">
                            <h5>Edit Price Ask Request</h5>
                            <span>Update a record for Price Ask Request</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- start message area-->
               @include('backend.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-header">
                        <h3>Update Price Ask Request</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.price_ask_requests.update',$price_ask_request->id) }}" method="post" enctype="multipart/form-data" id="PriceAskRequestForm">
                            @csrf
                            <div class="row">
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('workstream_id') ? 'has-error' : ''}}">
                                        <label for="workstream_id" class="control-label">Workstream Id<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="workstream_id" type="text" id="workstream_id" value="{{$price_ask_request->workstream_id }}">
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('sender_id') ? 'has-error' : ''}}">
                                        <label for="sender_id" class="control-label">Sender Id<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="sender_id" type="text" id="sender_id" value="{{$price_ask_request->sender_id }}">
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    
                                    <div class="form-group">
                                        <label for="receiver_id">Receiver <span class="text-danger">*</span></label>
                                        <select required name="receiver_id" id="receiver_id" class="form-control select2">
                                            <option value="" readonly>Select Receiver </option>
                                            @foreach(App\User::all()  as $option)
                                                <option value="{{ $option->id }}" {{ $price_ask_request->receiver_id  ==  $option->id ? 'selected' : ''}}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                                        <label for="price" class="control-label">Price<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="price" type="number" id="price" value="{{$price_ask_request->price }}">
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('qty') ? 'has-error' : ''}}">
                                        <label for="qty" class="control-label">Qty<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="qty" type="text" id="qty" value="{{$price_ask_request->qty }}">
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('total') ? 'has-error' : ''}}">
                                        <label for="total" class="control-label">Total</label>
                                        <input   class="form-control" name="total" type="text" id="total" value="{{$price_ask_request->total }}">
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="comment" class="control-label">Comment</label>
                                        <textarea  class="form-control" name="comment" id="comment" placeholder="Enter Comment">{{$price_ask_request->comment }}</textarea>
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('till_date') ? 'has-error' : ''}}">
                                        <label for="till_date" class="control-label">Till Date</label>
                                        <input   class="form-control" name="till_date" type="date" id="till_date" value="{{$price_ask_request->till_date }}">
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('details') ? 'has-error' : ''}}">
                                        <label for="details" class="control-label">Details</label>
                                        <input   class="form-control" name="details" type="text" id="details" value="{{$price_ask_request->details }}">
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select required name="status" id="status" class="form-control select2">
                                            <option value="" readonly>Select Status</option>
                                                                                        @php
                                                    $arr = "default";
                                            @endphp
                                                @foreach(explode(',',$arr) as $option)
                                                    <option value=" {{  $option }}" {{   $price_ask_request->status  ==  $option  ? 'selected' : ''}}>{{ $option}}</option> 
                                                @endforeach
                                                                                    </select>
                                    </div>
                                </div>
                                                            
                                <div class="col-md-12 mx-auto">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
    <script src="{{asset('backend/js/form-advanced.js') }}"></script>
    <script>
        $('#PriceAskRequestForm').validate();
                                                                                                                                                                                                                
    </script>
    @endpush
@endsection
