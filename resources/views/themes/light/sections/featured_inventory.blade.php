 <!-- featured inventory -->
 <section class="featured-inventory">
    <div class="container">
       <div class="row">
          <div class="col-12">
             <div class="section-header">
                <h5>{{$featured_inventory['single']['sub_heading']??''}}</h5>
                <h2>{{$featured_inventory['single']['heading']??''}}</h2>
                <p>
                    {!! $featured_inventory['single']['description']??'' !!}
                </p>
             </div>
          </div>
       </div>
    </div>
    <div class="container">
       <div class="row g-4 g-lg-5">
          <div class="col">
            <div class="owl-carousel popular-vehicles">
               @foreach(collect($featured_inventory['multiple'])->toArray() as $item)
                   @php
                   $itemObject = (object)$item
                   @endphp
                    <div class="item-box">
                        <div class="img-box">
                                <img src="{{getFile($item['driver'],$item['path_name'][mt_rand(0,count($item['path_name']) - 1)])}}" alt="" class="img-fluid" />
                            <div class="countdown" data-countdown="{{$item['details']['auction_ending_date']}}"></div>
                        </div>
                        <div class="text-box">
                            <h4>{{$itemObject->details['title']}}</h4>
                            @if (collect($itemObject->bidding_history)->max('bid_amount'))
                                <p>@lang('Current Bid') <span class="text-primary">{{collect($itemObject->bidding_history)->max('bid_amount')}}</span></p>
                            @else
                                <h4>@lang("Vehicle Initial Price") {{$itemObject->details['price'] }} {{basicControl()->currency_symbol}}</h4>
                            @endif
                            
                            <p>@lang('Location'): {{$itemObject->user['address_one']??''}}</p>
                            <a href="{{route('auction.details',[slug($itemObject->details['title'])??'',$item['id']])}}" class="btn-custom arrow"> <span>@lang('Place a Bid')</span> </a>
                        </div>
                    </div>
               @endforeach
            </div>
          </div>
       </div>
    </div>
 </section>
