@extends('backend.layouts.main') 
@section('title', 'Order')
@section('content')
@php
/**
* Order 
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
    ['name'=>'Edit Order', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Edit Order</h5>
                            {{-- <span>Update a record for Order</span> --}}
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
                        <h3>Update Order</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.orders.update',$order->id) }}" method="post" enctype="multipart/form-data" id="OrderForm">
                            @csrf
                            <div class="row">
                                                                                            
                                <div class="col-md-6 col-12"> 
                                                                        <div class="form-group">
                                        <label for="user_id">User <span class="text-danger">*</span></label>
                                        <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select User </option>
                                            @foreach(App\User::all()  as $option)
                                                <option value="{{ $option->id }}" {{ $order->user_id  ==  $option->id ? 'selected' : ''}}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('txn_no') ? 'has-error' : ''}}">
                                        <label for="txn_no" class="control-label">Txn No<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="txn_no" type="text" id="txn_no" value="{{$order->txn_no }}">
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('discount') ? 'has-error' : ''}}">
                                        <label for="discount" class="control-label">Discount</label>
                                        <input   class="form-control" name="discount" type="number" step="any" id="discount" value="{{$order->discount }}">
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('tax') ? 'has-error' : ''}}">
                                        <label for="tax" class="control-label">Tax</label>
                                        <input   class="form-control" name="tax" type="number" id="tax" value="{{$order->tax }}">
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('sub_total') ? 'has-error' : ''}}">
                                        <label for="sub_total" class="control-label">Sub Total<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="sub_total" type="number" step="any" id="sub_total" value="{{$order->sub_total }}">
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('total') ? 'has-error' : ''}}">
                                        <label for="total" class="control-label">Total<span class="text-danger">*</span> </label>
                                        <input required   class="form-control" name="total" type="number" step="any" id="total" value="{{$order->total }}">
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                                        <label for="status" class="control-label">Status</label>
                                        <input   class="form-control" name="status" type="hidden" id="status" value="{{$order->status }}">
                                    </div>
                                </div>
                                                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('payment_gateway') ? 'has-error' : ''}}">
                                        <label for="payment_gateway" class="control-label">Payment Gateway</label>
                                        <input   class="form-control" name="payment_gateway" type="text" id="payment_gateway" value="{{$order->payment_gateway }}">
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="remarks" class="control-label">Remarks</label>
                                        <textarea  class="form-control" name="remarks" id="remarks" placeholder="Enter Remarks">{{$order->remarks }}</textarea>
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="from" class="control-label">From</label>
                                        <textarea  class="form-control" name="from" id="from" placeholder="Enter From">{{$order->from }}</textarea>
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="to" class="control-label">To</label>
                                        <textarea  class="form-control" name="to" id="to" placeholder="Enter To">{{$order->to }}</textarea>
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
        $('#OrderForm').validate();
                                                                                                                                                                                                                                        </script>
    @endpush
@endsection
