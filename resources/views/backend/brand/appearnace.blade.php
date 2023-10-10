@extends('backend.layouts.main')
@section('title', 'Brand')
@section('content')
    @php
    /**
     * Brand
     *
     * @category  zStarter
     *
     * @ref  zCURD
     * @author    GRPL
     * @license  121.page
     * @version  <GRPL 1.1.0>
     * @link        https://121.page/
     */
    $breadcrumb_arr = [['name' => 'Edit Brand', 'url' => 'javascript:void(0);', 'class' => '']];
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
                            <h5>Edit Brand</h5>
                            <span>Update a record for Brand</span>
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
                        <h3>Update Brand</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.brands.update', $brand->id) }}" method="post"
                            enctype="multipart/form-data" id="BrandForm">
                            @csrf
                            <div class="row">

                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <label for="name" class="control-label">Name<span class="text-danger">*</span>
                                        </label>
                                        <input required class="form-control" name="name" type="text" id="name"
                                            value="{{ $brand->name }}">
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">

                                    <div class="form-group">
                                        <label for="user_id">User <span class="text-danger">*</span></label>
                                        <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select User </option>
                                            @foreach (App\User::role('Brand')->get() as $option)
                                                <option value="{{ $option->id }}"
                                                    {{ $brand->user_id == $option->id ? 'selected' : '' }}>
                                                    {{ $option->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
                                        <label for="logo" class="control-label">Logo</label>
                                        <input class="form-control" name="logo_file" type="file" id="logo">
                                        @if ($media != null)
                                            <img id="logo_file" src="{{ asset($media->path) }}" class="mt-2"
                                                style="border-radius: 10px;width:100px;height:80px;" />
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select required name="status" id="status" class="form-control select2">
                                            <option value="" readonly>Select Status</option>
                                            @foreach (getBrandStatus() as $option)
                                                <option value="{{ $option['id'] }}"
                                                    @if ($option['id'] == $brand->status) selected @endif>
                                                    {{ $option['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group {{ $errors->has('short_text') ? 'has-error' : '' }}">
                                        <label for="short_text" class="control-label">Short Text</label>
                                        <textarea class="form-control" name="short_text" type="text" id="short_text"
                                            value="">{{ $brand->short_text }}</textarea>
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
        <script src="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.js') }}"></script>
        <script src="{{ asset('backend/js/form-advanced.js') }}"></script>
        <script>
            $('#BrandForm').validate();

            document.getElementById('logo').onchange = function() {
                var src = URL.createObjectURL(this.files[0])
                $('#logo_file').removeClass('d-none');
                document.getElementById('logo_file').src = src
            }
        </script>
    @endpush
@endsection
