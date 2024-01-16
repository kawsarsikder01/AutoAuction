<!-- footer section -->
<footer class="footer-section">
    <div class="overlay">
       <div class="container">
          <div class="row gy-5 gy-lg-0">
             <div class="col-lg-3 col-md-6">
{{--                 @if($footer)@dd($footer) @endif--}}
                <div class="footer-box">
                   @if ($footer['single']['media'])
                   <a class="navbar-brand" href="{{route('page')}}"> <img src="{{getFile($footer['single']['media']->logo->driver,$footer['single']['media']->logo->path)}}" alt="" /></a>
                   @endif
                   <p class="company-bio">
                    @if ($footer['single'])
                       {{$footer['single']['text']}}
                    @endif
                   </p>
                   <h4 class="mb-3">Social Media</h4>
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
                      <h4>WANT TO CALL WITH US?</h4>
                      <div class="info-box">
                         <div class="icon"><i class="fa-thin fa-envelope"></i></div>
                         <div class="text">
                            <h4>Email</h4>
                            <p>{{$footer['single']['email']}}</p>
                         </div>
                      </div>
                   </div>
                   <div class="col-md-4">
                      <h4>WANT TO CALL WITH US?</h4>
                      <div class="info-box">
                         <div class="icon"><i class="fa-thin fa-phone"></i></div>
                         <div class="text">
                            <h4>Phone</h4>
                            <p>{{$footer['single']['phone_no']}}</p>
                         </div>
                      </div>
                   </div>
                   <div class="col-md-4">
                      <h4>WANT TO CALL WITH US?</h4>
                      <div class="info-box">
                         <div class="icon"><i class="fa-thin fa-location-dot"></i></div>
                         <div class="text">
                            <h4>Location</h4>
                            <p>{{$footer['single']['address']}}</p>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="row">
                   <div class="col-md-4">
                      <div class="footer-box">
                         <h4>Useful Links</h4>
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
                         <h4>support link</h4>
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
                <span> All rights reserved © 2022 by<a href="{{route('page')}}">Bug Finder</a> </span>
             </div>
             <div class="language-dropdown-items">
                <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                   <img
                      src="https://cdn.britannica.com/33/4833-004-828A9A84/Flag-United-States-of-America.jpg"
                      alt=""
                   />
                   <span>English</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-start">
                   <li>
                      <a href="" class="dropdown-item">
                         <img
                            src="https://cdn.britannica.com/46/3346-004-D3BDE016/flag-symbolism-Pakistan-design-Islamic.jpg"
                            alt=""
                            class="img-fluid"
                         />
                         <span>Urdu</span>
                      </a>
                   </li>
                   <li>
                      <a href="" class="dropdown-item">
                         <img src="https://flagcolor.com/wp-content/uploads/2018/11/spain_flag.png" alt="" />
                         <span>Spanish</span>
                      </a>
                   </li>
                   <li>
                      <a href="" class="dropdown-item">
                         <img src="https://www.state.gov/wp-content/uploads/2018/08/bg-lgflag.gif" alt="" />
                         <span>Bangla</span>
                      </a>
                   </li>
                </ul>
             </div>
          </div>
       </div>
    </div>
 </footer>
