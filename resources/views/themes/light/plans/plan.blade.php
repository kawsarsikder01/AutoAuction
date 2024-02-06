
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
                       <h5>{{$plan->first()->contentDetails->first()->description->sub_heading}}</h5>
                    </div>
                    <div class="box">
                       <h2>{{$plan->first()->contentDetails->first()->description->heading}}</h2>
                       <p>
                           {!! $plan->first()->contentDetails->first()->description->short_text !!}
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
                    <h2 class="text-primary">{{$plan->price <= 0? 'Free' :currencyPosition($plan->price)}}</h2>
                    <p>{{$plan->title}}</p>
                    <ul class="list-unstyled">
                        <li>
                              <i class="fa-light fa-check"></i>
                              <span>@lang('list up to') {{$plan->number_of_listing}} @lang('vehicle')</span>
                        </li>
                        <li>
                           <i class="fa-light fa-check"></i>
                           <span>@lang('Upload up to') {{$plan->number_of_images}} @lang('images per listing')</span>
                        </li>
                        <li>
                           <i class="fa-light fa-check"></i>
                           <span>@lang('Expiry time') {{$plan->expiry_time.' '.$plan->expiry_time_type}} </span>
                        </li>
                        @if ($plan->access_auction == 1)
                           <li>
                              <i class="fa-light fa-check"></i>
                              <span>@lang('Access to the auction platform and bidding process.')</span>
                           </li>
                           @endif
                           @if($plan->customer_support == 1)
                           <li>
                              <i class="fa-light fa-check"></i>
                              <span>@lang('Customer support via email or limited chat.')</span>
                           </li>
                           @endif
                           @if ($plan->promoted_listing ==1)
                           <li>
                              <i class="fa-light fa-check"></i>
                              <span>@lang('Promoted listings or featured spots for higher visibility.')</span>
                           </li>
                           @endif
                           @if ($plan->top_search_result ==1)
                           <li>
                              <i class="fa-light fa-check"></i>
                              <span>@lang('Premium placement on the platform (top of search results or featured sections).')</span>
                           </li>
                           @endif
                           @if ($plan->share_other_platform ==1)
                           <li>
                              <i class="fa-light fa-check"></i>
                              <span>@lang('Additional promotional tools (highlighted listings, social media promotion, etc.).')</span>
                           </li>
                        @endif
                    </ul>
                       @if(Auth::user() && Auth::user()->plan)
                            @if(Auth::user()->plan->expiry_date >= \Carbon\Carbon::now() )
                                @if(Auth::user()->plan && $plan->id == Auth::user()->plan->plan_id)
                                    <button class="btn-custom" type="button" data-bs-toggle="modal" data-bs-target="#planModal" disabled>@lang('Already Purchased')</button>
                                @elseif(Auth::user()->plan && $plan->price > Auth::user()->plan->price)
                                    <a href="javascript:void(0);"><button
                                            data-validity="{{$plan->expiry_time.' '.ucfirst($plan->expiry_time_type)}}"
                                            data-price="{{$plan->price." ".basicControl()->currency_symbol}}"
                                            data-listing="{{$plan->number_of_listing}}"
                                            class="btn-custom purchasePlanOrUpgrade"
                                            data-route="{{route('user.upgrade.plan',$plan->id)}}"
                                            type="button" data-bs-toggle="modal"
                                            data-bs-target="#planModal" > @lang('Upgrade Now')</button></a>
                                @elseif(Auth::user()->plan && $plan->price < Auth::user()->plan->price)
                                    <a href="javascript:void(0);"><button
                                            data-validity="{{$plan->expiry_time.' '.ucfirst($plan->expiry_time_type)}}"
                                            data-price="{{$plan->price." ".basicControl()->currency_symbol}}"
                                            data-listing="{{$plan->number_of_listing}}"
                                            class="btn-custom purchasePlanOrUpgrade"
                                            data-route="{{route('user.purchase.plan',$plan->id)}}"
                                            type="button"  data-bs-toggle="modal"
                                            data-bs-target="#planModal" > @lang('Purchase Now')</button></a>
                                @else
                                    <a href="javascript:void(0);"><button
                                            data-validity="{{$plan->expiry_time.' '.ucfirst($plan->expiry_time_type)}}"
                                            data-price="{{$plan->price." ".basicControl()->currency_symbol}}"
                                            data-listing="{{$plan->number_of_listing}}"
                                            class="btn-custom purchasePlanOrUpgrade"
                                            data-route="{{route('user.purchase.plan',$plan->id)}}"
                                            type="button" data-bs-toggle="modal"
                                            data-bs-target="#planModal" > @lang('Purchase Now')</button></a>
                                @endif
                            @else
                                @if(Auth::user()->plan && $plan->id == Auth::user()->plan->plan_id)
                                    <a href="javascript:void(0);"><button
                                            data-validity="{{$plan->expiry_time.' '.ucfirst($plan->expiry_time_type)}}"
                                            data-price="{{$plan->price." ".basicControl()->currency_symbol}}"
                                            data-listing="{{$plan->number_of_listing}}"
                                            class="btn-custom purchasePlanOrUpgrade"
                                            data-route="{{route('user.upgrade.plan',$plan->id)}}"
                                            type="button" data-bs-toggle="modal"
                                            data-bs-target="#planModal" >@lang('Expired Upgrade Now')</button></a>
                                @elseif(Auth::user()->plan && $plan->price > Auth::user()->plan->price)
                                    <a href="javascript:void(0);"><button
                                            data-validity="{{$plan->expiry_time.' '.ucfirst($plan->expiry_time_type)}}"
                                            data-price="{{$plan->price." ".basicControl()->currency_symbol}}"
                                            data-listing="{{$plan->number_of_listing}}"
                                            class="btn-custom purchasePlanOrUpgrade"
                                            data-route="{{route('user.upgrade.plan',$plan->id)}}"
                                            type="button" data-bs-toggle="modal"
                                            data-bs-target="#planModal" > @lang('Upgrade Now')</button></a>
                                @else
                                    <a href="javascript:void(0);"><button
                                            data-validity="{{$plan->expiry_time.' '.ucfirst($plan->expiry_time_type)}}"
                                            data-price="{{$plan->price." ".basicControl()->currency_symbol}}"
                                            data-listing="{{$plan->number_of_listing}}"
                                            class="btn-custom purchasePlanOrUpgrade"
                                            data-route="{{route('user.upgrade.plan',$plan->id)}}"
                                            type="button" data-bs-toggle="modal"
                                            data-bs-target="#planModal" > @lang('Purchase Now')</button></a>
                                @endif
                            @endif
                        @elseif(Auth::user() && !Auth::user()->plan)
                            <a href="javascript:void(0);"><button
                                    data-validity="{{$plan->expiry_time.' '.ucfirst($plan->expiry_time_type)}}"
                                    data-price="{{$plan->price." ".basicControl()->currency_symbol}}"
                                    data-listing="{{$plan->number_of_listing}}"
                                    class="btn-custom purchasePlanOrUpgrade"
                                    data-route="{{route('user.purchase.plan',$plan->id)}}"
                                    type="button" data-bs-toggle="modal"
                                    data-bs-target="#planModal" > @lang('Purchase Now')</button></a>
                        @elseif(!Auth::user())
                            <a href="{{route('user.purchase.plan',$plan->id)}}"><button class="btn-custom" type="button"> Purchase Now</button></a>
                       @endif
                    </div>
                </div>
              @endforeach
           </div>
        </div>
     </section>
@include($theme . 'sections.footer')


<!-- Modal -->
<div class="modal fade" id="planModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-black" id="exampleModalLabel">Purchase Plan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="planModalForm" action="" method="get">
                <div class="modal-body">
                    <li class="list-group-item border-0 d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">@lang('Price')</div>
                        <span class="plan-price" id="price"></span>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">@lang('No. Of Listing')</div>
                        <span class="plan-noOfListing" id="NoOfListing"></span>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">@lang('Validity')</div>
                        <span class="plan-validity" id="Validity"></span>
                    </li>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-custom btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn-custom">@lang('Confirm')</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
{{----}}
@push('script')
    <script>
        $(document).ready(function (){
            $('.purchasePlanOrUpgrade').on('click',function (){
                let route = $(this).data('route');
                let planPrice = $(this).data('price');
                let  planValidity = $(this).data('validity');
                let noOfListing = $(this).data('listing');
                console.log(noOfListing);
                $('#planModalForm').attr('action',route);
                $('#Validity').text(planValidity);
                $('#NoOfListing').text(noOfListing);
                $('#price').text(planPrice);
          });
        })
    </script>
@endpush
