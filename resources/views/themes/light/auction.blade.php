@extends($theme . 'layouts.app')

@section('title',trans($pageSeo->page_title ?? ''))
@section('content')
    <x-banner-component :pagetitle="$pageSeo->page_title" :path="$pageSeo->breadcrumb_image" :driver="$pageSeo->breadcrumb_image_driver"/>
     <!-- auction section -->
     <section class="auction-section">
        <div class="container">
           <div class="row g-lg-5">
              <div class="col-lg-3">
                  <form action="{{route('filter.vehicle')}}" method="get">
                      <div class="filter-area">
                          <div class="accordion-item">
                              <h5 class="accordion-header" id="headingOne">
                                  <button
                                      class="accordion-button"
                                      type="button"
                                      data-bs-toggle="collapse"
                                      data-bs-target="#collapseOne"
                                      aria-expanded="false"
                                      aria-controls="collapseOne"
                                  >
                                      Advanced Search
                                  </button>
                              </h5>
                              <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne">
                                  <div class="accordion-body">
                                      <div class="filter-box">
                                          <div class="row g-3">
                                              <div class="input-box col-12">
                                                  <input type="text" class="form-control" name="name" placeholder="Search by name" />
                                              </div>
                                              <div class="input-box col-12">
                                                  <select class="js-example-basic-single form-control" name="brand">
                                                      <option value="" >Select Brand</option>
                                                      @foreach($carBrand as $brand)
                                                          <option value="{{$brand->id}}" >{{$brand->name}}</option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                              <div class="input-box col-12">
                                                  <select class="js-example-basic-single form-control" name="category">
                                                      <option value="" >Car Type</option>
                                                      @foreach($CarCategory as $category)
                                                          <option value="{{$category->id}}" >{{$category->name}}</option>
                                                      @endforeach
                                                  </select>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="accordion-item">
                              <h5 class="accordion-header" id="headingTwo">
                                  <button
                                      class="accordion-button"
                                      type="button"
                                      data-bs-toggle="collapse"
                                      data-bs-target="#collapseTwo"
                                      aria-expanded="false"
                                      aria-controls="collapseTwo"
                                  >
                                      Price Range
                                  </button>
                              </h5>
                              <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo">
                                  <div class="accordion-body">
                                      <div class="filter-box">
                                          <div class="input-box">
                                              <input type="text" class="js-range-slider" name="my_range" />
                                              <label for="customRange1" class="form-label mt-3"> {{$minAmount." ".basicControl()->currency_symbol}} — {{$maxAmount.basicControl()->currency_symbol}}</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="accordion-item">
                              <h5 class="accordion-header" id="headingThree">
                                  <button
                                      class="accordion-button"
                                      type="button"
                                      data-bs-toggle="collapse"
                                      data-bs-target="#collapseThree"
                                      aria-expanded="false"
                                      aria-controls="collapseThree"
                                  >
                                      Status
                                  </button>
                              </h5>
                              <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree">
                                  <div class="accordion-body">
                                      <div class="filter-box">
                                          <!-- Checkbox -->
                                          <div class="form-check mb-3">
                                              <input type="radio" id="formRadio1" name="status" value="1" class="form-check-input"  >
                                              <label class="form-check-label" for="formRadio1">Sold</label>
                                          </div>
                                          <!-- End Checkbox -->

                                          <!-- Checkbox -->
                                          <div class="form-check mb-3">
                                              <input type="radio" id="formRadio2" name="status" value="0" class="form-check-input" >
                                              <label class="form-check-label" for="formRadio2">Unsold</label>
                                          </div>
                                          <div class="form-check mb-3">
                                              <input type="radio" id="formRadio3" name="status" value="" class="form-check-input" checked>
                                              <label class="form-check-label" for="formRadio3">All</label>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <button type="submit" class="btn-custom d-block m-auto w-100">Filter</button>
                      </div>
                  </form>
              </div>
              <div class="col-lg-9">
                 <div class="row g-4">
                    @foreach ($vehicles as $vehicle)
                        @if ($vehicle->status == 1)
                              <div class="col-lg-4">
                                 <div class="item-box">
                                    <div class="img-box">
                                       @foreach ($vehicle->path_name as $path)
                                       <img src="{{getFile($vehicle->driver,$path)}}" alt="" class="img-fluid" />
                                       @break
                                       @endforeach

                                       <div class="countdown" data-countdown="{{$vehicle->details->auction_ending_date}}"></div>

                                    </div>
                                    <div class="text-box">
                                       <h4>{{$vehicle->details->title}}</h4>
                                        @if ($vehicle->biddingHistory->max('bid_amount'))
                                            <p>Current Bid: <span class="text-primary">{{number_format($vehicle->biddingHistory->max('bid_amount'), 2, '.', ',')}} {{basicControl()->currency_symbol}}</span></p>
                                        @else
                                            <p>Initial Price: <span class="text-primary">{{number_format($vehicle->details->price, 2, '.', ',')}} {{basicControl()->currency_symbol}}</span></p>
                                        @endif
                                       <p>Location: {{$vehicle->user->address_one}}</p>
                                       <a href="{{route('auction.details',[slug($vehicle->details->title??''),$vehicle->id])}}" class="btn-custom arrow"> <span>Place a Bid</span> </a>
                                    </div>
                                 </div>
                              </div>
                           @endif
                    @endforeach
                 </div>
                 <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center mt-4">

                     {{ $vehicles->appends($_GET)->links($theme.'partials.pagination') }}

                    </ul>
                 </nav>
              </div>
           </div>
        </div>
     </section>
@include($theme . 'partials.footer')
@endsection
@push('script')
    <script>
        let halfAmount = @json($maxAmount) / 2;
        $(".js-range-slider").ionRangeSlider({
            type: "double",
            min: @json($minAmount),
            max: @json($maxAmount),
            from: @json($minAmount),
            to: halfAmount,
            grid: true,
        });
    </script>
@endpush
