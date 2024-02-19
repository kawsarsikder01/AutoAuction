<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="icon" type="image/x-icon" href="{{getFile(basicControl()->favicon_driver,basicControl()->favicon)}}"/>
    <title> @yield('title')</title>
    <!-- bootstrap 5 -->
    <link rel="stylesheet" href="{{asset($themeTrue.'css/bootstrap.min.css')}}"/>
    <!-- font awesome 6 -->
    <link rel="stylesheet" href="{{asset($themeTrue.'css/all.min.css')}}"/>
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{asset($themeTrue.'css/owl.carousel.min.css')}}"/>
    <link rel="stylesheet" href="{{asset($themeTrue.'css/owl.theme.default.min.css')}}"/>
    <!-- select 2 -->
    <link rel="stylesheet" href="{{asset($themeTrue.'css/select2.min.css')}}"/>
    <!-- range slider -->
    <link rel="stylesheet" href="{{asset($themeTrue.'css/range-slider.css')}}"/>
    <!-- fancybox -->
    <link rel="stylesheet" href="{{asset($themeTrue.'css/fancybox.css')}}"/>
    <!-- custom css -->
    <link rel="stylesheet" href="{{asset($themeTrue.'css/dashboard.css')}}"/>
    <link rel="stylesheet" href="{{asset($themeTrue.'css/flatpickr.min.css')}}"/>
    <link rel="stylesheet" href="{{asset($themeTrue.'css/quill.snow.min.css')}}"/>
    <link rel="stylesheet" href="{{asset($themeTrue.'css/addProduct.css')}}"/>
    <link rel="stylesheet" href="{{asset($themeTrue.'css/flatpickr.css')}}"/>
    <style>
        {{--:root {--}}
        {{--    --primary:  {{ basicControl()->primary_color }};--}}
        {{--    --secondary: {{ basicControl()->secondary_color }};--}}
        {{--}--}}

    </style>
    @stack('style')
    @stack("css-lib")


</head>
<body class="">
<!-- bottom navbar -->
@include($theme. 'partials.userBottomNavbar')

<div class="dashboard-wrapper">
    <!-- sidebar -->
    @include($theme. 'partials.sidebar')

    <!-- content -->
    <div id="content">
        <div class="overlay">
            <!-- navbar -->
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <a class="navbar-brand d-lg-none" href="index.html"> <img src="" alt=""/></a>
                    <button class="sidebar-toggler d-none d-lg-block" onclick="toggleSideMenu()">
                        <i class="fa-sharp fa-light fa-bars-staggered"></i>
                    </button>
                    <!-- navbar text -->
                    <div class="navbar-text">
                        <!-- inbox -->

                        <!-- notification panel -->
                        <div class="notification-panel" id="pushNotificationArea">
                            <button class="dropdown-toggle">
                                <i class="fal fa-bell"></i>
                                <span class="count" v-if="items.length > 0">@{{ items.length  }}</span>
                            </button>
                            <div class="notification-dropdown">
                                <ul class="dropdown-box list-unstyled">
                                    <li v-for="(item, index) in items">
                                        <a class="dropdown-item" :href="item.description.link">
                                            <i class="fal fa-bell"></i>
                                            <div class="text">
                                                <p>@{{ item.description.text }}</p>
                                                <span class="time">@{{item.formatted_date }}</span>
                                            </div>
                                        </a>
                                    </li>

                                </ul>
                                <div class="text-center p-4" v-if="items.length < 1">
                                    <img class="dataTables-image mb-3 w-50"
                                         src="{{ asset('assets/admin/img/oc-error.svg') }}"
                                         alt="Image Description">
                                    <p class="mb-0">@lang("No Notifications Found")</p>
                                </div>
                                <a class="clear-all fixed-bottom" href="javascript:void(0)" v-if="items.length > 0"
                                   @click.prevent="readAll">
                                    @lang("Clear all notifications") <i class="bi-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                        <!-- user panel -->
                        <div class="user-panel">
                          <span class="profile">
                             <img src="{{getFile(Auth::user()->image_driver,Auth::user()->image)}}" class="img-fluid"
                                  alt=""/>
                          </span>
                            <ul class="user-dropdown">
                                <li>
                                    <a href="{{route('page')}}"><i class="fa-solid fa-house"></i></i></i>@lang('Switch to Home Page')
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('user.profile')}}"> <i
                                            class="fal fa-user"></i>@lang('View Profile')</a>
                                </li>
                                <li>
                                    @auth
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fal fa-sign-out-alt"></i>@lang('Sign Out')</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                              class="d-none">
                                            @csrf
                                        </form>
                                    @endauth

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- main -->
            @yield('content')

        </div>
    </div>
</div>


<!-- bootstrap -->
<script src="{{asset($themeTrue.'js/bootstrap.bundle.min.js')}}"></script>
{{-- <!-- jquery cdn -->--}}
<script src="{{asset($themeTrue.'js/jquery-3.6.0.min.js')}}"></script>
{{-- <!-- owl carousel -->--}}
<script src="{{asset($themeTrue.'js/owl.carousel.min.js')}}"></script>
{{-- <!-- select 2 -->--}}
<script src="{{asset($themeTrue.'js/select2.min.js')}}"></script>
{{-- <!-- range slider -->--}}
<script src="{{asset($themeTrue.'js/range-slider.min.js')}}"></script>
{{-- <!-- fancy box -->--}}
<script src="{{asset($themeTrue.'js/fancybox.umd.js')}}"></script>
{{-- <!-- social js -->--}}
<script src="{{asset($themeTrue.'js/socialSharing.js')}}"></script>
<!-- custom script -->
<script src="{{asset($themeTrue.'js/script.js')}}"></script>
<script src="{{asset($themeTrue.'js/quill.min.js')}}"></script>
<script src="{{asset($themeTrue.'js/flatpickr.js')}}"></script>


<script src="{{ asset('assets/admin/js/notiflix-aio-2.7.0.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/jquery.uploadPreview.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/pusher.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/vue.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/axios.min.js') }}"></script>

@stack('js-lib')


<script>
    'use strict';
    let pushNotificationArea = new Vue({
        el: "#pushNotificationArea",
        data: {
            items: [],
        },
        beforeMount() {
            this.getNotifications();
            this.pushNewItem();
        },
        methods: {
            getNotifications() {
                let app = this;
                axios.get("{{ route('user.push.notification.show') }}")
                    .then(function (res) {
                        console.log(res)
                        app.items = res.data;
                    })
            },
            readAt(id, link) {
                let app = this;
                let url = "{{ route('user.push.notification.readAt', 0) }}";
                url = url.replace(/.$/, id);
                axios.get(url)
                    .then(function (res) {
                        if (res.status) {
                            app.getNotifications();
                            if (link !== '#') {
                                window.location.href = link
                            }
                        }
                    })
            },
            readAll() {
                let app = this;
                let url = "{{ route('user.push.notification.readAll') }}";
                axios.get(url)
                    .then(function (res) {
                        if (res.status) {
                            app.items = [];
                        }
                    })
            },
            pushNewItem() {
                let app = this;
                Pusher.logToConsole = false;
                let pusher = new Pusher("{{ env('PUSHER_APP_KEY') }}", {
                    encrypted: true,
                    cluster: "{{ env('PUSHER_APP_CLUSTER') }}"
                });
                let channel = pusher.subscribe('user-notification.' + "{{ Auth::id() }}");
                channel.bind('App\\Events\\UserNotification', function (data) {
                    app.items.unshift(data.message);
                });
                channel.bind('App\\Events\\UpdateUserNotification', function (data) {
                    app.getNotifications();
                });
            }
        }
    });

    // dashboard_toggle_sidemenu
    const toggleSideMenu = () => {
        document.getElementById("sidebar").classList.toggle("active");
        document.getElementById("content").classList.toggle("active");
    };
    const hideSidebar = () => {
        document.getElementById("formWrapper").classList.remove("active");
        document.getElementById("formWrapper2").classList.remove("active");
    };

    // tab
    const tabs = document.getElementsByClassName("tab");
    const contents = document.getElementsByClassName("content");
    for (const element of tabs) {
        const tabId = element.getAttribute("tab-id");
        const content = document.getElementById(tabId);
        element.addEventListener("click", () => {
            for (const t of tabs) {
                t.classList.remove("active");
            }
            for (const c of contents) {
                c.classList.remove("active");
            }
            element.classList.add("active");
            content.classList.add("active");
        });
    }

</script>


@stack('script')

</body>
</html>


@if (session()->has('success'))
    <script>
        Notiflix.Notify.Success("@lang(session('success'))");
    </script>
@endif

@if (session()->has('error'))
    <script>
        Notiflix.Notify.Failure("@lang(session('error'))");
    </script>
@endif

@if (session()->has('warning'))
    <script>
        Notiflix.Notify.Warning("@lang(session('warning'))");
    </script>
@endif


