@extends('backend.layouts.main') 
@section('title', 'Manage Currency')
@section('content')
<style>
    .remove-ik-class{
        -webkit-box-shadow: unset !important;
        box-shadow: unset !important;
    }
</style>
@php
/**
 * @Developer Ashish
 * @author  GRPL
 * @license  121.page
 * @version  <GRPL 1.1.0>
 * @link https://121.page/
 */
    $breadcrumb_arr = [
        ['name'=>'Currency', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                            <h5>Manage Currency</h5>
                            @if(AuthRole() == 'User')
                                <span style="margin-top: -10px;">
                                    <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="You Can Manege and Add Currency"></i>
                                </span>
                            @endif
                        </div>
                        {{-- <span>List of Groups</span> --}}
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
   
        <div class="row">
            <div class="col-md-12 col-12">
                @include('panel.currency.load')
            </div>
        </div>
        

        
        @include("panel.currency.modal.uploadfile")
        @include("panel.currency.modal.updatefile")
   
    </div>
    <!-- push external js -->
    @push('script')

    <script>
        $(document).ready(function () {
            $("#exportfile").click(function (e) { 
                e.preventDefault();
                $("#uploadfilemodal").modal('show')
            });

            $("#importfile").click(function (e) { 
                e.preventDefault();
                $("#updatefilemodal").modal('show')
            });            
            
        });



        
    </script>

    @endpush
@endsection
