 <!-- navbar -->
 <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
       <a class="navbar-brand" href="{{route('page','/')}}"> <img src="{{getFile(basicControl()->logo_driver, basicControl()->logo)}}" alt="" /></a>
       <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
              {!! renderHeaderMenu(getHeaderMenuData()) !!}
             <li class="nav-item">
               @if (Auth::user())
                  <a class="nav-link" href="{{ route("user.dashboard") }}">Dashboard</a>
               @endif
             </li>
          </ul>
       </div>

       <!-- navbar text -->
       <div class="navbar-text">
          <button class="search-btn" type="button" data-bs-toggle="modal" data-bs-target="#homeSearchModal">
             Search
          </button>
          <!-- <button class="cart-btn mx-4">
             <i class="fal fa-shopping-cart"></i>
          </button> -->
          <!-- <button
             class="offcanvas-btn"
             type="button"
             data-bs-toggle="offcanvas"
             data-bs-target="#offcanvasRight"
             aria-controls="offcanvasRight"
          ></button> -->

          <!-- cart panel -->

          <!-- user panel -->
           <!-- <div class="user-panel">
             <div class="profile">
                <i class="fa-light fa-circle-user"></i>
             </div>
             <ul class="user-dropdown">
                <li>
                   <a href="user-panel.html"> <i class="fal fa-user"></i> View Profile </a>
                </li>
                <li>
                   <a href=""> <i class="fal fa-file-edit"></i> Create Listing </a>
                </li>
                <li>
                   <a href=""> <i class="fal fa-comments-alt"></i> Messages </a>
                </li>
                <li>
                   <a href=""> <i class="fal fa-comment-smile"></i> Feedback </a>
                </li>
                <li>
                   <a href=""> <i class="fal fa-clipboard-list"></i> Orders </a>
                </li>
                <li>
                   <a href=""> <i class="fal fa-wallet"></i> Wallets </a>
                </li>
                <li>
                   <a href=""> <i class="fal fa-user-cog"></i> Account Settings </a>
                </li>
                <li>
                   <a href=""> <i class="fal fa-sign-out-alt"></i> Sign Out </a>
                </li>
             </ul>
          </div>-->
       </div>
    </div>
 </nav>
