@extends('backend.layouts.main') 
@section('title', 'Manage Offers')
@section('content')
<style>
    .remove-ik-class{
            -webkit-box-shadow: unset !important;
            box-shadow: unset !important;
        }
</style>
@php
/**
 * Proposal 
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
        ['name'=>'Offers', 'url'=> "javascript:void(0);", 'class' => 'active']
    ]
    @endphp
    <!-- push external head elements to head -->
    @push('head')
    @endpush

    <div class="container-fluid">
    	<div class="page-header d-none">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-mail bg-blue"></i>
                        <div class="d-flex">
                            <h5>Offers</h5>
                            @if(AuthRole() == 'User')
                                <span style="margin-top: -10px;">
                                    <i class="ik ik-info fa-2x text-dark ml-2 remove-ik-class" title="help Text"></i>
                                </span>
                            @endif
                        </div>
                        {{-- <span>List of Proposals</span> --}}
                    </div>
                </div>
                <div class="col-lg-4">
                    @include("backend.include.breadcrumb")
                </div>
            </div>
        </div>
        
        <form action="{{ route('panel.proposals.index') }}" method="GET" id="TableForm">
            <div class="row">
                <!-- start message area-->
                <!-- end message area-->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3>Offers</h3>
                            <div class="d-flex justicy-content-right">
                                @php
                                    $slug = App\Models\UserShop::where('user_id',auth()->user()->id)->first()->slug;
                                @endphp
                                @if(AuthRole() != 'User')
                                    <div class="form-group mb-0 mr-2">
                                        <span>From</span>
                                    <label for=""><input type="date" name="from" class="form-control" value="{{request()->get('from')}}"></label>
                                    </div>
                                    <div class="form-group mb-0 mr-2"> 
                                        <span>To</span>
                                            <label for=""><input type="date" name="to" class="form-control" value="{{request()->get('to')}}"></label> 
                                    </div>
                                    <button type="submit" class="btn btn-icon btn-sm mr-2 btn-outline-warning" title="Filter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                    <a href="javascript:void(0);" id="reset" data-url="{{ route('panel.proposals.index') }}" class="btn btn-icon btn-sm btn-outline-danger mr-2" title="Reset"><i class="fa fa-redo" aria-hidden="true"></i></a>
                               @else
                                <a href="{{ inject_subdomain('proposal/create', $slug, true, false)}}" class="btn btn-primary mt-2 mx-auto text-center" @if(request()->has('active') && request()->get('active') == "enquiry") active @endif id="makeoffer">Make Offer</a>
                               @endif  
                            </div>
                        </div>
                        @if(AuthRole() != 'User')
                            <div id="ajax-container">
                                @include('panel.proposals.load')
                            </div>
                        @else
                            <div class="col-md-12">
                                <div class="card-body bg-white">
                                    <div class="row mt-3">
                                        
                                        @if ($proposals->count() > 0)
                                        @foreach ($proposals as $proposal)
                                            @php
                                                $customer_detail = json_decode($proposal->customer_details);
                                                $customer_name = $customer_detail->customer_name ?? '--';
                                                $customer_mob_no = $customer_detail->customer_mob_no ?? '--';
                                                $direct = $proposal->status == 0 ? "?direct=1" : "";
                                                $user_key = encrypt(auth()->id());
                                            @endphp

                                        <div class="col-12 border-bottom p-3" id="bro">
                                            <div class="row">
                                                <div class="d-flex justify-content-between col-md-12 pl-0 mt-lg-0 mt-md-0 mt-3 flex-wrap" style="width: 100%">
                                                    <div class="text-muted mb-0 " style="auto">
                                                        <span>
                                                            {{ json_decode($proposal->customer_details)->customer_name }}
                                                            @if ($proposal->status == 1)
                                                                <span class="text-success"> Sent </span>
                                                            @else
                                                                <span class="text-danger"> Draft </span>
                                                            @endif
                                                        </span>
                                                        <div>
                                                            <small class="text-muted">
                                                                <a href="{{ route("customer.checksample",$proposal->id)}}" target="_blank">
                                                                    Samples : {{ App\Models\Proposalenquiry::where('proposal_id',$proposal->id)->latest()->first()->sample_count ?? 0 }}
                                                                </a> ,&nbsp;

                                                            Amount : {{ @App\Models\Proposalenquiry::where('proposal_id',$proposal->id)->latest()->first()->amount ?? "0"  }}
                                                            </small>
                                                        </div>

                                                        <div class=" py-1" ><small class="text-muted">Last Access : {{ getFormattedDateTime($proposal->updated_at)  }}</small></div>
                                                        <div class="">
                                                            <small class="text-muted mx-1">
                                                                View : {{ $proposal->view_count ?? '<i class="fa fa-times-circle fa-sm text-danger"></i>'  }}
                                                            </small>
                                                            <small class="text-muted mx-1">
                                                                {{-- PPT : {{ $proposal->ppt_download ?? "No Open Yet"  }} --}}
                                                                Download:
                                                                @if ($proposal->ppt_download > 0 || $proposal->pdf_download > 0)
                                                                    <i class="fa fa-check-circle fa-sm text-success"></i>
                                                                @else
                                                                    <i class="fa fa-times-circle fa-sm text-danger"></i>
                                                                @endif
                                                            </small>
                                                        </div>
                                                    </div>

                                                    {{-- @if ($proposal->relate_to == null) --}}
                                                    @if ($proposal->relate_to == $proposal->user_shop_id || $proposal->relate_to == "" || $proposal->user_id == auth()->id())
                                                        <div style="display: flex;flex-direction: row-reverse;gap: 15px;font-size: 1.6vh;text-align: center !important;">
                                                            @php
                                                                $product_count = App\Models\ProposalItem::where('proposal_id',$proposal->id)->get()->count();
                                                            @endphp

                                                                <div class="dropdown">
                                                                    <button class="btn btn-outline-primary my-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        More <i class="uil-angle-right"></i>
                                                                    </button>
                                                                    <ul class="dropdown-menu">
                                                                    @if ($proposal->status == 1)
                                                                        @if ($product_count != 0)
                                                                            <li>
                                                                                <button class="dropdown-item copybtn"  value="{{inject_subdomain('shop/proposal/'.$proposal->slug, $slug) }}">
                                                                                    <i class="uil-link-alt"></i> Copy Link
                                                                                </button>
                                                                            </li>
                                                                        @endif
                                                                        <li>
                                                                            <a href="{{inject_subdomain('make-copy/'.$proposal->id,$slug) }}" class="dropdown-item">
                                                                                <i class="uil-copy"></i> Duplicate
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                    <li>
                                                                        <a href="{{ inject_subdomain('proposal/edit/'.$proposal->id.'/'.$user_key, $slug, false, false)}}?margin={{$proposal->margin ?? 10}}" class="dropdown-item" target="_blank">
                                                                            <i class="uil uil-comment-alt-edit h6"></i> Edit ( {{ $product_count }} )
                                                                        </a>
                                                                    </li>
                                                                    {{-- @if ($proposal->status == 1)
                                                                        <li>
                                                                            <a href="{{ route('customer.lock.enquiry',$proposal->id) }}" class="dropdown-item">
                                                                                <i class="uil-lock-alt h6"></i> 
                                                                            </a>
                                                                        </li>
                                                                    @endif --}}
                                                                    @if ($proposal->status == 1)
                                                                        <li>
                                                                            <a href="{{ route("panel.proposals.destroy",$proposal->id) }}" class="dropdown-item text-danger delete-item">
                                                                                <i class="uil uil-trash h6"></i> Delete
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                    </ul>
                                                                </div>



                                                                {{-- <div class="d-flex gap-2 justify-content-end mb-3 d-none">
                                                                    <a href="{{inject_subdomain('make-copy/'.$proposal->id,$slug) }}" class="btn btn-danger btn-sm">Duplicate</a>
                                                                    <button class="btn btn-success btn-sm copybtn" value="{{inject_subdomain('shop/proposal/'.$proposal->slug, $slug) }}">Copy Link</button>
                                                                    <a href="{{ inject_subdomain('proposal/edit/'.$proposal->id.'/'.$user_key, $slug, false, false)}}?margin={{$proposal->margin ?? 10}}" class="btn btn-outline-primary btn-sm shop-btn-mobile md-2" target="_blank">
                                                                        <i class="uil uil-comment-alt-edit h6"></i> Edit ( {{ $product_count }} )
                                                                    </a>
                                                                </div> --}}
                                                                {{-- <span class="mt-3">
                                                                    Passcode: {{ $proposal->password }}
                                                                </span> --}}
                                                                <br>
                                                                {{-- @if ($proposal->relate_to == $proposal->user_shop_id || $proposal->relate_to == "")
                                                                    <span class="mt-3">Expiry : {{ $proposal->valid_upto ?? "None"}} </span>
                                                                @endif --}}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                                                                    
                                        @endforeach

                                        @else
                                            <div class="col-12">
                                                <span class="mx-auto"> No Proposals yet!</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <div class="pagination">
                                    {{ $proposals->appends(request()->except('page'))->links() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        <form>
    </div>
    <!-- push external js -->
    @push('script')
    <script src="{{ asset('backend/js/index-page.js') }}"></script>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
           
        function html_table_to_excel(type)
        {
            var table_core = $("#table").clone();
            var clonedTable = $("#table").clone();
            clonedTable.find('[class*="no-export"]').remove();
            clonedTable.find('[class*="d-none"]').remove();
            $("#table").html(clonedTable.html());
            var data = document.getElementById('table');

            var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
            XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
            XLSX.writeFile(file, 'ProposalFile.' + type);
            $("#table").html(table_core.html());
            
        }

        $(document).on('click','#export_button',function(){
            html_table_to_excel('xlsx');
        })
       

        $('#reset').click(function(){
            var url = $(this).data('url');
            getData(url);
            window.history.pushState("", "", url);
            $('#TableForm').trigger("reset");
        });
    </script>


    <script>
        $(document).ready(function () {
            $("#makeoffer").click(function (e) { 
                e.preventDefault();
                var url = $(this).attr('href');
                // var msg = "<input type='text' id='margin' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Name'> <br> <input type='text' id='offeremail' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Email (Optional)'> <br> <input type='number' maxlength='10' id='offerphone' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Phone (Optional)'>";
                var msg = "<input type='text' id='margin' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Buyer Name'> <br> <input type='text' id='alias' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Alias (optional)'> <br> <input type='text' id='offeremail' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Email (Optional)'> <br> <input type='number' maxlength='10' id='offerphone' class='w-100' class='form-control my-3' style='margin-top: 10px;outline:none;border:none;border-bottom:1px solid #6666cc;' placeholder='Enter Phone (Optional)'>";

                $.confirm({
                    draggable: true,
                    title: 'Offer for',
                    content: msg,
                    type: 'blue',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Next',
                            btnClass: 'btn-primary',

                            action: function(){
                                    let margin = $('#margin').val();
                                    let offeremail = $('#offeremail').val();
                                    let offerphone = $('#offerphone').val();

                                    let alias = $('#alias').val();
                                    let personname = $('#offerpersonname').val();

                                    if (!margin) {
                                        $.alert('provide a valid name');
                                        return false;
                                    }
                                    url = url+"&offerfor="+margin+"&offerphone="+offerphone+"&offeremail="+offeremail+"&offeralias="+alias+"&offerpersonname="+personname;
                                    window.location.href = url;               
                                    // console.log(url);
                            }
                        },
                        close: function () {
                        }
                    }
                });
            });


            function copyTextToClipboard(text) {
                    if (!navigator.clipboard) {
                        fallbackCopyTextToClipboard(text);
                        return;
                    }
                    navigator.clipboard.writeText(text).then(function() {
                    }, function(err) {
                    });
                    $.toast({
                        heading: 'SUCCESS',
                        text: "Offer link copied.",
                        showHideTransition: 'slide',
                        icon: 'success',
                        loaderBg: '#f96868',
                        position: 'top-right'
                    });
            }

            $(".copybtn").click(function (e) {
                e.preventDefault();
                var link = $(this).val();
                copyTextToClipboard(link);
            });


            
        });
        
    </script>
    @endpush
@endsection
