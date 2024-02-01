<!-- footer section -->
<footer class="footer-section">
    <div class="overlay">
       <div class="container">
          <div class="row gy-5 gy-lg-0">
             <div class="col-lg-3 col-md-6">
                <div class="footer-box">
                   @if ($footer['single'] && $footer['single']['media'])
                   <a class="navbar-brand" href="{{route('page')}}"> <img src="{{getFile($footer['single']['media']->logo->driver,$footer['single']['media']->logo->path)}}" alt="" /></a>
                   @endif
                   <p class="company-bio">
                    @if ($footer['single'])
                       {{$footer['single']['text']}}
                    @endif
                   </p>
                   <h4 class="mb-3"> @lang('SOCIAL MEDIA') </h4>
                   <div class="social-links">
                   @if ($footer['multiple'])
                        @foreach (collect($footer['multiple'])->toArray() as $item)
                            <a href="{{$item['url']}}" class="facebook">
                                <i class="{{$item['media']->icon}}"></i>
                            </a>
                        @endforeach
                   @endif
                   </div>
                </div>
             </div>
             <div class="col-lg-9">
                <div class="row contact-info-wrapper">
                   <div class="col-md-4">
                      <h4>@lang('WANT TO EMAIL WITH US?')</h4>
                      <div class="info-box">
                         <div class="icon"><i class="fa-thin fa-envelope"></i></div>
                         <div class="text">
                            <h4>@lang('Email')</h4>
                            <p>{{$footer['single']['email']?? ''}}</p>
                         </div>
                      </div>
                   </div>
                   <div class="col-md-4">
                      <h4>@lang('WANT TO CALL WITH US?')</h4>
                      <div class="info-box">
                         <div class="icon"><i class="fa-thin fa-phone"></i></div>
                         <div class="text">
                            <h4>@lang('Phone')</h4>
                            <p>{{$footer['single']['phone_no']??''}}</p>
                         </div>
                      </div>
                   </div>
                   <div class="col-md-4">
                      <h4>@lang('WANT TO KNOW ADDRESS?')</h4>
                      <div class="info-box">
                         <div class="icon"><i class="fa-thin fa-location-dot"></i></div>
                         <div class="text">
                            <h4>@lang('Location')</h4>
                            <p>{{$footer['single']['address']??''}}</p>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="row">
                   <div class="col-md-4">
                      <div class="footer-box">
                         <h4>@lang('Useful Links')</h4>
                         <ul>
                             @if(getFooterMenuData('useful_link') != null)
                                 @foreach(getFooterMenuData('useful_link') as $list)
                                     {!! $list !!}
                                 @endforeach
                             @endif
                         </ul>
                      </div>
                   </div>
                   <div class="col-md-4">
                      <div class="footer-box">
                         <h4>@lang('support link')</h4>
                         <ul>
                             @if(getFooterMenuData('support_link') != null)
                                 @foreach(getFooterMenuData('support_link') as $list)
                                     {!! $list !!}
                                 @endforeach
                             @endif
                         </ul>
                      </div>
                   </div>
                </div>
             </div>
          </div>
          <div class="d-flex copyright justify-content-between align-items-center">
             <div>
                <span> @lang('All rights reserved © 2022 by')<a href="{{route('page')}}"> {{basicControl()->site_title}} </a> </span>
             </div>
             <div class="language-dropdown-items">
                 @foreach($languages as $language)
                     <a href="{{route('language',$language->short_name)}}" class="{{session('lang')==$language->short_name?'text-decoration-underline':''}}">{{$language->name}}</a>
                 @endforeach
             </div>
          </div>
       </div>
    </div>
 </footer>
