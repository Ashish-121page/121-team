@extends('backend.layouts.main')
@section('title', 'Claim Request')
@section('content')
    @php
    $breadcrumb_arr = [['name' => 'View User Note', 'url' => 'javascript:void(0);', 'class' => '']];
    @endphp
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
                            <h5> View Request of @if($claim_record->type == 0)  Brand Owner @else Authorized Seller @endif</h5>
                            <span>{{ __('View a record for Claim Request') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            @include('backend.include.message')
            <!-- end message area-->
            <div class="col-md-6 mx-auto">
                <div class="card ">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Claim Request</h3>
                        <span class="badge ml-3 badge-{{ $claim_record->is_verified == 0 ? 'danger' : 'success' }}">{{ $claim_record->is_verified == 1 ? 'Verified' : 'Not Verified' }}</span>
                    </div>
                    <div class="card-body">

                         {{-- For AS --}}
                        <div class="row">
                                {{-- Pending --}}
                                @if(isset($claim_record) && $claim_record->status == 0)
                                    <div class="col-12">
                                        <div class="alert alert-warning">
                                            Verify details wisely and take appropriated action
                                        </div>
                                    </div>

                                {{-- Accepted --}}
                                @elseif(isset($claim_record) && $claim_record->status == 1)
                                    <div class="col-12">
                                        <div class="alert alert-success">
                                            This request has been accepted
                                        </div>
                                    </div>

                                {{-- Rejected --}}
                                @elseif(isset($claim_record) && $claim_record->status == 2)
                                    <div class="col-12">
                                        <div class="alert alert-danger">
                                            This request has been rejected
                                        </div>
                                    </div>
                                @endif

                        </div>

                        <div class="">

                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Request ID</th>
                                        <td>#CRID{{ $claim_record->id }} </td>
                                    </tr>
                                    <tr>
                                        <th>Applied At</th>
                                        <td>
                                             {{ $claim_record->created_at->format('Y-m-d') }}    
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ NameById($claim_record->user_id) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Request For</th>
                                        <td>{{ $claim_record->type == 0 ? 'Authorized Seller' : 'Brand Owner' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Brand Name</th>
                                        <td>{{ getBrandRecordByBrandId($claim_record->brand_id)->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Established At</th>
                                        <td>{{ $details['est_date'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $details['address'] ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Brand Logo</th>
                                        <td>
                                            @if(isset($brand_logo->path))
                                            <a target="_blank" href="{{ asset($brand_logo->path) }}" class="badge badge-danger" download="">
                                               View Attachment
                                            </a>    
                                            @else 
                                            --
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Proof of Certificate</th>
                                        <td>
                                            @if(isset($brand_user_proof->path))
                                            <a target="_blank" href="{{ asset($brand_user_proof->path) }}" class="badge badge-danger" download>
                                               View Attachment
                                            </a>    
                                             @else 
                                            --
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <form class="row mb-3" action="{{ route('panel.brand.seller.claim.rejection.store',$brand_id) }}" method="post">
                                <input type="hidden" name="user_brand_id" id="" value="
                                {{ $claim_record->id }}">
                                @csrf
                                {{-- Pending --}}
                                @if(isset($claim_record) && $claim_record->status == 0)
                                <div class="col-12">
                                     <div class="alert alert-warning">
                                         This action is not rollbackable, Kindly take step wisly.
                                     </div>
                                </div>
                                    <div class="col-md-5 justify-content-center mx-auto">
                                    <div class="row form-radio">
                                        <div class="col-md-6">
                                            <div class="radio radio-inline">
                                                <label>
                                                    <input type="radio" name="type" value="1" class="adminApproval">
                                                    <i class="helper"></i>{{ __('Accept') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="radio radio-inline">
                                                <label>
                                                    <input type="radio" name="type" value="0" id="" class="adminApproval">
                                                    <i class="helper"></i>{{ __('Reject') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 adminResponse">
                                    <div class="form-group">
                                        <label for="">Rejection Reason</label>
                                        <textarea name="rejection_reason" id="" cols="30" rows="5" class="form-control " name="response" placeholder="Enter.."></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-5">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                                    </div>
                                </div>

                                {{-- Accepted --}}
                                @elseif(isset($claim_record) && $claim_record->status == 1)
                                    

                                {{-- Rejected --}}
                                @elseif(isset($claim_record) && $claim_record->status == 2)
                                    
                                @endif
                                
                                
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- push external js -->
    @push('script')
        <script>
            $('.adminResponse').hide();
            $('.adminApproval').on('click', function() {
                var value = $(this).val();
                if (value == 0) {
                    $('.adminResponse').show();
                } else {
                    $('.adminResponse').hide();
                }
            });
        </script>
    @endpush
@endsection
