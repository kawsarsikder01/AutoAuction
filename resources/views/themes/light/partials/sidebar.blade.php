 <!-- sidebar -->
 <div id="sidebar" class="">
    <div class="sidebar-top">
       <a class="navbar-brand" href="{{route('page')}}"> <img src="{{getFile(basicControl()->admin_logo_driver, basicControl()->admin_logo)}}" alt="" /></a>
       <button class="sidebar-toggler d-lg-none" onclick="toggleSideMenu()">
          <i class="fal fa-times"></i>
       </button>
    </div>
    <ul class="main">
       <li>
          <a class="active" href="{{route('user.dashboard')}}"><i class="fal fa-th-large"></i>@lang('Dashboard')</a>
       </li>
       <li>
          <a href="{{route('user.profile')}}"><i class="fal fa-user-edit"></i>@lang('My Profile')</a>
       </li>
       <li>
         <a href="{{route('user.sell-car.submit')}}"><i class="fa-solid fa-car-side"></i>@lang("Sell Your Vehicle")</a>
      </li>
       @if (Auth::user()->plan)
       <li>
          <a href="{{route('user.listed.vehicle')}}"><i class="fa-solid fa-list"></i>@lang("Listed Vehicle")</a>
       </li>
       @endif
       <li>
         <a href="{{route('user.bidding.history')}}"><i class="fa-regular fa-file"></i>@lang("Bid History")</a>
      </li>
      <li>
         <a href="{{route('user.messages')}}"><i class="fa-brands fa-rocketchat"></i>@lang("Messages")</a>
      </li>
      <li>
         <a href="{{route('user.ticket.list')}}"><i class="fa-solid fa-ticket"></i>@lang("Support Ticket")</a>
      </li>
       <li>
         <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form1').submit();"> <i class="fal fa-sign-out-alt"></i>@lang('Sign Out') </a>
       </li>

    </ul>
 </div>
 <form id="logout-form1" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
         </form>