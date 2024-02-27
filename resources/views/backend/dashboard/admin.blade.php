@php
    $statistics = [
        [ 'a' => route('panel.brands.index'),'name'=>'Brands', "count"=> App\Models\Brand::count(), "icon"=>"<i class='ik ik-command f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'primary'],
        [ 'a' => route('panel.user_shops.index'),'name'=>'Micro Sites', "count"=>App\Models\UserShop::count(), "icon"=>"<i class='ik ik-home  f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'primary'],
        [ 'a' => route('panel.user_shop_items.index'),'name'=>'Master Products', "count"=>App\Models\UserShopItem::count(), "icon"=>"<i class='ik ik-shopping-bag f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'primary'],
        [ 'a' => route('panel.users.index')."?role=User",'name'=>'Customers', "count"=>App\User::role('User')->count(), "icon"=>"<i class='ik ik-users f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'primary'],
        [ 'a' => route('panel.users.index')."?role=User&isSupplier=1",'name'=>'Sellers', "count"=>App\User::role('User')->whereIsSupplier(1)->count(), "icon"=>"<i class='ik ik-user f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'primary'],
        [ 'a' => '#','name'=>'Kyc Request', "count"=>App\User::whereEkycStatus(3)->count(), "icon"=>"<i class=' ik ik-check-square f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'primary'],
        [ 'a' => route('panel.constant_management.user_enquiry.index'),'name'=>'New Enquiry', "count"=>App\Models\UserEnquiry::whereDate('created_at',Carbon\Carbon::now())->count(), "icon"=>"<i class='ik ik-mail f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'primary'],
        [ 'a' => route('panel.orders.index'),'name'=>'New Orders', "count"=>App\Models\Order::whereDate('created_at',Carbon\Carbon::now())->count(), "icon"=>"<i class='ik ik-shopping-cart f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'primary'],
        [ 'a' => url('panel/constant-management/support_ticket'),'name'=>'New Tickets', "count"=>App\Models\SupportTicket::whereStatus(0)->count(), "icon"=>"<i class='ik ik-mail f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'primary'],
    ];

    $users = App\User::whereEkycStatus(3)->latest()->get()->take(5);
@endphp 
<div class="row">
     <!-- peoduct statustic start -->
     <div class="col-xl-8">
        <div class="card product-progress-card">
            <div class="card-block">
                <div class="row pp-main">
                    @foreach ($statistics as $statistic)
                    <div class="col-xl-4 col-md-6">
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

        <div class="card">
            <div class="card-header">
                <h3>{{ __('Customers Acquisition Report')}}</h3>
            </div>
            <div class="card-block text-center">
                <div id="line_chart" class="chart-shadow"></div>
            </div>
        </div>
      
    </div>

    <div class="col-xl-4 col-md-8">
        <div class="card new-cust-card">
            <div class="card-header">
                <h3>{{ __('Role Report')}}</h3>
                <div class="card-header-right">
                    <ul class="list-unstyled card-option" style="height: 300px">
                        <li><i class="ik ik-chevron-left action-toggle"></i></li>
                        <li><i class="ik ik-minus minimize-card"></i></li>
                        <li><i class="ik ik-x close-card"></i></li>
                    </ul>
                </div>
            </div>
           <div id="container" class="chart-shadow"></div>
        </div>
        {{-- support ticket --}}
        <div class="card new-cust-card">
            <div class="card-header">
                @php
                    $supports = App\Models\SupportTicket::whereStatus(0)->latest()->get();                    
                @endphp
                <h3>{{ __('Support Tickets')}}</h3>
            </div>
            <div class="card-body">
                @if ($supports->count() > 0)
                <table class="table">
                   <thead>
                       <tr>
                           <th>{{ __('Name')}}</th>
                           <th>{{ __('Subject')}}</th>
                       </tr>
                   </thead>
                   <tbody>
                       @foreach ($supports as $support)
                           <tr>
                               <td>
                                   <a class="btn btn-link p-1 m-0" href="{{ route('panel.users.show',[$support->id,]) }}">

                                    <a class="btn btn-link p-1 m-0" href="{{ route('panel.constant_management.support_ticket.show',[$support->id]) }}">
                                       {{ NameById($support->user_id) }}
                                   </a>
                               </td>
                               <td>{{ ($support->subject) }}</td>
                           </tr>     
                       @endforeach
                   </tbody>
               </table>
                @else
                    <div class="text-center">
                        <img src="{{ asset('backend/img/Empty-pana.png') }}" style="height: 200px" alt="">
                        <p class="text-muted mb-0 pb-0 mt-3">Not Any New Support Tickets Yet!!</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- support ticket end --}}

          <div class="card new-cust-card">
            <div class="card-header">
                <h3>{{ __('eKyc Requests')}}</h3>
            </div>
            <div class="card-body">
                @if ($users->count() > 0)
                <table class="table">
                   <thead>
                       <tr>
                           <th>{{ __('Name')}}</th>
                           <th>{{ __('Request At')}}</th>
                       </tr>
                   </thead>
                   <tbody>
                       @foreach ($users as $user)
                           <tr>
                               <td>
                                   <a class="btn btn-link p-1 m-0" href="{{ route('panel.users.show',[$user->id,'showtype' => 'EKYC']) }}">
                                       {{ NameById($user->id) }}
                                   </a>
                               </td>
                               <td>{{ getFormattedDateTime($user->created_at) }}</td>
                           </tr>     
                       @endforeach
                   </tbody>
               </table>
                @else
                    <div class="text-center">
                        <img src="{{ asset('backend/img/Empty-pana.png') }}" style="height: 200px" alt="">
                        <p class="text-muted mb-0 pb-0 mt-3">Not Any New Request Received Yet!!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- peoduct statustic end -->
</div>


@push('script')
<script defer src="{{ asset('backend/plugins/amcharts/amcharts.js') }}"></script>
<script defer src="{{ asset('backend/plugins/amcharts/gauge.js') }}"></script>
<script defer src="{{ asset('backend/plugins/amcharts/serial.js') }}"></script>
<script defer src="{{ asset('backend/plugins/amcharts/themes/light.js') }}"></script>
<script defer src="{{ asset('backend/plugins/amcharts/animate.min.js') }}"></script>
<script defer src="{{ asset('backend/plugins/amcharts/pie.js') }}"></script>
<script defer src="{{ asset('backend/plugins/ammap3/ammap/ammap.js') }}"></script>
<script defer src="{{ asset('backend/plugins/ammap3/ammap/maps/js/usaLow.js') }}"></script>
<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-core.min.js"></script>
<script src="https://cdn.anychart.com/releases/8.11.0/js/anychart-pie.min.js"></script>
<script>
$(document).ready(function() {

     var chart = AmCharts.makeChart("line_chart", {
        "type": "serial",
        "theme": "light",
        "dataDateFormat": "YYYY-MM-DD",
        "precision": 2,
        "valueAxes": [{
            "id": "v1",
            "position": "left",
            "autoGridCount": false,
            "labelFunction": function(value) {
                return "$" + Math.round(value) + "M";
            }
        }, {
            "id": "v2",
            "gridAlpha": 0,
            "autoGridCount": false
        }],
        "graphs": [{
            "id": "g1",
            "valueAxis": "v2",
            "bullet": "round",
            "bulletBorderAlpha": 1,
            "bulletColor": "",
            "bulletSize": 8,
            "hideBulletsCount": 50,
            "lineThickness": 3,
            "lineColor": "#2ed8b6",
            "title": "Market Days",
            "useLineColorForBulletBorder": true,
            "valueField": "market1",
            "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[value]]</b>"
        }],
        "chartCursor": {
            "pan": true,
            "valueLineEnabled": true,
            "valueLineBalloonEnabled": true,
            "cursorAlpha": 0,
            "valueLineAlpha": 0.2
        },
        "categoryField": "date",
        "categoryAxis": {
            "parseDates": true,
            "dashLength": 1,
            "minorGridEnabled": true
        },
        "legend": {
            "useGraphSettings": true,
            "position": "top"
        },
        "balloon": {
            "borderThickness": 1,
            "shadowAlpha": 0
        },
        "dataProvider": [{
            "date": "2013-01-16",
            "market1": 71,
            "market2": 75
        }, {
            "date": "2013-01-17",
            "market1": 80,
            "market2": 84
        }, {
            "date": "2013-01-18",
            "market1": 78,
            "market2": 83
        }, {
            "date": "2013-01-19",
            "market1": 85,
            "market2": 88
        }, {
            "date": "2013-01-20",
            "market1": 87,
            "market2": 85
        }, {
            "date": "2013-01-21",
            "market1": 97,
            "market2": 88
        }, {
            "date": "2013-01-22",
            "market1": 93,
            "market2": 88
        }, {
            "date": "2013-01-23",
            "market1": 85,
            "market2": 80
        }, {
            "date": "2013-01-24",
            "market1": 90,
            "market2": 85
        }]
    });
});
// create data
var data = [
  {x: "A", value: 637166},
  {x: "B", value: 721630},
  {x: "C", value: 148662},
  {x: "D", value: 78662},
  {x: "E", value: 90000}
];

// create a pie chart and set the data
chart = anychart.pie(data);

/* set the inner radius
(to turn the pie chart into a doughnut chart)*/
chart.innerRadius("30%");

// set the container id
chart.container("container");

// initiate drawing the chart
chart.draw();
</script>

@endpush