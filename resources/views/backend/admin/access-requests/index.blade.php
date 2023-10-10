@extends('backend.layouts.main') 
@section('title', 'Access Catalogue Requests')
@section('content')
<style>
    .remove-ik-class{
            -webkit-box-shadow: unset !important;
            box-shadow: unset !important;
        }
</style>
@php
/**
 * Order 
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
        ['name'=>'Access Catalogue Requests', 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
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
                        <div class="d-flex">
                            <h5>Access Catalogue Requests</h5>
                            @if(AuthRole() == 'User')
                                <span style="margin-top: -10px;">
                                    <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                                </span>
                            @endif
                            {{-- <span>List of Access Code</span> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>

            <div class="row">
                <!-- start message area-->
                <!-- end message area-->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div>
                                <h3>Access Code</h3>
                            </div>
                            <div class="">
                                <form action="" class="d-flex">
                                    <div class="mr-2">
                                        <select name="user_type" id="" class="form-control select2">
                                            <option value="" aria-readonly="true">Select User Type</option>
                                            <option @if(request()->has('user_type') && request()->get('user_type') == 1) selected @endif value="1">Register Users</option>
                                            <option @if(request()->has('user_type') && request()->get('user_type') == 0) selected @endif  value="0">Non-Register Users</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                    <a href="{{ route('panel.catalogue-request') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                             <div class="table-responsive">
                                <table id="accessCode" class="table">
                                    <thead>
                                        <tr>
                                            <th  class="text-center">S.No </th>                     
                                            <th class="">Sender</th>
                                            <th class="">Receiver</th>
                                            <th class="">Status</th> 
                                            <th class="">Created At</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($accCatRequests as $accCatRequest)
                                            @php
                                                $sender = App\User::whereId($accCatRequest->user_id)->first();
                                                $receiver = App\User::wherePhone($accCatRequest->number)->first();
                                            @endphp
                                            <tr>
                                                <td class="text-center">#000ACR{{ $loop->iteration }}</td>
                                                <td>{{ $sender->name ?? 'Not Available' }}</td>
                                                <td>{{ $receiver->name ?? 'Not Available' }}</td>
                                                <td><span class="badge badge-{{ getCatalogueRequestStatus($accCatRequest->status)['color'] }}">{{ getCatalogueRequestStatus($accCatRequest->status)['name'] }}</span></td>
                                                <td>{{ getFormattedDate($accCatRequest->created_at) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                             </div>
                           
                        </div>
                       
                    </div>
                </div>
            </div>
    </div>
    <!-- push external js -->
    
@endsection

@push('script')
<script>
    $(document).ready(function() {
        var table = $('#accessCode').DataTable({
            responsive: true,
            fixedColumns: true,
            fixedHeader: true,
            scrollX: false,
            'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': ['nosort']
            }],
         

        });
    });
</script>


@endpush
