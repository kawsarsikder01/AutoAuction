
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="{{getFile(basicControl()->favicon_driver,basicControl()->favicon)}}" />
    <title>{{basicControl()->site_title}} | @yield('title')</title>
    <!-- bootstrap 5 -->
    <link rel="stylesheet" href="{{asset($themeTrue.'css/bootstrap.min.css')}}" />
    <!-- font awesome 6 -->
    <link rel="stylesheet" href="{{asset($themeTrue.'css/all.min.css')}}" />
    {{-- <link rel="stylesheet" href="{{asset('assets/themes/light/assets/fontawesome/fontawesome.min.css')}}" /> --}}
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{asset($themeTrue.'css/owl.carousel.min.css')}}" />
    <link rel="stylesheet" href="{{asset($themeTrue.'css/owl.theme.default.min.css')}}" />
    <!-- select 2 -->
    <link rel="stylesheet" href="{{asset($themeTrue.'css/select2.min.css')}}" />
    <!-- range slider -->
    <link rel="stylesheet" href="{{asset($themeTrue.'css/range-slider.css')}}" />
    <!-- fancybox -->
    <link rel="stylesheet" href="{{asset($themeTrue.'css/fancybox.css')}}" />
    <!-- custom css -->
    <link rel="stylesheet" href="{{asset($themeTrue.'css/style.css')}}" />
        @stack('style')
    </head>
<body>
@include($theme.'partials.navbar')
@if(!request()->is('/') && !request()->is('/'))
    <!-- banner section -->
    @if (isset($pageSeo) && isset($pageDetails))
    <x-banner-component :pagetitle="$pageSeo['page_title']??''" :path="$pageDetails->page->breadcrumb_status?$pageDetails->page->breadcrumb_image??'':''" :driver="$pageDetails->page->breadcrumb_image_driver??''"/>
    @endif
@endif

<!-- #main -->
<main id="main">
    @yield('content')

</main>
<!-- End #main -->
@include($theme. 'partials.bottomNavbar')
@include($theme.'partials.searchItem')
@include($theme.'partials.jsLink')

@stack('script')


</body>

</html>
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




