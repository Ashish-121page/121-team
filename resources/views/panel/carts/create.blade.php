@extends('backend.layouts.main') 
@section('title', 'Cart')
@section('content')
@php
/**
 * Cart 
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
    ['name'=>'Add Cart', 'url'=> "javascript:void(0);", 'class' => '']
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
                            <h5>Add Cart</h5>
                            <span>Create a record for Cart</span>
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
                        <h3>Create Cart</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.carts.store') }}" method="post" enctype="multipart/form-data" id="CartForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="user_id">User <span class="text-danger">*</span></label>
                                        <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select User </option>
                                            @foreach(UserList()  as $option)
                                                <option value="{{ $option->id }}" {{  old('user_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                                                                
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="user_shop_id">User Shop <span class="text-danger">*</span></label>
                                        <select required name="user_shop_id" id="user_shop_id" class="form-control select2">
                                            <option value="" readonly>Select User Shop </option>
                                            @foreach(App\Models\UserShop::all()  as $option)
                                                <option value="{{ $option->id }}" {{  old('user_shop_id') == $option->id ? 'Selected' : '' }}>{{  $option->name ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                                                                
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="product_id">Product <span class="text-danger">*</span></label>
                                        <select required name="product_id" id="product_id" class="form-control select2">
                                            <option value="" readonly>Select Product </option>
                                            @foreach(App\Models\Product::all()  as $option)
                                                <option value="{{ $option->id }}" {{  old('product_id') == $option->id ? 'Selected' : '' }}>{{  $option->title ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                                                                
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group">
                                        <label for="user_shop_item_id">User Shop Item <span class="text-danger">*</span></label>
                                        <select required name="user_shop_item_id" id="user_shop_item_id" class="form-control select2">
                                            <option value="" readonly>Select User Shop Item </option>
                                            @foreach(App\Models\UserShopItem::all()  as $option)
                                                <option value="{{ $option->id }}" {{  old('user_shop_item_id') == $option->id ? 'Selected' : '' }}>{{  $option->id ?? ''}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('qty') ? 'has-error' : ''}}">
                                        <label for="qty" class="control-label">Qty<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="qty" type="number" id="qty" value="{{old('qty')}}" placeholder="Enter Qty" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                                        <label for="price" class="control-label">Price<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="price" type="number" id="price" value="{{old('price')}}" placeholder="Enter Price" >
                                    </div>
                                </div>
                                                                                            
                                <div class="col-md-6 col-12"> 
                                    <div class="form-group {{ $errors->has('total') ? 'has-error' : ''}}">
                                        <label for="total" class="control-label">Total<span class="text-danger">*</span> </label>
                                        <input required  class="form-control" name="total" type="number" id="total" value="{{old('total')}}" placeholder="Enter Total" >
                                    </div>
                                </div>
                                                            
                                <div class="col-md-12 ml-auto">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Create</button>
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
        $('#CartForm').validate();
                                                                                                                                                    
    </script>
    @endpush
@endsection
