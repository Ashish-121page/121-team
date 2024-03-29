{{-- `Start table --}}

<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-6 d-flex justify-content-between align-items-center">
                @foreach ($proposals as $proposal)
                    @php
                        $customer_detail = json_decode($proposal->customer_details);
                        $customer_name_ = $customer_detail->customer_name ?? '--';
                        $customer_mob_no = $customer_detail->customer_mob_no ?? '--';
                        $direct = $proposal->status == 0 ? '?direct=1' : '';
                        $user_key = encrypt(auth()->id());
                        $product_count = App\Models\ProposalItem::where('proposal_id', $proposal->id)
                            ->get()
                            ->count();
                    @endphp
                @endforeach
                <div class=" mx-1">
                    <input type="text" class="form-control" id="search_buyer" name="search" placeholder="Buyer Search"
                        value="{{ request()->get('Buyer_name', '') }}">
                </div>


                <div class=" mx-1">
                    <select name="" id="status_check" class="form-control"
                        style="padding-right: 40px !important;">
                        <option value="status" @if (request()->get('Sent') == '') selected @endif>All</option>
                        <option value="sent" @if (request()->get('Sent') == 'sent') selected @endif>Sent</option>
                        <option value="draft" @if (request()->get('Sent') == 'draft') selected @endif>Draft</option>
                    </select>
                </div>

            </div>
            <div class="col-6 d-flex justify-content-end align-items-center">
                {{-- <a href="?view=listview" class="btn btn-outline-primary mx-1 @if (request()->get('view') == 'listview') active @endif"><i class="fas fa-list"></i></a> --}}
                {{-- <a href="?view=gridview" class="btn btn-outline-primary mx-1 @if (request()->get('view') == 'gridview') active @endif"><i class="fas fa-th-large"></i></a> --}}
                
                {{-- original --}}
                <a href="{{ inject_subdomain('proposal/create', $slug, true, false) }}"
                    class="btn btn-outline-primary mx-1" @if (request()->has('active') && request()->get('active') == 'enquiry') active @endif
                    id="makeoffer">Make Offer</a>

                    {{-- <a href="{{ inject_subdomain('proposal/create', $slug, true, false) }}" class="btn btn-outline-primary mx-1" class="btn btn-link text-primary mx-2 "
                     @if (request()->has('active') && request()->get('active') == 'enquiry') active @endif
                    >Make Offer</a> --}}
            </div>

        </div>
    </div>
    <div class="col-12">
        <div class="table-responsive mt-3">
            <table id="table" class="table">
                <thead class="h6 text-muted">
                    <tr>
                        <td class="no-export action_btn">
                            {{-- <input type="checkbox" id="checkallinp"> --}}
                        </td>
                        <td>Buyer Name</td>
                        <td>Created on</td>
                        <td>Total Products</td>
                        <td></td>
                        <td>Offer Status</td>
                        <td>Quotation Status</td>


                    </tr>
                </thead>
                <tbody>
                    @if ($proposals->count() > 0)
                        @foreach ($proposals as $proposal)
                            @php
                                $customer_detail = json_decode($proposal->customer_details);
                                $customer_name1 = $customer_detail->customer_name ?? '--';
                                $customer_mob_no = $customer_detail->customer_mob_no ?? '--';
                                $direct = $proposal->status == 0 ? '?direct=1' : '';
                                $user_key = encrypt(auth()->id());
                                $productItems = App\Models\ProposalItem::where('proposal_id', $proposal->id)->get();
                                $product_count = App\Models\ProposalItem::where('proposal_id', $proposal->id)
                                    ->get()
                                    ->count();
                            @endphp

                            <tr>
                                <td class="no-export action_btn">
                                    {{-- @if ($scoped_product->user_id == auth()->id()) --}}
                                    {{-- <input type="checkbox" name="exportproduct" id="exportproduct" class="input-check"> --}}
                                    {{-- @endif --}}
                                </td>
                                <td class="d-flex justify-content-between">
                                    <div class="mt-2 my-1 py-2">
                                        <span>
                                            {{ $customer_name1 }}
                                        </span>
                                    </div>
                                    <div class="d-lg-flex d-none justify-content-between" style="gap:10px;">

                                        @foreach ($productItems as $key => $item)
                                            @if ($key < 3)
                                                @php
                                                    $mediarecord = App\Models\Media::where('type_id', $item->product_id)
                                                        ->where('tag', 'Product_Image')
                                                        ->first();
                                                @endphp
                                                @if ($mediarecord != null)
                                                    <div
                                                        style="height: 60px;width: 60px; object-fit: contain;justify-content-end;">
                                                        <img src="{{ asset($mediarecord->path) ?? '' }}" alt=""
                                                            class="img-fluid "
                                                            style="border-radius: 10px;height: 100%;width: 100%;align-items: center; padding:2px;">
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>

                                </td>

                                <td style=" align-items: center;">
                                    <div class=" py-1">{{ getFormattedDateTime($proposal->created_at) }}</div>
                                </td>
                                <td>
                                    <div class=" py-1">{{ $product_count }} Product(s)</div>
                                </td>
                                <td>

                                    @if ($proposal->relate_to == $proposal->user_shop_id || $proposal->relate_to == '' || $proposal->user_id == auth()->id())
                                        @php
                                            $product_count = App\Models\ProposalItem::where('proposal_id', $proposal->id)
                                                ->get()
                                                ->count();
                                        @endphp
                                        {{-- <button class="btn btn-outline-primary my-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            More <i class="uil-angle-right"></i>
                                        </button> --}}
                                        <div class=" float-end justify-content-between mt-2">

                                            <a class="btn btn-transparent w-fit"
                                                href="{{ inject_subdomain('proposal/picked/' . $proposal->id . '/' . $user_key, $slug, false, false) }}?type=send"
                                                target="_blank"
                                                style="text-decoration: none;  color:primary; padding:6px 5px!important;margin-bottom: 3px;">
                                                <i class="far fa-save text-primary"
                                                    style="font-size: 18px; margin-bottom: 3px;" title="Download"></i>
                                            </a>

                                            <a class="btn-link text-primary"
                                                href="{{ inject_subdomain('proposal/picked/' . $proposal->id . '/' . $user_key, $slug, false, false) }}?type=picked"
                                                target=""
                                                style="text-decoration: none; padding:6px 5px!important;">
                                                <i class="far fa-edit" title="Edit"></i>
                                            </a>

                                            @if ($proposal->status == 1)
                                                @if ($product_count != 0)
                                                    <button class="btn-link text-primary copybtn"
                                                        value="{{ inject_subdomain('shop/proposal/' . $proposal->slug, $slug) }}"
                                                        style="text-decoration: underline; border:none; margin-bottom:22px; padding:4px">
                                                        <i class="fas fa-link" title="Copy Link"></i>
                                                    </button>
                                                @endif
                                            @endif
                                            <a class="btn-link text-primary "
                                                href="{{ inject_subdomain('make-copy/' . $proposal->id, $slug) }}"
                                                class="" style="text-decoration: underline; padding: 4px;">
                                                <i class="far fa-copy" title="Duplicate"></i>
                                            </a>

                                            @if ($proposal->status == 1)
                                                <a href="{{ route('panel.proposals.destroy', $proposal->id) }}"
                                                    class="text-primary delete-item mx-2" style=" padding: 4px;">
                                                    <i class="fas fa-trash" title="Delete Offer"></i>
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </td>


                                <td>
                                    @if ($proposal->status == 1)
                                        <span class="text-success"> Sent </span>
                                    @else
                                        <span class="text-danger"> Draft </span>
                                    @endif
                                </td>

                                <td>
                                    @php
                                        $chkQuote = App\Models\Quotation::where('proposal_id', $proposal->id)->first();
                                    @endphp
                                    @if ($proposal->status == 1)
                                        @if ($chkQuote != null && $chkQuote->type_of_quote == 0)
                                            {{-- <a href="{{ route('panel.Documents.quotation2') }}?typeId={{ $chkQuote->id }}" class=""> --}}
                                                <i class="fas fa-check text-primary " title="{{ $chkQuote->user_slug ?? '' }}"></i>
                                            {{-- </a> --}}
                                        @else
                                            <a href="{{ route('panel.Documents.make.quote.offer',$proposal->id ) }}?proposalId={{ $proposal->id }}"
                                                class="text-dark"> Create Quotation </a>
                                            {{-- <h6 title="{{ $chkrec->first()->user_slug ?? '' }}"><i class="fas fa-check text-primary "></i></h6> --}}
                                        @endif
                                    @else
                                        <span class="text-danger"> Draft Offer </span>
                                    @endif

                                </td>


                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- @include('frontend.micro-site.og_proposals.modal.offerexpo') --}}


<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>
