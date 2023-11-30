
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