@php
    $statistics = [
        [ 'a' => route('panel.access_codes.index'),'name'=>'Total Created Code', "count"=> App\Models\AccessCode::where('creator_id',auth()->id())->count(), "icon"=>"<i class='ik ik-codepen f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'primary'],
        [ 'a' => route('panel.access_codes.index'),'name'=>'Total Redeemed Code', "count"=>App\Models\AccessCode::where('redeemed_user_id',auth()->id())->count(), "icon"=>"<i class='ik ik-check-square  f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'primary'],
    ];
@endphp 
<div class="row">
    <div class="col-xl-6 col-lg-6 col-md-12 col-12">
        <div class="card product-progress-card">
            <div class="card-block">
                <div class="row pp-main">
                    @foreach ($statistics as $statistic)
                    <div class="col-xl-6 col-md-6">
                        <a href="{{ $statistic['a'] }}">
                            <div class="pp-cont">
                                <div class="row align-items-center mb-20">
                                    <div class="col-auto">
                                        {!! $statistic['icon'] !!}
                                    </div>
                                    <div class="col text-right">
                                        <h2 class="mb-0 text-{{ $statistic['color'] }}">{{ $statistic['count'] }}</h2>
                                    </div>
                                </div>
                                <div class="row align-items-center mb-15">
                                    <div class="col-auto">
                                        <p class="mb-0">{{ $statistic['name'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>  
    </div>
     <div class="col-xl-6 col-lg-6 col-md-12 col-12 mx-auto text-center">
        <div class="card proj-t-card">
            <div class="card-body">
                <div class="mx-auto text-center justify-content-center">
                    <img src="{{ asset('frontend/assets/img/customer/welcome.svg') }}" alt="" style="height: 245px;">
                    <h6>Welcome {{ auth()->user()->name }}</h6>
                    <a href="{{ route('panel.access_codes.index') }}" class="btn btn-primary">Access Codes</a>
                </div>
            </div>
        </div>
    </div>
    
</div>
