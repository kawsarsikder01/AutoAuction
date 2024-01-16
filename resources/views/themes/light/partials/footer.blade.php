<!-- footer section -->
<footer class="footer-section">
{{--    @dd($footer)--}}
   <div class="overlay">
      <div class="container">
         <div class="row gy-5 gy-lg-0">
            <div class="col-lg-3 col-md-6">
               <div class="footer-box">
                  @foreach ($Staticfooter as $item)
                       @if ($item->type == 'single')
                        @php
                            $data =collect($item->contentDetails)->toArray();
                        @endphp
                           <a class="navbar-brand" href="{{route('page')}}"> <img src="{{$item->media? getFile($item->media->logo->driver,$item->media->logo->path):''}}" alt="" ></a>
                           <p class="company-bio">
                              {{$data['0']['description']->text??''}}
                           </p>
                       @endif

                  @endforeach
                     <h4 class="mb-3">Social Media</h4>
                     <div class="social-links">
                        @foreach ($Staticfooter as $item)
                           @if ($item->type == 'multiple')
                              @php
                                 $multipleData = collect($item->contentDetails)->toArray()
                              @endphp
                                    <a href="{{$multipleData['0']['description']->url ?? ''}}" class="facebook">
                                       <i class="{{$item->media->icon ?? ''}}"></i>
                                    </a>
                           @endif
                        @endforeach
                     </div>

               </div>
            </div>
            <div class="col-lg-9">
               <div class="row contact-info-wrapper">
                  @foreach ($Staticfooter as $item)
                  @if ($item->type == 'single')
                            @php
                                $data =collect($item->contentDetails)->toArray();
                            @endphp
                      @if($data['0']['description']->email)
                          <div class="col-md-4">
                                  <h4>WANT TO EMAIL WITH US?</h4>
                             <div class="info-box">
                                <div class="icon"><i class="fa-thin fa-envelope"></i></div>
                                <div class="text">
                                        <h4>Email</h4>
                                        <p>{{$data['0']['description']->email}}</p>
                                </div>
                             </div>
                          </div>
                      @endif
                           @if($data['0']['description']->phone_no)
                               <div class="col-md-4">
                                   <h4>WANT TO CALL WITH US?</h4>
                                   <div class="info-box">
                                       <div class="icon"><i class="fa-thin fa-phone"></i></div>
                                       <div class="text">
                                           <h4>Phone</h4>
                                           <p>{{$data['0']['description']->phone_no}}</p>
                                       </div>
                                   </div>
                               </div>
                           @endif
                           @if($data['0']['description']->address)
                               <div class="col-md-4">
                                   <h4>WANT TO KNOW ADDRESS?</h4>
                                   <div class="info-box">
                                       <div class="icon"><i class="fa-thin fa-location-dot"></i></div>
                                       <div class="text">
                                           <h4>Location</h4>
                                           <p>{{$data['0']['description']->address}}</p>
                                       </div>
                                   </div>
                               </div>
                           @endif
                  @endif
                  @endforeach
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
                @foreach($allLanguage as $key => $language)
                        <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img
                                src="{{getFile($language->flag_driver,$language->flag)}}"
                                alt=""
                            />
                            <span>{{$language->name}}</span>
                        </button>
                    @if($key == 0) @break @endif
                @endforeach

               <ul class="dropdown-menu dropdown-menu-start">
                  @foreach($allLanguage as $key => $language)
                      @if($key == 0) @continue @endif
                       <li>
                           <a href="" class="dropdown-item">
                               <img
                                   src="{{getFile($language->flag_driver,$language->flag)}}"
                                   alt=""
                                   class="img-fluid"
                               />
                               <span>{{$language->name}}</span>
                           </a>
                       </li>
                  @endforeach
               </ul>
            </div>
         </div>
      </div>
   </div>
</footer>
