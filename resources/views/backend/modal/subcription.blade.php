@if(AuthRole() == "User")
@php
    $user_package = App\Models\UserPackage::whereUserId(auth()->id())->first();
    if ($user_package) {
      $package = App\Models\Package::whereId($user_package->package_id)->first();
      $limits = json_decode($package->limit,true);
    }
@endphp
<div class="modal fade" id="subscriptionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Active Subscription</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
              <div class="row">
                <div class="col-lg-8 mx-auto">
                  <div class="card mb-5 mb-lg-0">
                   @if ( $user_package != null)
                      <div class="card-body">
                        {{-- @dump($user_package) --}}
                        @if($user_package->to < now())
                          <div class="d-flex justify-content-end">
                            <span class="badge badge-danger badge-sm">Expired</span>
                          </div>
                        @endif
                        <h5 class="card-title text-muted text-uppercase text-center">{{ $package->name }}</h5>
                        <h6 class="card-price text-center">{{ format_price($package->price) }}<span class="period"> - {{ $package->duration ?? '-' }} Days</span></h6>
                        <hr>
                        <ul class="fa-ul">
                            <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ $limits['add_to_site'] }} Add to my Site</li>
                            <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ $limits['custom_proposals'] }} Custom Proposals</li>
                            <li><span class="fa-li"><i class="fas fa-check"></i></span>{{ $limits['product_uploads'] }} Upload Products</li>
                        </ul>
                        <a href="{{ route('plan.index') }}" class="btn btn-block btn-outline-primary text-uppercase">Upgrade Plan</a>
                        
                      </div>
                      @if($user_package->to > now())
                        <div class="text-center">
                            <h6>The plan will expire on <span class="text-danger font-weight-bold">{{ $user_package->to }}</span></h6>
                        </div>
                      @endif
                    @else
                        <div class="text-center">
                          <img src="{{ asset('backend/img/Empty-pana.png') }}" style="height: 200px" alt="">
                          <p class="text-muted mb-0 pb-0 mt-3">You don't have any active subscription yet!</p>
                      </div>
                      <div class="mx-auto m-2">
                        <a href="{{ route('plan.index') }}" target="_blank" type="button" class="btn btn-outline-primary">Explore Plans</a>
                      </div>
                    @endif
                  </div>

                </div>
            </div>
        </div>
    </div>
  </div>
</div>
@endif