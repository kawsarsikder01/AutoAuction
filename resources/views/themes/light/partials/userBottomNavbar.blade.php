<!-- bottom navbar -->
<div class="bottom-nav fixed-bottom d-lg-none">
    <div class="link-item">
       <button onclick="toggleSideMenu()">
          <span class="icon"><i class="fal fa-ellipsis-v-alt"></i></span>
          <span class="text">@lang('Menus')</span>
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
       <a href="{{route('user.profile')}}">
          <span class="icon"><i class="fal fa-user"></i></span>
          <span class="text">@lang('Profile')</span>
       </a>
    </div>
 </div>
     