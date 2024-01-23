
      <!-- bottom navbar -->
      <div class="bottom-nav fixed-bottom d-lg-none">
        <div class="link-item">
           <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#userSideMenu" aria-controls="userSideMenu">
              <span class="icon"><i class="fal fa-bars-staggered"></i></span>
              <span class="text">Menu</span>
           </button>
        </div>
        <div class="link-item">
           <a href="{{route('plan')}}">
              <span class="icon"><i class="fal fa-clipboard-list"></i></span>
              <span class="text">Plan</span>
           </a>
        </div>
        <div class="link-item active">
           <a href="{{route('page')}}">
              <span class="icon"><i class="fal fa-house"></i></span>
              <span class="text">Home</span>
           </a>
        </div>
        <div class="link-item">
           <a href="{{route('page','contact')}}">
              <span class="icon"><i class="fal fa-headset"></i></span>
              <span class="text">Contact</span>
           </a>
        </div>
        <div class="link-item">
           <a href="{{route('user.dashboard')}}">
              <span class="icon"><i class="fal fa-user"></i></span>
              <span class="text">Profile</span>
           </a>
        </div>
     </div>

     <!-- offcanvas side nav -->
     <div class="offcanvas offcanvas-start offcanvas-lg user-side-menu" tabindex="-1" id="userSideMenu" aria-labelledby="userSideMenu">
        <div class="offcanvas-header">
           <a class="navbar-brand" href="index.html"> <img src="./img/icon/logo.png" alt="" /></a>
           <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="menu-links">
                {!! renderHeaderMenu(getHeaderMenuData()) !!}
               <li class="nav-item">
                 @if (Auth::user())
                    <a class="nav-link" href="{{ route("user.dashboard") }}">Dashboard</a>
                 @endif
               </li>
            </ul>
        </div>
     </div>
