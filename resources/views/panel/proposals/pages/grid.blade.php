


<!-- Bootstrap CSS -->
{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
<div class="col-12">
  <div class="row">
      <div class="col-6 d-flex justify-content-between align-items-center">

          <div class=" mx-1">
              <input type="text" class="form-control" id="search_buyer" name="search" placeholder="Buyer Search">
          </div>                
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

  <div class="card-body1">
    <div class="d-flex gap-2 flex-wrap"> 
        @if ($proposals->count() > 0)
          @foreach ($proposals as $proposal)
              @php
                $customer_detail = json_decode($proposal->customer_details);
                $customer_name = $customer_detail->customer_name ?? '--';
                $customer_mob_no = $customer_detail->customer_mob_no ?? '--';
                $direct = $proposal->status == 0 ? "?direct=1" : "";
                $user_key = encrypt(auth()->id());
                $productItems = App\Models\ProposalItem::where('proposal_id',$proposal->id)->get();
                $product_count = $productItems->count();

              @endphp

              <div class="cardbx m-1 col-4 product-card product-box d-flex flex-column border bg-white m-1" style="width: 25rem;;max-width: 25rem; min-height: 13.5rem;max-height: 15rem;">
                  <div class="head d-flex justify-content-between mx-3 my-2">
                      <div class="one">
                        <div style="font-weight: bold">
                          {{ $customer_name }}
                        </div>
                          <small class="text-muted">
                            {{ $product_count }} Product(s)
                          </small>
                      </div>
                      <div class="two">
                        {{-- <div style="font-weight: bold">
                          {{ $customer_name }}
                        </div> --}}
                        @if ($proposal->status == 1)
                        <span class="text-success"> Sent </span>
                        @else
                            <span class="text-danger"> Draft </span>
                        @endif
                      </div>
                  </div>

                  <div class ="cardbody d-flex gap-2 p-4 justify-content-between">
                    @foreach ($productItems as $key => $item)
                      @if ($key < 3)
                          @php
                              $mediarecord = App\Models\Media::where('type_id',$item->product_id)->where('tag','Product_Image')->first();
                          @endphp
                          @if ($mediarecord != null)   
                                           
                            <div style="height: 100px; width: 100px;object-fit: contain; ">
                              <img src="{{ asset($mediarecord->path) ?? '' }}" alt="" class="img-fluid p-1" style="border-radius: 10px;height: 100%; width: 100%; background-color:grey; gap:10px;">
                            </div>   
                                        
                          @endif                                                                    
                      @endif
                    @endforeach
                  </div>

                  <div class="d-flex float-end justify-content-between">                    
                      <a class="btn btn-primary w-fit mx-1" href="{{ inject_subdomain('proposal/edit/'.$proposal->id.'/'.$user_key, $slug, false, false)}}?margin={{$proposal->margin ?? 10}}" target="_blank" style="text-decoration: none; margin-bottom: 10px ">
                        <i class="uil uil-comment-alt-edit h6"></i> Edit
                      </a>                      
                      
                    @if ($proposal->status == 1)                     
                      @if ($product_count != 0)                                               
                          <a class="btn-link text-primary copybtnw-fit mx-1"  href="{{inject_subdomain('shop/proposal/'.$proposal->slug, $slug) }}" style="text-decoration: underline;">
                              <i class="uil-link-alt"></i> Copy Link
                          </a>                                                
                      @endif                                            
                          <a class="btn-link text-primary w-fit mx-1" href="{{inject_subdomain('make-copy/'.$proposal->id,$slug) }}" class="" style="text-decoration: underline;">
                              <i class="uil-copy"></i> Duplicate
                          </a> 
                    @endif
                    @if ($proposal->status == 1)                                                                                  
                      <a href="{{ route("panel.proposals.destroy",$proposal->id) }}" class="text-danger delete-item mx-3" style="text-decoration: underline;">
                          <i class="uil uil-trash h6"></i> Delete
                      </a>                                                                                   
                    @endif 

                      <a class="btn btn-transparent w-fit" href="{{ inject_subdomain('proposal/picked/'.$proposal->id.'/'.$user_key, $slug, false, false)}}?type=send" target="_blank" style="text-decoration: none; margin-bottom: 10px; color:primary ">
                        <i class="fas fa-download" style="color:#6666cc"></i> 
                      </a>                                                                                        
                                                   
                  </div>
            
               </div>
             
          @endforeach
        @endif      
    </div>      
  </div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

   