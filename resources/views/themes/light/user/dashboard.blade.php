@extends($theme.'layouts.user')
@section('title',trans('Dashboard'))
@section('content')
<div class="container-fluid content" id="firebase-app">
    <div class="main row">
       <div class="col-12">
          <div class="row g-4">
            <div class="col-12">
                <div class="card-box p-0 m-0" v-if="user_foreground == '1' || user_background == '1'">
                    <div v-if="notificationPermission == 'default' && !is_notification_skipped" v-cloak>
                        <div class="d-flex align-items-center justify-content-between alert content alert-warn">
                            <div class="d-flex flex-wrap align-items-center justify-content-center alert-content">
                                <i class="fa-solid fa-circle-info me-3"></i>
                                <p class="me-3 mt-3">
                                    @lang('Do not miss any single important notification! Allow your browser to get instant push notification')
                                </p>
                                <button class="btn-custom" id="allow-notification">@lang('Allow me')</button>
                            </div>
                            <button class="close-btn me-3"  @click.prevent="skipNotification"><i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-box" v-if="notificationPermission == 'denied' && !is_notification_skipped" v-cloak>
                    <div class="media align-items-center d-flex justify-content-between alert alert-warn mb-4">
                        <div><i
                                class="fas fa-exclamation-triangle"></i> @lang('Please allow your browser to get instant push notification.Allow it from notification setting.')
                        </div>
                        <button class="close-btn pt-1" @click.prevent="skipNotification"><i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
              @if(($kycForm['not_submitedForm'] || $kycForm['is_pending']) || $kycForm['rejected'] )
                  <div class="col-12">
                      <div class="card-box p-0 kycAlert" id="alert">
                          <div class="alertContent " id="alertContent">
                              <div class="icon content"><i class="fa-solid fa-circle-info me-3"></i></div>
                              <div class="text content">
                                    @if($kycForm['not_submitedForm'])
                                        @lang('You are not submitted')
                                        @foreach($kycForm['not_submitedForm'] as $key => $item)
                                            {{$key == 0 ? $item :', '.$item}}
                                        @endforeach
                                        .
                                  @endif
                                    @if($kycForm['is_pending'])
                                      @lang('Your')
                                      @foreach($kycForm['is_pending'] as $key => $item)
                                          {{$key == 0 ? $item :','.$item}}
                                      @endforeach
                                        @lang($kycForm['rejected']?'is Pending and':'is Pending.')
                                      @endif
                                    @if($kycForm['rejected'])
                                      @lang('Your')
                                      @foreach($kycForm['rejected'] as $key => $item)
                                          {{$key == 0 ? $item :','.$item}}
                                      @endforeach
                                      @lang('is rejected.')
                                    @endif
                              </div>
                          </div>
                          <div class="crossbtn me-2" id="hideKycAlert">
                              <i class="fa-solid fa-xmark"></i>
                          </div>
                      </div>
                  </div>
              @endif
             <!-- quick links -->
            </div>
             <div class="col-12 d-lg-none">
                <div class="quick-links">
                   <div class="row g-2 g-lg-4">
                      <div class="col-md-3 col-4 col-sm-3">
                         <div class="link-item">
                            <a href="{{route('user.add.fund')}}">
                               <i class="fal fa-chart-bar"></i>
                               <span>@lang('Deposit')</span>
                            </a>
                         </div>
                      </div>
                      <div class="col-md-3 col-4 col-sm-3">
                         <div class="link-item">
                            <a href="{{route('user.payout')}}">
                               <i class="fal fa-chart-pie-alt"></i>
                               <span>@lang('Withdraw')</span>
                            </a>
                         </div>
                      </div>
                      <div class="col-md-3 col-4 col-sm-3">
                         <div class="link-item">
                            <a href="{{route('user.profile')}}">
                               <i class="fal fa-user-cog"></i>
                               <span>@lang('Settings')</span>
                            </a>
                         </div>
                      </div>
                      <div class="col-md-3 col-4 col-sm-3">
                         <div class="link-item">
                            <a href="{{route('page','contact')}}">
                               <i class="fal fa-user-headset"></i>
                               <span>@lang('Support')</span>
                            </a>
                         </div>
                      </div>
                      <div class="col-md-3 col-4 col-sm-3">
                         <div class="link-item">
                            <a href="{{route('user.twostep.security')}}">
                               <i class="fal fa-badge-check"></i>
                               <span>@lang('2fa')</span>
                            </a>
                         </div>
                      </div>
                   </div>
                </div>
             </div>

             <!-- card boxes -->
             <div class="col-12 d-none d-lg-block">
                <div class="row g-4">
                    <div class="col-xl-3 col-lg-4 col-md-12">
                        <div class="card-box">
                            <div class="d-flex justify-content-between">
                                {!! Auth::user()->plan?'<h4>'.Auth::user()->plan->plan_name.'</h4>':'<p>'.'Explore a Strategic Selling Plan for Your Vehicle – Maximize Your Selling Potential Now!'.'</p>' !!}
                                <i class="fa-solid fa-cube"></i>
                            </div>
                            <p class="mb-0"> {{Auth::user()->plan?trans('Current Plan'):''}}</p>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-12 ">
                        <div class="card-box">
                            <div class="d-flex justify-content-between">
                                <h4>{{currencyPosition(Auth::user()->balance)}}</h4>
                                <i class="fa-solid fa-wallet"></i>
                            </div>
                            <p class="mb-0">@lang('Current Balance')</p>
                        </div>
                    </div>
                   <div class="col-xl-3 col-lg-4 col-md-12">
                      <div class="card-box">
                         <div class="d-flex justify-content-between">
                            <h4>{{currencyPosition(Auth::user()->hold_balance)}}</h4>
                             <i class="fa-light fa-chart-pie-simple"></i>
                         </div>
                         <p class="mb-0">@lang('Hold Balance')</p>
                      </div>
                   </div>
                   <div class="col-xl-3 col-lg-4 col-md-12">
                      <div class="card-box">
                         <div class="d-flex justify-content-between">
                            <h4>{{$totalListedVehicle}}</h4>
                            <i class="fa-light fa-chart-network"></i>
                         </div>
                         <p class="mb-0">@lang('Total Listed Vehicle')</p>
                      </div>
                   </div>
                   <div class="col-xl-3 col-lg-4 col-md-12">
                      <div class="card-box">
                         <div class="d-flex justify-content-between">
                            <h4>{{$cancelAuction}}</h4>
                             <i class="fa-solid fa-rectangle-xmark"></i>
                         </div>
                         <p class="mb-0">@lang('Total Canceled Auction')</p>
                      </div>
                   </div>
                   <div class="col-xl-3 col-lg-4 col-md-12">
                      <div class="card-box">
                         <div class="d-flex justify-content-between">
                            <h4>{{$soldedVehicle - $cancelAuction}}</h4>
                             <i class="fa-solid fa-truck-monster"></i>
                         </div>
                         <p class="mb-0">@lang('Total Sold Vehicle')</p>
                      </div>
                   </div>
                   <div class="col-xl-3 col-lg-4 col-md-12">
                      <div class="card-box">
                         <div class="d-flex justify-content-between">
                            <h4>{{$totalWinAuction}}</h4>
                             <i class="fa-light fa-chart-mixed"></i>
                         </div>
                         <p class="mb-0">@lang('Total Win Auction')</p>
                      </div>
                   </div>

                    <div class="col-xl-3 col-lg-4 col-md-12">
                        <div class="card-box">
                            <div class="d-flex justify-content-between">
                                <h4>{{count(Auth::user()->supportTickets)}}</h4>
                                <i class="fa-regular fa-paper-plane"></i>
                            </div>
                            <p class="mb-0">@lang('Total Support Ticket')</p>
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
                      <p class="mb-0">@lang('Current Balance')</p>
                   </div>
                   <div class="card-box">
                      <div class="d-flex justify-content-between">
                         <h4>{{number_format(Auth::user()->hold_balance, 2, '.', ',')?? 0}} {{" ".basicControl()->currency_symbol}}</h4>
                         <i class="fa-light fa-file-chart-pie"></i>
                      </div>
                      <p class="mb-0">@lang('Hold Balance')</p>
                   </div>
                   <div class="card-box">
                      <div class="d-flex justify-content-between">
                         <h4>{{count(Auth::user()->vehicle)}}</h4>
                         <i class="fa-light fa-chart-network"></i>
                      </div>
                      <p class="mb-0">@lang('Total Listed Vehicle')</p>
                   </div>
                   <div class="card-box">
                      <div class="d-flex justify-content-between">
                         <h4>{{$cancelAuction}}</h4>
                         <i class="fa-light fa-chart-mixed"></i>
                      </div>
                      <p class="mb-0">@lang('Total Canceled Auction')</p>
                   </div>
                   <div class="card-box">
                      <div class="d-flex justify-content-between">
                         <h4>{{$soldedVehicle}}</h4>
                         <i class="fa-light fa-chart-pie-simple"></i>
                      </div>
                      <p class="mb-0">@lang('Total Sold Vehicle')</p>
                   </div>
                   <div class="card-box">
                      <div class="d-flex justify-content-between">
                         <h4>{{$totalWinAuction}}</h4>
                         <i class="fa-light fa-file-chart-pie"></i>
                      </div>
                      <p class="mb-0">@lang('Total Win Auction')</p>
                   </div>
                </div>
             </div>
              <div class="col-12">
                  <div class="row">
                    @include(template().'partials.Dashboard.TransactionSummary')
                    @include(template().'partials.Dashboard.bidHistory')
                      <div class="col-xl-6 col-lg-12 mt-xl-0 mt-lg-4 mt-sm-4" id="visitorCard">
                          @include(template().'partials.Dashboard.TopAuctionVisitors')
                      </div>

                      <div class="col-xl-6 col-lg-12 mt-xl-0 mt-lg-4 mt-sm-4">
                          @include(template().'partials.Dashboard.TopBidHistory')
                      </div>
                  </div>
              </div>

              <div class="col-12">
                @include(template().'partials.Dashboard.UserLoginHistory')
              </div>

          </div>
       </div>
    </div>
 </div>

@endsection
@push('js-lib')
    <script src="{{ asset('assets/admin/js/chart.min.js') }}"></script>
@endpush

@if($firebaseNotify)
    @push('script')
        <script type="module">

            import {initializeApp} from "https://www.gstatic.com/firebasejs/9.17.1/firebase-app.js";
            import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/9.17.1/firebase-messaging.js";

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



        </script>
    @endpush
@endif
@push('script')
    <script>
        $(document).ready(function (){
            $('#hideKycAlert').on('click',function (){
                $('.kycAlert').hide();
            })
        })
    </script>
@endpush

@push('style')
   <style>
       #BidHistory{
           width:100%;
           height: 400px!important;
           margin-bottom: -18px;
       }
       #Visitors{
           width:100%;
           height: 400px !important;
           margin-bottom: -18px;
       }
       #myChart{
           width:100%;
           height: 400px!important;
           margin-bottom: -18px;

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
      /*#alertContent .content{*/
      /*   margin-left: 25px;*/
      /*}*/
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
         .close-btn{
             position: absolute;
             top: 5px;
             right: 5px
         }
      }
       @media (max-width: 1213px){
           .close-btn{
               position: absolute;
               top: 5px;
               right: 5px;
           }
           #allow-notification{
               display: block;
           }
       }
   </style>
@endpush

