@extends('backend.layouts.main')
@section('title', 'Micro Sites')
@section('content')
    @php
    /**
     * User Shop
     *
     * @category  zStarter
     *
     * @ref  zCURD
     * @author    GRPL
     * @license  121.page
     * @version  <GRPL 1.1.0>
     * @link        https://121.page/
     */
    $breadcrumb_arr = [['name' => 'Add Micro Sites', 'url' => 'javascript:void(0);', 'class' => '']];
    @endphp
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
        <style>
            .error {
                color: red;
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
                            <h5>Add Micro Sites</h5>
                            <span>Create a record for Micro Sites</span>
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
                        <h3>Create Micro Sites</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.user_shops.store') }}" method="post" enctype="multipart/form-data"
                            id="UserShopForm">
                            @csrf
                            <div class="row">

                                <div class="col-md-4 col-12">

                                    <div class="form-group">
                                        <label for="user_id">User <span class="text-danger">*</span></label>
                                        <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select User </option>
                                            @foreach (UserList() as $option)
                                                <option value="{{ $option->id }}"
                                                    {{ old('user_id') == $option->id ? 'Selected' : '' }}>
                                                    {{ $option->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <label for="name" class="control-label">Name</label>
                                        <input class="form-control" name="name" type="text" id="name"
                                            value="{{ old('name') }}" placeholder="Enter Name">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12"> 
                                    <div class="form-group {{ $errors->has('img') ? 'has-error' : ''}}">
                                        <label for="img" class="control-label">Upload Banner Image</label>
                                        <input   class="form-control" name="img" type="file" id="img" value="{{old('img')}}" >
                                        <img id="img" class="d-none mt-2" style="border-radius: 10px;width:100px;height:80px;"/>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
                                        <label for="logo" class="control-label">Upload Business Logo</label>
                                        <input class="form-control" name="logo_file" type="file" id="logo"
                                            value="{{ old('logo') }}">
                                        <img id="logo_file" class="d-none mt-2"
                                            style="border-radius: 10px;width:100px;height:80px;" />
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group {{ $errors->has('contact_no') ? 'has-error' : '' }}">
                                        <label for="contact_no" class="control-label">Contact No</label>
                                        <input class="form-control" name="contact_no" type="number" id="contact_no"
                                            value="{{ old('contact_no') }}" placeholder="Enter Contact No">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="status">Status<span class="text-danger">*</span></label>
                                        <select required name="status" id="status" class="form-control select2">
                                            <option value="" readonly>Select Status</option>
                                                @foreach(getUserShopStatus() as $option)
                                                    <option value="{{  $option['id'] }}" {{  old('status') == $option ? 'Selected' : '' }}>{{ $option['name']}}</option> 
                                                @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="address" class="control-label">Address </label>
                                        <textarea class="form-control" name="address" id="address"
                                            placeholder="Enter Address">{{ old('address') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12"> 
                                    <div class="form-group">
                                        <label for="description" class="control-label">Description </label>
                                        <textarea  class="form-control" name="description" id="description" placeholder="Enter Description">{{ old('description')}}</textarea>
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
        <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
        <script>
            $('#UserShopForm').validate();

            document.getElementById('logo').onchange = function() {
                var src = URL.createObjectURL(this.files[0])
                $('#logo_file').removeClass('d-none');
                document.getElementById('logo_file').src = src
            }
        </script>
    @endpush
@endsection
