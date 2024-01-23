@extends($theme.'layouts.user')
@section('title',trans('Dashboard'))
@section('content')
<div class="container-fluid content" style="">
    <div class="main row">
       <div class="col-12">
          <div class="row g-4">
             <div class="col-12">
                <div class="card-box p-0">
                   <div class="row align-items-end">
                      <div class="col-lg-8">
                         <div class="p-4">
                            <h4 class="text-primary">Welcome Trista Francis! 🎉</h4>
                            <p>
                               You have done 72% more sales today. Check your new badge in your profile.
                            </p>
                            <a href="influencer-create-listing.html" class="btn-custom">Create Listing</a>
                         </div>
                      </div>
                      <div class="col-lg-4 text-center text-sm-left d-none d-lg-block">
                         <div class="text-right">
                            <img
                               src="{{asset($themeTrue.('img/img/bugatti.png'))}}"
                               height="140"
                               alt="View Badge User"
                               data-app-dark-img=""
                               data-app-light-img=""
                            />
                         </div>
                      </div>
                   </div>
                </div>
             </div>

             <!-- quick links -->
             <div class="col-12 d-lg-none">
                <div class="quick-links">
                   <div class="row g-2 g-lg-4">
{{--                      <div class="col-md-3 col-4 col-sm-3">--}}
{{--                         <div class="link-item">--}}
{{--                            <a href="">--}}
{{--                               <i class="fal fa-project-diagram"></i>--}}
{{--                               <span>Invest</span>--}}
{{--                            </a>--}}
{{--                         </div>--}}
{{--                      </div>--}}
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
{{--                      <div class="col-md-3 col-4 col-sm-3">--}}
{{--                         <div class="link-item">--}}
{{--                            <a href="">--}}
{{--                               <i class="fal fa-sack-dollar"></i>--}}
{{--                               <span>Transfer</span>--}}
{{--                            </a>--}}
{{--                         </div>--}}
{{--                      </div>--}}
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
{{--                      <div class="col-md-3 col-4 col-sm-3">--}}
{{--                         <div class="link-item">--}}
{{--                            <a href="">--}}
{{--                               <i class="fal fa-ellipsis-h-alt"></i>--}}
{{--                               <span>More</span>--}}
{{--                            </a>--}}
{{--                         </div>--}}
{{--                      </div>--}}
                   </div>
                </div>
             </div>

             <!-- card boxes -->
             <div class="col-12 d-none d-lg-block">
                <div class="row g-4">
                   <div class="col-xl-6 col-lg-6 col-md-12 ">
                      <div class="card-box">
                         <div class="d-flex justify-content-between">
                            <h4>{{number_format(Auth::user()->balance, 2, '.', ',')??0 }} {{" ".basicControl()->currency_symbol}}</h4>
                            <i class="fa-light fa-chart-pie-simple"></i>
                         </div>
                         <p class="mb-0">Current Balance</p>
                      </div>
                   </div>
                   <div class="col-xl-6 col-lg-6 col-md-12">
                      <div class="card-box">
                         <div class="d-flex justify-content-between">
                            <h4>{{number_format(Auth::user()->hold_balance, 2, '.', ',')?? 0}} {{" ".basicControl()->currency_symbol}}</h4>
                            <i class="fa-light fa-file-chart-pie"></i>
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
                            <i class="fa-light fa-chart-mixed"></i>
                         </div>
                         <p class="mb-0">Total Canceled Auction</p>
                      </div>
                   </div>
                   <div class="col-xl-3 col-lg-4 col-md-12">
                      <div class="card-box">
                         <div class="d-flex justify-content-between">
                            <h4>{{count($soldedVehicle)}}</h4>
                            <i class="fa-light fa-chart-pie-simple"></i>
                         </div>
                         <p class="mb-0">Total Sold Vehicle</p>
                      </div>
                   </div>
                   <div class="col-xl-3 col-lg-4 col-md-12">
                      <div class="card-box">
                         <div class="d-flex justify-content-between">
                            <h4>{{count($totalWinAuction)}}</h4>
                            <i class="fa-light fa-file-chart-pie"></i>
                         </div>
                         <p class="mb-0">Total Win Auction</p>
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
                <div class="card-box refferal-box">
                   <h5>Your refferal link</h5>
                   <div class="input-group">
                      <input
                         type="text"
                         class="form-control"
                         value="https://www.upwork.com/jobs/~01737b2cff792fde61"
                         id="jobLink"
                         disabled=""
                      />
                      <button id="copyBtn" onclick="copyText('jobLink')" class="btn text-white">
                         Copy Link
                      </button>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>

@endsection

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
        </script>
    @endpush
@endif

