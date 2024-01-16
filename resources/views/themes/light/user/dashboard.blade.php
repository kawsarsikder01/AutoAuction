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
                      <div class="col-md-3 col-4 col-sm-3">
                         <div class="link-item">
                            <a href="">
                               <i class="fal fa-project-diagram"></i>
                               <span>Invest</span>
                            </a>
                         </div>
                      </div>
                      <div class="col-md-3 col-4 col-sm-3">
                         <div class="link-item">
                            <a href="">
                               <i class="fal fa-chart-bar"></i>
                               <span>Deposit</span>
                            </a>
                         </div>
                      </div>
                      <div class="col-md-3 col-4 col-sm-3">
                         <div class="link-item">
                            <a href="">
                               <i class="fal fa-chart-pie-alt"></i>
                               <span>Withdraw</span>
                            </a>
                         </div>
                      </div>
                      <div class="col-md-3 col-4 col-sm-3">
                         <div class="link-item">
                            <a href="">
                               <i class="fal fa-sack-dollar"></i>
                               <span>Transfer</span>
                            </a>
                         </div>
                      </div>
                      <div class="col-md-3 col-4 col-sm-3">
                         <div class="link-item">
                            <a href="">
                               <i class="fal fa-user-cog"></i>
                               <span>Settings</span>
                            </a>
                         </div>
                      </div>
                      <div class="col-md-3 col-4 col-sm-3">
                         <div class="link-item">
                            <a href="">
                               <i class="fal fa-user-headset"></i>
                               <span>Support</span>
                            </a>
                         </div>
                      </div>
                      <div class="col-md-3 col-4 col-sm-3">
                         <div class="link-item">
                            <a href="">
                               <i class="fal fa-badge-check"></i>
                               <span>2fa</span>
                            </a>
                         </div>
                      </div>
                      <div class="col-md-3 col-4 col-sm-3">
                         <div class="link-item">
                            <a href="">
                               <i class="fal fa-ellipsis-h-alt"></i>
                               <span>More</span>
                            </a>
                         </div>
                      </div>
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
                            <h4>{{$averageSell? number_format($averageSell, 2, '.', ','):0}} {{" ".basicControl()->currency_symbol}}</h4>
                            <i class="fa-light fa-chart-mixed"></i>
                         </div>
                         <p class="mb-0">Avg. selling price</p>
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
                         <h4>$0</h4>
                         <i class="fa-light fa-chart-pie-simple"></i>
                      </div>
                      <p class="mb-0">Orders completed</p>
                   </div>
                   <div class="card-box">
                      <div class="d-flex justify-content-between">
                         <h4>$0</h4>
                         <i class="fa-light fa-file-chart-pie"></i>
                      </div>
                      <p class="mb-0">Earned in February</p>
                   </div>
                   <div class="card-box">
                      <div class="d-flex justify-content-between">
                         <h4>$0</h4>
                         <i class="fa-light fa-chart-network"></i>
                      </div>
                      <p class="mb-0">Earnings to date</p>
                   </div>
                   <div class="card-box">
                      <div class="d-flex justify-content-between">
                         <h4>$0</h4>
                         <i class="fa-light fa-chart-mixed"></i>
                      </div>
                      <p class="mb-0">Avg. selling price</p>
                   </div>
                   <div class="card-box">
                      <div class="d-flex justify-content-between">
                         <h4>$0</h4>
                         <i class="fa-light fa-chart-pie-simple"></i>
                      </div>
                      <p class="mb-0">Orders completed</p>
                   </div>
                   <div class="card-box">
                      <div class="d-flex justify-content-between">
                         <h4>$0</h4>
                         <i class="fa-light fa-file-chart-pie"></i>
                      </div>
                      <p class="mb-0">Earned in February</p>
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

          <!-- table -->
          <div class="table-parent table-responsive mt-4">
             <div class="table-search-bar">
                <div class="d-none d-lg-block">
                   <form>
                      <div class="row g-3 align-items-end">
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <input type="text" class="form-control" placeholder="Search" />
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="propertyType">
                               <option value="type1">Category</option>
                               <option value="type2">England</option>
                               <option value="type3">Pakistan</option>
                               <option value="type4">Palestine</option>
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="propertyType">
                               <option value="type1">Category</option>
                               <option value="type2">England</option>
                               <option value="type3">Pakistan</option>
                               <option value="type4">Palestine</option>
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="propertyType">
                               <option value="type1">Category</option>
                               <option value="type2">England</option>
                               <option value="type3">Pakistan</option>
                               <option value="type4">Palestine</option>
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <select class="js-example-basic-single form-control" name="propertyType">
                               <option value="type1">Category</option>
                               <option value="type2">England</option>
                               <option value="type3">Pakistan</option>
                               <option value="type4">Palestine</option>
                            </select>
                         </div>
                         <div class="input-box col-lg-3 col-md-6 col-xl-2">
                            <button class="btn-custom w-100"><i class="fal fa-search"></i> Filter</button>
                         </div>
                      </div>
                   </form>
                </div>
                <div class="d-lg-none justify-content-end">
                   <button
                      type="button"
                      class="btn-action"
                      data-bs-toggle="modal"
                      data-bs-target="#editModal"
                   >
                      Filter <i class="fa-light fa-filter"></i>
                   </button>
                </div>
             </div>
             <table class="table table-striped">
                <thead>
                   <tr>
                      <th scope="col">SL No.</th>
                      <th scope="col">Name</th>
                      <th scope="col">Phone</th>
                      <th scope="col">Email</th>
                      <th scope="col">Status</th>
                      <th scope="col">Action</th>
                   </tr>
                </thead>
                <tbody>
                   <tr>
                      <td data-label="SL No.">1</td>
                      <td data-label="Name">
                         <span class="currency">
                            <img src="" alt="..." />
                            Amanda Harvey
                         </span>
                      </td>
                      <td data-label="Phone">09165222122</td>
                      <td data-label="Email">iamsly52@gmail.com</td>
                      <td data-label="Status">
                         <span class="badge bg-primary">Primary</span>
                      </td>
                      <td data-label="Action">
                         <div>
                            <button
                               class="btn-action-icon bg-success"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#formModal"
                            >
                               <i class="fal fa-edit"></i>
                            </button>
                            <button
                               class="btn-action-icon bg-info"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#formModal"
                            >
                               <i class="fal fa-info-circle"></i>
                            </button>
                         </div>
                      </td>
                   </tr>
                   <tr>
                      <td data-label="SL No.">2</td>
                      <td data-label="Name">
                         <span class="currency">
                            <img src="" alt="..." />
                            Amanda Harvey
                         </span>
                      </td>
                      <td data-label="Phone">09165222122</td>
                      <td data-label="Email">iamsly52@gmail.com</td>
                      <td data-label="Status">
                         <span class="badge bg-secondary">Secondary</span>
                      </td>
                      <td data-label="Action">
                         <div>
                            <button
                               class="btn-action-icon bg-danger"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#formModal"
                            >
                               <i class="fal fa-edit"></i>
                            </button>
                            <button
                               class="btn-action-icon bg-warning"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#formModal"
                            >
                               <i class="fal fa-info-circle"></i>
                            </button>
                         </div>
                      </td>
                   </tr>
                   <tr>
                      <td data-label="SL No.">3</td>
                      <td data-label="Name">
                         <span class="currency">
                            <img src="" alt="..." />
                            Amanda Harvey
                         </span>
                      </td>
                      <td data-label="Phone">09165222122</td>
                      <td data-label="Email">iamsly52@gmail.com</td>
                      <td data-label="Status">
                         <span class="badge bg-success">Success</span>
                      </td>
                      <td data-label="Action">
                         <div>
                            <button
                               class="btn-action-icon"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#formModal"
                            >
                               <i class="fal fa-edit"></i>
                            </button>
                            <button
                               class="btn-action-icon"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#formModal"
                            >
                               <i class="fal fa-info-circle"></i>
                            </button>
                         </div>
                      </td>
                   </tr>
                   <tr>
                      <td data-label="SL No.">4</td>
                      <td data-label="Name">
                         <span class="currency">
                            <img src="" alt="..." />
                            Amanda Harvey
                         </span>
                      </td>
                      <td data-label="Phone">09165222122</td>
                      <td data-label="Email">iamsly52@gmail.com</td>
                      <td data-label="Status">
                         <span class="badge bg-danger">Danger</span>
                      </td>
                      <td data-label="Action">
                         <div>
                            <button
                               class="btn-action-icon"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#formModal"
                            >
                               <i class="fal fa-edit"></i>
                            </button>
                            <button
                               class="btn-action-icon"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#formModal"
                            >
                               <i class="fal fa-info-circle"></i>
                            </button>
                         </div>
                      </td>
                   </tr>
                   <tr>
                      <td data-label="SL No.">5</td>
                      <td data-label="Name">
                         <span class="currency">
                            <img src="" alt="..." />
                            Amanda Harvey
                         </span>
                      </td>
                      <td data-label="Phone">09165222122</td>
                      <td data-label="Email">iamsly52@gmail.com</td>
                      <td data-label="Status">
                         <span class="badge bg-warning">warning</span>
                      </td>
                      <td data-label="Action">
                         <div>
                            <button
                               class="btn-action-icon bg-danger"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#formModal"
                            >
                               <i class="fal fa-edit"></i>
                            </button>
                            <div class="sidebar-dropdown-items">
                               <button
                                  type="button"
                                  class="dropdown-toggle"
                                  data-bs-toggle="dropdown"
                                  aria-expanded="false"
                               >
                                  <i class="fal fa-cog"></i>
                               </button>
                               <ul class="dropdown-menu dropdown-menu-end">
                                  <li>
                                     <a href="" class="dropdown-item">
                                        <i class="fal fa-edit"></i> Edit
                                     </a>
                                  </li>
                                  <li>
                                     <button
                                        class="dropdown-item"
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#formModal"
                                     >
                                        <i class="fal fa-envelope"></i> Send Mail
                                     </button>
                                  </li>
                               </ul>
                            </div>
                         </div>
                      </td>
                   </tr>
                   <tr>
                      <td data-label="SL No.">6</td>
                      <td data-label="Name">
                         <span class="currency">
                            <img src="" alt="..." />
                            Amanda Harvey
                         </span>
                      </td>
                      <td data-label="Phone">09165222122</td>
                      <td data-label="Email">iamsly52@gmail.com</td>
                      <td data-label="Status">
                         <span class="badge bg-primary">Primary</span>
                      </td>
                      <td data-label="Action">
                         <div>
                            <button
                               class="btn-action-icon bg-success"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#formModal"
                            >
                               <i class="fal fa-edit"></i>
                            </button>
                            <button
                               class="btn-action-icon bg-info"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#formModal"
                            >
                               <i class="fal fa-info-circle"></i>
                            </button>
                         </div>
                      </td>
                   </tr>
                   <tr>
                      <td data-label="SL No.">7</td>
                      <td data-label="Name">
                         <span class="currency">
                            <img src="" alt="..." />
                            Amanda Harvey
                         </span>
                      </td>
                      <td data-label="Phone">09165222122</td>
                      <td data-label="Email">iamsly52@gmail.com</td>
                      <td data-label="Status">
                         <span class="badge bg-secondary">Secondary</span>
                      </td>
                      <td data-label="Action">
                         <div>
                            <button
                               class="btn-action-icon bg-danger"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#formModal"
                            >
                               <i class="fal fa-edit"></i>
                            </button>
                            <button
                               class="btn-action-icon bg-warning"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#formModal"
                            >
                               <i class="fal fa-info-circle"></i>
                            </button>
                         </div>
                      </td>
                   </tr>
                   <tr>
                      <td data-label="SL No.">8</td>
                      <td data-label="Name">
                         <span class="currency">
                            <img src="" alt="..." />
                            Amanda Harvey
                         </span>
                      </td>
                      <td data-label="Phone">09165222122</td>
                      <td data-label="Email">iamsly52@gmail.com</td>
                      <td data-label="Status">
                         <span class="badge bg-success">Success</span>
                      </td>
                      <td data-label="Action">
                         <div>
                            <button
                               class="btn-action-icon"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#formModal"
                            >
                               <i class="fal fa-edit"></i>
                            </button>
                            <button
                               class="btn-action-icon"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#formModal"
                            >
                               <i class="fal fa-info-circle"></i>
                            </button>
                         </div>
                      </td>
                   </tr>
                   <tr>
                      <td data-label="SL No.">9</td>
                      <td data-label="Name">
                         <span class="currency">
                            <img src="" alt="..." />
                            Amanda Harvey
                         </span>
                      </td>
                      <td data-label="Phone">09165222122</td>
                      <td data-label="Email">iamsly52@gmail.com</td>
                      <td data-label="Status">
                         <span class="badge bg-danger">Danger</span>
                      </td>
                      <td data-label="Action">
                         <div>
                            <button
                               class="btn-action-icon"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#formModal"
                            >
                               <i class="fal fa-edit"></i>
                            </button>
                            <button
                               class="btn-action-icon"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#formModal"
                            >
                               <i class="fal fa-info-circle"></i>
                            </button>
                         </div>
                      </td>
                   </tr>
                   <tr>
                      <td data-label="SL No.">10</td>
                      <td data-label="Name">
                         <span class="currency">
                            <img src="" alt="..." />
                            Amanda Harvey
                         </span>
                      </td>
                      <td data-label="Phone">09165222122</td>
                      <td data-label="Email">iamsly52@gmail.com</td>
                      <td data-label="Status">
                         <span class="badge bg-warning">warning</span>
                      </td>
                      <td data-label="Action">
                         <div>
                            <button
                               class="btn-action-icon bg-danger"
                               type="button"
                               data-bs-toggle="modal"
                               data-bs-target="#formModal"
                            >
                               <i class="fal fa-edit"></i>
                            </button>
                            <div class="sidebar-dropdown-items">
                               <button
                                  type="button"
                                  class="dropdown-toggle"
                                  data-bs-toggle="dropdown"
                                  aria-expanded="false"
                               >
                                  <i class="fal fa-cog"></i>
                               </button>
                               <ul class="dropdown-menu dropdown-menu-end">
                                  <li>
                                     <a href="" class="dropdown-item">
                                        <i class="fal fa-edit"></i> Edit
                                     </a>
                                  </li>
                                  <li>
                                     <button
                                        class="dropdown-item"
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#formModal"
                                     >
                                        <i class="fal fa-envelope"></i> Send Mail
                                     </button>
                                  </li>
                               </ul>
                            </div>
                         </div>
                      </td>
                   </tr>
                </tbody>
             </table>

             <!-- pagination -->
             <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end mt-4">
                   <li class="page-item disabled">
                      <a class="page-link"> Prev </a>
                   </li>
                   <li class="page-item active">
                      <a class="page-link" href="#">1</a>
                   </li>
                   <li class="page-item">
                      <a class="page-link" href="#">2</a>
                   </li>
                   <li class="page-item">
                      <a class="page-link" href="#">3</a>
                   </li>
                   <li class="page-item">
                      <a class="page-link" href="#"> Next </a>
                   </li>
                </ul>
             </nav>
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

