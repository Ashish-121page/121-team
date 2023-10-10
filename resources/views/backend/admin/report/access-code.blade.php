@extends('backend.layouts.main') 
@section('title', 'Access Code')
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
        ['name'=>'Access Code', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                            <h5>Access Code</h5>
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
                            <h3>Access Code</h3>
                        </div>

                        <div class="card-body">
                             <div class="table-responsive">
                                <table id="accessCode" class="table">
                                    <thead>
                                        <tr>
                                            <th  class="text-center ">S.No </th>
                                            <th class="">Name</th>                       
                                            <th class="">Total AC</th>
                                            <th class="">Redeemed AC</th>
                                            <th class="">Pending AC</th> 
                                            <th class="">Performance </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(MarketerList() as  $Marketer)
                                            @php
                                              $total_ac = App\Models\AccessCode::where('creator_id',$Marketer->id)->count();
                                              $redeemed_ac = App\Models\AccessCode::where('creator_id',$Marketer->id)->where('redeemed_user_id','!=',null)->count();
                                              if($redeemed_ac != null){
                                                  $pending_ac = $total_ac - $redeemed_ac;
                                              }else{
                                                  $pending_ac = 0;
                                              }
                                            @endphp
                                            {{-- @dd( $pending_ac) --}}
                                            <tr>
                                                <td class="text-center ">{{ $loop->iteration }}</td>
                                                <td>{{ $Marketer->name }}</td>
                                                <td>{{ $total_ac }}</td>
                                                <td>{{ $redeemed_ac }}</td>
                                                <td>{{ $pending_ac }}</td>
                                                <td>
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="10" aria-valuemax="100" style="width: @if($pending_ac != 0 && $total_ac != 0) {{ $pending_ac*100/$total_ac }}% @endif"></div>
                                                    </div>
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
            // dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
            // buttons: [
            //     {
            //         extend: 'excel',
            //         className: 'btn-sm btn-success',
            //         header: true,
            //         footer: true,
            //         exportOptions: {
            //         columns: ':visible',
            //         }
            //     },
            //     // table.buttons( '.export' ).remove();
            //     'colvis',
            //     {
            //         extend: 'print',
            //         className: 'btn-sm btn-primary',
            //         header: true,
            //         footer: false,
            //         orientation: 'landscape',
            //         exportOptions: {
            //         columns: ':visible',
            //         stripHtml: false
            //         }
            //     }
            // ]

        });
    });
</script>


@endpush
