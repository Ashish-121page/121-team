@extends('backend.layouts.main')
@section('title', 'Category')
@section('content')
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
                        <h5>{{ __('Edit Category')}}</h5>
                        <span>{{ __('Update a record for Category')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <h4 class="mb-4"><b>{{__("429 Is New Entries")}}</b></h4> --}}
    <form action="{{ route('panel.constant_management.category.changeup') }}" method="POST">
        @csrf

        <div class="row my-3">
            <select name="work_type" id="work_type" class="form-control select2">
                <option value="0" selected>Select What You Wnat to Work</option>
                <option value="1">Update Category</option>
                <option value="2">Update Sub Category</option>
                {{-- <option value="3">Update Industry</option> --}}
            </select>
        </div>


        <div class="h5 my-4" id="head">Select What You Want To Do</div>

        <div class="d-none" id="one">
            <div class="h6 my-3"><b>{{ __("Update Category") }}</b></div>
            <div class="row my-3">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="sub_category_id">{{ __('Category Type Old')}} <span class="text-danger">*</span>
                        </label>
                        <select name="old_sub_category_type_id[]" id="old_sub_category_id" class="form-control select2"
                            multiple>
                            <option value="" readonly required>{{ __('Select Category Type')}}</option>
                            @foreach ($category as $item)
                            <option value="{{$item->id}}">{{$item->name}} -> {{$item->id}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="sub_category_id">{{ __('Sub Category')}} <span class="text-danger">*</span> </label>
                        <select name="subcate" id="subcate" class="form-control select2">
                            <option value="" readonly required>{{ __('Select Category Type')}}</option>
                            @foreach ($category as $item)
                            <option value="{{$item->id}}">{{$item->name}} -> {{$item->id}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="og_category_id">{{ __('New Categpry Type')}} <span class="text-danger">*</span>
                        </label>
                        <select name="new_category_type_id_sub" id="og_sub_category_id" class="form-control select2">
                            <option value="" readonly required>{{ __('Select Category Type')}}</option>
                            @foreach ($category as $item)
                            <option value="{{$item->id}}">{{$item->name}} -> {{$item->id}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-12 d-flex align-items-center justify-content-center mt-5">
                    <button class="btn btn-outline-danger" type="submit" name="subcat">Submit Category</button>
                </div>

            </div>
        </div>

        <div class="d-none" id="two">

            <div class="h6 my-3"><b>{{ __("Update Sub Category") }}</b></div>
            <div class="row ">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="old_category_id">{{ __('Old  Type')}} <span class="text-danger">*</span> </label>
                        <select name="sub_category_type_id[]" id="sub_category_id" class="form-control select2"
                            multiple>
                            <option value="" readonly required>{{ __('Select Sub Category Type')}}</option>
                            @foreach ($category as $item)
                            <option value="{{$item->id}}">{{$item->name}} -> {{$item->id}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="og_category_id">{{ __('New Type')}} <span class="text-danger">*</span> </label>
                        <select name="new_category_type_id" id="og_category_id" class="form-control select2">
                            <option value="" readonly required>{{ __('Select Category Type')}}</option>
                            @foreach ($category as $item)
                            <option value="{{$item->id}}">{{$item->name}} -> {{$item->id}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-sm-12 d-flex align-items-center justify-content-center mt-5">
                    <button class="btn btn-outline-danger" type="submit" name="chcat">Submit Sub Category</button>
                </div>

            </div>
        </div>
    </form>
</div>
<!-- push external js -->


<script>
    $(document).ready(function () {
        $("#work_type").change(function (e) {
            e.preventDefault();

            let opt = $(this).val()

            if (opt == 1) {
                greeting = "Good morning";
                $('#one').removeClass('d-none');
                $("#two").addClass('d-none');
                $("#head").addClass('d-none');
            } else if (opt == 2) {
                $('#two').removeClass('d-none');
                $("#one").addClass('d-none');
                $("#head").addClass('d-none');
            } else {
                $("#head").removeClass('d-none');
                $("#one").addClass('d-none');
                $("#two").addClass('d-none');
            }
            
        });
    });

</script>



@push('script')
@endpush
@endsection
