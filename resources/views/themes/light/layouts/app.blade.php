<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="{{getFile(basicControl()->favicon_driver,basicControl()->favicon)}}" />
    <title>@yield('title')</title>
    <!-- bootstrap 5 -->
    <link rel="stylesheet" href="{{asset($themeTrue.'css/bootstrap.min.css')}}" />
    <!-- font awesome 6 -->
    <link rel="stylesheet" href="{{asset($themeTrue.'css/all.min.css')}}" />
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
        <style>
            :root {
                --primary:  {{ basicControl()->primary_color }};
                --secondary: {{ basicControl()->secondary_color }};
            }

        </style>
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


@if (basicControl()->cookie_status)
    <div class="cookies-allert" id="cookiesAlert">
        <img src="{{getFile(basicControl()->cookie_driver,basicControl()->cookie_image)}}" class="" alt="Federation cookies">
        <h4 class="mt-2 text-center">{{basicControl()->cookie_title}}</h4>
        <span class="d-block mt-2 text-center">{{basicControl()->cookie_short_text}} <a href="{{basicControl()->cookie_button_url}}" class="seemoreButton">{{basicControl()->cookie_button_name}}</a></span>
        <a href="javascript:void(0);" class="mt-3 cookieButton justify-content-center" type="button" onclick="acceptCookiePolicy()">Accept</a>
        <a href="javascript:void(0);" class="mt-2 cookieClose text-center" type="button" onclick="closeCookieBanner()">Close</a>
    </div>
@endif


@include($theme.'partials.jsLink')
@stack('js-lib')
@stack('script')




@if (session()->has('error'))
    <script>
        Notiflix.Notify.failure("@lang(session('error'))");
    </script>
@endif
@if (session()->has('success'))
    <script>
        Notiflix.Notify.success("@lang(session('success'))");
    </script>
@endif

@if (session()->has('warning'))
    <script>
        Notiflix.Notify.warning("@lang(session('warning'))");
    </script>
@endif

@if (basicControl()->cookie_status )
    <script>
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + value + expires + "; path=/";
    }

    // Function to check if the user has accepted the cookie policy
    function hasAcceptedCookiePolicy() {
        return document.cookie.indexOf("accept_cookie_policy=true") !== -1;
    }

    // Function to handle the user accepting the cookie policy
    function acceptCookiePolicy() {
        setCookie("accept_cookie_policy", true, 365);
        document.getElementById("cookiesAlert").style.display = "none";
    }

    // Function to handle the user closing the cookie banner without accepting
    function closeCookieBanner() {
        document.getElementById("cookiesAlert").style.display = "none";
    }

    // Display the cookie banner if the user has not accepted the policy
    if (!hasAcceptedCookiePolicy()) {
        document.getElementById("cookiesAlert").style.display = "block";
    }
</script>
@endif

<script>
    'use strict';

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







