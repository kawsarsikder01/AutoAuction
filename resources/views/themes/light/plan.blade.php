
@extends($theme . 'layouts.app')

@section('title',trans($pageSeo->page_title ?? ''))
@section('content')
<x-banner-component :pagetitle="$pageSeo->page_title??''" :path="$pageSeo->breadcrumb_image??''" :driver="$pageSeo->breadcrumb_image_driver??''"/>
     <!-- pricing section -->
     <section class="pricing-section">
        <div class="container">
           <div class="row">
              <div class="col-12">
                 <div class="section-header2" overlay-text="Pricing Plans">
                    <div class="box">
                       <h5>Plans</h5>
                    </div>
                    <div class="box">
                       <h2>Membership Options</h2>
                       <p>
                          As a Auto Auction Member, you'll be able to search our massive inventory for wholesale, used
                          and repairable cars, trucks and SUVs.
                       </p>
                    </div>
                 </div>
              </div>
           </div>
           <div class="row justify-content-center g-4 g-lg-5">
              @foreach ($plans as $plan)
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-box">
                    <h4>{{$plan->package_name}}</h4>
                    <h2 class="text-primary">{{$plan->price == 0? 'Free' :$plan->price.' '.basicControl()->currency_symbol}}</h2>
                    <p>{{$plan->title}}</p>
                    <ul class="list-unstyled">
                        <li>
                              <i class="fa-light fa-check"></i>
                              <span>list up to {{$plan->number_of_listing}} vehicle</span>
                        </li>
                        <li>
                           <i class="fa-light fa-check"></i>
                           <span>Upload up to {{$plan->number_of_images}} images per listing</span>
                        </li>
                        <li>
                           <i class="fa-light fa-check"></i>
                           <span>Expiry time {{$plan->expiry_time.' '.$plan->expiry_time_type}} </span>
                        </li>
                        @if ($plan->access_auction == 1)
                           <li>
                              <i class="fa-light fa-check"></i>
                              <span>Access to the auction platform and bidding process.</span>
                           </li>
                           @endif
                           @if($plan->customer_support == 1)
                           <li>
                              <i class="fa-light fa-check"></i>
                              <span>Customer support via email or limited chat.</span>
                           </li>
                           @endif
                           @if ($plan->promoted_listing ==1)
                           <li>
                              <i class="fa-light fa-check"></i>
                              <span>Promoted listings or featured spots for higher visibility.</span>
                           </li>
                           @endif
                           @if ($plan->top_search_result ==1)
                           <li>
                              <i class="fa-light fa-check"></i>
                              <span>Premium placement on the platform (top of search results or featured sections).</span>
                           </li>
                           @endif
                           @if ($plan->share_other_platform ==1)
                           <li>
                              <i class="fa-light fa-check"></i>
                              <span>Additional promotional tools (highlighted listings, social media promotion, etc.).</span>
                           </li>
                        @endif
                    </ul>
                       @if(Auth::user() && Auth::user()->plan)
                            @if(Auth::user()->plan_expire_date >= \Carbon\Carbon::now() )
                                @if(Auth::user()->plan && $plan->id == Auth::user()->plan->id)
                                    <button class="btn-custom" type="button" data-bs-toggle="modal" data-bs-target="#planModal" disabled>Already Purchased</button>
                                @elseif(Auth::user()->plan && $plan->price > Auth::user()->plan->price)
                                    <a href="{{route('user.upgrade.plan',$plan->id)}}"><button class="btn-custom" type="button" data-bs-toggle="modal" data-bs-target="#planModal" > Upgrade Now</button></a>
                                @elseif(Auth::user()->plan && $plan->price < Auth::user()->plan->price)
                                    <a href="{{route('user.purchase.plan',$plan->id)}}"><button class="btn-custom" type="button" data-bs-toggle="modal" data-bs-target="#planModal" > Purchase Now</button></a>
                                @else
                                    <a href="{{route('user.purchase.plan',$plan->id)}}"><button class="btn-custom" type="button" data-bs-toggle="modal" data-bs-target="#planModal" > Purchase Now</button></a>
                                @endif
                            @else
                                @if(Auth::user()->plan && $plan->id == Auth::user()->plan->id)
                                    <a href="{{route('user.upgrade.plan',$plan->id)}}"><button class="btn-custom" type="button" data-bs-toggle="modal" data-bs-target="#planModal" >Expired Upgrade Now</button></a>
                                @elseif(Auth::user()->plan && $plan->price > Auth::user()->plan->price)
                                    <a href="{{route('user.upgrade.plan',$plan->id)}}"><button class="btn-custom" type="button" data-bs-toggle="modal" data-bs-target="#planModal" > Upgrade Now</button></a>
                                @else
                                    <a href="{{route('user.upgrade.plan',$plan->id)}}"><button class="btn-custom" type="button" data-bs-toggle="modal" data-bs-target="#planModal" > Purchase Now</button></a>
                                @endif
                            @endif
                        @elseif(Auth::user() && !Auth::user()->plan)
                            <a href="{{route('user.purchase.plan',$plan->id)}}"><button class="btn-custom" type="button" data-bs-toggle="modal" data-bs-target="#planModal" > Purchase Now</button></a>
                        @else
                            <a href="{{route('user.purchase.plan',$plan->id)}}"><button class="btn-custom" type="button" data-bs-toggle="modal" data-bs-target="#planModal" > Purchase Now</button></a>
                       @endif
                    </div>
                </div>
              @endforeach
           </div>
        </div>
     </section>
 @include($theme . 'partials.footer')
@endsection
