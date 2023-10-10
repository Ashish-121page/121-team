
@extends('backend.layouts.main')
@section('title', 'Widget Data')
@section('content')
<!-- push external head elements to head -->
@push('head')

<link rel="stylesheet" href="{{ asset('backend/plugins/weather-icons/css/weather-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/plugins/owl.carousel/dist/assets/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/plugins/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/plugins/chartist/dist/chartist.min.css') }}">
@endpush

<!-- feed widget -->

<div class="row clearfix">
    <div class="col-lg-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>Feeds</h3>
                <div class="d-flex align-right">
                    <select class="form-control w-80 ml-20">
                        <option selected="">Today</option>
                        <option value="1">Last Week</option>
                        <option value="2">Last Month</option>
                    </select>
                </div>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="ik ik-chevron-left action-toggle"></i></li>
                        <li><i class="ik ik-minus minimize-card"></i></li>
                        <li><i class="ik ik-x close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-body feeds-widget">
                {{--<div class="d-flex align-right">
                    <select class="form-control w-20 ml-auto">
                        <option selected="">Today</option>
                        <option value="1">Last Week</option>
                        <option value="2">Last Month</option>
                    </select>
                </div>--}}
                <div class="feed-item">
                    <a href="#">
                        <div class="feeds-left"><i class="fas fa-rupee-sign text-primary"></i></div>
                        <div class="feeds-body">
                            <h4 class="title text-primary">Rs. samples <small
                                    class="float-right text-muted"></small></h4>
                            <small>Customers requests should be confirmed</small>
                        </div>
                    </a>
                </div>
                <div class="feed-item">
                    <a href="#">
                        <div class="feeds-left"><i class="fas fa-file-alt text-success"></i></i></div>
                        <div class="feeds-body">
                            <h4 class="title text-success">Proposals not opened <small
                                    class="float-right text-muted"></small>
                            </h4>
                            <small>Should follow with Customers</small>
                        </div>
                    </a>
                </div>
                <div class="feed-item">
                    <a href="#">
                        <div class="feeds-left"><i class="fas fa-bell text-warning"></i></div>
                        <div class="feeds-body">
                            <h4 class="title text-warning">Customer requests <small
                                    class="float-right text-muted"></small></h4>
                            <small>Approve to get verified queries</small>
                        </div>
                    </a>
                </div>
                <div class="feed-item">
                    <a href="#">
                        <div class="feeds-left"><i class="fas fa-cart-plus text-danger"></i></div>
                        <div class="feeds-body">
                            <h4 class="title text-danger">7 days ago, Last Stock Update <small
                                    class="float-right text-muted"></small></h4>
                            <small>Update for HOT enquiries</small>
                        </div>
                    </a>
                </div>
                <div class="feed-item">
                    <a href="#">
                        <div class="feeds-left"><i class="fas fa-hands-helping text-purple"></i></div>
                        <div class="feeds-body">
                            <h4 class="title text-purple">Raise Support Ticket<small
                                    class="float-right text-muted"></small></h4>
                            <small>For any assistance</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- statistics -->
    <div class="col-xl-4 col-md-12">
        <div class="card table-card-right">
            <div class="card-header">
                <h3>{{ __('Statistics')}}</h3>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="ik ik-chevron-left action-toggle"></i></li>
                        <li><i class="ik ik-minus minimize-card"></i></li>
                        <li><i class="ik ik-x close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block pb-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 without-header">
                        <tbody>
                            <tr>
                                <td class="d-flex align-items-center">
                                    <div class="bg-pink fs-3 mr-2 " style="height: 10px;width: 10px; border-radius: 50%;"></div>
                                    <div class="h5">{{ format_price($enquiry_amt) }}</div>
                                    </li>
                                </td>
                                <td>
                                    <p>Rs. Sample value </p>
                                </td>
                                <!--td class="text-right">
                                    <label class="badge badge-warning">43%</label>
                                </td-->
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center">
                                    <div class="bg-success fs-3 mr-2 " style="height: 15px;width: 15px; border-radius: 50%;"></div>
                                    <h3>{{ $Numbverofoffer ?? 0 }}</h3>
                                </td>
                                <td>
                                    <p>No. of Offers </p>
                                </td>
                                <!--td class="text-right">
                                    <label class="badge badge-success">58%</label>
                                </td-->
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center">
                                    <div class="bg-warning fs-3 mr-2 " style="height: 15px;width: 15px; border-radius: 50%;"></div>
                                    <h3>{{ __('--')}}</h3>
                                </td>
                                <td>
                                    <p>Visitors on Display</p>
                                </td>
                                <!--td class="text-right">
                                    <label class="badge badge-danger">30%</label>
                                </td-->
                            </tr>
                            <tr>
                                <td class="d-flex align-items-center">
                                    <div class="bg-purple fs-3 mr-2 " style="height: 15px;width: 15px; border-radius: 50%;"></div>
                                    <h3>{{ $productcount  }}</h3>
                                </td>
                                <td>
                                    <p>Products on Display </p>
                                </td>
                                <!--td class="text-right">
                                    <label class="badge badge-danger">30%</label>
                                </td-->
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- member's performance -->

    
    <div class="col-xl-6 col-md-6">
        <div class="card table-card">
            <div class="card-header">
                <h3>{{('Member’s  performance')}}</h3>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="ik ik-chevron-left action-toggle"></i></li>
                        <li><i class="ik ik-minus minimize-card"></i></li>
                        <li><i class="ik ik-x close-card"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 without-header">
                        <thead>
                            <tr>
                              <th scope="col">Team Members</th>
                              <th scope="col">Last login</th>
                            </tr>
                          </thead>

                        <tbody>

                            @foreach ($teams as $item)
                                <tr>
                                    <td>
                                        <div class="d-inline-block align-middle">
                                            <img src="../121.page/img/users/4.jpg" alt="user image"
                                                class="rounded-circle img-40 align-top mr-15">
                                            <div class="d-inline-block">
                                                <h6 class="mb-0">{{ $item->name ?? "--" }}</h6>
                                                <p class="text-muted mb-0">{{ $item->designation ?? "--" }}</p>
                                                <p cass="text-muted mb-0">{{ $item->city ?? "--" }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text">
                                        <h6 class="fw-70">{{ $item->updated_at->format('d/m/Y') }}</h6>
                                    </td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>

            </div>

           






        </div>
    </div>
</div>
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('backend/plugins/owl.carousel/dist/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/flot-charts/jquery.flot.js') }}"></script>
    <script src="{{ asset('backend/plugins/flot-charts/jquery.flot.categories.js') }}"></script>
    <script src="{{ asset('backend/plugins/flot-charts/curvedLines.js') }}"></script>
    <script src="{{ asset('backend/plugins/flot-charts/jquery.flot.tooltip.min.js') }}"></script>

    <script src="{{ asset('backend/js/widget-data.js') }}"></script>
    @endpush
    @endsection

