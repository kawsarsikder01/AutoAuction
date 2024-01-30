 <!-- navbar -->
 <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
       <a class="navbar-brand" href="{{route('page','/')}}"> <img src="{{getFile(basicControl()->logo_driver, basicControl()->logo)}}" alt="" /></a>
       <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
              {!! renderHeaderMenu(getHeaderMenuData()) !!}
             <li class="nav-item">
               @if (Auth::user())
                  <a class="nav-link" href="{{ route("user.dashboard") }}">@lang('Dashboard')</a>
               @endif
             </li>
          </ul>
       </div>

       <!-- navbar text -->
       <div class="navbar-text">
          <button class="search-btn" type="button" data-bs-toggle="modal" data-bs-target="#homeSearchModal">
             @lang('Search')
          </button>
       </div>
    </div>
 </nav>
