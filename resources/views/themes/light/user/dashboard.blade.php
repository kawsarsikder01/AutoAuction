@extends($theme.'layouts.user')
@section('title',trans('Dashboard'))
@section('content')
<div class="container-fluid content">
    <div class="main row">
       <div class="col-12">
          <div class="row g-4">
            <div class="col-12">
               <div class="card-box p-0" id="alert">
                 <div class="alertContent " id="alertContent">
                     <div class="icon content"><i class="fa-solid fa-circle-info"></i></div>
                     <div class="text content">Do not miss any single important notification allow your browser to get instant push notification</div>
                     <div class="button content"><button class="btn-custom" >allow me</button></div>
                 </div>
                 <div class="crossbtn">
                  <i class="fa-solid fa-xmark"></i>
               </div>
               </div>
            </div>
             <!-- quick links -->
             <div class="col-12 d-lg-none">
                <div class="quick-links">
                   <div class="row g-2 g-lg-4">
                      <div class="col-md-3 col-4 col-sm-3">
                         <div class="link-item">
                            <a href="{{route('user.add.fund')}}">
                               <i class="fal fa-chart-bar"></i>
                               <span>Deposit</span>
                            </a>
                         </div>
                      </div>
                      <div class="col-md-3 col-4 col-sm-3">
                         <div class="link-item">
                            <a href="{{route('user.payout')}}">
                               <i class="fal fa-chart-pie-alt"></i>
                               <span>Withdraw</span>
                            </a>
                         </div>
                      </div>
                      <div class="col-md-3 col-4 col-sm-3">
                         <div class="link-item">
                            <a href="{{route('user.profile')}}">
                               <i class="fal fa-user-cog"></i>
                               <span>Settings</span>
                            </a>
                         </div>
                      </div>
                      <div class="col-md-3 col-4 col-sm-3">
                         <div class="link-item">
                            <a href="{{route('page','contact')}}">
                               <i class="fal fa-user-headset"></i>
                               <span>Support</span>
                            </a>
                         </div>
                      </div>
                      <div class="col-md-3 col-4 col-sm-3">
                         <div class="link-item">
                            <a href="{{route('user.twostep.security')}}">
                               <i class="fal fa-badge-check"></i>
                               <span>2fa</span>
                            </a>
                         </div>
                      </div>
                   </div>
                </div>
             </div>

             <!-- card boxes -->
             <div class="col-12 d-none d-lg-block">
                <div class="row g-4">
                   <div class="col-xl-3 col-lg-4 col-md-12 ">
                      <div class="card-box">
                         <div class="d-flex justify-content-between">
                            <h4>{{number_format(Auth::user()->balance, 2, '.', ',')??0 }} {{" ".basicControl()->currency_symbol}}</h4>
                             <i class="fa-solid fa-wallet"></i>
                         </div>
                         <p class="mb-0">Current Balance</p>
                      </div>
                   </div>
                   <div class="col-xl-3 col-lg-4 col-md-12">
                      <div class="card-box">
                         <div class="d-flex justify-content-between">
                            <h4>{{number_format(Auth::user()->hold_balance, 2, '.', ',')?? 0}} {{" ".basicControl()->currency_symbol}}</h4>
                             <i class="fa-light fa-chart-pie-simple"></i>
                         </div>
                         <p class="mb-0">Hold Balance</p>
                      </div>
                   </div>
                   <div class="col-xl-3 col-lg-4 col-md-12">
                      <div class="card-box">
                         <div class="d-flex justify-content-between">
                            <h4>{{count(Auth::user()->vehicle)}}</h4>
                            <i class="fa-light fa-chart-network"></i>
                         </div>
                         <p class="mb-0">Total Listed Vehicle</p>
                      </div>
                   </div>
                   <div class="col-xl-3 col-lg-4 col-md-12">
                      <div class="card-box">
                         <div class="d-flex justify-content-between">
                            <h4>{{count($cancelAuction)}}</h4>
                             <i class="fa-solid fa-rectangle-xmark"></i>
                         </div>
                         <p class="mb-0">Total Canceled Auction</p>
                      </div>
                   </div>
                   <div class="col-xl-3 col-lg-4 col-md-12">
                      <div class="card-box">
                         <div class="d-flex justify-content-between">
                            <h4>{{count($soldedVehicle) - count($cancelAuction)}}</h4>
                             <i class="fa-solid fa-truck-monster"></i>
                         </div>
                         <p class="mb-0">Total Sold Vehicle</p>
                      </div>
                   </div>
                   <div class="col-xl-3 col-lg-4 col-md-12">
                      <div class="card-box">
                         <div class="d-flex justify-content-between">
                            <h4>{{count($totalWinAuction)}}</h4>
                             <i class="fa-light fa-chart-mixed"></i>
                         </div>
                         <p class="mb-0">Total Win Auction</p>
                      </div>
                   </div>
                        <div class="col-xl-3 col-lg-4 col-md-12">
                            <div class="card-box">
                                <div class="d-flex justify-content-between">
                                    {!! Auth::user()->plan?'<h4>'.Auth::user()->plan->plan_name.'</h4>':'<p>'.'Explore a Strategic Selling Plan for Your Vehicle – Maximize Your Selling Potential Now!'.'</p>' !!}
                                    <i class="fa-solid fa-cube"></i>
                                </div>
                                <p class="mb-0"> {{Auth::user()->plan?'Current Plan':''}}</p>
                            </div>
                        </div>
                    <div class="col-xl-3 col-lg-4 col-md-12">
                        <div class="card-box">
                            <div class="d-flex justify-content-between">
                                <h4>{{count(Auth::user()->supportTickets)}}</h4>
                                <i class="fa-regular fa-paper-plane"></i>
                            </div>
                            <p class="mb-0">Total Support Ticket</p>
                        </div>
                    </div>
                </div>
             </div>

             <!-- card boxes with slider -->
             <div class="col-12 d-lg-none">
                <div class="row g--4 g-0 card-box-wrapper owl-carousel card-boxes">
                   <div class="card-box">
                      <div class="d-flex justify-content-between">
                         <h4>{{number_format(Auth::user()->balance, 2, '.', ',')??0 }} {{" ".basicControl()->currency_symbol}}</h4>
                         <i class="fa-light fa-chart-pie-simple"></i>
                      </div>
                      <p class="mb-0">Current Balance</p>
                   </div>
                   <div class="card-box">
                      <div class="d-flex justify-content-between">
                         <h4>{{number_format(Auth::user()->hold_balance, 2, '.', ',')?? 0}} {{" ".basicControl()->currency_symbol}}</h4>
                         <i class="fa-light fa-file-chart-pie"></i>
                      </div>
                      <p class="mb-0">Hold Balance</p>
                   </div>
                   <div class="card-box">
                      <div class="d-flex justify-content-between">
                         <h4>{{count(Auth::user()->vehicle)}}</h4>
                         <i class="fa-light fa-chart-network"></i>
                      </div>
                      <p class="mb-0">Total Listed Vehicle</p>
                   </div>
                   <div class="card-box">
                      <div class="d-flex justify-content-between">
                         <h4>{{count($cancelAuction)}}</h4>
                         <i class="fa-light fa-chart-mixed"></i>
                      </div>
                      <p class="mb-0">Total Canceled Auction</p>
                   </div>
                   <div class="card-box">
                      <div class="d-flex justify-content-between">
                         <h4>{{count($soldedVehicle)}}</h4>
                         <i class="fa-light fa-chart-pie-simple"></i>
                      </div>
                      <p class="mb-0">Total Sold Vehicle</p>
                   </div>
                   <div class="card-box">
                      <div class="d-flex justify-content-between">
                         <h4>{{count($totalWinAuction)}}</h4>
                         <i class="fa-light fa-file-chart-pie"></i>
                      </div>
                      <p class="mb-0">Total Win Auction</p>
                   </div>
                </div>
             </div>
              <div class="col-12">
                  <div class="row">
                      <div class="col-xl-6 col-lg-12">
                          <div class="card rounded-4">
                              <h3 class="card-title d-block m-auto pt-3     ">
                                  Transaction Summary
                              </h3>
                              <div class="card-box">
                                  <canvas  id="myChart"></canvas>
                              </div>
                          </div>
                      </div>
                      <div class="col-xl-6 col-lg-12 mt-xl-0 mt-lg-4 mt-sm-4">
                          <div class="card rounded-4">
                              <h3 class="card-title d-block m-auto pt-3">
                                  Bid History
                              </h3>
                              <div class="card-box">
                                  <canvas  id="BidHistory"></canvas>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-12">
                <div class="row">
                    <div class="col-xl-4 col-lg-6 mb-3 mb-lg-5">
                        <div class="card custom-chart">
                            <div class="card-header bg-white">
                                <h4 class="card-header-title d-block m-auto p-1">
                                    Device History
                                </h4>
                            </div>
                            <div class="card-body  " >
                                <canvas id="GetDeviceHistory" ></canvas>
                            </div>
                            <div class="card-footer bg-white">
                                <span class="d-block text-center">@lang("Last 30 Days Device History")</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 mb-3 mb-lg-5">
                        <div class="card custom-chart">
                            <div class="card-header bg-white ">
                                <h4 class="card-header-title d-block m-auto p-1">
                                    Browser History
                                </h4>
                            </div>
                            <div class="card-body">
                                <canvas id="GetBrowserHistory" ></canvas>
                            </div>
                            <div class="card-footer bg-white">
                                <span class="d-block text-center">@lang("Last 30 Days Device History")</span>
                            </div>

                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 mb-3 mb-lg-5">
                        <div class="card  custom-chart">
                            <div class="card-header bg-white">
                                <h4 class="card-header-title d-block m-auto p-1">
                                    Operating System History
                                </h4>
                            </div>
                            <div class="card-body ">
                                <canvas id="GetOperatingSystemHistory"></canvas>
                            </div>
                            <div class="card-footer bg-white">
                                <span class="d-block text-center">@lang("Last 30 Days Device History")</span>
                            </div>
                        </div>
                    </div>
                </div>
              </div>

          </div>
       </div>
    </div>
 </div>




@endsection
@push('js-lib')
    <script src="{{ asset('assets/admin/js/Chart.min.js') }}"></script>
@endpush

@if($firebaseNotify)
    @push('script')
        <script type="module">

            import {initializeApp} from "https://www.gstatic.com/firebasejs/9.17.1/firebase-app.js";
            import {
                getMessaging,
                getToken,
                onMessage
            } from "https://www.gstatic.com/firebasejs/9.17.1/firebase-messaging.js";

            const firebaseConfig = {
                apiKey: "{{$firebaseNotify['apiKey']}}",
                authDomain: "{{$firebaseNotify['authDomain']}}",
                projectId: "{{$firebaseNotify['projectId']}}",
                storageBucket: "{{$firebaseNotify['storageBucket']}}",
                messagingSenderId: "{{$firebaseNotify['messagingSenderId']}}",
                appId: "{{$firebaseNotify['appId']}}",
                measurementId: "{{$firebaseNotify['measurementId']}}"
            };

            const app = initializeApp(firebaseConfig);
            const messaging = getMessaging(app);
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('{{ getProjectDirectory() }}' + `/firebase-messaging-sw.js`, {scope: './'}).then(function (registration) {
                        requestPermissionAndGenerateToken(registration);
                    }
                ).catch(function (error) {
                });
            } else {
            }

            onMessage(messaging, (payload) => {
                if (payload.data.foreground || parseInt(payload.data.foreground) == 1) {
                    const title = payload.notification.title;
                    const options = {
                        body: payload.notification.body,
                        icon: payload.notification.icon,
                    };
                    new Notification(title, options);
                }
            });

            function requestPermissionAndGenerateToken(registration) {
                document.addEventListener("click", function (event) {
                    if (event.target.id == 'allow-notification') {
                        Notification.requestPermission().then((permission) => {
                            if (permission === 'granted') {
                                getToken(messaging, {
                                    serviceWorkerRegistration: registration,
                                    vapidKey: "{{$firebaseNotify['vapidKey']}}"
                                })
                                    .then((token) => {
                                        $.ajax({
                                            url: "{{ route('user.save.token') }}",
                                            method: "post",
                                            data: {
                                                token: token,
                                            },
                                            success: function (res) {
                                            }
                                        });
                                        window.newApp.notificationPermission = 'granted';
                                    });
                            } else {
                                window.newApp.notificationPermission = 'denied';
                            }
                        });
                    }
                });
            }
        </script>
        <script>
            window.newApp = new Vue({
                el: "#firebase-app",
                data: {
                    user_foreground: '',
                    user_background: '',
                    notificationPermission: Notification.permission,
                    is_notification_skipped: sessionStorage.getItem('is_notification_skipped') == '1'
                },
                mounted() {
                    sessionStorage.clear();
                    this.user_foreground = "{{$firebaseNotify['user_foreground']}}";
                    this.user_background = "{{$firebaseNotify['user_background']}}";
                },
                methods: {
                    skipNotification() {
                        sessionStorage.setItem('is_notification_skipped', '1')
                        this.is_notification_skipped = true;
                    }
                }
            });

            $(document).ready(function (){

                $.ajax({
                    url: "{{route('user.get.chart.data')}}",
                    type: 'GET',
                    success: function (data) {
                        updateChart(data);
                        bidHistory(data);
                    }
                });
                function updateChart(data){
                    const xValues = data.xValues;

                    new Chart("myChart", {
                        type: "line",
                        data: {
                            labels: xValues,
                            datasets: [{
                                data: data.purchasePlan,
                                label: "Purchase Plan",
                                borderColor: "#00cec9",
                                fill: false
                            },{
                                data: data.deposit,
                                label: "Deposit",
                                borderColor: "#feba27",
                                fill: false
                            },{
                                data: data.payout,
                                label: "Payout",
                                borderColor: "#bdc3c7",
                                fill: false
                            }]
                        },
                        options: {
                            legend: {display: true}
                        }
                    });
                }

function bidHistory(data){
    const xValues = data.xValues;
    const yValues = data.bidHistory;
    const barColors = ["red", "green","blue","orange","brown","#561C24","#000000","#030637","#720455","#11009E","#7D0A0A","#B80000","#A7D397","#D6D46D","#FBECB2","#FC6736","#0C2D57","#12372A","#0072C6","#FF9500","#FF5733","#4285F4", "#0078D4", "#FF1B2D", "#006699", "#002558", "#003399", "#3E74A0", "#5EAA51","#999999"];
    new Chart("BidHistory", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                label:'Bid History',
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            legend: {display: true},
        }
    });
}

                new Chart("GetDeviceHistory", {
                    type: "doughnut",
                    data: {
                        labels: @json($userLoginsDeviceData->keys()),
                        datasets: [{
                            backgroundColor: [ "#0072C6","#FF9500","#FF5733"],
                            data: @json($userLoginsDeviceData->values())
                        }]
                    },
                    options: {
                        cutout: '70%',
                        title: {
                            display: true,
                        },
                        plugins: {
                            tooltip: {
                                hasIndicator: true,
                                mode: 'index',
                                intersect: false
                            }
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        }
                    }
                });
                new Chart("GetBrowserHistory", {
                    type: "doughnut",
                    data: {
                        labels: @json($userLoginsBrowserData->keys()),
                        datasets: [{
                            backgroundColor: [ "#0072C6","#FF9500","#FF5733","#4285F4", "#0078D4", "#FF1B2D", "#006699", "#002558", "#003399", "#3E74A0", "#5EAA51","#999999"],
                            data: @json($userLoginsBrowserData->values())
                        }]
                    },
                    options: {
                        cutout: '70%',
                        title: {
                            display: true,
                        },
                        plugins: {
                            tooltip: {
                                hasIndicator: true,
                                mode: 'index',
                                intersect: false
                            }
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        }
                    }
                });
                new Chart("GetOperatingSystemHistory", {
                    type: "doughnut",
                    data: {
                        labels: @json($userLoginsOSData->keys()),
                        datasets: [{
                            backgroundColor: [ "#0072C6","#FF9500","#FF5733","#4285F4", "#0078D4", "#FF1B2D", "#006699", "#002558", "#003399", "#3E74A0", "#5EAA51","#999999"],
                            data: @json($userLoginsOSData->values())
                        }]
                    },
                    options: {
                        cutout: '70%',
                        title: {
                            display: true,
                        },
                        plugins: {
                            tooltip: {
                                hasIndicator: true,
                                mode: 'index',
                                intersect: false
                            }
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        }
                    }
                });
            })

        </script>
    @endpush
@endif

@push('style')
   <style>
       #BidHistory{
           width:100%;
           height: 400px;
           margin-top: -18px;
       }
       #myChart{
           width:100%;
           height: 400px;
           margin-top:-18px;
       }
       #GetDeviceHistory{
          width: 60% !important;
           height: 60%!important;
           display: block;
           margin:auto;
       }

       #GetBrowserHistory{
           width: 60% !important;
           height: 60%!important;
           display: block;
           margin:auto;
       }
       #GetOperatingSystemHistory{
           width: 60% !important;
           height: 60%!important;
           display: block;
           margin:auto;
       }
       #myChart{
          display: block;
       }
       #alert{
         display: flex;
         justify-content: space-between;
         /* flex-wrap: wrap; */
         align-items: center;
      }
      #alertContent .content{
         margin-left: 25px;
      }
      #alert .crossbtn i{
         margin-right: 25px !important;
          cursor: pointer;
      }
      #alertContent{
         display: flex;
         /* height: 100px; */
         padding: 10px 20px;
         flex-wrap: wrap;
         align-items: center;

      }
      @media (max-width: 917px){

         #alertContent button{
            margin-top: 20px;
         }
      }
      @media (max-width: 877px){
         #alert{
            position: relative;
         }
         #alert .crossbtn i{
            position: absolute;
            top: 5px;
            right: 5px;
         }
      }
   </style>
@endpush

