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
            <div class="col-md-6 mx-auto">
                <!-- start message area-->
                @include('backend.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-header">
                        <h3>Update Brand</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.brand_user.update', $brand_user->id) }}" method="post">
                            @csrf
                             <input type="hidden" name="brand_id" value="{{$brand_user->brand_id}}">
                             <input type="hidden" name="user_id " value="{{$brand_user->user_id}}">
                            <div class="row">
                                <div class="col-md-12 col-12"> 
                                    <div class="form-group">
                                        <label for="status">Status<span class="text-danger">*</span></label>
                                        <select required name="status" class="form-control select2"  >
                                            <option value="" readonly>{{ __('Select Status')}}</option>
                                            @foreach (getBrandRequestStatus() as $index => $item)
                                                <option value="{{ $item['id'] }}" @if ($item['id'] == $brand_user->status) selected @endif>{{ $item['name'] }}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12"> 
                                    <div class="form-group {{ $errors->has('is_verified') ? 'has-error' : ''}}">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="is_verified" name="is_verified"
                                                value="1" @if ($brand_user->is_verified == 1)  checked selected @endif>
                                            <span class="pt-1 custom-control-label">&nbsp;Verify</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 text-right">
                                <button type="submit" class="btn btn-outline-primary">Save</button>
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
