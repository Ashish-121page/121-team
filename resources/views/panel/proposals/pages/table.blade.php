<<<<<<< HEAD
{{--`Start table--}}

=======
{{--` Start table --}}
>>>>>>> main
<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-6 d-flex justify-content-between align-items-center">
                @foreach ($proposals as $proposal)
                @php
                    $customer_detail = json_decode($proposal->customer_details);
                    $customer_name = $customer_detail->customer_name ?? '--';
                    $customer_mob_no = $customer_detail->customer_mob_no ?? '--';
                    $direct = $proposal->status == 0 ? "?direct=1" : "";
                    $user_key = encrypt(auth()->id());
                    $product_count = App\Models\ProposalItem::where('proposal_id',$proposal->id)->get()->count();
                @endphp
                @endforeach 
                <div class=" mx-1">          
                    <input type="text" class="form-control" id="search_buyer" name="search" placeholder="Buyer Search">
                </div>                
                       

                <div class=" mx-1">
                    <select name="" id="status_check" class="form-control" style="padding-right: 40px !important;">
                        <option value="status">All</option>
                        <option value="sent">Sent</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
                      
            </div>
            <div class="col-6 d-flex justify-content-end align-items-center">
                <a href="?view=listview" class="btn btn-outline-primary mx-1 @if(request()->get('view') == 'listview' ) active @endif"><i class="fas fa-list"></i></a>
                <a href="?view=gridview" class="btn btn-outline-primary mx-1 @if(request()->get('view') == 'gridview' ) active @endif"><i class="fas fa-th-large"></i></a>
                <a href="{{ inject_subdomain('proposal/create', $slug, true, false)}}" class="btn btn-outline-primary mx-1" @if(request()->has('active') && request()->get('active') == "enquiry") active @endif id="makeoffer">Make Offer</a>
            </div>

        </div>
    </div>
    <div class="col-12">
        <div class="table-responsive mt-3">
            <table id="table" class="table">
                <thead class="h5 text-muted">
                        <tr>
                            <td class="no-export action_btn"> 
                                {{-- <input type="checkbox" id="checkallinp"> --}}
                            </td> 
<<<<<<< HEAD
                            <td>Buyer Name</td>
=======
                            <td>Sent to</td>
>>>>>>> main
                            <td>Created on</td>
                            <td>Total Products</td>
                            <td>Status</td>
                            <td></td>
        
                            
                        </tr>
                </thead>
                <tbody>
                    @if ($proposals->count() > 0)
                        @foreach ($proposals as $proposal)
                            @php
                                $customer_detail = json_decode($proposal->customer_details);
                                $customer_name = $customer_detail->customer_name ?? '--';
                                $customer_mob_no = $customer_detail->customer_mob_no ?? '--';
                                $direct = $proposal->status == 0 ? "?direct=1" : "";
                                $user_key = encrypt(auth()->id());
                                $productItems = App\Models\ProposalItem::where('proposal_id',$proposal->id)->get();
                                $product_count = App\Models\ProposalItem::where('proposal_id',$proposal->id)->get()->count();
                            @endphp
                            
                            <tr>
                                <td class="no-export action_btn">
                                    {{-- @if($scoped_product->user_id == auth()->id()) --}}
                                        {{-- <input type="checkbox" name="exportproduct" id="exportproduct" class="input-check"> --}}
                                    {{-- @endif --}}
                                </td>   
                                <td class="d-flex justify-content-between">
                                    <span style="mr-3;">
                                        {{ $customer_name }}
                                    </span>
                                    <div class="d-flex justify-content-between" style="gap:10px;">
                                        
                                            @foreach ($productItems as $key => $item)
                                                @if ($key < 3)
                                                    @php
                                                        $mediarecord = App\Models\Media::where('type_id',$item->product_id)->where('tag','Product_Image')->first();
                                                    @endphp 
                                                    @if ($mediarecord != null)   
                                                        <div style="height: 60px;width: 60px; object-fit: contain;justify-content-end;">                                                                                                                                                                                                                                                                                                                                                           
                                                        <img src="{{ asset($mediarecord->path) ?? '' }}" alt="" class="img-fluid p-1" style="border-radius: 10px;height: 100%;width: 100%;background-color: gray;align-items: center;">
                                                        </div>   
                                                                    
                                                    @endif                                                                    
                                                @endif
                                            @endforeach
                                        </div>
                                  
                                </td>
                                
                                <td>
                                    <div class=" py-1" >{{ getFormattedDateTime($proposal->updated_at)  }}</div>
                                </td>
                                <td>
                                    <div class=" py-1" >{{ $product_count }} Product(s)</div>
                                </td>
                                <td>
                                    @if ($proposal->status == 1)
                                            <span class="text-success"> Sent </span>
                                        @else
                                            <span class="text-danger"> Draft </span>
                                        @endif
                                </td>
                  
                                <td>
<<<<<<< HEAD
                                    
                                    @if ($proposal->relate_to == $proposal->user_shop_id || $proposal->relate_to == "" || $proposal->user_id == auth()->id())                                        
                                        @php
                                            $product_count = App\Models\ProposalItem::where('proposal_id',$proposal->id)->get()->count();
                                        @endphp                                    
=======
                                    {{-- <a class="btn btn-outline-primary" href="{{ inject_subdomain('proposal/edit/'.$proposal->id.'/'.$user_key, $slug, false, false)}}?margin={{$proposal->margin ?? 10}}" target="_blank" style="border-radius: 10%">
                                        <i class="uil uil-comment-alt-edit h6"></i> Edit
                                    </a> --}}
                                    @if ($proposal->relate_to == $proposal->user_shop_id || $proposal->relate_to == "" || $proposal->user_id == auth()->id())
                                        {{-- <div style="display: flex;gap: 15px;font-size: 1.6vh;text-align: center !important;"> --}}
                                        @php
                                            $product_count = App\Models\ProposalItem::where('proposal_id',$proposal->id)->get()->count();
                                        @endphp

                                    
>>>>>>> main
                                        {{-- <button class="btn btn-outline-primary my-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            More <i class="uil-angle-right"></i>
                                        </button> --}}
                                      
                                        @if ($proposal->status == 1)
                                            @if ($product_count != 0)                                               
<<<<<<< HEAD
                                                <button class="btn-link text-primary copybtn mx-3"  value="{{inject_subdomain('shop/proposal/'.$proposal->slug, $slug) }}" style="text-decoration: underline; border:none;">
                                                    <i class="uil-link-alt"></i> Copy Link
                                                </button>                                                
=======
                                                <a class="btn-link text-primary copybtn mx-3"  href="{{inject_subdomain('shop/proposal/'.$proposal->slug, $slug) }}" style="text-decoration: underline;">
                                                    <i class="uil-link-alt"></i> Copy Link
                                                </a>                                                
>>>>>>> main
                                            @endif                                            
                                                <a class="btn-link text-primary mx-3" href="{{inject_subdomain('make-copy/'.$proposal->id,$slug) }}" class="" style="text-decoration: underline;">
                                                    <i class="uil-copy"></i> Duplicate
                                                </a>                                                                                        
                                        @endif                                                                                  
                                            <a class="btn-link text-primary mx-3" href="{{ inject_subdomain('proposal/edit/'.$proposal->id.'/'.$user_key, $slug, false, false)}}?margin={{$proposal->margin ?? 10}}" target="_blank" style="text-decoration: underline;">
                                                <i class="uil uil-comment-alt-edit h6"></i> Edit ( {{ $product_count }} ) 
<<<<<<< HEAD
                                            </a>                                                                                                                        
=======
                                            </a>                                        
                                        
                                        {{-- @if ($proposal->status == 1)                                            
                                                <a href="{{ route('customer.lock.enquiry',$proposal->id) }}" class="dropdown-item">
                                                    <i class="uil-lock-alt h6"></i> 
                                                </a>                                        
                                        @endif --}}
>>>>>>> main

                                        @if ($proposal->status == 1)                                                                                  
                                                <a href="{{ route("panel.proposals.destroy",$proposal->id) }}" class="text-danger delete-item mx-3" style="text-decoration: underline;">
                                                    <i class="uil uil-trash h6"></i> Delete
                                                </a>                                                                                   
                                        @endif                                                              
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
