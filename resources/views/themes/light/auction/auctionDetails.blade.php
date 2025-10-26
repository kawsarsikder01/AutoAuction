
@extends($theme . 'layouts.app')

@section('title',trans('Auctioin Details'))
@section('content')
<x-banner-component pagetitle="Auction Details" :path="$vehicle->path_name?$vehicle->path_name[mt_rand(0,count($vehicle->path_name) - 1)]??'':''" :driver="$vehicle->driver??''"/>

     <!-- auction details -->
     <section class="auction-details">
        <div class="overlay">
           <div class="container">
              <div class="row g-4 g-lg-5">
                 <div class="col-lg-6">
                    <div class="gallery-box">
                       <div id="mainCarousel" class="carousel mx-auto main_carousel">
                          @if($vehicle->path_name)
                           @foreach ($vehicle->path_name as $path)
                               <div
                                   class="carousel__slide"
                                   data-src="{{getFile($vehicle->driver,$path)}}"
                                   data-fancybox="gallery"
                                   data-caption=""
                               >
                                   <img class="img-fluid" src="{{getFile($vehicle->driver,$path)}}" />
                               </div>
                           @endforeach
                          @endif
                       </div>

                       <div id="thumbCarousel" class="carousel max-w-xl mx-auto thumb_carousel">
                        @if($vehicle->path_name)
                           @foreach ($vehicle->path_name as $path)
                               <div class="carousel__slide">
                                   <img class="panzoom__content img-fluid" src="{{getFile($vehicle->driver,$path)}}" />
                               </div>
                           @endforeach
                        @endif

                       </div>
                    </div>
                 </div>

                 <div class="col-lg-6">
                    <div class="auction-content-area">
                       <div class="btn-group socialShareing" id="React">
                             <button class="react" id="heartReact" data-ip = {{request()->ip()}}> <i class='fa-regular fa-heart'></i><span>{{count($react)}}</span></button>
                          <div class="">
                               @if(Auth::guard('admin')->user())
                                     <button type="submit" class="react" data-bs-toggle="modal" data-bs-target="#RemoveVehicleModal"><i class="fa-regular fa-trash-can"></i>@lang('Delete')</button>
                                  </form>
                               @else
                                  @if($vehicle->user->plan->share_other_platform == 1)
                                      <button class="react share" >
                                          <div id="shareBlock2"></div>
                                          <i class="fal fa-share-alt" aria-hidden="true"></i>@lang('Share')
                                      </button>
                                  @endif
                               @if (Auth::user() && $vehicle->user_id != Auth::user()->id)
                                   @if(checkReport(null,$vehicle) ==  false)
                                          <button class="react" id="report"    data-bs-toggle="modal" data-bs-target="#ReportModal"><i class="fal fa-flag-alt" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Report"></i><span data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Report">@lang('Report')</span></button>
                                   @endif
                               @endif
                              @endif
                          </div>
                       </div>
                       <h3>{{$vehicle->details->title??''}}</h3>
                       <p>
                         {!!$vehicle->details->short_description??''!!}
                       </p>
                       @if($vehicle->details->sold_status == 0)
                            @if ($vehicle->biddingHistory->max('bid_amount'))
                                <h4>@lang('Current Bid') {{currencyPosition($vehicle->biddingHistory->max('bid_amount'))}}</h4>
                            @else
                                <h4>@lang('Vehicle Initial Price') {{currencyPosition($vehicle->details->price) }}</h4>
                            @endif
                            @if (!Auth::guard('admin')->user())
                                @if (Auth::user())
                                    @if($vehicle->user_id == Auth::user()->id)
                                        <div class="card-box">
                                            <label>@lang('You Can Not Bid This Vehicle')</label>
                                        </div>
                                        @else
                                            @if($vehicle->details->auction_ending_date > today()->format('Y-m-d'))
                                            <div class="card-box">
                                                <h4>@lang('Bid Now')</h4>
                                                @if ($vehicle->biddingHistory->max('bid_amount'))
                                                    <pre> <h5>@lang('Bid Amount: Minimum Bid')   {{currencyPosition($vehicle->biddingHistory->max('bid_amount') + 1)}}</h5></pre>
                                                @else
                                                    <pre> <h5>@lang('Bid Amount: Minimum Bid')   {{currencyPosition($vehicle->details->price)}}</h5></pre>
                                                @endif
                                                    <form action="{{route('user.bid',$vehicle->id)}}" method="POST">
                                                        @csrf
                                                        <div class="input-group">
                                                            <input type="number" name="bid_amount" class="form-control" placeholder="Enter amount"  autocomplete="off" />
                                                            <button type="submit" class="btn-custom">@lang('bid now')</button>
                                                        </div>
                                                        @error("bid_amount")
                                                            <span class="invalid-feedback d-block" role="alert">
                                                               <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </form>

                                            </div>
                                            @else
                                                <div class="card-box">
                                                    @lang('Auction End')
                                                </div>
                                            @endif
                                    @endif
                                @else
                                    <div class="card-box">

                                        <div class="input-group">
                                            <label for=""> @lang('You Can Not Bid')</label>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @else
                            <div class="card-box">

                                <div class="input-group">
                                    <label for=""> @lang('This vehicle is sold')</label>
                                </div>
                            </div>
                       @endif
                    </div>
                 </div>
              </div>
              <div class="row g-lg-5 mt-5">
                 <div class="col-lg-8">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                       <li class="nav-item" role="presentation">
                          <button
                             class="nav-link btn-custom active"
                             id="home-tab"
                             data-bs-toggle="tab"
                             data-bs-target="#home-tab-pane"
                             type="button"
                             role="tab"
                             aria-controls="home-tab-pane"
                             aria-selected="true"
                          >
                             @lang('Description')
                          </button>
                       </li>
                       <li class="nav-item" role="presentation">
                          <button
                             class="nav-link btn-custom"
                             id="profile-tab"
                             data-bs-toggle="tab"
                             data-bs-target="#profile-tab-pane"
                             type="button"
                             role="tab"
                             aria-controls="profile-tab-pane"
                             aria-selected="false"
                          >
                             @lang('Specification')
                          </button>
                       </li>
                       <li class="nav-item" role="presentation">
                          <button
                             class="nav-link btn-custom"
                             id="contact-tab"
                             data-bs-toggle="tab"
                             data-bs-target="#contact-tab-pane"
                             type="button"
                             role="tab"
                             aria-controls="contact-tab-pane"
                             aria-selected="false"
                          >
                             @lang('Biding History')
                          </button>
                       </li>
                    </ul>
                    <div class="tab-content mt-4" id="myTabContent">
                       <div
                          class="tab-pane fade show active"
                          id="home-tab-pane"
                          role="tabpanel"
                          aria-labelledby="home-tab"
                          tabindex="0"
                       >
                                {!! $vehicle->details->description !!}
                       </div>
                       <div
                          class="tab-pane fade"
                          id="profile-tab-pane"
                          role="tabpanel"
                          aria-labelledby="profile-tab"
                          tabindex="0"
                       >
                          <div class="row g-4" id="car_specification">
                             <div class="col-md-6">
                                <h4>@lang('Vehicle Type')</h4>
                                   <li class="list-unstyled">{{optional($vehicle->details)->vehicle_type}}</li>
                             </div>
                             <div class="col-md-6">
                                <h4>@lang('Dimensions')</h4>
                                   {!!optional($vehicle->details)->dimension!!}
                             </div>
                             <div class="col-md-6">
                                <h4>@lang("C/D Test Results")</h4>
                                {!!optional($vehicle->details)->test_result!!}
                             </div>
                             <div class="col-md-6">
                                <h4>@lang('Engine Type')</h4>
                               <li class="list-unstyled"> {!!optional($vehicle->details)->engine_type!!}</li>
                             </div>
                             <div class="col-md-6">
                                <h4>@lang('Displacement')</h4>
                                <li class="list-unstyled">{!!optional($vehicle->details)->displacement!!}</li>
                             </div>
                             <div class="col-md-6">
                                <h4>@lang('Power')</h4>
                                <li class="list-unstyled">{!!optional($vehicle->details)->power!!}</li>
                             </div>
                             <div class="col-md-6">
                                <h4>@lang('Torque')</h4>
                                <li class="list-unstyled">{!!optional($vehicle->details)->torque!!}</li>
                             </div>
                             <div class="col-md-6">
                                <h4>@lang('Transmission')</h4>
                                <li class="list-unstyled">{!!optional($vehicle->details)->transmission!!}</li>
                             </div>
                          </div>
                       </div>
                       <div
                          class="tab-pane fade"
                          id="contact-tab-pane"
                          role="tabpanel"
                          aria-labelledby="contact-tab"
                          tabindex="0"
                       >
                       @if ($vehicle->biddingHistory->first())
                       @foreach ($vehicle->biddingHistory as $item)
                       <div class="bid-item">
                          <div class="img-box">
                             <img src="{{getFile($item->bidder->image_driver,$item->bidder->image)}}" alt="" />
                          </div>
                          <div class="info">
                             <div>
                                <h5>{{$item->bidder->firstname.' '.$item->bidder->lastname}}</h5>
                                <p>{{currencyPosition($item->bid_amount)}}</p>
                             </div>
                             <div>
                                @if ($maxBid->vehicle->details->sold_status == 1)
                                   @if (Auth::user()&&($maxBid->vehicle->user_id == Auth::user()->id && $item->bid_amount == $maxBid->bid_amount ))
                                      @if($maxBid->vehicle->release_status == 0)
                                             <button class="btn-custom" id="dataRoute" data-heading="Release Vehicle" data-message="Are You Sure You Want To Release Your Vehicle ?" data-route="{{route('user.release.property')}}" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" >
                                                 @lang('Release Your Vehicle')
                                             </button>
                                         @elseif($maxBid->vehicle->release_status == 1)
                                             <button class="btn-custom"  type="button" disabled>
                                                @lang("Already Released")
                                             </button>
                                         @elseif($maxBid->vehicle->release_status == 2)
                                             <button class="btn-custom"  type="button" disabled>
                                                 @lang('Canceled')
                                             </button>
                                      @endif
                                   @elseif (Auth::user()&&($maxBid->user_id == Auth::user()->id && $item->bid_amount == $maxBid->bid_amount))
                                         @if($maxBid->vehicle->payment_status == 0)
                                             <button class="btn-custom" id="dataRoute" data-heading="Payment Confirmation" data-message="Are You Sure You Want To Pay ?" data-route="{{route('user.confirm.payment')}}" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" >
                                                 @lang('Pay Now')
                                             </button>
                                         @elseif($maxBid->vehicle->payment_status == 1)
                                             <button class="btn-custom"  type="button" disabled>
                                                 @lang('Paid')
                                             </button>
                                         @elseif($maxBid->vehicle->payment_status == 2)
                                             <button class="btn-custom"  type="button" disabled>
                                                 @lang('Payment Cancel')
                                             </button>
                                         @endif
                                   @else
                                      <p class="time">{{dateTime($item->created_at)}}</p>
                                   @endif
                                @else
                                   <p class="time">{{dateTime($item->created_at)}}</p>
                                @endif
                             </div>
                          </div>
                       </div>
                     @endforeach
                     @else
                     <div class="text-center p-4" id="emptyImageDib">
                        <img  class="dataTables-image mb-3 w-50"
                              id="emptyImage"
                             src="{{ asset($themeTrue.'img/img/no_data_found.jpg') }}"
                             alt="Image Description">
                        <p class="mb-0">@lang("No Bidding History Found")</p>
                    </div>
                       @endif
                       </div>
                    </div>
                 </div>
                 @if (Auth::user() && Auth::user()->id != $vehicle->user_id)
                 <div class="col-lg-4">
                  <div class="inquiry-form-box">
                     <h4>@lang('Get more info')</h4>
                     <form action="{{route('user.get.info')}}" method="POST">
                      @csrf
                      <input type="hidden" name="vehicle_id" value="{{$vehicle->id}}">
                        <div class="row g-4">
                           <div class="col-md-12">
                              <div class="form-input">
                                 <input type="text" name="fullname" class="form-control" id="floatingName" placeholder="Name" autocomplete="off" />
                              </div>
                           </div>
                           @error("fullname")
                              <span class="invalid-feedback d-block" role="alert">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                           <div class="col-md-12">
                              <div class="form-input">
                                 <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    id="floatingInput"
                                    placeholder="Email Address"
                                    autocomplete="off"
                                 />

                              </div>
                           </div>
                           @error("email")
                              <span class="invalid-feedback d-block" role="alert">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                           <div class="col-md-12">
                            <div class="form-input">
                               <input type="text" class="form-control" name="subject" id="floatingSubject" placeholder="Subject" autocomplete="off" />

                            </div>
                         </div>
                           @error("subject")
                              <span class="invalid-feedback d-block" role="alert">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                           <div class="col-md-12">
                              <div class="form-input">
                                 <textarea
                                    class="form-control"
                                    name="comment"
                                    placeholder="Comments"
                                    id="floatingTextarea"
                                 ></textarea>
                              </div>
                           </div>
                           @error("comment")
                              <span class="invalid-feedback d-block" role="alert">
                                 <strong>{{ $message }}</strong>
                              </span>
                           @enderror
                           <div class="input-box col-12">
                              <button class="btn-custom"><span>@lang('Submit') </span></button>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
                 @endif
              </div>
           </div>
        </div>
     </section>
@include($theme . 'sections.footer')


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">@lang('Model')</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="FormRoute" method="POST">
               @csrf
                <div class="modal-body">
                    <input type="hidden" value="{{$vehicle->id}}" name="vehicle_id">
                   <span id="setMessage"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-custom btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn-custom">@lang('Confirm')</button>
                </div>
            </form>
        </div>
    </div>
</div>
 <!-- Modal -->
 <div class="modal fade"  id="ReportModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
           <div class="modal-header">
               <h1 class="modal-title text-black fs-5" id="staticBackdropLabel">@lang('Report')</h1>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <form action="{{route('user.store.report',[Auth::user()->id??0,$vehicle->user_id,$vehicle->id])}}" id="FormRoute" method="POST">
              @csrf
               <div class="modal-body">
                   <div class="row justify-content-center align-items-center">
                       <div class="col-lg-12">
                          <div class="form-wrapper">
                                <div class="row g-4">
                                   <div class="form-group mb-2">
                                       <label>@lang('Subject')</label>
                                       <input class="form-control" type="text" name="subject"
                                               placeholder="@lang('Enter Subject')" autocomplete="off">
                                   </div>
                                   @error("subject")
                                   <span class="invalid-feedback d-block" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                                 @enderror
                                   <div class="form-group mb-2">
                                       <label>@lang('Reason')</label>
                                       <textarea class="form-control ticket-box" name="reason" rows="5"
                                                 id="textarea1"
                                                 placeholder="@lang('Enter Reason')">{{old('message')}}</textarea>
                                   </div>
                                   @error("reason")
                                   <span class="invalid-feedback d-block" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                                 @enderror
                                </div>
                          </div>
                       </div>
                    </div>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn-custom btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                   <button type="submit" class="btn-custom">@lang('Confirm')</button>
               </div>
           </form>
       </div>
   </div>
</div>


<div class="modal fade"  id="RemoveVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="RemoveVehicleModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title text-black fs-5" id="RemoveVehicleModal">@lang('Remove Vehicle')</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('admin.delete.vehicle')}}"  method="POST">
                @csrf
                <input type="hidden" name="id" value="{{$vehicle->id}}">
                <div class="modal-body">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-lg-12">
                            <div class="form-wrapper">
                                <div class="row g-4">
                                    <div class="form-group mb-2">
                                        <label>@lang('Reason')</label>
                                        <textarea class="form-control ticket-box" name="reason" rows="5"
                                                  placeholder="@lang('Enter Reason')">{{old('message')}}</textarea>
                                    </div>
                                    @error("reason")
                                    <span class="invalid-feedback d-block" role="alert">
                                       <strong>{{ $message }}</strong>
                                   </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
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

@push('script')
    <script>
        // Initialise Carousel
        const mainCarousel = new Carousel(document.querySelector("#mainCarousel"), {
            Dots: false,
            Navigation: false,
        });

        // Thumbnails
        const thumbCarousel = new Carousel(document.querySelector("#thumbCarousel"), {
            Sync: {
                target: mainCarousel,
                friction: 0,
            },
            Dots: false,
            Navigation: true,
            center: true,
            slidesPerPage: 1,
            infinite: false,
        });

        // Customize Fancybox
        Fancybox.bind('[data-fancybox="gallery"]', {
            Carousel: {
                on: {
                    change: (that) => {
                        mainCarousel.slideTo(mainCarousel.findPageForSlide(that.page), {
                            friction: 0,
                        });
                    },
                },
            },
        });

        $(document).ready(function(){
         $('#FormRoute').attr('action', $('#report').data('route'));

         if( $('#dataRoute').length){
            $('#FormRoute').attr('action', $('#dataRoute').data('route'));
           $('#setMessage').text($('#dataRoute').data('message'));
         }
            let id = @json($vehicle->id);
            let ip = $('#heartReact').data('ip');
            let getReact = function (){
                $.ajax({
                    url: "{{ route('get.react', ['id' => 'id']) }}".replace('id', id),
                    method: "GET",
                    dataType: "json",
                    success: function(data) {
                        let length = data.length;
                        let icon = 0;
                        let react = $('#heartReact');
                        for(i = 0; i < length ; ++i){
                            if(data[i].ip_address === ip){
                                react.children('i').removeClass('submit fa-regular fa-heart');
                                react.children('i').addClass('unsubmit fa-solid fa-heart');
                                react.children('span').text(length);
                                icon = 1;
                                break;
                            }
                        }
                        if(icon == 0){
                            react.children('i').removeClass('unsubmit fa-solid fa-heart');
                            react.children('i').addClass('submit fa-regular fa-heart');
                            react.children('span').text(length);

                        }
                        $('#countReact').text(length);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Handle errors here
                        console.error("AJAX Error: " + textStatus, errorThrown);
                    }
                });
            }
            getReact();
            $('#heartReact').on('click',function (){
                var icon = $('#heartReact').find('.submit');
                   if(icon.length == 1){
                       $.ajax({
                           url: "{{ route('submit.react', ['id' => 'id']) }}".replace('id', id),
                           method: "GET",
                           dataType: "json",
                           success: function(data) {
                               getReact();
                           },
                           error: function(jqXHR, textStatus, errorThrown) {
                               // Handle errors here
                               console.error("AJAX Error: " + textStatus, errorThrown);
                           }
                       });
                   }else{
                       $.ajax({
                           url: "{{ route('unsubmit.react', ['id' => 'id']) }}".replace('id', id),
                           method: "GET",
                           dataType: "json",
                           success: function(data) {
                               getReact();
                               console.log(data);
                           },
                           error: function(jqXHR, textStatus, errorThrown) {
                               // Handle errors here
                               console.error("AJAX Error: " + textStatus, errorThrown);
                           }
                       });
                   }
            })

            $("#shareBlock2").socialSharingPlugin({
                urlShare: window.location.href,
                description: $("meta[name=description]").attr("content"),
                title: $("title").text(),
            });
        })

    </script>
@endpush
@push('style')
    <style>

        .unsubmit{
            transition: .1s;
            animation: react 1s ease;
        }
        @keyframes react {
            0% {
                transform: scale(1);
            }
            10%, 20% {
                transform: scale(0.9) rotate(-3deg);
            }
            30%, 50%, 70%, 90% {
                transform: scale(1.1) rotate(3deg);
            }
            40%, 60%, 80% {
                transform: scale(1.1) rotate(-3deg);
            }
            100% {
                transform: scale(1) rotate(0deg);
            }
        }
    </style>
@endpush
