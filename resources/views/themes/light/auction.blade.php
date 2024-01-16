@extends($theme . 'layouts.app')

@section('title',trans($pageSeo->page_title ?? ''))
@section('content')
    <x-banner-component :pagetitle="$pageSeo->page_title" :path="$pageSeo->breadcrumb_image" :driver="$pageSeo->breadcrumb_image_driver"/>
     <!-- auction section -->
     <section class="auction-section">
        <div class="container">
           <div class="row g-lg-5">
              <div class="col-lg-3">
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
                                      <input type="text" class="form-control" placeholder="Search by name" />
                                   </div>
                                   <div class="input-box col-12">
                                      <select class="js-example-basic-single form-control" name="propertyType">
                                         <option value="type1">Select Brand</option>
                                         <option value="type2">Toyota</option>
                                         <option value="type3">Mazda</option>
                                         <option value="type4">Mitsubishi</option>
                                         <option value="type5">Mazda</option>
                                         <option value="type6">Lexus</option>
                                         <option value="type7">Nissan</option>
                                         <option value="type8">Volkswagen</option>
                                         <option value="type9">Audi</option>
                                         <option value="type10">BMW</option>
                                         <option value="type11">Mercedes</option>
                                      </select>
                                   </div>
                                   <div class="input-box col-12">
                                      <select class="js-example-basic-single form-control" name="categories">
                                         <option value="type1">Car Type</option>
                                         <option value="type2">Sedan</option>
                                         <option value="type3">Suv</option>
                                         <option value="type4">Coupe</option>
                                         <option value="type5">Hatchback</option>
                                         <option value="type6">Crossover</option>
                                         <option value="type7">Sports</option>
                                         <option value="type8">Convertible</option>
                                         <option value="type9">Mini Van</option>
                                         <option value="type10">Wagon</option>
                                      </select>
                                   </div>
                                   <div class="input-box col-12">
                                      <select class="js-example-basic-single form-control" name="year">
                                         <option value="type1">Model Year</option>
                                         <option value="type2">1971 - 1980</option>
                                         <option value="type3">1981 - 1990</option>
                                         <option value="type4">1991 - 2000</option>
                                         <option value="type5">2001 - 2010</option>
                                         <option value="type6">2011 - 2020</option>
                                         <option value="type7">2021 - 2030</option>
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
                                   <input type="text" class="js-range-slider" name="my_range" value="" />
                                   <label for="customRange1" class="form-label mt-3"> $5,000 — $1,00,000</label>
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
                                <div class="check-box">
                                   <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="status1" />
                                      <label class="form-check-label" for="status1">Sold</label>
                                   </div>
                                   <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="status2" />
                                      <label class="form-check-label" for="status2">Not Sold</label>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                    <div class="accordion-item">
                       <h5 class="accordion-header" id="headingSeven">
                          <button
                             class="accordion-button"
                             type="button"
                             data-bs-toggle="collapse"
                             data-bs-target="#collapseSeven"
                             aria-expanded="false"
                             aria-controls="collapseSeven"
                          >
                             Colors
                          </button>
                       </h5>
                       <div id="collapseSeven" class="accordion-collapse collapse show" aria-labelledby="headingSeven">
                          <div class="accordion-body">
                             <div class="filter-box">
                                <div class="check-box">
                                   <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="color1" />
                                      <label class="form-check-label" for="color1"> Black </label>
                                   </div>
                                   <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="color2" />
                                      <label class="form-check-label" for="color2"> Blue </label>
                                   </div>
                                   <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="color3" />
                                      <label class="form-check-label" for="color3"> Red </label>
                                   </div>
                                   <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="color4" />
                                      <label class="form-check-label" for="color4"> Silver </label>
                                   </div>
                                   <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="color5" />
                                      <label class="form-check-label" for="color5"> White </label>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                    <div class="accordion-item">
                       <h5 class="accordion-header" id="headingSix">
                          <button
                             class="accordion-button"
                             type="button"
                             data-bs-toggle="collapse"
                             data-bs-target="#collapseSix"
                             aria-expanded="false"
                             aria-controls="collapseSix"
                          >
                             Cubic Capacity (CC)
                          </button>
                       </h5>
                       <div id="collapseSix" class="accordion-collapse collapse show" aria-labelledby="headingSix">
                          <div class="accordion-body">
                             <div class="filter-box">
                                <div class="check-box">
                                   <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="cubicCapacity1" />
                                      <label class="form-check-label" for="cubicCapacity1"> 1500 </label>
                                   </div>
                                   <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="cubicCapacity2" />
                                      <label class="form-check-label" for="cubicCapacity2"> 2000 </label>
                                   </div>
                                   <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="cubicCapacity3" />
                                      <label class="form-check-label" for="cubicCapacity3"> 3000 </label>
                                   </div>
                                   <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="cubicCapacity3" />
                                      <label class="form-check-label" for="cubicCapacity3"> 4000 </label>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                    <div class="accordion-item">
                       <h5 class="accordion-header" id="headingFour">
                          <button
                             class="accordion-button"
                             type="button"
                             data-bs-toggle="collapse"
                             data-bs-target="#collapseFour"
                             aria-expanded="false"
                             aria-controls="collapseFour"
                          >
                             Condition
                          </button>
                       </h5>
                       <div id="collapseFour" class="accordion-collapse collapse show" aria-labelledby="headingFour">
                          <div class="accordion-body">
                             <div class="filter-box">
                                <div class="check-box">
                                   <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="condition1" />
                                      <label class="form-check-label" for="condition1">
                                         <i class="fas fa-star"></i>
                                         <i class="fas fa-star"></i>
                                         <i class="fas fa-star"></i>
                                         <i class="fas fa-star"></i>
                                         <i class="fas fa-star"></i>
                                      </label>
                                   </div>
                                   <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="condition2" />
                                      <label class="form-check-label" for="condition2">
                                         <i class="fas fa-star"></i>
                                         <i class="fas fa-star"></i>
                                         <i class="fas fa-star"></i>
                                         <i class="fas fa-star"></i>
                                      </label>
                                   </div>
                                   <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="condition3" />
                                      <label class="form-check-label" for="condition3">
                                         <i class="fas fa-star"></i>
                                         <i class="fas fa-star"></i>
                                         <i class="fas fa-star"></i>
                                      </label>
                                   </div>
                                   <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="condition4" />
                                      <label class="form-check-label" for="condition4">
                                         <i class="fas fa-star"></i>
                                         <i class="fas fa-star"></i>
                                      </label>
                                   </div>
                                   <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="condition5" />
                                      <label class="form-check-label" for="condition5">
                                         <i class="fas fa-star"></i>
                                      </label>
                                   </div>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                    <div class="accordion-item">
                       <h5 class="accordion-header" id="headingFive">
                          <button
                             class="accordion-button"
                             type="button"
                             data-bs-toggle="collapse"
                             data-bs-target="#collapseFive"
                             aria-expanded="false"
                             aria-controls="collapseFive"
                          >
                             Popular Tags
                          </button>
                       </h5>
                       <div id="collapseFive" class="accordion-collapse collapse show" aria-labelledby="headingFive">
                          <div class="accordion-body">
                             <div class="filter-box">
                                <div class="checkbox-group">
                                   <span>
                                      <input type="checkbox" class="btn-check" id="btn-check-3" autocomplete="off" />
                                      <label class="btn btn-primary" for="btn-check-3">Hatchback</label>
                                   </span>
                                   <span>
                                      <input type="checkbox" class="btn-check" id="btn-check-4" autocomplete="off" />
                                      <label class="btn btn-primary" for="btn-check-4">SUV</label>
                                   </span>
                                   <span>
                                      <input type="checkbox" class="btn-check" id="btn-check-5" autocomplete="off" />
                                      <label class="btn btn-primary" for="btn-check-5">Pre Owned</label>
                                   </span>
                                   <span>
                                      <input type="checkbox" class="btn-check" id="btn-check-6" autocomplete="off" />
                                      <label class="btn btn-primary" for="btn-check-6">Unused</label>
                                   </span>
                                   <span>
                                      <input type="checkbox" class="btn-check" id="btn-check-1" autocomplete="off" />
                                      <label class="btn btn-primary" for="btn-check-1">New edition</label>
                                   </span>
                                   <span>
                                      <input type="checkbox" class="btn-check" id="btn-check-2" autocomplete="off" />
                                      <label class="btn btn-primary" for="btn-check-2">Convertible</label>
                                   </span>
                                   <span>
                                      <input type="checkbox" class="btn-check" id="btn-check-7" autocomplete="off" />
                                      <label class="btn btn-primary" for="btn-check-7">Sedan</label>
                                   </span>
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                 </div>
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
                                            <p>Current Bid: <span class="text-primary">{{number_format($vehicle->biddingHistory->max('bid_amount'), 2, '.', ',')}}</span></p>
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
