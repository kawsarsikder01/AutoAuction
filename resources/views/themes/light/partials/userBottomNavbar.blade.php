<!-- bottom navbar -->
<div class="bottom-nav fixed-bottom d-lg-none">
    <div class="link-item">
       <button onclick="toggleSideMenu()">
          <span class="icon"><i class="fal fa-ellipsis-v-alt"></i></span>
          <span class="text">Menus</span>
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
       <a href="{{route('user.profile')}}">
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
               <li>
                  <a class="nav-link active" href="index.html">Home</a>
               </li>
               <li>
                  <a class="nav-link" href="about.html">About us</a>
               </li>
               <li>
                  <a class="nav-link" href="plan.html">Plan</a>
               </li>
               <li>
                  <a class="nav-link" href="auction.html">Auction</a>
               </li>
               <li>
                  <a class="nav-link" href="blogs.html">Blogs</a>
               </li>
               <li>
                  <a class="nav-link" href="contact.html">Contact</a>
               </li>
               <li>
                  <a class="nav-link" href="login.html">Login</a>
               </li>
            </ul>
         </div>
      </div>
