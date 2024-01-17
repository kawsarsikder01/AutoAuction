
@extends($theme . 'layouts.app')

@section('title',trans('Auctioin Details'))
@section('content')
<x-banner-component pagetitle="Auction Details" :path="$vehicle->path_name[mt_rand(0,count($vehicle->path_name) - 1)]??''" :driver="$vehicle->driver??''"/>

     <!-- auction details -->
     <section class="auction-details">
        <div class="overlay">
           <div class="container">
              <div class="row g-4 g-lg-5">
                 <div class="col-lg-6">
                    <div class="gallery-box">
                       <div id="mainCarousel" class="carousel mx-auto main_carousel">
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
                       </div>

                       <div id="thumbCarousel" class="carousel max-w-xl mx-auto thumb_carousel">
                        @foreach ($vehicle->path_name as $path)
                        <div class="carousel__slide">
                            <img class="panzoom__content img-fluid" src="{{getFile($vehicle->driver,$path)}}" />
                         </div>
                          @endforeach

                       </div>
                    </div>
                 </div>

                 <div class="col-lg-6">
                    <div class="auction-content-area">
                       <div class="btn-group">
                          <button class="react"><i class="fa-regular fa-heart"></i>587</button>
                          <div class="">
                           @if(Auth::guard('admin')->user())
                              <form action="{{route('admin.delete.vehicle')}}" method="POST">
                                 @csrf
                                 <input type="hidden" name="id" value="{{$vehicle->id}}">
                                 <button type="submit" class="react"><i class="fa-regular fa-trash-can"></i>Delete</button>
                              </form>
                           @else
                           <button class="react"><i class="fal fa-share-alt" aria-hidden="true"></i>Share</button>
                           @if (Auth::user())
                              <button class="react" id="report"    data-bs-toggle="modal" data-bs-target="#ReportModal"><i class="fal fa-flag-alt" aria-hidden="true" data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Report"></i><span data-bs-toggle="tooltip" data-bs-placement="top"  data-bs-title="Report">Report</span></button>
                           @endif
                          @endif
                          </div>
                       </div>
                       <h3>{{$vehicle->details->title}}</h3>
                       <p>
                         {!!$vehicle->details->short_description!!}
                       </p>
                       @if($vehicle->details->sold_status == 0)
                            @if ($vehicle->biddingHistory->max('bid_amount'))
                                <h4>Current Bid: {{number_format($vehicle->biddingHistory->max('bid_amount'), 2, '.', ',')}}</h4>
                            @else
                                <h4>Vehicle Initial Price: {{ number_format($vehicle->details->price, 2, '.', ',') }} {{basicControl()->currency_symbol}}</h4>
                            @endif
                            @if (!Auth::guard('admin')->user())
                                @if (Auth::user())
                                    @if($vehicle->user_id == Auth::user()->id)
                                        <div class="card-box">
                                            <label>You Can Not Bid This Vehicle</label>
                                        </div>
                                        @else
                                            <div class="card-box">
                                                <h4>Bid Now</h4>
                                                @if ($vehicle->biddingHistory->max('bid_amount'))
                                                    <pre> <h5>Bid Amount: Minimum Bid   {{number_format( $vehicle->biddingHistory->max('bid_amount') + 1, 2, '.', ',')}} {{basicControl()->currency_symbol}}</h5></pre>
                                                @else
                                                    <pre> <h5>Bid Amount: Minimum Bid   {{number_format( $vehicle->details->price, 2, '.', ',')}} {{basicControl()->currency_symbol}}</h5></pre>
                                                @endif
                                                <form action="{{route('user.bid',$vehicle->id)}}" method="POST">
                                                    @csrf
                                                    <div class="input-group">
                                                        <input type="number" name="bid_amount" class="form-control" placeholder="Enter amount" />
                                                        <button type="submit" class="btn-custom">bid now</button>
                                                    </div>
                                                    @error("bid_amount")
                                                    <span class="invalid-feedback d-block" role="alert">
                                                   <strong>{{ $message }}</strong>
                                                </span>
                                                    @enderror
                                                </form>

                                                @if ($vehicle->user_id != Auth::user()->id)
                                                    {{--                                            <small>($100.00 USD Bid Increment) Incremental Bid Guidelines</small>--}}
                                                @endif
                                            </div>
                                    @endif
                                @else
                                    <div class="card-box">

                                        <div class="input-group">
                                            <label for=""> You Can Not Bid</label>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @else
                            <div class="card-box">

                                <div class="input-group">
                                    <label for=""> This vehicle is sold</label>
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
                             Description
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
                             Specification
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
                             Biding History
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
                                <h4>Vehicle Type</h4>
                                   <li class="list-unstyled">{{optional($vehicle->details)->vehicle_type}}</li>
                             </div>
                             <div class="col-md-6">
                                <h4>Dimensions</h4>
                                   {!!optional($vehicle->details)->dimension!!}
                             </div>
                             <div class="col-md-6">
                                <h4>C/D Test Results</h4>
                                {!!optional($vehicle->details)->test_result!!}
                             </div>
                             <div class="col-md-6">
                                <h4>Engine Type</h4>
                               <li class="list-unstyled"> {!!optional($vehicle->details)->engine_type!!}</li>
                             </div>
                             <div class="col-md-6">
                                <h4>Displacement</h4>
                                <li class="list-unstyled">{!!optional($vehicle->details)->displacement!!}</li>
                             </div>
                             <div class="col-md-6">
                                <h4>Power</h4>
                                <li class="list-unstyled">{!!optional($vehicle->details)->power!!}</li>
                             </div>
                             <div class="col-md-6">
                                <h4>Torque</h4>
                                <li class="list-unstyled">{!!optional($vehicle->details)->torque!!}</li>
                             </div>
                             <div class="col-md-6">
                                <h4>Transmission</h4>
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
                         @foreach ($vehicle->biddingHistory as $item)
                           <div class="bid-item">
                              <div class="img-box">
                                 <img src="{{getFile($item->bidder->image_driver,$item->bidder->image)}}" alt="" />
                              </div>
                              <div class="info">
                                 <div>
                                    <h5>{{$item->bidder->firstname.' '.$item->bidder->lastname}}</h5>
                                    <p>{{number_format($item->bid_amount, 2, '.', ',') .' '.basicControl()->currency_symbol}}</p>
                                 </div>
                                 <div>
                                    @if ($maxBid->vehicle->details->sold_status == 1)
                                       @if (Auth::user()&&($maxBid->vehicle->user_id == Auth::user()->id && $item->bid_amount == $maxBid->bid_amount ))
                                          @if($maxBid->vehicle->release_status == 0)
                                                 <button class="btn-custom" id="dataRoute" data-message="Are You Sure You Want To Release Your Vehicle ?" data-route="{{route('user.release.property')}}" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" >
                                                     Release Your Vehicle
                                                 </button>
                                             @else
                                                 <button class="btn-custom"  type="button" disabled>
                                                     Already Released
                                                 </button>
                                          @endif
                                       @elseif (Auth::user()&&($maxBid->user_id == Auth::user()->id && $item->bid_amount == $maxBid->bid_amount))
                                             @if($maxBid->vehicle->payment_status == 0)
                                                 <button class="btn-custom" id="dataRoute" data-message="Are You Sure You Want To Pay ?" data-route="{{route('user.confirm.payment')}}" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" >
                                                     Pay Now
                                                 </button>
                                             @else
                                                 <button class="btn-custom"  type="button" disabled>
                                                     Paid
                                                 </button>
                                             @endif
                                       @else
                                          <p class="time">{{$item->created_at}}</p>
                                       @endif
                                    @else
                                       <p class="time">{{$item->created_at}}</p>
                                    @endif
                                 </div>
                              </div>
                           </div>
                         @endforeach
                       </div>
                    </div>
                 </div>
                 <div class="col-lg-4">
                    <div class="inquiry-form-box">
                       <h4>Get more info</h4>
                       <form action="">
                          <div class="row g-4">
                             <div class="col-md-12">
                                <div class="form-floating">
                                   <input type="text" class="form-control" id="floatingName" placeholder="Name" />
                                   <label for="floatingName">Full Name</label>
                                </div>
                             </div>
                             <div class="col-md-12">
                                <div class="form-floating">
                                   <input
                                      type="email"
                                      class="form-control"
                                      id="floatingInput"
                                      placeholder="name@example.com"
                                   />
                                   <label for="floatingInput">Email address</label>
                                </div>
                             </div>
                             <div class="input-box col-12">
                                <select class="form-select" aria-label="Default select example">
                                   <option selected>Subject</option>
                                   <option value="1">One</option>
                                   <option value="2">Two</option>
                                   <option value="3">Three</option>
                                </select>
                             </div>
                             <div class="col-md-12">
                                <div class="form-floating">
                                   <textarea
                                      class="form-control"
                                      placeholder="Leave a comment here"
                                      id="floatingTextarea"
                                   ></textarea>
                                   <label for="floatingTextarea">Comments</label>
                                </div>
                             </div>
                             <div class="input-box col-12">
                                <button class="btn-custom"><span>Submit </span></button>
                             </div>
                          </div>
                       </form>
                    </div>
                 </div>
              </div>
           </div>
        </div>
     </section>
     @include($theme . 'partials.footer')


<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Model</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" id="FormRoute" method="POST">
               @csrf
                <div class="modal-body">
                    <input type="hidden" value="{{$vehicle->id}}" name="vehicle_id">
                   <span id="setMessage"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-custom btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn-custom">Confirm</button>
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
               <h1 class="modal-title text-black fs-5" id="staticBackdropLabel">Report</h1>
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
                                               placeholder="@lang('Enter Subject')">
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
                   <button type="button" class="btn-custom btn-secondary" data-bs-dismiss="modal">Close</button>
                   <button type="submit" class="btn-custom">Confirm</button>
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
        })

    </script>
@endpush
