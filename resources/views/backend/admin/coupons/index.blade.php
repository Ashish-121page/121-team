@extends('backend.layouts.main')
@section('title', 'Manage Short URLs')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('backend/plugins/DataTables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/dist/css/select2.min.css') }}">
    @endpush


    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-unlock bg-blue"></i>
                        <div class="d-flex">
                            <h5>Coupons</h5>
                        </div>
                        <span>{{ __('Create,Manange and Coupons ')}}</span>
                    </div>
                </div>
                <div class="col-lg-4">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="../index.html"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Manage Short Urls')}}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <!-- start message area-->
            @include('backend.include.message')
            <!-- end message area-->
            <!-- only those have manage_permission permission will get access -->
            @can('manage_permission')
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h3>{{ __('Add Url')}}</h3></div>
                    <div class="card-body">
                            <div class="row">

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <a href="javascript:void(0);" class="btn btn-primary addCoupon" data-id="{{ auth()->id() }}">Add Coupon</a>

                                    </div>
                                </div>

                            </div> {{--Row End--}}
                    </div>
                </div>
            </div>
            @endcan
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card p-3">

                    <form action="{{ route("panel.short_url.searchurl") }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex">
                            <input type="text" class="form-control " placeholder="Search Url Key" name="searchkey" value="{{ $request->searchkey ?? '' }}">
                            <button class="btn btn-primary mx-2" type="submit">search</button>
                        </div>
                    </form>

                    <div class="card-body">
                        <table id="url_table" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('#')}}</th>
                                    <th>{{ __('Action')}}</th>
                                    <th>{{ __('Name')}}</th>
                                    <th>{{ __('Code')}}</th>
                                    <th>{{ __('Discount')}}</th>
                                    <th>{{ __('For Plan')}}</th>
                                    <th>{{ __('Status')}}</th>
                                    <th>{{ __('Created At')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($coupons as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            <button class="btn btn-secondary">Action</button>
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->coupon_code }}</td>
                                        @php
                                            if ($item->discount_amt != null) {
                                                $amt = $item->discount_amt." ₹";
                                            }elseif ($item->discount_percent) {
                                                $amt = $item->discount_percent." %";
                                            }
                                        @endphp
                                        <td>{{ $amt ?? ''}}</td>

                                        <td>
                                            @php
                                                $plansapps = json_decode($item->plan_id);
                                            @endphp
                                            {{ App\Models\package::whereId($plansapps)->first()->name }}
                                        </td>
                                        <td>{{ ($item->terminated) ? 'Terminated' : "Activate" }}</td>
                                        <td>{{ $item->created_at }}</td>

                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>

                <div class="card-footer d-flex justify-content-between">
                    <div class="pagination">
                        {{ $short_url->appends(request()->except('page'))->links() }}
                    </div>
                    <div>
                        @if($short_url->lastPage() > 1)
                            <label for="">Jump To:
                                <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                                    @for ($i = 1; $i <= $short_url->lastPage(); $i++)
                                        <option value="{{ $i }}" {{ $short_url->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </label>
                        @endif
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>


    @include('backend.admin.coupons.modal.add');

    <!-- push external js -->
    @push('script')
    <script src="{{ asset('backend/plugins/select2/dist/js/select2.min.js') }}"></script>

    <script>


        $('.addCoupon').click(function(){
            user_id = $(this).data('id');
            $('#userId').val(user_id);
            $('#addCouponModal').removeAttr('tabindex');
            $('#addCouponModal').modal('show');
        });

        $("#markupstyle").change(function (e) {
            e.preventDefault();
            if ($(this).val() == 'rupee') {
                $("#amtpercent").addClass("d-none");
                $("#amtflat").addClass("d-none");
                $("#amtrupee").removeClass("d-none");
            }
            if ($(this).val() == 'percent') {
                $("#amtrupee").addClass("d-none");
                $("#amtflat").addClass("d-none");
                $("#amtpercent").removeClass("d-none");
            }
            if ($(this).val() == 'flat') {
                $("#amtrupee").addClass("d-none");
                $("#amtpercent").addClass("d-none");
                $("#amtflat").removeClass("d-none");
            }
        });



        // For Copy Text
        function copyTextToClipboard(text) {
            var text = $("#short").html();
                if (!navigator.clipboard) {
                    fallbackCopyTextToClipboard(text);
                    return;
                }
                navigator.clipboard.writeText(text).then(function() {
                }, function(err) {
                });
                $.toast({
                    heading: 'SUCCESS',
                    text: "Short Url copied successfully!",
                    showHideTransition: 'slide',
                    icon: 'success',
                    loaderBg: '#f96868',
                    position: 'top-right'
                });
            }

    </script>




    @endpush
@endsection
