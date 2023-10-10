@extends('backend.layouts.main')
@section('title', 'Group')
@section('content')
    @php
    /**
     * Group
     *
     * @category  zStarter
     *
     * @ref  zCURD
     * @author    GRPL
     * @license  121.page
     * @version  <GRPL 1.1.0>
     * @link        https://121.page/
     */
    $breadcrumb_arr = [['name' => 'Edit Group', 'url' => 'javascript:void(0);', 'class' => '']];
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
                            <h5>Edit Group</h5>
                            {{-- <span>Update a record for Group</span> --}}
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
                        <h3>Update Group</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('panel.groups.update', $group->id) }}{{'?user='.request()->get('user')  }}" method="post"
                            enctype="multipart/form-data" id="GroupForm">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $group->user_id }}">
                            <div class="row">
                                {{-- <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="user_id">User <span class="text-danger">*</span></label>
                                        <select required name="user_id" id="user_id" class="form-control select2">
                                            <option value="" readonly>Select User </option>
                                            @foreach (App\User::all() as $option)
                                                <option value="{{ $option->id }}"
                                                    {{ $group->user_id == $option->id ? 'selected' : '' }}>
                                                    {{ $option->name ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-md-12 col-12">
                                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                        <label for="name" class="control-label">Name<span class="text-danger">*</span>
                                        </label>
                                        <input required class="form-control" name="name" type="text" id="name"
                                            value="{{ $group->name }}">
                                    </div>
                                </div>

                                {{-- <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="type">Type</label>
                                        <select required name="type" id="type" class="form-control select2">
                                            <option value="" readonly>Select Type</option>
                                             @foreach (getGroupType() as $option)
                                                <option value=" {{ $option['id'] }}"
                                                    {{ $group->type == $option['id'] ? 'selected' : '' }}>
                                                    {{ $option['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> --}}
                                @if (!request()->get('user'))
                                    <input type="hidden" name="type" value="1">
                                @else
                                   <input type="hidden" name="type" value="0">
                                @endif

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
            $('#GroupForm').validate();
        </script>
    @endpush
@endsection
