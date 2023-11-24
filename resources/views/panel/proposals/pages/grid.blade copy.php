s


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

                  </div>
                    <small class="text-muted">
                      
                    </small>
                </div>
                <div class ="cardbody d-flex gap-2 p-4">
                  @foreach ($productItems as $key => $item)

                              @if ($key < 3)
                                  @php
                                      $mediarecord = App\Models\Media::where('type_id',$item->product_id)->where('tag','Product_Image')->first();
                                  @endphp
                                  @if ($mediarecord != null)
                  <div style="height: 100px; width: 100px;object-fit: contain">
                    <img src="{{ asset($mediarecord->path) ?? '' }}" alt="" class="img-fluid p-1" style="border-radius: 10px;height: 100%; width: 100%;">
                  </div>
                </div>









                      <div class="card-body border-dark">
                        <!-- Card Title -->
                        <div class="d-flex justify-content-between  mt-3">
                            <div class="mb-2">
                              <h6>Sent to
                                <br> 
                              <span>
                                {{ $customer_name }}
                                                
                              </span>
                            </h6>
                              <h6> {{ $product_count }} Product(s)</h6>
                            </div>
                            <div class="mb-2">               
                              <span>
                                
                                @if ($proposal->status == 1)
                                    <span class="text-success"> Sent </span>
                                @else
                                    <span class="text-danger"> Draft </span>
                                @endif
                              </span>            
                            </div>
                        </div>
                        <!-- Images Row -->
                        
                        <div class="row">
                          
                          @foreach ($productItems as $key => $item)

                              @if ($key < 3)
                                  @php
                                      $mediarecord = App\Models\Media::where('type_id',$item->product_id)->where('tag','Product_Image')->first();
                                  @endphp
                                  @if ($mediarecord != null)
                                    <div class="col-sm-4">
                                      <img src="{{ asset($mediarecord->path) ?? '' }}" alt="" height="40" width="40">
                                    </div>
                                  @endif
                                  
                                  
                              @endif
                          @endforeach

                          
                        </div>
                        <!-- Edit Button and Checkbox -->
                          <div class="d-flex justify-content-between align-items-center mt-3" style="max-height: fit-content">
                            {{-- <button class="btn btn-primary w-50">Edit</button> --}}
                            <a class="btn btn-primary w-50 mt-4" href="{{ inject_subdomain('proposal/edit/'.$proposal->id.'/'.$user_key, $slug, false, false)}}?margin={{$proposal->margin ?? 10}}" target="_blank" style="text-decoration: underline;">
                              <i class="uil uil-comment-alt-edit h6"></i> Edit ( {{ $product_count }} ) 
                            </a> 
                              {{-- @if ($proposal->relate_to == $proposal->user_shop_id || $proposal->relate_to == "" || $proposal->user_id == auth()->id())
                                    <div style="display: flex;gap: 15px;font-size: 1.6vh;text-align: center !important;">
                                        @php
                                            $product_count = App\Models\ProposalItem::where('proposal_id',$proposal->id)->get()->count();
                                        @endphp

                                            <div class="dropdown">
                                                <button class="btn btn-outline-primary my-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" target="_blank">
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
                                                
                                                @if ($proposal->status == 1)
                                                    <li>
                                                        <a href="{{ route("panel.proposals.destroy",$proposal->id) }}" class="dropdown-item text-danger delete-item">
                                                            <i class="uil uil-trash h6"></i> Delete
                                                        </a>
                                                    </li>
                                                @endif
                                                </ul>
                                            </div>



                                            
                                    </div>
                              @endif  --}}
                            {{-- <div class="form-check mt-4">               
                            <input type="checkbox" name="exportproduct" id="exportproduct" class="input-check">                
                            </div> --}}
                          </div>
                      </div>
                   
                
               </div>
              </div>
          @endforeach
        @endif      
    </div>      
  </div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

   