@extends('frontend.layouts.main-white')
@section('content')
<style>
    .t-select-btn{
        display: none !important;
    }
    .select2-container .select2-selection--multiple .select2-selection__rendered {
        overflow-y: scroll !important;
    }
</style>
    <section class="bg-home bg-circle-gradiant d-flex align-items-center">
        <div class="bg-overlay bg-overlay-white"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="form-signin p-4 bg-white rounded shadow">
                        <form action="{{ route('auth.code-validate') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('frontend/assets/img/logo-icon.png') }}" class="avatar avatar-small mb-4 d-block mx-auto" alt=""></a>
                                <div class="position-relative">
                                    <div class="position-absolute w-100 " style="top: 50%; transform: translateY(-50%); background: #6c636338; height: 5px; z-index: 1"></div>
                                    <div class="position-relative d-flex justify-content-between align-items-center" style="z-index: 10">
                                        @if(request()->routeIs('auth.access-code') == true)
                                            <span class="d-flex align-items-center text-white justify-content-center p-1 bg-primary" style="border-radius: 100%; height: 24px; width: 24px ">
                                                <i class="mdi mdi-check"></i>
                                            </span>
                                        @endif
                                        <span class="d-flex align-items-center text-white justify-content-center p-1 bg-primary" style="border-radius: 100%; height: 24px; width: 24px ">
                                                <i class="mdi mdi-check"></i>
                                        </span>
                                        <span class="d-flex align-items-center text-white justify-content-center p-1 bg-primary"  style="border-radius: 100%; height: 24px; width: 24px ">
                                            @if(!request()->routeIs('auth.access-code') == true)
                                                <i class="mdi mdi-check"></i>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-4 mt-1" style="font-size: 14px">
                                    <span class="text-center">OTP<br>Verified</span>
                                    <span class="text-center">Register</span>
                                    <span class="text-center">Finish</span>
                                </div>

                            {{-- <ul class="steper mb-3">
                                <hr class="step-hr">
                                <li><a href="#"><i class="mdi mdi-check"></i>
                                    <p class="mb-0">OTP Verified</p>
                                </a></li>
                                <li><a href="#" style="background:#fff;"><i class="mdi mdi-check"style="color:#444!important;"></i>
                                    <p class="mb-0">Register</p>
                                </a></li>
                                <li style="padding-right:0"><a href="#"><i class="mdi mdi-check"  style="background:#6666CC !important"></i>
                                    <p class="mb-0" style="color:#444!important;">Finish</p>
                                </a></li>
                                
                            </ul> --}}

                            <input type="hidden" name="industry_id" value="183">

                            <div class="mb-1">
                                <p class="text-info fw-600 d-none">Only one Profile can be selected at a time</p>
                                    <div class="t-dropdown-block">
                                        <div class="t-dropdown-select">
                                            <select required name="account_type" id="account_type" class="form-control" data-placeholder="Select Industry">
                                                {{-- @foreach(App\Models\Category::whereCategoryTypeId(13)->whereParentId(null)->whereType(1)->get()  as $option)
                                                    <option {{in_array($option->id, old('industry_id') ?: []) ? "selected" : ""}} value="{{ $option->id }}">{{  $option->name ?? ''}}</option> 
                                                @endforeach --}}
                                                <option selected>Select Profile Type</option>
                                                <option value="exporter">Exporter</option>
                                                <option value="supplier">Manufacturer / Stockist</option>
                                                <option value="reseller">Reseller</option>
                                                <option value="customer">End consumer</option>
                                            </select>
                                            <span class="t-select-btn">
                                            </span>
                                        </div>
                                       
                                    </div>
                            </div>
                            <div class="row text-center justify-content-center d-none" style="margin-top:20px;margin-bottom:20px;">
								<div class="col-lg-12" style="margin-bottom:10px;">
                                    <input name="img" style="display:none;" id="uploadfile" type="file">
                                    <button type="button" id="btnfile" class="btn btn-outline-primary w-100">Upload Visiting Card(Side 1)</button>
                                </div>
                                <img id="img_file" class="d-none mt-2"
                                style="border-radius: 10px;width:150px;height:80px;" />
                            </div>
                            {{-- <div style="border-top:1px solid #dbdbdb;margin:15px 10px;">
                                <h6 class="text-center mb-0" style="background: #fff;display:table;margin: -10px auto 0;padding: 0 12px; ">OR</h6>
                            </div> --}}
                            <div class="row mb-3" style="visibility: hidden">
                                <div class="col-lg-12">
                                    <p  style="padding-top:10px; font-weight:800; " class="mb-1">Access Code</p>
                                </div>
                                <div class="col-sm-12">
                                    <input name="access_code" type="text" class="form-control" id="code" placeholder="Enter Access Code">
                                </div>
                            </div>

                            @php
                                $suppliers = getAccessCatelogueRequestByNumber($user_data->phone, null, 5); 
                            @endphp

                            @if(!empty($suppliers))
                            <div class="d-flex justify-content-around text-center mb-2">
                                @foreach ($suppliers as $supplier)
                                @php
                                    $user_data = App\User::whereId($supplier->user_id)->first();
                                @endphp
                                    <div class="" style="margin-bottom:10px;">
                                        <img title="{{ $user_data->name }}" src="{{ ($user_data->avatar) ? $user_data->avatar : asset('backend/default/default-avatar.png') }}" class="img-fluid" style="border-radius: 50%;max-height: 50px !important;width: 50px !important;object-fit:cover;height: 50px !important;">
                                    </div>
                                @endforeach
                            </div>
                            @endif
                            <button class="btn btn-primary w-100" type="submit">Finish</button>
                            <p class="mb-0 text-muted mt-3 text-center" style="position:relative"><span style="position:absolute;left:0;">© {{ date('Y') }}</span> 121.Page</p>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!--end container-->
    </section>
@endsection
@push('script')
    <script>
            $("#btnfile").click(function () {
                $("#uploadfile").click();
            });
            document.getElementById('uploadfile').onchange = function() {
                var src = URL.createObjectURL(this.files[0])
                $('#img_file').removeClass('d-none');
                document.getElementById('img_file').src = src
            }
            $('.select2').select2();
            $(".select2").select2({
                placeholder: "Select Industry",
                allowClear: true
            });
        </script>
@endpush
