
@php
    
    $breadcrumb_arr = [['name' => 'Edit Proposal', 'url' => 'javascript:void(0);', 'class' => '']];
    $user = auth()->user();
    $proposal_options = json_decode($proposal->options);

    // $proposal_options->show_Attrbute = $proposal_options->show_Attrbute ?? 0;

    // $proposal_options->show_Description = $proposal_options->show_Description ?? 0;
    $slug_guest = getShopDataByUserId(155)->slug;
    $offer_url = inject_subdomain("shop/proposal/$proposal->slug",$slug_guest);

    $make_offer_link = inject_subdomain('proposal/create', $slug_guest, false, false)."?linked_offer=".$proposal->id."&offer_type=2&shop=".$proposal->user_shop_id;

    if ($proposal->type == 1) {
        $offer_url = $make_offer_link;
    }
    $user_shop_record = App\Models\UserShop::whereId($proposal->user_shop_id)->first();
    $added_products = App\Models\ProposalItem::whereProposalId($proposal->id)->orderBy('pinned','DESC')->get();
    $excape_items = $added_products->pluck('product_id')->toArray();   
    $aval_atrribute = App\Models\ProductExtraInfo::whereIn('product_id',$excape_items)->groupBy('attribute_id')->pluck('attribute_id')->toArray(); 
    session()->put('offer_attribute_count',count($aval_atrribute));

@endphp


@if (count($aval_atrribute) != 0)
    <!-- {{-- modal start --}} -->
    <div id="animatedModal3" style="position: fixed;">
        <div id="btn-close-modal3" class="close-animatedModal3 custom-spacing" style="color: black; font-size: 1.5rem; height:0px; display: inline-block; padding: 5px;">
            <i class="far fa-times-circle fa-lg" style="transform: rotate(270deg);"></i>
        </div>
        
        {{-- <div id="btn-close-modal3" class="close-animatedModal3 custom-spacing" style="color:black; font-size: 1.5rem; height: fit-content; ">
            <i class="far fa-times-circle fa-rotate-270 fa-lg "></i>
        </div> --}}
        <div class="modal-content custom-spacing " style="background-color:#f3f3f3; top: 4%; height: 50vh; width: 50%;overflow-y:hidden!important; overflow-x:hidden!important">
            <div class="row">

                {{-- Code WIll Goes Heree.. --}}

                
                    <div class="h3 mt-3 mb-5" style="text-align: center">Fields to include <span class="text-danger" title="These details are kept private"><i class="uil-info-circle"></i></span> </div>
                    {{-- <div class="col-md-6 float-start">  --}}
                    {{-- <div class="form-group">
                        <label for="passcode" class="form-label">Enter Passcode <span class="text-danger" title="This details are kept private"><i class="uil-info-circle"></i></span> </label>
                        <input type="text" class="form-control" placeholder="0 0 0 0" name="password" id="passcode" maxlength="4" oninvalid="alert('Enter minimum 4 digit passcode')" value="{{ $offerPasscode ?? ""}}" required>
                    </div>  --}}

                    {{-- custom fields options --}}
                    
                    @php
                        if (request()->has('view')) { 
                            $view = request()->get('view');
                        }else{
                            $view = 'firstview';
                        }
                    @endphp
                    <div class ="container">
                    <form action="{{ request()->url() }}" method="get">
                        <input type="hidden" name="view" value="{{ $view }}">
                        <input type="hidden" name="download" value="{{ request()->get('download') }}">
                        <select name="optionsforoffer[]" class="form-control w-75 mx-2" id="chooseprop" multiple autofocus style="padding-left: 4%">                        
                            @foreach ($aval_atrribute as $item)
                                <option value="{{ $item }}" 
                                @if ($proposal->options != null && isset(json_decode($proposal->options)->show_Attrbute))
                                    @if (in_array($item,((array) json_decode($proposal->options)->show_Attrbute) ?? ['']))
                                        selected 
                                    @endif
                                @endif
                                >{{ getAttruibuteById($item)->name ?? '' }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    </div>

                    
            

                    {{-- @if ($proposal->relate_to == $proposal->user_shop_id)
                        <div class="form-group my-3">
                            <label class="form-label" for="valid_upto"> Offer Valid Upto </label>
                            <input class="form-control" type="date" id="valid_upto" name="valid_upto" value="{{ $proposal->valid_upto }}">
                        </div>
                    @endif --}}

                    
                    {{-- @if ($proposal->relate_to == $proposal->user_shop_id)
                        <div class="form-group my-3 d-none">
                            <label class="form-label" for="sample_charge"> Sample %age increase </label>
                            <input class="form-control" type="number" min="0" max="100" id="sample_charge" name="sample_charge" value="{{ $sample_charge }}" placeholder="% Increase">
                        </div>
                        <div class="form-group my-3">
                            <label class="form-label" for="sample_charge"> Weekly Update </label> --}}
                            {{-- <select name="offer_type" class="form-select form-control" id="offer_type">
                                <option value="0" @if ($proposal->type == 0) selected @endif>No</option>
                                <option value="1" @if ($proposal->type == 1) selected @endif>Yes</option>
                            </select> --}}
                            {{-- <br>
                            <input type="checkbox" name="offer_type"  value="1" @if ($proposal->type == 1) checked @endif id="weekupdate">

                        </div>
                    @endif --}}
                </div>

            </div>
        </div>
    </div>
@endif
