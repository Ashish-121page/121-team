@extends('backend.layouts.main') 
@section('title', 'Proposals')
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
        ['name'=>'Proposals', 'url'=> "javascript:void(0);", 'class' => 'active']
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
                            <h5>Proposals</h5>
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
                            <h3>Proposals</h3>
                            <div class="d-flex justicy-content-right">
                                @php
                                    $slug = App\Models\Usershop::where('user_id',auth()->user()->id)->first()->slug;
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
                                    <a href="{{ route('panel.proposals.create') }}" class="btn btn-icon btn-sm btn-outline-primary" title="Add New Proposal"><i class="fa fa-plus" aria-hidden="true"></i></a>

                                    <a href="{{ inject_subdomain('proposal/create', $slug, true, false)}}" class="btn btn-icon btn-sm btn-outline-danger mx-2 microproposal" title="Add New Proposal With Microsite" target="_blank"><i class="fa fa-minus" aria-hidden="true"></i></a>
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
                                                @endphp
                                                <div class="col-md-4">
                                                    {{-- @dump($proposal) --}}
                                                    <div class="card">
                                                        <div class="card-body text-center" style="padding: 8px 10px;">
                                                            <div class="profile-pic mb-20">
                                                                <div class="row">
                                                                    <div class="col-3 pr-0">
                                                                        <img class="supplier-image mt-1" src="{{ $proposal->client_logo != null  ?  asset($proposal->client_logo) : asset('backend/default/default-avatar.png') }}"
                                                                        style="object-fit: cover; height:60px;width:60px;" alt="" class="rounded mt-2">
                                                                    </div>
                                                                    
                                                                    <div class="col-6 pl-15 pt-1 text-left">
                                                                        <h6 class="mb-0">
                                                                            <a href="{{ route('panel.proposals.edit', $proposal->id).$direct }}"> <h6 class="mb-0">#PROID{{ $proposal->id }} </h6></a>
                                                                            
                                                                            @php
                                                                                $user_key = encrypt(auth()->id());
                                                                            @endphp
                                                                            <a href="{{ inject_subdomain('proposal/edit/'.$proposal->id.'/'.$user_key, $slug, false, false)}}?margin={{$proposal->margin ?? 10}}" target="_blank"> 
                                                                                <h6 class="mb-0 text-danger my-2">#MiCRO{{ $proposal->id }}</h6>
                                                                            </a>
                                                                            
                                                                        </h6>
                                                                        <span class="ml-2 mb-1 text-{{ getProposalStatus($proposal->status)['color']}}" style="line-height: 15px;">{{ getProposalStatus($proposal->status)['name']}}</span><br>
                                                                        <i class="ik ik-user"></i> {{ $customer_name ?? 'Unknown' }}  <br><i class="ik ik-phone"></i> <span>{{ $customer_mob_no ?? "N/A" }}</span>
                                                                        <br>
                                                                        <i title="incoming request" class="ik pr-1  ik-corner-up-left"></i>Items: <a href="{{ route('panel.proposals.edit', [$proposal->id,'type' => 'picked']) }}"
                                                                            class="btn-link" title="Edit Proposal"> {{ $proposal->items_count }}</a><br>
                                                                                <span>
                                                                                <i class="ik ik-clock"></i> {{ getFormattedDate($proposal->created_at) }}
                                                                                </span>
                                                                    </div>
                                                                    <div class="col-3">
                                                                       
                                                                        <button style="background: transparent;margin-left: -10px;" class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ik ik-more-vertical pl-1"></i></button>
                                                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                                                            @if($proposal->status == 1)
                                                                                <a href="{{ route('panel.proposals.edit', $proposal->id).$direct }}"
                                                                                    title="Show Proposal" class="dropdown-item">
                                                                                    <li class=" p-0">Show</li>
                                                                                </a>
                                                                            @else  
                                                                                <a href="{{ route('panel.proposals.destroy', $proposal->id) }}"
                                                                                    title="Delete Proposal" class="dropdown-item  delete-item">
                                                                                    <li class=" p-0">Delete</li>
                                                                                </a>
                                                                            @endif  
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td class="" colspan="8"><span class="mx-auto">
                                                    No Proposals yet!</span>
                                                </td>
                                            </tr>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between">
                                <div class="pagination">
                                    {{ $proposals->appends(request()->except('page'))->links() }}
                                </div>
                                <div>
                                    @if ($proposals->lastPage() > 1)
                                        <label for="">Jump To:
                                            <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="jumpTo">
                                                @for ($i = 1; $i <= $proposals->lastPage(); $i++)
                                                    <option value="{{ $i }}" {{ $proposals->currentPage() == $i ? 'selected' : '' }}>
                                                        {{ $i }}</option>
                                                @endfor
                                            </select>
                                        </label>
                                    @endif
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
              $(document).on('click','.microproposal',function(e){
                e.preventDefault();
                var url = $(this).attr('href');
                var msg = "<b>Step 1: </b>Set Approx Margin <input type='text' id='margin' class=' w-25' placeholder='Ex: 10'> % <div class='mt-1' > <b>Step 2: </b>Search and Shortlist</div><div class='mt-1' ><b>Step 3: </b>Review % Markup one-by-one</div><div class='mt-1' ><b>Step 4: </b>Send or Share</div>";

                $.confirm({
                    draggable: true,
                    title: 'Create New Proposal',
                    content: msg,
                    type: 'blue',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Confirm',
                            btnClass: 'btn-blue',

                            action: function(){
                                    let margin = $('#margin').val();
                                    if (!margin) {
                                        $.alert('provide a valid name');
                                        return false;
                                    }
                                    url = url+"&margin="+margin;
                                    window.location.href = url;                             
                            }
                        },
                        close: function () {
                        }
                    }
                });
            });
            
        </script>
    @endpush
@endsection
