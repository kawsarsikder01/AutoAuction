
      <!-- bottom navbar -->
      <div class="bottom-nav fixed-bottom d-lg-none">
        <div class="link-item">
           <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#userSideMenu" aria-controls="userSideMenu">
              <span class="icon"><i class="fal fa-bars-staggered"></i></span>
              <span class="text">@lang('Menu')</span>
           </button>
        </div>
        <div class="link-item">
           <a href="{{route('plan')}}">
              <span class="icon"><i class="fal fa-clipboard-list"></i></span>
              <span class="text">@lang('Plan')</span>
           </a>
        </div>
        <div class="link-item active">
           <a href="{{route('page')}}">
              <span class="icon"><i class="fal fa-house"></i></span>
              <span class="text">@lang('Home')</span>
           </a>
        </div>
        <div class="link-item">
           <a href="{{route('page','contact')}}">
              <span class="icon"><i class="fal fa-headset"></i></span>
              <span class="text">@lang('Contact')</span>
           </a>
        </div>
        <div class="link-item">
           <a href="{{route('user.dashboard')}}">
              <span class="icon"><i class="fal fa-user"></i></span>
              <span class="text">@lang('Profile')</span>
           </a>
        </div>
     </div>

     <!-- offcanvas side nav -->
     <div class="offcanvas offcanvas-start offcanvas-lg user-side-menu" tabindex="-1" id="userSideMenu" aria-labelledby="userSideMenu">
        <div class="offcanvas-header">
           <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="menu-links">
                {!! renderHeaderMenu(getHeaderMenuData()) !!}
               <li class="nav-item">
                 @if (Auth::user())
                    <a class="nav-link" href="{{ route("user.dashboard") }}">@lang('Dashboard')</a>
                 @endif
               </li>
            </ul>
        </div>
     </div>
