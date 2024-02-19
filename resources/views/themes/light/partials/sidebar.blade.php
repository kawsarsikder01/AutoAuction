<!-- sidebar -->
<div id="sidebar" class="">
    <div class="sidebar-top">
        <a class="navbar-brand" href="{{route('page')}}"> <img
                src="{{getFile(basicControl()->admin_logo_driver, basicControl()->admin_logo)}}" alt=""/></a>
        <button class="sidebar-toggler d-lg-none" onclick="toggleSideMenu()">
            <i class="fal fa-times"></i>
        </button>
    </div>
    <ul class="main">
        <li>
            <a class="{{ isMenuActive('user.dashboard') }}" href="{{route('user.dashboard')}}"><i
                    class="fal fa-th-large"></i>@lang('Dashboard')</a>
        </li>
        <li>
            <a class="{{ isMenuActive('user.show.listing.form') }}" href="{{route('user.show.listing.form')}}"><i
                    class="fa-solid fa-car-side"></i>@lang("Sell Your Vehicle")</a>
        </li>
        @if (Auth::user()->plan)
            <li>
                <a class="{{ isMenuActive('user.listed.vehicle') }}" href="{{route('user.listed.vehicle')}}"><i
                        class="fa-solid fa-list"></i>@lang("Listed Vehicle")</a>
            </li>
            <li>
                <a class="{{ isMenuActive('user.purchase.history') }}" href="{{route('user.purchase.history')}}"><i
                        class="fa-solid fa-clock-rotate-left"></i>@lang("Purchase History")</a>
            </li>
        @endif
        <li>
            <a class="{{ isMenuActive('user.bidding.history') }}" href="{{route('user.bidding.history')}}"><i
                    class="fa-regular fa-file"></i>@lang("Bid History")</a>
        </li>
        <li>
            <a class="{{ isMenuActive('user.reports.conversation') }}" href="{{route('user.reports.conversation')}}"><i
                    class="fal fa-flag-alt"></i>@lang("Reports")</a>
        </li>

        <li>
            <a
                class="dropdown-toggle {{ menuActive(['user.add.fund', 'user.fund.index'], 2) }}"
                data-bs-toggle="collapse"
                href="#dropdownCollapsible"
                role="button"
                aria-expanded="false"
                aria-controls="collapseExample">
                <i class="fal fa-wallet"></i> @lang('Fund')
            </a>
            <div class="collapse dropdown-collapsible {{ menuActive(['user.add.fund', 'user.fund.index'], 2) }}" id="dropdownCollapsible">
                <ul>
                    <li>

                        <a class="{{ isMenuActive('user.add.fund') }}" href="{{ route('user.add.fund') }}"><i
                                class="fal fa-th-large"></i>@lang('Add Fund')</a>
                    </li>
                    <li>

                        <a class="{{ isMenuActive("user.fund.index") }}" href="{{ route('user.fund.index') }}"><i
                                class="fal fa-th-large"></i>@lang('List')</a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <a class="dropdown-toggle {{ menuActive(['user.payout', 'user.payout.index'], 2) }}"
               data-bs-toggle="collapse"
               href="#dropdownCollapsible2"
               role="button"
               aria-expanded="false"
               aria-controls="collapseExample">
                <i class="fa-light fa-money-bill-wave"></i> @lang('Payout')
            </a>
            <div class="collapse dropdown-collapsible {{ menuActive(['user.payout', 'user.payout.index'], 2) }}" id="dropdownCollapsible2">
                <ul class="">
                    <li>
                        <a class="{{ isMenuActive('user.payout') }}" href="{{ route('user.payout') }}"><i
                                class="fal fa-th-large"></i>@lang('Payout')</a>
                    </li>
                    <li>
                        <a class="{{ isMenuActive('user.payout.index') }}" href="{{ route("user.payout.index") }}"><i
                                class="fal fa-th-large"></i>@lang('List')</a>
                    </li>
                </ul>
            </div>
        </li>
        <li>
            <a class="{{ isMenuActive('user.ticket.list') }}" href="{{route('user.ticket.list')}}"><i
                    class="fa-regular fa-paper-plane"></i>@lang("Support Ticket")</a>
        </li>
        <li>
            <a class="{{ isMenuActive('user.twostep.security') }}" href="{{route('user.twostep.security')}}"><i
                    class="fal fa-lock"></i>@lang("2FA Security")</a>
        </li>
        <li>
            <a class="{{ isMenuActive('user.notification.permission') }}" href="{{route('user.notification.permission')}}"><i class="fa-regular fa-bell"></i>@lang("Notification Permission")</a>
        </li>
        <li>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form1').submit();"> <i
                    class="fal fa-sign-out-alt"></i>@lang('Sign Out') </a>
        </li>

    </ul>
</div>
<form id="logout-form1" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
